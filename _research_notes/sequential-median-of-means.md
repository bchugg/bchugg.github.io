---
layout: note 
date: "2024-09-09" 
title: "A sequential median-of-means template"
description: "How to construct a time-uniform median-of-means estimator"
status: published
---

$$
\newcommand{\muhat}{\widehat{\mu}}
\newcommand{\mom}{\text{MoM}}
\newcommand{\median}{\text{median}}
\newcommand{\E}{\mathbb{E}}
\newcommand{\calF}{\mathcal{F}}
\renewcommand{\Pr}{\mathbb{P}}
\newcommand{\Var}{\mathbb{V}}
\renewcommand{\Re}{\mathbb{R}}
$$

The [median-of-means (MoM) estimator]({% link _research_notes/median-of-means-univariate.md %}) is one of the best known estimator for mean estimation in heay-tailed settings. Is there a time-uniform version of MoM? Unlike Chernoff bounds which rely on exponential inequalities and can thus be made time-uniform very naturally via [Ville's inequality]({% link _research_notes/ville.md %}), it's much less clear how to approach the problem for the MoM estimator. 

Recall that the fixed-time MoM estimator splits the data into $$k$$ groups, takes the sample mean of each group, and then computes the median among those sample means. The same logic holds in the [multivariate case]({% link _research_notes/median-of-means-multivariate.md %}), but the computation of the median is much trickier. Here we'll stick to the univariate setting for simplicity (although very similar arguments carry over). 

Suppose we observe that random variables $$X_1,X_2,\dots,X_n\in\Re$$ with mean $$\mu$$. Given $$\delta\in(0,1)$$, if we choose $$k = \lceil 8\log(1/\delta)\rceil$$, one can show that the MoM estimator $$\muhat^\mom$$ satisfies 

$$
\begin{equation}
\label{eq:fixed-time-mom}
    \Pr\left(|\muhat^\mom - \mu| \leq \sigma \bigg(\frac{32\log(1/\delta)}{n}\bigg)^{1/2}\right)\geq 1-\delta.\tag{1}
\end{equation}
$$

There are two possible approaches to sequentializing this estimator. We could keep the group size fixed and create more groups as we receive more observations. Or we could keep the number of groups fixed and have their size grow over time. I think the first approach is possible (using [confidence sequences for the median](https://arxiv.org/abs/1906.09712)), but it gets messy (what does one do when the newest group is not full, for instance?). The second approach leads to a much cleaner solution.  

Fix the number of groups at $$k$$. Call them  $$G_1,\dots,G_k$$. We iteratively add observations to each group over time. We maintain a confidence sequence $$C^g(\alpha) \equiv (C^g_t(\alpha))_{t\geq 1}$$ for the  mean of each group, centered at some (weighted) empirical mean $$S_t^g$$.   We then have $$\muhat_t^\mom = \median(S_t^1,\dots,S_t^g)$$. The following result provides a template on the deviation from $$\mu$$ of $$\muhat_t^\mom$$ as a function of the widths of the confidence sequences. Let $$\ell(C)$$ denote the Lebesgue measure of a set $$C\subset\mathbb R$$.  


**Sequential MoM template.** Let $$X_1,X_2,\dots$$ be iid with mean $$\mu$$ and variance upper bounded by $$\sigma^2$$. Let $$C^g(\alpha)$$ be a $$(1-\alpha)$$-CS for the mean of bucket $$g\in[k]$$, where $$C_t^g(\alpha)$$ is centered at $$S_t^g$$. Then, 
the sequential MoM estimator satisfies 

$$
\begin{equation}
    \Pr\left(\forall t\geq 1: |\muhat^\mom_t - \mu| \leq \max_{g\in[k]} \ell(C^g_{\lfloor t/k\rfloor}(1/4))\right) \geq 1-\exp\{-k/8\}. 
\end{equation}
$$

*Proof.* Let $$m_t^g$$ be the number of observations in group $$g$$ at time $$t$$. Note that $$m_t^g \in\{\lfloor t/k\rfloor, \lceil t/k\rceil\}$$. By definition of a $$(1-\alpha)$$-CS, we are guaranteed that, for all $$g\in[k]$$,

$$
\begin{equation}
    \Pr(\exists t\geq 1: \mu \notin C^g_{m_t}(1/4)) \leq 1/4. 
\end{equation}
$$

Let $$E^g=\{\exists t\geq 1: \mu \notin C^g_{m_t}(1/4)\}$$, i.e., the event that the mean $$\mu$$ is not contained in $$C^g(1/4)$$ uniformly across time---call this a ``failure''. Let $$E = \sum_{g=1}^k E^g$$ count the number of failures. $$E$$ is the sum of independent Bernoulli events, each with probability at most $$1/4$$. Therefore, 

$$
\begin{equation*}
    \Pr(E\geq k/2) \leq \Pr_{B\sim \text{Bin}(k,1/4)}(B\geq k/2)\leq \exp\left\{-\frac{2(k/4)^2}{k}\right\} = \exp\{-k/8\}, 
\end{equation*}
$$

where we've employed Hoeffding's inequality to bound the event $$\{B\geq k/2\}$$. 
If there are fewer than $$k/2$$ failures, it implies that the majority of the CSs contain $$\mu$$ across all $$t$$. 
On the event $$E>k/2$$, more than half the empirical means $$S_t^g$$ are within distance $$\ell(C_{m_t}^g(1/4))$$ of the true mean $$\mu$$, in turn implying that $$\muhat^\mom$$ is within $$\max_{g\in[k]}\ell(C_{m_t}^g(1/4))$$ of $$\mu$$. QED. 


Which CSs should we deploy with the template? Since we're in a heavy-tailed setting, it's tempting to use the best known CSs for heavy-tailed observations, something like the [sequential Catoni-Giulini estimator]({% link _research_notes/catoni_giulini.md %}). But we're only deploying these CSs with $$\alpha=1/4$$, so we just want them to have a small width in that case. In the fixed-time setting, we use Chebyshev's inequality. In the sequential setting it's natural to use a sequential analogue of Chebyshev, the Dubins-Savage inequality. 

**Dubins-Savage Inequality.** Let $$(Z_t)_{t\geq 1}$$ be a scalar-valued stochastic process with conditional means $$\mu_t = \E[Z_t\vert\calF_{t-1}]$$ and conditional variances $$V_t = \Var(Z_t\vert\calF_{t-1})$$. Assume that $$\mu_t$$ is a.s. finite for all $$t$$. Then, for any $$a,b>0$$,  

$$
\begin{equation}
\label{eq:dubins-savage}
    \Pr\left(\exists t\geq 1: \sum_{i\leq t}( Z_i - \mu_i)  \geq a + b\sum_{i\leq t} V_i\right)\leq \frac{1}{ab + 1}. 
\end{equation}
$$

We apply Dubins-Savage inequality twice, once with $$Z_t^+ = \lambda_t X_t$$ for predictable scalars $$(\lambda_t)$$ and once with $$Z_t^- = -\lambda_t X_t$$. We take $$a=7$$ and $$b=1$$. Via a union bound we then obtain that 

$$
\begin{equation}
    \Pr\left(\exists t\geq 1: \bigg|\frac{\sum_{i\leq t}\lambda_iX_i}{\sum_{i\leq t} \lambda_i}-\mu\bigg| \geq \frac{7 + \sigma^2\sum_{i\leq t}\lambda_i^2}{\sum_{i\leq t}\lambda_i}\right) \leq \frac14.
\end{equation}
$$

The width of our $$1/4$$-CS is therefore $$(7 + \sum_{i\leq t}\lambda_i^2\sigma^2)/\sum_{i\leq t}\lambda_i$$. Plugging this into the template above gives the following. 


**Proposition 1.** Let $$X_1,X_2,\dots$$ have conditional mean $$\mu$$ and conditional variance upper bounded by $$\sigma^2$$. Let $$(\lambda_t)_t$$ be a predictable sequence of positive scalars and set

$$
S^g_t = \frac{\sum_{i\leq m_t^g} \lambda_iX_{\lfloor i/k\rfloor + g}}{\sum_{i\leq m_t^g} \lambda_i}.
$$

Then, for all $$\delta\in(0,1)$$, letting $$k(\delta) = \lceil 8\log(1/\delta)\rceil$$, 

$$
\begin{equation}
\label{eq:seq-mom-bound}
    \Pr\left(\forall t\geq 1: |\muhat^\mom_t - \mu| \leq \frac{7 + \sigma^2\sum_{i\leq \lfloor t/k(\delta)\rfloor} \lambda_i^2}{\sum_{i\leq \lfloor t/k(\delta)\rfloor}\lambda_i}\right) \geq 1-\delta. \tag{2}
\end{equation}
$$


Consider taking 

$$
\lambda_i \asymp \sqrt{\frac{1}{\sigma^2i\log(i+1)}}.
$$

Then, 

$$\sum_{i\leq m}\lambda_i \asymp \frac{1}{\sigma}\sqrt{\frac{m}{\log m}} \quad \text{and}\quad\sum_{i\leq m}\lambda_i^2 \asymp \frac{\log\log(m)}{\sigma^2},$$

so the right hand side of \eqref{eq:seq-mom-bound} is 

$$
\frac{7 + \sigma^2\sum_{i\leq \lfloor t/k(\delta)\rfloor} \lambda_i^2}{\sum_{i\leq \lfloor t/k(\delta)\rfloor}\lambda_i} \lesssim \sigma \sqrt{\frac{k(\delta)\log(t/k(\delta))}{t}} \log\log(t/k(\delta)).
$$ 

Loosening this bound slightly, we obtain that 


$$\Pr\left(|\muhat_t^\mom - \mu| \lesssim \sigma\sqrt{\frac{\log(1/\delta)\log(t)}{t}}\log\log(t)\right) \geq 1-\delta,$$

which is a sequential analogue to \eqref{eq:fixed-time-mom}. 
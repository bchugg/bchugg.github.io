---
layout: note 
date: "2022-09-8" 
title: "Supermartingales for Nonparametric Confidence Sequences"
description: "Constructing nonparametric confidence sequences using hypothesis testing and Ville's inequality for supermartingales"
status: published
---

$$
\renewcommand{\Pr}{\mathbb{P}}
\newcommand{\E}{\mathbb{E}}
\newcommand{\D}{\mathcal{D}}
\newcommand{\F}{\mathcal{F}}
\newcommand{\sep}{\;\vert\;}
\newcommand{\ind}{\mathbf{1}}
\newcommand{\R}{\mathbb{R}}
$$

- TOC 
{:toc}

This is an exploration of the paper [Estimating Means of Bounded Random Variables by Betting](https://arxiv.org/pdf/2010.09686.pdf). 

# 1. General Approach

For all $$v\in[0,1]$$, let $$\D(v)$$ be the set of all distributions with mean $$v$$ (discrete, continuous, mixtures, etc). Given a sequence $$X_1,X_2,\dots\sim \D$$ for some $$\D\in\D(\mu)$$ with unknown $$\mu$$, we are interested in constructing a _confidence sequence_  for $$\mu$$. A $$(1-\alpha)$$ confidence sequence is a sequence of sets $$(C_t)_{t\geq 0}$$ such that 

$$\inf_{\D\in\D(\mu)}\Pr_{\D}(\forall t,\; \mu\in C_t)\geq 1-\alpha.$$

This is equivalent to 

$$\inf_{\D\in\D(\mu)}\Pr_{\D}(\exists t,\; \mu\notin C_t)\leq \alpha,$$

and we'll generally work with the latter. Note the distinction between confidence _sequences_ and confidence _intervals_. A $$(1-\alpha)$$ confidence interval is a random variable $$C_t$$ such that 

$$\text{for all }t,\quad \inf_{\D\in\D(\mu)} \Pr_\D(\mu\in C_t)\geq 1-\alpha.$$

Having the universal quantifier outside the probability makes a big difference. It is the difference between (i) for each $$t$$, $$\mu$$ is not in $$C_t$$ with probability at most $$\alpha$$, and (ii) $$\mu$$ is not in each $$C_t$$ with probability at most $$\alpha$$. The latter is much stronger. Of course, a confidence sequence at a particular time $$t$$ will be a confidence interval at that time. 

Here we investigate how to construct such confidence sequences, using supermartingales and ideas from [game-theoretic probability]({% link _research_notes/intro_game_theory_prob.md %}). Recall [Ville's martingale inequality]({% link _research_notes/ville.md %}), which states that for a supermartingale $$M_t$$ adapted to the filtration $$(\F_t)$$, we have 

$$
\begin{equation}
\label{eq:ville}
\Pr(\exists t,\; M_t\geq \lambda\sep \F_0) \leq \frac{M_0}{\lambda}.\tag{1}
\end{equation}
$$

If $$G_t$$ is upper-bounded by the supermartingale $$M_t$$ (i.e., $$G_t\leq M_t$$ a.s.) and we take $$\lambda =1/\alpha$$, then Equation \eqref{eq:ville} implies

$$
\begin{equation}
\label{eq:ville2}
\Pr(\exists t,\; G_t\geq 1/\alpha\sep \F_0) \leq \alpha, \tag{2}
\end{equation}
$$

if $$G_0\leq 1$$. Suppose that for each $$v\in[0,1]$$, we construct a sequence $$G^t(v)=G^t(v)(X_1,\dots,X_t)$$ such that, for each $$\D\in\D(\mu)$$ (note the $$\mu$$) $$G^t(\mu)$$ is upper-bounded by a supermartingale $$M^t_\D(\mu)$$ with $$M^0_\D(\mu)=1$$. 
The intuition from Ville's inequality tells us that the supermartingale $$M^t_\D(\mu)$$ blows up with low probability. Therefore, we want to form our confidence sequence around those values of $$v$$ such that $$G_t(v)$$ remains small. 

Formally, we are interested in the event $$G^t(v)\geq 1/\alpha$$. Then, Equation \eqref{eq:ville2} gives that, for each $$\D\in\D(\mu)$$, $$\Pr_\D(\exists t,\; G_t(\mu)\geq 1/\alpha)\leq \alpha.$$ Since this holds for all $$\D\in\D(\mu)$$, we have 

$$\inf_{\D\in\D(\mu)}\Pr_\D(\exists t,\; G^t(\mu)\geq 1/\alpha)\leq \alpha.$$ 

Finally, it remains to actually construct the confidence sequence. As you might expect, we simply take the set of all $$v\in[0,1]$$ such that $$G^t(v)\leq 1/\alpha$$ (i.e., it has remained "small"). Call this set $$C_t$$. Then, 

$$\inf_{\D\in\D(\mu)}\Pr_\D(\exists t,\; \mu\notin C_t) = \inf_{\D\in\D(\mu)}\Pr_\D(\exists t,\; G^t(\mu)\geq 1/\alpha)\leq \alpha.$$

This is undoubtedly cool, but it's not immediately clear how useful it is. Is it feasible to even construct supermartingales that obey the desired properties? It turns out that yes ... yes it is. 

# 2. Recovering Chernoff 

N.B. In this section I switch from writing $$G^t(v)$$ to $$G_t(v)$$. Whoops. 

The first supermartingale we'll construct is based on Hoeffding's [famous inequality](https://en.wikipedia.org/wiki/Hoeffding%27s_lemma). Recall that for bounded random variables $$X\in[a,b]$$, Hoeffding showed that for any $$\lambda\in\R$$ and any $$\D\in\D(\mu)$$,

$$\E_\D[\exp(\lambda(X-\mu))] \leq \exp(\frac{\lambda^2}{8}(b-a)^2).$$

So, for $$X\in[0,1]$$, 

$$
\begin{equation}
\label{eq:hoeffding_lemma}
\sup_{\D\in\D(\mu)}\E[\exp(\lambda(X-\mu) - \lambda^2/8)]\leq 1. \tag{3}
\end{equation}$$

Put 

$$G_t(v) = \prod_{i=1}^t \exp(\lambda (X_i-v) - \lambda^2/8),$$

for each $$v\in[0,1]$$. Equation \eqref{eq:hoeffding_lemma} then implies that $$G_t(\mu)$$ is a supermartingale (for any $$\D\in\D(\mu)$$): 

$$
\begin{align}
\E[G_t(\mu)|\F_{t-1}] &= \prod_{i=1}^t \E[\exp(\lambda (X_i-\mu) - \lambda^2/8)|\F_{t-1}] \\
&= \E[\exp(\lambda(X-\mu) - \lambda^2/8)]\prod_{i=1}^{t-1}\exp(\lambda (X_i-\mu) - \lambda^2/8) \\
&\leq \prod_{i=1}^{t-1}\exp(\lambda (X_i-\mu) - \lambda^2/8).
\end{align}
$$

Here we're relying on independence of each $$X_i$$ and the fact that $$G_t(\mu)$$ is $$\F_t$$ measurable. Note that there is no guarantee that $$G_t(v)$$ is a supermartingale for $$v\neq \mu$$. 

Okay, this is all well and good, but how do we actually construct the confidence sequence $$C_t$$ from here? We've defined $$C_t$$ as those values $$v$$ such that $$G_t(v)$$ stays small, i.e., $$C_t=\{v:G_t(v)<\beta/\alpha\}$$. And notice that $$G_t(v)\geq 1/\alpha$$ iff 

$$\log\prod_i \exp(\lambda(X_i-v)-\lambda^2/8)\geq \log(\beta/\alpha),$$

that is, 

$$v\leq \overline{X}_t - \lambda/8 - \log(\beta/\alpha)/(n\lambda),$$

where $$\overline{X}_t = \frac{1}{t}\sum_{i=1}^t X_i$$. Now, just like in normal concentration bounds, we'll repeat the same process for $$-\overline{X}_t$$ with mean $$-\mu$$ to get the other tail. In particular, we construct the supermartingale 

$$H_t(v) = \prod_{i=1}^t \exp(\lambda(-X_i+v) - \lambda^2/8).$$

By similar arguments, we have $$H_t(v)\geq \beta/\alpha$$ iff $$v\geq \overline{X}_t +\lambda/8 + \log(\beta/\alpha)/(n\lambda)$$. Put $$A(\lambda) = \lambda/8 + \log(\beta/\alpha)$$. Then, 

$$
\begin{align}
& \Pr(\exists t: \mu\notin(\overline{X}_t-A(\lambda), \overline{X}_t+A(\lambda))) \\ 
&\leq \Pr(\exists t: \mu \leq \overline{X}_t-A(\lambda)) + \Pr(\exists t: \mu\geq \overline{X}_t + A(\lambda)) \\ 
&= \Pr(\exists t: G_t(v)\geq \beta/\alpha) + \Pr(\exists t: H_t(v)\geq \beta/\alpha) \leq \frac{2\alpha}{\beta}. 
\end{align}
$$

Taking $$\beta=2$$ gives us the desired bound of $$\alpha$$ and the confidence sequence $$C_t = \overline{X}_t \pm (\lambda/8 + \log(\frac{2}{\alpha})/(t\lambda))$$. So far, we haven't picked $$\lambda$$. To do so, we'll minimize $$A(\lambda)$$ to get 

$$\lambda=\sqrt{\frac{8\log(2/\alpha)}{t}},$$

which results in the confidence sequence 

$$C_t = \bigg(\overline{X}_t - \sqrt{\frac{\log(2/\alpha)}{2t}}, \overline{X}_t + \sqrt{\frac{\log(2/\alpha)}{2t}}\bigg).$$

This is precisely the Chernoff bound for iid random variables between 0 and 1! Because we can recover Chernoff with a particular supermartingale, this demonstrates that this approach is in fact more general (in some sense) than the Chernoff method, which involves bounding the moment generating function using Markov's inequality. Perhaps this is not surprising, given that the martingale approach is based on Ville's inequality, which itself is a generalization of Markov's inequality. 


# 3. Generalizing Chernoff: Adaptive $$\lambda$$

Notice that $$G_t(v)$$ from the previous section uses the same $$\lambda$$ for all terms in the product. Since $$\lambda$$ for $$G_t(v)$$ depends on $$t$$, this means we have to construct a new supermartingale for each set in the confidence sequence. That is, $$G_t(v)$$ and $$G_{t-1}(v)$$ do not share the same first $$t-1$$ terms in their product since $$\lambda$$ is distinct for both. 

It is natural to wonder if we can let $$\lambda$$ be a function of $$i$$ in the product, i.e., 

$$G_t(v) = \prod_{i=1}^t \exp(\lambda_i(X_i-v) - \lambda_i^2/8).$$

Indeed, $$G_t(v)$$ remains a supermartingale because Hoeffding's lemma still applies to each term. In fact, the mechanics of the previous section remain more or less untouched, and we obtain the confidence interval 

$$C_t = \frac{1}{\sum_{i=1}^t \lambda_i}\bigg(\sum_{i=1}^t \lambda_i X_i\pm[ \log(2/\alpha) + \frac{1}{8}\sum_{i=1}^t \lambda_i^2]\bigg).$$

This is much more computationally efficient, since we can reuse all values for subsequent calculations of $$C_t$$. The drawback is that optimizing the values of $$\lambda_i$$ becomes more difficult. The paper provides several "guiding principles" to help ensure tightness. 

# Resources 

- [Estimating means of bounded random variables by betting](https://arxiv.org/pdf/2010.09686.pdf)
- [Time-Uniform Chernoff bounds via nonnegative supermartingales](https://arxiv.org/pdf/1808.03204.pdf)
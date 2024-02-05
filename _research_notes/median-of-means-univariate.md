---
layout: note
title: "Median-of-Means for Univariate Distributions"
description: "Analysis of the median-of-means estimator in one-dimension" 
status: published
date: "2023-04-25"
---

$$
\newcommand{\ov}[1]{\overline{#1}}
\newcommand{\X}{\mathcal{X}}
\DeclareMathOperator*{\argmin}{\text{argmin}}
\newcommand{\rad}{\text{rad}}
\renewcommand{\Re}{\mathbb{R}}
\renewcommand{\leq}{\leqslant}
\renewcommand{\geq}{\geqslant}
\newcommand{\ind}{\mathbf{1}}
\newcommand{\eps}{\epsilon}
\renewcommand{\subset}{\subseteq}
\renewcommand{\Pr}{\mathbb{P}}
\newcommand{\bin}{\text{Bin}}
\newcommand{\Var}{\mathbb{V}}
\newcommand{\cP}{\mathcal{P}}
\newcommand{\E}{\mathbb{E}}
\newcommand{\hmu}{\widehat{\mu}}
\newcommand{\mom}{\text{MoM}}
\newcommand{\median}{\text{median}}
\newcommand{\spn}{\text{span}}
$$

- TOC 
{:toc}

Consider $$n$$ iid random variables $$X_1,\dots,X_n$$ drawn from some distribution $$P$$ with mean $$\mu=\E[X_1]$$. We want to generate an estimate $$\hmu=\hmu(X_1,\dots,X_n)$$ which is not too far from $$\mu$$ with high probability (as opposed to has low expected MSE, say). If $$P$$ is sufficiently light-tailed, the empirical mean is an optimal estimator. But its performance suffers when $$P$$ is heavy-tailed. Here we show that the _Median-of-Means_ (MoM) estimator achieves better performance on such distributions. 

# 1. Problems with the empirical mean

A natural choice of estimator is the empirical mean  $$\overline{X} = \frac{1}{n}\sum_i X_i$$. And indeed, this works nicely for sufficiently well-behaved distributions $$P$$. In particular, suppose that $$P$$ is $$\sigma$$-_sub-Gaussian_, i.e., $$\E_P e^{\lambda(X_i-\mu)}\leq e^{\lambda^2\sigma^2/2}$$ for all $$\lambda\in\Re$$. 
The Chernoff bound implies that 

$$
\begin{equation}
\label{eq:chernoff}
    \Pr\bigg(|\ov{X} - \mu\vert \leq \sigma \sqrt{\frac{2\log (2/\delta)}{n}}\bigg)\geq 1-\delta. \tag{1}
\end{equation}
$$

However, suppose only the variance $$\sigma^2=\Var(X_1)$$ exists, but no higher moments. In such a case we cannot deploy the Chernoff bound. Instead, Chebyshev's inequality tells us that, with probability at least $$1-\delta$$,  

$$
\begin{equation}
\label{eq:cheby-bound}
    |\ov{X} -\mu\vert \leq \sigma \frac{\sqrt{1/\delta}}{\sqrt{n}}. \tag{2}
\end{equation}
$$

This bound has a much looser dependence on $$\delta$$ than \eqref{eq:chernoff}. Unfortunately, rather than simply a limitation of the analysis, this dependence is inherent to such heavy-tailed distributions. [Catoni](https://arxiv.org/abs/1009.2048) gives an example demonstrating that \eqref{eq:cheby-bound} is essentially tight among distributions with only finite variance. 

This motivates the search for a new estimator. In particular, we would like an estimator which achieves the sub-Gaussian bound of \eqref{eq:chernoff} but without making light-tailed assumptions on the distribution. Let's say that an estimator $$\hmu=\hmu(X_1,\dots,X_n)$$ is $$L$$-sub-Gaussian if, for all $$\delta\in(0,1)$$, with probability at least $$1-\delta$$,

$$
\begin{equation}
    |\hmu - \mu\vert \lesssim L \sqrt{\frac{\log(1/\delta)}{n}}. 
\end{equation}
$$

We emphasize that we are searching for _non-asymptotic_ bounds. That is, we want bounds to hold for all sample sizes $$n$$, not only in the limit as $$n\to\infty$$. Such asymptotic bounds are easier to generate due to the central limit theorem (and require fewer assumptions on $$P$$), but may fail at finite (especially small) sample sizes. 



# 2. MoM with finite variance

It turns out that there is a simple estimator that achieves precisely what we want (and more). The median-of-means estimator proceeds as follows. We split the data in $$k$$ groups. To keep the arithmetic easy, we will assume that $$n$$ is multiple of $$k$$. Formally, let $$G_1,\dots,G_k$$ be any partition $$[n]$$ such that $$|G_i|=n/k$$, i.e., $$\cup G_i=[n]$$ and $$G_i\cap G_j=\emptyset$$ for all distinct $$i$$ and $$j$$. 
Let 

$$
\begin{equation}
    S_g = \frac{1}{\vert G_g\vert }\sum_{j\in G_g}X_j,
\end{equation}
$$

denote the sample mean of group $$g$$. The MoM estimator is 

$$
\begin{equation}
    \hmu^\mom_n = \median(S_1,\dots,S_k).
\end{equation} 
$$


Suppose $$\delta\in(0,1)$$ and $$k=\lceil 8\log(1/\delta)\rceil$$, then $$\hmu^\mom_n$$ satisfies 

$$
\begin{equation}
    |\hmu^\mom_n - \mu| \leq \sigma \bigg(\frac{32\log(1/\delta)}{n}\bigg)^{1/2},
\end{equation}
$$

with probability $$1-\delta$$, where $$\Var(X_1)\leq \sigma^2$$. The intuition is relatively  straightforward. The sample mean for each group is an unbiased estimator of the true mean $$\mu$$. Chebyshev's inequality implies that, with constant probability, the error $$\vert S_i-\mu\vert$$ is on the order $$\sigma/\sqrt{n/k}$$. Also, each $$S_i$$ is independent of the others. So for $$\hmu_n^\mom$$ to be far for $$\mu$$ it would require that many independent Bernoulli events are all far from their mean, which we can bound via exponential tail inequalities. Therefore, even though we don't assume anything higher than a second moment for $$P$$, we can employ powerful tail bounds on the behavior of the group means. 

As for the analysis, let $$m=n/k$$, so each group $$S_i$$ has $$m$$ elements (by assumption, $$m$$ is an integer). 
Since $$\E[S_i]=\mu$$, Chebyshev's inequality implies 

$$
\begin{align*}
    \Pr(\vert S_i - \mu\vert \geq 2\sigma/\sqrt{m}) = \Pr(\vert S_i - \mu\vert^2 \geq 4\sigma^2/m) \leq \frac{m\Var(S_i)}{4\sigma^2} \leq 1/4,
\end{align*}
$$

since $$\Var(S_i) = \frac{1}{m^2}\sum_{i\in S_g} \Var(X_i) \leq \sigma^2/m$$  by independence. Let $$E_i$$ denote the event that $$|S_i-\mu\vert \geq 2\sigma/\sqrt{m}$$. Put $$S=\sum_i E_i$$, so $$S$$ counts the number of groups whose average exceeds the mean by $$2\sigma/\sqrt{m}$$. The probability that $$S\geq k/2$$ is the probability that at least $$k/2$$ independent events, each with probability at most 1/4, occur. By definition of a binomial distribution, this is upper bounded by $$\Pr(B\geq k/2)$$ for $$B\sim\text{Bin}(k,1/4)$$. 
That is, 

$$\Pr(S\geq k/2) \leq \Pr_{B\sim \bin(k,1/4)}(B\geq k/2).$$

By definition of the median, for $$\hmu^\mom_n$$ to exceed $$\mu$$ by $$2\sigma/\sqrt{m}$$, $$k/2$$ of the groups must all exceed $$\mu$$ by that amount. Thus, 

$$
\begin{align*}
    \Pr(|\hmu^\mom_n-\mu\vert\geq 2\sigma/\sqrt{m}) &= \Pr(S\geq k/2)\leq \Pr_{B\sim \bin(k,1/4)}(B\geq k/2)\\&=  \Pr(B-k/4\geq k/4)\leq e^{-\frac{2(k/4)^2}{k}} = e^{-k/8},  
\end{align*}
$$

where the final inequality follows from Hoeffding's lemma. With $$k\geq  8\log(1/\delta)$$, we thus have 

$$\Pr(|\hmu^\mom_n-\mu\vert\geq 4\sigma\sqrt{2\log(1/\delta)/n}) \leq \Pr(B\geq k/2) \leq  e^{-k/8} \leq \delta,$$

as desired. 



# 3. MoM with infinite variance

It's possible to weaken the requirement that $$\Var(X_1)$$ is finite. Suppose only that the $$1-\eps$$ moment exists, for some $$\eps\in(0,1)$$. As before, let $$k=\lceil 8\log(1/\delta)\rceil$$. Then, with probability at least $$1-\delta$$, 


$$
\begin{equation}
    \Pr\bigg(|\hmu_n^\mom - \mu\vert> (12v)^{\frac{1}{1+\eps}} \bigg(\frac{8\log(1/\delta))}{n}\bigg)^{\frac{\eps}{\eps+1}}\bigg) \leq \delta. \tag{3}
\end{equation}
$$

Proving this requires a little more machinery than the finite variance case. 
Since we can no longer rely on Chebyshev's inequality, we need a different way to analyze the behavior of the sample means. The following is a rather technical result proved by Sébastien Bubeck and others [here](https://arxiv.org/abs/1209.1727). 

Let $$\hmu$$ be the empirical mean. Then, for all $$\delta\in(0,1)$$, with probability at least $$1-\delta$$, 

$$
\begin{equation}
\label{eq:partial_moment_bound}
\Pr(|\hmu -\mu\vert>\delta) \leq \bigg(\frac{3v}{n^\eps \delta}\bigg)^{\frac{1}{1+\eps}}. \tag{4}
\end{equation}
$$


To see this, fix any constants $$\alpha,\beta>0$$. Observe that

$$
\begin{equation}
\label{eq:lem_moment_bound1}
    \bigg\{|\hmu - \mu\vert > \beta\bigg\} \subset \bigg\{\exists i: \vert X_i - \mu\vert > \alpha \bigg\} \cup\bigg\{ \frac{1}{n}\sum_{i: \vert X_i-\mu\vert\leq\alpha} \vert X_i-\mu\vert > \beta\bigg\}. \tag{5}
\end{equation}
$$

This is easily seen by noticing that if the first event on the right hand side does not hold, then the second event on the same side is precisely the event $$\{\hmu - \mu>\beta\}$$. The union bound gives  

$$
\begin{align}
    \Pr(\exists i: \vert X_i-\mu\vert>\alpha) \leq n \Pr(\vert X - \mu\vert>\alpha) = n \Pr(\vert X - \mu\vert^{1+\eps}>\alpha^{1+\eps}) \leq \frac{n v}{\alpha^{1+\eps}}. \label{eq:lem_moment_bound2} \tag{6}
\end{align}
$$

As for the second term in \eqref{eq:lem_moment_bound1}, let $$E_i = \{\vert X_i-\mu\vert\leq \alpha\}$$. Then, by Chebyshev,

$$
\begin{align*}
    &\quad\Pr\bigg(\frac{1}{n}\sum_i \vert X_i-\mu\vert \ind_{E_i} >\beta\bigg) \\
    &= \frac{1}{n^2\beta^2}\E\bigg(\sum_i \vert X_i-\mu\vert\ind_{E_i}\bigg)^2 \\ 
    &= \frac{1}{n^2\beta^2}\bigg((n^2-n)\E[(X_1-\mu)\ind_{E_1}]^2 + n\E[(X_1-\mu)^2 \ind_{E_1}^2]\bigg) \\ 
    &\leq \frac{1}{\beta^2}\E[(X_1-\mu)\ind_{E_1}]^2 + \frac{1}{n\beta^2}\E[(X_1-\mu)^2\ind_{E_1}].
\end{align*}
$$

Note that $$E_1 = \{\vert X_1-\mu\vert\leq \alpha\} = \{\vert X_1-\mu\vert^{1-\eps}\leq \alpha^{1-\eps}\}$$, so 

$$
\begin{align*}
    \E[(X_1-\mu)^2\ind_{E_1}] = \E[(X_1-\mu)^{1+\eps} (X_1-\mu)^{1-\eps}\ind_{E_1}] \leq v \alpha^{1-\eps}. 
\end{align*}
$$

Further, by employing Hölder's inequality with $$p = 1+\eps$$ and $$q = 1 + 1/\eps$$ (it's easy to check that $$1/p + 1/q =1$$), we obtain 

$$
\begin{align*}
    \E[(X_1-\mu)\ind_{E_1}]^2 &\leq \E[(X_1-\mu)^p]^{2/p} \E[\ind_{E_1}^q]^{2/q} \\
    &\leq v^{\frac{2}{1+\eps}} \Pr(E_1)^{2/q} \leq v^{\frac{2}{1+\eps}} \bigg(\frac{v}{\alpha^{1+\eps}}\bigg)^{2/q} = v^2 \alpha^{-2\eps},  
\end{align*}
$$

where we've bounded $$\Pr(E_1)$$ the same way as above. Thus, we conclude that 

$$
\begin{equation}
\label{eq:lem_moment_bound3}
    \Pr\bigg(\frac{1}{n}\sum_i \vert X_i-\mu\vert \ind_{E_i} >\beta\bigg) \leq \frac{v^2}{\beta^2 \alpha^{2\eps}}  + \frac{v\alpha^{1-\eps}}{n\beta^2}.\tag{7}
\end{equation}
$$

Combining \eqref{eq:lem_moment_bound1}, \eqref{eq:lem_moment_bound2}, and \eqref{eq:lem_moment_bound3} and setting $$\alpha=n\beta$$ gives 

$$\Pr(\vert \hmu - \mu\vert>\beta)\leq \frac{nv}{\alpha^{1+\eps}} + \frac{v^2}{\beta^2 \alpha^{2\eps}}  + \frac{v\alpha^{1-\eps}}{n\beta^2} = \frac{2v}{n^\eps \beta^{1+\eps}} + \bigg(\frac{v}{n^\eps \beta^{1+\eps}}\bigg)^2.$$

Set $$b = \frac{v}{n^\eps \beta^{1+\eps}}$$. If $$b>1$$, then clearly $$\Pr(\vert\hmu -\mu\vert>\beta)\leq 3b$$. If $$b<1$$, then $$b^2<b$$ hence $$\Pr(\vert\hmu-\mu\vert>\beta)\leq 3b$$. Therefore, in either case we have $$\Pr(\vert\hmu-\mu\vert>\beta)\leq 3b$$. Setting $$b=\delta$$ and solving for $$\beta$$ gives the desired result. 


Now we can return to the analysis of the MoM estimator. The proof is similar to the finite variance case but we employ \eqref{eq:partial_moment_bound} to analyze the sample means in each group. For $$i\in[k]$$, let $$E_i = \{ \vert\hmu - \mu\vert\geq \eta\}$$ and $$S = \sum_i E_i$$. \eqref{eq:partial_moment_bound} implies that $$E_i$$ is Bernoulli with parameter bounded by $$(3v m^{-\eps}\eta^{-1})^{(1+\eps)^{-1}}$$, where $$m=n/k$$ is the number of points in each bin. Setting this equal to $$1/4$$ and solving for $$\eta$$ gives 

$$\eta = \bigg(\frac{12v}{m^\eps}\bigg)^{\frac{1}{1+\eps}} = \bigg(\frac{12vk^\eps}{n^\eps}\bigg)^{\frac{1}{1+\eps}} \geq (12v)^{\frac{1}{1+\eps}} \bigg(\frac{8\log(1/\delta))}{n}\bigg)^{\frac{\eps}{\eps+1}}.$$

Therefore, following precisely the same logic as above, we have 

$$
\begin{align*}
    \Pr(\vert\hmu_n^\mom - \mu\vert>\eta)\leq \Pr_{B\sim \bin(k,1/4)}(B\geq k/2) \leq e^{-k/8}, 
\end{align*}
$$

completing the argument. 


# 4. Resources 
- [Bandits with Heavy Tail](https://arxiv.org/abs/1209.1727), Bubeck, Cesa-Bianchi, Lugosi
- [Mean estimation and regression under
heavy-tailed distributions—a survey](https://arxiv.org/pdf/1906.04280.pdf), Lugosi and Mendelson 

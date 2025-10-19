---
layout: note 
date: "2024-06-10" 
title: "The variational approach to concentration"
description: "Concentration for multivariate processes based on a variational inequality"
status: published
---

$$
\newcommand{\norm}[1]{\|#1\|}
\newcommand{\Re}{\mathbb{R}}
\renewcommand{\Mspace}[1]{\mathcal{M}({#1})}
\newcommand{\E}{\mathbb{E}}
\newcommand{\la}{\langle}
\newcommand{\ra}{\rangle}
\renewcommand{\Pr}{\mathbb{P}}
\newcommand{\sd}{\mathbb{S}^{d-1}}
\newcommand{\Tr}{\text{Tr}}
\newcommand{\kl}{D_{\text{KL}}}
\newcommand{\ind}{\mathbf{1}}
\newcommand{\d}{\text{d}}
$$

Let $$(S_n)$$ be some stochastic process in, say, $$\Re^d$$. For instance, $$S_n = \sum_{i=1}^n X_i$$ for multivariate observations $$X_i\in\Re^d$$. We are aiming to generate a high probability bound on 

$$\norm{S_n} = \sup_{v:\norm{v}=1} \la v,S_n\ra.$$

There are several well-known ways to attempt this. Among them are covering, chaining, and Doob decomposition (done, e.g., [here]({% link _research_notes/dim_free_bernstein.md %})). Here we'll explore a separate (and relatively new) approach. 

The idea is to use the variational inequality which is at the core of the [PAC-Bayesian]({% link _research_notes/pac_bayes.md %}) methodology (so we could equivalently call this the PAC-Bayes approach to concentration).  This lets us simultaneously bound $$\la v,S_n\ra$$ in each direction $$v$$. Recall that a PAC-Bayes bound has the form 

$$
\begin{equation}
\label{eq:pb-basic-bound}
\Pr( \forall \rho \in \Mspace{\Theta}: \text{Something holds}) \geq 1-\delta, \tag{1}
\end{equation}
$$

where $$\Theta$$ is some parameter space and $$\Mspace{\Theta}$$ is the set of all probability measures over that space. 
A PAC-Bayes bound provides a high probability bound _simultaneously_ over all posteriors. The variational approach to concentration translates this into a high probability bound simultaneously over all directions. 

It's worth taking a moment to understand why this simultaneity property is valuable. A natural thought is to treat $$\la v,S_n\ra$$ as a scalar-valued process and apply well understood concentration results for real-valued functions to it. Doing this in the naive way would give a separate bound for each $$v\in\sd$$. So we'd have a result of the form: 

$$\forall v\in\sd, \Pr(\la v,S_n\ra \geq  B_n) \leq \delta.$$

But now we're stuck. This is not a bound on $$\sup_{v\in\sd}\la v,S_n\ra$$. One's first thought is to take a union bound over $$v$$ in order to move the "$$\forall v\in\sd$$" inside the probability statement, which would give us the result. But there are uncountably many such vectors. The  approach explored here solves this problem by translating the "$$\forall \rho\in\Mspace{\Theta}$$" in \eqref{eq:pb-basic-bound} into "$$\forall v\in\sd$$".  

This variational approach was pioneered by Catoni and Giulini ([here](https://ocatoni.perso.math.cnrs.fr/GramReg05.pdf) and [here](https://ocatoni.perso.math.cnrs.fr/CatGiulNips03.pdf)), and has now been used by a few authors to prove bounds in a variety of settings: 
- [Zhivotovskiy in 2024](https://arxiv.org/pdf/2108.08198) for bounding the singular values of random matrices, 
- [Nakakita et al. in 2024](https://ui.adsabs.harvard.edu/abs/2022arXiv221009756N/abstract) for bounding the mean of high-dimensional random matrices under heavy-tails, 
- [Giulini in 2018](https://arxiv.org/pdf/1511.06259) for estimating the Gram operator in Hilbert spaces, 
- [Myself and others in 2024](https://arxiv.org/abs/2311.08168) for estimating the mean of random vectors. 

# A general variational inequality 

Different authors use seemingly different PAC-Bayesian inequalities to achieve their results. However, [we recently showed](https://arxiv.org/pdf/2302.03421) that all of these inequalities are specific instantiations of the following more general result. 

Let $$\Theta$$ be some measurable parameter space and let $$N(\theta)$$ be nonnegative and have expected value at most 1 (it's an [e-value](https://en.wikipedia.org/wiki/E-values), if you like) for all $$\theta\in\Theta$$. Then 

$$\Pr(\forall\rho\in\Mspace{\Theta}: \E_\rho \log N(\theta) \leq \kl(\rho\|\nu) + \log(1/\delta))\geq 1-\delta,$$

where, as above, $$\Mspace{\Theta}$$ is the set of all probability measures on $$\Theta$$. The variational approach to concentration involves (i) finding some appropriate family of random variables $$N(\theta)$$, (ii) choosing $$\nu$$ and a family of distributions $$\{\rho_\theta:\theta\in\Theta\}$$ such that $$\sup_\theta \kl(\rho_\theta \|\nu)$$ is small, and (iii) applying this "master theorem."


# Example 1: Sub-Gaussian random vectors 

This comes from our paper on [time-uniform confidence spheres](https://arxiv.org/abs/2311.08168). Consider $$n$$ iid copies $$X_1,\dots,X_n$$ of a $$\Sigma$$-sub-Gaussian random vector $$X\in\Re^d$$. That is, 

$$\E\exp(\lambda \la \theta, X\ra) \leq \exp\left(\frac{\lambda^2}{2}\la\theta,\Sigma\theta\ra\right),$$

for all $$\lambda\in\Re$$ and $$\theta\in\Re^d$$. This implies that 

$$N(\theta) = \exp\left\{\lambda\sum_{i\leq n}\la \theta, X_i\ra - \frac{n\lambda^2}{2}\la\theta,\Sigma\theta\ra\right\},$$

has expectation at most 1. Let $$\nu$$ be a Gaussian with mean 0 and covariance $$\beta^{-1}I$$ for some $$\beta>0$$. Consider the family of distributions $$\{\rho_u:\norm{u}=1\}$$ where $$\rho_u$$ is a Gaussian with mean $$u$$ and covariance $$\beta^{-1}I$$. Then the KL divergence between $$\rho_u$$ and $$\nu$$ is $$\kl(\rho_u\|\nu) = \beta/2$$. Using the master theorem above, we obtain that, with probability $$1-\delta$$, _simultaneously for all distributions $$\rho$$_,

$$\lambda\sum_{i\leq n} \E_\rho \la\theta, X_i\ra \leq \frac{n\lambda^2}{2}\E_\rho \la \theta, \Sigma\theta\ra + \frac{\beta}{2} + \log(1/\delta).$$

Now, for $$\rho=\rho_u$$, $$\E_\rho \la \theta, X_i\ra = \la u,X_i\ra$$ and 

$$\E_\rho \la \theta, \Sigma\theta\ra = \la u,\Sigma u\ra + \beta^{-1}\Tr(\Sigma) \leq \norm{\Sigma} + \beta^{-1}\Tr(\Sigma),$$

using basic properties of the expectation of quadratic forms under Gaussian distributions (see e.g. [here](https://statproofbook.github.io/P/mean-qf.html)), and definition of the operator norm as $$\norm{A} = \sup_{u,v:\norm{u}=\norm{v}=1}\la u,\Sigma v \ra$$. Since this holds simultaneously for all $$\rho_u$$, we obtain that, with probability $$1-\delta$$, 

$$\sup_u \lambda \sum_{i\leq n} \la u,X_i\ra \leq \frac{n\lambda^2}{2}(\norm{\Sigma} + \beta^{-1}\Tr(\Sigma)) + \frac{\beta}{2} + \log(1/\delta).$$

The left hand side is equal to $$\lambda \norm{\sum_{i\leq n}X_i}$$, which gives us our concentration result. One can then optimize $$\lambda$$ using some calculus. This gives us state-of-the-art concentration up to an additive factor of $$(\Tr(\Sigma^2)/n)^{1/4}$$.

# Example 2: Random matrices with finite Orlicz-norm

This example is adapted from [Zhivotovskiy (2024)](https://arxiv.org/pdf/2108.08198). Let $$M_1,\dots,M_n$$ be iid copies of a random matrix $$M$$ with finite sub-exponential [Orlicz norm](https://en.wikipedia.org/wiki/Orlicz_space), in the sense that, for some $$C>0$$, 

$$\norm{\la \theta, M\phi\ra}_{\psi_1} \leq C \la\theta, \Sigma\phi\ra,$$

for all $$\theta, \phi\in\Re^d$$ where $$\Sigma = \E M$$. Here

$$\norm{Y}_{\psi_1} = \inf\left\{u>0: \E\exp(|Y|/u)\leq 2\right\}.$$

We take our parameter space in the master theorem above to be $$\Theta = \Re^d\times \Re^d$$. Let $$\nu$$ again be Gaussian with mean 0 and covariance $$\beta^{-1}\Sigma$$ and let $$\mu_u$$ be a _truncated_ Gaussian mean $$u$$, covariance $$\beta^{-1}\Sigma$$ and radius $$r$$. Being slightly loose with notation and writing $$\d\mu$$ for the density of $$\mu$$, the density of the truncated Gaussian can be written as 

$$\d\mu_{u}(x) = \frac{\ind\{\norm{x - u}\leq r\}}{Z}\d \rho_u,$$

where $$Z$$ is some normalizing constant and $$\rho_u$$ is a non-truncated Gaussian. For a vector $$u\in \Sigma^{1/2}\mathbb{S}^{d-1}$$, the KL-divergence between a truncated normal $$\mu_u$$ and $$\nu$$ is therefore

$$
\begin{align*}
    \kl(\mu_{u} \| \nu) &= \int\log\left(\frac{1}{Z}\frac{\d \rho_u}{\d\nu}(\theta)\right) {\mu}_{u}(\d\theta) \\ 
    &= \log\left(\frac{1}{Z}\right) + \frac{1}{2}\int (\la \theta-u,\beta\Sigma^{-1}(\theta-u)\ra + \la  \theta, \beta\Sigma^{-1}\theta\ra )\mu_{u}(\d\theta) \\ 
    &= \log\left(\frac{1}{Z}\right) + \frac{\beta}{2}\int (2\la \theta,\Sigma^{-1}u\ra - \la  u, \Sigma^{-1}u\ra )\mu_{u}(\d\theta) \\ 
    &= \log\left(\frac{1}{Z}\right) + \frac{\beta\la u,\Sigma^{-1} u\ra}{2} \leq  \log\left(\frac{1}{Z}\right) + \frac{\beta}{2}. 
\end{align*}
$$

Here $$Z = \Pr(\norm{\theta - u}\leq r)$$ where $$\theta\sim \rho_{u}$$. Equivalently, $$Z=\Pr(\norm{Y}\leq r)$$ where $$Y$$ is a normal with mean $$0$$ and covariance $$\beta^{-1}\Sigma$$. Hence $$1 - Z = \Pr(\norm{Y}>r)\leq \E\norm{Y}^2/r^2 = \beta^{-1}\Tr(\Sigma)/r^2$$. Thus, taking $$r = \sqrt{2 \beta^{-1}\Tr(\Sigma)}$$ yields $$Z\geq 1/2$$, and we obtain 

$$
\begin{align}
\kl(\mu_u\|\nu) \leq \log(2) + \frac{\beta}{2}. 
\end{align}
$$

Therefore, since the KL divergence is additive on product measures, we have that 

$$\kl(\rho_u\times\rho_v\|\nu\times\nu) \leq 2\log(2) + \beta.$$

Now it remains to construct a relevant quantity to use in the PAC-Bayes theorem. Consider 

$$N(\theta,\phi) = \exp\left\{\lambda\sum_{i\leq n}\la\theta, \Sigma^{-1/2}M_i\Sigma^{-1/2}\phi\ra - n\log\E\exp(\lambda\la \theta, \Sigma^{-1/2}M\Sigma^{-1/2}\phi\ra)\right\},$$

where the expectation is over $$M$$. It's easy to see that this has expectation at most 1 (it can be written as the product of terms each with expectation exactly one). We apply the master theorem with the product distribution $$\mu_u\times \mu_v$$ for $$u,v\in\Sigma^{1/2}\sd$$ where $$\sd = \{x:\norm{x}=1\}$$ is the unit sphere. Therefore, $$u = \Sigma^{1/2}u'$$ for $$v = \Sigma^{1/2}v'$$ for some $$u',v'\in\sd$$. We obtain that with probability $$1-\delta$$, for all $$u,v$$, 

$$\begin{align}
&\lambda \sum_{i\leq n}\E_{\mu_u\times \mu_v} \la \theta, \Sigma^{-1/2}M_i\Sigma^{-1/2}\phi\ra \\
&\leq n \E_{\mu_u\times\mu_v} \log \E\exp(\lambda\la\theta, 
\Sigma^{-1/2}M\Sigma^{1/2}\phi\ra) + \frac{\beta}{2} + \log(2/\delta).\label{eq:matrix_bound1}\tag{2}
\end{align}
$$

The truncated Gaussian is symmetric about its mean, so the left hand side above becomes 

$$\E_{\mu_u\times\mu_v}\la \theta, \Sigma^{-1/2}M_i\Sigma^{-1/2}\phi\ra = \la \Sigma^{-1/2}u,M_i\Sigma^{-1/2}v\ra = \la u', M_i v'\ra,$$

where, as before, $$u',v'\in\mathbb{S}^{d-1}$$.  It remains to bound the right hand side of \eqref{eq:matrix_bound1}. For this we appeal to a result which bounds the MGF of a random variable in terms of its $$\psi_1$$-norm. In particular, we appeal to an [exponential inequality]({% link _research_notes/exponential_inequalities.md %}), which states that for a random variable $$Y$$, 

$$
\begin{equation}
\label{eq:exp_ineq}
\E[\exp(\lambda (Y - \E Y))]\leq \exp(4\lambda^2\norm{Y-\E Y}_{\psi_1}^2),\quad \forall |\lambda| \leq \frac{1}{2\norm{Y-\E Y}_{\psi_1}}.\tag{3}
\end{equation}
$$

Applying this with $$Y = \la \theta,\Sigma^{-1/2} M\Sigma^{-1/2}\phi\ra$$ and noting that $$\E Y = \la \theta, \phi\ra$$, we have 

$$
\begin{align}
& \norm{\la \theta, \Sigma^{-1/2}M \Sigma^{-1/2} \phi\ra - \la \theta, \Sigma^{-1/2}\E M \Sigma^{1/2} \phi\ra}_{\psi_1} \\ 
&\leq \norm{\la \theta, \Sigma^{-1/2}M \Sigma^{-1/2} \phi\ra}_{\psi_1} + \norm{\la \theta, \Sigma^{-1/2}\E M \Sigma^{-1/2} \phi\ra}_{\psi_1} \\ 
&\leq \norm{\la \theta, \Sigma^{-1/2}M \Sigma^{-1/2} \phi\ra}_{\psi_1} + \E\norm{\la \theta, \Sigma^{-1/2} \Sigma^{-1/2} \phi\ra}_{\psi_1} \\ 
&= 2 \norm{\la \Sigma^{-1/2}\theta, M \Sigma^{-1/2} \phi\ra}_{\psi_1} \\ 
&\leq 2C \la \Sigma^{-1/2}\theta, \Sigma\Sigma^{-1/2}\phi\ra = 2C\la \theta, \phi\ra \leq C(\norm{\theta}^2 + \norm{\phi}^2). 
\end{align}
$$

Therefore, \eqref{eq:exp_ineq} yields 

$$
\begin{align}
\E\exp(\lambda \la\theta,\Sigma^{-1/2}M\Sigma^{-1/2}\phi\ra) &\leq \exp(\lambda \la \theta, \phi\ra + 4C^2\lambda^2(\norm{\theta}^2 + \norm{\phi}^2)^2). \label{eq:Eexp} \tag{4}
\end{align}
$$

Note that $$\norm{\theta - u}\leq r$$ and $$\norm{u} = \norm{\Sigma^{1/2}u'} \leq \norm{\Sigma^{1/2}} \leq \sqrt{\norm{\Sigma}}$$, so 

$$\norm{\theta}^2 \leq (r + \norm{u})^2 \leq \left(\sqrt{2\beta^{-1}\Tr(\Sigma)} + \sqrt{\norm{\Sigma}}\right)^2.$$

The same bound holds for $$\norm{\phi}^2$$. Therefore, \eqref{eq:Eexp} gives 

$$
\begin{align}
&\E_{\rho_u\times\rho_v} \log \E \exp(\lambda\la\theta, \Sigma^{-1/2} M\Sigma^{-1/2}\phi\ra ) \\
&\leq \lambda \la u,v\ra + 8C^2\lambda^2\left(\sqrt{2\beta^{-1}\Tr(\Sigma)} + \sqrt{\norm{\Sigma}}\right)^4 \\ 
&= \lambda \la u',\Sigma v'\ra + 8C^2\lambda^2\left(\sqrt{2\beta^{-1}\Tr(\Sigma)} + \sqrt{\norm{\Sigma}}\right)^4,
\end{align}
$$

assuming that 

$$|\lambda| \leq \frac{1}{4C(\sqrt{2\beta^{-1}\Tr(\Sigma)} + \sqrt{\norm{\Sigma}})^2}.$$ 

Choosing $$\beta = 2\Tr(\Sigma)/\norm{\Sigma}$$ and putting everything together, \eqref{eq:matrix_bound1} gives that with probability $$1-\delta,$$

$$\sup_{u',v'\in\sd}\lambda\sum_{i\leq n} \la u', (M_i-\Sigma) v'\ra \lesssim C^2\lambda^2 \norm{\Sigma}^2 + \frac{\Tr(\Sigma)}{\norm{\Sigma}} + \log(1/\delta).$$

Dividing by $$n$$ and optimizing over $$\lambda$$ gives us a final bound that matches state-of-the-art concentration bounds for random matrices. 







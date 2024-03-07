---
layout: note 
date: "2024-03-06" 
title: "Slightly tighter concentration for sub-Gaussian random vectors"
description: "A PAC-Bayesian argument yields slightly tighter concentration bounds for sums of sub-Gaussian random vectors"
status: published
---

$$
\newcommand{\bs}[1]{\boldsymbol{#1}}
\newcommand{\Xvec}{\bs{X}}
\newcommand{\muvec}{\bs{\mu}}
\newcommand{\E}{\mathbb{E}}
\newcommand{\la}{\langle}
\newcommand{\ra}{\rangle}
\newcommand{\thetavec}{\bs{\theta}}
\newcommand{\sd}{\mathbb{S}^{d-1}}
\renewcommand{\Re}{\mathbb{R}}
\newcommand{\kl}{D_{\text{KL}}}
\newcommand{\varthetavec}{\bs{\vartheta}}
\newcommand{\phivec}{\bs{\phi}}
\newcommand{\norm}[1]{\left\|#1\right\|}
$$


# Introduction 

We say a random vector $$\Xvec\in\Re^d$$, $$d\geq 1$$, drawn from a distribution $$P$$ with mean $$\muvec$$ is $$\sigma$$-sub-Gaussian if 

$$
\begin{equation}
\label{eq:subgaussian}
    \E_P \exp\{\lambda \la \phivec, \Xvec - \muvec\ra\} \leq \exp\left(\frac{\lambda^2\sigma^2}{2}\right)\quad\text{ for all }\quad\phivec\in\sd \text{ and }\lambda\in\Re, \tag{1}
\end{equation}
$$

where $$\sd:=\{\bs{x}\in\Re^d: \norm{\bs{x}}=1\}$$ is the unit ball in $$\Re^d$$. 
The concentration of sub-Gaussian random vectors is a well-studied topic, especially in the scalar case. Here we make a brief observation that by appealing to a seemingly unrelated branch of statistical learning theory---[PAC-Bayesian bounds]({% link _research_notes/pac_bayes.md %})---we can obtain tighter (and arguably cleaner) concentration inequalities on the behavior of sums of sub-Gaussian random vectors. 

PAC-Bayesian (a.k.a. simply "PAC-Bayes") theory emerged in the late 1990s and was refined in the early 2000s. At a high-level, the theory provides a Bayesian perspective on the successful "probably approximately correct" (PAC) framework of Valiant for statistical learning. PAC bounds are concerned with the worst case difference between the empirical loss and the expected loss and depend on the complexity of the class of learners $$\Theta$$ (via the VC-dimension, Rademacher complexity, metric entropy, etc.). The PAC-Bayes approach, meanwhile, places a prior $$\nu$$ over $$\Theta$$ and bounds the expected difference between the empirical and expected loss according to any "posterior" distribution $$\rho$$.[^1] The complexity term is replaced by a KL-divergence term between the prior and posterior. 

[^1]: Here, posterior is not meant in the Bayesian sense, i.e., it is not obtained by updating the prior via Bayes' theorem. Instead it refers to any distribution chosen after seeing the data. 

Of course, while PAC-Bayes theory was originally motivated by statistical learning, the mathematics involved can extend beyond this setting. 
Catoni and Giulini [were the first to observe this fact](https://arxiv.org/pdf/1712.02747.pdf), using PAC-Bayes bounds to estimate the mean of heavy-tailed random vectors. 
In a recent paper, [we studied](https://arxiv.org/abs/2302.03421) such bounds for general stochastic processes. A corollary of our main result is the following: 

**Proposition 1**
Suppose $$\Xvec_1,\dots,\Xvec_n\sim P$$ and let $$f:\Re^d\times\Theta \to \Re$$ obey $$\E_P \exp \{f(\Xvec, \theta)\}\leq 1$$ for each $$\theta\in\Theta$$. Fix a prior $$\nu$$ over $$\Theta$$. Then, for all $$\delta\in(0,1)$$,  
    \begin{equation}
        P\left(\forall \rho\in\mathcal{M}(\Theta):  \sum_{i=1}^n \E_{\theta\sim\rho} f(\Xvec_i,\theta) \leq \kl(\rho\|\nu) + \log(1/\delta)\right)\geq 1-\delta.
    \end{equation}

Here $$\kl(\cdot\|\cdot)$$ is the [KL divergence](https://en.wikipedia.org/wiki/Kullback%E2%80%93Leibler_divergence). 
A concentration result for sub-Gaussian random vectors will follow after selecting an appropriate function $$f$$, parameter space $$\Theta$$, prior and family of posteriors and then applying Proposition 1. 

# Sub-Gaussian concentration

Suppose we instantiate Proposition 1 with the parameter space $$\Theta = \Re^d$$ and the function 

$$
\begin{equation}
 f:(\Xvec,\thetavec)\mapsto \lambda \la \thetavec, \Xvec-\muvec\ra - \frac{\lambda^2\sigma^2\norm{\thetavec}^2}{2},   
\end{equation}
$$

for any fixed $$\lambda\in\Re$$. If $$\Xvec \sim P$$ has mean $$\muvec$$ and is $$\sigma$$-sub-Gaussian, then \eqref{eq:subgaussian} implies that $$\E_P \exp\{f(\Xvec,\thetavec)\}\leq 1$$. After choosing an appropriate prior and posterior, we obtain the following result. 

**Proposition 2**
Let $$\Xvec_1,\Xvec_2,\dots,\Xvec_n \sim P$$ be $$\sigma$$-sub-Gaussian with mean $$\muvec$$. For any $$\beta,\lambda>0$$ and $$\delta\in(0,1)$$, with probability $$1-\delta$$, 

$$
\begin{equation}
    \norm{\frac{1}{n}\sum_{i=1}^n \Xvec_i - \muvec}_2 \leq \frac{\lambda\sigma^2(d/\beta + 1)}{2} + \frac{\beta/2 + \log(1/\delta)}{n\lambda}.
\end{equation}
$$

*Proof*. 
Let $$\rho_{\phivec}$$ denote the density of the multivariate Gaussian distribution with mean $$\phivec$$ and covariance $$\beta^{-1}\bs{I}_d$$, where $$\bs{I}_d$$ is the $$d\times d$$ identity matrix. We choose our prior to be a Gaussian centered at $$\bs{0}$$, i.e., $$\nu = \rho_{\bs{0}}$$. Note that for any $$\phivec\in\sd$$, $$\kl(\rho_{\phivec}\|\nu) = \beta/2$$, which follows from well-known equations for the KL divergence between Gaussians.  
Proposition 1 applies for all posteriors over $$\Theta=\Re^d$$, but in our case it is sufficient to consider the family of posteriors $$\rho_{\phivec}$$ for $$\phivec\in\sd$$. Doing so yields that with probability $$1-\delta$$, simultaneously for all $$\phivec\in\sd$$, 

$$
\begin{align}
\label{eq:}
    \lambda \sum_{i=1}^n \E_{\thetavec\sim\rho_{\phivec}} \la\thetavec, \Xvec_i-\muvec\ra \leq \frac{n\lambda^2\sigma^2}{2}\E_{\thetavec\sim \rho_{\phivec}} \norm{\thetavec}^2 + \frac{\beta}{2} + \log(1/\delta). 
\end{align}
$$

Observing that 

$$\E_{\thetavec\sim\rho_{\phivec}} \la\thetavec, \Xvec_i-\muvec\ra = \la\phivec,\Xvec_i-\muvec\ra,$$ 

and 

$$\E_{\thetavec\sim \rho_{\phivec}} \norm{\thetavec}^2 = \text{Tr}(\text{Cov}(\beta^{-1}\bs{I}_d)) + \norm{\phivec}^2 = d/\beta + 1,$$ 

we can rearrange the above display to read 

$$
\begin{align*}
    \sup_{\phivec\in\sd} \lambda \sum_{i=1}^n \left\langle \phivec, \Xvec_i-\muvec\right\rangle \leq \frac{\lambda^2 \sigma^2 (d/\beta +1)}{2} + \frac{\beta}{2}+ \log(1/\delta).
\end{align*}
$$

Dividing by $$n\lambda$$ and 
noting that $$\sup_{\phivec\in\sd}\la \phivec, \bs{y}\ra = \norm{\bs{y}}_2$$ completes the proof. 

Proposition 2 provides us with two parameters to optimize: $$\beta$$ and $$\lambda$$. Taking $$\lambda = \sigma\sqrt{\log(1/\alpha)/n}$$ and $$\beta=\sqrt{d\log(1/\alpha)}$$ we obtain the following corollary. 

**Corollary 1.** Let $$\Xvec_1,\dots,\Xvec_n\sim P$$ be $$\sigma$$-sub-Gaussian.  Then, for all $$\alpha\in(0,1)$$, with probability $$1-\alpha$$,

$$
    \begin{equation}
    \norm{\frac{1}{n}\sum_{i=1}^n \Xvec_i - \muvec}_2 \leq \sigma\sqrt{\frac{d}{n}} + \frac{3\sigma}{2}\sqrt{\frac{\log(1/\alpha)}{n}}.
    \end{equation}
$$

Why is the PAC-Bayesian approach useful here? 
Intuitively, it's providing a high-dimensional analogue of a union bound. We are translating the fact that Proposition 1 provides a uniform bound over all posteriors into a bound in each direction $$\phivec\in\sd$$, hence the choice of $$\rho_{\phivec}$$ as our family of posteriors. In the univariate case, a traditional analysis would employ a union bound and pay a an additional factor of $$\log(2)$$. The PAC-Bayes approach replaces this price with the KL divergence between prior and posterior, which in our case is $$\beta/2$$.  

It's annoyingly hard to find explicit high probability bounds for sub-Gaussian random vectors in the literature (oddly, there are more bounds for sub-Gaussian matrices), but let's try and compare Corollary 1 to a few known results. 

A classical concentration result (found [here](https://www.stat.cmu.edu/~arinaldo/Teaching/36709/S19/Scribed_Lectures/Feb21_Shenghao.pdf) for example) obtained with a covering argument, states that, with probability $$1-\alpha$$, $$\norm{\frac{1}{n}\sum_i \Xvec_i-\muvec}\leq 4\sigma \sqrt{d}/\sqrt{n} + 2\sigma\sqrt{\log(1/\alpha)}/\sqrt{n}$$. Corollary 1 has the same order as this bound but improves the constants. 

A separate result comes from [Jin et al.](https://sham.seas.harvard.edu/files/kakade/files/1902-03736-2019.pdf), who studied so-called "norm sub-Gaussian" random vectors. These are generalizations of both norm-bounded vectors and sub-Gaussian vectors. In particular, if a random variable is $$\sigma/\sqrt{d}$$-sub-Gaussian, then it is $$2\sqrt{2}\sigma$$-norm-subGaussian. Translating their Hoeffding-style concentration result into one concerning sub-Gaussian random vectors gives that with probability $$1-\alpha$$, 

$$
\norm{\frac{1}{n}\sum_i \Xvec_i-\muvec}_2 = O(\sigma\sqrt{d\log(2d/\alpha)/n}).$$ 

Corollary 1 instead gives a bound with width $$O(\frac{\sigma}{\sqrt{n}}(\sqrt{d + \log(1/\alpha)))}$$, 
thus replacing the multiplicative dependence between 
$$d$$ and $$\log(1/\alpha)$$ with an additive dependence, and removing a factor of $$2d$$ in the log. 

---



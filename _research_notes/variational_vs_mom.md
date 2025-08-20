---
layout: note 
date: "2025-08-20" 
title: "Variational vs mixture methods"
description: "A convenient way to think about the variational approach to concentration"
status: published
---

$$
\renewcommand{\Re}{\mathbb{R}}
\newcommand{\dsphere}{\mathbb{S}^{d-1}}
\newcommand{\E}{\mathbb{E}}
\newcommand{\la}{\langle}
\newcommand{\ra}{\rangle}
\newcommand{\d}{\text{d}}
\newcommand{\kl}{\text{D}_{\text{KL}}}
$$

The last two posts explored two different ways to prove the classical self-normalized concentration inequality for sub-Gaussian processes. The original method used by de la Peña used the method mixtures. But we saw that one can also use the [variational approach to concentration]({% link _research_notes/variational_approach_to_concentration.md %}) to prove the same thing, and the last post ended abruptly with me wondering about the relationship between  the variational technique and the method of mixtures. 

I finally strumbled upon an answer (an obvious one, in hindsight), which is that *they're equally as powerful*. 

Suppose we have some random vector $$X$$ in $$\Re^d$$ with law $$P$$. We want to bound $$\|X\|$$ with high probability, where $$\|cdot\|$$ is some norm on $$\Re^d$$. Both the variational approach and the method of mixtures tell us to find some [e-value](https://thestatsmap.com/e-value) $$E(\theta)$$ for each $$\theta\in\Theta$$ which is a function of $$\la \theta, X\ra$$. Here $$\Theta$$ is some parameter space, often the unit-sphere, the unit-ball, or all of $$\Re^d$$. 

(In fact, this conversation applies to e-values more generally. We don't have to be considering concentration. Though that is arguably the most natural application.)

Such an e-value typically has the following form: 

$$
E(\theta) = \exp\{\la \theta, X\ra - \psi(\lambda)\la \theta, V\theta\ra\},
$$

for some PSD matrix $$V$$ and some real-valued function $$\psi$$. (In the sequential setting this would be a sub-$$\psi$$ process.) This is, for example, the kind of e-value we considered when proving [$$\ell_2$$ bounds on random vectors](https://arxiv.org/abs/2311.08168), and when studying [self-normalized concentration for sub-$$\psi$$ processes](https://arxiv.org/pdf/2508.06483). But more general e-values can also be considered. 

In the method of mixtures we pick some data-free distribution $$\nu$$ over $$\Theta$$ and consider the random variable 

$$E^{\nu} := \int E(\theta) \d\nu(\theta).$$

By Fubini's theorem, $$E^\nu$$ is also an e-value: 

$$
\begin{equation}
\label{eq:switch}
\E_P \int E(\theta)\d\nu  = \int \E_P E(\theta)\d\nu \leq 1,\tag{1}
\end{equation}
$$

where we can exchange the two integrals since $$\nu$$ is independent of the data. Therefore, by Markov, $$P(E^\nu > 1/\delta) \leq \delta$$. That is, with probability $$1-\delta$$, 

$$\log(E^\nu) \leq \log(1/\delta) \tag{2} \label{eq:mom-guarantee}$$ 

That's it! Of course, the trick is to choose an appropriate distribution $$\nu$$ and to compute $$E^\nu$$. 

In the variational approach, we pick some data-*dependent* distribution $$\rho$$ and we consider 

$$E^\rho := \int E(\theta) \d\rho. $$

This time, we cannot conclude that $$E^\rho$$ is an e-variable since we cannot exchange the integrals as we did in \eqref{eq:switch}.  Instead, we rely on the Donsker-Varadhan formula, which states that for a measurable function $$f:\Theta\to\Re$$ and a data-free distribution $$\nu$$ as above,   

$$\log \E_\nu \exp(f(\theta)) = \sup_\rho \left\{\E_\rho f(\theta) - \kl(\rho\|\nu)\right\},\tag{3} \label{eq:dv}$$

where the supremum is over all distributions $$\rho$$ on $$\Theta$$ and $$\kl(\rho\|\nu)$$ is the KL-divergence between $$\rho$$ and $$\nu$$. 

Consider $$f(\theta) = \log E(\theta)$$, which is well-defined since $$E(\theta)$$ is nonnegative (and we'll assume it's not identically zero for convenience). Then the Donsker-Varadhan formula gives, for any distribution $$\rho$$,  

$$
\begin{align}
\int \log E(\theta) \d\rho - \kl(\rho\|\nu) &\leq  \log \int E(\theta) \d\nu =  \log E^\nu.\tag{4} \label{eq:variational_bound}
\end{align}
$$

Then, using that $$\log E^\nu \leq \log(1/\delta)$$ with probability $$1-\delta$$ as above, the guarantee given by the variational approach is 

$$
\int \log E(\theta) \d\rho - \kl(\rho\|\nu) \leq  \log(1/\delta).
\tag{5} \label{eq:variational-guarantee}
$$

Now, the variational method is always looser than the method of mixtures in the sense of \eqref{eq:variational_bound}. To be more explicit, suppose that $$\log E^\nu = \|X\| f(\nu)$$ for some function $$f(\nu)$$ and $$\int \log E(\theta)\d\rho - \kl(\rho\|\nu) = \|X\|f(\rho)$$. Then $$f(\rho)\leq f(\nu)$$, and the method of mixtures results in a tighter bound:

$$\|X\| \leq \log(1/\delta)f^{-1}(\nu) \leq \log(1/\delta)f^{-1}(\rho).$$

But this is not the end of the story, because there exists a prior $$\rho^*$$ which achieves equality in \eqref{eq:dv}. It is the _Gibbs posterior_: 

$$ \rho^*(\d\theta) \propto \frac{E(\theta)}{\E_{\phi\sim \pi} E(\phi)} \nu(\d\theta).$$

For the Gibbs posterior we have $$f(\rho^*) = f(\nu)$$ and the variational technique and the method of mixtures both achieve the same bound. 

Ok, so if the variational approach is just as powerful as the mixture method, then why would you ever use it? Because it might be more tractable than the mixture method. Who says that $$\log E^\nu$$ has to give you a nice closed-form bound on your quantity of interest? We might be able to pick a nice data-dependent distribution such that $$\int \log E(\theta)\d\rho - \kl(\rho\|\nu)$$ is computable while $$E^\nu$$ is not. And indeed, judging by recent work in the area, this seems to be the case. 

Another reason to use the variational technique is that it provides bounds _simultaneously_ for all distributions $$\rho$$. This can be useful if computing $$\int \log E(\theta)\d\rho$$ results in a bound on $$\la \phi, X\ra$$, for some direction $$\phi$$, instead of a bound directly on the norm $$\|X\|$$. We can usually translate "for all $$\rho$$" into "for all directions $$\phi$$," which then gives a bound on $$\|X\|$$. This kind of flexibility isn't available when using the method of mixtures. 









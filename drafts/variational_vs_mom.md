---
layout: note 
date: "2025-08-09" 
title: "The variational technique generalizes the method of mixtures"
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

The last two posts explored two different ways to prove the classical self-normalized concentration inequality for sub-Gaussian processes. The original method used by de la Pena (and later Abbasi-Yadkori et al.) used the method mixtures. But we saw that one can also use the variational approach to concentration to prove the same thing. 

This had me thinking about the relationship between the variational technique and the method of mixtures. While I still don't have a total grasp of their relationship, here's a painfully obvious observation in hindsight: the variational technique can be seen as a generalization of the method of mixtures. 

Suppose we have some random vector $$X$$ in $$\Re^d$$ with law $$P$$. We want to bound $$\|X\|_2$$ with high probability (we can consider more general norms---including obviously matrix norms since that's what we did before---but let's keep it simple for now).  Both the variational approach and the method of mixtures tell us to find some e-value $$E(\theta)$$ for each $$\theta\in\Theta$$ which is a function of $$\la \theta, X\ra$$. Here $$\Theta$$ is some parameter space, often the unit-sphere, the unit-ball, or all of $$\Re^d$$. 

Such an e-value typically has the following form: 

$$
E(\theta) = \exp\{\la \theta, X\ra - \psi(\lambda)\la \theta, V\theta\ra\},
$$

for some PSD matrix $$V$$ and some real-valued function $$\psi$$. (In the sequential setting this would be a sub-$$\psi$$ process.) 

In the method of mixtures we pick some data-free distribution $$\nu$$ over $$\Theta$$ and consider the random variable 

$$E^{\nu} := \int E(\theta) \d\nu(\theta).$$

By Fubini's theorem, $$E^\nu$$ is also an e-value: 

$$
\begin{equation}
\label{eq:switch}
\E_P \int E(\theta)\d\nu  = \int \E_P E(\theta)\d\nu \leq 1,\tag{1}
\end{equation}
$$

where we can exchange the two integrals since $$\nu$$ is independent of the data. Therefore, by Markov, $$P(E^\nu > 1/\delta) \leq \delta$$. That is, with probability $$1-\delta$$, $$\log(E^\nu) \leq \log(1/\delta)$$. By Jensen's inequality, 

$$
\int\log E(\theta)\d\nu \leq \log \int E(\theta) \d\nu \leq \log(1/\delta), 
$$

and 

$$ 
\int\log E(\theta)  \d\nu = \int \la \theta, S\ra\d\nu - \psi(\lambda) \la \theta, V\theta\ra\d\nu \leq \log(1/\delta).
$$

In the variational approach, we pick some data-*dependent* distribution $$\rho$$ and we consider 

$$E^\rho := \int E(\theta) \d\rho. $$

This time, we cannot conclude that $$E^\rho$$ is an e-variable since we cannot exchange the integrals as we did in \eqref{eq:switch}.  Instead, we rely on the Donsker-Varadhan formula, which states that for a measurable function $$f:\Theta\to\Re$$ and a data-free distribution $$\nu$$ as above,   

$$\log \E_\nu \exp(f(\theta)) \geq \E_\rho f(\theta) - \kl(\rho\|\nu),$$

where $$\kl(\rho\|\nu)$$ is the KL-divergence between $$\rho$$ and $$\nu$$. Consider $$f(\theta) = \log E(\theta)$$, which is well-defined since $$E(\theta)$$ is nonnegative (and we'll assume it's not identically zero for convenience). Then the Donsker-Varadhan formula gives 

$$\int \log E(\theta) \d\rho \leq \kl(\rho\|\nu) + \log \int E(\theta) \d\nu.$$

And with probability $$1-\delta$$, using the previous bound on $$\log\int E(\theta)\d\nu$$ we have 

$$
\int \log E(\theta) \d\rho \leq \kl(\rho\|\nu) + \log(1/\delta).
$$



This is a generalization of the method of mixtures in the sense that if we pick $$\rho = \nu$$, then the KL divergence disappears and we recover the MoM bound. 

So really, the variational approach is just asking the question: What penalty do we have to suffer if we want to use a data-dependent mixing distribution in the method of mixtures? And the answer is a KL divergence (or, more generally, some $$f$$-divergence). 









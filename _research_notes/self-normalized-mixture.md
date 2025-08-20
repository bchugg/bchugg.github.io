---
layout: note 
date: "2025-08-12" 
title: "The mixture approach to sub-Gaussian self-normalized bounds"
description: "The standard way to prove the famous sub-Gaussian self-normalized bound"
status: published
---

$$
\newcommand{\la}{\langle}
\newcommand{\ra}{\rangle}
\renewcommand{\Re}{\mathbb{R}}
\newcommand{\d}{\text{d}}
\newcommand{\E}{\mathbb{E}}
$$

[Last time]({% link _research_notes/self-normalized-variational.md %}) we showed how you can obtain the famous self-normalized bound of de la Peña et al. (usually cited as the bound of Abbasi-Yadkori et al.) via the [variational approach to concentration](%{ link _research_notes/variational_approach_to_concentration.md %}). The bound was originally proven using the method of mixtures which is different than, but related to, the variational approach. 

As before, let 

$$S_t = \sum_{k\leq t} \eta_k X_k, \quad V_t = \sum_{k\leq t}X_kX_k^\intercal,$$

where $$\eta_k$$ is iid $$\sigma^2$$-sub-Gaussian noise. We'll assume that $$\sigma^2=1$$ for simplicity. Let $$V_0$$ be a positive definite matrix. The bound we're trying to prove is: With probability $$1-\delta$$, for all stopping times $$\tau$$, 

$$
\|S_\tau\|_{(V_\tau + V_0)^{-1}}^2 \leq 2 \log\left(\frac{\det^{1/2}(V_\tau + V_0)}{\delta\det^{1/2}(V_0)}\right), \tag{1} \label{eq:abbasi_bound} 
$$


As the name suggests, the method of mixtures involves _mixing_ different process using appropriate mixture distributions. 
Let $$\nu$$ be a Gaussian with mean 0 and covariance $$V_0^{-1}$$ and consider the stochastic process $$(M_t)$$ with increments

$$
\begin{equation}
    M_t = \int_{\Re^d} \exp\{  \la \theta, S_t\ra - \la \theta, V_t\theta\ra \}\nu(\d\theta).  
\end{equation}
$$

To compute $$M_t$$, notice that we can write 

$$
\begin{equation*}
    \la\theta, S_t \ra -  \la \theta, V_t\theta\ra = \frac{1}{2}\|S_t\|_{V_t^{-1}} - \frac{1}{2}\|\theta - V_t^{-1}S_t\|_{V_t}^2, 
\end{equation*}
$$

and 

$$
\begin{equation*}
  \| \theta - V_t^{-1}S_t\|_{V_t}^2 +\la \theta, V_0\theta\ra  = \|\theta - (V_0 + V_t)^{-1}S_t\|_{V_0 + V_t}^2 -2\|S_t\|_{V_t^{-1}}^{2} +2\|S_t\|_{(V_0 + V_t)^{-1}}^2. 
\end{equation*}
$$


Hence, writing out the density of $$\nu$$,

$$
\begin{align*}
    M_t &= \frac{\exp(\frac{1}{2}\|S_t\|_{V_t^{-1}}) }{\sqrt{2\pi \det(V_0^{-1})}} \int_{\Re^d} \exp\left(- \frac{1}{2}\| \theta - V_t^{-1}S_t\|_{V_t}^2 - \frac{1}{2}\la \theta, V_0\theta\ra\right) \d\theta  \\ 
    &= \frac{\exp(\frac{1}{2}\|S_t\|_{(V_0 + V_t)^{-1}}^2)}{\sqrt{2\pi \det(V_0^{-1})}} \int_{\Re^d} \exp\left(- \frac{1}{2}\|\theta - (V_0 + V_t)^{-1}S_t\|_{V_0 + V_t}^2  \right) \d\theta\\
    &= \frac{\exp(\frac{1}{2}\|S_t\|_{(V_0 + V_t)^{-1}}^2)}{\sqrt{2\pi \det(V_0^{-1})}} 
    \sqrt{2\pi \det((V_0 + V_t)^{-1}} \\ 
    &= \sqrt{\frac{\det(V_0)}{\det(V_0 + V_t)}} \exp\left(\frac{1}{2}\|S_t\|_{(V_0 + V_t)^{-1}}^2\right). 
\end{align*}
$$

Now, notice that $$N_t(\theta) = \exp\{ \la \theta, S_t\ra - \la \theta, V_t\theta\ra\}$$ defines a supermartingale for each fixed $$\theta\in \Re^d$$ (it's a sub-Gaussian process because of the assumption on the noise). Since $$\nu$$ is independent of the data, 

$$M_t = \int N_t(\theta) \d\theta,$$

is also a supermartingale by Fubini's theorem. We may thus apply [Ville's inequality]({% link _research_notes/ville.md %}) to obtain 

$$P(M_\tau \geq 1/\delta) \leq \E[M_1]\delta\leq \delta.$$ 

In other words, with probability $$1-\delta$$, $$\log M_\tau \leq 1/\delta$$, which translates to 

$$
\frac{1}{2}\|S_\tau\|^2_{(V_0 + V_\tau)^{-1}} \leq \frac{1}{2}\log\left(\frac{\det (V_0 + V_\tau)}{\det V_0}\right) + \log(1/\delta).
$$

This is precisely \eqref{eq:abbasi_bound}. 

What happened here? In the variational approach we also considered a mixture over supermartingales (the same supermartingales, in fact). But the mixture was data-dependent, and we paid the price for data-dependency with a KL divergence. Here we just stuck to a mixture over a data-independent distributions, and somehow out popped the same bound. The KL divergence was implicit in the calculation. 

Is this a more general phenomenon? What's the precise relationship between these two methods? 




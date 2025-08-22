---
layout: note 
date: "2025-08-22" 
title: "Rao-Blackwellization for e-values"
description: "Making e-values more powerful by conditioning on a sufficient statistic"
status: published
---

$$
\newcommand{\E}{\mathbb{E}}
\newcommand{\calF}{\mathcal{F}}
$$

The [Rao-Blackwell theorem](https://thestatsmap.com/Rao-Blackwell-theorem) is a famous result in statistical decision theory which says that the mean squared error (or more generally, any convex loss) of an estimator can never be made worse by conditioning on a sufficient statistic. While the theory doesn't say that the estimator will certainly get better, the gains in practice are often significant. (See this [nice example from wikipedia](https://en.wikipedia.org/wiki/Rao%E2%80%93Blackwell_theorem#Example).)

It turns out that there is a similar result in the world of [e-values](https://thestatsmap.com/e-value), which I realized recently while writing a [paper on post-hoc hypothesis testing](https://arxiv.org/pdf/2508.00770). I only wrote down the result for testing point hypotheses (see Theorem 4.10 in there), but it holds more generally. The proof is exceedingly simple and the statement is very general. 

Suppose we are testing the null $$\theta\in\Theta_0$$ against the alternative $$\theta\in\Theta_1$$, and suppose there is a sufficient statistic $$T$$ for the parameter $$\theta$$. (This probably means we're in a parametric setting.) 

Let $$E$$ be an e-variable for $$\Theta_0$$ (i.e., $$E\geq 0$$ and $$\sup_{\theta\in\Theta_0}\E_\theta [E]\leq 1$$) and define

$$S_T = \E_{\theta^*}[E \vert T],$$

for any fixed $$\theta^*\in\Theta$$. 

By definition of sufficiency, $$S_T$$ is independent of $$\theta^*$$, so $$\E_\theta [E\vert T] = \E_\phi[E\vert T]=S_T$$ for any $$\theta, \phi$$. This implies that $$S_T$$ is a bonafide e-variable: 

$$\sup_{\theta\in\Theta_0} \E_\theta[S_T] = \sup_{\theta\in\Theta_0} \E_\theta[\E_\theta[E|T]] = \sup_{\theta\in\Theta_0}\E_\theta[E]\leq 1.$$

As in the usual Rao-Blackwell setting, it's important to emphasize that $$S_T$$ is _observable_ (i.e., computable). This is because, as we said, it does not depend on $$\theta$$ by definition of a sufficient statistic. 

Next, we claim that $$\E_\phi[f(S_T)] \geq \E_\phi [f(E)]$$ for any concave function $$f$$ and any $$\phi\in\Theta_1$$. For any $$\theta\in\Theta_0$$, by concavity, 

$$
\begin{align}
    \E_\theta[f(E)|T] \leq f(\E_\theta[E|T]) = f(S_T). 
\end{align}
$$

Now, the likelihood ratio $$\Lambda_{\phi, \theta} = d P_\phi/dP_\theta$$ is _minimally_ sufficient so it is $$T$$-measurable (apply the Fisher-Neyman characterization to write $$\Lambda_{\phi,\theta}$$ as a function of $$T$$). Therefore, 

$$
\begin{align}
    \E_\phi[f(S_T)] &= \E_\theta[\Lambda f(S_T)] \geq \E_\theta[\Lambda \E_\theta[f(E)|T]] \\
    &= \E_\theta[\E_P[\Lambda  f(E)|T]] = \E_\theta[\Lambda f(E)] = \E_\phi[f(E)], \label{eq:Ef>Ef}
\end{align}
$$

proving the claim. An important special case is when $$f=\log$$, in which case we obtain that 

$$\E_\phi [\log(S_T)]\geq \E_\phi [\log(E)].$$

Log-power under the alternative is the usual criteria by which we judge e-values, and this result shows that log-power will never get worse if we condition on a sufficient statistic. 

This result can be easily extended to [e-processes](https://thestatsmap.com/e-process). If $$(E_t)$$ is an e-process adapted to a filtration $$\calF = (\calF_t)$$ and $$(T_t)$$ is a sequence of sufficient statistics also adapted to $$\calF$$ (e.g., $$T_t = \sum_{i\leq t}X_i$$ for a binomial or Poisson process), then 

$$
S_t = \E_{\theta^*}[E_t | T_t],
$$

is also an e-process. And, as above, $$\E_\phi [f (S_t)] \geq E_\phi [f(E_t)]$$ for any concave function $$f$$, so $$(S_t)$$ has at least as good a growth rate as $$E_t$$ under the alternative. 


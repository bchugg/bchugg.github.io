---
layout: note 
date: "2025-08-22" 
title: "Bayesian decision theory is post-hoc valid"
description: "On a very nice feature of Bayesianism that's missing from frequentist testing"
status: published
---

$$
\newcommand{\calA}{\mathcal{A}}
\newcommand{\argmin}{\text{argmin}}
\newcommand{\E}{\mathbb{E}}
\newcommand{\Re}{\mathbb{R}}
\newcommand{\calB}{\mathcal{B}}
\newcommand{\calX}{\mathcal{X}}
\newcommand{\d}{\text{d}}
$$

A common criticism of standard, frequentist Neyman-Pearson hypothesis testing is that it's extremely brittle under data-dependent choices of the parameters. In particular, the significance level $$\alpha$$ must be chosen in advance of seeing the data ([we previously studied this in the specific case of p-values]({% link _research_notes/p_values.md %})). As soon as $$\alpha$$ is data-dependent whatsoever, all the guarantees provided by Neyman-Pearson theory begin to break. 

One response to this problem is to yell at practitioners until they get it in their heads that they can't make these illegal post-hoc decisions. We've been doing this for many years, with limited success. There's just too much incentive to p-hack. 

Another response is to try and save Neyman-Pearson theory by making it post-hoc valid. This was the goal of [Peter Grünwald's 2024 PNAS paper](https://arxiv.org/pdf/2205.00901). I'm very sympathetic to this approach, and also wrote [a paper](https://arxiv.org/pdf/2508.00770) about it. But there are drawbacks, the biggest being that the kind of guarantee you obtain is different than the standard error probabilities. It's a heavy lift to convince the entire world to stop reporting p-values. Every social scientist would lose their mind. 

A third response is to give up on Neyman-Pearson theory and become a Bayesian. Enough of these type-I error guarantees and asymmetries between the null and the alternative. We'll just put a prior over everything and update our posteriors, which tells us all we need to know. 

This is controversial. I think it's fair to say that Bayesian methods are in the minority when it comes to applied statistics. Most analysts rely on frequentist tools like p-values, hypothesis tests, and confidence intervals. 

But Bayesianism does have a nice property: unlike Neyman-Pearson theory, it's post-hoc valid! That is, the loss function (their rough equivalent of the significance level) can change as a function of the data. This means that you can gather data, analyze it, change your goals and even what question you're asking, and then re-analyze. Regardless of how you feel about Bayesian statistics, you have to admit that this is extremely compelling. 

But as far as I can tell, that Bayesian theory is post-hoc valid is always stated as folklore. I've never seen a formal statement or proof anywhere. So that's what we're doing here. 

Let $$\Theta$$ be a parameter space, $$\calA$$ a set of actions, and $$L:\Theta\times \calA\to\Re_{\geq 0}$$ a loss function. Associated to each $$\theta\in\Theta$$ is a distribution $$P_\theta$$. 
Let $$\pi$$ be a prior on $$\Theta$$. Given observations $$X$$, Bayesian decision theory tells us to minimize the expected posterior loss. That is, we take action 
\begin{equation}
\label{eq:bayes_estimator}
    \delta_\pi(X) \equiv \argmin_{a\in\calA} \E_{\theta \sim \pi(\cdot|X)} L(\theta, a). \tag{1}
\end{equation}
A fundamental result is that the _Bayes optimal decision rule_, henceforth "Bayes decision" for brevity, is always given by $$\delta_\pi$$, meaning that it satisfies $$B_\pi(\delta_\pi) = \inf_\delta B_\pi(\delta)$$ where 
\begin{equation}
\label{eq:bayes_risk}
    B_\pi(\delta) = \E_{\theta\sim \pi} \E_{X\sim P_\theta}[L(\theta, \delta(X))].  \tag{2}
\end{equation}
(Note that $$\theta$$ is drawn from the prior $$\pi$$ in \eqref{eq:bayes_risk}, not the posterior $$\pi(\cdot|X)$$ as in \eqref{eq:bayes_estimator}.) Bayes estimators are, as the name suggests, the Bayesian equivalent to frequentist minimax estimators, and a unified solution for the Bayes decision regardless of the loss function is a big benefit of Bayesian decision theory. 


To move to a post-hoc setting, let's consider a set of losses $$\{L_b\}_{b\in\calB}$$. 
Suppose an adversary is allowed to choose which loss we're using, and this choice can be data-dependent. That is, the adversary sees the data, then chooses the loss. 
We can encode the adversary as a measurable map $$B:\calX\to\calB$$ (where the data $$X$$ is taking values in $$\calX$$). 

With this setup, Bayesian theory can accommodate a post-hoc selection of the loss in the following sense: If we minimize the expected posterior loss as before but on loss $$L_{B(X)}$$ (which we observe), then the resulting decision rule minimizes Bayes risk, where the Bayes risk is now defined in terms of the loss selected by the adversary. More formally: 

**Proposition.** The decision rule 
\begin{equation}
\phi_\pi(X) = \argmin_{a\in\calA} \E_{\theta\sim \pi(\cdot|X)} L_{B(X)} (\theta, a),
\end{equation}
satisfies 
\begin{equation}
    \E_{\theta\sim\pi} \E_{X\sim P_\theta} L_{B(X)}(\theta, \phi_\pi(X)) = \inf_{\phi} \E_{\theta\sim\pi} \E_{X\sim P_\theta} L_{B(X)}(\theta, \phi(X)), 
\end{equation}
for all $$B:\calX\to\calB$$. 


Note that $$\phi_\pi$$ is well-defined since $$\phi$$ is allowed to see $$B(X)$$ (if $$\phi$$ is not allowed to see $$B(X)$$ before making a decision, then the problem is basically impossible to solve. You'd have to assume a worse case loss). 

Again, this result isn't new per se, and the proof isn't difficult. But I can't find a similar statement anywhere. 

The proof is pretty straightforward. For any decision rule $$\phi$$, let $$\ell(\phi(x) \vert x) = \E_{\theta\sim \pi(\cdot\vert x)} L_{B(x)}(\theta, \phi(x))$$ be its expected posterior loss at a given $$x$$ on loss $$L_{B(x)}$$.  For simplicity, assume that $$P_\theta$$ has density $$p(\cdot\vert\theta)$$. Let $$p(x) = \int p(x\vert\theta)\pi(\theta)\d\theta$$ be the marginal and note that $$p(x\vert \theta)\pi(\theta) = \pi(\theta\vert x)p(x)$$. Then, by Fubini's theorem, 

$$
\begin{align}
    \E_{\theta\sim\pi} \E_{X\sim P_\theta} L_{B(X)}(\theta, \phi(X)) &= \int_\Theta \int_\calX L_{B(x)} (\theta, \phi(x)) p(x|\theta)\pi(\theta)\d x\d\theta \\ 
    &= \int_\calX \int_\Theta L_{B(x)} (\theta, \phi(x)) \pi(\theta|x)p(x)\d \theta\d x \\ 
    &= \int_\calX \ell(\phi(x)|x) p(x) \d\theta.
\end{align}
$$

By minimizing the expected posterior $$\ell(\phi(x)\vert x)$$ we're minimizing the above integrand at every $$x$$, thus minimizing the value of the integral. 

And there we have it. In the recent [paper](https://arxiv.org/pdf/2508.00770) that I mentioned, we also discuss what a notion of type-I error might  look like for Bayesians, and provide a decision rule which satisfies it. If you made it this far, you might like that. 


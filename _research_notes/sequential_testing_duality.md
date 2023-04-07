---
layout: note 
date: "2023-03-29" 
title: "Inverting Sequential Tests"
description: "A short note on the duality of sequential hypothesis testing and confidence sequences"
status: published
---

$$
\newcommand{\cX}{\mathcal{X}}
\newcommand{\cP}{\mathcal{P}}
\newcommand{\ind}{\mathbf{1}}
\newcommand{\E}{\mathbb{E}}
\newcommand{\cK}{\mathcal{K}}
$$

# 1. Fixed-time duality 

There is a well known duality between fixed-time hypothesis testing and confidence intervals. Suppose we are testing the hypotheses 

$$ H_0: \theta = \theta^*, \quad H_1: \theta\neq \theta^*,$$

for some fixed and known $$\theta^*$$. We receive samples $$X^n \equiv  X_1,\dots,X_n$$, $$X_i\in \cX$$ drawn from some distribution $$P$$. A hypothesis test based on $$n$$ samples is a function $$\phi: \cX^n \to \{0,1\},$$ where we interpret $$\phi(X^n) = 1$$ to mean "reject the null", and $$\phi(X^n) = 0$$ to mean "don't reject the null" (or "maintain the null", or "fail to reject the null", etc. All are equivalent --- no wonder Wittgenstein thought everything boiled down to language games).  We say the test is _level_-$$\alpha$$ if 

$$\sup_{P\in H_0} P(\phi(X^n) = 1) \leq \alpha.$$

That is, if the null is true, then $$\phi$$ rejects it with probability at most $$\alpha$$ . (In other words, the false positive rate is at most $$\alpha$$.)

Meanwhile, a $$(1-\alpha)$$ confidence interval for $$\theta$$ (or, more accurately, region) is a random set $$C = C(X^n)$$ such that  

$$\sup_{P\in\mathcal{P}(\theta)}P(\theta\in C(X^n)) \geq 1-\alpha,$$

where $$\mathcal{P}(\theta)$$ are all the distributions which have $$\theta$$ as the parameter of interest. (E.g., if we are testing means, then it would be the set of all distributions with mean $$\theta$$). 


Suppose we have a level-$$\alpha$$ test $$\phi^{\theta^*}$$ which tests the null $$H_0: \theta = \theta^*$$ against the alternative $$H_1: \theta\neq \theta^*$$. 
Construct the following confidence region: 

$$C(X^n) = \{\theta: \phi^{\theta}(X^n) = 0\}.$$ 

Then, 

$$\sup_{P\in \mathcal{P}(\theta^*)}P(\theta^* \notin C(X^n)) = \sup_{P\in\cP(\theta^*)}P(\phi^{\theta^*}=1) =\sup_{P\in H_0}P(\phi^{\theta^*}=1) \leq \alpha,$$

since the set of distributions in $$\cP(\theta^*)$$ is the set for which the null $$H_0 : \theta =\theta^*$$ is true. On the other hand, suppose you have a $$(1-\alpha)$$ confidence interval for some $$\theta^*$$. Then construct a hypothesis test $$\phi$$ which simply rejects if $$\theta^*\notin C(X_1,\dots,X_n)$$. It's easy to see that $$\phi$$ is level-$$\alpha$$. Therefore, confidence intervals are, in some sense, equivalent to confidence intervals. We'll see that this equivalence extends to the sequential setting as well. 

# 2. Sequential tests 

A sequential test is a sequence of functions $$\phi = (\phi_t)_{t\geq 1}$$ where $$\phi_t$$ maps $$t$$ observations $$Z_1,\dots,Z_t$$ to $$\{0,1\}$$. Similarly to fixed-time testing $$\phi_t = \phi_t(Z_1,\dots,Z_t)=1$$ is interpreted as "reject the null" at which point, in the sequential setting, we stop testing. Thus, a sequential test can equivalently be identified by the stopping time $$\tau = \inf_t \{\phi_t = 1\}$$. A sequential test is level-$$\alpha$$ if 

$$ \sup_{P\in H_0} P(\exists t\geq 1: \phi_t=1) = \sup_{P\in H_0} P(\tau < \infty) \leq \alpha, $$

meaning $$\phi$$ controls the type I error simultaneously over all time steps. 

As one would expect, the duality for sequential testing is based off of confidence sequences, which are confidence intervals that hold uniformly over time. More precisely, a confidence sequence for a parameter $$\theta$$ is a random sequence of sets $$C = (C_t)_{t\geq 1}$$ such that 

$$\sup_{P\in \cP(\theta)} P(\forall t\geq 1: \theta \in C_t)\geq 1-\alpha.$$

The duality between sequential tests and confidence sequences is nearly identical to the fixed-time setting. Given a $$(1-\alpha)$$-confidence sequence $$(C_t)$$, defining $$\phi_t = \ind(\theta^* \notin C_t)$$ gives a level-$$\alpha$$ test. Likewise, if $$\phi = (\phi_t)$$ is a level-$$\alpha$$ sequential test then taking $$C_t = \{\theta: \phi_t^\theta = 0\}$$ results in a $$(1-\alpha)$$ confidence sequence. 

# 3. Constructing sequential tests

Noticing the duality between sequential tests and confidence sequences is all well and good -- but does it help us when actually constructing sequential tests? 

We've seen before how to construct confidence sequences using (super)martingales. We do this by employing Ville's inequality. This relationship is a large part of the recent surge of interest in anytime-valid inference and game-theoretic probability. Indeed, the wealth process from the latter, which [we recall]({% link _research_notes/intro_game_theory_prob.md %}) is 

$$\cK_t(\mu) = \prod_{i=1}^t (1 + \lambda_i (X_i - \mu)),$$ 

is a $$P$$-martingale for any distribution $$P$$ on $$[0,1]^\infty$$ with mean $$\mu$$. 


But notice we can generalize this further. Indeed, suppose $$E=(E_t)_{t\geq 1}$$ is a sequence such that, for all $$P\in \cP$$ there exists some (super)martingale $$M_t^P$$ such that 

$$E_t \leq M_t^P\quad P\text{-almost surely}.$$

Then, the probability that $$E_t$$ ever exceeds $$1/\alpha$$ under any $$P\in \cP$$ is also bounded by $$\alpha$$. This immediately yields a sequential test for the null $$H_0: P \in \cP$$ versus $$H_1: P\notin \cP$$: set $$\tau = \inf_t \{ E_t > 1/\alpha\}$$. 

The construction is general enough that such processes have been given a name: _e-processes_. At any time $$t$$ the value $$E_t$$ of an e-process is an _e-value_ for $$\cP$$, which simply a random variable with expected value at most 1 under any $$P\in\cP$$.  This is because $$\E_P[E_t ]\leq \E_P[M_t^P]\leq 1$$. 

In fact, it has been [shown](https://arxiv.org/pdf/2009.03167.pdf) that "well-behaved" e-processes must obey $$E_t = \inf_P M_t^P$$. Therefore, if $$\cP = \{P\}$$ is a singleton and $$M_t^P$$ is a martingale (as opposed to a supermartingale), then  

$$1 = \E_P [M_t^P] = \E_P [E_t] = \int E_t dP,$$

which implies that $$E_t dP$$ is the density of some distribution $$Q$$. That is, $$dQ = E_t dP$$, so $$E_t$$ is the Radon-Nikodym derivative $$dQ / dP$$. Thus, in this case, we have simply recovered the likelihood ratio-test (based on the samples $$X_1,\dots,X_t$$)! In fact, this shows that the likelihood-ratio test is anytime-valid. But the theory of e-processes is more general than this, since we may consider composite distributions $$\cP$$ (such as, e.g., the set of all bounded distibutions with a common mean). 
 
The moral of the story is: If we can find an e-process for $$\cP$$, then we have a sequential test for $$H_0: P\in \cP$$, $$H_1:P\notin \cP$$. And finding e-processes is made easier via various tools from sequential analysis: martingales, Ville's inequality, and game-theoretic probability. 



# 4. Resources 
- [Game-theoretic statistics and safe anytime-valid inference](https://arxiv.org/pdf/2210.01948.pdf)













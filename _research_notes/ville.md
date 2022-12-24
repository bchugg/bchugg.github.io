---
layout: note 
date: "2022-08-24" 
title: "Markov for Martingales"
description: "Ville's inequality for supermartingales"
status: published
---

$$
\newcommand{E}{\mathbb{E}}
\renewcommand{\Pr}{\mathbb{P}}
\newcommand{\D}{\mathcal{D}}
\newcommand{\F}{\mathcal{F}}
\newcommand{\gn}{\;|\;}
$$

Possibly one of the most useful inequalities in all of probability is Markov's inequality, which states that for a non-negative random variable $$X$$, 

$$\Pr(X \geq \alpha )\leq \frac{\E[X]}{\alpha},$$

for all $$\alpha>0$$. The intuition is simple if looked at as an optimization problem. Suppose we fix the probability $$p_\alpha = \Pr(X\geq \alpha)$$ and ask the question: How small can we make $$\E[X]$$? That is, we want to solve 

$$
\begin{align*}
\min_{\D} \quad & \E_{X\sim D}[X]  \\ 
\text{s.t}\quad & p_\alpha = \Pr(X\geq \alpha) \\ 
& X\geq 0.
\end{align*}
$$

This is easy. If we could, we'd put all of $$X$$'s mass at 0, which would minimize $$\E[X]$$ subject to $$X\geq 0$$. But we have to move at least some of the mass to $$\alpha$$ or beyond. So we'll put mass $$p$$ at $$\alpha$$, and mass $$1-p$$ at 0. It should be clear that any other alteration would simply increase $$\E[X]$$. With these choices, we have $$\E[X] = \alpha p_\alpha$$, and since this minimized $$\E[X]$$, we have $$\E[X]\geq \alpha p_\alpha$$, which is the desired result. 

Admittedly, despite it's usefulness, you can only make Markov's inequality so interesting. However, it's natural to wonder whether Markov-like inequalities hold for more than just non-negative random variables. For instance, do certain random _processes_ exhibit this kind of behavior? The answer is yes. 

Recall that a supermartingale $$(X_t)$$ adapted to the filtration $$(\F_t)$$ on the filtered space $$(\Omega,\F,(\F_t),\Pr)$$ obeys 

$$\E[X_t\gn \F_\tau] \le X_\tau, \quad \text{for all }\tau\leq t.$$

Ville's inequality (mentioned in the [intro post](/research_notes/intro_game_theory_prob.md) on game-theoretic probability) generalizes Markov's inequality to supermartingales. In particular, it states that 

$$\Pr(\exists t\geq 0: X_t \geq \alpha \gn \F_0) \leq \frac{X_0}{\alpha}.$$

In other words, the probability -- given the information at the beginning of the process -- that the value of $$X_t$$ _at any time_ exceeds $$\alpha$$, is bounded in Markov-like fashion. For this reason, it's sometimes called an _infinite-horizon_ extension of Markov's inequality. 

To prove it, we'll show it holds for all finite times $$k$$, and then take the limit as $$k\to\infty$$. Define the stopping time $$T$$ to be the first time at which $$X_t$$ is at least $$\alpha$$. Formally, $$T=\inf\{t:X_t\geq \alpha\}$$. (Recall that a stopping time is simply a random $$T$$ where, for all $$t$$, one can determine if $$T=t$$ given $$\F_t$$.) Then, for some arbitrary $$k$$, define the truncated stopping time $$\tau = \min(T,k)$$. Clearly, both $$T$$ and $$\tau$$ are well-defined stopping times. 

Recall [Doob's optional stopping theorem](https://math.dartmouth.edu/~pw/math100w13/lalonde.pdf), which states that $$X_\tau$$ is measurable (almost surely) since $$\tau$$ is bounded (by construction). Thus, Markov's inequality applies to $$X_\tau$$: 

$$\Pr(T< k)\leq \Pr(X_\tau\geq \alpha \gn \F_0) \leq \frac{\E[X_\tau \gn \F_0]}{\alpha} \leq \frac{X_0}{\alpha},$$

where the first inequality follows since if $$T< k$$, then  $$\tau=T$$ and $$X_\tau =X_T\geq \alpha$$ by definition of $$T$$. The final inequality holds because $$(X_t)$$ is a supermartingale. Since this holds for all $$k$$, taking limits gives 

$$\Pr(T<\infty) = \lim_{k\to\infty} \Pr(T<k) \leq \frac{X_0}{\alpha}.$$

Noting that $$\Pr(T<\infty) = \Pr(\exists t\geq 0: X_t\geq \alpha)$$ completes the proof. 

Notice that there was nothing special about $$\F_0$$. The same proof yields 

$$\Pr(\exists t\geq T: X_t \geq \alpha \gn \F_T) \leq \frac{X_T}{\alpha},$$

for any $$T$$. 










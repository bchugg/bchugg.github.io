---
layout: note 
date: "2024-03-08" 
title: "The game-theoretic vs measure-theoretic LLN"
description: "The game-theoretic law of large numbers implies the measure-theoretic law of large numbers"
status: published
---

$$
\newcommand{\calF}{\mathcal{F}}
\renewcommand{\Re}{\mathbb{R}}
\newcommand{\E}{\mathbb{E}}
$$

When I first wrote about [the game-theoretic law of large numbers]({% link _research_notes/intro_game_theory_prob.md %}) I don't think I fully appreciated its relationship to the measure-theoretic law of the large numbers. The game-theoretic LLN can be stated as a guarantee on a certain type of full information game (a "protocol"). In the first post we stated the game in terms of three players, but we'll simplify it here for convenience. 

- Bob has some initial capital, $$C_0 = 1$$ 
- For $$t=1,2,\dots$$ 
    - Bob makes a bet $$M_t\in\Re$$ 
    - The world reveals a value $$x_t\in [0,1]$$
    - Bob updates his capital as $$C_t = C_{t-1} + M_t(1/2 - x_t)$$

The game stops if Bob goes broke (i.e., $$C_t<0$$).  Translating the result from last time into a statement about this game, Bob has a strategy which ensures that either 

$$
\label{eq:gt_slln}
\lim_{t\to\infty}\frac{1}{t}\sum_{i\leq t} x_i = 1/2, \tag{1}
$$

or he becomes infinitely wealthy ($$\liminf_{t\to\infty}C_t = \infty$$). There's nothing special about the constant 1/2 here. It could be replaced with any value between 0 and 1 and we'd simply change how Bob updates his capital. If you want to get all Bayesian about it, you might say that Bob has a belief that the average value of the observations $$x_t$$ is 1/2 and is betting accordingly. Or you don't have to get Bayesian at all, and you can instead say that Bob is able force the world to act in a certain way if the world wants to prohibit him from getting infinitely wealthy.  

Notice that there no probabilistic assumptions _whatsoever_ in the statement of the game-theoretic LLN. There are no distributions, no probability measures, no sigma algebras, nothing. It makes a deterministic statement about _every_ sequence of numbers $$(x_t)$$, namely that there exists a betting strategy such that either  \eqref{eq:gt_slln} will happen, or Bob will become infinitely wealthy. It takes only a minor amount of mathematical background to understand this statement. 

The measure-theoretic law of large numbers, on the other hand, requires graduate-level training in mathematics to fully understand. You need the notion of a probability measure, a sigma-algebra, and of almost-sure convergence (or convergence in probability for the weak law), which requires sophisticated tools from measure-theory to state, let alone understand. 

It's therefore somewhat remarkable that the game-theoretic LLN implies the measure-theoretic LLN (the _strong_ LLN, in fact, which implies the weak LLN) for bounded observations. The game-theoretic LLN is therefore a stronger statement than its measure-theoretic counterpart. 

To see that the game-theoretic LLN implies the measure-theoretic LLN, we add some distributional assumptions to the game above. Suppose the values $$x_t$$ are drawn iid from $$[0,1]$$ with mean $$1/2$$ (of course, $$[0,1]$$ can be replaced with any finite range). Let $$\calF_t$$ denote the $$\sigma$$-algebra of observations witnessed by the end of round $$t$$, i.e., $$\calF_t = \sigma(x_1,\dots,x_t)$$. Since $$M_t$$ is announced before witnessing $$x_t$$, it can only be based on the information in rounds $$1,2,\dots,t-1$$. That is, in measure-theoretic terms, $$M_t$$ is $$\calF_{t-1}$$-measurable. This implies that Bob's wealth process, $$(C_t)_{t\geq 1}$$, is a martingale (with respect to the distribution over $$(x_t)$$): 

$$\E[C_t|\calF_{t-1}] = \E[C_{t-1} + M_t(1/2 - x_t)|\calF_{t-1}] = C_{t-1} + M_t\E[1/2 - x_t|\calF_{t-1}] = C_{t-1}.$$

Moreover, Bob's betting strategy ensures that $$C_t\geq 0$$ for all $$t$$, implying that $$(C_t)$$ is a _nonnegative_ martingale. Nonnegative martingales starting at any finite value reach infinity with probability zero, i.e., 

$$\Pr( \sup_{t} C_t = \infty) = 0.$$

That is, Bob achieves infinite wealth with probability 0. Therefore, \eqref{eq:gt_slln} must happen with probability 1: 

$$\Pr\left(\lim_{t\to\infty} \frac{1}{t}\sum_{i=1}^t x_i = 1/2\right) = 1,$$

which is precisely the (strong) law of large numbers. 


# References 

- [Aaditya Ramdas' course on game-theoretic probability, statistics, and learning](https://www.stat.cmu.edu/~aramdas/gtpsl/index.html)








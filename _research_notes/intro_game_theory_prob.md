---
layout: note 
date: "2022-02-19" 
title: "Introduction to Game-Theoretic Probability: Law of Large Numbers"
status: unpublished
---

$$
\newcommand{\R}{\mathbb{R}}
\newcommand{\strat}{\varphi}
\newcommand{\proc}{\mathcal{S}}
\newcommand{\cp}{\mathcal{K}}
$$

Consider a full information game between three players: Forecaster, Skeptic, and Reality. It proceeds as follows: 

- Skeptic has some initial capital, $$C_0$$. 
- For rounds $$n=1,2,\dots$$ 
    - Forecaster announces a value $$v_n$$ 
    - Skeptic annonces a value $$M_n$$ 
    - Reality announces $$y_n$$
    - The new capital of $$S$$ is $$C_n = C_{n-1} + M_n(y_n - v_n)$$

It's helpful to consider yourself as playing the skeptic. Either you want to become rich as play progresses, i.e., 

$$C_n \xrightarrow{n\to\infty} \infty,$$

or you want to constrain the behavior of Forecaster and Reality -- that is, to constrain their behavior in some way. For example, you might force them with each other in the limit: 

$$
\begin{equation}
\label{eq:lln}
\lim_{n\to\infty} \frac{1}{n}\sum_{i=1}^n (y_i - v_i) = 0. \tag{1}
\end{equation}
$$

In the language of game-theoretic probability, $$M_n$$ is the bet that skeptic is placing on the forecast $$v_n$$. If $$M>0$$, he's assuming $$y_n$$ will be greater than $$v_n$$. Likewise for $$M_n<0$$. If his bet is correct, he'll add $$\vert M_n(y_n-v_n)\vert$$ to his capital; otherwise he loses the same amount. 

# Some terminology and prelims 

To begin rigorously analyzing such games, we need to introduce various concepts. 

## Events and Variables 

Like most areas of math, there's a slew of new (ish?) terminology that goes along with it. Most of it is intuitive and often you can get by without paying too attention to the precise definitons. But we still need to introduce several precise meanings to start proving things.  

Together, we refer to the skeptic and reality as Skeptic's opponents. An _event_ is a condition on the opponents. E.g., Equation $$\eqref{eq:lln}$$ is an event. A _situation_ is a finite sequence of moves by the opponents, i.e., $$\{v_1,y_2,v_2,y_2,\dots,v_k,y_k\}$$. An infinite sequence of moves played by reality is a _path_. Call $$\Omega$$ the sample space of all paths. A function 


$$X:\Omega\to\R$$ 

is called a _variable_. 

## Processes and Strategies

Let $$\mathbb{S}$$ be the set of all situations. A function 

$$\proc:\mathbb{S}\to\R$$ 

is a _process_. 


## Forcing and weak forcing 

Clearly, there is a strong similarity between these language choices and conventions from Kolmogorov probability theory. This is on purpose, and allows you to start forming a mental map of the relationships, and to perhaps anticipate some of the results. For instance, a foundational concept is normal probability is an _almost sure_ event. Here, as alluded to above, this means an event $$E$$ such that $$C_n\geq 0$$ and either 

$$\lim_n C_n =\infty\quad\text{or}\quad E \text{ happens}.$$ 

That is, the skeptic does not risk bankruptcy and either the skeptic becomes infinitely rich or forces $$E$$ to transpire. For this reason, we'll also say that the skeptic _can force_ $$E$$. 

Note also that $$f:\Omega\to\R$$ would be a random variable in measure-theoretic probability, but here we can drop the adjective "random" since our formalization involves no randomness. 


A strategy $$\strat$$ for Skeptic _weakly forces_ event $$E$$ if $$\proc^\strat \geq 0$$ and 

$$\sup_n \proc^\strat_n(\omega) =\omega$$ 

for all $$\omega\not\in E$$. 

Weak forcing is (surprise surprise) weaker than forcing, meaning that if we can weakly force $$E$$ we can force $$E$$. 

# Proving LLN 

To give a sense of how arguments can proceed in this space, we're going to prove the game-theoretic version of the LLN above. 

For simplicity, we'll assume that the forecaster always bets $$v_n=0$$. We'll show later that this assumption is without loss of generality. In this case the capital process is

$$\proc^\strat = \proc^\strat + \strat_n y_n.$$

Our goal is to show that the skeptic can force event $$E$$, where $$E$$ is the event 

$$\lim_{n\to\infty}\frac{1}{n}\sum_{i=1}^n y_i = 0.$$ 

Put $$\bar{y}_n = \frac{1}{n}\sum_{i=1}^n y_i$$. By the arguments it suffices to show that skeptic can _weakly_ force $$E$$. 




# Resources 

- [Game-Theoretic Foundations for Probability and Finance](https://www.wiley.com/en-us/Game+Theoretic+Foundations+for+Probability+and+Finance+-p-9780470903056) by Glenn Shafer and Vladimiar Vovk. See also the [Game-Theoretic Probability and Finance Project](http://www.probabilityandfinance.com/). 
- The course [Game-Theoretic Statistical Inference](https://www.stat.cmu.edu/~aramdas/betting/b21.html) by Shafer, Wang, and Ramdas. 

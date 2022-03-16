---
layout: note 
date: "2022-02-19" 
title: "Introduction to Game-Theoretic Probability"
status: unpublished
---

$$
\newcommand{\R}{\mathbb{R}}
\newcommand{\strat}{\varphi}
\newcommand{\proc}{\mathcal{S}}
\newcommand{\cp}{\mathcal{K}}
\newcommand{\cps}{\cp^\strat}
\newcommand{\eps}{\epsilon}
\renewcommand{\by}{\bar{y}}
$$

# Intro

Consider a full information game between three players: Alice, Bob, and Reality. It proceeds as follows: 

- Bob has some initial capital, $$C_0$$. 
- For rounds $$n=1,2,\dots$$ 
    - Alice announces a value $$v_n$$ 
    - Bob annonces a value $$M_n$$ 
    - Reality announces $$y_n$$
    - The new capital of $$S$$ is $$C_n = C_{n-1} + M_n(y_n - v_n)$$

It's helpful to consider yourself as playing Bob, and against Alice and Reality (who we'll henceforth call the _opponents_). Naturally, you want to become rich as play progresses, i.e., 

$$C_n \xrightarrow{n\to\infty} \infty,$$

or, barring that, you want to constrain the behavior of Alice and Reality -- that is, to constrain their behavior in some way. Basically, if you can't get your way and become infinitely wealth, let's be sure to exact some vengeance. For example, we'll show later that you can force them to agree with each other in the limit: 

$$
\begin{equation}
\label{eq:lln}
\lim_{n\to\infty} \frac{1}{n}\sum_{i=1}^n (y_i - v_i) = 0. \tag{1}
\end{equation}
$$

In the language of game-theoretic probability, $$M_n$$ is the bet that Bob is placing on the forecast $$v_n$$. If $$M>0$$, he's assuming $$y_n$$ will be greater than $$v_n$$. Likewise for $$M_n<0$$. If his bet is correct, he'll add $$\vert M_n(y_n-v_n)\vert$$ to his capital; otherwise he loses the same amount. 

# Some terminology and prelims 

To begin rigorously analyzing such games, we need to introduce various concepts. 

## Events and Variables 

Like most areas of math, there's a slew of new (ish?) terminology that goes along with it. Most of it is intuitive and often you can get by without paying too attention to the precise definitons. But we still need to introduce several precise meanings to start proving things.  

An _event_ is a condition on the opponents. E.g., Equation $$\eqref{eq:lln}$$ is an event. An infinite sequence of moves played by the opponents is a _path_. Call $$\Omega$$ the sample space of all paths. A function 

$$X:\Omega\to\R$$ 

is called a _variable_. 

## Processes and Strategies

Let $$\mathbb{S}$$ be the set of all situations. A function 

$$\proc:\mathbb{S}\to\R$$ 

is a _process_. 


## Forcing and weak forcing 

Clearly, there is a strong similarity between these language choices and conventions from Kolmogorov probability theory. This is on purpose, and allows you to start forming a mental map of the relationships, and to perhaps anticipate some of the results. For instance, a foundational concept is normal probability is an _almost sure_ event. Here, as alluded to above, this means an event $$E$$ such that $$C_n\geq 0$$ and either 

$$\lim_n C_n =\infty\quad\text{or}\quad E \text{ happens}.$$ 

That is, the Bob does not risk bankruptcy and either the Bob becomes infinitely rich or forces $$E$$ to transpire. For this reason, we'll also say that the Bob _can force_ $$E$$. 

Note also that $$f:\Omega\to\R$$ would be a random variable in measure-theoretic probability, but here we can drop the adjective "random" since our formalization involves no randomness. 


A strategy $$\strat$$ for Bob _weakly forces_ event $$E$$ if $$\proc^\strat \geq 0$$ and 

$$\sup_n \proc^\strat_n(\omega) =\omega$$ 

for all $$\omega\not\in E$$. 

Weak forcing is (shockingly) a weaker condition than forcing, meaning that meaning that if we can weakly force $$E$$ we can force $$E$$. 

TODO: Show that. 

# Averaging Strategies: The Infinite Casino

Thus far, we've conceived of Bob as playing a single game against his opponents. But, as we'll see, a common technique to force events is to average various strategies. To this end, it's helpful to consider the Bob as splitting his attention among many games. He walks into an infinite casino with two players, reality and Alice, sitting at each table. He can decide to play at any subset of the tables. 

Suppose he plays strategy $$\strat_1$$ at table 1, and $$\strat_2$$ at table 2. We can consider an overall strategy $$\alpha_1\strat_1 + \alpha_2\strat_2$$ for any convex combination $$\alpha_1+\alpha_2=1$$, and interpret it as Bob splitting his initial capital $$C_0$$ between two accounts, putting $$\alpha_1 C_0$$ on table 1, and $$\alpha_2 C_0$$ on table 2. And there's no reason he can't split her capital among infinitely many strategies. In that case, we have the overall strategy 

$$\strat = \sum_{i=1}^\infty \alpha_i \strat_i,$$

where $$\sum_{i=1}^\infty \alpha_i=1$$. For this to be a legitimate strategy, however, we need that $$\sum_i \alpha_i \strat_i$$ converges in $$\R$$ _for each_ $$n$$ since Bob can only bet a finite amount at any time. 

Naturally, the capital process for a strategy $$\sum_i \alpha_i \strat_i$$ is 

$$\cp_n^{\sum_i \alpha_i \strat_i} = \sum_i \alpha_i \cp_n^{\strat_i}.$$

Averaging strategies is useful for the following reason: Suppose $$\strat_1$$ forces $$E_1$$ and $$\strat_2$$ forces $$E_2$$. Then $$\strat = \alpha_1\strat_1 + \alpha_2\strat_2$$ forces $$E_1\cap E_2$$. Seeing this is mostly a matter of unwinding definitions. If $$\omega$$ is such that $$\lim_n \cps_n(\omega)<\infty$$, then the capital processes of both $$\alpha_1\strat_1$$ and $$\alpha_2\strat_2$$ are finite as well. But that means, by definition of forcing, that $$E_1$$ and $$E_2$$ both happen on this path. 

This argument can be extended to countably infinite stategies as well. Suppose $$\strat_i$$ forces $$E_i$$ for $$i=1,2,\dots$$. Since $$\cp^{\strat_i}_n=\cp_{n-1}^{\strat_i} + \strat_{i,n}y_n\geq 0$$ (by definition of forcing), we have

$$\vert \strat_{i,n} \vert \leq \frac{\cp_{n-1}^{\strat_i}}{B},$$

otherwise we could set $$y_n = B$$ or $$y_n=-B$$ to force bankruptcy. (Here $$\strat_{i,n}$$ is the $$n$$-th move of the $$i$$-th strategy.) This, in turn, implies that $$\cp_{i,n}y_n \leq \cp_{n-1}^{\strat_i}$$ (since $$y_n\leq B$$). Therefore, 

$$\cp_n^{\strat_i}=\cp_{n-1}^{\strat_i} + \strat_{i,n}y_n \leq 2\cp_{n-1}^{\strat_i} = 2(\cp_{n-2}^{\strat_i}+\strat_{i,n-1}y_{n-1})\leq 4\cp_{n-2}^{\strat_i}\leq \dots\leq 2^n C_0.$$

Combining this with the inequality above gives 

$$\vert \strat_{i,n}\vert \leq \frac{2^n C_0}{B}.$$

Consider the strategy 

$$\strat = \sum_k 2^{-k} \strat_i,$$

which is a valid convex combination because $$\sum_k 2^{-k}=1$$, and which converges for fixed $$n$$ because 

$$\sum_k \vert 2^{-k}\strat_{i,n}\vert \leq \frac{2^nC_0}{B}\sum_k \frac{1}{2^k}=\frac{2^nC_0}{B}<\infty.$$

From here, the arguments proceeds the same as above. For a path $$\omega$$ with $$\sup_n \cps_n(\omega)<\infty$$, it must be the case that $$\sup_n 2^{-k}\cp_n^{\strat_i}<\infty$$ as well. Therefore, on this path, $$E_k$$ occurs, meaning that $$\cap_{k=1}^\infty E_k$$ does too. 


# Proving LLN 

To give a sense of how arguments can proceed in this space, we're going to prove the game-theoretic version of the LLN above. 

For simplicity, we'll assume that the Alice always bets $$v_n=0$$. We'll show later that this assumption is without loss of generality. In this case the capital process is

$$\cps_n = \cps_{n-1} + \strat_n y_n.$$

Our goal is to show that the Bob can force event $$E$$, where $$E$$ is the event 

$$\lim_{n\to\infty}\frac{1}{n}\sum_{i=1}^n y_i = 0.$$ 

Put $$\bar{y}_n = \frac{1}{n}\sum_{i=1}^n y_i$$. By the arguments above it suffices to show that Bob can _weakly_ force $$E$$. To do this, we'll use a standard approach from analysis. Let $$\eps>0$$ and consider the events 

$$E^+: \limsup_n \by_n \leq \eps,\quad\text{and}\quad E^-:\liminf_n \by_n\geq -\eps.$$

Focus first on $$E^+$$. Consider the strategy $$\strat$$ which begins with initial stake $$C_0>0$$ and then proceeds to bet $$\eps \cps_{n-1}$$ (i.e., risks $$\eps$$ times the current amount of capital) on round $$n$$. Then, $$\cps_1 = \cps_0 + \strat_1y_1 = C_0(1 + \eps y_2)$$, and 

$$\cps_2 = \cps_1 + \strat_2 y_2 = \cps_1(1 + \eps y_2) = C_0(1 + \eps y_1)(1 + \eps y_2).$$

In general, 

$$\cps_n = C_0\prod_{i=1}^{n} (1 + \eps y_i).$$ 

To show that Bob weakly forces $$E^+$$ with this strategy, we need to show that for all $$\omega$$ such that $$ \sup_n \cps_n(\omega) <\infty$$, that $$E^+$$ happens. Consider some path $$\omega$$ such that $$\sup_n \cps_n(\omega) <\infty$$. Then there is some finite upper limit $$L_\omega$$ with $$\sup_n \cps_n(\omega)\leq L_\omega$$. Now we need some expression involving $$\by_n$$. Taking the logarithm of the product above seems like a good start. Since $$\cps_n \leq L_\omega$$ we have 

$$\log L_\omega \geq \log \cps_n = \log C_0\prod_i^n (1+\eps y_i) = \log C_0 + \sum_{i=1}^n \log(1 + \eps y_i).$$

Set $$C_0=1$$ in our strategy so that $$\log C_0$$ disappears. Recall that $$x-x^2 \leq log(1+x)$$ for $$x\geq -1/2$$. Since $$y_i\geq -B$$ and $$\eps$$ is small (wlog take it to be $$\leq 1/2B$$) we have that $$\eps y_i\geq -1/2$$. Hence, 

$$\log L_\omega \geq \sum_i (1 + \eps y_i) \geq \eps\sum_i y_i -\eps^2\sum_i y_i^2 \geq \eps\sum_i y_i -B^2\eps^2n,$$

where the final inequality follows because $$y_i\in [-B,B]$$. Rearranging gives 

$$\by_n \leq \frac{\log L_\omega}{\eps n} + B^2\eps\xrightarrow{n\to\infty} B^2\eps.$$

We can't say whether $$\lim \by_n$$ exists, but this does let us bound the limit superior: 

$$\limsup_n \by_n \leq B^2\eps.$$

Running through the same argument with $$-\eps$$ gives the result for $$E^-$$. 


# Resources 

- [Game-Theoretic Foundations for Probability and Finance](https://www.wiley.com/en-us/Game+Theoretic+Foundations+for+Probability+and+Finance+-p-9780470903056) by Glenn Shafer and Vladimir Vovk. 
- The [Game-Theoretic Probability and Finance Project](http://www.probabilityandfinance.com/). 
- The course [Game-Theoretic Statistical Inference](https://www.stat.cmu.edu/~aramdas/betting/b21.html) by Shafer, Wang, and Ramdas. 

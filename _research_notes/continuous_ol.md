---
layout: note 
date: "2023-01-29" 
title: "Continuous online learning"
description: "The continuous extension of the learning with experts' advice problem"
status: published
---


$$
\newcommand{\ind}{\mathbf{1}}
\newcommand{\eps}{\epsilon}
\newcommand{\la}{\langle}
\newcommand{\ra}{\rangle}
\newcommand{\F}{\mathcal{F}}
\newcommand{\d}{\,\text{d}}
\newcommand{E}{\mathbb{E}}
\newcommand{\Var}{\mathbb{V}}
\newcommand{\R}{\mathbb{R}}
\newcommand{\reg}{\text{Reg}}
$$

- TOC 
{:toc}

Nick Harvey's group at UBC has seemingly done the impossible, which is to apply stochastic calculus to something besides finance. This post is about a continuous time version of the prediction with experts' advice problem, following [this paper](https://arxiv.org/pdf/2206.00236.pdf). 

Before we jump to the continuous version, let's discuss the discrete time version of the experts problem. Suppose we have $$n$$ experts. 

For $$t=1,2,\dots,T$$: 
- The player chooses a strategy $$p_t \in \Delta_n := \{p\in[0,1]^n: \vert\vert p\vert\vert_1=1\}.$$
- An adversary chooses $$g_t \in [-1,1]^n$$, i.e., a *gain* for each expert. 
- The player receives the reward $$r_t = \la p_t,g_t\ra$$. 

This may look slightly different than what you're used to. Online learning with experts is often framed in terms of losses instead of gains, but this is an equivalent formulation and is more amenable to a continuous time extension.  

Typically we're interested in the _regret_ of the player, i.e., the difference between the best expert in hindsight and the player's reward. Formally, the regret at time $$t$$ is, 

$$R(t) = \max_{j\in[n]}\sum_{i=1}^t g_i(j) - \sum_{i=1}^t r_i.$$

If the time horizon $$T$$ is known in advance, we are in the _fixed-time_ (or fixed _horizon_) setting. If not, we are in the _anytime_ setting. The anytime setting is harder than the fixed-time setting, as we want regret guarantees that hold for all $$t$$ simultaneously. In the fixed-time setting we know which $$t$$ we're optimizing for which tends to make things easier. How *much* easier is actually an open question: Is the anytime-version fundamentally harder than the fixed-time setting? Currently there is a difference of $$\sqrt{2}$$ between the best fixed-time regret (which we know to be optimal), and the best anytime regret (which we don't). 

To make things even more interesting, at present the best bounds for the _quantile_ regret problem are the same in the fixed-horizon case and the anytime case. These bounds come from this Harvey et al. paper, which presents algorithms for the continuous time experts' problem and then discretize it with no loss in the tightness of the bound.  

For gains in $$[-1,1]$$, the state of the literature looks like this: 

| | Discrete time  | Continuous time | 
| ----:  |  ----  | -- | 
| Fixed-horizon regret | $$\sqrt{2T\log n}$$ (MWU, Vovk 1990). Optimal | $$\sqrt{2T\log n}$$ (Harvey et al. 2022)| 
| Anytime regret | $$2\sqrt{T\log n}$$ (MWU, Bubeck et al. 2011) | $$2\sqrt{T \log n}$$ (Harvey et al. 2022)| 
| Fixed-horizon $$\eps$$-quantile regret | $$2\sqrt{2T\log(1/\eps)}$$ (Orabona and Pal, 2016 & Harvey et al. 2022) | $$\leq 2\sqrt{2 t\log(1/\eps)}$$ (Harvey et al. 2022) |
| Anytime $$\eps$$-quantile regret | $$\leq 2\sqrt{2 t\log(1/\eps)}$$ (Harvey et al. 2022) |  $$\leq 2\sqrt{2 t\log(1/\eps)}$$ (Harvey et al. 2022) |


We won't focus on the discretization step here, only the setup and algorithm for the continuous time problem.

# 1. Problem setup 

To adapt this problem to the continuous setting, we need continuous notions of a strategy, the adversarial gain, and the reward. To do so, we'll use stochastic calculus. 

The continuous notion of a strategy is easy enough. It will simply be a continuous time predictable stochastic process $$(p_t)_{t\in [0,\infty]}$$. Technically we'll need to assume that the process is left-continuous. 

We'll model the gain as a stochastic differential equation. For the moment, suppose there is just one expert. Her gain $$G$$ will obey the SDE 

$$
\begin{align}
\label{eq:gain}
\d G(t) = w(t) \d B(t),  \tag{1}
\end{align}
$$

where $$B(t)$$ is a Wiener process (i.e., standard Brownian motion). Recall that the Wiener process obeys $$B(0)=0$$, and $$B(t+z) - B(t)$$ is a random variable distributed as $$N(0,z)$$ which is independent from past values $$B(\tau)$$, $$\tau<t$$ (independent increments). (But there are [many other](https://en.wikipedia.org/wiki/Wiener_process) characterizations.) 

Equation \eqref{eq:gain} is [shorthand for the Itô integral]({% link _research_notes/intro_ito.md %}) 

$$G(t) - G(s) = \int_s^t w(\tau) \d B(\tau).$$

Because Brownian motion has independent increments, Equation \eqref{eq:gain} is essentially saying that, in a small time interval $$\delta$$, $$G(t+\delta) - G(t)$$ is drawn as a random variable with mean 0 and variance $$w(t)^2 \delta$$. We can see this informally by assuming that the process $$w(t)$$ changes only at times $$t$$ and $$t+\delta$$. Then, the definition of the Itô integral gives: $$G(t+\delta) - G(t) = w(t)[B(t+\delta) - B(t)]$$. The process $$w$$ adapted to $$B$$, meaning that $$w(t)$$ is $$\F_t= \sigma(B(\tau)\vert\tau\leq t)$$ measurable. Therefore, 

$$\E[G(t+\delta) - G(t)|\F_t] = w(t)\E[B(t+\delta) - B(t)]=0,$$

and

$$\Var[G(t+\delta) - G(t)|\F_t] = w^2(t)\delta,$$

by the properties of $$B$$. 

For $$n$$ experts, we define the gain process of the $$i$$-th expert as  

$$ \d G_i(t) = \sum_{j=1}^n w_j^{(i)}(t) \d B_j(t).$$

The sum across all experts means we're allowing correlation between the gains of each expert. Here, $$w^{(i)}$$ is some stochastic process in $$\R^n$$ (it's allowed to be negative) such that $$\sum_j w^{(i)}(t)=1$$. That is, the gain of expert $$i$$ is a convex combination of the processes of all experts. As above, this equation is shorthand for the Itô integral

$$G_i(t) - G_i(s) = \sum_{j=1}^n \int_s^t w_j^{(i)}(\tau)\d B_j(\tau).$$

If $$w^{(i)}(t)=e_i$$ ($$i$$-th basis vector), then the gains of all experts are governed by independent Brownian motions. 

An obvious question at this point is whether Brownian motion is the "correct" stochastic process for the experts' problem. After all, in discrete time, Brownian motion reduces to a gain of -1 or +1 with probability 1/2, meaning that the gain is a standard random walk. A more flexible framework would be to allow for more general SDEs to govern the gain. For instance, 

$$\d G(t) = \mu(G(t), t)\d t + \sigma(G(t),t) \d B(t),$$

for functions $$\mu$$ and $$\sigma$$. Here, we interpret $$G(t+\delta)-G(t)$$ as having mean $$\mu(G(t),t)$$, which would be a natural way for an adversary to ensure some experts are performing better than others. 

It turns out, however, that this discussion is entirely academic. Considering (correlated) Brownian motion is enough to develop algorithms applicable to the general case (at least in discrete time). In [this 2016 paper](https://arxiv.org/pdf/1409.3040.pdf), Gravin et al. demonstrate that the optimal adversary need only ever assign gains of +1 or -1. In the case of three experts, for instance, the optimal adversary will assign the leading expert (i.e., the expert with the best performance so far) a gain of $$-g$$, and the two lagging experts gains of $$g$$. So the gain vector will be either $$(1,-1,-1)$$ or $$(-1,1,1)$$ (it doesn't matter which). In our setting, such correlation between experts is possible because of the vector $$w^{(i)}$$. 

Regardless of how we define the gain, the player's reward process is the gain across all experts weighted by the player's strategy. In the discrete case this is simply the sum of all rewards over time: $$A(T) = \sum_{t=1}^T  r_t = \sum_{t=1}^T \sum_{i=1}^n p_t(i) g_t(i)$$. In continuous time we integrate: 

$$A(T) = \int_0^T \sum_{i=1}^n p_i(\tau)\d G_i(\tau),$$

or, 

$$\d A(t) = \sum_{i=1}^n p_i(t) \d G_i(t).$$

Finally, the continuous regret will be the maximum gain across all experts minus the player's reward: 

$$ \reg(t) = \max_i G_i(t) - A(t).$$

# 2. Continuous MWU 

An optimal algorithm in the discrete, fixed-time setting is the multiplicative weights update algorithm, originally proposed by Vovk in 1990. It has regret at most $$\sqrt{2 T \log n}$$, which was shown to be (asymptotically) optimal in 1997 by Cesa-Bianchi et al. 

The idea behind MWU is to draw from the pool of experts randomly, where each expert is assigned weighted proportional to its cumulative gain until that point. More precisely, expert $$i$$ is assigned weight proportional to $$\exp(\eta_t G_i(t))$$, where $$\eta_t$$ is some hyperparameter.  The continuous setting will be no different. We want the strategy $$(p_t)$$ to obey 

$$(p_t)_i = \frac{\exp(\eta_t G_i(t))}{\sum_j \exp(\eta_t G_j(t))}.$$

In order to analyze the regret of this approach, we need a way to calculate $$A(t)$$. A natural tool for analyzing Itô integrals like the one above is, of course, Itô's lemma. I [discussed]({% link _research_notes/sde_ito_lemma.md %}) the one-dimensional version of this lemma previously (when the differential was Brownian motion), but we'll need the more general version for our purposes. The general version states for appropriate stochastic processes $$X(t)\in\R^n$$, (technically, $$X(t)$$ must be a continuous semimartingale), and a smooth function $$F:\R\times \R^n\to\R$$, we have 

$$\begin{align}
F(T,X(T)) &= F(0,X(0)) + \sum_{i=1}^n \int_0^T \partial_{x_i} F(t,X(t))\d X_i(t) \\ 
&\quad + \int_0^T \partial_t F(t,X(t))\d t + \frac{1}{2}\sum_{i,j=1}^n\int_0^T \partial_{x_i,x_j} F(t,X(t))\d \la X_i(t),X_j(t)\ra.
\end{align}$$

Like we did in the 1-dimensional case, we can see this informally via a Taylor expansion: 

$$
\begin{align}
F(T+\Delta T, X + \Delta X) &= F(T,X(T)) + \sum_{i=1}^n \partial_{x_i} F \Delta X_i + \partial_t F\Delta T  \\
&\quad + \frac{1}{2}\sum_{i,j=1}^n \partial_{x_i,x_j}F \Delta X_i\Delta X_j + \frac{1}{2}\sum_{i=1}^n \partial_{x_i,t} F\Delta X_i \Delta T  \\
&\quad +\frac{1}{2}\partial_t F \Delta T^2 + \text{err}.
\end{align}
$$

As we take $$\Delta X$$ and $$\Delta T$$ to zero, we have $$\Delta X\to \d X$$ and $$(\d t)^2=0$$, $$\d X_i\d t=0$$. We also need to use that $$\d X_i \d X_j = \d \la X_i,X_j\ra$$, where $$\la X_i,X_j\ra$$ is the quadratic variation. This is a technical point so we'll skip it. It also doesn't matter so much for our purposes since we'll actually use $$\d X_i \d X_j$$ for our calculations. From here, splitting up the interval $$[0,T]$$ into $$\Delta T$$ size chunks and taking the limit gives the result. 

To apply this formula to $$A(t)$$, we need to massage $$\int_0^T p_i(t)\d G_i(t)$$ into looking like a term in Itô's lemma. The most natural candidate is the term $$\int_0^T \partial_{x_i} F(t,X(t))\d X_i(t)$$ as it is also an Itô integral. Thus, we need to find the function $$F$$ such that $$\partial_{x_i} F(t,G(t)) = p_i(t)$$. One could try to integrate $$p_i(t)$$ directly to solve this equation, but that seems gross. So instead we're just going use the fact that other people have solved this equation for us to note that the solution is 

$$F(t,G(t)) = \frac{1}{\eta_t} \log \sum_{i=1}^n \exp(\eta_t G_i(t)).$$

Applying Itô's lemma gives 

$$\begin{align}
A(T) &= \sum_{i=1}^n \int_0^T \partial_{g_i} F(t,G(t))\d G_i(t) \\
&= F(T,G(T)) - F(0,G(0))- \int_0^T \partial_t F(t,G(t))\d t  \\
&\qquad - \frac{1}{2}\sum_{i,j} \int_0^T \partial_{g_i,g_j} F(t,G(t))\d \la G_i(t),G_j(t)\ra,
\end{align}
$$

To carry on the analysis, we first compute the quadratic variation. We have 

$$
\begin{align}
\d \la G_i(t),G_j(t)\ra &= \d G_i(t)\d G_j(t) \\
&= \sum_{k=1}^n w_k^{(i)}(t) \d B_k(t) \cdot \sum_{k=1} w_k^{(j)}(t)\d B_k(t) \\ 
&= \sum_{k,\ell=1}^n w_k^{(i)}(t) w_\ell^{(j)}(t) \d B_k(t) \d B_\ell(t).
\end{align}
$$

At this point it's helpful to use another characterization of quadratic variation. For processes $$S(t), R(t)$$, $$\la S,R\ra$$ is the unique process such that $$SR - \la S,R\ra$$ is a local martingale. Since Brownian motion $$B$$ is a martingale, if $$B_1$$ and $$B_2$$ are independent Brownian motions then $$B_1 B_2$$ is also a martingale, so it follows that we must have $$\la B_1,B_2\ra=0$$. Then, since the quadratic variation of a single Brownian motion is $$t$$, we have 

$$\d B_k(t) \d B_\ell(t) = \d \la B_k(t),B_\ell(t)\ra = \d t \cdot \ind(k=\ell).$$

Therefore, 

$$\d\la G_i(t),G_j(t)\ra = \sum_{k=1}^n w_k^{(i)}(t) w_k^{(j)}(t)\d t = \sum_{k=1}^n W_{i,j}(t) \d t,$$

where we've defined the matrix $$W$$ such that $$W_{i,j} = \la w^{(i)}(t),w^{(j)}(t)\ra$$. Moreover, note that the log-sum-exp function is always greater than the maximum, since for all $$i$$, 

$$G_i(t) = \frac{1}{\eta_t}\log\exp(\eta_t G_i(t)) \leq \frac{1}{\eta_t}\log\bigg(\sum_i \exp(\eta_t G_i(t))\bigg) = F(t,G(t)),$$

by monotonicity of the log. This implies that $$\max_i G_i(t) - F(t,G(t))\leq 0$$ for all $$t$$. Putting this all together gives 

$$\begin{align}
\reg(T) &=  \max_i G_i(T) - A(T) \\
&\leq F(0,G(0)) + \int_0^T \bigg\{\partial_t F(t,G(t)) - \frac{1}{2}\sum_{i} \partial_{g_i,g_i} F(t,G(t))W_{i,j}(t)\bigg\}\d t.
\end{align}
$$

From here, the game is to bound the terms $$\partial_t F(t,G(t))$$ and $$\partial_{g_i,g_i} F(t,G(t))W_{i,j}(t)$$. This is mostly just calculation so we'll skip the details. The result is that if we choose $$\eta_t = \sqrt{\log (n)/2t}$$, then we get regret $$\leq 2\sqrt{t \log(n)}$$. If the time horizon $$T$$ is known beforehand and we set $$\eta_t = \sqrt{\log (n) / 2T}$$, then we get regret $$\sqrt{2t\log (n)}$$.  Note that these are the same rates as in the discrete setting. The paper then goes on to show how you can discretize the algorithm (note that this is not trivial since the strategy above depends on a continuous gain process) at no loss. All in all, this as an exceptionally cool application of stochastic calculus, and I'll be curious to see whether more people start to analyze continuous versions of various statistical problems.  
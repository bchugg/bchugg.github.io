---
layout: note
title: Introduction to Itô Integration
status: Unpublished
date: "2022-01-16"
---

# Introduction to Itô Integration
$$\newcommand{\dif}{\;\text{d}}\newcommand{\ind}{\mathbf{1}}\newcommand{\R}{\mathbb{R}}\newcommand{\F}{\mathcal{F}}\renewcommand{P}{\mathbb{P}}\newcommand{\B}{\mathcal{B}}\newcommand{\E}{\mathbb{E}}$$


Traditional calculus is nice, sure. But sometimes you have some nice stochastic processes that don't obey the requirements needed for the usual differentiation or integration (in particular, they may be nowhere differentiable). This doesn't stop us from wanting to try and do something similar with them. We'll start with integration, because, unlike in calculus with nice smooth and deterministic functions, it's easier. 

Our goal is to make sense of the object 

$$\begin{equation*}
    I_T(X) \equiv \int_0^T X\dif W = \int_0^T X_t(\omega)\dif W_t(\omega),
\end{equation*}$$

where both $$X$$ and $$W$$ are stochastic processes (w.r.t. time, hence the bounds). 
Note that $$X$$ and $$W$$ are both functions of time and some underlying probability space $$(\Omega, \F, \P)$$. They can be viewed as measurable maps on the product space of $$\Omega$$ and the given time interval,

$$X:[0,T]\times \Omega \to\R,$$ 

with the underlying product measure $$\B_T\otimes\F$$ where $$\B_T$$ is the Borel $$\sigma$$-algebra on $$[0,T]$$. Such details will mostly be unimportant and, as usual, we'll mostly forget the dependence on $$\omega$$ and write $$X_t$$ or $$X(t)$$. But recalling the dependence on elements of $$\Omega$$ can be helpful for making sense of certain statements. For instance, for fixed $$\omega$$ the integral 

$$\int_0^T X(t,\omega)\dif t,$$

is a normal (deterministic) Lebesgue integral whose value is a function of $$\omega$$. The expectation over $$\Omega$$ is thus also well-defined: 

$$\E_\omega\bigg[\int_0^T X(t,\omega) \dif t\bigg]=\E\int_0^T X_t \dif t.$$

We'll mostly use the notation on the right for conciseness, but keeping the left hand side in mind will help when shit gets a little hairy. 

Before we diving into the construction of a whole new object, we should probably ask ourselves whether this is necessary at all. Why don't the usual notions of integration work here? $$W$$ is not a measure, so it's hard to see how to apply Lebesgue integration. Riemann-Stieltjes integration is an obvious candidate, but this doesn't work if $$W$$ isn't sufficiently well-behaved. In particular, it should be of bounded variation. Recall that the _total variation_ of a function $$f:[0,T]\to\R$$ is defined as 

$$V(f) = \sup_\Pi \sum_{t_i} |f(t_i) - f(t_{i-1})|,$$ 

where the supremum is taken over all partitions $$\Pi=\{t_0,\dots,t_n\}$$ of $$[0,T]$$. The paths of Brownian motion have infinite variation almost surely. That is, $$\P(\omega:V(f(\omega))<\infty)=0.$$ Stronger still, Brownian motion is a.s. nowhere differentiable (which implies infinite variation), making typical statements from regular calculus such as $$\int X\dif W=\int X \frac{dW}{dt} dt$$ impossible here, since the derivative of $$W$$ doesn't exist. Intuitively, this all stems from the fact that Brownian motion is fractal-like in its movement over time (illustrated below). It's wiggling up and down an infinite amount in every finite time period. 

![brownian-motion](/assets/images/brownian_motion.gif){: style="text-align: center;"}
<p class='caption'>
    Example of a single realization of Brownian motion over time. Stolen from <a href="https://users.math.yale.edu/public_html/People/frame/Fractals/RandFrac/Brownian/BrGrphMovie.html">this beautiful website</a> dedicated to fractals at Yale. Here, the x-axis is time, and the y-axis is the value of the random variable. 
</p>

So it looks like we do in fact need a new notion of integration to handle such stochastic processes. Before we get there, we need to introduce two assumptions on $$X$$. First, we'll assume it's square integrable in expectation, i.e., 

$$\E\int_0^T X_t^2 \dif t <\infty.$$

This assumption is used when constructing the integral in order to apply to the relevant convergence theorems. Second, we assume that $$X$$ is adapted to the process $$W$$. Let $$(\F_t)_{t\in[0,T]}$$ denote the [filtration](https://en.wikipedia.org/wiki/Filtration_(probability_theory)) associated with $$W$$, where formally

$$\F_t=\sigma(W_\tau|\tau\leq t)=\sigma(W_\tau^{-1}(S)|S\in\B_\tau,\tau\leq t).$$

Intuitively, $$\F_t$$ contains all information about $$W$$ up until time $$t$$, but no more. $$X$$ being adapted to $$(\F_t)$$ means that $$X_t$$ can act on knowledge about the value $$W_\tau$$ for $$\tau\leq t$$, but not on future values of $$W$$. In finance applications, this is equivalent to the assumption that there's no insider trading: $$X_t$$ cannot change depending on some future as-of-yet unrealized value of $$W$$. Formally, $$X$$ being adapted to $$(\F_t)$$ means that for every $$t$$, $$X_t=X(t,\cdot):\Omega\to \R$$ is $$\F_i$$ measurable. If this all looks weird, don't panic. The intuition that $$X$$ "can't see into the future" is good enough for most purposes. 

Alright, 'tis time to construct this bad boy. 

## Construction

Like every other integral you've ever seen in your life, the Itô integral is constructed by first defining the integral for simple expressions and then taking some complicated limits for general integrands. And even though we saw that the Riemann-Stieltjes integral won't suffice here, it's not a bad place to start. 

We start out assuming that our integrand is a _simple process_. That is,  assume that $$X$$ changes value only at discrete times $$0=t_0<t_1<\dots<t_n=T<\infty$$. Abusing notation somewhat, write $$X=X_i$$ at time $$t_i$$, etc. We're only assume that $$X$$ is simple; $$W$$ can still be continuous. Following a similar approach to the Riemann-Stieltjes integral, define 

$$\begin{equation}
\label{eq:I_simple}
    I_T(X) = \sum_{i=0}^{n-1} X_i(W_{i+1}-W_i). 
\end{equation}$$

To see that this isn't completely hopeless, we'll note that this equation has a nice interpretation in finance land (which is where many of the applications of stochastic calculus lie, so get used to it).  Suppose $$W$$ is the market price of some good you've bought, or some stock, and that $$X_i$$ is the amount of stock you hold between during $$[t_i,t_{i+1})$$. At time $$t_i$$, you pay $$X_iW_i$$ to buy $$X_i$$ units at price $$W_i$$. At time $$t_{i+1}$$, at the end of the trading day, the price has changed to $$W_{i+1}$$, so you sell your shares and receive a profit of $$X_iW_{i+1}$$. So your total gain (or loss, if $$W_{i+1}<W_i$$) for the period $$[t_i,t_{i+1})$$ is $$X_i(W_{i+1}-W_i)$$. Then, at $$t_{i+1}$$ you buy $$X_{i+1}$$ shares and the process repeats for the interval $$[t_{i+1},t_{i+2})$$. Over the interval $$[t_0,t_n)$$, your total wealth is then $$I(t)$$. Note that this interpretation requires that you sell at the end of each trading period, however. If you only adjust your price from $$X_i$$ to $$X_{i+1}$$ when the price changes from $$W_i$$ to $$W_{i+1}$$, then your total wealth at time $$t_n$$ would simply be the amount of stock you hold at that time times the price, minus whatever you paid at the beginning. That is, $$X_{n-1}W_n - X_0W_0$$. 

Now we'd like to extend the definition of the integral to general integrands. The proofs are finnicky and not very illuminating unless you're really keen on practicing your dominated and bounded convergence theorems. So suffice it to say that the usual tactic works out: Given a a general process $$X$$ we construct a sequence of simple processes $$X_n$$ which convergence pointwise to $$X$$: $$X_n(t,\omega)\to X(t,\omega)$$. Then we show that $$(X_n(t,\omega)-X(t,\omega))^2\to 0$$ and finally that 

$$\lim_{n\to\infty}\E\int_0^T (X_n(t,\omega)-X(t,\omega))^2\dif t\to0.$$

From here, it's natural to define 

$$\int_0^T X \dif W \equiv \lim_{n\to\infty}\int_0^T X_n\dif W,$$

where we're ensured that the limit exists because $$I_T(X_n)$$ is a cauchy sequence. This gives us our Itô integral $$I_T(X)$$. 

## Properties

First, just like when we were integrating against $$\dif t$$, note that $$I_t=I_t(X)$$ is itself a stochastic process: 

$$I_t(X): [0,T]\times \Omega \to \R: (t,\omega)\mapsto \int_0^t X(t,\omega)\dif W(t,\omega).$$ 

Right off the bat this lets us know that we've really entered distinct territory from regular calculus. 

### Martingale

### Quadratic Variation 

### Itô Isometry

## Resources
---
layout: note
title: "Itô Integral: Construction and Basic Properties"
description: "General introduction to stochastic calculus and Itô integration" 
status: published
date: "2022-01-16"
image: /assets/writing_images/brownian_motion.gif
---


$$
\newcommand{\dif}{\;\text{d}}
\newcommand{\ind}{\mathbf{1}}
\newcommand{\R}{\mathbb{R}}
\newcommand{\F}{\mathcal{F}}
\renewcommand{P}{\mathbb{P}}
\newcommand{\B}{\mathcal{B}}
\newcommand{\E}{\mathbb{E}}
\newcommand{\Var}{\mathbb{V}}
$$

- TOC 
{:toc}

# 1. Intro
Traditional calculus is fine, sure. But sometimes you have some juicy stochastic processes that don't obey the requirements for the usual differentiation or integration (in particular, they may be nowhere differentiable). This doesn't stop us from wanting to try doing something similar with them. [Itô calculus](https://en.wikipedia.org/wiki/It%C3%B4_calculus) is one way of extending the methods of deterministic calculus to the stochastic setting. But it isn't the only one: there is also [Stratonovich calculus](https://en.wikipedia.org/wiki/Stratonovich_integral). However, Itô calculus is (arguably) more common, and is also better suited to applications in finance, as we'll see below. I don't have much of an interest in mathematical finance, but hey, applications are always nice and they provide useful intuition checks. Stratonovich calculus is used more by physicists and I already have enough physics envy that I don't need to play into it. 

The big payoff of Itô integration will be when dealing with stochastic differential equations, i.e., differential equations where at least one variable is a stochastic process. This post contains the construction and basic properties of the Itô integral, so we won't actually see the big payoffs yet. But we'll get there eventually. Vegetables before dessert, people. 


Our goal is to make sense of the object 

$$\begin{equation*}
    I_T(X) \equiv \int_0^T X\dif W = \int_0^T X_t(\omega)\dif W_t(\omega),
\end{equation*}$$

for stochastic processes $$X$$ and $$W$$. Both $$X$$ and $$W$$ are functions of time and some underlying probability space $$(\Omega, \F, \P)$$. They can be viewed as measurable maps on the product space of $$\Omega$$ and the given time interval,

$$X:[0,T]\times \Omega \to\R,$$ 

with the underlying product measure $$\B_T\otimes\F$$ where $$\B_T$$ is the Borel $$\sigma$$-algebra on $$[0,T]$$. Such details will mostly be unimportant and, as usual, we'll mostly forget the dependence on $$\omega$$ and write $$X_t$$ or $$X(t)$$. But recalling the dependence on elements of $$\Omega$$ can be helpful for making sense of certain statements. For instance, for fixed $$\omega \in \Omega$$ the integral 

$$\int_0^T X(t,\omega)\dif t,$$

is a normal (deterministic) Lebesgue integral whose value is a function of $$\omega$$. The expectation over $$\Omega$$ is thus also well-defined: 

$$\E_\omega\bigg[\int_0^T X(t,\omega) \dif t\bigg]=\E\int_0^T X_t \dif t.$$

We'll mostly use the notation on the right for conciseness, but keeping the left hand side in mind will help when things get a little hairy. 

Before diving into the construction of a whole new object, we should ask ourselves if this is necessary at all. Why don't the usual notions of integration work here? For one, $$W$$ is not a measure, so it's hard to see how to apply Lebesgue integration. Riemann-Stieltjes integration is an obvious candidate, but this doesn't work if $$W$$ isn't sufficiently well-behaved. In particular, it should be of bounded variation. Recall that the _total variation_ of a function $$f:[0,T]\to\R$$ is defined as 

$$V(f) = \sup_\Pi \sum_{t_i} |f(t_i) - f(t_{i-1})|,$$ 

where the supremum is taken over all partitions $$\Pi=\{t_0,\dots,t_n\}$$ of $$[0,T]$$. The paths of Brownian motion have infinite variation a.s. (almost surely). That is, $$\P(\omega:V(f(\omega))<\infty)=0.$$ Stronger still, Brownian motion is a.s. nowhere differentiable (which implies infinite variation), making typical statements from regular calculus such as $$\int X\dif W=\int X \frac{dW}{dt} dt$$ impossible here, since the derivative of $$W$$ doesn't exist. Intuitively, this all stems from the fact that Brownian motion is fractal-like in its movement over time (illustrated below). It's wiggling up and down an infinite amount in every finite time period. 

![brownian-motion](/assets/writing_images/brownian_motion.gif){: style="text-align: center;"}
<p class='caption'>
    Example of a single realization of Brownian motion over time. Stolen from <a href="https://users.math.yale.edu/public_html/People/frame/Fractals/RandFrac/Brownian/BrGrphMovie.html">this beautiful website</a> dedicated to fractals at Yale. Here, the x-axis is time, and the y-axis is the value of the random variable. 
</p>

So it looks like we do in fact need a new notion of integration to handle such stochastic processes. Before we get there, we need to introduce two assumptions on $$X$$. First, we'll assume it's square integrable in expectation, i.e., 

$$\E\int_0^T X_t^2 \dif t <\infty.$$

This assumption is used when constructing the integral in order to apply to the relevant convergence theorems. Second, we assume that $$X$$ is adapted to the process $$W$$. Let $$(\F_t)_{t\in[0,T]}$$ denote the [filtration](https://en.wikipedia.org/wiki/Filtration_(probability_theory)) associated with $$W$$, where formally

$$\F_t=\sigma(W_\tau|\tau\leq t)=\sigma(W_\tau^{-1}(S)|S\in\B_\tau,\tau\leq t).$$

Intuitively, $$\F_t$$ contains all information about $$W$$ up until time $$t$$, but no more. $$X$$ being adapted to $$(\F_t)$$ means that $$X_t$$ can act on knowledge about the value $$W_\tau$$ for $$\tau\leq t$$, but not on future values of $$W$$. In finance applications, this is equivalent to the assumption that there's no insider trading: $$X_t$$ cannot change depending on some future price. Formally, $$X$$ being adapted to $$(\F_t)$$ means that for every $$t$$, $$X_t=X(t,\cdot):\Omega\to \R$$ is $$\F_i$$ measurable (i.e., it can be completely defined from $$\F_i$$). If this all looks weird, don't panic. The intuition that $$X$$ "can't see into the future" is good enough for most purposes. 

Alright, 'tis time to construct this bad boy. 

# 2. Construction

Like every other integral you've ever seen in your life, the Itô integral is constructed by first defining the integral for simple expressions and then taking some complicated limits for general integrands. And even though we saw that the Riemann-Stieltjes integral won't suffice here, it's not a bad place to start. 

We start out assuming that our integrand is a _simple process_. That is,  assume that $$X$$ changes value only at discrete times $$0=t_0<t_1<\dots<t_n=T<\infty$$. Abusing notation somewhat, write $$X=X_i$$ at time $$t_i$$, etc. We assume only that $$X$$ is simple -- $$W$$ can still be continuous. Following a similar approach to the Riemann-Stieltjes integral, define 

$$\begin{equation}
\label{eq:I_simple}
    I_T(X) = \sum_{i=0}^{n-1} X_i(W_{i+1}-W_i). \tag{1}
\end{equation}$$

To see that this isn't completely hopeless, we'll note that this equation has a nice interpretation in finance land (which is where many of the applications we'll discuss lie, so get used to it).  Suppose $$W$$ is the market price of some good you've bought, or some stock, and that $$X_i$$ is the amount of stock you hold between $$[t_i,t_{i+1})$$. At time $$t_i$$, you pay $$X_iW_i$$ to buy $$X_i$$ units at price $$W_i$$. At time $$t_{i+1}$$, at the end of the trading day, the price has changed to $$W_{i+1}$$, so you sell your shares and receive a profit of $$X_iW_{i+1}$$. So your total gain (or loss, if $$W_{i+1}<W_i$$) for the period $$[t_i,t_{i+1})$$ is $$X_i(W_{i+1}-W_i)$$. Then, at $$t_{i+1}$$ you buy $$X_{i+1}$$ shares and the process repeats for the interval $$[t_{i+1},t_{i+2})$$. Over the interval $$[t_0,t_n)$$, your total wealth is then $$I_T$$. Note that this interpretation requires that you sell at the end of each trading period. If you only adjust your price from $$X_i$$ to $$X_{i+1}$$ when the price changes from $$W_i$$ to $$W_{i+1}$$, then your total wealth at time $$t_n$$ would simply be the amount of stock you hold at that time times the price, minus whatever you paid at the beginning. That is, $$X_{n-1}W_n - X_0W_0$$. 

It's worth highlighting the importance of choosing the left endpoint of $$X_i$$ in Equation $$\eqref{eq:I_simple}$$ over the interval $$W_{i+1}-W_i$$, instead of say the middle point $$(X_{i+1}-X_i)/2$$ (as is done in Stratonovich calculus), or the right endpoint. The choice of left endpoint is suitable for finance: we choose how much stock to buy when we see the price at the beginning of the day. Choosing anything after $$X_i$$ would imply seeing into the future. Also, unlike in traditional calculus, this choice matters (due to, as we'll see, the quadratic variation of $$W$$)! Different choices yield different results for even fairly basic integrands. 

Now we'd like to extend the definition of the integral to general integrands. The proofs are finnicky and not very illuminating unless you're really keen on practicing your dominated and bounded convergence theorems. So suffice it to say that the usual tactic works out: Given a a general process $$X$$ we construct a sequence of simple processes $$X_n$$ which converge pointwise to $$X$$: $$X_n(t,\omega)\to X(t,\omega)$$. Then we show that $$(X_n(t,\omega)-X(t,\omega))^2\to 0$$ and finally that 

$$\lim_{n\to\infty}\E\int_0^T (X_n(t,\omega)-X(t,\omega))^2\dif t\to0.$$

This is convergence in $$L^2$$, which implies convergence in probability. (If you've forgotten your convergence definitions and theorems see [here](http://www2.stat.duke.edu/~sayan/CBB2012/convergence.pdf) for a nice, concise reminder). It's now natural to define 

$$\int_0^T X \dif W \equiv \lim_{n\to\infty}\int_0^T X_n\dif W,$$

(the converence is [convergence in probability](https://en.wikipedia.org/wiki/Convergence_of_random_variables)) where, if you were worried, we're ensured that the limit exists because $$I_T(X_n)$$ is a cauchy sequence. This gives us our Itô integral $$I_T(X)$$. 

# 3. Properties

First, just like when we were integrating against $$\dif t$$, note that $$I_t=I_t(X)$$ is itself a stochastic process: 

$$
\begin{equation}
\label{eq:ItX}
I_t(X): [0,T]\times \Omega \to \R: (t,\omega)\mapsto \int_0^t X(t,\omega)\dif W(t,\omega). \tag{2}
\end{equation}
$$ 

Right off the bat this lets us know that we've really entered distinct territory from regular calculus. To go much further however, we need to start talking a bit about $$W$$. 

Typically, $$W$$ is taken to be a [Wiener Process](https://en.wikipedia.org/wiki/Wiener_process), i.e., Brownian motion. Recall that (or just believe me if you've never seen Brownian motion before) that a one-dimensional Brownian motion $$B$$ is a stochastic process satisfying 

- $$B_0=0$$ (we can relax this to any real number but for the Itô integral it's always taken as 0). 
- $$B_{t+\tau} - B_t$$, $$\tau\geq 0$$ are independent of past values of $$W_s$$, $$s\leq t$$ (independent increments)
- $$B_{t+\tau}-B_t\sim\mathcal{N}(0,\tau)$$, $$\tau\geq 0$$ (increments are normally distributed)
- $$B_t$$ is continuous as a function of $$t$$. 

To get a sense of what this looks like just scroll up and look at the example above again. It looks like that damn stock market trend that you want a try and predict but can't. Super spikey, super random. If you need more than that right now then, sorry, you're going to have to Google it, because we have things to do. [Here](https://studiousguy.com/brownian-motion-examples/) are eight examples of brownian motion in real life (albeit most are two dimensional) - don't have too much fun.

The first thing to note is that $$\E[B_t]=\E[B_t-B_0]=0$$, using that $$B_0=0$$ and that increments are normally distributed. Also, $$\E[(B_{t+\tau}-B_t)^2] = \Var((B_{t+\tau}-B_t)^2) = \tau$$ since $$\E[B_{t+\tau}-B_t]^2=0$$. We call this final property _linear variation_ of Brownian motion. 


## 3.1 $$I_T$$ is a Martingale

If $$W$$ is a Wiener process, then it is also a martingale. A continuous time martingale $$Y_t$$ with respect to the filtration $$\F_t$$ obeys $$\E[\vert Y_t\vert]<\infty$$, and, for all $$t$$ and $$s\leq t$$, 

$$\E[Y_t \;\vert \; \F_s] = Y_s.$$

That is, given all information up until time $$s$$, the expected value of $$Y$$ for all future values is $$Y_s$$. If $$\F_s$$ is the filtration produced by $$Y$$ itself we'll often just say that $$Y$$ is a martingale. The classic example of a martingale is a fair game: if $$Y_t$$ is a gambler's wealth at time $$t$$, where the gambler wins $1 if a _fair_ coin lands heads and loses $1 if the coin lands tails, then the sequence $$Y_t$$ is a martingale. Given wealth $$Y_s$$ at time $$s$$, the expected value of future wealth is also $$Y_s$$ _because the game is fair_. An unbiased random walk is another example of a martingale. 

Because Brownian motion has independent increments we have 

$$\E[W_t \vert \F_s] = \E[W_t - W_s + W_s\vert \F_s] = \E[W_t - W_s \vert \F_s] + W_s = W_s.$$

Also, Jensen's inequality with $$\varphi:x\mapsto x^2$$ gives 

$$\E(\vert W_t\vert)^2 \leq \E(\vert W_t\vert^2) = \E[(W_t - W_0)^2] =t<\infty,$$

so $$\E(\vert W_t\vert)$$ is finite and we see that $$W$$ is a martingale. 

It turns out that $$I_t$$ is also a martingale. This might not come as a suprise though. If we're trading against an asset $$W$$ which is a "fair game", i.e., it's as likely to go up as go down, then our wealth over time should not be expected to go up or down either (and there's no using future information to our advantage because $$X$$ is adapted to $$W$$'s filtration).  

To see this, suppose again that $$X$$ is a simple process with $$X=X_i$$ for times $$[t_{i},t_{i+1})$$. Fix $$t$$ and let $$s\leq t$$. Let $$0=t_0<t_1<\dots<t_n=t$$ be a partition of $$[0,t]$$. Write 

$$
\begin{equation}
\label{eq:It_mart}
I_t = \sum_{i=0}^{t_{k-1}} X_i(W_{i+1}-W_i) + X_k(W_{k+1}-W_k) + \sum_{i=k+1}^{n-1} X_i(W_{i+1}-W_i).  \tag{3}
\end{equation}$$

We need to show that $$\E[I_t\vert\F_s]=I_s$$. All times in the first sum are prior to $$s$$, so are deterministic after conditioning on $$\F_s$$ (which, we recall, is all the information up to time $$s$$). For the second term, only $$t_{k+1}>s$$, so 

$$\E[X_k(W_{k+1}-W_k)\vert \F_s] = X_k(\E[W_{k+1}\vert \F_s] - W_k) = X_k(W_{t_s}-W_k),$$

because $$W$$ is a martingale. Thus, the result of the expected value of the first two terms of $$\eqref{eq:It_mart}$$ conditioned on $$\F_s$$ is precisely $$I_s$$. For the final sum, consider some $$i\geq k+1$$ and use towered expectations to write 

$$
\begin{align*}
\E[X_i(W_{i+1}-W_i)\vert\F_s] &= \E[\E(X_i(W_{i+1}-W_i)\vert \F_{t_i})\vert \F_s] \\
&= \E[X_i(\E[W_{i+1}\vert \F_{t_i}] - W_i)\vert \F_s] \\
&= \E[X_i(W_i - W_i)\vert \F_s] =0.
\end{align*}
$$

Note that this is only valid since $$\F_s\subset \F_{t_i}$$. This implies that the final sum of $$\eqref{eq:It_mart}$$ is zero, and we have our result. As you'd expect/hope this carries over into the limit and holds for general integrands of non-simple processes as well. 

## 3.2 The Itô Isometry

Let's get a little hot and heavy with functional analysis for a second. Given metric spaces $$M_1$$ and $$M_2$$ with metrics $$d_1$$ and $$d_2$$, a map 

$$f:M_1\to M_2,$$ 

is an _isometry_ if $$d_1(a,b) = d_2(f(a), f(b))$$ for all $$a,b\in M_1$$. In other words, the function $$f$$ is distance preserving. Now, the Itô integral before specifying an integrand $$X$$ can be viewed as a map from the space of all stochastic processes on $$[0,T]\times \Omega$$ which are (i) square-integrable  (ii) adapted (remember the conditions we outlined above). We denote this space $$L^2_A([0,T]\times \Omega)$$. 
Given a process in the space $$X$$, $$I_T(X)$$ is then a square integrable stochastic process in $$\Omega$$ ($$I_T(X)$$ is a function of $$\omega$$ only). In sum, the Itô integral is a function (or functional, if you prefer)

$$I_T:L^2_A([0,T]\times\Omega)\to L^2(\Omega):X\mapsto I_T(X)$$

(Note the distinction between this equation and Equation $$\eqref{eq:ItX}$$, where $$X$$ was given and we're hence already working in $$L^2(\Omega)$$.) For two processes $$X,Y\in L^2_A([0,T]\times\Omega)$$ consider the metric 

$$ d_{L^2_A([0,T]\times\Omega)}(X,Y) = \E\int_0^T X_tY_t\dif t.$$

And for $$X,Y\in L^2(\Omega)$$ consider the metric 

$$d_{L^2(\Omega)}(X,Y)=\E[XY].$$

Equipped with these metrics, the map $$I_T$$ is an isometry. That is, 

$$d_1(X,Y) = d_2(I_T(X)I_T(Y))=\E[I_T(X)I_T(Y)],$$ 

or 

$$\E\int_0^T X_tY_t\dif t = \E\left(\int_0^T X_t\dif W_t\int_0^T Y_t\dif W_t\right).$$

To prove this, we once again return to simple processes. Given simple $$X$$ and $$Y$$ which change at times $$\Pi_X=\{t_0^X,t_1^X, \dots,t_n^X\}$$ and $$\Pi_Y=\{t_0^Y,t_1^Y,\dots, t_n^Y\}$$, consider the partition which is the common refinement of these times, i.e., includes all breakpoints, $$\Pi_X\cup\Pi_Y=\{t_0,t_1,\dots,t_n\}$$. Let $$\Delta W_i=W_{i+1}-W_i$$. Then, 

$$\E\bigg(\int_0^TX_t\dif W_t\int_0^T Y_t\dif W_t\bigg) = \sum_{i,j=0}^{n-1} \E[X_iY_j\Delta W_i\Delta W_j].$$

Fix $$i<j$$. Then $$\Delta W_j$$ is independent of all of $$X_i$$, $$Y_j$$, $$\Delta W_i$$. It's indepedent of the first two since $$X_i$$ and $$Y_j$$ are adapted processes hence determined by $$\F_j$$, and of $$\Delta W_i$$ because $$W$$ of the independent increments property of Brownian motion. Moreover, $$\E[\Delta W_j]=0$$ (again by the assumptions of Brownian motion). For $$i=j$$ on the other hand, we have $$\E[X_iY_i\Delta W_i^2] = \E[X_iY_i]\E[\Delta W_i^2]=\E[X_iY_i](t_{j+1}-t_j)$$ where the second equality uses that $$\Delta W_i$$ is independent of $$X_i,Y_i$$ because the latter are fully determined by $$\F_i$$, and the third uses the linear variaton of brownian motion. This gives

$$\E\bigg(\int_0^TX_t\dif W_t\int_0^T Y_t\dif W_t\bigg) = \sum_i \E[X_iY_i](t_{i+1}-t_i) = \E\int_0^T X_tY_t \dif t,$$

as desired. As a corollary, we can take $$X=Y$$ and obtain 

$$\E\bigg[\bigg(\int_0^T X_t\dif W_t\bigg)^2\bigg] = \E\int_0^T X_t^2\dif t = \int_0^T \E[X_t^2]\dif t.$$ 

Notice that we can be a little fast and loose with the order of the expectation the integral from $$0$$ to $$T$$ because of our assumptions of square-integrability and [Fubini's theorem](https://en.wikipedia.org/wiki/Fubini%27s_theorem) (in the case of simple processes it's clear we can switch the order, but Fubini is required for continuous processes.)


## 3.3 Quadratic Variation 

The [quadratic variation](https://en.wikipedia.org/wiki/Quadratic_variation) of a stochastic process $$X$$ is 

$$[X,X](t) = \sup_{\|\Pi\|\to0}\sum_{i=1}^n (X(t_i) - X(t_{i-1}))^2,$$

where $$\Pi$$ is a partition of $$[0,t]$$ and $$\|\Pi\|=\max_j\vert t_{j+1}-t_j\vert $$. Clearly, this is similar to the total variation but the term $$X(t_{i}) - X(t_{i-1})$$ is squared. Somewhat suprisingly, functions can have infinite total variation but finite quadratic variation -- and this is indeed the case with Brownian motion which, over the interval $$[a,b]$$, has quadratic variation $$b-a$$. 

Let's compute the quadratic variation $$[I,I](T)$$. Once again we suppose that $$X$$ is simple and changes values at times $$t_0,t_1,\dots,t_n$$. Consider any partition $$\Pi=s_0<s_1<\dots<s_m$$ of $$[0,T]$$. Wlog we can assume that $$\Pi$$ is a refinement of $$t_0,t_1,\dots,t_n$$ since the mesh goes to zero in the limit anyways. Fix an interval on which $$X$$ is constant, $$[t_j,t_{j+1})$$. Suppose that $$\Pi$$ partitions this interval as $$t_j=s_\ell<\dots<s_{\ell+k}=t_{j+1}$$. We can of course write $$I_t(X)$$ as a function of $$\Pi$$. Consider the quadratic variaton on the interval $$[t_j,t_{j+1})$$:

$$
\begin{align*}
\sum_{i=\ell+1}^{\ell+k} (I(s_i)-I(s_{i-1}))^2 &= \sum_{i=\ell+1}^{\ell+k} \bigg(\sum_{z=0}^{i}X_z(W_{z+1}-W_z) - \sum_{z=0}^{i-1}X_z(W_{z+1}-W_z)\bigg)^2 \\
&= \sum_{i=\ell+1}^{\ell+k}(X_i(W_{i+1}-W_i))^2 \\
&= X(t_k)^2\sum_{i=\ell+1}^{\ell+k}(W_{i+1}-W_i)^2.
\end{align*}    
$$

In the limit, the sum $$\sum_{i=\ell+1}^{\ell+k}(W_{i+1}-W_i)^2$$ is precisely quadratic variation of $$W$$ on $$[t_j,t_{j+1}]$$, which is $$t_{j+1}-t_j$$. Therefore, on $$[t_j,t_{j+1}]$$ the quadratic variation of $$I$$ is 

$$[I,I]([t_j,t_{j+1}]) = X(t_k)^2(t_{j+1}-t_j)=\int_{t_j}^{t_{j+1}} X_t^2 \dif t.$$

Summing across all intervals $$[t_0,t_1)$$, $$[t_1,t_2)$$, etc., gives 

$$[I,I](T) = \int_0^T X_t^2 \dif t.$$

This might be a little confusing. After all, the quadratic variation of $$W$$ on $$[0,t]$$ is $$t$$, a number. But $$[I,I](t)$$ is a random variable? There's nothing in the definition of quadratic variation requiring that it converge to a number -- this just happens to be a particularly interesting property of Brownian motion. 

# 4. Examples

We can't get to the end of this thing and not actually calculate the value of any integrals. 

Starting with the most basic integral of all: If $$X=c$$ is constant, then it's a simple process on the single interval $$[0,T)$$ so 

$$\int_0^T  c\dif W_t = c(W_{T}-W_0).$$ 

This is a good sanity check -- any other value would be quite suspicious. 
The next example is a classic, and one that highlights a significant difference between Itô calculus and traditional calculus. We will consider $$W$$ as the integrand and evaluate

$$\int_0^T W\dif W.$$

Unfortunately, we actually need to do some work to compute this. For each $$n$$, define a simple approximation to $$W$$ as $$Z_n(t) = W(\frac{jT}{2^n})$$ for $$t\in[\frac{jT}{2^n},(j+1)\frac{T}{2^n})$$. As you'd expect, $$Z_n$$ converges to $$W$$: 

$$
\begin{align*}
\E\int_0^T(Z_n-W)^2\dif t &= \sum_{j=0}^{2^n-1} \int_{jT/2^n}^{(j+1)T/2^n} \E[(Z_n(t)-W(t))^2]\dif t \\ 
&= \sum_{j=0}^{2^n-1} \int_{jT/2^n}^{(j+1)T/2^n} \E[(W(jT/2^n)-W(t))^2]\dif t\\
&= \sum_{j=0}^{2^n} \int_{jT/2^n}^{(j+1)T/2^n} t-\frac{jT}{2^n}\dif t\\
&= \sum_{j=0}^{2^n} \frac{2^{-2n}}{2} = O(2^{-n}) \to 0.
\end{align*}
$$

Put $$W_j = W(jT/n)$$ and note that 

$$\sum_{j=0}^{n-1}W_j(W_{j+1}-W_j) = \frac{1}{2}W_T^2 - \frac{1}{2}\sum_{j=0}^{n-1}(W_{j+1}-W_j)^2.$$

If we take the limit as $$n\to\infty$$ of sum on the right hand side, this is precisely the quadratic variation of $$W$$, which equals $$T$$. Hence, 

$$
\begin{align}
I_T(W) &= \lim_{n\to\infty}\int_0^T Z_n(t) \dif W_t= \lim_{n\to\infty}\sum_{j=0}^{n-1}W_j(W_{j+1}-W_j)= \frac{W(T)^2}{2} - \frac{T}{2}.
\end{align}
$$

This is in marked contrast to ordinary calculus, in which $$\int_0^T x\dif x=T^2/2$$, i.e., we do not have the second term of $$T/2$$. The culprit is the quadratic variation of the $$W$$. The quadratic variation for the usual smooth functions we're used to integrating ordinarily have quadratic variation 0 (finite total variation implies quadratic variation of zero).

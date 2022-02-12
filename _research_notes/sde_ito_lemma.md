---
layout: note 
date: "2022-02-07" 
title: "Itô Processes and The Fundamental Theorem of Stochastic Calculus" 
status: published
---

$$
\newcommand{\dif}{\;\text{d}}
\newcommand{\dd}{\text{d}}
\newcommand{\E}{\mathbb{E}}
\newcommand{\Var}{\mathbb{V}}
$$

- TOC 
{:toc}


Throughout, let $$W$$ be a Wiener process starting at the origin, and let $$X$$ be a stochastic process adapted to $$W$$'s filtration. $$I_t=I_t(X)$$ is the [Itô integral](/research_notes/intro_ito/) of $$X$$ w.r.t. to $$W$$. 

## Itô Processes
There are at least two motivations for the Itô process. The first comes from the identity 

$$\bigg(\int_0^t \dif W\bigg)^2 = W_t^2 = 2\int_0^t W\dif W + t,$$ 

which we proved [previously](/research_notes/intro_ito/). Notice that $$t$$ cannot be the result of any Itô integral, since $$\E[t]=t\neq 0$$, whereas the Itô integral is a martingale and hence is zero in expectation. Thus, the family of Itô integrals _is not closed under smooth transformations_. In this case the transformation is $$x\mapsto x^2$$. 

The second is simply that, viewed as a stochastic process, the integral $$I_t$$ is less interesting -- or, at least, contains fewer degrees of freedom -- than we might have hoped. We might want processes to capture trends with tendencies to _drift_. 

We can remedy both of these issues at once by introducing the class of stochastic processes $$X_t$$ which evolve as follows: 

$$\begin{equation}
\label{eq:ito_process_int}
X_T-X_0 = \int_0^T \mu(X_t,t)\dif t + \int_0^T \sigma(X_t,t)\dif W_t. \tag{1}
\end{equation}$$



The rightmost integral is an Itô integral, where $$\sigma(X_t,t)$$ is some stochastic process adapted to the brownian motion $$W$$. The leftmost integral is just a Lebesgue integral with respect to time, which will give a real number for each $$\omega$$ in the sample space $$\Omega$$ on which $$X_t$$ is defined. 

We're going to re-write this equation in the differential form

$$\begin{equation}
\label{eq:sde}
\dif X_t = \mu(X_t,t)\dif t + \sigma(X_t,t)\dif W_t. \tag{2}
\end{equation}
$$

This, in all it's glory, is what's referred to as a stochastic differential equation (SDE). It's important to note that Equation $$\eqref{eq:sde}$$ isn't actually a precise mathematical statement. It's simply shorthand for Equation $$\eqref{eq:ito_process_int}$$. But it's definitely easier to write, and also has a nicer intuitive interpretation. Namely, a small change $$\Delta$$ in $$X_t$$ is normally distributed with expectation $$\mu(X_t,t)\Delta$$ and variance $$\sigma(X_t,t)^2\Delta$$ (hence the choice of notation). People often find it easier to work with the SDE form instead of the integral form, especially because you can basically operate differentials as you would expect (even though it's informal) and everything works out. 

While it may not seem so at first glance, almost all stochastic processes -- except those with jumps -- are Itô processes. 

### Example 1: Brownian motion with drift

Suppose  $$\mu$$ and $$\sigma$$ are constants. Then, if $$X_0=0$$ (which we will henceforth assume), Equation $$\eqref{eq:ito_process_int}$$ reads $$X_t = \mu t + \sigma W_t$$, and as an SDE we have 

$$\dif X_t = \alpha \dif t + \beta \dif W_t.$$ 

If $$X$$ satisfies this equation, it's called Brownian motion with drift $$\alpha$$ and variance $$\beta^2$$. It's fairly clear why: $$\E[X_t] = \alpha t$$ (since $$\E[W_t]=0$$) and 

$$\Var[X_t] = \E[X_t^2] - \alpha^2 t^2 = \beta^2 \E[W_t^2] = \beta^2t,$$ 

due to the quadratic variation of the Wiener process. 

### Example 2: Geometric Brownian motion (GBM)

Suppose $$\mu(X_t,t)=\alpha X_t$$ and $$\sigma(X_t,t) = \beta X_t$$ for constants $$\alpha$$ and $$\beta$$. Then, 

$$X_t = X_0 + \alpha\int_0^t X_t\dif t  + \beta\int_0^t X_t\dif W_t,$$

or, 

$$\dif X_t= \alpha X_t\dif t + \beta X_t\dif W_t.$$

GBM is so important it has its own [wikipedia page](https://en.wikipedia.org/wiki/Geometric_Brownian_motion) (what else could possibly signal value?). It's often used to model prices in mathematical finance. Itô's lemma will give us a way to solve it. 



### Integrals with respect to an Itô Process

So far we've seen stochastic integrals with respect to Brownian motion. But now that we've introduced a new class of processes, we should discuss integrals with respect to those. 

Let $$X_t$$ be an Itô process: $$\dif X = \mu(X,t)\dif t + \sigma(X,t)\dif W$$. Let $$Y_t$$ be a process adapted to $$X_t$$. Then we define the integral of $$Y$$ w.r.t $$X$$ as 

$$\int_0^t Y \dif X = \int_0^t Y \mu \dif s + \int_0^t Y \sigma \dif W,$$

which is what you might expect. As usual, the integral on the left is a Lebesgue integral w.r.t to the time component, and the integral on the right is an Itô integral. 

## Aside: Manipulating Infinitesimals

Even though Equation $$\eqref{eq:sde}$$ is informal, it's intuitive enough that you'll often see manipulations done to such equations directly, instead of reverting to the integral version. This isn't completely out of the ordinary, something similar happens when we do change of variables in intro calculus. E.g., if we have $$\int f(u) f'(u) \dif u$$, we might let $$v=f(u)$$ and $$dv = f'(u)du$$ to deal instead with the integral $$\int v \dif v$$. The equation $$dv=f'(u)du$$ isn't meaningful in a precise, technical sense, but it's still useful to get the final result. 

In SDE land, there are a few very common - and very useful - infinitesimal equations to keep in mind: 

$$(\dd t)^2 = 0,\quad \dd W\dd t = 0,\quad (\dd W)^2 = \dd t.$$

Intuitively, something like $$(\dd W)^2 = \dd t$$ should hold because of the quadratic variation of Brownian motion. Rigorously, what this statement means is that for well-behaved (namely, bounded and continuous) functions $$\varphi$$ acting on $$W$$, that 

$$\sum_{i=0}^{n-1} \varphi(W_i)(W_{i+1}-W_i)^2 \to \int_0^T \varphi(W)\dif t,$$

where the convergence is $$L^2$$. That is, one shows that 

$$\E\bigg\{\bigg(\sum_{i=0}^{n-1}\varphi(W_i)(\Delta W_i^2 - \Delta t_i)\bigg)^2\bigg\}\xrightarrow{n\to\infty}0.$$

Similarly for the other identities. This isn't incredibly hard but it's not incredibly insightful either, so we're not giving the proof. [Here](https://pi.math.cornell.edu/~web6720/Wendy_slides.pdf) are some details if you want them. 



## Itô's Lemma 

Our first concern with the family of Itô integrals was that they are not closed under the transformation $$x\mapsto x^2$$, which motivated the construction of Itô processes. Itô's lemma gives us a way to evaluate the transformation of Itô processes under sufficiently smooth transformations. To develop more intuition for the behavior of Brownian motion in the limit, it's worth giving a sketch of the proof before the result is stated. 

### Proof Sketch 

Let $$X_t$$ be an Itô process. For sufficiently smooth functions $$f(X,t)$$ of two variables, Taylor's Theorem gives 

$$\begin{align}
f(X+\Delta X,t+\Delta t) &= f(X,t) + \frac{\partial f}{\partial X}\Delta X+ 
\frac{\partial f}{\partial t}\Delta t + \frac{1}{2}\frac{\partial^2f}{\partial X^2}(\Delta X)^2\tag{3}\label{eq:taylor1} \\
&\quad + \frac{1}{2}\frac{\partial^2f}{\partial t^2}(\Delta t)^2 + 
\frac{\partial^2f}{\partial X\partial t}\Delta X\Delta t + \text{err}, \tag{4}\label{eq:taylor2}
\end{align}
$$

where $$f$$ is evaluated at $$(X,t)$$, and the error term is 

$$\text{err} = o((\Delta W)^3 + (\Delta t)^3 + (\Delta t)^2\Delta X + (\Delta X)^2 \Delta t).$$

Now, as $$\Delta t\to 0$$ and $$\Delta X \to 0$$, we have (using our favorite infinitesimal calculus) $$(\Delta t)^2 \to (\dd t)^2 = 0$$, and 

$$
\begin{align*}
(\Delta  X)^2 \to (\dd X)^2 &= (\mu\dif t+ \sigma \dif W)^2 \\
&= \mu^2 \dd t^2 + 2 \mu \sigma \dif t\dif W + \sigma^2 \dd W^2 \\
&= \sigma^2 \dif t.
\end{align*}
$$

Similarly, 

$$\Delta X\Delta t \to \dd X\dif t = \mu \dd t^2 + \sigma\dif W\dif t=0.$$

Therefore, the three terms in line $$\eqref{eq:taylor2}$$ disappear in the limit, and only the terms in the top line remain. 

Partition the interval $$[0,T]$$ into $$n+1$$ segments as $$t_0,t_1,\dots,t_{n}$$. Let $$X_i=X_{t_i}$$, $$\Delta X_i= X_{i+1} - X_i$$ and $$\Delta t_i = t_{i+1}-t_i$$. Now, write $$f(X_t,t) - f(X_0,0)$$ as a telescoping sum of small increments, apply Taylor's theorem to each term, and take the limit as the partition gets finer and finer (thus ignoring the terms which disappear): 

$$
\begin{align}
f(X_T,T)-f(X_0,0) &= \lim_{n\to\infty}\sum_{i=0}^{n-1} (f(X_{i+1},t_{i+1}) - f(X_i,t_i)) \\
&= \lim_{n\to\infty}\sum_{i=0}^{n-1} \bigg\{\frac{\partial f}{\partial X}\Delta X_i + \frac{\partial f}{\partial t}\Delta t_i + \frac{1}{2}\frac{\partial ^2 f}{\partial X^2}(\Delta X_i)^2\bigg\} \\
&= \lim_{n\to\infty}\sum_{i=0}^{n-1} \frac{\partial f}{\partial X}\Delta X_i + 
\lim_{n\to\infty}\sum_{i=0}^{n-1} \frac{\partial f}{\partial t}\Delta t_i + \lim_{n\to\infty}\frac{1}{2}\sum_{i=0}^{n-1} \frac{\partial^2 f}{\partial X^2}\sigma^2 \Delta t_i. 
\end{align}
$$

In the final sum, we replaced $$\Delta X^2$$ with $$\sigma ^2 \Delta t$$ due to the arguments above. The first sum of the final line is precisely the integral of the Itô process $$X_t$$ with integrand $$f_x$$. Thus, 

$$
\begin{align}
\lim_{n\to\infty}\sum_{i=0}^{n-1} \frac{\partial f}{\partial X}\Delta X_i & = \int_0^T \frac{\partial f}{\partial X}\dif X 
= \int_0^T \mu \frac{\partial f}{\partial X} \dif t + \int_0^T \sigma \frac{\partial f}{\partial X} \dif W.
\end{align}
$$

Meanwhile, the second and third sum are regular Riemann integrals with integrands $$f_t$$ and $$f_x\sigma^2$$ respectively. Putting this all together, we get 

$$f(X_T,T) = f(X_0,0) + \int_0^T \mu \frac{\partial f}{\partial X} \dd t + \int_0^T \sigma \frac{\partial f}{\partial X} \dd W + \int_0^T \frac{\partial f}{\partial t}\dd t + \frac{1}{2}\int_0^T \sigma^2 \frac{\partial^2 f}{\partial X^2}\dd t,$$

which is called Itô's lemma. Again, the partial derivatives and the functions $$\mu$$ and $$\sigma$$ are evaluated at $$(X_t,t)$$, we've just omitted this for brevity. Notice that for this statement to make sense we need that $$f\in C^2(\mathbb{R})$$ ($$f$$ is twice differentiable). More specifically, we need $$f(x,\cdot)\in C^1(\mathbb{R})$$ as a function of $$t$$ and $$f(\cdot,t)\in C^2(\mathbb{R})$$ as a function of $$x$$. 

For standard Brownian motion $$W$$, which is an Itô process with $$\mu\equiv 0$$ and $$\sigma\equiv 1$$, Itô's lemma gives 

$$f(W_T,T)=f(W_0,0) + \int_0^T \frac{\partial f}{\partial W} \dif W + \int_0^T \frac{\partial f}{\partial t}\dif t + \frac{1}{2}\int_0^T \frac{\partial^2 f}{\partial W^2}\dif t.$$

### SDE Form 

Itô's lemma is more commonly stated as an SDE. In this case, we write 

$$
\begin{align}
\dd f(X,t) &= \mu(X,t)f_x(X,t)\dif t + \sigma(X,t) f_x(X,t) \dif W_t + f_t(X,t)\dif t \\
&\quad + \frac{1}{2}\sigma^2(X,t)f_{xx}(X,t)\dif t.
\end{align}
$$

Observe that we can gather the differential $$\dd t$$ and rewrite this as 

$$\dd f = \bigg(\mu f_x + f_t + \frac{1}{2}\sigma^2 f_{xx}\bigg)\dif t + \sigma f_x \dif W,$$

which implies that $$f(X_t,t)$$ is itself an Itô process. This is good, as it was one of the primary motivators of defining the Itô process in the first place. 

In the case of Brownian motion this simplies to 

$$\dd f(W,t) = f_x(W,t)\dif W + f_t(X,t) \dif t + \frac{1}{2} f_{xx}(W,t)\dif t.$$

### The Fundamental Theorem of Stochastic Calculus

Itô's lemma is often considered the fundamental theorem of stochastic calculus. To see why, suppose that $$f$$ is a function of standard brownian motion $$W_t$$ only, $$f(W_t)$$. Since $$W_t$$ is still a function of $$t$$, we apply the chain rule and write

$$\frac{df}{dt} = \frac{df}{dW}\dd W_t,$$

which isn't _precisely_ rigorous, but it's also not wrong. Since $$\dd W_t \dd t = 0$$, the integral in Itô's lemma with integrand $$\frac{\partial f}{\partial t}$$ disappears, and we're left with 

$$f(W_T)-f(W_0) = \int_0^T \frac{d f}{d W}(W_t)\dif W_t + \frac{1}{2}\int_0^T \frac{d^2 f}{d W^2}(W_t)\dif t.$$

Contrast this with the fundamental theorem of (ordinary) calculus, where we don't have the final term on the right hand side. Indeed, this term only exists in the stochastic case because of the quadratic variation of Brownian motion ($$(\dd W)^2 = \dd t$$). The smooth functions dealt with ordinarily have quadratic variation 0. 

Equivalently, we can compare the (single variable) differential form 

$$\dd f(W_t) = f_x(W_t)\dif W + \frac{1}{2} f_{xx}(W_t)\dif t,$$

with the chain rule from ordinary calculus: 

$$\frac{df}{dt}(x(t)) = f'(x)x'(t),$$

or, in differential form, 

$$\dif f(x(t)) = f'(x)\dd x.$$ 

Again, we see the difference is the non-zero quadratic variation of $$W$$. 

## Examples 

Often we're less interested in evaluating $$f(X_t,t)$$, but rather in evaluating some stochastic integral $$\int Y_t\dif X_t$$. If we can choose a function $$f$$ such that one of its partial derivatives equals $$Y_t$$, then we're in business. 

### Back to Basics: $$\int_0^t W\dif W$$

We can solve the integral $$\int W\dif W$$ much more easily with Itô's lemma. Consider $$f(W,t)=W^2$$. The lemma gives 

$$W_t^2 = 2\int_0^t W\dif W + t,$$ 

which was obtained with much less hassle than before.  

### Stochastic Integration by Parts 

Suppose $$g:\mathbb{R}\to\mathbb{R}$$ is a deterministic function of time. We'd like to say something about $$\int g(t) \dif W_t$$. To do this, we want a smooth function $$f$$ which, using Itô's lemma, yields this integral. Since the lemma involves the derivatives of $$f$$, choosing $$f(x,t) = xg(t)$$ works nicely. Then $$f_x(x,t) = g(t)$$, $$f_{xx}(x,t)=0$$ and $$f_t(x,t) = g(t)x'(t) + g'(t)x(t)$$. Our favorite lemma gives: 

$$
\begin{align}
 W_Tg(T) &= \int_0^T g(t)\dif W_t + \int_0^T (W_tf'(t) + f(t)\dif W_t)\dif t \\ 
 &= \int_0^T g(t)\dif W_t + \int_0^T W_tf'(t)\dif t,
\end{align}
$$ 

since $$\dd W_t\dd t=0$$. Rearranging and using the intuition that $$f'(t)\dif t = \dd f$$ (which can be shown rigorously), we get 

$$\int_0^T g(t) \dif W_t = W_Tg(T) - \int_0^T W_t\dd f(t).$$

This looks a lot like the usual integration by parts formula. The rightmost integral should be interpreted as a Riemann-Stieltjes integral. 

### Geometric Brownian Motion

Recall that GBM satisfies 

$$\dd S_t = \mu S_t\dif t + \sigma S_t \dif W_t,$$

for constants $$\mu$$ and $$\sigma$$. To solve this, we borrow some intuition from ODE theory and guess that logarithms will be involved. In particular, apply Itô's lemma with $$f(x,t) = f(x) = \log x$$. As we saw above, since $$S_t$$ is also a function of $$t$$, the chain rule applies and $$f_t(S_t) = (S_t)^{-1} \dif S_t$$. Thus, Itô's lemma gives 

$$
\begin{align}
\dif \log(S_t) &= \bigg(\frac{\dd S_t}{S_t} + \mu S_t \frac{df}{dS} + \sigma^2\frac{S_t^2}{2}\frac{d^2f}{dS^2}\bigg)\dif t + \sigma S_t \frac{df}{dS} \dif W_t \\
&= \frac{d S_t}{S_t}\dif t + \mu\dif t - \frac{\sigma^2}{2}\dif t + \sigma \dif W_t\\
&= \bigg(\mu - \frac{1}{2}\sigma^2\bigg)\dif t + \sigma\dif W_t.
\end{align}
$$

Retreating from SDE notation, this means 

$$
\begin{align}
\log(S_T) - \log(S_0) &= \int_0^T \bigg(\mu - \frac{1}{2}\sigma^2\bigg) \dif t + \int_0^T \sigma \dif W_t  = \bigg(\mu-\frac{1}{2}\sigma^2\bigg) T + \sigma W_T.
\end{align}
$$

Exponentiating and performing the relevant arithmetic yields 

$$ S_T = S_0\exp\bigg(\mu T - \frac{T\sigma^2}{2}\bigg)\exp(\sigma W_T),$$

which gives us a closed form solution for GBM. 













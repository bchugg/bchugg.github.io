---
layout: note
date: "2026-08-17"
title: "European Options and the Heat Equation"
description: "Reducing the Black-Scholes PDE to the heat equation"
status: published
---

# 1. The Heat equation

Last time we derived the Black-Scholes PDE for the European option. Unfortunately, PDEs are tough to solve! Luckily, we can fool around with the Black-Scholes equation and turn it into the heat equation after a few clever change of variable arguments.

The heat equation for a function $$u(x,t)$$ is the famous PDE

$$
\begin{equation}
\label{eq:heat}
\frac{\partial u}{\partial t} = \frac{\partial^2 u}{\partial x^2}. \tag{1}
\end{equation}
$$

It has the well-known solution

$$
\begin{equation}
\label{eq:heat-soln}
u(x, \widetilde \tau) = \frac{1}{\sqrt{4\pi \widetilde\tau}}\int_{-\infty}^\infty \exp\left\{-\frac{(x -y)^2}{4\widetilde\tau}\right\} u_0(y)dy,\tag{2}
\end{equation}
$$

where $$u_0(y) = u(y,0)$$ is the initial condition at time 0. The heat equation was originally developed by Fourier in the 1800s to describe how heat diffuses in a given region. The quantity $$u(x,t)$$ is the temperature at location $$x$$ at time $$t$$, and the equation says that how quickly the temperature is changing at point $$x$$ has to do with the convexity or concavity of the material at that point. (This is an interesting phenomenon in and of itself, and not at all obvious.) In fact, there's nothing special about heat. The same dynamics apply to any diffusion process.

Is it a surprise that the Black-Scholes equation is related to the heat equation? Perhaps initially, but less and less as you think about it. The Black-Scholes PDE captures the price of a stock fluctuating as (geometric) Brownian motion, with a known value at some time $$T$$. Now, $$T$$ happens to be the end of the time period instead of the beginning, but this doesn't matter much analytically. It just means that time is reversed.


# 2. Transforming Black-Scholes into the Heat Equation

Recall the [Black-Scholes equation](/research_notes/black_scholes/) which we derived last time,

$$
\begin{equation}
\label{eq:black-scholes}
\frac{\partial V}{\partial t} + \frac{1}{2}\sigma^2 S^2 \frac{\partial^2 V}{\partial S^2} + rS \frac{\partial V}{\partial S} - rV = 0, \tag{3}
\end{equation}
$$

with boundary condition $$V(S,T) = \max\{0, S-K\}$$ for some $$K\geq 0$$ (the strike price. Look at us, talking like financiers). As we noted above, this thing moves backwards in time. We know the value of $$V_t$$ at $$t=T$$ and we're trying to understand how it behaves for $$t<T$$. We can fix this by simply considering $$\tau = T-t$$, the time until the payout. Since $$\partial V/\partial t= -\partial V/\partial \tau$$, \eqref{eq:black-scholes} becomes

$$
\begin{equation}
\label{eq:black-scholes-2}
\frac{\partial V}{\partial \tau} =  \frac{1}{2}\sigma^2 S^2 \frac{\partial^2 V}{\partial S^2} + rS \frac{\partial V}{\partial S} - rV. \tag{4}
\end{equation}
$$

Next we would like to turn the coefficients into constants, because the heat equation doesn't have any stochastic multiplicative factors in front of the derivatives. The underlying reason that we have non-constant factors in \eqref{eq:black-scholes-2}, is that the European options model considers _geometric_ (i.e., multiplicative) Brownian motion, which provides a hint that we should instead work in log space.

Set $$x = \log S$$. We want to write $$\eqref{eq:black-scholes-2}$$ in terms of $$x$$ instead of $$S$$. The chain rule gives

$$
\begin{equation}
\label{eq:dvds}
\frac{\partial V}{\partial S} = \frac{\partial V}{\partial x}\frac{\partial x}{\partial S} = \frac{\partial V}{\partial x}\frac{1}{S}, \tag{5}
\end{equation}
$$

and

$$
\begin{align}
\frac{\partial^2 V}{\partial S^2} &= \frac{\partial}{\partial S}\left(\frac{\partial V}{\partial x}\frac{1}{S}\right)
= \frac{\partial^2 V}{\partial S\partial x} \frac{1}{S} - \frac{1}{S^2}\frac{\partial V}{\partial x} \\
&= \frac{\partial^2 V}{\partial x^2}\frac{\partial x}{\partial S} \frac{1}{S} - \frac{1}{S^2}\frac{\partial V}{\partial x}
= \frac{1}{S^2}\left(\frac{\partial^2 V}{\partial x^2} - \frac{\partial V}{\partial x}\right). \label{eq:dvds2} \tag{6}
\end{align}
$$

Plugging $$\eqref{eq:dvds}$$ and $$\eqref{eq:dvds2}$$ back into $$\eqref{eq:black-scholes-2}$$ we obtain

$$
\begin{align}
\frac{\partial V}{\partial \tau} &= \frac{1}{2}\sigma^2 S^2 \cdot \frac{1}{S^2}\left(\frac{\partial^2 V}{\partial x^2} - \frac{\partial V}{\partial x}\right) + rS \cdot \frac{1}{S}\frac{\partial V}{\partial x} - rV \\
&= \frac{1}{2}\sigma^2 \frac{\partial^2 V}{\partial x^2} + \left(r - \frac{1}{2}\sigma^2\right)\frac{\partial V}{\partial x} - rV. \label{eq:constant-coeff} \tag{7}
\end{align}
$$

Ok, so now the coefficients on the derivatives are constant. But we still have too many terms floating around. The heat equation has no first-order term and no zeroth-order term, whereas $$\eqref{eq:constant-coeff}$$ has both. To get rid of them, we're going to define a new function $$u$$ such that, for some $$\alpha,\beta$$ to be determined,

$$
\begin{equation}
\label{eq:u-def}
u(x,\tau) = e^{-\alpha x - \beta \tau} V(x,\tau). \tag{8}
\end{equation}
$$

We can argue about whether this is an intuitive thing to do or not. The rough idea is that an exponential factor is precisely the sort of thing that spits out first-order and zeroth-order terms when you differentiate it, so we ought to be able to tune $$\alpha$$ and $$\beta$$ to cancel things we don't want. But admittedly this is hard to see by just staring at \eqref{eq:u-def}. Regardless, we have

$$
\begin{align}
\frac{\partial V}{\partial \tau} &= e^{\alpha x + \beta \tau}\left(\frac{\partial u}{\partial \tau} + \beta u\right), \\
\frac{\partial V}{\partial x} &= e^{\alpha x + \beta \tau}\left(\frac{\partial u}{\partial x} + \alpha u\right), \\
\frac{\partial^2 V}{\partial x^2} &= e^{\alpha x + \beta \tau}\left(\frac{\partial^2 u}{\partial x^2} + 2\alpha\frac{\partial u}{\partial x} + \alpha^2 u\right). \label{eq:u-derivs} \tag{9}
\end{align}
$$

Substituting $$\eqref{eq:u-derivs}$$ into $$\eqref{eq:constant-coeff}$$ and dividing by $$e^{\alpha x + \beta\tau}$$ (always nonzero), we obtain

$$
\begin{align}
\frac{\partial u}{\partial \tau} &= \frac{1}{2}\sigma^2 \frac{\partial^2 u}{\partial x^2} + \left(\sigma^2\alpha + r - \frac{1}{2}\sigma^2\right)\frac{\partial u}{\partial x} \\
&\quad + \left(\frac{1}{2}\sigma^2\alpha^2 + \left(r - \frac{1}{2}\sigma^2\right)\alpha - r - \beta\right)u. \label{eq:u-pde} \tag{10}
\end{align}
$$

Now we just choose $$\alpha$$ and $$\beta$$ to kill the last two coefficients. Setting the coefficient on $$\partial u/\partial x$$ to zero gives

$$
\begin{equation}
\label{eq:alpha}
\alpha = \frac{1}{2} - \frac{r}{\sigma^2}. \tag{11}
\end{equation}
$$

and then setting the coefficient on $$u$$ to zero and simplifying gives

$$
\begin{equation}
\label{eq:beta}
\beta = \frac{1}{2}\sigma^2\alpha^2 + \left(r - \frac{1}{2}\sigma^2\right)\alpha - r = -\frac{\sigma^2}{8}\left(1 + \frac{2r}{\sigma^2}\right)^2. \tag{12}
\end{equation}
$$

With these choices, $$\eqref{eq:u-pde}$$ becomes

$$
\begin{equation}
\label{eq:almost-heat}
\frac{\partial u}{\partial \tau} = \frac{1}{2}\sigma^2\frac{\partial^2 u}{\partial x^2}, \tag{13}
\end{equation}
$$

and we can write it precisely as the heat equation by rescaling time as $$\widetilde\tau = \sigma^2\tau/2$$. Since $$\partial/\partial\tau = (\sigma^2/2)\partial/\partial\widetilde\tau$$, the factor of $$\sigma^2/2$$ cancels off both sides and we're left with \eqref{eq:heat} precisely.



To write the boundary condition in terms of $$u_0$$, note that $$\widetilde\tau = 0$$ corresponds to $$\tau=0$$, i.e., to $$t=T$$, at which point $$V = \max\{0,S-K\} = \max\{0,e^x-K\}$$. So by $$\eqref{eq:u-def}$$,

$$
\begin{equation}
\label{eq:u0}
u_0(y) = e^{-\alpha y}\max\{0, e^y - K\} = \max\left\{0, e^{(1-\alpha)y} - Ke^{-\alpha y}\right\}. \tag{14}
\end{equation}
$$

The max is only positive for $$y > \log(K)$$. Plugging this into the heat kernel solution $$\eqref{eq:heat-soln}$$ and inverting $$\eqref{eq:u-def}$$ to recover $$V$$ gives

$$
\begin{align}
\label{eq:V-integral}
V(S,t) &= \frac{e^{\alpha x + \beta \tau}}{\sqrt{4\pi\widetilde\tau}}\int_{\log K}^\infty \exp\left\{-\frac{(x-y)^2}{4\widetilde\tau}\right\}
\left(e^{(1-\alpha)y} - Ke^{-\alpha y}\right)dy.
\tag{15}
\end{align}
$$

There are two ways to proceed from here. You can play around with this integral, complete some squares (actually just one), and write it in terms of the standard normal CDF. The result is the famous Black-Scholes formula

$$
\begin{equation}
\label{eq:bs-formula}
V(S,t) = S\Phi(d_1) - Ke^{-r(T-t)}\Phi(d_2), \tag{16}
\end{equation}
$$

where $$\Phi$$ is the standard normal CDF and

$$
\begin{equation}
\label{eq:d1d2}
d_1 = \frac{\log(S/K) + \left(r + \frac{1}{2}\sigma^2\right)(T-t)}{\sigma\sqrt{T-t}}, \qquad d_2 = d_1 - \sigma\sqrt{T-t}. \tag{17}
\end{equation}
$$

But there's a second option that I much prefer, both because the solution looks a lot cleaner, and because it connects much more obviously with optimal stopping.

# 3. The solution as an expectation

Go back to $$\eqref{eq:V-integral}$$, but keep $$u_0$$ in the unexpanded form $$e^{-\alpha y}\max\{0,e^y-K\}$$ from $$\eqref{eq:u0}$$, and substitute $$z = y - x$$. Since $$e^x = S$$, the two factors of $$e^{\alpha x}$$ cancel against each other, leaving

$$
\begin{align}
V(S,t) &= \frac{e^{\beta\tau}}{\sqrt{4\pi\widetilde\tau}}\int_{-\infty}^\infty \exp\left\{-\frac{z^2}{4\widetilde\tau} - \alpha z\right\}\max\{0, Se^z - K\}\,dz \\
&= \frac{e^{\beta\tau + \widetilde\tau\alpha^2}}{\sqrt{4\pi\widetilde\tau}}\int_{-\infty}^\infty \exp\left\{-\frac{(z + 2\widetilde\tau\alpha)^2}{4\widetilde\tau}\right\}\max\{0, Se^z - K\}\,dz, \label{eq:tilted} \tag{18}
\end{align}
$$

where the second line just completes the square in the exponent. The integrand is the pdf of a Gaussian (in $$z$$) with mean $$\mu = -2\widetilde\tau\alpha$$ and variance $$\upsilon^2 = 2\widetilde\tau$$. Recalling that $$\widetilde\tau = \sigma^2\tau/2$$ and $$\alpha = \frac{1}{2} - r/\sigma^2$$, we can rewrite those as

$$
\begin{equation}
\label{eq:moments}
\upsilon^2 = 2\widetilde\tau = \sigma^2\tau, \qquad \mu = -\sigma^2\tau\alpha = \left(r - \frac{1}{2}\sigma^2\right)\tau. \tag{19}
\end{equation}
$$

Now, keeping in mind the definition of $$\alpha$$ in \eqref{eq:alpha}, note that $$\beta\tau + \widetilde\tau \alpha^2 = -r\tau$$, so $$\exp(\beta\tau + \widetilde\tau\alpha^2) = \exp(-r\tau ) = \exp(-r(T-t))$$. Therefore, \eqref{eq:tilted} simplifies to

$$
\begin{align}
V(S,t) &= e^{-r(T-t)}\,\mathbb{E}_{Z\sim N(\mu,\upsilon^2)}\left[\max\{0, Se^Z - K\}\mid S_t=S\right]\\
&= e^{-r(T-t)}\,\mathbb{E}_{Z\sim N(0,1)}\left[\max\{0, Se^{\upsilon Z + \mu} - K\}\mid S_t=S\right], \tag{20}
\end{align}
$$



Let $$\mathbb{Q}$$ denote the _risk-neutral measure_: the probability measure under which the stock's drift is the risk-free rate $$r$$. The whole expression therefore becomes

$$
\begin{equation}
\label{eq:expectation}
V(S,t) = e^{-r(T-t)}\,\mathbb{E}_{\mathbb{Q}}\left[\max\{0, S_T - K\}\mid S_t=S\right], \tag{21}
\end{equation}
$$

where, conditional on $$S_t=S$$,

$$
\begin{equation}
\label{eq:ST}
S_T = S\exp\left\{\left(r - \frac{1}{2}\sigma^2\right)(T-t) + \sigma\sqrt{T-t}\,Z\right\}, \qquad Z \sim N(0,1). \tag{22}
\end{equation}
$$

todo


Compare $$\eqref{eq:ST}$$ with the stock price process we actually started from. Solving the geometric Brownian motion $$dS_t = \mu S_t dt + \sigma S_t dB_t$$ gives $$S_T = S\exp\{(\mu - \frac{1}{2}\sigma^2)(T-t) + \sigma\sqrt{T-t}Z\}$$ — the same expression with $$\mu$$ in place of $$r$$. So $$\eqref{eq:expectation}$$ is _not_ the expected payoff of the stock we were handed. It's the expected payoff of a fictitious stock whose drift has been replaced by the risk-free rate. This fictitious measure is called the _risk-neutral measure_, usually written $$\mathbb{Q}$$.

The expectation form is also the better jumping-off point for what comes next. An American option can be exercised at any time up to $$T$$, so instead of a fixed payoff date we get to choose a stopping time $$\vartheta$$, and the price becomes

$$
\begin{equation}
\label{eq:american}
V(S,t) = \sup_{t \leq \vartheta \leq T} \mathbb{E}^{\mathbb{Q}}\left[e^{-r(\vartheta - t)}\max\{0, S_\vartheta - K\}\right], \tag{23}
\end{equation}
$$

the supremum ranging over stopping times.

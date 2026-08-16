---
layout: note
date: "2026-08-12"
title: "European Options and Black-Scholes"
description: "An introduction to mathematical finance"
status: published
---

Sequential hypothesis testing, which is something I think about a lot, can be thought of as a particular kind of optimal stopping problem:  you want to develop procedures for rejecting the null (stopping the test) which satisfy certain error rates. It turns out that there are unignorable parallels between optimal stopping and mathematical finance. In fact, various problems in finance are precisely optimal stopping problems. American option pricing, for instance, asks the question: When is the optimal time to stop and exercise the option (i.e., buy or sell)?

Much of financial theory is in continuous time as opposed to discrete time. But still, the connections are there and I want to understand them better.  So the next few posts will be a dive into mathematical finance.

First up is European option pricing (i.e., the classical Black-Scholes equation). This is decidedly _not_ an optimal stopping problem since there are no decisions involved. We're just trying to develop an expression for the value of the option. The Black-Scholes equation can be transformed into the heat equation with a terminal condition determined by the option's payoff. When you introduce the possibility of exercising early, you still get the heat equation but the boundary conditions get more complicated. So Black-Scholes is a good warmup.

Our setting is as follows. We consider a stock $$S$$ whose price evolves as a [geometric Brownian motion](https://en.wikipedia.org/wiki/Geometric_Brownian_motion):

$$
\begin{equation}
\label{eq:stock-price}
dS_t = \mu S_t dt + \sigma S_t dB_t, \tag{1}
\end{equation}
$$

where $$B_t$$ is a standard Brownian motion. (I introduced the basic tools of stochastic calculus in [this post](/research_notes/intro_ito/), including standard Brownian motion.)

We are holding a (European) _call option_ for $$S$$ which, as every finance blog will tell you, "gives the holder the right, but not the obligation, to buy one share of $$S$$ at a predetermined time $$T$$ in the future for price $$K$$." The price $$K$$ is called the _strike price_. (A _put_ option would give us the right to sell instead of buy.) At time $$T$$, the value of this option is therefore:

$$V_T := \max\{0, S_T - K\}.$$

The question we want to answer is: What's the option worth at times $$t<T$$? That is, we want to develop an expression $$V_t \equiv V(S_t,t)$$ for $$t<T$$. The answer is going to take the form of a PDE that the function $$V(S,t)$$ must satisfy, called the Black-Scholes PDE. The derivation here is a bit different than the usual one that you'll see on, say, wikipedia. There is a step in that derivation that I simply cannot figure out how to justify mathematically. I'll explain a bit more about this later. But this way is cleaner, in my opinion.

One thing I want to do here is to be very explicit about the modelling assumptions, because I found these quite confusing when I was trying to work this out. So here's the list:
- The stock evolves as a geometric Brownian motion as in $$\eqref{eq:stock-price}$$, where $$\mu$$ and $$\sigma>0$$ are constant. This is already a big assumption. If you showed this to Nassim Taleb he would either scream at you or try and deadlift you. Maybe both.
- The stock pays no dividends. That is, there is no payoff before time $$T$$.
- There is a constant risk-free rate of return $$r$$. This means that there is an asset $$W$$ which grows as $$W_t = W_0 e^{rt}$$, that is, $$dW_t = rW_t dt$$. Note that this is deterministic growth. This assumption will be explicitly invoked several times. We'll discuss it more in Section 2 below.
- There are no arbitrage opportunities in the market. That is, one cannot start from zero wealth and make trades that can never lose and have positive probability of gaining wealth.
- Trading is frictionless and continuous. That is, there are no transaction costs and you can buy and sell arbitrary amounts of stock at any time.
- Trading strategies are _self-financing_. This is a bit weird and a bit complicated, so we'll start by sorting it out.


# 1. Self-financing portfolios

A _portfolio_ is just some combination of assets that you hold. A portfolio is _self-financing_ if all changes in its holdings are paid for using money already inside the portfolio. In other words, we are allowed to rebalance between assets, but we are not allowed to inject or withdraw any additional wealth. We operationalize this by assuming that if we hold $$\Delta$$ shares of $$S$$, our total wealth is actually $$\Delta S$$ plus some additional shares of $$W$$, the risk-free asset in the third assumption. At time $$t$$ our portfolio has total value

$$
\begin{equation}
\label{eq:Xt}
X_t = \Delta_t S_t + \beta_t W_t, \tag{2}
\end{equation}
$$

and the self-financing condition says that

$$
\begin{equation}
\label{eq:rebalancing-int}
X_t = X_0 + \int_0^t \Delta_s  d S_s + \int_0^t \beta_s  dW_s, \tag{3}
\end{equation}
$$

or more succinctly,

$$
\begin{equation}
\label{eq:rebalancing-diff}
dX_t = \Delta_t dS_t + \beta_t dW_t. \tag{4}
\end{equation}
$$

Equation $$\eqref{eq:rebalancing-int}$$ makes it clear that all changes to the total wealth $$X_t$$ come from changes in $$S_t$$ and $$W_t$$. It's worth noting that $$\eqref{eq:rebalancing-diff}$$ does not follow by simply differentiating $$\eqref{eq:Xt}$$. Since $$\Delta$$ and $$\beta$$ also vary with $$t$$, Ito's product rule introduces the additional rebalancing terms $$Sd\Delta + Wd\beta + d[\Delta,S]$$, where $$[\Delta,S]$$ is the quadratic covariation. (There is no corresponding covariation term involving $$W$$ because $$W$$ has finite variation.) The self-financing condition is precisely the requirement that these additional terms sum to zero.


## 1.1. Self-financing in discrete time

It's easiest to see where $$\eqref{eq:rebalancing-int}$$ comes from by considering discrete time. Suppose that just before time $$t_i$$ we hold $$\Delta_{i-1}$$ shares of stock and $$\beta_{i-1}$$ units of the risk-free asset $$W$$, and at time $$t_i$$ we rebalance to $$\Delta_i$$ and $$\beta_i$$. Since no money enters or leaves the portfolio, its value immediately before and after rebalancing must be the same:

$$
\Delta_{i-1} S_{t_i} + \beta_{i-1} W_{t_i} = \Delta_i S_{t_i} + \beta_i W_{t_i}.
$$

Equivalently,

$$
S_{t_i}(\Delta_i-\Delta_{i-1}) + W_{t_i}(\beta_i-\beta_{i-1})=0.
$$

For example, if we buy \$100 more stock, we must finance that purchase by selling \$100 of $$W$$.

Between $$t_i$$ and $$t_{i+1}$$, suppose we leave the holdings fixed. Then the only way the portfolio can gain or lose value is through changes in the prices of the assets themselves:

$$
X_{t_{i+1}}-X_{t_i}=\Delta_i(S_{t_{i+1}}-S_{t_i})+\beta_i(W_{t_{i+1}}-W_{t_i}).
$$

Equation $$\eqref{eq:rebalancing-int}$$ then follows by taking limits (see the definition of the stochastic integral [here](/research_notes/intro_ito/)).


# 2. No-arbitrage and the law of one price

A self-financing portfolio $$A$$ is _risk-free_ if it evolves deterministically (like $$W$$ in the third assumption). That is $$dA_t = a_t dt$$ for some deterministic process $$a$$. It turns out that we can say exactly what $$a$$ is because, intuitively, $$A$$ has to grow exactly as $$W$$ grows. Otherwise, since both are growing deterministically, there would be an arbitrage opportunity where we buy the one growing more quickly and short the one growing more slowly.

Formally, $$A$$ solves the same ODE as $$W$$, so $$dA_t = rA_t dt$$. To prove this, suppose that $$a_t \neq rA_t$$ at some time $$t$$. If $$a_t > rA_t$$, then at time $$t$$:
- First borrow $$A_t$$ dollars from the bank, so your balance is $$-A_t$$.
- Then use that to buy the portfolio consisting of $$A_t$$ (worth exactly $$A_t$$ at this time).

Now, consider how each investment changes over $$[t,t+dt]$$. The amount you've borrowed is now worth $$A_t + rA_t dt$$. And your portfolio is now worth $$A_t + dA_t = A_t + a_t dt$$. Overall, you've gained $$a_t dt - rA_t dt > 0$$, so this trade was an arbitrage. We're assuming no arbitrage opportunities, so this is impossible. An equivalent argument where we reverse the buying and selling (buy $$A_t$$ from the bank, sell the portfolio consisting of $$A_t$$), shows that we can't have $$rA_t > a_t$$. So we conclude that for a risk-free portfolio $$A$$, we must have $$dA_t = rA_t dt$$.

This argument actually proves something more general. Suppose $$A$$ and $$C$$ are two admissible, self-financing portfolios which have the same payoff at some future time $$T$$, i.e., $$A_T = C_T$$ almost surely. Then they must have the same value at all earlier times too. For if $$A_t > C_t$$ for some $$t<T$$, we can sell $$A$$, buy $$C$$, and deposit the difference $$A_t - C_t > 0$$ in the bank. At time $$T$$ our two positions in $$A$$ and $$C$$ cancel exactly and we walk away with extra money. But that's an arbitrage!

This is called the _law of one price_. Formally:

$$
\begin{equation}
\label{eq:law-of-one-price}
A_T = C_T \text{ almost surely} \quad \text{implies} \quad A_t = C_t \text{ for all } t \leq T. \tag{5}
\end{equation}
$$


# 3. Deriving Black-Scholes

Ok, back to business.  We don't know what $$V$$ looks like, but we know that it's a function of the time $$t$$ and the current stock price $$S$$. Taking derivatives according to Ito's formula gives

$$
\begin{equation}
\label{eq:dV-1}
dV = \frac{\partial V}{\partial t} dt + \frac{\partial V}{\partial S} dS + \frac{1}{2} \frac{\partial^2 V}{\partial S^2} (dS)^2. \tag{6}
\end{equation}
$$

Now, from $$\eqref{eq:stock-price}$$,

$$
\begin{align}
(dS)^2 &= (\mu S dt + \sigma S dB_t)^2 = \mu^2 S^2 (dt)^2 + 2\mu \sigma S^2 dt dB_t + \sigma^2 S^2 (dB_t)^2.
\end{align}
$$

Recalling the calculus of infinitesimals, we have $$(dt)^2 = 0$$, $$dB dt = 0$$ and $$(dB)^2 = dt$$. I go over these [here](/research_notes/sde_ito_lemma/#2-aside-manipulating-infinitesimals), but the intuition is that we're measuring things on a timescale of $$dt$$. Compared to that $$(dt)^2$$ is small and vanishes, and since Brownian motion is expected to move by roughly $$\sqrt{t}$$ in $$t$$ time, $$dBdt$$ roughly behaves as $$(dt)^{3/2}$$. Of course, you can make all of this nice and formal if you want to. Overall, we get

$$
(dS)^2 = \sigma^2 S^2 dt.
$$

Substituting this into $$\eqref{eq:dV-1}$$, we obtain

$$
\begin{equation}
\label{eq:dV-2}
dV = \left(\frac{\partial V}{\partial t} + \mu S \frac{\partial V}{\partial S} + \frac{1}{2} \sigma^2 S^2 \frac{\partial^2 V}{\partial S^2}\right)dt + \sigma S \frac{\partial V}{\partial S} dB. \tag{7}
\end{equation}
$$

Now, consider a self-financing portfolio $$X = \Delta S + \beta W$$. We'd like to find processes $$\Delta$$ and $$\beta$$ such that $$X_T = V_T = \max\{0,S_T-K\}$$. If such a portfolio exists, the law of one price says the option must be worth $$X_t$$ at every earlier time, and hence $$dV_t=dX_t$$. So let's look for such a $$\Delta$$ and $$\beta$$. Self-financing gives that they must satisfy

$$
dV = dX = \Delta dS + \beta dW.
$$

By definition of $$W$$ we have $$dW = rW dt$$. Using the definition of $$dS$$, we obtain

$$
\begin{equation}
\label{eq:dV-3}
dV = dX = \Delta ( \mu S dt + \sigma S dB) + r\beta W dt. \tag{8}
\end{equation}
$$

Now we have two distinct expressions for $$dV$$. Comparing $$\eqref{eq:dV-2}$$ and $$\eqref{eq:dV-3}$$ and matching the coefficients on $$dB$$ gives $$\Delta \sigma S = \sigma S \partial V / \partial S$$, so

$$
\Delta = \frac{\partial V}{\partial S}.
$$

Plugging this back into the definition of $$ V = X = \Delta S + \beta W$$ gives

$$
\beta W = V - \frac{\partial V}{\partial S} S,
$$

and plugging _this_ back into $$\eqref{eq:dV-3}$$ gives

$$
\begin{align}
dV &= \left(\mu S \frac{\partial V}{\partial S} + rV - rS \frac{\partial V}{\partial S}\right)dt + \sigma S \frac{\partial V}{\partial S} dB.
\end{align}
$$

Matching the $$dt$$ terms with those in $$\eqref{eq:dV-2}$$ and rearranging gives

$$
\frac{\partial V}{\partial t} + \frac{1}{2}\sigma^2 S^2 \frac{\partial^2 V}{\partial S^2} + rS \frac{\partial V}{\partial S} - rV = 0.
$$

This is precisely the Black-Scholes equation, though without the boundary. On its own, the PDE doesn't pin down the price of the option. Plenty of processes satisfy it, such as $$V = S$$ and $$V = e^{rt}$$. What makes the solution unique is the condition $$V(S,T) = \max\{0, S-K\}$$.

There's still one loose end. We assumed that a self-financing portfolio replicating the terminal payoff existed in the first place. Suppose $$u$$ is a solution to the PDE with terminal condition $$u(S,T)=\max\{0,S-K\}$$, and set $$\Delta = \partial u/\partial S$$ and $$\beta = (u - S\,\partial u/\partial S)/W$$. Then $$X = \Delta S + \beta W = u$$ by construction, and running the calculation above backwards shows that $$dX = \Delta dS + \beta dW$$ precisely because $$u$$ satisfies the PDE. Moreover, $$X_T=u(S_T,T)=V_T$$. Thus any such solution produces a self-financing replicating portfolio, and the law of one price gives $$V_t=X_t=u(S_t,t)$$ for every $$t\leq T$$. Existence of the option price is therefore reduced to existence of a solution to the Black-Scholes problem.


Some interesting things about this equation. For one, $$\mu$$ does not make an appearance! This is interesting. $$\mu$$ is the drift of the process, governing whether it's going up or down on average. The fact that it's missing from Black-Scholes means that, to agree on a price, two people need only agree on $$r$$ and the volatility $$\sigma$$, not the drift. Second, the PDE is valid for any process $$V$$ which is a function of $$S$$ and $$t$$ and has some terminal value $$V(S_T,T) = g(S)$$. It's just the boundary condition that has to be updated.

The "usual" derivation of Black-Scholes often introduces a portfolio $$\Pi = V - \Delta S$$ and immediately invokes self-financing to write $$d\Pi = dV - \Delta dS$$. But I don't understand why this is valid. In particular, I don't understand how you can get away with the self-financing assumption if you don't include $$W$$ in the portfolio. Where is the rebalancing coming from?

Next time we'll explore the relationship between the Black-Scholes PDE and the heat equation, which will bring us one step closer to understanding American options.

---
layout: note 
date: "2022-05-31" 
title: "Liquidity Provider Wealth in Constant Product AMMs"
description: "Calculating the average geometric return for a liquidity provider in a constant product AMM"
status: published
---

$$
\newcommand{\N}{\mathbb{N}}
\newcommand{\ratio}{\Lambda}
\newcommand{\DX}{\Delta X}
\newcommand{\DY}{\Delta Y}
\newcommand{E}{\mathbb{E}}
$$

# 1. Setting

Our goal is to compute the geometric mean return of a Liquidity Provider's (LP) wealth $$W_t = Y_tS_t + X_t$$ for numeraire $$X_t$$, asset $$Y_t$$, and price process $$S_t$$ (see [this post](/research_notes/amms) for more on the setting). In particular, for a given fee $$\gamma$$, we want to calculate 

$$\lim_{T\to\infty}\frac{1}{T}\E[\log W_T].$$ 

We'll move away from the abstract setting considered [last time](/research_notes/amms/), and consider an actual price process. We'll adopt that used by Martin Tassy and David White in [this paper](https://math.dartmouth.edu/~mtassy/articles/AMM_returns.pdf) which has the price process $$S_t$$ follow (discrete) geometric Brownian motion. 

$$
\label{eq:price_process}
    S_t = 
    \begin{cases}
    1, & t=0, \\
    S_{t-1}e^{\delta U_t},& t>0,
    \end{cases}
$$

where $$U_t$$ are iid binomial random variables with success probability $$p$$, and $$\delta>0$$ is some constant parameter. Wlog we may assume $$p\geq 1/2$$, otherwise we flip the role of $$X_t$$ and $$Y_t$$. 

It's more intuitive to look at the price process in log space. Then we see that 

$$\log(S_t)-\log(S_{t-1})\in\{-\delta,\delta\},$$

meaning prices can jump up or down by a factor of $$\delta$$. $$\delta$$ sort of acts as our "discretization factor." 

Now, because products of exponentials play well together, we're going to choose the fee $$\gamma$$ to be $$\exp=(-k\delta)$$ for some $$k\in\N$$. This constrains the structure of $$S_t$$ very nicely. In particular, if $$S_0=X_0/Y_0$$, then at all times $$t$$, $$S_t=\exp(m_t\delta)\ratio_t$$ for some integer $$m_t$$. This is clear from induction on $$t$$: if $$S_t=\exp(m_t\delta)\ratio_t$$ then by definition of the price process, $$S_{t+1}\in\{\exp(\delta)S_t,\exp(-\delta)S_t\}=\{\exp((m_t+1)\delta)\ratio_t, \exp((m_t-1)\delta)\ratio_t\}$$ (the two cases come from $$U_{t+1}$$). 

# 2. Trading Game 

Under these assumptions, the no arbitrage condition is now 

$$S_t \in [\exp(-k\delta)\ratio_t, \exp(k\delta)\ratio_t].$$ 

As soon as the price is outside these bounds -- and it will be outside by a factor of either $$e^\delta$$ or $$e^{-\delta}$$ by definition of the price process -- then a trade is made. 

Thus, we can rewrite the trading game from last time as follows. 


1.  If $$S_t<\gamma\ratio_t$$, then $$S_t=\exp(-\delta)\gamma\ratio_t=\exp(-\delta(k+1))\ratio_t$$ and exchanging $$\DY_t$$ for $$\DX_t$$ is profitable. Using the equations we derived last time for how much is traded, along with definitions of $$\gamma,\ratio_t$$ and the value $$S_t$$, we obtain

    $$\DY_t = Y_t(\exp(\frac{\delta}{\gamma+1})-1),\quad \DX_t = X_t(1 - \exp(-\frac{\delta \gamma}{\gamma +1})).$$

2.  If $$S_t>\gamma^{-1}\ratio_t$$, then $$S_t=\exp(\delta)\gamma^{-1}\ratio_t=\exp(\delta(k+1))\ratio_t$$ and exchanging $$\DX_t$$ for $$\DY_t$$ is profitable. We obtain

    $$\DX_t = X_t(\exp(\frac{\delta}{\gamma+1}) -1),\quad \DY_t = Y_t(1 - \exp(-\frac{\delta\gamma}{\gamma+1})).$$

3. If $$\exp(-k\delta)\ratio_t\leq S_t\leq \exp(k\delta) \ratio_t$$ then no trade is made. 

Now, notice that the ratio $$S_t/\ratio_t$$ is always in the set $$\{\exp(-(k+1)\delta), \exp(-k\delta),\dots,\exp((k+1)\delta)\}$$, i.e., 

$$\log\frac{S_t}{\ratio_t}\in\delta\{-k-1,-k,\dots,k,k+1\},$$

with the two ends corresponding to trading states. 

Put $$M_t = \log(S_t/\ratio_t)$$. We can treat the movement of $$M_t$$ as Markov chain on the finite state space $$\{-k\delta,\dots,k\delta\}$$, which represent all the non-arbitrage states. 

In state $$k\delta$$, $$M_t$$ transitions with probability $$\delta$$ back to itself, meaning the price went up and a trade was made (case 2 in the trading game). In that case the ratio returns to $$S_t/\ratio_t=\exp(k\delta)$$. With probability $$1-\delta$$ the price went down and $$M_t$$ moves to state $$(k-1)\delta$$. 

Similarly, in state $$-k\delta$$, $$M_t$$ returns to its current state with probability $$1-\delta$$ and moves to state $$(-k+1)\delta$$ with probability $$\delta$$. Note the probabilities are reversed in this case because a trade is made when the price moves down instead of up. 

In all states besides the end state, the dynamics are driven solely by the price process.  In these states, the subsequent state moves up (towards $$k\delta$$) with probability $$\delta$$, and down (towards $$-k\delta$$) with probability $$1-\delta$$. 

The transition matrix for this process is therefore 

$$
P  = \begin{pmatrix}
1-p & p \\ 
1-p & 0 & p \\
0 & 1-p & 0 & p \\
& && \ddots  \\
&&& 1-p & 0 & p \\ 
&&&& 1-p & p
\end{pmatrix}
$$

To find the long run behavior of $$M_t$$ we find the stationary distribution $$\pi$$ such that $$\pi P=\pi$$.  Solving this equation gives that $$\pi_{i+1}=\frac{p}{q}\pi_{i-1}$$ for $$q=1-p$$ for all $$i$$, or $$\pi_i = (p/q)^{i-1}\pi_1$$. If $$p=q=1-p$$, i.e., $$p=1/2$$, then $$\pi_i=\pi_{i-1}$$ for all $$i$$ and the stationary distribution is 

$$\pi = \bigg(\frac{1}{2k+1},\dots,\frac{1}{2k+1}\bigg).$$

Otherwise, since we need all entries to sum to 1, 

$$1=\sum_{i=1}^{2k+1}(p/q)^{i-1}\pi_1 = \pi_1 \bigg(\frac{(p/q)^{2k+1}-1}{p/q-1}\bigg).$$

So we get 

$$\pi = \bigg(r, \frac{p}{q}r, \dots,\bigg(\frac{p}{q}\bigg)^{2k}r\bigg),$$

where 

$$r=\frac{p/q - 1}{(p/q)^{2k+1}-1}.$$



# 3. Expected Return 


Recall the no-arbitrage condition: $$S_t \in [\gamma \ratio_t, \gamma^{-1}\ratio_t]$$, that is,  $$\gamma\leq S_t/\ratio_t \leq \gamma^{-1}$$.  We can use this to bound the difference between $$W_t$$ and $$Y_t\ratio_t+X_t$$, which we call the _implicit wealth_. We have 

$$\frac{W_t}{Y_t\ratio_t + X_t} = \frac{Y_tS_t}{2X_t} + \frac{X_t}{2X_t} = \frac{S_t}{2\ratio_t} + \frac{1}{2} \in \bigg[\frac{\gamma}{2}, \frac{1}{2\gamma}\bigg].$$

This lets us write the expected log return as 

$$
\begin{align}
\E[\log W_t] &= \E\bigg[\log\bigg(\frac{W_t}{Y_t\ratio_t + X_t}\bigg) + \log(Y_t\ratio_t + X_t)\bigg] \\ 
&= \E[\log O(1)] + \E[\log(Y_t\ratio_t+X_t)]. 
\end{align}
$$

The reason we want to work with the implicit wealth instead of the true wealth is because it's easier to get a handle on the behavior of $$\ratio_t$$ than that of $$S_t$$. In particular, recall from last post that we know how the ratio $$\frac{X_{t+1}Y_{t+1}}{X_tY_t}$$ behaves over time. Trading $$X_t$$ for $$Y_t$$, we saw that 

$$\frac{X_{t+1}Y_{t+1}}{X_tY_t} = \bigg(\frac{\gamma S_t}{\ratio_t}\bigg)^{\frac{1-\gamma}{\gamma+1}}.$$

Note that in our case, $$S_t = \exp(\delta)\gamma\ratio_t$$ (Case 2 in the trading game), we get that 

$$\frac{X_{t+1}Y_{t+1}}{X_tY_t} = \exp\bigg(\delta\frac{1-\gamma}{1+\gamma}\bigg)=:C$$

Remarkably, we get the same result when trading $$Y_t$$ for $$X_t$$. Consequently, if there have been $$N_t$$ trades at time $$t$$ we have 

$$X_tY_t = C^{N_t} X_0Y_0 = C^n,$$

since $$X_0=Y_0=1$$. Drawing some inspiration from the fact that we know how $$X_tY_t$$ behaves over time, write 

$$
\begin{align}
\ratio_t = \frac{X_t}{Y_t} = \frac{X_t^2}{X_tY_t} = \frac{1}{4X_tY_t}(X_t\ratio_t + Y_t)^{2}. 
\end{align}
$$

In other words, 

$$Y_t\ratio_t + X_t = 2(\ratio_t)^{1/2}(X_tY_t)^{1/2} = 2\ratio_t^{1/2} C^{N_t/2},$$

therefore 

$$\E[\log(Y_t\ratio_t + X_t)] = \frac{1}{2}\E[\log \ratio_t ] + \frac{1}{2}\log(C)\E[N_t] + \log(2).$$

For the term $$\E[\log\ratio_t]$$, notice that $$X_t/Y_t$$ doesn't change unless there's a trade. If $$X_t$$ is traded for $$Y_t$$, then ratio changes as 

$$\frac{X_t + \Delta X_t}{Y_t - \Delta Y_t} = \frac{X_t}{Y_t}\exp\bigg(\frac{\delta}{\gamma+1}-\frac{-\delta\gamma}{\gamma+1}\bigg) = \frac{X_t}{Y_t}\exp(\delta).$$

Similarly, exchanging $$Y_t$$ for $$X_t$$ leads to a change by a factor of $$\exp(-\delta)$$. Since $$X_0=Y_0=1$$, it follows that $$\log(\ratio_t)$$ is always changing by a factor of $$\delta$$ or $$-\delta$$. Thus, to evaluate $$\E[\log\ratio_t]$$, we want to know how many times it ticked up by $$\delta$$, and how many times it ticked down by $$-\delta$$. Let $$M_T^\uparrow$$ be the number of times the price exceeded the top of the no-arbitrage range, i.e., $$S_t>\gamma^{-1}\ratio_t$$ (number of times $$\log\ratio_t$$ ticked up). Similarly, let $$M_t^\downarrow$$ be the number of times it falls below. Then, 

$$\E[\log \ratio_t] = \delta \E[M_T^\uparrow ] - \delta\E[M_T^\downarrow].$$

We evaluate these terms using the Markov chain $$M_t$$. In the limit, $$T^{-1}\E[M_T^\uparrow]$$ is the fraction of time during the interval $$[0,T]$$ that a trade (at the upper end of the arbitrage region) is made. This is precisely $$nTp\pi(k\delta)$$, where $$\pi$$ is the stationary distribution of $$M_t$$, $$nT$$ is total number of iterations played[^1] during time $$[0,T]$$, and $$p$$ is probability of the price moving up when in state $$\pi(k\delta)$$. Note we need to multiply $$\pi(k\delta)$$ by $$p$$, since we don't make a trade in state $$k\delta$$, only if the price increases while $$M_t$$ is already in state $$k\delta$$. The probability of the price increasing is $$p$$. A similar argument for $$T^{-1}\E[M_T^\downarrow]$$ in the limit implies its value is $$nT(1-p)\pi(-k\delta)$$. 

[^1]: This is an annoying detail that I chose to ignore for most of the post. Technically, there's one final detail we need to add to the model, and that's the number of trades that occur during an interval of time. So far we've just been writing $$t$$ and $$t+1$$, but since we're going to start taking limits in terms of time we need to be a little more careful. We'll assume that there are $$n$$ steps (e.g., price changes) in a single interval of time, so that in $$[0,T]$$ there are $$nT$$ steps played. Abusing notation, when we write e.g., $$X_{t+1}$$, we mean the next value of $$X_t$$, not the value at the next unit time $$n$$ steps later. 


Finally, note that $$N_T = M_T^\uparrow + M_T^\downarrow$$, so we can use the above analysis to obtain the value of $$T^{-1}\E[N_T]$$ in the limit. Putting this all together we get 

$$
\begin{align}
\lim_T \frac{1}{T}\E[\log W_T] &= \lim_T \frac{1}{T}\bigg(\E[\log O(1)] + \E[Y_t\ratio_t + X_t]\bigg) \\ 
&= \lim_T \frac{1}{T}\bigg(\frac{1}{2}\E[\log\ratio_t] + \frac{1}{2}\log(C)\E[N_T] + \log(2)\bigg) \\ 
&= \lim_T\frac{1}{2T}\bigg(\delta\E[M_T^\uparrow] - \delta\E[M_T^\downarrow] + \log(C)(\E[M_T^\uparrow] + \E[M_T^\downarrow])\bigg)\\
&= \lim_T\frac{\delta}{2T}\bigg\{\E[M_T^\uparrow]\bigg(1 + \frac{1-\gamma}{1+\gamma}\bigg) + \E[M_T^\downarrow]\bigg(\frac{1-\gamma}{1+\gamma}-1\bigg)\bigg\}\\
&= \frac{\delta}{2}\bigg\{np\pi(k\delta)\bigg(\frac{1}{1+\gamma}\bigg) - n(1-p)\pi(-k\delta)\bigg(\frac{2\gamma}{1+\gamma}\bigg)\bigg\}.
\end{align}
$$

From here, there are two cases to consider: $$p=1/2$$ and $$p>1/2$$. For $$p=1/2$$, we have $$\pi(k\delta)=\pi(-k\delta)=(2k+1)^{-1}$$, and 

$$
\begin{align}
\lim_T\frac{1}{T}\E[\log W_T] 
&= \frac{\delta n}{2(1+\gamma)(2k+1)}(p - 2\gamma(1-p)).
\end{align}
$$

Whereas for $$p>1/2$$, 


$$
\begin{align}
\lim_T \frac{1}{T} \E[\log W_T] 
&= \frac{\delta nr}{2(1+\gamma)}\bigg\{p\bigg(\frac{p}{q}\bigg)^{2k} - 2\gamma(1-p)\bigg\}.
\end{align}
$$

In sum, 

$$
\begin{equation}
\label{eq:return}
\lim_{T\to\infty}\frac{1}{T}\E[\log W_T] =  \begin{cases}
\frac{\delta n}{2(1+e^{-k\delta})(2k+1)}(p - 2e^{-k\delta}(1-p)),
& \text{if }p=1/2 \\ 
\frac{\delta nr}{2(1+e^{-k\delta})}(p(p/q)^{2k} - 2e^{-k\delta}(1-p)), &\text{if }p>1/2. 
\end{cases} \tag{1}
\end{equation}
$$

From here, you can start taking limits (slightly trickier than you think because of the relationship between $$\delta$$ and $$p$$ is constrained by the requirement that price process is geometric Brownian motion) to move into the continuous case. We're going to skip that because you can still gain insight into the optimal fee structure from this equation.

How should we set the fee in order to maximize return? In particular, how do we choose $$k$$? For $$p>1/2$$, we can check that Equation \eqref{eq:return} is monotonically increasing as $$k\to\infty$$, implying it gets larger as $$\gamma$$ gets smaller. That is, we want to set the fee as close to zero as possible without it actually being zero.[^2]

[^2]: Note our math prohibits it from ever reaching zero, and if we did simply set $$\gamma=0$$ then the LP wealth wouldn't ever increase. 

This is what's referred to as Uniswap's "[financial alchemy](https://research.paradigm.xyz/uniswaps-alchemy)", because the result is so counterintuitive. Of course, in reality I'm not sure what it means to set the fee arbitrarily close to zero. Most likely, something would break. Better, I think, to realize that this model is imperfect and likely not capturing true market behavior. 

Then again, the model is more robust than it might appear at first glance, at least from the perspective of maximizing LP wealth (besides it being discrete, but that can be fixed). Sure, it makes the assumption that a trade occurs each time step. But even if not, and the prices deviates significantly from the no-arbitrage region, then the next trade which optimizes its profits is mathematically equivalent to multiple intermediary trades (i.e., in some sense, the model is linear -- not preferring one big trade to many small ones). Moreover, while the model assumes that only arbitrage trades are made, other trades would simply add to the LP's wealth while not being worth it for the trader. In that sense, the model is conservative in its estimate of wealth accumulation. 

Still, it _does_ assume perfect information and, of course, that the price follows a well-defined geometric brownian motion. This implies that there are no huge, near-instantaneous price drops (or at least they occur with very, very low probability), which is not the case in practice. I'm sure Nassim Taleb has yelled about this somewhere. 

It's also worth noting that Equation \eqref{eq:return} looks slightly different from that obtained by Tassy and White in their [paper](https://math.dartmouth.edu/~mtassy/articles/AMM_returns.pdf). I think they made a mistake when calculating $$\lim \E[\log \ratio_T]/T$$, but it's hard to be sure. Either way, we get the same result for the optimal fee.  
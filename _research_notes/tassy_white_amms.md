---
layout: note 
date: "2022-03-21" 
title: "LP Wealth in Constant Product AMMs"
status: unpublished
---

$$
\newcommand{\N}{\mathbb{N}}
\newcommand{\ratio}{\Lambda}
\newcommand{\DX}{\Delta X}
\newcommand{\DY}{\Delta Y}
$$

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

It's more intutive to look at the price process in log space. Then we see that 

$$\log(S_t)-\log(S_{t-1})\in\{-\delta,\delta\},$$

meaning prices can jump up or down by a factor of $$\delta$$. $$\delta$$ sort of acts as our "discretization factor." 

Now, because products of exponentials play well together, we're going to choose the fee $$\gamma$$ to be $$\exp=(-k\delta)$$ for some $$k\in\N$$. This constrains the structure of $$S_t$$ very nicely. In particular, if $$S_0=X_0/Y_0$$, then at all times $$t$$, $$S_t=\exp(m_t\delta)\ratio_t$$ for some integer $$m_t$$. We can see this by induction on $$t$$. The base case is given by assumption. Assume it holds for some $$t$$, so $$S_t=\exp(m_t\delta)\ratio_t$$. Then by definition of the price process, $$S_{t+1}\in\{\exp(\delta)S_t,\exp(-\delta)S_t\}$$ (the two cases come from $$U_{t+1}$$). Then, by Equations \eqref{eq:XtYtnumeraire} and \eqref{eq:XtYtasset}, $$S_t$$ is a function of $$\gamma$$ and $$\ratio_t$$. Since $$\gamma=\exp(-k\delta)$$, multiplying everything together gives the result. 


Ok, that's all well and good -- but why does this matter? Because now we can say precisely how much is traded at each timestep. 

The no arbitrage condition is now 

$$S_t \in [\exp(-k\delta)\ratio_t, \exp(k\delta)\ratio_t].$$ 

As soon as the price is outside these bounds -- and it will be outside by a factor of either $$e^\delta$$ or $$e^{-\delta}$$ by definition of the price process -- then a trade is made. 

Thus, we can re-write the trading game (Section~\ref{sec:trading_game}) as follows. 


- If $$S_t<\gamma\ratio_t$$, then $$S_t=\exp(-\delta)\gamma\ratio_t=\exp(-\delta(k+1))\ratio_t$$ and exchanging $$\DY_t$$ for $$\DX_t$$ is profitable. Using Equations~\eqref{eq:sol2} along with the definitions of $$\gamma, \ratio_t$$ and the value of $$S_t$$, we find that the amounts traded are: 

    $$\DY_t = Y_t(\exp(\frac{\delta}{\gamma+1})-1),\quad \DX_t = X_t(1 - \exp(-\frac{\delta \gamma}{\gamma +1})).$$

- If $$S_t>\gamma^{-1}\ratio_t$$, then $$S_t=\exp(\delta)\gamma^{-1}\ratio_t=\exp(\delta(k+1))\ratio_t$$ and exchanging $$\DX_t$$ for $$\DY_t$$ is profitable. Using Equations~\eqref{eq:uncon_sol} along with definitions of $$\gamma,\ratio_t$$ and the value $$S_t$$, we find that the amounts traded are: 

$$\DX_t = X_t(\exp(\frac{\delta}{\gamma+1}) -1),\quad \DY_t = Y_t(1 - \exp(-\frac{\delta\gamma}{\gamma+1})). $$

- If $$\exp(-k\delta)\ratio_t\leq S_t\leq \exp(k\delta) \ratio_t$$ then no trade is made. 




---
layout: note 
date: "2022-03-21" 
title: "Understanding Automated Market Makers (AMMs)"
status: published
---

<p class='title'>Introduction to Automated Market Makers (AMMs)</p>

$$
\newcommand{\blambda}{\bar{\lambda}}
\newcommand{\bp}{\bar{p}}
\newcommand{\Z}{\mathbb{Z}}
\newcommand{\N}{\mathbb{N}}
\newcommand{\DX}{\Delta X}
\newcommand{\DY}{\Delta Y}
\newcommand{\ratio}{\Lambda}
$$

- TOC 
{:toc}

Decentralized Exchanges (DEXs) are digital markets enabling cryptocurrency transactions which do not require third parties to oversee the process. Part of this involves replacing human [market makers](https://www.investopedia.com/terms/m/marketmaker.asp#:~:text=The%20term%20market%20maker%20refers,in%20the%20bid%2Dask%20spread.) with smart contracts known as _automated market makers_ (AMMs). Roughly, AMMs are rules determining how much of good $$X$$ can be traded for good $$Y$$ (where "goods" here typically refer to various cryptocurrencies). Examples of DEXs include [Uniswap](https://uniswap.org/) and [Balancer](https://balancer.fi/), each of which has their own AMM protocol. 

I'm basically agnostic as to the promise of DEXs, and there are certainly [known problems](https://cointelegraph.com/explained/crypto-rug-pulls-what-is-a-rug-pull-in-crypto-and-6-ways-to-spot-it#:~:text=Rug%20pulls%20happen%20when%20fraudulent,decentralized%20finance%20(DeFi)%20exploit.) as they exist right now. But the math is interesting, so we're going to explore them from that perspective. Going forward, we'll focus on markets exchanging two goods. 

# 1. Wealth and Price Processes

A _numeraire_ is any financial standard against which we compare the value of assets. Typically numeraires are stable, providing a reliable means against we can compare something more volatile. Technically speaking, however, they can be anything. 

For example, a numeraire might be the US dollar, and the asset lumber. In crypto land, they're typically cryptocurrencies. But it's helpful to keep the USD and lumber example in the back of your head. 

At time $$t$$, let $$X_t$$ be the amount of numeraire (USD), and $$Y_t$$ the amount of asset (lumber). The price of the asset w.r.t. to the numeraire is controlled by stochastic market forces, captured mathematically by what we'll call a _price process_. The price process is a sequence of random variables $$S_t$$, which define the relationship between wealth, numeraire, and assets: 

$$
\begin{equation}
    \label{eq:wealth}
    W_t = X_t + Y_tS_t. \tag{1}
\end{equation}
$$

Here, $$W_t$$ is total wealth _as measured by the numeraire_. Thus, $$S_t$$ can be conceived as a mapping from the asset space to the numeraire space. E.g., suppose $$S_t=7$$ USD per unit lumber. If we have 100 USD on hand, and 8 pieces of lumber, then our total wealth is 100 + 7*8 = 156 USD. 

The specific price process will be chosen as a function of the market being analyzed. Later on, we'll consider a Brownian motion based price process. But the general takeaway is that the price process is external to the market under consideration. Neither the liquidity provider (person supplying initial supplies of $$X$$ and $$Y$$ to the market), nor the traders control $$S_t$$. 


# 2. AMMs
In a perfectly balanced market, a trader should not care whether she holds $$X_t$$ or $$Y_t$$, because they convert to the same amount, i.e., $$X_t=Y_tS_t$$, so that total wealth is $$2X_t=2Y_tS_t$$. For example, if $$X_t=100$$ USD, and there are 5 units of lumber $$(Y_t)$$, each unit costing 20 USD $$(S_t)$$ then it is immaterial whether one holds USD or lumber, and there is no gain to be made from swapping between the two. This is captured by the condition $$S_t=X_t/Y_t$$. We call $$X_t/Y_t$$ the _implicit price_.   

Roughly speaking, if $$S_t$$ is higher than the implicit price, then trading $$X_t$$ for $$Y_t$$ becomes profitable (assuming there's no cost for making the transaction). Likewise, if $$S_t$$ is lower than the implicit price, then trading $$Y_t$$ for $$X_t$$ becomes profitable. 

The preceding paragraph is only approximately true, because the exact mechanics depend on how exchanging $$X_t$$ for $$Y_t$$ and vice versa is allowed. If there is a fee associated with the transaction which is higher than all the current value in the market, then clearly no trade is profitable. 

The rule determining which trades are permissible is the AMM. It takes the form of an invariant which must hold after the transaction is completed. One of the simplest AMMs is a _constant function_ AMM, which takes the form: 

$$
\begin{equation*}
\begin{cases}
    (X_t + \DX_t)(Y_t-\DY_t) = c,&\text{if trading }\DX_t\text{ for }\DY_t,\\
    (X_t - \DX_t)(Y_t+\DY_t) = c,&\text{if trading }\DY_t\text{ for }\DX_t.
\end{cases}    
\end{equation*}
$$

where $$c>0$$ is some constant, $$\DX_t$$ is the amount of $$X_t$$ being traded, and $$\DY_t$$ the amount of $$Y_t$$. Note that if a trader is exchanging $$\DX_t$$ for $$\DY_t$$, then the market gains $$\DX_t$$ and loses $$\DY_t$$, hence the signs. 

We want to encourage these markets to exist; in particular, we want to encourage people to invest $$X$$ and $$Y$$ into them (so-called liquidity providers). To do this, we'll add a fee to the transaction, so that the market is getting richer over time. 
A common such AMM is the following: 

$$
\begin{equation}
\label{eq:amm_fee}
\begin{cases}
    (X_t + \DX_t)^\gamma (Y_t-\DY_t) = X_t^\gamma Y_t,&\text{if trading }\DX_t\text{ for }\DY_t,\\
    (X_t - \DX_t) (Y_t+\DY_t)^\gamma = X_t Y_t^\gamma,&\text{if trading }\DY_t\text{ for }\DX_t,
\end{cases}  \tag{2}  
\end{equation}
$$

where $$\gamma\in[0,1)$$. The quantity $$\rho = 1-\gamma$$ acts as the fee. If $$\rho=0$$, then we recover the constant AMM above, and as $$\rho\to1$$, the trade becomes ever more expensive in the sense that we are given less $$Y_t$$ for every unit of $$X_t$$ traded (and vice versa).  

We'll be using \eqref{eq:amm_fee} for the remainder of the post. 

# 3. Trading dynamics

Our eventual goal is to understanding how the wealth of a liquidity provider increases or decreases over time as a function of the fee $$\gamma$$. To do this, we need to understand how the quantities of $$X_t$$ and $$Y_t$$ change over time. The first step is to understand when it is in a trader's interest to exchange goods -- i.e., when there is an arbitrage opportunity.  

## 3.1 No Arbitrage Conditions
At a fixed time $$t$$ and with $$S_t$$ known to a trader, we want to answer the question: what trade (if any) is the most profitable? First, consider trading $$X_t$$ for $$Y_t$$. For now, we'll assume that however much $$Y_t$$ the trader obtains, she's able to cash it all (the lumber can all be converted to cash). That is, if she obtains $$\DY_t$$ of $$Y_t$$, then the value is $$S_t\DY_t$$. The technical term for this is that the market is sufficiently liquid for any trade, or infinitely liquid. Thus, the trader is interested in maximizing $$S_t\DY_t - \DX_t$$ (she gains $$\DY_t$$ at unit price $$S_t$$, and loses $$\DX_t$$). Of course, $$\DX_t$$ and $$\DY_t$$ must be constrained by the AMM, and must be positive. This yields the following optimization problem: 

$$
\begin{align}
    \max_{\DX_t,\DY_t} \quad & S_t\DY_t - \DX_t \notag\\ 
    \text{s.t.} \quad & (X_t + \DX_t)^\gamma (Y_t-\DY_t)=X_t^\gamma Y_t, \tag{3}\label{eq:opt1}\\
    &\DX_t,\DY_t\geq 0. \notag
\end{align}
$$

Using the AMM constraint, we can rewrite $$\DY_t$$ in terms of $$\DX_t$$ and obtain the single variable problem

$$
\begin{align*}
    \max_{\DX_t}\; f(\DX_t) = S_t Y_t(1 - X_t^\gamma(X_t+\DX_t)^{-\gamma}) - \DX_t,\quad \text{s.t.}\quad \DX_t \geq 0. 
\end{align*}
$$

Setting $$\frac{df}{d\DX_t}=0$$ and performing the relevant arithmetic yields

$$
\begin{equation}
\label{eq:uncon_sol}
\DX_t = X_t\bigg(\bigg(\frac{\gamma S_t Y_t}{X_t}\bigg)^{\frac{1}{\gamma+1}}-1\bigg),\quad \DY_t = Y_t\bigg(1 - \bigg(\frac{\gamma S_t Y_t}{X_t}\bigg)^{-\frac{\gamma}{\gamma + 1}}\bigg),    \tag{4}
\end{equation}
$$

where the second equation comes from substituting $$\DX_t$$ into the AMM equation. 
Note that 

$$\frac{d^2 f}{d\DX_t^2}=-\frac{\gamma(\gamma+1) S_tY_tX_t^\gamma}{(X_t+\DX_t)^{\gamma+2}}<0,$$

meaning $$f$$ is concave so it has a single maximum. It follows that the maximum to the constrained problem is either at $$\DX_t$$ of \eqref{eq:uncon_sol}, or at 0 (since if $$\DX_t<0$$ then it \emph{strictly} decreases away from this point). Thus, the solution to \eqref{eq:opt1} is $$\DX_t^*=\max\{\DX_t,0\}$$, and $$\DY_t^*=\max\{\DY_t,0\}$$, where $$\DY_t$$ and $$\DX_t$$ are as in Equation \eqref{eq:uncon_sol}.

Notice that $$\DX_t^*> 0$$ iff $$S_t > \gamma^{-1} X_t/Y_t$$, implying the trade is not worth it for $$S_t$$ less than that (and recall that the trader knows $$S_t$$ -- she can check the price of lumber). The same condition holds for $$\DY_t^*$$. We've learned when it is profitable to trade $$X_t$$ for $$Y_t$$. 

Answering the opposite question, namely when it is profitable to trade $$Y_t$$ for $$X_t$$ is similar to above. In this case we solve the problem

$$
\begin{align}
\label{eq:opt2}
    \max_{\DX_t,\DY_t} \quad & \DX_t - S_t\DY_t \notag\\
    \text{s.t.} \quad & (X_t - \DX_t)  (Y_t+\DY_t)^\gamma=X_t Y_t^\gamma, \notag \\
    &\DX_t,\DY_t\geq 0. \notag
\end{align}
$$

Proceeding as before, this time we obtain the solutions 

$$
\begin{equation}
\label{eq:sol2}
\DX_t^* = \max\bigg\{X_t\bigg(1 - \bigg(\frac{S_tY_t}{\gamma X_t}\bigg)^{\frac{\gamma}{\gamma+1}}\bigg), 0\bigg\}, 
\end{equation}
$$

$$
\begin{equation}
\label{eq:sol3}
\DY_t^* =  \max\bigg\{Y_t\bigg(\bigg(\frac{\gamma X_t}{S_tY_t}\bigg)^{\frac{1}{\gamma+1}} -1 \bigg),0\bigg\}. 
\end{equation}
$$

In this case, we learn that it's not profitable to trade unless $$S_t < \gamma X_t/Y_t$$. 


This gives us conditions on when no trade is profitable (so called 'no-arbitrage' conditions). 

$$
\begin{equation}
\label{eq:no_arbitrage}
  S_t\in\bigg[\gamma\ratio_t,\frac{1}{\gamma}\ratio_t\bigg],\quad\text{where}\quad \ratio_t\equiv \frac{X_t}{Y_t}. 
 \end{equation}
 $$

 Note that this is fairly intuitive: as $$\gamma$$ increases (and the fee decreases), the interval gets smaller. Less costly trades imply that traders can be more sensitive to changes in price and leverage even small differences to their advantage. 

## 3.2 The trading game

Based on the no-arbitrage conditions derived above, we know understand when trades will and won't occur. It's now worth spelling out how the actual dynamics of this two good economy will play themselves out. 

We make the following assumption: 


(A1) _When there is an arbitrage opportunity, there exists a trader in the market who will make a trade to maximize her profits. Moreover, this trade freezes the market, i.e., no two traders try to trade at the same time. The subsequent change in the availability of $$X_t$$ and $$Y_t$$ are known to all traders in the market immediately after the transaction has occurred._

Note that assumption A1 implies that only one trade happens per timestep. 

The game proceeds as follows. We start with some initial amount of numeraire and asset, $$X_0$$, $$Y_0$$, and an initial price $$S_0$$. At each time $$t$$: 


- If $$S_t<\gamma \ratio_t$$, then a trader exchanges $$\DY_t$$ for $$\DX_t$$ such that $$S_t\in [\gamma \ratio_{t+1},\gamma^{-1}\ratio_{t+1}]$$. In particular, $$S_t = \gamma \Lambda_{t+1}$$. 
- If $$S_t > \gamma^{-1}\ratio_t$$, then a trader exchanges $$\DX_t$$ for $$\DY_t$$ such that $$S_t\in [\gamma \ratio_{t+1},\gamma^{-1}\ratio_{t+1}]$$. In particular, $$S_t = \gamma^{-1}\Lambda_t$$. 
- If $$S_t\in [\gamma \ratio_{t},\gamma^{-1}\ratio_{t}]$$ then no trade occurs. 

While this is somewhat abstract, it's worth keeping this general process in mind. The upshot is that if the current price is in the no-arbitrage region then no trade occurs because it's not in any traders' interest. On the other hand, if $$X_t$$ is sufficiently underpriced relative to $$Y_t$$ such that $$S_t < \gamma \Lambda_t$$, then somebody will trades $$\DY_t$$ for $$\DX_t$$. In particular, they trade precisely the amount given by Equation \eqref{eq:uncon_sol}, which means that $$X$$ and $$Y$$ (which are now $$X_{t+1}$$ and $$Y_{t+1}$$) now obey $$S_t = \gamma\Lambda_{t+1}$$. Exchanging more $$\DY_t$$ would not have been profitable for the trader. 

## 3.3 Evolution of $$X_t/Y_t$$

Finally, we investigate how the ratio $$X_t/Y_t$$ behaves over time. Of course, in the constant AMM case, it remains constant: $$X_t Y_t=c$$. But the fee complicates matters. For the AMM with fee, consider a numeraire based trade (trading $$\DX_t$$ for $$\DY_t$$). Using Equation \eqref{eq:uncon_sol} 

$$
\begin{equation}
\label{eq:XtYtnumeraire}
    \frac{X_{t+1}}{Y_{t+1}} 
    = \frac{X_t + \DX_t}{Y_t-\DY_t} 
    = X_t\bigg(\frac{\gamma S_t Y_t}{X_t}\bigg)^{\frac{1}{\gamma+1}} \bigg/ Y_t \bigg(\frac{\gamma S_t Y_t}{X_t}\bigg)^{-\frac{\gamma}{\gamma+1}} = \gamma S_t. 
\end{equation}
$$

Similarly, in the case of trading $$\DY_t$$ for $$\DX_t$$ we obtain, 

$$
\begin{equation}
\label{eq:XtYtasset}
    \frac{X_{t+1}}{Y_{t+1}} = \frac{X_t-\DX_t}{Y_t+\DY_t} = \gamma^{-1}S_t.
\end{equation}
$$

The knowledge that the ratio of $$X_t/Y_t$$ evolves according to a multiplicative factor of $$\gamma$$ and price process will be valuable later on. 

# 4. Resources 

- [LP Wealth](https://research.paradigm.xyz/LP_Wealth.pdf)
- [An analysis of Uniswap markets](https://arxiv.org/pdf/1911.03380.pdf)

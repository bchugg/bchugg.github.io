---
layout: note
date: "2026-07-21"
title: "Optimal Stopping with Snell Envelopes"
description: "Discrete-time optimal stopping via the Snell envelope, in finite and infinite horizon"
status: published
---

$$
\newcommand{\ind}{\mathbf{1}}
\newcommand{\E}{\mathbb{E}}
\newcommand{\calF}{\mathcal{F}}
\newcommand{\esssup}{\operatorname*{ess\,sup}}
$$


Let $$(X_n)_{n\in\mathbb{N}}$$ be a discrete stochastic process on a filtered probability space $$(\Omega,(\calF_n)_{n\geq 0},P)$$. We are interested in calculating the quantity

$$
\begin{equation}
V_N = \sup_{\tau\leq N} \E_P[X_\tau], \tag{1}
\end{equation}
$$

where $$\tau$$ ranges over all stopping times and $$N\in\mathbb{N}\cup\{\infty\}$$.

# 1. Finite $$N$$

Let's first focus on finite $$N$$. In this case the solution can be found via dynamic programming, in an argument that really feels like it should be simpler than it is. Suppose we are betting on the $$X_t$$ as they are revealed. At time $$t$$ we can either take $$X_t$$ and stop the game, or we can discard it and move onto $$X_{t+1}$$. What's the optimal strategy?

Define a sequence $$(S_t)$$ which will capture our gain. If we hit the end of the game, i.e., $$t = N$$, then we have no choice but to end with $$X_N$$. So set $$S_N = X_N$$. At time $$N-1$$ we can either choose $$X_{N-1}$$ or we can keep playing, in which case our expected gain given what we know at time $$N-1$$ is $$\E[S_{N}\mid\calF_{N-1}] = \E[X_N \mid \calF_{N-1}]$$. Similarly at time $$N-2$$, $$N-3$$, and so on. In general, for $$n=1,\dots,N-1$$,

$$
\begin{equation}
    S_n = \max\{ X_n, \E_P[S_{n+1} \mid \calF_n]\}, \tag{2}
\end{equation}
$$

and $$S_0 = \E_P[S_{1}\mid \calF_0] = \E_P[S_1]$$ (we assume that $$\calF_0$$ is the trivial $$\sigma$$-field). The stopping time associated with this game is

$$
\begin{equation}
    \tau^* = \inf\{t\geq 0: S_t = X_t\}, \tag{3}
\end{equation}
$$

i.e., we stop precisely when the current value of $$X_t$$ equals our optimal expected gain. Note that $$\tau^*$$ is a bona fide finite stopping time: $$\{\tau^* = t\}$$ is $$\calF_t$$-measurable, and since $$X_N = S_N$$, $$\tau^* \leq N$$.

Now, we constructed $$(S_t)$$ to be optimal at every step intuitively, but the reasoning we used was heuristic. Proving that the resulting stopping time $$\tau^*$$ is indeed optimal is a bit more involved.

**Claim 1.**
For every $$0\leq k\leq N$$, $$S_k = \E[S_{\sigma_k^*} \mid \calF_k]$$ where $$\sigma_k^* = \inf\{j\geq k: S_j = X_j\}$$.
Moreover,

$$
\begin{equation}
\label{eq:Sn=max}
    S_n = \esssup_{n\leq \tau\leq N} \E[X_\tau \mid \calF_n]. \tag{4}
\end{equation}
$$

(If you don't like the essential supremum, just replace it with the supremum and ignore any measurability issues. It's just a technicality to ensure that everything is well-defined.)

**Proof.**
We begin with the first part. Fix $$k$$ and write $$\sigma^* = \sigma_k^*$$. We claim that
$$(S_{t\wedge \sigma^*})_{k\leq t\leq N}$$ is a martingale. This is easy enough to see after recalling the definition $$S_t = \max\{X_t ,\E[S_{t+1}\mid \calF_t]\}$$. For $$t<\sigma^*$$, by definition of $$\sigma^*$$, we must have $$X_t < S_t$$. Therefore, $$S_{t\wedge \sigma^*} = S_{t} = \E[S_{t +1}\mid \calF_t] = \E[S_{(t+1)\wedge \sigma^*}\mid \calF_t]$$ (since $$t+1 = (t+1)\wedge \sigma^*$$ for such $$t$$). Meanwhile, for $$t\geq \sigma^*$$, the process is stopped and $$S_{t\wedge \sigma^*} = S_{\sigma^*} = \E[S_{\sigma^*}\mid \calF_t],$$ so the martingale property is immediate in this case. Martingale proof complete.

Next, using that $$(S_{t\wedge \sigma^*})_{k\leq t\leq N}$$ is a martingale, we have

$$
\begin{equation*}
    S_k = S_{k\wedge \sigma^*} = \E[S_{N\wedge \sigma^*} \mid \calF_k] = \E[S_{\sigma^*}\mid \calF_k] = \E[X_{\sigma^*}\mid \calF_k],
\end{equation*}
$$

where the final equality follows by definition of $$\sigma^*$$. This gives the first part of the claim.

Now let's move onto proving \eqref{eq:Sn=max}, which we do by backwards induction. The base case $$n=N$$ is clear. Suppose the claim holds for some $$k$$.
Here's a very common trick in the theory of optimal stopping: consider any stopping time $$\tau\geq {k-1}$$ and let $$E = \{\tau = k-1\}$$, which is $$\calF_{k-1}$$-measurable by definition of a stopping time. Hence $$E^c \in \calF_{k-1}$$ as well. By definition of $$E$$ write

$$
\begin{equation*}
    X_\tau = X_{k-1} \ind_E + X_{\tau \vee k} \ind_{E^c}.
\end{equation*}
$$

Taking conditional expectations and using that both $$E$$ and $$E^c$$ are $$\calF_{k-1}$$-measurable,

$$
\begin{align*}
    \E[X_\tau \mid \calF_{k-1}] &= \ind_E X_{k-1} + \ind_{E^c} \E[X_{\tau\vee k}\mid \calF_{k-1}] \\
    &= \ind_E X_{k-1} + \ind_{E^c} \E[\E[X_{\tau\vee k}\mid \calF_k]\mid\calF_{k-1}] \\
    &\leq \ind_E X_{k-1} + \ind_{E^c} \E\left[\max_{k\leq \sigma\leq N}\E[X_{\sigma}\mid \calF_k]\,\Big|\,\calF_{k-1}\right] \\
    &=  \ind_E X_{k-1} + \ind_{E^c} \E[S_k\mid\calF_{k-1}] \\
    &\leq \max\{X_{k-1}, \E[S_k \mid \calF_{k-1}]\} \\
    & = S_{k-1}.
\end{align*}
$$

Therefore, since $$\tau\geq k-1$$ was arbitrary,

$$
\begin{equation}
    \esssup_{k-1\leq\tau\leq N} \E[X_\tau\mid \calF_{k-1}] \leq S_{k-1}. \tag{5}
\end{equation}
$$

Now for the converse. Using that $$S_k = \E[X_{\sigma_k^*}\mid \calF_{k}]$$ we have

$$
\begin{align*}
      \E[S_k\mid\calF_{k-1}] &= \E\big[\E[X_{\sigma^*}\mid\calF_k]\mid\calF_{k-1}\big]
      \\
      &= \E[X_{\sigma^*}\mid\calF_{k-1}]
      \leq \esssup_{k-1\leq\tau\leq N}\E[X_\tau\mid\calF_{k-1}],
\end{align*}
$$

so

$$
\begin{equation*}
      S_{k-1} = \max\{X_{k-1},\, \E[S_k\mid\calF_{k-1}]\}
      \leq \esssup_{k-1\leq\tau\leq N}\E[X_\tau\mid\calF_{k-1}],
\end{equation*}
$$

and combined with the forward inequality we conclude that \eqref{eq:Sn=max} holds for $$n=k-1$$.

The process $$(S_t)$$ is called the _Snell envelope_ of $$(X_t)$$. It's an upper bound on $$(X_t)$$ (by construction) and also a supermartingale: $$\E_P[S_{n+1}\mid\calF_n] \leq S_n$$ for all $$n$$. It is in fact the smallest supermartingale which dominates $$(X_n)$$. At each time $$t$$ the Snell envelope $$S_t$$ can be considered as an optimistic estimate of the future of the underlying process.

That $$\tau^*$$ is the optimal stopping time follows from Claim 1. Note that $$\sigma_0^* = \tau^*$$, so $$S_0 = \E[S_{\tau^*}\mid\calF_0] = \E[S_{\tau^*}]$$. And from \eqref{eq:Sn=max} we have $$S_0 = \esssup_{\tau\leq N} \E[X_\tau]$$. Hence $$\E[S_{\tau^*}] = \esssup_{\tau\leq N} \E[X_\tau]$$.

# 2. $$N=\infty$$

In the infinite-horizon setting, the previous strategy breaks down immediately. For one, there's no base case in the recursion anymore (we can't start with $$S_N = X_N$$). Second, even if we could define $$(S_n)$$ inductively, the martingale property of $$(S_{t\wedge \tau^*})$$ wouldn't be enough to show that $$\tau^*$$ is optimal since the optional stopping theorem doesn't immediately hold in the infinite-horizon case.

Interestingly, the solution will be to basically reverse the analysis done in the finite-horizon case. There we started with the recursive definition of $$S_n$$, and then proved that it gave rise to the Snell envelope. Here we start with the Snell envelope, and then prove that it satisfies the recursion. Of course, the finite-horizon setting could be proved this way too, but I prefer starting with the recursion because it's significantly more intuitive.

For finite $$N$$, define

$$
\begin{equation}
    S_n^{(N)} := \esssup_{n\leq \tau\leq N} \E[X_\tau \mid \calF_n], \tag{6}
\end{equation}
$$

which is the same object we saw in the finite-horizon case. Observing that $$S_n^{(N)}\leq S_n^{(N+1)}\leq \dots$$ (since we're only enlarging the set of stopping times) we can define the limit (which may be $$+\infty$$)

$$
\begin{equation}
\label{eq:Sn-infinite}
    S_n := \lim_{N\to\infty} S_n^{(N)} = \sup_{N\geq n} S_n^{(N)} = \esssup_{\tau\geq n} \E[X_\tau\mid \calF_n]. \tag{7}
\end{equation}
$$

And now we can show $$S_n$$ satisfies the desired recursion.

**Claim 2.** For $$S_n$$ as defined in \eqref{eq:Sn-infinite}, we have

$$
\begin{equation}
    S_n = \max\{X_n, \E[S_{n+1}\mid \calF_n]\}. \tag{8}
\end{equation}
$$

**Proof.** The forward direction mimics what was done above. Consider any stopping time $$\tau\geq n$$ and let $$E = \{\tau=n\}\in\calF_n$$. Write

$$
\begin{align*}
    \E[X_\tau\mid \calF_n] &= \E[X_\tau \ind_E + X_\tau\ind_{E^c}\mid \calF_n] = X_n \ind_E + \ind_{E^c} \E[X_\tau\mid \calF_n],
\end{align*}
$$

where on $$E^c$$, $$\tau\geq n+1$$ and is a candidate in the ess sup defining $$S_{n+1}$$, hence $$\E[X_\tau\mid \calF_n] = \E[\E[X_\tau \mid \calF_{n+1}]\mid \calF_n] \leq \E[S_{n+1}\mid \calF_n]$$. Therefore,

$$
\begin{align*}
    \E[X_\tau\mid \calF_n] \leq X_n \ind_E + \ind_{E^c} \E[S_{n+1}\mid \calF_n] \leq \max\{X_n, \E[S_{n+1}\mid \calF_n]\}.
\end{align*}
$$

As for the other direction, clearly $$S_n \geq X_n$$ by considering $$\tau=n$$. To see that $$S_n \geq \E[S_{n+1}\mid \calF_n]$$ we need to use a sneaky property of the essential supremum, which is that there exists an increasing sequence of stopping times $$(\sigma_k)$$, $$\sigma_k\geq n+1$$, such that

$$
\begin{equation*}
    \lim_{k\nearrow \infty} \E[X_{\sigma_k}\mid \calF_{n+1}] = S_{n+1}.
\end{equation*}
$$

This is not terribly surprising once you stare at the definition, but we won't prove it here because it takes us a bit far afield from our goal. Using this property, we have

$$
\begin{align*}
    \E[S_{n+1}\mid \calF_n] &= \E[\lim_k \E[X_{\sigma_k}\mid \calF_{n+1}]\mid \calF_n] \\
    &= \lim_k \E[ \E[X_{\sigma_k}\mid \calF_{n+1}]\mid \calF_n] = \lim_k \E[X_{\sigma_k}\mid\calF_n]\leq S_n,
\end{align*}
$$

where the second equality is by the monotone convergence theorem, and the final inequality holds because each $$\sigma_k$$ is a candidate in the esssup defining $$S_n$$. We can thus conclude that $$S_n \geq \max\{X_n, \E[S_{n+1}\mid\calF_n]\}$$ and hence that the claim holds.

Ok good, so we've extended at least some of the work in the finite-horizon case to the infinite-horizon case. But we still need to prove the optimality of the stopping time

$$
\begin{equation}
    \tau^* = \inf\{t\geq 0: S_t = X_t\}. \tag{9}
\end{equation}
$$

The argument in the finite-horizon case relied on showing that $$(S_{t\wedge \tau^*})$$ is a martingale, and then applying the optional stopping theorem. Again, this breaks when $$N=\infty$$.
But here's what we _want_ to do. As before, we'd like to show that $$S_0 = \E[S_{\tau^*}]$$. The process $$(S_{t\wedge \tau^*})$$ is a martingale (the proof of this fact doesn't change), so $$S_0 = \E[S_{n\wedge \tau^*}]$$ for any $$n$$, hence

$$
\begin{equation}
    S_0 = \lim_{n\to\infty} \E[S_{n\wedge \tau^*}]. \tag{10}
\end{equation}
$$

We would like to pass the limit inside, since $$\lim_n S_{n\wedge \tau^*} = S_{\tau^*}$$. But we can't do that without some sort of regularity condition on the underlying process. A sufficient one is uniform integrability of $$(S_n)$$, which says that $$\lim_{K\to\infty} \sup_n \E[\vert S_n\vert \ind\{\vert S_n\vert \geq K\}] = 0.$$ This is handy because if $$(S_n)$$ is uniformly integrable and $$S_n \to S$$ almost surely, then $$\E[S_n]\to \E[S]$$, so

$$\lim_{n\to\infty} \E[S_{n\wedge \tau^*}] = \E[\lim_n S_{n\wedge \tau^*}] = \E[S_{\tau^*}],$$

which gives us the desired conclusion. Of course, you might complain that this isn't that useful. The sequence $$(S_n)$$ is defined in terms of an essential supremum over stopping times and is rather opaque. How do we know that $$(S_n)$$ is uniformly integrable? But we can give a condition on the underlying process $$(X_n)$$ which is much easier to check, and which implies uniform integrability of $$(S_n)$$. This is the most common sufficient condition you'll see stated in papers using the Snell envelope. It's that the positive part of $$(X_n)$$ has finite expected value, uniformly over $$n$$:

$$
\begin{equation}
    \E[\sup_n X_n^+]<\infty, \tag{11}
\end{equation}
$$

where $$X_n^+ = \max(X_n,0)$$. And that's more or less the whole story. The Snell envelope $$(S_t)$$ is the smallest supermartingale dominating $$(X_t)$$. In terms of our game, at each time it's the most you can
hope to walk away with from here on out, and the optimal strategy is just to wait until $$X_t$$ meets it. In the finite-horizon setting we built it directly by backwards induction. In the infinite-horizon setting we recovered the same recursion as a limit but paid for it with a regularity condition.

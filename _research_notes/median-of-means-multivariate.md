---
layout: note
title: "Median-of-Means for Multivariate Distributions"
description: "Analysis of the median-of-means estimator for multivariate distributions" 
status: published
date: "2023-05-18"
---

$$
\newcommand{\ov}[1]{\overline{#1}}
\newcommand{\X}{\mathcal{X}}
\DeclareMathOperator*{\argmin}{\text{argmin}}
\newcommand{\rad}{\text{rad}}
\renewcommand{\Re}{\mathbb{R}}
\renewcommand{\leq}{\leqslant}
\renewcommand{\geq}{\geqslant}
\newcommand{\ind}{\mathbf{1}}
\newcommand{\eps}{\epsilon}
\renewcommand{\subset}{\subseteq}
\renewcommand{\Pr}{\mathbb{P}}
\newcommand{\bin}{\text{Bin}}
\newcommand{\Var}{\mathbb{V}}
\newcommand{\cP}{\mathcal{P}}
\newcommand{\E}{\mathbb{E}}
\newcommand{\hmu}{\widehat{\mu}}
\newcommand{\mom}{\text{MoM}}
\newcommand{\median}{\text{median}}
\newcommand{\spn}{\text{span}}
\newcommand{\norm}[1]{\|#1\|}
\newcommand{\tr}{\text{tr}}
\newcommand{\C}{\mathscr{C}}
\newcommand{\la}{\langle}
\newcommand{\ra}{\rangle}
$$

- TOC 
{:toc}

We're back to median-of-means (MoM) estimators, but this time we'll consider multivariate distributions. We'll follow the recent(ish) paper of [Lugosi and Mendelson](https://arxiv.org/abs/1702.00482) which introduces a sub-Gaussian MoM estimator for high dimensions. 
Assume that $$X_1,\dots,X_n$$ lie in $$\Re^d$$ and are distributed according to some distribution $$P$$ with mean $$\mu$$ and covariance matrix $$\Sigma$$. Before extending the [univariate MoM estimator]({% link _research_notes/median-of-means-univariate.md %}) to this setting, we need to clarify what sub-Gaussian performance means in higher dimensions. To do so, we appeal (like we did for $$d=1$$) to the performance of the sample mean for light-tailed distributions. Throughout, we'll use $$\norm{\cdot}$$ to refer to the $$\ell_2$$-norm $$\norm{\cdot}_2$$. 

# 1. Performance of sample mean

Let $$\ov{X} = \sum_{i\leq n} X_i/n$$ where $$X_i \sim N(\mu,\Sigma)$$. Note that by independence, $$\ov{X}\sim N(\mu,\Sigma/n)$$, so $$\ov{X}-\mu\sim N(0,\Sigma/n)$$. Therefore, 

$$
\begin{equation}
\label{eq:gauss1}
    \Pr(\|\ov{X} - \mu\| \geq \E\|\ov{X} - \mu\| + u) \leq \Pr( \|Z\| \geq \E\|Z\|+u\sqrt{n}), \tag{1}
\end{equation}
$$

where $$Z\sim N(0,\Sigma)$$. The multivariate Gaussian concentration inequality (e.g., [here](https://link.springer.com/chapter/10.1007/bfb0077482)) gives

$$
\begin{equation}
\label{eq:gauss_tail_bound}
    \Pr( \|Z\| \geq \E\|Z\|+u\sqrt{n}) \leq \exp(-\frac{nt^2}{2\lambda_{\max}}).\tag{2}
\end{equation}
$$

Also, note that,  $$\E\|\ov{X} - \mu\|^2 = \frac{1}{n}\sum_i \E(\ov{X}_i - \mu_i)^2 = \tr(\Sigma)/n$$. Therefore, by Jensen's inequality, $$\E\|\ov{X}-\mu\|\leq \sqrt{\tr(\Sigma)/n}$$. 
Combining this fact with \eqref{eq:gauss1} and \eqref{eq:gauss_tail_bound} and solving the right hand side of \eqref{eq:gauss_tail_bound} for $$\delta$$ gives

$$
\begin{equation*}
    \Pr(\|\ov{X}-\mu\| \geq \delta) \leq \sqrt{\frac{\tr(\Sigma)}{n}} + \sqrt{\frac{2\lambda_{\max}(\Sigma)\log(1/\delta)}{n}}.
\end{equation*}
$$

This will be our standard for estimators going forward. 
In particular, we will say that an estimator $$\hmu$$ of $$\mu$$ is sub-Gaussian with respect to $$\norm{\cdot}$$ if, with probability $$1-\delta$$,  

$$
\begin{equation}
\label{eq:subgaussian-multivariate}
    \norm{\hmu - \mu} \lesssim \sqrt{\frac{\tr(\Sigma)}{n}} + \sqrt{\frac{\lambda_{\max}(\Sigma)\log(1/\delta)}{n}}, \tag{3}
\end{equation}
$$

where $$\lambda_{\max}(\Sigma)$$ is the maximum eigenvalue of $$\Sigma$$. Notice that the dimension makes no appearance in \eqref{eq:subgaussian-multivariate}. It's also worth emphasizing that the second term is multiplied by $$\lambda_{\max}(\Sigma)$$ instead of $$\tr(\Sigma)$$. This is a big distinction in situations where all eigenvalues are roughly the same order, in which case $$\tr(\Sigma)$$ might be order $$d$$ and $$\tr(\Sigma)\log(1/\delta)\gg \lambda_{\max}(\Sigma)\log(1/\delta)$$.  

# 2. Coordinate-wise median

The first thing one would probably try is a naive reduction from the multivariate case to the univariate case. In particular, consider constructing the univariate MoM estimator for each coordinate of the samples separately. That is, $$\hmu_i$$ will be the $$\hmu^\mom$$ constructed on $$\Pi_i(X_1),\dots,\Pi_i(X_n)$$, where $$\Pi_i$$ is the projection from $$\Re^d$$ onto $$\spn(e_i)$$. 

To analyze this estimator, we simply apply a union bound to the event that the estimator for each coordinate does "well". More precisely, let $$E_i$$ be the event

$$E_i = \bigg\{ |\hmu^\mom_i - \mu_i| \leq \sigma_i \bigg(\frac{32\log(d/\delta)}{n}\bigg)^{1/2}\bigg\},$$

where $$\sigma_i = \Var(\Pi_i(X)) = \Var_{(X_1,\dots,X_n)\sim P}[X_i]$$. 
Using the bound from the univariate case, conditional on the event $$\cap E_i$$ (i.e., all $$E_i$$'s occur), 

$$
\begin{equation*}
    \norm{\hmu - \mu}_2^2 = \sum_{i\leq n}|\hmu^\mom_i - \mu|^2 \leq \frac{32\log(d/\delta)}{n}\sum_{i\leq n}\sigma_i^2 =  \frac{32\log(d/\delta)\tr(\Sigma)}{n}. 
\end{equation*}
$$

Moreover, the probability that all $$E_i$$ occur simultaneously is $$\Pr(\cap E_i) = 1 - \Pr(\cup E_i^c) \geq 1 - \delta$$. We've obtained the following bound for this estimator:  For $$k\in\mathbb{N}$$ and $$\delta>0$$ such that $$k$$ divides $$n$$ and $$k=\lceil 8\log(1/\delta)\rceil$$, 

$$
\begin{equation}
    \Pr\bigg\{\norm{\hmu -\mu}_2 \leq \bigg(\frac{32\log(d/\delta)\tr(\Sigma)}{n}\bigg)^{1/2}\bigg\}\geq 1-\delta.
\end{equation} 
$$


Thus, we see that the coordinate-wise median does not result in sub-Gaussian performance. We must therefore turn to another strategy.  


# 3. A new notion of median

Here we discuss an altogether different notion of median, originally proposed by [Lugosi and Mendelson](https://arxiv.org/abs/1702.00482). To introduce it, let us consider an alternative way to frame the median in $$\Re$$. Let $$\{s_1,\dots,s_k\}\in\Re$$. Consider the order statistics $$s_{(1)},\dots,s_{(k)}$$ and assume for simplicity that $$k$$ is even so the median is $$a = (s_{(k/2)} + s_{(k/2 + 1)})/2$$. Let $$p= a+\eps$$ for some $$\eps>0$$. What makes $$p$$ a "worse" choice of median than $$a$$? Indeed, for small enough $$\eps$$, $$p$$ still has $$k/2$$ points to either side of it (if picturing the points on a horizontal axis). In some sense, then, it still accomplishes what we expect of a median. 

One way to formalize why $$a$$ is a better median than $$p$$ is to notice that $$p$$ breaks symmetry in rather unappealing ways. For a point $$z\in \Re$$, let $$\C(z)$$ be the set of points which are as close or closer to $$k/2$$ of the points $$s_1,\dots,s_k$$ as $$z$$. Intuitively, $$\C(z)$$ is the set of points which are possibly better medians than $$z$$. It is easy to see that $$\C(a)= [s_{(k/2)} - d(s_{(k/2)},a), s_{(k/2+1)} + d(s_{(k/2+1)},a)]$$ and, for sufficiently small $$\eps$$, $$\C(p)= [s_{(k/2)} - d(s_{(k/2)},a+\eps), s_{(k/2+1)} + d(s_{(k/2+1)},a+\eps)]$$. For $$\eps>0$$ and the Euclidean metric, $$d(s_{(k/2)},a+\eps) = d(s_{(k/2)},p) + \eps$$. Thus, the radius of $$\C(p)$$, defined as $$\sup_{y\in \C(p)} d(p,y)$$ is equal to $$2\eps$$ plus the radius of $$\C(a)$$. In fact, while the precise arithmetic in this example works only for small $$\eps$$, it remains true that $$\C(a)$$ has minimal radius among all points. 

The benefit of framing the median as such is that it extends to arbitrary dimensions (indeed, to any metric space). For a metric space $$(\X,d)$$ and $$S=\{s_1,\dots,s_k\}$$, define 

$$
\begin{equation}
\label{eq:multi_median}
    \median(s_1,\dots,s_k) = \argmin_{a\in \X} \rad(\C_S(a)), \tag{4}
\end{equation}
$$

where $$\rad(\C_S(a)) = \sup_{y} d(a,y)$$ and 

$$
\begin{equation}
    \C_S(a) = \big\{x\in\X: \exists J\subset[k] \text{ with }|J|\geq k/2\text{ s.t. } d(s_j,x) \leq d(s_j,a)\text{ for all }j\in [J]\big\}.
\end{equation}
$$

This motivates the following median-of-means estimator for $$\X=\Re^d$$. As in the univariate case, we are presented with $$X_1,\dots,X_n\in\Re^d$$. We form $$k$$ groups $$G_1,\dots,G_k$$ for some $$k$$ which divides $$n$$, compute the sample mean within each group, and then take the median  in accordance with \eqref{eq:multi_median}: 

$$
\begin{equation}
\label{eq:mom_multivariate}
  \hmu^\mom = \argmin_{a\in\Re^d} \rad(\C_{\{S_1,\dots,S_k\}}(a)),\quad\text{where}\quad S_i = \frac{1}{|G_i|}\sum_{k\in G_i}X_i.  \tag{5}
\end{equation}
$$

Now we analyze the performance of this estimator. Set 

$$
\begin{equation}
    r := \max\bigg\{960\sqrt{\frac{\tr(\Sigma)}{n}}, 240\sqrt{\frac{\lambda_{\max}\log(2/\delta)}{n}}\bigg\},
\end{equation}
$$

where again, $$\lambda_{\max}$$ is the maximum eigenvalue of $$\Sigma$$. 


# 4. Proof of sub-Gaussian performance

The proof relies on a technique dubbed "median-of-mean tournaments," whereby we compare successive pairs of points and argue about which points are closer to the point cloud $$S_1,\dots,S_k$$ (the group means) on average. Let us introduce the following notation which will be helpful in the analysis. 
For $$a\in \Re^d$$, let 

$$\ell_g(a) := \frac{1}{|S_g|} \sum_{i\in S_g}\|a - X_i\|_2^2,$$

denote the mean distance of $$a$$ from the all points in $$S_g$$. Observe the following relationship: 

$$
\begin{align}
    \ell_g(a)- \ell_g(b) &= \norm{a-b}_2^2 - \frac{2}{|S_g|}\sum_{i\in S_g}\la X_i-b,a-b\ra  \\
    &= \norm{a-b}_2^2 -2 \la S_g - b,a-b\ra = \norm{S_g - a}_2^2 - \norm{S_g -b}_2^2.\label{eq:la-lb} \tag{6}
\end{align}
$$

We introduce a partial ordering among vectors in $$\Re^d$$ by writing 

$$a <_S b \quad\text{iff}\quad \ell_g(a) < \ell_g(b)\text{ for a majority of }g\in[k].$$

Clearly, if $$a<_S b$$, then $$a\in \C_S(b)$$. 
If $$a<_S b$$, we will say that $$a$$ _beats_ $$b$$. Intuitively, this should be taken to mean that $$a$$ is better candidate for the median than $$b$$. The following claim constitutes the core of the proof. It says that, with high probability, all points $$b$$ that are sufficiently far from the mean $$\mu$$ will be beaten by $$\mu$$. Thus, they will not be contenders for the median. We emphasize that the probability statement in this result is _uniform_ over $$b$$. That is, it holds simultaneously for all such vectors.  

_Claim_: With probability at least $$1-\delta$$, $$\mu <_S b$$ for all $$b\in\Re^d$$ such that $$\norm{\mu - b}\geq r$$. 


Before proving this, let us first note how it implies the main result. Combined with \eqref{eq:la-lb}, it implies that with probability $$1-\delta$$, if $$\norm{\mu-b}\geq r$$, then $$\norm{S_g -\mu} < \norm{S_g - b}$$ on a majority of $$g$$. Conditioning on this event, if $$\norm{\mu-b}>r$$, then $$b\notin \C_S(\mu)$$, so $$\rad \C_S(\mu)\leq r$$. And since $$\hmu^\mom$$ is chosen to minimize this radius, we have $$\rad\C_S(\hmu^\mom)\leq \rad\C_S(\mu)\leq r$$. Finally, since either $$\mu \in \C_S(\hmu^\mom)$$ or $$\hmu\in \C_S(\hmu^\mom)$$ (because $$\C_S(a) \cup \C_S(a)^c=\Re^d$$), this implies that $$\hmu$$ and $$\mu$$ are distance at most $$r$$ apart. 


So, it remains only to prove the claim. The proof is quite technical, and many of the details are not terribly illuminating, so we'll provide only a sketch here. The proof follows a so-called "small ball" strategy, the high-level steps of which are as follows. (i) First, a high probability bound is obtained for an arbitrary $$b$$ with $$\norm{\mu-b}\geq r$$. (ii) A union bound is then taken over a finite, well-chosen collection of points. In particular, we choose the points to be an $$\eps$$-packing over $$r S^{d-1}$$ in a suitable metric. (iii) We then show that points near the points of the $$\eps$$-packing retain the desired behavior (that is, the bound is immune to small perturbations).  

We'll outline the steps in more detail, but first let us rewrite our objective. 
Fix $$b\in\Re^d$$ with $$\norm{\mu-b}\geq r$$. We have via \eqref{eq:la-lb} that $$\mu<_S b$$ if $$0< \ell_g(b) - \ell_g(\mu) = \norm{\mu - b}^2 - \frac{2}{m}\sum_{i\in S_g}\la X_i-\mu,b-\mu\ra$$. That is, $$\mu<_S b$$ if 

$$
\begin{equation}
\label{eq:desired}
    2\la S_g - \mu, v\ra \leq \norm{v}_2^2 \quad\text{where}\quad v = b-\mu.\tag{7}
\end{equation}
$$

It thus suffices to show that with high probability, the above inequality holds simultaneously for all vectors $$v$$ with $$\norm{v}_2^2=r$$. 

## Step 1: High probability bound for single vector
Since $$S_g-\mu$$ is the average of centered random variables, Chebyschev's inequality  gives 

$$
\begin{align}
    \Pr(\vert\la S_g-\mu,v\ra\vert \geq t) &\leq \frac{\Var(\la S_g-\mu,v\ra)}{t^2} = \frac{\E\la X-\mu,v\ra^2}{mt^2}  \\
    &\leq \frac{\norm{v}_2^2\E\norm{X-\mu}_2^2}{mt^2}\leq \frac{\norm{v}_2^2\lambda_{\max}}{mt^2},
\end{align}
$$

where we recall that $$m=|S_g|$$. 
Setting the right hand side equal to 1/10 gives that with probability at least 9/10, 

$$ \vert\la S_g-\mu,v\ra\vert \leq \norm{v}\sqrt{10 \lambda_{\max}/m}=r\sqrt{10\lambda_{\max}/m}.$$

Note that $$r\geq 4\sqrt{10\lambda_{\max}/m}$$, so the above implies $$\vert\la S_g-\mu,v\ra\vert\leq r^2/4$$. 
Applying Hoeffding's inequality on the above event across all $$g$$, we conclude that with probability at least $$1 - e^{-k/50}$$, $$\vert\la S_g-\mu,v\ra\vert \leq r^2/4$$ for at least $$8k/10$$ of the groups $$g$$. This gives us the desired high probability bound for a fixed $$v$$. 

## Step 2: Extend to $$\epsilon$$-packing 
Now we want to apply this bound to a well-selected group of vectors $$v$$ with norm $$r$$. Let $$S^{d-1}(r)$$ denote the $$d$$-sphere $$\{x\in\Re^d:\norm{x}_2=r\}$$. We consider an $$\eps$$-packing of $$S^{d-1}(r)$$ in the norm $$\norm{\cdot}_\Sigma$$ defined by the covariance matrix. More specifically, we choose a finite set of points of maximum cardinality $$V_1 = \{v_1,\dots,v_L\}$$ such that $$\norm{v_i-v_j}_\Sigma = \la \Sigma^{1/2}(v_i-v_j),\Sigma^{1/2}(v_i-v_j)\ra^{1/2}\geq \eps$$ for all $$i,j\in[L]$$. The size of $$V_1$$, $$L$$, can be estimated via the so-called [dual Sudakov inequality](https://www.math.uci.edu/~rvershyn/papers/GFA-book.pdf), which tells us that, if $$G$$ is a standard Gaussian,  

$$
\begin{equation}
    \log(L) \leq \log(2) + \frac{1}{32}\bigg(\frac{\E\la G,\Sigma G\ra^{1/2}}{\eps/r}\bigg)^2 \leq \log(2) + \frac{1}{32}\bigg(\frac{\sqrt{\tr(\Sigma)}}{\eps/r}\bigg)^2.
\end{equation}
$$

Taking $$\eps = 2r\sqrt{\tr(\Sigma)/k}$$ gives $$L\leq 2\exp(k/100)$$. Thus, employing a union bound over the result in step 1, we obtain that $$\vert\la S_g-\mu,v\ra\vert\leq r^2/4$$ on $$8k/10$$ groups for each $$v\in V$$ with probability $$ 1- L\exp(-k/50)\geq 1 - 2\exp(-k/100)$$. 

## Step 3: Uniform bound by deviation analysis
Step 2 provided a high probability guarantee simultaneously over a maximal $$\eps$$-packing of $$S^{d-1}(r)$$. Now we want to extend this guarantee simultaneously to all $$v\in S^{d-1}(r)$$. For any $$x\in \Re^d$$, let $$v_x$$ denote the point in $$V_1$$ closest to $$x$$. Suppose we could show that with probability at least $$1- \exp(-k/200)$$, 

$$
\begin{equation}
\label{eq:supx}
    \sup_{x\in S^{d-1}(r)} \frac{1}{k}\sum_{g\leq k}\ind\bigg\{ \big|\la S_g-\mu,v-v_x\ra\big| \geq \frac{r^2}{4} \bigg\}\leq \frac{1}{10}. \tag{8}
\end{equation}
$$

This would imply that for each $$x$$, $$\vert\la S_g - \mu,v-v_x\ra \vert\leq r^2/4$$ for $$9k/10$$ groups  $$g$$. Taking a union bound with the result in Step 2 (applying it to $$v_x$$), we obtain that in at least $$7k/10$$ groups $$g$$, we have both 

$$
\begin{equation}
\label{eq:step3_2conds}
  \vert\la S_g - \mu,v_x\ra\vert \leq r^2/4,\quad\text{and}\quad \vert\la S_g - \mu,v\ra -\la S_g-\mu,v_x\ra\vert\ra \leq r^2/4.  \tag{9}
\end{equation}
$$

This occurs with probability at least $$1 - (2\exp(-k/200) + \exp(-k/100))\geq 1 - \delta$$ since $$k \geq 200 \log(2/\delta)$$. Note that the $$7k/10$$ ratio comes from the fact that the first event holds on $$8k/10$$ groups and the second on $$9k/10$$ groups. The intersection must be at least $$7k/10$$ groups by the pigeonhole principle. 

The conditions in \eqref{eq:step3_2conds} imply that 

$$\la S_g-\mu,v\ra\leq  \la S_g-\mu,v_x\ra + \frac{r^2}{4}\leq \frac{r^2}{4}+\frac{r^2}{4} = \frac{r^2}{2},$$

which is \eqref{eq:desired}, i.e., the desired inequality. Therefore, it remains only to prove \eqref{eq:supx}. To do so, let $$W$$ be the random variable on the left hand side of \eqref{eq:supx}. The main idea is to argue about its expected value and show that $$\E W\leq 1/20$$. Then, since $$W$$ is an average of indicators, we can employ the bounded differences inequality to obtain that 
$$W \leq \E W + 1/20\leq 1/10$$ with probability at least $$1-\exp(-k/200)$$, which is the desired result. To bound $$\E W$$, we first notice that $$\ind\{ \la S_g-\mu,v-v_x\ra|\geq r^2/4\}\leq \frac{4}{r^2}|\la S_g-\mu,v-v_x\ra|$$ (by simple case analysis). Therefore, letting $$\ov{S}_g = S_g-\mu$$ and $$\ov{v}=v-v_x$$, 

$$
\begin{align*}
    \E W &\leq \E\sup_{x\in S^{d-1}(r)} \frac{4}{kr^2} \sum_{g\leq k} |\la \ov{S}_g,\ov{v}\ra | \\
    &= \E\sup_{x\in S^{d-1}(r)} \bigg\{ \frac{4}{kr^2} \sum_{g\leq k} (|\la \ov{S}_g,\ov{v}\ra | - \E|\la \ov{S},\ov{v}\ra|) + \frac{4}{r^2}\E|\la \ov{S},\ov{v}\ra|\bigg\}, 
\end{align*}
$$

where $$\ov{S}$$ is distributed as some arbitrary $$\ov{S}_g$$ (which have the same distribution for all $$g$$). Then, by independence, 

$$
\begin{align*}
    \E|\la \ov{S},\ov{v}\ra| \leq \sqrt{\E\la \ov{S},\ov{v}\ra^2} = \sqrt{\frac{\E\la X-\mu,v-v_x\ra^2}{m}} \leq   \frac{\eps}{\sqrt{m}},
\end{align*}
$$

where the last line follows by definition of the metric chosen for the $$\eps$$-packing: 

$$\norm{v-v_x}_\Sigma = \sqrt{ \E\la X-\mu,v-v_x\ra^2}\leq \eps.$$

Hence, 

$$
\begin{equation}
\label{eq:EW}
  \E W \leq \E\sup_{x\in S^{d-1}(r)} \bigg\{ \frac{4}{kr^2} \sum_{g\leq k} (|\la \ov{S}_g,\ov{v}\ra | - \E|\la \ov{S},\ov{v}\ra|)\bigg\} + \frac{4\eps}{r^2\sqrt{m}}.  \tag{10}
\end{equation}
$$

By choice of $$\eps$$ in Step 2 and the definition of $$r$$, the quantity $$4\eps/(r^2\sqrt{m})$$ is at most $$1/60$$. Meanwhile, the other quantity on the right hand side of \eqref{eq:EW} can be handled by various techniques from empirical process theory (common when analyzing Rademacher complexities, for instance). In particular, using symmetrization and contraction arguments, we obtain that this quantity is bounded by $$1/30$$. Thus, $$\E W \leq 1/20$$, completing the proof. 


# 5. Computing the median

Finally, given the expression for $$\hmu^\mom$$ in \eqref{eq:mom_multivariate}, a natural question is whether it can be efficiently computed. It certainly looks intractable. And indeed, the first results concerning this estimator were purely theoretical and did not investigate how it might be computed. However, shortly after these initial results were published, Sam Hopkins [demonstrated](https://arxiv.org/abs/1809.07425) that \eqref{eq:mom_multivariate} can be approximated in polynomial time and, moreover, that this approximation maintains a sub-Gaussian rate. 
His approach uses semi-definite programming and can be computed in time $$O(nd + d\log(1/\delta)^c)$$, where $$c$$ is some (dimension-agnostic) constant. 
Consequently, everything we've discussed here is not only  mathematically powerful, but is also useful in practice.   


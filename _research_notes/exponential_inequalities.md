---
layout: note
date: "2023-08-23"
title: "A Table of Exponential Inequalities"
description: "A list of exponential inequalities that underlie useful concentration inequalities"
status: published
---

$$
\renewcommand{\Pr}{\mathbb{P}}
\newcommand{\E}{\mathbb{E}}
\renewcommand{\Re}{\mathbb{R}}
\newcommand{\Xbar}{\overline{X}}
\newcommand{\Var}{\mathbb{V}}
$$

I forget useful exponential inequalities all the time and I'm sick of looking them up. I considered writing a big list of _concentration_ inequalities, but then I realized that most of the time what I really wanted was the thing underlying the concentration inequality, which is typically some sort of exponential inequality. Plus, I do a lot of work with martingales, and writing things out like I've done here makes obvious the resulting supermartingale. So here we are.

Are there papers that do this more formally and completely? Yes, e.g., [this one](https://arxiv.org/pdf/1808.03204.pdf). But I needed something for myself that was easy and interpretable. (Pf) stands for proof and will jump you to the proof of the given inequality. If I've omitted your favorite inequality let me know.

Throughout, let $$X$$ be a random variable with mean $$\mu$$. Set $$\Xbar=X-\mu$$, $$\psi(x)=e^x-x-1$$, and $$\psi_E(x)=-\log(1-x)-x$$. Bounds involving $$H$$ or $$c$$ assume those constants are positive.

| Name | Condition | Bound |
| --- | --- | --- |
| Sub-Gaussian [(Pf)](#proof-of-sub-gaussian-and-hoeffding) | $$\Xbar$$ is $$\sigma$$-sub-Gaussian | $$\forall\lambda\in\Re\quad \E\exp\{\lambda\Xbar-\lambda^2\sigma^2/2\}\leq1$$ |
| Hoeffding [(Pf)](#proof-of-sub-gaussian-and-hoeffding) | $$X\in[a,b]$$ | $$\forall\lambda\in\Re\quad \E\exp\{\lambda\Xbar-\lambda^2(b-a)^2/8\}\leq1$$ |
| Bounded/Bernoulli [(Pf)](#proof-of-boundedbernoulli) | $$X\in[0,1]$$ | $$\forall\lambda\in\Re\quad \E\exp\{\lambda\Xbar\}\leq (1-\mu)e^{-\lambda\mu}+\mu e^{\lambda(1-\mu)}$$ |
| Cumulant normalization [(Pf)](#proof-of-cumulant-normalization) | $$\lambda\in\Re$$ and $$\E e^{\lambda X}<\infty$$ | $$\E\exp\{\lambda X-\log\E e^{\lambda X}\}=1$$ |
| Bennett [(Pf)](#proof-of-bennett) | $$\Xbar\leq H$$ and $$\Var(X)\leq v^2<\infty$$ | $$\forall\lambda\geq0\quad \E\exp\{\lambda\Xbar-(v^2/H^2)\psi(\lambda H)\}\leq1$$ |
| Bernstein moment condition [(Pf)](#proof-of-bernstein-moment-condition) | $$\E\lvert\Xbar\rvert^k\leq(k!/2)v^2c^{k-2}$$ for $$k=2,3,\ldots$$ | $$\forall\,\lvert\lambda\rvert<1/c\quad \E\exp\{\lambda\Xbar-v^2\lambda^2/[2(1-c\lvert\lambda\rvert)]\}\leq1$$ |
| One-sided Bernstein I [(Pf)](#proof-of-one-sided-bernstein-i) | $$\Xbar\leq H$$ and $$\Var(X)<\infty$$ | $$\forall\lambda\in[0,1/H]\quad \E\exp\{\lambda\Xbar-(e-2)\lambda^2\Var(X)\}\leq1$$ |
| One-sided Bernstein II [(Pf)](#proof-of-one-sided-bernstein-ii) | $$X\geq0$$ and $$\E[X^2]<\infty$$ | $$\forall\lambda>0\quad \E\exp\{-\lambda\Xbar-\lambda^2\E[X^2]/2\}\leq1$$ |
| Delyon [(Pf)](#proof-of-delyon) | $$\E[X^2]<\infty$$ | $$\forall\lambda\in\Re\quad \E\exp\{\lambda\Xbar-(\lambda^2/6)(\Xbar^2+2\E[\Xbar^2])\}\leq1$$ |
| Symmetry [(Pf)](#proof-of-symmetry) | $$X\overset{d}{=}-X$$ | $$\forall\lambda\in\Re\quad \E\exp\{\lambda X-\lambda^2X^2/2\}\leq1$$ |
| Fan [(Pf)](#proof-of-fan) | $$X\geq-1$$ and $$\E[X]\leq0$$ | $$\forall\lambda\in[0,1)\quad \E\exp\{\lambda X+X^2(\log(1-\lambda)+\lambda)\}\leq1$$ |
| Modified Howard [(Pf)](#proof-of-modified-howard) | $$X\in[0,1]$$ and fixed $$A\in(0,1)$$ | $$\forall\lambda\in[-1,1]\quad \E\exp\{\lambda\Xbar-\lambda^2\psi_E(\lvert X-A\rvert)\}\leq1$$ |
| Catoni [(Pf)](#proof-of-catoni) | $$\E\lvert\Xbar\rvert^p<\infty$$, $$p>1$$ | $$\forall\lambda\in\Re\quad \E\exp\{\phi_p(\lambda\Xbar)-(\lvert\lambda\rvert^p/p)\E\lvert\Xbar\rvert^p\}\leq1$$, where $$\phi_p(x)\leq\log(1+x+\lvert x\rvert^p/p)$$ |
{: style="font-size: 0.82rem;"}


## Proof of sub-Gaussian and Hoeffding

By definition, $$\Xbar$$ is $$\sigma$$-sub-Gaussian if

$$
\E e^{\lambda\Xbar}\leq e^{\lambda^2\sigma^2/2},\qquad \lambda\in\Re.
$$

Rearranging gives the sub-Gaussian entry. Hoeffding's lemma says that if $$X\in[a,b]$$, then $$\Xbar$$ is $$(b-a)/2$$-sub-Gaussian. Substituting $$\sigma=(b-a)/2$$ and rearranging gives the result.


## Proof of bounded/Bernoulli

For every $$x\in[0,1]$$ we have $$e^{\lambda x}\leq(1-x)+xe^\lambda$$. Taking expectations gives $$\E e^{\lambda X}\leq1-\mu+\mu e^\lambda$$ and multiplying by $$e^{-\lambda\mu}$$ yields

$$
\E e^{\lambda\Xbar}\leq(1-\mu)e^{-\lambda\mu}+\mu e^{\lambda(1-\mu)}.
$$

The bound is exact when $$X$$ is Bernoulli with mean $$\mu$$.

## Proof of cumulant normalization

For every $$\lambda$$ at which the moment generating function is finite, just calculate:

$$
\E\exp\{\lambda X-\log\E e^{\lambda X}\}=\frac{\E e^{\lambda X}}{\E e^{\lambda X}}=1.
$$

## Proof of Bennett

The function

$$
g(x)=\begin{cases}
\psi(x)/x^2,&x\neq0,\\
1/2,&x=0
\end{cases}
=\int_0^1(1-t)e^{tx}\,dt
$$

is increasing, since $$g'(x)=\int_0^1t(1-t)e^{tx}dt>0$$. For $$\lambda\geq0$$ and $$\Xbar\leq H$$, this gives

$$
\psi(\lambda\Xbar)
=\lambda^2\Xbar^2g(\lambda\Xbar)
\leq\frac{\Xbar^2}{H^2}\psi(\lambda H).
$$

Consequently,

$$
\begin{aligned}
\E e^{\lambda\Xbar} &=1+\lambda\E\Xbar+\E\psi(\lambda\Xbar)
\leq1+\frac{\E[\Xbar^2]}{H^2}\psi(\lambda H)
\leq\exp\left\{\frac{v^2}{H^2}\psi(\lambda H)\right\}.
\end{aligned}
$$

Rearranging proves the claim.

## Proof of Bernstein moment condition

For $$\lvert\lambda\rvert<1/c$$, the moment condition gives

$$
\sum_{k=2}^{\infty}\frac{\lvert\lambda\rvert^k\E\lvert\Xbar\rvert^k}{k!}
\leq\frac{v^2\lambda^2}{2}\sum_{k=2}^{\infty}(\lvert\lambda\rvert c)^{k-2}
<\infty.
$$

We may therefore expand the exponential and interchange expectation and summation. Using $$\E\Xbar=0$$,

$$
\begin{aligned}
\E e^{\lambda\Xbar}
&=1+\sum_{k=2}^{\infty}\frac{\lambda^k\E[\Xbar^k]}{k!}
\leq1+\sum_{k=2}^{\infty}\frac{\lvert\lambda\rvert^k\E\lvert\Xbar\rvert^k}{k!}\\
&\leq1+\frac{v^2\lambda^2}{2}\sum_{k=2}^{\infty}(\lvert\lambda\rvert c)^{k-2}
=1+\frac{v^2\lambda^2}{2(1-c\lvert\lambda\rvert)}
\leq\exp\left\{\frac{v^2\lambda^2}{2(1-c\lvert\lambda\rvert)}\right\}.
\end{aligned}
$$

Rearranging gives the result.

## Proof of one-sided Bernstein I

The inequality $$e^x\leq1+x+(e-2)x^2$$ holds for every $$x\leq1$$. If $$\lambda\in[0,1/H]$$, then $$\lambda\Xbar\leq1$$, and hence

$$
\begin{aligned}
\E e^{\lambda\Xbar}
&\leq1+\lambda\E\Xbar+(e-2)\lambda^2\E[\Xbar^2]\\
&=1+(e-2)\lambda^2\Var(X)\\
&\leq\exp\{(e-2)\lambda^2\Var(X)\}.
\end{aligned}
$$

Rearranging gives the result.

## Proof of one-sided Bernstein II

Put $$Z=-X$$. Since $$Z\leq0$$ and $$e^s\leq1+s+s^2/2$$ for $$s\leq0,$$ we have, for $$\lambda>0$$,

$$
\E e^{\lambda Z}\leq1+\lambda\E Z+\frac{\lambda^2}{2}\E[Z^2]
\leq\exp\left\{\lambda\E Z+\frac{\lambda^2}{2}\E[Z^2]\right\}.
$$

Since $$Z=-X$$ and $$\E Z=-\mu$$,

$$
\E e^{-\lambda\Xbar}=e^{\lambda\mu}\E e^{-\lambda X}
\leq e^{\lambda^2\E[X^2]/2}.
$$

Rearrange.

## Proof of Delyon

Delyon (2009) shows that, for every $$x\in\Re$$, $$e^{x-x^2/6}\leq1+x+x^2/3.$$ Taking $$x=\lambda\Xbar$$ and then expectations gives

$$
\begin{aligned}
\E\exp\{\lambda\Xbar-\lambda^2\Xbar^2/6\}
&\leq1+\lambda\E\Xbar+\frac{\lambda^2}{3}\E[\Xbar^2]\leq\exp\left\{\frac{\lambda^2}{3}\E[\Xbar^2]\right\}.
\end{aligned}
$$

Multiplying by $$\exp\{-\lambda^2\E[\Xbar^2]/3\}$$ gives the result.

## Proof of symmetry

Since $$X\overset{d}{=}-X$$,

$$
\begin{aligned}
\E\exp\{\lambda X-\lambda^2X^2/2\}&=\E\left[e^{-\lambda^2X^2/2}\cosh(\lambda X)\right]\leq1,
\end{aligned}
$$

where the final step uses $$\cosh(x)\leq e^{x^2/2}$$. Notice that we're using the observed square $$X^2$$, rather than its expectation.

## Proof of Fan

See the original Fan et al. paper [here](https://arxiv.org/pdf/1311.6273.pdf). The function $$f(x)=\frac{\log(1+x)-x}{x^2/2}$$ is non-decreasing for $$x>-1$$, after continuously extending it at zero. The result is immediate when $$\lambda=0$$. For $$0<\lambda<1$$, the assumption $$X\geq-1$$ gives $$\lambda X\geq-\lambda>-1$$. Thus

$$
\begin{aligned}
\log(1+\lambda X)-\lambda X
&=\frac{\lambda^2X^2}{2}f(\lambda X)
\geq\frac{\lambda^2X^2}{2}f(-\lambda)=X^2(\log(1-\lambda)+\lambda).
\end{aligned}
$$

Equivalently,

$$
\lambda X+X^2(\log(1-\lambda)+\lambda)
\leq\log(1+\lambda X).
$$

Exponentiating and taking expectations gives

$$
\E\exp\{\lambda X+X^2(\log(1-\lambda)+\lambda)\}
\leq\E[1+\lambda X]\leq1.
$$

## Proof of Modified Howard

This inequality is from [Chugg and Ramdas (2025)](https://arxiv.org/pdf/2512.21300). We first extend Fan's pointwise inequality to signed arguments: for $$a\in(-1,1)$$ and $$b\in[-1,1]$$,

$$
\exp\{ab-\psi_E(\lvert a\rvert)b^2\}\leq1+ab.
$$

When $$a\geq0$$ this is Fan's inequality. When $$a<0$$, apply Fan's inequality to $$-a>0$$ and $$-b\geq-1$$.

Now set $$Y=X-\mu$$ and $$\delta=A-\mu$$. Since $$X\in[0,1]$$ and $$A\in(0,1)$$, we have $$X-A=Y-\delta\in(-1,1)$$. Applying the signed inequality with $$a=Y-\delta$$ and $$b=\lambda$$ gives

$$
\exp\{\lambda Y-\lambda^2\psi_E(\lvert X-A\rvert)\}
\leq e^{\delta\lambda}[1+\lambda(Y-\delta)].
$$

Taking expectations and using $$\E Y=0$$,

$$
\E\exp\{\lambda\Xbar-\lambda^2\psi_E(\lvert X-A\rvert)\}
\leq e^{\delta\lambda}(1-\delta\lambda)\leq1,
$$

where the last step uses $$1-z\leq e^{-z}$$.

## Proof of Catoni

Let $$\phi_p:\Re\to\Re$$ be any measurable function such that

$$
\phi_p(x)\leq\log(1+x+\lvert x\rvert^p/p),\qquad x\in\Re.
$$

The quantity inside the logarithm is positive for every $$x\in\Re$$ when $$p>1$$. Therefore

$$
e^{\phi_p(\lambda\Xbar)}
\leq1+\lambda\Xbar+\frac{\lvert\lambda\rvert^p}{p}\lvert\Xbar\rvert^p.
$$

Taking expectations and using $$\E\Xbar=0$$,

$$
\begin{aligned}
\E e^{\phi_p(\lambda\Xbar)}
&\leq1+\frac{\lvert\lambda\rvert^p}{p}\E\lvert\Xbar\rvert^p\leq\exp\left\{\frac{\lvert\lambda\rvert^p}{p}\E\lvert\Xbar\rvert^p\right\}.
\end{aligned}
$$

Rearranging gives the result.

---
layout: note 
date: "2022-06-29" 
title: "Degrees of Freedom and Stein's Estimator"
description: "Minimum risk estimators for normal random vectors: Stein's paradox "
status: published
---

$$
\newcommand{\R}{\mathbb{R}}
\newcommand{\hmu}{\hat{\mu}}
\newcommand{\E}{\mathbb{E}}
\newcommand{\norm}[1]{\vert\vert #1 \vert\vert}
\newcommand{\Var}{\mathbb{V}}
\newcommand{\Cov}{\text{Cov}}
\newcommand{\df}{\text{df}}
\newcommand{\bZ}{\bar{Z}}
$$

- TOC 
{:toc}

Given random vectors $$X_i \sim N(\mu,\sigma^2I)$$, $$i=1,\dots,n$$, for $$\sigma\in\R$$ and $$\mu\in\R^d$$, we want to generate and evaluate an estimate $$\hmu(X)$$ of $$\mu$$. 

The _risk_ of the estimate $$\hmu(X)$$ is defined as its expected MSE: 

$$R(\hmu(X)) \equiv \E\norm{\mu-\hmu(X)}_2^2.$$

The expectation is over randomness in the $$X_i$$ and any randomness in the estimator itself. The notion of risk enables us to develop hierarchies of estimators. We say the estimator $$\hmu_1(X)$$ _dominates_ $$\hmu_2(X)$$ if $$R(\hmu_1(X))\leq R(\hmu_2(X))$$ for all $$\mu\in\R^d$$, and there exists at least one $$\mu$$ such that $$R(\hmu_1(X)) < R(\hmu_2(X))$$, i.e., $$\mu_1$$ is strictly better than $$\mu_2$$. If an estimator $$\hmu$$ is dominated by another, we say it is _inadmissible_. 

We'll often drop the dependence on $$X$$ when it's clear from context. 

There's a general technique to evaluate the risk of an estimator which involves expanding out its expression. Consider a single random vector $$y\sim N(\mu,\sigma^2I)$$

$$
\begin{align}
R(\hmu) &= \E\norm{\mu-y+y-\hmu}_2^2 \\
&= \E\norm{\mu-y}_2^2 + \E\norm{y-\hmu}_2^2 + 2\E(\mu-y)^t(y-\hmu).
\end{align}
$$

The first term is 

$$\frac{1}{\sigma\sqrt{2\pi}}\int_{\R^n}(\mu-y)^t(\mu-y)\exp\bigg(-\frac{1}{2}\bigg(\frac{y-\mu}{\sigma}\bigg)^2\bigg)dy,$$

which is an $$n$$-dimensional second moment and equal to $$n\sigma^2$$ using some [standard identities](https://en.wikipedia.org/wiki/Normal_distribution#Moments). The final term can be expanded as 

$$
\begin{align}
\E(\mu-y)^t(y-\hmu) &= \sum_{i=1}^n \E[\mu_iy_i - \mu_i\hmu_i -y_i^2 + y_i\hmu_i] \\ 
&= \sum_{i=1}^n (\mu_i^2 - \mu_i\E[\hmu_i] -\E[y_i^2] + \E[y_i\hmu_i]) \\ 
&= \sum_{i=1}^n (\Cov(y_i,\hmu_i)-\Var(y_i)) \\
&= \sum_{i=1}^n \Cov(y_i,\hmu_i) - n\sigma^2. 
\end{align}
$$

Therefore, 

$$R(\hmu) = \E\norm{y-\hmu}_2^2 + 2\sum_{i=1}^n \Cov(y_i,\hmu_i) - n\sigma^2.$$

If we view the estimator $$\hmu$$ as a predictive model trained on the samples $$X_i$$, then we can interpret $$\E\norm{y-\hmu}_2^2$$ as the expected mean squared (training) error of the model. The _degrees of freedom_ (see, e.g., [this paper](https://www.stat.cmu.edu/~ryantibs/papers/sdf.pdf)) of this model is the quantity 

$$\df(\hmu) = \frac{1}{\sigma^2}\sum_{i=1}^n \Cov(y_i,\hmu_i).$$

Note that this definition accords fairly well with the standard notion of degrees of freedom, which is roughly the number of parameters depended on by the model $$\hmu$$. If $$\hmu$$ does not use the $$i$$-th component of $$y$$ to form its estimate, the covariance will be zero and the degrees of freedom will decrease. 

Putting this all together, we can write the risk as 

$$
\begin{equation}
\label{eq:risk}
R(\hmu) = \E\norm{y-\hmu}_2^2 + 2\sigma^2 \df(\hmu) - n\sigma^2.\tag{1}
\end{equation}
$$


# 1. Stein's Lemma 

[Stein's lemma](https://en.wikipedia.org/wiki/Stein%27s_lemma) provides a nice way to evaluate the degrees of freedom of an estimator. It says that instead of evaluating the covariance, we can actually just take partial derivates of our estimator. That is, 

$$\frac{1}{\sigma^2}\sum_{i=1}^n \Cov(y_i,\hmu_i) = \sum_{i=1}^n\E\frac{\partial \hmu_i}{\partial x_i}(X).$$

This is rather remarkable, because the right hand side has nothing to do with the actual values we observe from the distribution. We can therefore usually evaluate it much more easily. 

Stated more generally, Stein's lemma says that for a sufficiently smooth function $$f:\R^n\to\R$$, and $$X\sim N(\mu,\sigma^2I)$$, then 

$$\frac{1}{\sigma^2}\Cov(X,f(X)) = \frac{1}{\sigma^2}\E[(X-\mu)f(X)] = \E[\nabla f(X)].$$

Stein's lemma is the second equality; the first simply follows from the definition of covariance. The proof is relatively straightforward after getting past some administrative inconvenience. 

First, we'll assume that $$X$$ is drawn from a standard normal ($$N(0,1)$$). If not, then we can perform the following proof on a rescaled version of $$X$$ (and $$f$$) which will yield the same result. Next, let $$g(x)=\frac{1}{\sqrt{2\pi}}\exp(-\frac{x^2}{2})$$ be the density of the standard normal. Note that $$g'(x) = -xg(x)$$. Finally, fix $$X$$ and put $$f_i(x) = f(x,X_{-i})$$, i.e., the behavior of $$f$$ as a function of the $$i$$-th entry only. Here $$X_{-i} = (X_1,\dots,X_{i-1},X_{i+1},\dots,X_n)$$. We're going to show that 

$$
\begin{equation}
\label{eq:stein}
\E[X_if_i(X_i)|X_{-i}] = \E[\frac{\partial f(X)}{\partial x_i}|X_{-i}], \tag{2}
\end{equation}$$

from which the final result will follow by taking expectations over $$X_{-i}$$. 

Since $$X_i$$ and $$X_{-i}$$ are independent, the expectation on the right hand side of Equation \eqref{eq:stein} is one-dimensional, and we can use the fundamental theorem of calculus and Fubini's theorem to write 

$$
\begin{align}
\E[\frac{\partial f_i(X_i)}{\partial x_i}|X_{-i}] &= \int_{-\infty}^\infty \partial f_i(x)g(x)dx \\ 
&=  -\int_{-\infty}^\infty \partial f_i(x)\int_{-\infty}^x zg(z)dz dx \\
&= \int_{0}^\infty \partial f_i(x)\int_{x}^\infty zg(z)dz dx -\int_{-\infty}^0 \partial f_i(x)\int_{-\infty}^x zg(z)dz dx \\
&= \int_0^\infty zg(z)\int_0^z \partial f_i(x)dxdz - \int_{-\infty}^0 zg(z) \int_{z}^0 \partial f_i(x)dxdz \\ 
&= \int_0^\infty zg(z)(f_i(z)-f_i(0))dz - \int_{-\infty}^0 zg(z)(f_i(0)- f_i(z)) dz \\
&= \int_{-\infty}^\infty zg(z)f_i(z)dz = \E_z[zf_i(z)],
\end{align}
$$

as desired. The last line follows because $$\int_0^\infty zg(z)f_i(0)dz = -\int_{-\infty}^0 zg(z)f_i(0)dz$$. 

As a side note, I've seen it claimed that you can simply use integration by parts and write 

$$\int_{-\infty}^\infty \partial f_i(x)g(x)dx = f_i(x)g(x)\bigg\vert_{-\infty}^\infty - \int_{-\infty}^\infty f_i(x)g'(x)dx.$$

Since, $$g'(x)=-xg(x)$$, this would give the result provided that $$f_i(x)g(x)\bigg\vert_{-\infty}^\infty$$ disappears. Unfortunately, I can't see a way to do this without imposing additional assumptions on $$f$$. While $$g(x)\to0$$ as $$x$$ goes to $$\infty$$ or $$-\infty$$, I don't see why $$f_i(x)$$ couldn't grow quickly enough to offset this. All it would take is super-exponential growth at either end. If you figure this out, please tell me. In the meantime, Fubini it is. 

Anyway, we can now write the risk of an estimator $$\hmu$$ as 

$$
\begin{equation}
\label{eq:stein_risk}
R(\hmu) = \E\norm{y-\hmu}_2^2 + 2\sigma^2 \sum_{i=1}^n \E\frac{\partial \hmu_i(X)}{\partial x_i} - n\sigma^2.\tag{3}
\end{equation}
$$


# 2. Stein's Paradox 

Consider a slight variant of the problem we started with. Now you're given random _variables_ (i.e., not scalars, not vectors) $$X_1,\dots,X_n$$ where $$X_i\sim N(\mu_i,\sigma^2)$$. From this small amount of data (only one observation per distribution!), our task is to estimate $$\mu=(\mu_1,\dots,\mu_n)$$. 

An obvious estimate is to take $$\hmu(X)=X$$. In this case, $$\partial \hmu_i/\partial X_i=1$$, so Stein's lemma tells us that 

$$R(\hmu(X)) = n\sigma^2.$$

Remarkably, and counterintuitively (for me, at least), this is not the minimum risk estimator (i.e., it's not admissible). Consider the [James-Stein estimator](https://en.wikipedia.org/wiki/James%E2%80%93Stein_estimator) 

$$\hmu^{JS}(X,v) = \bigg(1 - \frac{n-2}{\norm{X-v}_2^2}\bigg)(X-v)+v,$$

for any $$v\in \R^n$$. Intuitively, this takes $$X$$ and shrinks all components towards the vector $$v$$. This is easy to see when $$v=0$$, which is a helpful case to consider as an intuition pump. The $$i$$-th partial derivative of the James-Stein estimator is 

$$\frac{\partial \hmu_i^{JS}(X,v)}{\partial x_i} = 1 - (n-2)\bigg(\frac{1}{\norm{X-v}_2^2} - 2\frac{(X_i-v_i)^2}{\norm{X-v}_4^2}\bigg),$$

so 

$$\sum_i\frac{\partial \hmu_i^{JS}(X,v)}{\partial x_i} = n  - \frac{n(n-2)}{\norm{X-v}_2^2} - \frac{2(n-2)}{\norm{X-v}_2^2}=n-\frac{(n-2)^2}{\norm{X-v}_2^2}.$$

The expected training error is 

$$
\begin{align}
\E\norm{X-\hmu^{JS}(X,v)}_2^2 &= \E\sum_i\bigg(\bigg(\frac{n-2}{\norm{X-v}_2^2}\bigg)(X_i-v_i)\bigg)^2 \\
&= \E\bigg[\frac{(n-2)^2}{\norm{X-v}_2^2}\sum_i (X_i-v_i)^2 \bigg]\\ 
&= \E\bigg[\frac{(n-2)^2}{\norm{X-v}_2^2}\bigg]. 
\end{align}
$$

Combining all of this with Equation \eqref{eq:stein_risk} gives 

$$
\begin{equation}
\label{eq:risk_js}
R(\hmu_v^{JS}(X,v)) = n\sigma^2 +(n-2)^2(1-2\sigma^2)\E\bigg[\frac{1}{\norm{X-v}_2^2}\bigg].\tag{4}
\end{equation}
$$ 

We're interested in when this estimator performs better than the baseline estimate $$\hmu=X$$, which has risk $$n\sigma^2$$. Thus, $$R(\hmu_v^{JS}(X,v))<R(X)$$ iff 

$$(n-2)^2(1-2\sigma^2)\E\bigg[\frac{1}{\norm{X-v}_2^2}\bigg]<0$$

which occurs iff $$1-2\sigma^2<0$$, i.e., $$\sigma > 1/\sqrt{2}$$. 

Unfortunately, even though the JS estimator demonstrates that the estimate $$\hmu=X$$ is inadmissible, it itself is also inadmissible. This is because $$\hmu^{JS}$$ is dominated by $$\hmu^{JS}_{+} \equiv \max\{\hmu^{JS},0\}$$, where the maximum is taken point-wise. And, according to some classical results in point estimation, the minimum risk estimator must be smooth, so $$\hmu^{JS}_{+}$$ is also inadmissible. The search continues!

A note on variance: While we assumed all normal distributions have the same variance, we don't actually need to know what that variance is to form the JS estimate. Some resources seem to suggest that you do (e.g., Wikipedia), writing the JS estimator as 

$$\hmu^{JS}(X,v) = \bigg(1 - \frac{\sigma^2(n-2)}{\norm{X-v}_2^2}\bigg)(X-v)+v.$$

This doesn't seem to get you anything, however. The result is still the same: you need $$\sigma^2>1/2$$ for it to beat the canonical estimator. 

It's worth noting that you can prove this result without resorting to Stein's lemma and degrees of freedom (e.g., see [here](http://www.statslab.cam.ac.uk/~rjs57/SteinParadox.pdf)), but I think this way is more insightful and general. 

## 2.1 Optimizing $$v$$ 

It's tempting to try and optimize the risk as a function of $$v$$. However, this is challenging because the expectation in Equation \eqref{eq:risk_js} can't be computed since we don't know the distribution. If we receives multiple samples, we could use the empirical average instead, but in that case we'd be implicitly conditioning $$v$$ on $$X$$, in which case Equation \eqref{eq:risk_js} no longer holds. Indeed, if $$v$$ is chosen as a function of $$X$$, then the partial derivatives of the JS estimator  have extra terms: 

$$\sum_i\frac{\partial \hmu_i^{JS}(X,v)}{\partial x_i} = n - \frac{n-2}{\norm{X-v}_2^2}\bigg(\sum_i(1-\partial_i v_i) + 2\sum_i\frac{(X_i-v_i)^2(1-\partial_iv_i)}{\norm{X-v}_2^2}\bigg).$$

That is, if $$\partial_iv_i$$ is not zero, then the optimization problem becomes trickier. 

## 2.2 Multiple Samples 

An obvious question is whether the result can be extended when multiples observations are drawn from $$N(\mu,\sigma^2I)$$. The answer is yes. In that case, we consider the estimator 

$$\hmu_v = \bigg(1 - \frac{(n-2)\sigma^2}{k\norm{\bZ-v}_2^2}\bigg)(\bZ-v) + v,$$

where 

$$\bZ = \frac{1}{k}\sum_i Z_i,\quad Z_i\sim N(\mu,\sigma^2I).$$

The math is actually almost identical since the derivative of the average is simply 1. 

## 2.3 Discussion

Stepping away from the math for a moment -- this is kind of a crazy result. While the distributions are all assumed to be normal with the same variance, they don't actually have anything to do with one another. One could be the distribution of female height in India, the other could be the test scores of high-school students in Japan (I think both of those are approximately normally distributed). The James-Stein estimator would have us generate estimates for each of these _which depend on the data drawn from the other distribution_. Japanese test-scores informing the height of Indian women? What on earth is going on here? 

A rough answer is that the estimator expertly trades off bias and variance. By introducing some bias by correlating the independent observations, it's able to lower the variance even further. Since MSE is a combination of bias and variance, if we sacrifice just enough bias, better overall risk can be achieved.


# 3. Resources 

- [Stein's Unbiased Risk Estimate](https://www.stat.cmu.edu/~larry/=sml/stein.pdf), by Tibshirani and Wasserman (I basically stole their proof of Stein's lemma verbatim since it's so nice). 





---
layout: note
title: \(\pi\)ps Sampling without Replacement
status: unpublished
date: "2022-03-20"
---

$$
\renewcommand{\Pr}{\mathbb{P}}
\newcommand{\S}{\mathcal{S}}
\newcommand{\hmu}{\hat{\mu}}
\newcommand{\hmuht}{\hmu_{\bf ht}}
\newcommand{\Var}{\mathbb{V}}
\newcommand{\Cov}{\text{Cov}}
\newcommand{\E}{\mathbb{E}}
$$

Let $$X=\{1,\dots,N\}$$ be a finite population of $$N$$ distinct units. Each $$i\in X$$ has a hidden value $$y_i$$. We have a budget of $$n\ll N$$ that we can use to sample $$n$$ distinct elements of $$X$$ in order to estimate the mean

$$
\begin{equation}
\label{eq:mean}
\mu = \frac{1}{N}\sum_{i\in X} y_i. \tag{1}
\end{equation}
$$

Let $$S\subset X$$ be the set of sampled elements, and let $$\S=\{S_1,\dots,S_{N\choose n}\}$$ be the set of all possible sets of sampled elements. For each element $$i\in X$$, define its _inclusion probability_ $$\pi_i \equiv \Pr(i\in S)$$, which gives the probability that $$i$$ gets sampled. Note that $$\Pr=\Pr_\S$$ is a measure on $$\S$$. 

Note that inclusion probabilities do not behave as a typical distribution, because they are defined over multiple rounds of sampling. In particular, $$\sum_i \pi_i \neq 1$$. Instead, 

$$\sum_i \pi_i = \sum_i \sum_{S\in\S} \Pr(S) \delta_S(i) = \sum_{S\in \S}\Pr(S)\sum_i \delta_S(i) = n\sum_{S\in \S}\Pr (S) = n,$$

since $$\vert S\vert=n$$ for each $$S\in\S$$. Here $$\delta_S(i)$$ indicates whether $$i\in S$$. 

We can also define higher order inclusion probabilities. For $$i\neq j$$, let $$\pi_{i,j}=\Pr(i,j\in S)$$, and so on. 

The Horvitz-Thompson (HT) estimator for the mean is 

$$\hmuht = \frac{1}{N}\sum_{i\in S} \frac{y_i}{\pi_i}.$$

It's easy to see this is unbiased since 

$$\E[\hmuht] = \frac{1}{N}\sum_{i\in X}\frac{y_i}{\pi_i}\E[\delta_S(i)] = \frac{1}{N}\sum_{i\in X}y_i.$$


The variance of the HT estimator is 

$$
\begin{align}
\Var(\hmuht) &= \frac{1}{N^2}\Var\bigg(\sum_{i\in X}\frac{y_i}{\pi_i}\delta_S(i)\bigg) \\
&= \frac{1}{N^2}\bigg\{\sum_{i\in X}\frac{y_i^2}{\pi_i^2}\Var(\delta_S(i)) + \sum_{i\in X}\sum_{j\neq i}\frac{y_iy_j}{\pi_i\pi_j}\Cov(\delta_S(i),\delta_S(j))\bigg\} \\
&= \frac{1}{N^2}\bigg\{\sum_{i\in X}\frac{y_i^2}{\pi_i}(1-\pi_i) + \sum_{i\in X}\sum_{j\neq i}\frac{y_iy_j}{\pi_i\pi_j}(\pi_i\pi_j-\pi_{i,j})\bigg\}, 
\end{align}
$$

since $$\Var(\delta_S(i)) = \E[\delta_S(i)] - \E[\delta_S(i)]^2 = \pi_i(1-\pi_i)$$ and 
similarly for the covariance. (Note that $$\delta_S(i)=\delta_S(i)^2$$.) 
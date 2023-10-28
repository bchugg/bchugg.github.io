---
layout: note 
date: "2023-10-28" 
title: "de Bruijn, Relative Entropy, and the CLT"
description: "A short note on Barron's 1986 result"
status: published
---

$$
\newcommand{\E}{\mathbb{E}}
\newcommand{\J}{J}
\newcommand{\cN}{\mathcal{N}}
\newcommand{\kl}{D_{\operatorname{KL}}}
\newcommand{\I}{I}
\renewcommand{\Re}{\mathbb{R}}
\renewcommand{\d}{\mathrm{d}}
$$

- TOC 
{:toc}

# Introduction 

Let $$X_1,X_2,\dots, X_n\sim P$$ be iid random variables with mean $$\mu$$ and variance $$\sigma^2<\infty$$.  The (Lindeburg-Lévy) central limit theorem (CLT) states that 

$$
\begin{equation}
    \label{eq:clt}
    S_n \equiv \sqrt{n}(\overline{X}_n -\mu) \xrightarrow{d} \cN(0,\sigma^2), \tag{1}
\end{equation}
$$

where $$\overline{X}_n= \frac{1}{n}\sum_{i\leq n} X_i$$. 
Let the standardized sum $$S_n$$ have law $$P_n$$. 
Informally, we can conceive of the CLT as stating that the _divergence_ between $$P_n$$ and $$\Phi=\cN(0,\sigma^2)$$ vanishes as $$n\to\infty$$. We might therefore expect a result of the following form to hold:

$$
\begin{equation}
\label{eq:abstract_result}
    \lim_{n\to\infty} D(P_n\|\Phi) = 0,\tag{2}
\end{equation}
$$

where $$D$$ is some divergence between probability measures. 
Here we'll introduce [some results by Andrew Barron](https://projecteuclid.org/journals/annals-of-probability/volume-14/issue-1/Entropy-and-the-Central-Limit-Theorem/10.1214/aop/1176992632.full) (proved in 1986) that confirm this when $$D$$ is taken to be the KL-divergence. 

Intriguingly, Barron's result supplies an analogy between the CLT and thermodynamics. 
In particular, it relates the concept of information-theoretic relative entropy to thermodynamic entropy. The second law of thermodynamics states that closed systems tend towards a state maximum entropy. Subject to a variance constraint, the normal distribution maximizes information-theoretic entropy. Thus, \eqref{eq:abstract_result} may be interpreted as the normalized sum $$S_n$$ converging towards a state of maximum entropy, thereby providing us with an information-theoretic version of the second law. 

Thermodynamics aside, the result is also interesting for several purely statistical reasons. For one, it implies the classical CLT since convergence in KL-divergence implies convergence in $$L^1$$ and hence in distribution. Second, the proof of Barron's theorem entails several other interesting results, such as a relationship between KL-divergence and the so-called Fisher distance in addition to a separate CLT-like statement for the Fisher distance. 
Finally, Barron's work opens the door to further work connecting information theory and probabilistic limit theorems. 



# Three Results

Barron's theorem is undergirded by two results which are sufficiently interesting to warrant their own discussion, so we split the proof into three sections. 
The first will present a relationship between the KL-divergence and the Fisher distance, the second will present a CLT-like result for the Fisher distance, and the third will prove the main result of interest. 

Before we begin, let us recall some basic definitions. The Kullback-Liebler (KL) divergence, also known as the relative entropy, between measures $$P$$ and $$Q$$ on a sample space $$\Omega$$ is 

$$
\begin{equation}
    \kl(P\|Q) = \int_\Omega \log\left(\frac{p(x)}{q(x)}\right) \d P(x),
\end{equation}
$$

if $$P\ll Q$$ and $$\infty$$ otherwise. Here $$P$$ and $$Q$$ have densities $$p$$ and $$q$$ (lower case letters will be interpreted as the densities of their upper case counterparts throughout). 
We might sometimes abuse notation and write $$\kl(X\|Y)=\kl(P\|Q)$$ if $$X\sim P$$ and $$Y\sim Q$$.
The (nonparametric) Fisher information of $$X$$ with distribution $$P$$ and density $$p$$ is the quantity 

$$
\begin{equation}
\label{eq:fisher}
    \I(X) := \E_{X\sim P} \left(\frac{\partial }{\partial X}\log p(X)\right)^2 =  \int_{\Omega} \frac{(p'(x)^2}{p(x)}\d x. \tag{3}
\end{equation}
$$

for a random variable $$X$$ defined over $$\Omega$$.  While this is termed the nonparametric Fisher information, it can also be seen as the usual parametric Fisher information at $$\theta=0$$ of the model $$p_\theta(x) := p(x-\theta)$$. 
Henceforth we will not draw this distinction and refer to \eqref{eq:fisher} as simply the Fisher information. 
 Finally, let us define the _Fisher distance_ as the quantity 

$$ 
\begin{equation}
\label{eq:fisher_distance}
    I(X\|Y) := \E_{X\sim P}\left(\frac{\partial }{\partial x} \log\frac{p(x)}{q(x)}\right)^2,
\end{equation}
$$

for $$X\sim P$$ and $$Y\sim Q$$. 
(Note that despite similarities in the notation, $$I(X\|Y)$$ is distinct from $$I(X;Y)$$, the mutual information between $$X$$ and $$Y$$). 

## Relative Entropy as an integral of the Fisher distance

Trying to prove Barron's theorem by working directly with the KL-divergence is challenging. Instead, we leverage relationships between the KL diverge and other information-theoretic quantities, electing to work with those instead. In this section we demonstrate the relationship between the KL-divergence and the Fisher distance, which is both interesting in its own right and will be useful later on.

A central ingredient in the proof is _de Bruijn's identity_, which relates entropy and Fisher information. De Bruijn's identity can be written as 

$$
\begin{equation}
    \label{eq:debruijn}
    \frac{\partial}{\partial \theta} H( Y + \xi_\theta) = \frac{1}{2}\I(Y + \xi_\theta), \tag{4}
\end{equation}
$$

where $$\xi_\theta \sim \cN(0,\theta^2)$$ and $$Y$$ is independent of $$\xi_\theta$$. 
As usual, $$H$$ denotes the entropy $$H(Y) := -\int_\Omega p_Y(y)\log(p_Y(y))dy$$. 
Statement~\eqref{eq:debruijn} can be generalized to the statement 

$$
\begin{equation}
    \frac{\partial }{\partial \theta} \kl( Y_1 + \xi_\theta\| Y_2 + \xi_\theta) = -\frac{1}{2}I(Y_1 + \xi_\theta \| Y_2 + \xi_\theta),
\end{equation}
$$

where $$I(X\|Y)$$ is the Fisher distance defined above. Again, $$Y_1$$ and $$Y_2$$ are taken to be independent of $$\xi_\theta$$. 
Via a judicious application of change of variables, we can relate this to our quantity of interest. 
In particular, let $$X$$ have mean $$\mu$$ and variance $$\sigma^2$$. For any $$t\in[0,1]$$, taking $$Y_1 = \sqrt{t}X$$ and $$\theta^2 = (1-t)\sigma^2$$,  [Johnson demonstrates](https://books.google.ca/books?hl=en&lr=&id=r5XI8a0lYykC) that we may write 

$$
\begin{equation}
    \frac{\partial }{\partial t} \kl(\sqrt{t} X + \sqrt{t-1}Z\| \xi) = \frac{\sigma^2}{2t} I(\sqrt{t}X + \sqrt{1-t} Z\| \xi),
\end{equation}
$$

where $$Z,\xi$$ are independent and both drawn from $$\cN(\mu,\sigma^2)$$. Applying the fundamental theorem of calculus to the above display (and assuming certain technical conditions are met), we obtain 

$$
\begin{equation*}
    \kl(X\|\xi) - \kl( Z\|\xi) = \sigma^2 \int_0^1 I(\sqrt{t} X - \sqrt{1-t} Z\|\xi). 
\end{equation*}
$$

Noting that $$\kl(Z\|\xi)$$ provides the first result: If $$X$$ has mean $$\mu$$ and variance $$\sigma^2<\infty$$ and $$Z,\xi\sim \cN(\mu,\sigma^2)$$, then 

$$
\begin{equation}
\label{eq:kl_int}
    \kl(X\|\xi) = \sigma^2\int_0^1 \frac{I(\sqrt{t} X - \sqrt{1-t}Z\|\xi)}{2t} \d t.
\end{equation}
$$

This is a cool and not-at-all obvious result.


## CLT for the Fisher distance

We now provide a CLT-like result for the Fisher distance. More specifically, we will show that for all $$t\in[0,1]$$, 

$$\lim_{n\to\infty} I(\sqrt{t} S_n - \sqrt{1-t} Z\|\xi)= 0,$$

where, as above, $$S_n$$ is the standardized sum of $$X_1,\dots,X_n$$ and $$Z,\xi\sim \cN(\mu,\sigma^2)$$. 


Fix $$t\in[0,1]$$ and let $$W_n = \sqrt{t} W_n + \sqrt{1-t} Z$$ where $$Z\sim\cN(0,\sigma^2)$$. 
For convenience, let us assume that $$\mu=0$$. 
We proceed by demonstrating that 

$$
\lim_{n\to\infty} I(W_n) = \frac{1}{\sigma^2}.
$$

That is, in the limit, $$W_n$$ achieves the Cramer-Rao lower bound. This will prove the desired result after noticing that $$I(W_n \|\xi) = I(W_n) - 1/\sigma^2$$ due to the Fisher information of the normal. 

Consider the random variables $$Y_k = S_{2k} + \xi_\tau$$ where $$\xi\sim \cN(0,\tau^2)$$. Let $$Y_k$$ have law $$G_k$$ and pdf $$g_k$$. Note that 

$$
\begin{align*}
    I(Y_k) &= \E_{X\sim G_k}\left(\frac{\partial }{\partial X}\log g_k(X)\right)^2 = \int_\Omega \left(\frac{g_k'(x)}{g_k(x)}\right)^2 g_k(x)\d x = \int_\Omega \left(\frac{g_k'(x)}{g_k(x)}\right)^2 \frac{g_k(x)}{\phi(x)}\d \Phi,
\end{align*}
$$

where $$\Phi=\cN(0,\sigma^2+\tau)$$. By the CLT, $$S_{2k}\to \cN(0,\sigma^2)$$ in distribution, so $$Y_k \to\cN(0,\sigma^2+\tau^2).$$ This (for some technical reasons outside the scope of this note) implies convergence of the score functions in $$L^1$$, i.e., $$\E[(g_k'/g_k)^2 - (\phi'/\phi)^2]\to 0$$. Moreover, $$g_k\to\phi$$ in $$L^1$$ as well, hence in probability, so $$g_k / \phi \to 1$$ in probability. Putting all of this together and employing the continuous mapping theorem (modulo some uniform integrability issues which are met but which we will ignore),  we obtain that 

$$
\begin{equation*}
    I(Y_k) = \int_\Omega \left(\frac{g_k'(x)}{g_k(x)}\right)^2 \frac{g_k(x)}{\phi(x)}\d \Phi \xrightarrow{k\to\infty} \int_\Omega \left(\frac{\phi'(x)}{\phi(x)}\right)^2 \d \Phi = \frac{1}{\sigma^2 + \tau^2},
\end{equation*}
$$

where the final step uses standard equalities for the Fisher information of normal random variables. 
Therefore, a change of variables gives 

$$I( \sqrt{t} S_{2k} + \sqrt{1-t}\xi_{\tau}) ]\to \frac{1}{t\sigma^2 + (1-t)\tau)^2}.$$ 

Taking $$\tau=\sigma$$ in addition to the fact that $$W_n$$ is subadditive gives the result. 

## CLT for Relative Entropy

Now we provide Barron's main theorem, which follows with relatively little effort from the preceding sections. 
Let us again assume that $$\mu=0$$ for convenience. We claim that 
$$\kl(P_n \| \Phi) = \kl(S_n \|\xi) \to 0,$$
where $$\xi\sim \cN(0,\sigma^2)$$. First we will show that the limit exists, and then that the limit equals 0. 


Fekete's subadditive lemma states that if $$(a_n)$$ is a subadditive sequence then $$\lim_n \frac{a_n}{n}$$ exists. Therefore, to see that the limit $$\lim_n \kl(S_n\|\xi)$$ exists it suffices to show that $$\{n\kl(S_n\|\xi)\}$$ is subadditive in $$n$$. That is, we want to show that 

$$(n+m)\kl(S_{n+m}\|\xi) \leq  n\kl(S_n\|\xi) + m\kl(S_m\|\xi).$$ 

for all $$n,m$$. This can be seen by appealing to well-known convolutional inequalities for the Fisher information. In particular, it's known that 

$$I(\sqrt{a_1} Y_1 + \sqrt{a_2} Y_2) \leq a_1 I(Y_1) + a_2 I(Y_2),$$ 

for all $$a_1,a_2\geq 0$$, $$a_1+a_2=1$$. This shows that the sequence $$I(S_n)$$ is subadditive. Indeed, taking $$a_1=\sqrt{n}$$, $$a_2=\sqrt{m}$$, $$Y_1=S_n$$ and $$Y_2 = S_m$$ gives 

$$(n+m) I(S_{n+m}) = I(\sqrt{n+m} S_{n+m}) = I(\sqrt{n} S_n + \sqrt{m}S_m) \leq nI(S_n) + mI(S_m).$$

This implies that the same inequality holds true for the Fisher-distance, and therefore for $$\kl(\cdot \|\xi)$$ via \eqref{eq:kl_int}. So we conclude that $$\{n\kl(S_n\|\xi)\}$$ is subadditive. 

To see that the limit is zero, we appeal to the previous section. Assuming the required regularity conditions are met to exchange limits and integrals (they are, but we omit the details here because they are uninteresting), we have 

$$
\begin{align*}
    \lim_{n\to\infty}\kl(S_n \|\xi) &= \frac{\sigma^2}{2}\int_0^1 \frac{1}{t}\lim_{n\to\infty} I(\sqrt{t} S_n- \sqrt{1-t}Z\|\xi)\d t = 0,
\end{align*}
$$

which proves the desired result. 



# Applications and Extensions

The results above enable us to recover convergence in $$L^1$$ of $$S_n$$ to $$\Phi$$. In particular, recall that the $$L^1$$ norm is bounded by the KL-divergence: 

$$
\begin{align*}
    \left(\int_{\Omega} \vert p(x) - q(x)\vert \d P(x)\right)^2 \leq 2\log(2) \kl(p\|q). 
\end{align*}
$$

(See, e.g., Lemma 11.6.1 in the Cover and Thomas textbook.) This immediately implies that $$P_n$$ converges to $$\Phi$$ in $$L^1$$, and hence in distribution, thereby recovering the classical CLT. We can use nearly identical logic to see that $$\lim_n \int \vert p(x) - q(x)\vert\d x =0$$. 

We can further use the result to demonstrate that $$\log p_n(x)$$ is a good approximation of $$\log \phi(x)$$ in the sense that 

$$
\begin{equation*}
    \lim_{n\to\infty} \int_\Omega \vert\log p_n(x) - \log \phi(x)\vert\d P_n(x) = 0.
\end{equation*}
$$

This immediately follows from the inequality $$\int_\Omega \vert\log p/q\vert\d P \leq \kl(P\|Q) + \sqrt{2\kl(P\|Q)}$$. 

The original intuition for the result laid out in the introduction was not specific to the KL-divergence. Indeed, we might expect the result to hold for many divergences between probability measures. 

Of course, converge follows for some divergences by means of their relationship to the KL-divergence. For instance, the square of the Hellinger distance is bounded by the KL divergence, thus implying convergence  in that case. 
However, there are other divergences which are lower bounded by the KL divergence; Rényi $$\alpha$$-divergences for all $$\alpha>1$$ for instance. An interesting open problem is to determine whether convergence holds in such cases. 





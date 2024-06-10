---
layout: note 
date: "2023-08-23" 
title: "A Table of Exponential Inequalities"
description: "A list of exponential inequalities that underlie useful concentration inequalities"
status: published
---

$$
\newcommand{\Pr}{\mathbb{P}}
\newcommand{\E}{\mathbb{E}}
\newcommand{\Re}{\mathbb{R}}
\newcommand{\Xbar}{\overline{X}}
\newcommand{\Var}{\mathbb{V}}
$$

I forget useful exponential inequalities all the time and I'm sick of looking them up. (Pf) stands for proof and will jump you to the proof of the given inequality. If I've omitted your favorite inequality let me know. 

I considered writing a big list of _concentration_ inequalities, but then I realized that most of the time what I really wanted was the inequality underlying the concentration inequality, which is typically some sort of exponential inequality. So here we are. Plus, I do a lot of work with martingales, and writing things out like I've done here makes obvious the resulting supermartingale. 

Are there papers that do this more formally and completely? Yes, e.g., [this one](https://arxiv.org/pdf/1808.03204.pdf). But I needed something for myself that was easy and interpretable. 

Throughout, let $$X$$ be a random variable with mean $$\mu$$. Set $$\Xbar = X-\mu$$. 


| Name | Condition | Bound | 
| --- | --- | --- | 
| Hoeffding [(Pf)](#proof-of-hoeffding) | $$X\in [a,b]$$ | $$\E\exp\{\lambda \Xbar - \frac{\lambda^2}{8}(b-a)^2\}\leq 1 $$ |
| Self-bounding [(Pf)](#proof-of-self-bounding) | MGF exists | $$\forall \lambda\in\Re\quad \E \exp\{\lambda X - \log \E \exp(\lambda X)\}= 1$$| 
| Bennett [(Pf)](#proof-of-bennett) | $$\vert X \vert \leq H$$ $$\E[X^2]\leq v^2<\infty$$ | $$\forall\lambda\in (0,\frac{1}{v})\quad \E\exp\{-\lambda\Xbar - \frac{\mu^2}{H^2}(e^{\lambda H} - \lambda H -1)\}\leq 1 $$ |
| One-sided Bernstein I [(Pf)](#proof-of-one-sided-bernstein-i) | $$X \leq H$$ and $$\E[X^2]<\infty$$ | $$\forall \vert\lambda \vert\leq \frac{1}{2H}\quad \E\exp\{\lambda \Xbar - (e-2)\lambda^2\Var(X)\}\leq 1$$ |
| One-sided Bernstein II [(Pf)](#proof-of-one-sided-bernstein-ii) | $$X\geq 0$$ and $$\E[X^2]<\infty$$ | $$\forall \lambda>0 \quad \E\exp\{-\lambda\Xbar - \lambda^2\E[X^2]/2\}\leq 1$$ | 
| Delyon [(Pf)](#proof-of-delyon) | $$\E[X^2] < \infty$$ | $$\forall \lambda\in \Re\quad \E[\exp\{\lambda\Xbar - \frac{\lambda^2}{6}(\Xbar^2 - 2\E[\Xbar^2])\}]\leq 1$$ | 
| Fan [(Pf)](#proof-of-fan) | $$X\geq -1$$, $$\E[X]\leq 0$$ | $$\forall \lambda\in[0,1)\quad \E\exp\{\lambda X + X^2(\log(1 - \lambda) + \lambda)\}\leq 1$$ | 
| Catoni [(Pf)](#proof-of-catoni) | $$ \E[\vert X\vert^p]<\infty, p>1$$ | $$\forall\lambda>0\quad \E\exp\{\phi_p(\lambda X) - \frac{\lambda^p}{p}\E[\vert X\vert^p]\} \leq 1$$ where $$\phi_p(x) \leq \log(1 + x + \vert x\vert^p/p)$$ | 

## Proof of Hoeffding 

Just note that a bounded random variable $$X\in[a,b]$$ is $$(b-a)/2$$-sub-Gaussian, and apply the definition of sub-Gaussianity. It can also be proved more directly, see [wikipedia](https://en.wikipedia.org/wiki/Hoeffding%27s_lemma). 

## Proof of Self-Bounding 

Clear by definition: 

$$
\begin{align}
\E\exp\{\lambda X - \log \E \exp(\lambda X)\} &= \E\exp\{\lambda X\}\exp\{-\log \E\exp\{\lambda X\}\} \\
&= \E\exp\{\lambda X\}\exp\log(\E\exp\{\lambda X\})^{-1} = 1.
\end{align}
$$

## Proof of Bennett

Set $$\psi(x) = e^x - x -1$$. Notice that the function $$\psi(x)/x^2$$ is monotonically increasing. (Technically, at $$x=0$$, one should continuously extend the function; the left and right limits are the same so this works out. Plot the function if you don't believe me.) Since $$X\leq H$$, we have 

$$\frac{1}{(\lambda X)^2}\psi(\lambda X) \leq \frac{1}{(\lambda H)^2}\psi(\lambda H).$$

Rearranging, 

$$
\begin{equation}
\label{eq:bennett-I}
e^{\lambda X} \leq \frac{X^2}{H^2}\psi(\lambda H) + \lambda X + 1, 
\end{equation}
$$

so 

$$
\begin{equation}
\label{eq:bennett-ii}
\E e^{\lambda X} \leq \frac{\E X^2}{H^2}\psi(\lambda H) + \lambda \mu + 1. \tag{1}
\end{equation}
$$

Let $$v>0$$ be a bound on the second moment, i.e., $$\E[X^2]\leq v^2<\infty$$. Then $$\mu^2 \leq v^2$$ so $$|\mu|\leq v$$.  
Using the inequality $$e^x \geq 1 + x$$ for all $$x$$,  notice that $$\psi(x)\geq 0$$, so 
$$\frac{\mu^2}{H^2}\psi(\lambda H) + \lambda\mu \geq \lambda\mu \geq -\lambda v> -1$$ if $$\lambda< 1/v$$.   Therefore, taking logs of both sides of \eqref{eq:bennett-ii} is well-defined. Deploying the inequality $$\log(1 +x )\leq x$$ for $$x>-1$$, we have 

$$\log \E e^{\lambda X} \leq \log\bigg(\frac{v^2}{H^2}\psi(\lambda H) + \lambda\mu + 1\bigg) \leq \frac{v^2}{H^2}\psi(\lambda H) + \lambda\mu.$$

Adding $$-\lambda \mu = -\log e^{\lambda \mu} $$ to both sides, we obtain 

$$\log \E \frac{e^{\lambda X}}{e^{\lambda \mu}} \leq \frac{v^2}{H^2}\psi(\lambda H) + \lambda\mu - \log \E e^{\lambda X} \leq \frac{v^2}{H^2}\psi(\lambda H),$$


which, after exponentiating and rearranging, is the desired inequality. 










## Proof of one-sided Bernstein I 

The inequality $$e^x \leq 1 + x + (e-2)x^2$$ holds for all $$x\leq 1$$. Applying this with $$x = \lambda\Xbar$$ and taking expectations we obtain 

$$\begin{align}
\E[e^{\lambda \Xbar}] \leq 1 + \E[\lambda \Xbar] + (e-2)\lambda^2 \Var(X) = 1 + (e-2)\lambda^2 \Var(X) \leq \exp\{(e-2) \lambda^2\Var(X)\}.
\end{align}
$$

Rearranging gives the result. Note that we needed the condition on $$\lambda$$ to ensure that $$\lambda \Xbar\leq 1$$: $$\lambda\Xbar \leq \vert\lambda\vert \vert X-\mu\vert\leq \vert\lambda \vert 2H \leq 1$$. 


## Proof of one-sided Bernstein II 

Let $$Z=-X$$ and put $$\psi(s)= e^s - s -1$$. Set

$$g(s) = \begin{cases}
    \psi(s)/s^2,&s\neq 0,\\
    1/2,&s=0.
\end{cases}$$

Note that $$g(s)$$ simply defines the continuous extension of $$\psi(s)/s^2$$ at $$s=0$$. Indeed, $$\lim_{s\to0^+} \psi(s)/s^2=\lim_{s\to0^-}\psi(s)/s^2=1/2$$. Note also $$g(s)$$ is an increasing function for all $$s\in\Re$$. Therefore, for all $$s\leq 0$$, $$\psi(s) = s^2 g(s) \leq s^2 g(0) = \frac{s^2}{2}.$$
Since $$Z\leq 0$$ and $$\lambda>0$$, we may take $$s=\lambda Z$$ to obtain $$\phi(\lambda Z) \leq (\lambda Z)^2/2$$. Thus,
$$\E[e^{\lambda Z}] - \lambda \E[Z] - 1 \leq \frac{\lambda^2}{2}\E[Z^2],$$
and 

$$
\begin{align}
\E[\exp(\lambda(Z-\E[Z]))] &\leq e^{-\lambda \E[Z]} ( 1 + \lambda \E[Z] + \lambda^2\E[Z^2]/2) \\
&\leq e^{-\lambda \E[Z]}\exp(\lambda \E[Z] + \lambda^2\E[Z^2]/2) = \exp(\lambda^2\E[Z^2]/2).
\end{align}
$$

Replacing $$Z$$ with $$-X$$ completes the proof. 

## Proof of Delyon

Delyon (2009) shows that for all $$x\in \Re$$, $$\E[\exp( x - x^2/6)] \leq 1 + x + x^2/3$$. Setting $$x = \lambda\Xbar$$ and applying expectations gives  

$$
\begin{align}
\E[\exp\{\lambda\Xbar - \lambda^2\Xbar^2/6\}] &\leq 1 + \lambda\E[\Xbar] + \lambda^2\E[\Xbar^2]/3 \\ 
&= 1 + \lambda^2\E[\Xbar^2]/3 \leq \exp\{\E[\lambda^2\Xbar^2]/3\},
\end{align}
$$

using that $$1+x\leq e^x$$. Rearranging gives the result. 

## Proof of Fan 

See original Fan et al. paper [here](https://arxiv.org/pdf/1311.6273.pdf). Note that the function 

$$f(x) = \frac{\log(1+x) -x}{x^2/2},$$

is non-decreasing for all $$x>-1$$. (Continuously extend the function at $$x=0$$.) Consider $$x=-\lambda$$ and $$y = \lambda X$$. Note that $$\lambda X\geq -\lambda >-1$$. Therefore $$f(x)\leq f(y)$$ which rearranges to read 

$$f(-\lambda) \leq f(\lambda X)  = \frac{\log(1 + \lambda X) -\lambda X}{X^2/2},$$

which in turn rearranges to 

$$\lambda X + X^2(\log(1-\lambda) + \lambda)\leq \log(1 + \lambda X).$$

Exponentiating and taking expectations gives 

$$\E\exp\{\lambda X + X^2(\log(1-\lambda) +\lambda)\}\leq \E[1 + \lambda X] \leq 1,$$

as claimed. 



## Proof of Catoni

Let $$\E\vert X\vert^p\leq v<\infty$$. By definition of $$\phi_p$$,

$$
\begin{align}
\E\exp\bigg\{\phi_p(\lambda \Xbar) - \frac{\lambda^pv^p}{p} \bigg\} &\leq \E\bigg(1 + \lambda \Xbar + \frac{\vert\lambda \Xbar\vert^p}{p}\bigg)\exp\bigg(- \frac{\lambda^pv^p}{p}\bigg) \\ 
&= \E\bigg(1 +  \frac{\vert\lambda \Xbar\vert^p}{p}\bigg)\exp\bigg(- \frac{\lambda^pv^p}{p}\bigg)\\
&\leq \exp\bigg(\frac{\lambda^p \E\vert\Xbar\vert^p}{p}\bigg)\exp\bigg(- \frac{\lambda^pv^p}{p}\bigg)\leq 1,
\end{align}
$$

as desired. 

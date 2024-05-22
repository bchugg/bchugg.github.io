---
layout: note
title: A dimension-free Bernstein bound
description: "A martingale approach for concentration of bounded random vectors" 
status: published
date: "2024-05-21"
---

$$
\newcommand{\Re}{\mathbb{R}}
\newcommand{\norm}[1]{\left\| {#1}\right\|}
\newcommand{\E}{\mathbb{E}}
\newcommand{\calF}{\mathcal{F}}
\newcommand{\eps}{\epsilon}
\renewcommand{\Pr}{\mathbb{P}}
$$

- TOC 
{:toc}


Let $$X_1, X_2, \dots, X_n$$ be independent random vectors in $$\Re^d$$ with mean $$\mu$$ such that $$\norm{X_t}\leq c_t$$ almost surely. Assume the norm $$\norm{\cdot}$$ is the $$\ell_2$$ norm. What sort of concentration inequalities exist for $$\norm{S_n}$$, where $$S_n = \frac{1}{n}\sum_{i\leq n}X_i$$?

Here we'll investigate a method to obtain a dimension-free Bernstein bound for $$\norm{S_n}$$. I like this result for several reasons. First, it's not _a priori_ obvious that there should be a dimension-free bound in this case. Second, the proof technique is different than other known techniques for multivariate concentration (such as covering, variational, and isoperimetric arguments). More concretely, instead of trying to bound $$\langle \nu, S_n\rangle$$ in each direction $$\nu$$, we'll instead work directly with the norm $$\norm{S_n}$$. 

The high-level idea is simple: Construct the Doob-martingale for $$\norm{S_n}$$ and apply known inequalities for scalar valued  martingales. Since the $$X_i$$ are bounded, a natural result to use is the Azuma-Hoeffding inequality. This is where we'll begin, but we'll see that we can do better. 

# 1. Approach i: Azuma-Hoeffding 

First we form a scalar-valued martingale out of $$\norm{S_n}$$. In particular, we consider its Doob decomposition: 

$$Z_t := \E[\norm{S_n}\vert \calF_{t}] - \E[\norm{S_n}],$$


where $$\calF_t = \sigma(X_1,\dots,X_t)$$. By total expectation it's easy to see that $$\E[Z_t\vert \calF_{t-1}] = Z_{t-1}$$, so $$(Z_t)_{t\geq 0}$$ is indeed a martingale. Note that $$Z_0 = 0$$. 
Next we claim that $$(Z_t)$$ has bounded increments. Let $$D_t$$ denote these increments, i.e., 

$$D_t = Z_t - Z_{t-1}.$$

We want to bound $$\vert D_t\vert $$. First, notice that 

$$\E[\norm{S_n - X_t}\vert \calF_{t}] - \E[\norm{S_n - X_{t}}\vert \calF_{t-1}] = 0,$$

since the only terms that remain in $$S_n - X_t=\sum_{i\neq t}X_i$$ are either measurable with respect to both $$\calF_t$$ and $$\calF_{t-1}$$ or remain random. Therefore,

$$
\begin{align}
\vert D_t\vert  &= \left\vert  \E[\norm{S_n}\vert \calF_t] - \E[\norm{S_n}\vert \calF_{t-1}]\right\vert  \\
&=  \left\vert \E[\norm{S_n} - \norm{S_n - X_t}\vert \calF_t] - \E[\norm{S_n} - \norm{S_n - X_{t}}\vert \calF_{t-1}] \right\vert  \\ 
&\leq \left\vert \E[\norm{S_n} - \norm{S_n - X_t}\vert \calF_t] \right\vert  +  \left\vert \E[\norm{S_n} - \norm{S_n - X_{t}}\vert \calF_{t-1}] \right\vert  \\ 
&= \left\vert \E[\norm{S_n} - \norm{S_n - X_t}\vert \calF_t] - \E[\norm{S_n} - \norm{S_n - X_{t}}\vert \calF_{t-1}] \right\vert  \\ 
&\leq \E[\left\vert \norm{S_n} - \norm{S_n - X_t}\right\vert  \vert \calF_t]  +  \E[\left\vert \norm{S_n} - \norm{S_n - X_{t}}\right\vert  \vert \calF_{t-1}] \\ 
&\leq \E[\norm{X_t}\vert \calF_t] + \E[\norm{X_t}\vert \calF_{t-1}] \\ 
&= \norm{X_t} + \E[\norm{X_t}\vert \calF_{t-1}].
\end{align}
$$

Here, the first inequality is via the triangle inequality, the second by Jensen's inequality, and the third by the reverse triangle inequality. Using our assumption on the boundedness of $$X_t$$, we have 

$$\vert D_t\vert  \leq 2c_t.$$

A martingale with bounded increments is susceptible to the [Azuma-Hoeffding inequality](https://en.wikipedia.org/wiki/Azuma%27s_inequality). Since $$Z_0=0$$, this gives 

$$\Pr(Z_n \geq \eps)\leq \exp\left(\frac{-\eps^2}{2\sum_{t\leq n}c_t^2 }\right).$$

Put $$V_n = \sum_{i\leq n} \E\norm{X_i}^2$$. 
Observing that $$Z_n = \norm{S_n} - \E[\norm{S_n}]$$ and 
$$\E\norm{S_n}\leq \sqrt{\E\norm{S_n}^2} = \sqrt{\sum_{i\leq n}\E\norm{X_i}^2}$$, we can rewrite the above bound as 

$$\Pr(\norm{S_n}\geq \sqrt{V_n} + \eps )\leq \exp\left(\frac{-\eps^2}{2\sum_{t\leq n}c_t^2 }\right).$$

In other words, with probability at least $$1-\delta$$, we have 

$$\norm{S_n} \leq \sqrt{V_n} + \sqrt{2\log(1/\delta)\sum_{i\leq n}c_i^2}.$$

Can we strengthen this bound? It turns out that we can. In fact, we can replace the term $$\sum_{i\leq n}c_i^2$$ with the term $$V_n$$ (or any upper bound thereof). Is this better than the current bound? Yes. Notice that since $$\norm{X_t}\leq c_t$$ we have the trivial bound $$\E\norm{X_t}^2 \leq c_t^2$$. Therefore, if we have more information about the second moments of $$X_t$$, say they are upper bounded by $$\sigma_t^2$$, then we may assume that $$\sigma_t^2\leq c_t^2$$. 

To make this replacement, we need to modify the Azuma-Hoeffding inequality. 

# 2. Interlude: A martingale-variance inequality 

Let $$(M_t)_{t\geq 0}$$ be a martingale with increments bounded by $$b_t$$ (i.e., $$\vert M_t - M_{t-1}\vert \leq b_t$$) and, in addition, 

$$\E [\vert M_t - M_{t-1}\vert ^2\vert \calF_{t-1}]\leq \sigma_t^2.$$

Let $$V_n = \sum_{i\leq n}\sigma_i^2$$. With this extra information about the variance of the increments, we can modify Azuma's bound above to read: For all $$n$$, 

$$
\begin{equation}
\label{eq:variance-martingale-bound}
\Pr(M_n \geq M_0 + \eps) \leq \exp\left(\frac{-\eps^2}{4V}\right), \quad \text{ for all }\eps \leq \frac{2V}{\max_i b_i}. \tag{1}
\end{equation}
$$

As far as history is concerned, this bound was first proved by DA Grable in [A Large Deviation Inequality for Functions of Independent, Multi-way Choices](https://citeseerx.ist.psu.edu/document?repid=rep1&type=pdf&doi=3b7858b4475d8027cf49c8afbaac34b4229731fb). A very clean proof is given by Dubhasi and Panconesi in their textbook, [Concentration of Measure for the Analysis of Randomized Algorithms](http://wwwusers.di.uniroma1.it/~ale/Corsi/AlgoPro/monograph.pdf), Chapter 8. And for those of you who are interested in Matrix inequalities, David Gross gives an operator version of this bound (when $$M_t$$ are $$d\times d$$ Hermitian matrices) in [Recovering Low-Rank Matrices From Few Coefficients In Any Basis](https://www.math.ucdavis.edu/~strohmer/courses/270/lowrank_Gross.pdf). 




## 2.1. The proof 

To prove this bound, start with the basic Chernoff method. Let $$D_t= M_t - M_{t-1}$$ denote the increments of $$(M_t)$$. For any $$\lambda>0$$, 

$$
\begin{align}
\Pr(M_n \geq M_0 + \eps ) &= \Pr(e^{\lambda M_n} \geq e^{\lambda (M_0 + \eps)}) \leq e^{-\lambda (M_0 + \eps)}\E[e^{\lambda M_n}]. 
\end{align}
$$

Then, write 

$$
\begin{align}
\E[e^{\lambda M_n}] &= \E[\E[e^{\lambda (M_{n-1} + D_n)}\vert \calF_{n-1}]]  
 = \E[e^{\lambda M_{n-1}} \E[e^{\lambda D_n}\vert \calF_{n-1}]]. 
\end{align}
$$

Recall that for $$\vert x\vert \leq 1$$ we have the inequality $$e^x \leq 1 + x + x^2$$. Therefore, if $$\vert \lambda D_n\vert  \leq 1$$ we have 

$$
\begin{align}
\E[e^{\lambda D_n}\vert \calF_{n-1}] &\leq \E[1 + \lambda D_n + \lambda^2D_n^2 \vert \calF_{n-1}] \\
&= 1 + \lambda^2\E[D_n^2\vert \calF_{n-1}] 
\leq e^{\lambda^2 \E[D_n^2\vert \calF_{n-1}]} 
\leq e^{\lambda^2 \sigma_n^2},
\end{align}$$


where we've used that $$1 + x \leq e^x$$ and that $$\E[D_n\vert \calF_{n-1}]=0$$. Hence, 

$$\E[e^{\lambda M_n}] \leq e^{\lambda^2 \sigma_n^2}\E[e^{\lambda M_{n-1}}] \leq \dots \leq e^{\lambda M_0}\prod_{i=1}^n e^{\lambda^2\sigma_i^2} = e^{\lambda M_0 + \lambda^2V_n}.$$

Note the expectation has disappeared from $$e^{\lambda M_0}$$ because $$M_0$$ is assumed to be known (if not just replace $$M_0$$ with $$\E[M_0]$$ everywhere). Putting this all together gives 

$$\Pr(M_n \geq M_0 + \eps) \leq e^{\lambda^2 V_n - \lambda\eps}.$$

Optimizing the value of $$\lambda$$ on the right hand side gives 

$$\lambda = \frac{\eps}{2V}.$$

Recall that we require that $$\max_n \lambda \vert D_n\vert \leq 1$$. This holds if $$\eps \leq 2V / \max_t c_t$$ since $$\vert D_t\vert \leq c_t$$ by assumption. This gives us \eqref{eq:variance-martingale-bound}. 



# 3. Approach ii: A better bound

Let's return to our Doob-martingale $$(Z_t)$$ and its increments $$D_t$$. In order to use the above martingale-variance inequality we need to find a bound on $$\E[D_t^2 \vert \calF_{t-1}].$$ 
Using the same trick as above, write 

$$D_t^2 = (\E[\norm{S_n} - \norm{S_n - X_t}\vert \calF_t] - \E[\norm{S_n} - \norm{S_n - X_{t}}\vert \calF_{t-1}])^2. 
$$ 

Expanding the square and taking expectations over $$\calF_{t-1}$$ gives, 

$$
\begin{align}
\E[D_t^2 \vert \calF_{t-1}] &= \E[\E[\norm{S_n} - \norm{S_n - X_t}\vert \calF_{t}]^2\vert \calF_{t-1}]  - \E[\norm{S_n} - \norm{S_n - X_t}\vert \calF_{t-1}]^2 \\ 
&\leq \E[\E[\norm{S_n} - \norm{S_n - X_t}\vert \calF_{t}]^2\vert \calF_{t-1}] \\ 
&\leq \E[(\norm{S_n} - \norm{S_n - X_t})^2 \vert \calF_{t-1}] \\ 
&\leq \E[\norm{X_t}^2 \vert \calF_{t-1}] =: \sigma_t^2.
\end{align}
$$

Now, define $$V_n= \sum_{i=1}\sigma_i^2$$. 
Applying the martingale-variance inequality we obtain that 

$$
\Pr( Z_n \geq Z_0 + \eps) \geq \exp\left(\frac{-\eps^2}{4V_n}\right), \quad\text{for all } \eps\leq \frac{V}{\max_t c_t}.
$$

Notice that, compared to \eqref{eq:variance-martingale-bound} the factor of 2 has disappeared from the constraint on $$\eps$$. This is because our increments $$D_t$$ are bounded as $$2c_t$$. As in the Azuma-Hoeffding case above, we bound $$\E[\norm{S_n}]$$ as $$\sqrt{V_n}$$ and rewrite the above as:  

$$\Pr( \norm{S_n} \geq \sqrt{V_n} + \eps) \geq \exp\left(\frac{-\eps^2}{4V_n}\right), \quad\text{for all } \eps\leq \frac{V}{\max_t c_t},$$

which is the main result. 

We should notice the parallel between what we've done here and the scalar case. Given bounded real-valued random variables, Hoeffding's inequality gives an immediate bound. But if we have  additional moment information we can apply a Bennett or Bernstein style bound. The discussion here generalizes this to the multivariate setting. 

# References 
- [A Large Deviation Inequality for Functions of Independent, Multi-way Choices](https://citeseerx.ist.psu.edu/document?repid=rep1&type=pdf&doi=3b7858b4475d8027cf49c8afbaac34b4229731fb). 
- [Concentration of Measure for the Analysis of Randomized Algorithms](http://wwwusers.di.uniroma1.it/~ale/Corsi/AlgoPro/monograph.pdf), Chapter 8. 








---
layout: note 
date: "2024-03-7" 
title: "The Catoni-Giulini estimator"
description: "An analysis of the Catoni-Giulini estimator for heavy-tailed random vectors"
status: published
---


$$
\newcommand{\E}{\mathbb{E}}
% cals 
\newcommand{\cN}{\mathcal{N}}
\newcommand{\cX}{\mathcal{X}}
\newcommand{\cK}{\mathcal{K}}
% Vector stuff 
\newcommand{\bs}[1]{\boldsymbol{#1}}
\newcommand{\Xvec}{\boldsymbol{X}}
\newcommand{\xvec}{\boldsymbol{x}}
\newcommand{\Yvec}{\boldsymbol{Y}}
\newcommand{\yvec}{\boldsymbol{x}}
\newcommand{\muvec}{\boldsymbol{\mu}}
\newcommand{\muhat}{\widehat{\boldsymbol{\mu}}}
\newcommand{\thetavec}{\boldsymbol{\theta}}
\newcommand{\varthetavec}{\boldsymbol{\vartheta}}
\newcommand{\sphere}{\mathbb{S}}
\newcommand{\sd}{\sphere^{d-1}}
\newcommand{\Cov}{\text{Cov}}
\newcommand{\Var}{\mathbb{V}}
\newcommand{\norm}[1]{\left\|#1\right\|}
\newcommand{\thres}{\text{th}}
\newcommand{\la}{\langle}
\newcommand{\ra}{\rangle}
\newcommand{\d}{\text{d}}
\newcommand{\kl}{D_{\text{KL}}}
\renewcommand{\Re}{\mathbb{R}}
\newcommand{\Tr}{\text{Tr}}
$$

- TOC 
{:toc}

# Introduction

We've previously discussed the [median-of-means estimator]({% link _research_notes/median-of-means-multivariate.md %}) for estimating the mean of random vectors. While median-of-means has sub-Gaussian performance assuming only the existence of the covariance matrix, it's a complicated estimator to implement in the multivariate setting. Remarkably, there's a simple threshold-based estimator [due to Catoni and Giulini](https://arxiv.org/pdf/1802.04308.pdf) that achieves _near_ sub-Gaussian performance. 


Let $$\Xvec_1, \Xvec_2,\dots,\Xvec_n\sim P$$ be iid (this condition can be weakened---see [our paper](https://arxiv.org/pdf/2311.08168.pdf)) with mean $$\muvec$$ and assume that the second moment is bounded by $$v$$: 

$$
\begin{equation}
\E_P \norm{\Xvec}^2 \leq v<\infty. 
\end{equation}
$$

For a positive scalar $$\lambda>0$$ to be chosen later, define the threshold function

$$
\begin{equation}
     \thres(\bs{x}) := \frac{\lambda \norm{\bs{x}} \wedge 1}{\lambda\norm{\bs{x}}}\bs{x}. 
\end{equation}
$$

Here $$a\wedge b = \min(a,b)$$. This function simply shrinks $$\bs{x}$$ towards the origin by an amount proportional to $$\lambda$$ and is clearly easy to implement computationally. The Catoni-Giulini estimator is 

$$
\widehat{\muvec} = \frac{1}{n}\sum_{i=1}^n \thres(\Xvec_i). 
$$ 

Notice that by Cauchy-Schwarz, 

$$
\begin{equation}
\label{eq:muvec-mu-decomp}
\norm{\widehat{\muvec} - \muvec} = \sup_{\varthetavec\in\sd} \la \varthetavec, \widehat{\muvec} - \muvec\ra = \sup_{\varthetavec\in\sd}\frac{1}{n}\sum_{i=1}^n \la \varthetavec, \thres(\Xvec_i) - \muvec\ra,\tag{1}
\end{equation}
$$

where $$\sd = \{\bs{x}\in \Re^d: \norm{\bs{x}=1}\}.$$ Therefore, we'll bound the deviation of $$\widehat{\muvec}$$ from $$\muvec$$ by bounding $$\la \varthetavec, \thres(\Xvec_i) - \muvec\ra$$. We proceed by separating this  quantity into two terms: 

$$
\begin{equation}
\label{eq:thres_decomp}
  \la \varthetavec, \thres(\Xvec_i) - \muvec\ra = \underbrace{\la \varthetavec, \thres(\Xvec_i)  - \muvec^\thres\ra}_{(i)} + \underbrace{\la \varthetavec, \muvec^\thres - \muvec\ra}_{(ii)}, \tag{2}
\end{equation}
$$

where $$\muvec^\thres = \E[\thres(\Xvec)]$$. First we'll bound term (ii) and then we'll bound term (i). 

# Bounding (ii) 

Notice the relationship 

$$
\begin{equation*}
    0\leq 1 - \frac{a\wedge 1}{a}\leq a,\quad \forall a>0. 
\end{equation*}
$$
    
This is easily seen by case analysis. Indeed, for $$a\geq 1$$, we have $$(a\wedge 1)/a = 1/a$$ and $$1-1/a\leq 1\leq a$$. For $$a<1$$, we have $$1-(a\wedge 1)/a = 1 - 1=0\leq a$$. Now, let 

$$\alpha(\Xvec) = \frac{\lambda \norm{\Xvec} \wedge 1}{\lambda \norm{\Xvec}},$$

and note that the above analysis demonstrates that 

$$
\begin{equation}
\label{eq:abs_alpha_bound}
  |\alpha(\Xvec)-1| = 1 - \alpha(\Xvec) \leq \lambda\norm{\Xvec}.   \tag{3}
\end{equation}
$$


Therefore, 

$$
\begin{align*}
    \quad \la \varthetavec,\muvec^\thres - \muvec\ra 
    &= \la \varthetavec, \E[\alpha(\Xvec) \Xvec] - \E[\Xvec]\ra \\ 
    &= \E (\alpha(\Xvec)-1)\la \varthetavec, \Xvec\ra \\ 
    &\leq \E |\alpha(\Xvec)-1||\la \varthetavec, \Xvec\ra| & 
    \\ 
    &\leq \E \lambda \norm{\Xvec} \norm{\varthetavec}\norm{\Xvec} & \text{by \eqref{eq:abs_alpha_bound} and Cauchy-Schwarz} \\
    & = \lambda \E \norm{\Xvec}^2 & 
    \norm{\varthetavec} =1  \\ 
    &\leq \lambda v,
\end{align*}
$$

demonstrating that the second term in \eqref{eq:thres_decomp} is bounded by $$\lambda v$$. 

# Bounding (i)

To handle term (i), we appeal to [PAC-Bayesian]({% link _research_notes/pac_bayes.md %}) techniques. (This was Catoni and Giulini's big insight: the ability to use PAC-Bayesian arguments in estimation problems). We'll use the following bound: 


**Lemma 1.** Let $$f:\cX \times \Theta\to\Re$$ be a measurable function. Fix a prior $$\nu$$ over $$\Theta$$. Then, with probability $$1-\alpha$$ over $$P$$, for all distributions $$\rho$$ over $$\Theta$$, 

$$
\sum_{i\leq t} \int_{\Theta} f(\Xvec_i,\thetavec) \rho(\d\thetavec)
\leq \sum_{i\leq t}\int_{\Theta} \log\E e^{ f(\Xvec,\thetavec)} \rho(\d\thetavec)+ \kl(\rho\|\nu) + \log\frac{1}{\alpha}.
$$

We won't prove this bound (though it's perhaps worth noting that it follows from Proposition 1 in the [last post]({% link _research_notes/subgaussian_concentration.md %})). It's also in Catoni's [treatise](https://arxiv.org/pdf/0712.0248.pdf) on PAC-Bayesian theory. 

Let's apply this result with the function $$f(\Xvec, \thetavec) = \lambda\la \thetavec, \thres(\Xvec) - \muvec^\thres\ra$$.
Keeping in mind that 

$$\E_{\thetavec\sim\rho_{\varthetavec}}\la \thetavec ,\thres(\Xvec_i)-\muvec^\thres\ra 
= \la \varthetavec, \thres(\Xvec_i) - \muvec^\thres\ra,$$

we obtain that with probability $$1-\alpha$$, 

$$
\begin{align}
\label{eq:pb_mgf_applied}
    & \sup_{\varthetavec\in\sd}\sum_{i\leq t} \lambda\la\varthetavec, \thres(\Xvec_i) - \muvec^\thres \ra 
    \le 
    \sum_{i\leq t} \E_{\thetavec\sim\rho_{\varthetavec}}\log \E\left\{ e^{\lambda \la \thetavec, \thres(\Xvec_i) - \muvec^\thres \ra }\right\} + \frac{\beta}{2} + \log\frac{1}{\alpha}. \tag{4}
\end{align}
$$

Next, we bound the right hand side of \eqref{eq:pb_mgf_applied}. To begin, notice that Jensen's inequality gives

$$
\begin{align*}
    &\quad \int  \log \E_{\Xvec\sim P}\left\{ e^{\lambda  \la \thetavec, \thres(\Xvec) - \muvec^\thres \ra  } \right\}  \rho_{\varthetavec}(\d \thetavec)
    \\ &\le  \log \int \E_{\Xvec\sim P}\left\{ e^{\lambda \la\thetavec, \thres(\Xvec) - \muvec^\thres \ra  } \right\}  \rho_{\varthetavec}(\d \thetavec)
    \\ &=  \log \E_{\Xvec\sim P}\left\{ \int e^{  \lambda\la \thetavec, \thres(\Xvec) - \muvec^\thres \ra  } \rho_{\varthetavec}(\d \thetavec) \right\}
    \\ &=  \log \E \exp\left(\lambda\la \varthetavec, \thres(\Xvec) - \muvec^\thres \ra + \frac{\lambda^2}{2\beta} \| \thres(\Xvec) - \muvec^\thres \|^2 \right), 
\end{align*}
$$

where the final line uses the usual closed-form expression of the multivariate Gaussian MGF. 
Define the functions on $$\mathbb R$$

$$g_1(x) := \frac{1}{x}(e^x-1),$$

and 

$$g_2(x) := \frac{2}{x^2}(e^x-x-1),$$

(with $$g_1(0) = g_2(0) = 1$$ by continuous extension).
Both $$g_1$$ and $$g_2$$ are increasing. Notice that 

$$
\begin{equation}
\label{eq:ex+y}
  e^{x+y} = 1 + x+ \frac{x^2}{2}g_2(x) + g_1(y)ye^x.  \tag{5}
\end{equation}
$$

Consider setting $$x$$ and $$y$$ to be the two terms in the CGF above, i.e., 

$$x = \lambda\la \varthetavec, \thres(\Xvec) - \muvec^\thres\ra,$$

$$y = \frac{\lambda^2}{2\beta} \| \thres(\Xvec) - \muvec^\thres \|^2,$$

where we recall that $$\varthetavec\in\sd$$. Before applying \eqref{eq:ex+y} we would like to develop upper bounds on $$x$$ and $$y$$. 
Observe that 

$$
\begin{equation*}
    \norm{\thres(\Xvec)} = \frac{\lambda\norm{\Xvec} \wedge 1}{\lambda} \leq \frac{1}{\lambda}, 
\end{equation*}
$$

and consequently, 

$$\norm{\muvec^\thres} = \norm{\E\thres(\Xvec)} \leq \E\norm{\thres(\Xvec)} \leq \frac{1}{\lambda},$$

by Jensen's inequality. Therefore, by Cauchy-Schwarz and the triangle inequality,  

$$x \leq \lambda\norm{\varthetavec}\norm{\thres(\Xvec) - \muvec^\thres} \leq \lambda(\norm{\thres(\Xvec)} + \norm{\muvec^\thres})\leq 2.$$

Via similar reasoning, we can bound $$y$$ as 

$$
\begin{align*}
    y \leq \frac{\lambda^2}{2\beta}(\norm{\thres(\Xvec)}+\norm{\muvec^\thres})^2 \leq \frac{2}{\beta}. 
\end{align*}
$$

Finally, substituting in these values of $$x$$ and $$y$$ to \eqref{eq:ex+y}, taking expectations, and using the fact that $$g_1$$ and $$g_2$$ are increasing gives 

$$
\begin{align*}
  & \quad \E \left[\exp\left(\la \varthetavec, \thres(\Xvec) - \muvec^\thres \ra + \frac{1}{2\beta} \| \thres(\Xvec) - \muvec^\thres \|^2 \right) \right]  \\ 
  &\leq 1 + \lambda\E [\la \varthetavec, \thres(\Xvec) - \muvec^\thres\ra]  
  + g_2\left(2\right)\frac{\lambda^2}{2}\E[\la \varthetavec, \thres(\Xvec) - \muvec^\thres\ra^2 ]
  \\
  &\qquad + g_1\left(\frac{2}{\beta}\right )\frac{\lambda^2 e^{2}}{2\beta}\E[\norm{\thres(\Xvec) - \muvec^\thres}^2] \\ 
  &\leq 1 + g_2\left(2\right)\frac{\lambda^2}{2}\E[\norm{\thres(\Xvec) - \muvec^\thres}^2 ]
  + g_1\left(\frac{2}{\beta}\right )\frac{\lambda^2 e^{2}}{2\beta}\E[\norm{\thres(\Xvec) - \muvec^\thres}^2],  
\end{align*}
$$

where we've used that $$\E[\thres(\Xvec) - \muvec^\thres]= \bs{0}$$. 
Denote by $$\Xvec'$$ an iid copy of $$\Xvec$$. We can bound the norm as follows: 

$$
\begin{align*}
     \E[\norm{\thres(\Xvec) - \muvec^\thres}^2 ]
    & = \E [\norm{\thres(\Xvec) }^2 ]-  \norm{\muvec^\thres}^2
    \\
     & = \frac{1}{2} \E \left[ \norm{\thres(\Xvec) }^2 - 2\la \thres(\Xvec), \muvec^\thres  \ra + \E [\norm{\thres(\Xvec) }^2] \right]
    \\
     & =\frac{1}{2} \E_{\Xvec} \bigg[\norm{\thres(\Xvec) }^2 - 2\la \thres(\Xvec), \E_{\Xvec'} [\thres(\Xvec')  ]\ra 
     +  \E_{\Xvec'} \left[\norm{\thres(\Xvec') }^2   \right]\bigg] 
     \\
    & =  \frac{1}{2} \E_{\Xvec, \Xvec'} \left[\norm{\thres(\Xvec) - \thres(\Xvec')}^2\right]
    \\
    & \le \frac{1}{2} \E_{\Xvec, \Xvec'} \left[\norm{\Xvec - \Xvec'}^2\right] \\
    &= \E \norm{ \Xvec - \E \Xvec  }^2 \le \E \norm{\Xvec}^2
    \le  v,
\end{align*}
$$

where the first inequality uses the basic fact from convex analysis that, for a closed a convex set $$D\subset \Re^n$$ and any $$\bs{x},\bs{y}\in \Re^n$$,

$$
\begin{equation*}
    \norm{\Pi_D (\bs{x}) - \Pi_D(\bs{y})} \leq \norm{\bs{x}-\bs{y}},
\end{equation*}
$$

where $$\Pi_D$$ is the projection onto $$D$$. We have therefore shown that 

$$
\begin{align*}
    &\int  \log \E_{\Xvec\sim P}\left\{ e^{  \lambda \la\thetavec, \thres(\Xvec) - \muvec^\thres \ra  }\right\}  \rho_{\varthetavec}(\d \thetavec)   \\
    &\leq \log\left\{1 + g_2\left(2\right)\frac{\lambda^2 v}{2} + g_1\left(\frac{2}{\beta}\right)\frac{\lambda^2e^{2}}{2\beta}v\right\} \\ 
    &\leq g_2\left(2\right)\frac{\lambda^2 v}{2} + g_1\left(\frac{2}{\beta}\right)\frac{\lambda^2e^{2}}{2\beta}v \\ 
    &= v\frac{\lambda^2}{4}\left\{e^{2/\beta + 2} -3\right\} \\ 
    &\leq \frac{1}{4}v\lambda^2 e^{2/\beta + 2},
\end{align*}
$$

Dividing both sides of  \eqref{eq:pb_mgf_applied} by $$\lambda$$ and bounding the right hand side via the above display, we've shown that 
with probability $$1-\alpha$$, 

$$
\begin{align}
\label{eq:bound_i}
    & \sup_{\varthetavec\in\sd}\sum_{i=1}^n \la\varthetavec, \thres(\Xvec_i) - \muvec^\thres \ra 
    \le 
    \frac{n}{4}v\lambda e^{2/\beta + 2} + \frac{\beta}{2\lambda} + \frac{\log(1/\alpha)}{\lambda}. \tag{6}
\end{align}
$$




# The main result 



To obtain the main result, we apply \eqref{eq:muvec-mu-decomp} with the bound on term (i) and the bound on term (ii) to obtain that with probability $$1-\alpha$$, 

$$
\begin{align*}
\norm{\widehat{\muvec} - \muvec} &= 
    \sup_{\varthetavec\in\sd}\frac{1}{n}\sum_{i=1}^n \la \varthetavec, \thres(\Xvec_i) - \muvec\ra  \\
    &= \sup_{\varthetavec\in\sd} \frac{1}{n}\sum_{i=1}^n \bigg(\la \varthetavec, \thres(\Xvec_i) - \muvec^\thres\ra + \la\varthetavec, \muvec^\thres - \muvec\ra \bigg) \\
    &= \sup_{\varthetavec\in\sd}\frac{1}{n}\sum_{i=1}^n \la \varthetavec, \thres(\Xvec_i) - \muvec^\thres\ra + \sup_{\varthetavec\in\sd} \frac{1}{n}\sum_{i=1}^n \la\varthetavec, \muvec^\thres - \muvec\ra  \\
    &\leq \frac{1}{4}v\lambda e^{2/\beta + 2} + \frac{\beta}{2n\lambda} + \frac{\log(1/\alpha)}{n\lambda} + \lambda v.
\end{align*}
$$

Taking $$\beta=1$$ and 

$$\lambda \asymp \sqrt{\frac{\log(1/\alpha)}{nv}},$$

we obtain the high probability bound 

$$\norm{\widehat{\muvec} - \muvec} \lesssim \sqrt{\frac{v\log(1/\alpha)}{n}}.$$

Recall that sub-Gaussian estimators have bounds which scale as 

$$O\left(\sqrt{\frac{\lambda_{\max}\log(1/\alpha)}{n}} + \sqrt{\frac{\Tr(\Sigma)}{n}}\right),$$

where $$\lambda_{\max} = \lambda_{\max}(\Sigma)$$ is the maximum eigenvalue of the covariance matrix. Since $$\lambda_{\max} \leq \Tr(\Sigma) \leq v$$, the width of the bound for the Catoni-Giulini estimator is larger than the median-of-means estimator. Depending on the distribution, however, they can be close. 







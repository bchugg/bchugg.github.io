---
layout: note
title: "PAC-Bayes: McAllester and Motivation"
description: "Introduction to PAC-Bayes bounds" 
status: published
date: "2022-11-13"
---


$$
\newcommand{E}{\mathbb{E}}
\newcommand{\F}{\mathcal{F}}
\newcommand{\R}{\mathbb{R}}
\newcommand{\hR}{\widehat{R}}
\newcommand{\kl}{D_{\text{KL}}}
\newcommand{\X}{\mathcal{X}}
\newcommand{\vp}{\varphi}
$$

- TOC 
{:toc}

Suppose we're in the following supervised learning setting. We observe training data $$\{Z_i=(X_i,Y_i)\}_{i=1}^n\subset\mathcal{Z}$$ drawn iid from some unknown distribution $$D$$. We have a family of hypotheses $$\F$$ and oracle access to some unknown loss function $$\ell:\F\times \mathcal{Z}\to\R$$.  The expected risk of a predictor $$f\in\F$$ is $$R(f)=\E_D[\ell(f,Z)]$$, and the empirical risk for $$f$$ is 

$$\hR_n(f)=\frac{1}{n}\sum_{i=1}^n \ell(f,Z_i).$$

Much of learning theory is concerned with bounding the difference between the true risk  and the empirical risk.  Typically, this is done using the PAC (probably approximately correct) framework, in which we try to show that $$\hR_n(f)$$ is not too far from $$R(f)$$ (hence "approximately") with high probability (hence "probably"). A common way to prove PAC bounds is via uniform convergence. 

# 1. The burden of uniform convergence
 A uniform convergence (UC) guarantee has the following form: For any $$\delta\in(0,1)$$, with probability at least $$1-\delta$$, 

$$\sup_{f\in \F} \vert \hR_n(f) - R(f)\vert  \leq G(\F,t,\delta),$$

 where $$G$$ is some function which depends on the family $$\F$$ under consideration, the number of training examples $$n$$, and increases as $$\delta$$ decreases. 

UC guarantees are worst case bounds: we're looking at the supremum over the entire class $$\F$$. It's natural to wonder why we can't just reason about a particular classifier $$\hat{f}\in\F$$ instead. For instance, in practice we usually minimize the training error and choose

$$\hat{f}=\text{argmin}_{f\in\F} \hR_n(f).$$

Let $$f^*=\text{argmin}_{f\in \F} R(f)$$ be the predictor which minimizes the true expected risk. That is, $$f^*$$ is the optimal predictor. We want to understand the true risk of $$\hat{f}$$ vs that of $$f^*$$, which we can decompose as 

$$
\begin{align*}
R(\hat{f}) - R(f^*) &= R(\hat{f}) - \hR_n(\hat{f}) + \hR_n(\hat{f}) - \hR_n(f^*) + \hR_n(f^*) - R(f^*) \\
&\leq R(\hat{f}) - \hR_n(\hat{f}) + \hR_n(f^*) - R(f^*),
\end{align*}$$

since, by definition of $$\hat{f}$$, $$\hR_n(\hat{f})\leq \hR_n(f^*).$$ Now, since $$f^*$$ is independent of the training set, $$\hR_n(f^*)$$ is simply the average of iid random variables $$\ell(f^*,Z_i)$$, which all have mean $$\E[\ell(f^*,Z)] = R(f^*)$$. Therefore, we can use typical concentration inequalities to bound the difference. The difficulty arises in the attempt to bound $$R(\hat{f}) - \hR_n(\hat{f})$$. Since $$\hat{f}$$ is data-dependent, $$\hR_n(\hat{f})$$ is not the sum of iid rvs. This is where UC comes in. Instead of trying to reason about $$\hat{f}$$ in particular, we'll simply bound $$\vert \hR_n(f) - R(f)\vert $$ for all $$f\in\F$$. Combining this UC bound with the concentration inequality gives us a bound on $$R(\hat{f})$$. 

So that's the story of why UC bounds are useful. But they also have their issues. Possibly the most significant is that the function $$G$$ typically depends on either the VC-dimension or Rademacher complexity of $$\F$$. These can be extremely difficult to calculate for many families $$\F$$, especially for families of predictors we like to use in practice. Moreover, even when they can be calculated, the resulting bounds often end up being too loose. That is, in practice, we observe much faster convergence than what UC theory tells us. 

This motivates a different approach to bounding the difference between the empirical error and the true error. 

# 2. PAC-Bayes bounds 

As the name suggests, PAC-Bayes bounds deal with distributions over the hypothesis class, instead of with single hypotheses. Suppose we have a prior distribution $$P$$ over $$\F$$. The PAC-Bayes approach seeks to bound the mixture $$\E_{f\sim Q}[\hR_n(f)]$$ in terms of $$\E_{f\sim Q}[R(f)]$$ for any data-dependent distribution $$Q$$ over $$\F$$. 

As an example, here's one of the earliest PAC-Bayes bounds from McAllester in 1998. It states that if losses are bounded between [0,1], then with probability at least $$1-\delta$$, 

$$
\begin{equation}
\label{eq:mcallester}
\E_{f\sim Q}[R(f) - \hR_n(f)] \leq \bigg(\frac{\kl(Q\vert \vert P) + \log(n/\delta)}{2(n-1)}\bigg)^{1/2}, \tag{1}
\end{equation}
$$

for all $$Q$$. Here, $$\kl(Q\vert \vert P)$$ is the KL-divergence, which we recall is defined as  

$$\kl(Q\vert\vert P) = \E_Q \log(dQ/dP) = \int \log(dQ/dP)dQ,$$

where $$dQ/dP$$ is the Radon-Nikodym derivative of $$Q$$ w.r.t. $$P$$. 

Naturally, we might wonder in what sense this is actually an improvement over uniform convergence. The short answer is that we've lost the dependence on the class $$\F$$ in the right hand side, and replaced it with the KL-divergence between $$Q$$ and $$P$$. 

Consider what happens if $$\F$$ is finite (countable also works), and suppose our data dependent posterior $$Q$$ has unit mass on a single classifier $$\hat{f}$$. Then $$\kl(Q\vert \vert P) = \log(1/P(\hat{f}))$$, so the bound yields 

$$R(\hat{f}) - \hR_n(\hat{f})\leq \bigg(\frac{\log(1/P(\hat{f})) + \log(n/\delta)}{2(n-1)}\bigg)^{1/2} = \bigg(\frac{\log(n/(\delta P(\hat{f}))}{2(n-1)}\bigg)^{1/2}.$$

Let's compare this to the VC theorem, which tells us that, with probability $$1-\delta$$, 

$$R(\hat{f}) - \hR_n(\hat{f}) \leq \bigg(\frac{32\log(s(\F,n)/\delta))}{n}\bigg)^{1/2},$$ 

where $$s(\F,n)$$ is the $$n$$-th shattering coefficient of $$\F$$. Ignoring constants, the two bounds differ by a factor of $$s(\F,n)$$ versus $$n/P(\hat{f})$$ in the log term. We know from Sauer's lemma that $$s(\F,n)\leq (n+1)^{VC(\F)}$$ (for large enough $$n$$) where $$VC(\F)$$ is the VC dimension of $$\F$$. So the bounds differ by a log factor of $$n^{VC(\F)}$$ versus $$n/P(\hat{f})$$. Depending on our prior $$P$$, the latter can be much smaller.

# 3. Proving McAllester's bound 

Okay so let's actually prove McAllester's bound (Equation \eqref{eq:mcallester}) to get a sense of how PAC-Bayes bounds work. Most of the heavy lifting is done by the incredibly useful change-of-measure inequality, which goes back to Donsker and Varadhan in 1975. 

## 3.1 Change of measure 

For a prior $$P$$, the change of measure inequality states that, for any measure $$Q$$ (that is absolutely continuous w.r.t. to $$P$$), 

$$
\begin{equation}
\label{eq:com}
\log \E_{f\sim P} \exp(\vp(f)) \geq \E_{f\sim Q} [\vp(f)] - \kl(Q\vert \vert P), 
\end{equation}
$$

for any function $$\vp:\F\to\R$$. Seeing this involves one trick, and then simply massaging the definition of the KL divergence. The trick is to define a distribution $$P_G$$ via its density w.r.t. to $$P$$: 

$$\frac{dP_G}{dP}(f) = \frac{\exp(\vp(f))}{\E_{h\sim P} \exp(\vp(h))}.$$

This is called the "Gibbs measure". Notice that 

$$
\begin{align}
\kl(Q\vert \vert P) - \kl(Q\vert \vert P_G) &= \int\log\bigg(\frac{dQ}{dP}\bigg) - \log\bigg(\frac{dQ}{dP_G}\bigg)dQ \\
&= \int \log\bigg(\frac{dQ}{dP}\frac{dP_G}{dQ}\bigg)dQ \\
&= \int \log\bigg(\frac{dP_G}{dP}\bigg)dQ \\
&= \E_{f\sim Q}\log \bigg(\frac{\exp(\vp(f))}{\E_{h\sim P}\exp(\vp(h))} \bigg)\\ 
&= \E_Q \vp(f) - \log \E_P \exp(\vp(f)). 
\end{align}
$$

Thus, 

$$\log\E_P\exp(\vp(f)) = \E_Q\vp(f) - \kl(Q\vert \vert P) + \kl(Q\vert \vert P_G) \geq \E_Q\vp(f) - \kl(Q\vert \vert P),$$

since the KL divergence is non-negative. This proves what we wanted to show, but notice we've also showed something stronger. Namely, that there is an equality iff $$Q=P_G$$. 

## 3.2 The proof

In order to prove McAllester's bound, we're going to apply the change of measure inequality to the function $$2(n-1)\Delta(f)^2$$, where $$\Delta(f) = R(f) - \hR_n(f)$$. This gives 

$$\begin{equation}
\exp(2(n-1)\E_Q\Delta^2(f) - \kl(Q\vert \vert P)) \leq \E_P \exp(2(n-1)\Delta^2(f)).
\end{equation}$$

Consider taking the expectation w.r.t. to the sample $$S$$ on both sides. Since $$P$$ is data-free (it's a prior), we can swap the order of $$\E_P$$ and $$\E_S$$ to get 

$$\begin{equation}
\label{eq:mc1}
\E_S[\exp(2(n-1)\E_Q\Delta^2(f) - \kl(Q\vert \vert P))] \leq \E_P \E_S\exp(2(n-1)\Delta^2(f)). \tag{2}
\end{equation}$$


We want to upper bound the right hand side. Since $$f$$ is fixed, we can bound $$\Delta(f)$$ using Hoeffding: 

$$\Pr(\vert \Delta(f)\vert \geq \epsilon) = \Pr(\vert R(f) - \hR_n(f)\vert \geq \epsilon) \leq 2\exp(-2n\epsilon^2).$$

Therefore, since $$2(n-1)\Delta^2(f)\geq 0$$, we have 

$$
\begin{align}
\E_S\exp(2(n-1)\Delta^2(f)) &= \int_0^\infty \Pr(\exp(2(n-1)\Delta^2(f))\geq s)ds \\
&\leq 1 + \int_1^\infty \Pr(\vert \Delta(f)\vert  \geq \sqrt{\log(s)/2(n-1)})ds\\
&\leq 1 + \int_1^\infty 2\exp(-2n\log(s)/[2(n-1)])ds \\
&= 1 + 2(n-1)\leq 2n. 
\end{align}
$$

Plugging this back into Equation \eqref{eq:mc1}, we get 

$$\begin{equation}
\E_S[\exp(2(n-1)\E_Q\Delta^2(f) - \kl(Q\vert \vert P))] \leq 2n.
\end{equation}$$

Therefore, Markov's inequality tells us that 

$$\Pr(\exp(2(n-1)\E_Q\Delta^2(f) - \kl(Q\vert \vert P))>2n/\delta)\leq \delta.$$

That is, with probability at least $$1-\delta$$, 

$$2(n-1)\E_Q\Delta^2(f) \leq \log(2n/\delta) + \kl(Q\vert \vert P).$$

Using Jensen, this gives 

$$(\E_Q\Delta(f))^2 \leq \E_Q\Delta^2(f) \leq \frac{\log(2n/\delta) + \kl(Q\vert \vert P)}{2(n-1)}.$$


Taking the square root of both sides gives the result. Notice that our result has an extra factor of 2 in the log, but I'm not sure how to get rid of it. There's no reason $$\Delta(f)$$ must be positive, so we must use the two-sided Hoeffding. Of course, there might be a different way to prove that $$\E_S[\exp(2(n-1)\Delta^2(f))]\leq n$$. 

Finally, note that this gives us an objective function to optimize. Namely, given a prior $$P$$, solve 

$$\min_Q \bigg\{\E_Q\hR_n(f) + \sqrt{\frac{\kl(Q\vert \vert P) + \log(2n/\delta)}{2(n-1)}}\bigg\}.$$

---
layout: note
title: "OPE in RL vs Mean Estimation in Survey Sampling"
description: "A link between reinforcement learning and survey sampling" 
status: published
date: "2022-05-25"
---

$$
\newcommand{\hgamma}{\hat{\gamma}}
\newcommand{\H}{\mathcal{H}}
\renewcommand{\Pr}{\mathbb{P}}
\newcommand{\S}{\mathcal{S}}
\newcommand{\hmu}{\hat{\mu}}
\newcommand{\hmuht}{\hmu_{\bf NHT}}
\newcommand{\Var}{\mathbb{V}}
\newcommand{\Cov}{\text{Cov}}
\newcommand{\E}{\mathbb{E}}
\newcommand{\htheta}{\hat{\theta}}
\newcommand{\hmuha}{\hat{\mu}_{\bf Háyek}}
\newcommand{\hmudr}{\hmu_{\bf DR}}
\newcommand{\model}{\hat{f}}
\newcommand{R}{\mathbb{R}}
\newcommand{\hy}{\hat{y}}
\newcommand{\hpi}{\hat{\pi}}
\newcommand{\hmum}{\hmu_{\bf Model}}
\newcommand{\hmuipw}{\hmu_{\bf IPW}}
\newcommand{\D}{\mathcal{D}}
\newcommand{\by}{\bar{y}}
\newcommand{\A}{\mathcal{A}}
\newcommand{\hV}{\widehat{V}}
\newcommand{\hVm}{\hV_{\bf Model}}
\newcommand{\hVipw}{\hV_{\bf IPW}}
\newcommand{\hVdr}{\hV_{\bf DR}}
$$

- TOC 
{:toc}


Off Policy Evaluation (OPE) in Reinforement learning and mean estimation in survey sampling are distinct problems and settings, but can employ similar tools. We'll investigate model-based estimates, inverse propensity weighting, and doubly robust estimation in the context of both problems. 


# 1. RL Perspective 

The setting is given by a traditional contextual bandit setup, wherein each timestep some context vector is observed, a policy takes an action from a pre-specified and finite action set $$\A$$, and the resulting reward is revealed. The rewards pertaining to all other untaken actions are not observed. 

More specifically, repeat for $$i=1,\dots,N$$: 
- $$x_i\in\R^d$$ drawn iid from some (unknown) distribution $$\D$$. Call $$x_i$$ the _context_ or _covariates_. 
- Some (unknown) policy $$\gamma$$ takes action $$a_i\in\A$$, possibly depending on history contexts, actions, and rewards to this point. Write $$\gamma_i(a\vert x_i)$$, for the probability that $$\gamma$$ selects action $$a$$, where the index $$i$$ allows for possibility that $$\gamma$$ is a function of the past. Let
- Reward $$y_i\in\R$$ is drawn from $$\D(\cdot\vert x_i,a_i)$$ and revealed to the policy. 

The goal of policy evaluation is to use the data generated in this way to evaluate the expected reward of a policy $$\pi$$, most likely distinct from $$\gamma$$. Formally, if 

$$f(x,a) = \E_{y\sim \D(\cdot\vert x,a)}[y],$$ 

we want to estimate 

$$
\begin{equation}
\label{eq:Vpi}
V(\pi) = \E_{x\sim \D}\E_{a\sim \pi(\cdot\vert x)}[f(x,a)]. \tag{1}
\end{equation}
$$

For simplicitly, we'll assume that $$\pi$$ is _stationary_, i.e., it doesn't change over time. The results are similar if we don't make this assumption, but somewhat harder to interpret as their is an extra sum in all the equations. 

Also, instead of writing out three expectations everytime, we'll often write $$\E_{\pi}$$ to indicate that the expected value in Equation \eqref{eq:Vpi} depends on the policy, i.e., $$V(\pi)=\E_{\pi}[y].$$

So, how would you estimate this? The empirical mean of the select rewards won't do since the actions that gave rise to them were selected by $$\gamma$$, not $$\pi$$. This leads us to modelling the rewards directly. 

## 1.1 Model Based Estimator, $$\hVm$$

One natural approach is to train a model to predict the reward given the context and action. Given such a model $$\model:\A\times\R^d\to\R$$, we can just use the predicted mean of all the data: 

$$\hVm = \frac{1}{N}\sum_{k} \sum_{a\in\A}\pi(a\vert x_k)\model(a,x_k).$$

Clearly, $$\hVm$$ is only as good as $$\model$$. To see this more quantitatively,define 

$$\Delta(a,x)=\model(a,x) - f(a,x),$$

i.e., the difference between the model's estimate of the reward and the true expected reward. Then the expected bias of $$\hVm$$ is 

$$
\begin{align}
\E_{\gamma}[\hVm] &= \sum_{a\in\A} \E_\gamma[\pi(a|x)(\Delta(a,x) + f(a,x))] \\
&= \sum_{a\in\A} \bigg(\E_x[\pi(a\vert x)\Delta(a,x)] + \E_x[\pi(a\vert x)f(a,x))]\bigg) \\ 
&= \bigg(\E_{x,a\sim\pi}[\Delta(a,x)] + \E_{x,a\sim\pi}[f(a,x))]\bigg) \\ 
&= \E_{x,a\sim \pi}[\Delta(a,x)] + V(\pi),
\end{align}
$$

where we've used stationarity of $$\pi$$ to remove the sum over $$k$$. Note also that we're taking the expectation w.r.t. $$\gamma$$, not $$\pi$$. This is because we know what $$\pi$$ is -- we're trying to understand the behavior of our estimates under the uncertainty induced by $$\D$$ and $$\gamma$$. 

Thus, we see that $$\hVm$$ is biased by a linear factor of $$\Delta$$. We get a similar story with the variance. Since each $$x$$ is drawn iid from $$\D$$, we can simply sum the variance across each term to get:   

$$
\begin{align}
\Var_\gamma(\hVm) &= \frac{1}{N^2}\sum_k \Var_{x}\bigg[\sum_{a\in\A}\pi(a|x)\model(a,x)\bigg] \\ 
&= \frac{1}{N}\Var_{x}\bigg[\sum_{a\in\A}\pi(a|x)\model(a,x)\bigg] \\ 
&= \frac{1}{N}\Var_{x}\E_{a\sim \pi}[\model(a,x)]\\ 
&= \frac{1}{N}\Var_{x}\E_{a\sim \pi}[\Delta(a,x) + f(a,x)]\\ 
\end{align}
$$

The quantity $$N^{-1}\Var_x\E_{a\sim\pi}[f(a,x)]$$ is unavoidable variance obtained from sampling according to $$\pi$$. So we see that both the bias and variance of $$\hVm$$ depend on a very natural way on the error of model. 


## 1.2 Inverse Propensity Weighting, $$\hmuipw$$ 

If we're not confident in our ability to obtain a good model of $$f(x,a)$$ (likely in practice, since $$\pi$$ is most likely interested in different regions of the space than $$\gamma$$ - otherwise what are we doing), then we go try instead to estimate the selection probability under $$\gamma$$. If $$\hgamma(a\vert x)$$ is an estimate of $$\gamma(a\vert x)$$, then we can use inverse propensity weighting (IPW): 

$$\hVipw = \frac{1}{N}\sum_{k}\frac{\pi(a_k|x_k)}{\hgamma(a_k\vert x_k)}y_k.$$ 

The idea driving the IPW estimator is to start with the empirical mean of the rewards weighted by their selection probability under $$\pi$$. If rewards were selected at uniformly at random, then this estimator ($$N^{-1}\sum\pi(a_k\vert x_k)y_k$$) would be unbiased. Since they're (probably) not, we have to correct this estimate by dividing by the selection probability under $$\gamma$$. But since we don't have access to $$\gamma$$ we have to use $$\hgamma$$. 

In practice, it is typically easier to get an estimate of $$\gamma$$ than it is to train a reliable $$\model$$, so the IPW estimator is usually preferred over the model-based estimator. 

In order to examine the bias of $$\hVipw$$, define 

$$\lambda(a,x) = \frac{\gamma(a,x)}{\hgamma(a,x)},$$

to be the ratio of the true policy selection probability and our estimate. Then, 

$$
\begin{align}
\E_{\gamma}[\hVipw] &= \E_x\E_{a\sim \gamma}\bigg[\frac{\pi(a\vert x)}{\hgamma(a\vert x)}\E_y[y_k|x,a]\bigg] \\ 
&= \E_x\bigg[\sum_{a\in \A}\frac{\pi(a\vert x)}{\hgamma(a\vert x)}f(a,x)\gamma(a\vert x)\bigg] \\ 
&= \E_x\bigg[\sum_{a\in\A}\lambda(a,x)\pi(a,x)f(a,x)\bigg] \\ 
&= \E_{x,a\sim\pi}[\lambda(a,x)f(a,x)\bigg]. 
\end{align}
$$

Therefore the bias is 

$$\vert \E_\gamma[\hVipw] - V(\pi)\vert| = \E_{\pi}[f(x,a)(1-\lambda(a,x))].$$

That is, if $$\gamma=\hgamma$$ and $$\lambda\equiv 1$$, then the IPW estimator is unbiased. Instead of computing the variance directly, we'll use the fact that the next estimator is a generalization of $$\hVipw$$ to obtain it indirectly. 


## 1.3 Doubly Robust Estimator, $$\hVdr$$

Finally, we come to the _doubly robust_ estimator, which combines the strengths of the previous estimators. Let 

$$F(x) = \sum_{a\in\A}\pi(a\vert x)\model(a,x),$$

be the model estimate for a particular context $$x$$. The DR estimator is  

$$
\begin{align}
\hVdr &= \frac{1}{N}\sum_k \bigg(F(x_k) + \frac{\pi(a_k\vert x_k)}{\hgamma(a_k\vert x_k)}(y_k-\model(a_k,x_k))\bigg).
\end{align}
$$

In words, the doubly robust estimator relies on the model's predicted reward, but corrects the model when the true reward ($$y_k$$) is available. It can be helpful to observe that 

$$
\begin{equation}
\label{eq:vdr2}
\hVdr = \hVm + \hVipw - \frac{1}{N}\sum_{k}\frac{\pi(a_k\vert x_k)}{\hgamma(a_k\vert x_k)}\model(a_k,x_k). \tag{2}
\end{equation}$$

At first glance, this estimator seems a little unwieldy. However, it's useful because it is unbiased whenever either $$\Delta\equiv0$$ _or_ $$\lambda\equiv0$$. To see this, note that the last term in \eqref{eq:vdr2} has expectation 

$$
\begin{align}
\E_\gamma\bigg[\frac{\pi(a\vert x)}{\hgamma(a\vert x)}(\Delta(a,x)+f(a,x))\bigg] &= \E_x\bigg[\sum_a \pi(a\vert x)(\Delta(a,x)+f(a,x))\lambda(a,x)\bigg] \\ 
&= \E_{\pi}[\lambda(a,x)(\Delta(a,x)+f(a,x))]. 
\end{align}
$$

From this and the bias of $$\hVm$$ and $$\hVipw$$ it follows that 

$$
\begin{align}
\E_\gamma[\hVdr] &= \E_\pi[\Delta(a,x)] + V(\pi) + \E_\pi[\lambda(a,x)f(a,x)] - 
\E_\pi[\lambda(a,x)(\Delta(a,x)+f(a,x))] \\ 
&= \E_\pi[\Delta(a,x)(1-\lambda(a,x))] + V(\pi),
\end{align}
$$

that is, 

$$\vert \E_\gamma[\hVdr] - V(\pi)\vert = \E_\pi[\Delta(a,x)(1-\lambda(a,x))],$$

meaning that $$\hVdr$$ is unbiased if either the model $$\model$$ is accurate, or if the estimated policy $$\hgamma$$ is accurate. 

To compute the variance and keep things legible, we'll drop the arguments $$x$$ and $$a$$ from most functions. Consider the second moment of,

$$A_k = F(x_k) + \frac{\pi(a_k\vert x_k)}{\hgamma(a_k\vert x_k)}(y_k - \model(a_k,x_k)),$$

a single term in the sum of $$\hVdr$$. We'll use the same trick as above to convert the expectation over $$\gamma$$ into one over $$\pi$$ (which, we recall is shorthand for the distribution $$x\sim\D,a\sim\pi(\cdot\vert x),y\sim\D(\cdot\vert x,a)$$): 

$$
\begin{align}
\E_\gamma[A_k^2] &= \E_x[F^2] + 2\E_\gamma\bigg[F\frac{\pi}{\hgamma}(y - \model)\bigg] + \E_\gamma\bigg[\frac{\pi^2}{\hgamma^2}(y - \model)^2\bigg] \\ 
&= \E_x[F^2] + 2\E_\pi[F\lambda (y-\model)] + \E_\pi\bigg[\frac{\pi}{\hgamma}\lambda (y-\model)^2\bigg] \\ 
&= \E_x[F^2] + 2\E_{x,a}[F\lambda (f-\model)] + \E_\pi\bigg[\frac{\pi}{\hgamma}\lambda (y-\model)^2\bigg] \\ 
&= \E_{\pi}[(F - \lambda\Delta)^2] - \E_\pi[\lambda^2\Delta^2] + \E_\pi\bigg[\frac{\pi}{\hgamma}\lambda (y-\model)^2\bigg]. 
\end{align}
$$

Noticing from the calculations above that $$\E_\gamma[A_k] = \E_\pi[F-\lambda \Delta]$$, this gives 

$$\Var_\gamma[A_k] = \E_\gamma[A_k^2] - \E_\gamma[A_k]^2 = \Var_\pi[F - \lambda\Delta] - \E_\pi[\lambda^2\Delta^2] + \E_\pi\bigg[\frac{\pi}{\hgamma}\lambda (y-\model)^2\bigg].$$

Set 

$$B=\E_\pi\bigg[\frac{\pi}{\hgamma}\lambda (y-\model)^2\bigg],$$

and notice that 

$$\begin{align}
B &= \E_{x,a,r}[\pi\lambda\hgamma^{-1}(y^2 - 2y\model + \model^2)] \\ 
&= \E_{x,a}[\pi\lambda\hgamma^{-1}(\E_{\D(\cdot\vert x,a)}[y^2] - 2f\model + \model^2)] \\ 
&= \E_{x,a}[\pi\lambda\hgamma^{-1}(\E_{\D(\cdot\vert x,a)}[y^2] - f^2 + \Delta^2)] \\ 
&= \E_{x,a}[\pi\lambda\hgamma^{-1}(\Var_{\D(\cdot\vert x,a)}[y] + \Delta^2)].
\end{align}
$$

Applying total variance,

$$
\begin{align}
\Var_\gamma[A_k] &= \Var_x\E_{a\sim\pi}[F-\lambda\Delta] + \E_x\Var_{a\sim\pi}[F-\lambda\Delta] - \E_\pi[\lambda^2\Delta^2] + B \\ 
&= \Var_x[F - \E_a\lambda\Delta] + \E_x\Var_a[\lambda\Delta] - \E_\pi[\lambda^2\Delta^2] + B  \\ 
&=  \Var_x\E_{a\sim\pi}[\model - \lambda\Delta] + \E_x[\E_a[(\lambda\Delta)^2]] - \E_x[\E_a[\lambda\Delta]^2] - \E_\pi[\lambda^2\Delta^2] + B\\
&= \Var_x\E_{a\sim\pi}[f + \Delta(1-\lambda)] - \E_x[\E_a[\lambda\Delta]^2] + B.
\end{align}
$$

Finally, putting everything together we get 

$$
\begin{equation}
\label{eq:V_dr}
\Var_\gamma[\hVdr] = \frac{1}{N}\bigg(\Var_x\E_{a\sim\pi}[f + \Delta(1-\lambda)] - \E_x[\E_a[\lambda\Delta]^2] + \E_{x,a}[\frac{\pi\lambda}{\gamma}(\Var[y]+ \Delta^2)]\bigg).  \tag{3}
\end{equation}
$$

Noting that $$\hVipw$$ is $$\hVdr$$ with $$\model\equiv0$$ (hence $$\Delta=-f$$), we also get the variance for the IPW estimator: 

$$
\begin{equation}
\label{eq:V_ipw}
\Var_\gamma[\hVipw] = \frac{1}{N}\bigg(\Var_x\E_{a\sim\pi}[f\lambda] - \E_x[\E_a[f\lambda]^2] + \E_{x,a}[\frac{\pi\lambda}{\hgamma}(\Var_{\D(\cdot\vert x,a)}[y]+ f^2)]\bigg).  \tag{4}
\end{equation}
$$

## 1.4 Upshot 

A key distinction between Equations \eqref{eq:V_dr} and \eqref{eq:V_ipw} is the third term. The variance of IPW depends on the true values $$f(a,x)$$ whereas the variance of DR depends on the model residuals $$\Delta(a,x)$$. Under a good model fit, therefore, the variance of the doubly robust estimator can be significantly smaller. 

Consider what happens when either $$\Delta=0$$ or $$\lambda=1$$ (model is accurate or estimated selection probability is accurate). Then 

$$\Var(\hVipw) - \Var(\hVdr) = \frac{1}{N}\bigg(\E_{x,a}\bigg[\frac{\pi}{\gamma}f^2\bigg] - \E_x[\E_a[f]^2]\bigg).$$ 

If $$\gamma=\hgamma$$ is small with non-negligible probability, then this difference can be large. 

On the other hand, the model based variance isn't a function of the randomness in rewards ($$\Var[y]$$ or the policy $$\gamma$$, so can be much smaller in general. In practive, however, it's often harder to generate a reliable model $$\model$$ than a estimate of $$\gamma$$. 


# 2. Survey Sampling Perspective 

Let $$[N]=\{1,\dots,N\}$$ be a finite population of $$N$$ distinct units. Each $$i\in X$$ has a hidden value $$y_i$$ and observable quantities $$x_i\in\R^d$$. A sample $$S\subset [N]$$ of size $$n$$ has been drawn according to the _inclusion probabilities_ $$\pi_i=\Pr(i\in S)$$. The goal is to estimate the true mean of the population 

$$
\begin{equation}
\label{eq:mean}
\mu = \frac{1}{N}\sum_{i\in [N]} y_i. \tag{5}
\end{equation}
$$

This is the equivalent to estimating average reward in RL, but the two settings are clearly quite distinct. For one, we're not assuming a distribution over the covariates $$x_i$$; they're simply given. This will be important for variance calculations, since there's no independence assumptions and we can't ignore covariance. Second, we assume that the probabilities $$\pi_i$$ are known. You can change this assumption without too much fuss, in which case the results here resemble the RL setting more closely. Finally, in survey sampling, we typically don't assume that the hidden values are generated from a conditional distribution of the context. Instead, they're deterministic given the covariates. All of these assumptions simplify the calculations. 

Still, ignoring the details, the two settings can be tackled with similar approches. You can imagine training a model $$\model:\R^d\to\R$$ to predict the reward given the covariates, and then estimating the mean by simply predicting over the population: 

$$\hmum = \frac{1}{N}\sum_{i\in[N]} \model(x_i).$$ 

If $$\Delta(x_i) = \model(x_i) - y_i$$, then the bias of $$\hmum$$ is 

$$\E_\model[\hmum] = \frac{1}{N}\sum_i \E_\model[\Delta(x_i)] + \mu,$$

which is very similar to the RL setting. Note the only randomness is any randomness in the model. 

The IPW estimator (also called the Narain-Horvitz-Thompson estimator in sampling theory) is 

$$
\begin{equation}
\hmuipw = \frac{1}{N}\sum_{i\in [N]} \frac{y_i}{\pi_i}\delta_S(i), 
\end{equation}
$$

where $$\delta_S(i)=1$$ if $$i\in S$$ and 0 otherwise. Since $$\E[\delta_S(i)] = \pi_i$$, it's easy to see that $$\E[\hmuht] = \mu$$. If we didn't know the inclusion probabilities then we could use estimates $$\hpi$$ and we'd obtain a bias which depends multiplicatively on the ratio $$\pi/\hpi$$ as above. 

The DR estimator uses both the model predictions and the observed rewards: 

$$
\begin{equation}
\hmudr = \frac{1}{N}\sum_{i\in [N]}\bigg(\frac{y_i-\model(x_i)}{\pi_i}\delta_S(i) + \model(x_i)\bigg).
\end{equation}
$$

In the survey sampling setting, the intuition behind the DR estimator is even clearer. Essentially, we're relying on the model estimates for those elements we didn't sample and correcting the estimate where we have the true label. As with the IPW estimator, it's easy to see that $$\hmudr$$ is unbiased. 

## 2.1 Inclusion Probabilities

A brief aside on the probabilities $$\pi_i$$. Let $$\S=\{S_1,\dots,S_{N\choose n}\}$$ be the set of all possible sets of sampled elements. Note that $$\Pr=\Pr_\S$$ is a measure on $$\S$$. 
Inclusion probabilities do not behave as a typical distribution because they are defined over multiple rounds of sampling. In particular, $$\sum_i \pi_i \neq 1$$. Instead, 

$$\sum_i \pi_i = \sum_i \sum_{S\in\S} \Pr(S) \delta_S(i) = \sum_{S\in \S}\Pr(S)\sum_i \delta_S(i) = n\sum_{S\in \S}\Pr (S) = n,$$

since $$\vert S\vert=n$$ for each $$S\in\S$$. Here $$\delta_S(i)$$ indicates whether $$i\in S$$. 

We can also define higher order inclusion probabilities. For $$i\neq j$$, let $$\pi_{i,j}=\Pr(i,j\in S)$$, and so on. 


## 2.2 Variance Calculations

Put 

$$A(z) = \sum_{i\in [N]} \frac{z_i}{\pi_i}\delta_S(i).$$ 

Then 

$$
\begin{align}
\Var(A(z)) &= 
\sum_{i\in [N]}\frac{z_i^2}{\pi_i^2}\Var(\delta_S(i)) + \sum_{i\in [N]}\sum_{j\neq i}\frac{z_iz_j}{\pi_i\pi_j}\Cov(\delta_S(i),\delta_S(j)) \\
&= \sum_{i\in [N]}\frac{z_i^2}{\pi_i}(1-\pi_i) + \sum_{i\in [N]}\sum_{j\neq i}\frac{z_iz_j}{\pi_i \pi_j}(\pi_{i,j}-\pi_i\pi_j), 
\end{align}
$$

since $$\Var(\delta_S(i)) = \E[\delta_S(i)] - \E[\delta_S(i)]^2 = \pi_i(1-\pi_i)$$ and similarly for the covariance. (Note that $$\delta_S(i)=\delta_S(i)^2$$.) Now, note that sampling one set of $$n$$ elements is a disjoint event from sampling another. Thus we can write 

$$
\begin{align}
\sum_{j\neq i}\pi_{i,j}&=\sum_{j\neq i}\sum_S \Pr(S)\delta_S(i)\delta_S(j)=\sum_{S:i\in S}\Pr(S)\sum_{j\neq i}\delta_S(j)\\
&= (n-1)\sum_S \Pr(S)\delta_S(i) = (n-1)\pi_i.
\end{align}
$$

Consequently, 

$$\sum_{j\neq i}(\pi_{i,j}-\pi_i\pi_j) = (n-1)\pi_i - \pi_i(n-\pi_i) = \pi_i(\pi_i-1).$$

Plugging this into the first sum of $$\Var(A(z))$$ we have 

$$
\begin{align}
\Var(A(z)) &= -\sum_{i\in [N]}\frac{z_i^2}{\pi_i^2}\sum_{j\neq i}(\pi_{i,j}-\pi_i\pi_j)+ \sum_{i\in [N]}\sum_{j\neq i}\frac{z_iz_j}{\pi_i \pi_j}(\pi_{i,j}-\pi_i\pi_j)\\
&= \sum_{i\in [N]}\sum_{j\neq i}\bigg(\frac{z_iz_j}{\pi_i \pi_j}-\frac{z_i^2}{\pi_i^2}\bigg)(\pi_{i,j}-\pi_i\pi_j) \\ 
&= \frac{1}{2}\sum_{i\in [N]}\sum_{j\neq i}\bigg(\frac{z_i}{\pi_i}-\frac{z_j}{\pi_j}\bigg)^2(\pi_i\pi_j-\pi_{i,j}).
\end{align}
$$

In the last line we completed the square and divided by two to account for the extra terms being introduced. 

Using this, we can write out the variance of both the NHT and doubly-robust estimators: 

$$\Var(\hmuht) = \frac{1}{2N^2}\bigg\{\sum_{i,j\in [N]}\bigg(\frac{y_i}{\pi_i}-\frac{y_j}{\pi_j}\bigg)^2(\pi_i\pi_j-\pi_{i,j})\bigg\},$$

and 

$$\Var(\hmudr) = \frac{1}{2N^2}\bigg\{\sum_{i,j\in [N]}\bigg(\frac{y_i-\hy_i}{\pi_i}-\frac{y_j-\hy_j}{\pi_j}\bigg)^2(\pi_i\pi_j-\pi_{i,j})\bigg\}.$$

These look similar, but the squared terms differ quite drastically in their behaviour. First, notice that $$\Var(A(z))=0$$ if $$z_i/\pi_i$$ is constant for every $$i$$. For the NHT estimator, $$z_i=y_i$$, implying the variance is zero if we chose the inclusion probabilities to be proportional to the true values. Of course, we don't know the true values, so this is hard to do. For DR, $$z_i=y_i-\hy_i$$, so the variance will be zero if the signed residual between the true value and the model's prediction is proportional the inclusion probability. 

In order to say anything about which one is better, we'd need to know more about the model estimates $$\hy_i$$. Beyond that, comparing the estimators term-by-term is difficult because of the pesky joint inclusion probabilities $$\pi_{i,j}$$. For an unspecified sampling design, we can't say whether the terms $$\pi_i\pi_j-\pi_{i,j}$$ are positive or negative, so proving general theorems about the estimators is difficult. 

On the other hand, the variance of the model based estimator depends on the model errors and the true rewards

$$\Var(\hmum) = \frac{1}{N^2}\sum_{i,j}\Cov(\Delta(x_i)+y_i,\Delta(x_j)+y_j),$$ 

which can be smaller than the either of the variances above for a well-calibrated model. In general then, there is a bias-variance tradeoff  in the choices of estimators. 


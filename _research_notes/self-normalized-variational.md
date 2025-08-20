---
layout: note 
date: "2025-02-28" 
title: "A variational approach to sub-Gaussian self-normalized bounds"
description: "Recovering the Abbasi-Yadkori result using different techniques"
status: published
---

$$
\newcommand{\E}{\mathbb{E}}
\newcommand{\calF}{\mathcal{F}}
\renewcommand{\Re}{\mathbb{R}}
\newcommand{\la}{\langle}
\newcommand{\ra}{\rangle}
\newcommand{\d}{\text{d}}
\newcommand{\kl}{\text{KL}}
\renewcommand{\Pr}{\mathbb{P}}
\newcommand{\Tr}{\text{Tr}}
$$

Self-normalized bounds for martingales arise naturally in various statistical tasks, from regression to bandits. [De La Peña](https://scholar.google.com/citations?view_op=list_works&hl=en&hl=en&user=9W4bmC4AAAAJ) and coauthors did a tremendous amont of work on self-normalized bounds in the 90s and 2000s, and in 2011 [Abbasi-Yadkori et al](https://proceedings.neurips.cc/paper/2011/file/e1d5be1c7f2f456670de3d53c7b54f4a-Paper.pdf) applied some of their results to contextual bandits. The resulting concentration inequality has become a famous self-normalized bound. 

 
To state it, let $$X_1,X_2,\dots$$ be a sequence of vectors in $$\Re^d$$. Let $$\eta_1,\eta_2,\dots$$ be a sequence of mean-zero, conditionally $$\sigma^2$$-sub-Gaussian random variables in $$\Re$$, i.e., 

$$ 
\E_{t-1} \exp(\lambda \eta_t ) \leq \exp\left(\psi(\lambda\sigma)\right),
$$

for all $$\lambda\in\Re$$ where $$\psi(u) = u^2/2$$ and $$\E_{t-1}[\cdot]\equiv \E[\cdot \vert \calF_{t-1}]$$ and $$\calF=(\calF_t)_{t\geq 1}$$ is some filtration. We assume that $$(X_t)$$ is $$\calF$$-predictable, meaning that $$X_t$$ is $$\calF_{t-1}$$-predictable. In the bandit setting, $$X_t$$ is the action chosen at time $$t$$,  which is made with the information available at time $$t-1$$. $$\eta_t$$ is the noise accompanying the observed reward. 


Set

$$
S_t = \sum_{k\leq t} \eta_k X_k, \quad V_t = \sum_{k\leq t} X_kX_k^t. 
$$ 

Let $$V_0$$ be some PSD matrix. The Abbasi-Yadkori bound reads: With probability $$1-\delta$$, for all stopping times $$\tau$$,  

$$
\|S_\tau\|_{(V_\tau + V_0)^{-1}}^2 \leq 2\sigma^2 \log\left(\frac{\det^{1/2}(V_\tau + V_0)}{\delta\det^{1/2}(V_0)}\right), \tag{1} \label{eq:abbasi_bound} 
$$

where $$ \|Y\|^2_{A} = Y^t A Y$$. If the rewards we observe are of the form $$Y_t = \la \theta^*, X_t\ra + \eta_t$$, \eqref{eq:abbasi_bound} allows us to derive confidence sets for $$\theta^*$$. 

Abbasi-Yadkori et al. use the method of mixtures to prove their bound. Recently, [Ingvar Ziemann noticed](https://arxiv.org/pdf/2412.20949) that one can recover the result using the [variational approach to concentration]({% link _research_notes/variational_approach_to_concentration.md %}). I'm very curious about the limits of this approach, so I want to explore how this is done. 

Let's recall the main template used in the variational approach to concentration. 

**Proposition 1.** Fix a parameter space $$\Theta$$, and let $$M(\theta)\equiv (M_t(\theta))$$ be a nonnegative supermartingale with initial value 1 for each $$\theta\in \Theta$$ with respect to a filtration $$\calF$$. For any data-free distribution $$\pi$$ over $$\Theta$$, with probability $$1-\delta$$, for any (data-dependent) distribution $$\rho$$ over $$\Theta$$ and stopping-time $$\tau$$, 

$$
\label{eq:template}
\int M_t(\theta) \d\rho \leq \kl(\rho\|\nu) + \log(1/\delta). \tag{2}
$$

Let's prove \eqref{eq:abbasi_bound} using this proposition. By virtue of the sub-Gaussianity of $$\eta_t$$, we have 

$$\E_{t-1} \exp( \eta_t \la \theta, X_t\ra - \psi(\sigma\la\theta, X_t\ra))\leq 1,$$ 

implying that the process defined by these increments, namely 

$$M_t(\theta) = \prod_{k\leq t}  \exp\left\{\la \theta, \eta_k X_k\ra - \psi(\sigma\la \theta, X_k\ra) \right\} = \exp\left\{\la \theta, S_t\ra - \psi(\sigma \|\theta\|_{V_t})\right\},$$

$$M_0(\theta) \equiv 1$$, is a (nonnegative) supermartingale. (Note that here we've used that $$\sum_{k\leq t}\la \theta, X_k\ra^2 = \sum_k \la \theta, X_kX_k^t \theta\ra = \|\theta\|_{V_t}^2$$.) Define 

$$U_t = \sigma^2(V_t + V_0),$$

and observe that we can rewrite 

$$
\begin{align}
2\la \theta, S_t\ra - \sigma^2\|\theta\|_{V_t}^2 &= 2\theta^t S_t\theta - \theta^t U_t\theta +   \sigma^2\theta^t V_0\theta \\ 
&= S_t U_t^{-1}S_t - \theta^t U_t\theta + 2\theta^t U_tU_t^{-1}S_t - S_t^t U_t^{-1} U_tU_t^{-1}S_t + \sigma^2\theta^tV_0\theta \\ 
&= S_t^t U_t^{-1} S_t - (\theta - U_t^{-1}S_t)^tU_t(\theta - U_t^{-1}S_t) + \sigma^2\theta^tV_0\theta \\ 
&= \|S_t\|^2_{U_t^{-1}} - \|\theta - U_t^{-1}S_t\|_{U_t}^2 +  \sigma^2\|\theta\|^2_{V_0}.
\end{align}
$$

Therefore, 

$$ M_t(\theta) = \exp\left\{ \frac{1}{2}\|S_t\|^2_{U_t^{-1}} - \frac{1}{2}\|\theta - U_t^{-1}S_t\|_{U_t}^2 + \frac{\sigma^2}{2}\|\theta\|^2_{V_0}\right\}.$$


Fix a data-free distribution $$\pi$$ over $$\Re^d$$ and let $$\rho$$ be a Gaussian with mean $$\mu_\rho$$ and covariance $$\Sigma_\rho$$. Then 

$$
\begin{align}
\int \log M_t(\theta) \d\rho &= \frac{1}{2}\|S_t\|_{U_t^{-1}} - \frac{1}{2}\int \|\theta - U_t^{-1} S_t\|_{U_t}^2 \d\rho + \frac{\sigma^2}{2}\int \theta^tV_0\theta \d\rho \\ 
&= -\frac{1}{2}\int (\theta^t U_t\theta - 2\theta^t S_t)\d\rho  + \frac{\sigma^2}{2}\left(\mu_\rho^t V_0\mu_\rho + \Tr(V_0\Sigma_\rho)\right) \\ 
&= -\frac{1}{2}\left( \mu_\rho^t U_t\mu_\rho + \Tr(U_t \Sigma_\rho) - 2\mu_\rho^t S_t\right) + \frac{\sigma^2}{2}\left( \mu_\rho^tV_0\mu_\rho + \Tr(V_0\Sigma_\rho)\right)
\end{align}
$$

Consider taking $$\mu_\rho = U_t^{-1} S_t$$. Then the above simplifies to 

$$
\begin{align}
\int\log M_t(\theta) \d\rho &= \frac12\left(S_t^t U_t^{-1} S_t - \Tr(U_t\Sigma_\rho) + \sigma^2(S_t^t U_t^{-1}V_0U_t^{-1} S_t + \Tr(V_0\Sigma_\rho))\right) \\ 
&= \frac12\left(S_t^t U_t^{-1} S_t - \sigma^2\Tr(V_t\Sigma_\rho) +  \sigma^2S_t^t U_t^{-1}V_0U_t^{-1} S_t \right), \tag{3} \label{eq:ut2}
\end{align}
$$

since $$\Tr(U_t \Sigma_\rho ) = \sigma^2\Tr(V_t\Sigma_\rho) + \sigma^2\Tr(V_0 \Sigma_\rho)$$. Now let's choose $$\pi$$. If we take $$\pi$$ to be normal with mean 0 and covariance $$\Sigma_\pi$$ then, using the standard formula for KL-divergence, 

$$
\begin{align}
\kl(\rho\|\pi) &= \frac12\left\{\Tr(\Sigma_\pi^{-1}\Sigma_\rho) + \mu_\rho^t \Sigma_\pi^{-1}\mu_\rho - d + \log\left(\frac{\vert\Sigma_\pi\vert}{\vert \Sigma_\rho\vert}\right) \right\} \\ 
&= \frac12\left\{\Tr(\Sigma_\pi^{-1}\Sigma_\rho) + S_t^t U_t^{-1} \Sigma_\pi^{-1} U_t^{-1}S_t - d + \log\left(\frac{\vert\Sigma_\pi\vert}{\vert \Sigma_\rho\vert}\right) \right\}.
\end{align}
$$

In order to cancel out the term $$\sigma^2 S^t U_t^{-1}V_0 S_t$$ in \eqref{eq:ut2}, we should choose $$\Sigma_\pi^{-1} = \sigma^2 V_0$$ (this is data-free hence legal). In this case, our guarantee in Proposition 1 reads, for all stopping times $$\tau$$, 

$$
\begin{align}
\frac{1}{2} \|S_\tau\|_{U_\tau^{-1}}^2 &\leq \frac{1}{2}\left(\sigma^2\Tr(V_\tau\Sigma_\rho) + \sigma^2\Tr(V_0 \Sigma_\rho) -d + \log(\vert V_0^{-1}\vert/ \vert \Sigma_\rho\vert) \right) + \log(1/\delta) \\ 
&= \frac{1}{2}\left(\Tr(U_\tau\Sigma_\rho) -d + \log(\vert V_0^{-1}\vert/ \vert \Sigma_\rho\vert) \right) + \log(1/\delta)
\end{align}
$$

Consider choosing $$\Sigma_\rho = U_\tau^{-1}$$. Then $$\Tr(U_t \Sigma_\rho) =d$$, so the above bound becomes 

$$
\begin{align}
\|S_\tau\|_{U_\tau^{-1}}^2 &\leq \log\left(\frac{\det U_\tau}{\det \sigma^2 V_0}\right) + 2 \log(1/\delta)  \\ 
&= \log\left(\frac{\det (V_\tau + V_0)}{\det V_0}\right) + 2 \log(1/\delta).
\end{align}
$$

Noticing that $$\|S_\tau\|_{U_\tau^{-1}}^2 = \sigma^{-2}\| S_\tau \|_{(V_\tau + V_0)^{-1}}^2$$, we recover \eqref{eq:abbasi_bound} precisely. 











 















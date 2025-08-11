---
layout: note 
date: "2025-08-08" 
title: "The mixture approach to sub-Gaussian self-normalized bounds"
description: "The standard way to prove the famous sub-Gaussian self-normalized bound"
status: published
---

In this section we show that the method of mixtures---the proof method used by \citet{abbasi2011improved} and \citet{pena2008self}---can also be used to prove Theorem~\ref{thm:sub-gaussian}. To repeat what was said in that section, existing proofs assume that $V_t$ is predictable, not adapted. Here we show that the same proof technique can accommodate an adapted variance process. 

Let $(S_t,V_t)$ be a sub-$\psi_N$ process, implying that for all $\theta\in\Re^d$,
\[M_t(\theta) = \exp\left\{ \la \theta, S_t\ra - \psi_N(1)\la \theta, V_t\theta\ra\right\} \leq N_t(\theta),\]
where $(N_t(\theta))$ is a nonnegative supermartingale. (To see why we can consider all $\theta\in\Re^d$ instead of $\theta\in\dsphere$, see Section~\ref{proof:sub-gaussian} below.) Let $\nu$ be a Gaussian with mean 0 and covariance $U_0^{-1}$ and consider the process with increments
\begin{equation}
    M_t = \int_{\Re^d} \exp\{  \la \theta, S_t\ra - \psi_N(1)\la \theta, V_t\theta\ra \}\nu(\d\theta).  
\end{equation}
To compute $M_t$, notice that we can write 
\begin{equation*}
    \la\theta, S_t \ra - \psi_N(1) \la \theta, V_t\theta\ra = \frac{1}{2}\|S_t\|_{V_t^{-1}} - \frac{1}{2}\|\theta - V_t^{-1}S_t\|_{V_t}^2, 
\end{equation*}
and 
\begin{equation*}
  \| \theta - V_t^{-1}S_t\|_{V_t}^2 +\la \theta, U_0\theta\ra  = \|\theta - (U_0 + V_t)^{-1}S_t\|_{U_0 + V_t}^2 -2\|S_t\|_{V_t^{-1}}^{2} +2\|S_t\|_{(U_0 + V_t)^{-1}}^2. 
\end{equation*}
Hence, writing out the density of $\nu$,  
\begin{align*}
    M_t &= \frac{\exp(\frac{1}{2}\|S_t\|_{V_t^{-1}}) }{\sqrt{2\pi \det(U_0^{-1})}} \int_{\Re^d} \exp\left(- \frac{1}{2}\| \theta - V_t^{-1}S_t\|_{V_t}^2 - \frac{1}{2}\la \theta, U_0\theta\ra\right) \d\theta  \\ 
    %&= \frac{\exp(\frac{1}{2}\|S_t\|_{V_t^{-1}}) }{\sqrt{2\pi \det(U_0^{-1})}} \int_{\Re^d} \exp\left(- \frac{1}{2}\left(\|\theta - (U_0 + V_t)^{-1}S_t\|_{U_0 + V_t}^2 +\|S_t\|_{V_t^{-1}}^{2} -\|S_t\|_{(U_0 + V_t)^{-1}}^2\right)\right) \d\theta \\ 
    &= \frac{\exp(\frac{1}{2}\|S_t\|_{(U_0 + V_t)^{-1}}^2)}{\sqrt{2\pi \det(U_0^{-1})}} \int_{\Re^d} \exp\left(- \frac{1}{2}\|\theta - (U_0 + V_t)^{-1}S_t\|_{U_0 + V_t}^2  \right) \d\theta\\
    &= \frac{\exp(\frac{1}{2}\|S_t\|_{(U_0 + V_t)^{-1}}^2)}{\sqrt{2\pi \det(U_0^{-1})}} 
    \sqrt{2\pi \det((U_0 + V_t)^{-1}} \\ 
    &= \sqrt{\frac{\det(U_0)}{\det(U_0 + V_t)}} \exp\left(\frac{1}{2}\|S_t\|_{(U_0 + V_t)^{-1}}^2\right). 
\end{align*}
Since $\int N_t(\theta) \d\nu(\theta)$ is a supermartingale by Fubini's theorem, $M_t$ remains upper bounded by a nonnegative supermartingale. We may thus apply Ville's inequality to obtain $P(M_\tau \geq 1/\delta) \leq \E[M_1]\delta\leq \delta$. In other words, with probability $1-\delta$, $\log M_\tau \leq 1/\delta$, which translates to 
\[
\frac{1}{2}\|S_\tau\|^2_{(U_0 + V_\tau)^{-1}} \leq \frac{1}{2}\log\left(\frac{\det (U_0 + V_\tau)}{\det U_0}\right) + \log(1/\delta),
\]
which is precisely Theorem~\ref{thm:sub-gaussian}. 


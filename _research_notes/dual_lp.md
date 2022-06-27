---
layout: note
title: Intuition for LP Duality
description: "Short derivation of the dual of a linear program" 
status: published
date: "2022-01-16"
---

$$\newcommand{R}{\mathbb{R}}$$

Suppose we have the following basic linear program: 

$$\begin{align*}
\max_{x_1,x_2} \quad &  3x_1+2x_2 \\
 \text{s.t.} \quad & x_1+x_2/2\leq 1, \\
 & 4x_1+5x_2\leq 5, \\ 
 & x_1,x_2\geq 0.
\end{align*}$$

What's an upper bound on the solution? Five is one, simply because the coefficients of the second constraint are larger than those in the objective. If $$4x_1+5x_2\leq 5$$ then because $$3x_1\leq 4x_1$$, $$2x_2\leq 5x_2$$, we have $$3x_1+2x_2\leq 5$$ as well. We could also divide the second constraint through by 3/4 and get that $$3x_1+15x_2/4\leq 15/4$$, hence 15/4 is another (tighter) upper bound. If we divide the second constraint by anything smaller than 3/4 however, the coefficient of $$x_1$$ will become smaller than 3 (the coefficient of $$x_1$$ in the objective function), hence it will not be an upper bound. However, we can get an even tighter bound via linear combinations of the first and second constraints. Dividing the second constraint by 2, and then adding the first constraint yields $$3x_1+3x_2\leq 7/2$$, so we get a third, even tigher, upper bound of $$7/2$$. 

We could go on like this, but we can also formulate this process as an optimization problem. In the cases above, we multiply the two constraints by $$y_1$$ and $$y_2$$: 

$$\begin{align*}
&y_1(x_1+x_2/2)\leq y_1,\\
&y_2(4x_1+5x_2)\leq 5y_2,
\end{align*}$$

and sum the equations. (In the first two attempts, $$y_1=0$$). So that the inequalities don't flip, we need $$y_1,y_2\geq 0$$. We also need to ensure that $$y_1$$ and $$y_2$$ are large enough so that the coefficients of the result are larger than the coefficients of the objective function. That is, we need that $$y_1+4y_2\geq 3$$ and $$y_1/2+5y_2\geq 2$$. The bound is then $$y_1+5y_2$$. We want the smallest such upper bound, so we want to minimize that sum. That is, we want to solve

$$\begin{align*}
\min_{y_1,y_2} \quad &y_1+5y_2 \\
\text{s.t.}\quad & y_1+4y_2\geq 3, \\ 
& y_1/2+5y_2\geq 2, \\
& y_1,y_2\geq 0.
\end{align*}$$

That's the dual linear program! If we started with the minimization version, we could repeat much the same process and obtain the maximization version. This can be generalized to arbitrary LPs. The LP

$$\begin{align*}
\max_{\bf{x}\in\R^n} \quad &\sum_{k=1}^n c_kx_k \\ 
\text{ s.t. }\quad & \forall j\in[m]: \sum_{k=1}^n a_{jk}x_k\leq b_j, \\
& \bf{x}\geq 0,
\end{align*}$$

has dual

$$\begin{align*}
\min_{\bf{y}\in\R^m} \quad & \sum_{k=1}^m b_ky_k \\
\text{ s.t. }\quad & \forall j\in[n]: \sum_{k=1}^m a_{kj}y_k\geq c_j, \\
& \bf{y}\geq 0,
\end{align*}$$

and vice versa. More concisely: 

$$\max_{\bf{x}} \bf{c}^T\bf{x} \quad\text{s.t.}\quad A\bf{x}\leq \bf{b},\;\bf{x}\geq 0,$$

has dual 

$$\min_{\bf{y}}\bf{b}^T\bf{y}\quad\text{s.t.}\quad A^T\bf{y}\geq \bf{c},\;\bf{y}\geq 0.$$

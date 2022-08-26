---
layout: note 
date: "2022-03-21" 
title: "Supermartingales for Nonparametric Confidence Sequences"
description: "Achieving nonparametric confidence sequences by "
status: unpublished
---

$$
\renewcommand{\Pr}{\mathbb{P}}
\newcommand{\E}{\mathbb{E}}
$$

Suppose you observe a continuous stream of iid data on $$X_1,X_2,\dots$$ with unknown mean $$\E[X_i]=\mu$$ and $$X_i\in[0,1]$$ for all $$i$$. 

At a fixed time $$t$$, a confidence interval (CI) is a random variable $$C_n$$ depending on the first $$n$$ variables $$X_1,\dots,X_n$$ such that 

$$\inf_P \Pr_{X\sim P}(\mu\in C_n)\geq 1-\alpha,$$

where the infimum is taken over all distributions on $$[0,1]$$ with mean $$\mu$$. A confidence _sequence_ on the other hand, is a sequence of random variables $$(C_t)_{t=1}^\infty$$ such that 

$$\inf_P \Pr_{X\sim P}(\forall t, \; \mu\in C_t)\geq \alpha.$$ 





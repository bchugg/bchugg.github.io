---
layout: note
title: Discrete Neyman-Pearson via external randomization
description: "How to recover the Neyman-Pearson lemma by randomizing discrete data" 
status: published
date: "2024-12-14"
---

$$
\newcommand{\lr}{\Lambda}
\newcommand{\ind}{\mathbf{1}}
\newcommand{\Pr}{\mathbb{P}}
$$

When testing a point null $$P$$ against a point alternative $$Q$$, the [Neyman-Pearson lemma](https://thestatsmap.com/Neyman-Pearson-lemma) says to find the threshold $$\kappa$$ such that 

$$
P(\lr(X) \geq \kappa) =\alpha,
$$  

where $$\lr = d Q/d P$$ is the likelihood ratio between $$Q$$ and $$P$$. The resulting test rejects when $$\lr$$ is at least $$\kappa$$, i.e., 

$$\phi(x) = \begin{cases}
1,& \text{if }\lr(x) \geq \kappa,\\
0,&\text{otherwise},
\end{cases}$$ 

and is [uniformly most powerful](https://thestatsmap.com/uniformly-most-powerful-test).

Such a value $$\kappa$$ can only be guaranteed to exist when the distributions are continuous. What do you do when the distributions are discrete? 

Suppose you order the values of the likelihood ratio, $$\lr(x_i)<\lr(x_{i+1})$$ for all $$i$$ (there are possibly infinitely many, but countably many so such an ordering makes sense). Suppose you add uniform noise between $$\lr(x_i)$$ and $$\lr(x_{i+1})$$. That is, you preprocess your data such that if the original likelihood ratio was $$\lr(X) = \lr(x_i)$$, you observe 

$$\widetilde{\lr}(X) = \lr(x_i) + z, \text{ where } z\sim U[\lr(x_i), \lr(x_{i+1})].$$

On this augmented probability space, the desired value of $$\kappa$$ does exist. In particular, let $$i$$ be such that $$P(\lr(X) \geq \lr(x_i)) >\alpha$$ and $$P(\lr(X) \geq \lr(x_{i+1})) < \alpha$$ (if there exists some $$i$$ such that $$P(\lr(X) \geq \lr(x_{i+1})) = \alpha$$ then there's no problem).  Then there exists a value of $$\kappa\in(\lr(x_i),\lr(x_{i+1}))$$ such that 

$$\Pr(\widetilde{\lr}(X) \geq \kappa) = \alpha.$$

Here I'm using $$\Pr$$ instead of $$P$$ to indicate that we're technically working on a different space, since we're adding the randomness of $$z$$ to the original space. Note that $$z$$ is drawn after observing $$\lr(X)$$ so the distribution from which it's drawn is well-defined. Rewriting this, 

$$
\begin{align}
\alpha &= \Pr(\widetilde{\lr}(X) \geq \kappa) \\ 
&= P(\lr(X) > \lr(x_i)) + \Pr(\lr(X) = \lr(x_i), z \geq k) \\ 
&= P(\lr(X) > \lr(x_i)) + P(\lr(X) = \lr(x_i))\gamma,
\end{align}
$$

where $$\gamma = \Pr(z \geq k)$$. Now consider the following alternative explanation of the display above: If you draw $$\lr(X) = \lr(x_i)$$ then flip a coin with bias $$\gamma$$ and reject if the coin lands heads. Otherwise, reject if $$\lr(X) > \lr(x_i)$$ and accept if $$\lr(X) < \lr(x_i)$$. In other words, run the test 

$$
\psi(x) = \begin{cases}
1, & \lr(x) > \lr(x_i), \\
\gamma,& \lr(x) =\lr(x_i),\\ 
0, & \lr(x) <\lr(x_i).
\end{cases}
$$

But this is precisely the classical form of the [Neyman-Pearson lemma in the discrete case](https://thestatsmap.com/Neyman-Pearson-lemma-for-discrete-distributions). So we have recovered the discrete NP-lemma by using external randomization on the data and applying the continuous NP-lemma. I would like to claim that this is a fresh and deep insight, but alas this should in fact be radically unsurprising if you think about what "randomization" actually means in the discrete case. Merry Christmas.  


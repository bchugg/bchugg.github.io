---
layout: note 
date: "2022-12-24" 
title: "Introduction to Differential Privacy"
description: "The Laplace mechanism, composition theorems, and local privacy"
status: published
image: /assets/writing_images/cybersecurity.jpg
---


$$
\renewcommand{\lap}{\text{Lap}}
\newcommand{\eps}{\epsilon}
\newcommand{\range}{\text{range}}
\newcommand{\R}{\mathbb{R}}
\newcommand{\X}{\mathcal{X}}
\newcommand{\image}{\text{image}}
\newcommand{\ind}{\mathbf{1}}
\newcommand{\D}{\mathcal{D}}
$$

- TOC 
{:toc}


I remember attending some reading groups on differential privacy during my undergraduate days. My main takeaway was "add noise to data and privacy increases." That seemed rather obvious, so I stopped attending and gradually lost interest in the subject.  It didn't help that, at that point, differential privacy wasn't being relied on in practice. 

After few years I can safely say that I regret my choice. Differential privacy is now used in a lot of applications. Apple [started using it in macOS Sierra](https://www.apple.com/privacy/docs/Differential_Privacy_Overview.pdf) and has since expanded its application to Safari. Google [used differential privacy](https://arxiv.org/pdf/2107.01179.pdf) when gathering insights from searches related to Covid-19, and for their [Covid-19 mobility reports](https://arxiv.org/pdf/2004.04145.pdf). Other examples include [LinkedIn](https://arxiv.org/pdf/2010.13981.pdf), [Microsoft](https://proceedings.neurips.cc/paper/2017/file/253614bbac999b38b5b60cae531c4969-Paper.pdf) and [Uber](https://www.usenix.org/conference/enigma2018/presentation/ensign). What didn't occur to me was that that _how_ you add noise matters, and developing methods to add the right amount of noise in the right ways is an interesting problem. 

Intuitively, a differentially private mechanism should be one which is not excessively reactive to small changes in the dataset. Let $$\D$$ be the set of all databases, and consider a function $$g$$ which acts on $$\D$$. (Think of a database as just some big data table where, e.g., each row corresponds to a different user.) For instance, given a database $$x\in \D$$, $$g(x)$$ might be the size of $$x$$, or the total amount user deposits in $$x$$, or it might ask for the number of users with some property (a "counting query"). 

We want to add noise to $$g$$ in such a way that, regardless of how it queries the database, it cannot back out sensitive information. More precisely, we want to ensure that if there are two databases which are nearly identitical, then asking the same question of each will not betray anyone's private data. For example, if $$g(x)$$ is the total assets across all users in the database $$x$$, and $$z$$ equals $$x$$ except that it omits a single row, then $$g(x)-g(z)$$ tells you about the assets of the omitted user.  Similar examples abound: medical diagnoses, debts, etc. 

Formally, we call a (randomized) mechanism $$f$$ which acts on databases $$(\eps,\delta)$$-differentially private if, for all outputs $$A\subset \text{Range}(f)$$ and all databases $$x$$ and $$z$$ such that $$x$$ and $$z$$ differ by one row, 

$$\Pr(f(x)\in A)\leq e^\eps \Pr(f(z)\in A) + \delta.$$

If $$\delta=0$$, we call $$f$$ $$\eps$$-differentially private. 

The intuition behind the definition is easier to grasp if we negate it. If $$f$$ is _not_ differentially private, this means there exists some $$A$$ such that $$\Pr(f(x)\in A)\gg \Pr(f(z) \in A)$$. That is, swapping just a single row of $$x$$ to $$z$$ changed the output distribution considerably, meaning that $$f$$ is sensitive to the data. If $$f$$ is differentiably private then, roughly speaking, small changes in the input result in small changes in the output. 

A popular to write $$\eps$$-differential privacy is as the likelihood ratio

$$\sup_{A\in \image(f)} \sup_{x_1,x_2:x_1\in \delta_1(x_2)}\frac{\Pr(f(x_1)\in A)}{\Pr(f(x_2)\in A)}\leq e^\eps,$$

where $$\delta_1(x)$$ is the set of databases which different by at most 1 row from $$x$$. 

# 1. Example: The Laplace Mechanism

Consider a deterministic function $$g:\D\to \R^k$$.  For instance, $$g$$ might ask how many users obey $$k$$ properties. 
Define 

$$\Delta = \sup_{x,y:x\in \delta_1(x)} ||g(x) - g(y)||_1 = \sup_{x,y:x\in\delta_1(y)} \sum_{i=1}^k |g(x)_i - g(y)_i|.$$

$$\Delta$$ is often called the $$\ell_1$$-_sensitivity_ of $$g$$. The Laplace mechanism 
is defined as 

$$f(x) = g(x) + (Y_1,\dots,Y_k),$$

where $$Y_1,\dots,,Y_k\sim\lap(0,\Delta/\eps)$$ independently. Recall that the Laplacian distribution $$\lap(a,b)$$ has pdf $$p(x) = (2b)^{-1}\exp(-\vert x-a\vert /b)$$. To show that this mechanism is differentially private, we show that 

$$\int_A \Pr(f(x)=z)dz \leq e^\eps \int_A \Pr(f(y)=z)dz,$$

for all $$x\in\delta_1(y)$$. To see this, it suffices to show that for all $$z\in A$$, $$\Pr(f(z)=z)\leq e^\eps \Pr(f(y)=z$$) and then to integrate over $$A$$. Note that, 

$$\begin{align}
\Pr(f(x)=z) &= \prod_{i=1}^k \Pr(M(x)_i = z_i) = \prod_{i=1}^k \Pr(Y_i = z_i - g(x)_i) \\
&= \prod_{i=1}^k \frac{\eps}{\Delta} \exp(-\frac{\eps}{\Delta}|z_i - g(x)_i|).
\end{align}$$

Therefore, by the reverse triangle inequality, 

$$\begin{align}
\frac{\Pr(f(x)=z)}{\Pr(f(y)=z)} &= \prod_{i=1}^k \exp\bigg(\frac{\eps}{\Delta}(|z_i - g(y)_i| - |z_i - g(x)_i|)\bigg) \\ 
&\leq \prod_{i=1}^k \exp\bigg(\frac{\eps}{\Delta}(|g(y)_i- g(x)_i|)\bigg) \\ 
&= \exp\bigg(\frac{\eps}{\Delta}\sum_{i=1}^k |g(y)_i - g(x)_i|\bigg) \leq \exp(\eps),
\end{align}
$$

which shows that the Laplace mechanism is $$(\eps,0)$$-differentially private. 

# 2. Composition 

One immediate question is how differentially private mechanisms behave under composition. For instance, can we employ multiple differentially private algorithms in tandem and retain differential privacy? Sort of. 

Suppose $$f_1,f_2$$ are $$(\eps_1,\delta_1)$$, $$(\eps_2,\delta_2)$$ differentially private, respectively. Considering concatenating the output so that, given a database $$x$$, we construct a new map $$g$$ such that $$g(x) = (f_1(x), f_2(x))$$, where we run $$f_1$$ and $$f_2$$ independently of one another. Will $$g$$ be differentially private? 

It turns out that $$g$$ will be $$(\eps_1+\eps_2,\delta_1+\delta_2)$$ differentially private. You'll often see this result referred to as "the epsilons and deltas add up." Unfortunately, when people cite this result, they typically cite Theorem 1 of [this paper](https://www.iacr.org/archive/eurocrypt2006/40040493/40040493.pdf), which has an incorrect proof.  There is a corrected proof in the [book by Dwork and Roth](https://www.cis.upenn.edu/~aaroth/Papers/privacybook.pdf), but I think it's more complicated than necessary. Here's a simpler proof. 

Note the range of $$g$$ is the product space $$\range(f_1)\times\range(f_2)$$.  Since we run $$f_1$$ and $$f_2$$ independently, we have, for any $$A\times B\in range(g)$$ and any neighboring databases $$x$$ and $$z$$, 

$$
\begin{align*}\Pr(g(x)\in A\times B)&=\Pr((f_1(x),f_2(x))\in A\times B) \\ &= \Pr(f_1(x)\in A)\Pr(f_2(x)\in B)  \\ 
&\leq \min\{e^{\eps_1}\Pr(f_1(z)\in A+\delta_1,1\}\Pr(f_2(x)\in B) \\ 
&\leq (\min\{e^{\eps_1}\Pr(f_1(z)\in A),1\} + \delta_1)\Pr(f_2(x)\in B) \\ 
&\leq \min\{e^{\eps_1}\Pr(f_1(z)\in A),1\}\Pr(f_2(x)\in B) + \delta_1 \\ 
&\leq \min\{e^{\eps_1}\Pr(f_1(z)\in A),1\}(e^{\eps_2}\Pr(f_2(z)\in B) + \delta_2) + \delta_1 \\ 
&\leq \min\{e^{\eps_1}\Pr(f_1(z)\in A),1\}(e^{\eps_2}\Pr(f_2(z)\in B)  + \delta_2 + \delta_1 \\ 
&\leq e^{\eps_1+\eps_2} \Pr(f_1(z) \in A)\Pr(f_2(z)\in B) + \delta_1+\delta_2 \\ 
&= e^{\eps_1+\eps_2} \Pr(g(z) \in A\times B) + \delta_1+\delta_2.
\end{align*}
$$

Here we've just used basic facts of the min function and recognized that probabilities can be at most 1. Of course, we can extend this result by induction and conclude that given finitely many mechanisms $$\{f_i\}$$ where $$f_i$$ is $$(\eps_i,\delta_i)$$-differentially private, then the mechanism $$g:\X\to \bigotimes_i \range(f_i)$$ given by  $$g:x\mapsto \otimes_i f_i(x)$$ is $$(\sum_i \eps_i,\sum_i\delta_i)$$ differentially private. 

We can also consider deterministic composition, and demonstrate that it does not affect the privacy guarantees. Indeed, suppose $$f:\D\to U$$ is $$(\eps,\delta)$$ private and let $$g:U\to V$$ be deterministic and invertible. Then for any $$W\subset V$$,

$$
\begin{align}
\Pr(f\circ g(x) \in W) &= \Pr(f(x) \in g^{-1}(W)) \\
&\leq e^\eps \Pr(f(y) \in g^{-1}(W)) = \Pr(f\circ g(y)\in W),
\end{align}$$

so $$f\circ g$$ is  $$(\eps,\delta)$$ private. 

# 3. Local differential Privacy 


So far the model we've posited is one where there exists some large database $$x\in \X$$ which contains all users' data, and then some administrator or custodian of the data privatizes it. In practice, this isn't terribly secure. Do we trust the custodian? Does she delete the original database after it's privatized? What if another company offers her a lot of money for $$x$$, or her company is bought by another? 

For all these reasons, we might consider _local_ differentially privacy. Here, the data is privatized on the users end before reaching any centralized database. Thus, no one sees the raw data besides the user themselves. Google [uses](https://ai.google/research/pubs/pub42852) local differential privacy to collect information from users' browsers, and Apple [uses](https://machinelearning.apple.com/2017/12/06/learning-with-privacy-at-scale.html) local differential privacy to collect emoji data. 

In the local setting, instead of considering functions which act on the set of databases $$\D$$, we consider functions which act on a users private data. If $$h$$ is such a function, then we say that $$h$$ is $$\eps$$-local differentially private if, for all user data $$x$$ and $$y$$ and all $$A\subset \image(h)$$, 

$$\Pr(h(x)\in A)\leq e^\eps \Pr(h(y)\in A).$$

Mathematically, therefore, this looks precisely the same as the definition of $$(\eps,0)$$-differential privacy, except that the function $$h$$ is acting on a different space than the function $$f$$. 

## 3.1 Warner's randomized response 

An example of an algorithm which is locally differentially private is Warner's method for survey responses. The idea is to enable respondents to answer potentially sensitive survey questions while maintaining plausible deniability. 

Consider a survey with a sensitive yes/no question and fix some $$r\in(0,1]$$. The respondent answers truthfully with probability $$r$$, otherwise flips an unbiased coin. That is, the privatized response is 

$$Z\sim \begin{cases} X,& \text{w.p. } r\\ Y\sim \text{Bernoulli(1/2)},&\text{w.p }1-r
\end{cases}
$$

Note that $$\Pr(Z=z\vert X=x) = r\ind(z=x) + (1-r)/2$$. Therefore, 

$$\max_z\max_x \frac{\Pr(Z|X=x)}{\Pr(Z|X=x')} = \max_x\max_z \frac{r\ind(z=x) + (1-r)/2}{r\ind(z=x') + (1-r)/2} = 1 + \frac{2r}{1-r}.$$

If we set $$\eps=\log(1 + 2r/(1-r))$$, we see that Warner's randomized response is $$\eps$$-locally differentiably private. 




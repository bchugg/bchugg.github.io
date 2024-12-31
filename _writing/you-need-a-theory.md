---
layout: writing
title: "You need a theory for that theory"
description: "Another criticism of Bayesian epistemology: Evidence doesn't speak for itself" 
date: "2023-09-06" 
status: published
image: /assets/writing_images/turtles.jpeg
---


If you ask people what it means to be rational, I think many would say something like "the strength of your belief should accord with the evidence." This is a fairly natural notion after all. If there is good evidence for something, you should believe it strongly. If weak evidence, you should be sparing in your credulity.

The philosophical tradition of _Bayesian epistemology_ tries to formalize this idea, providing normative rules for precisely how much you should believe in various propositions. The formalization is based on [_Bayes' rule_](https://en.wikipedia.org/wiki/Bayes%27_theorem), a mathematical theorem which reads:

$$P(T|E) = \frac{P(E|T)P(T)}{P(E)}.$$

Bayes' rule itself has nothing to do with beliefs or evidence or rationality per se. It's a simple mathematical result that follows from the [axioms of probability theory](https://en.wikipedia.org/wiki/Probability_axioms). That is, as long as P is a so-called "probability measure," then Bayes' rule holds. Statisticians, for instance, use Bayes' rule all the time without referring to credences or rationality.

The core claim of Bayesian epistemology is that our credences (how much we believe various ideas) should be a probability measure over propositions. If we adopt this view, we can interpret Bayes' theorem as telling us how to update our beliefs in light of new evidence. You should read the vertical line $$\vert$$ in $$P(T\vert E)$$ as "given", so $$P(T\vert E)$$ is the new probability of T given that you received evidence E. $$P(T)$$ is the "prior probability" of T before you received evidence E, and $$P(E)$$ is the overall probability of receiving evidence E.

Examples always help. Let T be some theory you have about the world. (I'm going to use words theory and proposition interchangeably.) Maybe T is "my dog is mad at me." When you receive some evidence E like "my dog didn't greet me when I got home", Bayes' rule tells you precisely how concerned you should be that your best friend will never speak to you again, assuming you can put numbers on $$P(E\vert T)$$, $$P(T)$$ and $$P(E)$$.

There are many problems with Bayesian epistemology, some of which [I've discussed before](https://medium.com/conjecture-magazine/pascals-mugging-and-the-poverty-of-the-expected-value-calculus-70b190d953cd/). You can see a laundry list of other objections [here](https://plato.stanford.edu/entries/epistemology-bayesian/#IssuAbouDiacNorm), and a proof that probabilistic induction (a fancy term for using Bayes' theorem in this way) is incoherent [here](https://arxiv.org/pdf/2107.00749.pdf). These are all substantial criticisms, but I think an even more basic criticism exists.

The problem is that evidence doesn't speak for itself. Or, in other words, to determine what counts as evidence E for a theory T requires its own theory. And if you want to update your credence in _that_ theory using Bayes' rule, you need yet another theory. Mathematically, determining $$P(E)$$  requires a second theory, $$T_2$$, which tells you what these numbers are. 
And determining what counts as evidence for $$T_2$$ requires yet another theory, $$T_3$$. And so on and so forth, ad infinitum. 
(Incidentally, the same problem exists for $$P(E\vert T)$$, but it's simpler to just focus on $$P(E)$$.) 

Suppose T is the proposition "All cars in the US will be self-driving by 2028." And suppose Tesla releases a new model tomorrow. I'm sure many online commentators would consider this evidence for T, and would want to update on it.  Fair enough. But what about the fact that Tesla _didn't_ release a new model yesterday? Should that count as some (probably negative) evidence E, and should we update on it? Maybe? What about the fact that there was a coup in Gabon last week. That seems perhaps unrelated at first, but now fewer people in Gabon will be working on self-driving cars. And maybe a high end Tesla executive has family there. Or what about the fact that there wasn't a coup in France … now more people can work on self-driving cars. What about that I (frustratingly) don't have a toaster in my apartment, or that fire is hot, or that Canada did poorly in the women's World Cup?

The point is that to determine what counts as evidence for T (whether for or against) requires many assumptions about the world. It requires an implicit theory about what counts as evidence, because the world doesn't come pre-parcelled into things that are evidence and things that aren't.

This means, frustratingly, that Bayesianism is skipping over the precise step we all care about the most. Nobody cares how numerically confident you are in your ideas---they care _why_ you believe what you believe. They want to understand your arguments. And this boils down to understanding why you think some events are important and some aren't. If you think Gabon is crucial to the future of self-driving cars, I want to know why. I don't care that now you're 68% confident instead of 73%. [The commentary is all that matters]({% link _writing/commentary_is_all_that_matters.md %}). 

But didn't I say that statisticians use Bayes' rule all the time? How do they get around this problem? By construction: They apply Bayes' theorem only in well-defined statistical models, which are specifically tailored so that we can do such calculations. Models are simplifications of the world, engineered so that they can be useful, but not so they are true. [All models are wrong but some are useful](https://en.wikipedia.org/wiki/All_models_are_wrong), goes the aphorism. Bayesian epistemology obliterates the crucial distinction between models and the world, thereby becoming meaningless in the process.

So what do we do about this whole rationality thing? Are we doomed? Yes, in some sense. I don't think it makes sense to look for the ultimate foundations of rationality, a mathematical theory that will tell you precisely what to believe and how strongly to believe it. (What a mind-numbingly boring world that would be, anyway.) If rationality means "have perfectly calibrated numerical beliefs over the space of all propositions," then the search for rationality is futile.

But if rationality is simply the recognition that we're all fallible and must therefore scrutinize our ideas because we might be wrong, then there's hope, and we can indeed move towards a more rational world. In such a conception of rationality, it doesn't matter where the ideas come from, only that we do our best to discover how they are flawed. You don't run into mathematical paradoxes because nothing need rest on some ultimate logical-mathematical foundation.

--- 
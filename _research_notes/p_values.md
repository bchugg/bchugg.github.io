---
layout: note
title: "P-values and counterfactuals"
description: "The terrible horrible no good very bad truth about p-values. " 
status: published
date: "2024-06-08"
image: "/assets/writing_images/counterfactuals.jpeg"
---

_This is less math heavy than usual in an attempt to make the content more accessible._

$$
\renewcommand{\Pr}{\mathbb{P}}
$$
 
- TOC
{:toc}

# An overly long introduction to p-values

With the [replication crisis](https://en.wikipedia.org/wiki/Replication_crisis) in full swing (among those of us who aren't [in denial about its existence](https://bigthink.com/hard-science/the-replication-crisis-is-overstated/), at least), p-values have taken a public relations beating. People are aware that they can be manipulated and abused to arrive at a pre-determined conclusion and make your results look falsely significant. Suspicion that your friendly neighborhood sociologist is p-hacking their way to their next Nature paper is at an all time high. 

I'm here to ~~comfort you~~ tell you that it's even worse than you think. Many statisticians defend p-values by emphasizing that they're simply tools---it's their misuse which is causing the replication crisis. If everyone understood them better and adopted honest research practices, then things would be okay. "Don't blame us" is being screamed from the ramparts.   

This is partially true. But p-values also have mathematical properties which make them annoyingly difficult to use correctly,  even with the best of intentions. It is extremely easy to "break" p-values and largely impossible to determine if they're valid. 

We're going to explore some of the issues in a simple setting. 
Suppose you set out to test the efficacy of a new drug. You gather some number of participants, give half of them the drug and give the other half a placebo. You want to see whether there is a significant difference between the recovery rates of the two groups. 

This is a standard hypothesis testing setup. The null hypothesis $$H_0$$ is that the drug is no more effective (or has a worse effect) than the placebo, on average. The alternative $$H_1$$ is that the drug is more effective than the placebo, on average. We want to determine whether the study gives us enough evidence to reject the null. 

Hypothesis testing is usually done with p-values. A p-value is a random variable (a function of the data) such that, if the null hypothesis is true, is unlikely to be small. That is, if the drug is no more effective than the placebo, the p-value will be less than 0.05 only 5% of the time (say). Small p-values  therefore act as evidence against the null. (The p-value is _not_ the probability that the null hypothesis is true nor the probability that the result is due to chance, [as many intro psychology textbooks would have you believe](https://journals.sagepub.com/doi/full/10.1177/2515245919858072?journalCode=ampa).)

Mathematically, let $$P_n$$ be a p-value which is a calculated based on $$n$$ participants (usually by means of a test-statistic but the details are unimportant for this discussion). The (conservative) p-value guarantee reads: 

$$
\begin{equation}
\text{For all } n \text{ and for all }\alpha,\quad \Pr_{H_0}(P_n \leq \alpha) \leq \alpha.
\end{equation}
$$

The subscript "$$H_0$$" means the probability under the assumption that the null is true. If the math looks weird, don't panic---the basic intuition is all you need to understand the problems. The parameter $$\alpha$$ is the _significance level_ and $$n$$ is the _sample size_. If our p-value is less than $$\alpha$$ we reject the null hypothesis, meaning we _tentatively_ accept the alternative hypothesis and conclude that the drug is more effective than the placebo (note that it doesn't tell us anything about _why_ it's more effective than the placebo). Size does matter, and smaller is better. Everybody wants a small p-value. 

The significance level is the rate of false positives[^1] (aka Type-I error) we are willing to tolerate _if we were to repeatedly run the study_. If $$\alpha = 0.05$$ then we'll falsely reject the null about 5% of the time. So we want $$\alpha$$ to be small. But the smaller it is the more of a burden this places on the p-value. If $$\alpha = 0.000001$$ (which it often is in physics), we're going to need a huge number of study participants for the p-value to clear that threshold (even when the null is false). For small $$\alpha$$ there will be fewer false positives, but also fewer true positives. A standard value of $$\alpha$$ in psychology and the social sciences is 0.05. 

[^1]: A false positive in this context is falsely concluding the drug is effective when it's not. 

Now, onto the problems! 

All of the issues with p-values explored here are consequences of the fact that $$n$$ and $$\alpha$$ are _outside of the probability statement_. I forgive you if you're underwhelmed, because this might seem obscenely inconsequential. But unfortunately for you, me, and the world, it's not. It means that the guarantee on our p-value holds only if the sample size and the significance level are independent of the data. In other words, they are fixed in advance of the study. We'll consider four consequences of this property. 

# Four problems 

## 1. Significance adjustments 

Let's suppose you set your significance level to $$\alpha = 0.001$$. You want to be careful---this is a drug trial after all. 
You gather $$n=10,000$$ participants and observe a p-value of 0.004. Uh oh. Now you have to go tell your boss that you can't reject the null and the study was a waste. (Ideally you would still publish the study to avoid the [file-drawer effect](https://en.wikipedia.org/wiki/Publication_bias#:~:text=Publication%20bias%20is%20sometimes%20called,a%20bias%20in%20published%20research.), but we'd also like ). 

But $$P_n=0.004$$ _seems_ like such a low p-value. If you had only set $$\alpha$$ to be 0.005, then you could have rejected the null! 
It would be very tempting (and is undoubtedly common) to report that you reject the null at $$\alpha = 0.005$$. Nobody is checking what your initial value of $$\alpha$$ was. Unfortunately, this would mean that $$\alpha$$ was selected based on the data, which is not allowed. You're stuck with your original significance level, sorry. 

Part of the issue is that by changing your $$\alpha$$ value post-hoc, you're inflating your Type I error. Suppose you ran this study 10,000 times in a world where the drug is not effective. You will get a p-value less than 0.001 about 10 times and less than 0.005 about 50 times. Suppose every time you observe a p-value between 0.001 and 0.005 you change your $$\alpha$$ to 0.005 and reject the null. So you will reject the null about 50 times and your true type-I error probability is 0.005. But in the worlds where you didn't change your $$\alpha$$, you're reporting a type-I error probability of 0.001, which is false. And here we get our first sense of why counterfactuals are important. 


## 2. Peeking and early stopping

Let's stick with $$n=10,000$$ participants. It's like that you don't get all the data for your study all at once. Instead, the trial is run over several months and every day you get the results for a few more participants. **You should not monitor this data as it comes in, re-computing your p-value each day, and checking if it's significant**. 

Your p-value should only be calculated on the final sample of 10,000 people, since 10,000 was the initial number of observations chosen independently of the data. If you continuously monitor the result there's a possibility that you will stop early (at 5,000 participants say), in which case the sample size is data-dependent and the p-value is invalid. 

Of course, the act of simply looking at the data and re-computing the p-value is itself harmless. However, you cannot act on any if this information, otherwise it will contaminate your results. If there is even a possibility that you would stop early depending on the results then your p-value is invalid (see the counterfactual reasoning section below). 

## 3. Optional continuation 

Optional continuation is the flip side of peeking and early stopping. Suppose you calculate your p-value after gathering the data from your 10,000 participants. As above, the p-value is 0.004 but your significance level is $$\alpha=0.001$$. Since this looks promising, it's very tempting to gather a few more participants and see if your p-value will go down. But again, this is illegal.  It would mean your sample size is a function of your data. **So continuing the experiment by gathering more participants is invalid.** 

Unfortunately, this also seems to be common practice. In an anonymous survey of over 2,000 psychologists, [more than half admitted to](https://pubmed.ncbi.nlm.nih.gov/22508865/) deciding whether to collect more data based on the results thus far. And [here is Dana Carney discussing](https://faculty.haas.berkeley.edu/dana_carney/pdf_my%20position%20on%20power%20poses.pdf) how they conducted the infamous [power-posing study](https://www.bu.edu/wgs/files/2014/12/Carney-et-al.-2010-PowerPosingAffectsNeuroendocrineHormones.pdf): 

> We ran subjects in chunks and checked the effect along the
way. It was something like 25 subjects run, then 10, then 7, then 5. Back then this did not seem like p-hacking. It
seemed like saving money (assuming your effect size was big enough and p-value was the only issue). [...] The final sample size was $$N=42$$. 

Unsurprisingly, power-posing---despite being the [second most popular Ted Talk of all time](https://www.ted.com/playlists/171/the_most_popular_ted_talks_of_all_time) with over [71 million views](https://www.ted.com/talks/amy_cuddy_your_body_language_may_shape_who_you_are?referrer=playlist-the_most_popular_ted_talks_of_all_time&autoplay=true&subtitle=en)---failed to replicate and has been discredited. (If you're wondering why anyone would publish a study with a sample size of 42 then you're not alone. It's insane anyone takes these studies seriously.)

The problems with optional continuation don't stop there. They get more severe the more you meditate on them. Suppose you run a first clinical trial and, based on the results, run a second. In practice, we would consider this to be a completely separate study and assume that the p-value in the two studies are independent. Is this correct? After all, we only did the second study because of the results of the first. So in some sense, the sample size of the second study is data dependent. 

There's no great solution to this problem. In the real world, everything is related to everything else. "Independence" is a nice statistical concept allowing us to do math, but few studies on the same topic would truly be independent of one another. If you take this issue seriously however, then you should be worried since it arises constantly in practice. Two examples: 

 - In March 2021 [the LHC recorded a $$3\sigma$$ event](https://www.bbc.com/news/science-environment-56491033) against the null[^2], where the null hypothesis represented the standard model of physics. That is, they recorded an event that was extremely unlikely according to the standard model. Like good scientists, they were skeptical of the results, so they opted to collect data for 6 more months and then compute a new p-value. But this second experiment was dependent on the outcome (i.e., the data) of the first experiment. 
- During the Covid-19 trials, many labs were running experiments on potential vaccines. When a vaccine looked promising, that lab would either conduct a larger experiment, or other labs would conduct experiments on the same vaccine. Should this be considered the same study? 

[^2]: Annoyingly, the BBC misinterpreted the p-value. They said: "The measurement from LHCb is three-sigma --- meaning there is roughly a one in 1,000 chance that the measurement is a statistical coincidence." We know from above that this is incorrect. 


## 4. Counterfactual reasoning 

All of the issues above can be viewed as facets of a more general problem with p-values, which is the issue of counterfactual worlds. 

I keep emphasizing that the sample size needs to be fixed in advance. But the p-value requirement is stronger than this. It actually says that **the sample size needs to be same in all counterfactual worlds**. Or, if you don't like the word "counterfactual", then **the sample size needs to be same regardless of what happens in the experiment.** If not, it means that the sample size was actually data-dependent. 

(Mathematically, it can help to view the sample size as a deterministic random variable. That is, if $$N$$ is the sample size, then for all outcomes $$\omega\in\Omega$$ (the sample space), we require that $$N(\omega) = c$$ for some $$c$$ for the p-value to be valid.)

This is an irredeemably frustrating property. For one, it is unverifiable: how do you know the sample size would not have changed in every possible world? Second, it makes it extremely easy to start doubting the veracity of your p-value and to sink into a dark, deep, depressing nihilism about every scientific finding out there. (...)

Imagine you have a grad student analyzing the drug trial data as it arrives, just to make sure your data collection software is working. Do you think there's any situation in which he would stop the experiment early? What if the results looked _really, really_ good? If so, then the sample size is not truly fixed, and your p-value is invalid. To be clear: this doesn't even have to happen to your world, just in some counterfactual world. 

So you don't just have to guard against the issues of peeking and optional continuation in your experiment. You have to guard against them no matter what happens. But now we're in an ugly situation: To argue about the validity of p-values, we have to argue about what we think would have happened had the outcome of the experiment been different. This brings an element of subjectivity into what was, moments before, a purely mathematical discussion. 

To drill this point home, let's go back to the birth of the p-value. [Legend has it](https://en.wikipedia.org/wiki/Lady_tasting_tea) that Ronald Fisher invented the p-value when a colleague, Muriel Bristol, claimed she could tell whether it was the milk or water that was first added to her tea. So Fisher made eight cups of tea, put milk in first in four of them and water in first in the other four. 

The null hypothesis is that she can't tell the difference. Muriel guessed all eight cups correctly, which has odds 1/70 under the null. (70 is $${8\choose 4}$$; Muriel knew there were four cups of each.) Fisher concluded that this was sufficient evidence to reject the null. 

But suppose that Muriel had made a single mistake. Then the p-value would have been $$17 / 70$$ (16 ways to make a mistake, which involves swapping two cups, plus one way to get everything correct). This isn't very small, so Fisher may have been skeptical of her powers. Do you think Muriel would have asked Fisher for another try? If so then original p-value was not a valid p-value after all. 


# How much does any of this actually matter? 

So p-values have some problems. And they require some assumptions to work. But all of statistics is like this---the whole project requires assumptions to get off the ground. 

When we model the distribution of heights in the population as a normal distribution, this an approximation, it's not literally true. Likewise, the assumption that a coin flip is equally likely to land heads or tails is false but allows us do useful calculations. Whether a coin lands heads or tails is entirely deterministic---it has to do with physics and laws of motion. In fact, the whole notion of "randomness," (modulo possible quantum mechnical effects which don't affect the macro-world) is a useful fiction enabling mathematicians to prove cool, and occasionally useful, theorems. Nothing is actually random.  

Statistics operates in the "all models are wrong but some are useful" paradigm, based on the now-extremely-popular-but-simulaneously-still-underappreciated aphorism [usually attributed to George Box](https://en.wikipedia.org/wiki/All_models_are_wrong). Sure, the mathematics of p-values make some unrealistic assumptions, but are p-values useful?   

Opinions differ, and they differ in part based on your philosophy of counterfactuals. I think the preceding discussion shows that they're less useful than we'd like. No statistical tool will perfectly capture reality, but the ways in which they fail are important. The fact that the validity of p-values depends on counterfactuals is disappointing, and there are other tools which don't have this property ([e-values](https://en.wikipedia.org/wiki/E-values), for instance). One can simultaneously recognize that statistics deals in imperfect tools while also trying to improve the quality of those tools.  



# References 
- [Aaditya Ramdas' course on game-theoretic probability](https://www.stat.cmu.edu/~aramdas/gtpsl/index.html) which inspired a lot of this material. 
- [Intro to safe anytime-valid inference](https://arxiv.org/pdf/2210.01948), which introduces technical tools that avoid many of the pitfalls of p-values. 

---
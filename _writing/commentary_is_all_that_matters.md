---
layout: writing
title: "The commentary is all that matters (or, why nobody is actually a Bayesian)"
description: What would true Bayesian epistemology look like?
date: "2022-09-10" 
status: published
image: /assets/images/bayes.jpeg
---

Like many tech-adjacent twenty-somethings who have spent time in the Bay Area, I greatly admire [Astral Codex Ten](https://astralcodexten.substack.com/), the newsletter written by Scott Alexander. The writing is funny, smart, and remarkably broad in scope. 

There are surely many essays to be written in response to his articles. This is not one of those. Instead, I'm going to focus on something more important: the newsletter's description. It reads:

> $$P(A\vert B) = P(A)P(B\vert A)/P(B)$$, all the rest is commentary. 

If one were to compile Scott’s output into a book, that book would be approximately 10,000 pages long. All of this output, and I take his description to be one of the most outrageous things he’s ever written. Scott is selling himself short: His commentary is _all_ that matters. Bayesian decision theory (represented by the equation) is mostly an ad-hoc addition to his analysis which adds little value.  

For the unfamiliar, the equation in the description is known as [Bayes' theorem](https://en.wikipedia.org/wiki/Bayes%27_theorem), named after the 18th century Presbyterian minister Thomas Bayes. It's a basic but fundamental identity in probability theory, useful in a wide number of applications in statistics, data science, and machine learning. Odds are that some of the automated systems you use every day rely on Bayes' theorem. 

According to [some](https://twitter.com/esyudkowsky), Bayes' theorem represents more than a simple mathematical tool. It represents the normative rules of thought. On this view, belief (or ''credence'') in a proposition A (e.g., my dog is in the kitchen) should be characterized by a number between 0 and 1 which captures your confidence in the statement. A credence of 1 means absolute certainty that your dog is in the kitchen, while a credence of 0 is certainty that he is not. 

Once this assumption is adopted, Bayes' theorem is interpreted as the rules for how to update your beliefs in the face of new evidence. If you visit the living room and do not find your dog (let's call this event B), then we must update our confidence that the dog is in the kitchen to be P(A\|B), calculated using Bayes' theorem. 

(For any confused statisticians out there: this is not about, e.g., Bayesian parametrics, or any of your favorite Bayesian statistical methods. This is about applying Bayesian reasoning to beliefs and knowledge creation, and to every aspect of decision-making in the real world, not only in well-defined mathematical models. For this reason, it is often called [Bayesian epistemology](https://plato.stanford.edu/entries/epistemology-bayesian/). Henceforth, when I say Bayesianism, I mean it in this more expansive sense.)

There is a large community of people who think of Bayesianism as defining the rules of rationality, including Scott Alexander. The most famous of these communities is perhaps [LessWrong](https://www.lesswrong.com/), where being called a “good Bayesian” with “well calibrated credences” is the highest honor one can achieve. Their [third core tenet](https://www.lesswrong.com/posts/AN2cBr6xKWCB8dRQG/what-is-bayesianism) reads 

> We can use the concept of probability to measure our subjective belief in something. Furthermore, we can apply the mathematical laws regarding probability to choosing between different beliefs. **If we want our beliefs to be correct, we _must_ do so.** (emphasis added)

Taken seriously, what would a blog post look like based on nothing but Bayesian decision theory? Probably something like this: 

A = Someone will build an artificial general intelligence (AGI) by the end of the century. \\
B = DeepMind released [GATO](https://www.deepmind.com/publications/a-generalist-agent). \\
P(A) = 0.53, P(B) = 0.20, P(B|A) = 0.24. \\
P(A|B) = 0.64.  

A = Putin has cancer. \\
B = There are pictures of him with puffy cheeks. \\
P(A) = 0.06, P(B) = 0.09, P(B|A) = 0.30. \\
P(A|B) = 0.20. 

Scott may have avoided being [doxxed by the NYTimes](https://astralcodexten.substack.com/p/statement-on-new-york-times-article) if he wrote this way as nobody would read his blog. What we care about is why he made up these numbers in the first place — what were the arguments which lead him to thinking that AGI was 53% likely? And this is what makes his blog so good: his *reasoning*. 

The ACX description is tongue-in-cheek. Scott doesn’t even mention Bayes’ theorem in the majority of posts, and he knows that his arguments are what attract and retain his readers. But taking Bayesianism seriously helps highlight several of its problems when applied as the ultimate decision-making tool. 

In order to practice Bayesianism to the letter, one would have to have placed a probability over the event “Pictures of Putin get leaked wherein he has puffy cheeks,” (or a reference class containing this event) before hearing anything about it. I humbly submit that few people walk around with a probability distribution over all possible future events. 

A more substantial problem is that events in the real-world don’t come with probabilities attached to them. Who says the probability that pictures of Putin with puffy cheeks would surface given that he has cancer is 0.3? Why not 0.8? 

These issues don’t affect Bayesian _statistics_ because there we’re very careful about applying probability to highly structured and artificial mathematical worlds, where all possibilities are known a priori and all probabilities are well-defined. The probability that a random variable takes the value 1 or 2 is not a subjective guess. It’s given by the assumptions on the probabilistic model, and there’s no room for persuasion. Believe me, I wish it were not so, otherwise graduate statistics classes would be much easier. Statistics would become rhetoric and the sophists would rule the field. 

The tendency to overapply Bayesian methods has been noted among both philosophers and statisticians. Mathematician Ken Binmore [calls](https://www.jstor.org/stable/20079192) overzealous individuals with such habits “Bayesianites”. In his pioneering work [The Foundations of Statistics](https://www.gwern.net/docs/statistics/decision/1972-savage-foundationsofstatistics.pdf), Leonard Jimmie Savage coined the term “small worlds” to refer to stylized mathematical models wherein applying Bayesian methods, and probability more generally, makes sense. He said that it was “utterly ridiculous” and “preposterous” to apply Bayesian decision theory outside of such worlds. (Ironically, many Bayesianites use Savage’s axioms as the definition of rationality, not realizing they were meant for only very particular situations.) Nassim Taleb terms the misapplication of mathematical and probabilistic models to reality the [Ludic fallacy](https://en.wikipedia.org/wiki/Ludic_fallacy). 

In large, messy worlds — the opposite of Savage’s small worlds — where not every outcome can be foreseen, nor every proposition assigned a well-defined probability, argumentation is all we have. Bayesianism is summarizing nuanced arguments down to numbers, thereby compressing all discussion down to something that's much more difficult to interpret and, importantly, to argue with. It's also a cheap way out. Elucidating _why_ you think AGI is likely means you have to make arguments touching on the philosophy of mind, empiricism, linear algebra, and consciousness. Tossing out a random number is much easier. 

Note this is not about Bayesian versus frequentist _statistics_. It would be equally absurd if there was a  community of people who believed you should quantify beliefs using only the frequencies of past events. Rather, this is about the broader misuse of the tools of probability and statistics outside of their domains of applicability. It’s as if everybody was running around using laundry detergent to fuel their cars. 

In practice, of course, nobody acts like a true Bayesian. Most of the time, Bayesian reasoning is used synonymously for being open to new evidence, which is of course a very admirable trait. Performing a “Bayesian update” simply means changing your mind in response to a novel argument. Here is an example of a “Bayesian updating” procedure from an ACX [book review](https://astralcodexten.substack.com/p/your-book-review-viral) of _Viral_ by Alina Chan and Matt Ridley, which studies the origins of Covid-19.  (The review was written by someone else, not Scott. I tried to find an example of Scott’s updating procedure but I looked through the last month’s worth of posts and found nothing. It’s almost like he doesn’t require the procedure to make arguments …) 

> To summarize, my overall updating went something like this:

> Prior: Definitely natural origins (Obviously, I’m not a conspiracy theorist). 

> Update 1: Hmm, so I guess they haven’t found any direct evidence of an animal source yet, but I’m sure one will turn up. Anyway, a lab leak is still impossible, right?

> Update 2: Ok, so I guess there have been some lab leaks in the past. But still, the zoonotic spillovers are much more common.

> Update 3: Wait a minute… you mean the location of the initial outbreak actually is not close to the nearest natural reservoir of this type of virus? In that case, isn’t it kinda suspicious that it is close to one of the only virology institutes in the world doing gain-of-function research on bat coronaviruses? Why am I just hearing about this now?

> Update 4: Lots of technical points being discussed and debated, way over my head. However I notice scientists much smarter than me shifting their opinion and now claiming that neither hypothesis can be ruled out based on the current evidence.

> Posterior: Both hypotheses seem viable and a thorough, open investigation is needed. 

Not a probability in sight. You could blend in seamlessly with the Bayesian community if, upon hearing an argument you agreed with, said: “Good point. I’m updating on this because [insert reason here]”. When you heard an argument you disagreed with you said “I’m not updating on this because [insert reason here]”. Nobody would notice the difference, because nobody is running around ensuring all your credences sum up to 1 or obey the union bound. That would be absurd, _and everybody knows it would be absurd._ 

This brings us to the (pleasing) paradox of the Bayesian community. They know, deep down, that arguments are all that really matter. In fact, they've developed better norms of argumentation than any other online community I can think of. The EA forum and LessWrong are filled with debate, not with people shouting numbers at one another. The very people who are convinced that your beliefs should be compressed into single numbers are the same people who write 17 page responses to online blog posts, and who have four hour podcast conversations with one another to hash out their disagreements. The Bayesian community is filled with anti-Bayesianites, doing their best to grapple with the uncertainties of large worlds. 

The commentary on Scott’s blog is really _all_ that matters. It’s the substance; the main course. It’s why people read ACX. Bayes’ theorem is taking undeserved credit. I suggest modifying the description to something more pithy, like:

> The commentary is all that matters. Sometimes $$P(A\vert B) = P(A)P(B\vert A)/P(B)$$, but not in a very literal way. In fact, I could just leave out the probabilities and it wouldn’t make a difference. 


_Thanks to [Cam](https://falliblepieces.substack.com/) for helpful comments._ 






---
layout: writing
title: "On studying useless things"
description: "Either a case for the utility of fundamental research or an exercise in motivated reasoning." 
date: "2024-08-01" 
status: published
image: /assets/writing_images/hardy.png
---


> _We have concluded that the trivial mathematics is, on the whole, useful, and that the real mathematics, on the whole, is not._ 
> 
> \- G.H. Hardy

How do you justify a life spent studying a subject with no immediate practical applications? There are many problems in the world, from death, disease, and depression, to political oppression and social turmoil. Can one stare such suffering in the face and then turn around and study pure mathematics, theoretical physics, or the chemical bonds of obscure elements?

I think about this question a lot. After several failures to do “practical things” I ended up pursuing a PhD in theoretical statistics which, for anyone who is not a statistician or mathematician, looks indistinguishable from pure maths. This can make for awkward dinnertime conversations. After your cousin explains how she rescues dogs or your uncle discusses his latest ICU patient, explaining that you’ve developed a new proof technique for the concentration of Lipschitz functions falls remarkably flat.

Some theoreticians take pride in being “useless,” thinking of what they do as having its own intrinsic benefit, akin to producing a novel or a poem for other artists to enjoy. G.H. Hardy, a famous Oxbridge mathematician, advocated this view, taking pride in the fact that number theory—the “queen of mathematics”—had no applications.

<img id='img-50' src="/assets/writing_images/hardy.png">
<p id='center' class='caption'>G.H. Hardy.</p>

I don’t feel this way. I wish my interests and aptitudes aligned with one of the many problems I’d love to see solved—getting humanity to Mars; reducing rates of depression; increasing and extending quality of life; pandemic preparedness; eradicating various diseases; creating viable artificial wombs; increasing access to knowledge; reducing class disparities; and so on.

But the fact is the day-to-day work of an entrepreneur or software engineer or founder simply doesn’t appeal to me as much as proving theorems does. So it’s worth asking: Is this purely an exercise in self-aggrandizement, or does fundamental research in mathematics and the basic sciences have any benefit?

I believe the answer is yes, but the benefits are delayed, unpredictable, and uneven. Fortunately for my ability to sleep at night, however, I’m also convinced that we can’t do without it.

Let’s first discuss fundamental research more broadly, which includes not only mathematics and statistics but also foundational biology, chemistry, and physics. Such research has downstream benefits in terms of new technology, but the benefits take time to materialize. Perhaps a neurobiology lab discovers a new function of the hippocampus, which in turn suggests a new intervention for some rare disease. But this process can take years, because (i) discovering new things is hard and error-prone, (ii) it’s not always obvious how to leverage new discoveries, and (iii) moving from a proof of concept to a product that’s mass marketable requires funding, regulatory approval, and good engineering.

We can try and study the returns to basic science quantitatively. Skeptical as I am of many economic models, it’s a robust finding that research in maths and science has positive returns to economic growth. The mechanism is no mystery: you can imagine scientific advances as replenishing a reservoir of knowledge that can be mined to create new technologies. Scientific American (unbiased, I’m sure) claims that [between a third and a half of economic growth in the US](https://www.scientificamerican.com/article/why-science-is-important/) resulted from basic research. [This paper](https://www.tandfonline.com/doi/epdf/10.1080/23311886.2024.2309714?needAccess=true) has a giant table summarizing the literature on the relationship between economic growth and basic research, measured by publications. Most find a positive relationship (and sometimes causality) between the latter and the former.

You can also study natural shocks that disrupt or increase funding (such as wars) for basic science and see what happens. Matt Clancy has an [excellent summary of such research](https://www.newthingsunderthesun.com/pub/g1gyu4hr/release/15) and finds that more science means more innovation and more technology. He also finds that [it takes roughly 20 years on average](http://mu.zoom.us/meeting#/pmi/8576418462) to go from an increase in basic science research to obtaining the corresponding economic gains.

<img id='img-100' src="/assets/writing_images/journal_shock.jpeg">
<p id='center' class='caption'><a rel='nofollow' href="https://academic.oup.com/qje/article/133/2/927/4810578?login=false">Iaria, Schwarz, and Waldinger (2018)</a> use the fact that scientific communication was disrupted between the axis and allied powers during WWII to study effect of fewer novel ideas on progress. Matt clancy <a href="https://www.newthingsunderthesun.com/pub/g1gyu4hr/release/15" rel='nofollow'>reviews this paper here.</a> </p>


Of course, these results concern science as a whole. This says nothing about what any particular scientist is working on. Some advances will make their way into new technology in the coming decades, some will wait their turn on the bench, and some will never even get dressed for the game. Unfortunately, there’s no way to tell which are which beforehand.

By pursuing fundamental research, you are part of a collective of people all pushing the frontiers of our knowledge into the unknown. Many—perhaps most—of these efforts won’t pay off in terms of practical benefits, but the project as a whole is still worth it for those that do. We’re exploring this great frontier together, not sure which discoveries will lead where, but confident that some can change our lives for the better.


That _science_ results in economic growth and innovation might be easy to imagine in the case of biology, chemistry, and physics, where intimidating people in white lab coats run experiments which can lead to improvements in medicine, manufacturing, and electronics. But is this argument true of mathematicians and statisticians? Of theorists who spend their days scribbling on paper and then throwing out 99 out of every 100 sheafs?

Some math is clearly useful. Engines, bombs, smartphones, airplanes—anything with a microprocessor was designed by an engineer who used math at some point in the process. Whether the boolean logic used to derive the circuit, or the geometry of the wings of an airplane, if you removed math from the process nothing would get off the ground.

But all of these applications use math that is very old and not very sophisticated. What about more abstract, theoretical mathematics?

This objection is best answered by simply listing examples. Hardy’s favorite useless subject, number theory (and elliptic curves in particular), turned out to be central to cryptography; the [Radon transform is integral to tomography](https://en.wikipedia.org/wiki/Radon_transform); differential geometry [describes the curvature of spacetime](https://en.wikipedia.org/wiki/Spacetime) and is core to general relativity; [topology is used to unfold large telescopes in space](https://www.ted.com/talks/robert_lang_the_math_and_magic_of_origami?subtitle=en), conic sections (studied as pure maths by the Greeks) [turned out to describe planetary orbits in Newtonian mechanics](https://khudian.net/Etudes/Geometry/lagrgivental4.pdf); [spectral theory](https://en.wikipedia.org/wiki/Spectral_theory) turned out to describe actual physical spectra (one of the great nominative coincidences of all time); measure theory turned out to be central to probability theory, which is in turn central to many areas such as quantum mechanics and neural networks; [concentration inequalities](https://en.wikipedia.org/wiki/Concentration_of_measure) turned out to be central in clinical trials and A/B tests. Gottfried Liebniz [seems to have invented calculus](https://en.wikipedia.org/wiki/Leibniz%E2%80%93Newton_calculus_controversy) without any application in mind. 

Still, this doesn’t answer the question of whether such math needs to be developed _before_ its applications, or whether it could have been invented only when needed. In fact, many branches of mathematics were initially pursued because of some practical problem. My field of study, sequential analysis, was invented during World War II because Milton Friedman and W. Allen Wallis [wanted to reduce the number of samples required to determine the efficacy of anti-aircraft fire on dive bombers](https://www.jstor.org/stable/2287451?saml_data=eyJzYW1sVG9rZW4iOiIzM2IxYmM5Yy00NzkwLTQ4NmYtYjk3My1kOTdhODdmOGVkNmUiLCJpbnN0aXR1dGlvbklkcyI6WyIyYWY5ZGQ3ZC1iOTBkLTQ0YTEtYjUzZS1kYmQzMmFkMTJmZmMiXX0). Joseph Fourier introduced the [Fourier series](https://en.wikipedia.org/wiki/Fourier_series#History) in order to solve the problem of how heat propagates in metal bodies. The physicist Edward Witten invented so much new mathematics to develop string theory that they [gave him the fields medal](https://www.britannica.com/biography/Edward-Witten). Isaac Newton, who simultaneously but independently invented calculus alongside Liebniz, did so motivated by problems in physics. 

<img id='img-70' src="/assets/writing_images/wald.png">
<p id='center' class='caption'>Abraham Wald worked at the Statistical Research Group from 1942-1945 at Columbia university and nearly single-handedly invented sequential analysis.</p>


Practical problems that pose mathematical questions encourage mathematicians to work on them. So can’t we just solve problems as they arise? What’s the point of trying to do math for math’s sake? Two reasons.

For one, we’ll solve problems faster if the relevant math is already understood. Wallis and Friedman asked the initial question that sparked interest in sequential analysis in 1942. Out of their mathematical depth, they handed the problem over to Abraham Wald. But it took Wald several years to flesh out the ideas—publications on even relatively simple problems did not start appearing until 1945. Had sequential analysis been developed earlier, its insights could have contributed to the war effort much sooner.

Second, math developed for particular applications typically has a very specific flavor. Almost by definition, it’s not as general as it could be because generality is not the goal. But it is only when mathematics is formulated as generally as possible that the connections between different areas are fully realized, and it’s precisely such connections which lead to the deepest insights. And generalization falls into the realm of pure mathematics since you are leaving the specifics of the application behind.

Generalization is responsible for the [relationship between geometry and algebra](https://en.wikipedia.org/wiki/Algebraic_geometry), which you’ve seen in its simplest form if you’ve ever plotted an equation on a graph. Engineers are relying on this connection whenever they find solutions to systems of polynomial equations, and it’s used in [control theory, robotics, coding theory, and genetics](https://en.wikipedia.org/wiki/Algebraic_geometry#Applications). Generalization is also responsible for category theory, which has found applications in [programming language theory](https://mathoverflow.net/a/4274), [quantum field theory](https://arxiv.org/abs/0903.0340) and [natural language processing](https://github.com/jbrkr/Category_Theory_Natural_Language_Processing_NLP,). In the [words of a stack overflow user](https://mathoverflow.net/questions/19325/most-striking-applications-of-category-theory) responding to requests for applications of category theory: “The question is too broad. Category theory plays roles in half of mathematics.”

In my own field, generalization was responsible for a [unifying perspective on concentration inequalities](https://arxiv.org/pdf/1808.03204) which led to tools that are now used by many tech companies.[^1] The work of mathematicians on merging geometry and calculus and generalizing the technique to higher dimensions gave Einstein the relevant tools for general relativity, without which your GPS wouldn’t work. Claude Shannon leveraged [boolean algebra](https://en.wikipedia.org/wiki/Boolean_algebra), then an abstract mathematical topic and a generalization of Liebniz’s [algebra of concepts](https://en.wikipedia.org/wiki/Gottfried_Wilhelm_Leibniz#Formal_logic), to show how circuits could be designed to perform logical operations. Every personal computer to this day is built using boolean algebra. The list goes on and on.

[^1]: See [this page](https://www.stat.cmu.edu/~aramdas/misc.html) and scroll to the bottom.

Theoretical research might be conceived of as pushing our knowledge in various areas as far as possible, to see if and where it meets our knowledge in other areas, and to forge connections with other problems. It’s hard to justify these explorations before these connections are found, but we’re glad to have done it when they are. And the more we know, the more connections we can make.

Can we prove beyond a doubt that pursuing fundamental research is integral to progress? No, but it would be foolish to ignore its role in economic growth and in helping us solve more applied problems. Given that we know it can and has helped move us forward, studying useless things is not so useless.

---
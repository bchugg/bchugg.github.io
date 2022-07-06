---
layout: writing
title: "The case for replacing peer-review with preprints and overlay journals"
description: Pre-publication peer-review sucks - embrace the preprint revolution! 
date: "2022-06-26" 
status: published
image: /assets/images/building.jpeg
---

<br/><br/>

**tl;dr** The traditional model of academic publishing involves pre-publication peer-review, whereby papers are submitted to journals (or conferences), evaluated by two or three anonymous referees, and accepted if they are deemed sufficiently important. Preprint servers, on the other hand, allow authors to upload papers without passing peer-review thus enabling them to immediately disseminate their work. I argue that preprint servers, augmented with public commenting capability, should entirely replace pre-publication peer-review. Public comments would play the role of the referee process and make the overall model more incentive compatible than the status quo. I also argue for "overlay journals," which are retrospective instead of prospective and publish the most successful papers from the preprint server. 

<br/>

- TOC 
{:toc}



# 1. Is publishing even cool anymore?

Yann LeCun, one of the biggest names in the field of machine learning, [had all of his submissions rejected](https://twitter.com/ylecun/status/1526033359398379521) from the _International Conference on Machine Learning_ (ICML) in 2022, one of the premier peer-reviewed conferences in computer science. Asked why he wants to have papers published in the first place, he [responded](https://twitter.com/ylecun/status/1526039476119781377) that he doesn't care either way but that it's useful for his students:

> To me, the benefit is pretty much zero. To the students and postdocs working with me who actually wrote the paper, it's pretty important. It may impact their career trajectory in pretty major ways.

This is a striking statement. Aren't venues such as ICML supposed to be what precipitate progress? Aren't they where we look for rigorously reviewed papers which answer the biggest questions and change the field? Shouldn't we be surprised that publishing in ICML is not benefiting LeCun?

## 1.1 The preprint revolution

The answer is no, because venues such as ICML are not responsible for the progress in computer science. LeCun's three papers — just like everyone else's in computer science — will be just as readily seen and consumed by the community because they exist on [arXiv](https://arxiv.org/) (pronounced "archive"), an open-access digital repository of papers. ArXiv is open to anyone and submissions are not peer-reviewed, but given only a cursory check that they are "topical to the subject area". There are no fees for submission.

ArXiv has revolutionized the dissemination of scientific work in physics, mathematics, statistics, computer science, and several other technical subjects. You'll be hard pressed to find a paper not submitted to arXiv well before it's either accepted or rejected by a journal or conference. Indeed, there's very little downside for authors. For one, arXiv papers are readily cited (choose a random paper in one of these fields and see how often the references are from arXiv). Further, both journals and conferences allow their submissions to be uploaded to the arXiv before or during review (see, e.g., ICML's [call for papers](https://icml.cc/Conferences/2022/CallForPapers)). For this reason, the popularity of arXiv has exploded in the last decade. There are more than 2,000,000 papers on the server, and the growth is exponential. In 2021, there were more than 60,000 papers in computer science alone uploaded to the server. Find official statistics [here](https://arxiv.org/help/stats/2021_by_area).

Other disciplines also have popular preprint servers. Economics has the Social Science Research Network (SSRN) and RePEc (Research papers in Economics). Biology and Medicine have bioRxiv. The American chemical association just released ChemRxiv. Psychology has PsyArXiv. Here's a [giant list](https://asapbio.org/preprint-servers) of preprint servers for various disciplines.

Preprint servers have successfully accomplished what scientific journals were supposed to. The original goal of the prestigious journal _Nature_, for instance, was to disseminate the newest science quickly.[^1] Unfortunately, as of 2021, the median time between submission and acceptance of a manuscript is [226 days](https://www.nature.com/nature/journal-impact). 

 [^1]: See _Making Nature_, by Melinda Clare Baldwin. Some quotes: "Unlike the literary periodicals, there was almost no delay between the submission of a piece and its appearance in the journal." (pg. 63.) "Many British men of science found that one of the fastest ways to bring a scientific issue or idea to their fellow researchers' attention was to send a communication to Nature." (pg. 39.) See also the [review on ACX.](https://astralcodexten.substack.com/p/your-book-review-making-nature?s=r)

# 2. The proposal, in brief

Given the success and popularity of preprint servers, I argue that we can improve the scientific enterprise by 
- (i) letting preprint servers replace traditional publication venues which use pre-publication peer-review, 
- (ii) augmenting preprint servers with the ability to comment and to upvote others' comments, and 
- (iii) encouraging new "overlay journals" which publish the most successful preprints. 

Overlay journals curate collections of papers on the preprint server which they believe are valuable. They do not "publish" a paper separately, but simply point to the version on the server. This makes them significantly more cost-effective than traditional journals. I'll highlight more of their benefits below. 


Moving forward, I'm just going to write "peer-review" instead of "pre-publication peer-review". 

## 2.1 Q: Is this a novel idea? A: Not really

Despite me writing the first draft of this post thinking I was to peer-review as Galileo was to the Catholic church, a quick search shows that abolishing pre-publication peer-review is not an original proposal.  

In 2012, Brian Nosek and Yoav Bar-Anan [argued against](https://arxiv.org/pdf/1205.1055.pdf) this "needlessly inefficient" process, comparing it to "anachronistic practices of bygone eras."  In 2015, da Silva and Dobránszki [argued for](https://pubmed.ncbi.nlm.nih.gov/25275622/) post-publication  (as opposed to pre) peer-review as a way to remedy some of the inefficiencies in the current system. In 2017, Katzav and Vaesen [proposed](https://quod.lib.umich.edu/p/phimp/3521354.0017.019/--pluralism-and-peer-review-in-philosophy?view=image) relaxing publication standards in philosophy because peer-review was resulting in a bias against certain philosophical approaches.[^bias]

[^bias]: Honestly, if the bias is against continental philosophy, then I struggle to summon the will to care that much. A world with less Hegel seems like an all around better world. 


More recently, Remco Heesen and Liam Bright asked the question "[Is Peer Review a Good Idea?](https://philpapers.org/archive/HEEIPR.pdf)" In one of those good-for-the-world-but-bad-for-my-ego moments, it turns out they also propose commenting and overlay journals: 

> Our proposal is to abolish prepublication peer review. Scientists themselves will decide when their work is ready for sharing. When this happens, they publish their work online on something that looks like a preprint archive (think arXiv, bioRxiv, or PhilSci-archive, although the term ‘preprint’ would not be appropriate under our proposal). Authors can subsequently publish updated versions that reply to questions and comments from other scientists, which may have been provided publicly or privately. The business of journals will be to create curated collections of previously published articles. Their process for creating these collections will involve (postpublication) peer review, insofar as they currently use prepublication peer review.


In general, there seems to be a growing consensus that the status quo is unacceptable. Both [Vox](https://www.vox.com/2015/12/7/9865086/peer-review-science-problems) and [The Conversation](https://theconversation.com/peer-review-is-in-crisis-but-should-be-fixed-not-abolished-67972) have complained about peer-review. [Some academics](https://www.cs.cmu.edu/~nihars/) dedicate their research agendas to improving peer-review. Efforts to improve it include devising better ways of [matching papers and reviewers](https://arxiv.org/abs/2202.12273), or introducing [new journals](https://www.jmlr.org/tmlr/) to speed up the review process.  There is also an increasing focus on "meta-science", the focus of which is improve the scientific process (e.g., [Seeds of Science](https://www.theseedsofscience.org/), [New Science](https://newscience.org/)). 

So, obviously this proposal is not all that new. Still, I wrote several arguments in favor of it, and I'm going to tell you about them. 


# 3. A peer reviews peer-review

Before committing to an idea like replacing traditional peer-review with something else, it's worth asking the question, what does pre-publication peer-review actually accomplish?

## 3.1 Is peer-review effective?

Purportedly, peer-review ensures that submissions are of high enough quality to be published, that the results are coherent and robust, that the methodology is sound, and (unless it's a replication) the research is novel. There's no doubt peer-review can serve to separate some of the bad papers in these respects from some of the good ones, but how reliable is this signal?

While the number of reviewers varies by discipline, there are typically two to four reviewers for one paper, perhaps alongside an area chair or a meta-reviewer to oversee the process and make the final decision. This is a very small group of people to judge the quality of the work. Often, reviewers are only passingly familiar with the material and are unfit to comment on the technical details. Any researcher will be familiar with the process of submitting a paper, only to have one or more reviews be entirely vacuous.

We don't need to rely on anecdotes, however. There is a literature on the effectiveness of peer-review (fear not, most of it is peer-reviewed). In [Peer Review in Scientific Publications: Benefits, Critiques, &amp; A Survival Guide](https://www.ncbi.nlm.nih.gov/pmc/articles/PMC4975196/), the authors write "that there is little evidence that the [peer-review] process actually works, that it is actually an effective screen for good quality scientific work, and that it actually improves the quality of scientific literature". An [experiment](https://ils.unc.edu/courses/2015_fall/inls700_001/Readings/Ware2008-PRCPeerReview.pdf) which deliberately inserted eight errors into a manuscript and sent it to 420 reviewers found that the average number of errors caught was two, and nobody caught more than five. Relatedly, more than 100 nonsense papers generated by [SCIgen](https://pdos.csail.mit.edu/archive/scigen/) were [accepted](https://www.nature.com/articles/nature.2014.14763) by IEEE, and 16 by Springer. David Colquhoun [argues](https://www.theguardian.com/science/2011/sep/05/publish-perish-peer-review-science) that the number of papers published in a year far outweighs the available number of competent reviewers (i.e., those with expertise in the subject matter).

In 2014, the program chairs of the Neural Information Processing Systems (NeurIPS) conference conducted an experiment to assess the variation between reviews. Ten percent of the papers were randomly selected to be reviewed by two separate committees. An [analysis](http://blog.mrtz.org/2014/12/15/the-nips-experiment.html) found that

> about 57% of the papers accepted by the first committee were rejected by the second one and vice versa. In other words, most papers at [NeurIPS] would be rejected if one reran the conference review process (with a 95% confidence interval of 40-75%).

A followup [analysis](https://arxiv.org/abs/2109.09774) which tracked the accepted papers over seven years found that " **there is no correlation between quality scores and impact of the paper as measured as a function of citation count**" (emphasis mine). In light of these results, the authors suggest that "that the community should place less onus on the notion of 'top-tier conference publications' when assessing the quality of individual researchers."

## 3.2 Misaligned incentives

Poor review quality becomes unsurprising, even expected, the moment we remember that reviewers are subject to incentives just like everyone else. They are anonymous, busy, and don't get recognition for good reviews.[^2] There is no penalty for rejecting a good paper, nor for accepting a bad one. Nobody will know if you turned down [On the Electrodynamics of Moving Bodies](http://hermes.ffn.ub.es/luisnavarro/nuevo_maletin/Einstein_1905_relativity.pdf) because it was written by some patent clerk whose ideas seem a little odd. 

 [^2]: Some conferences in computer science have attempted to remedy this by assigning (non-monetary) rewards for review service. There is only one flaw with this tactic: Nobody cares about these awards.

Reflecting on why his paper was rejected from _Nature_, only to have a paper with the same thesis published a few months later, the Canadian geophysicist Lawrence Morley [notes](https://www.ncbi.nlm.nih.gov/pmc/articles/PMC4528400/) a paradox at the heart of peer-review:

> I knew that when a scientific paper was submitted to a journal, the editors choose reviewers who are experts on the topic being discussed. But the very expertise that makes them appropriate reviewers also generates a conflict of interest: they have a vested interest in the outcome of the debate. We could call this the 'not invented here syndrome': scientists may be biased against good ideas emerging from someone else's lab.

In other words, reviewers might be biased against papers with a similar thesis as their own because they don't want to be scooped. Anonymous peer-review ensures that, in such cases, the reviewers don't bear the consequences of rejecting a sound paper.

The result of an unreliable review process is that a rejection of a paper is viewed by the authors as bad luck, not as a reliable signal of its quality. In computer science, this leads to the well known submission iteration cycle in which authors receive a rejection from one conference only to turn the piece around a few days later and submit to another. Rejected from ICML? Submit to NeurIPS. Rejected from NeurIPS? Submit to ICLR. In fact, this strategy is explicitly [endorsed by AAAI](https://aaai.org/Conferences/AAAI-22/neurips-fast-track-submissions/) and their fastrack submission process for rejected NeurIPS papers. This strategy works. I know of instances of papers being rejected by one conference, only to win an award at the next one.[^3]

[^3]: No citation for obvious reasons. 

# 4. The benefits of (comment-augmented) preprints

Given the stochasticity and arbitrariness of the peer-review system as it currently exists, and the fact that preprint servers are already exploding in popularity, I suggest we discard the current system and simply rely on preprint servers for dissemination of scientific ideas.

However, there is one major change I would make to preprint servers as they exist right now, and that is to add the ability to make comments, and vote on others' comments in some way (e.g., upvoting/downvoting like Reddit, or "liking" like Twitter). Commenting would be tied to an academic profile[^4], much like [OpenReview](https://openreview.net/).

[^4]: There’s an interesting discussion to be had regarding allowing anonymous comments, but one would have to think carefully about the incentive structure.

Such a system has many potential benefits.

**Aligns interests of commenters with subject area**. Instead of a handful of peer-reviewers who may not be interested in the paper, those commenting will naturally be those most interested and familiar with the area. The feedback will thus be higher quality, and mistakes will stand a higher chance of being pointed out.

**Commenters have skin in the game.** Non-anonymous commenters are incentivized to provide good feedback, otherwise they will be downvoted. Good comments, meanwhile, can raise your status in the community by, e.g., demonstrating that the analysis was wrong or that the results don't replicate. Indeed, one hope is that comment statistics might even become part of an academic's portfolio, with high quality and rigorous comments prized just as much as papers. Perhaps publication profiles (e.g., Google scholar),  would recognize the number of comment upvotes, in addition to your h-index. This would enable division of labor, allowing those who want to focus on criticizing poor papers to gain status in the scientific community, a service very much needed in light of issues such as the replication crisis in psychology.

**Creates dialogue between authors and commenters**. Papers which did not respond to valid, highly upvoted, criticism would suffer reputational damage. Authors would thus engage with their critics, either defending their results or perhaps agreeing and uploading another version which fixes the problem.

**Reduces barriers for non-academics**. Publications fees are expensive! Relying on preprints as the primary mode of knowledge dissemination reduces barriers for people without academic funding to contribute. This opens the door for non-academics, and for bright high-school students and undergrads to write scientific papers without requiring funding.

**Incentivizes better papers**. As an author, if you know that once on a preprint server your paper will be commented on, weaknesses pointed out, the analysis re-run using your data, then I think you'll be more rigorous. The game ceases to be "fool three reviewers to get my paper accepted" and becomes "I better impress the people who know this research best otherwise someone is going to point out a flaw and I'll be embarrassed."

**Transparency**. This system is significantly more transparent than the status quo since comments are public. 

**Discards the for-profit journal model**. [There](https://tidsskriftet.no/en/2020/08/kronikk/money-behind-academic-publishing) [are](https://www.theguardian.com/science/2017/jun/27/profitable-business-scientific-publishing-bad-for-science) [many](https://www.electrochem.org/for-science-or-for-profit/) [concerns](https://www.ncbi.nlm.nih.gov/pmc/articles/PMC1557876/) [about](https://www.ncbi.nlm.nih.gov/pmc/articles/PMC6740196/) [for-profit](https://undark.org/2020/03/30/science-publishing-open-acess/) [publishing](https://journals.plos.org/plosone/article?id=10.1371/journal.pone.0253226) [companies](https://www.vocativ.com/culture/science/five-corporations-control-academic-publishing/index.html). In this model, since there would be no (prospective) journals, there would be no such problem.

# 5. Leveling up: Overlay journals

My final suggestion is the introduction of [overlay journals](https://en.wikipedia.org/wiki/Overlay_journal), which curate collections of the most promising or successful preprints. How they judge "successful" is up to them -- most innovative, most replicated, the most citations after some period of time, best writing, most explanatory, and so on. Unlike traditional academic journals, the goal of overlay journals is simply to recognize outstanding work as opposed to gatekeeping it.

Overlay journals already exist. [_Discrete Analysis_](https://discreteanalysisjournal.com/), for example, is an arXiv overlay math journal [introduced](https://gowers.wordpress.com/2015/09/10/discrete-analysis-an-arxiv-overlay-journal/) by Timothy Gowers. As [noted](https://discreteanalysisjournal.com/for-authors) on the website, the model is extremely cost-effective: 

> Discrete Analysis is an arXiv overlay journal. This means that while we have a conventional editorial board and refereeing process, we do not host the articles we accept or offer a formatting and copy-editing service. Instead, we simply link to preprints that are posted on the arXiv, which we believe amply meets the needs of our readers. As a result, the cost of running the journal, while not quite zero, is extremely low. Therefore, there are no charges for authors (and obviously none for readers, since the accepted papers are on the arXiv).

One attraction of overlay journals is the ability of editors to withhold publishing a preprint until they witness its value to the community. While traditional journals publish new papers, overlay journals don't have to guess at impact _a priori_. Indeed, by waiting and publishing only those papers which have had a positive impact (where, again, there may be multiple metrics for impact), overlay journals can incentivize better work. 

That said, such a practice would constitute a departure from how overlay journals currently function. Existing overlay journals seem to work in the traditional paradigm whereby authors submit to the journal shortly after the preprint is available. Rousi and Laakso recently [studied](https://arxiv.org/pdf/2204.03383.pdf) a sample of 35 overlay journals, and conclude that "the model does not, as it is commonly implemented today, provide a radical change to the open science practices as part of the pre-publication and review process." However, they also note that the movement is still in its nascent stages. 

A final issue worth discussing is funding. If authors aren't paying to be published, and readers aren't paying for access, where does the money come from? Answer: Grants! Prizes! Public and private funding! Just like researchers and labs compete for funding, so too should journals. 



# 6. Counterarguments

**Without peer-review, how do we differentiate good and bad papers?** 
As detailed in Section 2.1, it's unclear whether peer-review in its current form is doing a good job separating the wheat from the chaff. Removing the thin veneer of pre-publication peer-review means that papers will have to be judged on how well they stand up to scrutiny. In experimental subjects, this might mean how well they replicate. In theoretical subjects, this will mean how sound their arguments are. Researchers will have to engage with work in order judge its merit instead of relying on the stamp of approval of an anonymous referee. And if a researcher determines that a paper's findings don't stand up to scrutiny, they can point this out to the rest of community in the form of a comment. 


In short, I agree that the principle behind peer-review is valuable. I think it's so valuable that we should stop judging papers according to randomly assigned anonymous referees with no skin in the game, and instead let a paper be judged by those who care most about the paper and who understand the most about the subject area.

**Why would anyone comment?** To my mind, this is the best objection to the proposed system. Cultivating an environment in which good comments receive attention and increase status for their authors seems difficult. For instance, [_PLoS one_](https://journals.plos.org/plosone/) is a journal which allows comments on papers, but a quick skim of their archives reveals that few papers actually receive any. Lack of tangible credit has also been [cited](https://www.nature.com/articles/4471052d) as the reason why open commenting didn't work for _[Biology Direct](https://biologydirect.biomedcentral.com/)_. 

Still, I maintain that there's hope. For one, _PLoS One_ and _Biology Direct_ experimented with commenting on already published papers. This is less appealing than commenting on preprints, which can be changed as a result of your criticism. There was also no upvote/downvote capacity, and no way for comments to be tied to a general academic profile which would list comments as part of your output. As mentioned above, the emergence of academic profiles which track your comments and their karma alongside your citation numbers would help to incentivize commenting. 

Moreover, I think there is an appetite for critical examinations of studies across a variety of fields. Alexey Guzey's [dismantling](https://guzey.com/books/why-we-sleep/) of Matthew Walker's _Why We Sleep_, and the respect this earned him in various sub-communities (e.g., the "rationality" community) illustrate the demand for thorough fact-checking. Similarly for the _Growth in a time of debt_ fiasco, in which the graduate student [Thomas Herndon](https://en.wikipedia.org/wiki/Thomas_Herndon) pointed out severe errors in the influential paper by Carmen Reinhart and Kenneth Rogoff. The problem is that, as of yet, there is nowhere to conduct such conversations which facilities a response from the authors or a robust community discussion. 

**Most papers won't receive any attention**. Most papers don't receive any attention anyways. Citation counts follow (roughly) a power law distribution, with most papers receiving little attention, and only a small fraction being highly influential. And for papers which are garnering much attention -- notwithstanding the previous counterargument -- there would be incentive to comment, either to point out mistakes, make suggestions, or extend the work.

**In disciplines with peer-reviewed conferences, such conferences do more than publish papers -- they bring researchers together which fosters a sense of community and helps spark new ideas**. I don't object to conferences, but there's no reason they need to have peer-reviewed proceedings. In fact, many disciplines (e.g., biology, chemistry) have non peer-reviewed conferences.

**Won't this flood the preprint server with bad comments?** I don't think so. Similar concerns were expressed with Wikipedia, but it turns out to be astonishingly reliable. The hope is that good comments would be reliably upvoted by other experts.

**Removing anonymity introduces bias. Reviews can be biased against authors, and authors can be retaliate against authors whose comments they deem unfair.** 
Given an active and non-anonymous commenting ecosystem, commenters are incentivized to be rigorous and accurate. Unfair comments will be downvoted, and their authors will suffer reputational damage. 


# 7. Final thoughts

Many of the ideas presented here are already being experimented with at one scale or another. [Researchers.One](https://researchers.one/) is a new preprint server which allows public comments. [Preprints.org](https://www.preprints.org/how_it_works) is trying something similar. 

Many journals are experimenting with open review (i.e., public referee reviews), which is one more step in the right direction. Now the public and other researchers can examine the quality of the criticism, and how the authors responded to it. The next natural step is to allow the criticism to come from anyone. 

In fact, a good incremental step would be to allow public commenting, but to assign several referees who must comment. This would create a minimum standard of engagement for each paper, while leaving open the door for more discussion to take place if needed. 

<br/>

**Acknowledgements**

The idea for adding comments to arXiv came from [Clay Shentrup's comment](https://twitter.com/UtilaTheEcon/status/1525981789566537728) on Robert Wiblin's [tweet](https://twitter.com/robertwiblin/status/1525946982384209922). The idea for retrospective journals came from Tim Gowers [blog](https://gowers.wordpress.com/2015/09/10/discrete-analysis-an-arxiv-overlay-journal/). Thanks to Mira Korb for helpful discussions, and to Lawrence Kestelfoot, Josh Levent, and Cameron Peters for comments. Thanks also to some folks at [Seeds of Science](https://www.theseedsofscience.org/) who informed me that my ideas and arguments were not nearly as novel as I thought. 

---
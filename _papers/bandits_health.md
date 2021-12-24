---
layout: default 
title: Reconciling Risk Allocation and Prevalence Estimation in Public Health Using Batched Bandits
authors: Ben Chugg and Daniel E. Ho
publication: Neural Information Processing Systems, Workshop on Machine Learning in Public Health
year: 2021
date: "2021-12-14"
link: https://arxiv.org/pdf/2110.13306.pdf
code: https://github.com/reglab/mab-infectious-disease
abstract: "In many public health settings, there is a perceived tension between
        allocating resources to known vulnerable areas and learning about the overall
        prevalence of the problem. Inspired by a door-to-door Covid-19 testing program
        we helped design, we combine multi-armed bandit strategies and insights from
        sampling theory to demonstrate how to recover accurate prevalence estimates
        while continuing to allocate resources to at-risk areas. We use the outbreak of
        an infectious disease as our running example. The public health setting has
        several characteristics distinguishing it from typical bandit settings, such as
        distribution shift (the true disease prevalence is changing with time) and
        batched sampling (multiple decisions must be made simultaneously).
        Nevertheless, we demonstrate that several bandit algorithms are capable
        out-performing greedy resource allocation strategies, which often perform worse
        than random allocation as they fail to notice outbreaks in new areas."
---

---
layout: page
title: Research Notes
description: Muddling my way through various topics in math, statistics, and computer science
image: /assets/images/chalkboard.jpeg
---

<div class='research-notes-quote'> 
<i>We have not succeeded in answering all our problems.
The answers we have found only serve to raise a whole set
of new questions. In some ways we feel we are as confused
as ever, but we believe we are confused on a higher level
and about more important things.</i>
<p id='credit'>
 - Posted outside the mathematics reading room at Tromsø University 
</p>
</div>

Notes on various topics for my own edification. The majority of material is not original and is simply a restatement of previous results in language that makes the most intuitive sense to me. Making the notes public just helps keep me accountable for their accuracy. Maybe they can also help others in the eternal quest to reduce confusion. Some wiser advice on why keeping such notes is useful comes from Ryan Giordano [here](https://rgiordan.github.io/meta/2019/07/26/why.html). 



<hr>

{% assign notesByYear = site.research_notes | where_exp: "item", "item.status == 'published'" | sort: "date" | reverse | group_by_exp:"item", "item.date | date: '%Y'"%}

{% for year in notesByYear %}
  <h1>{{ year.name }}</h1>
  <ul>
      {% for post in year.items %}
        <li>
            {{ post.date | date: "%m/%d"}} - <a href="{{ post.url }}">{{ post.title }}</a>
        </li>
      {% endfor %}
    </ul>
{% endfor %}



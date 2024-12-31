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

Notes for my own benefit. You can [subscribe]({% link subscribe.md %}) to be notified of new posts.  



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



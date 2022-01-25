---
layout: default 
title: Research Notes
---

Notes on various topics for my own edification. Making them public mostly just helps keep me accountable for their accuracy (no promises, though). Some wiser advice on why keeping such notes are useful comes from Ryan Giordano [here](https://rgiordan.github.io/meta/2019/07/26/why.html). 
{% assign notes = site.research_notes | where_exp: "item","item.published" | sort: "date" | reverse %}
<ul class='note-list'>
{% for note in notes %}
<li>
    <a href="{{ note.url }}">{{ note.title }}</a> 
    <span>{{note.date | date: "%b %Y"}}</span>
</li>
{% endfor %}
</ul>


---
layout: page
title: Writing
description: "Spicy takes and explorations of various topics"
image: /assets/images/building.jpeg
---

Thoughts on things. If a post is old I'm probably at least semi-embarrassed by it and/or partially disagree with my own conclusions. So if you disagree with something send me an email and perhaps we can ~~fight to the death~~ laugh at it together. 

<br/>

{% assign internal_texts = site.writing | where_exp: "item", "item.status == 'published'" %}
{% assign external_texts = site.external_writing | where_exp: "item", "item.status == 'published'" %}
{% assign texts = internal_texts | concat: external_texts | sort: "date" | reverse %}

<ul class='writing-list'>
{% for text in texts %}
<li>
    <div class='writing-entry'>
        <p class='title-date'>
            {% unless text.external_only != nil and text.external_only %}
            <a class="title" href="{{ text.url }}">{{ text.title }}</a> <small>({{ text.date | date: "%b %Y"}})</small>
            {% else %}
            <a class='title' href="{{ text.external_link }}">{{ text.title }}</a> 
            <small>
            ({{ text.date | date: "%b %Y"}}, {{ text.external_source }})
            </small>
            {% endunless %}
        </p>
        {% if text.subtitle != nil %}
        <p class='subtitle'>    
            {{ text.subtitle }}
        </p>    
        {% endif %}
    </div>
</li>
{% endfor %}
</ul>

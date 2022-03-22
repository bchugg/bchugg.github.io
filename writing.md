---
layout: page
title: Writing
---

Thoughts on things. If a post is old I'm probably at least semi-embarrased by it and/or partially disagree with my own conclusions (does this happen to good writers?). So if you disagree with something send me an email and perhaps we can ~~fight to the death~~ laugh at it together. 

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
            <a class="title" href="{{ text.url }}">{{ text.title }}</a>
            {% else %}
            <a class='title' href="{{ text.external_link }}">{{ text.title }}</a>
            {% endunless %}
            <span>{{ text.date | date: "%b %Y"}}</span>
        </p>
        {% if text.subtitle != nil %}
        <p class='subtitle'>    
            {{ text.subtitle }}
        </p>    
        {% endif %}
        {% if text.external_link != nil and text.external_source != nil %}
        <p class='external-info'>
        ({{ text.external_source }})
        </p>
        {% endif %}
    </div>
</li>
{% endfor %}
</ul>

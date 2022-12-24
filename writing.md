---
layout: page
title: Writing
description: "Spicy takes and explorations of various topics"
image: /assets/images/building.jpeg
---

Sometimes I have thoughts, and sometimes I write them down. 

<br/>

{% assign internal_texts = site.writing | where_exp: "item", "item.status == 'published'" %}
{% assign external_texts = site.external_writing | where_exp: "item", "item.status == 'published'" %}
{% assign texts = internal_texts | concat: external_texts | sort: "date" | reverse %}

<table class='writing-table'>
{% for text in texts %}
<tr>
<td>
    {% unless text.external_only != nil and text.external_link %}
    <a class="title" href="{{ text.url }}">{{ text.title }}</a> 
    {% else %}
    <a class='title' href="{{ text.external_link }}">{{ text.title }}</a> 
    {% endunless %} 
    <p><small class='subtitle'>{{ text.description }}
    <i>{% if text.external_source != nil %}({{ text.external_source }}){% endif %}</i>
    </small>  
    </p>
    <hr>
</td>
<td>
    <small id='date'>{{ text.date | date: "%b %Y"}}</small>
</td>
</tr>
{% endfor %}
</table>


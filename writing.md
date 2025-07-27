---
layout: page
title: Writing
description: "There is nothing to writing. All you do is sit down at a typewriter and bleed."
image: /assets/images/building.jpeg
---


You can subscribe to be notified of new essays [here](https://www.stepstophaeacia.com/). 

{% assign internal_texts = site.writing | where_exp: "item", "item.status == 'published'" %}
{% assign external_texts = site.external_writing | where_exp: "item", "item.status == 'published'" %}
{% assign textsByYear = internal_texts | concat: external_texts | sort: "date" | reverse | group_by_exp:"item", "item.date | date: '%Y'" %}


{% for year in textsByYear %}
  <h1>{{ year.name }}</h1>
  <ul>
      {% for post in year.items %}
        <li>
            {% if post.external_only != nil and post.external_link %}
                {% assign thisUrl = post.external_link %}
            {% else %}
                {% assign thisUrl = post.url %}
            {% endif %}
            {{ post.date | date: "%m/%d"}} - <a href="{{ thisUrl }}">{{ post.title }}</a>
            <i>{% if post.external_source != nil %}({{ post.external_source }}){% endif %}</i>
        </li>
      {% endfor %}
    </ul>
{% endfor %}


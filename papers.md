---
layout: page
title: Papers
---

<p style="text-align: center">
  <em>"Curiouser and curiouser!" Cried Alice.</em>
</p>

{% assign publications = site.papers | sort: "date" | reverse %}
{% for pub in publications %}
<div class="pubitem">
  <div class="pubtitle">{{ pub.title }}</div>
  <div class="pubauthors">{{ pub.authors }}</div>
  <div class="pubinfo"><em>{{ pub.publication }}</em>, {{ pub.year}}</div>
  <div class='publinks'>
    {% unless pub.link == nil %}
         <a href="{{ pub.link }}">pdf</a> 
    {% endunless %} 
    {% if pub.code != nil %}
        | <a href="{{ pub.code }}">code</a>
    {% endif %}

  </div>
    
</div>
{% endfor %}
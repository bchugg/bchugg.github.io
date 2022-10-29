---
layout: page
title: Papers
description: Publications, preprints, and theses
image: /assets/images/manuscript.jpeg
---


<div class='papers'>
  <p style="text-align: center">
    <em>"Curiouser and curiouser!" Cried Alice.</em>
  </p>

  <h1>Publications and Preprints</h1>

  {% assign publications = site.papers | sort: "date" | reverse | where_exp: "item", "item.type != 'thesis'" %}
  {% assign n = publications.size %}
  {% for pub in publications %}
  <div class="pubitem">
    <div class="pubtitle"><a href='{{ pub.link }}'>{{ pub.title }}</a></div>
    <div class="pubauthors">{{ pub.authors }}. 
    </div>
    {% if pub.publication != nil %}
      <div class="pubinfo">
        <em>{{ pub.publication }}</em>, {{ pub.year}}
      </div>
    {% endif %}
  </div>
  {% assign n = n | minus:1 %}
  {% endfor %}

  <h1>Theses</h1>

  {% assign theses = site.papers | where_exp: "item", "item.type == 'thesis'" | sort: "date" | reverse %}
  {% for pub in theses %}
  <div class="pubitem">
    {% if pub.link != nil %}
      <div class="pubtitle"><a href='{{ pub.link }}'>{{ pub.title }}</a></div>
    {% else %}
      <div class="pubtitle">{{ pub.title }}</div>
    {% endif %}
    <div class="pubinfo"><em>{{ pub.publication }}</em>, {{ pub.year}}</div>
  </div>
  {% endfor %}

</div>
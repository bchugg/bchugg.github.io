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

  {% assign categories = "Theory|Application" | split: "|" %}


  {% for cat in categories %}

  <h1>Papers - {{ cat }} </h1>

  {% assign publications = site.papers | sort: "date" | reverse | where_exp: "item", "item.category == cat"%}

  <table class='papers-table'>
  {% for pub in publications %}
  <tr>
  <td>
   <div class="pubtitle">{{ pub.title }}</div>
    <div class="pubauthors">{{ pub.authors }}.</div>
    {% if pub.publication != nil %}
      <em>{{ pub.publication }}</em> | 
    {% endif %}
    <a href='{{ pub.link }}'>paper</a>
    {% if pub.code != nil %} 
       | <a href='{{ pub.code }}'>code</a>
    {% endif %}
  </td> 
  <td>
    <div class="pubinfo">
        {{ pub.year }}
        <small id='highlight'>{% if pub.highlight != nil %} <br> {{ pub.highlight }}{% endif %}</small>
    </div>
  </td>
  </tr>
  {% endfor %}
  </table>
   
  {% endfor %}

  
</div>
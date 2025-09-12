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

  {% assign pubs = site.papers | sort: "date" | where_exp:"item", "item.show" | reverse | uniq %}


  
<h1> Selected papers </h1>
  
  For a full list see my <a href="{% link assets/files/cv.pdf %}">CV</a>.

  <table class='papers-table'>
  {% for pub in pubs %}
  <tr>
  <td>
   <div class="pubtitle">{{ pub.title }}</div> 
    <!-- <div class="pubauthors">{{ pub.authors }}.</div> -->
    <div class="pubauthors">
      {% assign author_list = pub.authors | split: ", " %}
      {% for author in author_list %} 
        {% assign name_parts = author | split: " " %}
        {% assign last_name = name_parts[-1] %}
        {% assign initials = "" %}
        {% for name_part in name_parts %}
          {% unless forloop.last %}
            {% assign initial = name_part | slice: 0 %}
            {% assign initials = initials | append: initial | append: "." %}
          {% endunless %}
        {% endfor %}
        {{ initials }} {{ last_name }}{% unless forloop.last %}, {% endunless %}
      {% endfor %}
    </div>
    {% if pub.publication != nil %}
      <em>{{ pub.publication }}, </em> 
    {% endif %}
    {{ pub.year }} 
    {% if pub.highlight != nil %} <span id='highlight'>({{ pub.highlight }})</span> {% endif %}
    &middot;  
    <a href='{{ pub.link }}'>paper</a>
    {% if pub.code != nil %} 
       &middot; <a href='{{ pub.code }}'>code</a>
    {% endif %}
  </td> 
  </tr>
  {% endfor %}
  </table> 

  





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

  {% assign preprints = site.papers | sort: "date" | where_exp:"item", "item.show" | where_exp:"item", "item.publication == 'preprint'" | reverse | uniq %}
  {% assign pubs = site.papers 
  | sort: "date" 
  | where_exp: "item", "item.show == true" 
  | where_exp: "item", "item.publication != 'preprint'" 
  | reverse 
  | uniq %}

  
<h1> Selected papers </h1>

For a full list see my <a href="{% link assets/files/cv.pdf %}">CV</a>.

<h2> Preprints </h2>

<table class='papers-table'>
  {% for pub in preprints %}
  <tr>
  <td>
   <div class="pubtitle"><a href='{{ pub.link }}'>{{ pub.title }}</a></div> 
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
        {{ initials }} {{ last_name }}{% if forloop.last %}.{% else %}, {% endif %}
      {% endfor %} 
      {{ pub.year }} 
    </div>
  </td> 
  </tr>
  {% endfor %}
  </table> 


<h2> Publications </h2>

  <table class='papers-table'>
  {% for pub in pubs %}
  <tr>
  <td>
   <div class="pubtitle"><a href='{{ pub.link }}'>{{ pub.title }}</a></div> 
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
        {{ initials }} {{ last_name }}{% if forloop.last %}.{% else %}, {% endif %}
      {% endfor %}
      {% if pub.shortpub != nil %}
      <em>{{ pub.shortpub }}, </em> 
    {% endif %}
    {{ pub.year }} 
    {% if pub.highlight != nil %} <span id='highlight'>({{ pub.highlight }})</span> {% endif %}
    </div>
    <!-- {% if pub.publication != nil %}
      <em>{{ pub.publication }}, </em> 
    {% endif %} -->
  </td> 
  </tr>
  {% endfor %}
  </table> 

  





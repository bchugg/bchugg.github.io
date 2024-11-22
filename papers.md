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


  
<h1> Selected Papers </h1>
  
  For a full list see my <a href="{% link assets/files/cv.pdf %}">CV</a>.

  <table class='papers-table'>
  {% for pub in pubs %}
  <tr>
  <td>
   <div class="pubtitle">{{ pub.title }}</div> 
    <div class="pubauthors">{{ pub.authors }}.</div>
    {% if pub.publication != nil %}
      <em>{{ pub.publication }}, </em> 
    {% endif %}
    {{ pub.year }} 
    {% if pub.highlight != nil %} <span id='highlight'>({{ pub.highlight }})</span> {% endif %}
    | 
    <a href='{{ pub.link }}'>paper</a>
    {% if pub.code != nil %} 
       | <a href='{{ pub.code }}'>code</a>
    {% endif %}
  </td> 
  <!-- <td>
    <div class="pubinfo">
        {{ pub.year }}
        <small id='highlight'>{% if pub.highlight != nil %} <br> {{ pub.highlight }}{% endif %}</small>
    </div>
  </td> -->
  </tr>
  {% endfor %}
  </table> 

  





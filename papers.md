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

  {% assign pubs = site.papers | sort: "date" | reverse | uniq %}


  
  <h1>Papers & Preprints </h1>
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

  
<!-- {% capture markdown_content %}
# Software 

Aside from the code associated with the papers above, here are some packages that I maintain. 

<span style="color: black; font-weight: bold">testing-by-betting</span>: A python package which implements various methods for sequential, nonparametric hypothesis testing using various tools from game-theoretic probability and statistics. [[github]()] [[pypi]()]

<span style="color: black; font-weight: bold">xbounds</span>: A lightweight python package for Extreme Bounds Analysis. Computes both Leamer and Sala-i-Martin robustness criteria. Handles fixed-effects and multiprocessing. [[github]()] [[pypi]()]

{% endcapture %}
{{ markdown_content | markdownify }} -->





---
layout: recommendations
title: Books
---

An eclectic collection of books I've enjoyed. Needless to say, I don't agree with everything in each book, but they've all been influential on my thinking in some way.  

{% assign books = site.books %}
{% assign genres = books | map: "genre" | uniq %}

<div class='books'>
	{% for genre in genres %}
	<h4 id='{{ genre }}'>{{ genre }}</h4>
		{% assign genreBooks = books | where: "genre", genre %}
		{% for book in genreBooks %}
		<div class='book-rec'>
			<img src="{{ book.im_path | relative_url }}">
			<div class='middle'>
				<div class='title'>{{ book.title }}</div>
				<br>
				<auth>{{ book.author }}</auth>
				<br>
			</div>
		</div>
		{% endfor %}
	{% endfor %}
</div>

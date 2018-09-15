<html>
<head>
	<!-- Stylesheets -->
	<link rel="stylesheet" type="text/css" href="assets/stylesheets/main.css">
	<!-- Bootstrap -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
	</script>
</head>
<body>
	<?php include 'shared/header.php'; ?>
	<div class='container-fluid main-body'>
		<div class='container photo text-center'>
			<div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner">
      <div class="item active">
        <img src="la.jpg" alt="Los Angeles" style="width:100%;">
      </div>

      <div class="item">
        <img src="chicago.jpg" alt="Chicago" style="width:100%;">
      </div>
    
      <div class="item">
        <img src="ny.jpg" alt="New york" style="width:100%;">
      </div>
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
			<?php # include 'shared/carousel.php'; ?>
			<!-- <img id='top-img' src="./assets/images/me.JPG" alt='A silly picture of me'>			 -->
		</div>
		<div class='col-sm-6 col-sm-offset-3 info'>
			<h4>
				Hello! I have big ears and I'm addicted to podcasts. 
			</h4>

			<h4>
				I'm currently an M.Sc. student at the <a href="https://www.maths.ox.ac.uk/">Mathematical Institute</a> at <a href="http://www.ox.ac.uk/">Oxford</a>. I spend most of my time here proselytizing the Oxford comma. 
			</h4>

			<h4>
				Previously, I spent some time at <a href="http://www.riken.jp/en/research/labs/aip/">RIKEN AIP</a> in Tokyo, where I was  lucky to work with <a href="http://www.prefield.com/index.html">Dr. Maehara</a> as part of the <a href="http://www.riken.jp/en/research/labs/aip/generic_tech/discr_optimize/">Discrete Optimization Unit</a>. Here I spent most of my time confused about submodular stochastic optimization problems. Prior to that, I spent several wonderful years at the  
			 	<a href="https://www.ubc.ca/">University of British Columbia</a> studying mathematics and computer science. While there, my time spent on research was split between being confused about <a href="https://en.wikipedia.org/wiki/Chemical_reaction_network_theory">Stochastic Chemical Reaction Networks</a> and <a href="https://en.wikipedia.org/wiki/Graph_theory">graph theory</a>. I was immensely fortunate to be supervised by <a href="http://www.cs.ubc.ca/~will/">Will Evans</a> and  <a href="https://www.cs.ubc.ca/~condon/">Anne Condon</a>, who both abated my confusion on many occasions. I wrote my undergraduate thesis on computing in dynamic environments under uncertainty. 
			 </h4>

			<!-- <h4>More broadly, I'm interested in cross-disciplinary applications of computer science to health care, genomics and the non-profit sector. I'm the founder of <a href="https://codethechangeubc.org">Code the Change UBC</a>, an organization of students providing free software for non-profits who cannot afford it otherwise. We are a derivative of <a href="https://codethechange.org">Code the Change</a> at Stanford. I'm also the co-founder of the <a href="http://graceorphancare.org/">Friends of Grace Orphan Care Society</a>, a non-profit helping a small, locally run Malawian Orphan Care achieve financial sustainability. </h4> -->
		</div>

		<div class='col-sm-6 col-sm-offset-3 papers'>
			<h3>Papers</h3>
			<h4>
				<ul>
					<li>
						Adversarial Submodular Stochastic Probing with Prices. (In progress.) <br>
						With <a href="http://www.prefield.com/index.html">Takanori Maehara</a>.
					</li>
					<li>
						Output-Oblivious Chemical Reaction Networks. <br>
						With <a href="https://www.cs.ubc.ca/~condon/">Anne Condon</a> and Hooman Hashemi. <br>
						Poster in the International Conference on DNA Computing and Molecular Programming, DNA 24. 
					</li>
					<li>
						Simultaneous Visibility Representations of Undirected Graphs. (In progress.)<br>
						With <a href="http://www.cs.ubc.ca/~will/">Will Evans</a> and Kelvin Wong. 
					</li>
				</ul>
			</h4>
			
		</div>

		<div class='col-sm-6 col-sm-offset-3 theses'>
			<h3>Theses</h3>
			<h4>
				<ul>
					<li>A Model for Computing in Dynamic, Resource Limited Environments. <a href="files/thesis.pdf">[pdf]</a><br>
					B.Sc. Thesis. 
					</li>
				</ul>
			</h4>
		</div>

		<div class='col-sm-6 col-sm-offset-3 teaching'>
			<h3>Some teaching</h3>
			<h4>At UBC, I've been a teaching assistant for CPSC 221: Basic algorithms and data structures, CPSC 320: Intermediate Algorithm Design and Analysis, and CPSC 420: Advanced algorithm design and analysis.</h4>
			<h4>Random course materials:  
				<ul>
					<li>221: <a href="./files/function_runtime.pdf">Introductory notes on analyzing function runtimes</a></li>
					<li>420 Practice Problems: <a href="./files/linprog.pdf">Linear Programming</a>,
						<a href="./files/npcomplete.pdf">NP-Completeness</a>,
						<a href="./files/flow.pdf">Network Flow</a>.
					</li>
				</ul></h4>
		</div>
		<div class='col-sm-6 col-sm-offset-3 links'>
			<h3>Personal procrastination catalysts</h3>

			<h4>
				Here is a list of 
				<ul>
					<li><a href="podcasts.php">podcasts</a> I find enjoyable;</li>
					<li><a href="books.php">books and essays</a> which have something interesting to say;</li>
					<li>free, online <a href="lectures.php">courses and lectures</a> that have taught me something worthwile.</li>
				</ul>
			</h4>

			<h4>Here is a flood of miscellany to help ensure that you are less productive over the next few minutes than you would be otherwise: 
				<a href="https://xkcd.com/287/">https://xkcd.com/287/</a>, 
				<a href="https://xkcd.com/399/">https://xkcd.com/399/</a>,
				<a href="https://www.youtube.com/watch?v=OV5J6BfToSw">Steven Pinker on Linguistics and Style</a>. 
			</h4>

			<h4>Sometimes I try and do this when I'm alone: <a href=" https://www.youtube.com/watch?v=5ueJ4-lTa1s
			"> https://www.youtube.com/watch?v=5ueJ4-lTa1s</a>. It doesn't go as well.</h4>
		</div>


		<div class='col-sm-6 col-sm-offset-3 footnotes'>
		</div>
	</div>

	

</body>
</html>
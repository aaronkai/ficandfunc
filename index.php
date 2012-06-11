<!DOCTYPE html>

<html lang="en-US" xml:lang="en-US" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="author" content="Aaron Hubbard"/>
	<title>Aaron Hubbard Design and Development</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	
	<!-- 1140px Grid styles for IE -->
	<!--[if lte IE 9]><link rel="stylesheet" href="css/ie.css" type="text/css" media="screen" /><![endif]-->

	<!-- The 1140px Grid - http://cssgrid.net/ -->
	<link rel="stylesheet" href="css/1140.css" type="text/css" media="screen" />
	
	<!-- Your styles -->
	<link href="css/styles.css" rel="stylesheet" type="text/css" media="screen" />
	
	<!--css3-mediaqueries-js - http://code.google.com/p/css3-mediaqueries-js/ - Enables media queries in some unsupported browsers-->
	<script type="text/javascript" src="js/css3-mediaqueries.js"></script>
	
	<link rel="icon" href="img/favicon.gif" type="image/gif"/>
	<link rel="apple-touch-icon-precomposed" href="img/appletouchicon.png"/>
		
	<meta name="description" content="a portfolio for Aaron Hubbard, web designer and developer." />
	
	<meta name="keywords" content="Aaron Hubbard web design development Asheville Western North Carolina Buncombe" />

	<!--jQuery-->
		<link type="text/css" href="jquery/css/smoothness/jquery-ui-1.8.21.custom.css" rel="stylesheet" />
		<script type="text/javascript" src="jquery/js/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="jquery/js/jquery-ui-1.8.21.custom.min.js"></script>
		<script type="text/javascript">
			$(function(){
				// Accordion
				$("#accordion").accordion({ header: "h4", collapsible: true, active: false, autoHeight: false});
				});
		</script>
		
		<script>
			$(function() {
				// run the currently selected effect
				function runEffect() {
					// get effect type from 
					var selectedEffect = "drop";
					
					// most effect types need no options passed by default
					var options = {};
					
					// run the effect
					$( "#effect" ).toggle( selectedEffect, options, 500 );
				};
				
				// set effect from select menu value
				$( "#button" ).click(function() {
					runEffect();
					return false;
				});
			});
		</script>

	<!--end jQuery-->

	<!--google fonts-->
<link href='http://fonts.googleapis.com/css?family=Droid+Sans+Mono' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Lato:300,700' rel='stylesheet' type='text/css'>
	<!--end google fonts-->
	
</head>

<body>
	<div class="container">
		<div class="row">
			<div class="fourcol">
				<header>
					<h1>Aaron Kai Hubbard</h1>
					<h2> Available for Hire </h2>
					<h3>828.779.0920</h3>
					<h3>aaron.kai.hubbard&#64;
						<br />gmail.com
					</h3>
				</header>

				<nav>
					<ul>
						<li><a href="resume.pdf">Resume (.pdf)</a></li>
						<li><a href="#" id="button">Recent Work </a><li>
					</ul>
				</nav>
			</div><!--close fourcol-->
				
			
			<div class="sevencol last">
				
				
				<article>
					<p>Aaron Hubbard is a freelance web developer based in Asheville, North Carolina. His work focuses on clean, simple and effective design; responsive, mobile-friendly websites; and dynamic, data driven applications.</p>
				</article>
				
				
				<div class="toggler">
					<div id="effect" class="ui-widget-content ui-corner-all">
						<div id="accordion">
							
							<div>
								<h4><a href="#">The Bespoken</a></h4>
								<div>
									<p>A dynamicly generated social catalog. Essentially a hand-coded CMS written from scratch in PHP with a MySQL backend.</p>
									<p><a href='http://www.thebespoken.com' class="orange button">Check it out.</a></p>
								</div>
							</div>
							
							<div>
								<h4><a href="#">The Birds Database</a></h4>
								<div>
									<p>This website makes use of a MySQL backend to dynamicly display data about birds. It includes a safe email form, user registration, and fields that users can update.</p>
									<p><a href="http://www.fictionandfunction.com/PHP_MySQL_Demo" class="orange button">A database driven site</a></p>
								</div>
							</div>

							<div>
								<h4><a href="#">Greenpoint Builders</a></h4>
								<div>
									<p>A site that displays some more complex work with CSS</p>
									<p><a href="http://www.fictionandfunction.com/CSS_Demo" class="orange button">Greenpoint Builders</a><p>
								</div>
							</div>							
							
							<div>
								<h4><a href="#">Greenpoint WordPress Site</a></h4>
								<div>
									<p>The same site as above, but with done in WordPress using a hand-coded theme</p>
									<p><a href="http://www.fictionandfunction.com/firstTheme/wordpress" class="orange button">Simple WordPress Blog</a></p>
								</div>
							</div>
							
							<div>
								<h4><a href="#">Asheville Go Club</a></h4>
								<div>
									<p>A simple site coded in HTML and CSS for the Asheville Go Club</p>
									<p><a href="http://www.fictionandfunction.com/Asheville_Go_Club" class="orange button">Asheville Go Club</a></p>
								</div>
							</div>
							
							<div>
								<h4><a href="#">The Inca Trail</a></h4>
								<div>
									<p>A WordPress site that modifies the default template.</p>
									<p><a href="http://www.fictionandfunction.com/WordPress_Theme1/Sandbox2" class="orange button">The Inca Trail</a></p>
								</div>
							</div>
							
						</div><!--end accordion-->
					</div><!--close effect-->
				</div><!--close toggler-->
				
				<footer>
					<p>v.3.3	2012	&copy;	Aaron Hubbard</p>
				</footer>
			</div><!--close sevencol-->
		</div><!--close row-->

	</div><!--close container-->
  
	
</body>	
</html> 

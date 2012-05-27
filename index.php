<?php //turn on output bufering
ob_start()
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html lang="en-US" xml:lang="en-US" xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="author" content="Aaron Hubbard"/>
	<meta name="date" content="2011-03-06T23:27:18-0500"/>
	<title>Fiction and Function</title>
	<link href="Styles/blackTheme.css" rel="stylesheet" type="text/css" />

	<!--jQuery-->
		<link type="text/css" href="jquery/css/smoothness/jquery-ui-1.8.20.custom.css" rel="stylesheet" />
		<script type="text/javascript" src="jquery/js/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="jquery/js/jquery-ui-1.8.20.custom.min.js"></script>
	<!--end jQuery-->

	<!--google fonts-->
		<link href='http://fonts.googleapis.com/css?family=Oleo+Script' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Gudea' rel='stylesheet' type='text/css'>
	<!--end google fonts-->
</head>

<body>
<div id="wrapper">

<header class="main">
	<h1><a href="../index.php">Pick your poison</a></h1>
</header>
	
<header class="sub">
	<hgroup>
		<img id="squiggle" src="./Images/squiggle.png" />
		<h2>Projects</h2>
		<img id="squiggle" src="./Images/squiggle.png" />
	</hgroup>

	
<aside id="skull"></aside>
<article>
<script type="text/javascript">
			$(function(){
				// Accordion
				$("#accordion").accordion({ header: "h3", collapsible: true, active: false, autoHeight: false});
			});
</script>

<div id="accordion">
	
	<div>
		<h3><a href="#">The Bespoken</a></h3>
		<div>
			<p>A dynamicly generated social catalog. Essentially a hand-coded CMS written from scratch in PHP with a MySQL backend.</p>
			<p><a href='http://www.thebespoken.com' class="orange button">Check it out.</a></p>
		</div>
	</div>
	
	<div>
		<h3><a href="#">The Birds Database</a></h3>
		<div>
			<p>This website makes use of a MySQL backend to dynamicly display data about birds. It includes a safe email form, user registration, and fields that users can update.</p>
			<p><a href="http://www.fictionandfunction.com/PHP_MySQL_Demo" class="orange button">A database driven site</a></p>
		</div>
	</div>

	<div>
		<h3><a href="#">Greenpoint Builders</a></h3>
		<div>
			<p>A site that displays some more complex work with CSS</p>
			<p><a href="http://www.fictionandfunction.com/CSS_Demo" class="orange button">Greenpoint Builders</a><p>
		</div>
	</div>
	
	<div>
		<h3><a href="#">Greenpoint WordPress Site</a></h3>
		<div>
			<p>The same site as above, but with done in WordPress using a hand-coded theme</p>
			<p><a href="http://www.fictionandfunction.com/firstTheme/wordpress" class="orange button">Simple WordPress Blog</a></p>
		</div>
	</div>
	
	<div>
		<h3><a href="#">Asheville Go Club</a></h3>
		<div>
			<p>A simple site coded in HTML and CSS for the Asheville Go Club</p>
			<p><a href="http://www.fictionandfunction.com/Asheville_Go_Club" class="orange button">Asheville Go Club</a></p>
		</div>
	</div>
	
	
	<div>
		<h3><a href="#">The Inca Trail</a></h3>
		<div>
			<p>A WordPress site that modifies the default template.</p>
			<p><a href="http://www.fictionandfunction.com/WordPress_Theme1/Sandbox2" class="orange button">The Inca Trail</a></p>
		</div>
	</div>
</div><!--end accordion-->
</article>
<div id="footer">
<p>Copyright &copy; 2011 Aaron Hubbard</p>
</div><!--end footer-->
</div><!--from wrapper from header.inc.php-->
</body>

</html> 

<?php //send the buffer to the browser and turn off buffering
ob_end_flush()
?>

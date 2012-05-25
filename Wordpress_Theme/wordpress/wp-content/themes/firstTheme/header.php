<!DOCTYPE HTML> 
<html <?php language_attributes(); ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset="<?php bloginfo( 'charset' ); ?>" />
	<title>
	<?php
		//The title
		wp_title(  '|', true, 'right');
		//Add the blog name.
		bloginfo('name');
	?>	
	</title>
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link type="text/css" media="all" rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url'); ?>" />
	<!--Fix for IE < v.9
		by Remy Sharp http:/remysharp.com/2009/01/07/html5-enabling-script/ -->
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<?php
		wp_head();
	?>
</head>

<body <?php body_class(); ?>>

    <div id="outer-wrapper">
		<div id="inner-wrapper">
		
					<div id="header">
						<h1 id="site-title">
							<a href="<?php echo home_url(); ?>" title="<?php bloginfo('name'); ?>">
								<?php bloginfo( 'name' ); ?>
							</a>
						</h1>
						
						<ul id="banner-list">
							<li>Greenbeam Renewable Electric Co, LLC</li>
							<li>Boulder, CO (800) 555-1212</li>
							<li>State Contractor License 1234</li>
						</ul>
					</div>
				
			
			<div id="content-container">	
				<div id="content-container-inner">
				<nav id="top-navbar">
					<?php 
					//top navigation menu
					wp_nav_menu( array( 'theme_location' => 'top-navigation'))	; 
					?>
				</nav>
			

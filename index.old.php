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
		<script type="text/javascript" src="jquery/js/jquery-ui-1.8.21.custom.min.js"></script>
	<style>
		.toggler { width: 500px; height: 200px; position: relative; }
		#button { padding: .5em 1em; text-decoration: none; }
		#effect { width: 240px; height: 135px; padding: 0.4em; position: relative; }
		#effect h3 { margin: 0; padding: 0.4em; text-align: center; }
		.ui-effects-transfer { border: 2px dotted gray; } 
	</style>
	<script>
	$(function() {
		// run the currently selected effect
		function runEffect() {
			// get effect type from 
			var selectedEffect = $( "#effectTypes" ).val();
			
			// most effect types need no options passed by default
			var options = {};
			// some effects have required parameters
			if ( selectedEffect === "scale" ) {
				options = { percent: 0 };
			} else if ( selectedEffect === "transfer" ) {
				options = { to: "#button", className: "ui-effects-transfer" };
			} else if ( selectedEffect === "size" ) {
				options = { to: { width: 200, height: 60 } };
			}

			// run the effect
			$( "#effect" ).effect( selectedEffect, options, 500, callback );
		};

		// callback function to bring a hidden box back
		function callback() {
			setTimeout(function() {
				$( "#effect" ).removeAttr( "style" ).hide().fadeIn();
			}, 1000 );
		};

		// set effect from select menu value
		$( "#button" ).click(function() {
			runEffect();
			return false;
		});
	});
	</script>



<div class="demo">

<div class="toggler">
	<div id="effect" class="ui-widget-content ui-corner-all">
		<h3 class="ui-widget-header ui-corner-all">Effect</h3>
		<p>
			Etiam libero neque, luctus a, eleifend nec, semper at, lorem. Sed pede. Nulla lorem metus, adipiscing ut, luctus sed, hendrerit vitae, mi.
		</p>
	</div>
</div>

<select name="effects" id="effectTypes">
	<option value="blind">Blind</option>
	<option value="bounce">Bounce</option>
	<option value="clip">Clip</option>
	<option value="drop">Drop</option>
	<option value="explode">Explode</option>
	<option value="fade">Fade</option>
	<option value="fold">Fold</option>
	<option value="highlight">Highlight</option>
	<option value="puff">Puff</option>
	<option value="pulsate">Pulsate</option>
	<option value="scale">Scale</option>
	<option value="shake">Shake</option>
	<option value="size">Size</option>
	<option value="slide">Slide</option>
	<option value="transfer">Transfer</option>
</select>

<a href="#" id="button" class="ui-state-default ui-corner-all">Run Effect</a>

</div><!-- End demo -->



<div class="demo-description" style="display: none; ">
<p>Click the button above to show the effect.</p>
</div><!-- End demo-description -->

</body>
</html>

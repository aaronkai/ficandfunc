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
<script type="text/javascript">
			$(function(){

				// Accordion
				$("#accordion").accordion({ header: "h3", collapsible: true, active: false, autoHeight: false});

			});
</script>
<!--end jQuery-->


<!--google fonts-->
<link href='http://fonts.googleapis.com/css?family=Oleo+Script' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Gudea' rel='stylesheet' type='text/css'>

<!--end google fonts-->

</head>

<body>
<div id="wrapper">
<div id="banner">
<!--insert <h1> tag between header.inc.php and index.inc.php-->

<!--insert <h1> tag between header.inc.php and index.inc.php-->
</div><!--end banner from header.inc.php-->
<div id="column1"></div>
<div id="mod">
<?php
$dir=opendir(".");
$files=array();
while (($file=readdir($dir)) !== false)
{
if ($file!="BirdImages" &&
	$file!=".git" &&
	$file != "." &&
	$file != ".." &&
	$file != ".gitignore" &&
	$file != "index.php" &&
	$file!= "Styles" and $file!="Includes" && 
	$file!="Images" &&
	$file!="Sandbox2" &&
	$file!="Wordpress_Theme")
{
array_push($files, $file);
}
}
closedir($dir);
sort($files);
print '<ul>';
foreach ($files as $file) {
print '<li style="list-style-type: none"><a href="' . $file . '">' . $file . '</a></li>';
}
echo "<a href='http://www.thebespoken.com'>The Bespoken</a>";
print '</ul>';
?>
</div><!--end mod-->


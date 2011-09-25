<!--
File: myFunctions.inc.php
Author: Aaron Hubbard
Date: 8/21/2011
Description: Chapter 1 assignment--functions
-->

<?php
	function getBirds() {
		if (($file_handle=fopen("birds.txt","r") == "false"))
			return (echo "<p>There was a problem locatin the file. Please notify your system administrator.</p>");
		else
			{
			while(!feof($file_handle)){
				$data=fgets($file_handle);
				$birds[]=$data;
				}
			fclose($file_handle);	
			return $birds;
			}
		
		
			
		

>?

<?php
/*
File: myFunctions.inc.php
Author: Aaron Hubbard
Date: 8/21/2011
Description: Chapter 1 assignment--functions
*/

	function getBirds() {
		$file_handle=fopen("birdsForDropDown.txt","r");
			if ($file_handle==FALSE){
				$birds="There was a problem locating the file. Please contact your system admin.";
				return $birds;
				}
			else{
			while(!feof($file_handle)){
				$data=fgets($file_handle);
				$birds[]=$data;
				}
			fclose($file_handle);	
			return $birds;
			}
	}
?>

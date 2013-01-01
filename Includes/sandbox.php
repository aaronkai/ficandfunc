<?php
function getBirds() {
		$file_handle=fopen("birdsForDropDown.txt","r");
	
			while(!feof($file_handle)){
				$data=fgets($file_handle);
				$birds[]=$data;
			}
			fclose($file_handle);	
			echo $birds
	}
?>

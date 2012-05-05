<?php

echo "<div id='table'>";

//display arrows based on value of $dir
//if ($dir=='DESC')
//	echo '<img src="Images/downArrow.png" alt="a down arrow" class="arrow" />';
//if ($dir=='ASC')
//	echo '<img src="Images/upArrow.png" alt="a up arrow" class="arrow" />';

//table headings and create variables: sort, s, and p, and dir. Also toggle sort order
echo"<table><tr>
		<th></th>
		<th><a href='birdsPagination.php?sort=generalName&amp;dir=".(($sort != 'generalName')? 'ASC' : (($dir=='ASC')? 'DESC' : 'ASC'))."'>General Name</a></th>
		<th><a href='birdsPagination.php?sort=specificName&amp;dir=".(($sort != 'specificName')? 'ASC' : (($dir=='ASC')? 'DESC' : 'ASC'))."'>Specific Name</a></th>
		<th><a href='birdsPagination.php?sort=populationTrend&amp;dir=".(($sort != 'populationTrend')? 'ASC' : (($dir=='ASC')? 'DESC' : 'ASC'))."'>Population Trend</a></th>
		<th><a href='birdsPagination.php?sort=notes&amp;dir=".(($sort != 'notes')? 'ASC' : (($dir=='ASC')? 'DESC' : 'ASC'))."'>Notes</a></th>
		<th>Upload a Photo</th>
		<th>View Bird Photos</th></tr>";
	
//fetch and print records;
$bg='#dddddd'; //set initial background color
while ($row=mysqli_fetch_array($r, MYSQLI_ASSOC))
{
	$bg = ($bg == '#dddddd' ? '#ffffff' : '#dddddd'); //switch color;
	echo '<tr bgcolor="'.$bg.'">	<td> 	<a href="editBird.php?id='.$row['birdID'].'  
							&amp;gName='.$row['nameGeneral'].'
							&amp;sName='.$row['nameSpecific'].'
							&amp;popTrend='.$row['populationTrend'].'
							&amp;notes='.$row['notes'].'
							&amp;genus='.$row['genus'].'
							&amp;species='.$row['species'].'
							&amp;family='.$row['family'].'">Edit</a>
							
						<a href="deleteBird.php?id='.$row['birdID'].'
							&amp;gName='.$row['nameGeneral'].'
							&amp;sName='.$row['nameSpecific'].'
							&amp;popTrend='.$row['populationTrend'].'
							&amp;notes='.$row['notes'].'">Delete</a></td>
					<td>'.$row['nameGeneral'].'</td>
					<td>'.$row['nameSpecific'].'</td>
					<td>'.$row['populationTrend'].'</td>
					<td>'.$row['notes'].'</td>
					<td><a href="fileUpload.php?id='.$row['birdID'].'">Upload a Photo</a></td>
					<td>'.lightbox($dbc, $row['birdID']).'</td></tr>';
}

echo '</table>';
echo '</div>'; //end table
mysqli_free_result($r);
mysqli_close($dbc);
?>

<?php
/*-------------------------------------------
FILE PURPOSE

This file is for displaying videos on the index page of the portfolio that have an index_vid row value of 1 (true). I have an include in the root directory index file in order to include this code. I elected to remove this from that index file in order to make room for additional content at a later point in time.

/*------------------------------------------*/

// database connection file
include("blog/connect.php");

// query to get all neccessary information on  videos that have had their index display set to 1 (TRUE)
$sql= "SELECT description, filename, fileextension FROM video WHERE index_vid = 1";
$result = $dbcon->query($sql);

while($row = $result->fetch_assoc()) {
	$fileextensionvalue= $row['fileextension'];
	$videos_field= $row['filename'];
	$video_show= "videos/$videos_field";
	$descriptionvalue= $row['description'];

	echo "<video width='100%' controls><source src='".$video_show."' type='video/$fileextensionvalue'>Your browser does not support the video tag.</video>";

}  

?> 

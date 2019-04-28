<?php
/*-------------------------------------------
FILE PURPOSE

This file is included in the video.php file.
If the user clicks on the "PORTRAIT" tab while on video.php, then this file will be displayed on the page.
This particular tab will display all of the videos that have been entered in to the database with the category of "Portrait"

The 'display_hide' field in the datbase is a boolean. If the display_hide row is set to '1' instead of zero for a specific video row, then that video will not be displayed when the user is viewing this tab or the tab for the category that the video belongs to.

The $descriptionvalue variable AKA the 'description' row for each video corresponds to a summary that has been submitted to give a brief descripton of the video. 
When the user clicks on the 'View Additional Project Information' url they are taken to the 'video_details.php' page, which will display a full list of details on the video project, such as more detailed description of the video.
The more  detailed description of each video is being stored in the 'vid_details' table, while all of the brief overview information of the video is being stored in the 'video' table that's being used in this file.

The nl2br() function is used on the video description (the summary) in order to make the data  display with line breaks.

DATA QUERIED FOR THIS FILE:

id = unique id / primary key ... datatype int(11)
description = a summary of the video  .... datatype text
filename = the file name with the extension ... datatype varchar(50)
fileextension = the stand alone file extension, such as 'mp4' ... datatype varchar(4)
display_hide = sets if the video is hidden from public display ... datatype tinyint(1) ... AKA a boolean value

DATA UNREQUIRED FOR THIS FILE:
index_id = sets if the video displays on the index page of the portfolio or not ... tinyint(1) ... AKA a boolean value
submit_date = the date that the video was submitted to the database ... datatype date
category = the category to which each video belongs ... datatype varchar(255)

/*------------------------------------------*/

include("blog/connect.php");

// Select statement to get all of the data on every portrait video in the database that does not have a a boolean flag for display_hide set to 1
$sql= "SELECT id, description, filename, fileextension, display_hide FROM video WHERE category = 'Portrait' AND display_hide = 0 ORDER BY id";
$result = $dbcon->query($sql);

// store all data on each video in variables that are easier to use
// display the video itself, its summary description and a link to video_details.php, which will display information from the 'vid_details' table
while($row = $result->fetch_assoc()) {
	
	$id = $row['id']; // the unique id / primary key for the portrait video
	$fileextensionvalue= $row['fileextension']; // the stand alone extension for the video .... example: 'mp4'
	$videos_field= $row['filename']; // the name of the file with the extension
	$video_show= "videos/$videos_field"; // the full path for the video's location relative to the root directory of the portfolio
	$descriptionvalue= $row['description']; // summary of the video

	// display the video content at 100% the width of the parent element
	echo "<video width='100%' controls><source src='".$video_show."' type='video/$fileextensionvalue'>Your browser does not support the video tag.</video>";
	?>

	<div class="video_additionalInfo_link">
		<?php echo '<a href ="video_details?id='.$id.'">View Additional Project Information</a>'; ?>
	</div>

	<?php

	// display the summary of the video, found in the 'video' table as the 'description' row
	echo "<br/>". nl2br($descriptionvalue) . "<br/><br/>";

} 
 

?> 

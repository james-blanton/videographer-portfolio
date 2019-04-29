<?php
FUNCTION display_photoset($type) {

/*-------------------------------------------
FILE PURPOSE

This file is included at the top of the display_$type.php file above all of the photographs that don't belong to a photoset.
<div class='column'> needs to be displayed inside the loop. If this div is displayed outside the loop when there's no images inside it, 
then it will mess up the spacing of all the images on the page.

/*------------------------------------------*/

include("blog/connect.php");

// Select statement to get all of the data on every photo set in the database that does not have a a boolean flag for display_hide set to 1. Photographs that belong to a photo set will not be individually displayed in the "$type" tab.
$sql= "SELECT id, title, cover_photo, display_hide FROM photo_sets WHERE category = '$type' AND display_hide = 0 ORDER BY id";
$result = $dbcon->query($sql);
$num_rows = mysqli_num_rows($result);

?>
<div class='column'>
<?php
if ($num_rows > 0){
	// store all data on each photo set in variables that are easier to use
	while($row = $result->fetch_assoc()) {
	$id_photoset = $row['id']; // the unique id / primary key for the photo set
	$title_photoset = $row['title']; // the title for the photo set
	$cover_photo = $row['cover_photo']; // the file name for the cover photo of the photo set

	// only display a photoset that has photographs assigned to it
	$counting = "SELECT id FROM photo WHERE photoset_ID ='$id_photoset'";
	$results = $dbcon->query($counting);
	$num_rows_return = mysqli_num_rows($results);
?>
	
	<a href="view_photoset?id=<?php echo $id_photoset ?>">
		<div class="img_container">
			<img src="photo/<?php echo $cover_photo; ?>" alt="<?php echo $cover_photo ?>" class="img_resize"></img>
			<div class="photoset_links" class="img_link"><?php echo $title_photoset; echo ' ('.$num_rows_return.')';?></div>
		</div>
	</a>
	

<?php
		
	}
	
}
?>

</div>

<?php
}

?>


<?php
FUNCTION display_photographs($type) {
	/*-------------------------------------------
	FILE PURPOSE
	

	This file is included in the photography.php file.
	If the user clicks on the "$type" tab while on photography.php, then this file will be displayed on the page.
	This particular tab will display all of the photographs that have been entered in to the database with the category of "$type"
	$type photo sets are displays before all photographs that do not belong to a set through the use of the display_$type_photosets.php file.

	The 'display_hide' field in the datbase is a boolean. If the display_hide row is set to '1' instead of zero for a specific photo row, then that photograph will not be displayed when the user is viewing this tab on the photography.php page

	DATA QUERIED FOR THIS FILE:

	id = unique id / primary key ... datatype int(255)
	title = the title of the photograph  .... datatype varchar(255)
	category = the category to which each photographh belongs ... datatype varchar(255)
	filedate = the date that the photograph was submitted to the database ... datatype date
	name = the file name with the extension ... datatype varchar(255)
	display_hide = sets if the video is hidden from public display  tinyint(1) ... AKA a boolean value

	/*------------------------------------------*/

	include("blog/connect.php");

	?>

	<div class="flex">

	<?php display_photoset($type); ?>

	<?php
	// Select statement to get all of the data on every $type photograph in the database that does not have a a boolean flag for display_hide set to 1. Photographs that belong to a photo set will not be individually displayed in the "$type" tab with the exception of the 'cover photo', which will link to the other photographs belong to that set.
	$sql= "SELECT id, title, name, filedate, display_hide, photoset_ID FROM photo WHERE category = '$type' AND display_hide = 0 AND photoset_ID IS NULL ORDER BY id";
	$result = $dbcon->query($sql);

	// store all data on each $type photograph in variables that are easier to use
	while($row = $result->fetch_assoc()) {
	$id = $row['id']; // the unique id / primary key for the $type photograph
	$title= $row['title']; // the title for each $type photograph
	$filename= $row['name']; // the file name for each $type photograph including the file extension

	?>

	<div class='column'>
	<a href="photo/<?php echo $filename; ?>" target="_new">
	<img src="photo/<?php echo $filename; ?>" alt="<?php echo $filename; ?>" width='100%' style='float:left'>
	</a>
	</div>

	<?php
	}
	?>
	</div>
<?php
}

?>


<?php
FUNCTION display_video($type) {

/*-------------------------------------------
FILE PURPOSE

This file is included in the video.php file.
If the user clicks on the "$type" tab while on video.php, then this file will be displayed on the page.
This particular tab will display all of the videos that have been entered in to the database with the category of "$type"

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

// Select statement to get all of the data on every $type video in the database that does not have a a boolean flag for display_hide set to 1
$sql= "SELECT id, description, filename, fileextension, display_hide FROM video WHERE category = '$type' AND display_hide = 0 ORDER BY id";
$result = $dbcon->query($sql);

// store all data on each video in variables that are easier to use
// display the video itself, its summary description and a link to video_details.php, which will display information from the 'vid_details' table
while($row = $result->fetch_assoc()) {
	
	$id = $row['id']; // the unique id / primary key for the $type video
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
 
}
?>
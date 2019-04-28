<?php
/*-------------------------------------------
FILE PURPOSE

This file uploads a new video file in to the 'videos' directory and creates an entry in the 'video' database table.
The file consists of the html forms that send data to video_read.php for processing.

The fields displayed to the use include the following:
- title 
- summary (description)
- category
- index display

The index display field sets whether the video will be displayed on the index page for the portfolio or not.

Currently, this form will attempt to process a video of any size. However, my php.ini file will prevent any file larger than 1GB from being uploaded to the hosting platform. The javascript at the bottom of the file will warn the use if they have selected a file for upload that is larger than the allocated 1 GBs of space.

/*------------------------------------------*/

include("../header.php");

// database connection file
include("connect.php");

// Function to ensure that the user is logged in as an admin. This function can be found in header.php.
loginCheck();
		
?>

<?php 
// This file processes the form
include('video_read.php'); 
// Everything below this php file is the form for processing a new video submission.
?>

<div class="w3-container w3-light-grey"><h2>Video Upload</h2></div>
<div class="w3-container">

<a href="admin.php"> << return to Admin Dashboard</a><br/>

<div id="user_messages">
<?php 
// error messages are set in video_read.php
// javascript will alert the user to whether the file is too large or not in this div area as soon as they select the file with the file input portion of the form
echo $user_messages;
?>
</div>

<br/>
<form action="" method='post' enctype="multipart/form-data">


<label class="custom-file-upload">
    <input id="video_input" type="file" name="file" required>
    <i class="fa fa-upload"></i> Upload
</label>
<br><br>

<label>Title</label><br/>
<input type="text" class="w3-input w3-border" name="title_entered" required>
<br>

<label>Description</label>
<textarea row="30" cols="50" class="w3-input w3-border large_textbox" name="description_entered" /></textarea>
<br>

<label>Video Category</label><br/>
<select id="video_category" name="category" >
	<option id="category" name="category" value="Motion Graphics">Motion Graphics</option>
	<option id="category" name="category" value="Portrait">Portrait</option>
	<option id="category" name="category" value="Landscape">Landscape</option>
	<option id="category" name="category" value="Commercial">Commercial</option>
	<option id="category" name="category" value="Travel">Travel</option>
	<option id="category" name="category" value="Weddings">Weddings</option>
	<option id="category" name="category" value="Editorial">Editorial</option>
</select>
<br><br>

<label>Index Display</label><br/>
<select id="index" name="index" >
	<option id="index" name="index" value="1">Yes</option>
	<option id="index" name="index" value="0">No</option>
</select>
<br><br>

<label>Display Hidden</label><br/>
<select id="display" name="display" >
	<option id="display" name="display" value="1">Yes</option>
	<option id="display" name="display" value="0">No</option>
</select>
<br><br>
	
<input type="submit" name="submit" class="w3-btn w3-light-grey w3-round" value="Submit"/>

<script type="text/javascript">
// This will warn the use if the file they're attempting to upload is above ~1 MB
var uploadField = document.getElementById("photo_input");

// 4.60 MB file limit size (4,827,360 bytes)
uploadField.onchange = function() {
    if(this.files[0].size > 4827360){
		document.getElementById("user_messages").innerHTML = "<br/>File too big!";
		this.value = "";
    }else{
		document.getElementById("user_messages").innerHTML = "<br/>File size is acceptable!";
    };
};
</script>

</form>
</div>
</div>
<?php
	
include("footer.php");
?>
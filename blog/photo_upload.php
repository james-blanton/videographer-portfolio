<?php
/*-------------------------------------------
FILE PURPOSE

This file uploads a new photographic file in to the 'photo' directory and creates an entry in the 'photo' database table.
Currently, when a new photo is uploaded and added to a photo set the new photograph will take over as the new cover photo for a photo set.
The file consists of the html forms that send data to photo_read.php for processing.

The fields displayed include:
- title 
- category
- photo set


Currently, this form will attempt to process a photo of any size. However, my php.ini file will prevent any file larger than 1GB from being uploaded to the hosting platform. The javascript at the bottom of the file will warn the use if they have selected a file for upload that is larger than 4.60 MB (4,827,360 bytes)

/*------------------------------------------*/

include("../header.php");

// database connection file
Include("connect.php");

// if the user is not logged in, then redirect the user away to the login page before executing any more of this file
if(!isset($_SESSION['username'])) {
	Redirect('login', false);
	exit();
}
		
?>

<?php
// processes any photos that are uploaded 
include('photo_read.php'); 
?>

<div class="w3-container w3-light-grey"><h2>Photo Upload</h2></div>
<div class="w3-container">

<a href="admin"> << return to Admin Dashboard</a><br/>

<div id="user_messages">
<?php 
// error messages are set in video_read.php
// javascript will alert the user to whether the file is too large or not in this div area as soon as they select the file with the file input portion of the form
echo $user_messages;
?>
</div>

<br/>
<form action="" method='post' enctype="multipart/form-data">

Max file size is exactly 4.60 MB (4,827,360 bytes) <br/><br/>
<label class="custom-file-upload">
    <input id="photo_input" type="file" name="file" />
    <i class="fa fa-upload"></i> Upload
</label>
<br><br>

<label>Title</label><br/>
<input type="text" class="w3-input w3-border" name="title" >

<br><br>
<label>Category</label><br/>
<?php
// pull all of the categories specifically for photos
// create a dropdown menu using a loop
$sql = "SELECT * FROM category_photo";
$result = mysqli_query($dbcon, $sql);

if(mysqli_query($dbcon, $sql)) {
	$select= '<select id="category" name="category">';
	while($row=mysqli_fetch_array($result)){
	      $select.='<option name="category" value="'.$row['catname'].'">'.$row['catname'].'</option>';
	  }
}
$select.='</select>';
echo $select;
?>

<br><br>
<label>Photo Set</label><br/>
<?php
// pull a list of all available photo sets / collections

// query statement and execution of query
$sql_photosets = "SELECT id, title FROM photo_sets";
$result_sets = mysqli_query($dbcon, $sql_photosets);
// count the number of rows returned
$numrows = mysqli_num_rows($result_sets);

// display a dropdown of available photo sets if any exist in the database
// echo a message to the user if no photo sets are returned
if ($numrows != 0){
	if(mysqli_query($dbcon, $sql_photosets)) {
		$select= '<select id="photoset" name="photoset">';
		$select.='<option name="photoset" value="NULL">NULL</option>';
		while($row=mysqli_fetch_array($result_sets)){
		      $select.='<option name="photoset" value="'.$row['id'].'">'.$row['title'].'</option>';
		  }
	}
	$select.='</select>';
	echo $select;
} else echo 'No photo sets currently exist.'
?>
<br><br>

<label>Display Hidden</label><br/>
<select id="display" name="display" >
	<option id="display" name="display" value="1">Yes</option>
	<option id="display" name="display" value="0">No</option>
</select>
<br><br>
	
<input type="submit"  class="w3-btn w3-light-grey w3-round" name="submit" value="Submit"/>

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
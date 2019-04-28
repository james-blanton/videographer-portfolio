<?php
/*-------------------------------------------
FILE PURPOSE

This file accepts input for creating a new photoset. The data gets processed by photoset_read.php
The cover image file will be uploaded and included in the 'photo' table just as any other photograph would.
However, the file name for the cover image file will also be stored  in the 'photo_sets' table.

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
// processes the cover photo for a photoset and any other data collected by the form
include('photoset_read.php'); 
?>

<div class="w3-container w3-light-grey"><h2>Create Photo Set</h2></div>
<div class="w3-container">

<a href="admin"> << return to Admin Dashboard</a><br/>

<div id="user_messages">
<?php 
// error messages are set in photo_read.php
// javascript will alert the user to whether the file is too large or not in this div area as soon as they select the file with the file input portion of the form
echo $user_messages;
?>
</div>

<br/>
<form action="" method='post' enctype="multipart/form-data">

Max file size for cover image is exactly 4.60 MB (4,827,360 bytes) <br/><br/>
<label>Photoset Cover Image</label><br/>
<label class="custom-file-upload">
    <input id="photo_input" type="file" name="file" />
    <i class="fa fa-upload"></i> Upload
</label>
<br><br>

<label>Photoset Cover Image Title</label><br/>
<input type="text" class="w3-input w3-border" name="title" >

<label>Photoset Title</label><br/>
<input type="text" class="w3-input w3-border" name="photoset_title" >

<br>
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
<label>Description</label>
<textarea row="30" cols="50" class="w3-input w3-border large_textbox" name="description" /></textarea>
<br>

<label>Display Hidden</label><br/>
<select id="display" name="display" >
	<option id="display" name="display" value="1">Yes</option>
	<option id="display" name="display" value="0">No</option>
</select>
<br><br>

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
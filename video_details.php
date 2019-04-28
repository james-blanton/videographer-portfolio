<?php 
/*-------------------------------------------
FILE PURPOSE

This file is for displaying additional details assigned to a spcific video. Prepared statements have not been used in this file due to no user input being used with the exception of the ID from the url.

/*------------------------------------------*/

include('header.php');
// database connection file
include("blog/connect.php");

// Function to check that the id gathered from the url is valid. This function can be found in header.php.
$id = $_GET['id'];
idCheck($id);

// Select statement to acquire all details related to the selected video
$sql= "SELECT id, description, filename, fileextension FROM video WHERE id = $id";
$result = $dbcon->query($sql);

// Redirect the user away if they try and view video_details for a video id that does not exist in the database
$num_rows = mysqli_num_rows($result);
if($num_rows == 0){
	Redirect('video', false);
	exit();	
}

while($row = $result->fetch_assoc()) {
	$id = $row['id'];
	$fileextensionvalue= $row['fileextension'];
	$videos_field= $row['filename'];
	$video_show= "videos/$videos_field";
	$descriptionvalue= $row['description'];

	echo "<video width='100%' controls><source src='".$video_show."' type='video/$fileextensionvalue'>Your browser does not support the video tag.</video>";
	?>

	<br/><br/>
	<a href="video"> << return to Videos</a>
	<br/>

	<div class="w3-container w3-center w3-light-grey"><h3>Summary</h3></div>

<?php 
	echo "<br/>". nl2br($descriptionvalue) . "<br/><br/>";
?>

	<div class="w3-container w3-center w3-light-grey"><h3>Details</h3></div>

<?php
		$sql= "SELECT details FROM vid_details WHERE video_id = $id";
		$result = $dbcon->query($sql);
		while($row = $result->fetch_assoc()) {
			$video_details = $row['details'];
			echo "<br/>". nl2br($video_details) . "<br/><br/>";
		}

}

?>

<?php
// this shall be a url that takes an admin to the  file that allows them to edit this page
if(isset($_SESSION['username'])) { ?>
<a href="#"><div id="fixedbutton"><button class="switch">Edit Content</button></div></a>
<?php } ?>
        
</div>

</div>

<?php include('footer.php'); ?>
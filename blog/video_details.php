<?php
/*-------------------------------------------
FILE PURPOSE

This file is found via the admin dashboard. In short, this is used to edit existing in depth details related to a video. The information found while editing video details is in the "vid_details" table. The "video" table contains only a short summary of each video. All of the content edited in this file is related to the "vid_details" table.

/*------------------------------------------*/

include("../header.php");
// database connection file
include("connect.php");

// Function to check that the id gathered from the url is valid. This function can be found in header.php.
$id = $_GET['id'];
idCheck($id);

// Function to ensure that the user is logged in as an admin. This function can be found in header.php.
loginCheck();

// redirect the user away if they try to access the video_details.php page for a video id that doesnt exist in the database
$sql = "SELECT * FROM video WHERE id = '$id'";

// prepare statement for security
if ($stmt = mysqli_prepare($dbcon, $sql)) {

    // executes a prepared query (returns a TRUE or FALSE)
    mysqli_stmt_execute($stmt);

    // transfers a result set from a prepared statement
    mysqli_stmt_store_result($stmt);
 
	// if a result is not returned from the query, then redirect the user to the index of the portfolio
	if(mysqli_stmt_num_rows($stmt)==0) {
		Redirect('index', false);
		exit();
	} 
}


// query statement to get all database information related to the details for the video gathered from the url
//$sql = "SELECT * FROM vid_details WHERE video_id = '$id'";
$stmt = $dbcon->prepare("SELECT * FROM vid_details WHERE video_id = ?");
// binds variables to a prepared statement as parameters
$stmt->bind_param("i", $id);
// executes a prepared query
$stmt->execute();
// transfers a result set from a prepared statement
$stmt->store_result();
// count the number of rows returned by the query
$numrows = $stmt->num_rows;

// if there's no details entry in the database for this video, then enter placeholders now and re-run the query
if($numrows === 0) {
	$detail_placeholder = "Details coming soon.";
	$sql = "INSERT INTO vid_details (details, video_id) VALUES('$detail_placeholder', '$id')";
	mysqli_query($dbcon, $sql) or die("failed to send video detail placeholder data");
	$url ='video_details?id='.$_GET['id'];
	Redirect($url, false);
	exit(); // i need this exit of the insert goes on for forever 
} 


// get video details information for display in form now  that placeholder text has been entered if there was no initial details
// query statement to get a portion of the data related to the photograph from the database
$sql = "SELECT * FROM vid_details WHERE video_id = '$id'";
// execute the query
$result = mysqli_query($dbcon, $sql);

// store video's information in variables
// i don't need a while loop here because i'm only storing the information for one database row in to variables
$row = mysqli_fetch_assoc($result);
$id = $row['id'];
$details = $row['details'];


	// initialize  a variable for displaying success / errors messages to the user
	$error_display = '';

	if(isset($_POST['upd'])) {
		// if the form has been submitted, then store all of the information entered by the user in to variables
		$id = (INT)$_POST['id'];
		$details = $_POST['details'];
		
		 // query statement to update database row related to appropriate video details
		$stmt = $dbcon->prepare("UPDATE vid_details SET details=? WHERE id=?");
		// binds variables to a prepared statement as parameters
		$stmt->bind_param('si', $details, $id);
		// executes a prepared query and stores the result as TRUE or FALSE
		$status = $stmt->execute();

		// check if the query executed successfully or not
		// display a success or fail message to the user 
		if ($status === false) {
			$error_display = "<br/>Failed to edit.<br/>";
		} else {
			$error_display = "<br/>Video edited successfully.<br/>";
			$id=$_GET['id'];
			$sql = "SELECT * FROM video WHERE id = '$id'";
			// prepare statement for security
			if ($stmt = mysqli_prepare($dbcon, $sql)) {

			    // executes a prepared query
			    mysqli_stmt_execute($stmt);

			    // transfers a result set from a prepared statement
			    mysqli_stmt_store_result($stmt);
			 
				// if a result is not returned from the query, then redirect the user to the index of the portfolio
				if(mysqli_stmt_num_rows($stmt)==0) {
					Redirect('index', false);
					exit();
				} 
			}

		}
	}

	// this while statement allows the bound result variables to be displayed in the form
	 while (mysqli_stmt_fetch($stmt)) {

?>

<div class="w3-container w3-light-grey">
<h2>Edit Video Details</h2></div>
<div class="w3-container">

<a href="admin" > << return to Admin Dashboard</a><br/>

<?php echo $error_display; ?>

<form action="" method="POST" class="w3-container">
<input type="hidden" name="id" value="<?php echo $id;?>">

<label>Details (3500 characters)</label>
<textarea class="w3-input w3-border large_textbox" name="details" maxlength="3500"><?php echo $details;?></textarea>

<input type="submit" class="w3-btn w3-light-grey w3-round" name="upd" value="Submit">
</form>


<?php
	}

// close the connection for great security
mysqli_close($dbcon);
include("footer.php");
?>
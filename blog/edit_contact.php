<?php
/*-------------------------------------------
FILE PURPOSE

For editing contact page info/

/*------------------------------------------*/

include("../header.php");
// database connection file
include("connect.php");

// Function to ensure that the user is logged in as an admin. This function can be found in header.php.
loginCheck();

// get biography info for contact page
$sql = "SELECT * FROM general_info WHERE field_name='biography'";
// execute the query
$result = mysqli_query($dbcon, $sql);

// store general website information in variables
// i don't need a while loop here because i'm only storing the information for one database row in to variables
$row = mysqli_fetch_assoc($result);
$biography = $row['info'];

	// initialize  a variable for displaying success / errors messages to the user
	$error_display = '';

	if(isset($_POST['upd'])) {
		// if the form has been submitted, then store all of the information entered by the user in to variables
		$biography = $_POST['biography'];
		
		 // query statement to update database row related to appropriate video details
		$stmt = $dbcon->prepare("UPDATE general_info SET info=? WHERE field_name='biography'");
		// binds variables to a prepared statement as parameters
		$stmt->bind_param('s', $biography);
		// executes a prepared query and stores the result as TRUE or FALSE
		$status = $stmt->execute();

		// check if the query executed successfully or not
		// display a success or fail message to the user 
		if ($status === false) {
			$error_display = "<br/>Failed to edit.<br/>";
		} else {
			$error_display = "<br/>General  info edited successfully.<br/>";
			$sql = "SELECT * FROM general_info ";
			// prepare statement for security
			if ($stmt = mysqli_prepare($dbcon, $sql)) {

			    // executes a prepared query
			    mysqli_stmt_execute($stmt);

			    // transfers a result set from a prepared statement
			    mysqli_stmt_store_result($stmt);
			 
				// if a result is not returned from the query, then redirect the user to the index of the portfolio
				if(mysqli_stmt_num_rows($stmt)==0) {
					Redirect('../contact', false);
					exit();
				} 
			}

		}
	}



?>

<div class="w3-container w3-light-grey">
<h2>Edit General Website Info</h2></div>
<div class="w3-container">

<a href="admin" > << return to Admin Dashboard</a><br/><br/>
<a href="../contact" > << return to Contact Page</a><br/><br/>

<?php echo $error_display; ?>

<form action="" method="POST" class="w3-container">

<label>Biography (5000 characters)</label>
<textarea class="w3-input w3-border large_textbox" name="biography" maxlength="5000"><?php echo $biography;?></textarea>

<input type="submit" class="w3-btn w3-light-grey w3-round" name="upd" value="Submit">
</form>


<?php
	

// close the connection for great security
mysqli_close($dbcon);
include("footer.php");
?>
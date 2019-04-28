<?php 
/*-------------------------------------------
FILE PURPOSE

This file only includes an a short biography on myself and a contact form so that users may quickly send me correspondence.
As of right now the email that is sent by the form does not look asthetically pleasing because it's only seen by me.

I have also included my resume, which opens in a seperate window. This resume file name is linked to a field in the general_info database table. I have done this so that I may eventually create a resume upload script that will alter this field and automatically point to the proper resume file.

At a later point in time I will need to update the photograph on this page to an image of myself. 

/*------------------------------------------*/

include('header.php'); 
// database connection file
include("blog/connect.php");
?>

<?php
$user_message='';


if(isset($_POST['submit'])) {
	// my email that i wish to have all communication sent to
    $email_to = "charlesjamesblanton@gmail.com";
    $email_subject = $_POST['subject']; 
    $first_name = $_POST['firstname']; // required
    $last_name = $_POST['lastname']; // required
    $email_from = $_POST['email']; // required
    $comments = $_POST['message']; // required
    $comments = nl2br($comments);
 	
 	// initalize variable for displaying error message to the user if they do not fill out the email form correctly
    $user_message = "";

    // validating user input
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
 
	if(!preg_match($email_exp,$email_from)) {
		$user_message .= 'The email address you entered does not appear to be valid.<br />';
	}
	 
	$string_exp = "/^[A-Za-z .'-]+$/";
	 
	if(!preg_match($string_exp,$first_name)) {
		$user_message .= 'The first name you entered does not appear to be valid.<br />';
	}
	 
	if(!preg_match($string_exp,$last_name)) {
		$user_message .= 'The last name you entered does not appear to be valid.<br />';
	}
	 
	if(strlen($comments) < 2) {
		$user_message .= 'The email message you entered do not appear to be valid.<br />';
	}

	if(strlen($user_message) > 0) {
	} 
 
 	// initalize a variable for storing the body of the email message
    $email_message = "";

    // Generate email html. This email HTML can be changed by editing contact_email.php
	if($user_message=='') {
		// The following code with ob_get_contents() is used in order to store an entire php / html file in a variable.
		// This method allows all data collected from the form found in this file to be used in contact_email.php in order to generate  the required html for the body of an email.
		// Now I only have to edit contact_email.php when I wish to change the appearance of the emails that I recieve. 
		ob_start(); // turn on output buffering
		include('contact_email.php');
		$res = ob_get_contents(); // get the contents of the output buffer
		ob_end_clean(); //  clean (erase) the output buffer and turn off output buffering
		$email_message = $res;

		// create email headers
		$headers = 
		'Content-type: text/html; charset=iso-8859-1' . "\r\n".
		'From: '.$email_from."\r\n".
		'Reply-To: '.$email_from."\r\n" .
		'X-Mailer: PHP/' . phpversion();

		// send the email
		mail($email_to, $email_subject, $email_message, $headers); 

	} // don't execute the html section if there's any error messages for the user.
} else { $user_message='Feel free to contact me with any questions, concerns or buisness inquiries.'; }

?>

<div class = "contact_container">

<div class = "divide_small_content_l">
	<img src="images/ct_portrait_placehold.jpg">

<br/><br/>


<?php //form displayed with desktop resolution ?>
<div class ="contact_form">
<h2 class="bio_headers">CONTACT ME</h2>
	<?php  echo $user_message; ?>
	<form action="" class="w3-container" method="POST">
	    <label for="firstname">First Name</label><br/>
	    <input type="text" id="firstname" name="firstname" class="w3-input w3-border"placeholder="First Name ..." maxlength="20" >

	    <label for="lastname">Last Name</label><br/>
	    <input type="text" id="lastname" name="lastname" class="w3-input w3-border"placeholder="Last Name ..." maxlength="20">

	   	<label for="subject">Subject</label><br/>
	    <input type="text" id="subject" name="subject" class="w3-input w3-border"placeholder="Subject ..." maxlength="30" >

	   	<label for="email">Email</label><br/>
	    <input type="email" id="email" name="email" class="w3-input w3-border"placeholder="Email ..." maxlength="40" >

	    <label for="message">Message</label><br/>
	    <textarea id="message" name="message" class="w3-input w3-border large_textbox" placeholder="Message ..." maxlength="2000" ></textarea>

	    <input type="submit" name="submit" class="w3-btn w3-light-grey" value="Submit">
	</form>
</div>

</div>

<?php // biography ?>
<div class = "divide_small_content_r" class="bio_justify" style="">
<h2 class="bio_headers">GREETINGS</h2>

<?php
// select statement to acquire all details related to the users biography and other general information
$sql= "SELECT info FROM general_info WHERE field_name = 'biography'";
$result = $dbcon->query($sql);

// let the user know if there is no biography information available for display
$num_rows = mysqli_num_rows($result);
if($num_rows == 0){
	echo 'Biography information not available.';
}

while($row = $result->fetch_assoc()) {
	$biography_info= $row['info'];
	echo nl2br($biography_info);
}

?>

<br/><br/>

<?php
// select statement to acquire resume link
$sql= "SELECT info FROM general_info WHERE field_name = 'resume'";
$result = $dbcon->query($sql);

// let the user know if there is no resume information available for display
$num_rows = mysqli_num_rows($result);
if($num_rows == 0){
	echo 'Resume not available.';
}

while($row = $result->fetch_assoc()) {
	$resume_filename = $row['info'];
}

?>
<a href="documents/<?php echo $resume_filename ?>" target="_new">View Resume (PDF)</a>
<br/><br/>


<?php //form displayed with mobile resolution ?>
<div class ="contact_form_mobile">
<h2 class="bio_headers">CONTACT ME</h2>
	<?php  echo $user_message; ?>
	<form action="" class="w3-container" method="POST">
	    <label for="fname">First Name</label><br/>
	    <input type="text" id="fname" name="firstname" class="w3-input w3-border"placeholder="First Name ..." maxlength="20" >

	    <label for="lname">Last Name</label><br/>
	    <input type="text" id="lname" name="lastname" class="w3-input w3-border"placeholder="Last Name ..." maxlength="20">

	   	<label for="subject">Subject</label><br/>
	    <input type="text" id="subject" name="subject" class="w3-input w3-border"placeholder="Subject ..." maxlength="30" >

	   	<label for="email">Email</label><br/>
	    <input type="email" id="email" name="email" class="w3-input w3-border"placeholder="Email ..." maxlength="30" >

	    <label for="message">Message</label><br/>
	    <textarea id="message" name="message" class="w3-input w3-border large_textbox" placeholder="Message ..." maxlength="1000" ></textarea>

	    <input type="submit" name="submit" class="w3-btn w3-light-grey" value="Submit">
	</form>
</div>

<?php
// insert contact form here
?>

</div> <!-- end 'divide_small_content_r' -->


</div>

<?php
// this shall be a url that takes an admin to the  file that allows them to edit this page
if(isset($_SESSION['username'])) { ?>
<a href="blog/edit_contact.php"><div id="fixedbutton"><button class="switch">Edit Content</button></div></a>
<?php } ?>

</div> <!-- end 'small_content' div that starts in header -->
</div> <!-- end 'content' div that starts in header -->

<?php include('footer.php'); ?>
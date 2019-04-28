<?php
/*-------------------------------------------
FILE PURPOSE

This file processes all data gathered from the form found on contact.php and generates an html ouput.
This HTML output is then assigned to a variable in contact.php and sent as the body of the emails sent to me.

This file required the POST variables at the top in order properly generate the html for the email.

As of right now this email does not look asthetically pleasing because it's only seen by me.

/*------------------------------------------*/

 $email_to = "charlesjamesblanton@gmail.com";
 $email_subject = $_POST['subject']; 
 $first_name = $_POST['firstname']; // required
 $last_name = $_POST['lastname']; // required
 $email_from = $_POST['email']; // required
 $comments = $_POST['message']; // required
 $comments = nl2br($comments);
?>

<html>
<head>
<style type="text/css">
body, html {
	background: #F1F1F1;
	width:100%;
	height:100%;
}

h1 {
	font-family: "futura-pt", "Segoe UI", "Helvetica Neue", Arial, sans-serif !important;
	text-transform: uppercase !important;
	text-decoration: none !important;
	letter-spacing: 0px !important;
	font-weight: 300 !important;
	font-size: 35px !important;
}

h2 {
	font-family: "futura-pt", "Segoe UI", "Helvetica Neue", Arial, sans-serif !important;;
	margin-top: 10px;
	margin-bottom: 10px;
	font-weight: 300 !important;;
	font-size: 25px !important;
	text-transform: uppercase;
}

.container_outerContent {
	padding-bottom: 2rem;
	color: #040404;
	background-color: #F1F1F1;
	height:100%;
	padding:3%;
}

.container_innerContent {
	width:80%;
	bottom: 0;
	position: relative;
	background-color: #FFFFFF;
	z-index: 100;
	margin-left: auto;
	margin-right: auto;
	padding: 15px;
	padding-top: 100px;
	box-shadow: 12px 0 15px -4px rgba(154, 154, 154, 0.8), -12px 0 8px -4px #9E9E9E;
}

.small, small {
	font-size:60% !important;
}

</style>

</head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

<body>

	<div class="container_outerContent">
		<div class="container_innerContent" style="padding:20px;">
			<h2><?php echo $email_subject; ?><small> from <?php echo $first_name.'&nbsp;'.$last_name; ?></small></h2>
			<p><?php echo $comments; ?></p>
			<h2><small><?php echo $email_from; ?></small></h2>
		</div>
	</div>

</body>
</html>
		
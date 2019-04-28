<?php 
/*-------------------------------------------
FILE PURPOSE

Related to a work in progress system for a newsletter system. Similar to the file 'contact_email.php'

/*------------------------------------------*/

include('header.php'); 
?>

<?php
$user_message='';


if(isset($_POST['submit'])) {
 
    // EDIT THE 2 LINES BELOW AS REQUIRED
    $email_to = "charlesjamesblanton@gmail.com";
    $email_subject = $_POST['subject']; 
 
    $first_name = $_POST['firstname']; // required
    $last_name = $_POST['lastname']; // required
    $email_from = $_POST['email']; // required
    $comments = $_POST['message']; // required
    $comments = nl2br($comments);
 
    $user_message = "";
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
 
    $email_message = "";
 
     
    function clean_string($string) {
      $bad = array("content-type","bcc:","to:","cc:","href");
      return str_replace($bad,"",$string);
    }

	if($user_message=='') {

		// generate email html ... change this using newsletter.php  
		$email_message ='
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
}

ol, ul {
	margin-top: 0;
	margin-bottom: 10px;
	padding: 0;
}

li {
	list-style: none;
	float: left;
	border-right: 1px solid black;
	margin-right: 10px;
	padding-right:  10px
}

ul > li:nth-child(3) {
	border-right: none;
}

.lead {
	font-size: 17px;
	font-family: "futura-pt", "Segoe UI", "Helvetica Neue", Arial, sans-serif;
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

.header .columns {
	padding-bottom: 0;
}

.header .wrapper-inner {
	padding: 20px;
}

.header .container {
	background: #8a8a8a;
}

.wrapper.secondary {
	background: #f3f3f3;
}

img {
	width: 100%;
	position: relative;
}

.small, small {
	font-size:70% !important;
}

.img_shrink {
	max-height: 500px;
	overflow: hidden;
	position: relative;
	width: 100%;
}

menu {
	padding: 0;
	width: 100%;
	position: relative;
}

menu > item {
	position: relative;
	width: 25%;
}
</style>

</head>
<title>James Blanton</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" type="images/x-icon" href="https://james-blanton.com/v7/images/ico.ico" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

<body>

	<div class="container_outerContent">
		<div class="container_innerContent" style="padding:20px;">
			<wrapper class="header">
			<container>
				<row class="collapse">
				<columns small="6">            
				</columns>
				<columns small="6">
				</columns>
				</row>
			</container>
			</wrapper>

			<container>
				<spacer size="16"></spacer>

				<row>
					<columns small="12">
					<h1>Hi, James Blanton</h1>
					<p class="lead">For now this email will be a placeholder example of what a newletter email may look like. Im currently using this formatting for emails that I recieve via the form located in the contact section of my portfolio.</p>
					<div class="img_shrink">
					<img src="https://james-blanton.com/v7/images/ct_portrait_placehold.jpg" alt="" width="100%;">
					</div>
					<callout class="primary">
					<p>This is the most recent photograph that Ive added to my portfolio. Want to see more of what Ive been up to lately? <a href="#">Click here!</a></p>
					</callout>
					<hr>
					<h2>'.$email_subject.' <small>from '.$first_name.'&nbsp;'.$last_name.'</small></h2>
					<p>'.$comments.'</p>
					<h2><small>'.$email_from.'</small></h2>
					</columns>
				</row>
				<br/>

				<wrapper class="secondary">
				<row>
					<columns small="12" large="6">
					<h5>Connect With Me:</h5>
					<ul>
					<li><a href="#">LinkedIN</a></li>
					<li><a href="#">Twitter</a></li>
					<li><a href="#">Google +</a></li>
					</ul>
					</columns>
					<br/> <br/>
					<columns small="12" large="6">
					<p>Phone: 614-499-4736</p>
					<p>Email: <a href="mailto:charlesjamesblanton@gmail.com">contact@james-blanton.com</a></p>
					</columns>
				</row>
				
				</wrapper>    
				<a href="#">Terms</item>
				<a href="#">Privacy</item>
				<a href="#">Unsubscribe</item>
			</container>
		</div>
	</div>

</body>

</html>
		';

		  // create email headers
		  $headers = 
		  'Content-type: text/html; charset=iso-8859-1' . "\r\n".
		  'From: '.$email_from."\r\n".
		  'Reply-To: '.$email_from."\r\n" .
		  'X-Mailer: PHP/' . phpversion();
		  mail($email_to, $email_subject, $email_message, $headers); 

	} // don't execute the html section if there's any error messages for the user.
} else {$user_message='Enter email.';}

?>

<div class = "contact_container">

<div class = "divide_small_content_l">
	<img src="images/ct_portrait_placehold.jpg">

<br/><br/>


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

<div class = "divide_small_content_r" class="bio_justify" style="">
<h2 class="bio_headers">GREETINGS</h2>
Greetings, I'm James! I currently live and work in Columbus OH where I explore the unending potential that film provides to create immersive and humanizing narratives. In 2019, I began my journey towards making a living shooting the things I love while sharing my interpretation of the human condition. I often treat nature as a catalyst for creativity.<br/><br/>

As an avid fan of traditional animation I frequently unearth inspiration from the works of Tiny Inventions, Hayao Miyazaki, Makoto Shinkai, and Kyoto Animation. I  enjoy contemplative and quit narratives akin to Before Sunrise, Finding Forester, Into The Wild and Lost In Translation. <br/><br/>

In the realm of animation my favorites would include, but not be limited to Your Name (Kimi no Na wa), Princess Mononoke, The End of Evangelion, In This Corner of the World, 5 Centimeters Per Second, and How To Train Your Dragon.<br/><br/>

EMAIL: charlesjamesblanton@gmail.com<br/><br/>

The contact form found on this page has a max legnth of 20 characters for the name fields, 30 characters for a subject and 1,000 characters for the message. <br/><br/>

<a href="documents/resume_2019.pdf" target="_new">View Resume (PDF)</a><br/><br/>


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

</div> <!-- end 'small_content' div that starts in header -->
</div> <!-- end 'content' div that starts in header -->

<?php include('footer.php'); ?>
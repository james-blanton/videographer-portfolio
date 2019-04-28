<?php 
/*-------------------------------------------
FILE PURPOSE

This file includes the html found in contact_newsletter.php
This html will be used to generate the newsletter emails that will be sent to users who sigh up and have their name + email committed to the newsletter database table.

/*------------------------------------------*/


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
					<h2>'.$email_subject.' <small>from '.$first_name. $last_name.'</small></h2>
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
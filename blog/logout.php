<?php
/*-------------------------------------------
FILE PURPOSE

This file logs out the user / administrator and re-directs them to the login page.
If the user tries to access the logout file for some reason when they aren't even logged in, then they get redirected to the index page.

/*------------------------------------------*/

session_start();

if(!isset($_SESSION['username'])) 
{
	header("location: index");
}
else
{
	session_destroy();
	header("location: login") ;
}

?>
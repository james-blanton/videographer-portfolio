<?php
/*-------------------------------------------
FILE PURPOSE

This header file includes the primary navigation of video, photo, contact and article links at the top of the portfolio.
The following if else statement is used to adjust the urls and the paths for the css depending upon whether you are in the root directory or the blog directory:

    if ($current_location == "blog")
    {
        // if we're in the blog directory, then adjust the url here to go back to a file that's 1 directory level back
    }
    else {
        // if we're not in the blog directory, then adjust the url here to go to a file that's within the same directory
    }

This IF block is also used in the footer file.

I've left the old urls without the if else statement in this file in order to make the file easier and quicker to read and navigate.

/*------------------------------------------*/

// global redirect function 
function Redirect($url, $permanent = false)
{
    header('Location: ' . $url, true, $permanent ? 301 : 302);
    exit();
}

// This function returns the same of the current directory location  for the file that is being viewed. This function is used to adjust the navigation urls and the paths to the CC files depending upon whether we are in the blog directory or not. 
FUNCTION getCurrentDirectory() {
    $path = DIRNAME($_SERVER['PHP_SELF']);
    $position = STRRPOS($path,'/') + 1;
    RETURN SUBSTR($path,$position);
}

$current_location = getCurrentDirectory();

session_start();
?>

<!DOCTYPE HTML>
<html>
<title>James Blanton</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php



if ($current_location == "blog")
{
echo 
'
<link rel="shortcut icon" type="images/x-icon" href="../images/ico.ico" />
';
}
else {
echo
'
<link rel="shortcut icon" type="images/x-icon" href="images/ico.ico" />
';
}
?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

<?php
if ($current_location == "blog")
{
echo 
'
<link rel="stylesheet" type="text/css" href="../styles/main_style.css">
';
}
else {
echo
'
<link rel="stylesheet" type="text/css" href="styles/main_style.css">
';
}
?>

<meta name="description" content="James Blanton is a videographer living and working in Columbus, Ohio." />
<meta name="keywords" content="Art,Digital Art,James Blanton,James Blanton art">
<meta name="author" content="James Blanton">
<meta name="viewport" content="width=device-width" />

<body>
<div class="header_bar">
	<div id="links">
        
        <nav="nav">
            <nav class="nav">
                <div class="logo">
                	<h1>
					<?php
				    if ($current_location == "blog")
				    {
				        echo '<a href="../index">James Blanton</a>';
				    }
				    else {
				        echo '<a href="index">James Blanton</a>';
				    }
				    ?>
					</h1>
                </div>
                
                <ul>
                    <li>
                    <?php

                    if ($current_location == "blog")
                    {
                        echo '<a href="../video"><i class="fas fa-film"></i>Video</a>';
                    }
                    else {
                        echo '<a href="video"><i class="fas fa-film"></i>Video</a>';
                    }
                    ?>
                    </li>

                    <li>
                    <?php

                    if ($current_location == "blog")
                    {
                        echo '<a href="../photography"><i class="far fa-image"></i>Photo</a>';
                    }
                    else {
                        echo '<a href="photography"><i class="far fa-image"></i>Photo</a>';
                    }
                    ?>
                    </li>

                    <li>
                    <?php
                    if ($current_location == "blog")
                    {
                        echo '<a href="../contact"><i class="far fa-id-card"></i>Contact</a>';
                    }
                    else {
                        echo '<a href="contact"><i class="far fa-id-card"></i>Contact</a>';
                    }
                    ?>
                    </li>

                    <li>
                    <?php
                    if ($current_location == "blog")
                    {
                        echo '<a href="index"><i class="far fa-newspaper"></i>Articles</a>';
                    }
                    else {
                        echo '<a href="blog/index"><i class="far fa-newspaper"></i>Articles</a>';
                    }
                    ?>
                    </li>                 
                </ul>
			</nav>
        </nav>
    </div>
</div>

<div class="mobile_nav">
	<div class="mobile_logo">
		<h1>
			<?php
		    if ($current_location == "blog")
		    {
		        echo '<a href="../index">James Blanton</a>';
		    }
		    else {
		        echo '<a href="index">James Blanton</a>';
		    }
		    ?>
		</h1>
	</div>

    <div class="mobile_nav_bar">
    <?php
    if ($current_location == "blog")
    {
        echo '<a href="../video">Video</a>';
    }
    else {
        echo '<a href="video">Video</a>';
    }
    ?>
    </div>

    <div class="mobile_nav_bar">
    <?php
    if ($current_location == "blog")
    {
        echo '<a href="../photography">Photo</a>';
    }
    else {
        echo '<a href="photography">Photo</a>';
    }
    ?>
    </div>

    <div class="mobile_nav_bar">
    <?php
    if ($current_location == "blog")
    {
        echo '<a href="../contact">Contact</a>';
    }
    else {
        echo '<a href="contact">Contact</a>';
    }
    ?>
    </div>

    <div class="mobile_nav_bar">
    <?php
    if ($current_location == "blog")
    {
        echo '<a href="index">Articles</a>';
    }
    else {
        echo '<a href="blog/index">Articles</a>';
    }
    ?>
    </div>
    
</div>

</div>

<div class="nav_desktop_grayBar">
</div>

<div class="container_outerContent">

    <div class="container_innerContent">
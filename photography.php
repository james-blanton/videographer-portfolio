<?php 
/*-------------------------------------------
FILE PURPOSE

This file displays tabs for each video category. 
Each category tab includes a seperate file that queries the database to display the videos that belong to that specific category.

The javascript function at the end of this file toggles the width of photo to display at 100% the width of its parent container div. 

Currently I have two placeholder categories in place in prediction of adding more categories soon.

/*------------------------------------------*/

include('header.php'); 

?>


<link rel="stylesheet" href="styles/photo_styles.css">

<div id="fixedbutton"><button class="switch">Toggle Width</button></div>

<button class = "full_width_btn" onclick="fullWidthFunction()">MENU</button>

<div id="photography_menu" style="display: block;">

 <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#home">PORTRAIT</a></li>
    <li><a data-toggle="tab" href="#menu1">LANDSCAPE</a></li>
    <li><a data-toggle="tab" href="#menu2">COMMERCIAL</a></li>
    <!--
    <li><a data-toggle="tab" href="#menu3">CATEGORY 4</a></li>
    <li><a data-toggle="tab" href="#menu4">CATEGORY 5</a></li>
    -->

  </ul>
  </div>


  <div class="tab-content">

    <div id="home" class="tab-pane fade in active" style="height:100%; float:left;">
      <h3>PORTRAIT</h3>
      <?php include('display_portrait.php'); ?>
    </div>

    <div id="menu1" class="tab-pane fade" style="height:100%; float:left;">
      <h3>LANDSCAPE</h3> 
      <?php include('display_landscape.php'); ?>
    </div>

    <div id="menu2" class="tab-pane fade" style="height:100%; float:left;">
      <h3>COMMERCIAL</h3>
      <?php include('display_commercial.php'); ?>
    </div>

    <!--
    <div id="menu3" class="tab-pane fade" style="height:100%; float:left;">
      <h3>CATEGORY 4</h3>
      test category 4
    </div>

    <div id="menu4" class="tab-pane fade" style="height:100%; float:left;">
      <h3>CATEGORY 5</h3>
      test category 5
    </div>
    -->

  </div>

  <button class="switch">Toggle Width</button>

</div>

        
</div>
</div>

<script>    
    $('.switch').on('click', function(e) {
      $('.column').toggleClass("column-full"); // can list several class names 
      e.preventDefault();
    });
</script>

<script type="text/javascript">
  function fullWidthFunction() {
  var x = document.getElementById("photography_menu");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}
</script>

<?php include('footer.php'); ?>
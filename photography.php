<?php 
/*-------------------------------------------
FILE PURPOSE

This file displays tabs for each video category. 

Each category tab includes a function that queries the database to display the videos which belong to that specific category. Check functions.php if you wish to edit how the photographs are displayed. 

The javascript function at the end of this file toggles the width of photo to display at 100% the width of its parent container div. 

/*------------------------------------------*/

include('header.php'); 

?>

<link rel="stylesheet" href="styles/photo_styles.css">

<div id="fixedbutton"><button class="switch">Toggle Width</button></div>

<button class = "full_width_btn" onclick="fullWidthFunction()">MENU</button>

<div id="photography_menu">

 <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#home">PORTRAIT</a></li>
    <li><a data-toggle="tab" href="#menu1">LANDSCAPE</a></li>
    <li><a data-toggle="tab" href="#menu2">COMMERCIAL</a></li>
  </ul>
  </div>


  <div class="tab-content">

    <div id="home" class="tab-pane fade in active" class="float_fullHeight">
      <h3>PORTRAIT</h3>
      <?php $type = 'portrait'; display_photographs($type); ?>
    </div>

    <div id="menu1" class="tab-pane fade" class="float_fullHeight">
      <h3>LANDSCAPE</h3> 
      <?php $type = 'landscape'; display_photographs($type); ?>
    </div>

    <div id="menu2" class="tab-pane fade" class="float_fullHeight">
      <h3>COMMERCIAL</h3>
      <?php $type = 'commercial'; display_photographs($type); ?>
    </div>

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
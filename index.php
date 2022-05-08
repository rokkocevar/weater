<!DOCTYPE html>
<html lang="en">
<head>
<?php 
require_once 'povezava.php';
?>
<title>Weather app</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://maps.api.2gis.ru/2.0/loader.js?pkg=full"></script>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
body,h1,h2,h3,h4,h5,h6 {font-family: "Raleway", Arial, Helvetica, sans-serif}
body
{
    height:auto;
    overflow-x:hidden;
}
.w3-display-middle{
    position: absolute;
    height: 100%;
    padding-top: 60px; 
}
.kraji{
    height:auto;
    overflow-x:hidden;
	width: 100%;
	}
#map{
	margin: auto;
	margin-top: 25px;
}
.clear {
    clear: both;
}

</style>
</head>
<body class="w3-light-grey">

<!-- Navigation Bar -->
<div class="w3-bar w3-white w3-border-bottom w3-xlarge">
  <a href="index.php" class="w3-bar-item w3-button w3-text-red w3-hover-red"><b><i class="fa fa-map-marker w3-margin-right"></i></b></a>
          <div class="clear"> </div>

</div>

<!-- Header -->
  <div class="w3-display-middle" style="width:65%;margin-top:100px;">
    <div class="w3-bar" style="width:100%;">
	<form action="index.php" method="GET">
    <div id="search" class="w3-container w3-white w3-padding-16" style="padding-top: 200px;">
      <h3>Potujte v lepem vremenu</h3>
      <div class="w3-row-padding" style="margin:0 -16px;">
        <div class="w3-half">
          <label>Iz</label>
          <input class="w3-input w3-border" type="text" name="kraj1" id="kraj1" placeholder="Kraj odhoda">
        </div>
        <div class="w3-half">
          <label>Do</label>
          <input class="w3-input w3-border" type="text" name="kraj2" id="kraj2" placeholder="Kraj prihoda">
        </div>
      </div>
      <p><button class="w3-button w3-dark-grey">Išči</button></p>
    </div>
	</form>
	<div>
	<?php require 'iskanje_kraj.php'; ?>
	</div>
	  </div>
    </div>
<script type="text/javascript">
    var map;
    DG.then(function () {
        map = DG.map('map', 
		{
            center: [46.05, 14.51],
            zoom: 5

        });
				<?php echo $pinpoints; ?>
    });
</script>
	    <div id="map" style="width:500px; height:400px"></div>
  
<footer class="w3-container w3-center w3-opacity w3-margin-bottom">

</footer>


</body>
</html>

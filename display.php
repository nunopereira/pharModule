<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Display</title>
	<?php
		include "pharmacy.php";
		$teste = array();
				$pharmacy = new Pharmacy;

		$dbFile = file_get_contents('data/data.db');
		$rows= explode("\n", $dbFile);
		$i=0;
		foreach($rows as $row => $data){
			$row_data = explode('|', $data);
			$pharmacy = new Pharmacy;
			if(!(($row_data[0]=="FALSE")||($row_data[0]=="TRUE"))){
				$pharmacy->setName($row_data[0]);
				$pharmacy->setAddress($row_data[1]);
				$pharmacy->setZipcode($row_data[2]);
				$pharmacy->setParishName($row_data[3]);
				$pharmacy->setMunicipalityName($row_data[4]);
				$pharmacy->setPhone($row_data[5]);
				$pharmacy->setLatitude($row_data[6]);
				$pharmacy->setLongitude($row_data[7]);
				$teste[$i]=$pharmacy;
				$i++;
			}else{
				if($row_data[0]=="FALSE") $map=0;
				if($row_data[0]=="TRUE") $map=1;
			}
		}
		$pharmsqt=$i-1;
		$pharmsqt2=$i-1;
	    $j=$i-1;
	    $i=0;
	?>
	<style rel="stylesheet" type="text/css">
        div.menu{-webkit-border-radius:15px;-moz-border-radius:15px;-ms-border-radius:15px;-o-border-radius:15px;border-radius:15px;display:block;padding:10px;margin:0 auto;width:350px;background:rgba(255,255,255,.65)}
        #titles{-webkit-border-radius:15px;-moz-border-radius:15px;-ms-border-radius:15px;-o-border-radius:15px;border-radius:15px;display:block;padding:25px;width: 90%;text-align:center;margin:0 auto;background:rgba(255,255,255,.65)}
    	#map-canvas {
        height: 70%;
        width: 90%;
        margin-left: auto;
        margin-right: auto;
      }

    </style>
    <link href="css/bootstrap.css" rel="stylesheet">
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
    <script>

  		/********** REFRESH INFO ***********/
  		 //setTimeout(function(){window.location.reload(true)},3000);

		var directionsDisplay;
		var directionsService = new google.maps.DirectionsService();
		var map;
		var coords = [<?php 
			while($pharmsqt>=0){
				echo '{ "x" : ',$teste[$i]->getLatitude(),', "y" : ',$teste[$i]->getLongitude(),', "n" : "',$teste[$i]->getName(),'"}';
				$i++;
				$pharmsqt--;
				if($pharmsqt>=0) echo ' , ';
			}
			$i=0;
		?>];

		function initialize() {
		  directionsDisplay = new google.maps.DirectionsRenderer();
		  var pharm1 = new google.maps.LatLng(<?php echo $row_data[2],',',$row_data[3]; ?>);
		  var mapOptions = {
		    zoom:7,
		    center: pharm1	  }
		  map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
		  directionsDisplay.setMap(map);

		}

		function calcRoute(x,y) {
		  			var start = new google.maps.LatLng(<?php echo $row_data[2],',',$row_data[3]; ?>);
		  			var end = new google.maps.LatLng(x,y);
		  			var request = {
					      origin:start,
					      destination:end,
					      travelMode: google.maps.TravelMode.DRIVING
					};
					directionsService.route(request, function(response, status) {
				    if (status == google.maps.DirectionsStatus.OK) {
				      directionsDisplay.setDirections(response);
				    }
				  });
		}

		var i=0;

			setInterval(function(){
				calcRoute(coords[i].x, coords[i].y);
				document.getElementById('pharName').innerHTML = "<h3>"+ coords[i].n +"</h3>";
				i++;
				if (i><?php echo $pharmsqt2 ?>)
					i=0;
			},15000);

		



		google.maps.event.addDomListener(window, 'load', initialize);

    </script>

  </head>


  <body style="background: url('background.jpg') no-repeat fixed center center / cover transparent;">
    <br><br><br>
    <div class="row">
    	<div class="col-xs-6 col-md-4">
	        <div id="titles" style="width: 77%; height: 0px;"><h3 style="margin-top: -4%;"> PHARMACIES AT SERVICE </h3></div><br>
					<?php
					    while($j>=0){
					    	echo "<div class='menu'><h4>",
								$teste[$i]->getName(),'</h4>',
					    		$teste[$i]->getAddress(),'<br>',
					    		$teste[$i]->getZipcode(),' ',
					    		$teste[$i]->getParishName(),' - ',
					    		$teste[$i]->getMunicipalityName(),'<br>',
								$teste[$i]->getPhone(),'</div><br>';
					    	$i++;
					    	$j--;
					    }
					?>
			
        </div>
        <div class="col-xs-12 col-md-8">
        	<?php if($map==1) echo '<div id="titles"><div id="pharName"><h3>PHARMACIES</h3></div><div id="map-canvas"></div> </div>'; ?>
 		</div>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    
  </body>
</html>
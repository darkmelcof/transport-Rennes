<html>
<head>
	<title>Arrêts - Rennes</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" href="../foundation-5.5.1/css/foundation.css" />
	<link rel="stylesheet" href="../style.css" />
	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&language=fr"></script>
	<script type="text/javascript">
	///////////////////////////////////////////////////////////////////
	// Powered By MapsEasy.com Maps Generator                        
	// Please keep the author information as long as the maps in use.
	// You can find the free service at: http://www.MapsEasy.com     
	///////////////////////////////////////////////////////////////////
	function LoadGmaps() {
		var myLatlng = new google.maps.LatLng(48.1172660,-1.6777926);
		var myOptions = {
			zoom: 13,
			center: myLatlng,
			disableDefaultUI: true,
			panControl: false,
			zoomControl: true,
			zoomControlOptions: {
				style: google.maps.ZoomControlStyle.SMALL
			},

			mapTypeControl: false,
			streetViewControl: false,
			mapTypeId: google.maps.MapTypeId.ROADMAP
			}
		var map = new google.maps.Map(document.getElementById("MyGmaps"), myOptions);
		<?php 
			if (isset($_GET["ligne"])){;
				include("../connection.php");
		        $query = "SELECT DISTINCT `stop_name`,`stop_lat`,`stop_lon` FROM `stops` JOIN stop_times ON stop_times.stop_id = stops.stop_id JOIN trips ON stop_times.trip_id = trips.trip_id JOIN routes ON trips.route_id = routes.route_id WHERE routes.route_id='".$_GET["ligne"]."' AND trips.direction_id=1 ORDER BY stop_times.stop_sequence";
		        $result = mysqli_query($conn, $query);

		        $tableau = array();

		        while ($row = mysqli_fetch_assoc($result)) {
		        	$tableau[] = $row;
		        }
		        include("../deconnection.php");

		        foreach ($tableau as $position) { ?>
	    			var pos = new google.maps.LatLng(<?php echo $position['stop_lat']; ?>,<?php echo $position['stop_lon']; ?>);
					var marker = new google.maps.Marker({
						position: pos,
						map: map,
						title: <?php echo '"'.$position['stop_name'].'"'; ?>
					});
		        // Fin du foreach, fin du if
		        <?php }} ?>
	}	

</script>
</head>

<body onload="LoadGmaps()" onunload="GUnload()">
	<div class="row">
		<div class="large-12 columns">
			<img id="top" src="../images/bus3.jpg">
		</div>
	</div>

	<div class="row">
		<div class="large-12 columns">  	  
			<nav class="top-bar" data-topbar role="navigation">
				<ul class="title-area">
					<li class="name">
					  <h1><a href="../index.php">Réseau de transport de Rennes - Horaires</a></h1>
			  		<li class="toggle-topbar menu-icon"><a href="#"><span></span></a></li>
				</ul>
			 	<section class="top-bar-section">
					<ul class="right">
					  <li>
					  	<a href="http://www.star.fr/fileadmin/documents/PDF/plans/de_reseau/Rennes_Centre%20Ville.pdf">Plan du centre ville</a>
					  </li>
					  <li class="divider"></li>
					  <li >
					  	<a href="http://www.star.fr/fileadmin/documents/PDF/plans/de_reseau/Rennes_urb_complet.pdf">Plan des lignes</a>
					  </li>
					  
					</ul>
				</section>
			</nav>

		</div>
	</div>

	<div class="row">
		<div class="large-8 medium-8 columns">
			</br></br>
			<div class="panel">
				<form method="get" action="arrets.php">
				<p>Retrouvez la liste des arrêts sur votre ligne</p>
				<p><label>Votre ligne</label>
				<select name="ligne" onchange="this.form.submit();">
				
				
					<?php
					
					if (isset($_GET["ligne"])) { // Conserve l'information déjà entré
						include("../connection.php");
						
						/*******************
						* Memoire du Choix
						********************/
						$query = "SELECT `route_long_name`, `route_short_name`, `route_id` FROM `routes` WHERE route_id=$_GET[ligne]";
				        $result = mysqli_query($conn, $query);

				        $row = mysqli_fetch_assoc($result); // récupère une ligne de résultat sous forme de tableau associatif

						echo '<option value=' . $row["route_id"] . '>' . $row["route_short_name"] . ' - ' . $row["route_long_name"] . '</option>';
						
						/*******************
						* Reste de la liste
						********************/
						$query = "SELECT `route_long_name`, `route_short_name`, `route_id` FROM `routes`";
				        $result = mysqli_query($conn, $query);

				        while ($row = mysqli_fetch_assoc($result)) {

				            echo '<option value=' . $row["route_id"] . '>' . $row["route_short_name"] . ' - ' . $row["route_long_name"] . '</option>';
				        }
						include("../deconnection.php");

					}else{ // Affichage des lignes
						echo '<option value="null"></option>';
						include("../connection.php");
				        $query = "SELECT `route_long_name`, `route_short_name`, `route_id` FROM `routes`";
				        $result = mysqli_query($conn, $query);

				        while ($row = mysqli_fetch_assoc($result)) {

				            echo '<option value=' . $row["route_id"] . '>' . $row["route_short_name"] . ' - ' . $row["route_long_name"] . '</option>';
				        }
				        include("../deconnection.php");
					}
			       
		        	?>
				</select></p>
			</form>
			<?php
				if (isset($_GET["ligne"])) {
			        /***********
			        * arrêts
			        ************/
			        include("../connection.php");
			        $query = "SELECT DISTINCT `stop_name` FROM `stops` JOIN stop_times ON stop_times.stop_id = stops.stop_id JOIN trips ON stop_times.trip_id = trips.trip_id JOIN routes ON trips.route_id = routes.route_id WHERE routes.route_id= $_GET[ligne] ORDER BY stop_times.stop_sequence";
					$result = mysqli_query($conn, $query);
					echo '<p>Arrêts de la ligne : ' . $_GET["ligne"] . '</p>';
					echo '<p>';
					  while ($row = mysqli_fetch_assoc($result)) {
			            echo $row["stop_name"]. ' - ';
			        }
			        echo '</p>';
			        include("../deconnection.php");
		    	}
			?>



			</div>

			<p id="MyGmaps" style="width:100%;height:50%;border:1px solid #CECECE;"></p>
		</div>

		<div class="large-4 medium-4 columns">
			</br></br>
            <div class="panel">
            <h5 style="text-align:center;">Différents types de recherches</h5>
            <p style="text-align:center;">
                <a href="lignes.php" class="button">Voir les lignes</a><br/>
                <a href="arrets.php" class="button success">Voir les arrêts</a><br/>
                <a href="itineraire.php" class="button black">Itinéraire simple</a></br>
                <a href="../index.php" class="button rouge">Voir les horaires</a></br>
            </p>   
            </div>

			<div class="panel">
				<h5>Infos réseau</h5>
				<ul>
					<li><img src="../images/bus-de-stade_02.jpg"> Bus de stade</li>
					<li><img src="../images/co2b.png"> CO2</li>
					<li><img src="../images/lignes-scolaires.gif"> Lignes scolaires</li>
					<li><img src="../images/Twitter-star.gif"> Suivez le star sur twitter</li>
				</ul>        
			</div>
		</div>
	</div>



		<script src="../foundation-5.5.1/js/vendor/modernizr.js"></script>
	<script src="../foundation-5.5.1/js/vendor/jquery.js"></script>
	<script src="../foundation-5.5.1/js/foundation/foundation.js"></script>
  	<script src="../foundation-5.5.1/js/foundation/foundation.topbar.js"></script>
  	<script>
    $(document).foundation();
  </script>
</body>
</html>
html>
<head>
	<title>Transport de Rennes-</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" href="../foundation-5.5.1/css/foundation.css" />
	<link rel="stylesheet" href="../style.css" />

</head>
<body>
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
					</li>
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

				<?php
					header('Content-Type: text/html; charset=utf-8');
					include("../connection.php");
					$query = "SELECT DISTINCT stops.stop_name, stop_sequence, stop_times.arrival_time, trips.trip_id, stops.stop_id
					FROM stops
					JOIN stop_times
					ON stops.stop_id = stop_times.stop_id
					JOIN trips
					ON stop_times.trip_id = trips.trip_id
					WHERE stop_times.trip_id = (SELECT stop_times.trip_id
					FROM stop_times
					JOIN trips
					ON stop_times.trip_id = trips.trip_id
					JOIN stops
					ON stop_times.stop_id = stops.stop_id
					JOIN calendar
					ON trips.service_id = calendar.service_id
					WHERE trips.route_id=\"".$_GET['ligne']."\" AND stop_times.departure_time > '".$_GET['heures'].":".$_GET['minutes'].":00'
					AND stops.stop_name = \"".$_GET['depart']."\" AND calendar.".$_GET['jour']." = 1
					ORDER BY departure_time
					LIMIT 1)
					ORDER BY stop_sequence;";

					$result = mysqli_query($conn, $query);
					$flag = false;
					$resultat = array();
					
					while($row = mysqli_fetch_assoc($result)) {

					    if($row['stop_name'] == $_GET['depart']) {
					        $flag = true;
					    }

					    if($flag) {
					        $resultat[$row['stop_name']] = date('H:i',strtotime($row['arrival_time']));
					        echo '<p>'.$row['stop_name'] . ' - ' . $resultat[$row['stop_name']] . '</p>';
					        
					    }
					    if($row['stop_name'] == $_GET['arrivee']) {
					        $flag = false;
					    }
					}
					
					$heureArrivee =  strtotime($resultat[$_GET['arrivee']]);
					$heureDepart =  strtotime($resultat[$_GET['depart']]);
					echo "<br><p> Temps de trajet = " .gmdate("H:i:s", $heureArrivee-$heureDepart).'</p>';
					include("../deconnection.php");
				?>
			</div>
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


	    <script src="../js/jquery-2.1.3.min.js"></script>
	    <script src="../js/script.js"></script>
	<script src="../foundation-5.5.1/js/vendor/modernizr.js"></script>
	<script src="../foundation-5.5.1/js/vendor/jquery.js"></script>
	<script src="../foundation-5.5.1/js/foundation/foundation.js"></script>
  	<script src="../foundation-5.5.1/js/foundation/foundation.topbar.js"></script>
	  	<script>
	    $(document).foundation();
	  </script>
	</body>
	</html>
<html>
<head>
	<title>Lignes - Rennes</title>
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
		<?php 
			if (isset($_GET["arret"])){;
				include("../connection.php");
		        $query = "SELECT DISTINCT `stop_name`,`stop_lat`,`stop_lon` FROM stops JOIN stop_times ON stop_times.stop_id = stops.stop_id JOIN trips ON stop_times.trip_id = trips.trip_id JOIN routes ON trips.route_id = routes.route_id WHERE stop_name='".urldecode($_GET["arret"])."' GROUP BY routes.route_id ORDER BY routes.route_id";
		        $result = mysqli_query($conn, $query);

		        $tableau = array();

		        while ($row = mysqli_fetch_assoc($result)) {
		        	$tableau[] = $row;
		        }
		        include("../deconnection.php");

		        foreach ($tableau as $position) { ?>
	    			var pos = new google.maps.LatLng(<?php echo $position['stop_lat']; ?>,<?php echo $position['stop_lon']; ?>);
					var myOptions = {
						zoom: 13,
						center: pos,
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
					var marker = new google.maps.Marker({
						position: pos,
						map: map,
						title: <?php echo '"'.$position['stop_name'].'"'; ?>
					});
		        // Fin du foreach, fin du if
		        <?php }} else{ ?>
					var pos = new google.maps.LatLng(48.1172660,-1.6777926);
					var myOptions = {
						zoom: 13,
						center: pos,
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
					var marker = new google.maps.Marker({
						position: pos,
						map: map,
						title: "Rennes"
					});

		        // Fin du else
		        <?php }?>
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
				<p>Retrouvez la liste des lignes disponibles à votre arrêt</p>
				<form method="get" action="lignes.php">
				<p><label>Votre arrêt</label>
				<select name="arret" onchange="this.form.submit();">
				
				<?php 
					header('Content-Type: text/html;charset=utf-8');
					if (isset($_GET["arret"])) { // Conserve l'information déjà entré
							include("../connection.php");
							
							/*******************
							* Memoire du Choix
							********************/
							$nom = urldecode($_GET["arret"]);
							$query = "SELECT `stop_name` FROM `stops` WHERE stop_name ='".urldecode($_GET["arret"])."';";
					        $result = mysqli_query($conn, $query);

					        $row = mysqli_fetch_assoc($result); // récupère une ligne de résultat sous forme de tableau associatif
							
							echo '<option value=' . ($row["stop_name"]) . '>' . $row["stop_name"] . '</option>';
			
							
							/*******************
							* Reste de la liste
							********************/
							$query = "SELECT DISTINCT `stop_name`, `stop_id` FROM `stops` GROUP BY `stop_name` ORDER BY `stop_name` ASC";
					        $result = mysqli_query($conn, $query);

					        while ($row = mysqli_fetch_assoc($result)) {

					            echo '<option value=' . urlencode($row['stop_name']) . '>' . $row["stop_name"] . '</option>';
					        }


							include("../deconnection.php");

					}else{ // Affichage des arrets
						echo '<option value="null"></option>';
						include("../connection.php");
				        $query = "SELECT DISTINCT `stop_name`,`stop_id` FROM `stops` GROUP BY `stop_name` ORDER BY `stop_name` ASC";
				        $result = mysqli_query($conn, $query);

				        while ($row = mysqli_fetch_assoc($result)) {

				            echo '<option value=' . urlencode($row["stop_name"]) . '>' . $row["stop_name"] . '</option>';
				        }
				        include("../deconnection.php");
					}
				?>

				</select></p>
			</form>
			<?php
			if (isset($_GET["arret"])) {
				include("../connection.php");


				$query = "SELECT DISTINCT route_short_name, route_long_name FROM stops JOIN stop_times ON stop_times.stop_id = stops.stop_id JOIN trips ON stop_times.trip_id = trips.trip_id JOIN routes ON trips.route_id = routes.route_id WHERE stop_name='".urldecode($_GET["arret"])."' GROUP BY routes.route_id ORDER BY routes.route_id";
		        $result = mysqli_query($conn, $query);
		        echo '<p>Les lignes disponibles aux alentours de : '.urldecode($_GET["arret"]).'</p>';
		        echo '<p>';
		        while ($row = mysqli_fetch_assoc($result)) {
					echo $row["route_short_name"]. ' - ' . $row["route_long_name"] . '<br>' ;

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
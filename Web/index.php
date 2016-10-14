<html>
<head>
	<title>Transport de Rennes-</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" href="foundation-5.5.1/css/foundation.css" />
	<link rel="stylesheet" href="style.css" />

</head>
<body>
	<div class="row">
		<div class="large-12 columns">
			<img id="top" src="images/bus3.jpg">
		</div>
	</div>

	<div class="row">
		<div class="large-12 columns">  	  
			<nav class="top-bar" data-topbar role="navigation">
				<ul class="title-area">
					<li class="name">
					  <h1><a href="index.php">Réseau de transport de Rennes - Horaires</a></h1>
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
				<form method="get" action="pages/horaires.php">
				<p>Consulter les horaires</p>
				<p>Par ligne :</p>
				<p><label>Ligne</label>
				<select name="numeroLigne" id="ligneSelect">
				<option value="null"></option>

		        <?php
		        	header('Content-Type: text/html;charset=utf-8');
			        include("connection.php");
			        $query = "SELECT route_long_name, route_short_name, route_id FROM routes;";
			        $result = mysqli_query($conn, $query);

			        while ($row = mysqli_fetch_assoc($result)) { // récupère une ligne de résultat sous forme de tableau associatif

			            echo '<option value="' . $row["route_id"] . '">' . $row["route_short_name"] . ' - ' . $row["route_long_name"] . '</option>';
			        }
			        include("deconnection.php");
		        ?>

				</select></p>

				<p><label>Arrêt</label>
				<select name="nomArret" id="arretSelect">
				<option value="null"></option>
				
				
				</select></p>

				<p><label>Direction</label>
				<select name="direction_id" id="directionSelect">
				<option value="null"></option>

				

				</select></p>
				<p><input class="button tiny" type="submit" value="OK"></p>
				</form>
			





				<form method="get" action="pages/horaires.php">
					<p>Par arrêt :</p>
					<p><label>Arrêt</label>
				    <select name="nomArret" id="arretSelect2">
				        <option value="null"></option>
				        <?php
				        include("connection.php");
				        $query="SELECT DISTINCT stop_name
				                FROM stops
				                ORDER BY stop_name ASC;";
				        $result = mysqli_query($conn, $query);

				        while($row = mysqli_fetch_assoc($result)) {
				            echo '<option value="'.$row['stop_name'].'">'.$row['stop_name'].'</option>';
				        }
				        include("deconnection.php")
				        ?>
				    </select></p>

				    <p><label>Ligne</label></p>
				    <select name="numeroLigne" id="ligneSelect2">
				        <option value="null"></option>
				    </select>

				    <p><label>Direction</label></p>
				    <select name="direction_id" id="directionSelect2">
				        <option value="null"></option>
				    </select>

				    <p><input class="button tiny" type="submit" value="OK"></p>

				</form>
			</div>
		
		</div>


		<div class="large-4 medium-4 columns">
			</br></br>
            <div class="panel">
            <h5 style="text-align:center;">Différents types de recherches</h5>
            <p style="text-align:center;">
                <a href="pages/lignes.php" class="button">Voir les lignes</a><br/>
                <a href="pages/arrets.php" class="button success">Voir les arrêts</a><br/>
                <a href="pages/itineraire.php" class="button black">Itinéraire simple</a></br>
                <a href="index.php" class="button rouge">Voir les horaires</a></br>
            </p>   
            </div>

			<div class="panel">
				<h5>Infos réseau</h5>
				<ul>
					<li><img src="images/bus-de-stade_02.jpg"> Bus de stade</li>
					<li><img src="images/co2b.png"> CO2</li>
					<li><img src="images/lignes-scolaires.gif"> Lignes scolaires</li>
					<li><img src="images/Twitter-star.gif"> Suivez le star sur twitter</li>
				</ul>          
			</div>
		</div>
	</div>


    <script src="js/jquery-2.1.3.min.js"></script>
    <script src="js/script.js"></script>
    <script src="js/script2.js"></script>
	<script src="foundation-5.5.1/js/vendor/modernizr.js"></script>
	<script src="foundation-5.5.1/js/vendor/jquery.js"></script>
	<script src="foundation-5.5.1/js/foundation/foundation.js"></script>
  	<script src="foundation-5.5.1/js/foundation/foundation.topbar.js"></script>
  	<script>
    $(document).foundation();
  </script>
</body>
</html>
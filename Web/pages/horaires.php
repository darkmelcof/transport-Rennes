<html>
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

    <?php
    header('Content-Type: text/html;charset=utf-8');
    /************************************************************************************
    * 3 conditions importantes au cas où l'utilisateur clique trop vite sur la validation
    *************************************************************************************/
    if ($_GET["numeroLigne"]=="null" || !isset($_GET["nomArret"]) || $_GET["direction_id"]=="null") {
        echo '<div class="row">
                </br></br>
                <div class="large-8 medium-8 columns">
                    <div class="panel">';
        echo '<h3>Erreur formulaire</h3>';
        echo '<a href="../index.php">Retour au formulaire</a>';
        echo "</div></div>";
    }else{
        include("../connection.php");

        $query="SELECT trips.trip_headsign, stop_times.arrival_time, stop_times.departure_time, trips.service_id, stop_times.stop_id, stop_times.stop_sequence, calendar.*, trips.trip_id
                FROM stop_times
                  JOIN trips
                    ON stop_times.trip_id = trips.trip_id
                  JOIN calendar
                    ON trips.service_id = calendar.service_id
                  JOIN stops
                    ON stop_times.stop_id = stops.stop_id
                WHERE trips.route_id='".$_GET['numeroLigne']."' AND trips.direction_id='".$_GET['direction_id']."' AND stops.stop_name='".urldecode($_GET['nomArret'])."'
                ORDER BY calendar.monday DESC, calendar.tuesday DESC, calendar.wednesday DESC, calendar.thursday DESC,
                calendar.friday DESC, calendar.saturday DESC, calendar.sunday DESC, stop_times.arrival_time;";

        $result = mysqli_query($conn, $query);

        /**
         * @param $row
         * @return string, the day for the row
         */
        function dayOfRow($row) {
            if ($row['monday'])     return 'Lundi';
            if ($row['tuesday'])    return 'Mardi';
            if ($row['wednesday'])  return 'Mercredi';
            if ($row['thursday'])   return 'Jeudi';
            if ($row['friday'])     return 'Vendredi';
            if ($row['saturday'])   return 'Samedi';
            if ($row['sunday'])     return 'Dimanche';
        }

        /**
         * @param $row, MYSQL row
         * @param $day, monday | tuesday ...
         * @return bool, true if day is different of the row day
         */
        function dayChange($row, $day) {
            return dayOfRow($row) != $day;
        }

        $day = null;

        echo '<div class="row">
                </br></br>
                <div class="large-8 medium-8 columns">
                    <div class="panel">';
        echo '<p>Ligne : '.$_GET['numeroLigne'].'</p>';
        echo '<p>Arrêt : '.$_GET['nomArret'].'</p>';

        while($row = mysqli_fetch_assoc($result)) { // parcourt les lignes de resultats de la requete
            if ($day == null) {
                echo '<p>Direction : '.$row['trip_headsign'].'</p></div>';
                echo '<div class="panel" id="scroll">';
            }
            
            if(dayChange($row, $day))  { // si le jour change on fait ...

                if($day != null) {
                    echo '</table>';
                }
                $day = dayOfRow($row);
                echo $day;
                echo '<table>';
                echo '<tr>';
            }
            // on ecrit l'horaire de la row
            echo "<td>". date('H:i',strtotime($row['departure_time'])) ."</td>"; // formatte l'heure
        }
        echo '</table></div></div>';

        include("../deconnection.php");
        }
    ?>
    
        <div class="large-4 medium-4 columns">
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
</body>
</html>
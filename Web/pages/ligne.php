<?php
header('Content-Type: appplication/json;charset=utf-8'); // Dit au navigateur qu'on renvoie du json
include("../connection.php");

$query="SELECT DISTINCT routes.route_id, routes.route_long_name,stops.stop_name
        FROM stops
          JOIN stop_times
            ON stops.stop_id = stop_times.stop_id
          JOIN trips
            ON stop_times.trip_id = trips.trip_id
          JOIN routes
            ON trips.route_id = routes.route_id
        WHERE stops.stop_name = \"".$_GET['nomArret']."\"
        ORDER BY route_long_name ASC;"; // $_GET recupère le numeroLigne qui se trouve dans l'URL

$result = mysqli_query($conn, $query);
$resultat = array();

while($row = mysqli_fetch_assoc($result)) {
    $resultat[$row['route_id']] = $row['route_long_name']; // Associe la direction au trip_headsign
}

// Vérifie s'il transforme le tableau en objet javascript
if(json_encode($resultat)) {
    echo json_encode($resultat); // Transforme le tableau associatif en json et on le renvoie au navigateur, on l'affiche
} else {
    echo "KO";
    echo json_last_error_msg();
}

include("../deconnection.php")
?>
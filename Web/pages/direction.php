<?php
header('Content-Type: appplication/json;charset=utf-8'); // Dit au navigateur qu'on renvoie du json
include("../connection.php");

$query="SELECT DISTINCT trips.trip_headsign, stops.stop_name,trips.route_id, trips.trip_id,trips.direction_id
FROM trips
JOIN stop_times
ON trips.trip_id = stop_times.trip_id
JOIN stops
ON stop_times.stop_id = stops.stop_id
WHERE stops.stop_name = '".urldecode($_GET['nomArret'])."' AND trips.route_id=".$_GET['numeroLigne'].";"; // $_GET recupère le numeroLigne qui se trouve dans l'URL
$result = mysqli_query($conn, $query);
$resultat = array();

while($row = mysqli_fetch_assoc($result)) {
    $resultat[$row['direction_id']] = $row['trip_headsign']; // Associe la direction au trip_headsign
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

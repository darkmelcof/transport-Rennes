<?php
header('Content-Type: application/json;charset=utf-8');
include("../connection.php");

$query = " SELECT DISTINCT stops.stop_name
          FROM stops
            JOIN stop_times
              ON stops.stop_id = stop_times.stop_id
            JOIN trips
              ON stop_times.trip_id = trips.trip_id
            JOIN routes
              ON trips.route_id = routes.route_id
          WHERE trips.route_id=".$_GET['numeroLigne'].";";
$result = mysqli_query($conn, $query);
$resultat = array(); // Tableau

while($row = mysqli_fetch_assoc($result)) { // Parcourt le résultat de la requête
    $resultat[] = $row['stop_name']; // Remplie le tableau de résultat avec le nom des arrêts
}
// Verifie s'il transforme le tableau en objet javascript
if(json_encode($resultat)) {
    echo json_encode($resultat); // Transforme le tableau associatif en json ( JavaScript Object Notation )
}else {
    echo "KO";
    echo json_last_error_msg();
}
include("../deconnection.php");
?>

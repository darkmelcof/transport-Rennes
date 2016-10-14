<?php
header('Content-Type: appplication/json;charset=utf-8');
include("../connection.php");

$query="SELECT DISTINCT stops.stop_name, trips.route_id
        FROM stops
        JOIN stop_times
        ON stops.stop_id = stop_times.stop_id
        JOIN trips
        ON stop_times.trip_id = trips.trip_id
        WHERE trips.route_id='".$_GET['numeroLigne']."' AND stops.stop_name<> \"".$_GET['nomArret']."\"
        ORDER BY stops.stop_name ASC;";

$result = mysqli_query($conn, $query);
$resultat = array();

while($row = mysqli_fetch_assoc($result)) {
    $resultat[] = $row['stop_name'];
}


if(json_encode($resultat)) {
    echo json_encode($resultat);
} else {
    echo "KO";
    echo json_last_error_msg();
}

include("../deconnection.php");
?>
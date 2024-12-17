<?php
require 'functions.php';
$bdd = dbconnect();
session_start();

$heuresortie = date("H:i:s", strtotime('+2 hours'));
$date = date("Y-m-d");
$query2 = "UPDATE visitors SET heuresortie = :heuresortie, date = :date WHERE id = :id";
$result2 = $bdd->prepare($query2);

$tabID = getID();

foreach ($tabID as $id) {
    $result2->execute([':heuresortie' => $heuresortie, ':date' => $date, ':id' => $id]);
}

$query = "DELETE FROM visitorsmuseum";
$result = $bdd->prepare($query);
$result->execute();

$_SESSION['message'] = "<script>const popup = Notification();popup.success({title: 'Succès',message: 'Musée fermé avec succès.',});</script>";
header("Location: ../dashboard.php");
exit();
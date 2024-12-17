<?php
    require 'functions.php';
    if (isset($_POST['id'])) {
        $id = $_POST['id'];

        $bdd = dbconnect();
        $query = "DELETE FROM visitorsmuseum WHERE visitor_id = :id";
        $result = $bdd->prepare($query);
        $result->execute(['id' => $id]);

        $heuresortie = date("H:i:s", strtotime('+2 hours'));
        $query2 = "UPDATE visitors SET heuresortie = :heuresortie WHERE id = :id";
        $result2 = $bdd->prepare($query2);
        $result2->execute(['heuresortie' => $heuresortie, 'id' => $id]);
    }

    header('Location: ../visitors.php');
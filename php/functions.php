<?php
function dbconnect () {
    try {
        $bdd = new PDO('mysql:host=localhost; dbname=MUSEE; charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        return $bdd;
    } catch (Exception $e) {
        $_SESSION['error'] = 'Erreur de connexion à la base de données : ' . $e->getMessage();
        exit();
    }
}

function getID() : array {
    $bdd = dbconnect();
    $query = "SELECT visitor_id FROM visitorsmuseum";
    $result = $bdd->query($query);

    $tabID = [];

    foreach ($result as $row) {
        $tabID[] = $row['visitor_id'];
    }

    return $tabID;
}

function compteur() {
    $bdd = dbconnect();
    $query = "SELECT COUNT(DISTINCT visitor_id) AS total_rows FROM visitorsmuseum";
    $result = $bdd->query($query);
    $count = $result->fetchColumn() . "/50";
    return $count; 
}

function expo() {
    $bdd = dbconnect();
    $querry = "SELECT * FROM typeacces";
    $result = $bdd->prepare($querry);
    $result->execute();
    return $result->fetchAll();
}

function getExpo() {
    $bdd = dbconnect();
    $query = "SELECT id, exposition FROM expositions";
    $result2 = $bdd->prepare($query);
    $result2->execute();
    return $result2->fetchAll();
}

function getVisitors() {
    $bdd = dbconnect();
    $querry = "SELECT * FROM visitors ORDER BY id DESC";
    $result = $bdd->query($querry);
    return $result->fetchAll();
}

function getVisitorsMuseum() {
    $bdd = dbconnect();
    $querry = "SELECT * FROM visitors WHERE heuresortie IS NULL ORDER BY id DESC";
    $result = $bdd->query($querry);
    return $result->fetchAll();
}

function statSexe() {
    $bdd = dbconnect();
    $query = "SELECT sexe, COUNT(*) as total FROM visitors WHERE heuresortie IS NULL GROUP BY sexe";
    $result = $bdd->query($query);
    $result->execute();
    $result = $result->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

function statExpo() {
    $bdd = dbconnect();
    $querry = "SELECT exposition, COUNT(*) as total FROM visitors WHERE heuresortie IS NULL GROUP BY exposition";
    $result2 = $bdd->query($querry);
    $result2->execute();
    $result2 = $result2->fetchAll(PDO::FETCH_ASSOC);
    return $result2;
}

function statAge() {
    $bdd = dbconnect();
    $querry2 = "SELECT 
                    age_group,
                    COUNT(*) as total 
                FROM 
                    (SELECT 
                        CASE
                            WHEN age < 25 THEN '-25'
                            WHEN age BETWEEN 25 AND 39 THEN '25-39'
                            WHEN age BETWEEN 40 AND 59 THEN '40-59'
                            WHEN age BETWEEN 60 AND 69 THEN '60-69'
                            ELSE '70+'
                        END AS age_group
                    FROM 
                        visitors
                    WHERE
                        heuresortie IS NULL) AS subquery
                GROUP BY 
                    age_group
                ORDER BY
                    CASE
                        WHEN age_group = '-25' THEN 1
                        WHEN age_group = '25-39' THEN 2
                        WHEN age_group = '40-59' THEN 3
                        WHEN age_group = '60-69' THEN 4
                        ELSE 5
                    END";
    $result3 = $bdd->query($querry2);
    $result3->execute();
    $result3 = $result3->fetchAll(PDO::FETCH_ASSOC);
    return $result3;
}

function getExpoId() {
    $bdd = dbconnect();
    $querry = "SELECT * FROM expositions";
    $result3 = $bdd->prepare($querry);
    $result3->execute();
    foreach ($result3 as $row3) {
        $exposition_id = $row3['id'];
    }
    return $exposition_id;
}
function calculerTempsMoyenParExposition() {
    $bdd = dbconnect();
    $sql = "SELECT exposition, AVG(TIME_TO_SEC(TIMEDIFF(heuresortie, heurearrive))) AS temps_moyen FROM visitors GROUP BY exposition";
    $result = $bdd->query($sql);
    $tempsMoyenParExposition = array();
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $tempsMoyenParExposition[$row['exposition']] = $row['temps_moyen'];
    }
    return $tempsMoyenParExposition;
}

function compterVisiteursParHeure() {
    $bdd = dbconnect();
    $query = "SELECT HOUR(heurearrive) AS heure, COUNT(*) AS total_visiteurs FROM visitors WHERE heuresortie IS NULL GROUP BY HOUR(heurearrive)";
    $result = $bdd->query($query);
    return $result->fetchAll(PDO::FETCH_ASSOC);
}



function statSexeDate($start, $end) {
    $bdd = dbconnect();
    $query = "SELECT sexe, COUNT(*) as total FROM visitors WHERE date BETWEEN :start AND :end GROUP BY sexe";
    $stmt = $bdd->prepare($query);
    $stmt->bindParam(':start', $start);
    $stmt->bindParam(':end', $end);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}


function statExpoDate($start, $end) {
    $bdd = dbconnect();
    $query = "SELECT exposition, COUNT(*) as total 
              FROM visitors 
              WHERE date BETWEEN :start AND :end 
              GROUP BY exposition";
    $stmt = $bdd->prepare($query);
    $stmt->bindParam(':start', $start);
    $stmt->bindParam(':end', $end);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}


function statAgeDate($start, $end) {
    $bdd = dbconnect();
    $query = "SELECT 
                    age_group,
                    COUNT(*) as total 
              FROM 
                    (SELECT 
                        CASE
                            WHEN age < 25 THEN '-25'
                            WHEN age BETWEEN 25 AND 39 THEN '25-39'
                            WHEN age BETWEEN 40 AND 59 THEN '40-59'
                            WHEN age BETWEEN 60 AND 69 THEN '60-69'
                            ELSE '70+'
                        END AS age_group
                    FROM 
                        visitors
                    WHERE
                        date BETWEEN :start AND :end
                    ) AS subquery
              GROUP BY 
                    age_group
              ORDER BY
                    CASE
                        WHEN age_group = '-25' THEN 1
                        WHEN age_group = '25-39' THEN 2
                        WHEN age_group = '40-59' THEN 3
                        WHEN age_group = '60-69' THEN 4
                        ELSE 5
                    END";
    $stmt = $bdd->prepare($query);
    $stmt->bindParam(':start', $start);
    $stmt->bindParam(':end', $end);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

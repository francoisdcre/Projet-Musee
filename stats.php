<?php
    require 'php/functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques</title>
    <link rel="shortcut icon" href="img/logomusee.png"/>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/font.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link href="css/notification.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <?php
        if (isset($_POST['start']) && isset($_POST['end'])) {
            $start = $_POST['start'];
            $end = $_POST['end'];

            $bdd = dbconnect();
            $result = statSexeDate($start, $end);
            $labels = [];
            $values = [];
            foreach ($result as $row) {
                $labels[] = $row['sexe'];
                $values[] = $row['total'];
            }
    
            $result2 = statExpoDate($start, $end);
    
            $labels2 = [];
            $values2 = [];
            foreach ($result2 as $row) {
                $labels2[] = $row['exposition'];
                $values2[] = $row['total'];
            }
    
            $result3 = statAgeDate($start, $end);
            $labels3 = [];
            $values3 = [];
            foreach ($result3 as $row) {
                $labels3[] = $row['age_group'];
                $values3[] = $row['total'];
            }
            
        }

        $tempsMoyenParExposition = calculerTempsMoyenParExposition();

        // Préparer les données pour le graphique
        $labels = array_keys($tempsMoyenParExposition);
        $data = array_values($tempsMoyenParExposition);
    ?>
    <nav>
        <?php
            session_start();
            if (isset($_SESSION['username'])) {
                echo "<h1>Connecté en tant que : " . $_SESSION['username'] . "</h1><br>";
                echo "<img src='img/p2p.png' alt='Photo de profil de Vendeur'>";
                echo "<a href='dashboard.php'>Dashboard</a>";
                echo "<a href='php/logout.php'>Se déconnecter</a>";
                echo "<script src='./js/notification.js'></script>";
            } else {
                echo "<p>Vous n'êtes pas connecté.</p>";
                echo "<a href='index.php'>Se connecter</a>";
            }
        ?>
    </nav>
    <section id="stats">
        <h1>Statistiques</h1>
        <form action="stats.php" method="post">
            <label for="start">Début :</label>
                <input type="date" id="start" name="start">
                <label for="end">Fin :</label>
                <input type="date" id="end" name="end">
                <input type="submit" value="Valider">
        </form>
        <div class="stat">
            <div class="statTop">
                <div class="statLeft">
                    <canvas id="myChart" width="400" height="400"></canvas>
                </div>
                <div class="statRight">
                    <canvas id="myChart2" width="400" height="400"></canvas>
                </div>
            </div>
            <div class="statBottom">
                <canvas id="myChart3" width="900" height="400"></canvas>
            </div>
        </div>
    </section>
    <script>
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Homme', 'Femme'],
                datasets: [{
                    label: 'Nombre par sexe',
                    data: <?php echo json_encode($values); ?>,
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.5)', // Blue for Homme
                        'rgba(255, 99, 132, 0.5)', // Pink for Femme
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 99, 132, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                // Vos options de chart ici
            }
        });


        var ctx = document.getElementById('myChart2').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode($labels2); ?>,
                datasets: [{
                    label: 'Nombre de visiteurs par exposition',
                    data: <?php echo json_encode($values2); ?>,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.5)',
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(255, 170, 147, 0.5)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 151, 147, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                // Vos options de chart ici
            }
        });
        var ctx = document.getElementById('myChart3').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($labels3); ?>,
                datasets: [{
                    label: 'Nombre de visiteurs par tranche d\'âge',
                    data: <?php echo json_encode($values3); ?>,
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(255, 99, 132, 0.5)',
                        'rgba(255, 170, 147, 0.5)',
                        'rgba(255, 255, 112, 0.5)',
                        'rgba(169, 0, 255, 0.5)',
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(255, 151, 147, 1)',
                        'rgba(255, 255, 112, 1)',
                        'rgba(169, 0, 255, 1)',
                    ],
                    borderWidth: 1,
                    borderRadius: 20
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>
</body>
</html>
<?php
    $bdd = null;
?>
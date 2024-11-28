<?php
include "includes/header.php";
?>

<head>
    <meta charset="UTF-8">
    <title>Mon Calendrier de Congés</title>
    <link rel="stylesheet" href="styles/calendrier.css">
    <script>
        // maj dynamique du calendrier
        function majCalendrier() {
            const year = document.getElementById('year').value;
            const month = document.getElementById('month').value;
            window.location.href = `?year=${year}&month=${month}`;
        }

        //affiche le contenu sélectionné
        function afficheSelection(date, isHoliday) {
            //si c'est un jour ferié,  alors on affiche rien et on met un ptit message d'erreur
            if (isHoliday) {
                alert("Attention : La date sélectionnée est un samedi, un dimanche ou un jour férié !");
                document.getElementById('demi-journees-buttons').style.display = 'none';
                document.getElementById('selection-zone').style.display = 'none';
                //retourne rien pour pas à exécuter les lignes en dessous
                return;
            }
            //sinon affiche l'affichage normal pour sélectionner un congé
            document.getElementById('selected-date').innerText = `Date sélectionnée : ${date}`;
            document.getElementById('button-demi-journee-conge').style.display = 'flex';
            document.getElementById('selection-zone').style.display = 'block';
            document.getElementById('demi-journees-buttons').style.display = 'none';
        }

        // Affiche les boutons matinée et après-midi et supprime le bouton "prendre une demi-journée de congé" 
        function afficheDemIJourneesButton() {
            document.getElementById('button-demi-journee-conge').style.display = 'none';
            document.getElementById('demi-journees-buttons').style.display = 'flex';
        }
    </script>
</head>

<body>

    <h1>Mon Calendrier</h1>
    <h4>Demande de congés</h4>

    <!-- form de sélection de l'année et du mois -->
    <form>
        <label for="year">Année :</label>
        <select name="year" id="year" onchange="majCalendrier()">
            <?php
            $currentYear = date('Y');
            $selectedYear = isset($_GET['year']) ? $_GET['year'] : $currentYear;

            for ($year = $currentYear; $year <= $currentYear + 2; $year++) {
                $selected = ($selectedYear == $year) ? 'selected' : '';
                echo "<option value='$year' $selected>$year</option>";
            }
            ?>
        </select>

        <label for="month">Mois :</label>
        <select name="month" id="month" onchange="majCalendrier()">
            <?php
            $currentMonth = date('n');
            $selectedMonth = isset($_GET['month']) ? $_GET['month'] : $currentMonth;
            $months = [
                1 => 'Janvier',
                2 => 'Février',
                3 => 'Mars',
                4 => 'Avril',
                5 => 'Mai',
                6 => 'Juin',
                7 => 'Juillet',
                8 => 'Août',
                9 => 'Septembre',
                10 => 'Octobre',
                11 => 'Novembre',
                12 => 'Décembre'
            ];

            foreach ($months as $num => $name) {
                $selected = ($selectedMonth == $num) ? 'selected' : '';
                echo "<option value='$num' $selected>$name</option>";
            }
            ?>
        </select>
    </form>

    <?php
    function listeFeries($year)
    {
        return [
            //Liste de tous les jours feriés
            "$year-01-01",
            date('Y-m-d', strtotime("easter $year")), // Pâques "easter" = constante de la date de pâques
            date('Y-m-d', strtotime("easter $year + 1 day")), // Lundi de Pâques, pas de constante php proposée pour cette date, donc on se base sur la constante de pâques
            "$year-05-01",
            "$year-05-08",
            date('Y-m-d', strtotime("easter $year + 39 days")), // Ascension
            date('Y-m-d', strtotime("easter $year + 50 days")), // Pentecôte
            "$year-07-14",
            "$year-08-15",
            "$year-11-01",
            "$year-11-11",
            "$year-12-25"
        ];
    }
    //fonction appelée plus bas pour générer le calendrier avec la date et l'année sélectionnée par l'utilisateur
    function genereCalendrier($year, $month)
    {
        $daysOfWeek = ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'];
        $firstDayOfMonth = strtotime("$year-$month-01");
        $totalDays = date('t', $firstDayOfMonth);
        $firstDayOfWeek = date('N', $firstDayOfMonth);
        //appelle la fonction définie au dessus
        $vacances = listeFeries($year);

        echo "<div class='month'>";
        //affiche le mois et l'année sélectionnée
        echo "<h2>" . date('F Y', $firstDayOfMonth) . "</h2>";
        //début de la balise de création du calendrier
        echo "<div class='calendar'>";

        // affiche  les jours de la semaine
        foreach ($daysOfWeek as $day) {
            echo "<div class='day'>$day</div>";
        }
        // permet d'aligner les premiers jours
        for ($i = 1; $i < $firstDayOfWeek; $i++) {
            echo "<div class='day empty'></div>";
        }
        // affiche les jours
        for ($day = 1; $day <= $totalDays; $day++) {
            $date = "$year-$month-" . str_pad($day, 2, '0', STR_PAD_LEFT);
            $isWeekend = (date('N', strtotime($date)) >= 6);
            $isHoliday = in_array($date, $vacances) || $isWeekend;
            $class = $isHoliday ? 'day holiday' : 'day';
            echo "<div class='$class' onclick='afficheSelection(\"$date\", " . ($isHoliday ? 'true' : 'false') . ")'>$day</div>";
        }
        //fin des div qui sont en haut
        echo "</div></div>";
    }
    // récupère le mois et l'année sélectionnées, sinon met la date actuelle
    $year = isset($_GET['year']) ? $_GET['year'] : $currentYear;
    $month = isset($_GET['month']) ? str_pad($_GET['month'], 2, '0', STR_PAD_LEFT) : str_pad($currentMonth, 2, '0', STR_PAD_LEFT);

    //génère le calendrier à partir des données créées au dessus.
    genereCalendrier($year, $month);
    ?>



    <!-- Zone de sélection avec boutons -->
    <div id="selection-zone" class="selection-zone" style="display: none;">
        <p id="selected-date">Date sélectionnée : </p>
        <div class="buttons">
            <button onclick="alert('Demande de congé envoyée pour ' + document.getElementById('selected-date').innerText)">Prendre une journée de congé</button>
            <button id="button-demi-journee-conge" onclick="afficheDemIJourneesButton()">Prendre une demi-journée de congé</button>
        </div>
        <!-- zone des boutons de matinée et après-midi -->
        <div id="demi-journees-buttons" class="buttons" style="display: none;">
            <button onclick="alert(document.getElementById('selected-date').innerText + ', demande de congé pour la matinée.')">Matinée (8h-12h)</button>
            <button onclick="alert(document.getElementById('selected-date').innerText + ', demande de congé pour l\'après-midi.')">Après-midi (13h30-16h30)</button>
        </div>
    </div>
    <?php
    include 'includes/footer.php';
    ?>
<?php

include 'includes/header.php';
?>

<head>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }

        .header {
            background-color: #4CAF50;
            color: white;
            padding: 20px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 2.5em;
        }

        .header p {
            margin: 5px 0 0;
            font-size: 1.2em;
        }

        .nav {
            display: flex;
            justify-content: center;
            background-color: #333;
            padding: 10px 0;
        }

        .nav a {
            color: white;
            padding: 14px 20px;
            text-decoration: none;
            text-align: center;
        }

        .nav a:hover {
            background-color: #4CAF50;
            color: white;
        }

        .main-content {
            padding: 20px;
            text-align: center;
        }

        .main-content h2 {
            font-size: 2em;
            color: #4CAF50;
        }

        .features {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .feature {
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin: 10px;
            width: 300px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .feature h3 {
            color: #4CAF50;
            font-size: 1.5em;
        }

        .feature p {
            font-size: 1em;
            color: #666;
        }

        .footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px 0;
            position: absolute;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Bienvenue sur Gérico</h1>
        <p>La solution complète pour la gestion de vos transports</p>
    </div>

    <div class="main-content">
        <h2>Optimisez votre logistique dès aujourd'hui</h2>
        <p>Gérez efficacement vos véhicules, vos chauffeurs et vos itinéraires grâce à notre plateforme intuitive.</p>

        <div class="features">
            <div class="feature">
                <h3>Suivi des Véhicules</h3>
                <p>Gardez un œil sur votre flotte en temps réel avec notre outil de géolocalisation avancé.</p>
            </div>
            <div class="feature">
                <h3>Gestion des Chauffeurs</h3>
                <p>Attribuez facilement des missions à vos chauffeurs et suivez leurs performances.</p>
            </div>
            <div class="feature">
                <h3>Optimisation des Itinéraires</h3>
                <p>Réduisez les coûts et les délais grâce à notre planificateur d'itinéraires intelligent.</p>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>&copy; 2024 Gérico. Tous droits réservés.</p>
    </div>
</body>

</html>



<?php

include 'includes/footer.php';
?>
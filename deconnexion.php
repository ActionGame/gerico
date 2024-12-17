<?php
session_start();
session_unset(); // supprime toutes les variables de sessions
session_destroy(); // fin de la session
header('Location: connexion.php'); // redirection
exit;

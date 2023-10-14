<?php
/* Anmeldeinformationen für die MySQL Datenbank */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'f1dbch');
define('DB_PASSWORD', '%%)hN!L&b9OQ');
define('DB_NAME', 'f1db');
 
/* Mit den oben genannten Daten auf die MySQL Datenbank verbinden */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Verbindung überprüfen -> Bei Fehler erscheint eine Fehlermeldung
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>
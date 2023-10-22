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

$nationalityToCountryCode = array(
    "American" => "US",
    "Canadian" => "CA",
    "British" => "GB",
    "French" => "FR",
    "German" => "DE",
    "Italian" => "IT",
    "Australian" => "AU",
    "Japanese" => "JP",
    "Chinese" => "CN",
    "Indian" => "IN",
    "Dutch" => "NL",
    "Mexican" => "MX",
    "Spanish" => "ES",
    "Austrian" => "AT",
    "Swiss" => "CH",
    "Monegasque" => "MC",
    "Thai" => "TH",
    "Danish" => "DK",
    "New Zealander" => "NZ",
    "Finnish" => "FI",
    "Brazilian" => "BR",
    "South African" => "ZA",
    "Argentine" => "AR",
    "Polish" => "PL",
    "Russian" => "RU",
    "Belgian" => "BE",
    "Swedish" => "SE",
    "Venezuelan" => "VE",
    "Hong Kong" => "HK",
    "Colombian" => "CO",
    "Chilean" => "CL",
    "Malaysian" => "MY",
    "Indonesian" => "ID",
    "Portuguese" => "PT",
    "Irish" => "IE",
    "Hungarian" => "HU",
    "Rhodesian" => "ZW",
    "East German" => "DE",
    "Czech" => "CZ",
    "Liechtensteiner" => "LI"
);
?>
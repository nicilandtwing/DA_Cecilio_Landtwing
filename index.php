<!doctype html>
<html lang="de">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Formula 1 DB</title>
  <link rel="icon" type="image/x-icon" href="/images/favicon.png">
  <!-- Eigenes Stylesheet -->
  <link href="css/style.css" rel="stylesheet">
  <!-- Bootstrap Stylesheet -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <!-- Datenbankzugriff -->
  <?php
                require_once "php/config.php";
    ?>
</head>

<body>
  <!-- Navigationsleiste oben -->
  <nav class="navbar navbar-dark bg-dark navbar-expand-md">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">
        <img src="images/Logo.png" alt="Formula 1 DB Logo" width="200px" />
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="season-list.php">Saisons</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="race.php">Rennen</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="drivers.php">Fahrer</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="teams.php">Teams</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Startseiten-Banner mit Logo -->
  <section id="random-image" class="d-flex flex-column justify-content-center align-items-center container-fluid">
    <h1 id="welcome-text">Willkommen bei</h1>
    <img id="welcome-text-logo" src="images/Logo.png" alt="Formula 1 DB Logo">
    <!-- Javascript, damit jedes Mal ein anderes Bild erscheint -->
    <script src="js/randombackground.js"></script>
  </section>
  <br>

  <!-- Tabellen -->
  <section id="every-season" class="container">

    <div class="row">
      <div class="col-lg-7 col-md-10 col-sm-12">
        <h1>Letztes Rennergebnis</h1>
        <?php
                  /* SQL Abfrage in Variabel speichern */
                  $latest_race_sql = "SELECT * FROM v_latest_race";

                  /* Überprüfen, ob Datenbank das SQL ausführen kann */
                  if($latest_race_result = mysqli_query($link, $latest_race_sql)){
                    
                    /* Falls das Resultat mehr als 0 Reihen zurückgibt */
                    if(mysqli_num_rows($latest_race_result) > 0){

                      /* Resultat des Select Befehles ausgeben und auf der Webseite mit Echo darstellen */
                      while($latest_race_row = mysqli_fetch_array($latest_race_result)){
                        echo '<p> Das letzte Rennen war der <strong>' . $latest_race_row['year'] . ' ' . $latest_race_row['race_name'] . '</strong> auf der Strecke <strong>' . $latest_race_row['circuit_name'] . '</strong> in <strong>' . $latest_race_row['circuit_location'] . '.</strong></p>';
                      }
                    }
                  }
                ?>

        <?php
                  /* SQL Abfrage in Variabel speichern */
                   $latest_race_result_sql = "SELECT * FROM v_latest_race_result";

                   /* Überprüfen, ob Datenbank das SQL ausführen kann */
                   if($latest_race_result_result = mysqli_query($link, $latest_race_result_sql)){

                    /* Falls das Resultat mehr als 0 Reihen zurückgibt */
                   if(mysqli_num_rows($latest_race_result_result) > 0){
                       
                      /* Tabellen Kopfzeile erstellen */
                       echo '<table class="table table-striped table-hover table-responsive">';
                           echo "<thead>";
                               echo "<tr>";
                                   echo "<th>Pos.</th>";
                                   echo "<th>Fahrer</th>";
                                   echo "<th>Team</th>";
                                   echo "<th>Rennzeit</th>";
                                   echo "<th>Status</th>";
                               echo "</tr>";
                           echo "</thead>";
                           echo "<tbody>";

                           /* Für jede Reihe eine Tabellenreihe erstellen (Loop) */
                           while($latest_race_result_row = mysqli_fetch_array($latest_race_result_result)){
                               echo "<tr>";
                                   echo "<td>" . $latest_race_result_row['position'] . "</td>";
                                   echo "<td class='modalcell' onclick='loadDriverModal(".$latest_race_result_row['driverid'] . ")'><img src='https://flagsapi.com/" . $nationalityToCountryCode[$latest_race_result_row['driver_nationality']] . "/shiny/32.png'>" . $latest_race_result_row['driver_name'] . "</td>";
                                   echo "<td class='modalcell' onclick='loadTeamModal(".$latest_race_result_row['constructor_id'] . ")'><img src='https://flagsapi.com/" . $nationalityToCountryCode[$latest_race_result_row['constructor_nationality']] . "/shiny/32.png'> " . $latest_race_result_row['constructor_name'] . "</td>";
                                   echo "<td>" . $latest_race_result_row['time'] . "</td>";
                                   echo "<td>" . $latest_race_result_row['status'] . "</td>";
                               echo "</tr>";
                           }
                          }
                        }
                           echo "</tbody>";                            
                       echo "</table>";
                ?>

      </div>
      <div class="col-lg-5 col-md-10 col-sm-12">
        <h1>Fahrer-Rangliste</h1>
        <p>Die Tabelle zeigt die momentane Fahrer-Rangliste (Top 5).</p><br>
        <?php
                   $current_drivers_position_sql = "SELECT * FROM v_current_drivers_position LIMIT 5";
                   /* Überprüfen, ob Datenbank das SQL ausführen kann */
if($current_drivers_position_result = mysqli_query($link, $current_drivers_position_sql)){
   /* Falls das Resultat mehr als 0 Reihen zurückgibt */
                   if(mysqli_num_rows($current_drivers_position_result) > 0){
                     /* Falls das Resultat mehr als 0 Reihen zurückgibt */
/* Tabellen Kopfzeile erstellen */
                       echo '<table class="table table-striped table-hover table-responsive">';
                           echo "<thead>";
                               echo "<tr>";
                                   echo "<th>Position</th>";
                                   echo "<th>Fahrer</th>";
                                   echo "<th>Team</th>";
                                   echo "<th>Punkte</th>";
                                   echo "<th>Siege</th>";
                               echo "</tr>";
                           echo "</thead>";
                           echo "<tbody>";
                           /* Für jede Reihe eine Tabellenreihe erstellen (Loop) */
                           while($current_drivers_position_row = mysqli_fetch_array($current_drivers_position_result)){
                               echo "<tr>";
                                   echo "<td>" . $current_drivers_position_row['position'] . "</td>";
                                   echo "<td class='modalcell' onclick='loadDriverModal(".$current_drivers_position_row['driverid'] . ")'><img src='https://flagsapi.com/" . $nationalityToCountryCode[$current_drivers_position_row['driver_nationality']] . "/shiny/32.png'> " . $current_drivers_position_row['driver_name'] .  "</td>";
                                   echo "<td class='modalcell' onclick='loadTeamModal(".$current_drivers_position_row['constructor_id'] . ")'><img src='https://flagsapi.com/" . $nationalityToCountryCode[$current_drivers_position_row['constructor_nationality']] . "/shiny/32.png'>" . $current_drivers_position_row['constructor_name'] . "</td>";
                                   echo "<td>" . $current_drivers_position_row['points'] . "</td>";
                                   echo "<td>" . $current_drivers_position_row['wins'] . "</td>";
                               echo "</tr>";
                           }
                           echo "</tbody>";                            
                       echo "</table>";
                          }
                        }
                ?><br>

        <h1>Teams-Rangliste</h1><br>
        <?php
        /* SQL Abfrage in Variabel speichern */
                   $current_constructors_position_sql = "SELECT * FROM v_current_constructors_position";

                   /* Überprüfen, ob Datenbank das SQL ausführen kann */
                   if($current_constructors_position_result = mysqli_query($link, $current_constructors_position_sql)){

                     /* Falls das Resultat mehr als 0 Reihen zurückgibt */
                   if(mysqli_num_rows($current_constructors_position_result) > 0){

                    /* Tabellen Kopfzeile erstellen */
                       echo '<table class="table table-striped table-hover table-responsive">';
                           echo "<thead>";
                               echo "<tr>";
                                   echo "<th>Position</th>";
                                   echo "<th>Team</th>";
                                   echo "<th>Punkte</th>";
                                   echo "<th>Siege</th>";
                               echo "</tr>";
                           echo "</thead>";
                           echo "<tbody>";

                           /* Für jede Reihe eine Tabellenreihe erstellen (Loop) */
                           while($current_constructors_position_row = mysqli_fetch_array($current_constructors_position_result)){
                               echo "<tr>";
                                   echo "<td>" . $current_constructors_position_row['position'] . "</td>";
                                   echo "<td class='modalcell' onclick='loadTeamModal(".$current_constructors_position_row['constructorid'] . ")'><img src='https://flagsapi.com/" . $nationalityToCountryCode[$current_constructors_position_row['constructor_nationality']] . "/shiny/32.png'> " . $current_constructors_position_row['constructor_name'] . "</td>";
                                   echo "<td>" . $current_constructors_position_row['points'] . "</td>";
                                   echo "<td>" . $current_constructors_position_row['wins'] . "</td>";
                               echo "</tr>";
                           }
                           echo "</tbody>";                            
                       echo "</table>";
                          }
                        }
                ?>
      </div>
    </div>
  </section>

<!-- Footer -->
  <section id="footer" class="container-fluid bg-dark text-white">
    <footer>
      <div class="row justify-content-center">
        <div class="col-3 justify-content-center d-flex">
          <p>Diplomarbeit 2023</p>
        </div>
        <div class="col-3 justify-content-center d-flex">
          <p>TEKO Schweizerische Fachschule</p>
        </div>
        <div class="col-3 justify-content-center d-flex">
          <p>Francisco Cecilio | Nicolas Landtwing</p>
        </div>
        <div class="col-3 justify-content-center d-flex">
        <p>Daten bereitgestellt von <a href="https://ergast.com/mrd">Ergast</a>.</p>
        </div>
      </div>

    </footer>
  </section>
  <!-- Eigenes Script, JQuery und Bootstrap Javascripts hinzufügen -->
  <script src="js/modalTrigger.js">
  </script>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
  </script>
</body>

</html>
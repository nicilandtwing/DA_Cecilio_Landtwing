<!doctype html>
<html lang="de">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Formula 1 DB - Rennen</title>
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
            <a class="nav-link" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="season-list.php">Saisons</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="race.php">Rennen</a>
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

  <!-- Banner mit Seitentitel -->
  <section id="random-image" class="d-flex flex-column justify-content-center align-items-center container-fluid">
    <h1 id="subpage-text">Rennen</h1>
    <!-- Javascript, damit jedes Mal ein anderes Bild erscheint -->
    <script src="js/randombackground.js"></script>
  </section>
  <br>

  <!-- Auswahl des Rennens -->
  <section id="race-selection" class="container">
    <div class="row">
      <?php
      /* Wenn Link keine Renn-ID mitliefert, den Text anzeigen */
          if(empty($raceid)){
            echo "<h4>Bitte Rennen auswählen:</h4>";
          }
          else{
            echo "";
          }
        ?>
      <div class="col-6">
        <div class="dropdown">
          <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
            aria-expanded="false">
            <?php
             if (isset($_GET['year'])) {
              // Das Jahr ist im Link vorhanden
              $year = $_GET['year'];
              if (empty($year)){
                echo "Jahr auswählen";
              }else{
              echo "$year";
              }
          } else {
              // Das Jahr fehlt im Link
              echo "Jahr auswählen";
          };
          
             ?>
          </button>
          <!-- Jahres Auswahl Dropdown -->
          <ul class="dropdown-menu">
            <?php
            /* SQL Abfrage in Variabel speichern */
                $years_sql = "SELECT DISTINCT year FROM races ORDER BY year DESC;";

                /* Überprüfen, ob Datenbank das SQL ausführen kann */
                $years_result = mysqli_query($link, $years_sql);

                 /* Falls das Resultat mehr als 0 Reihen zurückgibt */
                if(mysqli_num_rows($years_result) > 0){
                  while($years_row = mysqli_fetch_array($years_result)){
                    /* Für jedes Jahr ein Dropdown Eintrag erstellen */
                    echo "<li><a class='dropdown-item' href='race.php?year=" . $years_row['year'] . "'>" . $years_row['year'] . "</a></li>";
                  };
                };
                
              ?>
          </ul>
        </div>
      </div>
      <div class="col-6">
        <div class="dropdown">
          <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
            aria-expanded="false">
            <?php
               if (isset($_GET['raceid'])) {
                // Renn-ID ist in der URL vorhanden
                $raceid = $_GET['raceid'];
                if (empty($raceid)){
                  echo "Rennen auswählen";
                }else{
                $racename_sql = "SELECT name FROM races WHERE raceid = $raceid;";
                $racename_result = mysqli_query($link, $racename_sql);
                if(mysqli_num_rows($racename_result) > 0){
                  $racename_row = mysqli_fetch_array($racename_result);
                    echo $racename_row['name'];
                  
                }
              
                }
            } else {
                // Renn-ID fehlt in der URL
                echo "Rennen auswählen";
            };
            
               ?>
          </button>
          <ul class="dropdown-menu">
            <?php
            /* Wenn noch kein Jahr ausgewählt wurde */
              if (empty($year)){
                echo "<li>Kein Jahr ausgewählt!</li>";
              }else{

                /* Falls ein Jahr gewählt wurde */
                /* SQL Abfrage in Variabel speichern */
                $race_sql = "SELECT raceid, name FROM races WHERE year = $year ORDER BY raceid ASC;";

                /* Überprüfen, ob Datenbank das SQL ausführen kann */
                $race_result = mysqli_query($link, $race_sql);

                /* Falls das Resultat mehr als 0 Reihen zurückgibt */
                if(mysqli_num_rows($race_result) > 0){

                  /* Für jedes Rennen ein Dropdown Eintrag erstellen */
                  while($race_row = mysqli_fetch_array($race_result)){
                    echo "<li><a class='dropdown-item' href='race.php?year=$year&raceid=" . $race_row['raceid'] . "'>" . $race_row['name'] . "</a></li>";
                  }
                }
              }
                
              ?>
          </ul>
        </div>
      </div>
    </div>

  </section>
  <br>

  <!-- Tabellen -->
  <section id="race-details" class="container">
    <div class="row">
      <div class="col-md-10 col-sm-12">

        <?php
              if(empty($raceid)){
                echo "";
              }else{
                echo "<h2>Rennresultate</h2>";

                /* SQL Abfrage in Variabel speichern */
                $racedetails_sql = "SELECT res.position AS Position,dri.driverid AS driverid, CONCAT(dri.forename, ' ', dri.surname) AS Driver, con.name AS Constructor, con.constructorId, sta.status AS Status, res.points AS Punkte, dri.nationality AS driver_nationality, con.nationality AS constructor_nationality
                FROM races rac
                INNER JOIN results res ON res.raceId = rac.raceId
                INNER JOIN drivers dri ON dri.driverId = res.driverId
                INNER JOIN constructors con ON con.constructorId = res.constructorId
                INNER JOIN status sta ON sta.statusId = res.statusId
                WHERE rac.raceid = $raceid
                GROUP BY dri.driverid
				ORDER BY 
					CASE 
						WHEN res.position IS NULL THEN 1
					ELSE 0
				END,
				res.position;
                
                ";

                /* Überprüfen, ob Datenbank das SQL ausführen kann */
                    if($racedetails_result = mysqli_query($link, $racedetails_sql)){

                       /* Falls das Resultat mehr als 0 Reihen zurückgibt */
                    if(mysqli_num_rows($racedetails_result) > 0){

                      /* Tabellen Kopfzeile erstellen */
                        echo '<table class="table  table-striped table-hover table-responsive">';
                            echo "<thead>";
                                echo "<tr>";
                                    echo "<th>Pos.</th>";
                                    echo "<th>Fahrer</th>";
                                    echo "<th>Team</th>";
                                    echo "<th>Status</th>";
                                    echo "<th>Punkte</th>";
                                echo "</tr>";
                            echo "</thead>";
                            echo "<tbody>";

                            /* Für jede Reihe eine Tabellenreihe erstellen (Loop) */
                            while($racedetails_row = mysqli_fetch_array($racedetails_result)){
                                echo "<tr>";
                                    echo "<td>" . $racedetails_row['Position'] .  "</td>";
                                    echo "<td class='modalcell' onclick='loadDriverModal(".$racedetails_row['driverid'] . ")'><img src='https://flagsapi.com/" . $nationalityToCountryCode[$racedetails_row['driver_nationality']] . "/shiny/32.png'> " . $racedetails_row['Driver'] . "</td>";
                                    echo "<td class='modalcell' onclick='loadTeamModal(".$racedetails_row['constructorId'] . ")'><img src='https://flagsapi.com/" . $nationalityToCountryCode[$racedetails_row['constructor_nationality']] . "/shiny/32.png'> " . $racedetails_row['Constructor'] . "</td>"; 
                                    echo "<td>" . $racedetails_row['Status'] . "</td>";
                                    echo "<td>" . $racedetails_row['Punkte'] . "</td>";
                                echo "</tr>";
                            }
                            echo "</tbody>";                            
                        echo "</table>";
                          }
                        }



              
            }?>
      </div>
    </div>

    <!-- Qualifying Informationen -->
    <div class="row">
      <div class="col-md-10 col-sm-12">
        <br>
        <?php
              if(empty($raceid)){
                echo "";
              }else{
                echo "<h2>Qualifying</h2>";

                /* SQL Abfrage in Variabel speichern */
                $qualifying_sql = "SELECT qua.position, dri.driverid, CONCAT(dri.forename, ' ', dri.surname) AS driver_name, dri.nationality AS driver_nationality, qua.q1, qua.q2, qua.q3
                FROM qualifying qua
                INNER JOIN drivers dri on dri.driverid = qua.driverid
                WHERE qua.raceid = $raceid;";

                /* Überprüfen, ob Datenbank das SQL ausführen kann */
                    if($qualifying_result = mysqli_query($link, $qualifying_sql)){

                       /* Falls das Resultat mehr als 0 Reihen zurückgibt */
                    if(mysqli_num_rows($qualifying_result) > 0){

                      /* Tabellen Kopfzeile erstellen */
                        echo '<table class="table  table-striped table-hover table-responsive">';
                            echo "<thead>";
                                echo "<tr>";
                                    echo "<th>Pos.</th>";
                                    echo "<th>Fahrer</th>";
                                    echo "<th>Q1</th>";
                                    echo "<th>Q2</th>";
                                    echo "<th>Q3</th>";
                                echo "</tr>";
                            echo "</thead>";
                            echo "<tbody>";

                            /* Für jede Reihe eine Tabellenreihe erstellen (Loop) */
                            while($qualying_row = mysqli_fetch_array($qualifying_result)){
                                echo "<tr>";
                                    echo "<td>" . $qualying_row['position'] .  "</td>";
                                    echo "<td class='modalcell' onclick='loadDriverModal(".$qualying_row['driverid'] . ")'><img src='https://flagsapi.com/" . $nationalityToCountryCode[$qualying_row['driver_nationality']] . "/shiny/32.png'> " . $qualying_row['driver_name'] . "</td>";
                                    echo "<td>" . $qualying_row['q1'] . "</td>"; 
                                    echo "<td>" . $qualying_row['q2'] . "</td>";
                                    echo "<td>" . $qualying_row['q3'] . "</td>";
                                echo "</tr>";
                            }
                            echo "</tbody>";                            
                        echo "</table>";
                          }else{
                            echo "<p>Keine Qualifying Daten vorhanden.</p>";
                          }
                        }



              
            }?>
      </div>
    </div>
  
  </section>

  <br>
  <br>
  <!-- Footer -->
  <section id="footer" class="container-fluid bg-dark text-white fixed-bottom">
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
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous">
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
  </script>

</body>

</html>
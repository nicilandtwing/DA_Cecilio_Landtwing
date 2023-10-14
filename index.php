<!doctype html>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Formula 1 DB</title>
    <link href="css/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <?php
                require_once "php/config.php";
    ?>
  </head>
  <body>
    <nav class="navbar navbar-dark bg-dark navbar-expand-md">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">
            <img src="images/Logo.png" alt="Formula 1 DB Logo" width="200px"/>
          </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Saisons</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Rennen</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Fahrer</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Teams</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>

      <!-- Startseiten-Banner mit Logo -->
    <section id="welcome-image" class="d-flex flex-column justify-content-center align-items-center container-fluid">
      <h1 id="welcome-text">Willkommen bei</h1>
      <img id="welcome-text-logo" src="images/Logo.png" alt="Formula 1 DB Logo">
    </section>


    <section id="last-race-current-scores" class="container">

        <div class="row">
            <div class="col-lg-7 col-md-10">
                <h1>Letztes Rennergebnis</h1>
                <?php
                  $latest_race_sql = "SELECT * FROM v_latest_race";
                  if($result = mysqli_query($link, $latest_race_sql)){
                    if(mysqli_num_rows($result) > 0){
                      while($row = mysqli_fetch_array($result)){
                        echo '<p> Das letzte Rennen war der <strong>' . $row['year'] . ' ' . $row['racename'] . '</strong> auf der Strecke <strong>' . $row['circuitname'] . '</strong> in <strong>' . $row['location'] . '.</strong></p>';
                      }
                    }
                  }
                ?>

                <?php
                   $latest_race_result_sql = "SELECT * FROM v_latest_race_result";
                   if($result = mysqli_query($link, $latest_race_result_sql)){
                   if(mysqli_num_rows($result) > 0){
                       echo '<table class="table table-bordered table-striped">';
                           echo "<thead>";
                               echo "<tr>";
                                   echo "<th>Position</th>";
                                   echo "<th>Fahrer</th>";
                                   echo "<th>Team</th>";
                                   echo "<th>Rennzeit</th>";
                                   echo "<th>Status</th>";
               echo "<th>Gestartet von</th";
                               echo "</tr>";
                           echo "</thead>";
                           echo "<tbody>";
                           while($row = mysqli_fetch_array($result)){
                               echo "<tr>";
                                   echo "<td>" . $row['Position'] . "</td>";
                                   echo "<td>" . $row['Fahrervorname'] . " " . $row['Fahrernachname'] . "</td>";
                                   echo "<td>" . $row['constructor_name'] . "</td>";
                                   echo "<td>" . $row['time'] . "</td>";
                                   echo "<td>" . $row['status'] . "</td>";
               echo "<td>" . $row['grid'] . "</td>";
                               echo "</tr>";
                           }
                          }
                        }
                           echo "</tbody>";                            
                       echo "</table>";
                ?>
                
            </div>
            <div class="col-lg-5 col-md-10">
                <h1>Fahrer-Rangliste</h1>
                <p>Die Tabelle zeigt die momentane Rangliste.</p>
                <?php
                   $current_drivers_position_sql = "SELECT * FROM v_current_drivers_position LIMIT 5";
                   if($result = mysqli_query($link, $current_drivers_position_sql)){
                   if(mysqli_num_rows($result) > 0){
                       echo '<table class="table table-bordered table-striped table-hover table-responsive">';
                           echo "<thead>";
                               echo "<tr>";
                                   echo "<th>Position</th>";
                                   echo "<th>Punkte</th>";
                                   echo "<th>Fahrer</th>";
                                   echo "<th>Team</th>";
                                   echo "<th>Anzahl Siege</th>";
                               echo "</tr>";
                           echo "</thead>";
                           echo "<tbody>";
                           while($row = mysqli_fetch_array($result)){
                               echo "<tr>";
                                   echo "<td>" . $row['position'] . "</td>";
                                   echo "<td>" . $row['points'] . "</td>";
                                   echo "<td>" . $row['forename'] . " " . $row['surname'] . "</td>";
                                   echo "<td>" . $row['constructor_name'] . "</td>";
                                   echo "<td>" . $row['wins'] . "</td>";
                               echo "</tr>";
                           }
                           echo "</tbody>";                            
                       echo "</table>";
                          }
                        }
                ?>

                <h1>Teams-Rangliste</h1>
                <?php
                   $current_constructors_position_sql = "SELECT * FROM v_current_constructors_position";
                   if($result = mysqli_query($link, $current_constructors_position_sql)){
                   if(mysqli_num_rows($result) > 0){
                       echo '<table class="table table-bordered table-striped table-hover table-responsive">';
                           echo "<thead>";
                               echo "<tr>";
                                   echo "<th>Position</th>";
                                   echo "<th>Punkte</th>";
                                   echo "<th>Team</th>";
                                   echo "<th>Anzahl Siege</th>";
                               echo "</tr>";
                           echo "</thead>";
                           echo "<tbody>";
                           while($row = mysqli_fetch_array($result)){
                               echo "<tr>";
                                   echo "<td>" . $row['position'] . "</td>";
                                   echo "<td>" . $row['points'] . "</td>";
                                   echo "<td>" . $row['conname'] . "</td>";
                                   echo "<td>" . $row['wins'] . "</td>";
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


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  </body>
</html>
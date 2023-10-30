<!doctype html>
<html lang="de">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Formula 1 DB - Saisons</title>
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
            <a class="nav-link active" aria-current="page" href="season-list.php">Saisons</a>
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

  <!-- Banner mit Seitentitel -->
  <section id="random-image" class="d-flex flex-column justify-content-center align-items-center container-fluid">
    <h1 id="subpage-text">Saisons</h1>
    <!-- Javascript, damit jedes Mal ein anderes Bild erscheint -->
    <script src="js/randombackground.js"></script>
  </section>
  <br>

  <!-- Tabellen -->
  <section id="last-race-current-scores" class="container">

    <div class="row">
      <div class="col-md-10 col-sm-12">
        <h1>Alle Saisons</h1>
        <p>Klicke auf eine Jahreszahl, um mehr über die Saison zu erfahren.</p>
        <?php
        /* SQL Abfrage in Variabel speichern */
                    $season_list_sql = "SELECT * FROM v_seasons_with_world_champions;";

                    /* Überprüfen, ob Datenbank das SQL ausführen kann */
                    if($season_list_result = mysqli_query($link, $season_list_sql)){

                       /* Falls das Resultat mehr als 0 Reihen zurückgibt */
                    if(mysqli_num_rows($season_list_result) > 0){

                      /* Tabellen Kopfzeile erstellen */
                        echo '<table class="table table-striped table-hover table-responsive">';
                            echo "<thead>";
                                echo "<tr>";
                                    echo "<th>Saison</th>";
                                    echo "<th>Fahrer</th>";
                                    echo "<th>Punkte</th>";
                                    echo "<th>Team-Meister</th>";
                                    echo "<th>Punkte</th>";
                                echo "</tr>";
                            echo "</thead>";
                            echo "<tbody>";

                            /* Für jede Reihe eine Tabellenreihe erstellen (Loop) */
                            while($season_list_row = mysqli_fetch_array($season_list_result)){
                                echo "<tr>";
                                    echo "<td><a class='custom-link' href='season.php?year=" . $season_list_row['year'] . "'>" . $season_list_row['year'] . "</a></td>";
                                    echo "<td class='modalcell' onclick='loadDriverModal(".$season_list_row['driverId'] . ")'><img src='https://flagsapi.com/" . $nationalityToCountryCode[$season_list_row['driver_nationality']] . "/shiny/32.png'> " . $season_list_row['driver_name'] . "</td>";
                                    echo "<td>" . $season_list_row['drspoints'] .  "</td>";
                                    if(is_null($season_list_row['constructor_nationality'])) {
                                      echo "<td> </td>";                                    
                                      } else {
                                        echo "<td class='modalcell' onclick='loadTeamModal(".$season_list_row['constructorId'] . ")'><img src='https://flagsapi.com/" . $nationalityToCountryCode[$season_list_row['constructor_nationality']] . "/shiny/32.png'> " . $season_list_row['constructor_name'] . "</td>";
                                      }
                                    echo "<td>" . $season_list_row['constructor_points'] . "</td>";
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
<!doctype html>
<html lang="de">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Formula 1 DB - Teams</title>
  <link rel="icon" type="image/x-icon" href="/images/favicon.png">

  <!-- Eigenes Stylesheet -->
  <link href="css/style.css" rel="stylesheet">

  <!-- Bootstrap Stylesheet -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

  <!-- Bootstrap Stylesheet mit DataTables (Sortierfunktion) -->
  <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">

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
            <a class="nav-link" aria-current="page" href="index.php">Home</a>
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
            <a class="nav-link active" aria-current="page" href="teams.php">Teams</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Banner mit Seitentitel -->
  <section id="random-image" class="d-flex flex-column justify-content-center align-items-center container-fluid">
    <h1 id="subpage-text">Teams</h1>

    <!-- Javascript, damit jedes Mal ein anderes Bild erscheint -->
    <script src="js/randombackground.js"></script>
  </section>
  <br>


  <!-- Tabellen -->
  <section id="Teams" class="container">
    <div class="row">
      <div class="col-md-10 col-sm-12">
        <h1>Aktuelle Teams</h1>
        <p>Sortiert nach WM-Position</p>
        <p>Die Tabelle kann mit einem Klick auf den Spalten-Titel <strong>sortiert werden!</strong></p>
        <?php
        
        /* SQL Abfrage in Variabel speichern */
                   $currentteamssql = "SELECT * FROM v_current_teams_wins";

                   /* Überprüfen, ob Datenbank das SQL ausführen kann */
                   if($currentteamsresult = mysqli_query($link, $currentteamssql)){

                     /* Falls das Resultat mehr als 0 Reihen zurückgibt */
                   if(mysqli_num_rows($currentteamsresult) > 0){

                    /* Tabellen Kopfzeile erstellen */
                       echo '<table id="teams-table" class="table table-striped table-hover table-responsive">';
                           echo "<thead>";
                               echo "<tr>";
                                   echo "<th>Team</th>";
                                   echo "<th>WM-Titel</th>";
                                   echo "<th>Renn-Siege</th>";
                                   echo "<th>Wiki</th>";
                               echo "</tr>";
                           echo "</thead>";
                           echo "<tbody>";

                           
/* Für jede Reihe eine Tabellenreihe erstellen (Loop) */
                           while($currentteamsrow = mysqli_fetch_array($currentteamsresult)){
                               echo "<tr>";
                                   echo "<td><img src='https://flagsapi.com/" . $nationalityToCountryCode[$currentteamsrow['constructor_nationality']] . "/shiny/32.png'> " . $currentteamsrow['name'] . "</td>";
                                   echo "<td>" . $currentteamsrow['constructor_worldchampions'] . "</td>";
                                   if(is_null($currentteamsrow['constructor_wins'])) {
                                    echo "<td>0</td>";                                    
                                    } else {
                                      echo "<td>" . $currentteamsrow['constructor_wins'] . "</td>";
                                     }
                                   echo "<td><a class='custom-link' href='" . $currentteamsrow['url'] . "' target='_blank'>Link</a></td>";
                               echo "</tr>";
                           }
                          }
                        }
                           echo "</tbody>";                            
                       echo "</table>";
                ?>

      </div>
    </div>
  </section>

  <!-- Eigenes Script, JQuery und Bootstrap Javascripts hinzufügen -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
    integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
  </script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

  <!-- DatTable (Sortierfunktion) Einstellungen -->
  <script>
    $(document).ready(function () {
      $('#teams-table').dataTable({
        "bPaginate": false,
        "bLengthChange": false,
        "bFilter": true,
        "bInfo": false,
        "bAutoWidth": false,
        "aaSorting": []
      });
    });
  </script>
</body>

</html>
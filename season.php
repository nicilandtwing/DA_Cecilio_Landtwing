<!doctype html>
<html lang="de">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Formula 1 DB - Saisons</title>
  <link rel="icon" type="image/x-icon" href="/images/favicon.png">
  <link href="css/style.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <?php
                require_once "php/config.php";
    ?>
</head>

<body>
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
            <a class="nav-link" aria-current="page" href="teams.php">Fahrer</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="teams.php">Teams</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Saisons-Banner -->
  <section id="random-image" class="d-flex flex-column justify-content-center align-items-center container-fluid">
    <h1 id="subpage-text">Saisons</h1>
    <script src="js/randombackground.js"></script>
  </section>
  <br>

  <section id="season-race-list" class="container">
    <?php 
        $year = $_GET["year"];
        $champion_sql = "SELECT * FROM v_seasons_with_world_champions WHERE year='$year';";
    $champion_result = mysqli_query($link, $champion_sql);

  ?>


    <div class="row">
      <div class="col-md-10 col-sm-10">
        <h1>Saison <?php echo "$year"?></h1>
        <p>Fahrer-Weltmeister der Saison <?php echo "$year"?> wurde <strong><?php
                $champion_row = mysqli_fetch_array($champion_result);
                echo $champion_row['driver_name'];
                ?></strong> mit <strong><?php
                echo $champion_row['drspoints'];
                ?> Punkten</strong>.
        </p>

        <?php
                echo"<p><strong>";
                if(is_null($champion_row['constructor_name'])) {
                    echo "In dieser Saison hat es noch keine Konstruktoren-Weltmeisterschaft gegeben!</strong></p>";                                    
                } else {
                  echo $champion_row['constructor_name'];
                  echo "</strong> wurde mit <strong>";
                  echo $champion_row['constructor_points']; 
                  echo " Punkten</strong> Team-Weltmeister.</p>";
                  }
                ?>
        <p>Klicke <a class="custom-link" href="season-list.php">hier</a>, um zurück zu allen Saisons zu kommen.</p>

        <?php 
                    $season_sql = "SELECT
                    rac.raceid, rac.year, rac.name AS 'Grand-Prix',
                    rac.round AS 'Runde',
                    (SELECT CONCAT(d1.forename,' ', d1.surname) FROM drivers d1
                     JOIN results res1 ON d1.driverId = res1.driverId
                     WHERE res1.raceId = rac.raceId AND res1.position = 1 LIMIT 1) AS 'Rennsieger',
                    (SELECT CONCAT(d1.driverid) FROM drivers d1
                     JOIN results res1 ON d1.driverId = res1.driverId
                     WHERE res1.raceId = rac.raceId AND res1.position = 1 LIMIT 1) AS 'RennsiegerID',
                    (SELECT CONCAT(d1.nationality) FROM drivers d1
                     JOIN results res1 ON d1.driverId = res1.driverId
                     WHERE res1.raceId = rac.raceId AND res1.position = 1 LIMIT 1) AS 'Rennsieger-Nationality',
                    (SELECT CONCAT(d2.forename,' ', d2.surname) FROM drivers d2
                     JOIN results res2 ON d2.driverId = res2.driverId
                     WHERE res2.raceId = rac.raceId AND res2.grid = 1 LIMIT 1) AS 'Renn-Pole',
                    (SELECT CONCAT(d2.driverid) FROM drivers d2
                     JOIN results res2 ON d2.driverId = res2.driverId
                     WHERE res2.raceId = rac.raceId AND res2.grid = 1 LIMIT 1) AS 'Renn-PoleID',
                    (SELECT CONCAT(d2.nationality) FROM drivers d2
                     JOIN results res2 ON d2.driverId = res2.driverId
                     WHERE res2.raceId = rac.raceId AND res2.grid = 1 LIMIT 1) AS 'Renn-Pole-Nationality',
                    (SELECT CONCAT(d3.forename,' ', d3.surname) FROM drivers d3
                     JOIN sprintResults spr1 ON spr1.driverId = d3.driverId
                     WHERE spr1.raceId = rac.raceId AND spr1.position = 1 LIMIT 1) AS 'Sprintsieger',
                    (SELECT CONCAT(d3.driverid) FROM drivers d3
                     JOIN sprintResults spr1 ON spr1.driverId = d3.driverId
                     WHERE spr1.raceId = rac.raceId AND spr1.position = 1 LIMIT 1) AS 'SprintsiegerID',
                    (SELECT CONCAT(d3.nationality) FROM drivers d3
                     JOIN sprintResults spr1 ON spr1.driverId = d3.driverId
                     WHERE spr1.raceId = rac.raceId AND spr1.position = 1 LIMIT 1) AS 'Sprintsieger-Nationality',
                    (SELECT CONCAT(d4.forename,' ', d4.surname) FROM drivers d4
                     JOIN sprintResults spr2 ON spr2.driverId = d4.driverId
                     WHERE spr2.raceId = rac.raceId AND spr2.grid = 1 LIMIT 1) AS 'Sprint-Pole',
                    (SELECT CONCAT(d4.driverid) FROM drivers d4
                     JOIN sprintResults spr2 ON spr2.driverId = d4.driverId
                     WHERE spr2.raceId = rac.raceId AND spr2.grid = 1 LIMIT 1) AS 'Sprint-PoleID',
                    (SELECT CONCAT(d4.nationality) FROM drivers d4
                     JOIN sprintResults spr2 ON spr2.driverId = d4.driverId
                     WHERE spr2.raceId = rac.raceId AND spr2.grid = 1 LIMIT 1) AS 'Sprint-Pole-Nationality'
                FROM races rac
                WHERE rac.year = $year
                ORDER BY rac.round ASC;";
                
                    if($season_result = mysqli_query($link, $season_sql)){
                    if(mysqli_num_rows($season_result) > 0){
                        echo '<table class="table table-striped table-hover table-responsive">';
                            echo "<thead>";
                                echo "<tr>";
                                    echo "<th>Nr.</th>";
                                    echo "<th>GP</th>";
                                    echo "<th>Sieger</th>";
                                    echo "<th>Pole</th>";
                                    echo "<th>Sprint-Sieger</th>";
                                    echo "<th>Sprint-Pole</th>";
                                echo "</tr>";
                            echo "</thead>";
                            echo "<tbody>";
                            while($season_row = mysqli_fetch_array($season_result)){
                                echo "<tr>";
                                    echo "<td>" . $season_row['Runde'] . "</td>";
                                    echo "<td><a class='custom-link' href='race.php?year=$year&raceid=" . $season_row['raceid'] . "'>" . $season_row['Grand-Prix'] . "</a></td>";
                                    echo "<td class='modalcell' onclick='loadDriverModal(".$season_row['RennsiegerID'] . ")'><img src='https://flagsapi.com/" . $nationalityToCountryCode[$season_row['Rennsieger-Nationality']] . "/shiny/32.png'> " . $season_row['Rennsieger'] . "</td>";
                                    echo "<td class='modalcell' onclick='loadDriverModal(".$season_row['Renn-PoleID'] . ")'><img src='https://flagsapi.com/" . $nationalityToCountryCode[$season_row['Renn-Pole-Nationality']] . "/shiny/32.png'> " . $season_row['Renn-Pole'] . "</td>";
                                    if(is_null($season_row['Sprintsieger'])) {
                                      echo "<td> </td>";
                                      echo "<td> </td>";                                     
                                  } else {
                                    echo "<td class='modalcell' onclick='loadDriverModal(".$season_row['SprintsiegerID'] . ")'><img src='https://flagsapi.com/" . $nationalityToCountryCode[$season_row['Sprintsieger-Nationality']] . "/shiny/32.png'> " . $season_row['Sprintsieger'] . "</td>";
                                    echo "<td class='modalcell' onclick='loadDriverModal(".$season_row['Sprint-PoleID'] . ")'><img src='https://flagsapi.com/" . $nationalityToCountryCode[$season_row['Sprint-Pole-Nationality']] . "/shiny/32.png'> " . $season_row['Sprint-Pole'] . "</td>";
                                    }
                                echo "</tr>";
                            }
                            echo "</tbody>";                            
                        echo "</table>";
                          }
                        }
                ?>
        <p>* Sprint-Wochenende gab es erstmals ab 2020.</p>
      </div>

    </div>
  </section>


  <script src="js/modalTrigger.js">
  </script>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
  </script>
</body>

</html>
<!doctype html>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Formula 1 DB - Fahrer</title>
    <link rel="icon" type="image/x-icon" href="/images/favicon.png">
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
                <a class="nav-link" aria-current="page" href="index.php">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="season-list.php">Saisons</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="race.php">Rennen</a>
              </li>
              <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="drivers.php">Fahrer</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Teams</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>

      <!-- Fahrer Banner-->
    <section id="random-image" class="d-flex flex-column justify-content-center align-items-center container-fluid">
      <h1 id="subpage-text">Fahrer</h1>
      <script src="js/randombackground.js"></script>
    </section>
<br>

    <section id="drivers" class="container">
        <div class="row">
                <h1>Aktuelle Fahrer</h1>
                <?php
                   $current_drivers = "SELECT * FROM v_current_driver_teams_wins";
                   if($result = mysqli_query($link, $current_drivers)){
                   if(mysqli_num_rows($result) > 0){
                       echo '<table class="table table-striped table-hover table-responsive">';
                           echo "<thead>";
                               echo "<tr>";
                                   echo "<th>Fahrer</th>";
                                   echo "<th>Team</th>";
                                   echo "<th>Weltmeisterschaften</th>";
                                   echo "<th>Rennsiege</th>";
                                   echo "<th>Wikipedia</th>";
                               echo "</tr>";
                           echo "</thead>";
                           echo "<tbody>";
                           while($row = mysqli_fetch_array($result)){
                               echo "<tr>";
                                   echo "<td><img src='https://flagsapi.com/" . $nationalityToCountryCode[$row['nationality']] . "/shiny/32.png'> " . $row['forename'] . " " . $row['surname'] . "</td>";
                                   echo "<td>" . $row['constructor_name'] . "</td>";
                                   echo "<td>" . $row['Weltmeisterschaften'] . "</td>";
                                   echo "<td>" . $row['Rennsiege'] . "</td>";
                                   //echo "<td>" . $row['url'] . "</td>";
                                   echo "<td><a class='custom-link' href='" . $row['url'] . "' target='_blank'>Link</a></td>";
                               echo "</tr>";
                           }
                          }
                        }
                           echo "</tbody>";                            
                       echo "</table>";
                ?>
                
        </div>
    </section>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  </body>
</html>
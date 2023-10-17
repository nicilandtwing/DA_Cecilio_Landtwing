<!doctype html>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Formula 1 DB - Rennen</title>
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
                <a class="nav-link" href="index.php">Home</a>
              </li>
              <li class="nav-item">
              <a class="nav-link" href="season-list.php">Saisons</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="race.php">Rennen</a>
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

      <!-- Rennen-Banner -->
    <section id="seasons-image" class="d-flex flex-column justify-content-center align-items-center container-fluid">
      <h1 id="subpage-text">Rennen</h1>
    </section>
<br>

    <section id="race-selection" class="container">
      <div class="row">
        <div class="col-4">
          <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
             <?php
             if (isset($_GET['year'])) {
              // Die Variable ist in der URL vorhanden
              $year = $_GET['year'];
              if (empty($year)){
                echo "Jahr auswählen";
              }else{
              echo "$year";
              }
          } else {
              // Die Variable fehlt in der URL
              echo "Jahr auswählen";
          };
          
             ?>
            </button>
            <ul class="dropdown-menu">
              <?php
                $years_sql = "SELECT DISTINCT year FROM races ORDER BY year DESC;";
                $years_result = mysqli_query($link, $years_sql);
                if(mysqli_num_rows($years_result) > 0){
                  while($years_row = mysqli_fetch_array($years_result)){
                    echo "<li><a class='dropdown-item' href='race.php?year=" . $years_row['year'] . "'>" . $years_row['year'] . "</a></li>";
                  };
                };
                
              ?>
            </ul>
          </div>
        </div>
        <div class="col-4">
          <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?php
               if (isset($_GET['raceid'])) {
                // Die Variable ist in der URL vorhanden
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
                // Die Variable fehlt in der URL
                echo "Rennen auswählen";
            };
            
               ?>
            </button>
            <ul class="dropdown-menu">
              <?php
              if (empty($year)){
                echo "<li>Kein Jahr ausgewählt!</li>";
              }else{
                $race_sql = "SELECT raceid, name FROM races WHERE year = $year ORDER BY raceid ASC;";
                $race_result = mysqli_query($link, $race_sql);
                if(mysqli_num_rows($race_result) > 0){
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

    <section id="race-details" class="container">


    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  </body>
</html>
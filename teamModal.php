<html lang="de">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Formula 1 DB - Rennen</title>
  <link rel="icon" type="image/x-icon" href="/images/favicon.png">
  <link href="css/style.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <?php
                require_once "php/config.php";
    ?>
  <style>
    body {
      background-color: white !important;
    }
  </style>

</head>
<?php 
require_once "php/config.php";
$constructor_id = $_GET["constructor_id"]; //escape the string if you like
$team_modal_sql = "SELECT * FROM v_constructor_modal_details WHERE constructorId = $constructor_id";
$team_modal_result = mysqli_query($link,$team_modal_sql);
//$count = mysqli_num_rows($result); //Don't need to count the rows too
$team_modal_row = mysqli_fetch_array($team_modal_result); //Don't need the loop if you wana fetch only single row against id

?>

<body>

  <div class="modal fade" id="teamDetails" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Teamdetails</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <h4><?php echo $team_modal_row['constructor_name']?></h4>
          <p><strong>Rennsiege: </strong><?php if (is_null($team_modal_row['constructor_wins'])){
            echo "0";
          }else{
            echo $team_modal_row['constructor_wins'];
          }
          ?></p>
          <p><strong>Weltmeisterschaften: </strong><?php echo $team_modal_row['constructor_worldchampions']?></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Schliessen</button>
        </div>
      </div>
    </div>
  </div>

</body>

</html>
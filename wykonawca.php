<?php
$current_artist_id = $_GET['id'];
?>
<!DOCTYPE html>
<html>
<head>
  <title>Profil wykonawcy</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<div>
    <?php
    include("navigation.php");

    $query = "SELECT album.id_albumu, album.nazwa, extract (year from album.premiera) as year, album.okladka, wykonawca.nazwa,
		wykonawca.id_wykonawcy, album.opis, wykonawca.biografia, wykonawca.id_wykonawcy, wykonawca.zdjecie FROM album_wykonawca
		JOIN album ON album_wykonawca.id_albumu=album.id_albumu
		JOIN wykonawca ON album_wykonawca.id_wykonawcy=wykonawca.id_wykonawcy
		WHERE wykonawca.id_wykonawcy = $current_artist_id
        ORDER BY year DESC";

    $result = pg_query($db, $query);
    $row = pg_fetch_row($result);
    ?>
  <div class="container row">
    <div class="col  s12 m8 offset-m2 l10 offset-l1">
    <div>
      <div class="card-panel grey lighten-5 z-depth-1">
        <div class="row valign-wrapper">
          <div class="col s4">
              <?php
              echo "<img src=" . $row[9] . " alt=" . $row[1] . " class='circle responsive-img'>";
              ?>
          </div>
          <div class="col s8">
            <h1 class="left-align"><?php echo $row[4];?></h1>
              <span class="black-text">
                <?php
                  echo $row[7];
                ?>

              </span>
          </div>
        </div>
      </div>
    </div>

    <h1 class="left-align col s12">Dyskografia</h1>
    <div class="row">
    <?php
    $result = pg_query($db, $query);
      while ($row = pg_fetch_row($result)) { ?>
        <h2 class="left-align"><?php echo $row[2]; ?></h2>

        <div class="box z-depth-5">

          <div class="card">
            <div class="card-image col s12 m6 z-depth-5">
                <?php
                echo "<a href='album.php?id=" . $row[0] . "'><img src=" . $row[3] . " alt=" . $row[1] . " class='cover-top'></a>";
                ?>
            </div>
          </div>
          <div class="card-content col s12 m5 offset-m1">
              <?php
              echo "<h2 class='underline-animation'><a href='wykonawca.php?id=" . $row[8] . "'>$row[4]</a> \"$row[1]\"</h2>";
              echo $row[6];
              ?>
          </div>
        </div>
          <?php
      } ?>
  </div>
    </div>
  </div>
    <?php
    include('footer.php');
    ?>
  <script type="text/javascript" src="materialize/js/materialize.js"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"
          integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
          crossorigin="anonymous"></script>

</body>
</html>
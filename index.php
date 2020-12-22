<?php
session_start();

if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
}

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    unset($_SESSION['userID']);
    header("location: index.php");
}

?>
<!DOCTYPE html>
<html>
<head>
  <title>Home</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <link type="text/css" rel="stylesheet" href="materialize/css/materialize.css"/>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<?php
include("navigation.php")
?>
<div class="container">
  <div>
    <a class='dropdown-trigger btn' href='#' data-target='dropdown1'>
        <?php if (isset($_GET["genre"])) {
            echo $_GET["genre"];
        } else echo 'Gatunek';
        ?>
      <i class="material-icons">arrow_drop_down</i></a>
    <ul id='dropdown1' class='dropdown-content'>
      <li><a href="index.php" class="black-text">Wszystkie</a></li>
      <li><a href="index.php?genre=Pop" class="black-text">Pop</a></li>
      <li><a href="index.php?genre=Rock" class="black-text">Rock</a></li>
    </ul>
  </div>
    <?php
    if (isset($_GET["genre"])) {
        $query = "SELECT album.id_albumu, album.nazwa, extract (year from album.premiera), album.okladka, wykonawca.nazwa,
  wytwornia.nazwa, gatunek.nazwa
  FROM album_wykonawca
  JOIN album ON album_wykonawca.id_albumu=album.id_albumu
  JOIN wykonawca ON album_wykonawca.id_wykonawcy=wykonawca.id_wykonawcy
  JOIN wytwornia ON album.id_wytworni=wytwornia.id_wytworni
  JOIN gatunek_album ON gatunek_album.id_albumu=album.id_albumu
  JOIN gatunek ON gatunek.id_gatunku=gatunek_album.id_gatunku
  WHERE gatunek.nazwa = '{$_GET["genre"]}'
  ORDER BY album.nazwa DESC";
    } else {
        $query = "SELECT album.id_albumu, album.nazwa, extract (year from album.premiera), album.okladka, wykonawca.nazwa,
                    wytwornia.nazwa
    FROM album_wykonawca
		JOIN album ON album_wykonawca.id_albumu=album.id_albumu
		JOIN wykonawca ON album_wykonawca.id_wykonawcy=wykonawca.id_wykonawcy
    JOIN wytwornia ON album.id_wytworni=wytwornia.id_wytworni
    ORDER BY album.nazwa DESC";
    }
    $result = pg_query($db, $query);
    $row = pg_fetch_assoc($result);

    $result = pg_query($db, $query);
    while ($row = pg_fetch_row($result)) { ?>
  <div class="row">
    <div class="profil-album col s12 m6 l3">
      <div class="album-info">
          <?php
          echo "<a href='album.php?id=" . $row[0] . "'><img src=" . $row[3] . " alt=" . $row[1] . " class='cover-top'></a>"; ?>
          <?php

          echo "<h5>$row[4] \"$row[1]\"</h5><h6>$row[5], $row[2]</h6>";
          ?>
      </div>
    </div>
      <?php
      }
      ?>
  </div>
    <?php
    include('footer.php');
    ?>
  <script type="text/javascript" src="materialize/js/materialize.js"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"
          integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
          crossorigin="anonymous"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      var elems = document.querySelectorAll('.dropdown-trigger');
      var instances = M.Dropdown.init(elems, 0);
    });
  </script>
</body>
</html>
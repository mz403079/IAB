<?php
session_start();
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    unset($_SESSION['userID']);
    header('location: index.php');
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Wyniki wyszukiwania</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<?php
include("navigation.php")
?>
<div class="container">
    <?php

    if (isset($_POST['searchResult'])) {

    $query_usr = $_POST['query'];
    $query_usr = preg_replace("#[^0-9 a-z]#i", "", $query_usr);
    $query_usr = strtolower($query_usr);


    $query = "SELECT DISTINCT album.id_albumu, album.nazwa, extract (year from album.premiera), album.okladka, wykonawca.nazwa,
    wytwornia.nazwa,wykonawca.id_wykonawcy FROM album_wykonawca
    JOIN album ON album_wykonawca.id_albumu=album.id_albumu
    JOIN wykonawca ON album_wykonawca.id_wykonawcy=wykonawca.id_wykonawcy
    JOIN wytwornia ON album.id_wytworni=wytwornia.id_wytworni
    JOIN gatunek_album ON gatunek_album.id_albumu=album.id_albumu
    JOIN gatunek ON gatunek.id_gatunku=gatunek_album.id_gatunku
    WHERE lower(album.nazwa) LIKE '%$query_usr%'
    or lower(wykonawca.nazwa) LIKE '%$query_usr%'
    or lower(gatunek.nazwa) = '$query_usr'
    GROUP BY album.id_albumu,wykonawca.id_wykonawcy,wytwornia.nazwa,gatunek.nazwa
    ORDER BY album.nazwa DESC";

    $result = pg_query($db, $query);
    $row = pg_fetch_assoc($result);

    $result = pg_query($db, $query);
    $i = 0;
    if (pg_num_rows($result) == 0)
        echo "<h3>Brak wyników dla:</br> $query_usr</h3>";
    else
        echo "<h3>Wyniki dla:</br> $query_usr </h3>";
    while ($row = pg_fetch_row($result)) { ?>

  <div class="row">
      <?php if ($i % 3 == 0) { ?>
        <div class="col l1 hide-on-med-and-down"></div>
      <?php } ?>
    <div class="profil-album col s12 m5 offset-m1 l3 z-depth-3">
      <div class="album-info-search">
          <?php
          echo "<a href='album.php?id=" . $row[0] . "'><img src=" . $row[3] . " alt=" . $row[1] . " class='cover-top'></a>"; ?>
          <?php

          echo "<h5 class='underline-animation'><a href='wykonawca.php?id=" . $row[6] . "'>$row[4]</a> \"$row[1]\"</h5><h6>$row[5], $row[2]</h6>";
          ?>
      </div>
    </div>
      <?php
      $i++;
      }
      }
      else {
          header('location: index.php');
      }
      ?>
  </div>
    <?php
    include('footer.php');
    ?>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"
          integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
          crossorigin="anonymous"></script>
  <script
      src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

  <script>
    $('.dropdown-trigger').dropdown();
    document.addEventListener('DOMContentLoaded', function () {
      var elems = document.querySelectorAll('.dropdown-trigger');
      var instances = M.Dropdown.init(elems, 0);
    });
  </script>
</body>
</html>
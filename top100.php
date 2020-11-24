<!DOCTYPE html>
<html>
<head>
  <title>Ranking - Top 100</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <link type="text/css" rel="stylesheet" href="materialize/css/materialize.css"/>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<div>
    <?php
    include("navigation.php")
    ?>
  <div class="content">
    <a class='dropdown-trigger btn' href='#' data-target='dropdown1'>
        <?php if (isset($_GET["genre"])) {
            echo $_GET["genre"];
        } else echo 'Gatunek';
        ?>
      <i class="material-icons">arrow_drop_down</i></a>
    <ul id='dropdown1' class='dropdown-content'>
      <li><a href="top100.php" class="black-text">Wszystkie</a></li>
      <li><a href="top100.php?genre=Pop" class="black-text">Pop</a></li>
      <li><a href="top100.php?genre=Rock" class="black-text">Rock</a></li>

    </ul>
  </div>
  <div class="content-albums">

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
      while ($row = pg_fetch_row($result)) { ?>
        <div class="album-info">
            <?php
            echo "<h2>$row[4] \"$row[1]\"</h2><h4>$row[5], $row[2]</h4>"; ?>
            <?php
            echo "<a href='album.php?id=" . $row[0] . "'><img src=" . $row[3] . " alt=" . $row[1] . " class='cover-top'></a>";
            ?>


        </div>
        <div class="bottom">
          <p>
              <?php
              $query = "SELECT ROUND(AVG(ocena),1) FROM ocena WHERE id_albumu = $row[0]";      //średnia ocena
              $average_rating = pg_fetch_row(pg_query($db, $query));
              echo $average_rating[0] ?>/5<br>
              <?php
              $query = "SELECT COUNT(*) FROM ocena WHERE id_albumu =  $row[0]";
              $num_of_votes = pg_fetch_row(pg_query($db, $query));
              echo $num_of_votes[0] ?> głosów </p>
        </div>
          <?php
      } ?>


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
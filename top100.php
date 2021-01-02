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
    <?php
    include("navigation.php")
    ?>
  <div class="container">
    <div class="content-albums row">
        <?php
        $i = 1;
        $query = "SELECT album.id_albumu, album.nazwa, extract (year from album.premiera), album.okladka, wykonawca.nazwa,
wytwornia.nazwa, album.opis, ROUND(AVG(ocena.ocena),1) as oc, COUNT(*) ocena,wykonawca.id_wykonawcy FROM album_wykonawca
JOIN album ON album_wykonawca.id_albumu=album.id_albumu
JOIN wykonawca ON album_wykonawca.id_wykonawcy=wykonawca.id_wykonawcy
JOIN wytwornia ON album.id_wytworni=wytwornia.id_wytworni
LEFT JOIN ocena ON album.id_albumu=ocena.id_albumu
GROUP BY album.id_albumu,wykonawca.nazwa,wykonawca.id_wykonawcy,wytwornia.nazwa,wykonawca.biografia
ORDER BY oc DESC NULLS LAST";
        $result = pg_query($db, $query);
        while ($row = pg_fetch_row($result)) { ?>
          <div class="box z-depth-5">
            <div class="card">
              <div class="card-image col s12 m6 z-depth-5">
                  <?php
                  echo "<a href='album.php?id=" . $row[0] . "'><img src=" . $row[3] . " alt=" . $row[1] . " class='cover-top'>";
                  echo "<a class='card-title waves-effect waves-light'>$i</a></a>";
                  $i++;
                  ?>
              </div>
            </div>
            <div class="card-content col s12 m5 offset-m1">
                <?php
                echo "<h2><a href='wykonawca.php?id=" . $row[9] . "'>$row[4]</a> \"$row[1]\"</h2><h4>$row[5], $row[2]</h4><br>";
                echo $row[6];
                ?>
            </div>
          <div class="bottom col s12 center z-depth-1">
            <p>
                <?php
                if($row[7] === null) {
                 echo 'brak';
                 } else {
                echo $row[7] ?>/5<br>
                <?php
                echo $row[8]; } ?> głosów </p>
          </div>
          </div>
            <?php
        } ?>

    </div>
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
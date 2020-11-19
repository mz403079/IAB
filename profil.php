<?php
if (($_SESSION['userID'] != "")) {
    $current_user_id = $_SESSION['userID'];
    echo $current_user_id;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Profil</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <link type="text/css" rel="stylesheet" href="materialize/css/materialize.css"/>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<div>
    <?php
    include("navigation.php");
    include("check.php");

    if ($is_logged == 1) {
    $current_user_id = $_SESSION['userID'];
    echo $current_user_id;

    ?>
  <div class="content">
    <div class="content-albums">
        <?php
        $query = "SELECT album.id_albumu, album.nazwa, extract (year from album.premiera), album.okladka, album.ocena, album.ilosc_ocen, wykonawca.nazwa,
                    wytwornia.nazwa
            FROM album_wykonawca
		JOIN album ON album_wykonawca.id_albumu=album.id_albumu
		JOIN wykonawca ON album_wykonawca.id_wykonawcy=wykonawca.id_wykonawcy
    JOIN wytwornia ON album.id_wytworni=wytwornia.id_wytworni
    JOIN ulubione ON album.id_albumu=ulubione.id_albumu WHERE ulubione.id_uzytkownika=$current_user_id
        	ORDER BY album.ocena DESC";

        $result = pg_query($db, $query);
        $row = pg_fetch_assoc($result);
        if (!$row) {
            echo "Dodaj jakies albumy byczque";
        } else {
            $result = pg_query($db, $query);
            while ($row = pg_fetch_row($result)) { ?>
              <div class="album-info">
                  <?php
                  echo "<h2>$row[6] \"$row[1]\"</h2><h4>$row[7], $row[2]</h4>"; ?>
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
            }
        }
        } ?>


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
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

    if ($is_logged != 0) {
    $current_user_id = $_SESSION['userID'];
    echo $current_user_id;

    ?>
  <div class="container">
    <div class="content-profile">
        <?php
        $query = "SELECT album.id_albumu, album.nazwa, extract (year from album.premiera), album.okladka, wykonawca.nazwa,
                    wytwornia.nazwa
            FROM album_wykonawca
		JOIN album ON album_wykonawca.id_albumu=album.id_albumu
		JOIN wykonawca ON album_wykonawca.id_wykonawcy=wykonawca.id_wykonawcy
    JOIN wytwornia ON album.id_wytworni=wytwornia.id_wytworni
    JOIN ulubione ON album.id_albumu=ulubione.id_albumu WHERE ulubione.id_uzytkownika=$current_user_id
        	ORDER BY album.nazwa DESC";

        $result = pg_query($db, $query);
        $row = pg_fetch_assoc($result);
        if (!$row) {
            echo "<h3>Nie dodałeś jeszcze żadnych albumów</h3>";
        } else {

            echo '<div class="row">';
            $result = pg_query($db, $query);
            while ($row = pg_fetch_row($result)) { ?>
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
        }
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

</body>
</html>
<?php
if (($_SESSION['userID'] != "")) {
    $current_user_id = $_SESSION['userID'];
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Profil</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<div>
    <?php
    include("navigation.php");
    include("check.php");
    if ($is_logged == 0) {
        header('location: result.php');
    }
    $current_user_id = $_SESSION['userID'];
    ?>
  <div class="container">
      <?php
      $query = "SELECT album.id_albumu, album.nazwa, extract (year from album.premiera), album.okladka, wykonawca.nazwa,
                    wytwornia.nazwa, wykonawca.id_wykonawcy
            FROM album_wykonawca
		JOIN album ON album_wykonawca.id_albumu=album.id_albumu
		JOIN wykonawca ON album_wykonawca.id_wykonawcy=wykonawca.id_wykonawcy
    JOIN wytwornia ON album.id_wytworni=wytwornia.id_wytworni
    JOIN ulubione ON album.id_albumu=ulubione.id_albumu WHERE ulubione.id_uzytkownika=$current_user_id
        	ORDER BY album.nazwa DESC";

      $result = pg_query($db, $query);
      $row = pg_fetch_assoc($result);
      $i = 0;
      if (!$row) {
          echo "<h3>Nie dodałeś jeszcze żadnych albumów!</h3>";
      } else {
      echo "<h3>Lista twoich albumów</h3>";
      $result = pg_query($db, $query);
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
        } ?>
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
    </script>
</body>
</html>
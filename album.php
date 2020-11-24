<?php
$current_album_id = $_GET['id'];
include('server.php');
$current_user_id = $_SESSION['userID'];
pg_close($db);
$errors = array();
if (isset($_POST['save'])) {
    include('server.php');
    if (($_SESSION['userID'] != "")) {
        $query = "SELECT * FROM ocena WHERE id_albumu = $current_album_id AND id_uzytkownika = $current_user_id";

        $result = pg_query($db, $query);
        $rated = pg_fetch_assoc($result);
        $rating = pg_escape_string($_POST['rating']);
        $rating++;
        if ($rated) {
            pg_query("UPDATE ocena SET ocena = $rating WHERE id_albumu = $current_album_id AND id_uzytkownika = $current_user_id");
        } else {

            $result = pg_query($db, "SELECT id_oceny FROM ocena ORDER BY id_oceny DESC LIMIT 1");
            $id_oceny = pg_fetch_row($result);
            $query = "INSERT INTO ocena (id_albumu, id_uzytkownika, ocena,id_oceny)
                VALUES ('$current_album_id', '$current_user_id', '$rating',$id_oceny[0]+1)";

            $result = pg_query($db, $query);
        }
    } else {
        array_push($errors, "Nie jestes zalogowany");
    }


    pg_close($db);
}
if (isset($_POST['add'])) {
    echo "erer";
    include('server.php');
    if (($_SESSION['userID'] != "")) {

        $result = pg_query($db, "SELECT id_ulubione FROM ulubione ORDER BY id_ulubione DESC LIMIT 1");
        $id_ulubione = pg_fetch_row($result);
        $query = "INSERT INTO ulubione (id_ulubione,id_uzytkownika, id_albumu)
                VALUES ($id_ulubione[0]+1,'$current_user_id','$current_album_id')";

        $result = pg_query($db, $query);
    } else {
        array_push($errors, "Nie jestes zalogowany");
    }


    pg_close($db);
}
if (isset($_POST['remove'])) {
    include('server.php');
    if (($_SESSION['userID'] != "")) {
        $query = "DELETE FROM ulubione WHERE id_uzytkownika = $current_user_id AND id_albumu = $current_album_id";
        pg_query($db, $query);
    } else {
        array_push($errors, "Nie jestes zalogowany");
    }


    pg_close($db);
}
?>


<!DOCTYPE HTML>
<html>
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="style.css">
  <link type="text/css" rel="stylesheet" href="materialize/css/materialize.css"/>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Album Wykonawcy</title>

</head>
<body>

<?php
include('server.php');
include('navigation.php');
?>
<?php


$query = "SELECT album.nazwa, gatunek.nazwa, album.id_albumu
            FROM gatunek_album
            JOIN album on gatunek_album.id_albumu=album.id_albumu
			JOIN gatunek on gatunek_album.id_gatunku=gatunek.id_gatunku
			WHERE album.id_albumu=$current_album_id";
$result = pg_query($db, $query);
$genres = array();
while ($row = pg_fetch_row($result)) {
    $genres[] = $row;
}
$query = "SELECT album.id_albumu, wykonawca.nazwa
        FROM album_wykonawca
		JOIN album ON album_wykonawca.id_albumu=album.id_albumu
		JOIN wykonawca ON album_wykonawca.id_wykonawcy=wykonawca.id_wykonawcy
		WHERE album.id_albumu=$current_album_id";
$result = pg_query($db, $query);
$album_artists = array();
while ($row = pg_fetch_row($result)) {
    $album_artists[] = $row;
}
$query = "SELECT piosenka.id_piosenki, wykonawca.nazwa
        FROM piosenka_wykonawca
		JOIN piosenka ON piosenka_wykonawca.id_piosenki=piosenka.id_piosenki
		JOIN wykonawca ON piosenka_wykonawca.id_wykonawcy=wykonawca.id_wykonawcy
		WHERE piosenka.id_albumu=$current_album_id";
$result = pg_query($db, $query);
$song_artists = array();
while ($row = pg_fetch_row($result)) {
    $song_artists[] = $row;
}
$query = "SELECT * FROM ulubione WHERE id_albumu = $current_album_id AND id_uzytkownika = $current_user_id";
$result = pg_query($db, $query);
$added_fav = pg_fetch_assoc($result);

$query = "SELECT album.id_albumu, album.nazwa, album.premiera, album.okladka, album.liczba_piosenek,
            piosenka.tytul,piosenka.dlugosc,piosenka.nr_piosenki,
            wytwornia.nazwa, piosenka.kompozytor, piosenka.mix, piosenka.id_piosenki FROM album
            JOIN piosenka ON album.id_albumu=piosenka.id_albumu
            JOIN wytwornia on album.id_wytworni=wytwornia.id_wytworni
            WHERE album.id_albumu=$current_album_id
            ORDER BY piosenka.nr_piosenki";
$result = pg_query($db, $query);
$album = pg_fetch_row($result);

?>
<div class="content">
  <div class="content-album">
    <div class="row album-info">
      <div>
        <h1> <?php echo $album[1]; ?>
            <?php if ($added_fav) { ?>
              <a class="btn-floating btn-large waves-effect waves-light remove_favourite">-</a>
            <?php } else { ?>
          <a class="btn-floating btn-large waves-effect waves-light add_favourite">+</a>
          <?php } ?>
        </h1>
      </div>
      <h5>
          <?php
          foreach ($album_artists as $album_artist) {
              if ($album[0] == $album_artist[0])
                  echo "$album_artist[1] ";
          }
          echo '</h5>';
          ?>
        <div class="col s12 l5 left">

            <?php echo "<img src=" . $album[3] . " alt=" . $album[1] . " class='cover'>";
            ?>
          <table style="width:100%">
            <tr>
              <td>Gatunki:</td>
              <td>
                  <?php
                  foreach ($genres as $genre) {
                      echo "$genre[1]<br>";
                  }
                  ?>
              </td>
            </tr>
            <tr>
              <td>Data wydania:</td>
              <td>
                  <?php
                  echo $album[2];
                  ?>
              </td>
            </tr>
            <tr>
              <td>Wytwórnia:</td>
              <td>
                  <?php
                  echo $album[8];
                  ?>
              </td>
            </tr>
            <tr>
              <td>Liczba piosenek:</td>
              <td>
                  <?php
                  echo $album[4];
                  ?>
              </td>
            </tr>
          </table>

        </div>

        <div class="col s12 l5 right">
          <ul class="collapsible" data-collapsible="accordion">
              <?php
              $result = pg_query($db, $query);
              while ($row = pg_fetch_row($result)) {
                  ?>
                <li>
                  <div class="collapsible-header">
                      <?php echo $row[7] ?>. <?php echo $row[5] ?>
                  </div>
                  <div class="collapsible-body">
                    <table style="width:100%">
                      <tr>
                        <td>Dlugość:</td>
                        <td>
                            <?php echo gmdate("i:s", $row[6]) ?></td>
                      </tr>
                      <tr>
                        <td>Kompozytor:</td>
                        <td><?php echo $row[9] ?></td>
                      </tr>
                      <tr>
                        <td>Mix:</td>
                        <td><?php echo $row[10] ?></td>
                      </tr>
                      <tr>
                        <td>Wykonawcy:</td>
                        <td>
                            <?php
                            foreach ($song_artists as $song_artist) {
                                if ($row[11] == $song_artist[0])
                                    echo "$song_artist[1]<br> ";
                            }
                            ?>
                        </td>
                      </tr>
                    </table>
                  </div>
                </li>
              <?php } ?>
          </ul>
        </div>
    </div>
    <div class="bottom-album">

      <i class="material-icons" data-index="0">star</i>
      <i class="material-icons" data-index="1">star</i>
      <i class="material-icons" data-index="2">star</i>
      <i class="material-icons" data-index="3">star</i>
      <i class="material-icons" data-index="4">star</i>
      <br>
      <p class="rating-box">
          <?php
          $query = "SELECT ROUND(AVG(ocena),1) FROM ocena WHERE id_albumu = $album[0]";      //średnia ocena
          $average_rating = pg_fetch_row(pg_query($db, $query));
          echo $average_rating[0] ?>/5 <br>
          <?php
          $query = "SELECT COUNT(*) FROM ocena WHERE id_albumu = $album[0]";
          $num_of_votes = pg_fetch_row(pg_query($db, $query));
          echo $num_of_votes[0] ?> głosów </p>
    </div>
  </div>
    <?php
    pg_close($db);
    include('footer.php');
    ?>
  <script type="text/javascript" src="materialize/js/materialize.js"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"
          integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
          crossorigin="anonymous"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      var elems = document.querySelectorAll('.collapsible');
      var instances = M.Collapsible.init(elems, 1);
    });

    var rating = -1;
    $(document).ready(function () {
      $('.material-icons').on('click', function () {
        rating = parseInt($(this).data('index'));
        saveToDB();
      });

      $('.material-icons').mouseover(function () {
        restartColors()
        var currentStar = parseInt($(this).data('index'));
        setStars(currentStar);
      });
      $('.material-icons').mouseleave(function () {
        restartColors()
        if (rating > -1) {
          setStars(rating);
        }
      });
      $('.add_favourite').on('click', function () {
        addToFavourite();
      });
      $('.remove_favourite').on('click', function () {
        removeFavourite();
      });
    });

    function setStars(index) {
      for (var i = 0; i <= index; i++) {
        $('.material-icons:eq(' + i + ')').css('color', 'gold');
      }
    }

    function addToFavourite() {
      $.ajax({
        url: "album.php?id=<?php echo $current_album_id ?>",
        method: "POST",
        dataType: "json",
        data: {
          add: 1,
        }, success: function (r) {
        }
      });
    }
    function removeFavourite() {
      $.ajax({
        url: "album.php?id=<?php echo $current_album_id ?>",
        method: "POST",
        dataType: "json",
        data: {
          remove: 1,
        }, success: function (r) {
        }
      });
    }

    function saveToDB() {
      $.ajax({
        url: "album.php?id=<?php echo $current_album_id ?>",
        method: "POST",
        dataType: "json",
        data: {
          save: 1,
          rating: rating,
        }, success: function (r) {
        }
      });
    }

    function restartColors() {
      $('.material-icons').css('color', 'black');
    }
  </script>
</body>
</html>
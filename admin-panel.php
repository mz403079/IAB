<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>Admin Panel</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <link type="text/css" rel="stylesheet" href="materialize/css/materialize.css"/>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <!--  <link-->
  <!--      href="https://cdnjs.cloudflare.com/ajax/libs/material-components-web/4.0.0/material-components-web.min.css"-->
  <!--      rel="stylesheet"/>-->
  <link href="https://cdn.datatables.net/1.10.22/css/dataTables.material.min.css" rel="stylesheet"/>
</head>
<body>

<?php include("navigation.php");
?>
<?php
if (isset($_POST['insert_movie'])) {
    $album_name = pg_escape_string($db, $_POST['album_name']);
    $artist = pg_escape_string($db, $_POST['artist']);
    $label = pg_escape_string($db,$_POST['label']);
    $cover_link = pg_escape_string($db,$_POST['cover']);
    $number_of_songs = $_POST['number_of_songs'];
    $description = pg_escape_string($db,$_POST['description']);
    $release = pg_escape_string($db,$_POST['release']);


    $result = pg_query($db, "SELECT * FROM wykonawca WHERE nazwa='$artist'");
    $artist_present = pg_fetch_row($result);
    $artist_id = 0;
    if($artist_present)
      $artist_id = $artist_present[0];
    else {
        pg_query($db, "INSERT into wykonawca(nazwa) VALUES('$artist')");
        $result = pg_query($db, "SELECT * FROM wykonawca ORDER BY id_wykonawcy DESC LIMIT 1 ");
        $row = pg_fetch_row($result);
        $artist_id = $row[0];
    }

    $result = pg_query($db, "SELECT * FROM wytwornia WHERE nazwa='$label'");
    $label_present = pg_fetch_row($result);
    $label_id = 0;
    if($label_present)
        $label_id = $label_present[0];
    else {
        pg_query($db, "INSERT into wytwornia(nazwa) VALUES('$label')");
        $result = pg_query($db, "SELECT * FROM wytwornia ORDER BY id_wytworni DESC LIMIT 1 ");
        $row = pg_fetch_row($result);
        $label_id = $row[0];
    }

    $query = "INSERT INTO album (nazwa, premiera, id_wytworni, okladka, liczba_piosenek, opis)
					  VALUES('$album_name', '$release','$label_id','$cover_link','$number_of_songs','$description')";
    pg_query($db, $query) or die('Query failed: ' . pg_last_error());
    $result = pg_query($db, "SELECT * FROM album WHERE nazwa='$album_name'");
    $row = pg_fetch_row($result);
    $album_id = $row[0];

    $checkbox1=$_POST['genre'];
    echo $checkbox1;
    foreach($checkbox1 as $chk1)
    {
        echo $chk1;
        $query = "INSERT INTO gatunek_album(id_albumu,id_gatunku) VALUES('$album_id','$chk1')";
        pg_query($db, $query) or die('Query failed: ' . pg_last_error());
    }


    $query = "INSERT INTO album_wykonawca(id_albumu,id_wykonawcy) VALUES('$album_id','$artist_id')";
    pg_query($db, $query) or die('Query failed: ' . pg_last_error());
    header('location: admin-panel.php');
}
?>
<div class="container">
  <!-- Modal Trigger -->
  <!-- Modal Trigger -->
  <a class="waves-effect waves-light btn tooltipped modal-trigger" onclick="$('#modal1').modal('open');">Modal</a>

  <!-- Modal Structure -->
  <div  class="modal row" id="modal1">
    <div class="modal-content col s8 offset-l2">
      <h4>Dodaj film do bazy</h4>
      <form method="post" id="insertMovie">

        <div class="input-field">
          <label for="album_name">Nazwa albumu:</label>
          <input id="album_name" type="text" name="album_name" >
        </div>
        <div class="input-field">
          <label for="artist" >Wykonawca:</label>
          <input id="artist" type="text" name="artist">
        </div>
        <div class="input-field">
          <label for="label" >Wytwornia:</label>
          <input id="label" type="text" name="label">
        </div>
        <div class="input-field">

            <select id="genre" name="genre[]" multiple>
              <option value="" disabled> Gatunek</option>
              <?
              $query = "SELECT * FROM gatunek";
              $result = pg_query($db, $query);
              while ($row = pg_fetch_row($result)) {
              ?>
              <option value="<?php echo $row[0] ?>" name="genre[]"><?php echo $row[1]  ?></option>
              <?php } ?>
            </select>
          <label for="genre"></label>
        </div>
        <div class="input-field">
          <label for="release" >data (rrrr-mm-dd):</label>
          <input id="release" type="text" name="release">
        </div>
        <div class="input-field">
          <label>Liczba piosenek:</label>
          <input type="number" name="number_of_songs">
        </div>
        <div class="input-field">
          <label>link do okładki:</label>
          <input type="text" name="cover">
        </div>
        <div class="input-field">
          <textarea id="textarea1" class="materialize-textarea"></textarea>
          <label for="textarea1">Opis albumu:</label>
        </div>
        <div class="input-field">
          <button type="submit" class="btn waves-effect orange" name="insert_movie">Dodaj</button>
        </div>
      </form>
    </div>
  </div>
  <?php
  $query = "SELECT album.id_albumu, album.nazwa, album.premiera, album.okladka, wykonawca.nazwa,
  wytwornia.nazwa
  FROM album_wykonawca
  JOIN album ON album_wykonawca.id_albumu=album.id_albumu
  JOIN wykonawca ON album_wykonawca.id_wykonawcy=wykonawca.id_wykonawcy
  JOIN wytwornia ON album.id_wytworni=wytwornia.id_wytworni
  ORDER BY album.nazwa DESC";
  $result = pg_query($db, $query);
  ?>
  <div class="row">
    <table id="example" class="mdl-data-table col s12" style="width:100%">
      <thead>
      <tr>
        <th>Okładka</th>
        <th>Nazwa</th>
        <th>Autor</th>
        <th>Wytwornia</th>
        <th>Rok wydania</th>
      </tr>
      </thead>
      <tbody>
      <?php while ($row = pg_fetch_row($result)) { ?>
        <tr>
          <td class="center-align"><?php echo "<a href='album.php?id=" . $row[0] . "'><img src=" . $row[3] . " alt=" . $row[1] . " height=50></a>"; ?></td>
          <td><?php echo "$row[1]"; ?></td>
          <td><?php echo "$row[4]"; ?></td>
          <td><?php echo "$row[5]"; ?></td>
          <td><?php echo "$row[2]"; ?></td>
        </tr>
      <?php } ?>
      </tbody>
      <tfoot>
      <tr>
        <th>Okładka</th>
        <th>Nazwa</th>
        <th>Autor</th>
        <th>Wytwornia</th>
        <th>Rok wydania</th>
      </tr>
      </tfoot>
    </table>
  </div>
</div>
<?php include("footer.php"); ?>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
        crossorigin="anonymous"></script>
<script
    src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script type="text/javascript"
        src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script type="text/javascript"
        src="https://cdn.datatables.net/1.10.22/js/dataTables.material.min.js"></script>
<script>
  $(document).ready(function () {
    $('#modal1').modal();
  });
  $(document).ready(function(){
    $('select').formSelect();
  });
  $(document).ready(function () {
    $('#example').DataTable({
      autoWidth: false,
      "info": false,
      "lengthChange": false,
      "dataTables_length": false,
      "pageLength": 5,
      columnDefs: [
        {
          targets: ['_all'],
          className: 'mdc-data-table__cell'
        }
      ]
    });
  });
  $(function(){
    $('#insertAlbum').on('submit', function(e){
      console.log($('#insertAlbum').serialize());
      $.post('admin-panel.php',
          $('#insertAlbum').serialize(),
          function(data, status, xhr){
            // do something here with response;
          });
    });
  });
</script>
</body>
</html>
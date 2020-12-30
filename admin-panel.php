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
    $username = pg_escape_string($db, $_POST['username']);
    $password = pg_escape_string($db, $_POST['password']);
    echo 'her';
    $query = "INSERT INTO album (nazwa, premiera, id_wytworni, typ, okladka, liczba_piosenek, opis) 
					  VALUES('$username', '2020-10-17','1','$password','sf','18','aaa')";
    pg_query($db, $query) or die('Query failed: ' . pg_last_error());
    $query = "INSERT INTO album_wykonawca (id_albumu,id_wykonawcy) 
					  VALUES('7','1')";
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
      <h4>Dodaj film</h4>
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

            <select id="genre" multiple>
              <option value="" disabled> Gatunek</option>
              <?
              $query = "SELECT * FROM gatunek";
              $result = pg_query($db, $query);
              while ($row = pg_fetch_row($result)) {
              ?>
              <option value="1"><?php echo $row[1]  ?></option>
              <?php } ?>
            </select>
          <label for="genre"></label>
        </div>
        <div class="input-field">
          <label for="release" >data (rrrr-mm-dd):</label>
          <input id="release" type="text" name="release">
        </div>
        <div class="input-field">
          <label>link do okładki:</label>
          <input type="text" name="cover">
        </div>
        <div class="input-field">
          <label>data link do okładki:</label>
          <input type="text" name="cover">
        </div>
        <div class="input-field">
          <textarea id="textarea1" class="materialize-textarea"></textarea>
          <label for="textarea1">Opis albumu:</label>
        </div>
        <div class="input-field">
          <button type="submit" class="btn waves-effect orange" name="insert_movie">Login</button>
        </div>
      </form>
    </div>
    <div class="modal-footer">
      <a class="modal-close waves-effect waves-green btn-flat">Zapisz</a>
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
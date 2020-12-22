<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>Rejestracja</title>
  <!--        <link rel="stylesheet" type="text/css" href="style.css">-->
  <!--        <link type="text/css" rel="stylesheet" href="materialize/css/materialize.css"/>-->
  <!--        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">-->
  <link
      href="https://cdnjs.cloudflare.com/ajax/libs/material-components-web/4.0.0/material-components-web.min.css"
      rel="stylesheet"/>
  <link href="https://cdn.datatables.net/1.10.22/css/dataTables.material.min.css" rel="stylesheet"/>
</head>
<body>

<?php include("navigation.php");
$query = "SELECT album.id_albumu, album.nazwa, album.premiera, album.okladka, wykonawca.nazwa,
                    wytwornia.nazwa
    FROM album_wykonawca
		JOIN album ON album_wykonawca.id_albumu=album.id_albumu
		JOIN wykonawca ON album_wykonawca.id_wykonawcy=wykonawca.id_wykonawcy
    JOIN wytwornia ON album.id_wytworni=wytwornia.id_wytworni
    ORDER BY album.nazwa DESC";
$result = pg_query($db, $query);
$row = pg_fetch_assoc($result);

$result = pg_query($db, $query);
?>
<div class="container">
  <table id="example" class="mdl-data-table" style="width:100%">
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
        <td><?php echo "<a href='album.php?id=" . $row[0] . "'><img src=" . $row[3] . " alt=" . $row[1] . " height=50></a>"; ?></td>
        <td><?php echo "$row[1]"; ?></td>
        <td><?php echo "$row[4]"; ?></td>
        <td><?php echo "$row[5]"; ?></td>
        <td><?php echo "$row[2]"; ?></td>
      </tr>
    <?php } ?>
    </tfoot>
  </table>
</div>
<?php include("footer.php"); ?>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript"
        src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script type="text/javascript"
        src="https://cdn.datatables.net/1.10.22/js/dataTables.material.min.js"></script>
<script>
  $(document).ready(function () {
    $('#example').DataTable({
      autoWidth: false,
      columnDefs: [
        {
          targets: ['_all'],
          className: 'mdc-data-table__cell'
        }
      ]
    });
  });
</script>
</body>
</html>
<?php

$result = pg_query($db, "SELECT *from gatunek");

?>
<form method="post" id="searchMovie">
<div class="input-group searchbar row">
  <div class="col s10">
  <input type="hidden" name="search_param" value="all" id="search_param">
  <input type="text" class="form-control white" name="x" placeholder=" Wyszukaj">
  </div>
  <div class="col s2">
  <a class="btn-flat orange white-text"><i
        class="large material-icons search-cion">search</i></a>
  </div>
</div>
</form>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
        crossorigin="anonymous"></script>
<script
    src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

<script>
  $('.dropdown-trigger').dropdown();
</script>
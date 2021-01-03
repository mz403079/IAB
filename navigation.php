<?php
include("check.php");
?>
<?php
if ($is_logged == 0) { ?>
  <div class="hed black row">
    <div class="col s9 m5 l4 offset-l1">
        <?php include("searchbar.php"); ?>
    </div>
    <ul class="nav-bar col m5 l4 offset-l2  row valign-wrapper hide-on-small-only">
      <li class="col m1 l2 offset-l1 valign-wrapper">
        <a href="index.php">Top 100</a>
      </li>
      <li class="col m1 l2 offset-l1 valign-wrapper">
        <a href="login.php">Zaloguj</a>
      </li>
      <li class="col m1 l2 offset-l1 valign-wrapper">
        <a href="register.php">Zarejestruj</a>
      </li>
    </ul>
      <div class="input-group-btn btn-flat col s3 hide-on-med-and-up right-align">
        <a class='dropdown-trigger btn-flat orange white-text' href='#' data-target='dropdown1'>V</a>
        <ul id='dropdown1' class='dropdown-content'>
          <li>
            <a href="index.php">Top 100</a>
          </li>
          <li>
            <a href="login.php">Zaloguj</a>
          </li>
          <li>
            <a href="register.php">Zarejestruj</a>
          </li>
        </ul>
      </div>
  </div>
<?php } else { ?>
  <div class="hed black row">
    <div class="col s9 m5 l4 offset-l1">
        <?php include("searchbar.php"); ?>
    </div>
    <ul class="nav-bar col l4 offset-l2 row valign-wrapper hide-on-small-only">
      <li class="col l3 valign-wrapper">
        <a href="index.php">Top 100</a>
      </li>
      <li class="col l3 valign-wrapper">
        <a href='profil.php'><?php echo $_SESSION['username']; ?></a>
      </li>
      <li class="col l3 valign-wrapper">
        <a href="result.php?logout='1'">Wyloguj</a>
      </li>
        <?php if ($is_logged == 2) { ?>
          <li class="col l3 valign-wrapper">
            <a href="admin-panel.php">Panel admina</a>
          </li>
        <?php } ?>
    </ul>
    <div class="input-group-btn btn-flat col s3 hide-on-med-and-up right-align">
      <a class='dropdown-trigger btn-flat orange white-text' href='#' data-target='dropdown1'>V</a>
      <ul id='dropdown1' class='dropdown-content'>
        <li>
          <a href="index.php">Top 100</a>
        </li>
        <li class="col l3 valign-wrapper">
          <a href='profil.php'><?php echo $_SESSION['username']; ?></a>
        </li>
        <li class="col l3 valign-wrapper">
          <a href="result.php?logout='1'">Wyloguj</a>
        </li>
      </ul>
    </div>
  </div>
<?php } ?>


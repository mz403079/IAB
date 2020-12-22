<?php
include("check.php")
?>
<?php
if ($is_logged == 0) { ?>

  <header>
    <div class="nav-bar">
      <ul>
        <li>
          <a href="top100.php">Top 100</a>
        </li>
        <li>
          <a href="login.php">Zaloguj</a>
        </li>
        <li>
          <a href="register.php">Zarejestruj</a>
        </li>
      </ul>
    </div>
  </header>
<?php } else { ?>
  <header>
    <div class="nav-bar">
      <ul>

        <li>
          <a href="top100.php">Top 100</a>
        </li>
        <li>
          <a href="index.php?logout='1'">Wyloguj</a>
        </li>
        <li>
          <a href='profil.php'><?php echo $_SESSION['username']; ?></a>
        </li>
          <?php if ($is_logged == 2) { ?>
            <li>
              <a href="admin-panel.php">Panel admina</a>
            </li>
          <?php } ?>
      </ul>
    </div>
  </header>
<?php } ?>
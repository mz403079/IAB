<?php include('server.php') ?>
  <!DOCTYPE html>
  <html>
  <head>
    <title>Rejestracja</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
  <body>

  <?php
  include("navigation.php"); ?>
  <div class="container row">
    <div class="wrapper col s12 m6 offset-m3 l4 offset-l4">

      <form method="post" action="register.php" id="login">
        <h4>Zarejestruj konto</h4>
        <div class="input-group">
          <label>Login</label>
          <input type="text" name="username" value="<?php echo $username; ?>">
        </div>
        <div class="input-group">
          <label>Email</label>
          <input type="email" name="email" value="<?php echo $email; ?>">
        </div>
        <div class="input-group">
          <label>Hasło</label>
          <input type="password" name="password_1">
        </div>
        <div class="input-group">
          <label>Potwierdź hasło</label>
          <input type="password" name="password_2">
        </div>
        <div class="input-group">
          <button type="submit" class="btn waves-effect orange" name="reg_user">Zarejestruj</button>
        </div>
        <p>
          Masz już konto? <a class="orange-text" href="login.php">Zaloguj</a>
        </p>
      </form>
    </div>
  </div>
  <?php
  include('footer.php');
  ?>
  <script type="text/javascript" src="js/error.js"></script>
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
<?php if (count($errors) > 0) : ?>
    <?php foreach ($errors as $error) : ?>
    <script type="text/javascript">
      var val = "<?php echo $error ?>";
      call(val);
    </script>

    <?php endforeach ?>
<?php endif ?>
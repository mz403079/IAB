<?php include('server.php') ?>
  <!DOCTYPE html>
  <html>
  <head>
    <title>Rejestracja</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link type="text/css" rel="stylesheet" href="materialize/css/materialize.css"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  </head>
  <body>

  <?php include("navigation.php"); ?>
  <div class="container">
    <div class="header">
      <h2>Rejestracja</h2>
    </div>

    <form method="post" action="register.php" id="login">
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
        <button type="submit" class="btn" name="reg_user">Zarejestruj</button>
      </div>
      <p>
        Masz już konto?? <a href="login.php">Zaloguj</a>
      </p>
    </form>
  </div>
  <script type="text/javascript" src="js/error.js"></script>
  <script type="text/javascript" src="materialize/js/materialize.js"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"
          integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
          crossorigin="anonymous"></script>

  </body>
  </html>
<?php if (count($errors) > 0) : ?>
    <?php foreach ($errors as $error) : ?>
    <script type="text/javascript">
      var val = "<?php echo $error ?>";
      console.log(val);
      call(val);
    </script>

    <?php endforeach ?>
<?php endif ?>
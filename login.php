<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
	<title>Logowanie</title>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="style.css">
  <link type="text/css" rel="stylesheet" href="materialize/css/materialize.css"/>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<?php include("navigation.php"); ?>
<div class="container row">
  <div class="wrapper col s12 m6 offset-m3 l4 offset-l4">

	<form method="post" action="login.php" id="login">
    <h4>Zaloguj się</h4>
		<div class="input-group">
			<label>Login</label>
			<input type="text" name="username" >
		</div>
		<div class="input-group">
			<label>Hasło</label>
			<input type="password" name="password">
		</div>
		<div class="input-group">
			<button type="submit" class="btn waves-effect orange" name="login_user">Login</button>
		</div>
		<p>
			Nie masz konta? <a class="orange-text" href="register.php">Zarejestruj</a>
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
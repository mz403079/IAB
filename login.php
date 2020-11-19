<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
	<title>Logowanie</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<?php include("navigation.php"); ?>
<div class="content">
	<div class="header">
		<h2>Login</h2>
	</div>

	
	<form method="post" action="login.php" id="login">

		<?php include('errors.php'); ?>

		<div class="input-group">
			<label>Login</label>
			<input type="text" name="username" >
		</div>
		<div class="input-group">
			<label>Hasło</label>
			<input type="password" name="password">
		</div>
		<div class="input-group">
			<button type="submit" class="btn" name="login_user">Login</button>
		</div>
		<p>
			Nie masz konta? <a href="register.php">Zarejestruj</a>
		</p>
	</form>
</div>

</body>
</html>
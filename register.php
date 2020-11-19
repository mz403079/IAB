<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
	<title>Rejestracja</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<?php include("navigation.php"); ?>
<div class="content">
	<div class="header">
		<h2>Rejestracja</h2>
	</div>
	
	<form method="post" action="register.php" id="login">

		<?php include('errors.php'); ?>

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
</body>
</html>
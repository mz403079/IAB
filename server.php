<?php
session_start();

// variable declaration
$username = "";
$email = "";
$errors = array();
$_SESSION['success'] = "";

// connect to database
$db = pg_connect("host=localhost dbname=AlbumyDB user=postgres password=root")
or die('Could not connect: ' . pg_last_error());

// REGISTER USER
if (isset($_POST['reg_user'])) {
    $username = pg_escape_string($db, $_POST['username']);
    $email = pg_escape_string($db, $_POST['email']);
    $password_1 = pg_escape_string($db, $_POST['password_1']);
    $password_2 = pg_escape_string($db, $_POST['password_2']);

    if (empty($username)) {
        array_push($errors, "Nie podałeś loginu!");
    }
    if (empty($email)) {
        array_push($errors, "Nie podałeś email-a!");
    }
    if (empty($password_1)) {
        array_push($errors, "Nie podałeś hasła!");
    }

    if ($password_1 != $password_2) {
        array_push($errors, "Hasła się nie zgadzają!");
    }
    $user_check_query = "SELECT * FROM uzytkownicy WHERE login='$username' OR email='$email' LIMIT 1";
    $result = pg_query($db, $user_check_query);
    $user = pg_fetch_row($result);

    if ($user) { // if user exists
        if ($user[1] === $username) {
            array_push($errors, "Ten login jest zajęty!");
        }

        if ($user[3] === $email) {
            array_push($errors, "Istnieje już konto o podanym emailu!");
        }
    }
    if (count($errors) == 0) {
        $password = md5($password_1);
        $query = "INSERT INTO uzytkownicy (id_uzytkownika, login, haslo, email, rola) 
					  VALUES(DEFAULT,'$username', '$password','$email','user')";
        pg_query($db, $query) or die('Query failed: ' . pg_last_error());
        pg_query($db, "SELECT id_uzytkownika FROM uzytkownicy WHERE login = '$username'") or die('Query failed: ' . pg_last_error());
        $row = pg_fetch_row($result);
        $user_id = $row[0];
        $_SESSION['username'] = $username;
        $_SESSION['success'] = "Jesteś zarejestrowany!";
        $_SESSION['userID'] = $row[0];
        header('location: profil.php');
    }
}


// LOGIN USER
if (isset($_POST['login_user'])) {
    $username = pg_escape_string($db, $_POST['username']);
    $password = pg_escape_string($db, $_POST['password']);

    if (empty($username)) {
        array_push($errors, "Nie podałeś loginu!");
    }
    if (empty($password)) {
        array_push($errors, "Nie podałeś hasła!");
    }

    if (count($errors) == 0) {
        $password = md5($password);
        $query = "SELECT * FROM uzytkownicy WHERE login='$username' AND haslo='$password'";
        $results = pg_query($db, $query);

        if (pg_num_rows($results) == 1) {
            $_SESSION['username'] = $username;
            $_SESSION['success'] = "Zalogowałeś się!";
            pg_query($db, "SELECT id_uzytkownika FROM uzytkownicy WHERE login = '$username'") or die('Query failed: ' . pg_last_error());
            $result = pg_query($db, $query);
            $row = pg_fetch_row($result);
            $user_id = $row[0];
            $_SESSION['userID'] = $row[0];
            header('location: profil.php');
            exit();
        } else {
            array_push($errors, "Zły login lub hasło");
        }
    }
}

<?php
include('server.php');
$is_logged = 0;
if ($_SESSION['username']) {

    $user_check = $_SESSION['username'];

    $result = pg_query($db, "SELECT * FROM uzytkownicy WHERE login='$user_check' ");

    while ($row = pg_fetch_row($result)) {
        if ($row[4] == 'admin')
            $is_logged = 2;
        else
            $is_logged = 1;
    }

}

?>
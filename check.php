<?php
include('server.php');
$is_logged = 0;
if ($_SESSION['username']){

    $user_check = $_SESSION['username'];

    $result = pg_query($db,"SELECT login FROM uzytkownicy WHERE login='$user_check' ");

    while($row=pg_fetch_row($result));

    if(empty($row))
    {
        $is_logged = 1;
    }
}

?>
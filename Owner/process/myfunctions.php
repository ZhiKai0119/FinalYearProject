<?php
function redirect($url, $message) {
    setcookie("status", $message, time()+1, "/", NULL);
    header('Location: '.$url);
    exit();
}
?>
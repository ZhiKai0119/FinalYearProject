<?php
function redirect($url, $message) {
    setcookie("status", $message, time()+1, "/", NULL);
    header('Location: '.$url);
    exit();
}

function errorRedirect($url, $message) {
    setcookie("failureStatus", $message, time()+1, "/", NULL);
    header('Location: '.$url);
    exit();
}
?>
<?php

header('Content-Type: text/xml');

$HTML = "";


session_start();
if (isset($_POST["logout"])) {

    session_unset();
    session_destroy();
    $_SESSION = array();

    $HTML = "<br><span class='confirmed'>You are successfully logged out!</span></br>";
    echo $HTML;
}

?>
<?php

// Definition and writing of the server's URI
if (!empty ($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
    $uri = 'https://';
} else {
    $uri = 'http://';
}
$uri .= $_SERVER['HTTP_HOST'];

// Redirection to the Home page
header("Location: " . $uri . "/templates/home.php");
exit();

?>
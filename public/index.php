<?php

require $_SERVER["DOCUMENT_ROOT"] . "/../src/Configs/index.php";

$url = strtok(string: $_SERVER["REQUEST_URI"], token: "?");
$router->render(url: $url);

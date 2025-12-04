<?php

include "generic/Autoload.php";
include "imports/vendor/autoload.php";

use generic\Controller;


$rota = $_GET["param"];
$controller = new Controller();
$controller->verificarChamadas($rota);

<?php

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/../src/routes/routes.php";
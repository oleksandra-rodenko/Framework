<?php
require_once __DIR__ . '/Components/Autoloader.php';
$autoloader = new \Components\Autoloader(__DIR__);

use Components\Application;
$controller = new Application(__DIR__);
?>


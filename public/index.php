<?php 
require_once dirname(__DIR__) . "/config/init.php";
require_once HELPERS . "/functions.php";
require_once CONFIG . "/routes.php";

if (PHP_MAJOR_VERSION < 8){
    die();
}
new \dopler_core\App();


?>

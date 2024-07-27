<?php

define("DEBUG", true);

define("ROOT", dirname(__DIR__));
define("WWW", ROOT . "/public");
define("APP", ROOT . "/app");
define("CORE", ROOT . "/vendor/dopler_core");
define("HELPERS", ROOT . "/vendor/dopler_core/helpers");
define("CACHE", ROOT . "/tmp/cache");
define("LOGS", ROOT .  "/tmp/logs");
define("CONFIG", ROOT . "/config");

define("LAYOUT", "ishop");
define("PATH", "http://dopler");
define("ADMIN", "http://dopler/admin");
define("NO_IMAGE", "/uploads/no_image.jpg");

require_once ROOT . "/vendor/autoload.php";
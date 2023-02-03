<?php

use Felix\StudyProject\Controller;

if (preg_match('/\.(?:png|jpg|jpeg|gif|css|js)$/', $_SERVER["REQUEST_URI"])) {
    return false;    // serve the requested resource as-is.
}
require_once __DIR__ . '/../vendor/autoload.php';

(new Controller())->process();
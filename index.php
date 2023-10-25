<?php
date_default_timezone_set('America/Mexico_City');
error_reporting(E_ALL);

ini_set('ignore_repeated_errors', TRUE);
ini_set('display_errors', FALSE);
ini_set('log_errors', TRUE); 
ini_set("error_log", (__DIR__) . "/php-error.log");

require 'vendor/autoload.php';
require 'src/core/routes.php';
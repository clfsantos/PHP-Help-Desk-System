<?php

session_start();

include 'Conexao.php';

define('HOME_URI', 'http://' . $_SERVER['SERVER_NAME'] . '/sgsti/src');
define('ABSPATH', dirname(__FILE__));
define('REQUIRE_PATH', '/pages');

$getURL = strip_tags(trim(filter_input(INPUT_GET, 'url', FILTER_DEFAULT)));
$setURL = (empty($getURL) ? 'home' : $getURL);
$url = explode('/', $setURL);

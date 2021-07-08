<?php

session_cache_expire(86400);
session_start();

include '../Conexao.php';
include '../geral.conf.php';

define('HOME_URI', $home_uri);
define('ABSPATH', dirname(__FILE__));

define('REQUIRE_PATH', '/pages');

$getURL = strip_tags(trim(filter_input(INPUT_GET, 'url', FILTER_DEFAULT)));
$setURL = (empty($getURL) ? 'home' : $getURL);
$url = explode('/', $setURL);

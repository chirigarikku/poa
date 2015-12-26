<?php

require_once('helpers.php');
require_once('Application.php');

$app = new Application();

$app->middleware(function($next) {
	echo 1 . PHP_EOL;
	return $next();
});

$app->middleware(function($next) {
	echo 2 . PHP_EOL;
	return $next();
});

$app->middleware(function($next) {
	var_dump($this);
	return $next();
});

$app->run();
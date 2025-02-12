<?php

// phpinfo();

// ini_set('memory_limit','225M');

// echo ini_get('memory_limit');


include __DIR__ . "/../src/App/functions.php"; // Include helper functions

$app = include __DIR__ . "/../src/App/bootstrap.php"; // Bootstrap the application nitializes the application and returns an instance of the App class.

$app->run(); // Run the application  Calls the run() method on the $app object to start the application
<?php


declare(strict_types=1);


require __DIR__ . "/../../vendor/autoload.php"; // Autoload dependencies via Composer

use Framework\App;
use App\Config\Paths;

use function App\Config\{registerRoutes, registerMiddleware};

$app = new App(Paths::SOURCE . "app/container-definitions.php"); // Create a new instance of the App class

registerRoutes($app);
registerMiddleware($app);

// $app->get('/',[AboutController::class,'about']); // Define a route for the root path

//dd($app); // Debugging: Dump the app object and stop execution

return $app; // Return the app instance 
<?php

use App\Controllers\RecipeController;
use App\Models\Recipe;
use App\Services\Database;
use FastRoute\RouteCollector;
use FastRoute\Dispatcher;

require_once __DIR__ . '/../vendor/autoload.php';

$db = new Database();
$recipeController = new RecipeController(new Recipe($db));

$dispatcher = FastRoute\simpleDispatcher(function (RouteCollector $r) use ($recipeController) {
    $r->addRoute('GET', '/recipes', [$recipeController, 'index']);
    $r->addRoute('GET', '/recipes/{id:\d+}', [$recipeController, 'show']);
    $r->addRoute('POST', '/recipes', [$recipeController, 'store']);
    $r->addRoute('PUT', '/recipes/{id:\d+}', [$recipeController, 'update']);
    $r->addRoute('DELETE', '/recipes/{id:\d+}', [$recipeController, 'destroy']);
});

// Fetch method and URI from the server request
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
$uri = parse_url($uri, PHP_URL_PATH);
$uri = rawurldecode($uri);

// Dispatch the request to the appropriate route handler
$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {
    case Dispatcher::NOT_FOUND:
        http_response_code(404);
        echo json_encode(['error' => 'Not Found']);
        break;
    case Dispatcher::METHOD_NOT_ALLOWED:
        http_response_code(405);
        echo json_encode(['error' => 'Method Not Allowed']);
        break;
    case Dispatcher::FOUND:
        [$handler, $vars] = $routeInfo[1];
        // Call the handler with the route variables
        call_user_func_array($handler, [$vars]);
        break;
}

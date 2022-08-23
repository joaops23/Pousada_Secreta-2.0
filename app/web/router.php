<?php 

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use Slim\Routing\RouteCollectorProxy;


$app = AppFactory::create();

$app->addRoutingMiddleware();

$errorMiddleware = $app->addErrorMiddleware(true, true, true);

$twig = Twig::create('../app/views', ['cache' => false]);
$app->add(TwigMiddleware::create($app, $twig));

$app->get('/', function(Request $request, Response $response, $args){
    $view = Twig::fromRequest($request);
    return $view->render($response, 'index.html.twig');
})->setName("index");

$app->group('/views', function(RouteCollectorProxy $group){

    $group->get('/style', function(Request $request, Response $response, $args){
        $view = Twig::fromRequest($request);
        return $view->render('style.css');
    });
});

$app->run();

?>
<?php
// Routes

$app->get('/[{name}]', function ($request, $response, $args) use ($app){

    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});

$app->get('/search/{name}', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});

$app->get('/language/{name}', function(\Slim\Http\Request $request,\Slim\Http\Response $response, $args) {

    $user = new \App\Model\User();

    $user->setLanguage('fr');

    $userLanguage = $user->getLanguage();

    $response->write($userLanguage);

    return $response;
});

$app->get('/language/get/1', function(\Slim\Http\Request $request,\Slim\Http\Response $response, $args) {

    $userLanguage = $_SESSION['language'];
    $response->write($userLanguage);

    return $response;
});


$app->get('/phpinfo/get', function(\Slim\Http\Request $request,\Slim\Http\Response $response, $args) {


    $response->write(phpinfo());

    return $response;
});

<?php
// Routes


use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

$app->get(
    '/',
    function ($request, $response, $args) use ($app) {

        // Sample log message
        $this->logger->info("Slim-Skeleton '/' route");

        // Render index view
        return $this->renderer->render($response, 'index.phtml', $args);
    }
);


$app->get(
    '/phpinfo',
    function (\Slim\Http\Request $request, \Slim\Http\Response $response, $args) {

        $response->getBody(phpinfo());

        return $response;
    }
);

$app->get(
    '/wines',
    function ($request, $response, $args) {


        $statement = $this->pdo->prepare('SELECT * FROM wine ORDER BY name ');

        $statement->execute();

        $wines = $statement->fetchAll(PDO::FETCH_OBJ);

        return $response->withJson($wines);


    }
);

$app->get(
    '/wine/{id}',
    function ($request, $response, $args) {


        $id = $args['id'];

        $this->logger->info("Slim-Skeleton '/wine/$id' route");


        $statement = $this->pdo->prepare('SELECT * FROM wine where id = :id');

        $statement->bindValue(':id', $id);

        $statement->execute();

        $wine = $statement->fetch(PDO::FETCH_ASSOC);

        return $response->withJson($wine);

    }
);

$app->get(
    '/wines/search/{searchKey}',
    function ($request, $response, $args) {

        $searchKey = $args['searchKey'];


        $this->logger->info("Slim-Skeleton '/wines/$searchKey' route");

        $statement = $this->pdo->prepare('SELECT * FROM wine WHERE UPPER(name) LIKE :searchKey ORDER BY name');

        $statement->bindValue(':searchKey', '%'.$searchKey.'%');

        $statement->execute();

        $wines = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $response->withJson($wines);
    }
);

$app->post('/wine',function($request,$response,$args){

    $wine = json_decode($request->getBody());

    $sql = "INSERT INTO wine (name, grapes, country, region, year, description) VALUES (:name, :grapes, :country, :region, :year, :description)";
    $statement = $this->pdo->prepare($sql);

    $statement->bindParam(':name',$wine->name);
    $statement->bindParam(':grapes',$wine->grapes);
    $statement->bindParam(':country',$wine->country);
    $statement->bindParam(':region',$wine->region);
    $statement->bindParam(':year',$wine->year);
    $statement->bindParam(':description',$wine->descrition);
    $statement->execute();
    $wine->id =  $this->pdo->lastInsertId();

    $response = $response->withJson($wine);

    return $response;



});
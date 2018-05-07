<?php

    require '../../vendor/autoload.php';
    use Slim\Http\Request;
    use Slim\Http\Response;
    $app = new \Slim\App;
    $app->get('/fbplaces', function (Request $request, Response $response, array $args) {
        
        //$lat = $args['lat'];
       // $lgn = $args['lng'];

        $places = new Beltrao\v1\domain\FacebookPlaces();

        

        $response->getBody()->write($places->getPlaces());

        return $response;
    });


    $app->run();
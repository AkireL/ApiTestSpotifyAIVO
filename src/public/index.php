<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../../vendor/autoload.php';
require '../bussines/AlbumsByArtist.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();
$dotenv->required(['SPOTIFY_CLIENT_ID', 'SPOTIFY_CLIENT_SECRET']);

$app = new \Slim\App;

$app->get('/api/v1/albums', function (Request $request, Response $response) {
    $nameArtist = $request->getQueryParams()['q'];
    $bussines = new AlbumsByArtist();
    $data = $bussines->execute($nameArtist);
    return $response->withJson( $data );
});




$app->post('/callback', function (Request $request, Response $response) {
    $arrays = $request->getParsedBody();

    $f = fopen(__DIR__ . "/archivo_". uniqid() .'.json', 'rw');
    fwrite($f, json_encode($arrays));
    fclose($f);
    
    $response->getBody()->write(json_encode(['mensaje'=>'ok' ]));
    return $response;
});
$app->run();
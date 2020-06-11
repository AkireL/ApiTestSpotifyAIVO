<?php
require '../../vendor/autoload.php';

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use App\Bussines\ManagerAlbumsArtist;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();
$dotenv->required(['SPOTIFY_CLIENT_ID', 'SPOTIFY_CLIENT_SECRET']);

$app = new \Slim\App;

$app->get('/api/v1/albums', function (Request $request, Response $response) {
    try{
        if(!isset($request->getQueryParams()['q'])){
            throw new Exception('Parameter "q" is required', 400);
        }
        $nameArtist = $request->getQueryParams()['q'];

        $usecase = new ManagerAlbumsArtist();
        $data = $usecase($nameArtist);

        return $response->withJson( $data );
    }catch(Exception $ex){
        $code = (int)$ex->getCode();

        if($code < 400 || $code > 503){
            $code = 500;
        }

        return $response->withJson(["error"=> $ex->getMessage(), "code" => $ex->getCode()], $code);
    }
    
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
<?php
require "../vendor/autoload.php";
use App\Services\AuthSpotifyService;
/**
 * Test Log In
 * @author Erika Leonor Basurto Munguia <iamdleonor@gmail.com>
 * @version 1.0.0
 */
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();
$dotenv->required(['SPOTIFY_CLIENT_ID', 'SPOTIFY_CLIENT_SECRET']);

$n = new AuthSpotifyService($_ENV['SPOTIFY_CLIENT_ID'], $_ENV['SPOTIFY_CLIENT_SECRET']);

$data = $n->getToken();

print_r($data['statusCode'] == 200 ? $data['data']->access_token : $data['data']->error_description);
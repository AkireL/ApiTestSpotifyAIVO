<?php
require "../vendor/autoload.php";
require "../src/services/AuthSpotifyService.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();
$dotenv->required(['SPOTIFY_CLIENT_ID', 'SPOTIFY_CLIENT_SECRET']);

$n = new AuthSpotifyService($_ENV['SPOTIFY_CLIENT_ID'], $_ENV['SPOTIFY_CLIENT_SECRET']);

$data = $n->getToken();

print_r($data['statusCode'] == 200 ? $data['data']->access_token : $data['data']->error_description);
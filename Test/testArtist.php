<?php
require "../vendor/autoload.php";
use App\Services\ArtistSpotifyService;

$token = "<jwt>";
$n = new ArtistSpotifyService($token);
$data = $n->SearchArtist("no existe");

print_r($data);
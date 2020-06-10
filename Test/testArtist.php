<?php
require "../vendor/autoload.php";
require "../src/services/ArtistSpotifyService.php";

$token = "<jwt>";
$n = new ArtistSpotifyService($token);
$data = $n->SearchArtist("no existe");

print_r($data);
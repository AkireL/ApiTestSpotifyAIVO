<?php
require "../vendor/autoload.php";
use App\Services\AlbumSpotifyService;

$token = "<jwt>";
$n = new AlbumSpotifyService($token);
$data = $n->SearchArtistAlbums("<id_Artist>");

print_r($data);
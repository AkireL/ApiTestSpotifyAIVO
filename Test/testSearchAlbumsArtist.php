<?php
require "../vendor/autoload.php";
require "../src/services/AlbumSpotifyService.php";

$token = "<jwt>";
$n = new AlbumSpotifyService($token);
$data = $n->SearchArtistAlbums("<id_Artist>");

print_r($data);
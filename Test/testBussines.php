<?php
require "../vendor/autoload.php";
use App\Bussines\AlbumsByArtist;

$a = new AlbumsByArtist();
$response = $a->execute("codplay");
echo json_encode($response, JSON_PRETTY_PRINT).PHP_EOL ;
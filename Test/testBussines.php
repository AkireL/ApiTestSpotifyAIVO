<?php
require "../vendor/autoload.php";
require "../src/bussines/AlbumsByArtist.php";

$a = new AlbumsByArtist();
$response = $a->execute("codplay");
echo json_encode($response, JSON_PRETTY_PRINT).PHP_EOL ;
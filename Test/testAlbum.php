<?php
require "../vendor/autoload.php";
use App\Bussines\AlbumsByArtist;
/**
 * Test Album
 * @author Erika Leonor Basurto Munguia <iamdleonor@gmail.com>
 * @version 1.0.0
 */
$a = new AlbumsByArtist();
$response = $a->execute("codplay");
echo json_encode($response, JSON_PRETTY_PRINT).PHP_EOL ;
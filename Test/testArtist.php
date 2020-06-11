<?php
require "../vendor/autoload.php";
use App\Services\ArtistSpotifyService;
/**
 * Test Artist
 * @author Erika Leonor Basurto Munguia <iamdleonor@gmail.com>
 * @version 1.0.0
 */

$token = "<jwt>";
$n = new ArtistSpotifyService($token);
$data = $n->SearchArtist("no existe");

print_r($data);
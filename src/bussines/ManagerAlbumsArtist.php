<?php
namespace App\Bussines;

use App\Services\AuthSpotifyService;
use App\Services\ArtistSpotifyService;
use App\Services\AlbumSpotifyService;
use \Exception;

/**
 * Manager 
 * @author Erika Leonor Basurto Munguia <iamdleonor@gmail.com>
 * @version 1.0.0
 */
class ManagerAlbumsArtist
{
    public function __invoke(string $artistName) {
        $authSpotifyService = new AuthSpotifyService($_ENV['SPOTIFY_CLIENT_ID'], $_ENV['SPOTIFY_CLIENT_SECRET']);
        # 1. Log In: get Token
        $responseToken = $authSpotifyService->getToken();

        if($responseToken['statusCode'] != 200){
            throw new Exception($responseToken['data']->error_description);
        }
        $token = $responseToken['data']->access_token;

        $artistService = new ArtistSpotifyService($token);
        $albumService = new AlbumSpotifyService($token);

        return (new AlbumsByArtist($artistService, $albumService))->execute($artistName);
    }

}

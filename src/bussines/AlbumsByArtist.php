<?php
namespace App\Bussines;
use App\Services\AuthSpotifyService;
use App\Services\AlbumSpotifyService;
use App\Services\ArtistSpotifyService;

use \Exception;

class AlbumsByArtist
{
    private $authService = null;
    
    public function __construct(){
        $this->authService = new AuthSpotifyService($_ENV['SPOTIFY_CLIENT_ID'], $_ENV['SPOTIFY_CLIENT_SECRET']);
    }

    public function execute(string $artistName){
        # 1. Log In: get Token
        $responseToken = $this->authService->getToken();

        if($responseToken['statusCode'] != 200){
            throw new Exception($responseToken['data']->error_description);
        }
        $token = $responseToken['data']->access_token;

        # 2. Search Artist's Id
        $artistService = new ArtistSpotifyService($token);
        $responseArtist = $artistService->SearchArtist($artistName);
        if($responseArtist["statusCode"] != 200){
            throw new Exception($responseArtist['data']->error_description);
        }
        if(Count($responseArtist["data"]->artists->items) <= 0){
            throw new Exception("Artist not found", 404);
        }
        $artist = $responseArtist["data"]->artists->items[0];
        $IdArtist = $artist->id;

        # 3. Search Artist's Albums
        $albumService = new AlbumSpotifyService($token);
        $responseAlbums = $albumService->SearchArtistAlbums($IdArtist);
        if($responseAlbums["statusCode"] != 200){
            throw new Exception($responseAlbums['data']->error->message, $responseAlbums['data']->error->status );
        }
        
        return array_map(function($row){
            return [
                "name" => $row->name
                , "released" => $row->release_date
                , "tracks" => $row->total_tracks
                , "cover" => [
                    "height" => $row->images[0]->height
                    , "width" => $row->images[0]->width
                    , "url" => $row->images[0]->url
                ]
            ];
        },
        $responseAlbums["data"]->items);
    }
    
}

<?php
require __DIR__ . "/../services/AuthSpotifyService.php";
require __DIR__ . "/../services/AlbumSpotifyService.php";
require __DIR__ . "/../services/ArtistSpotifyService.php";

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
        $artist = $responseArtist["data"]->artists->items[0];
        $IdArtist = $artist->id;

        # 3. Search Artist's Albums
        $albumService = new AlbumSpotifyService($token);
        $responseAlbums = $albumService->SearchArtistAlbums($IdArtist);
        if($responseAlbums["statusCode"] != 200){
            throw new Exception($responseAlbums['data']->error_description);
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

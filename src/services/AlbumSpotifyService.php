<?php
namespace App\Services;

use GuzzleHttp\Client;
use App\Services\IAlbumService;

/**
 * Operations with Albums by artist API Spotify 
 * @author Erika Leonor Basurto Munguia <iamdleonor@gmail.com>
 * @version 1.0.0
 */
class AlbumSpotifyService implements IAlbumService
{
    private $client = null;
    private $token = null;
    public function __construct(string $token){
        $this->client = new Client(['http_errors' => false]);
        $this->token = $token;
    }
    
    public function SearchAlbumsByArtist(string $IdArtist) {
        $response = $this->client->request('get', "https://api.spotify.com/v1/artists/{$IdArtist}/albums", [
            'headers' => ["Authorization" => "Bearer {$this->token}"],            
        ]);

        $statusCode = (int) $response->getStatusCode();
        $data = json_decode( (string) $response->getBody() );

        return[
            "statusCode" => $statusCode
            ,"data" => $data
        ];
    }
}

<?php
namespace App\Services;
use GuzzleHttp\Client;
use App\Services\IArtistService;

/**
 * API Spotify Operations with Artist
 * @author Erika Leonor Basurto Munguia <iamdleonor@gmail.com>
 * @version 1.0.0
 */
class ArtistSpotifyService implements IArtistService
{
    private $client = null;
    private $token = null;
    public function __construct(string $token){
        $this->client = new Client(['http_errors' => false]);
        $this->token = $token;
    }
    
    public function SearchArtist(string $ArtistName)  {
        $response = $this->client->request('get', 'https://api.spotify.com/v1/search', [
            'headers' => ["Authorization" => "Bearer {$this->token}"],
            "query" => [
                "q" => $ArtistName,
                "type" => "artist"
            ]
        ]);

        $statusCode = (int) $response->getStatusCode();
        $data = json_decode( (string) $response->getBody() );

        return["statusCode" => $statusCode
                ,"data" => $data];
    }
}

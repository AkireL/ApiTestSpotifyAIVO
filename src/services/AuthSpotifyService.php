<?php
namespace App\Services;
use GuzzleHttp\Client;

class AuthSpotifyService{
    private $client = null;
    private $user = null;
    private $pass = null;
    public function __construct($user, $pass){
        $this->client = new Client(['http_errors' => false]);
        $this->user = $user;
        $this->pass = $pass;
    }

    public function getToken(){
        $response = $this->client->request(
            'post'
            , 'https://accounts.spotify.com/api/token'
            , [
                'auth' => [$this->user, $this->pass],
                "form_params" => [
                                    "grant_type" => "client_credentials"
                                ]
            ]
        );

        $statusCode = (int) $response->getStatusCode();
        $data = json_decode( (string) $response->getBody() );

        return[
            "statusCode" => $statusCode,
            "data" => $data
        ];
    }
}
<?php
namespace App\Bussines;

use App\Services\IAlbumService;
use App\Services\IArtistService;
use \Exception;

/**
 * Get Albums by artist
 * @author Erika Leonor Basurto Munguia <iamdleonor@gmail.com>
 * @version 1.0.0
 */

class AlbumsByArtist
{    
    private $albumService = null;
    private $artistService = null;
    
    public function __construct(IArtistService $artistService, IAlbumService $albumService){
        $this->albumService = $albumService;
        $this->artistService = $artistService;
    }

    public function execute(string $artistName){
        # Search Artist's Id
        $responseArtist = $this->artistService->SearchArtist($artistName);
        if($responseArtist["statusCode"] != 200){
            throw new Exception($responseArtist['data']->error_description);
        }
        if(Count($responseArtist["data"]->artists->items) <= 0){
            throw new Exception("Artist not found", 404);
        }
        $artist = $responseArtist["data"]->artists->items[0];
        $IdArtist = $artist->id;

        # Search Artist's Albums
        $responseAlbums = $this->albumService->SearchAlbumsByArtist($IdArtist);
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

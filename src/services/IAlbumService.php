<?php
namespace App\Services;
/**
 * Interface Album's operations
 * @author Erika Leonor Basurto Munguia <iamdleonor@gmail.com>
 * @version 1.0.0
 */
interface IAlbumService{
    public function SearchAlbumsByArtist(string $IdArtist);

}
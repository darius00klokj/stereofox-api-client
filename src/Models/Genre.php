<?php

namespace SFAPI\Models;

use App\Http\Controllers\GenresController;
use SFAPI\ApiGenresGet;

/**
 * Description of Genre
 *
 * @author darius
 */
class Genre
{
    public $id;
    public $name;
    public $slug;
    public $description;
    public $image;
    public $color;

    /**
     *
     * @var Tracks[]
     */
    public $tracks;

    /**
     *
     * @var PlaylistStream[]
     */
    public $playlists;

    /**
     * Meta heads
     * 
     * @var type
     */
    public $head;

    const GENRE_ID_TRACKS     = 34;
    const GENRE_ID_HIPHOP     = 4751;
    const GENRE_ID_ELECTRONIC = 2;

    /**
     * Returns the url of the genre.
     * 
     * @return  url    url to the genre.
     */
    public function getURL(): string
    {
        return surl(sprintf('/%s/%s/', GenresController::URI, $this->getSlug()));
    }

    /**
     * Return the URL for a list of tracks of a genre.
     * 
     * @param   string    The time frame.
     * @return  string    The URL to the list of tracks of a genre in a time frame.
     */
    public function getListURL($timeframe): string
    {
        return surl(sprintf('/%s/%s/%s', GenresController::URI, $this->getSlug(), $timeframe));
    }

    public function __construct(mixed $jsonPost)
    {
        if ($jsonPost) {
            $this->populate($jsonPost);
        }
    }

    /**
     * Fills genre object with the response data.
     *  
     * @param array $jsonPost  API JSON response
     * @return boolean
     */
    public function populate(mixed $jsonPost)
    {

        $jsonPost = is_array($jsonPost) ? (object) $jsonPost : $jsonPost;
        if (!$jsonPost || !isset($jsonPost->id)) {
            return false;
        }

        foreach ($jsonPost as $property => $value) {
            if (property_exists(static::class, $property)) {
                $this->{$property} = $value;
            }
        }

        /**
         * Populates the playlists contained in the GenreGet response
         */
        if ($this->playlists) {
            $jsonPlaylists   = $this->playlists;
            $this->playlists = [];
            foreach ($jsonPlaylists as $playlist) {
                $this->playlists[] = new PlaylistStream($playlist);
            }
        }
    }

    /**
     * Returns a single post.
     * 
     * @param  string  $slug
     * @return ?Genre  Author object or nullx
     */
    public static function fetchBySlug(string $slug): ?object
    {
        /**
         * Init the API for posts
         */
        $api = new GenresGet();

        /**
         * Fetch the single JSON
         */
        $jsonPost = $api->single($slug);

        if (!$jsonPost || !isset($jsonPost->{0})) {
            /**
             * When view controller reads NULL, then 404 the request.
             */
            return null;
        }

        return new Genre($jsonPost->{0});
    }
    /*
      |--------------------------------------------------------------------------
      | Getters and Setters
      |--------------------------------------------------------------------------
     */

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id

     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name

     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get the value of slug
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set the value of slug

     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * Get the value of description
     */
    public function getDescription()
    {
        return base64_decode($this->description);
    }

    /**
     * Set the value of description

     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get the value of image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set the value of image

     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * Get the value of color
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set the value of color
     */
    public function setColor($color)
    {
        $this->color = $color;
    }

    /**
     * Get the value of tracks
     *
     * @return Track[]
     */
    public function getTracks()
    {
        return $this->tracks;
    }

    /**
     * Set the value of tracks
     *
     * @param  Tracks[]  $tracks
     */
    public function setTracks(array $tracks)
    {
        $this->tracks = $tracks;
    }

    /**
     * Get the value of playlists
     *
     * @return  PlaylistStream[]
     */
    public function getPlaylists()
    {
        return $this->playlists;
    }

    /**
     * Set the value of playlists
     *
     * @param  PlaylistStream[]  $playlists
     */
    public function setPlaylists(array $playlists)
    {
        $this->playlists = $playlists;
    }

    public function getHead() {
        return $this->head;
    }

    public function setHead($head) {
        $this->head = $head;
    }

}

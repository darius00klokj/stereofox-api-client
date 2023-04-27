<?php

namespace SFAPI\Models;

use App\Http\Controllers\ArtistController;
use SFAPI\Api\PostsGet;
use SFAPI\Api\ArtistsGet;
use SFAPI\Models\Track;

/**
 * Description of Artist
 * Example:
 * https://www.stereofox.com/?api=eyAiYWN0aW9uIjogImdldF9wb3N0cyIsICJwYXJhbXMiOiB7ICJ0eXBlIjogImFydGlzdCIsICJzbHVnIjoiYW1wbGlmaWVkIiB9fQ==
 * 
 * @author darius
 */
class Artist extends PostType {
    public $role;
    public $pos;

    /**
     * List of tracks from this artist.
     * 
     * @var Track[]
     */
    public $tracks;

    /**
     * Articles of the artist
     * 
     * @var Article[]
     */
    public $articles = [];

    /**
     * The labels associated to this artist
     * 
     * @return Label[]
     */
    public $labels = [];

    public function getURL(): string {
        return ArtistController::getURL($this->getPost_name());
    }

    public function __construct(mixed $jsonPost) {
        if ($jsonPost) {
            $this->populate($jsonPost);
        }
    }

    /**
     * Returns the country of the artist.
     *
     * @return string
     */
    public function getCountry() {

        $metas = (object) $this->getMetas();
        if(!isset($metas->artist_country)){
            return '';
        }

        return $metas->artist_country[0];
    }

    /**
     *
     * @param mixed $jsonPost
     */
    public function populate(mixed $jsonPost) {
        parent::populate($jsonPost);

        if ($this->tracks) {
            $json_tracks  = $this->tracks;
            $this->tracks = [];
            foreach ($json_tracks as $track) {
                $this->tracks[] = new Track($track);
            }
        }

        if ($this->articles) {
            $arts  = $this->articles;
            $this->articles = [];
            foreach ($arts as $obj) {
                $this->articles[] = new Article($obj);
            }
        }

        if ($this->labels) {
            $arts  = $this->labels;
            $this->labels = [];
            foreach ($arts as $obj) {
                $this->labels[] = new Label($obj);
            }
        }
    }

    /**
     * 
     * @param string $sortby
     * @param int $max
     * @return Artist[]
     */
    public static function fetchList(string $sortby, int $page = 0, int $max = 25, $withCount = false): array {

        $api = new ArtistsGet();
        $api->setParam_sortby($sortby);
        $api->setParam_page($page);
        $api->setParam_max($max);
        $api->setParam_withCount($withCount ? 1 : 0);

        $posts = $api->list();

        return Artist::json2objects($posts);
    }

    public static function fetchBySlug(string $slug): ?Artist {
        /**
         * Init the API for posts
         */
        $api = new PostsGet();

        /**
         * Fetch the single JSON
         */
        $jsonPost = $api->single($slug, PostType::TYPE_ARTIST);

        if (!$jsonPost) {
            abort(404);
        }

        return new Artist($jsonPost);
    }
    /*
      |--------------------------------------------------------------------------
      | Getters and Setters
      |--------------------------------------------------------------------------
     */

    /**
     * Get the value of role
     * 
     * @return  string    The artists intern role.
     */
    public function getRole(): string {
        return $this->role;
    }

    /**
     * Set the value of role
     * 
     * @param  string  $role    The artists intern role.
     */
    public function setRole(string $role) {
        $this->role = $role;
    }

    /**
     * Get the value of pos
     * 
     * @return  int    The artists intern position.
     */
    public function getPos(): int {
        return $this->pos;
    }

    /**
     * Set the value of pos
     * 
     * @param  int  $pos    The artists intern position
     */
    public function setPos(int $pos) {
        $this->pos = $pos;
    }

    /**
     * Get list of tracks from this artist.
     *
     * @return  Track[]    An array of Track objects.
     */
    public function getTracks(): array {
        return $this->tracks;
    }

    /**
     * Set list of tracks from this artist.
     *
     * @param  array  $tracks    List of tracks from this artist.
     */
    public function setTracks(array $tracks) {
        $this->tracks = $tracks;
    }

    /**
     *
     * @return Article[]
     */
    public function getArticles(): array {
        return $this->articles;
    }

    /**
     *
     * @return Label[]
     */
    public function getLabels() {
        return $this->labels;
    }

    public function setArticles(array $articles): void {
        $this->articles = $articles;
    }

    public function setLabels($labels): void {
        $this->labels = $labels;
    }


}
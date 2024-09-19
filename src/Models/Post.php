<?php

namespace SFAPI\Models;

use SFAPI\Api\PostsGet;
use SFAPI\Models\Genre;
use SFAPI\Api\PostsGetRelated;

/**
 * We want to get all data from the API, a single post fetched as example:
 */
class Post extends PostType {
    /**
     * All post which are songs have a track. Other do not.
     * @var Track
     */
    public $track = null;

    /**
     *
     * @var Tracks[]
     */
    public $tracks = [];

    /**
     * List of genres where this post belongs to (WP categories).
     * @var Genre[]
     */
    public $genres = [];

    /**
     * List of artist of this post.
     * 
     * @var Artist[]
     */
    public $artists = [];

    /**
     *
     * @var PlaylistStream[]
     */
    public $playlistStreams = [];

    public function __construct(mixed $jsonPost) {
        if ($jsonPost) {
            $this->populate($jsonPost);
        }
        
    }

    /**
     * Fills object with the response data.
     *  
     * @param array $jsonPost  API JSON response
     * @return boolean
     */
    public function populate(mixed $jsonPost) {

        /**
         * Call parent function not to rewrite the wheal.
         */
        parent::populate($jsonPost);

        /**
         * Populates the track mnodel
         */
        if ($this->track) {
            $this->track = new Track($this->track);
        }

        /**
         * Populate the meta model.
         */
        //        if ($this->metas) {
        //            $json_metas = $this->metas;
        //            $this->metas = [];
        //            foreach ($json_metas as $meta) {
        //                $this->metas[] = new Image($meta);
        //            }
        //        }

        /**
         * Populate the artists model
         */
        if ($this->artists) {
            $json_artists  = $this->artists;
            $this->artists = [];
            foreach ($json_artists as $singleArtist) {
                $this->artists[] = new Artist($singleArtist);
            }
        }

        /**
         * If a playlist or artists we can get several tracks.
         */
        if ($this->tracks) {
            $json_tracks  = $this->tracks;
            $this->tracks = [];
            foreach ($json_tracks as $singleTrack) {
                $this->tracks[] = new Track($singleTrack);
            }
        }

        /**
         * If a playlist or artists we can get several tracks.
         */
        if ($this->playlistStreams) {
            $list                  = $this->playlistStreams;
            $this->playlistStreams = [];
            foreach ($list as $obj) {
                $this->playlistStreams[] = new PlaylistStream($obj);
            }
        }
    }

    /**
     * Returns a single post.
     * 
     * @param  string  $slug
     * @return ?Post   Post object or null.
     */
    public static function fetchBySlug(string $slug): ?Post {
        /**
         * Init the API for posts
         */
        $api = new PostsGet();

        /**
         * Fetch the single JSON
         */
        $jsonPost = $api->single($slug, PostType::TYPE_POST);

        if (!$jsonPost) {
            return null;
        }

        return new Post($jsonPost);
    }

    /**
     * Retrieves the tracks withing the given genre and time frame.
     * 
     * @param   string  $slug         The name of the genre.
     * @param   array   $timeframe    The time frame
     * @return  array            
     */
    public static function fetchByGenre($key, $times = [], $page = 1): ?array {
        $api = new PostsGet();

        $api->setParam_type(PostType::TYPE_POST);
        $api->setParam_genre($key);
        $api->setParam_page($page);

        if ($times) {
            $api->tracksWithinTimePeriod($times[0], $times[1]);
        }

        return Post::json2objects($api->list());
    }

    /**
     * Fetches popular songs withing a specific time period.
     * 
     * @param  string   $slug    Contains the time period.
     * @return ?Post[]            List of popular posts.
     */
    public static function fetchPopular(array $timeFrames, int $page = null, $withCount = false): ?array {
        $api = new PostsGet();

        $api->setParam_type(PostType::TYPE_POST);
        $api->setParam_page($page);
        $api->setParam_max(50);
        $api->setParam_withCount($withCount ? 1 : 0);

        if (empty($timeFrames)) {
            return null;
        }
        
        $api->tracksWithinTimePeriod($timeFrames[0], $timeFrames[1]);

        return Post::json2objects($api->list());
    }

    /**
     * The fetch all will serve as example, but rarely used
     * since we fetch based on genre, search etc...
     *
     * @return \SFAPI\Models\Post[]
     */
    public static function fetchAll(int $page = 0, $withCount = false): array {
        $api = new PostsGet();

        /**
         * Fetch a JSON list
         */
        $api->setParam_type(PostType::TYPE_POST);
        $api->setParam_page($page);
        $api->setParam_max(50);
        $api->setParam_withCount($withCount ? 1 : 0);

        //new APIParams(array('postType' => PostType::TYPE_POST, 'max' => 4))
        $jsonPosts = $api->list();
        if (!$jsonPosts) {
            return [];
        }

        return Post::json2objects($jsonPosts);
    }

    /**
     * Overwrite the title, use the track title if set.
     */
    public function getPost_title(): string {

        if($this->getTrack()){
            return $this->getTrack()->getTitle();
        }
        
        return $this->post_title;
    }

    /*
      |--------------------------------------------------------------------------
      | Getters and Setters
      |--------------------------------------------------------------------------
     */

    /**
     * Get all post which are songs have a track. Other do not.
     *
     * @return  Track
     */
    public function getTrack() {
        return $this->track;
    }

    /**
     * Set all post which are songs have a track. Other do not.
     *
     * @param  Track  $ull  All post which are songs have a track. Other do not.
     */
    public function setTrack(Track $track) {
        $this->track = $track;
    }

    /**
     * Get the value of tracks
     *
     * @return  Tracks[]
     */
    public function getTracks() {
        $trs = $this->tracks;
        return !$trs ? [] : $trs; // make sure its always array
    }

    /**
     * Set the value of tracks
     *
     * @param  Tracks[]  $tracks
     */
    public function setTracks(array $tracks) {
        $this->tracks = $tracks;
    }

    /**
     * Get list of genres where this post belongs to (WP categories).
     *
     * @return  Genre[]
     */
    public function getGenres() {
        $gens = $this->genres;
        return !$gens ? [] : $gens; // make sure its always array
    }

    /**
     * Set list of genres where this post belongs to (WP categories).
     *
     * @param  Genre[]  $genres  List of genres where this post belongs to (WP categories).
     */
    public function setGenres(array $genres) {
        $this->genres = $genres;
    }

    /**
     * Get list of artist of this post.
     *
     * @return  Artist[]
     */
    public function getArtists(): array {
        $arts = $this->artists;
        return !$arts ? [] : $arts; // make sure its always array
    }

    /**
     * Set list of artist of this post.
     *
     * @param  Artist[]  $artists  List of artist of this post.
     */
    public function setArtists(array $artists) {
        $this->artists = $artists;
    }

    /**
     *
     * @return PlaylistStream[]
     */
    public function getPlaylistStreams(): array {
        $streams = $this->playlistStreams;
        return !$streams ? [] : $streams; // make sure its always array
    }

    public function setPlaylistStreams(array $playlistStreams): void {
        $this->playlistStreams = $playlistStreams;
    }
}
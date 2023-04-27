<?php

namespace SFAPI\Models;

use SFAPI\Api\StreamsGet;
use SFAPI\Models\{
    Artist,
    Post
};

/**
 * Initially playlists were called streams, not to be confused with User generated
 * playlists.
 *
 * Later it was decided to change the name from Streams to Playlist. These
 * Playlists/streams are admin created.
 *
 * For user playlists (when a user likes a track) use UserPlaylistsGet
 */
class PlaylistStream {
    public $id;
    public $name;
    public $slug;
    public $post_parent_id;
    public $menu_order;
    public $disabled;
    public $spotify_link;
    public $apple_link;
    public $img;
    public $color;
    public $date_updated;
    public $post_content;
    public $genres;

    /**
     * Total amount of tracks within this playlist.
     * 
     * @var type
     */
    public $count;

    /**
     *
     * @var Track[]
     */
    public $tracks = [];

    /**
     * 
     * @var Artist[];
     */
    public $artists = [];

    /**
     * The url for this playliststream
     *
     * playlists/{slug}
     *
     * @return type
     */
    public function getURL() {
        return surl(sprintf('/%s/%s/', PostType::TYPE_PLAYLISTS, $this->getSlug()));
    }

    /**
     *
     * @return type
     */
    public function getSocialMediaLinks() {

        return [
            Social::TYPE_SPOTIFY => $this->getSpotifyLink(),
            Social::TYPE_APPLE => $this->getAppleLink()
        ];
    }

    /**
     *
     * @param array|object $jsonPost
     */
    public function __construct(mixed $jsonPost = []) {
        if ($jsonPost) {
            $this->populate($jsonPost);
        }
    }

    /**
     * Dynamically populates the PlaylistStream object.
     * 
     * @param  mixed  $jsonPost  Contains the database response as json decoded 
     * @return  boolean  if jsonPost is empty return false.
     */
    public function populate(mixed $jsonPost) {

        if (!$jsonPost || empty($jsonPost)) {
            return false;
        }

        foreach ($jsonPost as $property => $value) {
            if (property_exists(static::class, $property)) {
                $this->{$property} = $value;
            }
        }

        /**
         * Populate posts
         */
        if ($this->tracks) {
            $clone_posts  = $this->tracks;
            $this->tracks = [];
            foreach ($clone_posts as $post_json) {
                $this->tracks[] = new Track($post_json);
            }
        }

        /**
         * Populate artists
         */
        if ($this->artists) {
            $clone_artists = $this->artists;
            $this->artists = [];
            foreach ($clone_artists as $post_json) {
                $this->artists[] = new Artist($post_json);
            }
        }

        /**
         * Populate Genres
         */
        if ($this->genres) {
            $clone_artists = $this->genres;
            $this->genres  = [];
            foreach ($clone_artists as $post_json) {
                $this->genres[] = new Genre($post_json);
            }
        }
    }

    /**
     *
     * @param  string  $slug
     * @return PlaylistStream
     */
    public static function fetchBySlug(string $slug, string $page = null): PlaylistStream|null {
        global $post_count;

        $api = new StreamsGet();

        /**
         * Fetch the single JSON
         */
        $api->setParam_page($page);
        $jsonPost = $api->single($slug);

        if (!$jsonPost) {
            /**
             * When view controller reads NULL, then 404 the request.
             */
            return null;
        }

        if ($jsonPost->count ?? false) {
            $post_count = intval($jsonPost->count);
        }

        return new PlaylistStream($jsonPost);
    }

    /**
     * The fetch all will serve as example, but rarely used
     * since we fetch based on genre, search etc...
     *
     * @return \SFAPI\Models\Post[]
     */
    public static function fetchAll(): array {

        /**
         * Init the API for posts
         */
        $api = new StreamsGet();

        /**
         * Fetch the single JSON
         */
        $jsonPosts = $api->list();

        if (!$jsonPosts) {
            /**
             * When view controller reads NULL, then 404 the request.
             */
            return null;
        }

        return PlaylistStream::json2objects($jsonPosts);
    }

    /**
     * Converts JSON response to an object.
     * 
     * @param object $json_array
     * @return \SFAPI\Models\PlaylistStream[]
     */
    public static function json2objects(array $jsonPosts): array {
        $playlistSreams = [];
        foreach ($jsonPosts as $json) {
            $playlistSreams[] = new static($json); //
        }

        return $playlistSreams;
    }

    /**
     * Get the value of id
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set the value of id

     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * Get the value of name
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set the value of name

     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * Get the value of slug
     */
    public function getSlug() {
        return $this->slug;
    }

    /**
     * Set the value of slug

     */
    public function setSlug($slug) {
        $this->slug = $slug;
    }

    /**
     * Get the value of post_parent_id
     */
    public function getPostParentId() {
        return $this->post_parent_id;
    }

    /**
     * Set the value of post_parent_id

     */
    public function setPostParentId($post_parent_id) {
        $this->post_parent_id = $post_parent_id;
    }

    /**
     * Get the value of menu_order
     */
    public function getMenuOrder() {
        return $this->menu_order;
    }

    /**
     * Set the value of menu_order

     */
    public function setMenuOrder($menu_order) {
        $this->menu_order = $menu_order;
    }

    /**
     * Get the value of disabled
     */
    public function getDisabled() {
        return $this->disabled;
    }

    /**
     * Set the value of disabled

     */
    public function setDisabled($disabled) {
        $this->disabled = $disabled;
    }

    /**
     * Get the value of spotify_link
     */
    public function getSpotifyLink() {
        return $this->spotify_link;
    }

    /**
     * Set the value of spotify_link

     */
    public function setSpotifyLink($spotify_link) {
        $this->spotify_link = $spotify_link;
    }

    /**
     * Get the value of apple_link
     */
    public function getAppleLink() {
        return $this->apple_link;
    }

    /**
     * Set the value of apple_link

     */
    public function setAppleLink($apple_link) {
        $this->apple_link = $apple_link;
    }

    /**
     * Get the value of img
     */
    public function getImg() {
        return $this->img;
    }

    /**
     * Set the value of img

     */
    public function setImg($img) {
        $this->img = $img;
    }

    /**
     * Get the value of color
     */
    public function getColor() {
        return $this->color;
    }

    /**
     * Set the value of color

     */
    public function setColor($color) {
        $this->color = $color;
    }

    /**
     * Get the value of date_updated
     */
    public function getDateUpdated() {
        return $this->date_updated;
    }

    /**
     * Set the value of date_updated

     */
    public function setDateUpdated($date_updated) {
        $this->date_updated = $date_updated;
    }

    /**
     * Get the value of post_content
     */
    public function getPostContent() {
        return base64_decode($this->post_content);
    }

    /**
     * Set the value of post_content

     */
    public function setPostContent($post_content) {
        $this->post_content = $post_content;
    }

    /**
     *
     * @return Genre[]
     */
    public function getGenres() {
        return $this->genres;
    }

    /**
     * Set the value of genres

     */
    public function setGenres($genres) {
        $this->genres = $genres;
    }

    public function getTracks(): array {
        return $this->tracks;
    }

    public function setTracks(array $tracks): void {
        $this->tracks = $tracks;
    }

    /**
     * Get the value of artists
     *
     * @return  Artist[];
     */
    public function getArtists() {
        return $this->artists;
    }

    /**
     * Set the value of artists
     *
     * @param  Artist[];  $artists

     */
    public function setArtists(array $artists) {
        $this->artists = $artists;
    }

    public function getCount() {
        return $this->count;
    }

    public function setCount($count): void {
        $this->count = $count;
    }

}
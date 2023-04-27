<?php

namespace SFAPI\Models;

use SFAPI\Models\{
    Artist,
    Genre,
    Social
};

class Track {
    public $id;
    public $post_id;
    public $image;
    public $title;
    public $duration_human;
    public $stream;
    public $duration;
    public $slug;
    public $status;
    public $artists;
    public $html_artists;
    public $social;
    public $genres;
    public $plays;

    public function __construct(mixed $jsonPost) {
        if ($jsonPost) {
            $this->populate($jsonPost);
        }
    }

    /**
     * Fills objects with the response data.
     * 
     * @param array $jsonPost  API JSON response
     * @return boolean
     */
    public function populate(mixed $trJson) {

        $jsonPost = is_array($trJson) ? (object) $trJson : $trJson;
        if (!$jsonPost || !isset($jsonPost->id)) {
            return false;
        }

        foreach ($jsonPost as $property => $value) {
            if (property_exists(static::class, $property)) {
                $this->{$property} = $value;
            }
        }

        /**
         * Populates the artist model.
         */
        if ($this->artists) {
            $json_artists  = $this->artists;
            $this->artists = [];
            foreach ($json_artists as $artist) {
                $this->artists[] = new Artist($artist);
            }
        }

        /**
         * Populates the genre model.
         */
        if ($this->genres) {
            $json_genres  = $this->genres;
            $this->genres = [];
            foreach ($json_genres as $genre) {
                $this->genres[] = new Genre($genre);
            }
        }

        /**
         * Populates the social model.
         */
        if ($this->social) {
            $json_social  = $this->social;
            $this->social = [];
            foreach ($json_social as $type => $social) {
                $s              = new Social($social);
                $s->setType($type);
                $this->social[] = $s;
            }
        }
    }

    /**
     * Post type post does not include the type.
     * 
     * @return  string    url of the track.
     */
    public function getURL(): string {
        return surl(sprintf('/%s/', $this->getSlug()));
        
    }

    /**
     * Post type post does not include the type.
     *
     * @return string url of the social media  of a track.
     */
    public function getSocialURL(string $type): string {

        $social = $this->hasSocial($type);
        if (!$social) {
            return '';
        }

        return $social->getURL();
    }

    /**
     * If this track has the social id of type XXX
     *
     * @return Social
     */
    public function hasSocial($type) {

        $socials = $this->getSocial();
        if(!$socials){
            return false;
        }
        
        foreach ($socials as $s) {
            if ($s->getType() === $type && $s->getID()) {
                return $s;
            }
        }
        return false;
    }

    /**
     * if we can play the track
     * 
     * @return boolean
     */
    public function canPlay() {
        if ($this->getStatus() == 2 || $this->getStatus() == 4) {
            return true;
        }

        return false;
    }
    /*
      |--------------------------------------------------------------------------
      | Getters and Setters
      |--------------------------------------------------------------------------
     */

    /**
     * Get the value of id
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set the value of id

     */
    public function setId($id): void {
        $this->id = $id;
    }

    /**
     * Get the value of post_id
     */
    public function getPostId() {
        return $this->post_id;
    }

    /**
     * Set the value of post_id

     */
    public function setPostId($post_id): void {
        $this->post_id = $post_id;
    }

    /**
     *
     * @param string $size
     * @return string
     */
    public function getImage(): null|string {
        return $this->image;
    }

    /**
     * Set the value of image

     */
    public function setImage($image): void {
        $this->image = $image;
    }

    /**
     * Get the value of title
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Set the value of title

     */
    public function setTitle($title): void {
        $this->title = $title;
    }

    /**
     * Get the value of duration_human
     */
    public function getDurationHuman() {
        return $this->duration_human;
    }

    /**
     * Set the value of duration_human

     */
    public function setDurationHuman($duration_human): void {
        $this->duration_human = $duration_human;
    }

    /**
     * Get the value of stream
     */
    public function getStream() {
        return $this->stream;
    }

    /**
     * Set the value of stream

     */
    public function setStream($stream): void {
        $this->stream = $stream;
    }

    /**
     * Get the value of duration
     */
    public function getDuration() {
        return $this->duration;
    }

    /**
     * Set the value of duration

     */
    public function setDuration($duration): void {
        $this->duration = $duration;
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
    public function setSlug($slug): void {
        $this->slug = $slug;
    }

    /**
     * Get the value of status
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * Set the value of status

     */
    public function setStatus($status): void {
        $this->status = $status;
    }

    /**
     * Get the value of artists
     * @return Artist[]
     */
    public function getArtists() {
        return $this->artists;
    }

    /**
     * Set the value of artists

     */
    public function setArtists(Artist $artists): void {
        $this->artists = $artists;
    }

    /**
     * Get the value of html_artists
     */
    public function getHtmlArtists() {
        return $this->html_artists;
    }

    /**
     * Set the value of html_artists
     */
    public function setHtmlArtists(string $html_artists): void {
        $this->html_artists = $html_artists;
    }

    /**
     *
     * @return Social
     */
    public function getSocial() {
        return $this->social;
    }

    /**
     * Set the value of social

     */
    public function setSocial($social): void {
        $this->social = $social;
    }

    /**
     * Get the value of genres
     */
    public function getGenres(): ?array {
        return $this->genres;
    }

    /**
     * Set the value of genres

     */
    public function setGenres($genres): void {
        $this->genres = $genres;
    }

    /**
     * Get the value of the p[lay count]
     */
    public function getPlays(): int {
        return $this->plays;
    }

    /**
     * Set the value of the play count

     */
    public function setPlays(int $plays): void {
        $this->plays = $plays;
    }
}
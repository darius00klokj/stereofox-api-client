<?php


namespace SFAPI\Models;
use SFAPI\Models\PostType;

class SearchResult {

    public $title;
    public $string;
    public $post_id;
    public $date_updated;
    public $date_post;
    public $post_type;
    public $image;
    public $slug;
    public $id;

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
    public function populate(mixed $jsonPost) {

        $jsonPost = is_array($jsonPost) ? (object) $jsonPost : $jsonPost;

        foreach ($jsonPost as $property => $value) {
            if (property_exists(static::class, $property)) {
                $this->{$property} = $value;
            }
        }
    }

    /**
     * Returns the url of a single search result.
     * 
     * @return  string    uri of the single search result.
     */
    public function getURL(): string  {
        if ($this->getPost_type() === PostType::TYPE_POST) {
            return surl(sprintf('/%s/', $this->getSlug()));
        } 
        return surl(sprintf('/%s/%s/', $this->getPost_type(), $this->getSlug()));
    }

    /*
    |--------------------------------------------------------------------------
    | Getters and Setters
    |--------------------------------------------------------------------------
     */
    public function getTitle(): string {
        return $this->title;
    }

    public function setTitle($title): void  {
        $this->title = $title;
    }

    public function getString(): string {
        return $this->string;
    }

    public function setString($string): void  {
        $this->string = $string;
    }

    public function getPost_id(): int {
        return $this->post_id;
    }

    public function setPost_id( int $post_id): void  {
        $this->post_id = $post_id;
    }

    public function getDate_updated() {
        return $this->date_updated;
    }

    public function setDate_updated($date_updated): void  {
        $this->date_updated = $date_updated;
    }

    public function getPost_date() {
        return $this->date_post;
    }

    public function setPost_date($date_post): void  {
        $this->date_post = $date_post;
    }

    public function getPost_type(): string {
        return $this->post_type;
    }

    public function setPost_type(string $post_type): void  {
        $this->post_type = $post_type;
    }

    public function getImage(): string {
        return $this->image;
    }

    public function setImage(string $image): void  {
        $this->image = $image;
    }

    public function getSlug(): string {
        return $this->slug;
    }

    public function setSlug(string $slug): void  {
        $this->slug = $slug;
    }

    public function getID(): int {
        return $this->id;
    }

    public function setID(int $id): void  {
        $this->id = $id;
    }
}

<?php
/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace SFAPI\Models;

use SFAPI\Api\AuthorsGet;
use App\Http\Controllers\AuthorController;

/**
 * Description of Author. 
 *
 * @author darius
 */
class Author {

    public $ID;
    public $name;
    public $slug;
    public $avatar;
    public $description;
    public $links;
    public $latestArticle;
    public $latestPosts;
    public $position;
    public $order;
    public $stats;
    public $head;

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

        if(($jsonPost->latest_article ?? false)){
            $this->latestArticle = new Article($jsonPost->latest_article);
        }

        if(($jsonPost->latest_posts ?? false)){
            $posts = [];
            foreach($jsonPost->latest_posts as $pjson){
                $posts[] = new Post($pjson);
            }
            $this->latestPosts = $posts;
        }
        

    }

    /**
     * Returns the public URL for this author.
     * 
     * @return string
     */
    public function getURL() {
        return surl(sprintf('/%s/%s/', AuthorController::URI,
                $this->getSlug()
            )
        );
    }

    /**
     *
     * @return \SFAPI\Models\Author[]
     */
    public static function fetchAll() {

        /**
         * Init the API for posts
         */
        $api = new AuthorsGet();

        /**
         * Fetch the single JSON
         */
        $jsonPost = $api->fetch();

        if (!$jsonPost) {
            /**
             * When view controller reads NULL, then 404 the request.
             */
            return null;
        }

        $authors = [];
        foreach ($jsonPost as $jp) {
            $aut = new Author($jp);

            while (true) {
                /**
                 * Order by order
                 */
                if (!isset($authors[$aut->getOrder()])) {
                    $authors[$aut->getOrder()] = $aut;
                    break;
                } else {
                    $aut->setOrder($aut->getOrder() + 1);
                }
            }
        }

        ksort($authors);

        return $authors;
    }

    /**
     * Returns a single Author.
     * 
     * @param  string   $slug
     * @return ?Author  Author object or null.
     */
    public static function fetchBySlug(string $slug): ?Author {
        /**
         * Init the API for posts
         */
        $api = new AuthorsGet();

        /**
         * Fetch the single JSON
         */
        $jsonPost = $api->single($slug);

        if (!$jsonPost) {
            /**
             * When view controller reads NULL, then 404 the request.
             */
            return null;
        }

        return new Author($jsonPost);
    }
    /*
      |--------------------------------------------------------------------------
      | Getters and Setters
      |--------------------------------------------------------------------------
     */

    public function getName(): string {
        return $this->name;
    }

    public function setName($name): void {
        $this->name = $name;
    }

    public function getSlug(): string {
        return $this->slug;
    }

    public function setSlug($slug): void {
        $this->slug = $slug;
    }

    public function getAvatar(): string {
        return $this->avatar;
    }

    public function setAvatar($avatar): void {
        $this->avatar = $avatar;
    }

    public function getDescription(): string {
        return base64_decode($this->description);
    }

    public function setDescription($description): void {
        $this->description = $description;
    }

    public function getLinks(): array {
        return $this->links;
    }

    public function setLinks($links): void {
        $this->links = $links;
    }

    /**
     *
     * @return Article
     */
    public function getLatestArticle(): mixed {
        return $this->latestArticle;
    }

    public function setLatestArticle($latestArticle): void {
        $this->latestArticle = $latestArticle;
    }

    public function getLatestPosts() {
        return $this->latestPosts;
    }

    public function setLatestPosts($latestPosts): void {
        $this->latestPosts = $latestPosts;
    }

    public function getPosition(): mixed {
        return $this->position;
    }

    public function setPosition($position): void {
        $this->position = $position;
    }

    public function getOrder(): mixed {
        return intval($this->order);
    }

    public function setOrder($order): void {
        $this->order = $order;
    }

    public function getStats() : object {
        return (object) ($this->stats ?? []);
    }

    public function getHead() {
        return $this->head;
    }

    public function setStats($stats): void {
        $this->stats = $stats;
    }

    public function setHead($head): void {
        $this->head = $head;
    }


    /**
     * Get the value of ID
     */
    public function getID()
    {
        return $this->ID;
    }

    /**
     * Set the value of ID
     */
    public function setID($ID): self
    {
        $this->ID = $ID;

        return $this;
    }
}
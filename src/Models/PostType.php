<?php
/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace SFAPI\Models;
use SFAPI\Api\PostsGetRelated;

/**
 * Parent class 
 *
 * @author darius
 */
class PostType {
    /**
     * All posts types
     */
    const TYPE_POST         = 'post';
    const TYPE_PLAYLISTS    = 'playlists'; // AKA Streams
    const TYPE_PAGE         = 'page';
    const TYPE_ARTICLE      = 'articles';
    const TYPE_ARTIST       = 'artist';
    const TYPE_INTERVIEW    = 'interviews';
    const TYPE_MIX          = 'mixes';
    const TYPE_LABEL        = 'label';
    const TYPE_ALBUM_REVIEW = 'album-reviews';
    const TYPE_PODCASTS = 'podcasts';
    const TYPE_RESOURCES = 'resources';

    /**
     * Every post has these properties.
     */
    public $ID;
    public $post_title;
    public $post_type;
    public $post_date;
    public $post_modified;
    public $post_name;
    public $post_status;
    public $post_author;
    public $content; // Base64 encoded HTML content;
    public $excerpt; // 160 chars summary of the content;
    public $metas; // All extra meta fields (like _sf_url_spotify).

    /**
     * List of images of a post.
     * ["cropped", "resized", "mini", "large"]
     * 
     * @var array[]
     */
    public $images;

    /**
     * Base64 of the meta tags for the <head> of the page.
     *
     * @var string
     */
    public $head;

    /**
     * The Writer within our team that created the post.
     *
     * @var Author
     */
    public $author;

    /**
     * Sorts artists by popular, featured, fresh
     */
    public $sortby;

    /**
     * Possible image sizes
     */
    const IMAGE_SIZE_CROPPED = 'cropped'; // 200x200
    const IMAGE_SIZE_RESIZED = 'resized'; //450x450
    const IMAGE_SIZE_MINI    = 'mini'; // 70x70
    const IMAGE_SIZE_LARGE   = 'large'; // As large as possible

    public static function post2Type(Post $post) {

        if ($post->getPost_type() === self::TYPE_INTERVIEW) {
            return new Interview($post);
        }
    }

    /**
     * Gets the image of the post.
     * 
     * @param string  $size    Size of the image: cropped, resized, mini or large.
     * @return string          The url of the image.
     */
    public function getImage(string $size = self::IMAGE_SIZE_CROPPED): string {
        $imgs = $this->getImages();
        if (!$imgs || !isset($imgs->{$size})) {
            // TODO Returns a default img
            return '';
        }

        return $imgs->{$size};
    }

    public function __construct(mixed $jsonPost) {
        if ($jsonPost) {
            $this->populate($jsonPost);
        }
    }

    /**
     * Based on the metas of a post it will return the social medias.
     *
     * @return type
     */
    public function getSocialMediaLinks() {

        $metas = (object) $this->getMetas();

        $socialMedias = [
            Social::TYPE_SPOTIFY,
            Social::TYPE_FACEBOOK,
            Social::TYPE_SOUNDCLOUD,
            Social::TYPE_TWITTER,
            Social::TYPE_INSTRAGRAM,
            Social::TYPE_AMAZON,
            Social::TYPE_ITUNES,
            Social::TYPE_BANDCAMP
        ];

        $links = [];
        foreach ($socialMedias as $media) {
            $meta = sprintf('%s_link', $media);
            $link = isset($metas->{$meta}) && $metas->{$meta} ? $metas->{$meta}[0] : null;
            if ($link) {
                $links[$media] = $link;
            }
        }

        return $links;
    }

    /**
     * Fills objects with the response data.
     *  
     * @param  object  $jsonPost    Database resopnse as json.
     * @return 
     */
    public function populate(mixed $jsonPost) {
        $jsonPost = is_array($jsonPost) ? (object) $jsonPost : $jsonPost;

        if (!$jsonPost || !isset($jsonPost->ID)) {
            return false;
        }

        foreach ($jsonPost as $property => $value) {
            if (property_exists(static::class, $property)) {
                $this->{$property} = $value;
            }
        }

        /**
         * Populate the author.
         */
        if ($this->author) {
            $this->author = new Author($this->author);
        }

        /**
         * Populate the image model
         */
        if ($this->images) {
            $this->images = new Image($this->images);
        }
    }

    /**
     * By default all post type urls are:
     * type/slug
     * 
     * @return  string    url of the resource.
     */
    public function getURL(): string {
        if ($this->getPost_type() === self::TYPE_POST) {
            $url = surl(sprintf('/%s/', $this->getPost_name()));
        } else {
            $url = surl(sprintf('/%s/%s/', $this->getPost_type(), $this->getPost_name()));
        }
        return $url;
    }

    /**
     * Converts JSON response to an object.
     * 
     * @param  array  $jsonPosts    Database response  
     * @return array                objects with the response data.
     */
    public static function json2objects(array $jsonPosts): array {
        $posts = [];
        foreach ($jsonPosts as $json) {
            $posts[] = new static($json); // Late binding -> creates new object depending on which class calls the function. 
        }

        return $posts;
    }

    /**
     *
     * @return Post[]
     */
    public function fetchRelated($postType = false) {
        $related = new PostsGetRelated();
        $related->setParam_max(3);
        $related->setParam_post_id($this->getID());
        $related->setParam_type($postType ?? static::TYPE_POST);

        $list = $related->list();

        return Post::json2objects($list);
    }

    /**
     * Returns a readable label for the post type
     * 
     * @return type
     */
    public function getPostTypeLabel() {
        $type = $this->getPost_type();
        $type = str_replace('-', ' ', $type);
        return strtoupper($type);
    }
    /*
      |--------------------------------------------------------------------------
      | Getters and Setters
      |--------------------------------------------------------------------------
     */

    /**
     * Get every post has these properties.
     * 
     * @return  int  Post id.
     */
    public function getID(): int {
        return $this->ID;
    }

    /**
     * Set every post has these properties.
     * 
     * @param  int  Post id.
     */
    public function setID(int $ID): void {
        $this->ID = $ID;
    }

    /**
     * Get the value of post_title
     */
    public function getPost_title(): string {
        return $this->post_title;
    }

    /**
     * Set the value of post_title

     */
    public function setPost_title(string $post_title): void {
        $this->post_title = $post_title;
    }

    /**
     * Get the value of post_type
     */
    public function getPost_type(): string {
        return $this->post_type;
    }

    /**
     * Set the value of post_type
     */
    public function setPost_type($post_type): void {
        $this->post_type = $post_type;
    }

    /**
     * Get the value of post_date
     */
    public function getPost_date() {
        return $this->post_date;
    }

    /**
     * Set the value of post_date
     */
    public function setPost_date($post_date): void {
        $this->post_date = $post_date;
    }

    /**
     * Get the value of post_modified
     */
    public function getPost_modified() {
        return $this->post_modified;
    }

    /**
     * Set the value of post_modified
     */
    public function setPost_modified($post_modified): void {
        $this->post_modified = $post_modified;
    }

    /**
     * Get the value of post_name
     */
    public function getPost_name() {
        return $this->post_name;
    }

    /**
     * Set the value of post_name
     */
    public function setPost_name($post_name): void {
        $this->post_name = $post_name;
    }

    /**
     * Get the value of post_author
     */
    public function getPost_author(): string {
        return $this->post_author;
    }

    /**
     * Set the value of post_author
     */
    public function setPost_author(string $post_author): void {
        $this->post_author = $post_author;
    }

    /**
     * Get the value of ontent
     *
     * @return  string
     */
    public function getContent(): string {
        return base64_decode($this->content);
    }

    /**
     * Set the value of ontent
     */
    public function setContent(string $content): void {
        $this->content = $content;
    }

    /**
     * Get the value of excerpt
     *
     * @return  
     */
    public function getExcerpt(): string {
        return $this->excerpt;
    }

    /**
     * Set the value of excerpt.
     */
    public function setExcerpt(string $excerpt): void {
        $this->excerpt = $excerpt;
    }

    /**
     * Get the value of metas
     */
    public function getMetas() {
        return $this->metas;
    }

    /**
     * Set the value of metas
     */
    public function setMetas($metas): void {
        $this->metas = $metas;
    }

    /**
     *
     * @return Image
     */
    public function getImages() {
        return $this->images;
    }

    /**
     * Set ["cropped", "resized", "mini", "large"]
     *
     * @param  array[]  $images  ["cropped", "resized", "mini", "large"]

     */
    public function setImages(array $images): void {
        $this->images = $images;
    }

    /**
     * Get base64 of the meta tags for the <head> of the page.
     *
     * @return  string
     */
    public function getHead() {
        return $this->head;
    }

    /**
     * Set base64 of the meta tags for the <head> of the page.
     *
     * @param  string  $head  Base64 of the meta tags for the <head> of the page.

     */
    public function setHead(string $head): void {
        $this->head = $head;
    }

    /**
     * Get the Writer within our team that created the post.
     *
     * @return  Author
     */
    public function getAuthor(): Author {
        return $this->author;
    }

    /**
     * Set the Writer within our team that created the post.
     *
     * @param  Author  $author  The Writer within our team that created the post.
     */
    public function setAuthor(Author $author): void {
        $this->author = $author;
    }

    public function getPost_status() {
        return $this->post_status;
    }

    public function setPost_status($post_status): void {
        $this->post_status = $post_status;
    }
    
    /**
     * 
     * @return boolean
     */
    public function is_published(){
        if($this->getPost_status() === 'publish'){
            return true;
        }
        return false;
    }


    /**
     * Get sorts artists by popular, featured, fresh
     */
    public function getSortby()
    {
        return $this->sortby;
    }

    /**
     * Set sorts artists by popular, featured, fresh
     */
    public function setSortby($sortby): self
    {
        $this->sortby = $sortby;

        return $this;
    }
}
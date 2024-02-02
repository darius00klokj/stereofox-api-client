<?php

namespace SFAPI\Models;

use SFAPI\Api\PostsGet;
use SFAPI\Models\Author;

class Resource extends PostType {

    /**
     * Traits
     */
    use Traits\ArticleProps;

    public function __construct(mixed $jsonPost) {
        /**
         * Calls the populate methode in the parent class PostType.
         */
        if ($jsonPost) {
            $this->populate($jsonPost);
        }
    }

    /**
     * Returns a single Article
     * 
     * @param  string  $slug
     * @return ?Podcast   Article object or null.
     */
    public static function fetchBySlug(string $slug): ?Resource {
        /**
         * Init the API for posts
         */
        $api = new PostsGet();

        /**
         * Fetch the single JSON
         */
        $jsonPost = $api->single($slug, PostType::TYPE_RESOURCES);

        if (!$jsonPost) {
            /**
             * When view controller reads NULL, then 404 the request.
             */
            return null;
        }

        return new Resource($jsonPost);
    }
}
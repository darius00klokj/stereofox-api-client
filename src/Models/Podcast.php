<?php

namespace SFAPI\Models;

use SFAPI\Api\PostsGet;
use SFAPI\Models\Author;

class Podcast extends PostType {

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
    public static function fetchBySlug(string $slug): ?Podcast {
        /**
         * Init the API for posts
         */
        $api = new PostsGet();

        /**
         * Fetch the single JSON
         */
        $jsonPost = $api->single($slug, PostType::TYPE_PODCASTS);

        if (!$jsonPost) {
            /**
             * When view controller reads NULL, then 404 the request.
             */
            return null;
        }

        return new Podcast($jsonPost);
    }
}
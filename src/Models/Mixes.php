<?php

namespace SFAPI\Models;

use SFAPI\ApiPostsGet;

class Mixes extends PostType
{

    public function __construct(mixed $jsonPost)
    {
        /**
         * Calls the populate methode in the parent class PostType.
         */
        if ($jsonPost) {
            $this->populate($jsonPost);
        }
    }

    /** 
     * Fetches a list of mixes 
     * 
     * @return  array  list ob Mixes objects
     */
    public static function fetchAll(): array
    {
        /**
         * Init the API for posts
         */
        $api = new PostsGet();
        $api->setParam_type(PostType::TYPE_MIX);

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

        $posts = [];
        foreach ($jsonPosts as $json) {
            $posts[] = new Mixes($json);
        }

        return $posts;
    }

    /**
     * Returns a single mix.
     * 
     * @param  string  $slug
     * @return ?Mixes   Mixes object or null.
     */
    public static function fetchBySlug(string $slug): ?Mixes
    {
        /**
         * Init the API for posts
         */
        $api = new PostsGet();

        /**
         * Fetch the single JSON
         */
        $jsonPost = $api->single($slug, PostType::TYPE_MIX);

        if (!$jsonPost) {
            /**
             * When view controller reads NULL, then 404 the request.
             */
            return null;
        }

        return new Mixes($jsonPost);
    }
}

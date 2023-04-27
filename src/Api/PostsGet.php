<?php

namespace SFAPI\Api\Api;

use \SFAPI\Models\Traits\PostsGetParams;

/**
 * https://www.stereofox.com/?api=eyAiYWN0aW9uIjogImdldF9wb3N0cyIsICJwYXJhbXMiOiB7ICJnZW5yZSI6IDM0LCAidHlwZSI6ICJwb3N0IiwgInNsdWciOiJhbXBsaWZpZWQtcmVhbC1sb3ZlIiB9fQ==
 */
class PostsGet extends Api {

    use PostsGetParams; // trait
    const ACTION = 'get_posts';

    /**
     * docs https://stereofox.atlassian.net/wiki/spaces/STEREOFOX/pages/647790596/SFAPI+Posts+Get
     * Will serve as example but rarely used.
     * 
     * @param string $postType
     * @return array
     */
    public function list(): array {
        global $post_count;
        
        $apiParams = $this->getParams();

        $filteredApiParams = array_filter($apiParams); // filters out all NULL, 0 and '' values

        $jsonPosts = $this->request($filteredApiParams);

        /**
         * Based on the docs, any request to get_posts will
         * return a list, but we only want the first object.
         */
        if (!$jsonPosts || !isset($jsonPosts->posts)) {
            return [];
        }

        /**
         * Check that we have a response
         */
        if (count($jsonPosts->posts) === 0) {
            return [];
        }

        if($jsonPosts->count ?? false){
            $post_count = intval($jsonPosts->count);
        }

        /**
         * Return all instances
         */
        return $jsonPosts->posts;
    }

    /**
     * Sends prepared query to database via API.
     *
     * docs https://stereofox.atlassian.net/wiki/spaces/STEREOFOX/pages/647790596/SFAPI+Posts+Get
     * 
     * @return  string  Database response.
     */
    public function single(string $slug, string $postType): ?object {

        $jsonPosts = $this->request(
            [
                'slug' => $slug,
                'type' => $postType
            ]
        );

        /**
         * Based on the docs, any request to get_posts will
         * return a list, but we only want the first object.
         */
        if (!$jsonPosts || !isset($jsonPosts->posts)) {
            return null;
        }

        /**
         * Check that we have a response
         */
        if (count($jsonPosts->posts) === 0) {
            return null;
        }

        /**
         * Return the first instance
         */
        return (object) $jsonPosts->posts[0];
    }
}
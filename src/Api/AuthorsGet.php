<?php

namespace SFAPI\Api;

class AuthorsGet extends Api
{
    const ACTION = 'get_authors';

    /**
     *
     * @return array
     */
    public function fetch(){
        
        $jsonPosts = $this->request([]);

        /**
         * Based on the docs, any request to get_posts will
         * return a list, but we only want the first object.
         */
        if (!$jsonPosts || !isset($jsonPosts->authors)) {
            return null;
        }

        /**
         * Check that we have a response
         */
        if (count($jsonPosts->authors) === 0) {
            return null;
        }

        /**
         * Return the first instance
         */
        return $jsonPosts->authors;
    }
    /**
     * Sends prepared query to database via API.
     *
     * docs https://stereofox.atlassian.net/wiki/spaces/STEREOFOX/pages/647790596/SFAPI+Posts+Get
     * @param  string  $slug    Name of the requested post.
     * 
     * @return  string   Databese response as JSON.
     */
    public function single(string $slug): ?object
    {

        $jsonPosts = $this->request(
            [
                'slug' => $slug,
            ]
        );

        /**
         * Based on the docs, any request to get_posts will
         * return a list, but we only want the first object.
         */
        if (!$jsonPosts || !isset($jsonPosts->authors)) {
            return null;
        }

        /**
         * Check that we have a response
         */
        if (count($jsonPosts->authors) === 0) {
            return null;
        }

        /**
         * Return the first instance
         */
        return (object) $jsonPosts->authors[0];
    }
}

<?php
/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace SFAPI\Api\Api;

/**
 * Description of GenresGet
 *
 * example: https://api.stereofox.com/?api=eyAiYWN0aW9uIjogImdldF9nZW5yZXMifQ==
 *
 * @author darius
 */
class GenresGet extends Api
{
    const ACTION = 'get_genres';

    /**
     * { "action": "get_genres", "params":{"slug": "electronic"}}
     *
     * example: https://api.stereofox.com/?api=eyAiYWN0aW9uIjogImdldF9nZW5yZXMiLCAicGFyYW1zIjogeyJzbHVnIjoiZWxlY3Ryb25pYyJ9fQ==
     *
     * @param string $slug
     * @return ?object
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
        if (!$jsonPosts || !isset($jsonPosts)) {
            return null;
        }

        /**
         * Check that we have a response
         */
        if (empty($jsonPosts)) {
            return null;
        }

        /**
         * Return the first instance
         */
        return (object) $jsonPosts;
    }
}

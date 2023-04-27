<?php

namespace SFAPI\Models;

use SFAPI\ApiPageGet;
use SFAPI\Models\Author;

class Page extends PostType
{

    public function __construct(mixed $jsonPost)
    {
        if ($jsonPost) {
            $this->populate($jsonPost);
        }
    }

    /**
     * Returns a single page.
     * 
     * @param  string  $slug
     * @return ?Page   Page object or null.
     */
    public static function fetchBySlug(string $slug): ?Page
    {
        /**
         * Init the API for posts
         */
        $api = new PageGet();

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

        return new Page($jsonPost);
    }
}

<?php

namespace SFAPI\Models;

use SFAPI\ApiPostsGet;
use SFAPI\Models\Author;

class Interview extends PostType {

    use Traits\ArticleProps;

    public function __construct(mixed $jsonPost) {
        if ($jsonPost) {
            $this->populate($jsonPost);
        }
    }

    public static function fetchBySlug(string $slug): ?Interview {
        /**
         * Init the API for posts
         */
        $api = new PostsGet();

        /**
         * Fetch the single JSON
         */
        $jsonPost = $api->single($slug, PostType::TYPE_INTERVIEW);

        if (!$jsonPost) {
            /**
             * When view controller reads NULL, then 404 the request.
             */
            return null;
        }

        return new Interview($jsonPost);
    }
}
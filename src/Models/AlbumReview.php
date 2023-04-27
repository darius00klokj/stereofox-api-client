<?php

namespace SFAPI\Models;

use SFAPI\Api\PostsGet;

class AlbumReview extends PostType {

    use Traits\ArticleProps;

    public function __construct(mixed $jsonPost) {
        /**
         * Calls the methode populate in the parent class PostType.
         */
        if ($jsonPost) {
            $this->populate($jsonPost);
        }
    }
    
    /**
     * Returns a single album review.
     *
     * @param  string  $slug
     * @return ?Post   Album review object or null.
     */
    public static function fetchBySlug(string $slug): ?AlbumReview {
        /**
         * Init the API for posts
         */
        $api = new PostsGet();

        /**
         * Fetch the single JSON
         */
        $jsonPost = $api->single($slug, PostType::TYPE_ALBUM_REVIEW);

        if (!$jsonPost) {
            /**
             * When view controller reads NULL, then 404 the request.
             */
            return null;
        }

        return new AlbumReview($jsonPost);
    }
}
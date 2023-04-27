<?php

namespace SFAPI\Api;

use Illuminate\Support\Facades\Http;

class PageGet extends Api {
    const ACTION = 'get_page';

    /**
     * When the page is not a WP page, but a statically
     * generated page. Like sitemaps or RSS feed
     * 
     * @var int
     */
    public $param_static_page = 0;

    /**
     * The slug of the page
     * @var type
     */
    public $param_slug    = '';

    /**
     * Sends prepared query to database via API.
     * 
     * docs https://stereofox.atlassian.net/wiki/spaces/STEREOFOX/pages/548044841/SFAPI+Page+Get
     *
     * @param string $slug
     * @param string $postType
     * @return ?object
     */
    public function single(string $slug): ?object {

        $this->setParam_slug($slug);

        $jsonPosts = $this->request(
            [
                'slug' => $this->getParam_slug(),
                'static_page' => $this->getParam_static_page()
            ]
        );

        /**
         * Based on the docs, any request to get_posts will
         * return a list, but we only want the first object.
         */
        if (!$jsonPosts || !isset($jsonPosts->ID)) {
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

    public function getParam_slug() {
        return $this->param_slug;
    }


    public function setParam_slug($param_slug): void {
        $this->param_slug = $param_slug;
    }

    public function getParam_static_page(): int {
        return $this->param_static_page;
    }

    public function setParam_static_page(int $param_static_page): void {
        $this->param_static_page = $param_static_page;
    }

}
<?php

namespace SFAPI\Api\Api;

/**
 * 
 * docs: https://stereofox.atlassian.net/wiki/spaces/STEREOFOX/pages/773226501/SFAPI+Artists
 * 
 * @author darius
 */
class ArtistsGet extends Api {
    const ACTION = 'get_artists';

    /**
     * Sorting opts
     */
    const SORTBY_POPULAR  = 'popular';
    const SORTBY_FRESH    = 'fresh';
    const SORTBY_FEATURED = 'featured';

    public $param_sortby;
    public $param_max       = 42;
    public $param_page      = 0;
    public $param_withCount = 0;
    public $param_featured  = 0;

    public function list() {
        global $post_count;

        $apiParams = [
            'sortby' => $this->getParam_sortby(),
            'max' => $this->getParam_max(),
            'page' => $this->getParam_page(),
            'withCount' => $this->getParam_withCount(),
            'featured' => $this->getParam_featured()
        ];

        $jsonPosts = $this->request($apiParams);

        /**
         * Based on the docs, any request to get_posts will
         * return a list, but we only want the first object.
         */
        if (!$jsonPosts || !isset($jsonPosts->posts)) {
            return [];
        }

        if (isset($jsonPosts->count)) {
            $post_count = intval($jsonPosts->count);
        }

        /**
         * Check that we have a response
         */
        if (count($jsonPosts->posts) === 0) {
            return [];
        }

        /**
         * Return all instances
         */
        return $jsonPosts->posts;
    }

    public function getParam_sortby() {
        return $this->param_sortby;
    }

    public function getParam_max() {
        return $this->param_max;
    }

    public function setParam_sortby($param_sortby): void {
        $this->param_sortby = $param_sortby;
    }

    public function setParam_max($param_max): void {
        $this->param_max = $param_max;
    }

    public function getParam_page() {
        return $this->param_page;
    }

    public function getParam_withCount() {
        return $this->param_withCount;
    }

    public function setParam_page($param_page): void {
        $this->param_page = $param_page;
    }

    public function setParam_withCount($param_withCount): void {
        $this->param_withCount = $param_withCount;
    }

    public function getParam_featured() {
        return $this->param_featured;
    }

    public function setParam_featured($param_featured): void {
        $this->param_featured = $param_featured;
    }
}
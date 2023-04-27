<?php

namespace SFAPI\Api\Api;

use \SFAPI\Models\Traits\PostsGetParams;


class PostsGetRelated extends Api
{
    public $param_post_id;
    public $param_type;
    public $param_max;

    const ACTION = 'get_related_posts';

    /**
     * List of related post by post id
     * 
     * @param string $postType
     * @return array
     */
    public function list(): array
    {
        $jsonPosts = $this->request(
            [
                'max' => $this->getParam_max(),
                'type' => $this->getParam_type(),
                'post_id' => $this->getParam_post_id()
            ]
        );

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

        /**
         * Return all instances
         */
        return  $jsonPosts->posts;
    }

    public function getParam_post_id() {
        return $this->param_post_id;
    }

    public function getParam_type() {
        return $this->param_type;
    }

    public function getParam_max() {
        return $this->param_max;
    }

    public function setParam_post_id($param_post_id): void {
        $this->param_post_id = $param_post_id;
    }

    public function setParam_type($param_type): void {
        $this->param_type = $param_type;
    }

    public function setParam_max($param_max): void {
        $this->param_max = $param_max;
    }



}

<?php

namespace SFAPI\Api\Api;

/**
 * Streams are curated playlists. NOT user generated ones.
 * 
 * We do not call single playlist via get_posts. we use this command.
 * docs: https://stereofox.atlassian.net/wiki/spaces/STEREOFOX/pages/548044801/SFAPI+Streams+Get+curated+playlists
 */
class StreamsGet extends Api
{

    const ACTION = 'get_streams';

    private $param_complete;
    private $param_post_id;
    private $param_slug;
    private $param_page;

    /**
     * docs https://stereofox.atlassian.net/wiki/spaces/STEREOFOX/pages/548044801/SFAPI+Streams+Get+curated+playlists
     * Returns the list of curated streams
     *
     * @param string $postType
     * @return array
     */
    public function list(): array
    {
        $jsonPosts = $this->request([]);

        /**
         * Based on the docs, any request to get_posts will
         * return a list, but we only want the first object.
         */
        if (!$jsonPosts || !isset($jsonPosts->streams)) {
            return [];
        }

        /**
         * Check that we have a response
         */
        if (count($jsonPosts->streams) === 0) {
            return [];
        }

        /**
         * Return all instances
         */
        return $jsonPosts->streams;
    }

    /**
     * Sends prepared query to database via API.
     *
     * Example: https://api.stereofox.com/?api=eyAiYWN0aW9uIjogImdldF9zdHJlYW1zIiwgInBhcmFtcyI6eyJzbHVnIjoiY2hpbGwtZWxlY3Ryb25pY2EifX0=
     *
     * @return object 
     */
    public function single($slug): mixed
    {

        $jsonPosts = $this->request(
            [
                'slug' => $slug,
                'page' => $this->getParam_page()
            ]
        );

        /**
         * Based on the docs, any request to get_posts will
         * return a list, but we only want the first object.
         */
        if (!$jsonPosts || !isset($jsonPosts->streams)) {
            return null;
        }

        /**
         * Check that we have a response
         */
        if (count($jsonPosts->streams) === 0) {
            return null;
        }

        /**
         * Return the first instance
         */
        return (object) $jsonPosts->streams[0];
    }

    /*
    |--------------------------------------------------------------------------
    | Getters and Setters
    |--------------------------------------------------------------------------
    */
    /**
     * Get the value of param_complete
     * 
     * @return  bool  all track posts and all artists posts within a stream.
     */
    public function getParam_complete()
    {
        return $this->param_complete;
    }

    /**
     * Set the value of param_complete
     *
     * @param  bool  all track posts and all artists posts within a stream.
     */
    public function setParam_complete(bool $param_complete): void
    {
        $this->param_complete = $param_complete;
    }

    /**
     * Get the value of param_post_id
     * 
     * @return  int  ID for a single stream inside of a playlist
     */
    public function getParam_post_id(): int
    {
        return $this->param_post_id;
    }

    /**
     * Set the value of param_post_id
     *
     * @param  int  ID for a single stream inside of a playlist
     */
    public function setParam_post_id(int $param_post_id): void
    {
        $this->param_post_id = $param_post_id;
    }

    /**
     * Get the value of param_slug
     * 
     * @return  string  Name of a stream.
     */
    public function getParam_slug(): string
    {
        return $this->param_slug;
    }

    /**
     * Set the value of param_slug
     * 
     * @param  string  Name of a stream.
     */
    public function setParam_slug(string $param_slug): void
    {
        $this->param_slug = $param_slug;
    }

    public function getParam_page() {
        return $this->param_page;
    }

    public function setParam_page($param_page): void {
        $this->param_page = $param_page;
    }

}

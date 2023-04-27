<?php

namespace SFAPI\Api\Api;

class UserFavoritesGet extends Api
{
    const ACTION = 'get_user_favourites';

    private $param_slug;

    /**
     * docs https://stereofox.atlassian.net/wiki/spaces/STEREOFOX/pages/548044801/SFAPI+Streams+Get+curated+playlists
     * Returns the list of curated streams
     *
     * @param string $postType
     * @return array
     */
    public function fetch(): object
    {

        $this->setDoCache(false);
        $jsonPosts = $this->request([
            'slug' => $this->getParam_slug()
        ]);

        /**
         * Return all instances
         */
        return (object) $jsonPosts;
    }


    /*
    |--------------------------------------------------------------------------
    | Getters and Setters
    |--------------------------------------------------------------------------
    */
    /**
     * Get the value of param_type
     * 
     * @return  string  
     */
    public function getParam_slug(): string
    {
        return $this->param_slug;
    }

    /**
     * Set the value of param_type
     */
    public function setParam_slug($param_slug): void
    {
        $this->param_slug = $param_slug;
    }
}

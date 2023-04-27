<?php

namespace SFAPI\Api;

/**
 * https://www.stereofox.com/?api=eyAiYWN0aW9uIjogImdldF9wb3N0cyIsICJwYXJhbXMiOiB7ICJnZW5yZSI6IDM0LCAidHlwZSI6ICJwb3N0IiwgInNsdWciOiJhbXBsaWZpZWQtcmVhbC1sb3ZlIiB9fQ==
 */
class TracksGet extends Api {
    const ACTION             = 'get_tracks';
    const TYPE_USER_PLAYLIST = 'playlist';

    private $param_type;
    private $param_parent; //ID or slug, reference of the playlist type.
    private $param_status = 2; // playable
    private $param_max;

    /**
     * Returns object with totalCount and tracks.
     * 
     * @return type
     */
    public function fetch() {

        $jsonPosts = (object) $this->request([
            'type' => $this->getParam_type(),
            'parent' => $this->getParam_parent(),
            'status' => $this->getParam_status(),
            'max' => $this->getParam_max()
        ]);


        if (!($jsonPosts->tracks ?? false)) {
            return [];
        }

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
     * @return  string  post type.
     */
    public function getParam_type(): string {
        return $this->param_type;
    }

    /**
     * Set the value of param_type
     *
     * @param  string  Post type.
     */
    public function setParam_type(string $param_type): void {
        $this->param_type = $param_type;
    }

    /**
     * Get the value of ype
     *
     * @return  int|string  ID or slug, reference of the playlist type.
     */
    public function getParam_parent(): int|string {
        return $this->param_parent;
    }

    /**
     * Set the value of ype
     *
     * @param  int|string  ID or slug, reference of the playlist type.

     */
    public function setParam_parent(int|string $param_parent): void {
        $this->param_parent = $param_parent;
    }

    /**
     * Get the value of param_status
     * 
     * @return  int  Status of audio files.
     */
    public function getParam_status(): int {
        return $this->param_status;
    }

    /**
     * Set the value of param_status
     *
     * @param  int  Status of audio file.
     */
    public function setParamStatus(int $param_status): void {
        $this->param_status = $param_status;
    }

    public function getParam_max() {
        return $this->param_max;
    }

    public function setParam_max($param_max): void {
        $this->param_max = $param_max;
    }

}
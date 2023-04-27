<?php
/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace SFAPI\Api;

/**
 * Description of TrackToggleFavourite
 *
 * @author darius
 */
class TrackToggleFavourite extends Api{
    //put your code here

    const ACTION = 'track_toggle_playlist';

    public $param_type;
    public $param_track_id;
    public $param_token;

    const TYPE_FAVOURITE = 'fav';
    const TYPE_SPOTIFY = 'spotify';

    /**
     *
     * @return type
     */
    public function toggle(){

        $this->setDoCache(false);

        $jsonPosts = $this->request([
            'type' => $this->getParam_type(),
            'track_id' => $this->getParam_track_id(),
            'token' => $this->getParam_token()
        ]);

        /**
         * Return all instances
         */
        return (object) $jsonPosts;
    }


    public function getParam_type() {
        return $this->param_type;
    }

    public function getParam_track_id() {
        return $this->param_track_id;
    }

    public function getParam_token() {
        return $this->param_token;
    }

    public function setParam_type($param_type): void {
        $this->param_type = $param_type;
    }

    public function setParam_track_id($param_track_id): void {
        $this->param_track_id = $param_track_id;
    }

    public function setParam_token($param_token): void {
        $this->param_token = $param_token;
    }

}
<?php

namespace SFAPI\Api\Api;

/**
 * https://www.stereofox.com/?api=eyAiYWN0aW9uIjogImdldF9wb3N0cyIsICJwYXJhbXMiOiB7ICJnZW5yZSI6IDM0LCAidHlwZSI6ICJwb3N0IiwgInNsdWciOiJhbXBsaWZpZWQtcmVhbC1sb3ZlIiB9fQ==
 */
class UserCurrentGet extends Api {
    const ACTION = 'get_current_user';

    private $param_token;
    private $param_player_id;

    /**
     * Sends prepared query to database via API.
     *
     * docs https://stereofox.atlassian.net/wiki/spaces/STEREOFOX/pages/548044841/SFAPI+Page+Get
     *
     * @param string $slug
     * @param string $postType
     * @return ?object
     */
    public function fetchUser(): ?object {

        $this->setDoCache(false);

        $token = $this->getParam_token();
        if(!$token){
            return null;
        }
        
        $userJson = $this->request(
            [
                'token' => $token
            ]
        );

        /**
         * Check that we have a response
         */
        if (empty($userJson)) {
            return null;
        }

        /**
         * Return the first instance
         */
        return (object) $userJson;
    }
    /*
      |--------------------------------------------------------------------------
      | Getters and Setters
      |--------------------------------------------------------------------------
     */

    /**
     * Get the value of param_token
     */
    public function getParam_token(): mixed {
        return $this->param_token;
    }

    /**
     * Set the value of param_token

     */
    public function setParamToken($param_token): void {
        $this->param_token = $param_token;
    }

    /**
     * Get the value of player_id
     *
     * @return  int
     */
    public function getParam_player_id(): int {
        return $this->param_player_id;
    }

    /**
     * Set the value of player_id
     *
     * @param  int
     */
    public function setParam_player_id(int $param_player_id): void {
        $this->param_player_id = $param_player_id;
    }
}
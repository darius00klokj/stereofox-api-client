<?php

namespace App\Api;

/**
 * https://www.stereofox.com/?api=eyAiYWN0aW9uIjogImdldF9wb3N0cyIsICJwYXJhbXMiOiB7ICJnZW5yZSI6IDM0LCAidHlwZSI6ICJwb3N0IiwgInNsdWciOiJhbXBsaWZpZWQtcmVhbC1sb3ZlIiB9fQ==
 */
class UserUnlinkAccount extends Api
{
    const ACTION = 'user_unlink';

    private $param_type;
    private $param_token;


    /*
    |--------------------------------------------------------------------------
    | Getters and Setters
    |--------------------------------------------------------------------------
    */
    /**
     * Get the value of param_type
     * 
     * @return  string  type of the service to unlink
     */
    public function getParam_type(): string
    {
        return $this->param_type;
    }

    /**
     * Set the value of param_type
     * 
     * @param  string  type of the service to unlink
     */
    public function setParam_type(string $param_type)
    {
        $this->param_type = $param_type;
    }

    /**
     * Get the value of param_token
     * 
     * @return  string  Logged in user tokn
     */
    public function getParam_token(): string
    {
        return $this->param_token;
    }

    /**
     * Set the value of param_token
     * 
     * @param  string  Logged in user tokn
     */
    public function setParam_token(string $param_token): void
    {
        $this->param_token = $param_token;
    }
}

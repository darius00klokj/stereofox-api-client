<?php

namespace SFAPI\Api;

/**
 * https://www.stereofox.com/?api=eyAiYWN0aW9uIjogImdldF9wb3N0cyIsICJwYXJhbXMiOiB7ICJnZW5yZSI6IDM0LCAidHlwZSI6ICJwb3N0IiwgInNsdWciOiJhbXBsaWZpZWQtcmVhbC1sb3ZlIiB9fQ==
 */
class UserPasswordReset extends Api
{
    const ACTION = 'user_password_reset';

    private $param_token;
    private $param_password;
    private $parma_uid;

    /**
     * Send the email to recover password
     *
     * docs https://stereofox.atlassian.net/wiki/spaces/STEREOFOX/pages/730988545/SFAPI+User+Password+Recovery+Email
     *
     * @return array
     */
    public function send(): object|null {

        $this->setDoCache(false);

        $resp = $this->request(
            [
                'token' => $this->getParam_token(),
                'password' => $this->getParam_password(),
                'uid' => $this->getParma_uid()
            ]
        );

        /**
         * Check that we have a response
         */
        if (empty($resp)) {
            return null;
        }

        /**
         * Return the first instance
         */
        return (object) $resp;
    }

    /*
    |--------------------------------------------------------------------------
    | Getters and Setters
    |--------------------------------------------------------------------------
    */
    /**
     * Get the value of param_token
     * 
     * @return  string  User token. 
     */
    public function getParam_token(): string
    {
        return $this->param_token;
    }

    public function setParam_token($param_token): void {
        $this->param_token = $param_token;
    }

    /**
     * Get the value of password
     *
     * @return  string  User password
     */
    public function getParam_password(): string
    {
        return $this->param_password;
    }

    /**
     * Set the value of password
     *
     * @param  string  User password.
     */
    public function setParam_password(string $param_password): void
    {
        $this->param_password = $param_password;
    }

    public function getParma_uid() {
        return $this->parma_uid;
    }

    public function setParma_uid($parma_uid): void {
        $this->parma_uid = $parma_uid;
    }

}

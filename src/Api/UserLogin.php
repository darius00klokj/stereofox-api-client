<?php

namespace SFAPI\Api\Api;

class UserLogin extends Api
{
    const ACTION = 'user_login';

    private $param_email;
    private $param_password;

    /**
     * Send the email to recover password
     *
     * docs https://stereofox.atlassian.net/wiki/spaces/STEREOFOX/pages/321486920/SFAPI+User+Login
     *
     * @return array
     */
    public function login(): object|null {

        $this->setDoCache(false);

        $resp = $this->request(
            [
                'email' => $this->getParam_email(),
                'password' => $this->getParam_password(),
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
     * Get the value of email
     *
     * @return  string  user email
     */
    public function getParam_email(): string
    {
        return $this->param_email;
    }

    /**
     * Set the value of email
     *
     * @param  the  email

     */
    public function setParam_email(string $param_email): void
    {
        $this->param_email = $param_email;
    }

    /**
     * Get the value of password
     *
     * @return  string  user password
     */
    public function getParam_password(): string
    {
        return $this->param_password;
    }

    /**
     * Set the value of password
     *
     * @param  string  user password

     */
    public function setParam_password(string $param_password): void
    {
        $this->param_password = $param_password;
    }

}

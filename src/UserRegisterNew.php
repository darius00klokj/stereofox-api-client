<?php

namespace App\Api;

/**
 * https://www.stereofox.com/?api=eyAiYWN0aW9uIjogImdldF9wb3N0cyIsICJwYXJhbXMiOiB7ICJnZW5yZSI6IDM0LCAidHlwZSI6ICJwb3N0IiwgInNsdWciOiJhbXBsaWZpZWQtcmVhbC1sb3ZlIiB9fQ==
 */
class UserRegisterNew extends Api {
    const ACTION = 'user_register_new';

    private $param_email;
    private $param_password;
    private $param_name;

    /**
     * Agreed terms 
     * @var array
     */
    private $terms;

    public function register() {

        $this->setDoCache(false);

        $resp = $this->request(
            [
                'email' => $this->getParam_email(),
                'password' => $this->getParam_password(),
                'name' => $this->getParam_name(),
                'terms' => $this->getTerms()
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
     * @return  string  user eemail
     */
    public function getParam_email(): string {
        return $this->param_email;
    }

    /**
     * Set the value of email
     *
     * @param  the  email

     */
    public function setParam_email($param_email): void {
        $this->param_email = $param_email;
    }

    /**
     * Get the value of password
     *
     * @return  string  user password
     */
    public function getParam_password(): string {
        return $this->param_password;
    }

    /**
     * Set the value of password
     *
     * @param  string  user password
     */
    public function setParam_password(string $param_password): void {
        $this->param_password = $param_password;
    }

    /**
     * Get the value of param_name
     *
     * @return  string  user name
     */
    public function getParam_name(): string {
        return $this->param_name;
    }

    /**
     * Set the value of param_name
     *
     * @param  string  $ser name
     */
    public function setParam_name(string $param_name): void {
        $this->param_name = $param_name;
    }

    public function getTerms() {
        return $this->terms;
    }

    public function setTerms($terms): void {
        $this->terms = $terms;
    }
}
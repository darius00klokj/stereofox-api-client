<?php

namespace SFAPI\Api\Api;

class UserAuthenticate extends Api {
    const ACTION = 'user_authenticate';

    private $param_type;
    private $param_code; //verifies the user account
    private $param_token; // To link a user with an account
    private $redirect_url = '';

    /**
     * Based on a code from a service, we can log the user in.
     *
     * docs https://stereofox.atlassian.net/wiki/spaces/STEREOFOX/pages/321421334/SFAPI+User+Authenticate
     *
     * @param string $slug
     * @param string $postType
     * @return ?object
     */
    public function login(): ?object {

        $this->setDoCache(false);

        $params = [
            'type' => $this->getParam_type(),
            'redirect_url' => $this->getRedirect_url(),
            'code' => $this->getParam_code(),
            'token' => $this->getParam_token()
        ];

        $userJson = $this->request(
            $params
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

    /**
     * Get the value of param_type
     *
     * @return  string  Type of post.
     */
    public function getParam_type(): string {
        return $this->param_type;
    }

    /**
     * Set the value of param_type
     */
    public function setParam_type($param_type): void {
        $this->param_type = $param_type;
    }

    /**
     * Get the value of param_code
     *
     * @return  string  Authentication code.
     */
    public function getParam_code(): string {
        return $this->param_code;
    }

    /**
     * Set the value of param_code
     *
     * @param  string  Authentication code.
     */
    public function setParam_code(string $param_code): void {
        $this->param_code = $param_code;
    }

    /**
     * Get the value of param_token
     *
     * @return  string  user token
     */
    public function getParam_token(): string {
        return $this->param_token;
    }

    /**
     * Set the value of param_token
     *
     * @param  string  user token
     */
    public function setParam_token(string $param_token): void {
        $this->param_token = $param_token;
    }

    public function getRedirect_url() {
        return $this->redirect_url;
    }

    public function setRedirect_url($redirect_url): void {
        $this->redirect_url = $redirect_url;
    }

}
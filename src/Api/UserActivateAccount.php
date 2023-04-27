<?php

namespace SFAPI\Api;

class UserActivateAccount extends Api {
    const ACTION = 'user_activate_account';

    private $param_terms;
    private $param_token; // To link a user with an account

    /**
     * Based on a code from a service, we can log the user in.
     *
     * docs https://stereofox.atlassian.net/wiki/spaces/STEREOFOX/pages/321421334/SFAPI+User+Authenticate
     *
     * @param string $slug
     * @param string $postType
     * @return ?object
     */
    public function send(): ?object {

        $this->setDoCache(false);

        $params   = [
            'token' => $this->getParam_token(),
            'terms' => $this->getParam_terms()
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

    public function getParam_terms() {
        return $this->param_terms;
    }

    public function setParam_terms($param_terms): void {
        $this->param_terms = $param_terms;
    }

}
<?php

namespace SFAPI\Api;

/**
 * Based on the Type of login, fetch the login URL for each service.
 *
 * https://www.stereofox.com/?api=eyAiYWN0aW9uIjogImdldF91c2VyX2xvZ2luX3VybCIsICJwYXJhbXMiOiB7ICJyZWRpcmVjdF91cmwiOiJodHRwOi8vd3d3LnN0ZXJlb2ZveC5pby8/c3BvdGlmeSIgfX0=
 */
class UserLoginUrlGet extends Api {
    const ACTION = 'get_user_login_url';

    public $redirect_url;

    /**
     * Based on a code from a service, we can log the user in.
     *
     * docs
     *
     * @return object
     */
    public function fetch(): object|null {

        $resp = $this->request(
            [
                'redirect_url' => $this->getRedirect_url(),
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

    public function getRedirect_url() {
        return $this->redirect_url;
    }

    public function setRedirect_url($redirect_url): void {
        $this->redirect_url = $redirect_url;
    }
}
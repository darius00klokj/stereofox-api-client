<?php

namespace App\Api;

/**
 * docs: https://stereofox.atlassian.net/wiki/spaces/STEREOFOX/pages/730988545/SFAPI+User+Password+Recovery+Email
 */
class UserPasswordRecoveryEmail extends Api {
    const ACTION = 'user_password_recovery';

    private $param_email;
    private $param_referer;
    private $param_action;

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
                'email' => $this->getParam_email(),
                'referer' => $this->getParam_referer(),
                'action' => $this->getParam_action()
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
    public function getParam_email() {
        return $this->param_email;
    }

    /**
     * Set the value of email
     *
     * @param  the  user email

     */
    public function setParam_email(string $param_email): void {
        $this->param_email = $param_email;
    }

    public function getParam_referer() {
        return $this->param_referer;
    }

    public function setParam_referer($param_referer): void {
        $this->param_referer = $param_referer;
    }

    public function getParam_action() {
        return $this->param_action;
    }

    public function setParam_action($param_action): void {
        $this->param_action = $param_action;
    }
}
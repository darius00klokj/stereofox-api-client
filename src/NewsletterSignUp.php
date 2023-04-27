<?php
/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Api;

/**
 * Description of NewsletterSignUp
 *
 * @author darius
 */
class NewsletterSignUp extends Api {
    //put your code here
    const ACTION = 'newsletter_sign_up';

    private $param_email;

    /**
     * Sends prepared query to database via API.
     *
     * Sample: https://api.stereofox.com/?api=ewogICAiYWN0aW9uIjoiZ2V0X21ldGFzIiwKICAgInBhcmFtcyI6ewogICAgICAidXJpIjoiL2FsZmEtbWlzdC10ZWtpLyIKICAgfSAgICAgICAKfQ==
     * docs https://stereofox.atlassian.net/wiki/spaces/STEREOFOX/pages/536969217/SFAPI+Get+URL+Metas
     *
     * @param string $slug
     * @param string $postType
     * @return ?object
     */
    public function signup() : ?object
    {
        $resp = $this->request(
            [
                'email' => $this->getParam_email()
            ]
        );

        /**
         * If no error is present then
         */
        return $resp;
    }

    public function getParam_email() {
        return $this->param_email;
    }

    public function setParam_email($param_email): void {
        $this->param_email = $param_email;
    }

}
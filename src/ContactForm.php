<?php

namespace App\Api;

use Illuminate\Support\Facades\Http;

class ContactForm extends Api {
    const ACTION = 'send_contact_form';

    private $param_name;
    private $param_email;
    private $param_subject;
    private $param_message;

    public function send() {

        $this->setDoCache(false);

        $resp = $this->request(
            [
                'name' => $this->getParam_name(),
                'email' => $this->getParam_email(),
                'subject' => $this->getParam_subject(),
                'message' => $this->getParam_message()
            ]
        );
        /**
         * Based on the docs, any request to get_posts will
         * return a list, but we only want the first object.
         */
        if (!$resp || !isset($resp)) {
            return null;
        }

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
     * Get the value of param_type
     * 
     * @return  string  post type.
     */
    public function getParam_type(): string {
        return $this->param_type;
    }

    /**
     * Set the value of param_type
     *
     * @param  string  Post type.
     */
    public function setParam_type(string $param_type): void {
        $this->param_type = $param_type;
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

    /**
     * Get the value of email
     *
     * @return  string  user email
     */
    public function getParam_email(): string {
        return $this->param_email;
    }

    /**
     * Set the value of email
     *
     * @param  the  email

     */
    public function setParam_email(string $param_email): void {
        $this->param_email = $param_email;
    }

    /**
     * Get the value of param_subject
     *
     * @return  string  Subject of the message.
     */
    public function getParam_subject(): string {
        return $this->param_subject;
    }

    /**
     * Set the value of param_subject
     *
     * @param  string  Subject of the message.

     */
    public function setParam_subject(string $param_subject): void {
        $this->param_subject = $param_subject;
    }

    /**
     * Get the value of param_message
     *
     * @return  string  Actual message.
     */
    public function getParam_message(): string {
        return $this->param_message;
    }

    /**
     * Set the value of param_message
     *
     * @param  string  Actual message.

     */
    public function setParam_message(string $param_message) {
        $this->param_message = $param_message;
    }
}
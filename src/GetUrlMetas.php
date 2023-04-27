<?php

namespace App\Api;

/**
 * 
 */
class GetUrlMetas extends Api
{
    const ACTION = 'get_metas';

    private $param_uri;

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
    public function single(string $uri) : ?string
    {
        $this->setParam_uri($uri);

        $headJson = $this->request(
            [
                'uri' => $this->getParam_uri()
            ]
        );

        /**
         * Based on the docs, any request to get_posts will
         * return a list, but we only want the first object.
         */
        if (!$headJson || !isset($headJson->head)) {
            return null;
        }

        /**
         * Check that we have a response
         */
        if (empty($headJson)) {
            return null;
        }

        /**
         * Return the first instance
         */
        return $headJson->head;
    }

    /**
     * Get the value of param_uri
     *
     * @return  string  Uri to the the metas for.
     */
    public function getParam_uri(): string
    {
        return $this->param_uri;
    }

    /**
     * Set the value of param_uri
     *
     * @param  string  Uri to the the metas for.
     */
    public function setParam_uri(string $param_uri): void
    {
        $this->param_uri = $param_uri;
    }
}

<?php

namespace SFAPI\Api;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Log;
use App\Exceptions\CustomException;
use Exception;

/**
 * https://kinsta.com/blog/laravel-caching/
 */
class Api {
    const METHOD_GET      = 'GET';
    const METHOD_POST     = 'POST';
    const ACTION          = null;

    public $doCache = true;

    /**
     * Gets the API URL.
     * 
     * @return  string  API url set in .env
     */
    public static function getURL(): string {
        return surl(sprintf('%s', env('API_CONNECTION')));
    }

    /**
     * Funnel all request to the API vie this method.
     *
     * docs https://laravel.com/docs/9.x/http-client
     * 
     * @param  array  $params    API call paramters
     * @param  string $method    Http methode. POST | GET
     * @return array|object      JSON object or array.
     */
    public function request(array $params, $method = self::METHOD_GET): array|object {

        if (!static::ACTION) {
            throw new Exception('ACTION is not set in ' . static::class);
        }

        /**
         * Add the action to the params.
         */
        $params = [
            'action' => static::ACTION,
            'params' => $params
        ];

        /**
         * Check our cache first
         */
        $cache_key = md5(json_encode($params));
        $data      = $this->getCache($cache_key);
        if ($data) {
            return $data;
        }

        /**
         * Check the type of request.
         */
        if(isset($_SERVER['HTTP_HOST'])){
            $params['params']['url'] = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        }else{
            $params['params']['url'] = 'CLI';
        }
        
        if ($method === self::METHOD_POST) {
            $response = $this->post($params);
        } else {
            $response = $this->get($params);
        }

        /**
         * After request check the response.
         */
        if (!$response->successful()) {
            /**
             * Logs the error to the .log file and sends a 
             * notification to a Discord channel.
             */
            $msg = sprintf('Error %s: %s', $response->status(), $response->body());
            throw new CustomException($msg);
        }

        /**
         * Convert to JSON
         */
        try {
            $json = $response->json();
        } catch (Exception $ex) {
            /**
             * Logs the error to the .log file and sends a 
             * notification to a Discord channel.
             */
            $msg = sprintf('Unable to decode %s: %s', $response->status(), $response->body());
            throw new CustomException($msg);
        }

        /**
         * Make sure the response is an object.
         */
        $data = is_array($json) ? (object) $json : $json;
        if ($data && !isset($data->error)) {
            /**
             * Lets cache those responses
             */
            $this->setCache($cache_key, $data);
        }

        return $data;
    }

    /**
     * Will not be used yet, but, in the future we might want to change our API
     * to read JSON body instead of base64 parameters.
     *
     * @param  type   $params    API call paramters
     * @return  Response         Database response
     */
    private function post(array $params): Response {
        return Http::post(static::getURL(), $params);
    }

    /**
     * Our API for now uses this function, since we append the API JSON as
     * a base64.
     * 
     * @param  type   $params    API call paramters
     * @return  Response         Database response
     */
    private function get(array $params): Response {

        /**
         * Make sure its a JSON encoded string.
         */
        $json = is_array($params) || is_object($params) ? json_encode($params) : $params;

        /**
         * Add it to the URL
         */
        $url = sprintf('%s%s', static::getURL(), base64_encode($json));

        if (getenv('APP_DEBUG')) {
            Log::debug('API CALL');
            Log::debug($json);
            Log::debug($url);
            Log::debug(PHP_EOL);
        }

        $val = Http::get($url);
        return $val;
    }

    /**
     * To clear the cache use
     * php artisan cache:clear
     *
     * https://kinsta.com/blog/laravel-caching/
     *
     */
    public function setCache($key, $data) {
        if (getenv('APP_CACHE') && $this->getDoCache()) {
            Cache::forever($key, $data);
        }
    }

    /**
     * clear the cache with
     * php artisan cache:clear
     *
     * https://kinsta.com/blog/laravel-caching/
     * @param type $key
     */
    public function getCache($key) {
        if (getenv('APP_CACHE') && $this->getDoCache()) {
            return Cache::get($key);
        }
        return null;
    }

    public function getDoCache() {
        return $this->doCache;
    }

    public function setDoCache($doCache): void {
        $this->doCache = $doCache;
    }

}
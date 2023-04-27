<?php

namespace SFAPI\Models\Traits;

/**
 * A traits to handle all the PostGet and StreamGet parameters and their getter and setter methods.
 * 
 * PHP Manual: https://www.php.net/manual/en/language.oop5.traits.php
 */
trait PostsGetParams {
    /**
     * All PostGet related API parameters to make an valid API call.
     */
    private $param_pos; // As example
    private $param_type;
    private $param_popularity = [];
    private $param_max;
    private $param_page;
    private $param_query;
    private $param_search;
    private $param_genre;
    private $param_sortBy;
    private $param_withCount;

    /**
     * We will only accept a single string
     * @var string
     */
    private $param_orderBy;

    /**
     * We will only accept a single string
     * @var  string  ASC|DESC  
     */
    private $param_order;

    /**
     * Returns a list of Parameters to execute the current API call.
     *
     * @return  array
     */
    public function getParams(): array {
        $params = [];
        $vars   = get_object_vars($this);
        foreach ($vars as $property => $value) {
            if (strpos($property, 'param') === 0 && !is_null($value)) {
                $key          = str_replace('param_', '', $property);
                $params[$key] = $value;
            }
        }

        return $params;
    }

    /**
     * Resets all params for a new query to be executed.
     */
    public function reset(): void {
        $vars   = get_object_vars($this);
        foreach ($vars as $property => $value) {
            if (strpos($property, 'param') === 0) {
                $this->{$property} = NULL;
            }
        }
    }

    /**
     * Fetches tracks within a specified time period.  
     * Function used => mktime() format: mktime(hour, minute, second, month, day, year, is_dst)
     * 
     * @param  int  $timeFrom    The fist day of time period in unix time
     * @param  int  $timeTo      The last day of time period in unix time  
     */
    public function tracksWithinTimePeriod(int $timeFrom, int $timeTo): void {
        $this->setParam_popularity([
            'time_from' => $timeFrom,
            'time_to' => $timeTo
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Getters and Setters
    |--------------------------------------------------------------------------
    */
    /**
     * Get the value of param_type
     * 
     * @return  int  Position
     */
    public function getParam_pos(): int {
        return $this->param_pos;
    }

    /**
     * Set the value of param_type
     *
     * @param  int  $param_pos    Position
     */
    public function setParam_pos(int $param_pos): void {
        $this->param_pos = $param_pos;
    }

    /**
     * Get the value of param_type
     * 
     * @return  string|array  Type of post(s).
     */
    public function getParam_type(): string|array
    {
        return $this->param_type;
    }

    /**
     * Set the value of param_type
     * 
     * @param  string|array  $param_type    Type of post(s).
     */
    public function setParam_type(string|array $param_type): void {
        $this->param_type = $param_type;
    }

    /**
     * Get the value of param_popularity
     * 
     * @return  array
     */
    public function getParam_popularity(): array {
        return $this->param_popularity;
    }

    /**
     * Set the value of param_popularity
     *
     * @param  array  $param_popularity    Filters posts by popolarity.
     */
    public function setParam_popularity(array $param_popularity): void {
        $this->param_popularity = $param_popularity;
    }

    /**
     * Get the value of param_max
     * 
     * @return  int  max post entries
     */
    public function getParam_max(): int {
        return $this->param_max;
    }

    /**
     * Set the value of param_max
     * 
     * @param  int  $param_max    Max number of posts.
     */
    public function setParam_max(int $param_max): void {
        $this->param_max = $param_max;
    }

    /**
     * Get the value of param_page
     * 
     * @return  int  Number of pages.
     */
    public function getParam_page() {
        return $this->param_page;
    }

    /**
     * Set the value of param_page
     * 
     * @return  int  $param_page    Current page
     */
    public function setParam_page($param_page): void {
        $this->param_page = $param_page;
    }

    /**
     * Get the value of param_query
     * 
     * @return  string  Query to search for.
     */
    public function getParam_query(): string {
        return $this->param_query;
    }

    /**
     * Set the value of param_query
     *
     * @return  string  $param_query   Query to search for.
     */
    public function setParam_query(string $param_query): void {
        $this->param_query = $param_query;
    }
    /**
     * Get the value of param_search
     * 
     * @return  string  Query to search for.
     */
    public function getParam_search(): string {
        return $this->param_search;
    }

    /**
     * Set the value of param_search
     *
     * @return  string  $param_query   Query to search for.
     */
    public function setParam_search(string $param_search): void {
        $this->param_seearch = $param_search;
    }

    /**
     * Get the value of param_orderBy
     * 
     * @return  string
     */
    public function getParam_order_by(): string {
        return $this->param_orderBy;
    }

    /**
     * Set the value of param_orderBy.
     * 
     * @param  string  $param_orderBy    Filter to order posts.
     */
    public function setParam_order_by(string $param_orderBy): void {
        $this->param_orderBy = $param_orderBy;
    }

    /**
     * Get the value of param_order
     * 
     * @return  string  Order posts by applying a filter. One of these: post_date | post_title | ID
     */
    public function getParam_order(): string {
        return $this->param_order;
    }

    /**
     * Set the value of param_order
     * 
     * @param  string  $param_order    Order posts by applying a filter. One of these: post_date | post_title | ID
     */
    public function setParam_order(string $param_order): void {
        $this->param_order = $param_order;
    }

    /**
     * Get the value of param_genre
     * 
     * @return  int|array  A single music genre or an array 
     */
    public function getParam_genre(): int|string {
        return $this->param_genre;
    }

    /**
     * Set the value of param_genre
     * 
     * @param  int  $param_genre    A single music genre or array.
     */
    public function setParam_genre(int|string $param_genre): void {
        $this->param_genre = $param_genre;
    }

    public function getParam_sortBy() {
        return $this->param_sortBy;
    }

    public function getParam_withCount() {
        return $this->param_withCount;
    }

    public function getParam_orderBy(): string {
        return $this->param_orderBy;
    }

    public function setParam_sortBy($param_sortBy): void {
        $this->param_sortBy = $param_sortBy;
    }

    public function setParam_withCount($param_withCount): void {
        $this->param_withCount = $param_withCount;
    }

    public function setParam_orderBy(string $param_orderBy): void {
        $this->param_orderBy = $param_orderBy;
    }




}

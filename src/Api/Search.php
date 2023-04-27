<?php

namespace SFAPI\Api\Api;

use SFAPI\Models\SearchResult;

class Search extends Api {
    const ACTION = 'search';

    /**
     * Handles the search parameters and initiates the request.
     * 
     * @param  string  $postType       Defines the category in which to search for.
     * @param  string  $searchQuery    The actual search string.
     * @return object                   The search results.
     */
    public function search(string $searchQuery, ?string $type, ?int $currentUser = 0): object|null {

        if(!$searchQuery){
            return null;
        }
        
        $query     = [
            'search' => $searchQuery,
            'post_type' => $type,
            'max' => 50,
            'currentUser' => $currentUser
        ];
        $jsonPosts = $this->request($query);
        
        return $jsonPosts;
    }
}
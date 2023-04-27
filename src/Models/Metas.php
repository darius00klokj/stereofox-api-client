<?php

namespace SFAPI\Models;

class Metas
{ 
    public $head;
    public $status;

    public function __construct(mixed $jsonPost)
    {
        if ($jsonPost) {
            $this->populate($jsonPost);
        }
    }

    /**
     * Fills genre object with the response data.
     *  
     * @param array $jsonPost  API JSON response
     * @return boolean
     */
    public function populate(mixed $jsonPost)
    {
        $jsonPost = is_array($jsonPost) ? (object) $jsonPost : $jsonPost;
        if (!$jsonPost || !isset($jsonPost->id)) {
            return false;
        }
        foreach ($jsonPost as $property => $value) {
            if (property_exists(static::class, $property)) {
                $this->{$property} = $value;
            }
        }
    }
    
    /**
     * Get the value of head
     */
    public function getHead(): string
    {
        return $this->head;
    }

    /**
     * Set the value of head
     */
    public function setHead($head): void
    {
        $this->head = $head;
    }

    /**
     * Get the value of status
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * Set the value of status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }
}

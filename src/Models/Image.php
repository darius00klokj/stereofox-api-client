<?php

namespace SFAPI\Models;

class Image
{

    public $cropped;
    public $resized;
    public $mini;
    public $large;

    public function __construct(mixed $jsonPost)
    {
        if ($jsonPost) {
            $this->populate($jsonPost);
        }
    }

    /**
     * Fills object with the response data.
     *  
     * @param array $jsonPost  API JSON response
     * @return boolean
     */
    public function populate(mixed $jsonPost)
    {

        $jsonPost = is_array($jsonPost) ? (object) $jsonPost : $jsonPost;

        foreach ($jsonPost as $property => $value) {
            if (property_exists(static::class, $property)) {
                $this->{$property} = $value;
            }
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Getters and Setters
    |--------------------------------------------------------------------------
    */
    /**
     * Get the value of cropped
     */
    public function getCropped()
    {
        return $this->cropped;
    }

    /**
     * Set the value of cropped
     */
    public function setCropped($cropped): void
    {
        $this->cropped = $cropped;
    }

    /**
     * Get the value of resized
     */
    public function getResized(): string
    {
        return $this->resized;
    }

    /**
     * Set the value of resized
     */
    public function setResized($resized): void
    {
        $this->resized = $resized;
    }

    /**
     * Get the value of mini
     */
    public function getMini(): string
    {
        return $this->mini;
    }

    /**
     * Set the value of mini
     */
    public function setMini($mini): void
    {
        $this->mini = $mini;
    }

    /**
     * Get the value of large
     */
    public function getLarge(): string
    {
        return $this->large;
    }

    /**
     * Set the value of large
     */
    public function setLarge($large): void
    {
        $this->large = $large;
    }
}

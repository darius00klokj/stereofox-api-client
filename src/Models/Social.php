<?php

namespace SFAPI\Models;

class Social {
    public $type;
    public $url;
    public $id;

    const TYPE_STEREOFOX       = 'stereofox';
    const TYPE_STEREOFOX_LARGE = 'stereofox-large';
    const TYPE_SF_EMAIL        = 'email';
    const TYPE_SF_CLOSE        = 'close';
    const TYPE_SF_PLUS         = 'plus';
    const TYPE_APPLE           = 'apple';
    const TYPE_SPOTIFY         = 'spotify';
    const TYPE_SOUNDCLOUD      = 'soundcloud';
    const TYPE_DEEZER          = 'deezer';
    const TYPE_LINKEDIN        = 'linkedin';
    const TYPE_FACEBOOK        = 'facebook';
    const TYPE_TWITTER         = 'twitter';
    const TYPE_INSTRAGRAM      = 'instagram';
    const TYPE_AMAZON          = 'amazon';
    const TYPE_ITUNES          = 'itunes';
    const TYPE_BANDCAMP        = 'bandcamp';
    const TYPE_DISCORD         = 'discord';

    public function __construct(mixed $jsonPost) {
        if ($jsonPost) {
            $this->populate($jsonPost);
        }
    }

    /**
     * List our social platform links
     * 
     * @return type
     */
    public static function list_platforms() {
        return [
            Social::TYPE_SPOTIFY => static::getPlatformUrl(Social::TYPE_SPOTIFY),
            Social::TYPE_APPLE => static::getPlatformUrl(Social::TYPE_APPLE),
            Social::TYPE_INSTRAGRAM => static::getPlatformUrl(Social::TYPE_INSTRAGRAM),
            Social::TYPE_TWITTER => static::getPlatformUrl(Social::TYPE_TWITTER),
        ];
    }

    /**
     * Fills object with the response data.
     *  
     * @param array $jsonPost  API JSON response
     * @return boolean
     */
    public function populate(mixed $jsonPost) {

        $jsonPost = is_array($jsonPost) ? (object) $jsonPost : $jsonPost;

        foreach ($jsonPost as $property => $value) {
            if (property_exists(static::class, $property)) {
                $this->{$property} = $value;
            }
        }
    }

    /**
     * 
     * @param mixed $social 
     * @return string 
     */
    public static function getPlatformUrl($social){
        $urls = [
            Social::TYPE_SPOTIFY => 'https://open.spotify.com/user/stereofox',
            Social::TYPE_APPLE => 'https://music.apple.com/profile/stereofox',
            Social::TYPE_INSTRAGRAM => 'https://www.instagram.com/wearestereofox/',
            Social::TYPE_FACEBOOK => 'https://www.facebook.com/wearestereofox',
            Social::TYPE_TWITTER => 'https://twitter.com/wearestereofox',
            Social::TYPE_SOUNDCLOUD => 'https://soundcloud.com/wearestereofox/',
            Social::TYPE_DISCORD => 'https://discord.gg/nWd7VccZ'
        ];

        return $urls[$social];
    }

    /**
     *
     * @param type $type
     * @return string
     */
    public static function getLabel($type) {

        $labels = [
            static::TYPE_SPOTIFY => 'Spotify',
            static::TYPE_TWITTER => 'Twitter',
            static::TYPE_FACEBOOK => 'Facebook',
            static::TYPE_SOUNDCLOUD => 'Soundcloud',
            static::TYPE_APPLE => 'Apple',
            static::TYPE_DISCORD => 'Discord'
        ];

        return $labels[$type];
    }
    /*
      |--------------------------------------------------------------------------
      | Getters and Setters
      |--------------------------------------------------------------------------
     */

    /**
     * Get the value of url
     * 
     * @return  string    url string of the social network
     */
    public function getURL(): string {
        return $this->url;
    }

    /**
     * Set the value of url
     * 
     * @param  string  $url    url string of the social network
     */
    public function setURL(string $url): void {
        $this->url = $url;
    }

    /**
     * Get the value of id
     * 
     * @return  int    id of the social network.
     */
    public function getID(): mixed {
        return ($this->id);
    }

    /**
     * Set the value of id
     * 
     * @param  int  $id    id of the social network.
     */
    public function setID(mixed $id): void {
        $this->id = $id;
    }

    public function getType() {
        return $this->type;
    }

    public function setType($type): void {
        $this->type = $type;
    }
}
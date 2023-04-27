<?php

namespace SFAPI\Models\Traits;

use SFAPI\Models\Artist;
use SFAPI\Models\Post;


/**
 * Description of ArticleProps
 *
 * @author darius
 */
trait ArticleProps {

    public $artists = [];
    public $related_tracks = [];
    public $related_articles = [];

    /*
     * @param mixed $jsonPost
     */
    public function populate(mixed $jsonPost) {
        parent::populate($jsonPost);

        if ($this->artists) {
            $list          = $this->artists;
            $this->artists = [];
            foreach ($list as $obj) {
                $this->artists[] = new Artist($obj);
            }
        }

        if ($this->related_tracks) {
            $list                 = $this->related_tracks;
            $this->related_tracks = [];
            foreach ($list as $obj) {
                $this->related_tracks[] = new Post($obj);
            }
        }

        if ($this->related_articles) {
            $list                 = $this->related_articles;
            $this->related_articles = [];
            foreach ($list as $obj) {
                $this->related_articles[] = new Post($obj);
            }
        }
    }

    public function getArtists() {
        return $this->artists;
    }

    public function getRelated_tracks() {
        return $this->related_tracks;
    }

    public function setArtists($artists): void {
        $this->artists = $artists;
    }

    public function setRelated_tracks($related_tracks): void {
        $this->related_tracks = $related_tracks;
    }

    public function getRelated_articles() {
        return $this->related_articles;
    }

    public function setRelated_articles($related_articles): void {
        $this->related_articles = $related_articles;
    }

}
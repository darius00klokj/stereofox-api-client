<?php

namespace SFAPI\Models;

use SFAPI\Api\PostsGet;
use SFAPI\Models\Artist;
use App\Http\Controllers\LabelController;

class Label extends PostType {
    /**
     * 
     * @var Track[]
     */
    public $tracks;

    /**
     *
     * @var Artist[]
     */
    public $artists;

    /**
     * The slug for the label of Stereofox Records
     */
    const SF_RECORDS_SLUG = 'stereofox-records';

    public function populate($jsonPost) {

        parent::populate($jsonPost);

        if (isset($jsonPost->tracks)) {
            $trs          = $jsonPost->tracks;
            $this->tracks = [];
            $this->artists = [];
            foreach ($trs as $tr) {
                $track          = new Track($tr);
                $this->tracks[] = $track;

                /**
                 * Fill the artists
                 */
                $arts = $track->getArtists();
                foreach($arts as $art){
                    $this->artists[$art->ID] = $art;
                }
            }

        }
    }

    /**
     * Gets the URL of the Labels
     * 
     * @return string
     */
    public function getURL(): string {
        return sprintf('%s/%s/', LabelController::getListURI(), $this->getPost_name());
    }

    public function __construct(mixed $jsonPost) {
        /**
         * Calls the methode populate in the parent class PostType.
         */
        if ($jsonPost) {
            $this->populate($jsonPost);
        }
    }

    public static function fetchBySlug(string $slug): Label|null {
        /**
         * Init the API for posts
         */
        $api = new PostsGet();

        /**
         * Fetch the single JSON
         */
        $jsonPost = $api->single($slug, PostType::TYPE_LABEL);

        if (!$jsonPost) {
            /**
             * When view controller reads NULL, then 404 the request.
             */
            return null;
        }

        return new Label($jsonPost);
    }

    /**
     * Will splice the array based on the current page.
     * 
     * @param int $page
     * @return Track[]
     */
    public function getTracks(int $page = 1): array {
        if (!$this->tracks) {
            return [];
        }
        $page = $page ? $page - 1 : 0;
        return array_slice($this->tracks, $page * 25, 25);
    }

    /**
     *
     * @return Artist[]
     */
    public function getArtists(int $page = 1): array {
        if (!$this->artists) {
            return [];
        }
        $page = $page ? $page - 1 : 0;
        return array_slice($this->artists, $page * 25, 25);
    }

    /**
     * Will count how many tracks there are in the label
     *
     * @return int
     */
    public function countTracks(): int {
        return count($this->tracks);
    }

    /**
     * Will count how many artists there are in the label
     *
     * @return int
     */
    public function countArtists(): int {
        return count($this->artists);
    }

    public function setTracks(array $tracks): void {
        $this->tracks = $tracks;
    }

    public function setArtists(array $artists): void {
        $this->artists = $artists;
    }
}
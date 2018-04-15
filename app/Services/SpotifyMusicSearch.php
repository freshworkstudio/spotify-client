<?php

namespace App\Services;

use App\Contracts\MusicSearchInterface;
use SpotifyWebAPI\SpotifyWebAPI;

/**
 * Class SpotifyMusicSearch
 * @package App\Serivices
 */
class SpotifyMusicSearch implements MusicSearchInterface
{
    /**
     * @var SpotifyWebAPI
     */
    private $api;
    /**
     * SearchController constructor.
     * @param SpotifyWebAPI $api
     */
    public function __construct(SpotifyWebAPI $api)
    {
        $this->api = $api;
    }

    /**
     * @param $query
     * @return null
     */
    public function search($query)
    {
        $response = $this->api->search($query, ['track']);
        $response = json_decode(json_encode($response), true);
        return $response['tracks']['items'] ?? null;
    }

    /**
     * Get popular tracks on a specific Country
     * @param $countryCode
     * @return null
     */
    public function charts($countryCode)
    {
        if ($countryCode !== 'CL') {
            return [];
        }

        $tracks = $this->api->getUserPlaylist(config('services.spotify.charts_user'), config('services.spotify.charts_playlist'));
        $tracks = collect($tracks->tracks->items);
        $tracks = $tracks->map(function($track) {
            return $track->track;
        });
        return $tracks;

    }
}
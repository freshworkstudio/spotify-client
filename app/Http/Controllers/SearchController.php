<?php

namespace App\Http\Controllers;

use App\Contracts\MusicSearchInterface;
use App\Serivices\SpotifyMusicSearch;
use Illuminate\Http\Request;
use SpotifyWebAPI\SpotifyWebAPI;

/**
 * Class SearchController
 * @package App\Http\Controllers
 */
class SearchController extends Controller
{

    /**
     * @param Request $request
     * @param MusicSearchInterface $musicSearch
     * @return mixed
     */
    public function search(Request $request, MusicSearchInterface $musicSearch)
    {
        $this->validate($request, [
            'q' => 'required|min:3'
        ]);

        $tracks = null;
        if ($request->get('q') === 'most_popular') {
            $tracks = $musicSearch->charts('CL');
        } else {
            $tracks = $musicSearch->search($request->get('q'));
        }


        return $tracks;
    }
}

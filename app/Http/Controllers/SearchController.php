<?php

namespace App\Http\Controllers;

use App\Contracts\MusicSearchInterface;
use App\SearchLog;
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
        $this->logQueryOnDatabase($request);
        $tracks = $this->getTracksBasedOnQuery($request, $musicSearch);

        return $tracks;
    }

    public function getTrack($id, MusicSearchInterface $musicSearch)
    {
        return $musicSearch->getTrack($id);
    }
    /**
     * @param Request $request
     */
    public function logQueryOnDatabase(Request $request): void
    {
        try {
            $log = new SearchLog();
            $log->query = $request->get('q');
            $log->ip = $request->ip();
            $log->save();
        } catch (\Exception $exception) {
            logger()->error($exception);
        }
    }
    /**
     * @param Request $request
     * @param MusicSearchInterface $musicSearch
     * @return null
     */
    public function getTracksBasedOnQuery(Request $request, MusicSearchInterface $musicSearch)
    {
        $tracks = null;
        if ($request->get('q') === 'most_popular') {
            $tracks = $musicSearch->charts('CL');
        } else {
            $tracks = $musicSearch->search($request->get('q'));
        }

        return $tracks;
    }
}

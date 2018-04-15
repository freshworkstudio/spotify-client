<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SpotifyWebAPI\SpotifyWebAPI;

class SearchController extends Controller
{
    public function search(Request $request, SpotifyWebAPI $api)
    {
        $this->validate($request, [
            'q' => 'required|min:3'
        ]);

        $response = $api->search($request->get('q'), ['album', 'artist', 'track']);

        return json_decode(json_encode($response), true);
    }
}

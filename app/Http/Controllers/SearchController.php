<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class SearchController extends Controller
{
    /*
    * Shows a simple search box
    * */
    public function showForm()
    {
        //show random movies in the frontpage
        $movies = Movie::inRandomOrder()->limit(10)->get();
        return view('search.form', ['movies' => $movies]);
    }

    /*
    *
    * Retrieves the movie searched by name
    *
    * */
    public function findMovie(Request $request)
    {
        /* $movie = Movie::where(['name' => $request->input('name')])->firstOrFail(); */
        //Not matching an exact name
        $movie = Movie::where('name', 'LIKE', "%{$request->input('name')}%")->firstOrFail();
        return view('search.result', ['movie'=> $movie, 'trailer'=> $this->apiRequest($movie)]);
    }

    /*
    * Retrieves a movie by id
    * */
    public function serve(Movie $movie)
    {
        $apiRequest = $this->apiRequest($movie);
        return view('search.result', ['movie'=> $movie]);
    }
    /*
    *
    * Send back the lookup response as json
    *
    * @return \Illuminate\Http\Response
    *
    * */
    public function autocomplete(Request $request)
    {
        $response = Movie::select('name')
            ->where('name', 'LIKE', "%{$request->term}%")
            ->get();

        return response()->json($response);
    }

    public function apiRequest(Movie $movie)
    {
        $apiKey = 'd2b1c2298093b6a80271b3b3cac17780';
        $link = "https://api.themoviedb.org/3/movie/$movie->imdb_id/videos?api_key=$apiKey&language=en-US&external_source=imdb_id";
        dump($link);
        $response = Http::get($link)->json();
        if (empty($response['results'])) {
            return null;
        }
        return $response;
    }
}

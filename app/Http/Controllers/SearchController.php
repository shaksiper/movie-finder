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
        $movie = Movie::where(['name' => $request->input('name')])->firstOrFail();
        return view('search.result', ['movie'=> $movie]);
    }

    /*
    * Retrieves a movie by id
    * */
    public function serve(Movie $movie)
    {
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
}

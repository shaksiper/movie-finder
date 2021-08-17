@extends('layouts.app')
@section('content')
<form method="post" action="{{route('search')}}">
    @csrf
    <div class="p-8 pt-20">
      <div class="bg-white flex items-center rounded-full shadow-xl">
        <input class="rounded-l-full w-full py-4 px-6 text-gray-700 leading-tight focus:outline-none" id="name" name="name" type="text" placeholder="Search">
        
    <div class="p-4">
          <button class="bg-blue-500 text-white rounded-full p-2 hover:bg-blue-400 focus:outline-none w-12 h-12 flex items-center justify-center">
            &#128269;
          </button>
          </div>
        </div>
     </div>
    </form>
<script src="{{ asset('js/auto.js') }}"></script>
<div class="min-h-screen bg-gray-100 py-6 flex flex-row flex-wrap justify-center sm:py-12">
@foreach($movies as $movie)
  
  <div class="py-6 sm:max-w-xl sm:mx-auto">
    <div class="bg-white shadow-lg border-gray-100 max-h-80	 border sm:rounded-3xl p-8 flex space-x-8">
      <div class="h-48 overf;ow-visible w-1/2">
          <img class="rounded-3xl shadow-lg" src="{{$movie->image}}" alt="">
      </div>
      <div class="flex flex-col w-1/2 space-y-4">
        <div class="flex justify-between items-start">
          <h2 class="text-3xl font-bold"><a href='{{route("serve.movie", $movie)}}'>{{$movie->name}}</a></h2>
          <div class="bg-yellow-400 font-bold rounded-xl p-2">{{number_format( $movie->rating,1,'.' )}}</div>
        </div>
        <div>
          <div class="text-sm text-gray-400">{{$movie->genre}}</div>
          <div class="text-lg text-gray-800">{{$movie->release_year}}</div>
        </div>
          <p class="text-sm text-gray-400 max-h-40 overflow-y-hidden">{{$movie->synopsis}}</p>
        <div class="flex text-2xl text-a">{{$movie->directors}}</div>
      </div>

    </div>
  </div>
  
@endforeach 
</div>
@endsection

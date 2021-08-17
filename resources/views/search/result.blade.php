@extends('layouts.app')
@section('content')
<div class="min-h-screen bg-gray-100 py-6 flex flex-col justify-center sm:py-12">
  
  <div class="py-6 sm:max-w-xl sm:mx-auto">
    <div class="bg-white shadow-lg border-gray-100 max-h-200	 border sm:rounded-3xl p-8 flex space-x-8">
      <div class="h-48 overf;ow-visible w-1/2">
          <img class="rounded-3xl shadow-lg" src="{{$movie->image}}" alt="">
      </div>
      <div class="flex flex-col w-1/2 space-y-4">
        <div class="flex justify-between items-start">
          <h2 class="text-3xl font-bold">{{$movie->name}}</h2>
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
  
</div>
@endsection

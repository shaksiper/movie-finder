@extends('layouts.app')
@section('content')
<style>
    :root {

        --shadow:0 25px 50px -12px rgba(0, 0, 0, 0.25);
        --ring-offset-shadow:0 0 #0000;
        --ring-shadow:0 0 #0000;
    }

    .card_open {
        animation-duration: 2s;
        background: #ccc;
        animation-name: card_open;
    }

    @keyframes card_open {
        from {
            height: 1%;
            box-shadow: var(--shadow);
        }

        to {
            height: 100%;
            box-shadow: var(--ring-offset-shadow,0 0 #0000),var(--ring-shadow,0 0 #0000),var(--shadow);
        }
    }
</style>
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
            <button id="card_open" class="py-8 px-8 bg-green-400 hover:bg-green-300 border-gray-500 text-blue-50 hover:text-white rounded-md block">Watch trailer</button>
      </div>

    </div>
  </div>
  <div id="card_panel" class="main-modal fixed w-full inset-0 z-50 overflow-hidden flex justify-center items-center hidden">
        <div class="modal-container bg-white w-4/12 md:max-w-11/12 mx-auto rounded-xl z-50 overflow-y-auto">
            @if($trailer)
            <div class="modal-content py-4 text-left px-6">
                <div class="my-5 mr-5 ml-5 flex justify-center">
                    <p>{{$trailer['results'][1]['key']}}</p>
                    div class="relative" style="padding-top: 56.25%">
  <iframe class="absolute inset-0 w-full h-full" src="https://www.youtube-nocookie.com/embed/{{$trailer['results'][1]['key']}}" frameborder="0" …></iframe>
</div>
                </div>
                <div class="flex justify-end pt-2 pr-4 space-x-14">
                    <p id='card_close' class="modal-close cursor-pointer">Close window</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
<script>
    const card_open = document.getElementById('card_open')
    const card_close = document.getElementById('card_close')
    const card_panel = document.getElementById('card_panel')

    function modalState() {
        if(card_panel.classList.contains('hidden')) {
            // Show modal
            card_panel.classList.remove('hidden')
            card_panel.classList.add('block')

            // Delete button
            card_open.classList.add('hidden')
            card_open.classList.remove('block')

            // Start animation open
            card_panel.classList.add('card_open')
        } else {
            // Delete modal
            card_panel.classList.add('hidden')
            card_panel.classList.remove('block')

            // Show button
            card_open.classList.remove('hidden')
            card_open.classList.add('block')

            // Remove animation open
            card_panel.classList.remove('card_open')
        }
    }

    card_open.addEventListener('click', modalState)
    card_close.addEventListener('click', modalState)
</script>

@endsection

@extends('layouts.app')

@section('content')

                  <div class="scoreboard">

                    <div class="score">
                      {{ $game->points_black }} : {{ $game->points_green }}
                    </div>

                  </div>
            
@endsection

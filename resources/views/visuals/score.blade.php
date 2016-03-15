@extends('layouts.app')

@section('content')

                  <div class="scoreboard">
                    <div class="names row">
                      <p class="playerOne col-md-4">
                        {{ $game->player1 }}
                      </p>
                      <p  class="col-md-offset-1 col-md-5">
                        :
                      </p>
                      <p class="playerTwo col-md-5">
                        {{ $game->player2 }}
                      </p>
                    </div>

                    <div class="score">
                      {{ $game->points_black }} : {{ $game->points_green }}
                    </div>

                  </div>

@endsection

@extends('layouts.app')

@section('content')

                  <div class="scoreboard">
                    <div class="names row">
                      <p class="playerOne col-md-4">
                        @{{ player1 }}
                      </p>
                      <p  class="col-md-offset-1 col-md-5">
                        :
                      </p>
                      <p class="playerTwo col-md-5">
                        @{{ player2 }}
                      </p>
                    </div>

                    <div class="score">
                      @{{points_black}} : @{{ points_green }}
                    </div>

                    <div class="winner">
                      winner: @{{winner}}
                    </div>

                  </div>

                  <script>
                    var black   = "<?php echo(isset($game) ?  $game->points_black : "0"); ?>";
                    var green   = "<?php echo(isset($game) ?  $game->points_green : "0"); ?>";
                    var player1 = "<?php echo((isset($game) && $game->getPlayer1) ?  $game->getPlayer1->name : "player 1"); ?>";
                    var player2 = "<?php echo((isset($game) && $game->getPlayer2) ?  $game->getPlayer2->name : "player 2"); ?>";
                    var winner  = "<?php echo(isset($game) ?  $game->winner : ""); ?>";
                  </script>
                  <script src="/js/scoreboard.js"></script>
@endsection

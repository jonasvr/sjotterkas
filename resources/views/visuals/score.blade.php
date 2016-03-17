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
                  var black = "<?php echo  $game->points_black; ?>";
                  var green = "<?php echo  $game->points_green; ?>";
                  var player1 = "<?php echo  $game->player1; ?>";
                  var player2 = "<?php echo  $game->player2; ?>";
                  var winner = "<?php echo  $game->winner; ?>";

                  var socket = io('http://152.146.46.125:3000');//raspberry
                  // var socket = io('http://127.0.0.101:3000'); //locaal => kan veranderen
                    new Vue({
                      el: '.scoreboard',

                      data:{
                        points_black:black,
                        points_green:green,
                        player1:player1,
                        player2:player2,
                        winner:winner
                      },

                      ready: function(){
                        socket.on('points-channel:App\\Events\\UpdateScore', function(data){
                          console.log(data);
                          this.points_black = data.points_black;
                          this.points_green = data.points_green;
                        }.bind(this));
                        socket.on('player-channel:App\\Events\\UpdatePlayers', function(data){
                          console.log(data);
                          this.player1 = data.player1;
                          this.player2 = data.player2;
                        }.bind(this));
                        socket.on('winner-channel:App\\Events\\UpdateWinner', function(data){
                          console.log(data);
                          this.winner = data.winner;
                        }.bind(this));
                        socket.on('new-channel:App\\Events\\NewGame', function(data){
                          if(data.new)
                          {
                            this.points_black = 0;
                            this.points_green = 0;
                            this.player1 = "player 1";
                            this.player2 = "player 2";
                            this.winner = "";
                          }
                        }.bind(this));
                      }
                    })
                  </script>
@endsection

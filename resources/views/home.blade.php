@extends('layouts.app')

@section('content')
  <div class="wrapper border-R-25 scoreboard">
    <div class="row">
      <div class="col-md-8 padding-top-10 ">
        <div class="bgBlack padding-10 height-400">
          <h2 class='text-center red'>Current Game</h2>
          <div class="row">
            <div class="text-center font-BNP red  ">
                <p class=" text-size-50">
                    @{{ player1 }} vs  @{{ player2 }}
                </p>
                  <p class=" text-size-100">
                    @{{points_black}} : @{{ points_green }}
                  </p>
                  <p class=" text-size-50">
                    winner: @{{winner}}
                  </p>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4 padding-top-10">
        <div class="bgBlack padding-10  height-400">
          <h2 class='text-center blue text-capitalize'>Record: most wins</h2>
          <div class="text-center red text-size-20">
            {{-- <div class="row">
              @foreach($rankings as $winners )
                <p>
                    {{ $winners->name }} : {{ $winners->winnings }}
                </p>
              @endforeach
            </div> --}}
            <div class="row" v-for="speed in speeds">
                <p>
                    @{{ speed.name }} : @{{ speed.winnings }}
                </p>
            </div>


          </div>
        </div>
      </div>
      {{-- new row --}}
      <div class="col-md-4 padding-top-10">
        <div class="bgBlack padding-10 height-235">
          <h2 class='text-center blue text-capitalize'>Record: past games</h2>
          <div class="text-center red text-size-20">
            <div class="row">
              @foreach($matches as $match)
                <div class="col-md-offset-1 col-md-4 col-xs-offset-2 col-xs-3 text-center text-capitalize">
                    {{ $match->player1 }}:   {{ $match->points_black }}
                </div>
                <div class=" col-md-2 col-xs-2 text-uppercase">
                  vs
                </div>
                <div class=" col-md-4 col-xs-3  text-center text-capitalize">
                  {{ $match->player2 }}:   {{ $match->points_green }}
                </div>
              @endforeach
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4 padding-top-10">
        <div class="bgBlack padding-10 height-235">
          <h2 class='text-center blue text-capitalize'>Record:Goal Saldo</h2>
          <div class="text-center red text-size-20">
            <div class="row">
              <p>Jonas:0</p>
              <p>Jonas:0</p>
              <p>Jonas:0</p>
              <p>Jonas:0</p>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4 padding-top-10">
        <div class="bgBlack padding-10 height-235">
          <h2 class='text-center blue text-capitalize'>Record: top speeds</h2>
          <div class="text-center red text-size-20">
            <div class="row">
              <p>Jonas:0</p>
              <p>Jonas:0</p>
              <p>Jonas:0</p>
              <p>Jonas:0</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <script>
    var black   = "<?php echo(isset($game) ?  $game->points_black : "0"); ?>";
    var green   = "<?php echo(isset($game) ?  $game->points_green : "0"); ?>";
    var player1 = "<?php echo((isset($game) &&  $game->getPlayer1) ?  $game->getPlayer1->name : "player 1"); ?>";
    var player2 = "<?php echo((isset($game) &&  $game->getPlayer2) ?  $game->getPlayer2->name : "player 2"); ?>";
    var winner  = "<?php echo(isset($game)  &&  $game->winner ?  $game->getWinner->name : ""); ?>";
    // var speeds   = "<?php echo(isset($rankings) ?  $rankings : ['name'=>'','winnings'=>'']); ?>";

  </script>
  <script src="/js/scoreboard.js"></script>
@endsection

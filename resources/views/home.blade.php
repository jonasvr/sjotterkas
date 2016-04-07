@extends('layouts.app')

@section('content')
    <div class="wrapper scoreboard">
    <div v-if="show" class="row">
        <div class="col-md-12">
            <div class="bgBlack font-BNP height-45 maxHeight-45">
                <div class="col-md-offset-4 col-md-4">
                    <div class="message  padding-0">
                        <p class="text text-size-30 text-center text-capitalize margin-0">
                            New game started
                        </p>
                    </div>
                </div>
            </div>
        </div>
      <div class="col-md-8 padding-top-10 ">
          {{-- <div class="col-md-5 message red">
              test
          </div> --}}
        <div class="bgBlack padding-10 height-400">
        <h2 class='text-center red'>Current Game</h2>
          <div class="row">
            <div class="text-center font-BNP red  ">
                <p class=" text-size-50">
                    @{{ player1 }} vs  @{{ player2 }}
                </p>
                  <p class=" text-size-100">
                    @{{points_left}} : @{{ points_right }}
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
            <div class="row" v-for="(index, win) in wins">
                <p>
                    @{{ index }} : @{{ win }}
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
              <div v-for="match in matches">
                <div class="col-md-offset-1 col-md-4 col-xs-offset-2 col-xs-3 text-center text-capitalize">
                    @{{ match.player1 }}:   @{{ match.points_left }}
                </div>
                <div class=" col-md-2 col-xs-2 text-uppercase">
                  vs
                </div>
                <div class=" col-md-4 col-xs-3  text-center text-capitalize">
                  @{{ match.player2 }}:   @{{ match.points_right }}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4 padding-top-10">
        <div class="bgBlack padding-10 height-235">
          <h2 class='text-center blue text-capitalize'>Record:Goal Saldo</h2>
          <div class="text-center red text-size-20">
              <div class="row" v-for="(index, kd) in kds">
                  <p>
                      @{{ index }} : @{{ kd }}
                  </p>
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


    <div v-if="!show" class="row">
      <div class="col-md-offset-3 col-md-6">
        <div class="bgBlack height-400 text-center red">
        <p class="padding-top-10">
          Just started up.
        </p>
        <p>
          Start new game!
        </p>
          <img class="height-300 padding-top-10" src="/img/logo.png" alt="" />
        </div>
      </div>
    </div>




  </div>
@endsection


@section('js')
    <script src="/js/scoreboard.js"></script>
@endsection

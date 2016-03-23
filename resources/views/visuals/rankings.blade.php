@extends('layouts.app')

@section('content')
        <div class="container">
          <div class="row">
            <div class="col-md-offset-1 col-md-5 matches text-center blue text-capitalize">
              matches
              <div class="row padding-top-20">
                <div class="col-md-5 text-center text-capitalize">
                name: score
                </div>
                <div class=" col-md-2 text-uppercase">
                  vs
                </div>
                <div class=" col-md-5 text-center text-capitalize">
                  name: score
                </div>

                @foreach($matches as $match)
                  <div class="col-md-5 text-center text-capitalize">
                      {{ $match->player1 }}:   {{ $match->points_black }}
                  </div>
                  <div class=" col-md-2 text-uppercase">
                    vs
                  </div>
                  <div class=" col-md-5 text-center text-capitalize">
                    {{ $match->player2 }}:   {{ $match->points_green }}
                  </div>
                @endforeach

              </div>
            </div>
            <div class="col-md-5 ranking text-center blue text-capitalize">
              ranking
              <div class="row padding-top-20">
                <div class="col-md-offset-2 col-md-6 text-center">
                  Name
                </div>
                <div class="col-md-offset-4 text-center">
                  winnings
                </div>
                @foreach($rankings as $winners )
                  <div class="col-md-offset-2 col-md-6 text-center">
                  {{ $winners->name }}
                  </div>
                  <div class="col-md-offset-4 text-center">
                    {{ $winners->winnings }}
                  </div>
                @endforeach

              </div>
            </div>
          </div>
        </div>
@endsection

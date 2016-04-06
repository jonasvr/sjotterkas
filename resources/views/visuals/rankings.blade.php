@extends('layouts.app')

@section('content')
        <div class="wrapper">
            <div class="row">
            <div class="col-md-6 padding-top-10 ">
                <div class="bgBlack padding-10 minheight-400">
                <h2 class='text-center blue text-capitalize'>Record: most wins</h2>
                    <div class="text-center red  text-size-30">
                        @foreach($wins as $name => $win)
                          {{ $name . ": " . $win }} <br>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-6 padding-top-10 ">
                <div class="bgBlack padding-10 minheight-400">
                <h2 class='text-center blue text-capitalize'>Record: most losses</h2>
                    <div class="text-center red  text-size-30">
                        @foreach($losses as $name => $loss)
                          {{ $name . ": " . $loss }} <br>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-6 padding-top-10 ">
                <div class="bgBlack padding-10 minheight-400">
                <h2 class='text-center blue text-capitalize'>Record: wins/total</h2>
                    <div class="text-center red  text-size-30">
                        @foreach($percentage as $name => $stats)
                          {{ $name . ": " . $stats['winPerc']. "%" }} <br>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-6 padding-top-10 ">
                <div class="bgBlack padding-10 minheight-400">
                <h2 class='text-center blue text-capitalize'>Record: Goal Ratio</h2>
                    <div class="text-center red  text-size-30">
                        {{-- {{dd($kds)}} --}}
                        @foreach($kds as $name => $kd)
                          {{ $name . ": " . $kd }} <br>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md-6 padding-top-10 ">
                <div class="bgBlack padding-10 minheight-400">
                <h2 class='text-center blue text-capitalize'>Record: topspeeds</h2>
                    <div class="text-center red  text-size-30">
                        @foreach($percentage as $name => $stats)
                          {{ $name . ": " . $stats['winPerc']. "%" }} <br>
                        @endforeach
                    </div>
                </div>
            </div>
                {{-- <pre>
                    {{ var_dump($wins) }}
                </pre>
              @foreach($wins as $name => $win)
                {{ $name . " " . $win }} <br>
              @endforeach
            </div>
          <div class="row">
            @foreach($matches as $match)
              <pre>
                  {{ var_dump($match) }}
              </pre>
            @endforeach --}}
          </div>
        </div>
@endsection

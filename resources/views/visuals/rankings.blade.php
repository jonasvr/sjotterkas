@extends('layouts.app')

@section('content')
        <div class="wrapper rankings">
            <div class="row">
            <div class="col-md-6 padding-top-10 ">
                <div class="bgBlack padding-10 minheight-400">
                @include('records.wins')
                </div>
            </div>
            <div class="col-md-6 padding-top-10 ">
                <div class="bgBlack padding-10 minheight-400">
                    @include('records.kd')
                </div>
            </div>
            <div class="col-md-6 padding-top-10 ">
                <div class="bgBlack padding-10 minheight-400">
                {{-- <h2 class='text-center blue text-capitalize'>Record: most losses</h2>
                    <div class="text-center red  text-size-30">
                        @foreach($losses as $name => $loss)
                          {{ $name . ": " . $loss }} <br>
                        @endforeach
                </div> --}}
                @include('records.losses')
                </div>
            </div>
            <div class="col-md-6 padding-top-10 ">
                <div class="bgBlack padding-10 minheight-400">
                {{-- <h2 class='text-center blue text-capitalize'>Record: wins/total</h2>
                    <div class="text-center red  text-size-30">
                        @foreach($percentage as $name => $stats)
                          {{ $name . ": " . $stats['winPerc']. "%" }} <br>
                        @endforeach
                    </div> --}}
                    @include('records.pcs')
                </div>
            </div>

            <div class="col-md-6 padding-top-10 ">
                <div class="bgBlack padding-10 minheight-400">
                @include('records.speed')
                </div>
            </div>
            <div class="col-md-6 padding-top-10 ">
                <div class="bgBlack padding-10 minheight-400">
                @include('records.past')
                </div>
            </div>
          </div>
        </div>
@endsection

@section('js')
    <script src="/js/rankings.js"></script>
@endsection

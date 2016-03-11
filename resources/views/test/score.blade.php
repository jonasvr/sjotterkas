@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Welcome</div>

                <div class="panel-body">
                  {!! Form::open(array('url' => URL::route('score'), 'method' => 'post')) !!}
                    {!! Form::label('team') !!}
                    {!! Form::text('team')!!}
                  {!! Form::submit() !!}
                  {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

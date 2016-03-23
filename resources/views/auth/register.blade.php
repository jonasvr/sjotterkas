@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/player/addName') }}">
                        {!! csrf_field() !!}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}">

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('card_id') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Card id</label>

                            <div class="col-md-6">
                                <label class="control-label">@{{ card_id }}</label>
                                @if ($errors->has('card_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i>Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

// var socket = io('http://10.242.16.39:3000');//raspberry
// var socket = io('http://192.168.56.101:3000'); //locaal => kan veranderen

  new Vue({
    el: '.form-horizontal',

    data:{
      card_id:'Card_id',
    },

    ready: function(){
      socket.on('card-channel:App\\Events\\NewCard', function(data){
        console.log(data);
        this.card_id = data.card_id;
      }.bind(this));
    }
  })
</script>
@endsection

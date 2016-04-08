var wins  = wins;
var kds   = kds;
// var socket = io('http://10.242.16.39:3000');//raspberry
// var socket = io('http://192.168.56.101:3000'); //locaal => kan veranderen
  new Vue({
    el: '.rankings',

    data:{

      wins:wins,
      losses:losses,
      matches:matches,
      kds:kds,
      percentage:percentage,
    },

    ready: function(){
      socket.on('points-channel:App\\Events\\UpdateScore', function(data){
        console.log(data);
        this.points_left = data.points_left;
        this.points_right = data.points_right;
      }.bind(this));
      socket.on('player-channel:App\\Events\\UpdatePlayers', function(data){
        console.log(data);
        this.player1 = data.player1;
        this.player2 = data.player2;
      }.bind(this));
      socket.on('winner-channel:App\\Events\\UpdateWinner', function(data){
          console.log('winner');
        console.log(data);
        this.winner  = data.winner;
        this.wins    = data.wins;
        this.matches = data.matches;
        this.kds     = data.kds;
      }.bind(this));
      socket.on('new-channel:App\\Events\\NewGame', function(data){
        if(data.new)
        {
          this.points_left = 0;
          this.points_right = 0;
          this.player1 = "player 1";
          this.player2 = "player 2";
          this.winner = "";
          this.show = 1;
        }
      }.bind(this));
      socket.on('message-channel:App\\Events\\MessageSystem', function(data){
          console.log(data);
        $('.text').removeClass("succesMessage");
        $('.text').removeClass("errorMessage");
        $('.text').addClass(data.class);
        $('.text').html(data.message);
        $('.message').show();
        $('.message').delay(5000).fadeOut("slow");
      }.bind(this));
    }
  })

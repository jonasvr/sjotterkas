console.log(matches);
if (game != null) {
  var black   = game['points_black'];
  var green   = game['points_green'];
  var player1 = player1;
  var player2 = player2;
  var winner  = winner;
  var show    = 1;
}
else {
  var show = 0;
}
var speeds  = rankings;
// var socket = io('http://10.242.16.39:3000');//raspberry
// var socket = io('http://192.168.56.101:3000'); //locaal => kan veranderen
  new Vue({
    el: '.scoreboard',

    data:{
      points_black:black,
      points_green:green,
      player1:player1,
      player2:player2,
      winner:winner,
      speeds:speeds,
      matches:matches,
      show:show,
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
          this.show = 1;
        }
        this.speeds = data.speeds;
        this.matches = data.matches;
      }.bind(this));
    }
  })

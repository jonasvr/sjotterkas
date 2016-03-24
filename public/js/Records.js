new Vue({
  el: '.records',

  data:{
    prevGames:prevGames,
    speeds:speeds,
  },

  ready: function(){
    socket.on('new-channel:App\\Events\\NewGame', function(data){
      if(data.new)
      {
        this.prevGames  = data.matches;
        this.speeds     = data.speeds;
      }
    }.bind(this));
  }
})

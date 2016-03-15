var server = require('http').Server();

var io = require('socket.io')(server);

var Redis = require('ioredis'); //return equilevent of a class
var pointRedis = new Redis(); // class in redis
var playerRedis = new Redis();
var winnerRedis = new Redis();
var NewRedis = new Redis();



pointRedis.subscribe('points-channel');
playerRedis.subscribe('player-channel');
winnerRedis.subscribe('winner-channel');
NewRedis.subscribe('new-channel');


//when redis get any kind of message, accept channel + message
pointRedis.on('message', function(channel,message){
  message = JSON.parse(message);
  io.emit(channel + ':' + message.event, message.data); //test-channel:UserSignedUp
});

playerRedis.on('message', function(channel,message){
  message = JSON.parse(message);
  io.emit(channel + ':' + message.event, message.data); //test-channel:UserSignedUp
});

winnerRedis.on('message', function(channel,message){
  message = JSON.parse(message);
  io.emit(channel + ':' + message.event, message.data); //test-channel:UserSignedUp
});

NewRedis.on('message', function(channel,message){
  message = JSON.parse(message);
  io.emit(channel + ':' + message.event, message.data); //test-channel:UserSignedUp
});


server.listen(3000);

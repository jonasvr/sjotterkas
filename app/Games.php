<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\User;

class Games extends Model
{
  protected $fillable = [
      'player1', 'player2', 'player3','player4','winner'
  ];


  public function users()
  {
      return $this->belongsToMany('App\User','game_users', 'game_id', 'card_id');
  }

  public function getLatest() {
    return $this->orderby('id','desc')->first();
  }

  public static function ranking()
  {
    $topper   =  Games::groupBy('winner')
                      ->whereNotNull('winner')
                      ->join('users', 'users.card_id', '=', 'games.winner')
                      ->select(DB::raw('COUNT(games.winner) as winnings'),'users.name')
                      ->orderBy('winnings','desc')
                      ->take(8)
                      ->get();
    return $topper;
  }

  public static function matches()
  {
    $matches   =  Games::take(4)
                        ->whereNotNull('winner')
                        ->get();
                        // dd($matches);
    for ($i=0; $i < COUNT($matches); $i++) {
      $playerName = User::where('card_id',$matches[$i]->player1)->first();
      $matches[$i]->player1 = $playerName->name;
      $playerName = User::where('card_id',$matches[$i]->player2)->first();
      $matches[$i]->player2 = $playerName->name;
      // dd(  $matches[$i]);

    }

    return $matches;
  }

  public function getPlayer($game_id, $left)
  {
     return $this->getLatest()->users()->where('game_id',$game_id)->where('is_left',$left)->first();
  }

  public function getPlayer1()
  {
    return $this->belongsTo('App\User','player1','card_id');
  }

  public function getPlayer2()
  {
    return $this->belongsTo('App\User','player2','card_id');
  }

  public function getWinner()
  {
    return $this->belongsTo('App\User','winner','card_id');
  }
}

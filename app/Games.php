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

  public static function ranking()
  {
    $topper   =  Games::groupBy('winner')
                      ->whereNotNull('winner')
                      ->join('users', 'users.card_id', '=', 'games.winner')
                      ->select(DB::raw('COUNT(games.winner) as winnings'),'users.name')
                      ->orderBy('winnings','desc')
                      ->take(10)
                      ->get();
    return $topper;
  }

  public static function matches()
  {
    $matches   =  Games::take(10)
                        ->whereNotNull('winner')
                        ->get();
    for ($i=0; $i < COUNT($matches); $i++) {
      $playerName = User::where('card_id',$matches[$i]->player1)->first();
      $matches[$i]->player1 = $playerName->name;
      $playerName = User::where('card_id',$matches[$i]->player2)->first();
      $matches[$i]->player2 = $playerName->name;
      // dd(  $matches[$i]);

    }

    return $matches;
  }

  public function getPlayer1()
  {
    return $this->belongsTo('App\User','player1','card_id');
  }

  public function getPlayer2()
  {
    return $this->belongsTo('App\User','player2','card_id');
  }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\User;

class Games extends Model
{
  protected $fillable = [
      'winner'
  ];


  public function users()
  {
      return $this->belongsToMany('App\User','game_users', 'game_id', 'card_id')->withPivot('is_left');;
  }

  public function getLatest() {
    return $this->orderby('id','desc')->first();
  }

  public static function ranking()
  {


      $test = Games::with('users')->get();
       foreach ($test as $user) {
           echo ( $user->users[0]->pivot->is_left);
       }
     //   dd(Games::with('users')->get());
      dd($test);
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
    for ($i=0; $i < COUNT($matches); $i++) {
      $matches[$i]->player1 = $matches[$i]->getPlayer($matches[$i]->id, 1)->name;
      $matches[$i]->player2 = $matches[$i]->getPlayer($matches[$i]->id, 0)->name;
    }
    return $matches;
  }


  public function getPlayer($game_id, $left)
  {
    //  no use of this->id => had to be used in other situations
     return $this->users()
                    ->where('game_id',$game_id)
                    ->where('is_left',$left)
                    ->first();
  }

  public function countPlayers()
  {
      return $this->users()
                     ->count();
  }

  public function checkPlayer($card_id)
  {
      return $this->users()
                     ->where('game_users.card_id', $card_id)
                     //already search on card_id, had to specify in wich table
                     ->count();
  }

  public function getWinners()
  {
    //   $this->id => huidige game zijn id
      return $this->users()
            ->where('game_id',$this->id)
            ->where('is_left', 'winner')
            ->first();
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

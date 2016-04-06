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
      return $this->belongsToMany('App\User','game_users', 'game_id', 'user_id')->withPivot('is_left');
  }

  public function getLatestAttribute() {
    return $this->orderby('id','desc')->first();
  }

  public static function getMatchesAttribute()
  {
    $matches   =  Games::orderby('id','DESC')
                        ->take(4)
                        ->whereNotNull('winner')
                        ->get();
                        // dd($matches);
    for ($i=0; $i < COUNT($matches); $i++) {
        // var_dump($matches[$i]->getPlayer($matches[$i]->id, 1));
      $matches[$i]->player1 = $matches[$i]->getPlayer($matches[$i]->id, 1)->name;
      $matches[$i]->player2 = $matches[$i]->getPlayer($matches[$i]->id, 0)->name;
    }
    return $matches->toArray();
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

  public function checkPlayer($user_id)
  {
      return $this->users()
                     ->where('users.id', $user_id)
                     //already search on card_id, had to specify in wich table
                     ->count();
  }

  public function getWinnersAttribute()
  {
      return $this->users()
            ->where('game_id', $this->id)
            ->where('is_left', $this->winner)
            ->first();
  }
}

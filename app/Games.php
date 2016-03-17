<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Games extends Model
{
  protected $fillable = [
      'player1', 'player2', 'player3','player4','winner'
  ];

  public static function ranking()
  {
    $topper   =  Games::groupBy('winner')
                      ->whereNotNull('winner')
                      ->select(DB::raw('COUNT(winner) as winnings'),'winner')
                      ->orderBy('winnings','desc')
                      ->take(10)
                      ->get();
    return $topper;
  }

  public static function matches()
  {
    $matches   =  Games::take(10)
                      ->get();
    return $matches;
  }
}

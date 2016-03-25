<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game_User extends Model
{
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
      'card_id','game_id','is_left'
  ];

  public function users()
  {
    $this->belongsTo('App\User');
  }

}

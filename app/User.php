<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;
use App\Games;
class User extends Authenticatable
{

    // protected $primaryKey = 'card_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'card_id',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function games()
    {
        return $this->belongsToMany('App\Games','game_users', 'user_id', 'game_id')->withPivot('is_left');
    }

    public static function getWinsAttribute()
    {
        $winner = array();
          $users = User::with('games')->get();
        //   dd($games);
           foreach ($users as $user) {
               foreach ($user->games as $games) {
                   if ($games->winner ==  $games->pivot->is_left) {

                       $winner[]=$user->name;
                   }
               }
           }
          $winner = array_count_values ( $winner );
          $winner = array_slice($winner, 0, 8, true);
          return $winner;
    }
    public function getKdRatioAttribute()
    {

    }
    public function kdRatio()
    {
        $allPlayers = $this->all();
        foreach ($allPlayers as $players) {
            var_dump($players->card_id);
            echo $players->card_id;
        }

        $games = $this->join('games', function ($join) {
            // meerdere joins binnen zelfde tabel
            $join
            ->on('games.player1', '=', 'users.card_id')
            ->orOn('games.player2', '=', 'users.card_id');
        })
        ->get();



        return 'nok';
    }

    public function getRankingAttribute()
    {

        return $this->games();
    }
}

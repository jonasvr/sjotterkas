<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;
use App\Games;
class User extends Authenticatable
{

    protected $primaryKey = 'card_id';
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
        return $this->belongsToMany('App\Games','game_users', 'card_id', 'game_id');
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

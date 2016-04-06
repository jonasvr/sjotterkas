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

    public static function getMostWinsAttribute()
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

    public static function getKDAttribute()
    {
        $kd = array();
        $users = User::with('games')->get();
        foreach ($users as $user) {
            $ratio = array(
                    'scored' => 0,
                    'counter' => 0,
                 );
            foreach ($user->games as $games) {
                if ($games->pivot->is_left) {
                    $ratio['scored']    += $games->points_left;
                    $ratio['counter']  += $games->points_right;
                }else {
                    $ratio['scored']    += $games->points_right;
                    $ratio['counter']  += $games->points_left;
                }
            }
            if (!$ratio['counter']) {$ratio['counter'] = 1;}

            $kd[$user->name] = round($ratio['scored']/$ratio['counter'], 2) ;
            // $kd[$user->name] = $ratio['scored']/$ratio['counter'] ;
        }
        arsort($kd);
        // dd($kd);
        $kd = array_slice($kd, 0, 8, true);
        return $kd;
    }
}

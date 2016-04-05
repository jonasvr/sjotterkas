<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user1 = new User;
          $user1->name            = "Jonas";
          $user1->card_id         = "7D 5E 9D F7";
          $user1->save();

      $user1 = new User;
        $user1->name            = "Jeroen";
        $user1->card_id         = "F2 37 E7 C3";
        $user1->save();

    }
}

<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class FollowersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::get();
        $firstuser = User::first();
        $first_id = $firstuser->id;

        $users = $users->slice(1);
        $users_id = $users->pluck('id')->toArray();

        //一号用户关注所有人
        $firstuser->follow($users_id);

        //所有人关注一号
        foreach ($users as $key => $value) {
            $value->follow($first_id);
        }

    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('games')->insert(
            [
                'title'=>'World of Warcraft',
                'user_id'=> 1
            ]
            );
        DB::table('games')->insert(
            [
                'title'=>'League of Legends',
                'user_id'=> 1
            ]
            );
        DB::table('games')->insert(
            [
                'title'=>'The Sims',
                'user_id'=> 2
            ]
            );
        DB::table('games')->insert(
            [
                'title'=>'Minecraft',
                'user_id'=> 2
            ]
            );
        DB::table('games')->insert(
            [
                'title'=>'Sonic',
                'user_id'=> 3
            ]
            );
    }
}

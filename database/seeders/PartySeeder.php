<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PartySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        {
            DB::table('parties')->insert(
                [
                    'name'=>'Hate Shaco',
                    'game_id'=> 2
                ]
                );
            DB::table('parties')->insert(
                [
                    'name'=>'Demacia!',
                    'game_id'=> 2
                ]
                );
            DB::table('parties')->insert(
                [
                    'name'=>'Beautiful Pony',
                    'game_id'=> 4
                ]
                );
            DB::table('parties')->insert(
                [
                    'name'=>'Run Run',
                    'game_id'=> 4
                ]
                );
            DB::table('parties')->insert(
                [
                    'name'=>'Dragonflight',
                    'game_id'=> 1
                ]
                );
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(
            [
                'name'=>'gema',
                'email'=>'gema@gema.com',
                'password'=>'gema',
                'alias'=>'gemma'
            ]
            );

        DB::table('users')->insert(
            [
                'name'=>'vinicius',
                'email'=>'vini@vini.com',
                'password'=>'vini',
                'alias'=>'viniJR'
            ]
            );

        DB::table('users')->insert(
            [
                'name'=>'paco',
                'email'=>'paco@paco.com',
                'password'=>'paco',
                'alias'=>'Polilla'
            ]
            );

        DB::table('users')->insert(
            [
                'name'=>'dani',
                'email'=>'dani@dani.com',
                'password'=>'dani',
                'alias'=>'daniDEvitto'
            ]
            );

        DB::table('users')->insert(
            [
                'name'=>'alba',
                'email'=>'alba@alba.com',
                'password'=>'alba',
                'alias'=>'AlbusDumbledore'
            ]
            );
    }
}
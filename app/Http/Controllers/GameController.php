<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class GameController extends Controller
{
    public function newGame(Request $request)
    {
        try {
            Log::info('Create a new game');

            $validator = Validator::make($request->all(), [   
                'title' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            };

            $newGame = new Game();
            $userId = auth()->user()->id;

            $newGame->title = $request->title;
            $newGame->user_id=$userId;  

            $newGame->save();

            return response()->json(["data"=>$newGame, "success"=>'Game created'], 200);
     
        } catch (\Throwable $th) {
            Log::error('Fail, can not create the game->'.$th->getMessage());

            return response()->json([ 'error'=> 'Error, try again!'], 500);
        }
    }

    public function getGames()
    {
        try {
            Log::info('Getting all games');

            $userId = auth()->user()->id;

            $game = DB::table('games')->where('user_id', $userId)->get()->toArray();
            
            if(empty($game)){
                return response()->json(
                    [
                        "success" => "Not games yet"
                    ], 202
                );
            };

            return response()->json($game, 200);
            
        } catch (\Throwable $th) {

            Log::error('Fail, can not get the games->'.$th->getMessage());

            return response()->json([ 'error'=> 'Error, try again!'], 500);  

        }
    }

    public function gameById($id) // User Id, 
    {
        try {
            Log::info('Get a game by id');

            $userId = auth()->user()->id;

            $game = DB::table('games')->where('user_id',$userId)->where('user_id',$id)->get();

            if(empty($game)){
                return response()->json(
                    [
                        "error" => "We do not have this game"
                    ],400
                );
            };

            return response()->json($game, 200);

        } catch (\Throwable $th) {
            Log::error('Fail, can not get game by id -> '.$th->getMessage());

            return response()->json([ 'error'=> 'Error, try again!'], 500);
        }
    }

    public function gameByTitle($title) // By Title, 
    {
        try {
            Log::info('Get a game by title');

            $userId = auth()->user()->id;

            $game = DB::table('games')->where('title',$title)->get();

            if(empty($game)){
                return response()->json(
                    [
                        "error" => "We do not have this game"
                    ],400
                );
            };

            return response()->json($game, 200);

        } catch (\Throwable $th) {
            Log::error('Fail, can not get game by title -> '.$th->getMessage());

            return response()->json([ 'error'=> 'Error, try again!'], 500);
        }
    }



    public function updateGame(Request $request, $id)
    {
        try {
            Log::info('Update a game');
            $userId = auth()->user()->id;

            $validator = Validator::make($request->all(), [   
                'title' => 'string|max:100',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            };

            $game = Game::where('id',$id)->where('user_id',$userId)->first();

            if(empty($game)){
                return response()->json(["error"=> "Game not exists"], 404);
            };
            if(isset($request->title)){
                $game->title = $request->title;
            }
            $game->save();

            return response()->json(["data"=>$game, "success"=>'Game updated'], 200);
            
        } catch (\Throwable $th) {
            Log::error('Fail, can not update the game->'.$th->getMessage());
            return response()->json([ 'error'=> 'Error, try again!'], 500);
        }
    }

    public function deleteGame($id)
    {
        try {
            Log::info('Deleting game');
            $userId = auth()->user()->id;

            $game = Game::where('id',$id)->where('user_id',$userId)->first();

            if(empty($game)){
                return response()->json(["error"=> "Game do not exists"], 404);
            };
            $game->delete();

            return response()->json(["data"=> "The game has been deleted"], 200);

        } catch (\Throwable $th) {
        Log::error('Fail, can not delete the game->'.$th->getMessage());

        return response()->json([ 'error'=> 'Error, try again!'], 500);
        }
    }

}

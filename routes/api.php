<?php

use App\Http\Controllers\FilmController;
use App\Http\Controllers\YearController;
use App\Http\Controllers\ActorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\TrendingController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AuthenticatedSessionController::class, 'store']);

Route::get('films', [FilmController::class, 'getAllFilms']);
Route::get('films/range/{start}/{end}', [FilmController::class, 'getFilmsByRange']);
Route::get('films/search/{start}/{end}', [FilmController::class, 'searchFilmsByTitle']);

Route::get('films/{year}', [YearController::class, 'getFilmsByYear']);
Route::get('years', [YearController::class, 'getAllYears']);

Route::get('actors', [ActorController::class, 'getAllActors']);
Route::get('actors/{actorId}/films', [ActorController::class, 'getActorActedIn']);

Route::get('trending', [TrendingController::class, 'getAllTrending']);
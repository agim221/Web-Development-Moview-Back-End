<?php

use App\Http\Controllers\FilmController;
use App\Http\Controllers\YearController;
use App\Http\Controllers\ActorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('films', [FilmController::class, 'getAllFilms']);
Route::post('films', [FilmController::class, 'store']);

Route::get('films/{year}', [YearController::class, 'getFilmsByYear']);
Route::get('years', [YearController::class, 'getAllYears']);

Route::get('actors', [ActorController::class, 'getAllActors']);
Route::get('actors/{actorId}/films', [ActorController::class, 'getActorActedIn']);
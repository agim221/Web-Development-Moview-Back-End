<?php

use App\Http\Controllers\FilmController;
use App\Http\Controllers\YearController;
use App\Http\Controllers\ActorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\TrendingController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\CommentController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('films', [FilmController::class, 'getAllFilms']);
Route::get('films/range/{start}/{end}', [FilmController::class, 'getFilmsByRange']);
Route::get('films/search/{start}/{end}', [FilmController::class, 'searchFilmsByTitle']);
Route::get('films/search/actor/{start}/{end}', [FilmController::class, 'searchFilmsByActor']);
Route::get('films/auto-complete/title', [FilmController::class, 'autoCompleteByTitle']);
Route::get('films/auto-complete/actor', [FilmController::class, 'autoCompleteByActor']);

Route::get('films/{year}', [YearController::class, 'getFilmsByYear']);
Route::get('years', [YearController::class, 'getAllYears']);

Route::get('actors', [ActorController::class, 'getAllActors']);
Route::get('actors/{actorId}/films', [ActorController::class, 'getActorActedIn']);

Route::get('trending', [TrendingController::class, 'getAllTrending']);

Route::get('films_detail/{filmId}', [FilmController::class, 'getFilmById']);
Route::get('films_detail/{filmId}/actors', [FilmController::class, 'getFilmActors']);
Route::get('films_detail/{filmId}/comments', [FilmController::class, 'getFilmComments']);

Route::get('auth/google', [SocialAuthController::class, 'googleRedirect']);
Route::get('auth/callback/google', [SocialAuthController::class, 'handleProviderCallback']);

Route::get('bookmarks/{token}', [BookmarkController::class, 'getFilmBookmark']);
Route::get('bookmarks/{start}/{end}', [BookmarkController::class, 'getFilmBookmarkByRange']);

Route::get('countries', [CountryController::class, 'getAllCountries']);

Route::get('genres', [GenreController::class, 'getAllGenres']);

Route::post('add-comments', [CommentController::class, 'addComment']);
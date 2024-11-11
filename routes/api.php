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
use App\Http\Controllers\AwardController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('films/verified', [FilmController::class, 'getAllVerifiedFilms']);
Route::get('films/unverified', [FilmController::class, 'getAllUnverifiedFilms']);
Route::put('films/approve/{id}', [FilmController::class, 'approveFilm']);
Route::get('films/range/{start}/{end}', [FilmController::class, 'getFilmsByRange']);
Route::get('films/search/{start}/{end}', [FilmController::class, 'searchFilmsByTitle']);
Route::get('films/search/actor/{start}/{end}', [FilmController::class, 'searchFilmsByActor']);
Route::get('films/auto-complete/title', [FilmController::class, 'autoCompleteByTitle']);
Route::get('films/auto-complete/actor', [FilmController::class, 'autoCompleteByActor']);

Route::get('films/{year}', [YearController::class, 'getFilmsByYear']);
Route::get('years', [YearController::class, 'getAllYears']);

Route::get('actors', [ActorController::class, 'getAllActors']);
Route::get('actors/{actorId}/films', [ActorController::class, 'getActorActedIn']);
Route::post('/actors', [ActorController::class, 'store']);
Route::put('/actors/{id}', [ActorController::class, 'update']);
Route::delete('/actors/{id}', [ActorController::class, 'destroy']);
Route::get('/search/actors', [ActorController::class, 'searchActor']);

Route::post('/add-actor', [ActorController::class, 'store']);
Route::put('/actors/update/{id}', [ActorController::class, 'update']);

Route::get('trending', [TrendingController::class, 'getAllTrending']);

Route::get('films_detail/{filmId}', [FilmController::class, 'getFilmById']);
Route::get('films_detail/{filmId}/actors', [FilmController::class, 'getFilmActors']);
Route::get('films_detail/{filmId}/comments', [FilmController::class, 'getFilmComments']);
Route::get('films_detail/{filmId}/genres', [FilmController::class, 'getFilmGenres']);
Route::get('films_detail/{filmId}/awards', [FilmController::class, 'getFilmAwards']);
Route::put('films/{filmId}/update', [FilmController::class, 'update']);
Route::post('add-film', [FilmController::class, 'store']);
Route::delete('films/{filmId}', [FilmController::class, 'destroy']);

Route::get('bookmarks/{token}', [BookmarkController::class, 'getFilmBookmark']);
Route::get('bookmarks/{start}/{end}', [BookmarkController::class, 'getFilmBookmarkByRange']);
Route::post('bookmarks', [BookmarkController::class, 'store']);
Route::get('bookmarks/{id}', [BookmarkController::class, 'show']);
Route::put('bookmarks/{id}', [BookmarkController::class, 'update']);
Route::delete('bookmarks/{id}', [BookmarkController::class, 'destroy']);
Route::post('bookmarks/check', [BookmarkController::class, 'checkBookmark']);
Route::post('bookmarks/remove', [BookmarkController::class, 'remove']);

Route::get('/countries', [CountryController::class, 'index']);
Route::get('/countries/{id}', [CountryController::class, 'getCountryById']);
Route::post('/countries', [CountryController::class, 'store']);
Route::put('/countries/{id}', [CountryController::class, 'update']);
Route::delete('/countries/{id}', [CountryController::class, 'destroy']);
Route::get('/search/countries', [CountryController::class, 'searchCountry']);

Route::get('/genres', [GenreController::class, 'index']);
Route::post('/genres', [GenreController::class, 'store']);
Route::put('/genres/{id}', [GenreController::class, 'update']);
Route::delete('/genres/{id}', [GenreController::class, 'destroy']);
Route::get('/search/genres', [GenreController::class, 'searchGenre']);


Route::get('/awards', [AwardController::class, 'index']);
Route::post('/awards', [AwardController::class, 'store']);
Route::put('/awards/{id}', [AwardController::class, 'update']);
Route::delete('/awards/{id}', [AwardController::class, 'destroy']);
Route::get('/awards/film', [AwardController::class, 'getFilmByAward']);
Route::get('/search/awards', [AwardController::class, 'searchAward']);

Route::get('/role', [UserController::class, 'getRole']);

Route::post('add-comments', [CommentController::class, 'addComment']);
Route::get('/comments', [CommentController::class, 'index']);
Route::delete('/comments/{id}', [CommentController::class, 'destroy']);
Route::get('/search/comments', [CommentController::class, 'searchComment']);

Route::get('/users', [UserController::class, 'index']);
Route::get('/search/users', [UserController::class, 'searchUser']);
Route::get('/users/block/{id}', [UserController::class, 'blockUser']);
Route::get('/users/unblock/{id}', [UserController::class, 'unblockUser']);
Route::get('/users/detail', [UserController::class, 'getDetailAccount']);
Route::put('/users/change-password', [UserController::class, 'changePassword']);

Route::get('/comments/unapproved', [CommentController::class, 'getUnapprovedComments']);
Route::get('/comments/approved', [CommentController::class, 'getApprovedComments']);
Route::put('/comments/approve/{id}', [CommentController::class, 'approveComment']);
Route::delete('/comments/{id}', [CommentController::class, 'destroy']);
Route::get('/comments', [CommentController::class, 'index']);


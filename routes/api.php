<?php

use App\Http\Controllers\MemberController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get("/teams/{team}/members", [TeamController::class, 'members']);
Route::resource("/teams", TeamController::class);

Route::get("/projects/{project}/members", [ProjectController::class, 'members']);
Route::post("/projects/{project}/members", [ProjectController::class, 'addMember']);
Route::resource("/projects", ProjectController::class);

Route::patch("/members/{member}/team", [MemberController::class, 'updateTeam']);
Route::resource("/members", MemberController::class);

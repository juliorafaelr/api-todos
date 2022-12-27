<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\UserController;
use LaravelJsonApi\Laravel\Facades\JsonApiRoute;
use LaravelJsonApi\Laravel\Http\Controllers\JsonApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/', function (Request $request) {
//    return $request->user();
//});

Route::get('/', function (Request $request) {
    return phpinfo();
});

JsonApiRoute::server('v1')->prefix('v1')->resources(function ($server) {
    $server->resource('tasks', JsonApiController::class);
    $server->resource('users', UserController::class)->only('index', 'show', 'store');
});

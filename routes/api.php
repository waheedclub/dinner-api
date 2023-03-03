<?php

use App\Http\Controllers\{
    AmountController,
    AuthController,
    DashboardController,
    FoodController,
    UserController
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => 'auth:sanctum'], function () {

    // Route::auth();
    Route::apiResources([
        'users' => UserController::class,
        'foods' => FoodController::class,
        'amounts' => AmountController::class,
    ]);
Route::post('/amount/update_status', [AmountController::class, 'updateStatus']);
Route::get('/get-dashboard-data', [DashboardController::class, 'getDashboardData']);

});

Route::post('/auth/login', [AuthController::class, 'login']);

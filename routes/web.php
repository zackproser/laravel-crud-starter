<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 * Home Page View
 *
 * Welcomes users to the application
 */
Route::get('/', function () {
  return view('welcome',
    [
      'bodyClass' => 'splash',
      'appName' => config('app.name'),
      'appAuthor' => env('APP_AUTHOR'),
      'adminEmail' => env('ADMIN_EMAIL'),
    ]
  );
});

/**
 * Main item grid view
 *
 * Displays items in a responsive grid
 */
Route::get('/items', function() {
  return view('grid', ['itemsCollection' => App\Item::all(), 'gridTitle' => env('grid_title')]);
});

/**
 * Admin view
 *
 * Allows authenticated admin users to perform CRUD operations via the Items API
 */
Route::get('/admin', function() {
  return view('admin');
})->middleware('auth.basic');
<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


 /*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'HomeController@index');

Auth::routes();

Route::post('login', 'SigninController@signin');

Route::get('login', 'SigninController@show');





//User routes
Route::resource('user', 'UserController', ['only' => [
    'index', 'store'
]]);


Route::get('getAllUsers', 'UserController@getAllUsers');

Route::get('user/getSingle', 'UserController@getSingle');

Route::get('user/userDelete', 'UserController@deleteUser');






//Driver routes
// Route::resource('driver', 'DriverController', ['only' => [
//     'index', 'show' , 'store'
// ]]);

Route::get('driver', 'DriverController@index');

Route::get('getAllDrivers', 'DriverController@getAllDrivers');

Route::get('getAllDriverNames', 'DriverController@getAllDriverNames');

Route::get('driver/{id}/posts', 'DriverController@show');

// Route::get('driver/{id}/posts', 'DriverController@driverPosts');

 
//STORES routes
//To show all the stores. 
Route::get('store', 'StoreController@index');

Route::get('getAllStores', 'StoreController@getAllStores');

//To show a single store.
Route::get('store/{id}/posts', 'StoreController@show');


Route::get('getAllStoreNames', 'StoreController@getAllStoreNames');


//Posts routes
Route::resource('post', 'PostController', ['except' => [
    'create', 'show','edit'
]]);

Route::post('/getPosts', 'PostController@getPosts')->name('posts.getPosts');

Route::post('/changePostStatus', 'PostController@changePostStatus');

Route::get('post/all', 'PostController@all');

Route::get('post/new', 'PostController@new');

Route::get('post/on-the-way', 'PostController@onTheWay');

Route::get('getAllDriverAndStores', 'PostController@getAllDriverAndStores');

Route::get('post/delivered', 'PostController@delivered');

Route::get('post/refused', 'PostController@refused');

Route::get('post/getCounts', 'PostController@getCounts');

Route::get('post/add', 'PostController@add');

Route::get('post/all', 'PostController@all');

Route::get('post/getSingle/{id}', 'PostController@getSingle');


 
//Location routes

// Route::resource('location', 'LocationController');

Route::get('location','LocationController@index');

Route::post('location','LocationController@store');

Route::get('getAllLocationNames', 'LocationController@getAllLocationNames');

Route::get('location/getAllLocations', 'LocationController@getAllLocations');

Route::get('location/getSingle/{id}', 'LocationController@getSingle');

Route::delete('location/locationDelete/{id}', 'LocationController@locationDelete');
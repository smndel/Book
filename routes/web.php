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

//Page d'accueil
Route::get('/', 'FrontController@index');

//Route pour afficher un livre, route sécurisée
Route::get('book/{id}', 'FrontController@show')->where(['id'=>'[0-9]+']);

//Route pour la page author
Route::get('author/{id}', 'FrontController@showBookByAuthor')->where(['id'=>'[0-9]+']);

//Route pour la page Menu
Route::get('genre', 'FrontController@__construct')->where(['id'=>'[0-9]+']);

//Route pour la page genre
Route::get('genre/{id}', 'FrontController@showBookByGenre')->where(['id'=>'[0-9]+']);

Route::post('vote', 'FrontController@create')->name('vote');

// Route::get('/', function () {
//     return view('welcome');
// });

// //Test d'une route type closure
// /*Route::get('test', function(){
// 	return "Je suis un test";
// });*/

// //Retourne l'ensemble de slivres de l'appliction "book" dans une route:
// Route::get('books', function(){
// 	return App\Book::all();
// });

// //Route avec paramètre de l'id d'un livre en particulier
// Route::get('books/{id}', function($id){
// 	return App\Book::find($id);



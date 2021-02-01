<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'BooksController@show');
Route::get('books', 'BooksController@show');
Route::get('del_book', 'BooksController@del');
Route::get('show_books_with_filter', 'BooksController@showWithFilter');
Route::get('authors', 'AuthorsController@show');
Route::get('del_author', 'AuthorsController@del');
Route::get('add_edit_books', 'AddEditBooksController@show');
Route::get('show_to_edit_book', 'AddEditBooksController@showToEdit');
Route::get('add_edit_book', 'AddEditBooksController@addEdit');
Route::get('add_book', 'AddEditBooksController@add');
Route::get('edit_book', 'AddEditBooksController@edit');
Route::get('add_edit_authors', 'AddEditAuthorsController@show');
Route::get('add_edit_author', 'AddEditAuthorsController@addEdit');
Route::get('add_author', 'AddEditAuthorsController@add');
Route::get('edit_author', 'AddEditAuthorsController@edit');

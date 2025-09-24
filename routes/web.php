<?php

use Src\Route;

Route::add('GET', '/hello', [Controller\Site::class, 'hello'])->middleware('auth');
Route::add(['GET', 'POST'], '/signup', [Controller\Site::class, 'signup']);
Route::add(['GET', 'POST'], '/login', [Controller\Site::class, 'login']);
Route::add('GET', '/logout', [Controller\Site::class, 'logout']);

Route::add('GET', '/admin-panel', [Controller\Site::class, 'admin'])->middleware('auth');
Route::add(['GET', 'POST'], '/admin-panel/add-librarian', [Controller\Site::class, 'addLibrarian'])->middleware('auth');

Route::add('GET', '/librarian-panel', [Controller\Site::class, 'librarian'])->middleware('auth');
Route::add(['GET', 'POST'], '/librarian-panel/add-book', [Controller\Site::class, 'addBook'])->middleware('auth');
Route::add(['GET', 'POST'], '/librarian-panel/add-reader', [Controller\Site::class, 'addReader'])->middleware('auth');
Route::add(['GET', 'POST'], '/librarian-panel/issue-book', [Controller\Site::class, 'issueBook'])->middleware('auth');
Route::add(['GET'], '/librarian-panel/return-book', [Controller\Site::class, 'returnBook'])->middleware('auth');
Route::add(['GET','POST'], '/librarian-panel/return-book/user/{userId}', [Controller\Site::class, 'checkBorrowedBooks'])->middleware('auth');



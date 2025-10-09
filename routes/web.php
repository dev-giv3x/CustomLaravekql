<?php

use Src\Route;

// дефолтныке
Route::add('GET', '/', [Controller\Site::class, 'index'])->middleware('auth');
Route::add(['GET', 'POST'], '/signup', [Controller\Site::class, 'signup']);
Route::add(['GET', 'POST'], '/login', [Controller\Site::class, 'login']);
Route::add('GET', '/logout', [Controller\Site::class, 'logout']);

// админка
Route::add('GET', '/admin-panel', [Controller\AdminController::class, 'admin'])->middleware('auth');
Route::add(['GET', 'POST'], '/admin-panel/add-librarian', [Controller\AdminController::class, 'addLibrarian'])->middleware('auth');

// библиотекрь и прочие
Route::add('GET', '/librarian-panel', [Controller\LibrarianController::class, 'librarian'])->middleware('auth');
Route::add('GET', '/books/{id}', [Controller\Site::class, 'show'])->middleware('auth');
Route::add(['GET', 'POST'], '/librarian-panel/add-book', [Controller\LibrarianController::class, 'addBook'])->middleware('auth');
Route::add(['GET', 'POST'], '/librarian-panel/add-reader', [Controller\LibrarianController::class, 'addReader'])->middleware('auth');
Route::add(['GET', 'POST'], '/librarian-panel/issue-book', [Controller\LibrarianController::class, 'issueBook'])->middleware('auth');
Route::add(['GET'], '/librarian-panel/return-book', [Controller\LibrarianController::class, 'returnBook'])->middleware('auth');
Route::add(['GET','POST'], '/librarian-panel/return-book/user/{userId}', [Controller\LibrarianController::class, 'checkBorrowedBooks'])->middleware('auth');
Route::add(['GET','POST'], '/librarian-panel/log', [Controller\LibrarianController::class, 'listBorrowedBooks'])->middleware('auth');
Route::add(['GET','POST'], '/librarian-panel/readers/borrowed-book', [Controller\LibrarianController::class, 'readersWithBorrowedBooks'])->middleware('auth');
Route::add(['GET','POST'], '/librarian-panel/popular-books', [Controller\LibrarianController::class, 'popularBooks'])->middleware('auth');



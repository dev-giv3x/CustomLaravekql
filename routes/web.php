<?php

use Src\Route;

Route::add('GET', '/hello', [Controller\Site::class, 'hello'])
    ->middleware('auth');
Route::add(['GET', 'POST'], '/signup', [Controller\Site::class, 'signup']);
Route::add(['GET', 'POST'], '/login', [Controller\Site::class, 'login']);
Route::add('GET', '/logout', [Controller\Site::class, 'logout']);
Route::add('GET', '/admin-panel', [Controller\Site::class, 'admin'])->middleware('auth');
Route::add('GET', '/librarian-panel', [Controller\Site::class, 'librarian'])->middleware('auth');

;

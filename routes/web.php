<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [PostController::class, 'index'])->name('index');

Route::get('/post/{post_id}', [PostController::class, 'post'])->name('post');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', [PostController::class, 'show'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/create', function () {
    return view('create');
})->name('create');
Route::post('/store', [PostController::class, 'store'])->name('store');
Route::get('/edit/{post_id}', [PostController::class, 'edit'])->name('edit');
Route::post('/update/{post_id}', [PostController::class, 'update'])->name('update');
Route::post('/delete/{post_id}', [PostController::class, 'delete'])->name('delete');
Route::post('/store_comment', [CommentController::class, 'store'])->name('store_comment');
Route::get('/edit_comment/{comment_id}', [CommentController::class, 'edit'])->name('edit_comment');
Route::post('/update_comment/{comment_id}', [CommentController::class, 'update'])->name('update_comment');
Route::post('/delete_comment/{comment_id}', [CommentController::class, 'delete'])->name('delete_comment');
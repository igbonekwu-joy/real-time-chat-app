<?php

use App\Http\Controllers\GroupController;
use App\Livewire\Chats;
use App\Livewire\Dashboard;
use App\Livewire\Login;
use App\Livewire\Register;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('login');
})->name('home');

Route::get('/login', Login::class)->name('login');
Route::get('/register', Register::class)->name('register');

Route::middleware('auth')->group(function () {
    Route::get('groups', Dashboard::class)->name('dashboard');

    Route::get('chats', Chats::class)->name('chats');

    Route::prefix('group')->group(function () {
        Route::post('send-message', [GroupController::class, 'sendMessage'])->name('group.send-message');
        Route::get('get-messages', [GroupController::class, 'getMessages'])->name('group.get-messages');
        Route::post('add-member', [GroupController::class, 'addMember'])->name('group.add-member');
        Route::post('mark-as-read', [GroupController::class, 'markAsRead'])->name('group.mark-as-read');
        Route::post('clear-history', [GroupController::class, 'clearHistory'])->name('group.clear-history');
        Route::post('leave-group', [GroupController::class, 'leaveGroup'])->name('group.leave-group');
        Route::delete('delete-group', [GroupController::class, 'deleteGroup'])->name('group.delete-group');
    });

});

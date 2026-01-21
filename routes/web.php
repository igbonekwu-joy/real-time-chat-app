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

    Route::post('group/send-message', [GroupController::class, 'sendMessage'])->name('group.send-message');
    Route::get('group/get-messages', [GroupController::class, 'getMessages'])->name('group.get-messages');
    Route::post('group/add-member', [GroupController::class, 'addMember'])->name('group.add-member');
});

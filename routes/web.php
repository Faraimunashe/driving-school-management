<?php

use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InstructorController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\VehicleController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\ResponseController;
use App\Http\Controllers\User\TestController;
use App\Http\Controllers\User\TestSessionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', [AuthenticationController::class, 'index'])->middleware(['auth'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group(['middleware' => ['auth', 'role:admin']], function(){
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin-dashboard');

    Route::resource('questions', QuestionController::class);
    Route::resource('students', StudentController::class);
    Route::resource('instructors', InstructorController::class);
    Route::resource('vehicles', VehicleController::class);
    Route::resource('bookings', BookingController::class);

});

Route::group(['middleware' => ['auth', 'role:instructor']], function(){
    Route::get('/instructor/dashboard', [\App\Http\Controllers\Instructor\DashboardController::class, 'index'])->name('instructor-dashboard');
    Route::post('/instructor/dashboard', [\App\Http\Controllers\Instructor\DashboardController::class, 'store'])->name('instructor-dashboard');

});

Route::group(['middleware' => ['auth', 'role:user']], function(){
    Route::get('/user/dashboard', [\App\Http\Controllers\User\DashboardController::class, 'index'])->name('user-dashboard');

    Route::resource('test-sessions', TestSessionController::class);
    Route::resource('tests', TestController::class);
    Route::resource('responses', ResponseController::class);
    Route::resource('user-bookings', \App\Http\Controllers\User\BookingController::class);
});



require __DIR__.'/auth.php';

<?php

use App\Http\Controllers\EmployeeManageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\DepartmentController;

// Route::get('/', function () {
//     return view('welcome');
// });

// Login
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('auth.authenticate');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

// Admin Dashboard
Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

// Employee Dashboard
Route::get('/employee/dashboard', [EmployeeController::class, 'index'])->name('employee.dashboard');


Route::get('/employee/profile/edit', [EmployeeController::class, 'editProfile'])->name('employee.profile.edit');

// Route to handle the profile update form submission
Route::post('/employee/profile/update', [EmployeeController::class, 'updateProfile'])->name('employee.profile.update');

// Department
Route::get('admin/department/{id}/delete',[DepartmentController::class,'destroy']);
Route::resource('/admin/department',DepartmentController::class);

// Employee
Route::get('admin/employeemanage/{id}/delete',[EmployeeManageController::class,'destroy']);
Route::resource('/admin/employeemanage',EmployeeManageController::class);

Route::get('/admin/department/{id}/employees', [DepartmentController::class, 'employees']);

//Chat
Route::get('/chat/{userId}', [ChatController::class, 'showChat'])->name('chat.show');
Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('chat.send');
Route::get('/chat/messages/{userId}', [ChatController::class, 'fetchMessages'])->name('chat.messages');


Route::get('/admin/chat', [ChatController::class, 'index'])->name('admin.chat');
Route::get('/employee/chat', [ChatController::class, 'index'])->name('employee.chat');

Route::get('/admin/profile/edit', [AdminController::class, 'editProfile'])->name('admin.profile.edit');
Route::post('/admin/profile/update', [AdminController::class, 'updateProfile'])->name('admin.profile.update');

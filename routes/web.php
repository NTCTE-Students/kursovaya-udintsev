<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\ConsultantController;
use App\Http\Controllers\AdminController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

// Главная страница — список консультантов
Route::get('/', function () {
    $consultants = User::where('role', 'consultant')->get();
    return view('welcome', compact('consultants'));
});

// Дашборд (после входа и подтверждения email)
Route::get('/dashboard', function () {
    $consultants = User::where('role', 'consultant')->get();
    return view('dashboard', compact('consultants'));
})->middleware(['auth', 'verified'])->name('dashboard');

// === Аутентифицированные пользователи ===
Route::middleware(['auth'])->group(function () {
    // Профиль
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Список всех консультантов
    Route::get('/consultants', [ConsultantController::class, 'fullList'])->name('consultants.full');

    // Консультации как клиент
    Route::get('/consultations', [ConsultationController::class, 'index'])->name('consultations.index');
    Route::get('/consultations/create', [ConsultationController::class, 'create'])->name('consultations.create');
    Route::post('/consultations', [ConsultationController::class, 'store'])->name('consultations.store');
    Route::post('/consultations/{consultation}/pay', [ConsultationController::class, 'pay'])->name('consultations.pay');

    // Консультации как консультант
    Route::get('/consultations/as-consultant', [ConsultationController::class, 'asConsultant'])->name('consultations.as_consultant');
    Route::patch('/consultations/{consultation}/status', [ConsultationController::class, 'updateStatus'])->name('consultations.update_status');

    // Общие действия
    Route::delete('/consultations/{consultation}', [ConsultationController::class, 'destroy'])->name('consultations.destroy');
});

// === Админ-панель (проверка роли внутри функций) ===
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Админская главная страница — список пользователей с фильтрацией
    Route::get('/admin/users', function () {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Доступ запрещён');
        }
        return app()->call('App\Http\Controllers\AdminController@index');
    })->name('admin.users.index');

    // Переключить роль консультанта
    Route::post('/admin/users/{user}/toggle-consultant', function (User $user) {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Доступ запрещён');
        }
        return app()->call('App\Http\Controllers\AdminController@toggleConsultant', ['user' => $user]);
    })->name('admin.users.toggle_consultant');

    // Переключить роль администратора
    Route::patch('/admin/users/{user}/toggle-role', function (User $user) {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Доступ запрещён');
        }
        return app()->call('App\Http\Controllers\AdminController@toggleRole', ['user' => $user]);
    })->name('admin.toggleRole');

    // Удаление пользователя
    Route::delete('/admin/users/{user}', function (User $user) {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Доступ запрещён');
        }
        return app()->call('App\Http\Controllers\AdminController@destroy', ['user' => $user]);
    })->name('admin.users.destroy');
});

require __DIR__.'/auth.php';

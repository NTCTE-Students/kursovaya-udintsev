<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // Список пользователей с фильтрацией
    public function index(Request $request)
    {
        $this->authorizeAdmin();

        $query = User::query();

        // Фильтр по роли
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Фильтр по имени (частичное совпадение)
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        $users = $query->orderBy('id', 'desc')->get();

        // Передаем текущие значения фильтров для формы
        return view('admin.dashboard', [
            'users' => $users,
            'filterRole' => $request->role,
            'filterName' => $request->name,
        ]);
    }

    public function toggleConsultant(User $user)
    {
        $this->authorizeAdmin();

        if ($user->id === Auth::id()) {
            return back()->with('error', 'Вы не можете менять свою роль.');
        }

        $user->role = $user->role === 'consultant' ? 'client' : 'consultant';
        $user->save();

        return back()->with('success', "Роль пользователя {$user->name} успешно обновлена.");
    }

    public function toggleRole(User $user)
    {
        $this->authorizeAdmin();

        if ($user->id === Auth::id()) {
            return back()->with('error', 'Вы не можете изменить свою роль администратора.');
        }

        if ($user->role === 'admin') {
            $user->role = 'client';
        } else {
            $user->role = 'admin';
        }

        $user->save();

        return back()->with('success', "Роль пользователя {$user->name} успешно обновлена.");
    }

    public function destroy(User $user)
    {
        $this->authorizeAdmin();

        if ($user->id === Auth::id()) {
            return back()->with('error', 'Вы не можете удалить свой аккаунт.');
        }

        $user->delete();

        return back()->with('success', "Пользователь {$user->name} удалён.");
    }

    private function authorizeAdmin()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Доступ запрещен');
        }
    }
}

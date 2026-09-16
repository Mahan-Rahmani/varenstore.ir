<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::withCount('orders')
            ->withSum(['orders' => function ($q) {
                $q->where('payment_status', 'paid');
            }], 'grand_total');

        if ($request->filled('search')) {
            $search = trim($request->query('search'));
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->query('role'));
        }

        $users = $query->latest()->paginate(15)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->load(['orders' => function ($q) {
            $q->latest();
        }]);

        $paidOrdersSum = $user->orders->where('payment_status.value', 'paid')->sum('grand_total');

        return view('admin.users.show', compact('user', 'paidOrdersSum'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'role' => ['required', new Enum(UserRole::class)],
        ]);

        // Prevent admin from demoting themselves
        if ($user->id === Auth::id() && $validated['role'] !== UserRole::ADMIN->value) {
            return back()->with('error', 'شما نمی‌توانید نقش حساب کاربری خودتان را از مدیریت تغییر دهید.')->withInput();
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')->with('success', 'مشخصات کاربر با موفقیت به‌روزرسانی شد.');
    }

    public function destroy(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'شما نمی‌توانید حساب کاربری خودتان را حذف کنید.');
        }

        $user->delete();

        return back()->with('success', 'کاربر مورد نظر با موفقیت حذف شد.');
    }
}

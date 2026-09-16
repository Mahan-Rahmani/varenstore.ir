<?php

namespace App\Http\Controllers\Customer;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Rules\PersianName;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class CustomerDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $totalOrders = Order::where('user_id', $user->id)->count();
        $processingCount = Order::where('user_id', $user->id)
            ->where('status', OrderStatus::PROCESSING)
            ->count();
        $completedCount = Order::where('user_id', $user->id)
            ->where('status', OrderStatus::COMPLETED)
            ->count();
        $pendingCount = Order::where('user_id', $user->id)
            ->where('status', OrderStatus::PENDING)
            ->count();

        $recentOrders = Order::with(['items.product'])
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('account.dashboard', compact(
            'user',
            'totalOrders',
            'processingCount',
            'completedCount',
            'pendingCount',
            'recentOrders'
        ));
    }

    public function orders(Request $request)
    {
        $user = Auth::user();
        $query = Order::with(['items.product'])
            ->where('user_id', $user->id);

        if ($request->filled('status')) {
            $status = $request->query('status');
            $query->where('status', $status);
        }

        $orders = $query->latest()->paginate(10)->withQueryString();

        return view('account.orders', compact('orders', 'user'));
    }

    public function showOrder(string $orderNumber)
    {
        $user = Auth::user();
        $order = Order::with(['items.product', 'transactions'])
            ->where('user_id', $user->id)
            ->where('order_number', $orderNumber)
            ->firstOrFail();

        return view('account.order_show', compact('order', 'user'));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('account.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', new PersianName()],
            'phone' => ['required', 'string', 'regex:/^09[0-9]{9}$/', Rule::unique('users')->ignore($user->id)],
            'email' => ['nullable', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'current_password' => ['nullable', 'required_with:new_password'],
            'new_password' => ['nullable', 'min:8', 'confirmed'],
        ], [
            'name.required' => 'وارد کردن نام و نام خانوادگی الزامی است.',
            'phone.required' => 'وارد کردن شماره همراه الزامی است.',
            'phone.regex' => 'شماره همراه باید ۱۱ رقم بوده و با ۰۹ شروع شود.',
            'phone.unique' => 'این شماره همراه قبلاً برای کاربر دیگری ثبت شده است.',
            'email.email' => 'فرمت نشانی ایمیل معتبر نیست.',
            'email.unique' => 'این نشانی ایمیل قبلاً برای کاربر دیگری ثبت شده است.',
        ]);

        if (!empty($validated['new_password'])) {
            if (!Hash::check($validated['current_password'], $user->password)) {
                return back()->withErrors(['current_password' => 'رمز عبور فعلی نادرست است.'])->withInput();
            }
            $user->password = Hash::make($validated['new_password']);
        }

        $user->name = $validated['name'];
        $user->phone = $validated['phone'];
        $user->email = !empty($validated['email']) ? $validated['email'] : null;
        $user->save();

        return back()->with('success', 'مشخصات حساب کاربری با موفقیت به‌روزرسانی شد.');
    }
}

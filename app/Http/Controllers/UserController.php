<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;



class UserController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function index(Request $request)
    {
        if (!Auth::user()->hasRole('admin')) {
            return redirect()->back()->with('error', 'لا تملك صلاحية الوصول إلى هذه الصفحة.');
        }

        $users = User::with('roles')->get();
        return view('user.index', compact('users'));
    }

     public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email'    => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'role'     => 'required|in:admin,accountant,employee',
        ]);
        $user = User::create([
            'name'     => $request->name,
            'username' => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($request->role);

        return redirect()->route('user.index')->with('success', 'User added successfully.');
    }
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|string|in:admin,accountant,employee',
            'password' => 'nullable|string|min:6',
        ]);

        $passwordChanged = $request->filled('password');

        $user->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => $passwordChanged ? Hash::make($request->password) : $user->password ,
        ]);

        $user->syncRoles([$request->role]);

        // تسجيل خروج المستخدم من كل جلساته
        if ($passwordChanged) {
           DB::table('sessions')->where('user_id', $user->id)->delete(); // حذف الجلسات
            $user->update(['remember_token' => null]);
        }


        return redirect()->back()->with('success', 'User updated and forced logout applied if password changed.');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}

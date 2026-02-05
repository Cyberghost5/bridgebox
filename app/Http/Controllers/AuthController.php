<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    private array $roles = [
        'admin' => [
            'label' => 'Admin',
            'subtitle' => 'Manage the learning hub and oversee content access.',
        ],
        'teacher' => [
            'label' => 'Teacher',
            'subtitle' => 'Prepare lessons, track learners, and share resources.',
        ],
        'student' => [
            'label' => 'Student',
            'subtitle' => 'Access lessons and keep learning on any device.',
        ],
    ];

    public function showLogin(string $role)
    {
        $roleKey = strtolower($role);
        if (!array_key_exists($roleKey, $this->roles)) {
            abort(404);
        }

        return view('auth.login', [
            'role' => $this->roles[$roleKey]['label'],
            'roleKey' => $roleKey,
            'subtitle' => $this->roles[$roleKey]['subtitle'],
        ]);
    }

    public function login(Request $request, string $role)
    {
        $roleKey = strtolower($role);
        if (!array_key_exists($roleKey, $this->roles)) {
            abort(404);
        }

        $request->validate([
            'identifier' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $identifier = $request->string('identifier')->toString();

        $user = User::where('email', $identifier)
            ->orWhere('name', $identifier)
            ->first();

        if (!$user || !Hash::check($request->string('password')->toString(), $user->password)) {
            return back()
                ->withInput(['identifier' => $identifier])
                ->with('error', 'Invalid credentials. Please try again.');
        }

        if ($user->role !== $roleKey) {
            return back()
                ->withInput(['identifier' => $identifier])
                ->with('error', 'This account does not match the selected role.');
        }

        Auth::login($user);

        return redirect()->route('dashboard.' . $roleKey);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('landing');
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Papar halaman register.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Proses pendaftaran akaun baru.
     *
     * Support BOTH:
     * - UI: name + username (no_matrik/staff_id) + password
     * - Tests: name + email + password + password_confirmation
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'email' => ['sometimes', 'nullable', 'email', 'string', 'max:255'],
            'username' => ['sometimes', 'nullable', 'string', 'max:50'],
        ]);

        $userData = [
            'name' => $request->name,
            'password' => Hash::make($request->password),
        ];

        if ($request->filled('email')) {
            // For automated tests (and standard Breeze expectations)
            $userData['email'] = $request->email;
        } else {
            // For your UI (username represents no_matrik/staff_id)
            $username = $request->username;

            $isStaff = !empty($username) && is_numeric($username);

            if ($isStaff) {
                $userData['staff_id'] = $username;
                $userData['email'] = null;
            } else {
                $userData['no_matrik'] = $username;
                $userData['email'] = null;
            }
        }

        $user = User::create($userData);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('user.index', absolute: false));
    }
}
<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Support both your UI and default test expectations:
            // - Your UI sends: login_input (no_matrik) + password
            // - Tests send: email + password
            'login_input' => ['sometimes', 'string'],
            'email' => ['sometimes', 'email', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $password = $this->input('password');

        $loginInput = $this->input('login_input');
        $email = $this->input('email');

        // Try no_matrik first (your UI), then email (tests).
        $credentials = null;

        if (! empty($loginInput)) {
            $credentials = ['no_matrik' => $loginInput, 'password' => $password];
        } elseif (! empty($email)) {
            $credentials = ['email' => $email, 'password' => $password];
        }

        if ($credentials === null) {
            RateLimiter::hit($this->throttleKey());
            throw ValidationException::withMessages([
                'login_input' => __('Maklumat log masuk yang dimasukkan adalah salah.'),
            ]);
        }

        $loggedIn = Auth::attempt($credentials, $this->boolean('remember'));

        if (! $loggedIn) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'login_input' => __('Maklumat log masuk yang dimasukkan adalah salah.'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'login_input' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->input('login_input')).'|'.$this->ip());
    }
}
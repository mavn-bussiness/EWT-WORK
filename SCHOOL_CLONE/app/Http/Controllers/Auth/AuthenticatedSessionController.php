<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Redirect based on user role
        if ($request->user()->role === 'admin') {
            return redirect()->intended(route('admin.dashboard', absolute: false));
        } elseif ($request->user()->role === 'headteacher') {
            return redirect()->intended(route('headteacher.dashboard', absolute: false));
        } elseif ($request->user()->role === 'teacher') {
            return redirect()->intended(route('teacher.dashboard', absolute: false));
        } elseif ($request->user()->role === 'bursar') {
            return redirect()->intended(route('bursar.dashboard', absolute: false));
        } elseif ($request->user()->role === 'dos') {
            return redirect()->intended(route('dos.dashboard', absolute: false));
        } elseif ($request->user()->role === 'librarian') {
            return redirect()->intended(route('librarian.dashboard', absolute: false));
        } elseif ($request->user()->role === 'parent') {
            return redirect()->intended(route('parent.dashboard', absolute: false));
        } else {
            // Default for students or any other role
            return redirect()->intended(route('dashboard', absolute: false));
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
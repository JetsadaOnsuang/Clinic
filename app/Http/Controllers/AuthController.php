<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => 'อีเมลหรือรหัสผ่านไม่ถูกต้อง',
            ])->onlyInput('email');
        }

        if (! auth()->user()->isAdmin() && ! auth()->user()->isDoctor()) {
            Auth::logout();

            return back()->withErrors([
                'email' => 'บัญชีนี้ยังไม่ได้กำหนดบทบาทหรือผูกกับข้อมูลแพทย์ กรุณาติดต่อผู้ดูแลระบบ',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();
        $request->session()->put('auth_role', auth()->user()->role);

        return redirect()->intended(route('dashboard'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}

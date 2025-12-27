<?php
// app/Http\Controllers\Auth\LoginController.php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // ✅ FIXED: Use is_admin instead of role
            if (Auth::user()->is_admin) {  // Change this line
                return redirect()->intended('/admin/dashboard');
            }
            
            return redirect()->intended('/');
        }

        // throw ValidationException::withMessages([
        //     'email' => 'The provided credentials do not match our records.',
        // ]);
        
        // Better error handling:
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
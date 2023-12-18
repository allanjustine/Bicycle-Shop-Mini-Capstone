<?php

namespace App\Http\Controllers\Auth;

use App\Events\UserLog;
use App\Http\Controllers\Controller;
use App\Jobs\CustomerJob;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AuthIndexController extends Controller
{
    public function loginPage()
    {
        if (auth()->check()) {
            return back();
        }

        return view('auth.login');
    }

    public function registerPage()
    {
        if (auth()->check()) {
            return back();
        }

        return view('auth.register');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'         =>      'required',
            'password'      =>      'required',
        ]);


        $user = User::where('email', $request->email)->first();

        if (!$user || $user->email_verified_at == null) {
            return back()->withInput()->with('error', 'Sorry your account is not yet verified or does not exist');
        }

        $login = Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ]);

        while ($login) {
            if (auth()->user()->is_admin) {
                return redirect()->intended('/admin/dashboard');
            } else {
                return redirect()->intended('/');
            }
        }

        return back()->withInput()->with('error', 'Invalid Credentials')->withErrors(['email' => ' ', 'password' => ' ']);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'          => 'required|string',
            'address'       => 'required|string',
            'email'         => 'required|email|unique:users',
            'password'      => 'required|confirmed|string|min:6'
        ]);

        $token = Str::random(24);

        $user = User::create([
            'name'              => $request->name,
            'address'           => $request->address,
            'email'             => $request->email,
            'password'          => bcrypt($request->password),
            'remember_token'    => $token
        ])->assignRole('User')
            ->givePermissionTo('customer');

        CustomerJob::dispatch($user);
        return redirect('/login')->with('message', 'Account -' . $user->email . '- registered successfully. Please check your email for the verification link.');
    }

    public function logout()
    {
        auth()->logout();
        return redirect('/login')->with('message', 'Log out successfully');
    }

    public function verification(User $user, $token)
    {

        if ($user->remember_token !== $token) {
            return back()->with('error', 'Invalid Token');
        }

        $user->email_verified_at = now();
        $user->save();

        dispatch(new CustomerJob($user));
        return back()->with('message', 'Your account has been verified');
    }
}

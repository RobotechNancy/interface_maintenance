<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use \Cache;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        if(Cache::has('user-is-online-' . $request->email)){
            return back()->with('warning', "Impossible d'accéder au compte car l'utilisateur ".$request->email." est déjà connecté !");
        }

        $request->authenticate();

        $request->session()->regenerate();

        $expiresAt = date('Y-m-d H:i:s', strtotime("+5 min"));
        Cache::put('user-is-online-' . Auth::user()->email, true, $expiresAt);

        return redirect("/dashboard")->with('message', "Content de vous revoir cher(e) ".Auth::user()->name." !");
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Cache::forget('user-is-online-' . Auth::user()->email);
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/')->with('message', "Vous avez correctement été déconnecté de votre compte.");
    }
}

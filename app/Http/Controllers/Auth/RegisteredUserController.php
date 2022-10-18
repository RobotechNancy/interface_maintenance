<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'alpha_num', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:users'],
            'password' => ['required', 'confirmed', 'alpha_dash', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME)->with('message', "Bienvenue parmi nous, cher ".$user->name." ! Votre compte utilisateur a été créé avec succès !");
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        if($user->id != Auth::user()->id && Auth::user()->role != 2){
            return view('errors.403')->with('message', 'Erreur 403 : accès non autorisé');
        }
        return view('auth.edit', [
            'user' => $user
        ]);
    }

    public function show()
    {
        $user = Auth::User();
        return view('auth.show', [
            'user' => $user
        ]);
    }

    public function index()
    {
        $users = User::all();
        return view('auth.index', compact('users'));
    }

    public function update(Request $request, User $user)
    {
        $request->role = intval($request->role);
        $request->validate([
            'role' => ['required', 'integer', 'in:0,1,2']
        ]);

        if($request->name != $user->name){
            $request->validate([
                'name' => ['required', 'string', 'alpha_num', 'max:50']
            ]);

            $user->name = $request->name;
        }

        if($request->email != $user->email){
            $request->validate([
                'email' => ['required', 'string', 'email', 'max:100', 'unique:users']
            ]);

            $user->email = $request->email;
        }

        if(!empty($request->password)){
            $request->validate([
                'password' => ['required', 'confirmed', 'alpha_dash', Rules\Password::defaults()]
            ]);

            $user->password = Hash::make($request->password);
        }

        $user->role = $request->role;
        $user->save();
        return back()->with('message', "Le compte utilisateur ". $user->name ." a été modifié avec succès !");
    }
}

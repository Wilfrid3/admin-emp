<?php

namespace App\Http\Controllers;

use App\Models\Compte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AllAuthController extends Controller
{
    //

    public function login(){
        return view('layouts.auth.login');
    }

    public function signupSa(){
        return view('layouts.auth.signin');
    }


    public function RegisterSuperAdmin(Request $request)
    {
        $request->validate([
            'noms'=>'required',
            'mail'=>'required|email',
            'username'=>'required|unique:comptes,username',
            'pasword'=>'required|min:8',
        ]);

        $compte = new Compte();

        $compte->idTypecompte = 1;
        $compte->noms = $request->noms;
        $compte->phone = $request->phone;
        $compte->mail = $request->mail;
        $compte->addresse = $request->addresse;
        $compte->username = $request->username;
        $compte->pasword = Hash::make($request->pasword);
        $compte->valpass = $request->pasword;
        $compte->created_at = date("Y-m-d H:i:s");
        $compte->etat = 1;

        $res = $compte->save();

        if ($res) {
            return back()->with('success', 'Enregistrement réussie!');
        }else {
            return back()->with('fail', 'Echec de l\' enregistrement!');
        }
    }

    public function LoginUser(Request $request)
    {
        $request->validate([
            'username'=>'required',
            'pasword'=>'required',
        ]);

        $compte = Compte::where('username', '=', $request->username)->first();

        if ($compte) {
            if (Hash::check($request->pasword, $compte->pasword)) {
                if ($compte->etat == 1) {
                    $request->session()->put('accountid', $compte->id);
                    return redirect('/dashbord');
                } else {
                    return back()->with('fail', 'Impossible de vous connecter car votre compte a été désactivé!');
                }
                
            } else {
                return back()->with('fail', 'Mot de passe incorrect!');
            }
            
        } else {
            return back()->with('fail', 'Ce login n`existe pas!');
        }
        
    }

    public function logout()
    {
        if(Session::has('accountid')){
            Session::pull('accountid');
            return redirect('/');
        }
    }
}

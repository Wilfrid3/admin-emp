<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Book;
use App\Models\Compte;
use App\Models\Order;
use App\Models\Service;
use App\Models\Transaction;
use App\Models\Typecompte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class SuperAdminController extends Controller
{
    //

    public function dashbord(){
        $data = array();
        if(Session::has('accountid')){
            $data = Compte::where('id', '=', Session::get('accountid'))->first();
            $typeuser = Typecompte::findOrFail($data->idTypecompte);

            $books = Book::select('books.id', 'books.name', 'books.email', 'books.idhoraire', 'books.etat', 'books.idservice', 'books.created_at', 'services.id as idserv', 'services.idTypeservice as idtypeserv', 'services.libelle as libserv', 'services.prix as prixserv', 'services.duree as dureeserv', 'services.lienImg as lienImgserv', 'typeservices.libelle as typeserv', 'horaires.id as idhor', 'horaires.idPlaning', 'horaires.heureDeb', 'horaires.heureFin', 'planings.id as idplan', 'planings.datePlaning as daterdv')
                                ->join('services', 'services.id', '=', 'books.idservice')
                                ->join('horaires', 'horaires.id', '=', 'books.idhoraire')
                                ->join('typeservices', 'typeservices.id', '=', 'services.idTypeservice')
                                ->join('planings', 'planings.id', '=', 'horaires.idPlaning')
                                ->orderBy('daterdv', 'desc')
                                ->skip(0)
                                ->take(3)
                                ->get();
            
            $orders = Order::select('orders.id', 'orders.name', 'orders.email', 'orders.address', 'orders.ref', 'orders.etat', 'orders.idarticle', 'orders.qte', 'orders.created_at', 'articles.id as idarti', 'articles.idTypearticle as idtypearti', 'articles.libelle as libarti', 'articles.prix as prixarti', 'articles.lienImg as lienImgarti', 'typearticles.libelle as typearti')
                                ->join('articles', 'articles.id', '=', 'orders.idarticle')
                                ->join('typearticles', 'typearticles.id', '=', 'articles.idTypearticle')
                                ->orderBy('created_at', 'desc')
                                ->skip(0)
                                ->take(3)
                                ->get();

            $transactions = Transaction::select('transactions.id', 'transactions.ref', 'transactions.idbook', 'transactions.etat', 'transactions.created_at', 'books.id as bookid', 'books.name', 'books.email', 'books.idservice', 'services.id as idserv', 'services.idTypeservice as idtypeserv', 'services.libelle as libserv', 'services.prix as prixserv', 'services.duree as dureeserv', 'services.lienImg as lienImgserv', 'typeservices.libelle as typeserv')
                                ->join('books', 'books.id', '=', 'transactions.idbook')
                                ->join('services', 'services.id', '=', 'books.idservice')
                                ->join('typeservices', 'typeservices.id', '=', 'services.idTypeservice')
                                ->orderBy('created_at', 'desc')
                                ->skip(0)
                                ->take(3)
                                ->get();

            $services = Service::select('services.id', 'services.libelle', 'services.description', 'services.prix', 'services.oldPrix', 'services.duree', 'services.remise', 'services.lienImg', 'services.etat', 'services.idTypeservice', 'services.created_at', 'typeservices.libelle as type')
                                ->join('typeservices', 'typeservices.id', '=', 'services.idTypeservice')
                                ->orderBy('created_at', 'desc')
                                ->skip(0)
                                ->take(3)
                                ->get();
            $articles = Article::select('articles.id', 'articles.libelle', 'articles.description', 'articles.prix', 'articles.oldPrix', 'articles.quantite', 'articles.remise', 'articles.lienImg', 'articles.etat', 'articles.idTypearticle', 'articles.created_at', 'typearticles.libelle as type')
                                ->join('typearticles', 'typearticles.id', '=', 'articles.idTypearticle')
                                ->orderBy('created_at', 'desc')
                                ->skip(0)
                                ->take(3)
                                ->get();
        }
        return view('layouts.dash.dashbord', compact('data', 'typeuser', 'services', 'articles', 'books', 'orders', 'transactions'));
    }

    public function viewProfil()
    {
        $data = array();
        if(Session::has('accountid')){
            $data = Compte::where('id', '=', Session::get('accountid'))->first();
            $typeuser = Typecompte::findOrFail($data->idTypecompte);
        }
        return view('layouts.accounts.profil', compact('data', 'typeuser'));
    }

    public function updateProfil(Request $request, $id)
    {
        $request->validate([
            'noms'=>'required',
            'mail'=>'required|email',
            'username'=>'required|unique:comptes,username,'.$id,
        ]);

        $compte = Compte::find($id);

        $compte->noms = $request->noms;
        $compte->phone = $request->phone;
        $compte->mail = $request->mail;
        $compte->addresse = $request->addresse;
        $compte->username = $request->username;
        $compte->updated_at = date("Y-m-d H:i:s");

        $res = $compte->save();

        if ($res) {
            return back()->with('success', 'Modification de vos informations réussi!');
        } else {
            return back()->with('fail', 'Echec de modification de vos information!');
        }
    }

    public function updatePass(Request $request, $id)
    {
        $request->validate([
            'currentpassword'=>'required|min:8',
            'pasword'=>'required|min:8',
        ]);

        if ($request->currentpassword != $request->valpass) {
            return back()->with('fail', 'Mot de passe actuel incorrect!');
        } else {
            $compte = Compte::find($id);

            $compte->pasword = Hash::make($request->pasword);
            $compte->valpass = $request->pasword;
            $compte->updated_at = date("Y-m-d H:i:s");

            $res = $compte->save();

            if ($res) {
                return back()->with('success', 'Modification de votre mot de passe réussie!');
            } else {
                return back()->with('fail', 'Echec de modification de votre mot de passe!');
            }
        }
        
    }

    public function allComptes()
    {
        $data = array();
        $comptes = array();
        if(Session::has('accountid')){
            $data = Compte::where('id', '=', Session::get('accountid'))->first();
            $typeuser = Typecompte::findOrFail($data->idTypecompte);
            if ($data->idTypecompte == 1) {
                $comptes = Compte::select('comptes.id', 'comptes.noms', 'comptes.mail', 'comptes.username', 'comptes.phone', 'comptes.addresse', 'comptes.id', 'comptes.etat', 'comptes.idTypeCompte', 'comptes.created_at', 'typecomptes.libelle as type')
                                ->join('typecomptes', 'typecomptes.id', '=', 'comptes.idTypecompte')
                                ->orderBy('created_at', 'desc')
                                ->get();
            } else {
                $comptes = Compte::select('comptes.id', 'comptes.noms', 'comptes.mail', 'comptes.username', 'comptes.phone', 'comptes.addresse', 'comptes.id', 'comptes.etat', 'comptes.idTypeCompte', 'comptes.created_at', 'typecomptes.libelle as type')
                                ->where('comptes.idTypecompte', '!=', 1)
                                ->join('typecomptes', 'typecomptes.id', '=', 'comptes.idTypecompte')
                                ->orderBy('created_at', 'desc')
                                ->get();
            }
            
            
        }
        return view('layouts.accounts.comptes_sp', compact('data', 'typeuser', 'comptes'));
    }

    public function addCompte()
    {
        $data = array();
        if(Session::has('accountid')){
            $data = Compte::where('id', '=', Session::get('accountid'))->first();
            $typeuser = Typecompte::findOrFail($data->idTypecompte);
        }
        return view('layouts.accounts.add_compte', compact('data', 'typeuser'));
    }

    public function RegisterCompte(Request $request)
    {
        $request->validate([
            'noms'=>'required',
            'mail'=>'required|email',
            'username'=>'required|unique:comptes,username',
            'pasword'=>'required|min:8',
        ]);

        $compte = new Compte();

        $compte->idTypecompte = 2;
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
            return redirect('/comptes_sp')->with('success', 'Création du compte réussie!');
        }else {
            return back()->with('fail', 'Echec de création du compte!');
        }
    }

    public function editCompte($id)
    {
        $data = array();
        if(Session::has('accountid')){
            $data = Compte::where('id', '=', Session::get('accountid'))->first();
            $typeuser = Typecompte::findOrFail($data->idTypecompte);
            $compte = Compte::findOrFail($id);
        }
        return view('layouts.accounts.edit_compte', compact('data', 'typeuser', 'compte'));
    }

    public function updateCompte(Request $request, $id)
    {
        $request->validate([
            'noms'=>'required',
            'mail'=>'required|email',
            'username'=>'required|unique:comptes,username,'.$id,
            'pasword'=>'required|min:8',
        ]);

        $compte = Compte::find($id);

        $compte->noms = $request->noms;
        $compte->phone = $request->phone;
        $compte->mail = $request->mail;
        $compte->addresse = $request->addresse;
        $compte->username = $request->username;
        $compte->pasword = Hash::make($request->pasword);
        $compte->valpass = $request->pasword;
        $compte->updated_at = date("Y-m-d H:i:s");

        $res = $compte->save();

        if ($res) {
            return redirect('/comptes_sp')->with('success', 'Modification du compte réussie!');
        } else {
            return back()->with('fail', 'Echec de modification du compte!');
        }
    }

    public function activeCompte($id)
    {
        $compte = Compte::find($id);

        $compte->etat = 1;

        $res = $compte->save();

        if($res){
            return back()->with('success', 'Activation du compte réussie!');
        }else{
            return back()->with('fail', 'Echec d`activation du compte!');
        }
           
    }
    
    public function desactiveCompte($id)
    {
        $compte = Compte::find($id);

        $compte->etat = 2;

        $res = $compte->save();

        if($res){
            return back()->with('success', 'Désactivation du compte réussie!');
        }else{
            return back()->with('fail', 'Echec de désactivation du compte!');
        }
    }

    public function deleteCompte($id)
    {
        $res = Compte::find($id)->delete();

        if($res){
            return back()->with('success', 'Suppression du compte réussie!');
        }else{
            return back()->with('fail', 'Echec de suppression du compte!');
        }
    }
}

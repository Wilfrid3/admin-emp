<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Book;
use App\Models\Compte;
use App\Models\Horaire;
use App\Models\Order;
use App\Models\Planing;
use App\Models\Service;
use App\Models\Transaction;
use App\Models\Typecompte;
use App\Models\Typeservice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    //

    public function allServices()
    {
        $data = array();
        if(Session::has('accountid')){
            $data = Compte::where('id', '=', Session::get('accountid'))->first();
            $typeuser = Typecompte::findOrFail($data->idTypecompte);
            $services = Service::select('services.id', 'services.libelle', 'services.description', 'services.prix', 'services.oldPrix', 'services.duree', 'services.remise', 'services.lienImg', 'services.etat', 'services.idTypeservice', 'services.created_at', 'typeservices.libelle as type')
                                ->join('typeservices', 'typeservices.id', '=', 'services.idTypeservice')
                                ->orderBy('created_at', 'desc')
                                ->get();
        }
        return view('layouts.services.services', compact('data', 'typeuser', 'services'));
    }

    public function addService()
    {
        $data = array();
        if(Session::has('accountid')){
            $data = Compte::where('id', '=', Session::get('accountid'))->first();
            $typeuser = Typecompte::findOrFail($data->idTypecompte);
            $typeservices = DB::table('typeservices')
                            ->select('id', 'libelle')
                            ->get();
        }
        return view('layouts.services.add_service', compact('data', 'typeuser', 'typeservices'));
    }

    public function RegisterService(Request $request)
    {
        $request->validate([
            'lienImg'=>'required|image|mimes:jpg,png,jpeg|max:2048',
            'libelle'=>'required|unique:services,libelle',
            'description'=>'required',
            'prix'=>'required',
            'oldPrix'=>'required',
            'duree'=>'required',
            'idTypeservice'=>'required',
        ]);
        
        if ($request->etat == null) {
            $request->etat = "1";
        }

        $servicepath = null;
        if($request->file('lienImg') != null){
            $request->file('lienImg')->store('public/servicesImg');
            $servicepath = $request->file('lienImg')->store('servicesImg');
        }

        $service = new Service();

        $service->idCompte = $request->idCompte;
        $service->idTypeservice = $request->idTypeservice;
        $service->libelle = $request->libelle;
        $service->description = $request->description;
        $service->prix = $request->prix;
        $service->oldPrix = $request->oldPrix;
        $service->duree = $request->duree;
        $service->lienImg = $servicepath;
        $service->etat = $request->etat;
        $service->created_at = date("Y-m-d H:i:s");

        $res = $service->save();

        if ($res) {
            return redirect('/services')->with('success', 'Création du service réussie!');
        } else {
            return back()->with('fail', 'Echec de création du service!');
        }
        
    }

    public function editservice($id)
    {
        $data = array();
        if(Session::has('accountid')){
            $data = Compte::where('id', '=', Session::get('accountid'))->first();
            $typeuser = Typecompte::findOrFail($data->idTypecompte);
            $typeservices = DB::table('typeservices')
                            ->select('id', 'libelle')
                            ->get();
            $service = Service::findOrFail($id);
        }
        return view('layouts.services.edit_service', compact('data', 'typeuser', 'typeservices',  'service'));
    }

    public function updateService(Request $request, $id)
    {
        $request->validate([
            'lienImg'=>'image|mimes:jpg,png,jpeg|max:2048',
            'libelle'=>'required|unique:services,libelle,'.$id,
            'description'=>'required',
            'prix'=>'required',
            'oldPrix'=>'required',
            'duree'=>'required',
            'idTypeservice'=>'required',
        ]);

        $servicepath = $request->old_lienImg;
        if($request->file('lienImg') != null){
            $request->file('lienImg')->store('public/servicesImg');
            $servicepath = $request->file('lienImg')->store('servicesImg');
        }

        $service = Service::find($id);

        $service->idTypeservice = $request->idTypeservice;
        $service->libelle = $request->libelle;
        $service->description = $request->description;
        $service->prix = $request->prix;
        $service->oldPrix = $request->oldPrix;
        $service->duree = $request->duree;
        $service->lienImg = $servicepath;
        $service->updated_at = date("Y-m-d H:i:s");

        $res = $service->save();

        if ($res) {
            return redirect('/services')->with('success', 'Mise à jour du service réussie!');
        } else {
            return back()->with('fail', 'Echec de mise à jour du service!');
        }
    }

    public function publishService($id)
    {
        $service = Service::find($id);

        $service->etat = 2;

        $res = $service->save();

        if($res){
            return back()->with('success', 'Service publié avec succès!');
        }else{
            return back()->with('fail', 'Echec de publication du service!');
        }
    }

    public function blockService($id)
    {
        $service = Service::find($id);

        $service->etat = 3;

        $res = $service->save();

        if($res){
            return back()->with('success', 'Service suspendu avec succès!');
        }else{
            return back()->with('fail', 'Echec de suspention du service!');
        }
    }

    public function deleteService($id)
    {
        // $service = Service::find($id);
        $plans = array();
        $plans = Planing::where('idService', '=', $id)->get();
        if(count($plans) != 0){
            for ($i=0; $i < count($plans); $i++) { 
                Horaire::where('idPlaning', '=', $plans[$i]->id)->delete();
            }

            $resdelete = Planing::where('idService', '=', $id)->delete();
            if ($resdelete) {
                $res = Service::find($id)->delete();
    
                if($res){
                    return back()->with('success', 'Suppression du service réussie!');
                }else{
                    return back()->with('fail', 'Echec de suppression du service!');
                }
            }
        } else{
            $res = Service::find($id)->delete();
    
            if($res){
                return back()->with('success', 'Suppression du service réussie!');
            }else{
                return back()->with('fail', 'Echec de suppression du service!');
            }
        }
    }

    public function planService($id)
    {
        $data = array();
        if(Session::has('accountid')){
            $data = Compte::where('id', '=', Session::get('accountid'))->first();
            $typeuser = Typecompte::findOrFail($data->idTypecompte);
            $plans = Planing::select('planings.id', 'planings.datePlaning', 'planings.idService', 'planings.created_at')
                                ->where('planings.idService', '=', $id)
                                ->orderBy('created_at', 'desc')
                                ->get();
        }
        return view('layouts.services.plans_service', compact('data', 'typeuser', 'plans', 'id'));
    }

    public function addPlan($id)
    {
        $data = array();
        if(Session::has('accountid')){
            $data = Compte::where('id', '=', Session::get('accountid'))->first();
            $typeuser = Typecompte::findOrFail($data->idTypecompte);
        }
        return view('layouts.services.add_plan_service', compact('data', 'typeuser', 'id'));
    }

    public function RegisterPlan(Request $request)
    {
        $request->validate([
            'datePlaning'=>'required',
        ]);
        $idservice = $request->idService;

        $plan = new Planing();

        $plan->idService = $idservice;
        $plan->datePlaning = $request->datePlaning;
        $plan->created_at = date("Y-m-d H:i:s");

        $res = $plan->save();
        $idplan = $plan->id;

        if ($res) {
            return redirect('hm_plan_serv_add/'.$idservice.'/'.$idplan)->with('success', 'Ajout du planing réussie!');
        } else {
            return back()->with('fail', 'Echec d`ajout du planing');
        }
    }

    public function addHorairePlan($idserv, $id)
    {
        $data = array();
        if(Session::has('accountid')){
            $data = Compte::where('id', '=', Session::get('accountid'))->first();
            $typeuser = Typecompte::findOrFail($data->idTypecompte);
        }
        return view('layouts.services.add_hm_plan_service', compact('data', 'typeuser', 'idserv', 'id'));
    }

    public function RegisterHorairePlan(Request $request)
    {
        $request->validate([
            'heureDeb'=>'required',
            'heureFin'=>'required',
        ]);

        $horaire = new Horaire();

        $horaire->idPlaning = $request->idPlaning;
        $horaire->heureDeb = $request->heureDeb;
        $horaire->heureFin = $request->heureFin;
        $horaire->created_at = date("Y-m-d H:i:s");

        $res = $horaire->save();

        if ($res) {
            return back()->with('success', 'Horaire ajouté avec succès');
        } else {
            return back()->with('fail', 'Echec d`ajout de l`horaire');
        }

    }

    public function horairePlanService($id, $idserv)
    {
        $data = array();
        if(Session::has('accountid')){
            $data = Compte::where('id', '=', Session::get('accountid'))->first();
            $typeuser = Typecompte::findOrFail($data->idTypecompte);
            $horaires = Horaire::select('horaires.id', 'horaires.heureDeb', 'horaires.heureFin', 'horaires.idPlaning', 'horaires.created_at')
                                ->where('horaires.idPlaning', '=', $id)
                                ->orderBy('created_at', 'desc')
                                ->get();
        }
        return view('layouts.services.h_plan_service', compact('data', 'typeuser', 'horaires', 'id', 'idserv'));
    }

    public function deleteHoraire($id)
    {
        $res = Horaire::find($id)->delete();

        if($res){
            return back()->with('success', 'Horaire supprimé!');
        }else{
            return back()->with('fail', 'Echec de suppression de l`horaire!');
        }
    }

    public function RegisterHoraire(Request $request)
    {
        $request->validate([
            'heureDeb'=>'required',
            'heureFin'=>'required',
        ]);

        $horaire = new Horaire();

        $horaire->idPlaning = $request->idPlaning;
        $horaire->heureDeb = $request->heureDeb;
        $horaire->heureFin = $request->heureFin;
        $horaire->created_at = date("Y-m-d H:i:s");

        $res = $horaire->save();

        if ($res) {
            return back()->with('success', 'Horaire ajouté avec succès');
        } else {
            return back()->with('fail', 'Echec d`ajout de l`horaire');
        }
    }

    public function deletePlan($id)
    {
        $horaires = array();
        $horaires = Horaire::where('idPlaning', '=', $id)->get();

        if (count($horaires) != 0) {
            $resdelete = Horaire::where('idPlaning', '=', $id)->delete();
        
            if ($resdelete) {
                $res = Planing::find($id)->delete();
    
                if($res){
                    return back()->with('success', 'Planification supprimé!');
                }else{
                    return back()->with('fail', 'Echec de suppression de la planification!');
                }
            }
        }else{
            $res = Planing::find($id)->delete();
    
            if($res){
                return back()->with('success', 'Planification supprimé!');
            }else{
                return back()->with('fail', 'Echec de suppression de la planification!');
            }
        }
        
    }

    public function allPlaning()
    {
        $data = array();
        if(Session::has('accountid')){
            $data = Compte::where('id', '=', Session::get('accountid'))->first();
            $typeuser = Typecompte::findOrFail($data->idTypecompte);
            $plans = Planing::select('planings.id', 'planings.idService', 'planings.datePlaning', 'planings.created_at', 'services.id as idserv', 'services.libelle', 'services.prix', 'services.duree', 'services.lienImg', 'services.etat', 'services.idTypeservice', 'services.created_at', 'typeservices.libelle as type')
                                ->join('services', 'services.id', '=', 'planings.idService')
                                ->join('typeservices', 'typeservices.id', '=', 'services.idTypeservice')
                                ->orderBy('datePlaning', 'asc')
                                ->get();
        }
        return view('layouts.services.planings', compact('data', 'typeuser', 'plans'));
    }

    public function viewPlan($id)
    {
        $data = array();
        if(Session::has('accountid')){
            $data = Compte::where('id', '=', Session::get('accountid'))->first();
            $typeuser = Typecompte::findOrFail($data->idTypecompte);
            $plan = Planing::findOrFail($id);
            $service = Service::findOrFail($plan->idService);
            $typeservice = Typeservice::findOrFail($service->idTypeservice);
            
            $horaires = array();
            $horaires = Horaire::where('idPlaning', '=', $id)->get();
        }
        return view('layouts.services.planing_view', compact('data', 'typeuser', 'plan', 'service', 'typeservice', 'horaires'));
    }

    public function allArticles()
    {
        $data = array();
        if(Session::has('accountid')){
            $data = Compte::where('id', '=', Session::get('accountid'))->first();
            $typeuser = Typecompte::findOrFail($data->idTypecompte);
            $articles = Article::select('articles.id', 'articles.libelle', 'articles.description', 'articles.prix', 'articles.oldPrix', 'articles.quantite', 'articles.remise', 'articles.lienImg', 'articles.etat', 'articles.idTypearticle', 'articles.created_at', 'typearticles.libelle as type')
                                ->join('typearticles', 'typearticles.id', '=', 'articles.idTypearticle')
                                ->orderBy('created_at', 'desc')
                                ->get();
        }
        return view('layouts.articles.articles', compact('data', 'typeuser', 'articles'));
    }

    public function addArticle()
    {
        $data = array();
        if(Session::has('accountid')){
            $data = Compte::where('id', '=', Session::get('accountid'))->first();
            $typeuser = Typecompte::findOrFail($data->idTypecompte);
            $typearticles = DB::table('typearticles')
                            ->select('id', 'libelle')
                            ->get();
        }
        return view('layouts.articles.add_article', compact('data', 'typeuser', 'typearticles'));
    }

    public function RegisterArticle(Request $request)
    {
        $request->validate([
            'lienImg'=>'required|image|mimes:jpg,png,jpeg|max:2048',
            'libelle'=>'required|unique:services,libelle',
            'description'=>'required',
            'prix'=>'required',
            'oldPrix'=>'required',
            'quantite'=>'required',
            'idTypearticle'=>'required',
        ]);
        
        if ($request->etat == null) {
            $request->etat = "1";
        }

        $articlepath = null;
        if($request->file('lienImg') != null){
            $request->file('lienImg')->store('public/articlesImg');
            $articlepath = $request->file('lienImg')->store('articlesImg');
        }

        $article = new Article();

        $article->idCompte = $request->idCompte;
        $article->idTypearticle = $request->idTypearticle;
        $article->libelle = $request->libelle;
        $article->description = $request->description;
        $article->prix = $request->prix;
        $article->oldPrix = $request->oldPrix;
        $article->quantite = $request->quantite;
        $article->lienImg = $articlepath;
        $article->etat = $request->etat;
        $article->created_at = date("Y-m-d H:i:s");

        $res = $article->save();

        if ($res) {
            return redirect('/articles')->with('success', 'Création de l`article réussie!');
        } else {
            return back()->with('fail', 'Echec de création de l`article!');
        }
    }

    public function editArticle($id)
    {
        $data = array();
        if(Session::has('accountid')){
            $data = Compte::where('id', '=', Session::get('accountid'))->first();
            $typeuser = Typecompte::findOrFail($data->idTypecompte);
            $typearticles = DB::table('typearticles')
                            ->select('id', 'libelle')
                            ->get();
            $article = Article::findOrFail($id);
        }
        return view('layouts.articles.edit_article', compact('data', 'typeuser', 'typearticles',  'article'));
    }

    public function updateArticle(Request $request, $id)
    {
        $request->validate([
            'lienImg'=>'image|mimes:jpg,png,jpeg|max:2048',
            'libelle'=>'required|unique:services,libelle,'.$id,
            'description'=>'required',
            'prix'=>'required',
            'oldPrix'=>'required',
            'quantite'=>'required',
            'idTypearticle'=>'required',
        ]);

        $articlepath = $request->old_lienImg;
        if($request->file('lienImg') != null){
            $request->file('lienImg')->store('public/articlesImg');
            $articlepath = $request->file('lienImg')->store('articlesImg');
        }

        $article = Article::find($id);

        $article->idTypearticle = $request->idTypearticle;
        $article->libelle = $request->libelle;
        $article->description = $request->description;
        $article->prix = $request->prix;
        $article->oldPrix = $request->oldPrix;
        $article->quantite = $request->quantite;
        $article->lienImg = $articlepath;
        $article->updated_at = date("Y-m-d H:i:s");

        $res = $article->save();

        if ($res) {
            return redirect('/articles')->with('success', 'Mise à jour de l`article réussie!');
        } else {
            return back()->with('fail', 'Echec de mise à jour de l`article!');
        }
    }

    public function publishArticle($id)
    {
        $article = Article::find($id);

        $article->etat = 2;

        $res = $article->save();

        if($res){
            return back()->with('success', 'article publié avec succès!');
        }else{
            return back()->with('fail', 'Echec de publication de l`article!');
        }
    }

    public function blockArticle($id)
    {
        $article = Article::find($id);

        $article->etat = 3;

        $res = $article->save();

        if($res){
            return back()->with('success', 'article suspendu avec succès!');
        }else{
            return back()->with('fail', 'Echec de suspention de l`article!');
        }
    }

    public function deleteArticle($id)
    {
        $res = Article::find($id)->delete();

        if($res){
            return back()->with('success', 'Article supprimé avec succès!');
        }else{
            return back()->with('fail', 'Echec de suppression de l`article!');
        }
    }

    public function allRdvs()
    {
        $data = array();
        if(Session::has('accountid')){
            $data = Compte::where('id', '=', Session::get('accountid'))->first();
            $typeuser = Typecompte::findOrFail($data->idTypecompte);
            $books = Book::select('books.id', 'books.name', 'books.email', 'books.idhoraire', 'books.etat', 'books.idservice', 'books.created_at', 'services.id as idserv', 'services.idTypeservice as idtypeserv', 'services.libelle as libserv', 'services.prix as prixserv', 'services.duree as dureeserv', 'services.lienImg as lienImgserv', 'typeservices.libelle as typeserv', 'horaires.id as idhor', 'horaires.idPlaning', 'horaires.heureDeb', 'horaires.heureFin', 'planings.id as idplan', 'planings.datePlaning as daterdv')
                                ->join('services', 'services.id', '=', 'books.idservice')
                                ->join('horaires', 'horaires.id', '=', 'books.idhoraire')
                                ->join('typeservices', 'typeservices.id', '=', 'services.idTypeservice')
                                ->join('planings', 'planings.id', '=', 'horaires.idPlaning')
                                ->orderBy('created_at', 'desc')
                                ->get();
        }
        return view('layouts.services.books', compact('data', 'typeuser', 'books'));
    }

    public function allCommandes()
    {
        $data = array();
        if(Session::has('accountid')){
            $data = Compte::where('id', '=', Session::get('accountid'))->first();
            $typeuser = Typecompte::findOrFail($data->idTypecompte);
            $orders = Order::select('orders.id', 'orders.name', 'orders.email', 'orders.address', 'orders.ref', 'orders.etat', 'orders.idarticle', 'orders.qte', 'orders.created_at', 'articles.id as idarti', 'articles.idTypearticle as idtypearti', 'articles.libelle as libarti', 'articles.prix as prixarti', 'articles.lienImg as lienImgarti', 'typearticles.libelle as typearti')
                                ->join('articles', 'articles.id', '=', 'orders.idarticle')
                                ->join('typearticles', 'typearticles.id', '=', 'articles.idTypearticle')
                                ->orderBy('created_at', 'desc')
                                ->get();
        }
        return view('layouts.articles.orders', compact('data', 'typeuser', 'orders'));
    }

    public function allTransactions()
    {
        $data = array();
        if(Session::has('accountid')){
            $data = Compte::where('id', '=', Session::get('accountid'))->first();
            $typeuser = Typecompte::findOrFail($data->idTypecompte);
            $transactions = Transaction::select('transactions.id', 'transactions.ref', 'transactions.idbook', 'transactions.etat', 'transactions.created_at', 'books.id as bookid', 'books.name', 'books.email', 'books.idservice', 'services.id as idserv', 'services.idTypeservice as idtypeserv', 'services.libelle as libserv', 'services.prix as prixserv', 'services.duree as dureeserv', 'services.lienImg as lienImgserv', 'typeservices.libelle as typeserv')
                                ->join('books', 'books.id', '=', 'transactions.idbook')
                                ->join('services', 'services.id', '=', 'books.idservice')
                                ->join('typeservices', 'typeservices.id', '=', 'services.idTypeservice')
                                ->orderBy('created_at', 'desc')
                                ->get();
        }
        return view('layouts.services.transactions', compact('data', 'typeuser', 'transactions'));
    }
}

<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AllAuthController;
use App\Http\Controllers\SuperAdminController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::group(['prefix' => 'public'], function () {
    Route::get('/', [AllAuthController::class, 'login'])->middleware('alreadyLoggetIn');
    Route::get('/signup_sa', [AllAuthController::class, 'signupSa'])->middleware('alreadyLoggetIn');
    Route::post('/register_sa', [AllAuthController::class, 'RegisterSuperAdmin'])->name('register-sa');
    Route::post('/login_user', [AllAuthController::class, 'LoginUser'])->name('login-user');
    Route::get('/logout', [AllAuthController::class, 'logout']);
    Route::get('storage/servicesImg/{filename}', function ($filename) {
        $path = storage_path('app/servicesImg/' . $filename);
        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    });

    Route::get('/dashbord', [SuperAdminController::class, 'dashbord'])->middleware('isLoggedIn');
    Route::get('/profil', [SuperAdminController::class, 'viewProfil'])->middleware('isLoggedIn');
    Route::get('/comptes_sp', [SuperAdminController::class, 'allComptes'])->middleware('isLoggedIn');
    Route::get('/compte_add', [SuperAdminController::class, 'addCompte'])->middleware('isLoggedIn');
    Route::post('/compte_register', [SuperAdminController::class, 'RegisterCompte'])->name('compte-register')->middleware('isLoggedIn');
    Route::get('/compte_edit/{id}', [SuperAdminController::class, 'editCompte'])->name('compte-edit')->middleware('isLoggedIn');
    Route::patch('/compte_update/{id}', [SuperAdminController::class, 'updateCompte'])->name('compte-update')->middleware('isLoggedIn');
    Route::patch('/profil_update/{id}', [SuperAdminController::class, 'updateProfil'])->name('profil-update')->middleware('isLoggedIn');
    Route::patch('/pass_update/{id}', [SuperAdminController::class, 'updatePass'])->name('pass-update')->middleware('isLoggedIn');
    Route::patch('/compte_active/{id}', [SuperAdminController::class, 'activeCompte'])->name('compte-active')->middleware('isLoggedIn');
    Route::patch('/compte_desactive/{id}', [SuperAdminController::class, 'desactiveCompte'])->name('compte-desactive')->middleware('isLoggedIn');
    Route::delete('/compte_delete/{id}', [SuperAdminController::class, 'deleteCompte'])->name('compte-delete')->middleware('isLoggedIn');

    Route::get('/services', [AdminController::class, 'allServices'])->middleware('isLoggedIn');
    Route::get('/service_add', [AdminController::class, 'addService'])->middleware('isLoggedIn');
    Route::post('/service_register', [AdminController::class, 'RegisterService'])->name('service-register')->middleware('isLoggedIn');
    Route::get('/service_edit/{id}', [AdminController::class, 'editservice'])->name('service-edit')->middleware('isLoggedIn');
    Route::patch('/service_update/{id}', [AdminController::class, 'updateService'])->name('service-update')->middleware('isLoggedIn');
    Route::patch('/service_publish/{id}', [AdminController::class, 'publishService'])->name('service-publish')->middleware('isLoggedIn');
    Route::patch('/service_block/{id}', [AdminController::class, 'blockService'])->name('service-block')->middleware('isLoggedIn');
    Route::delete('/service_delete/{id}', [AdminController::class, 'deleteService'])->name('service-delete')->middleware('isLoggedIn');
    Route::get('/plans_serv/{id}', [AdminController::class, 'planService'])->name('plans')->middleware('isLoggedIn');
    Route::get('/plans_serv_add/{id}', [AdminController::class, 'addPlan'])->name('plan-add')->middleware('isLoggedIn');
    Route::post('/plan_register', [AdminController::class, 'RegisterPlan'])->name('plan-register')->middleware('isLoggedIn');
    Route::get('/hm_plan_serv_add/{idserv}/{id}', [AdminController::class, 'addHorairePlan'])->name('hm-plan-add')->middleware('isLoggedIn');
    Route::post('/hm_plan_register', [AdminController::class, 'RegisterHorairePlan'])->name('hm-plan-register')->middleware('isLoggedIn');
    Route::get('/hs_plan_serv/{id}/{idserv}', [AdminController::class, 'horairePlanService'])->name('hs-plans')->middleware('isLoggedIn');
    Route::delete('/horaire_delete/{id}', [AdminController::class, 'deleteHoraire'])->name('horaire-delete')->middleware('isLoggedIn');
    Route::post('/hm_register', [AdminController::class, 'RegisterHoraire'])->name('hm-register')->middleware('isLoggedIn');
    Route::delete('/plan_delete/{id}', [AdminController::class, 'deletePlan'])->name('plan-delete')->middleware('isLoggedIn');
    Route::get('/planing', [AdminController::class, 'allPlaning'])->middleware('isLoggedIn');
    Route::get('/plan_view/{id}', [AdminController::class, 'viewPlan'])->name('plan-view')->middleware('isLoggedIn');

    Route::get('/articles', [AdminController::class, 'allArticles'])->middleware('isLoggedIn');
    Route::get('/article_add', [AdminController::class, 'addArticle'])->middleware('isLoggedIn');
    Route::post('/article_register', [AdminController::class, 'RegisterArticle'])->name('article-register')->middleware('isLoggedIn');
    Route::get('/article_edit/{id}', [AdminController::class, 'editArticle'])->name('article-edit')->middleware('isLoggedIn');
    Route::patch('/article_update/{id}', [AdminController::class, 'updateArticle'])->name('article-update')->middleware('isLoggedIn');
    Route::patch('/article_publish/{id}', [AdminController::class, 'publishArticle'])->name('article-publish')->middleware('isLoggedIn');
    Route::patch('/article_block/{id}', [AdminController::class, 'blockArticle'])->name('article-block')->middleware('isLoggedIn');
    Route::delete('/article_delete/{id}', [AdminController::class, 'deleteArticle'])->name('article-delete')->middleware('isLoggedIn');

    Route::get('/rdvs', [AdminController::class, 'allRdvs'])->middleware('isLoggedIn');
    Route::get('/commandes', [AdminController::class, 'allCommandes'])->middleware('isLoggedIn');
    Route::get('/transactions', [AdminController::class, 'allTransactions'])->middleware('isLoggedIn');
});

<?php

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

Route::get('/', function () {
    return view('Accueil');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->middleware('can:all')->name('home');

Route::get('/connexion', [App\Http\Controllers\AuthController::class, 'index'])->name('connexion');
Route::post('/connexion', [App\Http\Controllers\AuthController::class, 'postLogin'])->name('postLogin');
Route::get('/inscription', [App\Http\Controllers\AuthController::class, 'register'])->middleware('guest')->name('inscription');
Route::post('/inscription', [App\Http\Controllers\AuthController::class, 'postRegister'])->name('postInscription');
Route::get('/logout', 		 [App\Http\Controllers\AuthController::class, 'logout'])->name('deconnexion');

Route::get('/password/resetter/{query}', [App\Http\Controllers\PasswordResetController::class, 'resetter'])->name('resetter');

Route::get('/verify/{phone}', [App\Http\Controllers\VerificationController::class, 'registrationShow'])->name('verify');
Route::post('/post-verify', [App\Http\Controllers\VerificationController::class, 'registration'])->name('post-verify');
Route::get('/resend-code/{phone}', [App\Http\Controllers\VerificationController::class, 'resend_code'])->name('resend_code');






//User actions
	Route::get('/mesengins', [App\Http\Controllers\User\EnginsController::class, 'index'])->middleware('can:user')->name('engins.index');

	Route::get('/nouvelle/vignette', [App\Http\Controllers\User\EnginsController::class, 'selectEnginType'])->middleware('can:user')->name('user.selectEnginType');
	Route::get('/nouvelle/vignette/{type}', [App\Http\Controllers\User\EnginsController::class, 'create'])->middleware('can:user')->name('user.createEngin');
	Route::post('/nouvelle/vignette', [App\Http\Controllers\User\EnginsController::class, 'store'])->middleware('can:user')->name('user.storeEngin');
	Route::get('/vignettes/{enginId}/{userId}', [App\Http\Controllers\User\VignettesController::class,'demande_de_vignette'])->middleware('can:user')->name('user.demande_vignette');

	Route::get('/notifications', [App\Http\Controllers\User\VignettesController::class,'notificationListing'])->middleware('can:user')->name('notification.list');

	Route::get('/notifications/{notification}', [App\Http\Controllers\User\VignettesController::class,'notificationShow'])->middleware('can:user')->name('notification.show');

	Route::post('qrvignette/{qr_path}', [App\Http\Controllers\User\VignettesController::class, 'downloadQr'])->middleware('can:user')->name('downloadQr');

	// Route::post('/declaration/{user}/{vignette}/{engin}', [App\Http\Controllers\User\VignettesController::class,  'declaration_de_perte'])->middleware('auth')->name('declaration_de_perte');

	// Route::post('/annuler_declaration/{user}/{vignette}/{engin}', [App\Http\Controllers\User\VignettesController::class,  'annuler_declaration'])->middleware('auth')->name('annuler_declaration');

	// Route::post('/renouveller_vignette/{user}/{vignette}/{engin}', [App\Http\Controllers\User\VignettesController::class, 'renouveller_vignette'])->middleware('auth')->name('renouveller_vignette');




	// 	Administration Routes
	Route::get('/super', [App\Http\Controllers\Administration\SuperAdminController::class, 'index'])->middleware('can:superadmin')->name("superadmin.index");
	Route::get('/super/create', [App\Http\Controllers\Administration\SuperAdminController::class, 'create'])->middleware('can:superadmin')->name("superadmin.create");
	Route::get('/super/edit/{id}', [App\Http\Controllers\Administration\SuperAdminController::class, 'edit'])->middleware('can:superadmin')->name("superadmin.edit");
	Route::put('/super/update/{id}', [App\Http\Controllers\Administration\SuperAdminController::class, 'update'])->middleware('can:superadmin')->name("superadmin.update");
	Route::post('/super/create', [App\Http\Controllers\Administration\SuperAdminController::class, 'store'])->middleware('can:superadmin')->name("superadmin.store");
	Route::delete('/super/delete/{id}', [App\Http\Controllers\Administration\SuperAdminController::class, 'destroy'])->middleware('can:superadmin')->name("superadmin.destroy");

	Route::get('/adminsh', [App\Http\Controllers\AuthController::class, 'admin_login'])->name("get_admin_login");
	Route::get('/admin-dashboard', [App\Http\Controllers\AuthController::class, 'adminDashboard'])->middleware('auth')->name("get_admin_dash");
	Route::get('/examiner/{usagerId}/{enginId}/{notificationId}/{demandeTrackId}', [App\Http\Controllers\Administration\GestionVignettesController::class, 'examinerDemande'])->middleware('can:guichet')->name('examinerDemande');
	Route::post('/ikvUE-validation/{enginId}/{notificationId}/{usager}/{demandeTrackId}', [App\Http\Controllers\Administration\GestionVignettesController::class, 'demandeValidation'])->middleware('can:guichet')->name('validerDemande');

	Route::get('/nouveau-agent', [App\Http\Controllers\Administration\AgentController::class, 'createShow'])->middleware('can:comptable-public')->name("agent.create");
	Route::post('/nouveau-agent', [App\Http\Controllers\Administration\AgentController::class, 'store'])->middleware('can:comptable-public')->name("agent.store");
	Route::get('/agents', [App\Http\Controllers\Administration\AgentController::class, 'index'])->middleware('can:comptable-public')->name("agent.index");
	Route::get('/agent/edit/{id}', [App\Http\Controllers\Administration\AgentController::class, 'edit'])->middleware('can:comptable-public')->name("agent.edit");
	Route::put('/agent/update/{id}', [App\Http\Controllers\Administration\AgentController::class, 'update'])->middleware('can:comptable-public')->name("agent.update");
	Route::delete('/agent/delete/{id}', [App\Http\Controllers\Administration\AgentController::class, 'destroy'])->middleware('can:comptable-public')->name("agent.destroy");


	Route::get('/enrollHistory', [App\Http\Controllers\Administration\HistoryController::class, 'enrollHistory'])->middleware('can:guichet')->name("enrollHistory");



	// Guichet nouvel_engin
	Route::get('guichet/users', [App\Http\Controllers\Guichet\UsagerController::class, 'index'])->middleware('can:guichet')->name('guichet.user.index');
	Route::get('guichet/user/edit/{i}', [App\Http\Controllers\Guichet\UsagerController::class, 'edit'])->middleware('can:guichet')->name('guichet.user.edit');
	Route::get('guichet/user/show/{i}', [App\Http\Controllers\Guichet\UsagerController::class, 'show'])->middleware('can:guichet')->name('guichet.user.show');
	Route::get('guichet/user/engin/nouvel/{i}', [App\Http\Controllers\Guichet\UsagerController::class, 'nouvel_engin'])->middleware('can:guichet')->name('guichet.user.engin.nouvel');
	Route::post('guichet/user/engin/nouvel', [App\Http\Controllers\Guichet\UsagerController::class, 'post_nouvel_engin'])->middleware('can:guichet')->name('guichet.user.engin.nouvel.post');
	Route::put('guichet/user/update/{id}', [App\Http\Controllers\Guichet\UsagerController::class, 'update'])->middleware('can:guichet')->name('guichet.user.update');
	Route::get('guichet/user/ficheIndividuel/{id}', [App\Http\Controllers\Guichet\UsagerController::class, 'fiche_individuel'])->middleware('can:guichet')->name('guichet.user.ficheIndividuel');
	Route::get('guichet/user/engin/signaler/{chassie}', [App\Http\Controllers\Guichet\SignalerPerduController::class, 'declaration_de_perte'])->middleware('can:guichet')->name('guichet.user.engin.signaler_perdue');
	Route::get('guichet/user/engin/annuler/{chassie}', [App\Http\Controllers\Guichet\SignalerPerduController::class, 'annuler_declaration'])->middleware('can:guichet')->name('guichet.user.engin.annuler');
	
	Route::get('guichet/nouveau', [App\Http\Controllers\Administration\GuichetController::class, 'createShow'])->middleware('can:comptable-public')->name('guichet.create');
	Route::post('guichet/nouveau', [App\Http\Controllers\Administration\GuichetController::class, 'postCreate'])->middleware('can:comptable-public')->name('guichet.postCreate');
	Route::get('guichet/list', [App\Http\Controllers\Administration\GuichetController::class, 'index'])->middleware('can:comptable-public')->name('guichet.index');


	// Enroll routes
	Route::get('enrollement-1', [App\Http\Controllers\Guichet\EnrollController::class, 'stepOne'])->middleware('can:guichet')->name('enrollStepOne');
	Route::post('enrollement-1', [App\Http\Controllers\Guichet\EnrollController::class, 'postStepOne'])->middleware('can:guichet')->name('postStepOne');
	Route::get('enrollement-2/{user_id}', [App\Http\Controllers\Guichet\EnrollController::class, 'stepTwo'])->middleware('can:guichet')->name('enrollStepTwo');
	Route::post('enrollement-2', [App\Http\Controllers\Guichet\EnrollController::class, 'postStepTwo'])->middleware('can:guichet')->name('postStepTwo');

	Route::get('enrollList', [App\Http\Controllers\Guichet\EnrollController::class, 'enrollList'])->middleware('can:guichet')->name('enrollList');
	Route::get('enrolls', [App\Http\Controllers\Guichet\EnrollController::class, 'index'])->middleware('can:intern')->name('enroll.index');
	Route::get('csv-list', [App\Http\Controllers\Guichet\SalesController::class, 'csv_print_list'])->middleware('can:guichet')->name('csv.list');
	Route::get('csv/{enginId}', [App\Http\Controllers\Guichet\SalesController::class, 'csv'])->middleware('can:guichet')->name('csv');



	// Sales routes
	Route::get('sales/index', [App\Http\Controllers\Guichet\SalesController::class, 'pendingSales'])->middleware('can:guichet')->name('pendingSales');
	Route::get('sales/checkout/{enginId}', [App\Http\Controllers\Guichet\SalesController::class, 'stepOne'])->middleware('can:guichet')->name('salesStepOne');
	Route::post('sales/checkout/process', [App\Http\Controllers\Guichet\SalesController::class, 'stepTwo'])->middleware('can:guichet')->name('salesStepTwo');
	Route::get('sales/history', [App\Http\Controllers\Guichet\SalesController::class, 'salesHistory'])->middleware('can:intern')->name('salesHistory');
	Route::post('sales/history', [App\Http\Controllers\Guichet\SalesController::class, 'salesHistoryPost'])->middleware('can:intern')->name('salesHistorypost');
	Route::get('sales/report', [App\Http\Controllers\Guichet\SalesController::class, 'salesReport'])->middleware('can:regisseur-public')->name('salesReport');
	Route::get('sales/reportFilter/{}', [App\Http\Controllers\Guichet\SalesController::class, 'salesReportFilter'])->middleware('can:intern')->name('salesReportFilter');
	Route::any('sales/checkout/notify', [App\Http\Controllers\PaymentController::class, 'notify'])->name('salesCheckoutNotify');
	Route::get('sales/checkout/return', [App\Http\Controllers\PaymentController::class, 'return'])->name('salesCheckoutReturn');
	

// Vignette verification routes
   Route::get('/check/{unique_id}', [App\Http\Controllers\QrCheckController::class, 'CheckQr'])->middleware('auth')->name('checkQr');

   Route::get('/ChassieCheckShow', function(){
   		return view('ChassieCheckShow');
   });

   Route::post('/checkChassie', [App\Http\Controllers\QrCheckController::class, 'ChassieCheck'])->middleware('auth')->name('ChassieCheck');

   Route::get('/payement', [App\Http\Controllers\PaymentController::class, 'checkoutShow'])->middleware('auth')->name('payement');
   Route::post('/payement', [App\Http\Controllers\PaymentController::class, 'checkout'])->middleware('auth')->name('payement');
   Route::get('/elu', [App\Http\Controllers\eluController::class, 'eluIndex'])->name('elu');


   //prevision
   Route::get('prevision', [App\Http\Controllers\PrevisionController::class, 'index'])->middleware('can:comptable-public')->name('prevision.index');
   Route::post('prevision', [App\Http\Controllers\PrevisionController::class, 'store'])->middleware('can:comptable-public')->name('prevision.store');
   Route::get('prevision/edit/{id}',[App\Http\Controllers\PrevisionController::class, 'edit'])->middleware('can:comptable-public')->name('prevision.edit');
   Route::put('prevision/update/{id}', [App\Http\Controllers\PrevisionController::class, 'update'])->middleware('can:comptable-public')->name('prevision.update');

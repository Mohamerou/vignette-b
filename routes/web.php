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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

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
	Route::get('/mesengins', [App\Http\Controllers\User\EnginsController::class, 'index'])->middleware('auth')->name('engins.index');

	Route::get('/nouvelle/vignette', [App\Http\Controllers\User\EnginsController::class, 'selectEnginType'])->middleware('auth')->name('user.selectEnginType');
	Route::get('/nouvelle/vignette/{type}', [App\Http\Controllers\User\EnginsController::class, 'create'])->middleware('auth')->name('user.createEngin');
	Route::post('/nouvelle/vignette', [App\Http\Controllers\User\EnginsController::class, 'store'])->middleware('auth')->name('user.storeEngin');
	Route::get('/vignettes/{enginId}/{userId}', [App\Http\Controllers\User\VignettesController::class,'demande_de_vignette'])->middleware('auth')->name('user.demande_vignette');

	Route::get('/notifications', [App\Http\Controllers\User\VignettesController::class,'notificationListing'])->middleware('auth')->name('notification.list');

	Route::get('/notifications/{notification}', [App\Http\Controllers\User\VignettesController::class,'notificationShow'])->middleware('auth')->name('notification.show');

	Route::post('qrvignette/{qr_path}', [App\Http\Controllers\User\VignettesController::class, 'downloadQr'])->middleware('auth')->name('downloadQr');

	Route::post('/declaration/{user}/{vignette}/{engin}', [App\Http\Controllers\User\VignettesController::class,  'declaration_de_perte'])->middleware('auth')->name('declaration_de_perte');

	Route::post('/annuler_declaration/{user}/{vignette}/{engin}', [App\Http\Controllers\User\VignettesController::class,  'annuler_declaration'])->middleware('auth')->name('annuler_declaration');

	Route::post('/renouveller_vignette/{user}/{vignette}/{engin}', [App\Http\Controllers\User\VignettesController::class, 'renouveller_vignette'])->middleware('auth')->name('renouveller_vignette');




	// 	Administration Routes
	Route::get('/super', [App\Http\Controllers\Administration\SuperAdminController::class, 'index'])->middleware('auth')->name("superadmin.index");
	Route::get('/super/create', [App\Http\Controllers\Administration\SuperAdminController::class, 'create'])->middleware('auth')->name("superadmin.create");
	Route::get('/super/edit/{id}', [App\Http\Controllers\Administration\SuperAdminController::class, 'edit'])->middleware('auth')->name("superadmin.edit");
	Route::put('/super/update/{id}', [App\Http\Controllers\Administration\SuperAdminController::class, 'update'])->middleware('auth')->name("superadmin.update");
	Route::post('/super/create', [App\Http\Controllers\Administration\SuperAdminController::class, 'store'])->middleware('auth')->name("superadmin.store");
	Route::delete('/super/delete/{id}', [App\Http\Controllers\Administration\SuperAdminController::class, 'destroy'])->middleware('auth')->name("superadmin.destroy");

	Route::get('/adminsh', [App\Http\Controllers\AuthController::class, 'admin_login'])->name("get_admin_login");
	Route::get('/admin-dashboard', [App\Http\Controllers\AuthController::class, 'adminDashboard'])->middleware('auth')->name("get_admin_dash");
	Route::get('/examiner/{usagerId}/{enginId}/{notificationId}/{demandeTrackId}', [App\Http\Controllers\Administration\GestionVignettesController::class, 'examinerDemande'])->middleware('auth')->name('examinerDemande');
	Route::post('/ikvUE-validation/{enginId}/{notificationId}/{usager}/{demandeTrackId}', [App\Http\Controllers\Administration\GestionVignettesController::class, 'demandeValidation'])->middleware('auth')->name('validerDemande');

	Route::get('/nouveau-agent', [App\Http\Controllers\Administration\AgentController::class, 'createShow'])->middleware('auth')->name("agent.create");
	Route::post('/nouveau-agent', [App\Http\Controllers\Administration\AgentController::class, 'store'])->middleware('auth')->name("agent.store");
	Route::get('/agents', [App\Http\Controllers\Administration\AgentController::class, 'index'])->middleware('auth')->name("agent.index");
	Route::get('/agent/edit/{id}', [App\Http\Controllers\Administration\AgentController::class, 'edit'])->middleware('auth')->name("agent.edit");
	Route::put('/agent/update/{id}', [App\Http\Controllers\Administration\AgentController::class, 'update'])->middleware('auth')->name("agent.update");
	Route::delete('/agent/delete/{id}', [App\Http\Controllers\Administration\AgentController::class, 'destroy'])->middleware('auth')->name("agent.destroy");


	Route::get('/enrollHistory', [App\Http\Controllers\Administration\HistoryController::class, 'enrollHistory'])->middleware('auth')->name("enrollHistory");



	// Guichet Routes
	Route::get('guichet/nouveau', [App\Http\Controllers\Administration\GuichetController::class, 'createShow'])->middleware('auth')->name('guichet.create');
	Route::post('guichet/nouveau', [App\Http\Controllers\Administration\GuichetController::class, 'postCreate'])->middleware('auth')->name('guichet.postCreate');
	Route::get('guichet/list', [App\Http\Controllers\Administration\GuichetController::class, 'index'])->middleware('auth')->name('guichet.index');


	// Enroll routes
	Route::get('enrollement-1', [App\Http\Controllers\Guichet\EnrollController::class, 'stepOne'])->middleware('auth')->name('enrollStepOne');
	Route::post('enrollement-1', [App\Http\Controllers\Guichet\EnrollController::class, 'postStepOne'])->middleware('auth')->name('postStepOne');
	Route::get('enrollement-2/{user_id}', [App\Http\Controllers\Guichet\EnrollController::class, 'stepTwo'])->middleware('auth')->name('enrollStepTwo');
	Route::get('entrepriseList/{user_id}', [App\Http\Controllers\Guichet\EnrollController::class, 'stepTwo'])->middleware('auth')->name('entrepriseList');
	Route::post('enrollement-2', [App\Http\Controllers\Guichet\EnrollController::class, 'postStepTwo'])->middleware('auth')->name('postStepTwo');
	Route::post('entrepriseList', [App\Http\Controllers\Guichet\EnrollController::class, 'postStepTwo'])->middleware('auth')->name('entrepriseList');

	Route::get('enrollList', [App\Http\Controllers\Guichet\EnrollController::class, 'enrollList'])->middleware('auth')->name('enrollList');
	Route::get('enrolls', [App\Http\Controllers\Guichet\EnrollController::class, 'index'])->middleware('auth')->name('enroll.index');
	Route::get('csv-list', [App\Http\Controllers\Guichet\SalesController::class, 'csv_print_list'])->middleware('auth')->name('csv.list');
	Route::get('csv/{enginId}', [App\Http\Controllers\Guichet\SalesController::class, 'csv'])->middleware('auth')->name('csv');



	// Sales routes
	Route::get('sales/index', [App\Http\Controllers\Guichet\SalesController::class, 'pendingSales'])->middleware('auth')->name('pendingSales');
	Route::get('sales/checkout/{enginId}', [App\Http\Controllers\Guichet\SalesController::class, 'stepOne'])->middleware('auth')->name('salesStepOne');
	Route::post('sales/checkout/process', [App\Http\Controllers\Guichet\SalesController::class, 'stepTwo'])->middleware('auth')->name('salesStepTwo');
	Route::get('sales/history', [App\Http\Controllers\Guichet\SalesController::class, 'salesHistory'])->middleware('auth')->name('salesHistory');
	Route::post('sales/history', [App\Http\Controllers\Guichet\SalesController::class, 'salesHistoryPost'])->middleware('auth')->name('salesHistorypost');
	Route::get('sales/report', [App\Http\Controllers\Guichet\SalesController::class, 'salesReport'])->middleware('auth')->name('salesReport');
	Route::get('sales/reportFilter/{}', [App\Http\Controllers\Guichet\SalesController::class, 'salesReportFilter'])->middleware('auth')->name('salesReportFilter');
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
   Route::get('prevision', [App\Http\Controllers\PrevisionController::class, 'index'])->name('prevision.index');
   Route::post('prevision', [App\Http\Controllers\PrevisionController::class, 'store'])->name('prevision.store');
   Route::get('prevision/edit/{id}',[App\Http\Controllers\PrevisionController::class, 'edit'])->name('prevision.edit');
   Route::put('prevision/update/{id}', [App\Http\Controllers\PrevisionController::class, 'update'])->name('prevision.update');

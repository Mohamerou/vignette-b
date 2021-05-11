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
Route::get('/inscription', [App\Http\Controllers\AuthController::class, 'register'])->name('inscription');
Route::post('/inscription', [App\Http\Controllers\AuthController::class, 'postRegister'])->name('postInscription');
Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('deconnexion');

Route::get('/password/resetter/{query}', [App\Http\Controllers\PasswordResetController::class, 'resetter'])->name('resetter');

Route::get('/verify/{phone}', [App\Http\Controllers\VerificationController::class, 'registrationShow'])->name('verify');
Route::post('/post-verify', [App\Http\Controllers\VerificationController::class, 'registration'])->name('post-verify');
Route::get('/resend-code/{phone}', [App\Http\Controllers\VerificationController::class, 'resend_code'])->name('resend_code');






//User actions
	Route::get('/mesengins', [App\Http\Controllers\User\EnginsController::class, 'index'])->name('engins.index');

	Route::get('/nouvelle/vignette', [App\Http\Controllers\User\EnginsController::class, 'selectEnginType'])->name('user.selectEnginType');
	Route::get('/nouvelle/vignette/{type}', [App\Http\Controllers\User\EnginsController::class, 'create'])->name('user.createEngin');
	Route::post('/nouvelle/vignette', [App\Http\Controllers\User\EnginsController::class, 'store'])->name('user.storeEngin');
	Route::get('/vignettes/{enginId}/{userId}', [App\Http\Controllers\User\VignettesController::class,'demande_de_vignette'])->name('user.demande_vignette');

	Route::get('/notifications', [App\Http\Controllers\User\VignettesController::class,'notificationListing'])->name('notification.list');

	Route::get('/notifications/{notification}', [App\Http\Controllers\User\VignettesController::class,'notificationShow'])->name('notification.show');

	Route::post('qrvignette/{qr_path}', [App\Http\Controllers\User\VignettesController::class, 'downloadQr'])->name('downloadQr');

	Route::post('/declaration/{user}/{vignette}/{engin}', [App\Http\Controllers\User\VignettesController::class,  'declaration_de_perte'])->name('declaration_de_perte');

	Route::post('/annuler_declaration/{user}/{vignette}/{engin}', [App\Http\Controllers\User\VignettesController::class,  'annuler_declaration'])->name('annuler_declaration');

	Route::post('/renouveller_vignette/{user}/{vignette}/{engin}', [App\Http\Controllers\User\VignettesController::class, 'renouveller_vignette'])->name('renouveller_vignette');
	//Admin Routes
	Route::get('/examiner/{usagerId}/{enginId}/{notificationId}/{demandeTrackId}', [App\Http\Controllers\Admin\GestionVignettesController::class, 'examinerDemande'])->name('examinerDemande');
	Route::post('/ikvUE-validation/{enginId}/{notificationId}/{usager}/{demandeTrackId}', [App\Http\Controllers\Admin\GestionVignettesController::class, 'demandeValidation'])->name('validerDemande');



// Vignette verification routes
   Route::get('/check/{unique_id}', [App\Http\Controllers\QrCheckController::class, 'CheckQr'])->name('checkQr');

   Route::get('/ChassieCheckShow', function(){
   		return view('ChassieCheckShow');
   });

   Route::post('/checkChassie', [App\Http\Controllers\QrCheckController::class, 'ChassieCheck'])->name('ChassieCheck');

   Route::get('/payement', [App\Http\Controllers\PaymentController::class, 'checkoutShow'])->name('payement');
   Route::post('/payement', [App\Http\Controllers\PaymentController::class, 'checkout'])->name('payement');
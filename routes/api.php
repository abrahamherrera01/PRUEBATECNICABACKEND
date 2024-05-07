<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// servicio para Address
Route::resource('address', App\Http\Controllers\AddressController::class, [
    'only' => ['index','store','update','destroy']
]);

// servicio para email
Route::resource('email', App\Http\Controllers\EmailController::class, [
    'only' => ['index','store','update','destroy']
]);

// servicio para phone
Route::resource('phone', App\Http\Controllers\PhoneController::class, [
    'only' => ['index','store','update','destroy']
]);

// servicio para contacts
Route::resource('contact', App\Http\Controllers\ContactController::class, [
    'only' => ['index','store','update','destroy']
]);

//obtener todos los contactos con relaciones
Route::get('/getContacts', [App\Http\Controllers\ContactController::class, 'getContacts']);

//obtener todos los contactos con relaciones por id
Route::get('/getContactsbyId/{contact_id}', [App\Http\Controllers\ContactController::class, 'getContactsbyId']);

//Crear contact
Route::post('/createContact', [App\Http\Controllers\ContactController::class, 'createContact']);

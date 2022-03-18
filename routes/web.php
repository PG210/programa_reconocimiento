<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Usuarios\Inicio; //controlador al cual se apunta "administracion"
use App\Http\Controllers\Usuarios\Perfil; //controlador al cual se apunta "administracion"
use App\Http\Controllers\Inisignias\InsigniasController;
use App\Http\Controllers\Inisignias\CategoriasController;
use App\Http\Controllers\Reconocimientos\ReconocimientosController;

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
    return view('inicio');
});
Route::get('/reg', function () {
    return view('prueba');
});
Route::get('/for', function () {
    return view('formulario');
});
Route::get('/dashboard', function () {
    return view('usuario.principa_usul');
})->middleware(['auth'])->name('dashboard');

Route::get('/inicio', [Inicio::class, 'index'])->name('inicio');

Route::get('/perfil', [Perfil::class, 'index'])->name('perfil');

Route::get('/insignia/registro', [InsigniasController::class, 'registrar'])->name('reg_insignia');

Route::get('/Categorias/registro', [CategoriasController::class, 'registrar'])->name('reg_categ');

Route::post('/Categorias/registro', [CategoriasController::class, 'regis_cat'])->name('regcategorias');

Route::get('/reconocimientos/enviar', [ReconocimientosController::class, 'enviar'])->name('enviar');

Route::get('/premios/reg', [InsigniasController::class, 'premios'])->name('premios_vis');

Route::get('/registro/insignias', [InsigniasController::class, 'insignia'])->name('insignia');


Route::post('/insignia/registro', [InsigniasController::class, 'reginsig'])->name('reginsignias');



require __DIR__.'/auth.php';

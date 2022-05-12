<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Usuarios\Inicio; //controlador al cual se apunta "administracion"
use App\Http\Controllers\Usuarios\Perfil; //controlador al cual se apunta "administracion"
use App\Http\Controllers\Inisignias\InsigniasController;
use App\Http\Controllers\Inisignias\CategoriasController;
use App\Http\Controllers\Reconocimientos\ReconocimientosController;
use App\Http\Controllers\ImagenesController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\EmpresaController\AreasController;
use App\Http\Controllers\FiltrarCatController\FiltrarCat;
use App\Http\Controllers\NotificacionController\Notificar;

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

//rutas de pagina princpal inicio
Route::get('/pro', function () {
    return view('qep');
});
Route::get('/reconocimientos', function () {
    return view('reconocimientos');
});
Route::get('/contacto', function () {
    return view('contacto');
});
//end rutas principal

Route::get('/dashboard', function () {
    return view('usuario.inicio');
})->middleware(['auth'])->name('dashboard');

Route::get('/inicio', [Inicio::class, 'index'])->name('inicio');

Route::get('/perfil', [Perfil::class, 'index'])->name('perfil');
Route::get('/perfil/actualizar', [Perfil::class, 'editar'])->name('usuarioeditar');
Route::post('/perfil/actualizar', [Perfil::class, 'guardar'])->name('datosper');


Route::get('/reconocimientos/enviar', [ReconocimientosController::class, 'enviar'])->middleware(['auth'])->name('enviar');

Route::get('/insignia/registro', [InsigniasController::class, 'registrar'])->middleware(['auth', 'admin'])->name('reg_insignia');

Route::get('/Categorias/registro', [CategoriasController::class, 'registrar'])->middleware(['auth', 'admin'])->name('reg_categ');

Route::post('/Categorias/registro', [CategoriasController::class, 'regis_cat'])->middleware(['auth', 'admin'])->name('regcategorias');

Route::get('/premios/reg', [InsigniasController::class, 'premios'])->middleware(['auth', 'admin'])->name('premios_vis');

Route::get('/registro/insignias', [InsigniasController::class, 'insignia'])->middleware(['auth', 'admin'])->name('insignia');

Route::post('/insignia/registro', [InsigniasController::class, 'reginsig'])->middleware(['auth', 'admin'])->name('reginsignias');

Route::get('/registro/imagenes', [ImagenesController::class, 'registro'])->middleware(['auth', 'admin'])->name('imagenes');

Route::post('/registro/imagenes', [ImagenesController::class, 'regimagen'])->middleware(['auth', 'admin'])->name('ingresardat');

Route::post('/registro/premio', [ImagenesController::class, 'regpre'])->middleware(['auth', 'admin'])->name('regpremio');

Route::post('/insignia/registro/admin', [InsigniasController::class, 'registroinsignia'])->middleware(['auth', 'admin'])->name('registroinsignias');

//actualizar categoria insignias
Route::get('/actualizar/categorias/{id}', [CategoriasController::class, 'buscaractu'])->middleware(['auth', 'admin'])->name('formactucat');
Route::post('/actualizar/cambios/{id}', [CategoriasController::class, 'actucat'])->middleware(['auth', 'admin'])->name('actualizarcat');


//buscar
//Route::get('posts',[PostController::class, 'index'])->name('posts.index');
Route::get('posts/search',[PostController::class, 'search'])->name('posts.search');
Route::get('posts/show',[PostController::class, 'show'])->name('posts.show');

//reporte insignias enviadas usuario 
Route::get('/reporte/insignias',[ReconocimientosController::class, 'reporteinsig'])->name('reporteinsignias');

//ruta reconocimiento
Route::get('/reconocimientos/listar', [ReconocimientosController::class, 'reporte_reconocimiento'])->name('reporte_re');
Route::get('/reconocimientos/usuario/{id}', [ReconocimientosController::class, 'listarrec'])->name('listareconocer');


//envia reconocimiento de categoria
Route::post('/enviar/recono/categoria', [ReconocimientosController::class, 'recocatguardar'])->middleware(['auth'])->name('envrecat');

//filtrar categoria
Route::post('/filtrar/categoria/comportamiento', [FiltrarCat::class, 'filtrar'])->middleware(['auth'])->name('filtrarcat');
//filtrar comportamiento
Route::post('/filtrar/comportamiento', [FiltrarCat::class, 'comportamiento'])->middleware(['auth'])->name('filtrarcomport');

//eliminar categoria
Route::get('/eliminar/categoria/{id}', [CategoriasController::class, 'eliminar'])->middleware(['auth', 'admin'])->name('eliminarcat');


//actualizar categoria
Route::get('/actualizar/categoria/{id}', [CategoriasController::class, 'busactualizar'])->middleware(['auth', 'admin'])->name('actualizarcate');
Route::post('/actualizar/categoria/{id}', [CategoriasController::class, 'actualizar'])->middleware(['auth', 'admin'])->name('guarcategoria');
//areas de la empresa
Route::get('/areas/empresa', [AreasController::class, 'index'])->middleware(['auth', 'admin'])->name('areas');
Route::post('/areas/empresa', [AreasController::class, 'registrar'])->middleware(['auth', 'admin'])->name('guardararea');
Route::get('/eliminar/area/{id}', [AreasController::class, 'eliminar'])->middleware(['auth', 'admin']);
Route::post('/consultar/area', [AreasController::class, 'consultar'])->middleware(['auth', 'admin'])->name('consultararea');
//cargos
Route::get('/cargo/view', [AreasController::class, 'vistacar'])->middleware(['auth', 'admin'])->name('vistacargo');
Route::post('/registrar/cargo', [AreasController::class, 'regcargo'])->middleware(['auth', 'admin'])->name('guardarcargo');
Route::get('/cargo/eliminar/{id}', [AreasController::class, 'elimcargo'])->middleware(['auth', 'admin'])->name('eliminarcargo');
Route::post('/actualizar/cargo', [AreasController::class, 'cargoactu'])->middleware(['auth', 'admin'])->name('actualizarcargo');

//

Route::get('/reporte/usuarios', [Inicio::class, 'visualizar'])->middleware(['auth', 'admin'])->name('reporteusuarios');
Route::get('/users/estado/{id}', [Inicio::class, 'estado'])->middleware(['auth', 'admin'])->name('cambiarestado');
Route::get('/users/actualizar/{id}', [Inicio::class, 'actualizar'])->middleware(['auth', 'admin'])->name('actualizaruser');
Route::post('/users/actualizar', [Inicio::class, 'regdatos'])->middleware(['auth', 'admin'])->name('actudatos');
//
//notificaciones cambiar estado
Route::get('notificacion/estado/{id}', [Notificar::class, 'estado'])->name('notificaciones');

require __DIR__.'/auth.php';

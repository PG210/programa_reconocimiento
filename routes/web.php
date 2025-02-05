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
use App\Http\Controllers\Reportes;
use App\Http\Controllers\JefesController\Jefescon;
use App\Http\Controllers\VotacionController\VotacionControl;
use App\Http\Controllers\ImportacionController\Importacion;
use App\Http\Controllers\MensajesController\MensajesControl;
use App\Http\Controllers\Comunicacion\ComunicacionController; //ruta para comunicacion
use App\Http\Controllers\MailController;

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

Route::get('/inicio/prueba', function () {
    return view('pagina_inicio');
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

//ruta para retornar al dahboard
Route::get('/dashboard', [Inicio::class, 'dash'])->middleware(['auth'])->name('dashboard');

Route::get('/inicio', [Inicio::class, 'index'])->middleware(['auth'])->name('inicio');

Route::get('/perfil', [Perfil::class, 'index'])->middleware(['auth'])->name('perfil');
Route::get('/perfil/actualizar', [Perfil::class, 'editar'])->middleware(['auth'])->name('usuarioeditar');
Route::post('/perfil/actualizar', [Perfil::class, 'guardar'])->middleware(['auth'])->name('datosper');


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
Route::get('/delete/comportamiento/{id}', [CategoriasController::class, 'deleteCom'])->middleware(['auth', 'admin'])->name('deleteCom');
//buscar
//Route::get('posts',[PostController::class, 'index'])->name('posts.index');
Route::get('posts/search',[PostController::class, 'search'])->name('posts.search')->middleware(['auth']);
Route::get('posts/show',[PostController::class, 'show'])->name('posts.show')->middleware(['auth']);

//reporte insignias enviadas usuario 
Route::get('/reporte/insignias',[ReconocimientosController::class, 'reporteinsig'])->middleware(['auth'])->name('reporteinsignias');
//filltrar reconocimietos 
Route::post('/reporte/insignias/filter',[ReconocimientosController::class, 'filtrarReconocimientos'])->middleware(['auth'])->name('filtrarReconocimientos');

//ruta reconocimiento
Route::get('/reconocimientos/listar', [ReconocimientosController::class, 'reporte_reconocimiento'])->middleware(['auth'])->name('reporte_re');
Route::get('/reconocimientos/usuario', [ReconocimientosController::class, 'listarrec'])->middleware(['auth'])->name('listareconocer');


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
Route::post('/areas/empresa/licencias', [AreasController::class, 'reglicencias'])->middleware(['auth', 'admin'])->name('reglicencias');
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
//registrar usuario individual
Route::post('/admin/add/user', [Inicio::class, 'addUser'])->middleware(['auth', 'admin'])->name('addUser');
//=========================== grupos de usuarios =========================================
Route::get('/users/grupos', [Inicio::class, 'vistaGrupos'])->middleware(['auth', 'admin'])->name('vistaGrupos');
Route::post('/users/nuevo/grupo', [Inicio::class, 'nuevoGrupo'])->middleware(['auth', 'admin'])->name('nuevoGrupo');
Route::post('/users/update/grupo', [Inicio::class, 'actuGrupo'])->middleware(['auth', 'admin'])->name('actuGrupo');
Route::post('/users/delete/grupo/{id}', [Inicio::class, 'deleteGrupo'])->middleware(['auth', 'admin'])->name('deleteGrupo');
Route::post('/grupo/users/{id}', [Inicio::class, 'grupUser'])->middleware(['auth', 'admin'])->name('grupUser');

#========================= metricas ========================================
Route::get('/grupo/metricas/{id}', [Inicio::class, 'metricas'])->middleware(['auth', 'admin'])->name('metricas');
Route::post('/update/puntos', [InsigniasController::class, 'modpuntos'])->middleware(['auth', 'admin'])->name('modpuntos');

//notificaciones cambiar estado
Route::get('notificacion/estado/{id}', [Notificar::class, 'estado'])->middleware(['auth'])->name('notificaciones');
//eliminar notificacion
Route::get('notificacion/eliminar/{id}', [Notificar::class, 'eliminar'])->middleware(['auth']);
//leer notificacion de insignias
Route::get('notificacion/insignia/estado/{id}', [Notificar::class, 'leer'])->middleware(['auth']);
Route::get('notificacion/eliminar/insignia/{id}', [Notificar::class, 'elimarinsig'])->middleware(['auth']);

Route::get('notificacion/vista/correo', [Notificar::class, 'correo']);

//vista reporte para jefes
Route::get('/reporte/recompensas', [Reportes::class, 'index'])->middleware(['auth', 'jefe'])->name('recompensas_obtenidas');
Route::get('/entregar/{id}', [Reportes::class, 'cambiar_estado'])->middleware(['auth', 'jefe'])->name('entregar');
Route::get('/listado/entregados', [Reportes::class, 'consultar_entregados'])->middleware(['auth', 'jefe'])->name('entregados');

//aqui reporte de insignias_con recompensas
Route::get('/reporte/insignias/excel/{id}', [Reportes::class, 'reporte_recompensas'])->middleware(['auth', 'jefe']);

//vincular jefes para reportes
Route::get('/admin/vincular/jefes', [Jefescon::class, 'index'])->middleware(['auth', 'admin'])->name('vincular_jefes');
Route::post('/admin/vincular/jefes', [Jefescon::class, 'registrar'])->middleware(['auth', 'admin'])->name('vinjefes');
Route::get('/eliminar/jefes/{id}', [Jefescon::class, 'eliminar'])->middleware(['auth', 'admin']);

//informe gerente
Route::get('/gerente/informe/{id}', [Jefescon::class, 'vista_gen'])->middleware(['auth', 'gerente'])->name('informe_gerente');
Route::get('/gerente/insignias/excel/{id}', [Jefescon::class, 'gerente_excel'])->middleware(['auth', 'gerente']);

//visualizar insignias que pueden ganar
Route::get('/reporte/visualizar/recompensas', [InsigniasController::class, 'reporte'])->middleware(['auth'])->name('visinsignias');

//buscar un usuario

Route::post('/buscar/usuario', [PostController::class, 'buscar'])->middleware(['auth'])->name('buscar_usuario');

//votacion habilitar
Route::get('/admin/votacion', [VotacionControl::class, 'habilitar'])->middleware(['auth'])->name('habilitar_votacion');
Route::post('/admin/hab/votacion', [VotacionControl::class, 'hab_votacion'])->middleware(['auth'])->name('hab_votaciones');
Route::get('/vista/votacion', [VotacionControl::class, 'vista_user'])->middleware(['auth'])->name('votacion_user');
Route::post('/votacion/buscar/usuario', [VotacionControl::class, 'buscar'])->middleware(['auth'])->name('buscar_votante');
Route::post('/votacion/registrar', [VotacionControl::class, 'registrar'])->middleware(['auth'])->name('regvoto');
Route::get('/deshab/votacion/{id}/{val}', [VotacionControl::class, 'desvot'])->middleware(['auth']);
Route::post('/filtrar/votos', [VotacionControl::class, 'filtrar'])->middleware(['auth'])->name('filtrarVotos');
Route::post('/votos/categoria', [VotacionControl::class, 'categoria'])->middleware(['auth'])->name('listaVot');
//importar usuarios
Route::post('/admin/importar/usuarios', [Importacion::class, 'archivoimpor'])->middleware(['auth', 'admin'])->name('usuariosImport');

//mensajes envio
Route::get('/mensajes', [MensajesControl::class, 'vista'])->middleware(['auth'])->name('vistamensajes');

//eliminar premio
Route::get('/eliminar/premio/{id}', [InsigniasController::class, 'elimpremios'])->name('eliminarpremio')->middleware(['auth', 'admin']);
Route::get('/actualizar/premio/{id}', [InsigniasController::class, 'actualizarpre'])->name('actualizarpremio')->middleware(['auth', 'admin']);
Route::post('/actualizar/premio/form/{id}', [InsigniasController::class, 'actupremion'])->middleware(['auth', 'admin'])->name('regpremioactu');

//actualizar insignias
Route::get('/actualizar/insignias/{id}', [InsigniasController::class, 'vistainsig'])->name('actualizarinsignia')->middleware(['auth', 'admin']);
// delete insignias 
Route::get('/delete/insignias/{id}', [InsigniasController::class, 'deleteinsig'])->name('deleteinsignia')->middleware(['auth', 'admin']);
Route::post('/actualizar/insignias/datos/{id}', [InsigniasController::class, 'formactuinsig'])->name('registroinsigniasactu')->middleware(['auth', 'admin']);

//================== metricas =======================================
Route::get('/metricas/ranking', [ReconocimientosController::class, 'metricasranking'])->name('metricasranking')->middleware(['auth']);
Route::get('/metricas/ranking/user', [ReconocimientosController::class, 'metricasusers'])->name('metricasusers')->middleware(['auth']);

//===================reconocimientos enviados =======================
Route::get('/reconocimientos/enviados', [ReconocimientosController::class, 'recenviados'])->name('recenviados')->middleware(['auth']);
Route::get('/reconocimientos/enviados/admin', [ReconocimientosController::class, 'metricasEnvio'])->name('metricasEnvio')->middleware(['auth']);

//============= reacciones ============
Route::get('/reacciones', [Inicio::class, 'reacciones'])->name('reacciones')->middleware(['auth']);
Route::get('/reacciones/holidays', [Inicio::class, 'reaccionesaniv'])->name('reaccionesaniv')->middleware(['auth']);
//============= comentario  ============
Route::any('/comentario', [Inicio::class, 'comentario'])->name('comentario')->middleware(['auth']);
//============ comentarios para holidays =======
Route::post('/comentario/holidays', [Inicio::class, 'comentariosholdays'])->middleware(['auth']);

Route::get('/correo/not', function () {
    return view('correos.reconocimiento');
});

//================== reporte de votaciones =========
Route::post('/download/votos', [VotacionControl::class, 'excelVotos'])->name('excelVotos')->middleware(['auth']);
Route::post('/postular/usuarios', [VotacionControl::class, 'postularVot'])->name('postularVot')->middleware(['auth']);

//=========== comunicaciones ===========================
// Ruta para el controlador de recursos, esto maneja las rutas index, store, show, edit, update, destroy
Route::resource('comunicacion', ComunicacionController::class)->middleware(['auth']);
// ruta para publicar
Route::get('/publicar', [ComunicacionController::class, 'publicar'])->name('publicar')->middleware(['auth']);

require __DIR__.'/auth.php';

// eliminar usuario
Route::get('/users/delete/{id}', [Inicio::class, 'eliminaruser'])->middleware(['auth', 'admin'])->name('eliminaruser');

//================== manejo de correo microsoft =================0
Route::get('/redirect-to-microsoft', [MailController::class, 'redirectToMicrosoft']);
Route::get('/oauth/callback', [MailController::class, 'handleMicrosoftCallback']);
Route::post('/send-mail', [MailController::class, 'sendMail']);

//=================== manejo de eventos ==============
Route::get('/empresa/eventos', [AreasController::class, 'eventos'])->middleware(['auth', 'admin'])->name('eventos');
Route::post('/empresa/eventos/happy', [AreasController::class, 'happybirthday'])->middleware(['auth', 'admin'])->name('happybirthday');
Route::post('/empresa/eventos/antique', [AreasController::class, 'antique'])->middleware(['auth', 'admin'])->name('antique');
Route::get('/empresa/eventos/{id}', [AreasController::class, 'deletevento'])->middleware(['auth', 'admin'])->name('deletevento');
Route::post('/empresa/eventos/active', [AreasController::class, 'activeCumple'])->middleware(['auth', 'admin'])->name('activeCumple');

//======================== download excel ======
Route::post('/download/excel/appreciation', [ReconocimientosController::class, 'downloadGet'])->middleware(['auth'])->name('downloadGet');
Route::post('/download/excel/give', [ReconocimientosController::class, 'downloadgive'])->middleware(['auth'])->name('downloadgive');
Route::post('/download/excel/puntos', [ReconocimientosController::class, 'downloadPuntos'])->middleware(['auth'])->name('downloadPuntos');

//======================= filtros para metricas ==================
Route::post('/filter/reconocimiento', [ReconocimientosController::class, 'filterReconocimientoTotal'])->middleware(['auth'])->name('filterReconocimientoTotal');
Route::post('/filter/reconocimiento/enviado', [ReconocimientosController::class, 'filterReconocimientoEnviadoTotal'])->middleware(['auth'])->name('filterReconocimientoEnviadoTotal');
//========================= metricas de puntos ==========================
Route::get('/metricas/puntos', [ReconocimientosController::class, 'metricasPuntos'])->middleware(['auth'])->name('metricasPuntos');
Route::post('/filter/puntos', [ReconocimientosController::class, 'filterPuntos'])->middleware(['auth'])->name('filterPuntos');

Route::get('/forprueba', function () {
    return view('formprueba');
});
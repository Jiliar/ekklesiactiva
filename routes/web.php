<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|


Route::get('/', function () {
    return view('welcome');
});*/


Route::get('login',                           'App\Http\Controllers\AuthUsuarioController@showLogin');
Route::get('register',                        'App\Http\Controllers\AuthUsuarioController@showRegistrar');
Route::post('register',                       'App\Http\Controllers\AuthUsuarioController@registrarUsuario');
Route::get('reset/{xid}',                     'App\Http\Controllers\AuthUsuarioController@resetUsuario');
Route::post('reset/pass',                     'App\Http\Controllers\AuthUsuarioController@resetPassword');
Route::post('login',                          'App\Http\Controllers\AuthUsuarioController@login');
Route::get('login',                           'App\Http\Controllers\AuthUsuarioController@showLogin');
Route::get('confirmacion/{xid}',              'App\Http\Controllers\AuthUsuarioController@confirmacion');
Route::get('/',                               'App\Http\Controllers\AuthUsuarioController@valida');
Route::get('inicio',                          'App\Http\Controllers\AuthUsuarioController@inicio');
Route::get('submenu/{usuario}/{idappdet}',    'App\Http\Controllers\AuthUsuarioController@submenu');
Route::get('menu/{usuario}',                  'App\Http\Controllers\AuthUsuarioController@menu');
Route::post('form_logic_restaurar_password', 'App\Http\Controllers\AuthUsuarioController@restorepassword');

Route::post('form_send_mail', 'App\Http\Controllers\NotificacionesController@notificaciones');
Route::post('form_logic_restaurar_password', 'App\Http\Controllers\AuthUsuarioController@restorepassword');
Route::get('form_logic_envia_notificaciones_table', 'App\Http\Controllers\NotificacionesController@getNotificacionesTable');
Route::post('form_send_reestablecer', 'App\Http\Controllers\NotificacionesController@reestablecer');

Route::post('/rsave_data_entidad', 'App\Http\Controllers\EntidadController@save');
Route::delete('/rdelete_data_entidad', 'App\Http\Controllers\EntidadController@deleteModuloData');
Route::get('/rpdf', 'ReportePDFController@generarpdf');

//Exportar XLSX
Route::get('/rexportarxlsx', 'ExportXLSController@init');
Route::delete('/rdeletexlsx', 'ExportXLSController@delete');

/* Route::get('conf/{proceso}', 'ConfiguracionController@index'); */
Route::get('cerrarSesion',   'App\Http\Controllers\AuthUsuarioController@cerrarSesion');
Route::get('/token/{token}',  'App\Http\Controllers\AuthUsuarioController@login');
Route::get('vistas','App\Http\Controllers\ScreenController@vistas');



Route::get('form_auth_usuarios_one', 'App\Http\Controllers\AuthUsuarioController@find');
Route::get('form_auth_usuarios', 'App\Http\Controllers\AuthUsuarioController@list');
Route::post('form_auth_usuarios', 'App\Http\Controllers\AuthUsuarioController@save');
Route::put('form_auth_usuarios', 'App\Http\Controllers\AuthUsuarioController@edit');
Route::delete('form_auth_usuarios', 'App\Http\Controllers\AuthUsuarioController@remove');

Route::get('form_auth_perfiles_one', 'App\Http\Controllers\AuthPerfilController@find');
Route::get('form_auth_perfiles', 'App\Http\Controllers\AuthPerfilController@list');
Route::post('form_auth_perfiles', 'App\Http\Controllers\AuthPerfilController@save');
Route::put('form_auth_perfiles', 'App\Http\Controllers\AuthPerfilController@edit');
Route::delete('form_auth_perfiles', 'App\Http\Controllers\AuthPerfilController@remove');

Route::get('form_auth_tipos_id_one', 'App\Http\Controllers\AuthTipoIdController@find');
Route::get('form_auth_tipos_id', 'App\Http\Controllers\AuthTipoIdController@list');
Route::post('form_auth_tipos_id', 'App\Http\Controllers\AuthTipoIdController@save');
Route::put('form_auth_tipos_id', 'App\Http\Controllers\AuthTipoIdController@edit');
Route::delete('form_auth_tipos_id', 'App\Http\Controllers\AuthTipoIdController@remove');

Route::get('form_logic_ministerios_one', 'App\Http\Controllers\LogicMinisterioController@find');
Route::get('form_logic_ministerios', 'App\Http\Controllers\LogicMinisterioController@list');
Route::post('form_logic_ministerios', 'App\Http\Controllers\LogicMinisterioController@save');
Route::put('form_logic_ministerios', 'App\Http\Controllers\LogicMinisterioController@edit');
Route::delete('form_logic_ministerios', 'App\Http\Controllers\LogicMinisterioController@remove');

Route::get('form_logic_cargos_one', 'App\Http\Controllers\LogicCargoController@find');
Route::get('form_logic_cargos', 'App\Http\Controllers\LogicCargoController@list');
Route::post('form_logic_cargos', 'App\Http\Controllers\LogicCargoController@save');
Route::put('form_logic_cargos', 'App\Http\Controllers\LogicCargoController@edit');
Route::delete('form_logic_cargos', 'App\Http\Controllers\LogicCargoController@remove');

Route::get('form_logic_ministerios_usuarios_cargos_one', 'App\Http\Controllers\LogicMinisterioUsuarioCargoController@find');
Route::get('form_logic_ministerios_usuarios_cargos', 'App\Http\Controllers\LogicMinisterioUsuarioCargoController@list');
Route::post('form_logic_ministerios_usuarios_cargos', 'App\Http\Controllers\LogicMinisterioUsuarioCargoController@save');
Route::put('form_logic_ministerios_usuarios_cargos', 'App\Http\Controllers\LogicMinisterioUsuarioCargoController@edit');
Route::delete('form_logic_ministerios_usuarios_cargos', 'App\Http\Controllers\LogicMinisterioUsuarioCargoController@remove');

Route::get('form_logic_actividades_one', 'App\Http\Controllers\LogicActividadController@find');
Route::get('form_logic_actividades', 'App\Http\Controllers\LogicActividadController@list');
Route::post('form_logic_actividades', 'App\Http\Controllers\LogicActividadController@save');
Route::put('form_logic_actividades', 'App\Http\Controllers\LogicActividadController@edit');
Route::delete('form_logic_actividades', 'App\Http\Controllers\LogicActividadController@remove');

Route::get('form_logic_tipos_actividades_one', 'App\Http\Controllers\LogicTipoActividadController@find');
Route::get('form_logic_tipos_actividades', 'App\Http\Controllers\LogicTipoActividadController@list');
Route::post('form_logic_tipos_actividades', 'App\Http\Controllers\LogicTipoActividadController@save');
Route::put('form_logic_tipos_actividades', 'App\Http\Controllers\LogicTipoActividadController@edit');
Route::delete('form_logic_tipos_actividades', 'App\Http\Controllers\LogicTipoActividadController@remove');

Route::get('form_logic_actividades_usuarios_one', 'App\Http\Controllers\LogicActividadUsuarioController@find');
Route::get('form_logic_actividades_usuarios', 'App\Http\Controllers\LogicActividadUsuarioController@list');
Route::post('form_logic_actividades_usuarios', 'App\Http\Controllers\LogicActividadUsuarioController@save');
Route::put('form_logic_actividades_usuarios', 'App\Http\Controllers\LogicActividadUsuarioController@edit');
Route::delete('form_logic_actividades_usuarios', 'App\Http\Controllers\LogicActividadUsuarioController@remove');

Route::get('form_logic_congregaciones_one', 'App\Http\Controllers\LogicCongregacionController@find');
Route::get('form_logic_congregaciones', 'App\Http\Controllers\LogicCongregacionController@list');
Route::post('form_logic_congregaciones', 'App\Http\Controllers\LogicCongregacionController@save');
Route::put('form_logic_congregaciones', 'App\Http\Controllers\LogicCongregacionController@edit');
Route::delete('form_logic_congregaciones', 'App\Http\Controllers\LogicCongregacionController@remove');

Route::get('form_logic_concilios_one', 'App\Http\Controllers\LogicConcilioController@find');
Route::get('form_logic_concilios', 'App\Http\Controllers\LogicConcilioController@list');
Route::post('form_logic_concilios', 'App\Http\Controllers\LogicConcilioController@save');
Route::put('form_logic_concilios', 'App\Http\Controllers\LogicConcilioController@edit');
Route::delete('form_logic_concilios', 'App\Http\Controllers\LogicConcilioController@remove');

Route::get('form_logic_cms_one', 'App\Http\Controllers\LogicCmsController@find');
Route::get('form_logic_cms', 'App\Http\Controllers\LogicCmsController@list');
Route::post('form_logic_cms', 'App\Http\Controllers\LogicCmsController@save');
Route::put('form_logic_cms', 'App\Http\Controllers\LogicCmsController@edit');
Route::delete('form_logic_cms', 'App\Http\Controllers\LogicCmsController@remove');

Route::get('form_geo_countries_one', 'App\Http\Controllers\GeoCountryController@find');
Route::get('form_geo_countries', 'App\Http\Controllers\GeoCountryController@list');
Route::post('form_geo_countries', 'App\Http\Controllers\GeoCountryController@save');
Route::put('form_geo_countries', 'App\Http\Controllers\GeoCountryController@edit');
Route::delete('form_geo_countries', 'App\Http\Controllers\GeoCountryController@remove');

Route::get('form_geo_states_one', 'App\Http\Controllers\GeoStateController@find');
Route::get('form_geo_states', 'App\Http\Controllers\GeoStateController@list');
Route::post('form_geo_states', 'App\Http\Controllers\GeoStateController@save');
Route::put('form_geo_states', 'App\Http\Controllers\GeoStateController@edit');
Route::delete('form_geo_states', 'App\Http\Controllers\GeoStateController@remove');

Route::get('form_geo_cities_one', 'App\Http\Controllers\GeoCityController@find');
Route::get('form_geo_cities', 'App\Http\Controllers\GeoCityController@list');
Route::post('form_geo_cities', 'App\Http\Controllers\GeoCityController@save');
Route::put('form_geo_cities', 'App\Http\Controllers\GeoCityController@edit');
Route::delete('form_geo_cities', 'App\Http\Controllers\GeoCityController@remove');

Route::get('form_menu_items_one', 'App\Http\Controllers\MenuItemController@find');
Route::get('form_menu_items', 'App\Http\Controllers\MenuItemController@list');
Route::post('form_menu_items', 'App\Http\Controllers\MenuItemController@save');
Route::put('form_menu_items', 'App\Http\Controllers\MenuItemController@edit');
Route::delete('form_menu_items', 'App\Http\Controllers\MenuItemController@remove');

Route::get('form_menu_subitems_one', 'App\Http\Controllers\MenuSubitemController@find');
Route::get('form_menu_subitems', 'App\Http\Controllers\MenuSubitemController@list');
Route::post('form_menu_subitems', 'App\Http\Controllers\MenuSubitemController@save');
Route::put('form_menu_subitems', 'App\Http\Controllers\MenuSubitemController@edit');
Route::delete('form_menu_subitems', 'App\Http\Controllers\MenuSubitemController@remove');

Route::get('form_config_api_one', 'App\Http\Controllers\ConfigApiController@find');
Route::get('form_config_api', 'App\Http\Controllers\ConfigApiController@list');
Route::post('form_config_api', 'App\Http\Controllers\ConfigApiController@save');
Route::put('form_config_api', 'App\Http\Controllers\ConfigApiController@edit');
Route::delete('form_config_api', 'App\Http\Controllers\ConfigApiController@remove');

Route::get('form_config_componentes_formulario_one', 'App\Http\Controllers\ConfigComponentesFormularioController@find');
Route::get('form_config_componentes_formulario', 'App\Http\Controllers\ConfigComponentesFormularioController@list');
Route::post('form_config_componentes_formulario', 'App\Http\Controllers\ConfigComponentesFormularioController@save');
Route::put('form_config_componentes_formulario', 'App\Http\Controllers\ConfigComponentesFormularioController@edit');
Route::delete('form_config_componentes_formulario', 'App\Http\Controllers\ConfigComponentesFormularioController@remove');




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

Route::post('register', '\App\Http\Controllers\UserController@register');
Route::post('login', '\App\Http\Controllers\UserController@authenticate');

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::group(['middleware' => ['jwt.verify']], function() {

    Route::get('auth_usuarios', 'App\Http\Controllers\AuthUsuarioController@index');
    Route::get('auth_usuarios/{id}', 'App\Http\Controllers\AuthUsuarioController@show');
    Route::post('auth_usuarios', 'App\Http\Controllers\AuthUsuarioController@store');
    Route::put('auth_usuarios/{id}', 'App\Http\Controllers\AuthUsuarioController@update');
    Route::delete('auth_usuarios/{id}', 'App\Http\Controllers\AuthUsuarioController@delete');

    Route::get('auth_perfiles', 'App\Http\Controllers\AuthPerfilController@index');
    Route::get('auth_perfiles/{id}', 'App\Http\Controllers\AuthPerfilController@show');
    Route::post('auth_perfiles', 'App\Http\Controllers\AuthPerfilController@store');
    Route::put('auth_perfiles/{id}', 'App\Http\Controllers\AuthPerfilController@update');
    Route::delete('auth_perfiles/{id}', 'App\Http\Controllers\AuthPerfilController@delete');

    Route::get('auth_tipos_id', 'App\Http\Controllers\AuthTipoIdController@index');
    Route::get('auth_tipos_id/{id}', 'App\Http\Controllers\AuthTipoIdController@show');
    Route::post('auth_tipos_id', 'App\Http\Controllers\AuthTipoIdController@store');
    Route::put('auth_tipos_id/{id}', 'App\Http\Controllers\AuthTipoIdController@update');
    Route::delete('auth_tipos_id/{id}', 'App\Http\Controllers\AuthTipoIdController@delete');

    Route::get('logic_ministerios', 'App\Http\Controllers\LogicMinisterioController@index');
    Route::get('logic_ministerios/{id}', 'App\Http\Controllers\LogicMinisterioController@show');
    Route::post('logic_ministerios', 'App\Http\Controllers\LogicMinisterioController@store');
    Route::put('logic_ministerios/{id}', 'App\Http\Controllers\LogicMinisterioController@update');
    Route::delete('logic_ministerios/{id}', 'App\Http\Controllers\LogicMinisterioController@delete');

    Route::get('logic_cargos', 'App\Http\Controllers\LogicCargoController@index');
    Route::get('logic_cargos/{id}', 'App\Http\Controllers\LogicCargoController@show');
    Route::post('logic_cargos', 'App\Http\Controllers\LogicCargoController@store');
    Route::put('logic_cargos/{id}', 'App\Http\Controllers\LogicCargoController@update');
    Route::delete('logic_cargos/{id}', 'App\Http\Controllers\LogicCargoController@delete');

    Route::get('logic_cms', 'App\Http\Controllers\LogicCmsController@index');
    Route::get('logic_cms/{id}', 'App\Http\Controllers\LogicCmsController@show');
    Route::post('logic_cms', 'App\Http\Controllers\LogicCmsController@store');
    Route::put('logic_cms/{id}', 'App\Http\Controllers\LogicCmsController@update');
    Route::delete('logic_cms/{id}', 'App\Http\Controllers\LogicCmsController@delete');

    Route::get('logic_ministerios_usuarios_cargos', 'App\Http\Controllers\LogicMinisterioUsuarioCargoController@index');
    Route::get('logic_ministerios_usuarios_cargos/{id}', 'App\Http\Controllers\LogicMinisterioUsuarioCargoController@show');
    Route::post('logic_ministerios_usuarios_cargos', 'App\Http\Controllers\LogicMinisterioUsuarioCargoController@store');
    Route::put('logic_ministerios_usuarios_cargos/{id}', 'App\Http\Controllers\LogicMinisterioUsuarioCargoController@update');
    Route::delete('logic_ministerios_usuarios_cargos/{id}', 'App\Http\Controllers\LogicMinisterioUsuarioCargoController@delete');

    Route::get('logic_actividades', 'App\Http\Controllers\LogicActividadController@index');
    Route::get('logic_actividades/{id}', 'App\Http\Controllers\LogicActividadController@show');
    Route::post('logic_actividades', 'App\Http\Controllers\LogicActividadController@store');
    Route::put('logic_actividades/{id}', 'App\Http\Controllers\LogicActividadController@update');
    Route::delete('logic_actividades/{id}', 'App\Http\Controllers\LogicActividadController@delete');

    Route::get('logic_tipos_actividades', 'App\Http\Controllers\LogicTipoActividadController@index');
    Route::get('logic_tipos_actividades/{id}', 'App\Http\Controllers\LogicTipoActividadController@show');
    Route::post('logic_tipos_actividades', 'App\Http\Controllers\LogicTipoActividadController@store');
    Route::put('logic_tipos_actividades/{id}', 'App\Http\Controllers\LogicTipoActividadController@update');
    Route::delete('logic_tipos_actividades/{id}', 'App\Http\Controllers\LogicTipoActividadController@delete');

    Route::get('logic_actividades_usuarios', 'App\Http\Controllers\LogicActividadUsuarioController@index');
    Route::get('logic_actividades_usuarios/{id}', 'App\Http\Controllers\LogicActividadUsuarioController@show');
    Route::post('logic_actividades_usuarios', 'App\Http\Controllers\LogicActividadUsuarioController@store');
    Route::put('logic_actividades_usuarios/{id}', 'App\Http\Controllers\LogicActividadUsuarioController@update');
    Route::delete('logic_actividades_usuarios/{id}', 'App\Http\Controllers\LogicActividadUsuarioController@delete');

    Route::get('logic_congregaciones', 'App\Http\Controllers\LogicCongregacionController@index');
    Route::get('logic_congregaciones/{id}', 'App\Http\Controllers\LogicCongregacionController@show');
    Route::post('logic_congregaciones', 'App\Http\Controllers\LogicCongregacionController@store');
    Route::put('logic_congregaciones/{id}', 'App\Http\Controllers\LogicCongregacionController@update');
    Route::delete('logic_congregaciones/{id}', 'App\Http\Controllers\LogicCongregacionController@delete');

    Route::get('logic_concilios', 'App\Http\Controllers\LogicConcilioController@index');
    Route::get('logic_concilios/{id}', 'App\Http\Controllers\LogicConcilioController@show');
    Route::post('logic_concilios', 'App\Http\Controllers\LogicConcilioController@store');
    Route::put('logic_concilios/{id}', 'App\Http\Controllers\LogicConcilioController@update');
    Route::delete('logic_concilios/{id}', 'App\Http\Controllers\LogicConcilioController@delete');

    Route::get('geo_countries', 'App\Http\Controllers\GeoCountryController@index');
    Route::get('geo_countries/{id}', 'App\Http\Controllers\GeoCountryController@show');
    Route::post('geo_countries', 'App\Http\Controllers\GeoCountryController@store');
    Route::put('geo_countries/{id}', 'App\Http\Controllers\GeoCountryController@update');
    Route::delete('geo_countries/{id}', 'App\Http\Controllers\GeoCountryController@delete');

    Route::get('geo_states', 'App\Http\Controllers\GeoStateController@index');
    Route::get('geo_states/{id}', 'App\Http\Controllers\GeoStateController@show');
    Route::post('geo_states', 'App\Http\Controllers\GeoStateController@store');
    Route::put('geo_states/{id}', 'App\Http\Controllers\GeoStateController@update');
    Route::delete('geo_states/{id}', 'App\Http\Controllers\GeoStateController@delete');

    Route::get('geo_cities', 'App\Http\Controllers\GeoCityController@index');
    Route::get('geo_cities/{id}', 'App\Http\Controllers\GeoCityController@show');
    Route::post('geo_cities', 'App\Http\Controllers\GeoCityController@store');
    Route::put('geo_cities/{id}', 'App\Http\Controllers\GeoCityController@update');
    Route::delete('geo_cities/{id}', 'App\Http\Controllers\GeoCityController@delete');

    Route::get('menu_items', 'App\Http\Controllers\MenuItemController@index');
    Route::get('menu_items/{id}', 'App\Http\Controllers\MenuItemController@show');
    Route::post('menu_items', 'App\Http\Controllers\MenuItemController@store');
    Route::put('menu_items/{id}', 'App\Http\Controllers\MenuItemController@update');
    Route::delete('menu_items/{id}', 'App\Http\Controllers\MenuItemController@delete');

    Route::get('menu_subitems', 'App\Http\Controllers\MenuSubitemController@index');
    Route::get('menu_subitems/{id}', 'App\Http\Controllers\MenuSubitemController@show');
    Route::post('menu_subitems', 'App\Http\Controllers\MenuSubitemController@store');
    Route::put('menu_subitems/{id}', 'App\Http\Controllers\MenuSubitemController@update');
    Route::delete('menu_subitems/{id}', 'App\Http\Controllers\MenuSubitemController@delete');

    Route::get('config_api', 'App\Http\Controllers\ConfigApiController@index');
    Route::get('config_api/{id}', 'App\Http\Controllers\ConfigApiController@show');
    Route::post('config_api', 'App\Http\Controllers\ConfigApiController@store');
    Route::put('config_api/{id}', 'App\Http\Controllers\ConfigApiController@update');
    Route::delete('config_api/{id}', 'App\Http\Controllers\ConfigApiController@delete');

    Route::get('config_componentes_formulario', 'App\Http\Controllers\ConfigComponentesFormularioController@index');
    Route::get('config_componentes_formulario/{id}', 'App\Http\Controllers\ConfigComponentesFormularioController@show');
    Route::post('config_componentes_formulario', 'App\Http\Controllers\ConfigComponentesFormularioController@store');
    Route::put('config_componentes_formulario/{id}', 'App\Http\Controllers\ConfigComponentesFormularioController@update');
    Route::delete('config_componentes_formulario/{id}', 'App\Http\Controllers\ConfigComponentesFormularioController@delete');

});

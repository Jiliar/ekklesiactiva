<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigComponenteFormulario extends Model
{
    use HasFactory;
    protected $table    = "config_componentes_formulario";
    protected $primaryKey = 'id';
    protected $fillable = ['id_css','clase_css','caption','tipo','etiqueta','origen','orden','modulo','hoja_ruta','campo_importado','custom_css','js','icono','es_requerido','es_readonly'];
}

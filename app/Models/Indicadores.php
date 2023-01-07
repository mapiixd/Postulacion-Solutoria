<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\IndicadoresController;
use Carbon\Carbon;


class Indicadores extends Model
{
    use HasFactory;

    protected $dates = [
        'fechaIndicador',
        'updated_at',
        'created_at'
    ];

    //Campos que se pueden rellenar del objeto Indicadores en la base de datos
    protected $fillable = [
        'nombreIndicador', 
        'codigoIndicador', 
        'unidadMedidaIndicador', 
        'valorIndicador', 
        'fechaIndicador', 
        'tiempoIndicador', 
        'origenIndicador'
    ];

}

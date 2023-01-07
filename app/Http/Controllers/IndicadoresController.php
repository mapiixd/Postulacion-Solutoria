<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Indicadores;
use Illuminate\Support\Facades\Http;
use Yajra\Datatables\Datatables;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class IndicadoresController extends Controller
{
    //Función que solicita el token, lo retorna y lo imprime
    public function tkn()
    {

        $response = Http::post('https://postulaciones.solutoria.cl/api/acceso', [
            'userName' => 'leallucas2kxkaon_tz2@indeedemail.com',
            'flagJson' => true
        ]);
        $data = json_decode($response->getBody());
        $tkn = $data->token;
        return $tkn;
        echo $tkn;
    }

    //Función que solicita los datos de los indicadores y los filtra para que solo retorne los datos de las UF
    public function solicitar_uf()
    {
        $token = $this->tkn();
        $response = Http::withToken($token)->get('https://postulaciones.solutoria.cl/api/indicadores');
        $collection = collect($response->json());
        $filtered = $collection->whereIn('codigoIndicador', 'UF');
        return $filtered->all();
    }

    //Función que borra la tabla indicadores y luego la llena con la información de la función solicitar_uf
    public function llenar_db()
    {
        Indicadores::truncate();
        $datosUf = $this->solicitar_uf();
        foreach ($datosUf as $datoUf) {
            Indicadores::create($datoUf);
        }
        return view('inicio')->with('successMsg','Property is updated .');
    }


    public function index(Request $request)
    {
     
        if ($request->ajax()) {
  
            $data = Indicadores::get();
  
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('fechaIndicador', function($row)
                {
                return $row->fechaIndicador->format('Y-m-d');
                })
                ->addColumn('action', function($row){
   
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editIndicador">Editar</a>';
   
                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteIndicador">Eliminar</a>';
    
                    return $btn;
                })
            ->rawColumns(['action'])
            ->make(true);
        }
        
        return view('indicadoresCrud');
    }

    public function store(Request $request)
    {
        Indicadores::updateOrCreate([
                    'id' => $request->id
                ],
                [
                    'nombreIndicador' => $request->nombreIndicador, 
                    'codigoIndicador' => $request->codigoIndicador,
                    'unidadMedidaIndicador' => $request->unidadMedidaIndicador,
                    'valorIndicador' => $request->valorIndicador,
                    'fechaIndicador' => $request->fechaIndicador,
                    'tiempoIndicador' => $request->tiempoIndicador,
                    'origenIndicador' => $request->origenIndicador
                ]);        
     
        return response()->json(['success'=>'Indicador guardado correctamente.']);
    }


    public function edit($id)
    {
        $indicadores = Indicadores::find($id);
        return response()->json($indicadores);
    }


    public function destroy($id)
    {
        Indicadores::find($id)->delete();
      
        return response()->json(['success'=>'Indicador borrado exitosamente.']);
    }

    public function g_indicadores(Request $request)
    {
        if (isset($request->date_filter)) {
            $parts = explode(' - ' , $request->date_filter);
            $date_from = $parts[0];
            $date_to = $parts[1];
        } else {
            $carbon_date_from = new Carbon('last Monday');
            $date_from = $carbon_date_from->toDateString();
            $carbon_date_to = new Carbon('this Sunday');
            $date_to = $carbon_date_to->toDateString();
        }

        $reportTitle = 'Indicadores';
        $reportLabel = 'Valor del indicador';
        $chartType   = 'line';

        $results = Indicadores::where('fechaIndicador', '>=', $date_from)->where('fechaIndicador', '<=', $date_to)
            ->get()->sortBy('fechaIndicador')->groupBy(function ($entry) {
            if ($entry->fechaIndicador instanceof \Carbon\Carbon) {
                return \Carbon\Carbon::parse($entry->fechaIndicador)->format('Y-m-d');
            }

            return \Carbon\Carbon::createFromFormat(config('app.date_format'), $entry->fechaIndicador)->format('Y-m-d');
        })->map(function ($entries, $group) {
            return $entries->sum('valorIndicador');
        });

        return view('grafico', compact('reportTitle', 'results', 'chartType', 'reportLabel'));
    }

}
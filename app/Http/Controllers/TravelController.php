<?php

namespace App\Http\Controllers;

use App\Car;
use App\Gas;
use App\Travel;
use App\TravelDetail;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Input;
use Auth;
use Carbon\Carbon;
use Krucas\Notification\Facades\Notification;
use Excel;

class TravelController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        if(Auth::user()->hasRole('driver')){
            return view('travels.drivers.index')->with('travels',Auth::user()->travels);
        }else{

            switch(Input::get('filter')){
                case 0:
                    $travels = Travel::all();
                    break;
                case 1:
                    $travels = Travel::where('status','=',Input::get('type'));
                    break;
                case 2:
                    $travels = Travel::where('driver_id','=',Input::get('driver_id'));
                    break;
                case 3:
                    $travels = Travel::where('accountant','=',Input::get('accountant_id'));
                    break;
                default:
                    $travels = Travel::all();
                    break;
            }
            return view('travels.accountants.index')->with('travels',$travels);
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        if(Auth::user()->hasRole('driver')){
            return view('travels.drivers.coe');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        return DB::transaction(function($request) use ($request){
            $new_travel = new Travel;
            $new_travel->driver_id = intval(Input::get('driver_id'));
            $new_travel->car_id = intval(Input::get('car_id'));
            $new_travel->accountant_id = null;
            $new_travel->status = 1;
            $new_travel->reason = Input::get('reason');
            $new_travel->observations =Input::get('observations');
            $new_travel->travel_date = Carbon::createFromFormat('d/m/Y',Input::get('date'));
            $new_travel->total_distance = floatval(Input::get('total_distance'));

            $performance = Car::find($new_travel->car_id)->value('km_liter');
            $new_travel->estimate_cost = $new_travel->total_distance / $performance * Gas::all()->first()->price;

            $new_travel->save();
            $routes = Input::get('routes');
            foreach($routes as $route){
                $new_detail = new TravelDetail;
                $new_detail->travel_id = $new_travel->id;
                $new_detail->route_id = $route['id'];
                $new_detail->save();
            }
            $request->session()->flash('success_msg', 'Viaje creado exitosamente. Notifique al contador para la autorización!');
            return response()->json(['ok'], 200);
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        return view('travels.show')->with('travel', Travel::find($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $travel = Travel::find($id);
        if($travel !== null && Auth::user()->id == $travel->driver_id && $travel->status == 1){
            return view('travels.drivers.coe')->with('travel', $travel);
        }else{
            return redirect('travels');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {

        return DB::transaction(function() use ($request, $id){
            $update_travel = Travel::find($id);
            if($update_travel->status != 1){
                return response()->json(['status'], 403);
            }
            $update_travel->car_id = intval(Input::get('car_id'));
            $update_travel->reason = Input::get('reason');
            $update_travel->observations =Input::get('observations');
            $update_travel->travel_date = Carbon::createFromFormat('d/m/Y',Input::get('date'));
            $update_travel->total_distance = floatval(Input::get('total_distance'));
            $performance = Car::find($update_travel->car_id)->value('km_liter');
            $update_travel->estimate_cost = $update_travel->total_distance / $performance * Gas::all()->first()->price;
            $update_travel->save();

            foreach($update_travel->travelDetails as $detail){
                $detail->delete();
            }

            $routes = Input::get('routes');
            foreach($routes as $route){
                $new_detail = new TravelDetail;
                $new_detail->travel_id = $update_travel->id;
                $new_detail->route_id = $route['id'];
                $new_detail->save();
            }
            $request->session()->flash('success_msg', 'Viaje #'.$id.' actualizado exitosamente. Notifique al contador para la autorización!');
            return response()->json(['ok'], 200);
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        DB::transaction(function($id) use ($id){
            $travel = Travel::findOrFail($id);
            foreach($travel->travelDetails as $detail){
                $detail->delete();
            }
            $travel->delete();
            Notification::success('Viaje #'.$id.' eliminado correctamente');
            return redirect('travels');
        });
    }

    public function changeStatus($status, $id){
        if(Auth::user()->hasRole('accountant')){
            $travel = Travel::findOrFail($id);
            $travel->status = $status;
            $travel->accountant_id = Auth::user()->id;
            $travel->save();
            Notification::success('Viaje #'.$id.' estado actualizado correctamente');
            return redirect('travels');
        }
        return redirect('travels');
    }

    public function excel($id){    
        $titulosTabla=array('Origen','Destino','Distancia');
        $datosTabla=array();        
        $travel = Travel::find($id);
        $details = $travel->travelDetails;
        $lineas = array();
        foreach ($details as $detail) {  
            $linea     = array();         
            $origen    = $detail->route->origin_location->name;
            $destino   = $detail->route->destination_location->name;
            $distancia = $detail->route->distance;
            array_push($linea,$origen,$destino,$distancia);
            array_push($lineas, $linea);
            
        }

        Excel::create('Travel#'.$travel->id, function($excel) use($travel,$lineas,$titulosTabla) {

            // Call writer methods here
            $excel->sheet('Details', function($sheet) use($travel,$lineas,$titulosTabla) {
            // Sheet manipulation 
                $sheet->row(1, array(
                     'Fecha Del Viaje', 'Distancia Total'
                ));  
                $sheet->row(2, array(
                     $travel->travel_date, $travel->total_distance.'Km'
                )); 
                $sheet->row(4, array(
                     'Motivo'
                ));  
                $sheet->row(5, array(
                     $travel->reason
                )); 
                $sheet->row(7, array(
                     'Observaciones'
                ));  
                $sheet->row(8, array(
                    $travel->observations
                ));

                $sheet->fromArray($titulosTabla, null, 'A10');                
                $contador = 0;
                foreach ($lineas as $linea) {
                    $sheet->row(11+$contador, $linea);
                    $contador = $contador + 1;
                }  

                $sheet->row(1, function($row) {
                    $row->setFont(array(                    
                    'bold'       =>  true
                    ));                    
                });
                
                $sheet->row(4, function($row) {
                    $row->setFont(array(                    
                    'bold'       =>  true
                    ));
                });

                $sheet->row(7, function($row) {
                    $row->setFont(array(                    
                    'bold'       =>  true
                    ));
                });

                 $sheet->row(10, function($row) {
                    $row->setFont(array(                    
                    'bold'       =>  true
                    ));
                });               

                $sheet->cell('A1', function($cell) {
                    $cell->setBorder('thick', 'thick', 'thick', 'thick');
                });
                $sheet->cell('B1', function($cell) {
                    $cell->setBorder('thick', 'thick', 'thick', 'thick');
                });
                $sheet->cell('A4', function($cell) {
                    $cell->setBorder('thick', 'thick', 'thick', 'thick');
                });
                $sheet->cell('A7', function($cell) {
                    $cell->setBorder('thick', 'thick', 'thick', 'thick');
                });
                $sheet->cell('A10', function($cell) {
                    $cell->setBorder('thick', 'thick', 'thick', 'thick');
                });
                $sheet->cell('B10', function($cell) {
                    $cell->setBorder('thick', 'thick', 'thick', 'thick');
                });
                $sheet->cell('C10', function($cell) {
                    $cell->setBorder('thick', 'thick', 'thick', 'thick');
                });

            });          

        })->export('xls');//or ->download('xls'); ->export('pdf'); ->export('xlsx');     
    }
}

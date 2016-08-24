<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Krucas\Notification\Facades\Notification;

use App\Travel;
use Excel;

class ReportGeneratorController extends Controller
{

	 public function viewReport()
    {
    	return view('reports.index');
    }

    public function setReportDetails(Request $request)
    {
    	$startingDate = $request->input('startingDate');
    	$finalDate = $request->input('finalDate');
        $travels = Travel::where('travel_date','>=',$startingDate)->where('travel_date','<=',$finalDate)
                           ->where('status','=',2)->get();
        $data['startingDate'] = $startingDate;
        $data['finalDate'] = $finalDate;
        $data['travels'] = $travels;
        $data['numberOfTravels'] = $travels->count();
        $data['totalCost'] = 0;
        $data['totalDistance'] = 0;
        foreach ($travels as $travel ) {
            $data['totalCost'] += $travel->estimate_cost;
        }
        foreach ($travels as $travel ) {
            $data['totalDistance'] += $travel->total_distance;
        }
       //return $travels;
       return view('reports.index')->with('data',$data);
    }

    public function excel(Request $request){
        $titulosTablaViajes = array('ID','Fecha del viaje','Distancia Total','Costo','Motivo', 'Observaciones');    
        $titulosTablaFinal = array('# de viajes','Distancia total', 'Costo total');     

        $startingDate = $request->input('startingDate');
        $finalDate = $request->input('finalDate');
        $travels = Travel::where('travel_date','>=',$startingDate)->where('travel_date','<=',$finalDate)
                           ->where('status','=',2)->get();

        $travelsData['startingDate'] = $startingDate;
        $travelsData['finalDate'] = $finalDate;
        $travelsData['travels'] = $travels;
        $travelsData['numberOfTravels'] = $travels->count();
        $travelsData['totalCost'] = 0;
        $travelsData['totalDistance'] = 0;
        foreach ($travels as $travel ) {
            $travelsData['totalCost'] += $travel->estimate_cost;
        }
        foreach ($travels as $travel ) {
            $travelsData['totalDistance'] += $travel->total_distance;
        }

        //$travelsData = $request->input('travelsData');
        //$travels = $travelsData['travels'];
        $lineas = array();

        foreach ($travels as $travel) {
            $linea        = array();
            $id           = $travel->id;   
            $date         = $travel->travel_date;   
            $distance     = $travel->total_distance;  
            $cost         = $travel->estimate_cost;   
            $reason       = $travel->reason;   
            $observations = $travel->observations;               
            array_push($linea,$id,$date,$distance,$cost,$reason,$observations);
            array_push($lineas, $linea);
        }
        
        Excel::create('Reporte:'.$travelsData['startingDate'].'---'.$travelsData['finalDate'], function($excel) use($travelsData,$lineas,$titulosTablaViajes,$titulosTablaFinal) {
            // Call writer methods here
            $excel->sheet('Details', function($sheet) use($travelsData,$lineas,$titulosTablaViajes,$titulosTablaFinal) {
            // Sheet manipulation 
                $sheet->fromArray($titulosTablaViajes,null, 'A6');

                //$sheet->fromArray($titulosTablaFinal, null, 'A1');  
                $sheet->row(1, array(
                     'RESUMEN'
                )); 
   
                $sheet->row(2, array(
                     '# de Viajes', 'Distancia Total', 'Costo Total'
                )); 

                $sheet->row(3, array(
                     $travelsData['numberOfTravels'],
                     $travelsData['totalDistance'].' Km',
                     '$'.$travelsData['totalCost']
                )); 
                
                $sheet->row(5, array(
                     'VIAJES'
                )); 

                $contador = 0;
                foreach ($lineas as $linea) {
                    $sheet->row(7+$contador, $linea);
                    $contador = $contador + 1;
                }  

                $sheet->row(1, function($row) {
                    $row->setFont(array(                    
                    'bold'       =>  true
                    ));                    
                });
                $sheet->row(2, function($row) {
                    $row->setFont(array(                    
                    'bold'       =>  true
                    ));                    
                });
                $sheet->row(5, function($row) {
                    $row->setFont(array(                    
                    'bold'       =>  true
                    ));
                });
                $sheet->row(6, function($row) {
                    $row->setFont(array(                    
                    'bold'       =>  true
                    ));
                });

                $sheet->cell('A1', function($cell) {
                    $cell->setBorder('thick', 'thick', 'thick', 'thick');
                });
                $sheet->cell('A2', function($cell) {
                    $cell->setBorder('thick', 'thick', 'thick', 'thick');
                });
                $sheet->cell('B2', function($cell) {
                    $cell->setBorder('thick', 'thick', 'thick', 'thick');
                });
                $sheet->cell('C2', function($cell) {
                    $cell->setBorder('thick', 'thick', 'thick', 'thick');
                });
                $sheet->cell('A5', function($cell) {
                    $cell->setBorder('thick', 'thick', 'thick', 'thick');
                });
                $sheet->cell('A6', function($cell) {
                    $cell->setBorder('thick', 'thick', 'thick', 'thick');
                });
                $sheet->cell('B6', function($cell) {
                    $cell->setBorder('thick', 'thick', 'thick', 'thick');
                });
                $sheet->cell('C6', function($cell) {
                    $cell->setBorder('thick', 'thick', 'thick', 'thick');
                });
                $sheet->cell('D6', function($cell) {
                    $cell->setBorder('thick', 'thick', 'thick', 'thick');
                });
                $sheet->cell('E6', function($cell) {
                    $cell->setBorder('thick', 'thick', 'thick', 'thick');
                });
                $sheet->cell('F6', function($cell) {
                    $cell->setBorder('thick', 'thick', 'thick', 'thick');
                });
            });          

        })->export('xls');//or ->download('xls'); ->export('pdf'); ->export('xlsx'); 
    }

}
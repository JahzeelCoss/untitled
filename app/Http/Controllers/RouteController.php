<?php

namespace App\Http\Controllers;

use App\Route;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Input;
use Krucas\Notification\Facades\Notification;

class RouteController extends Controller
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
        return view('routes.index')->with('routes',Route::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('routes.coe');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $route = new Route;
        if($route->validate(Input::all(), Route::$rules)){
            $origin_Id = Input::get("origin_location_id");
            $destination_Id = Input::get("destination_location_id");
            $origin_on_db = Route::where('origin_location_id', '=', $origin_Id)->where('destination_location_id', '=', $destination_Id)->first() !== null;
            if(!$origin_on_db){
                $route = new Route(Input::except('_token'));
                $route->save();
                if(Input::get('reverse') != null){
                    $destination_on_db = Route::where('origin_location_id', '=', $destination_Id)->where('destination_location_id', '=', $origin_Id)->first() !== null;
                    if(!$destination_on_db){
                        $reverse_route = new Route;
                        $reverse_route->origin_location_id = $destination_Id;
                        $reverse_route->destination_location_id = $origin_Id;
                        $reverse_route->distance = Input::get("distance");
                        $reverse_route->save();
                    }
                }
                Notification::success('Ruta #'.$route->id.' añadida correctamente');
                return redirect('routes');
            }else{
                Notification::error('La ruta ya se encuentra registrada en el sistema');
                return redirect()->back()->withInput();
            }
        }else{
            $errors = $route->errors();
            return redirect()->back()->withInput()->withErrors($errors);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $route = Route::find($id);
        if($route !== null){
            return view('routes.coe')->with('route', $route);
        }else{
            return redirect('routes');
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
        $route = Route::find($id);
        if($route->validate(Input::all(), Route::$rules)){
            if(Input::get('origin_location_id') == $route->origin_location_id && Input::get('destination_location_id') == $route->destination_location_id){
                if(Input::get('distance') == $route->distance){
                    return redirect('routes');
                }else{
                    $route->distance = Input::get('distance');
                    $route->save();
                    Notification::success('Ruta #'.$route->id.' editada correctamente');
                    return redirect('routes');
                }
            }else{
                $origin_on_db = Route::where('origin_location_id', '=', Input::get('origin_location_id'))->where('destination_location_id', '=', Input::get('destination_location_id'))->first() !== null;
                if(!$origin_on_db){
                    $route->update(Input::except('_token'));
                    Notification::success('Ruta #'.$route->id.' editada correctamente');
                    return redirect('routes');
                }else{
                    Notification::error('La ruta ya se encuentra registrada en el sistema');
                    return redirect()->back()->withInput();
                }
            }
        }else{
            $errors = $route->errors();
            return redirect()->back()->withInput()->withErrors($errors);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $route = Route::find($id);
        $route->delete();
        Notification::success('Ruta eliminada correctamente');
        return redirect('routes');
    }

    public function getRoute(){
            $idOrigin = Input::get('origin');
            $idDestination = Input::get('destination');
            $res   = Route::where('origin_location_id', '=', $idOrigin)->where('destination_location_id', '=', $idDestination)->first();
            return response()->json($res);
    }
}

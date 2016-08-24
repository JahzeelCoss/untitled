<?php

namespace App\Http\Controllers;

use App\Car;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Krucas\Notification\Facades\Notification;

class CarController extends Controller
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
        return view('cars.index')->with('cars',Car::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('cars.coe');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $car = new Car;
        if($car->validate(Input::all(), Car::$rules)){
            $car = new Car(Input::except('_token'));
            $car->save();
            Notification::success('Vehículo #'.$car->id.' añadido correctamente');
            return redirect('cars');
        }else{
            $errors = $car->errors();
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
        $car = Car::find($id);
        if($car !== null){
            return view('cars.coe')->with('car', $car);
        }else{
            return redirect('cars');
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
        $car = Car::find($id);
        if($car->validate(Input::all(), Car::$rules)){
            $car->update(Input::except('_token'));
            Notification::success('Vehículo #'.$car->id.' editado correctamente');
            return redirect('cars');
        }else{
            $errors = $car->errors();
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
        $car = Car::find($id);
        $car->delete();
        Notification::success('Vehículo #'.$id.' eliminado correctamente');
        return redirect('cars');
    }

    public function getCar(){
        $query = Input::get('name');
        $searchValues = preg_split('/\s+/', $query); // split on 1+ whitespace
        $res = Car::where(function ($q) use ($searchValues) {
            foreach ($searchValues as $value) {
                $q->orWhere('brand', 'like', "%{$value}%")
                ->orWhere('plates', 'like', "%{$value}%")
                ->orWhere('description', 'like', "%{$value}%");
            }
        })->get();
        return response()->json($res);
    }
}

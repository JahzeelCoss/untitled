<?php

namespace App\Http\Controllers;

use App\Location;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Krucas\Notification\Facades\Notification;

class LocationController extends Controller
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
        return view('locations.index')->with('locations',Location::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('locations.coe');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $location = new Location();
        if($location->validate(Input::all(), Location::$rules)){
            $location = new Location(Input::except('_token'));
            $location->save();
            Notification::success('Localidad "'.$location->name.'" añadida correctamente');
            return redirect('locations');
        }else{
            $errors = $location->errors();
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
        $location = Location::find($id);
        if($location !== null){
            return view('locations.coe')->with('location', $location);
        }else{
            return redirect('locations');
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
        $location = Location::find($id);
        if($location->validate(Input::all(), Location::$rules)){
            $location->update(Input::except('_token'));
            Notification::success('Localidad "'.$location->name.'" editada correctamente');
            return redirect('locations');
        }else{
            $errors = $location->errors();
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
        $location = Location::find($id);
        $location->delete();
        Notification::success('Localidad "'.$location->name.'" eliminada correctamente');
        return redirect('locations');
    }

    public function getLocation(){
        $query = Input::get('name');
        $res   = Location::where('name', 'LIKE', "%$query%")->get();
        return response()->json($res);
    }
}

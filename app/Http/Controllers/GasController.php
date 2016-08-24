<?php

namespace App\Http\Controllers;

use App\Gas;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Krucas\Notification\Facades\Notification;

class GasController extends Controller
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
        return view('gas.index')->with('gas',Gas::all()->first());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $gas = new Gas;
        if($gas->validate(Input::all(), Gas::$rules)){
            $gas = new Gas(Input::except('_token'));
            $gas->save();
            Notification::success('Precio guardado correctamente');
            return redirect('gas');
        }else{
            $errors = $gas->errors();
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
        //
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
        $gas = Gas::find($id);
        if($gas->validate(Input::all(), Gas::$rules)){
            $gas->update(Input::except('_token'));
            Notification::success('Precio actualizado correctamente');
            return redirect('gas');
        }else{
            $errors = $gas->errors();
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
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Krucas\Notification\Facades\Notification;
use Illuminate\Support\Facades\Input;

class RoleController extends Controller
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
        return view('roles.index')->with('users',User::all());
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
        //
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
        $user = User::find($id);
        if($user !== null){
            return view('roles.coe')->with('user', $user);
        }else{
            return redirect('roles');
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
        $user = User::findOrFail($id);
        $role = Role::findOrFail(Input::get('role'));
        if(!$user->hasRole($role->name)){
            $user->detachRoles($user->roles);
            $user->attachRole($role);
            Notification::success('Al usuario <strong>'.$user->name.'</strong> se le asigno el rol <strong>'.$role->display_name.'</strong>');
            return redirect('roles');
        }else{
            return redirect('roles');
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

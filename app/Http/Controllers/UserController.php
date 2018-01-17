<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Session;
use Redirect;
use Illuminate\Validation\Rule;
use App\User;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return view('admin')->with('users',$users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ];

        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return Redirect::to('/admin/users/create')->withErrors($validator);
        }
        $data['password'] = bcrypt($data['password']);
        $user = new User($data);

        if($user->save()){
            // redirect
            Session::flash('message', 'Successfully created the users!');
            return Redirect::to('/admin/users');
        } else {
            return Redirect::to('/admin/users');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $data['id'] = $id;
        $validator = Validator::make($data, [
            'id' => 'required|numeric|exists:users,id',
        ]);

        if ($validator->fails()) {
            return Redirect::to('/admin/users')->withErrors($validator);
        }

        $user = User::find($id);

       return view('edit')->with('user',$user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data =$request->all();
        $data['id'] = $id;
        $rules = [
            'id' => 'required|numeric|exists:users,id',
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return Redirect::to('/admin/users/'.$id.'/edit')->withErrors($validator);
        }

        $user = User::find($id);
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = $data['password'];

        if($user->save()){
            // redirect
            Session::flash('message', 'Successfully updated the users!');
            return Redirect::to('/admin/users');
        } else {
            return Redirect::to('/admin/users');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data['id'] = $id;
        $validator = Validator::make($data, [
            'id' => 'required|numeric|exists:users,id',
        ]);

        if ($validator->fails()) {
            return Redirect::to('/admin/users')->withErrors($validator);
        }

        $user = User::find($id);

        if($user->delete()){
            // redirect
            Session::flash('message', 'Successfully deleted the users!');
            return Redirect::to('/admin/users');
        } else {
            return Redirect::to('/admin/users');
        }


    }


}

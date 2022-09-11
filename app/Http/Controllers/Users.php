<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Users extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\UserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $request = $request->all();

        $createUser = User::create([
            'name'       => $request['first_name'] . ' ' . $request['last_name'] , 
            'first_name' => $request['first_name'], 
            'last_name'  => $request['last_name'], 
            'email'      => $request['email'], 
            'password'   => Hash::make($request['login']['password']), 
        ]);
        if($createUser) {
            return view('users.login');
        } else {
            return view('users.create');
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    /**
     * login the user to the applicatoin
     * @param  \Illuminate\Http\UserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function login(UserRequest $request)
    {
        $credentials = [
            'email' => $request['email'],
            'password' => $request['password'],
        ];
      
        if(Auth::attempt($credentials)) {
            return redirect()->route('email.create');
        } else {
            return back()->with('errors', 'Please try again with correct credentials');
        }
    }
}

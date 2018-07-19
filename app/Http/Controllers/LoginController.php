<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;


use App\Persona;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function autenticar(Request $request)
    {   

        $email = $request->input('txtEmail');
        $password   =$request->input('txtPassword');

        if (Auth::attempt(['email' => $email, 'password' => $password])) {

             // return redirect()->route('home');
             // $actividades = Actividad::orderBy('id','asc')->paginate(10);

            // return view("actividad.index",compact("actividades"));
            return redirect()->route('actividad.index');
           
        }else{ 
             // return redirect('login')->with('error','Usuario o contraseña incorrecta.');
             return redirect()->route('login')->with('error','Usuario o contraseña incorrecta.');
          
        }
    }


    public function index()
    {
        return view('auth.login');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

    public function logout(){

        Auth::logout();
        //return redirect()->route('login.index')->with('error','User o password no coinciden');
        return redirect()->route('login');


    }
}

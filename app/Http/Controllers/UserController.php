<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Rol;
use Hash;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('usuarios.Login');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         $roles = Rol::all();
     return view('admin.User.create',compact('roles'));
        // return view('admin.User.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validacion de lado del servidor
        // $validator = Validator::make($request->all(),[
        //     'identificacion'  => "required | unique:users,identificacion",
        //     'nombre'          => "required",
        //     'apellido'        => "required",
        //     'email'           => "required | email | unique:users,email",
        //     'telefono'        => "required",
        //     'nick'            => "required",
        //     'password'        => "required"



        // ]);



        // if($validator->fails()){

        //     return redirect()->back()->withErrors($validator->errors());

        // }else{

            $user = new User();
            $user->persona_id       = $request->input("txtPersonaId");
            $user->dni       = $request->input("txtDni");
            $user->rol_id           = 1;
            $user->user_status_id           = 1;
            $user->password       = Hash::make($request->input("txtPassword"));
            $user->save();
            
            return redirect()->back()->with('info','La cuenta ha sido creada correctamente, por favor, contactarse con el administrador para su activación.');

        // }
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
    public function edit()
    {
        //
        return view('admin.user.edit');
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
        $pass1 = trim($request->input("txtPassword1"));
        $pass2 = trim($request->input("txtPassword2"));

        if($pass1==$pass2){
            // echo "se peude actualizar";

            $usuario = User::where('id','=',$id)->first();

            // dd($usuario);
            $usuario->password = Hash::make($pass1);
            $usuario->save();

             return redirect()->route('user.edit')->with('info','Su contraseña ha sido actualizada');

        }else{
            return redirect()->route('user.edit')->with('error','Las contraseñas ingresadas deben ser iguales');
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
        //
    }
}

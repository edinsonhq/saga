<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Empleado;
use Hash;
use Validator;


class RegistroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.login'); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         
         $email =  $request->input("email");
         $password = $request->input("password");
         $passwordConfirm = $request->input("password_confirmation");

        
                // buscando empleado
                 $empleado = Empleado::where('email','=',$email)->first();


                 $validator = Validator::make($request->all(),[
                     'email' => "required | unique:users,email",
                     'password'        => "required"
                 ]);

                 if($validator->fails()){

                     return redirect()->back()->with('error','La cuenta que desea crear ya existe.');

                 }else{

                 // dd($empleado);

                         if($empleado<>""){


                                if($password == $passwordConfirm){




                                    $user = new User();
                                    $user->email = $email;
                                    $user->empleado_id = $empleado->id;
                                    $user->rol_id= 2;
                                    $user->password = Hash::make($password);
                                    $user->save();

                                    auth()->login($user);
                                    // return redirect('/home');
                                    return redirect()->route('actividad.index');





                                }else{
                                            return redirect()->back()->with('error','Las claves no concuerdan.'); 
                                            // return redirect()->back(); 
                                }

                         }else{

                            // return redirect()->back()->withErrors($validator->errors());
                            return redirect()->back()->with('error','email no existe');

                         }
                }
        
    }


}

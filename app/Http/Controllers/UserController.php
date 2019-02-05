<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function config(){
        return view('user.config');
    }
    
    public function update(Request $request){
        //conseguir usuario identificado
        $user = \Auth::user();
        $id = $user->id;
        
        //validacion del usuario
        $validate = $this->validate($request, [
            'name'=>'required|string|max:255',
            'surname' =>'required|string|max:255',
            'nick' => 'required|string|max:255|unique:users,nick,'.$id,
            'email' => 'required|string|email|max:255|unique:users,email,'.$id
        ]);
        
        //recoger datos del usuario
        $name = $request->input('name');
        $surname = $request->input('surname');
        $nick = $request->input('nick');
        $email = $request->input('email');
        
        //asignar valores a usuario
        $user->name= $name;
        $user->surname= $surname;
        $user->nick= $nick;
        $user->email= $email;
        
        //ejecutar consulta y cambios en la base de datos
        $user->update();
        
        return redirect()->route('config')
                         ->with(['message'=>'Usuario actualizado correctament']);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage; //Para las imagenes
use Illuminate\Support\Facades\File; //Para las imagenes

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
        
        //subir imagen
        $image_path = $request->file('image_path');
        if($image_path){
            //Poner nombre unico
            $image_path_full = time().$image_path->getClientOriginalName();
            //Guardar en la carpeta storage (app/users)
            Storage::disk('users')->put($image_path_full, File::get($image_path));
            //Seteo el nombre de la imagen en el objeto
            $user->image = $image_path_full;
        }
        
        //ejecutar consulta y cambios en la base de datos
        $user->update();
        
        return redirect()->route('config')
                         ->with(['message'=>'Usuario actualizado correctament']);
    }
    
    public function getImage($filename){
        $file = Storage::disk('users')->get($filename);
        return new Response ($file, 200);
        
    }
}

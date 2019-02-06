<?php

namespace App\Http\Controllers;
use Illuminate\Http\Response; //para funcion que devuelve la imagen que tenemos en el disco
use Illuminate\Support\Facades\Storage; //Para las imagenes
use Illuminate\Support\Facades\File; //Para las imagenes
use Illuminate\Http\Request;
use App\Image;

class ImageController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    
    public function create(){
        return view('image.create');
    }
    
    public function save(Request $request){
        
        //validacion
        $validate = $this->validate($request, [
           'descripcion' => 'required',
           'image_path' => 'required|mimes:jpg,jpeg,png,gif '
        ]);
        
        //Recoger datos
        $image_path = $request ->file('image_path');
        $descripcion= $request ->input('descripcion');
        
        //Autenticar usuario
        $user = \Auth::user();
        //Asignar valores nuevo objetos
        $image = new Image();
        $image->image_path = null;
        $image->description = $descripcion;
        
        //Subir fichero
        if($image_path){
            $image_path_name = time().$image_path->getClientOriginalName();
            Storage::disk('images')->put($image_path_name, File::get($image_path));
            $image->image_path = $image_path_name;
        }
        $image->save();
        
        return redirect()->route('home')->with([
            'message' => 'La foto ha sido subida correctamente'
        ]);
    }
}

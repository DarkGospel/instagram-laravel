<?php

namespace App\Http\Controllers;
use App\Comment;
use Illuminate\Http\Response; //para funcion que devuelve la imagen que tenemos en el disco
use Illuminate\Support\Facades\Storage; //Para las imagenes
use Illuminate\Support\Facades\File; //Para las imagenes
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    
    public function store(Request $request){
        //validadcion
        $validate = $this->validate($request, [
           'image_id' => 'int|required',
            'content' => 'string|required'
        ]);
        //Recoger datos del formulario
        $user = \Auth::user();
        $image_id = $request->input('image_id');
        $content = $request->input('content');
        //Asignar los valores recogidos
        $comment = new Comment();
        $comment->user_id = $user->id;
        $comment->image_id = $image_id;
        $comment->content = $content;
        //guardar en la base de datos
        $comment->save();
        //Redireccion
        return redirect()->route('image.detail', ['id' => $image_id])
                         ->with([
                             'message' => 'Has publicado tu comentario correctamente'
                         ]);
    }
    
    public function delete($id){
        //Conseguir datos del usuario identificado
        $user = \Auth::user();
        
        //Conseguir objeto del comentario
        $comment = Comment::find($id);
        
        //Comprobar dueño del comentario o publicacion
        if($user && ($comment->user_id == $user->id || $comment->image->user_id == $user->id)){
            $comment->delete();
            //Redireccion
            return redirect()->route('image.detail', ['id' => $comment->image->id])
                             ->with([
                             'message' => 'Comentario eliminado correctamente!! :D'
                         ]);
        }
        else
        {
            return redirect()->route('image.detail', ['id' => $comment->image->id])
                             ->with([
                             'message' => 'El comentario no se ha eliminado!! :('
                         ]);
        }
    }
}

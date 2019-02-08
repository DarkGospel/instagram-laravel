<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Image;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $images = Image::orderBy('id', 'desc')->paginate(5);//5 indica el numero de elementos por pagina
        //$images = Image::orderBy('id', 'desc')->get(); //Esto lo hemos usado hasta aplicar la paginacion
        //$image = Image::all(); //Esto también funciona solo que no lo ordena
        return view('home', [
            'images' => $images
        ]);
    }
}

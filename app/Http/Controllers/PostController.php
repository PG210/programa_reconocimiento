<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuarios\Usuarios;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function search(Request $request){
        $uselogeado=auth()->id();
        $results = Usuarios::where('name', 'LIKE', "%{$request->search}%")->where('id', '!=', $uselogeado)
                   ->where('id_rol', '=', 2)->get();
        return view('reconocimientos.results', compact('results'))->with(['search' => $request->search])->render();
    }
        
    public function show(Request $request){
        $post = Usuarios::findOrFail($request->id);
        return view('reconocimientos.post', compact('post'))->render();
    }
}



<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuarios\Usuarios;

class PostController extends Controller
{
    public function search(Request $request){
        $results = Usuarios::where('name', 'LIKE', "%{$request->search}%")->get();
        return view('reconocimientos.results', compact('results'))->with(['search' => $request->search])->render();
    }
        
    public function show(Request $request){
        $post = Usuarios::findOrFail($request->id);
        return view('reconocimientos.post', compact('post'))->render();
    }
}



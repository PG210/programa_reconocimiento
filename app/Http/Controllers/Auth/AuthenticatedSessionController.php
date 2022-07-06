<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
Use Session;


class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {  

            return view('auth.login');
        
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
       //valida si el usuario esta deshabilitado segun el estado
        $con = DB::table('users')->where('users.email', '=', $request->email)->where('users.id_estado', '=', '1')->count();
        
        if($con!=0){

            $request->authenticate();

            $request->session()->regenerate();
    
            return redirect()->intended(RouteServiceProvider::HOME);

        }else{
            Session::flash('errorInicio','Lo sentimos! Tu usuario ha sido deshabilitado');
            return back();
        }
       
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}

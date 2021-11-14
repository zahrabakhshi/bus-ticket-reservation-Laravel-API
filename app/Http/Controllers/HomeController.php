<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        return view('home');
    }

    public function createViewParam(){
        $user_roles = array_column(Auth::user()->roles->toArray(),'name');
        if(in_array('super-admin',$user_roles)){

        }
        if(in_array('admin',$user_roles)){

        }
        if(in_array('company',$user_roles)){
            $date = [
                'vehicle' => [

                ]
            ];
        }
        if(in_array('user',$user_roles)){

        }
    }
}

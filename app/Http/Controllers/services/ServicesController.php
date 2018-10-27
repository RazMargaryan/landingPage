<?php

namespace App\Http\Controllers\services;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service;

class ServicesController extends Controller
{
    public function index (){
        if(view()->exists('admin.service')){
            $services = Service::all();
            $data = ['title'=>'Services', 'services'=>$services];
            return view('admin.service',$data);
        }
        abort(404);
    }
}

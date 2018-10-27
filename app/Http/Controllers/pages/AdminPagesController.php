<?php

namespace App\Http\Controllers\pages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Page;

class AdminPagesController extends Controller
{
    public function index(){

        if(view()->exists('admin.pages')){
            $page = Page::all();
            $data = ['title'=>'Pages', 'pages'=>$page];
            return view('admin.pages', $data);
        }
        abort(404);

    }
}

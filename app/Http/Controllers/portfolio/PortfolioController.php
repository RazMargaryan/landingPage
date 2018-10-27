<?php

namespace App\Http\Controllers\portfolio;

use App\Portfolio;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PortfolioController extends Controller
{
    public function index (){
        if(view()->exists('admin.portfolio')){
            $portfolios = Portfolio::all();
            $data = ['title'=>'Portfolio', 'portfolios'=>$portfolios];
            return view('admin.portfolio',$data);
        }
        abort(404);
    }
}

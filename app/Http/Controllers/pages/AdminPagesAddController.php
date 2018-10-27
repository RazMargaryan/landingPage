<?php

namespace App\Http\Controllers\pages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Page;
use Illuminate\Validation\Rule;

class AdminPagesAddController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(){
        if(view()->exists('admin.pages_add')){
            $data = ['title'=>'New page'];
            return view('admin.pages_add', $data);
        }
        abort(404);
        }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {

        $input = $request->except('_token');
        $validator = Validator::make($input, [
            'name' => 'required|max:255',
            'alias'=> 'required|unique:pages|max:255',
            'text' =>'required',
            'images'=>'required'
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if($request->hasFile('images')){
            $file = $request->file('images');
            $input['images'] = $file->getClientOriginalname();
            $file->move(public_path('./assets/img'), $input['images']);
        }
        $page = new Page();
        $page->fill($input);
        if($page->save()){
            return redirect('admin')->with('status', 'Pages added');
        }

    }



}

<?php

namespace App\Http\Controllers\portfolio;

use App\Portfolio;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PortfolioAddController extends Controller
{

    public function show(){
        if(view()->exists('admin.portfolio_add')){
            $data = ['title'=>'Добавления портфолио'];
            return view('admin.portfolio_add', $data);
        }
    }

    public function store(Request $request)
    {
        $input = $request->except('_token');
       $validator = Validator::make($input, [
          'name'=>'required|max:255',
          'filter'=>'required|max:255',
           'images'=>'required'
       ]);
       if($validator->fails()){
           return redirect()->back()->withErrors($validator)->withInput();
       }
        $images = $request->file('images');
        $input['images'] = $images->getClientOriginalname();
        $images->move(public_path('./assets/img'), $input['images']);
        $portfolio = new Portfolio();
        $portfolio->fill($input);
        if($portfolio->save()){
            return redirect('admin')->with('status', 'Портфолио добавлена');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

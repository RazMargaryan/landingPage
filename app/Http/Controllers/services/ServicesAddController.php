<?php

namespace App\Http\Controllers\services;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Service;
use Illuminate\Support\Facades\Validator;

class ServicesAddController extends Controller
{

    public function index()
    {
        if(view()->exists('admin.service_add')){
            $title = ['title'=>'Новый сервис'];
            return view('admin.service_add', $title);

        }
    }

    public function create(Request $request){

        $input = $request->except('_token');
        $messages = [
            'required' => 'Поле :attribute обязатеьно к заполнению',
            'unique' => 'Поле :attribute должно быть уникальным'
        ];
        $validator = Validator::make($input, [
            'name'=>'required|max:255',
            'text'=>'required| max: 2000'
        ], $messages);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $services = new Service();
        $services->fill($input);
        if($services->save()){
            return redirect('admin/services')->with('status', 'Сервис добавлен');
        }

    }

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

<?php

namespace App\Http\Controllers\services;

use App\Service;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServicesEditController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $serviceData = Service::find($id)->toArray();
        $data= [
          'title'=> 'Редактирование страницы - ' . $serviceData['name'],
          'data'=>$serviceData
        ];
        return view('admin.services_edit', $data);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Service $service, Request $request)
    {
        $inputData = $request->except('_token');
        $messages = [
          'name'=>'Поле :attribute обьязательно к заполнению',
          'text'=>'Поле :attribute обьязательно к заполнению'
        ];
        $validator = Validator::make($inputData, [
           'name'=> 'required|max:255',
           'text' => 'required|max:2000'
        ], $messages);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator);
        }
        $service->fill($inputData);
        if($service->update()){
            return redirect('admin/services')->with('status', 'Сервис обнавлен');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $serviceDelete = Service::find($id);
        if($serviceDelete->delete()){
            return redirect('admin/services')->with('status', 'Сервис удалена');
        }
    }
}

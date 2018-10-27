<?php

namespace App\Http\Controllers\portfolio;

use App\Portfolio;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PortfolioEditController extends Controller
{


    public function index($id)
    {
        if($id){
            $old = Portfolio::find($id)->toArray();
            $data = ["title"=> "Редактирование страницы" . $old['name'], 'data'=>$old];
            return view('admin.portfolio_edit', $data);
        }
    }


    public function update(Portfolio $portfolio ,Request $request)
    {
        $inputData = $request->except('_token');
        $validator = Validator::make($inputData, [
            'name'=> 'required| max:255',
            'filter'=>'required|max:255',
            //'images'=>'required'
        ]);

        if($validator->fails()){
            return redirect()->route('portfolioEdit',['portfolio' => $inputData['id']])->withErrors($validator);
        }
        if($request->hasFile('images')){
            $file = $request->file('images');
            $file->move(public_path('assets/img '), $file->getClientOriginalName());
            $inputData['images'] = $file->getClientOriginalName();
        }else{
            $inputData['images'] = $inputData['old_images'];
        }
        unset($inputData['old_images']);
        //$portfolio = new Portfolio();
        $portfolio->fill($inputData);
        if($portfolio->update()){

            return redirect('admin/portfolio')->with('status', 'Страница обновлена');
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
        if($id){
            $portItem = Portfolio::find($id);
            $portItem->delete();
            return redirect('admin/portfolio')->with('status', 'Страница удалена');
        }
        abort(404);
    }
}

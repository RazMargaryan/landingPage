<?php

namespace App\Http\Controllers\pages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Page;

class AdminPagesEditController extends Controller
{


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if($id && view()->exists('admin.pages_edit')){
            $page = Page::find($id);
            $page = $page->toArray();
            $data = ['title'=> 'Редактирование страницы -  ' . $page['name'], 'data'=>$page ];
            return view('admin.pages_edit', $data);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Page $page, Request $request) {

        $input = $request->except('_token');
        $validator = Validator::make($input, [
            'name'=>'required|max:255',
            'alias'=>'required|max:255|unique:pages,id,' . $input['id'],
            'text'=>'required'
        ]);
        if($validator->fails()) {
            //dd($validator);
            return redirect()->route('showPageEdit',['page' => $input['id']])->withErrors($validator);
        }
        if($request->hasFile('images')) {
            $file = $request->file('images');
            $file->move(public_path().'/assets/img', $file->getClientOriginalName());
            $input['images'] = $file->getClientOriginalName();

        }
        else {
            $input['images'] = $input['old_images'];
        }
        unset($input['old_images']);
        $page->fill($input);
        if($page->update()) {
            return redirect('admin')->with('status', 'Страница обновлена');
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
        $deletePage = Page::find($id);
        $deletePage->delete();
            return redirect('admin/pages')->with('status', 'Страница удалена');
    }
}

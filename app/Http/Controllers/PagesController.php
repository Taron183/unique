<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Page;

use Validator;


class PagesController extends Controller
{
    public  function execute(){
        if(view()->exists('admin.pages')){

            $pages = Page::all();

            $data =[
                'title' => 'Pages',
                'pages' => $pages

                ];

            return view('admin.pages',$data);

        }else{
            abort(404);
        }
    }


    public function pagesAdd(Request $request){

        if($request->isMethod('post')){
            $input = $request->except('_token');

            $validator = Validator::make($input,[
                'name' => 'required|max:255',
                'alias' => 'required|unique:pages|max:255',
                'text' => 'required'
            ]);

            if($validator->fails()){
              return redirect()->route('pagesAdd')->withErrors($validator)->withInput();

            }

            if($request->hasFile('images')){
                $file = $request->file('images');
                $input['images'] = $file->getClientOriginalName();

                $file->move(public_path().'/assets/img',$input['images']);
            }

            $page = new Page();
            $page->fill($input);

            if($page->save()){
                return redirect('admin')->with('status','Page added');
            }



        }

        if(view()->exists('admin.pages_add')){

                $data = [
                    'title' => 'New title',

                ];

            return view('admin.pages_add',$data);

        }else{
            abort(404);
        }
    }


    public  function edit(Page $page,Request $request){


        if($request->isMethod('delete')){
            $page->delete();

            return redirect('admin')->with('status','Delete Page');
        }


        if($request->isMethod('post')){
            $input = $request->except('_token');

            $validator = Validator::make($input,[
                'name' => 'required|max:255',
                'alias' => 'required|max:255|unique:pages,alias,'.$input['id'],
                'text' => 'required',
            ]);

            if($validator->fails()){
                return redirect()
                    ->route('pagesEdit', ['page'=>$input['id']])
                    ->withErrors($validator);
            }

            if($request->hasFile('images')){

                $file = $request->file('images');
                $file->move(public_path().'/assets/img',$file->getClientOriginalName());
                $input['images'] = $file->getClientOriginalName();

            }
            else{

                $input['images'] = $input['old_images'];
            }

            unset($input['old_images']);

            $page->fill($input);

            if($page->update()){
                return  redirect('admin')->with('status', 'Page Refresh');
            }
        }


        // $page = Page::find($id);

        $old = $page->toArray();
       if(view()->exists('admin.pages_edit')){

           $data = [
               'title' => 'Edit page -'.$old['name'],
               'data' => $old
           ];

           return view('admin.pages_edit',$data);

       }else{
           abort(404);
       }
    }
}

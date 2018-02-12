<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Page;
use App\People;
use App\Portfolio;
use App\Service;
use DB;
use Mail;

class IndexController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function execute(Request $request){

         $messages = [
             'required' => 'Required :attribute fields',
             'email' => 'Fields :attribute must compose an email
'
         ];

        if($request->isMethod('post')){

            $this->validate($request,[
               'name' => 'required|max:255',
               'email' => 'required|email',
               'text' => 'required'

            ],$messages);

            $data = $request->all();
           $result = Mail::send('site.email', ['data'=>$data], function($messages) use ($data){
                $mail_admin = env('MAIL_ADMIN');

                $messages->from($data['email'],$data['name']);
                $messages->to($mail_admin)->subject('Question');
            });

            if($result){
                return redirect()->route('home')->with('status','Email is send');
            }

        }




        $pages = Page::all();
        $portfolios = Portfolio::get(array('name','filter','images'));
        $services = Service::where('id','<',20)->get();
        $peoples = People::take(3)->get();

        $tags = DB::table('portfolios')->distinct()->pluck('filter')->all();




        $menu = array();

        foreach($pages as $page){
            $item = array('title' => $page->name, 'alias' => $page->alias);
            array_push($menu,$item);
        }



        $item = array('title' => 'Services', 'alias' => 'service');
        array_push($menu,$item);

        $item = array('title' => 'Portfolio', 'alias' => 'Portfolio');
        array_push($menu,$item);

        $item = array('title' => 'Team', 'alias' => 'team');
        array_push($menu,$item);

        $item = array('title' => 'Contact', 'alias' => 'contact');
        array_push($menu,$item);



        return view('site.index', array(

                    'menu' => $menu,
                    'pages' => $pages,
                    'services' => $services,
                    'portfolios' => $portfolios,
                    'peoples' => $peoples,
                    'tags' => $tags,

        ));
    }
}

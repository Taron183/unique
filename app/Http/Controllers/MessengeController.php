<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Messenge;

class MessengeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $from_id = $_SESSION['user_id'];
        $to_id = $_GET['to_id'];
        $last_id = $_GET['last_id'];



        $d =  Messenge::

        leftJoin('users', 'users.id', '=', 'messages.from_id')
            ->where(function($query) use ($from_id, $to_id ) {
                $query->where(function($query) use ($from_id, $to_id ) {
                    $query->where('messages.from_id', '=', $to_id);
                    $query->where('messages.to_id', '=', $from_id);
                });
                $query->orWhere(function($query)  use ($from_id, $to_id ) {
                    $query->where('messages.from_id', '=', $from_id);
                    $query->where('messages.to_id', '=', $to_id);
                });
            })
            ->select('messages.*',  'users.name')
            ->orderBy('messages.created_at', 'asc')
            ->where('messages.id', '>', $last_id)


            ->get();


        return response()->json($d);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        



    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $text = $_POST['text'];
        $to_id = $_POST['to_id'];
        $from_id = $_SESSION['user_id'];



        $data =[
            'text' => $text,
            'from_id' => $from_id,
            'to_id' => $to_id

        ];

         Messenge::create($data);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {



    }

    /**
     * Show the form for editing the specified resource.
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

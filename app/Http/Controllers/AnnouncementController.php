<?php

namespace App\Http\Controllers;

use App\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $query = Announcement::query();
        $search_info = '';

        $query->where('type','<=',1);
        $query->orderBy('create_date','DESC');

        if($request->has('search_info')){
            $search_info = $request->input('search_info');
        }
        if($search_info != ''){
            $query->where('title', 'like', "%{$search_info}%");
        }


        $announcements = $query->paginate(15);
//        $announcements = $query->get();


        $data = [
            'announcements' => $announcements,
            'search_info' => $search_info,

        ];


        return view('announcement',$data);
    }


    public function index_search(Request $request)
    {
        $query = Announcement::query();
        $search_info = '';

        $query->where('type','=',2);
        $query->orderBy('create_date','DESC');

        if($request->has('search_info')){
            $search_info = $request->input('search_info');
        }
        if($search_info != ''){
            $query->where('title', 'like', "%{$search_info}%");
        }



        $announcements = $query->paginate(15);
//        $announcements = $query->get();


        $data = [
            'announcements' => $announcements,
            'search_info' => $search_info,
        ];


        return view('search',$data);
    }


    public function content($id , Request $request)
    {

        $ann = Announcement::find($id);
        $data =[
            'ann' => $ann,
        ];

        return view('content',$data);



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

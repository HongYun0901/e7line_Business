<?php

namespace App\Http\Controllers\Admin;

use App\Announcement;
use App\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        //

        $query = Announcement::query();
        $sortBy_text = ['建立日期', '截止日期'];
        $date_from = now()->subDays(7)->format('Y-m-d');
        $date_to = now()->format('Y-m-d');
        $search_type = 0;
        $search_info = '';
        $sortBy = 'create_date';
        $type_filter = -1;

        $query->where('type','<=',1);


        if(Auth::user()->level != 2){
            $query->where('company_id','=',Auth::user()->company->id);
        }

        if ($request->has('sortBy')) {
            $sortBy = $request->input('sortBy');
        }

        if ($request->has('type_filter')) {
            $type_filter = $request->input('type_filter');
        }
        if ($type_filter >= 0) {
            $query->where('type', '=', $type_filter);
        }


        if ($request->has('date_from')) {
            $date_from = $request->input('date_from');
        }
        if ($request->has('date_to')) {
            $date_to = $request->input('date_to');
        }
        if ($date_from != null && $date_to != null) {
            $date_from_addtime = $date_from . " 00:00:00";
            $date_to_addtime = $date_to . " 23:59:59";
            $query->whereBetween( $sortBy, [$date_from_addtime, $date_to_addtime]);
        }

        if ($request->has('search_type')) {
            $search_type = $request->query('search_type');
        }
        if ($search_type > 0) {
            $search_info = $request->query('search_info');
            switch ($search_type) {
                case 1:
                    $query->where('title', 'like', "%{$search_info}%");
                    break;

                default:
                    break;
            }
        }




        $query->orderBy($sortBy,'DESC');
        $announcements = $query->paginate(15);
        $data = [
            'announcements' =>$announcements,
            'date_to' => $date_to,
            'date_from' => $date_from,
            'search_type' => $search_type,
            'search_info' => $search_info,
            'sortBy' => $sortBy,
            'type_filter' => $type_filter,
            'sortBy_text' => $sortBy_text,
        ];

        return view('admin.announcement.index',$data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        $companies = Company::all();


        $data = [
            'companies' => $companies,
        ];

        return view('admin.announcement.create',$data);
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
        $this->validate($request, [
            'type' => 'required',
            'content' => 'required',
            'title' => 'required',
        ]);


        $new_ann = Announcement::create([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'user_id'=> Auth::user()->id,
            'company_id' => Auth::user()->company->id,
            'type' => $request->input('type'),
            'create_date' => now(),
            'update_date' => now(),
        ]);

        return redirect()->route('admin_announcement.index');


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
    public function edit(Announcement $announcement , Request $request)
    {
        //
//        dd($request);
//        dd($announcement);
        $data = [
            'announcement' => $announcement,
            'source_html' => $request->input('source_html'),
        ];

        return view('admin.announcement.edit' , $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Announcement $announcement)
    {
        //
        $this->validate($request, [
            'type' => 'required',
            'content' => 'required',
            'title' => 'required',
        ]);

        $announcement->type = $request->input('type');
        $announcement->content = $request->input('content');
        $announcement->title = $request->input('title');
        $announcement->update_date = now();
        $announcement->update();

//        return Redirect::to();
        return redirect()->to($request->input('source_html'));

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

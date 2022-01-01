<?php

namespace App\Http\Controllers\Students;
use App\Http\Controllers\Controller;

use App\Grade;
use App\students;
use Illuminate\Http\Request;

class GradueatedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $students = students::onlyTrashed()->get();
        return view('pages.Students.Graduated.index',compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $Grades  = Grade::all();
        return view('pages.students.Graduated.create',compact('Grades'));

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
        $students = students::where('Grade_id',$request->Grade_id)->where('Classroom_id',$request->Classroom_id)->where('section_id',$request->section_id)->get();

        if($students->count() < 1){
            return redirect()->back()->with('error_Graduated', __('لاتوجد بيانات في جدول الطلاب'));
        }

        foreach ($students as $student) {
            
            $ids = explode(',',$student->id);
            
            students::whereIn('id',$ids)->Delete();
        }

        toastr()->success(trans('messages.success'));
        return redirect()->route('Graduated.index');
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
    public function update(Request $request)
    {
        //

        students::onlyTrashed()->where('id',$request->id)->first()->restore();
        toastr()->success(trans('messages.success'));
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        students::onlyTrashed()->where('id',$request->id)->first()->forceDelete();
        toastr()->success(trans('messages.Delete'));
        return redirect()->back();
    }


    public function SoftDelte(Request $request)
    {
        //
    }
}

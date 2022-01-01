<?php

namespace App\Http\Controllers\sections;

use App\Http\Controllers\Controller;

use App\sections;
use App\Grade;
use App\classrooms;
use App\teacher;
use Illuminate\Http\Request;

class SectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $Grades = Grade::with(['section'])->get();

        $list_Grades = Grade::all();
        $teachers = teacher::all();
   
        return view('pages.sections.mainSection',compact('Grades','list_Grades','teachers'));
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
        
       /* if(sections::where('Name_Section->ar','=',$request->Name_Section_Ar)->orWhere('Name_Section->en','=',$request->Name_Section_En)->exists())
        {
          return back()->withErrors(trans('Grades_trans.exists'));
        }*/
        $validate = $request->validate([
            'Name_Section_Ar'=>'required',
            'Name_Section_En'=>'required',
            'Grade_id'=>'required',
            'Class_id'=>'required',
          ],
        [
          'Name_Section_Ar.required'=>trans('validation.required'),
          'Name_Section_En.required'=>trans('validation.required'),
          'Grade_id.required'=> trans('validation.required'),
          'Class_id.required'=> trans('validation.required'),
        ]);
        $sections = new sections();

        $sections->Name_Section = ['en'=>$request->Name_Section_En, 'ar'=>$request->Name_Section_Ar];
        $sections->Grade_id = $request->Grade_id;
        $sections->Class_id = $request->Class_id;
        $sections->Status = 1;
        $sections->save();

      
        $sections->teacher()->attach($request->teacher_id);

        toastr()->success(trans('messages.success'));

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function show(sections $sections)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function edit(sections $sections)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //


        $sections = sections::findOrFail($request->id);

        $sections->Name_Section = ['ar'=>$request->Name_Section_Ar  ,'en'=>$request->Name_Section_En];
        $sections->Grade_id = $request->Grade_id;
        $sections->Class_id = $request->Class_id;

        if(isset($request->Status))
        {
            $sections->Status =1;
        }
        else
        {
            $sections->Status =0;
        }

              // update pivot tABLE
              if (isset($request->teacher_id)) {
                $sections->teacher()->sync($request->teacher_id);
            } else {
                $sections->teacher()->sync(array());
            }
    
        
        $sections->save();

        toastr()->success(trans('message.success'));

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function destroy(sections $sections)
    {
        //
    }


    public function ajax($id)
    {
        $classrooms = classrooms::where('Grade_id','=',$id)->pluck('Name_Class','id');

        return $classrooms;
    }
}

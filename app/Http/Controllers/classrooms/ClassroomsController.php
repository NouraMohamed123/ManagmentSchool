<?php

namespace App\Http\Controllers\classrooms;

use App\Http\Controllers\Controller;
use App\Grade;
use App\Classrooms;

use Illuminate\Http\Request;

class ClassroomsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $My_Classes = Classrooms::all();

        $Grades = Grade::all();
        return view('pages.My_Classes.My_Classes',compact('My_Classes','Grades'));
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

      /*  $validate = $request->validate([
            'Name'=>'required',
            'Name_class_en'=>'required',
 
          ],
        [
          'Name.required'=>trans('validation.required'),
          'Name_class_en.required'=>trans('validation.required'),
        ]);*/

        $validate = $request->validate([
            'List_Classes.*.Name'=>'required',
            'List_Classes.*.Name_class_en'=>'required',
        ],
        [
            'List_Classes.*.Name'=>trans('validation.required'),
            'List_Classes.*.Name_class_en'=>trans('validation.required'),
        ]);

        $listClass = $request->List_Classes; 

        try {

  

            foreach($listClass as $list)
            {
                $My_Classes = new Classrooms();

                $My_Classes->Name_Class = ['en'=>$list["Name_class_en"] , 'ar'=>$list['Name']];

                $My_Classes->Grade_id = $list['Grade_id'];

                $My_Classes->save();

            }

            
            
            toastr()->success(trans('message.success'));

                
            return back();
            
        } catch (\Exception $e) {
            return back()->withErrors(['error'=>$e->getMessage()]);
        }
    
    


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Classrooms  $classrooms
     * @return \Illuminate\Http\Response
     */
    public function show(Classrooms $classrooms)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Classrooms  $classrooms
     * @return \Illuminate\Http\Response
     */
    public function edit(Classrooms $classrooms)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Classrooms  $classrooms
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {


        try {
            $classrooms = Classrooms::findOrFail($request->id);
            $classrooms->update([
    
                $classrooms->Name_Class = ['en'=>$request->Name_en , 'ar'=>$request->Name],
                $classrooms->Grade_id = $request->Grade_id,
    
            ]);
    
    
            $classrooms->save();
            toastr()->success(trans('message.Update'));

            return back();
        } catch  (\Exception $e) {
            return back()->withErrors(['error'=>$e->getMessage()]);;
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Classrooms  $classrooms
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //

        Classrooms::findOrFail($request->id)->delete();
        toastr()->error(trans('message.Delete'));
        return back();
    }


    public function delete_all(Request $request)
    {
        $delete_all = explode(',',$request->delete_all_id);

        Classrooms::whereIn('id',$delete_all)->Delete();

        toastr()->error(trans('message.Delete'));
        return back();
    }


    public function Filter_Classes(Request $request)
    {
        $Grades = Grade::all();
        $search = Classrooms::select('*')->where('Grade_id','=',$request->Grade_id)->get();
       

        return view('pages.My_Classes.My_Classes',compact('Grades'))->withDetails($search);
    }
}

<?php

namespace App\Http\Controllers\Students;
use App\Http\Controllers\Controller;
use App\students;
use App\Grade;
use App\promotions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class PromotionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $Grades = Grade::all();
        return view('pages.students.promotion.index',compact('Grades'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $promotions = promotions::all();
        return view('pages.students.promotion.management',compact('promotions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $students = students::where('Grade_id',$request->Grade_id)->where('Classroom_id',$request->Classroom_id)->where('section_id',$request->section_id)->get();
        DB::beginTransaction();
        try {
            foreach ($students as $student) {
                $ids =  explode(',',$student->id);
    
                students::whereIn('id',$ids)->update([
                   
                    'Grade_id' => $request->Grade_id_new,
                    'Classroom_id' => $request->Classroom_id_new,
                    'section_id' => $request->section_id_new,
                    'section_id'=>$request->section_id_new,
                    'academic_year'=>$request->academic_year_new,
    
                ]);
    
                // insert in to promotions
                promotions::updateOrCreate([
                'student_id'=>$student->id,
                'from_grade'=>$request->Grade_id,
                'from_Classroom'=>$request->Classroom_id,
                'from_section'=>$request->section_id,
                'to_grade'=>$request->Grade_id_new,
                'to_Classroom'=>$request->Classroom_id_new,
                'to_section'=>$request->section_id_new,
                'academic_year'=>$request->academic_year,
                'academic_year_new'=>$request->academic_year_new,
                ]);
    
             
            }
            DB::commit();
            toastr()->success(trans('messages.success'));
            return redirect()->back();
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
      
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\promotions  $promotions
     * @return \Illuminate\Http\Response
     */
    public function show(promotions $promotions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\promotions  $promotions
     * @return \Illuminate\Http\Response
     */
    public function edit(promotions $promotions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\promotions  $promotions
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, promotions $promotions)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\promotions  $promotions
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        DB::beginTransaction();
        try {
            if($request->page_id == 1)
            {
                $promotions = promotions::all();
                
                foreach ($promotions as $promotion) {
                    $ids = explode(',',$promotion->id); 

                    students::wherein('id',$ids)->update([
                        'Grade_id'=>$promotion->from_grade,
                        'Classroom_id'=>$promotion->from_Classroom ,
                        'section_id'=>$promotion->from_section,
                        'academic_year'=>$promotion->academic_year,
                    ]);
                    promotions::truncate();

                }
                DB::commit();
                toastr()->error(trans('messages.Delete'));
                return redirect()->back();
                
            }
            else
            {
                $Promotion = Promotion::findorfail($request->id);
                student::where('id', $Promotion->student_id)
                    ->update([
                        'Grade_id'=>$Promotion->from_grade,
                        'Classroom_id'=>$Promotion->from_Classroom,
                        'section_id'=> $Promotion->from_section,
                        'academic_year'=>$Promotion->academic_year,
                    ]);


                Promotion::destroy($request->id);
              //  DB::commit();
                toastr()->error(trans('messages.Delete'));
                return redirect()->back();

                
            }
        } catch (\Throwable $th) {
            //throw $th;
        }


    }
}

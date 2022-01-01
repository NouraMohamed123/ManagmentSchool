<?php

namespace App\Http\Controllers\Fees;
use App\Http\Controllers\Controller;
use App\fees;

use App\Grade;

use Illuminate\Http\Request;

class FeesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fees = fees::all();
        $Grades = Grade::all();
        return view('pages.Fees.index',compact('fees','Grades'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $Grades = Grade::all();
        return view('pages.Fees.add',compact('Grades'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            $fees = new fees();
            $fees->title = ['en' => $request->title_en, 'ar' => $request->title_ar];
            $fees->amount  =$request->amount;
            $fees->Grade_id  =$request->Grade_id;
            $fees->Classroom_id  =$request->Classroom_id;
            $fees->description  =$request->description;
            $fees->year  =$request->year;
            $fees->Fee_type =$request->Fee_type;
            $fees->save();
            toastr()->success(trans('messages.success'));
            return redirect()->route('Fees.index');

        }

        catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\fees  $fees
     * @return \Illuminate\Http\Response
     */
    public function show(fees $fees)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\fees  $fees
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $fee = fees::findorfail($id);
        $Grades = Grade::all();
        return view('pages.Fees.edit',compact('fee','Grades'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\fees  $fees
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, fees $fees)
    {
        try {
            $fees = fees::findorfail($request->id);
            $fees->title = ['en' => $request->title_en, 'ar' => $request->title_ar];
            $fees->amount  =$request->amount;
            $fees->Grade_id  =$request->Grade_id;
            $fees->Classroom_id  =$request->Classroom_id;
            $fees->description  =$request->description;
            $fees->Fee_type =$request->Fee_type;
            $fees->year  =$request->year;
            $fees->save();
            toastr()->success(trans('messages.Update'));
            return redirect()->route('Fees.index');
        }

        catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\fees  $fees
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            fees::destroy($request->id);
            toastr()->error(trans('messages.Delete'));
            return redirect()->back();
        }

        catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}

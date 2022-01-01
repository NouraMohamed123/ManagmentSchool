<?php 

namespace App\Http\Controllers\Grades;

use App\Http\Controllers\Controller;

use App\Grade;

use App\Classrooms;

use Illuminate\Http\Request;



class GradeController extends Controller 
{

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
    $grades = Grade::all();
    return view('pages.Grades.Grades',compact('grades'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
    
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store(Request $request)
  {

    if(Grade::where('Name->ar','=',$request->Name)->orWhere('Name->en','=',$request->Name_en)->exists())
    {
      return back()->withErrors(trans('Grades_trans.exists'));
    }
    $validate = $request->validate([
      'Name'=>'required',
      'Name_en'=>'required',
      'Notes'=>'required',
    ],
  [
    'Name.required'=>trans('validation.required'),
    'Name_en.required'=>trans('validation.required'),
    'Notes.required'=> trans('validation.required'),
  ]);
    try {




    $Grades = new Grade();

    $Grades->Name = ['en' => $request->Name_en, 'ar' => $request->Name];

    $Grades->Notes = $request->Notes;

    $Grades->save();

    toastr()->success(trans('message.success'));

  

    return back();

    } catch (\Exception $e) {
      
      return back()->withErrors(['error'=>$e->getMessage()]);
    }

  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id)
  {
    
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
  {
    
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update(Request $request)
  {
    if(Grade::where('Name->ar','=',$request->Name)->orWhere('Name->en','=',$request->Name_en)->exists())
    {
      return back()->withErrors(trans('Grades_trans.exists'));
    }

    $validate = $request->validate([
      'Name'=>'required ',
      'Name_en'=>'required',
      'Notes'=>'required',
    ],
  [
    'Name.required'=>trans('validation.required'),
    'Name_en.required'=>trans('validation.required'),
    'Notes.required'=> trans('validation.required'),
  ]);



    try {



    $Grades = Grade::findOrFail($request->id);

    $Grades->update([

      $Grades->Name = [ 'ar'=>$request->Name , 'en'=> $request->Name=$request->Name_en],

      $Grades->Notes = $request->Notes,

    ]);

    toastr()->success(trans('message.Update'));


    return back();

    } catch (\Exception $e) {
      
      return back()->withErrors(['error'=>$e->getMessage()]);
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy(Request $request)
  {
/*
    try {
      //code...
      Grade::findOrFail($request->id)->delete();
      toastr()->success(trans('message.Delete'));
      return back();
  
    } 

    catch (\Exception $e) {
      
      return back()->withErrors(['error'=>$e->getMessage()]);
    }*/

    $classrooms = Classrooms::where('Grade_id','=',$request->id)->pluck('Grade_id');


    if($classrooms->count() == 0)
    {
      Grade::findOrFail($request->id)->delete();
      toastr()->error(trans('message.Delete'));
      return back();
    }
    else
    {
      toastr()->error(trans('message.Delete'));
      return back();
    }


  }
  
}

?>
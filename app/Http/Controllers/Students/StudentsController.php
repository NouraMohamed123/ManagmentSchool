<?php

namespace App\Http\Controllers\students;

use App\Http\Controllers\Controller;

use App\Classrooms;
use App\Grade;
use App\Gender;
use App\My_Parents;
use App\Nationalitie;
use App\sections;
use App\students;
use App\Type_Blood;
use App\Image;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = students::all();
        return view('pages.students.index',compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        $Genders = Gender::all();
        $Grades = Grade::all();
        $nationals = Nationalitie::all();
        $bloods = Type_Blood::all();
        $my_classes = Classrooms::all();        
        $parents = My_Parents::all();



        return view('pages.students.add',compact('Genders','nationals','bloods','my_classes','parents','Grades'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $students = new students();
            $students->name = ['en' => $request->name_en, 'ar' => $request->name_ar];
            $students->email = $request->email;
            $students->password = Hash::make($request->password);
            $students->gender_id = $request->gender_id;
            $students->nationalitie_id = $request->nationalitie_id;
            $students->blood_id = $request->blood_id;
            $students->Date_Birth = $request->Date_Birth;
            $students->Grade_id = $request->Grade_id;
            $students->Classroom_id = $request->Classroom_id;
            $students->section_id = $request->section_id;
            $students->parent_id = $request->parent_id;
            $students->academic_year = $request->academic_year;
            $students->save();

            
            // insert img
            if($request->hasfile('photos'))
            {
                foreach($request->file('photos') as $file)
                {
                    $name = $file->getClientOriginalName();
                    $file->storeAs('attachments/students/'.$students->name, $file->getClientOriginalName(),'upload_attachments');

                    // insert in image_table
                    $images= new Image();
                    $images->filename=$name;
                    $images->imageable_id= $students->id;
                    $images->imageable_type = 'App\students';
                    $images->save();
                }
            }
            DB::commit(); // insert data
            toastr()->success(trans('messages.success'));
            return redirect()->route('Students.create');
        }

        catch (\Exception $e){
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\students  $students
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $Student = students::findOrFail($id);

        return view('pages.students.show',compact('Student'));
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\students  $students
     * @return \Illuminate\Http\Response
     */
    public function edit( $id)
    {
        //
        $Students = students::findOrFail($id);
        $Genders  = Gender::all();
        $nationals = Nationalitie::all();
        $bloods  = Type_Blood::all();
        $Grades  = Grade::all();
        $parents = My_Parents::all();
        return view('pages.students.edit',compact('Students','Genders','nationals','bloods','Grades','parents'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\students  $students
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            $Edit_Students = students::findorfail($request->id);
            $Edit_Students->name = ['ar' => $request->name_ar, 'en' => $request->name_en];
            $Edit_Students->email = $request->email;
            $Edit_Students->password = Hash::make($request->password);
            $Edit_Students->gender_id = $request->gender_id;
            $Edit_Students->nationalitie_id = $request->nationalitie_id;
            $Edit_Students->blood_id = $request->blood_id;
            $Edit_Students->Date_Birth = $request->Date_Birth;
            $Edit_Students->Grade_id = $request->Grade_id;
            $Edit_Students->Classroom_id = $request->Classroom_id;
            $Edit_Students->section_id = $request->section_id;
            $Edit_Students->parent_id = $request->parent_id;
            $Edit_Students->academic_year = $request->academic_year;
            $Edit_Students->save();
            
            toastr()->success(trans('messages.Update'));
            return redirect()->route('Students.index');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\students  $students
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //

        students::findOrFail($request->id)->delete();
        toastr()->error(trans('message.Delete'));
        return back();
    }

    
    public function Get_classrooms($id){

        $list_classes = Classrooms::where("Grade_id", $id)->pluck("Name_Class", "id");
        return $list_classes;

    }

    //Get Sections
    public function Get_Sections($id){

        $list_sections = sections::where("Class_id", $id)->pluck("Name_Section", "id");
        return $list_sections;
    }

    public function upload_attachments(Request $request)
    {
       foreach ($request->file('photos') as $file) {

        $name = $file->getClientOriginalName();
        $file->storeAs('attachments/students/'.$request->student_name, $file->getClientOriginalName(),'upload_attachments');

        // insert in image_table
        $images= new Image();
        $images->filename=$name;
        $images->imageable_id= $request->student_id;
        $images->imageable_type = 'App\students';
        $images->save();

       }
       toastr()->success(trans('messages.Update'));
       return back();
    }


    public function Download_attachment($studentsname , $filename)
    {
        return response()->download(public_path('attachments/students/'.$studentsname.'/'.$filename));
    }

    public function Delete_attachment(Request $request)
    {
                // Delete img in server disk
                Storage::disk('upload_attachments')->delete('attachments/students/'.$request->student_name.'/'.$request->filename);

                // Delete in data
                Image::where('id',$request->id)->where('filename',$request->filename)->delete();
                toastr()->error(trans('messages.Delete'));
                return redirect()->route('Students.show',$request->student_id);
    }
}

<?php
namespace App\Repository;

use App\teacher;

use App\spespecializations;
use Illuminate\Support\Facades\Hash;
use App\Gender;

// implementaion
class TeacherRepository implements TeacherRepositoryInterface
{
    public function getAllTeachers()
    {
        return teacher::all();
    }



    public function GetSpecialization()
    {
        return spespecializations::all();
    }
    public function GetGender()
    {
        return Gender::all();
    }

    public function StoreTeacher($request)
    {
        if(teacher::where('Email','=', $request->Email)->exists())
        {
            return back()->withErrors(trans('Grades_trans.exists'));
        }


        $validate = $request->validate([
            'Email'=>'required',
            'Password'=>'required',
            'Specialization_id'=>'required',
            'Gender_id'=>'required',
            'Joining_Date'=>'required',
            'Address'=>'required',
            'Name_en'=>'required',
            'Name_ar'=>'required',
          ],
        [
          'Email.required'=>trans('validation.required'),
          'Password.required'=>trans('validation.required'),
          'Specialization_id.required'=> trans('validation.required'),
          'Gender_id.required'=>trans('validation.required'),
          'Joining_Date.required'=>trans('validation.required'),
          'Address.required'=> trans('validation.required'),
          'Name_en.required'=>trans('validation.required'),
          'Name_ar.required'=>trans('validation.required'),
        ]);

        try {
          
            $teacher = new teacher();

            $teacher->Email = $request->Email;
            $teacher->Password = $request->Password;
            $teacher->Name = ['en'=> $request->Name_en , 'ar'=>$request->Name_ar];
            $teacher->Specialization_id = $request->Specialization_id;
            $teacher->Gender_id = $request->Gender_id;
            $teacher->Joining_Date = $request->Joining_Date;
            $teacher->Address = $request->Address;
    
    
            $teacher->save();

            toastr()->success(trans('message.success'));
    
            return back();
        } catch (\Throwable $th) {
            
        }


    }

    public function EditTeacher($id)
    {
        return teacher::findOrFail($id);
    }


    
    public function UpdateTeachers($request)
    {
        if(teacher::where('Email','=', $request->Email)->exists())
        {
            return back()->withErrors(trans('Grades_trans.exists'));
        }


        $validate = $request->validate([
            'Email'=>'required',
            'Password'=>'required',
            'Specialization_id'=>'required',
            'Gender_id'=>'required',
            'Joining_Date'=>'required',
            'Address'=>'required',
            'Name_en'=>'required',
            'Name_ar'=>'required',
          ],
        [
          'Email.required'=>trans('validation.required'),
          'Password.required'=>trans('validation.required'),
          'Specialization_id.required'=> trans('validation.required'),
          'Gender_id.required'=>trans('validation.required'),
          'Joining_Date.required'=>trans('validation.required'),
          'Address.required'=> trans('validation.required'),
          'Name_en.required'=>trans('validation.required'),
          'Name_ar.required'=>trans('validation.required'),
        ]);

        try {
            $Teachers = teacher::findOrFail($request->id);
            $Teachers->Email = $request->Email;
            $Teachers->Password =  Hash::make($request->Password);
            $Teachers->Name = ['en' => $request->Name_en, 'ar' => $request->Name_ar];
            $Teachers->Specialization_id = $request->Specialization_id;
            $Teachers->Gender_id = $request->Gender_id;
            $Teachers->Joining_Date = $request->Joining_Date;
            $Teachers->Address = $request->Address;
            $Teachers->save();
            toastr()->success(trans('messages.Update'));
            return redirect()->route('teacher.index');
        }
        catch (Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    public function delete($request)
    {

        teacher::findOrFail($request->id)->Delete();
        toastr()->error(trans('message.Delete'));
        return redirect()->route('teacher.index');
        
    }

}


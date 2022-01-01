<?php

namespace App\Http\Controllers\teacher;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Repository\TeacherRepositoryInterface;

class TeacherController extends Controller
{
    protected $teacher;
    public function __construct(TeacherRepositoryInterface $teacher)
    {
        $this->teacher = $teacher;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $Teachers =  $this->teacher->getAllTeachers();

        return view('pages.Teachers.Teachers',compact('Teachers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $specializations = $this->teacher->GetSpecialization();
        $genders = $this->teacher->GetGender();



        return view('pages.Teachers.create',compact('specializations','genders'));
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

       return  $this->teacher->StoreTeacher($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function show($teacher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $specializations = $this->teacher->GetSpecialization();
        $genders = $this->teacher->GetGender();
        $Teachers =$this->teacher->EditTeacher($id);

        return view('pages.Teachers.Edit',compact('Teachers','specializations','genders'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        return $this->teacher->UpdateTeachers($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //

        $this->teacher->delete($request);
    }
}

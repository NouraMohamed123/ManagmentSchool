<?php
use Illuminate\Database\Seeder;
use App\Classrooms;
use App\Gender;
use App\Grade;
use App\My_Parents;
use App\Nationalitie;
use App\sections;
use App\students;
use App\Type_Blood;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('students')->delete();
        $students = new students();
        $students->name = ['ar' => 'احمد ابراهيم', 'en' => 'Ahmed Ibrahim'];
        $students->email = 'Ahmed_Ibrahim@yahoo.com';
        $students->password = Hash::make('12345678');
        $students->gender_id = 1;
        $students->nationalitie_id = Nationalitie::all()->unique()->random()->id;
        $students->blood_id =Type_Blood::all()->unique()->random()->id;
        $students->Date_Birth = date('1995-01-01');
        $students->Grade_id = Grade::all()->unique()->random()->id;
        $students->Classroom_id =Classrooms::all()->unique()->random()->id;
        $students->section_id = sections::all()->unique()->random()->id;
        $students->parent_id = My_Parents::all()->unique()->random()->id;
        $students->academic_year ='2021';
        $students->save();
    }
}

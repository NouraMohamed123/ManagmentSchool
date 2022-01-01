<?php
namespace App\Repository;

interface TeacherRepositoryInterface
{

        // get all function
        public function getAllTeachers();
      
        //GetSpecialization
        public function GetSpecialization();

        //GetGender
        public function GetGender();

        //insert into dataBase

        public function StoreTeacher($request);

          //edit into dataBase

          public function EditTeacher($id);

        // UpdateTeachers
        public function UpdateTeachers($request);


        //delete into dataBase

        public function delete($request);
    


}
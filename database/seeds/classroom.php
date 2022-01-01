<?php


use App\Classrooms;
use App\Grade;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class classroom extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

        public function run()
        {
            DB::table('classrooms')->delete();
            $classrooms = [
                ['en'=> 'First grade', 'ar'=> 'الصف الاول'],
                ['en'=> 'Second grade', 'ar'=> 'الصف الثاني'],
                ['en'=> 'Third grade', 'ar'=> 'الصف الثالث'],
            ];

            foreach ($classrooms as $classroom) {
                Classrooms::create([
                'Name_Class' => $classroom,
                'Grade_id' => Grade::all()->unique()->random()->id
                ]);
            }
    }
}

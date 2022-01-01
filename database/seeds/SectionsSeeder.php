<?php

use Illuminate\Database\Seeder;

use App\Classrooms;
use App\Grade;
use App\sections;
use Illuminate\Support\Facades\DB;
class SectionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sections')->delete();

        $Sections = [
            ['en' => 'a', 'ar' => 'ا'],
            ['en' => 'b', 'ar' => 'ب'],
            ['en' => 'c', 'ar' => 'ت'],
        ];

        foreach ($Sections as $section) {
         sections::create([
                'Name_Section' => $section,
                'Status' => 1,
                'Grade_id' => Grade::all()->unique()->random()->id,
                'Class_id' =>  Classrooms::all()->unique()->random()->id
            ]);
        }
    }
}

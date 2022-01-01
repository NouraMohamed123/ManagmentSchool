<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	public function run()
	{
        $this->call(UserSeeder::class);

		$this->call(BloodTableSeeder::class);
		$this->call(NationalitiesTableSeeder::class);
		$this->call(religionTableSeeder::class);
		$this->call(SpecializationsTableSeeder::class);
		$this->call(GinderSeeder::class);
        $this->call(GradeSeeder::class);
        $this->call(classroom::class);
        $this->call(SectionsSeeder::class);
        $this->call(ParentsSeeder::class);
        $this->call(StudentsSeeder::class);


	}
}

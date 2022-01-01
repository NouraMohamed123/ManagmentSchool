<?php

use App\Type_Blood;

use Illuminate\Support\Facades\DB;

use Illuminate\Database\Seeder;

class BloodTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('type__bloods')->delete();

        $bgs=['O-','O+','AB-','AB+','A-','A+','B+','B-'];

        foreach ($bgs as $bg) {
            
            Type_Blood::create(['Name'=>$bg]);
        }
    }
}

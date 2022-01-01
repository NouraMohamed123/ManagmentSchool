<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fee_invoices extends Model
{

    public function grade()
    {
        return $this->belongsTo('App\Grade', 'Grade_id');
    }


    public function classroom()
    {
        return $this->belongsTo('App\Classrooms', 'Classroom_id');
    }


    public function section()
    {
        return $this->belongsTo('App\Sections', 'section_id');
    }

    public function student()
    {
        return $this->belongsTo('App\Students', 'student_id');
    }

    public function fees()
    {
        return $this->belongsTo('App\fees', 'fee_id');
    }
}

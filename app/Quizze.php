<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
class Quizze extends Model
{
    use HasTranslations;

    public $translatable = ['name'];

    protected $guarded=[];
    public function teacher()
    {
        return $this->belongsTo('App\teacher', 'teacher_id');
    }



    public function subject()
    {
        return $this->belongsTo('App\Subject', 'subject_id');
    }


    public function grade()
    {
        return $this->belongsTo('App\Grade', 'grade_id');
    }


    public function classroom()
    {
        return $this->belongsTo('App\Classrooms', 'classroom_id');
    }


    public function section()
    {
        return $this->belongsTo('App\sections', 'section_id');
    }
}

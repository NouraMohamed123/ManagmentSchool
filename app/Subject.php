<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
class Subject extends Model
{
    use HasTranslations;

    public $translatable = ['name'];

    protected $guarded=[];


    // جلب اسم المراحل الدراسية

    public function grade()
    {
        return $this->belongsTo('App\Grade', 'grade_id');
    }

    // جلب اسم الصفوف الدراسية
    public function classroom()
    {
        return $this->belongsTo('App\Classrooms', 'classroom_id');
    }

    // جلب اسم المعلم
    public function teacher()
    {
        return $this->belongsTo('App\Teacher', 'teacher_id');
    }
}
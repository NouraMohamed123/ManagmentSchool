<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
class fees extends Model
{
    use HasTranslations;
    public $translatable = ['title'];
    protected $fillable=['title','amount','Grade_id','Classroom_id','year','description','Fee_type'];


    // علاقة بين الرسوم الدراسية والمراحل الدراسية لجب اسم المرحلة

    public function grade()
    {
        return $this->belongsTo('App\Grade', 'Grade_id');
    }


    // علاقة بين الصفوف الدراسية والرسوم الدراسية لجب اسم الصف

    public function classroom()
    {
        return $this->belongsTo('App\Classrooms', 'Classroom_id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Spatie\Translatable\HasTranslations;

class teacher extends Model
{
    //
    use HasTranslations;
    public $translatable = ['Name'];
    protected $guarded =[];
    protected $table = 'teachers';
    public $timestamps = true;


    public function specializations()
    {
        return $this->belongsTo('App\spespecializations','Specialization_id');
    }

    public function genders()
    {
        return $this->belongsTo('App\Gender');
    }

    // علاقة بين المعلمين والانواع لجلب جنس المعلم


    public function sections()
    {
        return $this->belongsToMany('App\sections','teacher_section');
    }
}

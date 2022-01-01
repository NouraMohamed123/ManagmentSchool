<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class sections extends Model
{
    //
    use HasTranslations;
    public $translatable = ['Name_Section'];
    protected $fillable=['Name_Section','Status','Grade_id','Class_id'];
    protected $table = 'sections';
    public $timestamps = true;

    public function My_class()
    {
        return $this->belongsTo('App\Classrooms','Class_id');
    }

    
    public function teacher()
    {
        return $this->belongsToMany('App\teacher','teacher_section');
    }

}

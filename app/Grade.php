<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Grade extends Model 
{
    use HasTranslations;
    public $translatable = ['Name'];
    protected $fillable=['Name','Notes'];
    protected $table = 'Grades';
    public $timestamps = true;

    public function section()
    {
        return  $this->hasMany('App\sections', 'Grade_id');
    }

}

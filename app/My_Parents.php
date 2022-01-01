<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class My_Parents extends Model
{
    //
    use HasTranslations;
    public $translatable = ['Name_Father','Job_Father','Name_Mother','Job_Mother'];
    protected $guarded = [];
    protected $table = 'my__parents';
}

<?php
namespace App;
use Spatie\Translatable\HasTranslations;


use Illuminate\Database\Eloquent\Model;

class Classrooms extends Model
{
    //
    use HasTranslations;
    public $translatable = ['Name_Class'];

    protected $fillable=['Name_Class','Grade_id'];

    protected $table = 'classrooms';
    public $timestamps = true;

    public function Grades(){
      return  $this->belongsTo('App\Grade', 'Grade_id');
    }
}

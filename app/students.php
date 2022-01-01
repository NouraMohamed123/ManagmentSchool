<?php
namespace App;


use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

use Illuminate\Database\Eloquent\SoftDeletes;
class students extends Model
{
    //
    use SoftDeletes;

    use HasTranslations;
    public $translatable = ['name'];
    protected $guarded =[];

        // علاقة بين الطلاب والانواع لجلب اسم النوع في جدول الطلاب

        public function gender()
        {
            return $this->belongsTo('App\Gender', 'gender_id');
        }

        // علاقة بين الطلاب والمراحل الدراسية لجلب اسم المرحلة في جدول الطلاب

        public function grade()
        {
            return $this->belongsTo('App\Grade', 'Grade_id');
        }

        public function Nationality()
        {
            return $this->belongsTo('App\Nationalitie', 'nationalitie_id');
        }

        public function myparent()
        {
            return $this->belongsTo('App\My_Parents', 'parent_id');
        }
        // علاقة بين الطلاب الصفوف الدراسية لجلب اسم الصف في جدول الطلاب

        public function classroom()
        {
            return $this->belongsTo('App\Classrooms', 'Classroom_id');
        }

        // علاقة بين الطلاب الاقسام الدراسية لجلب اسم القسم  في جدول الطلاب

        public function section()
        {
            return $this->belongsTo('App\sections', 'section_id');
        }

        public function images()
        {
            return $this->morphMany('App\Image', 'imageable');
        }


    // علاقة بين جدول سدادت الطلاب وجدول الطلاب لجلب اجمالي المدفوعات والمتبقي
    public function student_account()
    {
        return $this->hasMany('App\StudentAccount', 'student_id');

    }

   // علاقة بين جدول الطلاب وجدول الحضور والغياب
   public function attendance()
   {
       return $this->hasMany('App\attendances', 'student_id');
   }
}

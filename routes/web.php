<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();


Route::group(['middleware'=>['guest']],function()
{

    Route::get('/',function()
    {
        return view('auth.login');
    });

});



Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath','auth' ]
    ], function(){ //...

        Route::get('/', function()
        {
            return View::make('dashboard');
        });



    Route::get('/dashboard', 'HomeController@index');



    Route::group(['namespace'=>'Grades'],function()
    {
        Route::resource('Grades','GradeController');
    });

    Route::group(['namespace'=>'Classrooms'],function()
    {
        Route::resource('Classrooms','ClassroomsController');
        Route::post('delete_all','ClassroomsController@delete_all')->name('delete_all');
        Route::post('Filter_Classes','ClassroomsController@Filter_Classes')->name('Filter_Classes');
    });



    Route::group(['namespace'=>'sections'],function()
    {
        Route::resource('sections','SectionsController');

        Route::get('ajax/{id}','SectionsController@ajax');
    });



    Route::group(['namespace'=>'teacher'],function()
    {
        Route::resource('teacher','TeacherController');


    });

         //===========================students=============//
    Route::group(['namespace'=>'Students'],function()
    {
        Route::resource('Students','StudentsController');


        Route::resource('Promotion','PromotionsController');

        Route::resource('Graduated','GradueatedController');

        Route::resource('Fees_Invoices','FeesInvoicesController');


        Route::resource('receipt_students','ReceiptStudentController');

        Route::resource('ProcessingFee','ProcessingFeesController');

        Route::resource('Attendance','AttendanceController');

        Route::get('/Get_classrooms/{id}', 'StudentsController@Get_classrooms');

        Route::get('/Get_Sections/{id}', 'StudentsController@Get_Sections');

        Route::get('Download_attachment/{studentsname}/{filename}', 'StudentsController@Download_attachment')->name('Download_attachment');

        Route::post('upload_attachments', 'StudentsController@upload_attachments')->name('upload_attachments');

        Route::post('Delete_attachment', 'StudentsController@Delete_attachment')->name('Delete_attachment');


    });

    Route::group(['namespace'=>'Fees'],function()
    {
        Route::resource('Fees','FeesController');

    });

    Route::group(['namespace'=>'Subjects'],function()
    {
        Route::resource('subjects','SubjectController');

    });


    Route::group(['namespace'=>'Quizess'],function()
    {
        Route::resource('Quizzes','QuizessController');

    });


    //===========================parent=============//
        Route::view('add_parent','livewire.show_Form');
});






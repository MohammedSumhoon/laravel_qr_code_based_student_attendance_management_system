<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Models\Student;
use App\Models\Status;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/student_dashboard', function () { 
        $id=Auth::id();
        $datas=Status::where('student_id',$id)->select('status','date')->get();
        $leaveCount=Status::where('student_id',$id)->where('status','Absent')->count();
        $name=Student::where('id',$id)->get()->value('student_name');
        $dob=Student::where('id',$id)->get()->value('student_dob');
        return view('student_dashboard',compact('datas','leaveCount','name','dob'));
    })->name('student_dashboard');
});
Route::get('dashboard',[StudentController::class,'dashboard'])->name('dashboard');
Route::get('students',[StudentController::class,'index'])->name('students');
Route::post('store_student_details',[StudentController::class,'store'])->name('store_student_details');
Route::get('edit_student_data/{id}',[StudentController::class,'edit']);
Route::post('update_student_data/{id}',[StudentController::class,'update']);
Route::get('delete_student_data/{id}',[StudentController::class,'delete']);
Route::get('leave_sheet',function(){
    return view('leavesheet');
})->name('leave_sheet');
Route::get('attendance_status',[StudentController::class,'getStatus'])->name('attendance_status');
Route::post('leave_sheet',[StudentController::class,'leaveSheet']);//important
Route::get('qrcode',[StudentController::class,'qrcode']);
Route::get('scanner',[StudentController::class,'scanner']);
Route::get('generate',[StudentController::class,'generate']);
Route::post('put_attendance',[StudentController::class,'putAttendance']);//important
Route::get('getTime',[StudentController::class,'getTime']);
Route::get('exportExcel',[StudentController::class,'exportExcel']);

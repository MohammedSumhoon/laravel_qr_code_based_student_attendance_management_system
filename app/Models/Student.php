<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Student extends Model
{
    use HasFactory;
    protected $table = 'students';
    protected $fillable = ['student_name', 'student_email','student_dob','student_contactno'];

    public function status()
    {
        return $this->hasMany('App\Models\Status','status');
    }

    public static function getAttendance()//for excel report
    {
        $attendanceStatus = DB::table('students')->leftJoin('attendance_status', 'attendance_status.student_id', '=', 'students.id')
            ->selectRaw("student_name,IF(ISNULL(status)=1,'Absent',status) as status,date")->orderBy('student.student_name', 'asc')->orderBy('attendance_status.date', 'desc')->get();
            
            return $attendanceStatus;
    }

}

<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class AttendanceExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    
    public function collection()
    {
        return collect(Student::getAttendance());
    }

    public function headings():array{
        return ['student_name','status','present_at'];
     }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $table='attendance_status';
    protected $fillable=['status','student_id'];

    public function studentStatus()
    {
        return $this->belongsTo('App\Models\Student','students');
    }

    // public function getStatusAttribute()
    // {
    //     if($this->status=="Present")
    //     {
    //         return "Absent";
    //     }
    // }
}

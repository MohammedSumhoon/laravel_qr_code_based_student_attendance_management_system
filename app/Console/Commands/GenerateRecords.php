<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Student;
use App\Models\Status;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class GenerateRecords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:records';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the records for attendance table';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $todayDate = Carbon::now()->format('Y-m-d');
        $totalNoOfStudentsId = DB::table('students')->pluck('id');
        foreach ($totalNoOfStudentsId as $id) {
            $status = new Status;
            $status->status = "Absent";
            $status->student_id = $id;
            $status->date = $todayDate;
            $status->save();
        }
        $this->info('The records have been generated successfully');
    }
}

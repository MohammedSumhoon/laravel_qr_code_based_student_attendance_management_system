<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QRcodeGenerationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $studentData;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($studentData)
    {
        $this->studentData=$studentData;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $qrData=$this->studentData;
        QrCode::size(300)->format('png')->generate($qrData, public_path('/students_qrcode/' .$qrData->student_name. '.png'));
    }
}

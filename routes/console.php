<?php

use App\Models\EmployerNotification;
use App\Models\JobApplication;
use Carbon\Carbon;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

#fungsi untuk reminder jadwal interview pada employer
Schedule::call(function () {
    Carbon::setLocale('id');
    LOG::info('Check interview schedule running');
    $applicants = JobApplication::with(['employee', 'job.employer'])->get();

    foreach ($applicants as $applicant) {
        if (
            $applicant->status === 'interview' &&
            $applicant->interview_date &&
            Carbon::parse($applicant->interview_date)->isBetween(now(), now()->addDays(7)) // akan check apakah ada jadwal interview di antara hari ini dan 7 hari kedepan
        ) {
            Log::info('Interview notification triggered for applicant ID: ' . $applicant->id);

            $interviewDate = Carbon::parse($applicant->interview_date);
            $message = "Anda memiliki jadwal interview dengan {$applicant->employee->first_name} {$applicant->employee->last_name} pada lowongan {$applicant->job->nama_lowongan} dalam {$interviewDate->diffForHumans()}";

            // Optional: Avoid duplicate notifications
            $alreadyExists = EmployerNotification::where('employer_id', $applicant->job->employer->id)
                ->where('title', 'Jadwal Interview Anda')
                ->where('message', $message)
                ->exists();

            if (! $alreadyExists) {
                EmployerNotification::create([
                    'employer_id' => $applicant->job->employer->id,
                    'title' => 'Jadwal Interview Anda',
                    'message' => $message,
                    'is_read' => false,
                ]);
            }
        }
    }
})->everyMinute();
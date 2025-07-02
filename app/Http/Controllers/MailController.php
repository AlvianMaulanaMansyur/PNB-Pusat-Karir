<?php

namespace App\Http\Controllers;

use App\Mail\InviteApplicantsMail;
use App\Models\employees;
use App\Models\employers;
use App\Models\JobListing;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    //
    public function inviteApplicants($jobId, $userId)
    {
        $employee = employees::with('user')->where('user_id', $userId)->firstOrFail();
        $email = $employee->user->email;
        $job = JobListing::findOrFail($jobId);
        $employer = employers::where('user_id', $job->user_id)->firstOrFail();
        $company = $employer->company_name;
        $body = "Hey {$employee->first_name}, kamu mendapatkan undangan untuk melamar lowongan di perusahaan {$company} dengan posisi *{$job->nama_lowongan}*. Yuk, segera ajukan lamaran kamu melalui PNB Pusat Karir!";

        Mail::to($email)->send(new InviteApplicantsMail([
            'title' => 'You are being invited!',
            'body' => $body,
        ]));

        return back()->with('success', 'Undangan berhasil dikirim ke ' . $email);
    }
}

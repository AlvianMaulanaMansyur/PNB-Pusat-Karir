<?php

namespace App\Http\Controllers\Jobseeker;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use App\Models\JobListing;
use App\Models\portofoliopathimg;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppliedJobController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $employeeData = $user->dataEmployees;

        $filterStatus = $request->query('status');

        if (!$employeeData) {
            abort(403, 'Data karyawan tidak ditemukan');
        }

        // Ambil semua lamaran dan relasi job
        $jobApplied = JobApplication::with('job.employer')->where('employee_id', $employeeData->id)->get()->groupBy('status');

        // Ubah nama 'pending' jadi 'dikirim'
        $statusMap = [
            'interview' => 'Wawancara',
            'reviewed' => 'Ditinjau',
            'pending' => 'Dikirim',
            'accepted' => 'Diterima',
            'rejected' => 'Ditolak',
        ];

        // Urutan prioritas
        $statusOrder = ['interview', 'reviewed', 'pending', 'accepted', 'rejected'];

        // Pindahkan status yang difilter ke paling atas (jika ada)
        if ($filterStatus && in_array($filterStatus, $statusOrder)) {
            $statusOrder = array_diff($statusOrder, [$filterStatus]);
            array_unshift($statusOrder, $filterStatus);
        }

        // Ambil semua sertifikat yang berkaitan dengan employee_id dan job yang dilamar
        $serticificate = portofoliopathimg::where('employee_id', $employeeData->id)
            ->whereIn('job_id', $jobApplied->flatten()->pluck('job_id'))
            ->get();

        return view('jobseeker.allJobsAppliedPage', compact('jobApplied', 'serticificate', 'statusOrder', 'statusMap', 'filterStatus'));
    }
}

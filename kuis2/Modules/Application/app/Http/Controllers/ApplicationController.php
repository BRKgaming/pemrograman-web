<?php
namespace Modules\Application\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\JobApplySociety;
use App\Models\JobApplyPosition;
use App\Models\AvailablePosition;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ApplicationController extends Controller
{
    // Kirim lamaran
    public function store(Request $request)
    {
        // Cek apakah user sudah tervalidasi
        $user = auth('society')->user();
        if (!$user) {
            return back()->with('error', 'Anda harus login terlebih dahulu');
        }

        // Debug: Log user information
        Log::info('User applying for job', [
            'user_id' => $user->id,
            'id_card_number' => $user->id_card_number,
            'job_vacancy_id' => $request->job_vacancy_id
        ]);

        // Verify user exists in societies table
        $societyExists = DB::table('societies')->where('id', $user->id)->exists();
        if (!$societyExists) {
            Log::error('Society not found in database', ['user_id' => $user->id]);
            return back()->with('error', 'Data pengguna tidak ditemukan dalam database');
        }

        if (!$user->validation || $user->validation->status !== 'accepted') {
            return back()->with('error', 'Anda harus mendapatkan validasi terlebih dahulu sebelum melamar pekerjaan');
        }

        $request->validate([
            'job_vacancy_id' => 'required|exists:job_vacancies,id',
            'positions' => 'required|array|min:1',
            'positions.*' => 'exists:available_positions,id',
            'notes' => 'required|string'
        ]);

        // Cek apakah sudah pernah apply ke vacancy ini
        $existingApplication = JobApplySociety::where([
            'society_id' => $user->id,
            'job_vacancy_id' => $request->job_vacancy_id
        ])->first();

        if ($existingApplication) {
            return back()->with('error', 'Anda sudah melamar ke lowongan ini sebelumnya');
        }

        // Cek kapasitas untuk setiap posisi yang dipilih
        foreach ($request->positions as $positionId) {
            $position = AvailablePosition::find($positionId);
            if (!$position) {
                return back()->with('error', 'Posisi tidak ditemukan');
            }
            if ($position->apply_capacity >= $position->capacity) {
                return back()->with('error', 'Posisi "' . $position->position . '" sudah penuh!');
            }
        }

        // Buat application utama
        $application = JobApplySociety::create([
            'society_id' => $user->id,
            'job_vacancy_id' => $request->job_vacancy_id,
            'notes' => $request->notes,
            'date' => now()->format('Y-m-d')
        ]);

        // Tambahkan setiap position yang dilamar
        foreach ($request->positions as $positionId) {
            JobApplyPosition::create([
                'society_id' => $user->id,
                'job_vacancy_id' => $request->job_vacancy_id,
                'position_id' => $positionId,
                'job_apply_societies_id' => $application->id,
                'status' => 'pending',
                'date' => now()->format('Y-m-d')
            ]);

            // Update apply_capacity untuk posisi tersebut
            $position = AvailablePosition::find($positionId);
            $position->increment('apply_capacity');
        }

        return redirect()->route('applications.index')->with('success', 'Lamaran berhasil dikirim!');
    }


    // Daftar lamaran saya
    public function index()
    {
        $user = auth('society')->user();
        if (!$user) {
            return redirect()->route('society.login.form')->with('error', 'Anda harus login terlebih dahulu');
        }

        $applications = JobApplySociety::with(['jobVacancy', 'positions.position'])
            ->where('society_id', $user->id)
            ->orderBy('date', 'desc')
            ->get();

        return view('application::index', compact('applications'));
    }

    // Detail lamaran
    public function show($id)
    {
        $user = auth('society')->user();
        if (!$user) {
            return redirect()->route('society.login.form')->with('error', 'Anda harus login terlebih dahulu');
        }

        $application = JobApplySociety::with(['jobVacancy', 'positions.position', 'society'])
            ->where('society_id', $user->id)
            ->findOrFail($id);

        return view('application::show', compact('application'));
    }
}
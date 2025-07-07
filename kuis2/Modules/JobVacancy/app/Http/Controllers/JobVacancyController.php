<?php
namespace Modules\JobVacancy\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\JobVacancy\Models\JobVacancy;

class JobVacancyController extends Controller {
    // Tampilkan daftar lowongan
    public function index() {
        $jobVacancies = JobVacancy::with('availablePositions')->get();
        return view('jobvacancy::index', compact('jobVacancies'));
    }

    // Detail lowongan
    public function show($id) {
        $job = JobVacancy::with('availablePositions')->findOrFail($id);
        return view('jobvacancy::show', compact('job'));
    }
}

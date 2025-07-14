<?php
namespace Modules\Validation\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Validation\Models\Validation;

class ValidationController extends Controller {
    // Tampilkan status validasi
    public function index() {
        $validation = auth('society')->user()->validation;
        return view('validation::index', compact('validation'));
    }

    // Form pengajuan validasi
    public function create()
    {
        $jobCategories = \App\Models\JobCategory::all();
        return view('validation::create', compact('jobCategories'));
    }

    // Simpan data validasi
    public function store(Request $request) {
        $request->validate([
            'work_experience' => 'required',
            'job_category_id' => 'required|exists:job_categories,id',
            'job_position' => 'required',
            'reason_accepted' => 'required'
        ]);

        auth('society')->user()->validation()->create([
            'work_experience' => $request->work_experience,
            'job_category_id' => $request->job_category_id,
            'job_position' => $request->job_position,
            'reason_accepted' => $request->reason_accepted,
            'status' => 'pending'
        ]);

        return redirect()->route('validation.index');
    }
}

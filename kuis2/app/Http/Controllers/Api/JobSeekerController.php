<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Society;
use App\Models\Validation;
use App\Models\JobVacancy;
use App\Models\JobApplySociety;
use App\Models\JobApplyPosition;
use App\Models\AvailablePosition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class JobSeekerController extends Controller
{
    // A1 - Login
    public function login(Request $request)
    {
        $request->validate([
            'id_card_number' => 'required|string',
            'password' => 'required|string',
        ]);

        $society = Society::where('id_card_number', $request->id_card_number)->first();

        if (!$society || !Hash::check($request->password, $society->password)) {
            return response()->json(['message' => 'ID Card Number or Password incorrect'], 401);
        }

        $token = Str::random(32);
        $society->update(['login_tokens' => $token]);

        return response()->json([
            'name' => $society->name,
            'born_date' => $society->born_date,
            'gender' => $society->gender,
            'address' => $society->address,
            'token' => $token,
            'regional' => [
                'id' => $society->regional->id,
                'province' => $society->regional->province,
                'district' => $society->regional->district,
            ]
        ]);
    }

    // A1 - Logout
    public function logout(Request $request)
    {
        $token = $request->query('token');
        $society = Society::where('login_tokens', $token)->first();

        if (!$society) {
            return response()->json(['message' => 'Invalid token'], 401);
        }

        $society->update(['login_tokens' => null]);

        return response()->json(['message' => 'Logout success']);
    }

    // A2 - Request Data Validation
    public function requestValidation(Request $request)
    {
        $token = $request->query('token');
        $society = Society::where('login_tokens', $token)->first();

        if (!$society) {
            return response()->json(['message' => 'Unauthorized user'], 401);
        }

        $request->validate([
            'work_experience' => 'required|string',
            'job_category_id' => 'required|exists:job_categories,id',
            'job_position' => 'required|string',
            'reason_accepted' => 'required|string',
        ]);

        // Cek apakah sudah pernah request validasi
        $existingValidation = Validation::where('society_id', $society->id)->first();
        if ($existingValidation) {
            return response()->json(['message' => 'You have already submitted a validation request'], 400);
        }

        $validation = Validation::create([
            'job_category_id' => $request->job_category_id,
            'society_id' => $society->id,
            'work_experience' => $request->work_experience,
            'job_position' => $request->job_position,
            'reason_accepted' => $request->reason_accepted,
            'status' => 'pending',
        ]);

        return response()->json(['message' => 'Request data validation sent successful']);
    }

    // A2 - Get Validation Data
    public function getValidation(Request $request)
    {
        $token = $request->query('token');
        $society = Society::where('login_tokens', $token)->first();

        if (!$society) {
            return response()->json(['message' => 'Unauthorized user'], 401);
        }

        $validation = Validation::where('society_id', $society->id)->first();

        if (!$validation) {
            return response()->json(['message' => 'No validation data found'], 404);
        }

        return response()->json([
            'validation' => [
                'id' => $validation->id,
                'status' => $validation->status,
                'work_experience' => $validation->work_experience,
                'job_category_id' => $validation->job_category_id,
                'job_position' => $validation->job_position,
                'reason_accepted' => $validation->reason_accepted,
                'validator_notes' => $validation->validator_notes,
                'validator' => $validation->validator ? [
                    'id' => $validation->validator->id,
                    'name' => $validation->validator->name,
                ] : null,
            ]
        ]);
    }

    // A3 - Get Job Vacancies
    public function getJobVacancies(Request $request)
    {
        $token = $request->query('token');
        $society = Society::where('login_tokens', $token)->first();

        if (!$society) {
            return response()->json(['message' => 'Unauthorized user'], 401);
        }

        // Cek status validasi
        $validation = Validation::where('society_id', $society->id)
            ->where('status', 'accepted')
            ->first();

        if (!$validation) {
            return response()->json(['message' => 'Your data must be validated first'], 403);
        }

        $jobVacancies = JobVacancy::with(['availablePositions', 'category'])
            ->where('job_category_id', $validation->job_category_id)
            ->get();

        $vacancies = $jobVacancies->map(function ($vacancy) use ($society) {
            $applied = JobApplySociety::where('society_id', $society->id)
                ->where('job_vacancy_id', $vacancy->id)
                ->exists();

            return [
                'id' => $vacancy->id,
                'category' => [
                    'id' => $vacancy->category->id,
                    'job_category' => $vacancy->category->job_category,
                ],
                'company' => $vacancy->company,
                'address' => $vacancy->address,
                'description' => $vacancy->description,
                'available_positions' => $vacancy->availablePositions->map(function ($position) {
                    return [
                        'position' => $position->position,
                        'capacity' => $position->capacity,
                        'apply_capacity' => $position->apply_capacity,
                    ];
                }),
                'applied' => $applied,
            ];
        });

        return response()->json(['vacancies' => $vacancies]);
    }

    // A3 - Get Job Vacancy Detail
    public function getJobVacancyDetail(Request $request, $id)
    {
        $token = $request->query('token');
        $society = Society::where('login_tokens', $token)->first();

        if (!$society) {
            return response()->json(['message' => 'Unauthorized user'], 401);
        }

        $vacancy = JobVacancy::with(['availablePositions', 'category'])->find($id);

        if (!$vacancy) {
            return response()->json(['message' => 'Job vacancy not found'], 404);
        }

        $appliedPositions = JobApplyPosition::where('society_id', $society->id)
            ->where('job_vacancy_id', $id)
            ->pluck('position_id')
            ->toArray();

        return response()->json([
            'vacancy' => [
                'id' => $vacancy->id,
                'category' => [
                    'id' => $vacancy->category->id,
                    'job_category' => $vacancy->category->job_category,
                ],
                'company' => $vacancy->company,
                'address' => $vacancy->address,
                'description' => $vacancy->description,
                'available_position' => $vacancy->availablePositions->map(function ($position) use ($appliedPositions) {
                    $appliedCount = JobApplyPosition::where('position_id', $position->id)->count();

                    return [
                        'position' => $position->position,
                        'capacity' => $position->capacity,
                        'apply_capacity' => $position->apply_capacity,
                        'apply_count' => $appliedCount,
                        'applied' => in_array($position->id, $appliedPositions),
                    ];
                }),
            ]
        ]);
    }

    // A4 - Apply for Job
    public function applyForJob(Request $request)
    {
        $token = $request->query('token');
        $society = Society::where('login_tokens', $token)->first();

        if (!$society) {
            return response()->json(['message' => 'Unauthorized user'], 401);
        }

        $request->validate([
            'vacancy_id' => 'required|exists:job_vacancies,id',
            'positions' => 'required|array',
            'positions.*' => 'exists:available_positions,id',
            'notes' => 'required|string',
        ]);

        // Cek status validasi
        $validation = Validation::where('society_id', $society->id)
            ->where('status', 'accepted')
            ->first();

        if (!$validation) {
            return response()->json(['message' => 'Your data validator must be accepted by validator before'], 401);
        }

        // Cek apakah sudah pernah apply ke vacancy ini
        $existingApplication = JobApplySociety::where('society_id', $society->id)
            ->where('job_vacancy_id', $request->vacancy_id)
            ->first();

        if ($existingApplication) {
            return response()->json(['message' => 'Application for a job can only be once'], 401);
        }

        // Buat job application
        $jobApplySociety = JobApplySociety::create([
            'society_id' => $society->id,
            'job_vacancy_id' => $request->vacancy_id,
            'notes' => $request->notes,
            'date' => now(),
        ]);

        // Buat apply positions
        foreach ($request->positions as $positionId) {
            JobApplyPosition::create([
                'society_id' => $society->id,
                'job_vacancy_id' => $request->vacancy_id,
                'position_id' => $positionId,
                'job_apply_societies_id' => $jobApplySociety->id,
                'date' => now(),
                'status' => 'pending',
            ]);
        }

        return response()->json(['message' => 'Applying for job successful']);
    }

    // A4 - Get Job Applications
    public function getJobApplications(Request $request)
    {
        $token = $request->query('token');
        $society = Society::where('login_tokens', $token)->first();

        if (!$society) {
            return response()->json(['message' => 'Unauthorized user'], 401);
        }

        $applications = JobApplySociety::with(['jobVacancy.category', 'positions.position'])
            ->where('society_id', $society->id)
            ->get();

        $vacancies = $applications->map(function ($application) {
            return [
                'id' => $application->jobVacancy->id,
                'category' => [
                    'id' => $application->jobVacancy->category->id,
                    'job_category' => $application->jobVacancy->category->job_category,
                ],
                'company' => $application->jobVacancy->company,
                'address' => $application->jobVacancy->address,
                'position' => $application->positions->map(function ($position) {
                    return [
                        'position' => $position->position->position,
                        'apply_status' => $position->status,
                        'notes' => $position->notes,
                    ];
                }),
            ];
        });

        return response()->json(['vacancies' => $vacancies]);
    }
}
<?php

namespace App\Http\Controllers;

use app\Models\Validation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function societyDashboard()
    {
        try {
            $user = auth('society')->user();

            if (!$user) {
                throw new \Exception('User not authenticated');
            }

            $user->load([
                'validation.jobCategory',
                'applications' => function($query) {
                    $query->with([
                        'jobVacancy',
                        'positions.position'
                    ])->latest();
                }
            ]);

            return view('dashboard.society', compact('user'));

        } catch (\Exception $e) {
            Log::error('Dashboard error: '.$e->getMessage());
            return back()->with('error', 'Failed to load dashboard data');
        }
    }

    public function validatorDashboard()
    {
        $data = [
            'pendingCount' => Validation::where('status', 'pending')->count(),
            'approvedCount' => Validation::where('status', 'accepted')->count(),
            'rejectedCount' => Validation::where('status', 'rejected')->count(),
            'validations' => Validation::with(['society', 'jobCategory'])
                                ->orderBy('created_at', 'desc')
                                ->limit(10)
                                ->get()
        ];

        return view('dashboard.validator', $data);
    }
}
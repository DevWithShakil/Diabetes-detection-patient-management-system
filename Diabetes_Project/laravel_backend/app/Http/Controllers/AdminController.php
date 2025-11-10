<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Patient;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'can:admin']);
    }

    public function index()
    {
        $user = Auth::user();

        // Dashboard Stats
        $totalPatients = Patient::count();
        $totalDoctors = User::where('role', 'doctor')->count();
        $totalPredictions = Patient::whereNotNull('result')->count();

        // Chart Data (you can replace with dynamic ML data)
        $chartData = [
            'Decision Tree' => 75.32,
            'KNN' => 69.48,
            'Logistic Regression' => 75.32,
            'Random Forest' => 74.03,
            'SVM' => 73.38
        ];

        // Get last 10 patients
        $patients = Patient::latest()->take(10)->get();

        return view('admin.dashboard', compact(
            'user', 'totalPatients', 'totalDoctors', 'totalPredictions', 'chartData', 'patients'
        ));
    }

    // ✅ PDF Download for specific patient
    public function downloadReport(Patient $patient)
    {
        $pdf = Pdf::loadView('patients.report', compact('patient'));
        return $pdf->download('report-'.$patient->id.'.pdf');
    }
}

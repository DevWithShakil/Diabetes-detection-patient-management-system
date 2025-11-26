<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

        // 🔹 1. Dashboard Stats
        $totalPatients = Patient::count();
        $totalDoctors = User::where('role', 'doctor')->count();
        $totalPredictions = Patient::whereNotNull('result')->count();

        // 🔹 2. Define Target Models (Short Names for Chart)
        $chartData = [
            'Decision Tree' => 0,
            'Random Forest' => 0,
            'SVM' => 0,
            'KNN' => 0,
            'Logistic Regression' => 0
        ];

        // 🔹 3. Fetch last prediction record
        $latestPatient = Patient::orderBy('id', 'desc')->first();

        if ($latestPatient && $latestPatient->result) {
            $result = json_decode($latestPatient->result, true);
            $accuracies = $result['accuracies'] ?? [];

            // 🔥 SMART MAPPING LOGIC (Fixes the issue)
            // We check for both "Short Name" and "Long Name" from Database

            // 1. Decision Tree
            if(isset($accuracies['Decision Tree']))
                $chartData['Decision Tree'] = round($accuracies['Decision Tree'], 2);

            // 2. Random Forest
            if(isset($accuracies['Random Forest']))
                $chartData['Random Forest'] = round($accuracies['Random Forest'], 2);

            // 3. SVM (Check both 'SVM' and 'Support Vector Machine')
            if(isset($accuracies['SVM'])) {
                $chartData['SVM'] = round($accuracies['SVM'], 2);
            } elseif(isset($accuracies['Support Vector Machine'])) {
                $chartData['SVM'] = round($accuracies['Support Vector Machine'], 2);
            }

            // 4. KNN (Check both 'KNN' and 'K-Nearest Neighbors')
            if(isset($accuracies['KNN'])) {
                $chartData['KNN'] = round($accuracies['KNN'], 2);
            } elseif(isset($accuracies['K-Nearest Neighbors'])) {
                $chartData['KNN'] = round($accuracies['K-Nearest Neighbors'], 2);
            }

            // 5. Logistic Regression (Or Naive Bayes Fallback if using mock data)
            if(isset($accuracies['Logistic Regression'])) {
                $chartData['Logistic Regression'] = round($accuracies['Logistic Regression'], 2);
            } elseif(isset($accuracies['Naive Bayes'])) {
                // If you used mock data previously which had Naive Bayes
                // We map it to this key just to show data, or rename key to 'Naive Bayes'
                $chartData['Logistic Regression'] = round($accuracies['Naive Bayes'], 2);
            }
        }

        // 🔹 4. Get last 5 patients for table
        $patients = Patient::orderBy('id', 'desc')->take(5)->get();

        return view('admin.dashboard', compact(
            'user',
            'totalPatients',
            'totalDoctors',
            'totalPredictions',
            'chartData',
            'patients'
        ));
    }

    /**
     * PDF Download
     */
    public function downloadReport(Patient $patient)
    {
        $pdf = Pdf::loadView('admin.reports.pdf', ['patient' => $patient]);
        return $pdf->download('Admin_Master_Report_' . $patient->name . '.pdf');
    }
}

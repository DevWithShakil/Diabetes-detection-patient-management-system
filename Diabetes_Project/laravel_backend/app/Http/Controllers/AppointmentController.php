<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use App\Models\User;
use App\Models\Patient;
use PDF;

class PatientController extends Controller
{
    /**
     * 🔹 1. Patient Dashboard
     * Shows stats and recent appointments.
     */
    public function dashboard()
    {
        // Get Current Patient
        $patient = Patient::where('user_id', Auth::id())->first();

        // If new user has no patient record yet
        if (!$patient) {
            return view('patient.dashboard', [
                'total' => 0, 'pending' => 0, 'approved' => 0, 'appointments' => []
            ])->with('warning', 'Please complete your profile details first.');
        }

        // Calculate Stats
        $total = Appointment::where('patient_id', $patient->id)->count();
        $pending = Appointment::where('patient_id', $patient->id)->where('status', 'pending')->count();
        $approved = Appointment::where('patient_id', $patient->id)->where('status', 'approved')->count();

        // Recent Appointments (Limit 5)
        $appointments = Appointment::where('patient_id', $patient->id)
            ->with('doctor')
            ->orderBy('appointment_date', 'desc')
            ->take(5)
            ->get();

        return view('patient.dashboard', compact('total', 'pending', 'approved', 'appointments'));
    }

    /**
     * 🔹 2. All Appointments List
     * Route: patient.appointments.index
     */
    public function appointments()
    {
        $patient = Patient::where('user_id', Auth::id())->first();

        if (!$patient) {
            return redirect()->route('patient.dashboard')->with('error', 'Patient profile not found.');
        }

        $appointments = Appointment::where('patient_id', $patient->id)
            ->with('doctor')
            ->orderBy('appointment_date', 'desc')
            ->paginate(10);

        return view('patient.appointments.index', compact('appointments'));
    }

    /**
     * 🔹 3. Show Create Form
     * Route: patient.appointments.create
     */
    public function createAppointment()
    {
        // Get list of doctors
        $doctors = User::where('role', 'doctor')->get();
        return view('patient.appointments.create', compact('doctors'));
    }

    /**
     * 🔹 4. Store Appointment
     * Route: patient.appointments.store
     */
    public function storeAppointment(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:users,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'time' => 'nullable',
            'notes' => 'nullable|string|max:500',
        ]);

        $patient = Patient::where('user_id', Auth::id())->first();

        if (!$patient) {
            return back()->with('error', 'Please complete your prediction/profile first.');
        }

        Appointment::create([
            'patient_id' => $patient->id,
            'doctor_id' => $request->doctor_id,
            'appointment_date' => $request->appointment_date,
            'time' => $request->time,
            'notes' => $request->notes,
            'status' => 'pending'
        ]);

        return redirect()->route('patient.appointments.index')
            ->with('success', 'Appointment request sent successfully!');
    }

    /**
     * 🔹 5. Show Single Appointment Details
     * Route: patient.appointments.show
     */
    public function showAppointment(Appointment $appointment)
    {
        // Security: Ensure patient owns this appointment
        $patient = Patient::where('user_id', Auth::id())->first();

        if (!$patient || $appointment->patient_id !== $patient->id) {
            abort(403, 'Unauthorized access.');
        }

        return view('patient.appointments.show', compact('appointment'));
    }

    // ==========================================
    // 🔹 OTHER EXISTING METHODS (ML / REPORT)
    // ==========================================

    public function showDetectionForm() {
        return view('patient.detection');
    }

    public function storeDetection(Request $request) {
        // ... Your ML Logic Here ...
        // Ensure you save/update the 'Patient' model here
        return redirect()->route('patient.dashboard')->with('success', 'Analysis Complete');
    }

    public function report(Patient $patient) {
        // Security check
        if($patient->user_id != Auth::id()) abort(403);
        return view('patient.report', compact('patient'));
    }

    public function downloadReport(Patient $patient) {
        if($patient->user_id != Auth::id()) abort(403);
        $pdf = PDF::loadView('patient.report_pdf', compact('patient'));
        return $pdf->download('report.pdf');
    }
}

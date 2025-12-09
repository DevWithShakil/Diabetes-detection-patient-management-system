<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentMail;

class AppointmentController extends Controller
{
    /**
     *  Show All Appointments (Admin Panel)
     */
    public function index()
    {
        $appointments = Appointment::with(['patient.user', 'doctor'])
            ->orderBy('appointment_date', 'desc')
            ->paginate(10);

        return view('appointments.index', compact('appointments'));
    }

    /**
     * Show Create Appointment Form
     */
    public function create()
    {
        $patients = Patient::with('user')->get();
        $doctors = User::where('role', 'doctor')->get();

        return view('appointments.create', compact('patients', 'doctors'));
    }

    /**
     * 🔹 Store Appointment (Admin creates)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:users,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'time' => 'nullable',
            'notes' => 'nullable|string',
        ]);

        $validated['status'] = 'pending';

        //  Create appointment
        $appointment = Appointment::create($validated);

        // Send email (optional)
        try {
            $doctor = User::find($validated['doctor_id']);
            if ($doctor && $doctor->email) {
                Mail::to($doctor->email)->send(new AppointmentMail($appointment));
            }
        } catch (\Exception $e) {
            \Log::error("Mail not sent: " . $e->getMessage());
        }

        return redirect()->route('appointments.index')
            ->with('success', ' Appointment created successfully!');
    }

    /**
     *  Update appointment status
     */
    public function updateStatus(Request $request, Appointment $appointment)
    {
        $request->validate(['status' => 'required|string|in:pending,approved,cancelled,completed']);
        $appointment->update(['status' => $request->status]);

        return back()->with('success', ' Appointment status updated!');
    }

    /**
     *  Delete appointment
     */
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return back()->with('success', 'Appointment deleted successfully!');
    }
}

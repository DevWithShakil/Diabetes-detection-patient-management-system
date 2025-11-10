<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','can:admin']);
    }

    // show patients which have result (reports)
    public function index(Request $request)
    {
        $q = Patient::whereNotNull('result');

        if ($request->filled('q')) {
            $q->where('name','ilike','%'.$request->q.'%');
        }

        $reports = $q->orderBy('created_at','desc')->paginate(15);
        return view('reports.index', compact('reports'));
    }

    // "delete" report: nullify patient's result
    public function destroy(Patient $patient)
    {
        $patient->update(['result' => null]);
        return redirect()->route('reports.index')->with('success', 'Report deleted successfully.');
    }
}

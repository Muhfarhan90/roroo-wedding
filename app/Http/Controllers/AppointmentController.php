<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Client;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);

        $startOfMonth = Carbon::create($year, $month, 1)->startOfMonth();
        $endOfMonth = Carbon::create($year, $month, 1)->endOfMonth();

        // Get all appointments for the month
        $appointments = Appointment::with('client')
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->orderBy('date')
            ->orderBy('start_time')
            ->get()
            ->groupBy(function ($appointment) {
                return $appointment->date->format('Y-m-d');
            });

        // Get upcoming appointments (from today onwards)
        $upcomingAppointments = Appointment::with('client')
            ->where('date', '>=', now()->toDateString())
            ->orderBy('date')
            ->orderBy('start_time')
            ->take(10)
            ->get();

        $clients = Client::orderBy('bride_name')->get();

        return view('calendar.index', compact('appointments', 'upcomingAppointments', 'clients', 'month', 'year', 'startOfMonth', 'endOfMonth'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'nullable|exists:clients,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'color' => 'required|string',
        ]);

        Appointment::create($validated);

        return redirect()->route('calendar.index')
            ->with('success', 'Appointment berhasil dibuat');
    }

    public function update(Request $request, $encryptedId)
    {
        $validated = $request->validate([
            'client_id' => 'nullable|exists:clients,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'color' => 'required|string',
        ]);

        $appointment = Appointment::findOrFail($encryptedId);
        $appointment->update($validated);

        return redirect()->route('calendar.index')
            ->with('success', 'Appointment berhasil diperbarui');
    }

    public function destroy($encryptedId)
    {
        $appointment = Appointment::findOrFail($encryptedId);
        $appointment->delete();

        return redirect()->route('calendar.index')
            ->with('success', 'Appointment berhasil dihapus');
    }

    public function show($encryptedId)
    {
        $appointment = Appointment::with('client')->findOrFail($encryptedId);

        // Format date to Y-m-d for HTML5 date input
        $appointment->date = $appointment->date->format('Y-m-d');

        return response()->json($appointment);
    }
}

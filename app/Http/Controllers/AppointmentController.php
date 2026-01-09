<?php

namespace App\Http\Controllers;


use App\Models\Appointment;
use App\Models\Client;
use App\Models\Order;
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

        // Get all orders with clients for the month based on akad_date or reception_date
        $orders = \App\Models\Order::with('client')
            ->whereHas('client', function ($query) use ($startOfMonth, $endOfMonth) {
                $query->where(function ($q) use ($startOfMonth, $endOfMonth) {
                    $q->whereBetween('akad_date', [$startOfMonth, $endOfMonth])
                        ->orWhereBetween('reception_date', [$startOfMonth, $endOfMonth]);
                });
            })
            ->get();

        // Format data untuk calendar - group by date
        $appointments = collect();

        foreach ($orders as $order) {
            $client = $order->client;

            // Add Akad appointment if exists in range
            if (
                $client->akad_date &&
                $client->akad_date >= $startOfMonth &&
                $client->akad_date <= $endOfMonth
            ) {
                $appointments->push((object)[
                    'date' => $client->akad_date,
                    'title' => $client->client_name . ' - Akad',
                    'start_time' => $client->akad_time ?? '08:00:00',
                    'end_time' => \Carbon\Carbon::parse($client->akad_time ?? '08:00:00')->addHours(2)->format('H:i:s'),
                    'location' => $client->event_location,
                    'description' => 'Akad - Order #' . $order->order_number,
                    'color' => '#9333ea', // Ungu untuk Akad
                    'client' => $client,
                    'order' => $order,
                    'order_id' => $order->id,
                    'type' => 'akad',
                ]);
            }

            // Add Resepsi appointment if exists in range and different from akad
            if (
                $client->reception_date &&
                $client->reception_date >= $startOfMonth &&
                $client->reception_date <= $endOfMonth &&
                ($client->reception_date != $client->akad_date ||
                    $client->reception_time != $client->akad_time)
            ) {
                $appointments->push((object)[
                    'date' => $client->reception_date,
                    'title' => $client->client_name . ' - Resepsi',
                    'start_time' => $client->reception_time ?? '18:00:00',
                    'end_time' => $client->reception_end_time ?? '22:00:00',
                    'location' => $client->event_location,
                    'description' => 'Resepsi - Order #' . $order->order_number,
                    'color' => '#ec4899', // Pink untuk Resepsi
                    'client' => $client,
                    'order' => $order,
                    'order_id' => $order->id,
                    'type' => 'resepsi',
                ]);
            }
        }

        // Group by date
        $appointments = $appointments->groupBy(function ($appointment) {
            return $appointment->date->format('Y-m-d');
        });

        // Get upcoming appointments (from today onwards)
        $upcomingOrders = \App\Models\Order::with('client')
            ->whereHas('client', function ($query) {
                $query->where(function ($q) {
                    $q->where('akad_date', '>=', now()->toDateString())
                        ->orWhere('reception_date', '>=', now()->toDateString());
                });
            })
            ->get();

        $upcomingAppointments = collect();
        foreach ($upcomingOrders as $order) {
            $client = $order->client;

            if ($client->akad_date && $client->akad_date >= now()->toDateString()) {
                $upcomingAppointments->push((object)[
                    'date' => $client->akad_date,
                    'title' => $client->client_name . ' - Akad',
                    'start_time' => $client->akad_time ?? '08:00:00',
                    'end_time' => \Carbon\Carbon::parse($client->akad_time ?? '08:00:00')->addHours(2)->format('H:i:s'),
                    'location' => $client->event_location,
                    'description' => 'Akad - Order #' . $order->order_number,
                    'color' => '#9333ea',
                    'client' => $client,
                    'order' => $order,
                    'order_id' => $order->id,
                    'type' => 'akad',
                ]);
            }

            if (
                $client->reception_date &&
                $client->reception_date >= now()->toDateString() &&
                ($client->reception_date != $client->akad_date ||
                    $client->reception_time != $client->akad_time)
            ) {
                $upcomingAppointments->push((object)[
                    'date' => $client->reception_date,
                    'title' => $client->client_name . ' - Resepsi',
                    'start_time' => $client->reception_time ?? '18:00:00',
                    'end_time' => $client->reception_end_time ?? '22:00:00',
                    'location' => $client->event_location,
                    'description' => 'Resepsi - Order #' . $order->order_number,
                    'color' => '#ec4899',
                    'client' => $client,
                    'order' => $order,
                    'order_id' => $order->id,
                    'type' => 'resepsi',
                ]);
            }
        }

        $upcomingAppointments = $upcomingAppointments->sortBy('date')->take(10);

        $clients = Client::orderBy('client_name')->get();

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

    public function show($orderId, $type = null)
    {
        // Load order dengan client
        $order = Order::with('client')->findOrFail($orderId);
        $client = $order->client;

        // Jika type tidak ada di parameter, coba ambil dari query string
        if (!$type) {
            $type = request()->query('type', 'akad');
        }

        // Build appointment data dari order dan client
        if ($type === 'akad' && $client->akad_date) {
            $date = $client->akad_date;
            $startTime = $client->akad_time ?: '00:00:00';
            $endTime = \Carbon\Carbon::parse($startTime)->addHours(2)->format('H:i:s');
            $title = $client->client_name . ' - Akad';
            $color = '#9333ea'; // purple
        } else {
            $date = $client->reception_date;
            $startTime = $client->reception_time ?: '00:00:00';
            $endTime = $client->reception_end_time ?: \Carbon\Carbon::parse($startTime)->addHours(4)->format('H:i:s');
            $title = $client->client_name . ' - Resepsi';
            $color = '#ec4899'; // pink
        }

        // Build appointment object
        $appointment = (object)[
            'order_id' => $order->id,
            'type' => $type,
            'title' => $title,
            'date' => $date,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'color' => $color,
            'location' => $client->event_location,
            'description' => $type === 'akad' ? 'Acara Akad Nikah' : 'Acara Resepsi',
            'client' => $client,
            'order' => $order,
        ];

        return response()->json($appointment);
    }
}

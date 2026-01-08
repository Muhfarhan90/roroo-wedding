<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        // Handle PDF export
        if ($request->get('export') === 'pdf') {
            return $this->exportPDF($request);
        }

        $query = Client::query();

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('client_name', 'like', "%{$search}%")
                    ->orWhere('bride_phone', 'like', "%{$search}%")
                    ->orWhere('groom_phone', 'like', "%{$search}%");
            });
        }

        // Date range filter
        if ($request->has('start_date') && $request->start_date) {
            $query->where('akad_date', '>=', $request->start_date);
        }
        if ($request->has('end_date') && $request->end_date) {
            $query->where('akad_date', '<=', $request->end_date);
        }

        // Sorting
        $sortBy = $request->get('sort', 'created_at');
        $sortOrder = 'desc';

        switch ($sortBy) {
            case 'bride_name':
            case 'akad_date':
            case 'reception_date':
                $sortOrder = 'asc';
                break;
        }

        $query->orderBy($sortBy, $sortOrder);

        // Pagination
        $perPage = $request->get('per_page', 25);
        $clients = $query->paginate($perPage)->withQueryString();

        return view('clients.index', compact('clients'));
    }

    private function exportPDF(Request $request)
    {
        $query = Client::query();

        // Apply same filters as index
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('client_name', 'like', "%{$search}%");
            });
        }

        if ($request->has('start_date') && $request->start_date) {
            $query->where('akad_date', '>=', $request->start_date);
        }
        if ($request->has('end_date') && $request->end_date) {
            $query->where('akad_date', '<=', $request->end_date);
        }

        $sortBy = $request->get('sort', 'created_at');
        $query->orderBy($sortBy, 'asc');

        $clients = $query->get();

        // Validasi jika tidak ada data
        if ($clients->isEmpty()) {
            return redirect()->route('clients.index')
                ->with('error', 'Tidak ada data klien untuk di-export. Silakan sesuaikan filter pencarian Anda.');
        }

        $pdf = \PDF::loadView('clients.pdf', compact('clients'));
        return $pdf->download('clients-' . date('Y-m-d') . '.pdf');
    }

    public function create()
    {
        return view('clients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_name' => 'required|string|max:255',
            'bride_phone' => 'required|string|max:20',
            'groom_phone' => 'required|string|max:20',
            'bride_address' => 'nullable|string',
            'groom_address' => 'nullable|string',
            'bride_parents' => 'nullable|string|max:255',
            'groom_parents' => 'nullable|string|max:255',
            'akad_date' => 'nullable|date',
            'akad_time' => 'nullable|date_format:H:i',
            'reception_date' => 'nullable|date',
            'reception_time' => 'nullable|date_format:H:i',
            'reception_end_time' => 'nullable|date_format:H:i',
            'event_location' => 'nullable|string',
        ]);

        $client = Client::create($validated);

        // Auto-create appointments for this client
        $this->createAppointmentsForClient($client);

        // Return JSON response if request is AJAX
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Klien berhasil ditambahkan!',
                'client' => $client
            ]);
        }

        return redirect()->route('clients.index')
            ->with('success', 'Klien berhasil ditambahkan!');
    }

    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'client_name' => 'required|string|max:255',
            'bride_phone' => 'required|string|max:20',
            'groom_phone' => 'required|string|max:20',
            'bride_address' => 'nullable|string',
            'groom_address' => 'nullable|string',
            'bride_parents' => 'nullable|string|max:255',
            'groom_parents' => 'nullable|string|max:255',
            'akad_date' => 'nullable|date',
            'akad_time' => 'nullable|date_format:H:i',
            'reception_date' => 'nullable|date',
            'reception_time' => 'nullable|date_format:H:i',
            'reception_end_time' => 'nullable|date_format:H:i',
            'event_location' => 'nullable|string',
        ]);

        $client->update($validated);

        // Update or create appointments when dates change
        $this->updateAppointmentsForClient($client);

        return redirect()->route('clients.index')
            ->with('success', 'Klien berhasil diupdate!');
    }

    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()->route('clients.index')
            ->with('success', 'Klien berhasil dihapus!');
    }

    /**
     * Create appointments for client based on akad and reception dates
     */
    private function createAppointmentsForClient(Client $client)
    {
        // Create appointment for Akad date
        if ($client->akad_date) {
            \App\Models\Appointment::create([
                'title' => $client->client_name . ' - Akad',
                'date' => $client->akad_date,
                'start_time' => $client->akad_time ?? '08:00:00',
                'end_time' => '12:00:00', // Default end time for akad
                'location' => $client->event_location,
                'description' => 'Akad Nikah - ' . $client->client_name,
                'color' => '#ec4899', // Pink for akad
                'client_id' => $client->id,
            ]);
        }

        // Create appointment for Reception date (if different from akad)
        if ($client->reception_date && $client->reception_date != $client->akad_date) {
            \App\Models\Appointment::create([
                'title' => $client->client_name . ' - Resepsi',
                'date' => $client->reception_date,
                'start_time' => $client->reception_time ?? '18:00:00',
                'end_time' => $client->reception_end_time ?? '22:00:00',
                'location' => $client->event_location,
                'description' => 'Resepsi Pernikahan - ' . $client->client_name,
                'color' => '#9333ea', // Purple for reception
                'client_id' => $client->id,
            ]);
        }
    }

    /**
     * Update appointments when client dates change
     */
    private function updateAppointmentsForClient(Client $client)
    {
        // Delete existing appointments for this client (without order_id)
        \App\Models\Appointment::where('client_id', $client->id)
            ->whereNull('order_id')
            ->delete();

        // Recreate appointments with new dates
        $this->createAppointmentsForClient($client);
    }
}

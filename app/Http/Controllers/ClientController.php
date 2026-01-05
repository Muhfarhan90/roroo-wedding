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
                $q->where('bride_name', 'like', "%{$search}%")
                    ->orWhere('groom_name', 'like', "%{$search}%")
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
                $q->where('bride_name', 'like', "%{$search}%")
                    ->orWhere('groom_name', 'like', "%{$search}%");
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
            'bride_name' => 'required|string|max:255',
            'groom_name' => 'required|string|max:255',
            'bride_phone' => 'required|string|max:20',
            'groom_phone' => 'required|string|max:20',
            'bride_address' => 'nullable|string',
            'groom_address' => 'nullable|string',
            'bride_parents' => 'nullable|string|max:255',
            'groom_parents' => 'nullable|string|max:255',
            'akad_date' => 'nullable|date',
            'akad_time' => 'nullable|date_format:H:i',
            'akad_end_time' => 'nullable|date_format:H:i',
            'reception_date' => 'nullable|date',
            'reception_time' => 'nullable|date_format:H:i',
            'reception_end_time' => 'nullable|date_format:H:i',
            'event_location' => 'nullable|string',
        ]);

        $client = Client::create($validated);

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
            'bride_name' => 'required|string|max:255',
            'groom_name' => 'required|string|max:255',
            'bride_phone' => 'required|string|max:20',
            'groom_phone' => 'required|string|max:20',
            'bride_address' => 'nullable|string',
            'groom_address' => 'nullable|string',
            'bride_parents' => 'nullable|string|max:255',
            'groom_parents' => 'nullable|string|max:255',
            'akad_date' => 'nullable|date',
            'akad_time' => 'nullable|date_format:H:i',
            'akad_end_time' => 'nullable|date_format:H:i',
            'reception_date' => 'nullable|date',
            'reception_time' => 'nullable|date_format:H:i',
            'reception_end_time' => 'nullable|date_format:H:i',
            'event_location' => 'nullable|string',
        ]);

        $client->update($validated);

        return redirect()->route('clients.index')
            ->with('success', 'Klien berhasil diupdate!');
    }

    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()->route('clients.index')
            ->with('success', 'Klien berhasil dihapus!');
    }
}

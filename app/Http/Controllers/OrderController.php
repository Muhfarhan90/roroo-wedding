<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Client;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    public function timeline(Request $request)
    {
        $selectedDate = $request->get('date', now()->format('Y-m-d'));
        $date = \Carbon\Carbon::parse($selectedDate);

        // Get orders for the selected date (based on akad_date or reception_date)
        $orders = Order::with('client')
            ->whereHas('client', function ($q) use ($date) {
                $q->whereDate('akad_date', $date->format('Y-m-d'))
                    ->orWhereDate('reception_date', $date->format('Y-m-d'));
            })
            ->orderBy('created_at', 'asc')
            ->get();

        // Count total upcoming events
        $upcomingEventsCount = Order::with('client')
            ->whereHas('client', function ($q) {
                $q->where('akad_date', '>=', now()->format('Y-m-d'))
                    ->orWhere('reception_date', '>=', now()->format('Y-m-d'));
            })
            ->count();

        // Get dates with events for the timeline (30 days range)
        $startDate = $date->copy()->subDays(15);
        $endDate = $date->copy()->addDays(15);
        $datesWithEvents = [];

        for ($d = $startDate->copy(); $d <= $endDate; $d->addDay()) {
            $eventCount = Order::whereHas('client', function ($q) use ($d) {
                $q->whereDate('akad_date', $d->format('Y-m-d'))
                    ->orWhereDate('reception_date', $d->format('Y-m-d'));
            })->count();

            // Only add dates that have events
            if ($eventCount > 0) {
                $datesWithEvents[] = [
                    'date' => $d->format('Y-m-d'),
                    'count' => $eventCount,
                    'isToday' => $d->isToday(),
                    'isSelected' => $d->format('Y-m-d') === $date->format('Y-m-d'),
                ];
            }
        }

        // Find previous date with events
        $previousDate = null;
        $checkDate = $date->copy()->subDay();
        for ($i = 0; $i < 365; $i++) {
            $hasEvents = Order::whereHas('client', function ($q) use ($checkDate) {
                $q->whereDate('akad_date', $checkDate->format('Y-m-d'))
                    ->orWhereDate('reception_date', $checkDate->format('Y-m-d'));
            })->exists();

            if ($hasEvents) {
                $previousDate = $checkDate->format('Y-m-d');
                break;
            }
            $checkDate->subDay();
        }

        // Find next date with events
        $nextDate = null;
        $checkDate = $date->copy()->addDay();
        for ($i = 0; $i < 365; $i++) {
            $hasEvents = Order::whereHas('client', function ($q) use ($checkDate) {
                $q->whereDate('akad_date', $checkDate->format('Y-m-d'))
                    ->orWhereDate('reception_date', $checkDate->format('Y-m-d'));
            })->exists();

            if ($hasEvents) {
                $nextDate = $checkDate->format('Y-m-d');
                break;
            }
            $checkDate->addDay();
        }

        return view('orders.timeline', compact('orders', 'date', 'upcomingEventsCount', 'datesWithEvents', 'previousDate', 'nextDate'));
    }

    public function index(Request $request)
    {
        // Handle PDF export
        if ($request->get('export') === 'pdf') {
            return $this->exportPDF($request);
        }

        $query = Order::with('client');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('client', function ($q) use ($search) {
                $q->where('bride_name', 'like', "%{$search}%")
                    ->orWhere('groom_name', 'like', "%{$search}%");
            })->orWhere('order_number', 'like', "%{$search}%");
        }

        // Date range filter
        if ($request->has('start_date') && $request->start_date) {
            $query->whereHas('client', function ($q) use ($request) {
                $q->where('akad_date', '>=', $request->start_date);
            });
        }
        if ($request->has('end_date') && $request->end_date) {
            $query->whereHas('client', function ($q) use ($request) {
                $q->where('akad_date', '<=', $request->end_date);
            });
        }

        // Sort
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'bride_name':
                    $query->join('clients', 'orders.client_id', '=', 'clients.id')
                        ->orderBy('clients.bride_name', 'asc')
                        ->select('orders.*');
                    break;
                case 'akad_date':
                    $query->join('clients', 'orders.client_id', '=', 'clients.id')
                        ->orderBy('clients.akad_date', 'asc')
                        ->select('orders.*');
                    break;
                case 'reception_date':
                    $query->join('clients', 'orders.client_id', '=', 'clients.id')
                        ->orderBy('clients.reception_date', 'asc')
                        ->select('orders.*');
                    break;
                default:
                    $query->latest();
            }
        } else {
            $query->latest();
        }

        $perPage = $request->get('per_page', 25);
        $orders = $query->paginate($perPage)->withQueryString();

        return view('orders.index', compact('orders'));
    }

    private function exportPDF(Request $request)
    {
        $query = Order::with('client');

        // Apply same filters
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('client', function ($q) use ($search) {
                $q->where('bride_name', 'like', "%{$search}%")
                    ->orWhere('groom_name', 'like', "%{$search}%");
            });
        }

        if ($request->has('start_date') && $request->start_date) {
            $query->whereHas('client', function ($q) use ($request) {
                $q->where('akad_date', '>=', $request->start_date);
            });
        }
        if ($request->has('end_date') && $request->end_date) {
            $query->whereHas('client', function ($q) use ($request) {
                $q->where('akad_date', '<=', $request->end_date);
            });
        }

        $orders = $query->get();

        // Validasi jika tidak ada data
        if ($orders->isEmpty()) {
            return redirect()->route('orders.index')
                ->with('error', 'Tidak ada data pesanan untuk di-export. Silakan sesuaikan filter pencarian Anda.');
        }

        $pdf = \PDF::loadView('orders.pdf-list', compact('orders'));
        return $pdf->download('orders-' . date('Y-m-d') . '.pdf');
    }

    public function create()
    {
        $clients = Client::orderBy('bride_name')->get();
        return view('orders.create', compact('clients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'items' => 'nullable|string', // Changed to string since it's JSON
            'total_amount' => 'required|numeric|min:0',
            'payment_status' => 'required|string',
            'decorations' => 'nullable|array',
            'decorations.photo_pelaminan' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'decorations.photo_kain_tenda' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'decorations.foto_gaun_1' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'decorations.foto_gaun_2' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'decorations.foto_gaun_3' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'notes' => 'nullable|string',
            'paid_amount' => 'nullable|numeric|min:0',
            'dp_type' => 'nullable|string',
            'payment_method' => 'nullable|string',
            'payment_notes' => 'nullable|string',
        ]);

        // Decode items JSON string to array
        if (!empty($validated['items'])) {
            $validated['items'] = json_decode($validated['items'], true);
        } else {
            $validated['items'] = [];
        }

        // Handle file uploads for decorations
        $decorations = $validated['decorations'] ?? [];

        // Photo pelaminan
        if ($request->hasFile('decorations.photo_pelaminan')) {
            $file = $request->file('decorations.photo_pelaminan');
            $filename = time() . '_pelaminan.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('decorations', $filename, 'public');
            $decorations['photo_pelaminan'] = $path;
        }

        // Photo kain tenda
        if ($request->hasFile('decorations.photo_kain_tenda')) {
            $file = $request->file('decorations.photo_kain_tenda');
            $filename = time() . '_kain_tenda.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('decorations', $filename, 'public');
            $decorations['photo_kain_tenda'] = $path;
        }

        // Foto gaun 1-3
        for ($i = 1; $i <= 3; $i++) {
            if ($request->hasFile("decorations.foto_gaun_{$i}")) {
                $file = $request->file("decorations.foto_gaun_{$i}");
                $filename = time() . "_gaun_{$i}." . $file->getClientOriginalExtension();
                $path = $file->storeAs('decorations', $filename, 'public');
                $decorations["foto_gaun_{$i}"] = $path;
            }
        }

        $validated['decorations'] = $decorations;

        // Initialize payment history
        $paymentHistory = [];

        // Add initial payment if provided - default to DP1 if no dp_type specified
        if (!empty($validated['paid_amount']) && $validated['paid_amount'] > 0) {
            $dpType = !empty($validated['dp_type']) ? $validated['dp_type'] : 'DP1';
            $paymentHistory[] = [
                'dp_number' => $dpType,
                'amount' => $validated['paid_amount'],
                'payment_method' => $validated['payment_method'] ?? 'Transfer Bank',
                'notes' => $validated['payment_notes'] ?? null,
                'paid_at' => now()->format('Y-m-d H:i:s'),
            ];
        }

        $validated['payment_history'] = $paymentHistory;
        $totalPaid = array_sum(array_column($paymentHistory, 'amount'));
        $validated['remaining_amount'] = $validated['total_amount'] - $totalPaid;

        // Remove fields that are not in the orders table
        unset($validated['paid_amount'], $validated['dp_type'], $validated['payment_method'], $validated['payment_notes']);

        $order = Order::create($validated);

        return redirect()->route('orders.show', $order)
            ->with('success', 'Pesanan berhasil dibuat!');
    }

    public function show(Order $order)
    {
        $order->load('client');
        return view('orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        $clients = Client::orderBy('bride_name')->get();
        $order->load('client');
        return view('orders.edit', compact('order', 'clients'));
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'items' => 'nullable|string', // Changed to string since it's JSON
            'total_amount' => 'required|numeric|min:0',
            'payment_status' => 'required|string',
            'decorations' => 'nullable|array',
            'notes' => 'nullable|string',
        ]);

        // Decode items JSON string to array
        if (!empty($validated['items'])) {
            $validated['items'] = json_decode($validated['items'], true);
        } else {
            $validated['items'] = [];
        }

        // Recalculate remaining amount based on payment history
        $paymentHistory = $order->payment_history ?? [];
        $totalPaid = 0;
        foreach ($paymentHistory as $payment) {
            $totalPaid += floatval($payment['amount'] ?? 0);
        }
        $validated['remaining_amount'] = $validated['total_amount'] - $totalPaid;

        $order->update($validated);

        return redirect()->route('orders.show', $order)
            ->with('success', 'Pesanan berhasil diperbarui!');
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('orders.index')
            ->with('success', 'Pesanan berhasil dihapus!');
    }

    public function addPayment(Request $request, Order $order)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0|max:' . $order->remaining_amount,
            'payment_method' => 'required|string',
            'notes' => 'nullable|string',
            'dp_number' => 'required|string',
        ]);

        // Get existing payment history or initialize as empty array
        $paymentHistory = $order->payment_history ?? [];

        // Add new payment
        $paymentHistory[] = [
            'dp_number' => $validated['dp_number'],
            'amount' => $validated['amount'],
            'payment_method' => $validated['payment_method'],
            'notes' => $validated['notes'] ?? null,
            'paid_at' => now()->format('Y-m-d H:i:s'),
        ];

        $order->payment_history = $paymentHistory;

        // Recalculate remaining amount
        $totalPaid = array_sum(array_column($paymentHistory, 'amount'));
        $order->remaining_amount = $order->total_amount - $totalPaid;

        // Update payment status
        if ($order->remaining_amount <= 0) {
            $order->payment_status = 'Lunas';
        } else {
            $order->payment_status = 'Belum Lunas';
        }

        $order->save();
        // Invoice akan otomatis ter-update melalui OrderObserver

        return redirect()->route('orders.show', $order)
            ->with('success', 'Pembayaran berhasil ditambahkan!');
    }

    public function createInvoice(Request $request, Order $order)
    {
        // Check if invoice already exists for this order
        $existingInvoice = Invoice::where('order_id', $order->id)->first();
        if ($existingInvoice) {
            return redirect()->route('invoices.show', $existingInvoice)
                ->with('info', 'Invoice untuk pesanan ini sudah ada.');
        }

        // Use provided due_date or default to 7 days from now
        $dueDate = $request->input('due_date', now()->addDays(7)->format('Y-m-d'));

        // Calculate total paid from payment_history
        $paymentHistory = $order->payment_history ?? [];
        $totalPaid = 0;
        foreach ($paymentHistory as $payment) {
            $totalPaid += $payment['amount'] ?? 0;
        }

        // Create invoice
        $invoice = new Invoice();
        $invoice->order_id = $order->id;
        $invoice->issue_date = now();
        $invoice->due_date = $dueDate; // Use calculated or provided due date
        $invoice->total_amount = $order->total_amount;
        $invoice->paid_amount = $totalPaid; // Set paid_amount first
        $invoice->remaining_amount = $invoice->total_amount - $invoice->paid_amount; // Calculate remaining

        // Update status based on payment
        if ($invoice->paid_amount >= $invoice->total_amount) {
            $invoice->status = 'Paid';
        } elseif ($invoice->paid_amount > 0) {
            $invoice->status = 'Partial';
        } else {
            $invoice->status = 'Unpaid';
        }

        $invoice->save();

        return redirect()->route('invoices.show', $invoice)
            ->with('success', 'Invoice berhasil dibuat!');
    }

    public function downloadPdf(Order $order)
    {
        $pdf = Pdf::loadView('orders.pdf', compact('order'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('Order-' . $order->order_number . '.pdf');
    }

    public function syncPayments()
    {
        $orders = Order::with('invoice')->get();
        $synced = 0;
        $errors = [];

        foreach ($orders as $order) {
            // Calculate total paid from payment_history
            $paymentHistory = is_array($order->payment_history) ? $order->payment_history : [];
            $totalPaid = collect($paymentHistory)->sum('amount');

            // Recalculate order remaining amount and status
            $orderRemainingAmount = $order->total_price - $totalPaid;

            $order->payment_status = $orderRemainingAmount <= 0 ? 'Lunas' : 'Belum Lunas';
            $order->remaining_amount = max(0, $orderRemainingAmount);
            $order->save();

            // Update related invoice if exists
            if ($order->invoice) {
                try {
                    $invoice = $order->invoice;
                    $invoice->paid_amount = $totalPaid;
                    $invoice->remaining_amount = max(0, $invoice->total_amount - $totalPaid);

                    // Update invoice status
                    if ($invoice->paid_amount >= $invoice->total_amount) {
                        $invoice->status = 'Paid';
                    } elseif ($invoice->paid_amount > 0) {
                        $invoice->status = 'Partial';
                    } else {
                        $invoice->status = 'Unpaid';
                    }

                    $invoice->save();
                    $synced++;
                } catch (\Exception $e) {
                    $errors[] = "Error syncing order #{$order->order_number}: " . $e->getMessage();
                }
            }
        }

        $message = "Sinkronisasi selesai. {$synced} invoice berhasil disinkronkan.";
        if (count($errors) > 0) {
            $message .= " Dengan " . count($errors) . " error.";
        }

        return redirect()->back()->with('success', $message);
    }
}

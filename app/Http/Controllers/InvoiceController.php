<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Order;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        // Handle PDF export
        if ($request->get('export') === 'pdf') {
            return $this->exportPDF($request);
        }

        $query = Invoice::with(['order.client']);

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                    ->orWhereHas('order.client', function ($q) use ($search) {
                        $q->where('bride_name', 'like', "%{$search}%")
                            ->orWhere('groom_name', 'like', "%{$search}%");
                    });
            });
        }

        // Date range filter
        if ($request->has('start_date') && $request->start_date) {
            $query->where('issue_date', '>=', $request->start_date);
        }
        if ($request->has('end_date') && $request->end_date) {
            $query->where('issue_date', '<=', $request->end_date);
        }

        // Sort
        $sortBy = $request->get('sort', 'created_at');

        if ($sortBy === 'client_name') {
            $query->join('orders', 'invoices.order_id', '=', 'orders.id')
                ->join('clients', 'orders.client_id', '=', 'clients.id')
                ->orderBy('clients.bride_name', 'asc')
                ->select('invoices.*');
        } elseif ($sortBy === 'issue_date') {
            $query->orderBy('issue_date', 'asc');
        } else {
            $query->orderBy($sortBy, 'desc');
        }

        $perPage = $request->get('per_page', 25);
        $invoices = $query->paginate($perPage)->withQueryString();

        return view('invoices.index', compact('invoices'));
    }

    private function exportPDF(Request $request)
    {
        $query = Invoice::with(['order.client']);

        // Apply same filters
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                    ->orWhereHas('order.client', function ($q) use ($search) {
                        $q->where('bride_name', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->has('start_date') && $request->start_date) {
            $query->where('issue_date', '>=', $request->start_date);
        }
        if ($request->has('end_date') && $request->end_date) {
            $query->where('issue_date', '<=', $request->end_date);
        }

        $invoices = $query->get();

        // Validasi jika tidak ada data
        if ($invoices->isEmpty()) {
            return redirect()->route('invoices.index')
                ->with('error', 'Tidak ada data invoice untuk di-export. Silakan sesuaikan filter pencarian Anda.');
        }

        $pdf = \PDF::loadView('invoices.pdf-list', compact('invoices'));
        return $pdf->download('invoices-' . date('Y-m-d') . '.pdf');
    }

    public function show($id)
    {
        $invoice = Invoice::with(['order.client'])->findOrFail($id);
        return view('invoices.show', compact('invoice'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'issue_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:issue_date',
            'notes' => 'nullable|string',
        ]);

        $order = Order::findOrFail($validated['order_id']);

        // Calculate total paid from payment_history
        $paymentHistory = $order->payment_history ?? [];
        $totalPaid = 0;
        foreach ($paymentHistory as $payment) {
            $totalPaid += $payment['amount'] ?? 0;
        }

        $invoice = new Invoice($validated);
        $invoice->total_amount = $order->total_amount;
        $invoice->paid_amount = $totalPaid;
        $invoice->calculateRemainingAmount();
        $invoice->updateStatus();
        $invoice->save();

        return redirect()->route('invoices.show', $invoice)
            ->with('success', 'Invoice berhasil dibuat');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'issue_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:issue_date',
            'notes' => 'nullable|string',
        ]);

        $invoice = Invoice::findOrFail($id);
        $invoice->update($validated);

        return redirect()->route('invoices.show', $invoice)
            ->with('success', 'Invoice berhasil diperbarui');
    }

    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();

        return redirect()->route('invoices.index')
            ->with('success', 'Invoice berhasil dihapus');
    }

    public function downloadPdf($encryptedId, Request $request)
    {
        $invoice = Invoice::findOrFail($encryptedId);
        $invoice->load('order.client');

        // Check if custom due_date is provided
        if ($request->has('due_date') && $request->due_date) {
            // Temporarily override due_date for PDF generation
            $invoice->due_date = $request->due_date;
        }

        $pdf = Pdf::loadView('invoices.pdf', compact('invoice'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('Invoice-' . $invoice->invoice_number . '.pdf');
    }
}

@extends('layouts.admin')

@section('content')
    <div class="min-h-screen bg-gray-50 p-6">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <a href="{{ route('invoices.index') }}"
                        class="text-sm text-gray-600 hover:text-[#d4b896] flex items-center gap-1 mb-2">
                        <span class="material-symbols-outlined text-base">arrow_back</span>
                        Back to Invoices
                    </a>
                    <h1 class="text-2xl font-bold text-gray-900">Pratinjau Generator Faktur</h1>
                    <p class="text-gray-600 text-sm mt-1">Tinjau dan selesaikan faktur untuk Pesanan
                        #{{ $invoice->order->order_number }}</p>
                </div>
                <button onclick="downloadPDF()"
                    class="inline-flex items-center gap-1 sm:gap-2 px-3 sm:px-4 py-2 text-sm sm:text-base bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                    <span class="material-symbols-outlined text-lg sm:text-2xl">picture_as_pdf</span>
                    <span>Export PDF</span>
                </button>
            </div>

            <!-- Edit Jatuh Tempo - Mobile Only (Shown at top) -->
            <div class="lg:hidden mb-6">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Edit Jatuh Tempo</h3>
                    @php
                        $paymentHistoryCheck = $invoice->order->payment_history ?? [];
                        $totalPaidCheck = 0;
                        foreach ($paymentHistoryCheck as $payment) {
                            $totalPaidCheck += floatval($payment['amount'] ?? 0);
                        }
                        $isFullyPaidMobile = $totalPaidCheck >= $invoice->total_amount;
                    @endphp
                    @if (!$isFullyPaidMobile)
                        <div class="space-y-3">
                            <label for="dueDateEditMobile" class="block text-sm font-medium text-gray-700">Tanggal Jatuh
                                Tempo</label>
                            <input type="date" id="dueDateEditMobile"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#d4b896] focus:border-transparent"
                                value="{{ \Carbon\Carbon::parse($invoice->due_date)->format('Y-m-d') }}">
                            <p class="text-xs text-gray-500">Ubah tanggal jatuh tempo untuk invoice ini sebelum
                                download PDF</p>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <span class="text-green-600 font-semibold">✓ Invoice Lunas</span>
                            <p class="text-xs text-gray-500 mt-2">Jatuh tempo tidak berlaku untuk invoice yang sudah
                                lunas</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Invoice Preview (Left Side) -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8" id="invoicePreview">
                        <!-- Header -->
                        <div class="flex justify-between items-start mb-6 pb-6 border-b border-[#e8d5c4]">
                            <div class="flex items-center gap-4">
                                <img src="{{ asset('logo/logo-roroo-wedding.png') }}" alt="RORO MUA Logo"
                                    class="w-20 h-20 rounded-full object-cover">
                                <div>
                                    <h2 class="text-5xl font-bold text-gray-700">FAKTUR</h2>
                                    <p class="text-xs text-gray-500 mt-1">{{ $invoice->invoice_number }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <h3 class="text-lg font-bold text-gray-900">{{ $profile->business_name ?? 'RORO MUA' }}</h3>
                                @if ($profile && $profile->address)
                                    @foreach (explode("\n", $profile->address) as $line)
                                        <p class="text-[10px] text-gray-500 mt-1">{{ $line }}</p>
                                    @endforeach
                                @else
                                    <p class="text-[10px] text-gray-500 mt-1">Perumahan Kaliwulu blok AC no.1</p>
                                    <p class="text-[10px] text-gray-500">Kec.Plered Kab Cirebon</p>
                                    <p class="text-[10px] text-gray-500">(Depan Lapangan)</p>
                                @endif
                            </div>
                        </div>

                        <!-- Invoice Info -->
                        <div class="grid grid-cols-2 gap-6 mb-6">
                            <div>
                                <p class="text-xs font-bold text-[#8b6f47] uppercase tracking-wide mb-3">DITERBITKAN KEPADA
                                </p>
                                <p class="text-sm font-bold text-gray-900 mb-2">{{ $invoice->order->client->client_name }}
                                </p>
                                <p class="text-xs text-gray-600 mb-1">
                                    <span class="text-gray-500">Tanggal Akad:</span>
                                    <span
                                        class="font-semibold text-gray-900">{{ $invoice->order->client->akad_date ? \Carbon\Carbon::parse($invoice->order->client->akad_date)->format('d F Y') : '-' }}</span>
                                </p>
                                <p class="text-xs text-gray-600 mb-1">
                                    <span class="text-gray-500">Tanggal Resepsi:</span>
                                    <span
                                        class="font-semibold text-gray-900">{{ $invoice->order->client->reception_date ? \Carbon\Carbon::parse($invoice->order->client->reception_date)->format('d F Y') : '-' }}</span>
                                </p>
                                <p class="text-xs text-gray-600">
                                    <span class="text-gray-500">Lokasi Acara:</span>
                                    <span
                                        class="font-semibold text-gray-900">{{ $invoice->order->client->event_location ?? '-' }}</span>
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-xs font-bold text-[#8b6f47] uppercase tracking-wide mb-3">DETAIL PEMBAYARAN
                                </p>
                                <div class="mb-1">
                                    <span class="text-xs text-gray-500">Tanggal Terbit:</span>
                                    <span
                                        class="text-xs font-bold text-gray-900">{{ \Carbon\Carbon::parse($invoice->issue_date)->format('M d, Y') }}</span>
                                </div>
                                @php
                                    $paymentHistoryCheck = $invoice->order->payment_history ?? [];
                                    $totalPaidCheck = 0;
                                    foreach ($paymentHistoryCheck as $payment) {
                                        $totalPaidCheck += floatval($payment['amount'] ?? 0);
                                    }
                                    $isFullyPaid = $totalPaidCheck >= $invoice->total_amount;
                                @endphp
                                <div class="mb-1">
                                    <span class="text-xs text-gray-500">Jatuh Tempo:</span>
                                    @if ($isFullyPaid)
                                        <span id="previewDueDate" class="text-xs font-bold text-green-600">Lunas ✓</span>
                                    @else
                                        <span id="previewDueDate"
                                            class="text-xs font-bold text-gray-900">{{ \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}</span>
                                    @endif
                                </div>
                                <div>
                                    <span class="text-xs text-gray-500">ID Pesanan:</span>
                                    <span
                                        class="text-xs font-bold text-gray-900">{{ $invoice->order->order_number }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Items Table -->
                        <div class="mb-6 overflow-x-auto">
                            <table class="w-full border-collapse">
                                <thead>
                                    <tr class="border-t-2 border-b-2 border-[#d4b896] bg-white">
                                        <th
                                            class="px-3 py-2.5 text-left text-[10px] font-semibold text-[#8b6f47] uppercase tracking-wide">
                                            LAYANAN
                                        </th>
                                        <th class="px-3 py-2.5 text-center text-[10px] font-semibold text-[#8b6f47] uppercase tracking-wide"
                                            style="width: 50px;">
                                            QTY
                                        </th>
                                        <th class="px-3 py-2.5 text-right text-[10px] font-semibold text-[#8b6f47] uppercase tracking-wide"
                                            style="width: 120px;">
                                            HARGA
                                        </th>
                                        <th class="px-3 py-2.5 text-right text-[10px] font-semibold text-[#8b6f47] uppercase tracking-wide"
                                            style="width: 120px;">
                                            TOTAL
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $items = is_array($invoice->order->items) ? $invoice->order->items : [];
                                    @endphp
                                    @foreach ($items as $item)
                                        <tr class="border-b border-[#d4b896]">
                                            <td class="px-3 py-2 text-sm text-gray-800">{{ $item['name'] }}</td>
                                            <td class="px-3 py-2 text-sm text-center text-gray-800">{{ $item['quantity'] }}
                                            </td>
                                            <td class="px-3 py-2 text-sm text-right text-gray-800">Rp
                                                {{ number_format($item['price'], 0, ',', '.') }}</td>
                                            <td class="px-3 py-2 text-sm text-right font-semibold text-gray-900">Rp
                                                {{ number_format($item['total'], 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Totals -->
                        <div class="pt-4">
                            @php
                                $paymentHistory = $invoice->order->payment_history ?? [];
                                $totalPaid = 0;
                                foreach ($paymentHistory as $payment) {
                                    $totalPaid += floatval($payment['amount'] ?? 0);
                                }
                            @endphp

                            <div class="flex justify-end mb-4">
                                <div class="w-80">
                                    <!-- Jumlah Total -->
                                    <div class="flex justify-between py-2 border-b-2 border-[#d4b896]">
                                        <span class="text-sm font-bold text-gray-900">Jumlah Total</span>
                                        <span class="text-sm font-bold text-gray-900">Rp
                                            {{ number_format($invoice->total_amount, 0, ',', '.') }}</span>
                                    </div>

                                    <!-- DP/Pembayaran Container -->
                                    @if (count($paymentHistory) > 0)
                                        <div class="bg-[#f0fdf4] border border-[#86efac] rounded px-3 py-2 my-3">
                                            @foreach ($paymentHistory as $index => $payment)
                                                <div
                                                    class="flex justify-between py-1.5 {{ $index < count($paymentHistory) - 1 ? 'border-b border-[#d1fae5]' : '' }}">
                                                    <span
                                                        class="text-xs font-semibold text-[#166534]">{{ $payment['dp_number'] ?? 'DP' }}</span>
                                                    <span class="text-xs font-bold text-[#16a34a]">Rp
                                                        {{ number_format($payment['amount'] ?? 0, 0, ',', '.') }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

                                    <!-- Sisa Tagihan -->
                                    <div class="bg-[#fff3e0] border border-[#ffb74d] px-3 py-2 rounded">
                                        <div class="flex justify-between">
                                            <span class="text-xs font-bold text-[#9a3412]">Sisa Tagihan</span>
                                            <span class="text-xs font-bold text-[#ea580c]">Rp
                                                {{ number_format($invoice->total_amount - $totalPaid, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="mt-6 pt-6 border-t-2 border-[#d4b896]">
                            <h4 class="text-xs font-bold text-[#8b6f47] uppercase tracking-wide mb-3">CATATAN / KETERANGAN
                            </h4>
                            <div class="text-sm text-gray-700 space-y-2">
                                @php
                                    $paymentHistory = $invoice->order->payment_history ?? [];
                                    $lastPayment = count($paymentHistory) > 0 ? end($paymentHistory) : null;
                                @endphp
                                @if ($lastPayment)
                                    <p class="text-xs"><span class="font-semibold text-gray-900">Invoice untuk:</span>
                                        <span class="text-gray-700">Pembayaran {{ $lastPayment['dp_number'] ?? 'N/A' }} -
                                            {{ $invoice->order->order_number }}</span>
                                    </p>
                                    <p class="text-xs text-gray-600 italic mt-2">Terima kasih telah memilih ROROO MUA untuk
                                        hari istimewa Anda! Kami sangat menghargai kepercayaan Anda.</p>
                                @else
                                    <p class="text-xs text-gray-500">-</p>
                                @endif
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="mt-8 pt-6 border-t border-[#d4b896]">
                            <div class="flex justify-start items-start text-xs text-gray-600">
                                <div>
                                    <p class="font-bold text-gray-900 mb-2">Informasi Bank</p>
                                    @if ($profile && $profile->banks && count($profile->banks) > 0)
                                        @foreach ($profile->banks as $bank)
                                            <p class="text-xs text-gray-700">{{ $bank['bank_name'] }}:
                                                {{ $bank['account_number'] }} a/n {{ $bank['account_holder'] }}</p>
                                        @endforeach
                                    @else
                                        <p class="text-xs text-gray-700">BCA: 774 539 3493 a/n Tatimatu Ghofaroh</p>
                                        <p class="text-xs text-gray-700">BRI: 0101 01030 547 563 a/n Tatimatu Ghofaroh</p>
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar (Right Side) -->
                <div class="lg:col-span-1 space-y-6">

                    <!-- Edit Jatuh Tempo - Desktop Only -->
                    <div class="hidden lg:block bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Edit Jatuh Tempo</h3>
                        @if (!$isFullyPaid)
                            <div class="space-y-3">
                                <label for="dueDateEdit" class="block text-sm font-medium text-gray-700">Tanggal Jatuh
                                    Tempo</label>
                                <input type="date" id="dueDateEdit"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#d4b896] focus:border-transparent"
                                    value="{{ \Carbon\Carbon::parse($invoice->due_date)->format('Y-m-d') }}">
                                <p class="text-xs text-gray-500">Ubah tanggal jatuh tempo untuk invoice ini sebelum
                                    download PDF</p>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <span class="text-green-600 font-semibold">✓ Invoice Lunas</span>
                                <p class="text-xs text-gray-500 mt-2">Jatuh tempo tidak berlaku untuk invoice yang sudah
                                    lunas</p>
                            </div>
                        @endif
                    </div>

                    <!-- Riwayat Pembayaran -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Riwayat Pembayaran</h3>
                        <div class="space-y-3">
                            @php
                                $paymentHistory = $invoice->order->payment_history ?? [];
                            @endphp
                            @if (count($paymentHistory) > 0)
                                @foreach ($paymentHistory as $payment)
                                    <div class="p-3 bg-gray-50 rounded-lg border-l-4 border-[#d4b896]">
                                        <div class="flex justify-between items-start mb-1">
                                            <span
                                                class="text-sm font-semibold text-gray-900">{{ $payment['dp_number'] ?? 'DP' }}</span>
                                            <span class="text-sm font-semibold text-[#d4b896]">Rp
                                                {{ number_format($payment['amount'] ?? 0, 0, ',', '.') }}</span>
                                        </div>
                                        <p class="text-xs text-gray-600">
                                            {{ \Carbon\Carbon::parse($payment['paid_at'] ?? now())->format('M d, Y') }} via
                                            {{ $payment['payment_method'] ?? 'Transfer Bank' }}
                                        </p>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center text-sm text-gray-500 py-4">
                                    Belum ada pembayaran
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Catatan / Keterangan -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Catatan / Keterangan</h3>
                        <div class="space-y-3">
                            @php
                                $paymentHistory = $invoice->order->payment_history ?? [];
                                $lastPayment = count($paymentHistory) > 0 ? end($paymentHistory) : null;
                            @endphp
                            @if ($lastPayment)
                                <div class="text-sm text-gray-700 space-y-2">
                                    <p><span class="font-semibold text-gray-900">Invoice untuk:</span> Pembayaran
                                        {{ $lastPayment['dp_number'] ?? 'N/A' }} - {{ $invoice->order->order_number }}</p>
                                    <p class="text-gray-600 italic pt-2">Terima kasih telah memilih ROROO MUA untuk hari
                                        istimewa Anda! Kami sangat menghargai kepercayaan Anda.</p>
                                </div>
                            @else
                                <p class="text-sm text-gray-500">Belum ada catatan</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Edit due date functionality - Handle both mobile and desktop inputs
        const dueDateEdit = document.getElementById('dueDateEdit');
        const dueDateEditMobile = document.getElementById('dueDateEditMobile');
        const previewDueDate = document.getElementById('previewDueDate');

        function updateDueDate() {
            // Determine which input was changed
            const sourceInput = this;
            const newValue = sourceInput.value;

            // Sync the other input
            if (sourceInput.id === 'dueDateEdit' && dueDateEditMobile) {
                dueDateEditMobile.value = newValue;
            } else if (sourceInput.id === 'dueDateEditMobile' && dueDateEdit) {
                dueDateEdit.value = newValue;
            }

            // Update preview
            const selectedDate = new Date(newValue);
            const options = {
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            };
            const formattedDate = selectedDate.toLocaleDateString('en-US', options);

            if (previewDueDate) {
                previewDueDate.textContent = formattedDate;
            }
        }

        // Attach event listeners to both inputs
        if (dueDateEdit) {
            dueDateEdit.addEventListener('change', updateDueDate);
        }
        if (dueDateEditMobile) {
            dueDateEditMobile.addEventListener('change', updateDueDate);
        }

        function downloadPDF() {
            // Get the updated due date from either input (both should be synced)
            const dueDate = (dueDateEdit && dueDateEdit.value) || (dueDateEditMobile && dueDateEditMobile.value) ||
                '{{ $invoice->due_date }}';

            // Redirect to PDF download with updated due date
            window.location.href = '{{ route('invoices.download-pdf', $invoice->id) }}?due_date=' + dueDate;
        }
    </script>

    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            #invoicePreview,
            #invoicePreview * {
                visibility: visible;
            }

            #invoicePreview {
                position: absolute;
                left: 0;
                top: 0;
            }
        }
    </style>
@endsection

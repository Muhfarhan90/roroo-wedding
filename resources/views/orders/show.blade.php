@extends('layouts.admin')

@section('title', 'Pesanan #' . $order->order_number . ' - ROROO MUA Admin')

@section('content')
    <div class="min-h-screen bg-gray-50 text-black p-4 sm:p-6 md:p-8">
        <!-- Page Header -->
        <div class="mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <a href="{{ route('orders.index') }}"
                        class="text-sm text-gray-600 hover:text-[#d4b896] flex items-center gap-1 mb-2">
                        <span class="material-symbols-outlined text-base">arrow_back</span>
                        Back to Orders
                    </a>
                    <h1 class="text-2xl md:text-3xl font-bold mb-2 text-black">Pesanan #{{ $order->order_number }}</h1>
                    <p class="text-sm md:text-base text-gray-600">Tampilkan detail pesanan untuk:
                        {{ $order->client->bride_name }} && {{ $order->client->groom_name }}</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-2">
                    <a href="{{ route('orders.edit', $order) }}"
                        class="inline-flex items-center justify-center gap-1 px-3 py-2 bg-gray-100 text-black rounded-lg hover:bg-gray-200 transition-colors font-medium shadow-sm text-sm">
                        <span class="material-symbols-outlined text-lg">edit</span>
                        <span>Ubah Pesanan</span>
                    </a>
                    <a href="{{ route('orders.download-pdf', $order) }}"
                        class="inline-flex items-center justify-center gap-1 px-3 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-medium shadow-sm text-sm">
                        <span class="material-symbols-outlined text-lg">picture_as_pdf</span>
                        <span>Export PDF</span>
                    </a>
                </div>
            </div>

            <!-- Invoice Form / Status -->
            @php
                $existingInvoice = $order->invoices()->first();
            @endphp

            @if (!$existingInvoice)
                <!-- Invoice Form -->
                <div class="mt-6 bg-white border-2 border-[#d4b896] rounded-xl p-6 shadow-lg">
                    <h3 class="text-lg font-bold mb-4 text-black">Buat Faktur Baru</h3>
                    <form action="{{ route('orders.create-invoice', $order) }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <!-- Issue Date (Read Only) -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Tanggal Terbit
                                </label>
                                <input type="text" value="{{ now()->format('d F Y') }}" readonly
                                    class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg bg-gray-50 text-gray-600 cursor-not-allowed">
                                <p class="text-xs text-gray-500 mt-1">Otomatis menggunakan tanggal hari ini</p>
                            </div>

                            <!-- Due Date -->
                            <div>
                                <label for="due_date" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Jatuh Tempo <span class="text-red-500">*</span>
                                </label>
                                <input type="date" id="due_date" name="due_date"
                                    value="{{ now()->addDays(7)->format('Y-m-d') }}" min="{{ now()->format('Y-m-d') }}"
                                    class="w-full px-4 py-2 border-2 border-gray-200 rounded-lg focus:border-[#d4b896] focus:outline-none transition-colors">
                                <p class="text-xs text-gray-500 mt-1">Default: 7 hari dari sekarang</p>
                            </div>
                        </div>

                        <!-- Summary -->
                        <div class="bg-gray-50 rounded-lg p-4 mb-4">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <span class="text-xs text-gray-600">Total Pesanan</span>
                                    <p class="text-lg font-semibold">Rp
                                        {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-600">Sudah Dibayar</span>
                                    <p class="text-lg font-semibold text-green-600">
                                        Rp
                                        {{ number_format(array_sum(array_column($order->payment_history ?? [], 'amount')), 0, ',', '.') }}
                                    </p>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-600">Sisa Tagihan</span>
                                    <p class="text-lg font-bold text-red-600">Rp
                                        {{ number_format($order->remaining_amount, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div>
                            <button type="submit"
                                class="w-full px-6 py-3 bg-[#d4b896] text-black rounded-lg hover:bg-[#c4a886] transition-colors font-medium shadow-sm">
                                <span class="material-symbols-outlined inline-block align-middle mr-1">receipt</span>
                                Buat Faktur Sekarang
                            </button>
                        </div>
                    </form>
                </div>
            @else
                <!-- Invoice Already Exists -->
                <div class="mt-6 bg-blue-50 border-2 border-blue-200 rounded-xl p-6 shadow-lg">
                    <div class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-blue-600 text-2xl">info</span>
                        <div class="flex-1">
                            <h3 class="text-lg font-bold mb-2 text-blue-900">Invoice Sudah Dibuat</h3>
                            <p class="text-sm text-blue-700 mb-3">Invoice untuk pesanan ini sudah dibuat dengan nomor
                                <strong>{{ $existingInvoice->invoice_number }}</strong>
                            </p>
                            <a href="{{ route('invoices.show', $existingInvoice) }}"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">
                                <span class="material-symbols-outlined text-base">visibility</span>
                                <span>Lihat Invoice</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Item Pesanan -->
                <div class="bg-white border-2 border-[#d4b896] rounded-xl p-6 shadow-lg">
                    <h2 class="text-lg font-bold mb-4 text-black">Item Pesanan</h2>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b-2 border-gray-200">
                                <tr>
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">ITEM / PAKET</th>
                                    <th class="px-4 py-3 text-center text-sm font-semibold text-gray-600">JML</th>
                                    <th class="px-4 py-3 text-right text-sm font-semibold text-gray-600">HARGA</th>
                                    <th class="px-4 py-3 text-right text-sm font-semibold text-gray-600">TOTAL</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @if (is_array($order->items) && count($order->items) > 0)
                                    @foreach ($order->items as $item)
                                        <tr>
                                            <td class="px-4 py-3 text-sm">{{ $item['name'] ?? 'N/A' }}</td>
                                            <td class="px-4 py-3 text-sm text-center">{{ $item['quantity'] ?? 0 }}</td>
                                            <td class="px-4 py-3 text-sm text-right">Rp
                                                {{ number_format($item['price'] ?? 0, 0, ',', '.') }}</td>
                                            <td class="px-4 py-3 text-sm text-right font-medium">Rp
                                                {{ number_format($item['total'] ?? 0, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" class="px-4 py-6 text-center text-gray-500">Tidak ada item</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <!-- Total -->
                    <div class="mt-6 border-t-2 border-gray-200 pt-4">
                        <div class="flex justify-end">
                            <div class="w-full md:w-1/2">
                                <div class="flex justify-between items-center mb-2 text-lg">
                                    <span class="font-semibold text-gray-700">Total</span>
                                    <span class="font-bold text-black">Rp
                                        {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pilihan Kustom -->
                @if (is_array($order->decorations) && count($order->decorations) > 0)
                    <div class="bg-white border-2 border-[#d4b896] rounded-xl p-6 shadow-lg">
                        <h2 class="text-lg font-bold mb-4 text-black">Pilihan Kustom</h2>

                        <div class="space-y-6">
                            @if (isset($order->decorations['photo_pelaminan']) && is_string($order->decorations['photo_pelaminan']))
                                <div>
                                    <h3 class="text-sm font-semibold mb-2">Foto Model Pelaminan</h3>
                                    <div class="bg-gray-100 rounded-lg overflow-hidden cursor-pointer hover:opacity-90 transition-opacity"
                                        onclick="openImageModal('{{ asset('storage/' . $order->decorations['photo_pelaminan']) }}', 'Model Pelaminan')">
                                        <img src="{{ asset('storage/' . $order->decorations['photo_pelaminan']) }}"
                                            alt="Model Pelaminan" class="w-full h-48 object-cover">
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1 italic">Klik gambar untuk melihat detail</p>
                                    <p class="text-sm text-gray-600 mt-2">
                                        {{ $order->decorations['kursi_pelaminan'] ?? '-' }}</p>
                                </div>
                            @endif

                            @if (isset($order->decorations['photo_kain_tenda']) && is_string($order->decorations['photo_kain_tenda']))
                                <div>
                                    <h3 class="text-sm font-semibold mb-2">Foto Warna Kain Tenda</h3>
                                    <div class="bg-gray-100 rounded-lg overflow-hidden cursor-pointer hover:opacity-90 transition-opacity"
                                        onclick="openImageModal('{{ asset('storage/' . $order->decorations['photo_kain_tenda']) }}', 'Warna Kain Tenda')">
                                        <img src="{{ asset('storage/' . $order->decorations['photo_kain_tenda']) }}"
                                            alt="Kain Tenda" class="w-full h-48 object-cover">
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1 italic">Klik gambar untuk melihat detail</p>
                                </div>
                            @endif

                            @if (isset($order->decorations['foto_gaun_1']) ||
                                    isset($order->decorations['foto_gaun_2']) ||
                                    isset($order->decorations['foto_gaun_3']))
                                <div>
                                    <h3 class="text-sm font-semibold mb-2">Foto Gaun</h3>
                                    <div class="grid grid-cols-3 gap-2">
                                        @for ($i = 1; $i <= 3; $i++)
                                            @if (isset($order->decorations["foto_gaun_{$i}"]) && is_string($order->decorations["foto_gaun_{$i}"]))
                                                <div class="bg-gray-100 rounded-lg overflow-hidden cursor-pointer hover:opacity-90 transition-opacity"
                                                    onclick="openImageModal('{{ asset('storage/' . $order->decorations["foto_gaun_{$i}"]) }}', 'Gaun {{ $i }}')">
                                                    <img src="{{ asset('storage/' . $order->decorations["foto_gaun_{$i}"]) }}"
                                                        alt="Gaun {{ $i }}" class="w-full h-32 object-cover">
                                                </div>
                                            @endif
                                        @endfor
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1 italic">Klik gambar untuk melihat detail</p>
                                </div>
                            @endif

                            @if (isset($order->decorations['kursi_pelaminan']))
                                <div>
                                    <h3 class="text-sm font-semibold mb-2">Kursi Pelaminan</h3>
                                    <p class="text-sm text-gray-700">{{ $order->decorations['kursi_pelaminan'] }}</p>
                                </div>
                            @endif

                            @if (isset($order->decorations['warna_tenda']))
                                <div>
                                    <h3 class="text-sm font-semibold mb-2">Warna Tenda</h3>
                                    <p class="text-sm text-gray-700">{{ $order->decorations['warna_tenda'] }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Catatan -->
                @if ($order->notes)
                    <div class="bg-white border-2 border-[#d4b896] rounded-xl p-6 shadow-lg">
                        <h2 class="text-lg font-bold mb-4 text-black">Catatan</h2>
                        <p class="text-sm text-gray-700 whitespace-pre-wrap">{{ $order->notes }}</p>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Detail Klien & Acara -->
                <div class="bg-white border-2 border-[#d4b896] rounded-xl p-6 shadow-lg">
                    <h2 class="text-lg font-bold mb-4 text-black border-b-2 border-[#d4b896] pb-2">Detail Klien & Acara
                    </h2>

                    <div class="grid grid-cols-2 gap-4">
                        <!-- Kolom Kiri -->
                        <div class="space-y-3">
                            <!-- Order Number -->
                            <div>
                                <h3 class="text-xs font-bold text-gray-500 uppercase mb-1">Order Number</h3>
                                <p class="text-sm font-semibold text-black">{{ $order->order_number }}</p>
                            </div>

                            <!-- Tanggal Order -->
                            <div>
                                <h3 class="text-xs font-bold text-gray-500 uppercase mb-1">Tanggal Order</h3>
                                <p class="text-sm text-black">{{ $order->created_at->format('d F Y') }}</p>
                            </div>

                            <!-- HP Pengantin Wanita -->
                            <div>
                                <h3 class="text-xs font-bold text-gray-500 uppercase mb-1">HP Pengantin Wanita</h3>
                                <a href="https://wa.me/{{ $order->client->bride_phone }}"
                                    class="text-sm text-black hover:text-[#8b7355]">{{ $order->client->bride_name }} -
                                    {{ $order->client->bride_phone }}</a>
                            </div>

                            <!-- HP Pengantin Pria -->
                            <div>
                                <h3 class="text-xs font-bold text-gray-500 uppercase mb-1">HP Pengantin Pria</h3>
                                <a href="https://wa.me/{{ $order->client->groom_phone }}"
                                    class="text-sm text-black hover:text-[#8b7355]">{{ $order->client->groom_name }} -
                                    {{ $order->client->groom_phone }}</a>
                            </div>

                        </div>

                        <!-- Kolom Kanan -->
                        <div class="space-y-3">

                            <!-- Orang Tua Pengantin Wanita -->
                            <div>
                                <h3 class="text-xs font-bold text-gray-500 uppercase mb-1">Orang Tua Pengantin Wanita</h3>
                                <p class="text-sm text-black">{{ $order->client->bride_parents ?? '-' }}</p>
                            </div>

                            <!-- Orang Tua Pengantin Pria -->
                            <div>
                                <h3 class="text-xs font-bold text-gray-500 uppercase mb-1">Orang Tua Pengantin Pria</h3>
                                <p class="text-sm text-black">{{ $order->client->groom_parents ?? '-' }}</p>
                            </div>

                            <!-- Tanggal Akad -->
                            <div>
                                <h3 class="text-xs font-bold text-gray-500 uppercase mb-1">Tanggal Akad</h3>
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-[#d4b896] text-base">event</span>
                                    <span class="text-sm text-black">
                                        {{ $order->client->akad_date ? $order->client->akad_date->format('d F Y') : '-' }}
                                        @if ($order->client->akad_time)
                                            - {{ date('H:i', strtotime($order->client->akad_time)) }}
                                            @if ($order->client->akad_end_time)
                                                s/d {{ date('H:i', strtotime($order->client->akad_end_time)) }}
                                            @endif
                                            WIB
                                        @endif
                                    </span>
                                </div>
                            </div>
                            <!-- Tanggal Resepsi -->
                            <div>
                                <h3 class="text-xs font-bold text-gray-500 uppercase mb-1">Tanggal Resepsi</h3>
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-[#d4b896] text-base">event</span>
                                    <span class="text-sm text-black">
                                        {{ $order->client->reception_date ? $order->client->reception_date->format('d F Y') : '-' }}
                                        @if ($order->client->reception_time)
                                            - {{ date('H:i', strtotime($order->client->reception_time)) }}
                                            @if ($order->client->reception_end_time)
                                                s/d {{ date('H:i', strtotime($order->client->reception_end_time)) }}
                                            @endif
                                            WIB
                                        @endif
                                    </span>
                                </div>
                            </div>

                            <!-- Lokasi Acara -->
                            <div>
                                <h3 class="text-xs font-bold text-gray-500 uppercase mb-1">Lokasi Acara</h3>
                                <p class="text-sm text-black">{{ $order->client->event_location ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status Pembayaran -->
                <div class="bg-white border-2 border-[#d4b896] rounded-xl p-6 shadow-lg">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-bold text-black">Status Pembayaran</h2>
                        <button onclick="openPaymentModal()"
                            class="inline-flex items-center gap-1 px-3 py-1.5 bg-[#d4b896] text-black rounded-lg hover:bg-[#c4a886] transition-colors text-sm font-medium">
                            <span class="material-symbols-outlined text-base">add</span>
                            <span>Tambah Pembayaran</span>
                        </button>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <div
                                class="w-3 h-3 rounded-full {{ $order->payment_status == 'Lunas' ? 'bg-green-500' : 'bg-yellow-500' }}">
                            </div>
                            <span
                                class="text-sm font-semibold {{ $order->payment_status == 'Lunas' ? 'text-green-700' : 'text-yellow-700' }}">
                                {{ $order->payment_status }}
                            </span>
                        </div>

                        <div class="text-sm text-gray-600">
                            Sisa pembayaran: <span
                                class="font-bold text-lg {{ $order->remaining_amount > 0 ? 'text-red-600' : 'text-green-600' }}">Rp
                                {{ number_format($order->remaining_amount, 0, ',', '.') }}</span>
                        </div>

                        <div class="border-t border-gray-200 pt-4 space-y-3">
                            <h3 class="text-sm font-semibold text-gray-700">Riwayat Pembayaran</h3>

                            @php
                                $paymentHistory = $order->payment_history ?? [];
                            @endphp

                            @if (count($paymentHistory) > 0)
                                @foreach ($paymentHistory as $payment)
                                    <div class="border-l-4 border-[#d4b896] pl-4 py-2">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <p class="text-sm font-semibold text-black">
                                                    {{ $payment['dp_number'] ?? 'DP' }}</p>
                                                <p class="text-xs text-gray-500">
                                                    {{ \Carbon\Carbon::parse($payment['paid_at'])->format('d F Y') }}</p>
                                                @if (!empty($payment['notes']))
                                                    <p class="text-xs text-gray-600 mt-1">{{ $payment['notes'] }}</p>
                                                @endif
                                                <p class="text-xs text-gray-500">
                                                    {{ $payment['payment_method'] ?? 'Transfer Bank' }}</p>
                                            </div>
                                            <span class="text-sm font-bold text-black">Rp
                                                {{ number_format($payment['amount'], 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-sm text-gray-500 text-center py-4">Belum ada pembayaran</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Pembayaran -->
    <div id="paymentModal"
        class="hidden fixed inset-0 backdrop-blur-sm bg-white/30 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-xl max-w-md w-full p-6 shadow-2xl">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-black">Tambah Pembayaran <span id="dpNumber"></span></h3>
                <button onclick="closePaymentModal()" class="text-gray-400 hover:text-gray-600">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <form action="{{ route('orders.add-payment', $order) }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Pesanan</label>
                    <div class="text-sm text-gray-600">{{ $order->order_number }}</div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Sisa Pembayaran</label>
                    <div class="text-lg font-bold text-red-600">Rp
                        {{ number_format($order->remaining_amount, 0, ',', '.') }}</div>
                </div>

                <div>
                    <label for="amount" class="block text-sm font-semibold text-gray-700 mb-1">Jumlah Pembayaran</label>
                    <input type="number" id="amount" name="amount"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#d4b896] focus:border-transparent"
                        placeholder="0" min="0" max="{{ $order->remaining_amount }}" required>
                    <p class="text-xs text-gray-500 mt-1">Maksimal: Rp
                        {{ number_format($order->remaining_amount, 0, ',', '.') }}</p>
                </div>

                <div>
                    <label for="payment_method" class="block text-sm font-semibold text-gray-700 mb-1">Metode
                        Pembayaran</label>
                    <select id="payment_method" name="payment_method"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#d4b896] focus:border-transparent"
                        required>
                        <option value="Transfer Bank">Transfer Bank</option>
                        <option value="Cash">Cash</option>
                        <option value="E-Wallet">E-Wallet</option>
                    </select>
                </div>

                <div>
                    <label for="notes" class="block text-sm font-semibold text-gray-700 mb-1">Catatan
                        (Optional)</label>
                    <textarea id="notes" name="notes" rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#d4b896] focus:border-transparent"
                        placeholder="Tambahkan catatan pembayaran..."></textarea>
                </div>

                <input type="hidden" id="dp_number" name="dp_number" value="">

                <div class="flex gap-3 pt-4">
                    <button type="button" onclick="closePaymentModal()"
                        class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 px-4 py-2 bg-[#d4b896] text-black rounded-lg hover:bg-[#c4a886] transition-colors font-medium">
                        Tambah Pembayaran
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Image Zoom Modal -->
    <div id="imageModal"
        class="hidden fixed inset-0 bg-black/80 backdrop-blur-sm z-50 flex items-center justify-center p-4"
        onclick="closeImageModal()">
        <div class="relative max-w-5xl max-h-[90vh] w-full">
            <button onclick="closeImageModal()"
                class="absolute top-4 right-4 p-2 bg-white/10 hover:bg-white/20 rounded-full text-white transition-colors z-10">
                <span class="material-symbols-outlined text-2xl">close</span>
            </button>
            <img id="modalImage" src="" alt="" class="w-full h-full object-contain rounded-lg"
                onclick="event.stopPropagation()">
            <div class="absolute bottom-4 left-1/2 -translate-x-1/2 bg-black/50 text-white px-4 py-2 rounded-full text-sm"
                id="modalImageTitle"></div>
        </div>
    </div>

    <script>
        // Payment Modal Functions
        function openPaymentModal() {
            const paymentHistory = @json($order->payment_history ?? []);
            const nextDpNumber = paymentHistory.length + 1;
            const dpLabel = 'DP' + nextDpNumber;

            document.getElementById('dpNumber').textContent = dpLabel;
            document.getElementById('dp_number').value = dpLabel;
            document.getElementById('paymentModal').classList.remove('hidden');
        }

        function closePaymentModal() {
            document.getElementById('paymentModal').classList.add('hidden');
        }

        // Image Modal Functions
        function openImageModal(src, title) {
            document.getElementById('modalImage').src = src;
            document.getElementById('modalImageTitle').textContent = title;
            document.getElementById('imageModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeImageModal() {
            document.getElementById('imageModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Close payment modal on outside click (only if exists)
        const paymentModal = document.getElementById('paymentModal');
        if (paymentModal) {
            paymentModal.addEventListener('click', function(e) {
                if (e.target === this) {
                    closePaymentModal();
                }
            });
        }

        // Close modals on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closePaymentModal();
                closeImageModal();
            }
        });
    </script>
@endsection

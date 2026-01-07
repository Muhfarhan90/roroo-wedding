@extends('layouts.admin')

@section('title', 'Timeline Acara Orders - ROROO MUA Admin')

@section('content')
    <div class="min-h-screen bg-gray-50 text-black p-4 sm:p-6 md:p-8">
        <!-- Back Button & Header -->
        <div class="mb-6">
            <a href="{{ route('orders.index') }}"
                class="inline-flex items-center gap-2 text-gray-600 hover:text-[#8b6f47] mb-4 transition-colors">
                <span class="material-symbols-outlined">arrow_back</span>
                <span>Kembali ke Daftar Orders</span>
            </a>

            <div class="flex items-center gap-2 sm:gap-3 mb-2">
                <div
                    class="w-10 h-10 sm:w-12 sm:h-12 bg-[#d4b896] rounded-full flex items-center justify-center flex-shrink-0">
                    <span class="material-symbols-outlined text-white text-xl sm:text-2xl">show_chart</span>
                </div>
                <div class="min-w-0">
                    <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-black">Timeline Acara Orders</h1>
                    <p class="text-xs sm:text-sm text-gray-600">Orders diurutkan berdasarkan tanggal acara terdekat
                        ({{ $upcomingEventsCount }} hari dengan acara)</p>
                </div>
            </div>
        </div>

        <!-- Date Navigation -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-3 sm:p-6 mb-4">
            <div class="flex items-center justify-between mb-4 gap-2">
                @if ($previousDate)
                    <a href="{{ route('orders.timeline', ['date' => $previousDate]) }}"
                        class="flex items-center gap-1 text-gray-600 hover:text-[#8b6f47] transition-colors text-xs sm:text-base">
                        <span class="material-symbols-outlined text-lg sm:text-2xl">chevron_left</span>
                        <span class="hidden sm:inline">Sebelumnya</span>
                    </a>
                @else
                    <div class="flex items-center gap-1 text-gray-300 cursor-not-allowed text-xs sm:text-base">
                        <span class="material-symbols-outlined text-lg sm:text-2xl">chevron_left</span>
                        <span class="hidden sm:inline">Sebelumnya</span>
                    </div>
                @endif

                <div class="text-center flex-1 min-w-0">
                    <div class="flex items-center gap-1 sm:gap-2 justify-center">
                        <span class="material-symbols-outlined text-[#8b6f47] text-lg sm:text-2xl">calendar_today</span>
                        <span class="text-sm sm:text-xl font-bold">{{ $date->format('d F Y') }}</span>
                        @if ($date->isToday())
                            <span
                                class="px-2 sm:px-3 py-0.5 sm:py-1 bg-green-100 text-green-700 text-[10px] sm:text-xs font-semibold rounded-full whitespace-nowrap">Hari
                                Ini</span>
                        @endif
                    </div>
                    <p class="text-xs sm:text-sm text-gray-600 mt-1">{{ $date->isoFormat('dddd') }} • {{ $orders->count() }}
                        acara</p>
                </div>

                @if ($nextDate)
                    <a href="{{ route('orders.timeline', ['date' => $nextDate]) }}"
                        class="flex items-center gap-1 text-gray-600 hover:text-[#8b6f47] transition-colors text-xs sm:text-base">
                        <span class="hidden sm:inline">Selanjutnya</span>
                        <span class="material-symbols-outlined text-lg sm:text-2xl">chevron_right</span>
                    </a>
                @else
                    <div class="flex items-center gap-1 text-gray-300 cursor-not-allowed text-xs sm:text-base">
                        <span class="hidden sm:inline">Selanjutnya</span>
                        <span class="material-symbols-outlined text-lg sm:text-2xl">chevron_right</span>
                    </div>
                @endif
            </div>

            <!-- Timeline Dots -->
            <div class="relative mt-6 pb-2 overflow-visible">
                @if (count($datesWithEvents) > 0)
                    <div class="flex items-center justify-center space-x-2 px-4">
                        @foreach ($datesWithEvents as $dateInfo)
                            <div class="relative group flex-shrink-0">
                                <a href="{{ route('orders.timeline', ['date' => $dateInfo['date']]) }}" class="block">
                                    <div
                                        class="w-3 h-3 rounded-full transition-all
                                        @if ($dateInfo['isSelected']) bg-[#8b6f47] ring-4 ring-[#8b6f47]/20
                                        @else bg-[#d4b896] hover:bg-[#8b6f47] @endif">
                                    </div>
                                </a>

                                <div
                                    class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200
                                           bg-gray-900 text-white text-xs font-medium px-3 py-2 rounded-md shadow-xl whitespace-nowrap pointer-events-none">
                                    {{ \Carbon\Carbon::parse($dateInfo['date'])->format('d M') }} ({{ $dateInfo['count'] }})
                                    <div
                                        class="absolute top-full left-1/2 -translate-x-1/2 -mt-1 border-4 border-transparent border-t-gray-900">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="absolute top-1/2 left-0 right-0 h-0.5 bg-gray-300 -z-10 mt-4"></div>
                @else
                    <div class="text-center text-gray-500 py-4">
                        <p class="text-sm">Tidak ada acara dalam rentang waktu ini</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Orders List -->
        @if ($orders->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                @foreach ($orders as $index => $order)
                    <div
                        class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
                        <!-- Card Header -->
                        <div class="bg-gradient-to-r from-[#f5f1ec] to-white p-4 border-b border-gray-200">
                            <div class="flex items-start justify-between">
                                <div class="flex items-start gap-3">
                                    <div
                                        class="w-10 h-10 bg-[#d4b896] rounded-full flex items-center justify-center text-white font-bold">
                                        {{ $index + 1 }}
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-bold text-black">Order #{{ $order->order_number }}</h3>
                                        <p class="text-sm text-gray-600">{{ $order->client->client_name }}</p>
                                    </div>
                                </div>
                                <a href="{{ route('orders.show', $order) }}"
                                    class="flex items-center gap-1 text-sm text-[#8b6f47] hover:text-[#d4b896] transition-colors">
                                    <span class="material-symbols-outlined text-lg">visibility</span>
                                    <span>Detail</span>
                                </a>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="p-4">
                            <!-- Event Time -->
                            <div class="flex items-center gap-2 mb-4 pb-4 border-b border-gray-100">
                                <span class="material-symbols-outlined text-pink-500">favorite</span>
                                <div>
                                    <p class="text-xs text-gray-500 font-semibold">Akad Nikah</p>
                                    <p class="text-sm font-bold text-[#8b6f47]">
                                        {{ $order->client->akad_time ? \Carbon\Carbon::parse($order->client->akad_time)->format('H:i') : '00:00' }}
                                        WIB
                                    </p>
                                </div>
                                <span
                                    class="px-3 py-1 text-xs font-semibold rounded-full ml-auto
                                    @if ($order->payment_status === 'lunas') bg-green-100 text-green-700
                                    @else bg-yellow-100 text-yellow-700 @endif">
                                    {{ $order->payment_status === 'lunas' ? 'Lunas' : 'Belum Lunas' }}
                                </span>
                            </div>

                            <!-- Client Details -->
                            <div class="space-y-3">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-gray-400 text-lg">groups</span>
                                    <h4 class="font-semibold text-sm">Detail Klien & Acara</h4>
                                </div>

                                <!-- Contact Person -->
                                <div>
                                    <p class="text-xs text-gray-500 mb-2">Kontak Person</p>

                                    <!-- Bride Contact -->
                                    <div class="mb-2">
                                        <p class="text-xs text-gray-600 mb-1">HP Pengantin Wanita -
                                            HP Mempelai Wanita</p>
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->client->bride_phone) }}"
                                            target="_blank"
                                            class="inline-flex items-center gap-2 px-3 py-2 bg-green-50 text-green-700 rounded-lg text-sm hover:bg-green-100 transition-colors">
                                            <span class="material-symbols-outlined text-lg">chat</span>
                                            <span class="font-medium">{{ $order->client->bride_phone }}</span>
                                            <span class="text-xs">WhatsApp</span>
                                        </a>
                                    </div>

                                    <!-- Groom Contact -->
                                    <div>
                                        <p class="text-xs text-gray-600 mb-1">HP Pengantin Pria -
                                            {{ $order->client->groom_name }}</p>
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->client->groom_phone) }}"
                                            target="_blank"
                                            class="inline-flex items-center gap-2 px-3 py-2 bg-green-50 text-green-700 rounded-lg text-sm hover:bg-green-100 transition-colors">
                                            <span class="material-symbols-outlined text-lg">chat</span>
                                            <span class="font-medium">{{ $order->client->groom_phone }}</span>
                                            <span class="text-xs">WhatsApp</span>
                                        </a>
                                    </div>
                                </div>

                                <!-- Names & Addresses -->
                                <div class="grid grid-cols-2 gap-4 pt-3 border-t border-gray-100">
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Nama Pengantin Wanita</p>
                                        <p class="text-sm font-semibold">HP Mempelai Wanita</p>
                                        @if ($order->client->bride_address)
                                            <p class="text-xs text-gray-600 mt-1">Alamat Pengantin Wanita</p>
                                            <p class="text-xs text-gray-700">{{ $order->client->bride_address }}</p>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Nama Pengantin Pria</p>
                                        <p class="text-sm font-semibold">HP Mempelai Pria</p>
                                        @if ($order->client->groom_address)
                                            <p class="text-xs text-gray-600 mt-1">Alamat Pengantin Pria</p>
                                            <p class="text-xs text-gray-700">{{ $order->client->groom_address }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- View Full Details Button -->
                            <button onclick="openDetailModal{{ $index }}()"
                                class="w-full mt-4 px-4 py-2 bg-[#d4b896] text-black rounded-lg hover:bg-[#c4a886] transition-colors font-medium text-sm">
                                Lihat Detail Lengkap (Items, Kustom, Pembayaran)
                            </button>
                        </div>
                    </div>

                    <!-- Detail Modal -->
                    <div id="detailModal{{ $index }}"
                        class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 overflow-y-auto">
                        <div class="min-h-screen px-4 py-8 flex items-center justify-center">
                            <div class="bg-white rounded-xl shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto"
                                onclick="event.stopPropagation()">
                                <!-- Modal Header -->
                                <div
                                    class="sticky top-0 bg-white border-b border-gray-200 p-6 flex items-center justify-between z-10">
                                    <h3 class="text-xl font-bold">Order #{{ $order->order_number }}</h3>
                                    <button onclick="closeDetailModal{{ $index }}()"
                                        class="p-2 hover:bg-gray-100 rounded-full transition-colors">
                                        <span class="material-symbols-outlined">close</span>
                                    </button>
                                </div>

                                <!-- Modal Body -->
                                <div class="p-6 space-y-6">
                                    <!-- Client Info -->
                                    <div>
                                        <h4 class="font-semibold text-sm mb-3 flex items-center gap-2">
                                            <span class="material-symbols-outlined text-[#8b6f47]">groups</span>
                                            Detail Klien & Acara
                                        </h4>
                                        <div class="bg-gray-50 rounded-lg p-4 space-y-2">
                                            <p class="text-sm"><span class="font-semibold">Pengantin:</span>
                                                {{ $order->client->client_name }}</p>
                                            <p class="text-sm"><span class="font-semibold">Lokasi:</span>
                                                {{ $order->client->event_location ?? 'Tidak ada' }}</p>
                                            <p class="text-sm"><span class="font-semibold">Tanggal Akad:</span>
                                                {{ $order->client->akad_date ? \Carbon\Carbon::parse($order->client->akad_date)->format('d F Y') : '-' }}
                                            </p>
                                            <p class="text-sm"><span class="font-semibold">Tanggal Resepsi:</span>
                                                {{ $order->client->reception_date ? \Carbon\Carbon::parse($order->client->reception_date)->format('d F Y') : '-' }}
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Items -->
                                    @if ($order->items && count($order->items) > 0)
                                        <div>
                                            <h4 class="font-semibold text-sm mb-3 flex items-center gap-2">
                                                <span class="material-symbols-outlined text-[#8b6f47]">inventory_2</span>
                                                Item Pesanan
                                            </h4>
                                            <div class="space-y-2">
                                                @foreach ($order->items as $item)
                                                    <div
                                                        class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                                        <div class="flex-1">
                                                            <p class="text-sm font-medium">{{ $item['name'] ?? 'Item' }}
                                                            </p>
                                                            <p class="text-xs text-gray-500">Qty:
                                                                {{ $item['quantity'] ?? 1 }}</p>
                                                        </div>
                                                        <p class="text-sm font-bold">Rp
                                                            {{ number_format($item['price'] ?? 0, 0, ',', '.') }}</p>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Custom Decorations -->
                                    @if ($order->decorations)
                                        <div>
                                            <h4 class="font-semibold text-sm mb-3 flex items-center gap-2">
                                                <span class="material-symbols-outlined text-[#8b6f47]">palette</span>
                                                Pilihan Kustom
                                            </h4>
                                            <div class="space-y-3">
                                                @if (isset($order->decorations['photo_pelaminan']) && is_string($order->decorations['photo_pelaminan']))
                                                    <div>
                                                        <p class="text-xs text-gray-500 mb-1">Foto Model Pelaminan</p>
                                                        <img src="{{ asset('storage/' . $order->decorations['photo_pelaminan']) }}"
                                                            alt="Pelaminan" class="w-full h-32 object-cover rounded-lg">
                                                        @if (isset($order->decorations['kursi_pelaminan']))
                                                            <p class="text-xs text-gray-600 mt-1">
                                                                {{ $order->decorations['kursi_pelaminan'] }}</p>
                                                        @endif
                                                    </div>
                                                @endif

                                                @if (isset($order->decorations['photo_kain_tenda']) && is_string($order->decorations['photo_kain_tenda']))
                                                    <div>
                                                        <p class="text-xs text-gray-500 mb-1">Foto Warna Kain Tenda</p>
                                                        <img src="{{ asset('storage/' . $order->decorations['photo_kain_tenda']) }}"
                                                            alt="Kain Tenda" class="w-full h-32 object-cover rounded-lg">
                                                    </div>
                                                @endif

                                                @if (isset($order->decorations['foto_gaun_1']) ||
                                                        isset($order->decorations['foto_gaun_2']) ||
                                                        isset($order->decorations['foto_gaun_3']))
                                                    <div>
                                                        <p class="text-xs text-gray-500 mb-1">Foto Gaun</p>
                                                        <div class="grid grid-cols-3 gap-2">
                                                            @for ($i = 1; $i <= 3; $i++)
                                                                @if (isset($order->decorations["foto_gaun_{$i}"]) && is_string($order->decorations["foto_gaun_{$i}"]))
                                                                    <img src="{{ asset('storage/' . $order->decorations["foto_gaun_{$i}"]) }}"
                                                                        alt="Gaun {{ $i }}"
                                                                        class="w-full h-24 object-cover rounded-lg">
                                                                @endif
                                                            @endfor
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Notes -->
                                    @if ($order->notes)
                                        <div>
                                            <h4 class="font-semibold text-sm mb-2 flex items-center gap-2">
                                                <span class="material-symbols-outlined text-[#8b6f47]">description</span>
                                                Catatan
                                            </h4>
                                            <p class="text-sm text-gray-700 bg-yellow-50 p-3 rounded-lg">
                                                {{ $order->notes }}</p>
                                        </div>
                                    @endif

                                    <!-- Total -->
                                    <div class="border-t pt-4">
                                        <div class="flex items-center justify-between text-lg font-bold">
                                            <span>Total</span>
                                            <span class="text-[#8b6f47]">Rp
                                                {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                                        </div>
                                    </div>

                                    <!-- Payment Status -->
                                    <div>
                                        <h4 class="font-semibold text-sm mb-3 flex items-center gap-2">
                                            <span class="material-symbols-outlined text-[#8b6f47]">
                                                {{ $order->payment_status === 'lunas' ? 'check_circle' : 'schedule' }}
                                            </span>
                                            Status:
                                            <span
                                                class="px-3 py-1 text-xs font-semibold rounded-full
                                                @if ($order->payment_status === 'lunas') bg-green-100 text-green-700
                                                @else bg-yellow-100 text-yellow-700 @endif">
                                                {{ $order->payment_status === 'lunas' ? 'Lunas' : 'Belum Lunas' }}
                                            </span>
                                        </h4>

                                        @if ($order->payment_history && count($order->payment_history) > 0)
                                            <div class="space-y-2">
                                                <p class="text-xs text-gray-500 font-semibold mb-2">Riwayat Pembayaran:</p>
                                                @php
                                                    $totalPaid = 0;
                                                @endphp
                                                @foreach ($order->payment_history as $payment)
                                                    @php
                                                        $totalPaid += floatval($payment['amount'] ?? 0);
                                                    @endphp
                                                    <div
                                                        class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                                                        <div>
                                                            <p class="text-sm font-medium">
                                                                {{ $payment['dp_number'] ?? 'DP' }}</p>
                                                            <p class="text-xs text-gray-500">
                                                                {{ isset($payment['paid_at']) ? \Carbon\Carbon::parse($payment['paid_at'])->format('d M Y') : '-' }}
                                                            </p>
                                                            @if (isset($payment['payment_method']))
                                                                <p class="text-xs text-gray-600">
                                                                    {{ $payment['payment_method'] }}</p>
                                                            @endif
                                                        </div>
                                                        <p class="text-sm font-bold text-green-700">Rp
                                                            {{ number_format($payment['amount'] ?? 0, 0, ',', '.') }}</p>
                                                    </div>
                                                @endforeach

                                                <!-- Summary -->
                                                <div class="mt-4 p-4 bg-gray-50 rounded-lg space-y-2">
                                                    <div class="flex justify-between text-sm">
                                                        <span class="text-gray-600">Total Dibayar:</span>
                                                        <span class="font-bold text-green-700">Rp
                                                            {{ number_format($totalPaid, 0, ',', '.') }}</span>
                                                    </div>
                                                    @if ($order->payment_status !== 'lunas')
                                                        <div class="flex justify-between text-sm">
                                                            <span class="text-gray-600">Sisa:</span>
                                                            <span class="font-bold text-red-700">Rp
                                                                {{ number_format($order->remaining_amount, 0, ',', '.') }}</span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                        function openDetailModal{{ $index }}() {
                            document.getElementById('detailModal{{ $index }}').classList.remove('hidden');
                            document.body.style.overflow = 'hidden';
                        }

                        function closeDetailModal{{ $index }}() {
                            document.getElementById('detailModal{{ $index }}').classList.add('hidden');
                            document.body.style.overflow = 'auto';
                        }

                        document.getElementById('detailModal{{ $index }}').addEventListener('click', function(e) {
                            if (e.target === this) {
                                closeDetailModal{{ $index }}();
                            }
                        });
                    </script>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                <span class="material-symbols-outlined text-6xl text-gray-300 mb-4">event_busy</span>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">Tidak Ada Acara</h3>
                <p class="text-gray-500">Tidak ada acara yang dijadwalkan pada tanggal ini.</p>
            </div>
        @endif
    </div>
@endsection

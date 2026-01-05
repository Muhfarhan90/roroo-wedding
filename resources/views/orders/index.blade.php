@extends('layouts.admin')

@section('title', 'Daftar Pesanan & Manajemen - ROROO MUA Admin')

@section('content')
    <div class="min-h-screen bg-gray-50 text-black p-4 sm:p-6 md:p-8">
        <!-- Page Header -->
        <div class="mb-6 md:mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold mb-2 text-black">Daftar Pesanan & Manajemen</h1>
                    <p class="text-sm md:text-base text-gray-600">Kelola semua pesanan klien, lacak pembayaran, dan lihat
                        detail.</p>
                </div>
                <div class="flex gap-2 sm:gap-3">
                    <a href="{{ route('orders.create') }}"
                        class="inline-flex items-center justify-center gap-1 sm:gap-2 px-3 py-2 sm:px-6 sm:py-3 bg-[#d4b896] text-black rounded-lg hover:bg-[#c4a886] transition-colors font-medium shadow-sm text-sm sm:text-base">
                        <span class="material-symbols-outlined text-lg sm:text-2xl">add</span>
                        <span class="hidden sm:inline">Buat Pesanan Baru</span>
                        <span class="sm:hidden">Buat Order</span>
                    </a>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="mb-4 sm:mb-6 p-3 sm:p-4 bg-green-50 border-l-4 border-green-500 text-green-800 rounded-lg">
                <div class="flex items-center gap-2 sm:gap-3">
                    <span class="material-symbols-outlined text-lg sm:text-2xl">check_circle</span>
                    <span class="text-sm sm:text-base">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 sm:mb-6 p-3 sm:p-4 bg-red-50 border-l-4 border-red-500 text-red-800 rounded-lg">
                <div class="flex items-center gap-2 sm:gap-3">
                    <span class="material-symbols-outlined text-lg sm:text-2xl">error</span>
                    <span class="text-sm sm:text-base">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <!-- Search and Filter Section -->
        <div class="bg-white border-2 border-[#d4b896] rounded-xl p-3 sm:p-6 mb-4 sm:mb-6 shadow-lg relative z-10">
            <form method="GET" action="{{ route('orders.index') }}" id="filterForm">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-2">
                    <!-- Search Box - Full width on mobile, 5 columns on desktop -->
                    <div class="relative lg:col-span-5">
                        <span
                            class="material-symbols-outlined absolute left-3 sm:left-4 top-1/2 -translate-y-1/2 text-gray-400 text-lg sm:text-2xl pointer-events-none">search</span>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari pesanan..."
                            class="w-full pl-9 sm:pl-12 pr-3 sm:pr-4 py-2 sm:py-3 text-sm sm:text-base border-2 border-gray-200 rounded-lg focus:border-[#d4b896] focus:outline-none transition-colors">
                    </div>

                    <!-- Filter, Sort, Per Page - 3 columns on mobile, spans 7 columns on desktop -->
                    <div class="grid grid-cols-3 gap-2 lg:col-span-7 lg:grid-cols-7">
                        <!-- Filter Button -->
                        <button type="button" onclick="toggleFilter()"
                            class="lg:col-span-2 flex items-center justify-center gap-1 px-2 sm:px-4 py-2 sm:py-3 border-2 border-gray-200 rounded-lg hover:border-[#d4b896] transition-colors bg-white relative z-20">
                            <span class="material-symbols-outlined text-lg sm:text-2xl">tune</span>
                            <span class="font-medium text-xs sm:text-base hidden sm:inline">Filter</span>
                        </button>

                        <!-- Sort Dropdown -->
                        <div
                            class="lg:col-span-3 flex items-center gap-1 px-2 sm:px-4 py-2 sm:py-3 border-2 border-gray-200 rounded-lg">
                            <span class="material-symbols-outlined text-lg sm:text-2xl">swap_vert</span>
                            <select name="sort"
                                class="font-medium text-xs sm:text-base border-none focus:outline-none bg-transparent cursor-pointer w-full"
                                onchange="this.form.submit()">
                                <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Urutkan
                                </option>
                                <option value="bride_name" {{ request('sort') == 'bride_name' ? 'selected' : '' }}>Nama
                                </option>
                                <option value="akad_date" {{ request('sort') == 'akad_date' ? 'selected' : '' }}>Akad
                                </option>
                                <option value="reception_date" {{ request('sort') == 'reception_date' ? 'selected' : '' }}>
                                    Resepsi</option>
                            </select>
                        </div>

                        <!-- Per Page -->
                        <select name="per_page"
                            class="lg:col-span-2 px-2 sm:px-4 py-2 sm:py-3 text-xs sm:text-base border-2 border-gray-200 rounded-lg focus:border-[#d4b896] focus:outline-none cursor-pointer"
                            onchange="this.form.submit()">
                            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10/hal</option>
                            <option value="25" {{ request('per_page', 25) == 25 ? 'selected' : '' }}>25/hal</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50/hal</option>
                            <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100/hal</option>
                        </select>
                    </div>
                </div>

                <!-- Advanced Filter (Hidden by default) -->
                <div id="advancedFilter" class="hidden mt-3 sm:mt-4 pt-3 sm:pt-4 border-t border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 sm:gap-4">
                        <div>
                            <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1 sm:mb-2">Tanggal
                                Mulai</label>
                            <input type="date" name="start_date" value="{{ request('start_date') }}"
                                class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border-2 border-gray-200 rounded-lg focus:border-[#d4b896] focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1 sm:mb-2">Tanggal
                                Akhir</label>
                            <input type="date" name="end_date" value="{{ request('end_date') }}"
                                class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border-2 border-gray-200 rounded-lg focus:border-[#d4b896] focus:outline-none">
                        </div>
                        <div class="flex items-end gap-2">
                            <button type="submit"
                                class="flex-1 px-3 sm:px-4 py-2 text-sm sm:text-base bg-[#d4b896] text-black rounded-lg hover:bg-[#c4a886] transition-colors font-medium">
                                Terapkan
                            </button>
                            <a href="{{ route('orders.index') }}"
                                class="px-3 sm:px-4 py-2 text-sm sm:text-base border-2 border-gray-200 rounded-lg hover:border-[#d4b896] transition-colors">
                                Reset
                            </a>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Export PDF Button -->
            <div class="mt-3 sm:mt-4 pt-3 sm:pt-4 border-t border-gray-200">
                <button onclick="exportPDF()"
                    class="inline-flex items-center gap-1 sm:gap-2 px-3 sm:px-4 py-2 text-sm sm:text-base bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                    <span class="material-symbols-outlined text-lg sm:text-2xl">picture_as_pdf</span>
                    <span>Export PDF</span>
                </button>
            </div>
        </div>

        <script>
            function toggleFilter() {
                const filter = document.getElementById('advancedFilter');
                filter.classList.toggle('hidden');
            }

            function exportPDF() {
                const form = document.getElementById('filterForm');
                const formData = new FormData(form);
                const params = new URLSearchParams(formData).toString();
                window.open('{{ route('orders.index') }}?export=pdf&' + params, '_blank');
            }
        </script>

        <!-- Table -->
        <div class="bg-white border-2 border-[#d4b896] rounded-xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b-2 border-[#d4b896]">
                        <tr>
                            <th
                                class="px-2 sm:px-6 py-2 sm:py-4 text-center text-[10px] sm:text-xs font-semibold text-[#d4b896] uppercase tracking-wider">
                                No</th>
                            <th
                                class="px-2 sm:px-6 py-2 sm:py-4 text-center text-[10px] sm:text-xs font-semibold text-[#d4b896] uppercase tracking-wider">
                                Kode</th>
                            <th
                                class="px-2 sm:px-6 py-2 sm:py-4 text-left text-[10px] sm:text-xs font-semibold text-[#d4b896] uppercase tracking-wider">
                                Mempelai</th>
                            <th
                                class="px-2 sm:px-6 py-2 sm:py-4 text-left text-[10px] sm:text-xs font-semibold text-[#d4b896] uppercase tracking-wider">
                                Akad</th>
                            <th
                                class="px-2 sm:px-6 py-2 sm:py-4 text-left text-[10px] sm:text-xs font-semibold text-[#d4b896] uppercase tracking-wider">
                                Resepsi</th>
                            <th
                                class="px-2 sm:px-6 py-2 sm:py-4 text-left text-[10px] sm:text-xs font-semibold text-[#d4b896] uppercase tracking-wider">
                                Total</th>
                            <th
                                class="px-2 sm:px-6 py-2 sm:py-4 text-left text-[10px] sm:text-xs font-semibold text-[#d4b896] uppercase tracking-wider">
                                Sisa</th>
                            <th
                                class="px-2 sm:px-6 py-2 sm:py-4 text-center text-[10px] sm:text-xs font-semibold text-[#d4b896] uppercase tracking-wider">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($orders as $order)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-2 sm:px-6 py-2 sm:py-4 text-center">
                                    <div class="text-xs sm:text-sm text-black">
                                        {{ $loop->iteration + ($orders->currentPage() - 1) * $orders->perPage() }}</div>
                                </td>
                                <td class="px-2 sm:px-6 py-2 sm:py-4">
                                    <div class="text-xs sm:text-sm font-medium text-black">{{ $order->order_number }}</div>
                                </td>
                                <td class="px-2 sm:px-6 py-2 sm:py-4">
                                    <div class="text-xs sm:text-sm font-medium text-black">{{ $order->client->bride_name }}
                                        &
                                        {{ $order->client->groom_name }}</div>
                                </td>
                                <td class="px-2 sm:px-6 py-2 sm:py-4">
                                    <div class="text-xs sm:text-sm text-black">
                                        {{ $order->client->akad_date ? $order->client->akad_date->format('M d, Y') : '-' }}
                                    </div>
                                </td>
                                <td class="px-2 sm:px-6 py-2 sm:py-4">
                                    <div class="text-xs sm:text-sm text-black">
                                        {{ $order->client->reception_date ? $order->client->reception_date->format('M d, Y') : '-' }}
                                    </div>
                                </td>
                                <td class="px-2 sm:px-6 py-2 sm:py-4">
                                    @php
                                        $paymentHistory = $order->payment_history ?? [];
                                        $totalPaid = is_array($paymentHistory)
                                            ? array_sum(array_column($paymentHistory, 'amount'))
                                            : 0;
                                    @endphp
                                    <div class="text-xs sm:text-sm text-black font-medium">
                                        Rp {{ number_format($totalPaid, 0, ',', '.') }}
                                    </div>
                                </td>
                                <td class="px-2 sm:px-6 py-2 sm:py-4">
                                    <div
                                        class="text-xs sm:text-sm font-semibold {{ $order->remaining_amount > 0 ? 'text-red-600' : 'text-green-600' }}">
                                        Rp {{ number_format($order->remaining_amount, 0, ',', '.') }}
                                    </div>
                                </td>
                                <td class="px-2 sm:px-6 py-2 sm:py-4">
                                    <div class="flex items-center justify-center gap-1 sm:gap-2">
                                        <a href="{{ route('orders.show', $order) }}"
                                            class="p-1 sm:p-2 text-gray-600 hover:text-[#d4b896] transition-colors"
                                            title="View">
                                            <span
                                                class="material-symbols-outlined text-lg sm:text-2xl\">visibility</span>
                                        </a>
                                        <a href="{{ route('orders.edit', $order) }}"
                                                class="p-1 sm:p-2 text-gray-600 hover:text-[#d4b896] transition-colors"
                                                title="Edit">
                                                <span
                                                    class="material-symbols-outlined text-lg sm:text-2xl\">edit</span>
                                        </a>
                                        <form action="{{ route('orders.destroy', $order) }}\"
                                                    method=\"POST\" class=\"inline\"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesanan ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="p-1 sm:p-2 text-gray-600 hover:text-red-600 transition-colors"
                                                        title="Hapus">
                                                        <span
                                                            class="material-symbols-outlined text-lg sm:text-2xl">delete</span>
                                                    </button>
                                                    </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-3 sm:px-6 py-8 sm:py-12 text-center">
                                    <div class="flex flex-col items-center gap-2 sm:gap-3">
                                        <span
                                            class="material-symbols-outlined text-4xl sm:text-6xl text-gray-300">receipt_long</span>
                                        <p class="text-sm sm:text-base text-gray-500">Tidak ada pesanan ditemukan</p>
                                        <a href="{{ route('orders.create') }}"
                                            class="inline-flex items-center gap-1 sm:gap-2 px-3 sm:px-4 py-2 text-sm sm:text-base bg-[#d4b896] text-black rounded-lg hover:bg-[#c4a886] transition-colors">
                                            <span class="material-symbols-outlined text-base sm:text-lg">add</span>
                                            <span>Buat Pesanan</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($orders->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

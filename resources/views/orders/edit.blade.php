@extends('layouts.admin')

@section('title', 'Ubah Pesanan #' . $order->order_number . ' - ROROO MUA Admin')

@section('content')
    <div class="min-h-screen bg-gray-50 text-black p-4 sm:p-6 md:p-8">
        <!-- Page Header -->
        <div class="mb-6">
            <a href="{{ route('orders.index') }}"
                class="text-sm text-gray-600 hover:text-[#d4b896] flex items-center gap-1 mb-2">
                <span class="material-symbols-outlined text-base">arrow_back</span>
                Back to Orders
            </a>
            <h1 class="text-2xl md:text-3xl font-bold mb-2 text-black">Ubah Pesanan #{{ $order->order_number }}</h1>
            <p class="text-sm md:text-base text-gray-600">Edit informasi pesanan untuk klien.</p>
        </div>

        <form action="{{ route('orders.update', $order) }}" method="POST" enctype="multipart/form-data" id="orderForm">
            @csrf
            @method('PUT')

            <!-- Informasi Klien -->
            <div class="bg-white border-2 border-[#d4b896] rounded-xl p-6 mb-6 shadow-lg">
                <h2 class="text-lg font-bold mb-4 text-black">Informasi Klien</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium mb-2 text-black">Pilih Klien <span
                                class="text-red-600">*</span></label>
                        <select name="client_id" id="client_id" required
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-[#d4b896] focus:outline-none">
                            <option value="">Pilih klien yang sudah ada atau tambahkan yang baru</option>
                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}" data-location="{{ $client->event_location }}"
                                    {{ $order->client_id == $client->id ? 'selected' : '' }}>
                                    {{ $client->client_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('client_id')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Item & Layanan yang Dipesan -->
            <div class="bg-white border-2 border-[#d4b896] rounded-xl p-6 mb-6 shadow-lg">
                <h2 class="text-lg font-bold mb-4 text-black">Item & Layanan yang Dipesan</h2>

                <!-- Desktop Table View -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full" id="itemsTable">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Item</th>
                                <th class="px-4 py-3 text-center text-sm font-semibold text-gray-600" style="width: 80px;">
                                    Jml</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600" style="width: 150px;">
                                    Harga</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600" style="width: 150px;">
                                    Total</th>
                                <th class="px-4 py-3 text-center text-sm font-semibold text-gray-600" style="width: 80px;">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="itemsBody">
                            <!-- Items will be loaded from existing data -->
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Card View -->
                <div class="md:hidden space-y-3" id="itemsBodyMobile">
                    <!-- Items will be added here dynamically as cards -->
                </div>

                <button type="button" onclick="addItemRow()"
                    class="mt-4 text-[#d4b896] hover:text-[#c4a886] text-sm flex items-center gap-2">
                    <span class="material-symbols-outlined text-base">add_circle</span>
                    <span>Tambah Item</span>
                </button>

                <!-- Total Section -->
                <div class="mt-6 border-t-2 border-gray-200 pt-4">
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-lg font-bold text-black">Total</span>
                        <span class="text-2xl font-bold text-black" id="grandTotal">Rp0</span>
                    </div>
                </div>

                <input type="hidden" name="items" id="itemsData">
                <input type="hidden" name="total_amount" id="total_amount">
            </div>

            <!-- Detail Dekorasi Pernikahan -->
            <div class="bg-white border-2 border-[#d4b896] rounded-xl p-6 mb-6 shadow-lg">
                <h2 class="text-lg font-bold mb-4 text-black">Detail Dekorasi Pernikahan</h2>

                <div class="space-y-6">
                    <!-- Foto Model Pelaminan -->
                    <div>
                        <label class="block text-sm font-medium mb-2 text-black">Foto Model Pelaminan (Optional)</label>
                        @if (isset($order->decorations['photo_pelaminan']) && $order->decorations['photo_pelaminan'])
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $order->decorations['photo_pelaminan']) }}"
                                    alt="Foto Pelaminan"
                                    class="w-full max-w-xs h-48 object-cover rounded-lg border-2 border-gray-200"
                                    id="pelaminan_preview">
                                <p class="text-xs text-gray-500 mt-1">Foto yang sudah ada (upload foto baru untuk
                                    menggantinya)</p>
                            </div>
                        @else
                            <div id="pelaminan_preview_container" class="mb-3 hidden">
                                <img src="" alt="Preview" id="pelaminan_preview"
                                    class="w-full max-w-xs h-48 object-cover rounded-lg border-2 border-gray-200">
                            </div>
                        @endif
                        <div class="flex items-center gap-3">
                            <button type="button" onclick="document.getElementById('photo_pelaminan').click()"
                                class="px-4 py-2 bg-[#d4b896] text-black rounded-lg hover:bg-[#c4a886] transition-colors text-sm">
                                Choose File
                            </button>
                            <span id="pelaminan_filename"
                                class="text-sm text-gray-500">{{ isset($order->decorations['photo_pelaminan']) && $order->decorations['photo_pelaminan'] ? 'File sudah ada' : 'No file chosen' }}</span>
                        </div>
                        <input type="file" id="photo_pelaminan" name="decorations[photo_pelaminan]" class="hidden"
                            accept="image/*" onchange="updateFileName(this, 'pelaminan_filename', 'pelaminan_preview')">
                    </div>

                    <!-- Kursi Pelaminan -->
                    <div>
                        <label class="block text-sm font-medium mb-2 text-black">Kursi Pelaminan (Optional)</label>
                        <input type="text" name="decorations[kursi_pelaminan]"
                            value="{{ old('decorations.kursi_pelaminan', $order->decorations['kursi_pelaminan'] ?? '') }}"
                            placeholder="cth: Sofa, Kursi tungggal"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-[#d4b896] focus:outline-none">
                    </div>

                    <!-- Foto Warna Kain Tenda -->
                    <div>
                        <label class="block text-sm font-medium mb-2 text-black">Foto Warna Kain Tenda (Optional)</label>
                        @if (isset($order->decorations['photo_kain_tenda']) && $order->decorations['photo_kain_tenda'])
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $order->decorations['photo_kain_tenda']) }}"
                                    alt="Foto Kain Tenda"
                                    class="w-full max-w-xs h-48 object-cover rounded-lg border-2 border-gray-200"
                                    id="kain_preview">
                                <p class="text-xs text-gray-500 mt-1">Foto yang sudah ada (upload foto baru untuk
                                    menggantinya)</p>
                            </div>
                        @else
                            <div id="kain_preview_container" class="mb-3 hidden">
                                <img src="" alt="Preview" id="kain_preview"
                                    class="w-full max-w-xs h-48 object-cover rounded-lg border-2 border-gray-200">
                            </div>
                        @endif
                        <div class="flex items-center gap-3">
                            <button type="button" onclick="document.getElementById('photo_kain_tenda').click()"
                                class="px-4 py-2 bg-[#d4b896] text-black rounded-lg hover:bg-[#c4a886] transition-colors text-sm">
                                Choose File
                            </button>
                            <span id="kain_filename"
                                class="text-sm text-gray-500">{{ isset($order->decorations['photo_kain_tenda']) && $order->decorations['photo_kain_tenda'] ? 'File sudah ada' : 'No file chosen' }}</span>
                        </div>
                        <input type="file" id="photo_kain_tenda" name="decorations[photo_kain_tenda]" class="hidden"
                            accept="image/*" onchange="updateFileName(this, 'kain_filename', 'kain_preview')">
                        <p class="text-xs text-gray-500 mt-1">Upload foto warna kain tenda (PNG, JPG/JPEG/WEBP)</p>
                    </div>

                    <!-- Warna Tenda -->
                    <div>
                        <label class="block text-sm font-medium mb-2 text-black">Warna Tenda (Optional)</label>
                        <input type="text" name="decorations[warna_tenda]"
                            value="{{ old('decorations.warna_tenda', $order->decorations['warna_tenda'] ?? '') }}"
                            placeholder="cth: Coklat, Abu-abu"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-[#d4b896] focus:outline-none">
                    </div>

                    <!-- Foto Gaun - 3 Foto -->
                    <div>
                        <label class="block text-sm font-medium mb-2 text-black">Foto Gaun - 3 Foto (Optional)</label>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @for ($i = 1; $i <= 3; $i++)
                                <div>
                                    @if (isset($order->decorations["foto_gaun_$i"]) && $order->decorations["foto_gaun_$i"])
                                        <div class="mb-3">
                                            <img src="{{ asset('storage/' . $order->decorations["foto_gaun_$i"]) }}"
                                                alt="Foto Gaun {{ $i }}"
                                                class="w-full h-48 object-cover rounded-lg border-2 border-gray-200"
                                                id="gaun_{{ $i }}_preview">
                                            <p class="text-xs text-gray-500 mt-1">Foto {{ $i }} sudah ada</p>
                                        </div>
                                    @else
                                        <div id="gaun_{{ $i }}_preview_container" class="mb-3 hidden">
                                            <img src="" alt="Preview" id="gaun_{{ $i }}_preview"
                                                class="w-full h-48 object-cover rounded-lg border-2 border-gray-200">
                                        </div>
                                    @endif
                                    <div class="flex items-center gap-3">
                                        <button type="button"
                                            onclick="document.getElementById('foto_gaun_{{ $i }}').click()"
                                            class="px-4 py-2 bg-[#d4b896] text-black rounded-lg hover:bg-[#c4a886] transition-colors text-sm">
                                            Choose File
                                        </button>
                                        <span id="gaun_{{ $i }}_filename"
                                            class="text-sm text-gray-500">{{ isset($order->decorations["foto_gaun_$i"]) && $order->decorations["foto_gaun_$i"] ? 'File sudah ada' : "Foto Gaun $i" }}</span>
                                    </div>
                                    <input type="file" id="foto_gaun_{{ $i }}"
                                        name="decorations[foto_gaun_{{ $i }}]" class="hidden"
                                        accept="image/*"
                                        onchange="updateFileName(this, 'gaun_{{ $i }}_filename', 'gaun_{{ $i }}_preview')">
                                </div>
                            @endfor
                        </div>
                        <p class="text-xs text-gray-500 mt-2">Upload gambar gaun untuk klien (PNG, JPG/JPEG/WEBP)</p>
                    </div>

                    <!-- Permintaan Optional -->
                    <div>
                        <label class="block text-sm font-medium mb-2 text-black">Permintaan Optional</label>
                        <textarea name="notes" rows="4" placeholder="Tulis permintaan tambahan di sini..."
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-[#d4b896] focus:outline-none">{{ old('notes', $order->notes) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Pembayaran -->
            <div class="bg-white border-2 border-[#d4b896] rounded-xl p-6 mb-6 shadow-lg">
                <h2 class="text-lg font-bold mb-4 text-black">Pembayaran</h2>

                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <label class="block text-sm font-medium mb-2 text-black">Status Pembayaran <span
                                class="text-red-600">*</span></label>
                        <select name="payment_status" required
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-[#d4b896] focus:outline-none">
                            <option value="Belum Lunas" {{ $order->payment_status == 'Belum Lunas' ? 'selected' : '' }}>
                                Belum Lunas</option>
                            <option value="Lunas" {{ $order->payment_status == 'Lunas' ? 'selected' : '' }}>Lunas
                            </option>
                        </select>
                    </div>
                </div>

                @php
                    $paymentHistory = $order->payment_history ?? [];
                @endphp

                @if (count($paymentHistory) > 0)
                    <div class="mt-6 p-4 bg-amber-50 border border-amber-200 rounded-lg">
                        <h3 class="text-sm font-bold text-gray-900 mb-4">Edit Riwayat Pembayaran</h3>
                        <div class="space-y-4">
                            @foreach ($paymentHistory as $index => $payment)
                                <div
                                    class="grid grid-cols-1 md:grid-cols-3 gap-4 p-4 bg-white rounded-lg border border-amber-300">
                                    <div>
                                        <label
                                            class="block text-xs font-medium mb-1 text-gray-600">{{ $payment['dp_number'] ?? 'DP' }}</label>
                                        <input type="text" name="dp_payments[{{ $index }}][dp_number]"
                                            value="{{ old('dp_payments.' . $index . '.dp_number', $payment['dp_number'] ?? 'DP') }}"
                                            class="w-full px-3 py-2 text-sm border-2 border-gray-200 rounded-lg focus:border-[#d4b896] focus:outline-none"
                                            placeholder="Contoh: DP1, DP2">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium mb-1 text-gray-600">Nominal</label>
                                        <input type="number" name="dp_payments[{{ $index }}][amount]"
                                            value="{{ old('dp_payments.' . $index . '.amount', $payment['amount']) }}"
                                            class="w-full px-3 py-2 text-sm border-2 border-gray-200 rounded-lg focus:border-[#d4b896] focus:outline-none"
                                            placeholder="Nominal pembayaran">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium mb-1 text-gray-600">Tanggal</label>
                                        <input type="date" name="dp_payments[{{ $index }}][paid_at]"
                                            value="{{ old('dp_payments.' . $index . '.paid_at', \Carbon\Carbon::parse($payment['paid_at'])->format('Y-m-d')) }}"
                                            class="w-full px-3 py-2 text-sm border-2 border-gray-200 rounded-lg focus:border-[#d4b896] focus:outline-none">
                                    </div>
                                    <input type="hidden" name="dp_payments[{{ $index }}][payment_method]"
                                        value="{{ $payment['payment_method'] ?? 'Transfer' }}">
                                    <input type="hidden" name="dp_payments[{{ $index }}][notes]"
                                        value="{{ $payment['notes'] ?? '' }}">
                                </div>
                            @endforeach
                        </div>
                        <p class="text-xs text-amber-700 mt-3">
                            💡 Edit label DP, nominal dan tanggal untuk setiap pembayaran. Untuk menambah pembayaran DP
                            baru, gunakan tombol "Tambah Pembayaran" di halaman detail.
                        </p>
                    </div>
                @else
                    <div class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <p class="text-sm text-blue-800">
                            <strong>💡 Info:</strong> Untuk menambah pembayaran DP, silakan ke halaman detail order dan
                            gunakan tombol "Tambah Pembayaran".
                        </p>
                    </div>
                @endif
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end gap-4">
                <a href="{{ route('orders.show', $order) }}"
                    class="px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium">
                    Batal
                </a>
                <button type="submit"
                    class="px-6 py-3 bg-[#d4b896] text-black rounded-lg hover:bg-[#c4a886] transition-colors font-medium">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    <script>
        let itemCounter = 0;
        let items = [];

        // Load existing items
        const existingItems = @json($order->items ?? []);

        function addItemRow(itemData = null) {
            itemCounter++;

            const name = itemData ? itemData.name : '';
            const quantity = itemData ? itemData.quantity : 1;
            const price = itemData ? itemData.price : 0;
            const total = itemData ? itemData.total : 0;

            // Add to desktop table
            const tbody = document.getElementById('itemsBody');
            const row = document.createElement('tr');
            row.id = `item-row-${itemCounter}`;

            row.innerHTML = `
                <td class="px-4 py-3">
                    <input type="text" data-id="${itemCounter}" data-field="name" value="${name}"
                        placeholder="Paket Riau Pengantin"
                        class="w-full px-3 py-2 border border-gray-200 rounded focus:border-[#d4b896] focus:outline-none text-sm"
                        onchange="updateItem(event, ${itemCounter})">
                </td>
                <td class="px-4 py-3 text-center">
                    <input type="number" data-id="${itemCounter}" data-field="quantity" value="${quantity}" min="1"
                        class="w-full px-3 py-2 border border-gray-200 rounded focus:border-[#d4b896] focus:outline-none text-sm text-center"
                        onchange="updateItem(event, ${itemCounter})">
                </td>
                <td class="px-4 py-3">
                    <input type="number" data-id="${itemCounter}" data-field="price" value="${price}" min="0" step="0.01"
                        class="w-full px-3 py-2 border border-gray-200 rounded focus:border-[#d4b896] focus:outline-none text-sm"
                        onchange="updateItem(event, ${itemCounter})" placeholder="INO">
                </td>
                <td class="px-4 py-3">
                    <input type="text" id="total-${itemCounter}" readonly
                        class="w-full px-3 py-2 border border-gray-200 rounded bg-gray-50 text-sm" value="Rp ${total.toLocaleString('id-ID')}">
                </td>
                <td class="px-4 py-3 text-center">
                    <button type="button" onclick="removeItem(${itemCounter})" class="text-red-600 hover:text-red-700">
                        <span class="material-symbols-outlined text-base">delete</span>
                    </button>
                </td>
            `;
            tbody.appendChild(row);

            // Add to mobile card view
            const mobileContainer = document.getElementById('itemsBodyMobile');
            const card = document.createElement('div');
            card.id = `item-card-${itemCounter}`;
            card.className = 'bg-gray-50 border-2 border-gray-200 rounded-lg p-3';
            card.innerHTML = `
                <div class="flex justify-between items-start mb-3">
                    <span class="text-xs font-semibold text-gray-600">Item #${itemCounter}</span>
                    <button type="button" onclick="removeItem(${itemCounter})" class="text-red-600 hover:text-red-700">
                        <span class="material-symbols-outlined text-lg">delete</span>
                    </button>
                </div>
                <div class="space-y-2">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Item</label>
                        <input type="text" data-id="${itemCounter}" data-field="name" data-mobile="true" value="${name}"
                            placeholder="Paket Riau Pengantin"
                            class="w-full px-3 py-2 border border-gray-200 rounded focus:border-[#d4b896] focus:outline-none text-sm"
                            onchange="updateItem(event, ${itemCounter})">
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Jml</label>
                            <input type="number" data-id="${itemCounter}" data-field="quantity" data-mobile="true" value="${quantity}" min="1"
                                class="w-full px-3 py-2 border border-gray-200 rounded focus:border-[#d4b896] focus:outline-none text-sm"
                                onchange="updateItem(event, ${itemCounter})">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Harga</label>
                            <input type="number" data-id="${itemCounter}" data-field="price" data-mobile="true" value="${price}" min="0" step="0.01"
                                class="w-full px-3 py-2 border border-gray-200 rounded focus:border-[#d4b896] focus:outline-none text-sm"
                                onchange="updateItem(event, ${itemCounter})" placeholder="0">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Total</label>
                        <input type="text" id="total-mobile-${itemCounter}" readonly
                            class="w-full px-3 py-2 border border-gray-200 rounded bg-gray-100 text-sm font-semibold" value="Rp ${total.toLocaleString('id-ID')}">
                    </div>
                </div>
            `;
            mobileContainer.appendChild(card);

            items.push({
                id: itemCounter,
                name: name,
                quantity: quantity,
                price: price,
                total: total
            });

            calculateTotal();
        }

        function updateItem(event, id) {
            const source = event.target;
            const isMobile = source.dataset.mobile === "true";

            const desktopRow = document.getElementById(`item-row-${id}`);
            const mobileCard = document.getElementById(`item-card-${id}`);

            let name, quantity, price;

            if (isMobile && mobileCard) {
                name = mobileCard.querySelector('[data-field="name"]').value;
                quantity = parseFloat(mobileCard.querySelector('[data-field="quantity"]').value) || 1;
                price = parseFloat(mobileCard.querySelector('[data-field="price"]').value) || 0;
            } else if (desktopRow) {
                name = desktopRow.querySelector('[data-field="name"]').value;
                quantity = parseFloat(desktopRow.querySelector('[data-field="quantity"]').value) || 1;
                price = parseFloat(desktopRow.querySelector('[data-field="price"]').value) || 0;
            }

            const total = quantity * price;

            const itemIndex = items.findIndex(item => item.id === id);
            if (itemIndex !== -1) {
                items[itemIndex] = {
                    id,
                    name,
                    quantity,
                    price,
                    total
                };
            }

            // Sync desktop
            if (desktopRow) {
                desktopRow.querySelector('[data-field="name"]').value = name;
                desktopRow.querySelector('[data-field="quantity"]').value = quantity;
                desktopRow.querySelector('[data-field="price"]').value = price;
                document.getElementById(`total-${id}`).value = `Rp ${total.toLocaleString('id-ID')}`;
            }

            // Sync mobile
            if (mobileCard) {
                mobileCard.querySelector('[data-field="name"]').value = name;
                mobileCard.querySelector('[data-field="quantity"]').value = quantity;
                mobileCard.querySelector('[data-field="price"]').value = price;
                document.getElementById(`total-mobile-${id}`).value = `Rp ${total.toLocaleString('id-ID')}`;
            }

            calculateTotal();
        }


        function removeItem(id) {
            const desktopRow = document.getElementById(`item-row-${id}`);
            const mobileCard = document.getElementById(`item-card-${id}`);

            if (desktopRow) desktopRow.remove();
            if (mobileCard) mobileCard.remove();

            items = items.filter(item => item.id !== id);
            calculateTotal();
        }

        function calculateTotal() {
            const grandTotal = items.reduce((sum, item) => sum + item.total, 0);
            document.getElementById('grandTotal').textContent = `Rp${grandTotal.toLocaleString('id-ID')}`;
            document.getElementById('total_amount').value = grandTotal;

            // Update items data
            document.getElementById('itemsData').value = JSON.stringify(items);
        }

        function updateFileName(input, spanId, previewId) {
            const span = document.getElementById(spanId);
            const preview = document.getElementById(previewId);
            const maxSize = 20480 * 1024; // 20480 KB = 20 MB

            if (input.files && input.files[0]) {
                const file = input.files[0];

                // Validasi ukuran file
                if (file.size > maxSize) {
                    alert(
                        `Ukuran file terlalu besar! Maksimal 20 MB.\nUkuran file Anda: ${(file.size / 1024 / 1024).toFixed(1)} MB`
                    );
                    input.value = ''; // Reset input
                    span.textContent = 'No file chosen';
                    return;
                }

                // Validasi tipe file
                if (!file.type.match('image.*')) {
                    alert('File harus berupa gambar (JPG, PNG, GIF, WEBP)');
                    input.value = '';
                    span.textContent = 'No file chosen';
                    return;
                }

                span.textContent = file.name;

                // Show preview for new image with compression
                if (preview) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = new Image();
                        img.onload = function() {
                            // SELALU kompresi semua foto untuk menghemat storage server
                            compressImageEdit(img, file, input, preview, span);
                        };
                        img.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            } else {
                span.textContent = 'No file chosen';
            }
        }

        function compressImageEdit(img, originalFile, input, preview, filenameSpan) {
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');

            // Tentukan ukuran maksimal (max width/height 1920px)
            const maxWidth = 1920;
            const maxHeight = 1920;
            let width = img.width;
            let height = img.height;

            // Hitung ukuran baru dengan mempertahankan aspek rasio
            if (width > height) {
                if (width > maxWidth) {
                    height *= maxWidth / width;
                    width = maxWidth;
                }
            } else {
                if (height > maxHeight) {
                    width *= maxHeight / height;
                    height = maxHeight;
                }
            }

            canvas.width = width;
            canvas.height = height;
            ctx.drawImage(img, 0, 0, width, height);

            // Kompresi dengan kualitas 0.8 (80%)
            canvas.toBlob(function(blob) {
                // Buat File baru dari blob
                const compressedFile = new File([blob], originalFile.name, {
                    type: 'image/jpeg',
                    lastModified: Date.now()
                });

                // Update input file dengan file yang sudah dikompresi
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(compressedFile);
                input.files = dataTransfer.files;

                // Tampilkan preview
                preview.src = canvas.toDataURL('image/jpeg', 0.8);
                const container = preview.closest('div');
                if (container && container.classList.contains('hidden')) {
                    container.classList.remove('hidden');
                }

                // Update filename dengan info kompresi
                const originalSizeKB = (originalFile.size / 1024).toFixed(0);
                const compressedSizeKB = (compressedFile.size / 1024).toFixed(0);
                filenameSpan.textContent = `${originalFile.name} (${originalSizeKB}KB → ${compressedSizeKB}KB)`;
                filenameSpan.classList.add('text-green-600');
            }, 'image/jpeg', 0.8);
        }

        // Load existing items on page load
        window.addEventListener('load', function() {
            if (existingItems && existingItems.length > 0) {
                existingItems.forEach(item => {
                    addItemRow(item);
                });
            } else {
                addItemRow();
            }
        });
    </script>
@endsection

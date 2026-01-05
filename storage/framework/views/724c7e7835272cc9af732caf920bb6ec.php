<?php $__env->startSection('title', 'Buat Pesanan Baru - ROROO MUA Admin'); ?>

<?php $__env->startSection('content'); ?>
    <div class="min-h-screen bg-gray-50 text-black p-3 sm:p-4 md:p-8">
        <!-- Page Header -->
        <div class="mb-4 sm:mb-6">
            <a href="<?php echo e(route('orders.index')); ?>"
                class="text-sm text-gray-600 hover:text-[#d4b896] flex items-center gap-1 mb-2">
                <span class="material-symbols-outlined text-base">arrow_back</span>
                Back to Orders
            </a>
            <h1 class="text-xl sm:text-2xl md:text-3xl font-bold mb-1 sm:mb-2 text-black">Buat Pesanan Baru</h1>
            <p class="text-xs sm:text-sm md:text-base text-gray-600">Isi formulir di bawah ini untuk menambahkan pesanan baru
                untuk
                klien.</p>
        </div>

        <form action="<?php echo e(route('orders.store')); ?>" method="POST" enctype="multipart/form-data" id="orderForm">
            <?php echo csrf_field(); ?>

            <!-- Informasi Klien -->
            <div class="bg-white border-2 border-[#d4b896] rounded-xl p-3 sm:p-4 md:p-6 mb-4 sm:mb-6 shadow-lg">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2 sm:gap-0 mb-3 sm:mb-4">
                    <h2 class="text-base sm:text-lg font-bold text-black">Informasi Klien</h2>
                    <button type="button" onclick="openAddClientModal()"
                        class="px-3 sm:px-4 py-1.5 sm:py-2 text-xs sm:text-sm bg-[#d4b896] text-black rounded-lg hover:bg-[#c4a886] transition-colors flex items-center gap-1 sm:gap-2 justify-center">
                        <span class="material-symbols-outlined text-base sm:text-lg">add</span>
                        <span class="hidden sm:inline">Tambah Klien Baru</span>
                        <span class="sm:hidden">Tambah Klien</span>
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4 md:gap-6">
                    <div>
                        <label class="block text-xs sm:text-sm font-medium mb-1 sm:mb-2 text-black">Pilih Klien <span
                                class="text-red-600">*</span></label>
                        <select name="client_id" id="client_id" required
                            class="w-full px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base border-2 border-gray-200 rounded-lg focus:border-[#d4b896] focus:outline-none">
                            <option value="">Pilih klien yang sudah ada atau tambahkan yang baru</option>
                            <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($client->id); ?>" data-location="<?php echo e($client->event_location); ?>"
                                    <?php echo e(old('client_id') == $client->id ? 'selected' : ''); ?>>
                                    <?php echo e($client->bride_name); ?> & <?php echo e($client->groom_name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['client_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-600 text-xs sm:text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
            </div>

            <!-- Item & Layanan yang Dipesan -->
            <div class="bg-white border-2 border-[#d4b896] rounded-xl p-3 sm:p-4 md:p-6 mb-4 sm:mb-6 shadow-lg">
                <h2 class="text-base sm:text-lg font-bold mb-3 sm:mb-4 text-black">Item & Layanan yang Dipesan</h2>

                <!-- Desktop Table View -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full" id="itemsTable">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-1 sm:px-2 py-2 text-left text-xs sm:text-sm font-semibold text-gray-600"
                                    style="min-width: 250px;">Item</th>
                                <th class="px-1 sm:px-2 py-2 text-center text-xs sm:text-sm font-semibold text-gray-600"
                                    style="width: 80px;">
                                    Qty</th>
                                <th class="px-1 sm:px-2 py-2 text-left text-xs sm:text-sm font-semibold text-gray-600"
                                    style="width: 150px;">
                                    Harga</th>
                                <th class="px-1 sm:px-2 py-2 text-left text-xs sm:text-sm font-semibold text-gray-600"
                                    style="width: 150px;">
                                    Total</th>
                                <th class="px-1 sm:px-2 py-2 text-center text-xs sm:text-sm font-semibold text-gray-600"
                                    style="width: 50px;">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="itemsBody">
                            <!-- Items will be added here dynamically -->
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Card View -->
                <div class="md:hidden space-y-3" id="itemsBodyMobile">
                    <!-- Items will be added here dynamically as cards -->
                </div>

                <button type="button" onclick="addItemRow()"
                    class="mt-3 sm:mt-4 text-[#d4b896] hover:text-[#c4a886] text-xs sm:text-sm flex items-center gap-1 sm:gap-2">
                    <span class="material-symbols-outlined text-base sm:text-lg">add_circle</span>
                    <span>Tambah Item</span>
                </button>

                <!-- Total Section -->
                <div class="mt-4 sm:mt-6 border-t-2 border-gray-200 pt-3 sm:pt-4">
                    <div class="flex justify-between items-center mb-3 sm:mb-4">
                        <span class="text-base sm:text-lg font-bold text-black">Total</span>
                        <span class="text-xl sm:text-2xl font-bold text-black" id="grandTotal">Rp0</span>
                    </div>

                    <div class="flex justify-end">
                        <div class="w-full md:w-1/2 lg:w-1/3">
                            <div class="mb-2 sm:mb-3">
                                <label class="block text-xs sm:text-sm font-medium mb-1 sm:mb-2 text-gray-700">Uang yang
                                    Dibayar</label>
                                <input type="number" name="paid_amount" id="paid_amount"
                                    value="<?php echo e(old('paid_amount', 0)); ?>" min="0" step="0.01"
                                    class="w-full px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base border-2 border-gray-200 rounded-lg focus:border-[#d4b896] focus:outline-none"
                                    onchange="calculatePayment()">
                            </div>

                            <div class="flex justify-between items-center text-xs sm:text-sm">
                                <span class="font-medium text-gray-700">Sisa yang Harus Dibayar</span>
                                <span class="font-bold text-black" id="remainingAmount">Rp0</span>
                            </div>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="items" id="itemsData">
                <input type="hidden" name="total_amount" id="total_amount">
            </div>

            <!-- Detail Dekorasi Pernikahan -->
            <div class="bg-white border-2 border-[#d4b896] rounded-xl p-3 sm:p-4 md:p-6 mb-4 sm:mb-6 shadow-lg">
                <h2 class="text-base sm:text-lg font-bold mb-3 sm:mb-4 text-black">Detail Dekorasi Pernikahan</h2>

                <div class="space-y-3 sm:space-y-4 md:space-y-6">
                    <!-- Foto Model Pelaminan -->
                    <div>
                        <label class="block text-sm font-medium mb-2 text-black">Foto Model Pelaminan (Optional)</label>
                        <div class="flex items-center gap-3 mb-2">
                            <button type="button" onclick="document.getElementById('photo_pelaminan').click()"
                                class="px-4 py-2 bg-[#d4b896] text-black rounded-lg hover:bg-[#c4a886] transition-colors text-sm">
                                Choose File
                            </button>
                            <span id="pelaminan_filename" class="text-sm text-gray-500">No file chosen</span>
                        </div>
                        <input type="file" id="photo_pelaminan" name="decorations[photo_pelaminan]" class="hidden"
                            accept="image/*" onchange="previewImage(this, 'pelaminan_preview', 'pelaminan_filename')">
                        <div id="pelaminan_preview" class="hidden mt-2">
                            <img src="" alt="Preview"
                                class="w-full h-48 object-cover rounded-lg border-2 border-gray-200">
                        </div>
                    </div>

                    <!-- Kursi Pelaminan -->
                    <div>
                        <label class="block text-sm font-medium mb-2 text-black">Kursi Pelaminan (Optional)</label>
                        <input type="text" name="decorations[kursi_pelaminan]"
                            value="<?php echo e(old('decorations.kursi_pelaminan')); ?>" placeholder="cth: Sofa, Kursi tungggal"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-[#d4b896] focus:outline-none">
                    </div>

                    <!-- Foto Warna Kain Tenda -->
                    <div>
                        <label class="block text-sm font-medium mb-2 text-black">Foto Warna Kain Tenda (Optional)</label>
                        <div class="flex items-center gap-3 mb-2">
                            <button type="button" onclick="document.getElementById('photo_kain_tenda').click()"
                                class="px-4 py-2 bg-[#d4b896] text-black rounded-lg hover:bg-[#c4a886] transition-colors text-sm">
                                Choose File
                            </button>
                            <span id="kain_filename" class="text-sm text-gray-500">No file chosen</span>
                        </div>
                        <input type="file" id="photo_kain_tenda" name="decorations[photo_kain_tenda]" class="hidden"
                            accept="image/*" onchange="previewImage(this, 'kain_preview', 'kain_filename')">
                        <div id="kain_preview" class="hidden mt-2">
                            <img src="" alt="Preview"
                                class="w-full h-48 object-cover rounded-lg border-2 border-gray-200">
                        </div>
                        <p class="text-xs text-gray-500 mt-1">Upload foto warna kain tenda (PNG, JPG/JPEG/WEBP)</p>
                    </div>

                    <!-- Warna Tenda -->
                    <div>
                        <label class="block text-sm font-medium mb-2 text-black">Warna Tenda (Optional)</label>
                        <input type="text" name="decorations[warna_tenda]"
                            value="<?php echo e(old('decorations.warna_tenda')); ?>" placeholder="cth: Coklat, Abu-abu"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-[#d4b896] focus:outline-none">
                    </div>

                    <!-- Foto Gaun - 3 Foto -->
                    <div>
                        <label class="block text-sm font-medium mb-2 text-black">Foto Gaun - 3 Foto (Optional)</label>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <?php for($i = 1; $i <= 3; $i++): ?>
                                <div>
                                    <div class="flex items-center gap-3 mb-2">
                                        <button type="button"
                                            onclick="document.getElementById('foto_gaun_<?php echo e($i); ?>').click()"
                                            class="px-4 py-2 bg-[#d4b896] text-black rounded-lg hover:bg-[#c4a886] transition-colors text-sm">
                                            Foto <?php echo e($i); ?>

                                        </button>
                                        <span id="gaun_<?php echo e($i); ?>_filename" class="text-sm text-gray-500">No
                                            file</span>
                                    </div>
                                    <input type="file" id="foto_gaun_<?php echo e($i); ?>"
                                        name="decorations[foto_gaun_<?php echo e($i); ?>]" class="hidden"
                                        accept="image/*"
                                        onchange="previewImage(this, 'gaun_<?php echo e($i); ?>_preview', 'gaun_<?php echo e($i); ?>_filename')">
                                    <div id="gaun_<?php echo e($i); ?>_preview" class="hidden">
                                        <img src="" alt="Gaun <?php echo e($i); ?>"
                                            class="w-full h-32 object-cover rounded-lg border-2 border-gray-200">
                                    </div>
                                </div>
                            <?php endfor; ?>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">Upload gambar gaun untuk klien (PNG, JPG/JPEG/WEBP)</p>
                    </div>

                    <!-- Permintaan Optional -->
                    <div>
                        <label class="block text-sm font-medium mb-2 text-black">Permintaan Optional</label>
                        <textarea name="notes" rows="4" placeholder="Tulis permintaan tambahan di sini..."
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-[#d4b896] focus:outline-none"><?php echo e(old('notes')); ?></textarea>
                    </div>
                </div>
            </div>

            <!-- Pembayaran -->
            <div class="bg-white border-2 border-[#d4b896] rounded-xl p-6 mb-6 shadow-lg">
                <h2 class="text-lg font-bold mb-4 text-black">Pembayaran</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium mb-2 text-black">Status Pembayaran <span
                                class="text-red-600">*</span></label>
                        <select name="payment_status" required
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-[#d4b896] focus:outline-none">
                            <option value="Belum Lunas" <?php echo e(old('payment_status') == 'Belum Lunas' ? 'selected' : ''); ?>>
                                Belum Lunas</option>
                            <option value="Lunas" <?php echo e(old('payment_status') == 'Lunas' ? 'selected' : ''); ?>>Lunas</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2 text-black">Pembayaran DP ke</label>
                        <select name="dp_type" id="dp_type"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-[#d4b896] focus:outline-none">
                            <option value="DP1" selected>DP1</option>
                            <option value="DP2">DP2</option>
                            <option value="DP3">DP3</option>
                            <option value="DP4">DP4</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2 text-black">Metode Pembayaran</label>
                        <select name="payment_method" id="payment_method"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-[#d4b896] focus:outline-none">
                            <option value="Transfer Bank">Transfer Bank</option>
                            <option value="Cash">Cash</option>
                            <option value="E-Wallet">E-Wallet</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2 text-black">Catatan Pembayaran</label>
                        <input type="text" name="payment_notes" id="payment_notes"
                            value="<?php echo e(old('payment_notes')); ?>" placeholder="Catatan untuk pembayaran ini (opsional)"
                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-[#d4b896] focus:outline-none">
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end gap-4">
                <a href="<?php echo e(route('orders.index')); ?>"
                    class="px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium">
                    Batal
                </a>
                <button type="submit"
                    class="px-6 py-3 bg-[#d4b896] text-black rounded-lg hover:bg-[#c4a886] transition-colors font-medium">
                    Buat Pesanan
                </button>
            </div>
        </form>
    </div>

    <!-- Modal Tambah Klien Baru -->
    <div id="addClientModal"
        class="hidden fixed inset-0 backdrop-blur-sm bg-black/30 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
            <div class="sticky top-0 bg-white border-b-2 border-[#d4b896] px-6 py-4 z-10">
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-bold text-black">Tambah Klien Baru</h3>
                    <button type="button" onclick="closeAddClientModal()" class="text-gray-500 hover:text-gray-700">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>
            </div>

            <form id="addClientForm" class="p-6">
                <?php echo csrf_field(); ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nama Pengantin Wanita -->
                    <div>
                        <label class="block text-sm font-semibold text-black mb-2">
                            Nama Pengantin Wanita <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="bride_name" required placeholder="e.g., Jane Doe"
                            class="w-full px-4 py-3 border-2 border-[#d4b896] rounded-lg focus:border-[#c4a886] focus:outline-none transition-colors">
                    </div>

                    <!-- Nomor HP Pengantin Wanita -->
                    <div>
                        <label class="block text-sm font-semibold text-black mb-2">
                            Nomor HP Pengantin Wanita <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="bride_phone" required placeholder="e.g., 081234567890"
                            class="w-full px-4 py-3 border-2 border-[#d4b896] rounded-lg focus:border-[#c4a886] focus:outline-none transition-colors">
                    </div>

                    <!-- Nama Pengantin Pria -->
                    <div>
                        <label class="block text-sm font-semibold text-black mb-2">
                            Nama Pengantin Pria <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="groom_name" required placeholder="e.g., John Smith"
                            class="w-full px-4 py-3 border-2 border-[#d4b896] rounded-lg focus:border-[#c4a886] focus:outline-none transition-colors">
                    </div>

                    <!-- Nomor HP Pengantin Pria -->
                    <div>
                        <label class="block text-sm font-semibold text-black mb-2">
                            Nomor HP Pengantin Pria <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="groom_phone" required placeholder="e.g., 081234567890"
                            class="w-full px-4 py-3 border-2 border-[#d4b896] rounded-lg focus:border-[#c4a886] focus:outline-none transition-colors">
                    </div>

                    <!-- Alamat Pengantin Wanita -->
                    <div>
                        <label class="block text-sm font-semibold text-black mb-2">
                            Alamat Pengantin Wanita
                        </label>
                        <textarea name="bride_address" rows="3" placeholder="Jl. Contoh Kec.Contoh Kota Contoh"
                            class="w-full px-4 py-3 border-2 border-[#d4b896] rounded-lg focus:border-[#c4a886] focus:outline-none transition-colors resize-none"></textarea>
                    </div>

                    <!-- Alamat Pengantin Pria -->
                    <div>
                        <label class="block text-sm font-semibold text-black mb-2">
                            Alamat Pengantin Pria
                        </label>
                        <textarea name="groom_address" rows="3" placeholder="e.g., 456 Oak Ave, Anytown, USA 12345"
                            class="w-full px-4 py-3 border-2 border-[#d4b896] rounded-lg focus:border-[#c4a886] focus:outline-none transition-colors resize-none"></textarea>
                    </div>

                    <!-- Nama Orang Tua Pengantin Wanita -->
                    <div>
                        <label class="block text-sm font-semibold text-black mb-2">
                            Nama Orang Tua Pengantin Wanita
                        </label>
                        <input type="text" name="bride_parents" placeholder="e.g., Mr. & Mrs. Doe"
                            class="w-full px-4 py-3 border-2 border-[#d4b896] rounded-lg focus:border-[#c4a886] focus:outline-none transition-colors">
                    </div>

                    <!-- Nama Orang Tua Pengantin Pria -->
                    <div>
                        <label class="block text-sm font-semibold text-black mb-2">
                            Nama Orang Tua Pengantin Pria
                        </label>
                        <input type="text" name="groom_parents" placeholder="e.g., Mr. & Mrs. Smith"
                            class="w-full px-4 py-3 border-2 border-[#d4b896] rounded-lg focus:border-[#c4a886] focus:outline-none transition-colors">
                    </div>

                    <!-- Tanggal Akad -->
                    <div>
                        <label class="block text-sm font-semibold text-black mb-2">
                            Tanggal Akad (Opsional)
                        </label>
                        <input type="date" name="akad_date"
                            class="w-full px-4 py-3 border-2 border-[#d4b896] rounded-lg focus:border-[#c4a886] focus:outline-none transition-colors">
                    </div>

                    <!-- Jam Akad -->
                    <div>
                        <label class="block text-sm font-semibold text-black mb-2">
                            Jam Akad
                        </label>
                        <input type="time" name="akad_time"
                            class="w-full px-4 py-3 border-2 border-[#d4b896] rounded-lg focus:border-[#c4a886] focus:outline-none transition-colors">
                    </div>

                    <!-- Jam Kelar Akad -->
                    <div>
                        <label class="block text-sm font-semibold text-black mb-2">
                            Jam Kelar Akad
                        </label>
                        <input type="time" name="akad_end_time"
                            class="w-full px-4 py-3 border-2 border-[#d4b896] rounded-lg focus:border-[#c4a886] focus:outline-none transition-colors">
                    </div>

                    <!-- Tanggal Resepsi -->
                    <div>
                        <label class="block text-sm font-semibold text-black mb-2">
                            Tanggal Resepsi (Opsional)
                        </label>
                        <input type="date" name="reception_date"
                            class="w-full px-4 py-3 border-2 border-[#d4b896] rounded-lg focus:border-[#c4a886] focus:outline-none transition-colors">
                    </div>

                    <!-- Jam Resepsi -->
                    <div>
                        <label class="block text-sm font-semibold text-black mb-2">
                            Jam Resepsi
                        </label>
                        <input type="time" name="reception_time"
                            class="w-full px-4 py-3 border-2 border-[#d4b896] rounded-lg focus:border-[#c4a886] focus:outline-none transition-colors">
                    </div>

                    <!-- Jam Kelar Resepsi -->
                    <div>
                        <label class="block text-sm font-semibold text-black mb-2">
                            Jam Kelar Resepsi
                        </label>
                        <input type="time" name="reception_end_time"
                            class="w-full px-4 py-3 border-2 border-[#d4b896] rounded-lg focus:border-[#c4a886] focus:outline-none transition-colors">
                    </div>
                </div>

                <!-- Lokasi Acara - Full Width -->
                <div class="mt-6">
                    <label class="block text-sm font-semibold text-black mb-2">
                        Lokasi Acara
                    </label>
                    <textarea name="event_location" rows="2" placeholder="e.g., Grand Ballroom, 789 Event Plaza, Anytown, USA"
                        class="w-full px-4 py-3 border-2 border-[#d4b896] rounded-lg focus:border-[#c4a886] focus:outline-none transition-colors resize-none"></textarea>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end gap-3 mt-6 pt-6 border-t-2 border-gray-200">
                    <button type="button" onclick="closeAddClientModal()"
                        class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors font-semibold">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-6 py-2 bg-[#d4b896] text-black rounded-lg hover:bg-[#c4a886] transition-colors font-semibold">
                        Simpan Klien
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Tambah Klien Baru -->
    <div id="addClientModal"
        class="hidden fixed inset-0 backdrop-blur-sm bg-black/30 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl max-w-3xl w-full max-h-[90vh] overflow-y-auto">
            <div class="sticky top-0 bg-white border-b-2 border-[#d4b896] p-6 z-10">
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-bold text-black">Tambah Klien Baru</h3>
                    <button type="button" onclick="closeAddClientModal()" class="text-gray-500 hover:text-gray-700">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>
            </div>

            <form id="addClientForm" class="p-6">
                <?php echo csrf_field(); ?>
                <div class="space-y-4">
                    <!-- Informasi Mempelai Wanita -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="font-semibold text-black mb-3">Informasi Mempelai Wanita</h4>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium mb-1 text-black">Nama Lengkap <span
                                        class="text-red-600">*</span></label>
                                <input type="text" name="bride_name" required
                                    class="w-full px-3 py-2 border-2 border-gray-200 rounded-lg focus:border-[#d4b896] focus:outline-none text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1 text-black">Nomor Telepon <span
                                        class="text-red-600">*</span></label>
                                <input type="tel" name="bride_phone" required
                                    class="w-full px-3 py-2 border-2 border-gray-200 rounded-lg focus:border-[#d4b896] focus:outline-none text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1 text-black">Alamat</label>
                                <textarea name="bride_address" rows="2"
                                    class="w-full px-3 py-2 border-2 border-gray-200 rounded-lg focus:border-[#d4b896] focus:outline-none text-sm"></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1 text-black">Nama Orang Tua</label>
                                <input type="text" name="bride_parents"
                                    class="w-full px-3 py-2 border-2 border-gray-200 rounded-lg focus:border-[#d4b896] focus:outline-none text-sm">
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Mempelai Pria -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="font-semibold text-black mb-3">Informasi Mempelai Pria</h4>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium mb-1 text-black">Nama Lengkap <span
                                        class="text-red-600">*</span></label>
                                <input type="text" name="groom_name" required
                                    class="w-full px-3 py-2 border-2 border-gray-200 rounded-lg focus:border-[#d4b896] focus:outline-none text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1 text-black">Nomor Telepon <span
                                        class="text-red-600">*</span></label>
                                <input type="tel" name="groom_phone" required
                                    class="w-full px-3 py-2 border-2 border-gray-200 rounded-lg focus:border-[#d4b896] focus:outline-none text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1 text-black">Alamat</label>
                                <textarea name="groom_address" rows="2"
                                    class="w-full px-3 py-2 border-2 border-gray-200 rounded-lg focus:border-[#d4b896] focus:outline-none text-sm"></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1 text-black">Nama Orang Tua</label>
                                <input type="text" name="groom_parents"
                                    class="w-full px-3 py-2 border-2 border-gray-200 rounded-lg focus:border-[#d4b896] focus:outline-none text-sm">
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Acara -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="font-semibold text-black mb-3">Informasi Acara</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium mb-1 text-black">Tanggal Akad</label>
                                <input type="date" name="akad_date"
                                    class="w-full px-3 py-2 border-2 border-gray-200 rounded-lg focus:border-[#d4b896] focus:outline-none text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1 text-black">Waktu Akad</label>
                                <input type="time" name="akad_time"
                                    class="w-full px-3 py-2 border-2 border-gray-200 rounded-lg focus:border-[#d4b896] focus:outline-none text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1 text-black">Tanggal Resepsi</label>
                                <input type="date" name="reception_date"
                                    class="w-full px-3 py-2 border-2 border-gray-200 rounded-lg focus:border-[#d4b896] focus:outline-none text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1 text-black">Waktu Resepsi</label>
                                <input type="time" name="reception_time"
                                    class="w-full px-3 py-2 border-2 border-gray-200 rounded-lg focus:border-[#d4b896] focus:outline-none text-sm">
                            </div>
                        </div>
                        <div class="mt-3">
                            <label class="block text-sm font-medium mb-1 text-black">Lokasi Acara</label>
                            <textarea name="event_location" rows="2" placeholder="cth: Gedung Serbaguna, Jl. Merdeka No. 123"
                                class="w-full px-3 py-2 border-2 border-gray-200 rounded-lg focus:border-[#d4b896] focus:outline-none text-sm"></textarea>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="closeAddClientModal()"
                        class="px-6 py-2 border-2 border-gray-300 text-black rounded-lg hover:bg-gray-50 transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-6 py-2 bg-[#d4b896] text-black rounded-lg hover:bg-[#c4a886] transition-colors">
                        Simpan Klien
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let itemCounter = 0;
        let items = [];

        // Modal Functions
        function openAddClientModal() {
            document.getElementById('addClientModal').classList.remove('hidden');
        }

        function closeAddClientModal() {
            document.getElementById('addClientModal').classList.add('hidden');
            document.getElementById('addClientForm').reset();
        }

        // Handle Add Client Form Submission
        document.getElementById('addClientForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const submitButton = this.querySelector('button[type="submit"]');
            const originalText = submitButton.textContent;

            submitButton.disabled = true;
            submitButton.textContent = 'Menyimpan...';

            try {
                const response = await fetch('<?php echo e(route('clients.store')); ?>', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                    body: formData
                });

                const data = await response.json();

                if (response.ok) {
                    // Add new client to select dropdown
                    const select = document.getElementById('client_id');
                    const option = new Option(
                        `${data.client.bride_name} & ${data.client.groom_name}`,
                        data.client.id,
                        true,
                        true
                    );
                    option.setAttribute('data-location', data.client.event_location || '');
                    select.add(option);

                    // Update event location field if available
                    if (data.client.event_location) {
                        document.getElementById('event_location').value = data.client.event_location;
                    }

                    // Show success message
                    alert('Klien berhasil ditambahkan!');

                    // Close modal
                    closeAddClientModal();
                } else {
                    alert(data.message || 'Terjadi kesalahan saat menyimpan klien');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menyimpan klien');
            } finally {
                submitButton.disabled = false;
                submitButton.textContent = originalText;
            }
        });

        // Update event location when client is selected
        document.getElementById('client_id').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const location = selectedOption.getAttribute('data-location');
            if (location) {
                document.getElementById('event_location').value = location;
            }
        });

        // Modal functions
        function openAddClientModal() {
            document.getElementById('addClientModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeAddClientModal() {
            document.getElementById('addClientModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
            document.getElementById('addClientForm').reset();
        }

        // Submit new client via AJAX
        function submitNewClient(event) {
            event.preventDefault();

            const formData = {
                bride_name: document.getElementById('new_bride_name').value,
                bride_phone: document.getElementById('new_bride_phone').value,
                groom_name: document.getElementById('new_groom_name').value,
                groom_phone: document.getElementById('new_groom_phone').value,
                bride_address: document.getElementById('new_bride_address').value,
                email: document.getElementById('new_email').value,
                venue: document.getElementById('new_venue').value,
                akad_date: document.getElementById('new_akad_date').value,
                reception_date: document.getElementById('new_reception_date').value,
                event_location: document.getElementById('new_event_location').value,
                _token: '<?php echo e(csrf_token()); ?>'
            };

            // Show loading state
            const submitBtn = event.target.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<span>Menyimpan...</span>';
            submitBtn.disabled = true;

            fetch('<?php echo e(route('clients.store')); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                    },
                    body: JSON.stringify(formData)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Add new client to dropdown
                        const clientSelect = document.getElementById('client_id');
                        const option = document.createElement('option');
                        option.value = data.client.id;
                        option.textContent = `${data.client.bride_name} & ${data.client.groom_name}`;
                        option.setAttribute('data-location', data.client.event_location || '');
                        option.selected = true;
                        clientSelect.appendChild(option);

                        // Auto-fill event location if available
                        if (data.client.event_location) {
                            document.getElementById('event_location').value = data.client.event_location;
                        }

                        // Show success message
                        alert('Klien berhasil ditambahkan!');

                        // Close modal
                        closeAddClientModal();
                    } else {
                        alert('Gagal menambahkan klien: ' + (data.message || 'Terjadi kesalahan'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menambahkan klien');
                })
                .finally(() => {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                });
        }

        function addItemRow() {
            itemCounter++;

            // Add to desktop table
            const tbody = document.getElementById('itemsBody');
            const row = document.createElement('tr');
            row.id = `item-row-${itemCounter}`;
            row.innerHTML = `
                <td class="px-2 py-3">
                    <input type="text" data-id="${itemCounter}" data-field="name"
                        placeholder="Paket Riau Pengantin"
                        class="w-full px-3 py-2 border border-gray-200 rounded focus:border-[#d4b896] focus:outline-none text-sm"
                        onchange="updateItem(${itemCounter})">
                </td>
                <td class="px-2 py-3 text-center">
                    <input type="number" data-id="${itemCounter}" data-field="quantity" value="1" min="1"
                        class="w-full px-2 py-2 border border-gray-200 rounded focus:border-[#d4b896] focus:outline-none text-sm text-center"
                        oninput="updateItem(${itemCounter})" onchange="updateItem(${itemCounter})">
                </td>
                <td class="px-2 py-3">
                    <input type="number" data-id="${itemCounter}" data-field="price" value="0" min="0" step="0.01"
                        class="w-full px-3 py-2 border border-gray-200 rounded focus:border-[#d4b896] focus:outline-none text-sm"
                        oninput="updateItem(${itemCounter})" onchange="updateItem(${itemCounter})" placeholder="0">
                </td>
                <td class="px-2 py-3">
                    <input type="text" id="total-${itemCounter}" readonly
                        class="w-full px-3 py-2 border border-gray-200 rounded bg-gray-50 text-sm" value="Rp 0">
                </td>
                <td class="px-2 py-3 text-center">
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
                        <input type="text" data-id="${itemCounter}" data-field="name" data-mobile="true"
                            placeholder="Paket Riau Pengantin"
                            class="w-full px-3 py-2 border border-gray-200 rounded focus:border-[#d4b896] focus:outline-none text-sm"
                            onchange="updateItem(${itemCounter})">
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Jml</label>
                            <input type="number" data-id="${itemCounter}" data-field="quantity" data-mobile="true" value="1" min="1"
                                class="w-full px-3 py-2 border border-gray-200 rounded focus:border-[#d4b896] focus:outline-none text-sm"
                                onchange="updateItem(${itemCounter})">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Harga</label>
                            <input type="number" data-id="${itemCounter}" data-field="price" data-mobile="true" value="0" min="0" step="0.01"
                                class="w-full px-3 py-2 border border-gray-200 rounded focus:border-[#d4b896] focus:outline-none text-sm"
                                onchange="updateItem(${itemCounter})" placeholder="0">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Total</label>
                        <input type="text" id="total-mobile-${itemCounter}" readonly
                            class="w-full px-3 py-2 border border-gray-200 rounded bg-gray-100 text-sm font-semibold" value="Rp 0">
                    </div>
                </div>
            `;
            mobileContainer.appendChild(card);

            items.push({
                id: itemCounter,
                name: '',
                quantity: 1,
                price: 0,
                total: 0
            });
        }

        function updateItem(id) {
            // Get values from either desktop or mobile view
            const desktopRow = document.querySelector(`#item-row-${id}`);
            const mobileCard = document.querySelector(`#item-card-${id}`);

            let name, quantity, price;
            let isDesktopActive = false;

            // Determine which view is active and get values from it
            if (desktopRow && window.getComputedStyle(desktopRow).display !== 'none') {
                isDesktopActive = true;
                name = desktopRow.querySelector('[data-field="name"]').value;
                quantity = parseFloat(desktopRow.querySelector('[data-field="quantity"]').value) || 1;
                price = parseFloat(desktopRow.querySelector('[data-field="price"]').value) || 0;
            } else if (mobileCard && window.getComputedStyle(mobileCard).display !== 'none') {
                name = mobileCard.querySelector('[data-field="name"]').value;
                quantity = parseFloat(mobileCard.querySelector('[data-field="quantity"]').value) || 1;
                price = parseFloat(mobileCard.querySelector('[data-field="price"]').value) || 0;
            }

            const total = quantity * price;

            // Update item in array
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

            // Update totals only (don't touch the inputs being typed in)
            if (desktopRow) {
                document.getElementById(`total-${id}`).value = `Rp ${total.toLocaleString('id-ID')}`;
            }

            if (mobileCard) {
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

            calculatePayment();
        }

        function calculatePayment() {
            const total = parseFloat(document.getElementById('total_amount').value) || 0;
            const paidAmount = parseFloat(document.getElementById('paid_amount').value) || 0;

            const remaining = total - paidAmount;

            document.getElementById('remainingAmount').textContent = `Rp${remaining.toLocaleString('id-ID')}`;
        }

        function updateFileName(input, spanId) {
            const span = document.getElementById(spanId);
            if (input.files && input.files[0]) {
                span.textContent = input.files[0].name;
            } else {
                span.textContent = 'No file chosen';
            }
        }

        function previewImage(input, previewId, filenameId) {
            const preview = document.getElementById(previewId);
            const filenameSpan = document.getElementById(filenameId);

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    const img = preview.querySelector('img');
                    img.src = e.target.result;
                    preview.classList.remove('hidden');
                }

                reader.readAsDataURL(input.files[0]);
                filenameSpan.textContent = input.files[0].name;
            } else {
                preview.classList.add('hidden');
                filenameSpan.textContent = 'No file chosen';
            }
        }

        // Add first row on load
        window.addEventListener('load', function() {
            addItemRow();
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Belajar\roro-wedding\resources\views/orders/create.blade.php ENDPATH**/ ?>
<?php $__env->startSection('title', 'Timeline Acara Orders - ROROO MUA Admin'); ?>

<?php $__env->startSection('content'); ?>
    <div class="min-h-screen bg-gray-50 text-black p-4 sm:p-6 md:p-8">
        <!-- Back Button & Header -->
        <div class="mb-6">
            <a href="<?php echo e(route('orders.index')); ?>"
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
                        (<?php echo e($upcomingEventsCount); ?> hari dengan acara)</p>
                </div>
            </div>
        </div>

        <!-- Date Navigation -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-3 sm:p-6 mb-4">
            <div class="flex items-center justify-between mb-4 gap-2">
                <?php if($previousDate): ?>
                    <a href="<?php echo e(route('orders.timeline', ['date' => $previousDate])); ?>"
                        class="flex items-center gap-1 text-gray-600 hover:text-[#8b6f47] transition-colors text-xs sm:text-base">
                        <span class="material-symbols-outlined text-lg sm:text-2xl">chevron_left</span>
                        <span class="hidden sm:inline">Sebelumnya</span>
                    </a>
                <?php else: ?>
                    <div class="flex items-center gap-1 text-gray-300 cursor-not-allowed text-xs sm:text-base">
                        <span class="material-symbols-outlined text-lg sm:text-2xl">chevron_left</span>
                        <span class="hidden sm:inline">Sebelumnya</span>
                    </div>
                <?php endif; ?>

                <div class="text-center flex-1 min-w-0">
                    <div class="flex items-center gap-1 sm:gap-2 justify-center">
                        <span class="material-symbols-outlined text-[#8b6f47] text-lg sm:text-2xl">calendar_today</span>
                        <span class="text-sm sm:text-xl font-bold"><?php echo e($date->format('d F Y')); ?></span>
                        <?php if($date->isToday()): ?>
                            <span
                                class="px-2 sm:px-3 py-0.5 sm:py-1 bg-green-100 text-green-700 text-[10px] sm:text-xs font-semibold rounded-full whitespace-nowrap">Hari
                                Ini</span>
                        <?php endif; ?>
                    </div>
                    <p class="text-xs sm:text-sm text-gray-600 mt-1"><?php echo e($date->isoFormat('dddd')); ?> • <?php echo e($orders->count()); ?>

                        acara</p>
                </div>

                <?php if($nextDate): ?>
                    <a href="<?php echo e(route('orders.timeline', ['date' => $nextDate])); ?>"
                        class="flex items-center gap-1 text-gray-600 hover:text-[#8b6f47] transition-colors text-xs sm:text-base">
                        <span class="hidden sm:inline">Selanjutnya</span>
                        <span class="material-symbols-outlined text-lg sm:text-2xl">chevron_right</span>
                    </a>
                <?php else: ?>
                    <div class="flex items-center gap-1 text-gray-300 cursor-not-allowed text-xs sm:text-base">
                        <span class="hidden sm:inline">Selanjutnya</span>
                        <span class="material-symbols-outlined text-lg sm:text-2xl">chevron_right</span>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Timeline Dots -->
            <div class="relative mt-6 pb-2 overflow-visible">
                <?php if(count($datesWithEvents) > 0): ?>
                    <div class="flex items-center justify-center space-x-2 px-4">
                        <?php $__currentLoopData = $datesWithEvents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dateInfo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="relative group flex-shrink-0">
                                <a href="<?php echo e(route('orders.timeline', ['date' => $dateInfo['date']])); ?>" class="block">
                                    <div
                                        class="w-3 h-3 rounded-full transition-all
                                        <?php if($dateInfo['isSelected']): ?> bg-[#8b6f47] ring-4 ring-[#8b6f47]/20
                                        <?php else: ?> bg-[#d4b896] hover:bg-[#8b6f47] <?php endif; ?>">
                                    </div>
                                </a>

                                <div
                                    class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200
                                           bg-gray-900 text-white text-xs font-medium px-3 py-2 rounded-md shadow-xl whitespace-nowrap pointer-events-none">
                                    <?php echo e(\Carbon\Carbon::parse($dateInfo['date'])->format('d M')); ?> (<?php echo e($dateInfo['count']); ?>)
                                    <div
                                        class="absolute top-full left-1/2 -translate-x-1/2 -mt-1 border-4 border-transparent border-t-gray-900">
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <div class="absolute top-1/2 left-0 right-0 h-0.5 bg-gray-300 -z-10 mt-4"></div>
                <?php else: ?>
                    <div class="text-center text-gray-500 py-4">
                        <p class="text-sm">Tidak ada acara dalam rentang waktu ini</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Orders List -->
        <?php if($orders->count() > 0): ?>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div
                        class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
                        <!-- Card Header -->
                        <div class="bg-gradient-to-r from-[#f5f1ec] to-white p-4 border-b border-gray-200">
                            <div class="flex items-start justify-between">
                                <div class="flex items-start gap-3">
                                    <div
                                        class="w-10 h-10 bg-[#d4b896] rounded-full flex items-center justify-center text-white font-bold">
                                        <?php echo e($index + 1); ?>

                                    </div>
                                    <div>
                                        <h3 class="text-lg font-bold text-black">Order #<?php echo e($order->order_number); ?></h3>
                                        <p class="text-sm text-gray-600"><?php echo e($order->client->bride_name); ?> &
                                            <?php echo e($order->client->groom_name); ?></p>
                                    </div>
                                </div>
                                <a href="<?php echo e(route('orders.show', $order)); ?>"
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
                                        <?php echo e($order->client->akad_time ? \Carbon\Carbon::parse($order->client->akad_time)->format('H:i') : '00:00'); ?>

                                        WIB
                                    </p>
                                </div>
                                <span
                                    class="px-3 py-1 text-xs font-semibold rounded-full ml-auto
                                    <?php if($order->payment_status === 'lunas'): ?> bg-green-100 text-green-700
                                    <?php else: ?> bg-yellow-100 text-yellow-700 <?php endif; ?>">
                                    <?php echo e($order->payment_status === 'lunas' ? 'Lunas' : 'Belum Lunas'); ?>

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
                                            <?php echo e($order->client->bride_name); ?></p>
                                        <a href="https://wa.me/<?php echo e(preg_replace('/[^0-9]/', '', $order->client->bride_phone)); ?>"
                                            target="_blank"
                                            class="inline-flex items-center gap-2 px-3 py-2 bg-green-50 text-green-700 rounded-lg text-sm hover:bg-green-100 transition-colors">
                                            <span class="material-symbols-outlined text-lg">chat</span>
                                            <span class="font-medium"><?php echo e($order->client->bride_phone); ?></span>
                                            <span class="text-xs">WhatsApp</span>
                                        </a>
                                    </div>

                                    <!-- Groom Contact -->
                                    <div>
                                        <p class="text-xs text-gray-600 mb-1">HP Pengantin Pria -
                                            <?php echo e($order->client->groom_name); ?></p>
                                        <a href="https://wa.me/<?php echo e(preg_replace('/[^0-9]/', '', $order->client->groom_phone)); ?>"
                                            target="_blank"
                                            class="inline-flex items-center gap-2 px-3 py-2 bg-green-50 text-green-700 rounded-lg text-sm hover:bg-green-100 transition-colors">
                                            <span class="material-symbols-outlined text-lg">chat</span>
                                            <span class="font-medium"><?php echo e($order->client->groom_phone); ?></span>
                                            <span class="text-xs">WhatsApp</span>
                                        </a>
                                    </div>
                                </div>

                                <!-- Names & Addresses -->
                                <div class="grid grid-cols-2 gap-4 pt-3 border-t border-gray-100">
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Nama Pengantin Wanita</p>
                                        <p class="text-sm font-semibold"><?php echo e($order->client->bride_name); ?></p>
                                        <?php if($order->client->bride_address): ?>
                                            <p class="text-xs text-gray-600 mt-1">Alamat Pengantin Wanita</p>
                                            <p class="text-xs text-gray-700"><?php echo e($order->client->bride_address); ?></p>
                                        <?php endif; ?>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Nama Pengantin Pria</p>
                                        <p class="text-sm font-semibold"><?php echo e($order->client->groom_name); ?></p>
                                        <?php if($order->client->groom_address): ?>
                                            <p class="text-xs text-gray-600 mt-1">Alamat Pengantin Pria</p>
                                            <p class="text-xs text-gray-700"><?php echo e($order->client->groom_address); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <!-- View Full Details Button -->
                            <button onclick="openDetailModal<?php echo e($index); ?>()"
                                class="w-full mt-4 px-4 py-2 bg-[#d4b896] text-black rounded-lg hover:bg-[#c4a886] transition-colors font-medium text-sm">
                                Lihat Detail Lengkap (Items, Kustom, Pembayaran)
                            </button>
                        </div>
                    </div>

                    <!-- Detail Modal -->
                    <div id="detailModal<?php echo e($index); ?>"
                        class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 overflow-y-auto">
                        <div class="min-h-screen px-4 py-8 flex items-center justify-center">
                            <div class="bg-white rounded-xl shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto"
                                onclick="event.stopPropagation()">
                                <!-- Modal Header -->
                                <div
                                    class="sticky top-0 bg-white border-b border-gray-200 p-6 flex items-center justify-between z-10">
                                    <h3 class="text-xl font-bold">Order #<?php echo e($order->order_number); ?></h3>
                                    <button onclick="closeDetailModal<?php echo e($index); ?>()"
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
                                                <?php echo e($order->client->bride_name); ?> & <?php echo e($order->client->groom_name); ?></p>
                                            <p class="text-sm"><span class="font-semibold">Lokasi:</span>
                                                <?php echo e($order->client->event_location ?? 'Tidak ada'); ?></p>
                                            <p class="text-sm"><span class="font-semibold">Tanggal Akad:</span>
                                                <?php echo e($order->client->akad_date ? \Carbon\Carbon::parse($order->client->akad_date)->format('d F Y') : '-'); ?>

                                            </p>
                                            <p class="text-sm"><span class="font-semibold">Tanggal Resepsi:</span>
                                                <?php echo e($order->client->reception_date ? \Carbon\Carbon::parse($order->client->reception_date)->format('d F Y') : '-'); ?>

                                            </p>
                                        </div>
                                    </div>

                                    <!-- Items -->
                                    <?php if($order->items && count($order->items) > 0): ?>
                                        <div>
                                            <h4 class="font-semibold text-sm mb-3 flex items-center gap-2">
                                                <span class="material-symbols-outlined text-[#8b6f47]">inventory_2</span>
                                                Item Pesanan
                                            </h4>
                                            <div class="space-y-2">
                                                <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div
                                                        class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                                        <div class="flex-1">
                                                            <p class="text-sm font-medium"><?php echo e($item['name'] ?? 'Item'); ?>

                                                            </p>
                                                            <p class="text-xs text-gray-500">Qty:
                                                                <?php echo e($item['quantity'] ?? 1); ?></p>
                                                        </div>
                                                        <p class="text-sm font-bold">Rp
                                                            <?php echo e(number_format($item['price'] ?? 0, 0, ',', '.')); ?></p>
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <!-- Custom Decorations -->
                                    <?php if($order->decorations): ?>
                                        <div>
                                            <h4 class="font-semibold text-sm mb-3 flex items-center gap-2">
                                                <span class="material-symbols-outlined text-[#8b6f47]">palette</span>
                                                Pilihan Kustom
                                            </h4>
                                            <div class="space-y-3">
                                                <?php if(isset($order->decorations['photo_pelaminan']) && is_string($order->decorations['photo_pelaminan'])): ?>
                                                    <div>
                                                        <p class="text-xs text-gray-500 mb-1">Foto Model Pelaminan</p>
                                                        <img src="<?php echo e(asset('storage/' . $order->decorations['photo_pelaminan'])); ?>"
                                                            alt="Pelaminan" class="w-full h-32 object-cover rounded-lg">
                                                        <?php if(isset($order->decorations['kursi_pelaminan'])): ?>
                                                            <p class="text-xs text-gray-600 mt-1">
                                                                <?php echo e($order->decorations['kursi_pelaminan']); ?></p>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php endif; ?>

                                                <?php if(isset($order->decorations['photo_kain_tenda']) && is_string($order->decorations['photo_kain_tenda'])): ?>
                                                    <div>
                                                        <p class="text-xs text-gray-500 mb-1">Foto Warna Kain Tenda</p>
                                                        <img src="<?php echo e(asset('storage/' . $order->decorations['photo_kain_tenda'])); ?>"
                                                            alt="Kain Tenda" class="w-full h-32 object-cover rounded-lg">
                                                    </div>
                                                <?php endif; ?>

                                                <?php if(isset($order->decorations['foto_gaun_1']) ||
                                                        isset($order->decorations['foto_gaun_2']) ||
                                                        isset($order->decorations['foto_gaun_3'])): ?>
                                                    <div>
                                                        <p class="text-xs text-gray-500 mb-1">Foto Gaun</p>
                                                        <div class="grid grid-cols-3 gap-2">
                                                            <?php for($i = 1; $i <= 3; $i++): ?>
                                                                <?php if(isset($order->decorations["foto_gaun_{$i}"]) && is_string($order->decorations["foto_gaun_{$i}"])): ?>
                                                                    <img src="<?php echo e(asset('storage/' . $order->decorations["foto_gaun_{$i}"])); ?>"
                                                                        alt="Gaun <?php echo e($i); ?>"
                                                                        class="w-full h-24 object-cover rounded-lg">
                                                                <?php endif; ?>
                                                            <?php endfor; ?>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <!-- Notes -->
                                    <?php if($order->notes): ?>
                                        <div>
                                            <h4 class="font-semibold text-sm mb-2 flex items-center gap-2">
                                                <span class="material-symbols-outlined text-[#8b6f47]">description</span>
                                                Catatan
                                            </h4>
                                            <p class="text-sm text-gray-700 bg-yellow-50 p-3 rounded-lg">
                                                <?php echo e($order->notes); ?></p>
                                        </div>
                                    <?php endif; ?>

                                    <!-- Total -->
                                    <div class="border-t pt-4">
                                        <div class="flex items-center justify-between text-lg font-bold">
                                            <span>Total</span>
                                            <span class="text-[#8b6f47]">Rp
                                                <?php echo e(number_format($order->total_amount, 0, ',', '.')); ?></span>
                                        </div>
                                    </div>

                                    <!-- Payment Status -->
                                    <div>
                                        <h4 class="font-semibold text-sm mb-3 flex items-center gap-2">
                                            <span class="material-symbols-outlined text-[#8b6f47]">
                                                <?php echo e($order->payment_status === 'lunas' ? 'check_circle' : 'schedule'); ?>

                                            </span>
                                            Status:
                                            <span
                                                class="px-3 py-1 text-xs font-semibold rounded-full
                                                <?php if($order->payment_status === 'lunas'): ?> bg-green-100 text-green-700
                                                <?php else: ?> bg-yellow-100 text-yellow-700 <?php endif; ?>">
                                                <?php echo e($order->payment_status === 'lunas' ? 'Lunas' : 'Belum Lunas'); ?>

                                            </span>
                                        </h4>

                                        <?php if($order->payment_history && count($order->payment_history) > 0): ?>
                                            <div class="space-y-2">
                                                <p class="text-xs text-gray-500 font-semibold mb-2">Riwayat Pembayaran:</p>
                                                <?php
                                                    $totalPaid = 0;
                                                ?>
                                                <?php $__currentLoopData = $order->payment_history; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php
                                                        $totalPaid += floatval($payment['amount'] ?? 0);
                                                    ?>
                                                    <div
                                                        class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                                                        <div>
                                                            <p class="text-sm font-medium">
                                                                <?php echo e($payment['dp_number'] ?? 'DP'); ?></p>
                                                            <p class="text-xs text-gray-500">
                                                                <?php echo e(isset($payment['paid_at']) ? \Carbon\Carbon::parse($payment['paid_at'])->format('d M Y') : '-'); ?>

                                                            </p>
                                                            <?php if(isset($payment['payment_method'])): ?>
                                                                <p class="text-xs text-gray-600">
                                                                    <?php echo e($payment['payment_method']); ?></p>
                                                            <?php endif; ?>
                                                        </div>
                                                        <p class="text-sm font-bold text-green-700">Rp
                                                            <?php echo e(number_format($payment['amount'] ?? 0, 0, ',', '.')); ?></p>
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                <!-- Summary -->
                                                <div class="mt-4 p-4 bg-gray-50 rounded-lg space-y-2">
                                                    <div class="flex justify-between text-sm">
                                                        <span class="text-gray-600">Total Dibayar:</span>
                                                        <span class="font-bold text-green-700">Rp
                                                            <?php echo e(number_format($totalPaid, 0, ',', '.')); ?></span>
                                                    </div>
                                                    <?php if($order->payment_status !== 'lunas'): ?>
                                                        <div class="flex justify-between text-sm">
                                                            <span class="text-gray-600">Sisa:</span>
                                                            <span class="font-bold text-red-700">Rp
                                                                <?php echo e(number_format($order->remaining_amount, 0, ',', '.')); ?></span>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                        function openDetailModal<?php echo e($index); ?>() {
                            document.getElementById('detailModal<?php echo e($index); ?>').classList.remove('hidden');
                            document.body.style.overflow = 'hidden';
                        }

                        function closeDetailModal<?php echo e($index); ?>() {
                            document.getElementById('detailModal<?php echo e($index); ?>').classList.add('hidden');
                            document.body.style.overflow = 'auto';
                        }

                        document.getElementById('detailModal<?php echo e($index); ?>').addEventListener('click', function(e) {
                            if (e.target === this) {
                                closeDetailModal<?php echo e($index); ?>();
                            }
                        });
                    </script>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                <span class="material-symbols-outlined text-6xl text-gray-300 mb-4">event_busy</span>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">Tidak Ada Acara</h3>
                <p class="text-gray-500">Tidak ada acara yang dijadwalkan pada tanggal ini.</p>
            </div>
        <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Belajar\roro-wedding\resources\views/orders/timeline.blade.php ENDPATH**/ ?>
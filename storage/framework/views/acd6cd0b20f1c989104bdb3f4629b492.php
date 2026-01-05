<?php $__env->startSection('title', 'Dashboard - ROROO MUA Admin'); ?>

<?php $__env->startSection('content'); ?>
    <div class="min-h-screen bg-gray-50 text-black p-4 sm:p-6 md:p-8">
        <!-- Page Header -->
        <div class="mb-6 md:mb-8">
            <h1 class="text-2xl md:text-3xl font-bold mb-2 text-black">Dashboard</h1>
            <p class="text-sm md:text-base text-gray-600">Welcome back! Here's your business overview</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-8">
            <!-- Total Clients Card -->
            <div class="bg-white border-2 border-[#d4b896] p-6 rounded-xl shadow-lg">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-gray-600 text-sm font-medium">Total Clients</h3>
                    <span class="material-symbols-outlined text-[#d4b896]">groups</span>
                </div>
                <p class="text-3xl font-bold text-black"><?php echo e($totalClients); ?></p>
                <p class="text-sm text-gray-500 mt-2">All registered clients</p>
            </div>

            <!-- Total Orders Card -->
            <div class="bg-white border-2 border-[#d4b896] p-6 rounded-xl shadow-lg">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-gray-600 text-sm font-medium">Total Orders</h3>
                    <span class="material-symbols-outlined text-[#d4b896]">shopping_bag</span>
                </div>
                <p class="text-3xl font-bold text-black"><?php echo e($totalOrders); ?></p>
                <p class="text-sm text-gray-500 mt-2">All orders</p>
            </div>

            <!-- Total Invoices Card -->
            <div class="bg-white border-2 border-[#d4b896] p-6 rounded-xl shadow-lg">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-gray-600 text-sm font-medium">Total Invoices</h3>
                    <span class="material-symbols-outlined text-[#d4b896]">receipt_long</span>
                </div>
                <p class="text-3xl font-bold text-black"><?php echo e($totalInvoices); ?></p>
                <p class="text-sm text-gray-500 mt-2">All invoices</p>
            </div>

            <!-- Total Revenue Card -->
            <div class="bg-white border-2 border-[#d4b896] p-6 rounded-xl shadow-lg">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-gray-600 text-sm font-medium">Total Revenue</h3>
                    <span class="material-symbols-outlined text-[#d4b896]">payments</span>
                </div>
                <p class="text-3xl font-bold text-black">Rp <?php echo e(number_format($totalRevenue, 0, ',', '.')); ?></p>
                <p class="text-sm text-gray-500 mt-2">Total payments received</p>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Monthly Revenue Chart -->
            <div class="bg-white border-2 border-[#d4b896] rounded-xl p-6 shadow-lg">
                <h2 class="text-xl font-bold mb-4 text-black">Revenue Last 6 Months</h2>
                <canvas id="revenueChart" class="w-full" style="max-height: 300px;"></canvas>
            </div>

            <!-- Payment Status Chart -->
            <div class="bg-white border-2 border-[#d4b896] rounded-xl p-6 shadow-lg">
                <h2 class="text-xl font-bold mb-4 text-black">Payment Status Distribution</h2>
                <canvas id="paymentStatusChart" class="w-full" style="max-height: 300px;"></canvas>
            </div>
        </div>

        <!-- Invoice Status Chart -->
        <div class="bg-white border-2 border-[#d4b896] rounded-xl p-6 shadow-lg mb-8">
            <h2 class="text-xl font-bold mb-4 text-black">Invoice Status Overview</h2>
            <div class="flex justify-center">
                <canvas id="invoiceStatusChart" style="max-width: 400px; max-height: 400px;"></canvas>
            </div>
        </div>

        <!-- Upcoming Events -->
        <div class="bg-white border-2 border-[#d4b896] rounded-xl p-6 shadow-lg mb-8">
            <h2 class="text-xl font-bold mb-4 text-black">Upcoming Events (Next 30 Days)</h2>

            <?php if($upcomingEvents->count() > 0): ?>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b-2 border-[#d4b896]">
                            <tr>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-[#d4b896] uppercase tracking-wider">
                                    Mempelai Wanita</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-[#d4b896] uppercase tracking-wider">
                                    Mempelai Pria</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-[#d4b896] uppercase tracking-wider">
                                    Tanggal Akad</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-[#d4b896] uppercase tracking-wider">
                                    Tanggal Resepsi</th>
                                <th
                                    class="px-6 py-4 text-center text-xs font-semibold text-[#d4b896] uppercase tracking-wider">
                                    Days Until</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <?php $__currentLoopData = $upcomingEvents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-black"><?php echo e($event->bride_name); ?></div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-black"><?php echo e($event->groom_name); ?></div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-black">
                                            <?php echo e($event->akad_date ? $event->akad_date->format('M d, Y') : '-'); ?>

                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-black">
                                            <?php echo e($event->reception_date ? $event->reception_date->format('M d, Y') : '-'); ?>

                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <?php
                                            $nearestDate =
                                                $event->akad_date && $event->akad_date->isFuture()
                                                    ? $event->akad_date
                                                    : $event->reception_date;
                                            $daysUntil = $nearestDate ? (int) $nearestDate->diffInDays(now()) : null;
                                        ?>
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold
                                            <?php echo e($daysUntil <= 7 ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800'); ?>">
                                            <?php echo e($daysUntil); ?> days
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center py-8">
                    <span class="material-symbols-outlined text-6xl text-gray-300">event</span>
                    <p class="text-gray-500 mt-4">No upcoming events in the next 30 days</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Recent Activity -->
        <div class="mt-8 bg-white border-2 border-[#d4b896] rounded-xl p-6 shadow-lg">
            <h2 class="text-xl font-bold mb-4 text-black">Recent Orders (5 Latest)</h2>

            <?php if($recentOrders->count() > 0): ?>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b-2 border-[#d4b896]">
                            <tr>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-[#d4b896] uppercase tracking-wider">
                                    Mempelai Wanita</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-[#d4b896] uppercase tracking-wider">
                                    Tanggal Akad</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-[#d4b896] uppercase tracking-wider">
                                    Tanggal Resepsi</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-[#d4b896] uppercase tracking-wider">
                                    Total Bayar</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-[#d4b896] uppercase tracking-wider">
                                    Sisa Pembayaran</th>
                                <th
                                    class="px-6 py-4 text-center text-xs font-semibold text-[#d4b896] uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <?php $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-black"><?php echo e($order->client->bride_name); ?></div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-black">
                                            <?php echo e($order->client->akad_date ? $order->client->akad_date->format('M d, Y') : '-'); ?>

                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-black">
                                            <?php echo e($order->client->reception_date ? $order->client->reception_date->format('M d, Y') : '-'); ?>

                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php
                                            $paymentHistory = $order->payment_history ?? [];
                                            $totalPaid = is_array($paymentHistory)
                                                ? array_sum(array_column($paymentHistory, 'amount'))
                                                : 0;
                                        ?>
                                        <div class="text-sm text-black font-medium">
                                            Rp <?php echo e(number_format($totalPaid, 0, ',', '.')); ?>

                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div
                                            class="text-sm font-semibold <?php echo e($order->remaining_amount > 0 ? 'text-red-600' : 'text-green-600'); ?>">
                                            Rp <?php echo e(number_format($order->remaining_amount, 0, ',', '.')); ?>

                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="<?php echo e(route('orders.show', $order)); ?>"
                                                class="p-2 text-gray-600 hover:text-blue-600 transition-colors"
                                                title="View">
                                                <span class="material-symbols-outlined">visibility</span>
                                            </a>
                                            <a href="<?php echo e(route('orders.edit', $order)); ?>"
                                                class="p-2 text-gray-600 hover:text-[#d4b896] transition-colors"
                                                title="Edit">
                                                <span class="material-symbols-outlined">edit</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 text-center">
                    <a href="<?php echo e(route('orders.index')); ?>"
                        class="inline-flex items-center gap-2 text-[#d4b896] hover:text-[#b8956e] font-medium">
                        View All Orders
                        <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </a>
                </div>
            <?php else: ?>
                <div class="text-center py-8">
                    <span class="material-symbols-outlined text-6xl text-gray-300">shopping_bag</span>
                    <p class="text-gray-500 mt-4">No orders yet</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        // Monthly Revenue Chart
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        const revenueData = <?php echo json_encode($monthlyRevenue, 15, 512) ?>;

        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: revenueData.map(item => {
                    const date = new Date(item.month + '-01');
                    return date.toLocaleDateString('id-ID', {
                        month: 'short',
                        year: 'numeric'
                    });
                }),
                datasets: [{
                    label: 'Revenue (Rp)',
                    data: revenueData.map(item => item.revenue),
                    borderColor: '#d4b896',
                    backgroundColor: 'rgba(212, 184, 150, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#d4b896',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + (value / 1000000).toFixed(1) + 'M';
                            }
                        }
                    }
                }
            }
        });

        // Payment Status Chart
        const paymentCtx = document.getElementById('paymentStatusChart').getContext('2d');
        const paymentStatusData = <?php echo json_encode($paymentStatus, 15, 512) ?>;

        new Chart(paymentCtx, {
            type: 'bar',
            data: {
                labels: ['Lunas', 'Belum Lunas'],
                datasets: [{
                    label: 'Orders',
                    data: [paymentStatusData.lunas, paymentStatusData.belum_lunas],
                    backgroundColor: [
                        'rgba(72, 187, 120, 0.8)',
                        'rgba(245, 158, 11, 0.8)'
                    ],
                    borderColor: [
                        'rgb(72, 187, 120)',
                        'rgb(245, 158, 11)'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });

        // Invoice Status Chart
        const invoiceCtx = document.getElementById('invoiceStatusChart').getContext('2d');
        const invoiceStatusData = <?php echo json_encode($invoiceStatus, 15, 512) ?>;

        new Chart(invoiceCtx, {
            type: 'doughnut',
            data: {
                labels: ['Paid', 'Partial', 'Unpaid'],
                datasets: [{
                    data: [invoiceStatusData.paid, invoiceStatusData.partial, invoiceStatusData.unpaid],
                    backgroundColor: [
                        'rgba(72, 187, 120, 0.8)',
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(239, 68, 68, 0.8)'
                    ],
                    borderColor: [
                        'rgb(72, 187, 120)',
                        'rgb(59, 130, 246)',
                        'rgb(239, 68, 68)'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Belajar\roro-wedding\resources\views/dashboard.blade.php ENDPATH**/ ?>
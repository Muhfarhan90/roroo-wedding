<?php $__env->startSection('title', 'Calendar - ROROO MUA Admin'); ?>

<?php $__env->startSection('content'); ?>
    <style>
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-down {
            animation: fadeInDown 0.5s ease-out;
        }
    </style>

    <div class="min-h-screen bg-gradient-to-br from-[#faf9f7] to-white text-black p-4 sm:p-6">
        <?php if(session('success')): ?>
            <div id="successAlert" class="fixed top-20 right-4 z-50 animate-fade-in-down">
                <div class="bg-white rounded-lg shadow-lg p-4 border-l-4 border-green-500 flex items-center gap-3">
                    <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                        <span class="material-symbols-outlined text-white text-lg">check</span>
                    </div>
                    <span class="text-sm font-medium text-gray-800"><?php echo e(session('success')); ?></span>
                </div>
            </div>

            <script>
                setTimeout(() => {
                    const alert = document.getElementById('successAlert');
                    if (alert) {
                        alert.style.transition = 'opacity 0.5s, transform 0.5s';
                        alert.style.opacity = '0';
                        alert.style.transform = 'translateY(-20px)';
                        setTimeout(() => alert.remove(), 500);
                    }
                }, 3000);
            </script>
        <?php endif; ?>

        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left: Calendar + Selected Day Appointments -->
                <div class="lg:col-span-2 space-y-4">
                    <!-- Calendar Card -->
                    <div class="bg-white rounded-2xl shadow-lg p-5">
                        <!-- Calendar Header -->
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-semibold text-gray-800">
                                <?php echo e($startOfMonth->format('F Y')); ?>

                            </h2>
                            <div class="flex items-center gap-1">
                                <a href="<?php echo e(route('calendar.index', ['month' => $startOfMonth->copy()->subMonth()->month, 'year' => $startOfMonth->copy()->subMonth()->year])); ?>"
                                    class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                                    <span class="material-symbols-outlined text-gray-600">chevron_left</span>
                                </a>
                                <a href="<?php echo e(route('calendar.index')); ?>"
                                    class="px-4 py-2 text-sm border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                                    Today
                                </a>
                                <a href="<?php echo e(route('calendar.index', ['month' => $startOfMonth->copy()->addMonth()->month, 'year' => $startOfMonth->copy()->addMonth()->year])); ?>"
                                    class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                                    <span class="material-symbols-outlined text-gray-600">chevron_right</span>
                                </a>
                            </div>
                        </div>

                        <!-- Calendar Grid -->
                        <div class="mb-4">
                            <!-- Day Headers -->
                            <div class="grid grid-cols-7 gap-1 mb-2">
                                <?php $__currentLoopData = ['SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div
                                        class="text-center text-[10px] font-medium text-gray-400 uppercase tracking-wider py-1">
                                        <?php echo e($day); ?>

                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>

                            <!-- Calendar Days -->
                            <?php
                                $currentDate = $startOfMonth->copy()->startOfWeek();
                                $endDate = $endOfMonth->copy()->endOfWeek();
                                $today = \Carbon\Carbon::today();
                            ?>

                            <div class="grid grid-cols-7 gap-1" id="calendarGrid">
                                <?php while($currentDate <= $endDate): ?>
                                    <?php
                                        $isCurrentMonth = $currentDate->month == $month;
                                        $isToday = $currentDate->isSameDay($today);
                                        $dateKey = $currentDate->format('Y-m-d');
                                        $dayAppointments = $appointments->get($dateKey, collect());
                                        $hasAppointments = $dayAppointments->count() > 0;
                                        $appointmentColor =
                                            $hasAppointments && !$isToday
                                                ? $dayAppointments->first()->color ?? '#d4b896'
                                                : '';
                                    ?>

                                    <button
                                        onclick="showDayAppointments('<?php echo e($dateKey); ?>', <?php echo e($dayAppointments->toJson()); ?>, this)"
                                        data-date="<?php echo e($dateKey); ?>"
                                        <?php if($hasAppointments && !$isToday): ?> style="background-color: <?php echo e($appointmentColor); ?>; border: 2px solid <?php echo e($appointmentColor); ?>;" <?php endif; ?>
                                        class="calendar-day aspect-square flex items-center justify-center rounded-full text-base font-semibold transition-all
                                            <?php echo e($isCurrentMonth ? ($hasAppointments && !$isToday ? 'text-white' : 'text-gray-800') : 'text-gray-300'); ?>

                                            <?php echo e($isToday ? 'bg-[#d4b896] text-white shadow-md' : ''); ?>

                                            <?php echo e(!$isToday && !$hasAppointments ? 'hover:bg-gray-100' : ''); ?>">
                                        <?php echo e($currentDate->day); ?>

                                    </button>

                                    <?php
                                        $currentDate->addDay();
                                    ?>
                                <?php endwhile; ?>
                            </div>
                        </div>

                        <!-- Add Appointment Button -->
                        <div class="text-center">
                            <button onclick="openNewAppointmentModal()"
                                class="inline-flex items-center gap-1 px-4 py-2 bg-[#d4b896] text-white rounded-full hover:bg-[#c4a886] transition-colors shadow-md text-sm">
                                <span class="material-symbols-outlined text-sm">add</span>
                                <span class="font-medium">New Appointment</span>
                            </button>
                        </div>
                    </div>

                    <!-- Selected Day Appointments (appears when date is clicked) -->
                    <div id="selectedDaySection" class="hidden">
                        <!-- Date Header -->
                        <div class="bg-white rounded-xl shadow-md p-3 mb-3 flex items-center justify-between">
                            <span class="text-base font-semibold text-gray-800" id="selectedDateHeader">Jadwal tanggal
                                ...</span>
                            <button onclick="openNewAppointmentModal()"
                                class="p-1 hover:bg-gray-100 rounded-lg transition-colors">
                                <span class="material-symbols-outlined text-[#d4b896] text-xl">add_circle</span>
                            </button>
                        </div>

                        <!-- Selected Day Appointments List -->
                        <div class="space-y-2" id="selectedDayAppointments"></div>
                    </div>
                </div>

                <!-- Right: Upcoming Appointments Sidebar -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-lg p-5">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Upcoming Appointments</h3>

                        <div class="space-y-2">
                            <?php $__empty_1 = true; $__currentLoopData = $upcomingAppointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div onclick="viewAppointment(<?php echo e($appointment->id); ?>)"
                                    class="bg-gray-50 rounded-xl p-3 hover:bg-gray-100 transition-all cursor-pointer flex items-center gap-3 border-l-4"
                                    style="border-left-color: <?php echo e($appointment->color ?? '#d4b896'); ?>;">
                                    <!-- Date Badge -->
                                    <div class="flex-shrink-0 w-10 h-10 rounded-full border-2 flex items-center justify-center"
                                        style="border-color: <?php echo e($appointment->color ?? '#d4b896'); ?>;">
                                        <span class="text-base font-bold"
                                            style="color: <?php echo e($appointment->color ?? '#d4b896'); ?>;"><?php echo e($appointment->date->format('d')); ?></span>
                                    </div>

                                    <!-- Appointment Info -->
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-2 mb-0.5">
                                            <span
                                                class="text-xs font-semibold text-gray-800"><?php echo e(\Carbon\Carbon::parse($appointment->start_time)->format('g:i A')); ?></span>
                                        </div>
                                        <h4 class="text-sm font-semibold text-gray-900 mb-0.5 truncate">
                                            <?php echo e($appointment->client ? $appointment->client->bride_name : 'No Name'); ?>

                                        </h4>
                                        <p class="text-xs text-gray-600 truncate"><?php echo e($appointment->title); ?></p>
                                    </div>

                                    <!-- Status Badge -->
                                    <?php if($appointment->status == 'confirmed'): ?>
                                        <div
                                            class="flex-shrink-0 px-2 py-0.5 bg-[#d4b896]/20 text-[#d4b896] text-[10px] font-medium rounded-full">
                                            Confirmed
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <div class="text-center py-8">
                                    <span class="material-symbols-outlined text-4xl text-gray-300 mb-2">event</span>
                                    <p class="text-gray-500 text-sm">No upcoming appointments</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- New/Edit Appointment Modal -->
    <div id="appointmentModal"
        class="hidden fixed inset-0 bg-black/30 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto border-2 border-[#d4b896]">
            <div class="p-6">
                <!-- Modal Header -->
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-2xl font-bold text-black" id="modalTitle">New Appointment</h3>
                    <button onclick="closeModal()" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <!-- Form -->
                <form id="appointmentForm" method="POST" action="<?php echo e(route('appointments.store')); ?>">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="_method" id="methodField" value="">
                    <input type="hidden" id="appointmentId" value="">

                    <!-- Client Selection -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Client (Optional)</label>
                        <select name="client_id" id="client_id"
                            class="w-full px-4 py-3 border-2 border-[#d4b896] rounded-lg focus:border-[#c4a886] focus:outline-none">
                            <option value="">Select a client</option>
                            <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($client->id); ?>"><?php echo e($client->bride_name); ?> & <?php echo e($client->groom_name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <!-- Title -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                        <input type="text" name="title" id="title" required placeholder="e.g., Bridal Makeup"
                            class="w-full px-4 py-3 border-2 border-[#d4b896] rounded-lg focus:border-[#c4a886] focus:outline-none">
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <textarea name="description" id="description" rows="3" placeholder="Add notes about this appointment..."
                            class="w-full px-4 py-3 border-2 border-[#d4b896] rounded-lg focus:border-[#c4a886] focus:outline-none"></textarea>
                    </div>

                    <!-- Date -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Date</label>
                        <input type="date" name="date" id="date" required
                            class="w-full px-4 py-3 border-2 border-[#d4b896] rounded-lg focus:border-[#c4a886] focus:outline-none">
                    </div>

                    <!-- Time Range -->
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Start Time</label>
                            <input type="time" name="start_time" id="start_time" required
                                class="w-full px-4 py-3 border-2 border-[#d4b896] rounded-lg focus:border-[#c4a886] focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">End Time</label>
                            <input type="time" name="end_time" id="end_time" required
                                class="w-full px-4 py-3 border-2 border-[#d4b896] rounded-lg focus:border-[#c4a886] focus:outline-none">
                        </div>
                    </div>

                    <!-- Color Picker -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-3">Color</label>
                        <div class="flex gap-3 flex-wrap">
                            <?php
                                $colors = ['#d4b896', '#ec4899', '#9333ea', '#3b82f6', '#22c55e', '#14b8a6'];
                            ?>
                            <?php $__currentLoopData = $colors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <label class="cursor-pointer">
                                    <input type="radio" name="color" value="<?php echo e($color); ?>" required
                                        class="hidden peer color-radio" <?php echo e($loop->first ? 'checked' : ''); ?>>
                                    <div class="w-12 h-12 rounded-lg border-4 border-transparent peer-checked:border-gray-800 peer-checked:ring-2 peer-checked:ring-gray-400 transition-all hover:scale-110"
                                        style="background-color: <?php echo e($color); ?>"></div>
                                </label>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-3">
                        <button type="button" onclick="closeModal()"
                            class="flex-1 px-6 py-3 border-2 border-[#d4b896] rounded-lg hover:bg-gray-50 transition-colors font-medium">
                            Cancel
                        </button>
                        <button type="button" id="deleteBtn" onclick="deleteAppointment()"
                            class="hidden px-6 py-3 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors font-medium">
                            Delete
                        </button>
                        <button type="submit" id="submitBtn"
                            class="flex-1 px-6 py-3 bg-[#ec4899] text-white rounded-lg hover:bg-[#db2777] transition-colors font-medium">
                            Create
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function showDayAppointments(date, appointments, clickedButton) {
            // Remove all active/today styles from all calendar days and restore original colors
            document.querySelectorAll('.calendar-day').forEach(btn => {
                const btnDate = btn.getAttribute('data-date');
                const hasStyle = btn.style.backgroundColor;

                // Remove temporary selection styles
                btn.classList.remove('ring-2', 'ring-[#d4b896]', 'shadow-md');

                // If button has inline style (has appointments), restore the color text to white
                if (hasStyle && btnDate !== date) {
                    btn.classList.remove('text-gray-800');
                    btn.classList.add('text-white');
                }
            });

            // Add active styling to clicked button
            if (clickedButton) {
                clickedButton.classList.add('ring-2', 'ring-offset-2', 'ring-gray-400', 'shadow-md');
            }

            // Show selected day section
            const selectedDaySection = document.getElementById('selectedDaySection');
            const selectedDayAppointments = document.getElementById('selectedDayAppointments');
            const selectedDateHeader = document.getElementById('selectedDateHeader');

            // Update date header with Indonesian month names
            const dateObj = new Date(date);
            const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
                'Oktober', 'November', 'Desember'
            ];
            const formattedDate =
                `Jadwal tanggal ${dateObj.getDate()} ${months[dateObj.getMonth()]} ${dateObj.getFullYear()}`;
            selectedDateHeader.textContent = formattedDate;

            selectedDaySection.classList.remove('hidden');

            if (appointments.length === 0) {
                selectedDayAppointments.innerHTML = `
                    <div class="bg-white rounded-xl shadow-sm p-6 text-center">
                        <span class="material-symbols-outlined text-4xl text-gray-300 mb-2">event</span>
                        <p class="text-gray-500 text-sm">No appointments for this date</p>
                    </div>
                `;
                return;
            }

            let html = '';
            appointments.forEach(appointment => {
                const startTime = new Date('2000-01-01 ' + appointment.start_time).toLocaleTimeString('en-US', {
                    hour: 'numeric',
                    minute: '2-digit',
                    hour12: true
                });

                const date = new Date(appointment.date);
                const day = date.getDate();

                const appointmentColor = appointment.color || '#d4b896';

                const statusBadge = appointment.status === 'confirmed' ?
                    '<div class="flex-shrink-0 px-2 py-0.5 bg-[#d4b896]/20 text-[#d4b896] text-[10px] font-medium rounded-full">Confirmed</div>' :
                    '<button class="flex-shrink-0 p-1 hover:bg-gray-100 rounded-full transition-colors"><span class="material-symbols-outlined text-gray-400 text-lg">edit</span></button>';

                html += `
                    <div onclick="viewAppointment(${appointment.id})"
                        class="bg-white rounded-xl shadow-sm p-3 hover:shadow-md transition-all cursor-pointer flex items-center gap-3 border-l-4"
                        style="border-left-color: ${appointmentColor};">
                        <div class="flex-shrink-0 w-10 h-10 rounded-full border-2 flex items-center justify-center"
                             style="border-color: ${appointmentColor};">
                            <span class="text-base font-bold" style="color: ${appointmentColor};">${day}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-0.5">
                                <span class="text-xs font-semibold text-gray-800">${startTime}</span>
                                <span class="text-[10px] text-gray-400">${appointment.client ? appointment.client.bride_name : 'No Client'}</span>
                            </div>
                            <h4 class="text-sm font-semibold text-gray-900 mb-0.5">
                                ${appointment.client ? appointment.client.bride_name : 'No Name'}
                            </h4>
                            <p class="text-xs text-gray-600">${appointment.title}</p>
                        </div>
                        ${statusBadge}
                    </div>
                `;
            });

            selectedDayAppointments.innerHTML = html;
        }

        function openNewAppointmentModal() {
            document.getElementById('modalTitle').textContent = 'New Appointment';
            document.getElementById('appointmentForm').action = '<?php echo e(route('appointments.store')); ?>';
            document.getElementById('appointmentForm').reset();
            document.getElementById('appointmentId').value = '';
            document.getElementById('methodField').value = '';
            document.getElementById('submitBtn').textContent = 'Create';
            document.getElementById('deleteBtn').classList.add('hidden');
            document.getElementById('appointmentModal').classList.remove('hidden');
        }

        function viewAppointment(id) {
            fetch(`/appointments/${id}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('modalTitle').textContent = 'Edit Appointment';
                    document.getElementById('appointmentForm').action = `/appointments/${id}`;
                    document.getElementById('methodField').value = 'PUT';
                    document.getElementById('appointmentId').value = id;

                    document.getElementById('client_id').value = data.client_id || '';
                    document.getElementById('title').value = data.title;
                    document.getElementById('description').value = data.description || '';
                    document.getElementById('date').value = data.date;
                    document.getElementById('start_time').value = data.start_time.substring(0, 5);
                    document.getElementById('end_time').value = data.end_time.substring(0, 5);

                    document.querySelectorAll('[name="color"]').forEach(radio => {
                        radio.checked = radio.value === data.color;
                    });

                    document.getElementById('submitBtn').textContent = 'Update';
                    document.getElementById('deleteBtn').classList.remove('hidden');
                    document.getElementById('appointmentModal').classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Error fetching appointment:', error);
                    alert('Gagal memuat data appointment');
                });
        }

        function deleteAppointment() {
            if (!confirm('Apakah Anda yakin ingin menghapus appointment ini?')) {
                return;
            }

            const id = document.getElementById('appointmentId').value;
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/appointments/${id}`;

            const csrfToken = document.querySelector('[name="_token"]').value;
            form.innerHTML = `
                <input type="hidden" name="_token" value="${csrfToken}">
                <input type="hidden" name="_method" value="DELETE">
            `;

            document.body.appendChild(form);
            form.submit();
        }

        function closeModal() {
            document.getElementById('appointmentModal').classList.add('hidden');
        }

        // Close modal on backdrop click
        document.getElementById('appointmentModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Belajar\roro-wedding\resources\views/calendar/index.blade.php ENDPATH**/ ?>
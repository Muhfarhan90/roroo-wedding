@extends('layouts.admin')

@section('title', 'Calendar - ROROO MUA Admin')

@section('content')
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
        @if (session('success'))
            <div id="successAlert" class="fixed top-20 right-4 z-50 animate-fade-in-down">
                <div class="bg-white rounded-lg shadow-lg p-4 border-l-4 border-green-500 flex items-center gap-3">
                    <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                        <span class="material-symbols-outlined text-white text-lg">check</span>
                    </div>
                    <span class="text-sm font-medium text-gray-800">{{ session('success') }}</span>
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
        @endif

        <div class="max-w-7xl mx-auto">
            <!-- Page Header -->
            <div class="mb-6 md:mb-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold mb-2 text-black">Calendar</h1>
                        <p class="text-sm md:text-base text-gray-600">Kelola jadwal dan acara Anda dengan mudah.</p>
                    </div>

                </div>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- Left: Calendar + Selected Day Appointments -->
                <div class="lg:col-span-2 space-y-4">
                    <!-- Calendar Card -->
                    <div class="bg-white rounded-2xl shadow-lg p-5">
                        <!-- Calendar Header -->
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-semibold text-gray-800">
                                {{ $startOfMonth->format('F Y') }}
                            </h2>
                            <div class="flex items-center gap-2">
                                <!-- Total Events Badge -->
                                <div
                                    class="px-3 py-1 bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-lg text-sm font-semibold">
                                    {{ $appointments->flatten()->count() }} Acara
                                </div>
                                <div class="flex items-center gap-1">
                                    <a href="{{ route('calendar.index', ['month' => $startOfMonth->copy()->subMonth()->month, 'year' => $startOfMonth->copy()->subMonth()->year]) }}"
                                        class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                                        <span class="material-symbols-outlined text-gray-600">chevron_left</span>
                                    </a>
                                    <a href="{{ route('calendar.index') }}"
                                        class="px-4 py-2 text-sm border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                                        Today
                                    </a>
                                    <a href="{{ route('calendar.index', ['month' => $startOfMonth->copy()->addMonth()->month, 'year' => $startOfMonth->copy()->addMonth()->year]) }}"
                                        class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                                        <span class="material-symbols-outlined text-gray-600">chevron_right</span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Calendar Grid -->
                        <div class="mb-4">
                            <!-- Day Headers -->
                            <div class="grid grid-cols-7 gap-1 mb-2">
                                @foreach (['SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT'] as $day)
                                    <div
                                        class="text-center text-[10px] font-medium text-gray-400 uppercase tracking-wider py-1">
                                        {{ $day }}
                                    </div>
                                @endforeach
                            </div>

                            <!-- Calendar Days -->
                            @php
                                $currentDate = $startOfMonth->copy()->startOfWeek(\Carbon\Carbon::SUNDAY);
                                $endDate = $endOfMonth->copy()->endOfWeek(\Carbon\Carbon::SATURDAY);
                                $today = \Carbon\Carbon::today();
                            @endphp

                            <div class="grid grid-cols-7 gap-1 sm:gap-2" id="calendarGrid">
                                @while ($currentDate <= $endDate)
                                    @php
                                        $isCurrentMonth = $currentDate->month == $month;
                                        $isToday = $currentDate->isSameDay($today);
                                        $dateKey = $currentDate->format('Y-m-d');
                                        $dayAppointments = $appointments->get($dateKey, collect());
                                        $hasAppointments = $dayAppointments->count() > 0;
                                        // Gunakan warna label asli dari appointment
                                        $appointmentColor = $hasAppointments
                                            ? $dayAppointments->first()->color ?? '#d4b896'
                                            : '';
                                        $firstAppointment = $hasAppointments ? $dayAppointments->first() : null;
                                    @endphp

                                    <div class="relative">
                                        <button
                                            @if ($hasAppointments) onclick="showDayAppointments('{{ $dateKey }}', '{{ $currentDate->format('l, d F Y') }}')" @endif
                                            data-date="{{ $dateKey }}"
                                            data-appointments="{{ $hasAppointments ? $dayAppointments->toJson() : '[]' }}"
                                            class="calendar-day w-full min-h-[80px] sm:min-h-[100px] flex flex-col p-1.5 sm:p-2 border-2 transition-all rounded-lg
                                                {{ $isCurrentMonth ? 'text-gray-800' : 'text-gray-300' }}
                                                {{ $isToday ? 'border-[#d4b896]' : 'border-gray-200' }}
                                                bg-white hover:bg-gray-50 {{ $hasAppointments ? 'cursor-pointer' : '' }}">
                                            <span
                                                class="text-sm sm:text-base font-semibold mb-1 {{ $isToday ? 'text-[#d4b896]' : '' }}">{{ $currentDate->day }}</span>
                                            @if ($hasAppointments)
                                                <div class="space-y-0.5 flex-1 overflow-hidden w-full">
                                                    @php
                                                        $displayCount = 2;
                                                        $totalCount = $dayAppointments->count();
                                                        $remaining = $totalCount - $displayCount;
                                                    @endphp
                                                    @foreach ($dayAppointments->take($displayCount) as $apt)
                                                        <div class="text-[8px] sm:text-[10px] font-medium truncate w-full px-1 py-0.5 rounded"
                                                            style="background-color: {{ $apt->color ?? '#d4b896' }}20; color: {{ $apt->color ?? '#d4b896' }};">
                                                            {{ $apt->client ? $apt->client->client_name : $apt->title }}
                                                        </div>
                                                    @endforeach
                                                    @if ($remaining > 0)
                                                        <div
                                                            class="text-[8px] sm:text-[10px] font-medium w-full px-1 py-0.5 bg-gray-100 rounded text-center text-gray-600">
                                                            dan {{ $remaining }} lainnya
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif
                                        </button>
                                    </div>

                                    @php
                                        $currentDate->addDay();
                                    @endphp
                                @endwhile
                            </div>
                        </div>

                        <!-- Add Appointment Button - DISABLED SEMENTARA -->
                        {{-- <div class="text-center">
                            <button onclick="openNewAppointmentModal()"
                                class="inline-flex items-center gap-1 px-4 py-2 bg-[#d4b896] text-white rounded-full hover:bg-[#c4a886] transition-colors shadow-md text-sm">
                                <span class="material-symbols-outlined text-sm">add</span>
                                <span class="font-medium">New Appointment</span>
                            </button>
                        </div> --}}
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
                            @forelse($upcomingAppointments as $appointment)
                                <div onclick="showAppointmentDetail({{ $appointment->id }})"
                                    class="bg-gray-50 rounded-xl p-3 hover:bg-gray-100 transition-all cursor-pointer flex items-start gap-3 border-l-4"
                                    style="border-left-color: {{ $appointment->color ?? '#d4b896' }};">
                                    <!-- Date Badge - Kotak -->
                                    <div class="flex-shrink-0 w-14 h-14 rounded-lg border-2 flex flex-col items-center justify-center"
                                        style="border-color: {{ $appointment->color ?? '#d4b896' }}; background-color: {{ $appointment->color ?? '#d4b896' }}20;">
                                        <span class="text-xl font-bold leading-tight"
                                            style="color: {{ $appointment->color ?? '#d4b896' }};">{{ $appointment->date->format('d') }}</span>
                                        <span
                                            class="text-[9px] font-medium text-gray-500 uppercase">{{ $appointment->date->format('M') }}</span>
                                    </div>

                                    <!-- Appointment Info -->
                                    <div class="flex-1 min-w-0">
                                        <!-- Time -->
                                        <div class="flex items-center gap-1.5 mb-1">
                                            <span class="material-symbols-outlined text-sm text-gray-400">schedule</span>
                                            <span class="text-xs font-semibold text-gray-800">
                                                {{ date('H:i', strtotime($appointment->start_time)) }} -
                                                {{ date('H:i', strtotime($appointment->end_time)) }} WIB
                                            </span>
                                            <span class="text-[10px] text-gray-400">
                                                {{ $appointment->date->format('D, M d') }}
                                            </span>
                                        </div>

                                        <!-- Title -->
                                        <h4 class="text-sm font-bold text-gray-900 mb-1 leading-tight">
                                            {{ $appointment->title }}
                                        </h4>

                                        <!-- Client Name -->
                                        <div class="flex items-center gap-1.5">
                                            <span class="material-symbols-outlined text-xs text-gray-400">person</span>
                                            <p class="text-xs text-gray-600 truncate">
                                                {{ $appointment->client ? $appointment->client->client_name : 'No Client' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8">
                                    <span class="material-symbols-outlined text-4xl text-gray-300 mb-2">event</span>
                                    <p class="text-gray-500 text-sm">No upcoming appointments</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal List Appointments (First Modal) -->
    <div id="appointmentListModal"
        class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full max-h-[90vh] overflow-y-auto">
            <!-- Modal Header -->
            <div class="sticky top-0 bg-gradient-to-r from-purple-500 to-pink-500 text-white p-5 rounded-t-2xl">
                <h3 class="text-lg font-bold">Jadwal Hari Ini</h3>
                <p class="text-sm opacity-90 mt-1" id="selectedDateText">-</p>
                <p class="text-xs opacity-75 mt-0.5" id="totalEventsText">0 Acara</p>
            </div>

            <!-- Modal Body -->
            <div class="p-4" id="appointmentListContent">
                <!-- List will be populated by JavaScript -->
            </div>

            <!-- Modal Footer -->
            <div class="p-4 bg-gray-50 rounded-b-2xl">
                <button onclick="closeListModal()"
                    class="w-full px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-xl font-medium transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- Appointment Detail Modal (Second Modal) -->
    <div id="appointmentDetailModal"
        class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-[60] flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-md max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <!-- Modal Header -->
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-black" id="detailClientName">Loading...</h3>
                    <button onclick="closeDetailModal()" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <!-- Detail Content -->
                <div class="space-y-4">
                    <!-- Phone Number Wanita -->
                    <div class="flex items-center gap-3 text-sm">
                        <span class="material-symbols-outlined text-gray-400">phone</span>
                        <div>
                            <div class="text-gray-500 text-xs">Nomor HP Mempelai Wanita</div>
                            <a id="detailPhone" href="#" class="text-black font-medium hover:text-[#d4b896]">-</a>
                        </div>
                    </div>

                    <!-- Date & Time -->
                    <div class="flex items-center gap-3 text-sm">
                        <span class="material-symbols-outlined text-gray-400">calendar_today</span>
                        <div>
                            <div class="text-gray-500 text-xs">Tanggal & Waktu</div>
                            <div id="detailDateTime" class="text-black font-medium whitespace-pre-line">-</div>
                        </div>
                    </div>

                    <!-- Total Order -->
                    <div class="flex items-center gap-3 text-sm">
                        <span class="material-symbols-outlined text-gray-400">payments</span>
                        <div>
                            <div class="text-gray-500 text-xs">Total Pesanan</div>
                            <div id="detailTotal" class="text-black font-bold text-lg">-</div>
                        </div>
                    </div>

                    <!-- Location -->
                    <div class="flex items-start gap-3 text-sm">
                        <span class="material-symbols-outlined text-gray-400">location_on</span>
                        <div class="flex-1">
                            <div class="text-gray-500 text-xs">Lokasi Acara</div>
                            <div id="detailLocation" class="text-black font-medium">-</div>
                        </div>
                    </div>

                    <!-- Catatan -->
                    <div class="flex items-start gap-3 text-sm">
                        <span class="material-symbols-outlined text-gray-400">notes</span>
                        <div class="flex-1">
                            <div class="text-gray-500 text-xs">Catatan</div>
                            <div id="detailNotes" class="text-black font-medium whitespace-pre-line">-</div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-6 flex gap-3">
                    <button onclick="closeDetailModal()"
                        class="flex-1 px-6 py-3 border-2 border-gray-300 text-gray-700 text-center rounded-lg hover:bg-gray-50 transition-colors font-medium">
                        Tutup
                    </button>
                    <a id="viewBookingBtn" href="#"
                        class="flex-1 px-6 py-3 bg-[#d4b896] text-white text-center rounded-lg hover:bg-[#c4a886] transition-colors font-medium">
                        View Booking
                    </a>
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
                <form id="appointmentForm" method="POST" action="{{ route('appointments.store') }}">
                    @csrf
                    <input type="hidden" name="_method" id="methodField" value="">
                    <input type="hidden" id="appointmentId" value="">

                    <!-- Client Selection -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Client (Optional)</label>
                        <select name="client_id" id="client_id"
                            class="w-full px-4 py-3 border-2 border-[#d4b896] rounded-lg focus:border-[#c4a886] focus:outline-none">
                            <option value="">Select a client</option>
                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}">{{ $client->client_name }}
                                </option>
                            @endforeach
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
                            @php
                                $colors = ['#d4b896', '#ec4899', '#9333ea', '#3b82f6', '#22c55e', '#14b8a6'];
                            @endphp
                            @foreach ($colors as $color)
                                <label class="cursor-pointer">
                                    <input type="radio" name="color" value="{{ $color }}" required
                                        class="hidden peer color-radio" {{ $loop->first ? 'checked' : '' }}>
                                    <div class="w-12 h-12 rounded-lg border-4 border-transparent peer-checked:border-gray-800 peer-checked:ring-2 peer-checked:ring-gray-400 transition-all hover:scale-110"
                                        style="background-color: {{ $color }}"></div>
                                </label>
                            @endforeach
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
        // All appointments data - flatten from grouped collection
        const allAppointments = [
            @foreach ($appointments as $date => $dayAppts)
                @foreach ($dayAppts as $apt)
                    {
                        id: {{ $apt->id }},
                        date: '{{ $apt->date->format('Y-m-d') }}',
                        title: '{{ addslashes($apt->title) }}',
                        start_time: '{{ $apt->start_time }}',
                        end_time: '{{ $apt->end_time }}',
                        color: '{{ $apt->color ?? '#d4b896' }}',
                        location: '{{ addslashes($apt->location ?? '') }}',
                        description: '{{ addslashes($apt->description ?? '') }}',
                        @if ($apt->client)
                            client: {
                                id: {{ $apt->client->id }},
                                client_name: '{{ addslashes($apt->client->client_name) }}',
                                bride_phone: '{{ $apt->client->bride_phone }}',
                                event_location: '{{ addslashes($apt->client->event_location ?? '') }}'
                            },
                        @endif
                        @if ($apt->order)
                            order: {
                                id: {{ $apt->order->id }},
                                total_amount: {{ $apt->order->total_amount }},
                                notes: '{{ addslashes($apt->order->notes ?? '') }}'
                            }
                        @endif
                    },
                @endforeach
            @endforeach
        ];

        console.log('All appointments loaded:', allAppointments);

        function showDayAppointments(date, formattedDate) {
            const appointments = allAppointments.filter(apt => apt.date === date);

            console.log('Looking for date:', date);
            console.log('Found appointments:', appointments);

            document.getElementById('selectedDateText').textContent = formattedDate;
            document.getElementById('totalEventsText').textContent = `${appointments.length} Acara`;

            if (appointments.length === 0) {
                document.getElementById('appointmentListContent').innerHTML = `
                    <div class="text-center py-8">
                        <span class="material-symbols-outlined text-5xl text-gray-300 mb-3">event</span>
                        <p class="text-gray-500">Tidak ada jadwal untuk hari ini</p>
                    </div>
                `;
            } else {
                let html = '<div class="space-y-2">';
                appointments.forEach(appointment => {
                    // Parse waktu dengan format yang lebih robust
                    let startTimeStr = '00:00';
                    let endTimeStr = '00:00';

                    if (appointment.start_time) {
                        const startParts = appointment.start_time.split(':');
                        startTimeStr = `${startParts[0].padStart(2, '0')}:${startParts[1].padStart(2, '0')}`;
                    }

                    if (appointment.end_time) {
                        const endParts = appointment.end_time.split(':');
                        endTimeStr = `${endParts[0].padStart(2, '0')}:${endParts[1].padStart(2, '0')}`;
                    }

                    const clientName = appointment.client ? appointment.client.client_name : appointment.title;
                    const appointmentColor = appointment.color || '#d4b896'; // Gunakan warna label asli

                    html += `
                        <button
                            onclick="showAppointmentDetail(${appointment.id})"
                            class="w-full text-left p-4 bg-gray-50 hover:bg-gray-100 rounded-xl transition-all border-l-4"
                            style="border-left-color: ${appointmentColor};">
                            <div class="flex items-start justify-between gap-3">
                                <div class="flex-1">
                                    <h4 class="font-bold text-gray-900 text-base mb-1">${clientName}</h4>
                                    <div class="flex items-center gap-2 text-sm text-gray-600">
                                        <span class="material-symbols-outlined text-sm">schedule</span>
                                        <span>${startTimeStr} - ${endTimeStr} WIB</span>
                                    </div>
                                </div>
                                <span class="material-symbols-outlined text-gray-400">chevron_right</span>
                            </div>
                        </button>
                    `;
                });
                html += '</div>';
                document.getElementById('appointmentListContent').innerHTML = html;
            }

            document.getElementById('appointmentListModal').classList.remove('hidden');
        }

        function closeListModal() {
            document.getElementById('appointmentListModal').classList.add('hidden');
        }

        function showAppointmentDetail(appointmentId) {
            // Tutup modal list dan buka modal detail LANGSUNG (tanpa delay)
            document.getElementById('appointmentListModal').classList.add('hidden');
            document.getElementById('appointmentDetailModal').classList.remove('hidden');

            // Set loading state
            document.getElementById('detailClientName').textContent = 'Loading...';
            document.getElementById('detailPhone').textContent = '-';
            document.getElementById('detailDateTime').innerHTML = 'Loading...';
            document.getElementById('detailLocation').textContent = '-';
            document.getElementById('detailTotal').textContent = 'Loading...';
            document.getElementById('detailNotes').textContent = '-';

            // Disable View Booking button while loading
            const viewBookingBtn = document.getElementById('viewBookingBtn');
            viewBookingBtn.href = '#';
            viewBookingBtn.classList.add('opacity-50', 'pointer-events-none', 'cursor-not-allowed');
            viewBookingBtn.classList.remove('cursor-pointer');

            // Fetch data dari API
            fetch(`/appointments/${appointmentId}`)
                .then(response => response.json())
                .then(data => {
                    console.log('Appointment detail data:', data);
                    console.log('Order data:', data.order);
                    console.log('Client data:', data.client);

                    // Update modal content
                    document.getElementById('detailClientName').textContent = data.client ? data.client.client_name :
                        data.title;

                    // Phone number
                    if (data.client && (data.client.bride_phone || data.client.groom_phone)) {
                        const phone = data.client.bride_phone || data.client.groom_phone;
                        document.getElementById('detailPhone').textContent = phone;
                        document.getElementById('detailPhone').href = `https://wa.me/${phone}`;
                    } else {
                        document.getElementById('detailPhone').textContent = '-';
                        document.getElementById('detailPhone').href = '#';
                    }

                    // Date & Time - Fix untuk handle berbagai format waktu
                    const date = new Date(data.date);
                    const dateStr = date.toLocaleDateString('id-ID', {
                        weekday: 'long',
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    });

                    // Parse waktu dengan lebih robust
                    let startTimeStr = '00:00';
                    let endTimeStr = '00:00';

                    if (data.start_time) {
                        // Jika format H:i:s atau H:i
                        const startParts = data.start_time.split(':');
                        startTimeStr = `${startParts[0].padStart(2, '0')}:${startParts[1].padStart(2, '0')}`;
                    }

                    if (data.end_time) {
                        const endParts = data.end_time.split(':');
                        endTimeStr = `${endParts[0].padStart(2, '0')}:${endParts[1].padStart(2, '0')}`;
                    }

                    document.getElementById('detailDateTime').innerHTML =
                        `${dateStr}<br>${startTimeStr} - ${endTimeStr} WIB`;

                    // Location
                    if (data.location) {
                        document.getElementById('detailLocation').textContent = data.location;
                    } else if (data.client && data.client.event_location) {
                        document.getElementById('detailLocation').textContent = data.client.event_location;
                    } else {
                        document.getElementById('detailLocation').textContent = '-';
                    }

                    // Total Order - FIX: Pastikan data.order ada dan handle string/decimal
                    if (data.order && data.order.id) {
                        const totalAmount = parseFloat(data.order.total_amount) || 0;
                        if (totalAmount > 0) {
                            const formatted = new Intl.NumberFormat('id-ID').format(totalAmount);
                            document.getElementById('detailTotal').textContent = `Rp ${formatted}`;
                            console.log('Order found with total:', totalAmount);
                        } else {
                            document.getElementById('detailTotal').textContent = '-';
                            console.log('Order found but total is 0:', data.order.total_amount);
                        }
                    } else {
                        document.getElementById('detailTotal').textContent = '-';
                        console.log('No order found:', data.order);
                    }

                    // Notes/Catatan
                    if (data.description) {
                        document.getElementById('detailNotes').textContent = data.description;
                    } else if (data.order && data.order.notes) {
                        document.getElementById('detailNotes').textContent = data.order.notes;
                    } else {
                        document.getElementById('detailNotes').textContent = '-';
                    }

                    // View Booking Button - Pastikan button disabled/enabled dengan benar
                    const viewBookingBtn = document.getElementById('viewBookingBtn');
                    if (data.order && data.order.id) {
                        viewBookingBtn.href = `/orders/${data.order.id}`;
                        viewBookingBtn.classList.remove('opacity-50', 'pointer-events-none', 'cursor-not-allowed');
                        viewBookingBtn.classList.add('cursor-pointer');
                        console.log('View Booking enabled for order ID:', data.order.id);
                    } else {
                        viewBookingBtn.href = '#';
                        viewBookingBtn.classList.add('opacity-50', 'pointer-events-none', 'cursor-not-allowed');
                        viewBookingBtn.classList.remove('cursor-pointer');
                        console.log('No order found for this appointment');
                    }
                })
                .catch(error => {
                    console.error('Error loading appointment:', error);
                    alert('Gagal memuat detail appointment');
                    document.getElementById('appointmentDetailModal').classList.add('hidden');
                });
        }

        function closeDetailModal() {
            document.getElementById('appointmentDetailModal').classList.add('hidden');
        }

        function openNewAppointmentModal() {
            document.getElementById('modalTitle').textContent = 'New Appointment';
            document.getElementById('appointmentForm').action = '{{ route('appointments.store') }}';
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
@endsection

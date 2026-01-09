@extends('layouts.admin')

@section('title', 'Tambahkan Klien Baru - RORO MUA Admin')

@section('content')
    <div class="min-h-screen bg-gray-50 text-black p-3 sm:p-4 md:p-8">
        <!-- Page Header -->
        <div class="mb-4 sm:mb-6 md:mb-8">
            <div class="flex items-center gap-3 sm:gap-4 mb-3 sm:mb-4">
                <a href="{{ route('clients.index') }}" class="p-1.5 sm:p-2 hover:bg-gray-200 rounded-lg transition-colors">
                    <span class="material-symbols-outlined text-lg sm:text-2xl">arrow_back</span>
                </a>
                <div>
                    <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-black">Tambahkan Klien Baru</h1>
                    <p class="text-xs sm:text-sm md:text-base text-gray-600 mt-1">Isi rincian di bawah ini untuk menambahkan
                        klien baru
                        ke basis data Anda.</p>
                </div>
            </div>
        </div>

        <!-- Form -->
        <form action="{{ route('clients.store') }}" method="POST"
            class="bg-white border-2 border-[#d4b896] rounded-xl p-4 sm:p-6 md:p-8 shadow-lg">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4 md:gap-6">
                <!-- Nama Pengantin -->
                <div class="md:col-span-2">
                    <label for="client_name" class="block text-xs sm:text-sm font-semibold text-black mb-1 sm:mb-2">
                        Nama Pengantin <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="client_name" name="client_name" value="{{ old('client_name') }}"
                        placeholder="e.g., Jane & John Doe" required
                        class="w-full px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base border-2 border-[#d4b896] rounded-lg focus:border-[#c4a886] focus:outline-none transition-colors @error('client_name') border-red-500 @enderror">
                    @error('client_name')
                        <p class="mt-1 text-xs sm:text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nomor HP Pengantin Wanita -->
                <div>
                    <label for="bride_phone" class="block text-xs sm:text-sm font-semibold text-black mb-1 sm:mb-2">
                        Nomor HP Pengantin Wanita <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="bride_phone" name="bride_phone" value="{{ old('bride_phone') }}"
                        placeholder="e.g., 081234567890" required
                        class="w-full px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base border-2 border-[#d4b896] rounded-lg focus:border-[#c4a886] focus:outline-none transition-colors @error('bride_phone') border-red-500 @enderror">
                    @error('bride_phone')
                        <p class="mt-1 text-xs sm:text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nomor HP Pengantin Pria -->
                <div>
                    <label for="groom_phone" class="block text-xs sm:text-sm font-semibold text-black mb-1 sm:mb-2">
                        Nomor HP Pengantin Pria <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="groom_phone" name="groom_phone" value="{{ old('groom_phone') }}"
                        placeholder="e.g., 081234567890" required
                        class="w-full px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base border-2 border-[#d4b896] rounded-lg focus:border-[#c4a886] focus:outline-none transition-colors @error('groom_phone') border-red-500 @enderror">
                    @error('groom_phone')
                        <p class="mt-1 text-xs sm:text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Alamat Pengantin Wanita -->
                <div>
                    <label for="bride_address" class="block text-sm font-semibold text-black mb-2">
                        Alamat Pengantin Wanita
                    </label>
                    <textarea id="bride_address" name="bride_address" rows="3" placeholder="Jl. Contoh Kec.Contoh Kota Contoh"
                        class="w-full px-4 py-3 border-2 border-[#d4b896] rounded-lg focus:border-[#c4a886] focus:outline-none transition-colors resize-none @error('bride_address') border-red-500 @enderror">{{ old('bride_address') }}</textarea>
                    @error('bride_address')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Alamat Pengantin Pria -->
                <div>
                    <label for="groom_address" class="block text-sm font-semibold text-black mb-2">
                        Alamat Pengantin Pria
                    </label>
                    <textarea id="groom_address" name="groom_address" rows="3" placeholder="e.g., 456 Oak Ave, Anytown, USA 12345"
                        class="w-full px-4 py-3 border-2 border-[#d4b896] rounded-lg focus:border-[#c4a886] focus:outline-none transition-colors resize-none @error('groom_address') border-red-500 @enderror">{{ old('groom_address') }}</textarea>
                    @error('groom_address')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nama Orang Tua Pengantin Wanita -->
                <div>
                    <label for="bride_parents" class="block text-sm font-semibold text-black mb-2">
                        Nama Orang Tua Pengantin Wanita
                    </label>
                    <input type="text" id="bride_parents" name="bride_parents" value="{{ old('bride_parents') }}"
                        placeholder="e.g., Mr. & Mrs. Doe"
                        class="w-full px-4 py-3 border-2 border-[#d4b896] rounded-lg focus:border-[#c4a886] focus:outline-none transition-colors @error('bride_parents') border-red-500 @enderror">
                    @error('bride_parents')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nama Orang Tua Pengantin Pria -->
                <div>
                    <label for="groom_parents" class="block text-sm font-semibold text-black mb-2">
                        Nama Orang Tua Pengantin Pria
                    </label>
                    <input type="text" id="groom_parents" name="groom_parents" value="{{ old('groom_parents') }}"
                        placeholder="e.g., Mr. & Mrs. Smith"
                        class="w-full px-4 py-3 border-2 border-[#d4b896] rounded-lg focus:border-[#c4a886] focus:outline-none transition-colors @error('groom_parents') border-red-500 @enderror">
                    @error('groom_parents')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal Akad -->
                <div>
                    <label for="akad_date" class="block text-sm font-semibold text-black mb-2">
                        Tanggal Akad (Opsional)
                    </label>
                    <input type="date" id="akad_date" name="akad_date" value="{{ old('akad_date') }}"
                        class="w-full px-4 py-3 border-2 border-[#d4b896] rounded-lg focus:border-[#c4a886] focus:outline-none transition-colors @error('akad_date') border-red-500 @enderror">
                    @error('akad_date')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jam Akad -->
                <div>
                    <label for="akad_time" class="block text-sm font-semibold text-black mb-2">
                        Jam Akad
                    </label>
                    <input type="time" id="akad_time" name="akad_time" value="{{ old('akad_time') }}"
                        class="w-full px-4 py-3 border-2 border-[#d4b896] rounded-lg focus:border-[#c4a886] focus:outline-none transition-colors @error('akad_time') border-red-500 @enderror">
                    @error('akad_time')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal Resepsi -->
                <div>
                    <label for="reception_date" class="block text-sm font-semibold text-black mb-2">
                        Tanggal Resepsi (Opsional)
                    </label>
                    <input type="date" id="reception_date" name="reception_date" value="{{ old('reception_date') }}"
                        class="w-full px-4 py-3 border-2 border-[#d4b896] rounded-lg focus:border-[#c4a886] focus:outline-none transition-colors @error('reception_date') border-red-500 @enderror">
                    @error('reception_date')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jam Resepsi -->
                <div>
                    <label for="reception_time" class="block text-sm font-semibold text-black mb-2">
                        Jam Resepsi
                    </label>
                    <input type="time" id="reception_time" name="reception_time" value="{{ old('reception_time') }}"
                        class="w-full px-4 py-3 border-2 border-[#d4b896] rounded-lg focus:border-[#c4a886] focus:outline-none transition-colors @error('reception_time') border-red-500 @enderror">
                    @error('reception_time')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jam Kelar Resepsi -->
                <div>
                    <label for="reception_end_time" class="block text-sm font-semibold text-black mb-2">
                        Jam Kelar Resepsi
                    </label>
                    <input type="time" id="reception_end_time" name="reception_end_time"
                        value="{{ old('reception_end_time') }}"
                        class="w-full px-4 py-3 border-2 border-[#d4b896] rounded-lg focus:border-[#c4a886] focus:outline-none transition-colors @error('reception_end_time') border-red-500 @enderror">
                    @error('reception_end_time')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Lokasi Acara - Full Width -->
            <div>
                <label for="event_location" class="block text-xs sm:text-sm font-semibold text-black mb-1 sm:mb-2">
                    Lokasi Acara
                </label>
                <textarea id="event_location" name="event_location" rows="2"
                    placeholder="e.g., Grand Ballroom, 789 Event Plaza, Anytown, USA"
                    class="w-full px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base border-2 border-[#d4b896] rounded-lg focus:border-[#c4a886] focus:outline-none transition-colors resize-none @error('event_location') border-red-500 @enderror">{{ old('event_location') }}</textarea>
                @error('event_location')
                    <p class="mt-1 text-xs sm:text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Form Actions -->
            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 mt-6 sm:mt-8 pt-4 sm:pt-6 border-t-2 border-gray-200">
                <button type="submit"
                    class="flex-1 sm:flex-none px-6 sm:px-8 py-2.5 sm:py-3 text-sm sm:text-base bg-[#d4b896] text-black rounded-lg hover:bg-[#c4a886] transition-colors font-semibold shadow-sm">
                    Simpan Klien
                </button>
                <a href="{{ route('clients.index') }}"
                    class="flex-1 sm:flex-none px-6 sm:px-8 py-2.5 sm:py-3 text-sm sm:text-base bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors font-semibold text-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
@endsection

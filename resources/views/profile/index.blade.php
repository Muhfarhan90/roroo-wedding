@extends('layouts.admin')

@section('title', 'Profile - ROROO MUA Admin')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-[#faf9f7] to-white p-4 sm:p-6">
        <div class="max-w-5xl mx-auto">
            <!-- Header -->
            <div class="mb-6">
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Business Profile</h1>
                <p class="text-gray-600 mt-1">Kelola informasi profil bisnis Anda</p>
            </div>

            <!-- Profile Card -->
            <div class="bg-white rounded-2xl shadow-lg">
                <form action="{{ route('profile.update') }}" method="POST" class="p-6 space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Business Information -->
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                            <span class="material-symbols-outlined text-[#d4b896]">business</span>
                            Informasi Bisnis
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Bisnis</label>
                                <input type="text" name="business_name"
                                    value="{{ old('business_name', $profile->business_name) }}"
                                    class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#d4b896]"
                                    required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Pemilik</label>
                                <input type="text" name="owner_name"
                                    value="{{ old('owner_name', $profile->owner_name) }}"
                                    class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#d4b896]"
                                    required>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                            <span class="material-symbols-outlined text-[#d4b896]">contact_phone</span>
                            Informasi Kontak
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input type="email" name="email" value="{{ old('email', $profile->email) }}"
                                    class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#d4b896]"
                                    required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">No. Telepon</label>
                                <input type="text" name="phone" value="{{ old('phone', $profile->phone) }}"
                                    class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#d4b896]"
                                    required>
                            </div>
                        </div>
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                            <textarea name="address" rows="3"
                                class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#d4b896]"
                                required>{{ old('address', $profile->address) }}</textarea>
                        </div>
                    </div>

                    <!-- Bank Accounts -->
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                                <span class="material-symbols-outlined text-[#d4b896]">account_balance</span>
                                Rekening Bank
                            </h2>
                            <button type="button" onclick="addBankAccount()"
                                class="px-3 py-1 bg-[#d4b896] text-white text-sm rounded-lg hover:bg-[#c4a886] transition-colors flex items-center gap-1">
                                <span class="material-symbols-outlined text-sm">add</span>
                                Tambah
                            </button>
                        </div>
                        <div id="bankAccounts" class="space-y-3">
                            @if ($profile->banks && count($profile->banks) > 0)
                                @foreach ($profile->banks as $index => $bank)
                                    <div class="bank-account bg-gray-50 rounded-lg p-4">
                                        <div class="flex items-start justify-between mb-3">
                                            <span class="text-sm font-medium text-gray-700">Rekening
                                                #{{ $index + 1 }}</span>
                                            <button type="button" onclick="removeBankAccount(this)"
                                                class="text-red-500 hover:text-red-600">
                                                <span class="material-symbols-outlined text-sm">delete</span>
                                            </button>
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                            <div>
                                                <label class="block text-xs font-medium text-gray-600 mb-1">Nama
                                                    Bank</label>
                                                <input type="text" name="banks[{{ $index }}][bank_name]"
                                                    value="{{ old("banks.{$index}.bank_name", $bank['bank_name']) }}"
                                                    class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#d4b896]"
                                                    placeholder="e.g., BCA, Mandiri" required>
                                            </div>
                                            <div>
                                                <label class="block text-xs font-medium text-gray-600 mb-1">No.
                                                    Rekening</label>
                                                <input type="text" name="banks[{{ $index }}][account_number]"
                                                    value="{{ old("banks.{$index}.account_number", $bank['account_number']) }}"
                                                    class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#d4b896]"
                                                    placeholder="1234567890" required>
                                            </div>
                                            <div>
                                                <label class="block text-xs font-medium text-gray-600 mb-1">Atas
                                                    Nama</label>
                                                <input type="text" name="banks[{{ $index }}][account_holder]"
                                                    value="{{ old("banks.{$index}.account_holder", $bank['account_holder']) }}"
                                                    class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#d4b896]"
                                                    placeholder="Nama Pemegang" required>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center py-8 text-gray-400 text-sm">
                                    Belum ada rekening bank. Klik tombol "Tambah" untuk menambahkan.
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Social Media -->
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                                <span class="material-symbols-outlined text-[#d4b896]">share</span>
                                Media Sosial
                            </h2>
                            <button type="button" onclick="addSocialMedia()"
                                class="px-3 py-1 bg-[#d4b896] text-white text-sm rounded-lg hover:bg-[#c4a886] transition-colors flex items-center gap-1">
                                <span class="material-symbols-outlined text-sm">add</span>
                                Tambah
                            </button>
                        </div>
                        <div id="socialMediaList" class="space-y-3">
                            @if ($profile->social_media && count($profile->social_media) > 0)
                                @foreach ($profile->social_media as $index => $social)
                                    <div class="social-media-item bg-gray-50 rounded-lg p-4">
                                        <div class="flex items-start justify-between mb-3">
                                            <span class="text-sm font-medium text-gray-700">Media Sosial
                                                #{{ $index + 1 }}</span>
                                            <button type="button" onclick="removeSocialMedia(this)"
                                                class="text-red-500 hover:text-red-600">
                                                <span class="material-symbols-outlined text-sm">delete</span>
                                            </button>
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                            <div>
                                                <label class="block text-xs font-medium text-gray-600 mb-1">Platform</label>
                                                <select name="social_media[{{ $index }}][platform]"
                                                    class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#d4b896]"
                                                    required>
                                                    <option value="">Pilih Platform</option>
                                                    <option value="Instagram"
                                                        {{ ($social['platform'] ?? '') == 'Instagram' ? 'selected' : '' }}>
                                                        Instagram</option>
                                                    <option value="Facebook"
                                                        {{ ($social['platform'] ?? '') == 'Facebook' ? 'selected' : '' }}>
                                                        Facebook</option>
                                                    <option value="TikTok"
                                                        {{ ($social['platform'] ?? '') == 'TikTok' ? 'selected' : '' }}>
                                                        TikTok</option>
                                                    <option value="YouTube"
                                                        {{ ($social['platform'] ?? '') == 'YouTube' ? 'selected' : '' }}>
                                                        YouTube</option>
                                                    <option value="Twitter"
                                                        {{ ($social['platform'] ?? '') == 'Twitter' ? 'selected' : '' }}>
                                                        Twitter</option>
                                                    <option value="WhatsApp"
                                                        {{ ($social['platform'] ?? '') == 'WhatsApp' ? 'selected' : '' }}>
                                                        WhatsApp</option>
                                                    <option value="Website"
                                                        {{ ($social['platform'] ?? '') == 'Website' ? 'selected' : '' }}>
                                                        Website</option>
                                                    <option value="Lainnya"
                                                        {{ ($social['platform'] ?? '') == 'Lainnya' ? 'selected' : '' }}>
                                                        Lainnya</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label
                                                    class="block text-xs font-medium text-gray-600 mb-1">URL/Username</label>
                                                <input type="text" name="social_media[{{ $index }}][value]"
                                                    value="{{ old("social_media.{$index}.value", $social['value'] ?? '') }}"
                                                    class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#d4b896]"
                                                    placeholder="@username atau https://..." required>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center py-8 text-gray-400 text-sm">
                                    Belum ada media sosial. Klik tombol "Tambah" untuk menambahkan.
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                            <span class="material-symbols-outlined text-[#d4b896]">description</span>
                            Deskripsi Bisnis
                        </h2>
                        <textarea name="description" rows="4"
                            class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#d4b896]"
                            placeholder="Ceritakan tentang bisnis Anda...">{{ old('description', $profile->description) }}</textarea>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end pt-4 border-t border-gray-200">
                        <button type="submit"
                            class="px-6 py-2 bg-[#d4b896] text-white rounded-lg hover:bg-[#c4a886] transition-colors font-medium">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let bankCounter = {{ count($profile->banks ?? []) }};
        let socialMediaCounter = {{ count($profile->social_media ?? []) }};

        function addBankAccount() {
            const container = document.getElementById('bankAccounts');
            const emptyMessage = container.querySelector('.text-center');
            if (emptyMessage) {
                emptyMessage.remove();
            }

            const bankDiv = document.createElement('div');
            bankDiv.className = 'bank-account bg-gray-50 rounded-lg p-4';
            bankDiv.innerHTML = `
                <div class="flex items-start justify-between mb-3">
                    <span class="text-sm font-medium text-gray-700">Rekening #${bankCounter + 1}</span>
                    <button type="button" onclick="removeBankAccount(this)"
                        class="text-red-500 hover:text-red-600">
                        <span class="material-symbols-outlined text-sm">delete</span>
                    </button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Nama Bank</label>
                        <input type="text" name="banks[${bankCounter}][bank_name]"
                            class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#d4b896]"
                            placeholder="e.g., BCA, Mandiri" required>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">No. Rekening</label>
                        <input type="text" name="banks[${bankCounter}][account_number]"
                            class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#d4b896]"
                            placeholder="1234567890" required>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Atas Nama</label>
                        <input type="text" name="banks[${bankCounter}][account_holder]"
                            class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#d4b896]"
                            placeholder="Nama Pemegang" required>
                    </div>
                </div>
            `;
            container.appendChild(bankDiv);
            bankCounter++;
        }

        function removeBankAccount(button) {
            const bankDiv = button.closest('.bank-account');
            bankDiv.remove();

            // Show empty message if no banks left
            const container = document.getElementById('bankAccounts');
            if (container.children.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-8 text-gray-400 text-sm">
                        Belum ada rekening bank. Klik tombol "Tambah" untuk menambahkan.
                    </div>
                `;
            } else {
                // Update numbering
                const banks = container.querySelectorAll('.bank-account');
                banks.forEach((bank, index) => {
                    bank.querySelector('span.text-sm').textContent = `Rekening #${index + 1}`;
                });
            }
        }

        function addSocialMedia() {
            const container = document.getElementById('socialMediaList');
            const emptyMessage = container.querySelector('.text-center');
            if (emptyMessage) {
                emptyMessage.remove();
            }

            const socialDiv = document.createElement('div');
            socialDiv.className = 'social-media-item bg-gray-50 rounded-lg p-4';
            socialDiv.innerHTML = `
                <div class="flex items-start justify-between mb-3">
                    <span class="text-sm font-medium text-gray-700">Media Sosial #${socialMediaCounter + 1}</span>
                    <button type="button" onclick="removeSocialMedia(this)"
                        class="text-red-500 hover:text-red-600">
                        <span class="material-symbols-outlined text-sm">delete</span>
                    </button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Platform</label>
                        <select name="social_media[${socialMediaCounter}][platform]"
                            class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#d4b896]"
                            required>
                            <option value="">Pilih Platform</option>
                            <option value="Instagram">Instagram</option>
                            <option value="Facebook">Facebook</option>
                            <option value="TikTok">TikTok</option>
                            <option value="YouTube">YouTube</option>
                            <option value="Twitter">Twitter</option>
                            <option value="WhatsApp">WhatsApp</option>
                            <option value="Website">Website</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">URL/Username</label>
                        <input type="text" name="social_media[${socialMediaCounter}][value]"
                            class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#d4b896]"
                            placeholder="@username atau https://..." required>
                    </div>
                </div>
            `;
            container.appendChild(socialDiv);
            socialMediaCounter++;
        }

        function removeSocialMedia(button) {
            const socialDiv = button.closest('.social-media-item');
            socialDiv.remove();

            // Show empty message if no social media left
            const container = document.getElementById('socialMediaList');
            if (container.children.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-8 text-gray-400 text-sm">
                        Belum ada media sosial. Klik tombol "Tambah" untuk menambahkan.
                    </div>
                `;
            } else {
                // Update numbering
                const socials = container.querySelectorAll('.social-media-item');
                socials.forEach((social, index) => {
                    social.querySelector('span.text-sm').textContent = `Media Sosial #${index + 1}`;
                });
            }
        }
    </script>
@endsection

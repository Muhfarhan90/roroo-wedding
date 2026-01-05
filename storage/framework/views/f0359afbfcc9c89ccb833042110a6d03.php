<?php $__env->startSection('title', 'Edit Klien - RORO MUA Admin'); ?>

<?php $__env->startSection('content'); ?>
    <div class="min-h-screen bg-gray-50 text-black p-4 sm:p-6 md:p-8">
        <!-- Page Header -->
        <div class="mb-6 md:mb-8">
            <div class="flex items-center gap-4 mb-4">
                <a href="<?php echo e(route('clients.index')); ?>" class="p-2 hover:bg-gray-200 rounded-lg transition-colors">
                    <span class="material-symbols-outlined">arrow_back</span>
                </a>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-black">Edit Klien</h1>
                    <p class="text-sm md:text-base text-gray-600 mt-1">Perbarui informasi klien <?php echo e($client->bride_name); ?> &
                        <?php echo e($client->groom_name); ?></p>
                </div>
            </div>
        </div>

        <!-- Form -->
        <form action="<?php echo e(route('clients.update', $client)); ?>" method="POST"
            class="bg-white border-2 border-[#d4b896] rounded-xl p-6 md:p-8 shadow-lg">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama Pengantin Wanita -->
                <div>
                    <label for="bride_name" class="block text-sm font-semibold text-black mb-2">
                        Nama Pengantin Wanita <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="bride_name" name="bride_name"
                        value="<?php echo e(old('bride_name', $client->bride_name)); ?>" placeholder="e.g., Jane Doe" required
                        class="w-full px-4 py-3 border-2 border-[#d4b896] rounded-lg focus:border-[#c4a886] focus:outline-none transition-colors <?php $__errorArgs = ['bride_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <?php $__errorArgs = ['bride_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-500"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Nama Pengantin Pria -->
                <div>
                    <label for="groom_name" class="block text-sm font-semibold text-black mb-2">
                        Nama Pengantin Pria <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="groom_name" name="groom_name"
                        value="<?php echo e(old('groom_name', $client->groom_name)); ?>" placeholder="e.g., John Smith" required
                        class="w-full px-4 py-3 border-2 border-[#d4b896] rounded-lg focus:border-[#c4a886] focus:outline-none transition-colors <?php $__errorArgs = ['groom_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <?php $__errorArgs = ['groom_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-500"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Nomor HP Pengantin Wanita -->
                <div>
                    <label for="bride_phone" class="block text-sm font-semibold text-black mb-2">
                        Nomor HP Pengantin Wanita <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="bride_phone" name="bride_phone"
                        value="<?php echo e(old('bride_phone', $client->bride_phone)); ?>" placeholder="e.g., 081234567890" required
                        class="w-full px-4 py-3 border-2 border-[#d4b896] rounded-lg focus:border-[#c4a886] focus:outline-none transition-colors <?php $__errorArgs = ['bride_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <?php $__errorArgs = ['bride_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-500"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Nomor HP Pengantin Pria -->
                <div>
                    <label for="groom_phone" class="block text-sm font-semibold text-black mb-2">
                        Nomor HP Pengantin Pria <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="groom_phone" name="groom_phone"
                        value="<?php echo e(old('groom_phone', $client->groom_phone)); ?>" placeholder="e.g., 081234567890" required
                        class="w-full px-4 py-3 border-2 border-[#d4b896] rounded-lg focus:border-[#c4a886] focus:outline-none transition-colors <?php $__errorArgs = ['groom_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <?php $__errorArgs = ['groom_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-500"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Alamat Pengantin Wanita -->
                <div>
                    <label for="bride_address" class="block text-sm font-semibold text-black mb-2">
                        Alamat Pengantin Wanita
                    </label>
                    <textarea id="bride_address" name="bride_address" rows="3" placeholder="Jl. Contoh Kec.Contoh Kota Contoh"
                        class="w-full px-4 py-3 border-2 border-[#d4b896] rounded-lg focus:border-[#c4a886] focus:outline-none transition-colors resize-none <?php $__errorArgs = ['bride_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><?php echo e(old('bride_address', $client->bride_address)); ?></textarea>
                    <?php $__errorArgs = ['bride_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-500"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Alamat Pengantin Pria -->
                <div>
                    <label for="groom_address" class="block text-sm font-semibold text-black mb-2">
                        Alamat Pengantin Pria
                    </label>
                    <textarea id="groom_address" name="groom_address" rows="3" placeholder="e.g., 456 Oak Ave, Anytown, USA 12345"
                        class="w-full px-4 py-3 border-2 border-[#d4b896] rounded-lg focus:border-[#c4a886] focus:outline-none transition-colors resize-none <?php $__errorArgs = ['groom_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><?php echo e(old('groom_address', $client->groom_address)); ?></textarea>
                    <?php $__errorArgs = ['groom_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-500"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Nama Orang Tua Pengantin Wanita -->
                <div>
                    <label for="bride_parents" class="block text-sm font-semibold text-black mb-2">
                        Nama Orang Tua Pengantin Wanita
                    </label>
                    <input type="text" id="bride_parents" name="bride_parents"
                        value="<?php echo e(old('bride_parents', $client->bride_parents)); ?>" placeholder="e.g., Mr. & Mrs. Doe"
                        class="w-full px-4 py-3 border-2 border-[#d4b896] rounded-lg focus:border-[#c4a886] focus:outline-none transition-colors <?php $__errorArgs = ['bride_parents'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <?php $__errorArgs = ['bride_parents'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-500"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Nama Orang Tua Pengantin Pria -->
                <div>
                    <label for="groom_parents" class="block text-sm font-semibold text-black mb-2">
                        Nama Orang Tua Pengantin Pria
                    </label>
                    <input type="text" id="groom_parents" name="groom_parents"
                        value="<?php echo e(old('groom_parents', $client->groom_parents)); ?>" placeholder="e.g., Mr. & Mrs. Smith"
                        class="w-full px-4 py-3 border-2 border-[#d4b896] rounded-lg focus:border-[#c4a886] focus:outline-none transition-colors <?php $__errorArgs = ['groom_parents'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <?php $__errorArgs = ['groom_parents'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-500"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Tanggal Akad -->
                <div>
                    <label for="akad_date" class="block text-sm font-semibold text-black mb-2">
                        Tanggal Akad (Opsional)
                    </label>
                    <input type="date" id="akad_date" name="akad_date"
                        value="<?php echo e(old('akad_date', $client->akad_date?->format('Y-m-d'))); ?>"
                        class="w-full px-4 py-3 border-2 border-[#d4b896] rounded-lg focus:border-[#c4a886] focus:outline-none transition-colors <?php $__errorArgs = ['akad_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <?php $__errorArgs = ['akad_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-500"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Jam Akad -->
                <div>
                    <label for="akad_time" class="block text-sm font-semibold text-black mb-2">
                        Jam Akad
                    </label>
                    <input type="time" id="akad_time" name="akad_time"
                        value="<?php echo e(old('akad_time', $client->akad_time)); ?>"
                        class="w-full px-4 py-3 border-2 border-[#d4b896] rounded-lg focus:border-[#c4a886] focus:outline-none transition-colors <?php $__errorArgs = ['akad_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <?php $__errorArgs = ['akad_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-500"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Jam Kelar Akad -->
                <div>
                    <label for="akad_end_time" class="block text-sm font-semibold text-black mb-2">
                        Jam Kelar Akad
                    </label>
                    <input type="time" id="akad_end_time" name="akad_end_time"
                        value="<?php echo e(old('akad_end_time', $client->akad_end_time)); ?>"
                        class="w-full px-4 py-3 border-2 border-[#d4b896] rounded-lg focus:border-[#c4a886] focus:outline-none transition-colors <?php $__errorArgs = ['akad_end_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <?php $__errorArgs = ['akad_end_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-500"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Tanggal Resepsi -->
                <div>
                    <label for="reception_date" class="block text-sm font-semibold text-black mb-2">
                        Tanggal Resepsi (Opsional)
                    </label>
                    <input type="date" id="reception_date" name="reception_date"
                        value="<?php echo e(old('reception_date', $client->reception_date?->format('Y-m-d'))); ?>"
                        class="w-full px-4 py-3 border-2 border-[#d4b896] rounded-lg focus:border-[#c4a886] focus:outline-none transition-colors <?php $__errorArgs = ['reception_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <?php $__errorArgs = ['reception_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-500"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Jam Resepsi -->
                <div>
                    <label for="reception_time" class="block text-sm font-semibold text-black mb-2">
                        Jam Resepsi
                    </label>
                    <input type="time" id="reception_time" name="reception_time"
                        value="<?php echo e(old('reception_time', $client->reception_time)); ?>"
                        class="w-full px-4 py-3 border-2 border-[#d4b896] rounded-lg focus:border-[#c4a886] focus:outline-none transition-colors <?php $__errorArgs = ['reception_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <?php $__errorArgs = ['reception_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-500"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Jam Kelar Resepsi -->
                <div>
                    <label for="reception_end_time" class="block text-sm font-semibold text-black mb-2">
                        Jam Kelar Resepsi
                    </label>
                    <input type="time" id="reception_end_time" name="reception_end_time"
                        value="<?php echo e(old('reception_end_time', $client->reception_end_time)); ?>"
                        class="w-full px-4 py-3 border-2 border-[#d4b896] rounded-lg focus:border-[#c4a886] focus:outline-none transition-colors <?php $__errorArgs = ['reception_end_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <?php $__errorArgs = ['reception_end_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-500"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <!-- Lokasi Acara - Full Width -->
            <div>
                <label for="event_location" class="block text-sm font-semibold text-black mb-2">
                    Lokasi Acara
                </label>
                <textarea id="event_location" name="event_location" rows="2"
                    placeholder="e.g., Grand Ballroom, 789 Event Plaza, Anytown, USA"
                    class="w-full px-4 py-3 border-2 border-[#d4b896] rounded-lg focus:border-[#c4a886] focus:outline-none transition-colors resize-none <?php $__errorArgs = ['event_location'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><?php echo e(old('event_location', $client->event_location)); ?></textarea>
                <?php $__errorArgs = ['event_location'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-sm text-red-500"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Form Actions -->
            <div class="flex flex-col sm:flex-row gap-4 mt-8 pt-6 border-t-2 border-gray-200">
                <button type="submit"
                    class="flex-1 sm:flex-none px-8 py-3 bg-[#d4b896] text-black rounded-lg hover:bg-[#c4a886] transition-colors font-semibold shadow-sm">
                    Update Klien
                </button>
                <a href="<?php echo e(route('clients.index')); ?>"
                    class="flex-1 sm:flex-none px-8 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors font-semibold text-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Belajar\roro-wedding\resources\views/clients/edit.blade.php ENDPATH**/ ?>
<!DOCTYPE html>
<html lang="en">
<?php echo $__env->make('components.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<body class="bg-gray-50 antialiased">
    <div class="min-h-screen bg-gray-50">
        <!-- Sidebar -->
        <?php echo $__env->make('components.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <!-- Main Content Area -->
        <main class="md:ml-64 lg:ml-72 flex flex-col min-h-screen">
            <!-- Flash Messages -->
            <?php if(session('success')): ?>
                <div class="mx-4 mt-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded">
                    <p class="font-semibold">Berhasil!</p>
                    <p><?php echo e(session('success')); ?></p>
                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="mx-4 mt-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded">
                    <p class="font-semibold">Error!</p>
                    <p><?php echo e(session('error')); ?></p>
                </div>
            <?php endif; ?>

            <?php if($errors->any()): ?>
                <div class="mx-4 mt-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded">
                    <p class="font-semibold">Ada kesalahan:</p>
                    <ul class="list-disc list-inside">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- Content -->
            <div class="flex-1">
                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </main>
    </div>

    <script>
        // Toggle mobile menu
        const menuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        const closeMenuBtn = document.getElementById('close-menu-btn');

        if (menuBtn && mobileMenu && closeMenuBtn) {
            menuBtn.addEventListener('click', () => {
                mobileMenu.classList.remove('translate-x-full');
            });

            closeMenuBtn.addEventListener('click', () => {
                mobileMenu.classList.add('translate-x-full');
            });
        }
    </script>
</body>

</html>
<?php /**PATH D:\Belajar\roro-wedding\resources\views/layouts/admin.blade.php ENDPATH**/ ?>
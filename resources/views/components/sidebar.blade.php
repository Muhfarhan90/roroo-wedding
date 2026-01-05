<!-- Desktop Sidebar -->
<aside
    class="hidden md:flex md:w-64 lg:w-72 bg-white border-r border-[#d4b896] flex-col shadow-lg fixed left-0 top-0 h-screen z-30">
    <!-- Brand -->
    <div class="p-6 border-b border-[#d4b896] text-center">
        <img src="{{ asset('logo/logo-roroo-wedding.PNG') }}" alt="ROROO MUA Logo"
            class="w-20 h-20 mx-auto mb-2 rounded-full border-4 border-[#d4b896] object-cover">
        <h1 class="text-[#d4b896] text-xl font-bold tracking-wider">ROROO</h1>
        <p class="text-gray-500 text-[10px] uppercase tracking-widest mt-0.5">Wedding Make Up</p>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
        <a href="/dashboard"
            class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->is('dashboard') ? 'text-[#d4b896] border-l-4 border-[#d4b896] bg-[#d4b896]/5' : 'text-[#8b6f47] hover:bg-gray-50 hover:text-[#d4b896]' }}">
            <span class="material-symbols-outlined text-xl">dashboard</span>
            <span class="font-medium">Dashboard</span>
        </a>

        <a href="/clients"
            class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->is('clients*') ? 'text-[#d4b896] border-l-4 border-[#d4b896] bg-[#d4b896]/5' : 'text-[#8b6f47] hover:bg-gray-50 hover:text-[#d4b896]' }}">
            <span class="material-symbols-outlined text-xl">groups</span>
            <span class="font-medium">Clients</span>
        </a>

        <a href="/orders"
            class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->is('orders') && !request()->is('orders-timeline') ? 'text-[#d4b896] border-l-4 border-[#d4b896] bg-[#d4b896]/5' : 'text-[#8b6f47] hover:bg-gray-50 hover:text-[#d4b896]' }}">
            <span class="material-symbols-outlined text-xl">shopping_bag</span>
            <span class="font-medium">Orders</span>
        </a>

        <a href="/orders-timeline"
            class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->is('orders-timeline*') ? 'text-[#d4b896] border-l-4 border-[#d4b896] bg-[#d4b896]/5' : 'text-[#8b6f47] hover:bg-gray-50 hover:text-[#d4b896]' }}">
            <span class="material-symbols-outlined text-xl">show_chart</span>
            <span class="font-medium">Timeline Acara</span>
        </a>

        <a href="/invoices"
            class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->is('invoices*') ? 'text-[#d4b896] border-l-4 border-[#d4b896] bg-[#d4b896]/5' : 'text-[#8b6f47] hover:bg-gray-50 hover:text-[#d4b896]' }}">
            <span class="material-symbols-outlined text-xl">receipt_long</span>
            <span class="font-medium">Invoice</span>
        </a>

        <a href="/calendar"
            class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->is('calendar*') ? 'text-[#d4b896] border-l-4 border-[#d4b896] bg-[#d4b896]/5' : 'text-[#8b6f47] hover:bg-gray-50 hover:text-[#d4b896]' }}">
            <span class="material-symbols-outlined text-xl">calendar_month</span>
            <span class="font-medium">Calendar</span>
        </a>

        <a href="/profile"
            class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->is('profile*') ? 'text-[#d4b896] border-l-4 border-[#d4b896] bg-[#d4b896]/5' : 'text-[#8b6f47] hover:bg-gray-50 hover:text-[#d4b896]' }}">
            <span class="material-symbols-outlined text-xl">account_circle</span>
            <span class="font-medium">Profile</span>
        </a>
    </nav>

    <!-- Logout Button -->
    <div class="p-4 border-t border-[#d4b896]">
        <form method="POST" action="{{ route('logout') ?? '#' }}">
            @csrf
            <button type="submit"
                class="flex items-center gap-3 px-4 py-3 rounded-lg text-[#8b6f47] hover:bg-gray-50 hover:text-[#d4b896] transition-colors w-full">
                <span class="material-symbols-outlined text-xl">logout</span>
                <span class="font-medium">Log Out</span>
            </button>
        </form>
    </div>
</aside>

<!-- Mobile Header -->
<header class="md:hidden bg-white border-b border-[#d4b896] px-4 py-3 sticky top-0 z-40 shadow-sm">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-2">
            <img src="{{ asset('logo/logo-roroo-wedding.PNG') }}" alt="ROROO MUA Logo"
                class="w-10 h-10 rounded-full border-2 border-[#d4b896] object-cover">
            <div>
                <h1 class="text-[#d4b896] text-base font-bold tracking-wider">ROROO</h1>
                <p class="text-gray-500 text-[8px] uppercase tracking-widest">Wedding Make Up</p>
            </div>
        </div>
        <button id="mobile-menu-btn" class="p-2 text-gray-600 hover:text-black transition-colors">
            <span class="material-symbols-outlined text-2xl">menu</span>
        </button>
    </div>
</header>

<!-- Mobile Sidebar -->
<div id="mobile-menu"
    class="md:hidden fixed top-0 right-0 h-full w-80 bg-white border-l border-[#d4b896] z-50 transform transition-transform duration-300 shadow-xl translate-x-full">
    <div class="flex flex-col h-full">
        <!-- Header with close button -->
        <div class="p-6 border-b border-[#d4b896] flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="inline-flex items-center justify-center w-10 h-10 border-2 border-[#d4b896] rounded-full">
                    <span class="text-base font-serif text-[#d4b896]">m</span>
                </div>
                <div>
                    <h2 class="text-[#d4b896] text-base font-bold tracking-wider">ROROO</h2>
                    <p class="text-gray-500 text-[8px] uppercase tracking-widest">Wedding Make Up</p>
                </div>
            </div>
            <button id="close-menu-btn" class="p-2 text-gray-600 hover:text-black transition-colors">
                <span class="material-symbols-outlined text-2xl">close</span>
            </button>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
            <a href="/dashboard"
                class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->is('dashboard') ? 'text-[#d4b896] border-l-4 border-[#d4b896] bg-[#d4b896]/5' : 'text-[#8b6f47] hover:bg-gray-50 hover:text-[#d4b896]' }}">
                <span class="material-symbols-outlined text-xl">dashboard</span>
                <span class="font-medium">Dashboard</span>
            </a>

            <a href="/clients"
                class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->is('clients*') ? 'text-[#d4b896] border-l-4 border-[#d4b896] bg-[#d4b896]/5' : 'text-[#8b6f47] hover:bg-gray-50 hover:text-[#d4b896]' }}">
                <span class="material-symbols-outlined text-xl">groups</span>
                <span class="font-medium">Clients</span>
            </a>

            <a href="/orders"
                class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->is('orders') && !request()->is('orders-timeline') ? 'text-[#d4b896] border-l-4 border-[#d4b896] bg-[#d4b896]/5' : 'text-[#8b6f47] hover:bg-gray-50 hover:text-[#d4b896]' }}">
                <span class="material-symbols-outlined text-xl">shopping_bag</span>
                <span class="font-medium">Orders</span>
            </a>

            <a href="/orders-timeline"
                class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->is('orders-timeline*') ? 'text-[#d4b896] border-l-4 border-[#d4b896] bg-[#d4b896]/5' : 'text-[#8b6f47] hover:bg-gray-50 hover:text-[#d4b896]' }}">
                <span class="material-symbols-outlined text-xl">show_chart</span>
                <span class="font-medium">Timeline Acara</span>
            </a>

            <a href="/invoices"
                class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->is('invoices*') ? 'text-[#d4b896] border-l-4 border-[#d4b896] bg-[#d4b896]/5' : 'text-[#8b6f47] hover:bg-gray-50 hover:text-[#d4b896]' }}">
                <span class="material-symbols-outlined text-xl">receipt_long</span>
                <span class="font-medium">Invoice</span>
            </a>

            <a href="/calendar"
                class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->is('calendar*') ? 'text-[#d4b896] border-l-4 border-[#d4b896] bg-[#d4b896]/5' : 'text-[#8b6f47] hover:bg-gray-50 hover:text-[#d4b896]' }}">
                <span class="material-symbols-outlined text-xl">calendar_month</span>
                <span class="font-medium">Calendar</span>
            </a>

            <a href="/profile"
                class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->is('profile*') ? 'text-[#d4b896] border-l-4 border-[#d4b896] bg-[#d4b896]/5' : 'text-[#8b6f47] hover:bg-gray-50 hover:text-[#d4b896]' }}">
                <span class="material-symbols-outlined text-xl">account_circle</span>
                <span class="font-medium">Profile</span>
            </a>
        </nav>

        <!-- Logout Button -->
        <div class="p-4 border-t border-[#d4b896]">
            <form method="POST" action="{{ route('logout') ?? '#' }}">
                @csrf
                <button type="submit"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg text-[#8b6f47] hover:bg-gray-50 hover:text-[#d4b896] transition-colors w-full">
                    <span class="material-symbols-outlined text-xl">logout</span>
                    <span class="font-medium">Log Out</span>
                </button>
            </form>
        </div>
    </div>
</div>

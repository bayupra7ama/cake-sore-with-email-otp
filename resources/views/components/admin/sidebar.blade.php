{{-- OVERLAY MOBILE --}}
<div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black bg-opacity-40 z-40 md:hidden"
    x-transition>
</div>

{{-- SIDEBAR --}}
<aside
    class="fixed md:static inset-y-0 left-0 z-50 w-64 bg-white shadow
           transform md:transform-none
           transition-transform duration-200
           -translate-x-full md:translate-x-0"
    :class="{ 'translate-x-0': sidebarOpen }">

    <div class="p-6 font-bold text-lg border-b">
        Raninsha Kitchen Admin
    </div>

    <nav class="p-4 space-y-2">
        <a href="{{ route('admin.dashboard') }}"
            class="block px-3 py-2 rounded
            {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
            Dashboard
        </a>

        <a href="{{ route('admin.categories.index') }}"
            class="block px-3 py-2 rounded
            {{ request()->routeIs('admin.categories.*') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
            Category
        </a>

        <a href="{{ route('admin.products.index') }}"
            class="block px-3 py-2 rounded
            {{ request()->routeIs('admin.products.*') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
            Produk
        </a>

        <a href="{{ route('admin.orders.index') }}"
            class="block px-3 py-2 rounded
            {{ request()->routeIs('admin.orders.*') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
            Pesanan
        </a>
    </nav>
</aside>

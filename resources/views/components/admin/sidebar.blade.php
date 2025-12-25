<aside class="w-64 bg-white shadow hidden md:block">
    <div class="p-6 font-bold text-lg border-b">
        Ranisya Admin
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


        <a href="#" class="block px-3 py-2 rounded text-gray-700 hover:bg-gray-100">
            Pesanan
        </a>

        <a href="#" class="block px-3 py-2 rounded text-gray-700 hover:bg-gray-100">
            Pembayaran
        </a>
    </nav>
</aside>

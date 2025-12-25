<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

    <div class="flex min-h-screen">

        {{-- SIDEBAR --}}
        @include('components.admin.sidebar')

        {{-- MAIN CONTENT --}}
        <div class="flex-1 flex flex-col">

            {{-- TOP BAR --}}
            <header class="bg-white shadow px-6 py-4 flex justify-between items-center">
                <h1 class="text-lg font-semibold">
                    @yield('title', 'Dashboard')
                </h1>

                <div class="flex items-center gap-4">
                    <span class="text-sm text-gray-600">
                        {{ auth()->user()->name }}
                    </span>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="text-red-600 text-sm hover:underline">
                            Logout
                        </button>
                    </form>
                </div>
            </header>

            {{-- PAGE CONTENT --}}
            <main class="p-6 flex-1 w-full">
                @yield('content')
            </main>


        </div>
    </div>

</body>

</html>

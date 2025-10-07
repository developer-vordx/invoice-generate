<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('app.name', 'ReconX'))</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3B82F6',
                        sidebar: '#1e293b',
                        'sidebar-hover': '#334155'
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gray-50 font-sans">
<div class="flex h-screen overflow-hidden">
    {{-- Sidebar --}}
    @include('layouts.auth.sidebar')

    {{-- Main Content --}}
    <div class="flex-1 flex flex-col overflow-hidden">
        {{-- Navbar --}}
        @include('layouts.auth.navbar')

        {{-- Page Content --}}
        <main class="flex-1 overflow-y-auto p-8">
            @yield('content')
        </main>

        {{-- Footer --}}
        @include('layouts.auth.footer')
    </div>
</div>
</body>
</html>

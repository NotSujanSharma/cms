<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CMS')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] {
            display: none !important;
        }
        select{
            height:35px;
            padding-left:10px !important;
        }
    </style>
    @yield('extra_head', '')
</head>
<body class="bg-purple-100 p-4">
    <div class="max-w-7xl mx-auto bg-white rounded-3xl h-[95vh] flex overflow-hidden shadow-xl">
        <!-- Sidebar -->
        <div class="w-64 flex-shrink-0 bg-[#262626] p-5 text-white">
            <h1 class="text-2xl font-bold mb-8">NCT Club</h1>
            <nav class="space-y-6">
                <a href="{{ route('admin.dashboard') }}" id="admin_dashboard" class="flex items-center space-x-3 p-3">
                    <i class="fas fa-home"></i>
                    <span>Admin</span>
                </a>
                <form method="POST" action="{{ route('logout') }}" class="flex items-center space-x-3 py-3">
                    @csrf
                    <i class="fas fa-sign-out-alt"></i>
                    <button type="submit">Logout</button>
                </form>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex overflow-auto w-full p-5">
            @yield('content')
        </div>
    </div>

    <script>
        // Add a highlight effect to the current page link
        document.getElementById('{{$page}}').classList.add('bg-white', 'text-[#262626]', 'rounded-xl');
    </script>
</body>
</html>

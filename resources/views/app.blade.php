<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Management System</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen font-sans text-gray-800">
    <header class="bg-blue-600 text-white p-4">
        <div class="max-w-6xl mx-auto">
            <h1 class="text-xl font-bold">My Document Management System</h1>
        </div>
    </header>

    <main class="max-w-6xl mx-auto p-4">
        @yield('content')
    </main>

    <footer class="bg-gray-100 text-gray-600 text-sm p-4 mt-8 text-center">
        &copy; {{ date('Y') }} Document Management System
    </footer>
</body>
</html>

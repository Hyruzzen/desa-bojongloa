<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - E-Arsip Desa Bojongloa</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-blue-700 to-blue-900 min-h-screen flex items-center justify-center px-4 font-sans antialiased">
    <div class="w-full max-w-md">
        <div class="text-center mb-6 text-white">
            <div class="text-4xl mb-2">🗂️</div>
            <h1 class="text-2xl font-bold">E-Arsip Desa Bojongloa</h1>
            <p class="text-blue-100 text-sm mt-1">Sistem Pengelolaan Arsip Kantor Desa</p>
        </div>

        <div class="bg-white rounded-2xl shadow-xl p-8">
            @if ($errors->any())
                <div class="mb-4 rounded-lg bg-red-50 border border-red-200 text-red-700 px-4 py-3 text-sm">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Password</label>
                    <input type="password" name="password" required
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <label class="flex items-center gap-2 text-sm text-slate-600">
                    <input type="checkbox" name="remember" class="rounded border-slate-300">
                    Ingat saya
                </label>
                <button type="submit"
                    class="w-full bg-blue-700 hover:bg-blue-800 text-white font-medium rounded-lg px-4 py-2.5 text-sm transition">
                    Masuk
                </button>
            </form>
        </div>
        <p class="text-center text-blue-100 text-xs mt-6">&copy; {{ date('Y') }} Kantor Desa Bojongloa</p>
    </div>
</body>
</html>

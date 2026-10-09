<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIMANDIK-SMP</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 dark:bg-gray-900">
    <main class="flex min-h-screen items-center justify-center p-4">
        <div class="w-full max-w-sm">

            <div class="mb-6 text-center">
                <span
                    class="mx-auto mb-3 inline-flex h-12 w-12 items-center justify-center rounded-xl border border-gray-300 text-2xl text-gray-800 dark:border-gray-600 dark:text-gray-100">
                    <i class="bi bi-building"></i>
                </span>
                <h1 class="text-xl font-bold text-gray-800 dark:text-gray-100">SIMANDIK-SMP</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">Silakan login untuk melanjutkan</p>
            </div>

            <x-card>
                <form action="{{ route('login.store') }}" method="POST" class="flex flex-col gap-4">
                    @csrf

                    <x-form.input name="email" label="Email" type="email" placeholder="nama@email.com" required />
                    <x-form.input name="password" label="Password" type="password" required />
                    <x-form.checkbox name="remember" label="Ingat saya" />

                    <x-button type="submit" class="w-full">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Login
                    </x-button>
                </form>
            </x-card>

            <p class="mt-6 text-center text-xs text-gray-400 dark:text-gray-600">
                &copy; {{ date('Y') }} SIMANDIK-SMP
            </p>
        </div>
    </main>
</body>

</html>

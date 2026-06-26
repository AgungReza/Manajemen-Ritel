<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Akses Ditolak</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-950 text-slate-100">

    <main class="relative flex min-h-screen items-center justify-center overflow-hidden px-6 py-12">

        {{-- Efek latar belakang --}}
        <div class="absolute -left-32 -top-32 h-80 w-80 rounded-full bg-indigo-600/30 blur-3xl"></div>

        <div class="absolute -bottom-32 -right-32 h-80 w-80 rounded-full bg-red-600/30 blur-3xl"></div>

        <section
            class="relative w-full max-w-lg overflow-hidden rounded-3xl border border-white/10 bg-white/5 p-8 text-center shadow-2xl backdrop-blur-xl sm:p-10"
        >
            {{-- Ikon peringatan --}}
            <div
                class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-red-500/15 ring-1 ring-red-400/30"
            >
                <svg
                    class="h-10 w-10 text-red-400"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    aria-hidden="true"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.8"
                        d="M12 9v4m0 4h.01M10.3 3.9 2.5 17.4A2 2 0 0 0 4.2 20h15.6a2 2 0 0 0 1.7-2.6L13.7 3.9a2 2 0 0 0-3.4 0Z"
                    />
                </svg>
            </div>

            <p class="mt-6 text-sm font-semibold uppercase tracking-[0.25em] text-red-400">
                403 Unauthorized
            </p>

            <h1 class="mt-3 text-3xl font-bold tracking-tight text-white sm:text-4xl">
                Akses ditolak
            </h1>

            <p class="mx-auto mt-4 max-w-md leading-7 text-slate-300">
                Akun Anda tidak memiliki izin untuk membuka halaman khusus
                administrator.
            </p>

            {{-- Countdown --}}
            <div
                id="countdown-container"
                data-seconds="{{ (int) ($countdown ?? 5) }}"
                data-redirect="{{ $redirectUrl }}"
                class="mt-8 rounded-2xl border border-indigo-400/20 bg-slate-900/80 px-5 py-6 shadow-inner"
            >
                <p class="text-sm font-medium text-slate-300">
                    Kembali ke dashboard dalam
                </p>

                <div
                    class="mx-auto mt-4 flex h-28 w-28 items-center justify-center rounded-full border-4 border-indigo-400 bg-indigo-500/20 shadow-lg shadow-indigo-500/30"
                >
                    <span
                        id="countdown"
                        class="block text-6xl font-black leading-none text-white"
                    >
                        {{ (int) ($countdown ?? 5) }}
                    </span>
                </div>

                <p class="mt-3 text-sm font-medium text-slate-300">
                    detik
                </p>
            </div>

            {{-- Tombol kembali --}}
            <a
                href="{{ $redirectUrl }}"
                class="mt-8 inline-flex w-full items-center justify-center rounded-xl bg-indigo-500 px-5 py-3.5 text-sm font-semibold text-white shadow-lg shadow-indigo-500/20 transition duration-200 hover:-translate-y-0.5 hover:bg-indigo-400 focus:outline-none focus:ring-4 focus:ring-indigo-500/30"
            >
                Kembali ke Dashboard
            </a>
        </section>

    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const container = document.getElementById('countdown-container');
            const countdownElement = document.getElementById('countdown');

            let remainingSeconds = parseInt(
                container.dataset.seconds,
                10
            );

            const redirectUrl = container.dataset.redirect;

            countdownElement.textContent = remainingSeconds;

            const timer = window.setInterval(function () {
                remainingSeconds -= 1;

                countdownElement.textContent = remainingSeconds;

                if (remainingSeconds <= 0) {
                    window.clearInterval(timer);
                    window.location.replace(redirectUrl);
                }
            }, 1000);
        });
    </script>

</body>
</html>

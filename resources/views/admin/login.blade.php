<!DOCTYPE html>
<html lang="ms">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Masuk Portal Pentadbir e-Aduan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-900 flex items-center justify-center h-screen font-sans">

    <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-xl space-y-6">

        <div class="flex flex-col items-center justify-center text-center">

            <div class="flex items-center justify-center gap-5 mb-4">

                <div class="p-2.5 bg-slate-900 border border-slate-800 rounded-xl shadow-sm flex items-center justify-center">
                    <svg class="w-8 h-8 text-amber-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>

                <img src="/build/assets/upsi.png" alt="Logo UPSI" class="w-32 h-16 object-contain">
            </div>

            <div class="space-y-1 mb-2">
                <h1 class="text-3xl font-black text-slate-800 tracking-tight uppercase">
                    e-Aduan
                </h1>
                <span class="text-amber-500 text-xs font-black tracking-widest uppercase block">
                    KSAS Admin Portal
                </span>
            </div>

            <p class="text-[10px] text-gray-400 uppercase font-semibold tracking-wider border-t border-gray-100 pt-2 w-full mt-2">
                Universiti Pendidikan Sultan Idris
            </p>
        </div>

        @if(session('error'))
        <div class="p-3 bg-red-100 border border-red-200 text-red-700 text-xs font-semibold rounded flex items-center gap-1">
            <span>⚠️</span>
            <div>{{ session('error') }}</div>
        </div>
        @endif
        @if(session('success'))
        <div class="p-3 bg-green-100 border border-green-200 text-green-700 text-xs font-semibold rounded flex items-center gap-1">
            <span>✅</span>
            <div>{{ session('success') }}</div>
        </div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase">Nama Pengguna</label>
                <input type="text" name="username" value="{{ old('username') }}" required
                    class="mt-1 block w-full p-2.5 border border-gray-300 rounded text-sm bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Masukkan nama pengguna">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase">Kata Laluan</label>
                <div class="relative mt-1">
                    <input type="password" id="password_input" name="password" required
                        class="block w-full p-2.5 pr-10 border border-gray-300 rounded text-sm bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Masukkan kata laluan">

                    <button type="button" onclick="togglePasswordVisibility()"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-slate-600 focus:outline-none">
                        <svg id="eye_icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                    </button>
                </div>
            </div>

            <button type="submit" class="w-full bg-slate-800 text-white font-bold p-3 text-sm rounded shadow hover:bg-slate-700 transition flex items-center justify-center gap-2">
                🔑 Log Masuk ke Sistem
            </button>
        </form>
    </div>

    <script>
        function togglePasswordVisibility() {
            const passwordField = document.getElementById('password_input');
            const eyeIcon = document.getElementById('eye_icon');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                `;
            } else {
                passwordField.type = 'password';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                `;
            }
        }
    </script>

</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="min-h-screen bg-gray-100 py-6 flex flex-col justify-center sm:py-12">
    <div class="relative py-3 sm:max-w-xl sm:mx-auto">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-300 to-blue-600 shadow-lg transform -skew-y-6 sm:skew-y-0 sm:-rotate-6 sm:rounded-3xl"></div>
        <div class="relative px-4 py-10 bg-white shadow-lg sm:rounded-3xl sm:p-20">
            <div class="max-w-md mx-auto">
                <h1 class="text-2xl font-semibold">Iniciar Sesión</h1>
                <div class="divide-y divide-gray-200">
                    <form action="{{ route('login') }}" method="POST" class="py-8 text-base leading-6 space-y-4 text-gray-700 sm:text-lg sm:leading-7">
                        @csrf
                        <div class="relative">
                            <input type="email" id="email" name="email" class="peer placeholder-transparent h-10 w-full border-b-2 border-gray-300 text-gray-900 focus:outline-none focus:border-rose-600" placeholder="Correo Electrónico" required autofocus>
                            <label for="email" class="absolute left-0 -top-3.5 text-gray-600 text-sm peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-440 peer-placeholder-shown:top-2 transition-all peer-focus:-top-3.5 peer-focus:text-gray-600 peer-focus:text-sm">Correo Electrónico</label>
                        </div>
                        <div class="relative">
                            <input type="password" id="password" name="password" class="peer placeholder-transparent h-10 w-full border-b-2 border-gray-300 text-gray-900 focus:outline-none focus:border-rose-600" placeholder="Contraseña" required autocomplete="current-password">
                            <label for="password" class="absolute left-0 -top-3.5 text-gray-600 text-sm peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-440 peer-placeholder-shown:top-2 transition-all peer-focus:-top-3.5 peer-focus:text-gray-600 peer-focus:text-sm">Contraseña</label>
                        </div>
                        <div class="relative">
                            <button type="submit" class="bg-blue-500 text-white rounded-md px-2 py-1 w-full">Iniciar Sesión</button>
                        </div>
                    </form>
                    <div class="mt-4 text-sm">
                        ¿No tienes una cuenta? <a href="{{ route('register') }}" class="text-blue-500 hover:text-blue-600">Regístrate aquí</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

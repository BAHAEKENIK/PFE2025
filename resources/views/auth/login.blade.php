<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign In - {{ config('app.name', 'Laravel') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Add custom styles if needed, e.g., for the specific purple color */
        .bg-custom-purple { background-color: #6C63FF; } /* Example color */
        .text-custom-purple { color: #6C63FF; }
        .border-custom-purple { border-color: #6C63FF; }
        .placeholder-gray-500::placeholder { color: #A0AEC0; }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
</head>
<body class="bg-gray-100">

    <div class="flex min-h-screen">
        <div class="w-full lg:w-1/2 flex flex-col justify-center items-center p-8 md:p-12 lg:p-16 bg-white relative">
            <div class="absolute top-6 left-6">
                <a  class="bg-gray-200 text-gray-700 text-sm font-medium py-1 px-3 rounded hover:bg-gray-300 transition duration-150">
                    Back
                </a>
            </div>

            <div class="w-full max-w-md">
                <h2 class="text-3xl font-bold text-center mb-8 text-gray-800">Sign in</h2>

                @if ($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">Oops!</strong>
                        <span class="block sm:inline">{{ $errors->first() }}</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('login.post') }}">
                    @csrf <div class="mb-5">
                        <label for="email" class="block text-sm font-medium text-gray-600 mb-1">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                               placeholder="example.email@gmail.com"
                               class="w-full px-4 py-3 bg-gray-100 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-custom-purple focus:border-transparent placeholder-gray-500 @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5 relative">
                        <label for="password" class="block text-sm font-medium text-gray-600 mb-1">Password</label>
                        <input type="password" id="password" name="password" required autocomplete="current-password"
                               placeholder="Enter at least 8+ characters"
                               class="w-full px-4 py-3 bg-gray-100 border border-gray-200 rounded-md focus:outline-none focus:ring-2 focus:ring-custom-purple focus:border-transparent placeholder-gray-500 @error('password') border-red-500 @enderror">
                        <button type="button" onclick="togglePasswordVisibility()" class="absolute inset-y-0 right-0 top-7 px-3 flex items-center text-gray-500 hover:text-gray-700">
                           <i class="fas fa-eye" id="eye-icon"></i>
                           </button>
                         @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center">
                            <input id="remember_me" type="checkbox" name="remember"
                                   class="h-4 w-4 text-custom-purple focus:ring-custom-purple border-gray-300 rounded">
                            <label for="remember_me" class="ml-2 block text-sm text-gray-700">
                                Remember me
                            </label>
                        </div>
                        <div>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-sm text-custom-purple hover:underline">
                                    Forgot password?
                                </a>
                            @endif
                        </div>
                    </div>

                    <div>
                        <button type="submit"
                                class="w-full bg-custom-purple text-white font-semibold py-3 px-4 rounded-md hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-custom-purple transition duration-150">
                            Sign in
                        </button>
                    </div>
                </form>

                 {{-- <p class="mt-8 text-center text-sm text-gray-600">
                     Don't have an account?
                     <a href="{{ route('register') }}" class="font-medium text-custom-purple hover:underline">
                         Sign up
                     </a>
                 </p> --}}
            </div>
        </div>

        <div class="hidden lg:flex w-1/2 bg-custom-purple items-center justify-center p-12">
            <img src="{{ asset('images/illustration.png') }}" alt="Illustration" class="max-w-full h-auto">
            {{-- Example using an inline SVG or placeholder --}}
            {{-- <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg" class="w-3/4 h-auto">
                <path fill="#FFFFFF" d="M40.1,-58.3C53.1,-50.5,65.6,-42.1,72.9,-30.3C80.2,-18.5,82.4,-3.4,78.5,9.6C74.7,22.6,64.9,33.5,55.1,44.8C45.3,56.1,35.5,67.8,23.6,74.4C11.7,81,-2.3,82.5,-15.6,78.3C-28.9,74.1,-41.5,64.2,-53.1,53.6C-64.7,43,-75.3,31.6,-79.2,18.1C-83.1,4.6,-80.3,-11.1,-72.8,-24.1C-65.3,-37.2,-53.1,-47.6,-40.8,-55.4C-28.5,-63.2,-16.1,-68.4,-3.2,-66.7C9.8,-65,19.6,-56.4,28.4,-50.8" transform="translate(100 100)" />
            </svg> --}}
        </div>
    </div>

    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }
    </script>

</body>
</html>
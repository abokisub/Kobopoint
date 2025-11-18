<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Back Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');
        
        :root {
            --primary-green: #00b875;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #ffffff;
        }

        .btn-primary {
            background-color: var(--primary-green);
            color: white;
            transition: background-color 0.2s;
        }

        .btn-primary:hover {
            background-color: #009e68;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-between">
    <div class="p-6 flex flex-col flex-grow w-full max-w-md mx-auto">

        <header class="mb-8">
            <button aria-label="Go back" class="p-1 rounded-full text-gray-800 hover:bg-gray-50 transition">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m15 18-6-6 6-6"/>
                </svg>
            </button>
        </header>

        <main class="flex-grow">
            <h1 class="text-3xl font-bold mb-1 text-gray-900">Welcome back 😎</h1>
            <p class="text-gray-600 mb-8">Login to your account.</p>

            <form action="#" method="POST" class="space-y-6">

                <div class="flex justify-between items-end">
                    <label id="input-label" class="text-sm font-medium text-gray-700">Phone number</label>
                    <button type="button" id="toggle-link" onclick="toggleLoginType()" class="text-sm font-medium text-[#00b875] hover:text-[#009e68]">
                        Use Email address
                    </button>
                </div>
                
                <div id="phone-input-group">
                    <input type="tel" placeholder="Enter your phone number"
                        class="w-full px-4 py-3 border border-gray-200 bg-gray-50 rounded-lg focus:ring-1 focus:ring-[#00b875] focus:border-[#00b875] placeholder-gray-400 text-gray-800">
                </div>


<div id="email-input-group" class="hidden">
    <input type="email" placeholder="Enter your email address"
        class="w-full px-4 py-3 border border-gray-200 bg-gray-50 rounded-lg focus:ring-1 focus:ring-[#00b875] focus:border-[#00b875] placeholder-gray-400 text-gray-800">
</div>

    
                <div>
                    <label class="text-sm font-medium text-gray-700 mb-1 block">Your password</label>
                    <div class="relative">
                        <input type="password" id="password" placeholder="Enter your password"
                            class="w-full px-4 py-3 border border-gray-200 bg-gray-50 rounded-lg focus:ring-1 focus:ring-[#00b875] focus:border-[#00b875] placeholder-gray-400 pr-12 text-gray-800">

                        <button type="button" onclick="togglePasswordVisibility()" 
                            id="eye-btn"
                            class="absolute inset-y-0 right-0 flex items-center pr-3">
                            <i id="eye-icon" data-lucide="eye-off" class="w-5 h-5 text-gray-400"></i>
                        </button>
                    </div>
                </div>

                <!-- Forgot Password -->
                <div class="flex justify-end">
                    <a href="#" class="text-sm font-medium text-[#00b875] hover:text-[#009e68]">
                        Forgot your password?
                    </a>
                </div>

                <!-- LOGIN BUTTON -->
                <button type="submit" 
                    class="btn-primary w-full py-3 text-base font-semibold rounded-xl shadow-lg hover:shadow-xl transition">
                    Login to your account
                </button>

                <!-- Signup link -->
                <div class="w-full flex justify-center pt-4">
                    <span class="text-sm text-gray-800">
                        New account?
                        <a href="#" class="font-semibold text-[#00b875] hover:text-[#009e68]">Signup</a>
                    </span>
                </div>

            </form>
        </main>
    </div>

    <script>
        let isPhoneLogin = true;

        // Initialize Lucide icons
        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();
        });

        function toggleLoginType() {
            isPhoneLogin = !isPhoneLogin;
            document.getElementById('phone-input-group').classList.toggle('hidden');
            document.getElementById('email-input-group').classList.toggle('hidden');
            document.getElementById('toggle-link').textContent = 
                isPhoneLogin ? 'Use Email address' : 'Use Phone number';
            document.getElementById('input-label').textContent = 
                isPhoneLogin ? 'Phone number' : 'Email address';
        }

        function togglePasswordVisibility() {
            const input = document.getElementById('password');
            const icon = document.getElementById('eye-icon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.setAttribute('data-lucide', 'eye');
            } else {
                input.type = 'password';
                icon.setAttribute('data-lucide', 'eye-off');
            }
            lucide.createIcons();
        }
    </script>
</body>
</html>

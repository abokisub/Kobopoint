<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Forgot Password</title>
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
        background-color: #009a62;
    }

    input:focus {
        border-color: var(--primary-green);
        ring-color: var(--primary-green);
    }

    /* OTP input styling */
    .otp-input {
        width: 3rem;
        height: 3rem;
        text-align: center;
        font-size: 1.5rem;
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
    }
    .otp-input:focus {
        border-color: var(--primary-green);
        box-shadow: 0 0 0 2px rgba(0,184,117,0.2);
        outline: none;
    }
</style>
</head>
<body class="min-h-screen flex flex-col justify-between">
<div class="p-6 flex flex-col flex-grow w-full max-w-md mx-auto">
    <!-- Moved main content down a bit -->
    <header class="mb-10">
        <button aria-label="Go back" class="p-1 rounded-full text-gray-800 hover:bg-gray-50 transition">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m15 18-6-6 6-6"/>
            </svg>
        </button>
    </header>

    <main class="flex-grow mt-4"> <!-- Added mt-4 to move content down -->
        <h1 class="text-2xl font-bold mb-3 text-gray-900">Forgot your password?</h1>
        <p class="text-gray-600 mb-6">
            Enter your registered email address or phone number.
        </p>

        <form id="forgot-form" class="space-y-4">

            <!-- Toggle Email/Phone -->
            <div class="flex justify-between items-end">
                <label id="input-label" class="text-sm font-medium text-gray-700">Email address</label>
                <button type="button" id="toggle-link" onclick="toggleLoginType()" class="text-sm font-medium text-[#00b875] hover:text-[#009a62]">
                    Use Phone number
                </button>
            </div>
            
            <!-- Stage 1: Email Input -->
            <div id="email-input-group">
                <input type="email" id="email" name="email" placeholder="Enter your email address" required
                       class="w-full px-4 py-3 border border-gray-200 bg-gray-50 rounded-lg focus:ring-1 focus:ring-[#00b875] focus:border-[#00b875] placeholder-gray-400 text-gray-800">
            </div>

            <!-- Stage 1: Phone Input -->
            <div id="phone-input-group" class="hidden">
                <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" required
                       class="w-full px-4 py-3 border border-gray-200 bg-gray-50 rounded-lg focus:ring-1 focus:ring-[#00b875] focus:border-[#00b875] placeholder-gray-400 text-gray-800">
            </div>

            <!-- Stage 2: OTP Inputs -->
            <div id="otp-stage" class="hidden">
                <div class="flex justify-between space-x-2">
                    <input type="text" maxlength="1" class="otp-input" id="otp1">
                    <input type="text" maxlength="1" class="otp-input" id="otp2">
                    <input type="text" maxlength="1" class="otp-input" id="otp3">
                    <input type="text" maxlength="1" class="otp-input" id="otp4">
                </div>

                <input type="password" id="new-password" name="new-password" placeholder="Enter new password"
                       class="w-full px-4 py-3 mt-4 border border-gray-200 bg-gray-50 rounded-lg focus:ring-1 focus:ring-[#00b875] focus:border-[#00b875] placeholder-gray-400 text-gray-800">
            </div>

            <!-- Button same size as login button -->
            <button id="action-btn" type="button"
                    class="btn-primary w-full py-3 text-base font-semibold rounded-xl shadow-lg hover:shadow-xl transition duration-300 ease-in-out">
                Get OTP
            </button>

        </form>
    </main>
</div>

<script>
    let isEmailLogin = true;
    let stage = 1; // Stage 1: email/phone, Stage 2: OTP + new password

    function toggleLoginType() {
        isEmailLogin = !isEmailLogin;
        document.getElementById('email-input-group').classList.toggle('hidden');
        document.getElementById('phone-input-group').classList.toggle('hidden');
        document.getElementById('toggle-link').textContent = isEmailLogin ? 'Use Phone number' : 'Use Email address';
        document.getElementById('input-label').textContent = isEmailLogin ? 'Email address' : 'Phone number';
    }

    const actionBtn = document.getElementById('action-btn');
    const otpStage = document.getElementById('otp-stage');
    const emailGroup = document.getElementById('email-input-group');
    const phoneGroup = document.getElementById('phone-input-group');

    actionBtn.addEventListener('click', () => {
        if(stage === 1) {
            otpStage.classList.remove('hidden');
            emailGroup.classList.add('hidden');
            phoneGroup.classList.add('hidden');
            actionBtn.textContent = 'Reset Password';
            stage = 2;
        } else {
            alert('Password reset logic here');
        }
    });

    // Auto focus next OTP input
    const otpInputs = document.querySelectorAll('.otp-input');
    otpInputs.forEach((input, idx) => {
        input.addEventListener('input', () => {
            if(input.value.length === 1 && idx < otpInputs.length - 1) {
                otpInputs[idx + 1].focus();
            }
        });
        input.addEventListener('keydown', (e) => {
            if(e.key === 'Backspace' && input.value === '' && idx > 0) {
                otpInputs[idx - 1].focus();
            }
        });
    });
</script>
</body>
</html>

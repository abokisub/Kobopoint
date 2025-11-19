<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Verify OTP</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');
    :root { --primary-green: #00b875; }
    body { font-family: 'Inter', sans-serif; background-color: #ffffff; }
    .btn-primary { background-color: var(--primary-green); color: white; transition: background-color 0.2s; }
    .btn-primary:hover { background-color: #009e68; }
    .otp-input {
      width: 3rem;
      height: 3rem;
      text-align: center;
      font-size: 1.25rem;
      border-radius: 0.75rem;
      border: 1px solid #e5e7eb;
      background: #f8fafc;
    }
    .otp-input:focus {
      outline: none;
      box-shadow: 0 0 0 3px rgba(0,184,117,0.08);
      border-color: var(--primary-green);
      background: white;
    }
    .small-muted { font-size: .8rem; color: #6b7280; }
    .nav-tight { margin-top: 0.25rem; }
  </style>
</head>
<body class="min-h-screen flex flex-col justify-between">
  <div class="p-6 flex flex-col flex-grow w-full max-w-md mx-auto">

    <!-- Header: back arrow above title -->
    <header class="mb-3">
      <div class="flex items-center">
        <button aria-label="Go back" id="globalBack" class="p-1 rounded-full text-gray-800 hover:bg-gray-50 transition" onclick="onBack()">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="m15 18-6-6 6-6"/>
          </svg>
        </button>
      </div>
      <div class="mt-3">
        <h1 class="text-2xl font-bold text-gray-900">Verify code</h1>
        <div class="text-xs text-gray-500">Enter the 6‑digit code sent to your email</div>
      </div>
    </header>

    <!-- Informational area -->
    <div class="mb-3">
      <div id="emailLine" class="text-sm text-gray-700">Sent to <span id="maskedEmail" class="font-medium"></span></div>
      <div class="text-xs text-gray-500 mt-1">If you didn't receive the email, check your spam or request a new code.</div>
    </div>

    <main class="flex-grow">
      <form id="otpForm" class="space-y-3" onsubmit="handleVerify(event)" novalidate>
        <!-- OTP inputs -->
        <div>
          <label class="text-sm text-gray-600 mb-2 block">Enter verification code</label>
          <div id="otpRow" class="flex gap-2">
            <input inputmode="numeric" pattern="[0-9]*" maxlength="1" class="otp-input" id="otp-1" />
            <input inputmode="numeric" pattern="[0-9]*" maxlength="1" class="otp-input" id="otp-2" />
            <input inputmode="numeric" pattern="[0-9]*" maxlength="1" class="otp-input" id="otp-3" />
            <input inputmode="numeric" pattern="[0-9]*" maxlength="1" class="otp-input" id="otp-4" />
            <input inputmode="numeric" pattern="[0-9]*" maxlength="1" class="otp-input" id="otp-5" />
            <input inputmode="numeric" pattern="[0-9]*" maxlength="1" class="otp-input" id="otp-6" />
          </div>
        </div>

        <!-- Timer & resend -->
        <div class="flex items-center justify-between text-sm text-gray-600">
          <div>
            <span id="timerText">Resend code in <span id="countdown">60</span>s</span>
            <button type="button" id="resendBtn" onclick="resendCode()" class="ml-2 text-[var(--primary-green)] font-medium hidden">Resend</button>
          </div>
          <div>
            <a href="#" id="changeEmail" class="text-[var(--primary-green)] text-sm font-medium">Change email</a>
          </div>
        </div>

        <!-- message -->
        <div id="formMessage" class="text-sm text-red-600 min-h-[1.25rem]" aria-live="polite"></div>

        <!-- Navigation (reduced top space) -->
        <div class="flex items-center justify-between nav-tight">
          <button type="button" class="inline-flex items-center gap-2 px-3 py-2 rounded-xl border text-gray-700 hover:bg-gray-50" onclick="onBack()">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg>
            Back
          </button>

          <button type="submit" id="verifyBtn" class="inline-flex items-center gap-2 px-3 py-2 rounded-xl btn-primary shadow-sm">
            Verify
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 12 2 2 4-4"/></svg>
          </button>
        </div>

        <div class="w-full flex justify-center pt-1">
          <span class="text-sm text-gray-800">Didn't request this? <a href="#" id="supportLink" class="font-semibold text-[var(--primary-green)] hover:text-[#009e68]">Contact support</a></span>
        </div>
      </form>
    </main>
  </div>

  <script>
    // Initialize lucide
    document.addEventListener('DOMContentLoaded', function(){ lucide.createIcons(); });

    // Get email from query param or localStorage (signupEmail)
    function getQueryParam(name) {
      const params = new URLSearchParams(window.location.search);
      return params.get(name);
    }
    function maskEmail(email) {
      if (!email) return '';
      const parts = email.split('@');
      const name = parts[0];
      const domain = parts[1] || '';
      if (name.length <= 2) return name[0] + '***@' + domain;
      const start = name[0];
      const end = name[name.length-1];
      return start + '***' + end + '@' + domain;
    }

    const providedEmail = getQueryParam('email') || localStorage.getItem('signupEmail') || '';
    document.getElementById('maskedEmail').textContent = providedEmail ? maskEmail(providedEmail) : 'your email';

    // OTP inputs handling
    const inputs = Array.from(Array(6)).map((_, i) => document.getElementById('otp-' + (i+1)));

    inputs.forEach((el, idx) => {
      el.addEventListener('input', (e) => {
        const v = e.target.value.replace(/\D/g,'');
        e.target.value = v;
        if (v && idx < inputs.length - 1) {
          inputs[idx + 1].focus();
          inputs[idx + 1].select();
        }
      });
      el.addEventListener('keydown', (e) => {
        if (e.key === 'Backspace' && !e.target.value && idx > 0) {
          inputs[idx-1].focus();
          inputs[idx-1].select();
        } else if (e.key === 'ArrowLeft' && idx > 0) {
          inputs[idx-1].focus();
        } else if (e.key === 'ArrowRight' && idx < inputs.length - 1) {
          inputs[idx+1].focus();
        }
      });
      el.addEventListener('paste', (e) => {
        e.preventDefault();
        const paste = (e.clipboardData || window.clipboardData).getData('text') || '';
        const digits = paste.replace(/\D/g,'').slice(0,6);
        for (let i = 0; i < digits.length; i++) {
          if (inputs[i]) inputs[i].value = digits[i];
        }
        if (digits.length > 0 && digits.length < inputs.length) inputs[digits.length].focus();
      });
    });

    // Autofocus first input
    setTimeout(() => inputs[0].focus(), 300);

    // Countdown timer for resend
    let countdown = 60;
    let timerId = null;
    const countdownEl = document.getElementById('countdown');
    const resendBtn = document.getElementById('resendBtn');
    const timerText = document.getElementById('timerText');

    function startTimer(seconds = 60) {
      clearInterval(timerId);
      countdown = seconds;
      updateTimerText();
      resendBtn.classList.add('hidden');
      countdownEl.parentElement.style.display = '';
      timerId = setInterval(() => {
        countdown--;
        if (countdown <= 0) {
          clearInterval(timerId);
          countdown = 0;
          countdownEl.textContent = '0';
          timerText.style.display = 'none';
          resendBtn.classList.remove('hidden');
        } else {
          updateTimerText();
        }
      }, 1000);
    }
    function updateTimerText() {
      countdownEl.textContent = String(countdown);
      timerText.style.display = '';
    }

    // Resend simulation
    function resendCode() {
      // simulate API call to resend OTP to providedEmail
      if (!providedEmail) {
        alert('No email available to resend code. Please go back and enter your email.');
        return;
      }
      resendBtn.disabled = true;
      resendBtn.textContent = 'Resending...';
      // Simulate network
      setTimeout(() => {
        // on success restart timer
        resendBtn.disabled = false;
        resendBtn.textContent = 'Resend';
        startTimer(60);
        // Show small confirmation
        const msg = document.getElementById('formMessage');
        msg.style.color = '#16a34a';
        msg.textContent = 'A new code was sent to ' + maskEmail(providedEmail);
        setTimeout(() => { msg.textContent = ''; msg.style.color = '#dc2626'; }, 4000);
      }, 900);
    }

    // Verify handler
    function handleVerify(e) {
      e.preventDefault();
      const code = inputs.map(i => i.value.trim()).join('');
      const msgEl = document.getElementById('formMessage');
      if (!/^\d{6}$/.test(code)) {
        msgEl.textContent = 'Enter the 6-digit verification code.';
        return;
      }
      // Simulate verify - replace with API POST to verify code and email/session
      document.getElementById('verifyBtn').disabled = true;
      document.getElementById('verifyBtn').textContent = 'Verifying...';
      msgEl.textContent = '';

      setTimeout(() => {
        // Fake success if code === "123456" (for local dev), else error
        if (code === '123456') {
          document.getElementById('verifyBtn').textContent = 'Verified ✓';
          // proceed - e.g., redirect to dashboard or next step
          alert('OTP verified (simulation). You can now proceed.');
          // example: window.location.href = '/welcome.html';
        } else {
          document.getElementById('verifyBtn').disabled = false;
          document.getElementById('verifyBtn').textContent = 'Verify';
          msgEl.textContent = 'Invalid code. Please try again or resend.';
        }
      }, 900);
    }

    // change email -> go back to signup or allow edit
    document.getElementById('changeEmail').addEventListener('click', (ev) => {
      ev.preventDefault();
      // You can change this behavior to direct to your signup route
      history.back();
    });

    document.getElementById('supportLink').addEventListener('click', (ev) => {
      ev.preventDefault();
      // Change to your support route
      alert('Open support flow (replace with real link).');
    });

    // Expose resendCode for button
    window.resendCode = resendCode;
    window.onBack = function() {
      history.back();
    };

    // start initial timer
    startTimer(60);
  </script>
</body>
</html>

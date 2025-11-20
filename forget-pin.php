<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover" />
  <title>Forgot PIN — Verify & Reset</title>

  <!-- Tailwind for quick mobile-friendly styling -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Font Awesome (requested 'fa fa eye' icon) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap');

    :root {
      --primary: #00b875;
      --primary-dark: #009e68;
      --muted: #6b7280;
      --danger: #ef4444;
      --success: #16a34a;
      --card-radius: 14px;
    }

    html, body {
      height: 100%;
      font-family: 'Inter', system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
      background: linear-gradient(180deg, #fbfdff 0%, #f7fbf8 100%);
    }

    /* Modal overlay & panel (mobile card style) */
    .modal-overlay {
      position: fixed;
      inset: 0;
      background: rgba(7,10,12,0.48);
      display: none;
      align-items: center;
      justify-content: center;
      z-index: 60;
      padding: 20px;
    }
    .modal-overlay.show { display: flex; }

    .modal-card {
      width: 100%;
      max-width: 420px;
      background: white;
      border-radius: var(--card-radius);
      box-shadow: 0 12px 50px rgba(2,6,23,0.22);
      padding: 18px;
      transform-origin: center;
      overflow: hidden;
    }

    .modal-header { display: flex; gap: 12px; align-items: flex-start; justify-content: space-between; }

    .row-title { font-weight: 600; color: #111827; }

    /* Input groups */
    .digit-row {
      display: flex;
      gap: 10px;
      justify-content: center;
      align-items: center;
      margin-top: 6px;
    }

    .digit {
      width: 3.6rem;
      height: 3.6rem;
      border-radius: 12px;
      border: 1px solid #e6eef0;
      background: #f8fafc;
      text-align: center;
      font-size: 1.25rem;
      line-height: 1;
      transition: all 0.12s ease;
      -webkit-appearance: none;
      -moz-appearance: none;
      caret-color: transparent;
    }
    .digit:focus {
      outline: none;
      transform: translateY(-1px);
      box-shadow: 0 10px 26px rgba(0,184,117,0.08);
      border-color: var(--primary);
      background: white;
      caret-color: auto;
    }

    /* OTP uses plain text numbers (not masked) */
    .digit.otp { font-weight: 600; }

    /* Eye toggle */
    .eye-btn {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      color: var(--primary);
      font-weight: 600;
      background: transparent;
      border: none;
      cursor: pointer;
    }

    .divider { height: 1px; background: linear-gradient(90deg, rgba(0,0,0,0.04), rgba(0,0,0,0.02)); margin: 12px 0; border-radius: 1px; }
    .tiny { font-size: 0.82rem; color: var(--muted); }
    .msg { min-height: 1.25rem; font-size: .95rem; }

    @media (max-width: 380px) {
      .digit { width: 3.1rem; height: 3.1rem; font-size: 1.05rem; }
    }
  </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">

  <!-- Demo trigger (useful for mobile testing) -->
  <div class="w-full max-w-md mx-auto text-center">
    <button id="openForgotBtn" class="mb-4 px-4 py-2 rounded-lg bg-[var(--primary)] text-white font-semibold shadow-sm hover:bg-[var(--primary-dark)]">
      Forgot PIN — Open Popup
    </button>
  </div>

  <!-- Modal -->
  <div id="forgotModal" class="modal-overlay" role="dialog" aria-modal="true" aria-labelledby="forgotTitle">
    <div class="modal-card" role="document">
      <div class="modal-header">
        <div class="flex items-start gap-3">
          <button aria-label="Close" id="closeModalBtn" class="p-2 rounded-md text-gray-700 hover:bg-gray-50" title="Close">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
          </button>
          <div>
            <h2 id="forgotTitle" class="text-lg font-semibold text-gray-900">Forgot transaction PIN</h2>
            <div class="tiny mt-0.5">Verify your identity with an OTP and create a new 5-digit PIN</div>
          </div>
        </div>
      </div>

      <div class="divider" aria-hidden="true"></div>

      <main>
        <form id="forgotForm" onsubmit="handleForgotSubmit(event)" novalidate>
          <!-- OTP (5 digits) -->
          <div class="mb-3">
            <label class="block text-sm font-medium text-gray-700 mb-2">Enter OTP</label>
            <div class="digit-row" id="otpRow" role="group" aria-label="Enter OTP">
              <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="1" class="digit otp" id="otp-1" aria-label="OTP digit 1" />
              <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="1" class="digit otp" id="otp-2" aria-label="OTP digit 2" />
              <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="1" class="digit otp" id="otp-3" aria-label="OTP digit 3" />
              <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="1" class="digit otp" id="otp-4" aria-label="OTP digit 4" />
              <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="1" class="digit otp" id="otp-5" aria-label="OTP digit 5" />
            </div>
            <div class="flex items-center justify-between mt-2">
              <div class="tiny text-gray-500">We sent the OTP to your email/phone.</div>
              <button type="button" id="resendOtp" class="text-[var(--primary)] text-sm font-semibold hidden">Resend</button>
            </div>
          </div>

          <!-- New PIN -->
          <div class="mb-3">
            <label class="block text-sm font-medium text-gray-700 mb-2">New PIN</label>
            <div class="digit-row" id="newPinRow" role="group" aria-label="Enter new PIN">
              <input type="password" inputmode="numeric" pattern="[0-9]*" maxlength="1" autocomplete="new-password" class="digit" id="new-1" aria-label="New PIN digit 1" />
              <input type="password" inputmode="numeric" pattern="[0-9]*" maxlength="1" autocomplete="new-password" class="digit" id="new-2" aria-label="New PIN digit 2" />
              <input type="password" inputmode="numeric" pattern="[0-9]*" maxlength="1" autocomplete="new-password" class="digit" id="new-3" aria-label="New PIN digit 3" />
              <input type="password" inputmode="numeric" pattern="[0-9]*" maxlength="1" autocomplete="new-password" class="digit" id="new-4" aria-label="New PIN digit 4" />
              <input type="password" inputmode="numeric" pattern="[0-9]*" maxlength="1" autocomplete="new-password" class="digit" id="new-5" aria-label="New PIN digit 5" />
            </div>
            <div class="tiny mt-2 text-gray-500">Digits only. Keep this PIN secret.</div>
          </div>

          <!-- Confirm PIN with FA eye -->
          <div class="mb-1">
            <div class="flex items-center justify-between">
              <label class="block text-sm font-medium text-gray-700 mb-2">Confirm PIN</label>
              <button id="eyeToggle" class="eye-btn" type="button" aria-pressed="false" title="Show / hide PINs">
                <i id="eyeIcon" class="fa fa-eye" aria-hidden="true"></i>
                <span class="text-xs">Show</span>
              </button>
            </div>

            <div class="digit-row" id="confirmPinRow" role="group" aria-label="Confirm PIN">
              <input type="password" inputmode="numeric" pattern="[0-9]*" maxlength="1" autocomplete="new-password" class="digit" id="confirm-1" aria-label="Confirm PIN digit 1" />
              <input type="password" inputmode="numeric" pattern="[0-9]*" maxlength="1" autocomplete="new-password" class="digit" id="confirm-2" aria-label="Confirm PIN digit 2" />
              <input type="password" inputmode="numeric" pattern="[0-9]*" maxlength="1" autocomplete="new-password" class="digit" id="confirm-3" aria-label="Confirm PIN digit 3" />
              <input type="password" inputmode="numeric" pattern="[0-9]*" maxlength="1" autocomplete="new-password" class="digit" id="confirm-4" aria-label="Confirm PIN digit 4" />
              <input type="password" inputmode="numeric" pattern="[0-9]*" maxlength="1" autocomplete="new-password" class="digit" id="confirm-5" aria-label="Confirm PIN digit 5" />
            </div>
          </div>

          <!-- message -->
          <div class="flex items-center justify-between mt-3">
            <div id="formMessage" class="msg text-sm text-red-600" aria-live="polite"></div>
          </div>

          <!-- actions -->
          <div class="flex items-center justify-between gap-3 mt-4">
            <button type="button" onclick="closeForgotModal()" class="px-3 py-2 rounded-xl border text-gray-700 hover:bg-gray-50 inline-flex items-center gap-2">
              Cancel
            </button>

            <button id="forgotSubmitBtn" type="submit" class="px-4 py-2 rounded-xl bg-[var(--primary)] text-white font-semibold shadow-sm hover:bg-[var(--primary-dark)] transition inline-flex items-center gap-2">
              Reset PIN
              <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 12 2 2 4-4"/></svg>
            </button>
          </div>

        </form>
      </main>
    </div>
  </div>

  <script>
    // Elements
    const modal = document.getElementById('forgotModal');
    const openBtn = document.getElementById('openForgotBtn');
    const closeBtn = document.getElementById('closeModalBtn');
    const resendBtn = document.getElementById('resendOtp');
    const eyeToggle = document.getElementById('eyeToggle');
    const eyeIcon = document.getElementById('eyeIcon');
    const eyeLabel = eyeToggle.querySelector('span');
    const formMsg = document.getElementById('formMessage');
    const submitBtn = document.getElementById('forgotSubmitBtn');

    // Inputs groups
    const otpInputs = Array.from({length:5}, (_, i) => document.getElementById('otp-' + (i+1)));
    const newPinInputs = Array.from({length:5}, (_, i) => document.getElementById('new-' + (i+1)));
    const confirmPinInputs = Array.from({length:5}, (_, i) => document.getElementById('confirm-' + (i+1)));

    // Show modal
    function openForgotModal() {
      modal.classList.add('show');
      // focus first otp
      setTimeout(() => otpInputs[0].focus(), 120);
      startResendTimer(60);
    }
    function closeForgotModal() {
      modal.classList.remove('show');
      clearAllFields();
      formMsg.textContent = '';
    }

    openBtn.addEventListener('click', openForgotModal);
    closeBtn.addEventListener('click', closeForgotModal);
    modal.addEventListener('click', (e) => { if (e.target === modal) closeForgotModal(); });

    // Wire inputs: auto-advance, backspace, arrow, paste
    function wireInputs(inputs, options = {}) {
      inputs.forEach((el, idx) => {
        el.addEventListener('input', (e) => {
          const v = (e.target.value || '').replace(/\D/g, '');
          e.target.value = v;
          if (v && idx < inputs.length - 1) {
            inputs[idx + 1].focus();
            inputs[idx + 1].select();
          }
        });

        el.addEventListener('keydown', (e) => {
          if (e.key === 'Backspace' && !e.target.value && idx > 0) {
            e.preventDefault();
            inputs[idx - 1].focus();
            inputs[idx - 1].select();
          } else if (e.key === 'ArrowLeft' && idx > 0) {
            inputs[idx - 1].focus();
          } else if (e.key === 'ArrowRight' && idx < inputs.length - 1) {
            inputs[idx + 1].focus();
          } else if (e.key === 'Enter' && idx === inputs.length - 1) {
            // submit when pressing enter on last input of a group if requested
            if (options.submitOnEnter) document.getElementById('forgotForm').requestSubmit();
          }
        });

        el.addEventListener('paste', (e) => {
          e.preventDefault();
          const pasted = (e.clipboardData || window.clipboardData).getData('text') || '';
          const digits = pasted.replace(/\D/g, '').slice(0, inputs.length);
          for (let i = 0; i < digits.length; i++) {
            if (inputs[i]) inputs[i].value = digits[i];
          }
          const focusIdx = Math.min(digits.length, inputs.length - 1);
          inputs[focusIdx].focus();
          inputs[focusIdx].select();
        });
      });
    }

    wireInputs(otpInputs, { submitOnEnter: false });
    wireInputs(newPinInputs, { submitOnEnter: false });
    wireInputs(confirmPinInputs, { submitOnEnter: true });

    // Toggle show/hide for PIN inputs using FA icon
    eyeToggle.addEventListener('click', () => {
      const pressed = eyeToggle.getAttribute('aria-pressed') === 'true';
      const newState = !pressed;
      eyeToggle.setAttribute('aria-pressed', String(newState));
      if (newState) {
        eyeIcon.className = 'fa fa-eye-slash';
        eyeLabel.textContent = 'Hide';
        [...newPinInputs, ...confirmPinInputs].forEach(i => i.type = 'text');
      } else {
        eyeIcon.className = 'fa fa-eye';
        eyeLabel.textContent = 'Show';
        [...newPinInputs, ...confirmPinInputs].forEach(i => i.type = 'password');
      }
    });

    // Helper collect functions
    function collect(inputs) { return inputs.map(i => i.value || '').join(''); }
    function showMessage(msg, color = '') { formMsg.textContent = msg; formMsg.style.color = color || ''; }
    function clearAllFields() {
      [...otpInputs, ...newPinInputs, ...confirmPinInputs].forEach(i => i.value = '');
    }

    // Simple trivial PIN check
    function isTrivial(pin) {
      return /^([0-9])\1{4}$/.test(pin) || /^01234$/.test(pin) || /^12345$/.test(pin) || /^98765$/.test(pin);
    }

    // Resend timer (controls "Resend" visibility)
    let resendTimer = null;
    let resendCount = 0;
    const RESEND_SECONDS = 60;
    function startResendTimer(seconds = RESEND_SECONDS) {
      clearInterval(resendTimer);
      resendBtn.classList.add('hidden');
      let left = seconds;
      resendBtn.textContent = `Resend (${left}s)`;
      resendTimer = setInterval(() => {
        left--;
        if (left <= 0) {
          clearInterval(resendTimer);
          resendBtn.textContent = 'Resend';
          resendBtn.classList.remove('hidden');
        } else {
          resendBtn.textContent = `Resend (${left}s)`;
        }
      }, 1000);
    }
    resendBtn.addEventListener('click', () => {
      // simulate resend flow
      resendBtn.disabled = true;
      resendBtn.textContent = 'Resending...';
      setTimeout(() => {
        resendBtn.disabled = false;
        startResendTimer(RESEND_SECONDS);
        showMessage('A new OTP was sent.', 'var(--success)');
        setTimeout(() => showMessage(''), 3500);
      }, 900);
    });

    // Submit handler: validate OTP and new PIN
    function handleForgotSubmit(e) {
      e.preventDefault();
      showMessage('');
      const otp = collect(otpInputs);
      const newPin = collect(newPinInputs);
      const confirmPin = collect(confirmPinInputs);

      if (!/^\d{5}$/.test(otp)) {
        showMessage('Enter the 5-digit OTP.');
        const firstEmpty = otpInputs.find(i => !i.value);
        if (firstEmpty) firstEmpty.focus();
        return;
      }

      if (!/^\d{5}$/.test(newPin)) {
        showMessage('Enter a 5-digit New PIN.');
        const firstEmpty = newPinInputs.find(i => !i.value);
        if (firstEmpty) firstEmpty.focus();
        return;
      }

      if (!/^\d{5}$/.test(confirmPin)) {
        showMessage('Enter a 5-digit Confirm PIN.');
        const firstEmpty = confirmPinInputs.find(i => !i.value);
        if (firstEmpty) firstEmpty.focus();
        return;
      }

      if (newPin !== confirmPin) {
        showMessage('PINs do not match. Please try again.');
        confirmPinInputs.forEach(i => i.value = '');
        confirmPinInputs[0].focus();
        return;
      }

      if (isTrivial(newPin)) {
        showMessage('Choose a less predictable PIN.', '#b45309');
        newPinInputs.forEach(i => i.value = '');
        confirmPinInputs.forEach(i => i.value = '');
        newPinInputs[0].focus();
        return;
      }

      // Simulate API call for OTP verification and PIN reset
      submitBtn.disabled = true;
      const oldText = submitBtn.innerHTML;
      submitBtn.textContent = 'Resetting...';
      showMessage('', '');

      setTimeout(() => {
        // Simulate success when OTP === "11111" (for local dev); otherwise treat as invalid
        if (otp === '11111') {
          submitBtn.innerHTML = 'Done ✓';
          showMessage('PIN reset successfully.', 'var(--success)');

          setTimeout(() => {
            // Clear and close modal
            clearAllFields();
            submitBtn.disabled = false;
            submitBtn.innerHTML = oldText;
            closeForgotModal();
          }, 900);
        } else {
          submitBtn.disabled = false;
          submitBtn.innerHTML = oldText;
          showMessage('Invalid OTP. Please try again or resend.');
        }
      }, 900);
    }

    // Hook form submit
    document.getElementById('forgotForm').addEventListener('submit', handleForgotSubmit);

    // Auto-open modal for demo/testing (comment out if undesired)
    window.addEventListener('DOMContentLoaded', () => {
      setTimeout(openForgotModal, 300);
    });

    // Expose close for convenience
    window.closeForgotModal = closeForgotModal;
  </script>
</body>
</html>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover" />
  <title>Reset PIN — Modal</title>

  <!-- Tailwind for quick styling -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Font Awesome 4.7 (for fa fa-eye icon requested) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap');

    :root{
      --primary: #00b875;
      --primary-dark: #009e68;
      --muted: #6b7280;
      --danger: #ef4444;
      --success: #16a34a;
      --card-radius: 14px;
    }

    html,body{
      height:100%;
      font-family: 'Inter', system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
      background: linear-gradient(180deg,#fbfdff 0%,#f7fbf8 100%);
      -webkit-font-smoothing:antialiased;
      -moz-osx-font-smoothing:grayscale;
    }

    /* Modal overlay & card */
    .modal-overlay{
      position:fixed;
      inset:0;
      background:rgba(7,10,12,0.48);
      display:none;
      align-items:center;
      justify-content:center;
      z-index:60;
      padding:20px;
    }
    .modal-overlay.show{ display:flex; }

    .modal-card{
      width:100%;
      max-width:420px;
      background:white;
      border-radius:var(--card-radius);
      box-shadow:0 12px 50px rgba(2,6,23,0.22);
      padding:18px;
      overflow:hidden;
    }

    .modal-header{ display:flex; gap:12px; align-items:flex-start; justify-content:space-between; }

    .divider{ height:1px; background:linear-gradient(90deg, rgba(0,0,0,0.04), rgba(0,0,0,0.02)); margin:12px 0; border-radius:1px; }

    /* Digit inputs (5 digits each) */
    .digit-row{
      display:flex;
      gap:10px;
      justify-content:center;
      align-items:center;
      margin-top:6px;
    }
    .digit{
      width:3.6rem;
      height:3.6rem;
      border-radius:12px;
      border:1px solid #e6eef0;
      background:#f8fafc;
      text-align:center;
      font-size:1.25rem;
      line-height:1;
      transition:all 0.12s ease;
      -webkit-appearance:none;
      -moz-appearance:none;
      caret-color:transparent; /* hide caret for single-digit masked inputs */
    }
    .digit:focus{
      outline:none;
      transform:translateY(-1px);
      box-shadow:0 10px 26px rgba(0,184,117,0.08);
      border-color:var(--primary);
      background:white;
      caret-color:auto;
    }

    /* OTP style (not masked) */
    .digit.otp{ font-weight:600; }

    .tiny{ font-size:0.82rem; color:var(--muted); }
    .msg{ min-height:1.25rem; font-size:.95rem; }

    .eye-btn{
      display:inline-flex;
      align-items:center;
      gap:8px;
      color:var(--primary);
      font-weight:600;
      background:transparent;
      border:none;
      cursor:pointer;
    }

    @media (max-width:380px){
      .digit{ width:3.1rem; height:3.1rem; font-size:1.05rem; }
    }
  </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">

  <!-- Demo trigger -->
  <div class="w-full max-w-md mx-auto text-center">
    <button id="openResetBtn" class="mb-4 px-4 py-2 rounded-lg bg-[var(--primary)] text-white font-semibold shadow-sm hover:bg-[var(--primary-dark)]">
      Open Reset PIN popup
    </button>
  </div>

  <!-- Modal -->
  <div id="resetModal" class="modal-overlay" role="dialog" aria-modal="true" aria-labelledby="resetTitle">
    <div class="modal-card" role="document">
      <div class="modal-header">
        <div class="flex items-start gap-3">
          <button aria-label="Close" id="closeBtn" class="p-2 rounded-md text-gray-700 hover:bg-gray-50" title="Close">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
          </button>
          <div>
            <h2 id="resetTitle" class="text-lg font-semibold text-gray-900">Reset transaction PIN</h2>
            <div class="tiny mt-0.5">Enter your old PIN, then create and confirm a new 5-digit PIN</div>
          </div>
        </div>
      </div>

      <div class="divider" aria-hidden="true"></div>

      <main>
        <form id="resetForm" onsubmit="handleResetSubmit(event)" novalidate>
          <!-- Old PIN -->
          <div class="mb-3">
            <label class="block text-sm font-medium text-gray-700 mb-2">Old PIN</label>
            <div class="digit-row" id="oldPinRow" role="group" aria-label="Enter old PIN">
              <input type="password" inputmode="numeric" pattern="[0-9]*" maxlength="1" autocomplete="current-password" class="digit" id="old-1" aria-label="Old PIN digit 1" />
              <input type="password" inputmode="numeric" pattern="[0-9]*" maxlength="1" autocomplete="current-password" class="digit" id="old-2" aria-label="Old PIN digit 2" />
              <input type="password" inputmode="numeric" pattern="[0-9]*" maxlength="1" autocomplete="current-password" class="digit" id="old-3" aria-label="Old PIN digit 3" />
              <input type="password" inputmode="numeric" pattern="[0-9]*" maxlength="1" autocomplete="current-password" class="digit" id="old-4" aria-label="Old PIN digit 4" />
              <input type="password" inputmode="numeric" pattern="[0-9]*" maxlength="1" autocomplete="current-password" class="digit" id="old-5" aria-label="Old PIN digit 5" />
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
            <div class="tiny mt-2 text-gray-500">Digits only. Do not share your PIN.</div>
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
            <button type="button" onclick="closeResetModal()" class="px-3 py-2 rounded-xl border text-gray-700 hover:bg-gray-50 inline-flex items-center gap-2">
              Cancel
            </button>

            <button id="resetSubmitBtn" type="submit" class="px-4 py-2 rounded-xl bg-[var(--primary)] text-white font-semibold shadow-sm hover:bg-[var(--primary-dark)] transition inline-flex items-center gap-2">
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
    const modal = document.getElementById('resetModal');
    const openBtn = document.getElementById('openResetBtn');
    const closeBtn = document.getElementById('closeBtn');
    const eyeToggle = document.getElementById('eyeToggle');
    const eyeIcon = document.getElementById('eyeIcon');
    const eyeLabel = eyeToggle.querySelector('span');
    const formMsg = document.getElementById('formMessage');
    const submitBtn = document.getElementById('resetSubmitBtn');

    // Input groups (5 digits each)
    const oldInputs = Array.from({length:5}, (_, i) => document.getElementById('old-' + (i+1)));
    const newInputs = Array.from({length:5}, (_, i) => document.getElementById('new-' + (i+1)));
    const confirmInputs = Array.from({length:5}, (_, i) => document.getElementById('confirm-' + (i+1)));

    // Open/close modal functions
    function openResetModal(){
      modal.classList.add('show');
      setTimeout(() => oldInputs[0].focus(), 120);
    }
    function closeResetModal(){
      modal.classList.remove('show');
      clearAll();
      showMessage('');
    }

    openBtn.addEventListener('click', openResetModal);
    closeBtn.addEventListener('click', closeResetModal);
    modal.addEventListener('click', (e) => { if (e.target === modal) closeResetModal(); });

    // Wiring inputs: auto-advance, backspace nav, arrow nav, paste
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
            if (options.submitOnEnter) document.getElementById('resetForm').requestSubmit();
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

    wireInputs(oldInputs);
    wireInputs(newInputs);
    wireInputs(confirmInputs, { submitOnEnter: true });

    // Toggle show/hide for all PIN fields (old, new, confirm)
    eyeToggle.addEventListener('click', () => {
      const pressed = eyeToggle.getAttribute('aria-pressed') === 'true';
      const next = !pressed;
      eyeToggle.setAttribute('aria-pressed', String(next));
      if (next) {
        eyeIcon.className = 'fa fa-eye-slash';
        eyeLabel.textContent = 'Hide';
        [...oldInputs, ...newInputs, ...confirmInputs].forEach(i => i.type = 'text');
      } else {
        eyeIcon.className = 'fa fa-eye';
        eyeLabel.textContent = 'Show';
        [...oldInputs, ...newInputs, ...confirmInputs].forEach(i => i.type = 'password');
      }
    });

    // Helpers
    function collect(inputs){ return inputs.map(i => i.value || '').join(''); }
    function showMessage(msg, color=''){ formMsg.textContent = msg; formMsg.style.color = color || ''; }
    function clearAll(){ [...oldInputs, ...newInputs, ...confirmInputs].forEach(i => i.value = ''); }

    function isTrivial(pin){
      return /^([0-9])\1{4}$/.test(pin) || /^01234$/.test(pin) || /^12345$/.test(pin) || /^98765$/.test(pin);
    }

    // Submit handler - simulated API
    function handleResetSubmit(e){
      e.preventDefault();
      showMessage('');
      const oldPin = collect(oldInputs);
      const newPin = collect(newInputs);
      const confirmPin = collect(confirmInputs);

      if (!/^\d{5}$/.test(oldPin)){
        showMessage('Enter your 5-digit old PIN.');
        const fe = oldInputs.find(i => !i.value); if (fe) fe.focus();
        return;
      }
      if (!/^\d{5}$/.test(newPin)){
        showMessage('Enter a 5-digit new PIN.');
        const fe = newInputs.find(i => !i.value); if (fe) fe.focus();
        return;
      }
      if (!/^\d{5}$/.test(confirmPin)){
        showMessage('Enter a 5-digit confirm PIN.');
        const fe = confirmInputs.find(i => !i.value); if (fe) fe.focus();
        return;
      }
      if (newPin !== confirmPin){
        showMessage('New PIN and confirmation do not match.');
        confirmInputs.forEach(i => i.value='');
        confirmInputs[0].focus();
        return;
      }
      if (oldPin === newPin){
        showMessage('New PIN cannot be the same as old PIN.');
        newInputs.forEach(i => i.value='');
        confirmInputs.forEach(i => i.value='');
        newInputs[0].focus();
        return;
      }
      if (isTrivial(newPin)){
        showMessage('Choose a less predictable PIN.');
        newInputs.forEach(i => i.value='');
        confirmInputs.forEach(i => i.value='');
        newInputs[0].focus();
        return;
      }

      // Simulate backend verification of old PIN and updating to new PIN.
      // Replace this timeout with a real fetch POST to your secure API.
      submitBtn.disabled = true;
      const oldHtml = submitBtn.innerHTML;
      submitBtn.textContent = 'Resetting...';
      showMessage('', '');

      setTimeout(() => {
        // Demo behavior: treat oldPin === "22222" as valid
        if (oldPin === '22222') {
          submitBtn.innerHTML = 'Done ✓';
          showMessage('PIN reset successfully.', 'var(--success)');

          setTimeout(() => {
            closeResetModal();
            submitBtn.disabled = false;
            submitBtn.innerHTML = oldHtml;
          }, 900);
        } else {
          submitBtn.disabled = false;
          submitBtn.innerHTML = oldHtml;
          showMessage('Old PIN is incorrect. Please try again.', 'var(--danger)');
          // clear old inputs for retry
          oldInputs.forEach(i => i.value='');
          oldInputs[0].focus();
        }
      }, 900);
    }

    // wire form submit
    document.getElementById('resetForm').addEventListener('submit', handleResetSubmit);

    // auto-open demo modal on load (comment out if not wanted)
    window.addEventListener('DOMContentLoaded', () => setTimeout(openResetModal, 300));
  </script>
</body>
</html>

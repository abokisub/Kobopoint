<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover" />
  <title>Set Transaction PIN — Modal</title>

  <!-- Tailwind (for quick styling) -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Font Awesome 4.7 (user requested "fa fa eye icon") -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap');

    :root {
      --primary: #00b875;
      --primary-dark: #009e68;
      --muted: #6b7280;
      --danger: #ef4444;
      --success: #16a34a;
    }

    html, body {
      height: 100%;
      background: linear-gradient(180deg, #fbfdff 0%, #f7fbf8 100%);
      font-family: 'Inter', system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
    }

    /* Modal overlay & panel */
    .modal-overlay {
      position: fixed;
      inset: 0;
      background: rgba(7, 10, 12, 0.48);
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
      border-radius: 14px;
      box-shadow: 0 12px 50px rgba(2,6,23,0.25);
      padding: 20px;
      transform-origin: center;
      overflow: hidden;
    }

    /* header */
    .modal-header {
      display: flex;
      gap: 12px;
      align-items: flex-start;
      justify-content: space-between;
    }

    /* pin inputs */
    .pin-row {
      display: flex;
      gap: 12px;
      justify-content: center;
      align-items: center;
      margin-top: 6px;
    }
    .pin-input {
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
      caret-color: transparent; /* hide caret for single-digit masked inputs */
    }
    .pin-input:focus {
      outline: none;
      transform: translateY(-1px);
      box-shadow: 0 10px 26px rgba(0,184,117,0.08);
      border-color: var(--primary);
      background: white;
      caret-color: auto;
    }

    /* toggle eye button placed to the right of confirm row */
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

    .divider {
      height: 1px;
      background: linear-gradient(90deg, rgba(0,0,0,0.04), rgba(0,0,0,0.02));
      margin: 12px 0;
      border-radius: 1px;
    }

    .msg { min-height: 1.25rem; font-size: .95rem; }

    @media (max-width: 380px) {
      .pin-input { width: 3.2rem; height: 3.2rem; font-size: 1.05rem; }
    }
  </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">

  <!-- Demo trigger (useful while testing on mobile) -->
  <div class="w-full max-w-md mx-auto text-center">
    <button id="openDemoBtn" class="mb-4 px-4 py-2 rounded-lg bg-[var(--primary)] text-white font-semibold shadow-sm hover:bg-[var(--primary-dark)]">
      Open Set PIN popup
    </button>
  </div>

  <!-- Modal overlay -->
  <div id="pinModal" class="modal-overlay" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
    <div class="modal-card">
      <div class="modal-header">
        <div class="flex items-start gap-3">
          <button aria-label="Close" id="modalClose" class="p-2 rounded-md text-gray-700 hover:bg-gray-50" title="Close">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
          </button>
          <div>
            <h2 id="modalTitle" class="text-lg font-semibold text-gray-900">Set transaction PIN</h2>
            <div class="text-xs text-gray-500 mt-0.5">Create a 5-digit PIN to authorize transfers and payments</div>
          </div>
        </div>

        <!-- optional space for status icon -->
        <div class="flex items-center">
          <!-- could place a contextual icon here -->
        </div>
      </div>

      <div class="divider" aria-hidden="true"></div>

      <main>
        <form id="setPinForm" onsubmit="handleSetPin(event)" novalidate>
          <!-- New PIN -->
          <div class="mb-3">
            <label class="block text-sm font-medium text-gray-700 mb-2">New PIN</label>
            <div class="pin-row" id="pinRowNew" role="group" aria-label="Enter new PIN">
              <input type="password" inputmode="numeric" pattern="[0-9]*" maxlength="1" autocomplete="new-password" class="pin-input" id="pin-new-1" aria-label="New PIN digit 1" />
              <input type="password" inputmode="numeric" pattern="[0-9]*" maxlength="1" autocomplete="new-password" class="pin-input" id="pin-new-2" aria-label="New PIN digit 2" />
              <input type="password" inputmode="numeric" pattern="[0-9]*" maxlength="1" autocomplete="new-password" class="pin-input" id="pin-new-3" aria-label="New PIN digit 3" />
              <input type="password" inputmode="numeric" pattern="[0-9]*" maxlength="1" autocomplete="new-password" class="pin-input" id="pin-new-4" aria-label="New PIN digit 4" />
              <input type="password" inputmode="numeric" pattern="[0-9]*" maxlength="1" autocomplete="new-password" class="pin-input" id="pin-new-5" aria-label="New PIN digit 5" />
            </div>
            <div class="text-xs text-gray-500 mt-2">Digits only. Keep this PIN secret.</div>
          </div>

          <!-- Confirm PIN with eye toggle -->
          <div class="mb-2">
            <div class="flex items-center justify-between">
              <label class="block text-sm font-medium text-gray-700 mb-2">Confirm PIN</label>
              <button id="eyeToggle" class="eye-btn" type="button" aria-pressed="false" title="Show / hide PINs">
                <i id="eyeIcon" class="fa fa-eye" aria-hidden="true"></i>
                <span class="text-xs">Show</span>
              </button>
            </div>

            <div class="pin-row" id="pinRowConfirm" role="group" aria-label="Confirm PIN">
              <input type="password" inputmode="numeric" pattern="[0-9]*" maxlength="1" autocomplete="new-password" class="pin-input" id="pin-confirm-1" aria-label="Confirm PIN digit 1" />
              <input type="password" inputmode="numeric" pattern="[0-9]*" maxlength="1" autocomplete="new-password" class="pin-input" id="pin-confirm-2" aria-label="Confirm PIN digit 2" />
              <input type="password" inputmode="numeric" pattern="[0-9]*" maxlength="1" autocomplete="new-password" class="pin-input" id="pin-confirm-3" aria-label="Confirm PIN digit 3" />
              <input type="password" inputmode="numeric" pattern="[0-9]*" maxlength="1" autocomplete="new-password" class="pin-input" id="pin-confirm-4" aria-label="Confirm PIN digit 4" />
              <input type="password" inputmode="numeric" pattern="[0-9]*" maxlength="1" autocomplete="new-password" class="pin-input" id="pin-confirm-5" aria-label="Confirm PIN digit 5" />
            </div>
          </div>

          <div class="flex items-center justify-between mt-3">
            <div id="formMessage" class="msg text-sm text-red-600" aria-live="polite"></div>
          </div>

          <div class="flex items-center justify-between gap-3 mt-4">
            <button type="button" onclick="closeModal()" class="px-3 py-2 rounded-xl border text-gray-700 hover:bg-gray-50 inline-flex items-center gap-2">
              Cancel
            </button>

            <button id="setPinBtn" type="submit" class="px-4 py-2 rounded-xl bg-[var(--primary)] text-white font-semibold shadow-sm hover:bg-[var(--primary-dark)] transition inline-flex items-center gap-2">
              <span>Set PIN</span>
              <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 12 2 2 4-4"/></svg>
            </button>
          </div>

        </form>
      </main>
    </div>
  </div>

  <script>
    // Elements
    const modal = document.getElementById('pinModal');
    const openDemoBtn = document.getElementById('openDemoBtn');
    const modalClose = document.getElementById('modalClose');
    const eyeToggle = document.getElementById('eyeToggle');
    const eyeIcon = document.getElementById('eyeIcon');
    const eyeLabel = eyeToggle.querySelector('span');
    const setPinBtn = document.getElementById('setPinBtn');
    const formMsg = document.getElementById('formMessage');

    // inputs
    const newInputs = Array.from({length:5}, (_, i) => document.getElementById('pin-new-' + (i+1)));
    const confirmInputs = Array.from({length:5}, (_, i) => document.getElementById('pin-confirm-' + (i+1)));

    // open/close modal
    function openModal() {
      modal.classList.add('show');
      // small timeout to allow modal to be visible before focusing
      setTimeout(() => newInputs[0].focus(), 120);
    }
    function closeModal() {
      modal.classList.remove('show');
      // clear fields for safety
      newInputs.forEach(i => i.value = '');
      confirmInputs.forEach(i => i.value = '');
      formMsg.textContent = '';
    }

    openDemoBtn.addEventListener('click', openModal);
    modalClose.addEventListener('click', closeModal);

    // clicking overlay (outside card) closes modal
    modal.addEventListener('click', (e) => {
      if (e.target === modal) closeModal();
    });

    // wiring inputs: auto-advance, backspace nav, arrow nav, paste
    function wire(inputs) {
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
            document.getElementById('setPinForm').requestSubmit();
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

    wire(newInputs);
    wire(confirmInputs);

    // toggle show/hide using Font Awesome classes fa fa-eye / fa fa-eye-slash
    eyeToggle.addEventListener('click', () => {
      const pressed = eyeToggle.getAttribute('aria-pressed') === 'true';
      const newState = !pressed;
      eyeToggle.setAttribute('aria-pressed', String(newState));
      if (newState) {
        // show plaintext
        eyeIcon.className = 'fa fa-eye-slash';
        eyeLabel.textContent = 'Hide';
        [...newInputs, ...confirmInputs].forEach(i => i.type = 'text');
      } else {
        // mask
        eyeIcon.className = 'fa fa-eye';
        eyeLabel.textContent = 'Show';
        [...newInputs, ...confirmInputs].forEach(i => i.type = 'password');
      }
    });

    // helper to collect pin
    function collect(inputs) {
      return inputs.map(i => i.value || '').join('');
    }

    function showMessage(text, color = '') {
      formMsg.textContent = text;
      formMsg.style.color = color || '';
    }

    function isTrivial(pin) {
      return /^([0-9])\1{4}$/.test(pin) || /^01234$/.test(pin) || /^12345$/.test(pin) || /^98765$/.test(pin);
    }

    // submit handler
    function handleSetPin(e) {
      e.preventDefault();
      showMessage('');
      const newPin = collect(newInputs);
      const confirmPin = collect(confirmInputs);

      if (!/^\d{5}$/.test(newPin)) {
        showMessage('Enter a 5-digit New PIN.');
        const firstEmpty = newInputs.find(i => !i.value);
        if (firstEmpty) firstEmpty.focus();
        return;
      }
      if (!/^\d{5}$/.test(confirmPin)) {
        showMessage('Enter a 5-digit Confirm PIN.');
        const firstEmpty = confirmInputs.find(i => !i.value);
        if (firstEmpty) firstEmpty.focus();
        return;
      }
      if (newPin !== confirmPin) {
        showMessage('PINs do not match. Please try again.');
        confirmInputs.forEach(i => i.value = '');
        confirmInputs[0].focus();
        return;
      }
      if (isTrivial(newPin)) {
        showMessage('Choose a less predictable PIN.', '#b45309');
        newInputs.forEach(i => i.value = '');
        confirmInputs.forEach(i => i.value = '');
        newInputs[0].focus();
        return;
      }

      // simulate API call
      setPinBtn.disabled = true;
      const oldText = setPinBtn.innerHTML;
      setPinBtn.textContent = 'Setting...';
      showMessage('', '');

      setTimeout(() => {
        setPinBtn.innerHTML = 'Set';
        showMessage('Transaction PIN set successfully.', '#16a34a');

        // close modal after short delay and clear
        setTimeout(() => {
          closeModal();
          setPinBtn.disabled = false;
          setPinBtn.innerHTML = oldText;
        }, 900);
      }, 900);
    }

    // connect form submit to handler (in case of other triggers)
    document.getElementById('setPinForm').addEventListener('submit', handleSetPin);

    // Auto-open modal on load to simulate popup behavior (comment out if not desired)
    window.addEventListener('DOMContentLoaded', () => {
      // small delay to allow demo button to render and avoid abrupt load jump on mobile
      setTimeout(openModal, 350);
    });
  </script>
</body>
</html>

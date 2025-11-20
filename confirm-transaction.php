<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover" />
  <title>Confirm Transaction — Enter PIN</title>

  <!-- Tailwind for layout + Font Awesome for eye/biometric icons -->
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap');

    :root{
      --accent: #06b6d4;      /* teal-cyan */
      --primary: #00b875;     /* green */
      --glass: rgba(255,255,255,0.72);
      --muted: #7b8794;
      --danger: #ef4444;
      --success: #16a34a;
    }

    html,body{height:100%;font-family:Inter,ui-sans-serif,system-ui,-apple-system,"Segoe UI",Roboto,"Helvetica Neue",Arial;background:
      radial-gradient(1200px 600px at 10% 10%, rgba(0,184,117,0.06), transparent),
      radial-gradient(800px 400px at 90% 90%, rgba(6,182,212,0.04), transparent),
      #f6fbfb;
      -webkit-font-smoothing:antialiased; -moz-osx-font-smoothing:grayscale;
    }

    /* Modal overlay & panel */
    .overlay {
      position: fixed;
      inset: 0;
      display: none;
      align-items: center;
      justify-content: center;
      background: linear-gradient(180deg, rgba(6,7,14,0.42), rgba(6,7,14,0.42));
      z-index: 60;
      padding: 20px;
    }
    .overlay.show { display: flex; }
    .panel {
      width: 100%;
      max-width: 420px;
      background: linear-gradient(180deg, rgba(255,255,255,0.96), rgba(255,255,255,0.98));
      border-radius: 16px;
      box-shadow: 0 18px 50px rgba(2,6,23,0.28);
      overflow: hidden;
      transform-origin: center;
      animation: popIn .26s cubic-bezier(.2,.9,.2,1);
    }

    @keyframes popIn {
      from { transform: translateY(12px) scale(.995); opacity: 0; }
      to   { transform: translateY(0) scale(1); opacity: 1; }
    }

    .header {
      display:flex; gap:12px; align-items:center; padding:18px 18px 8px 18px;
    }
    .brand {
      width:48px; height:48px; border-radius:12px; display:inline-grid; place-items:center;
      background: linear-gradient(135deg, rgba(6,182,212,0.12), rgba(0,184,117,0.08));
      border: 1px solid rgba(6,7,14,0.03);
      box-shadow: 0 6px 18px rgba(6,182,212,0.06);
      font-weight:700; color:var(--primary);
    }
    .title { flex:1; }
    .title h3 { font-size:1.05rem; font-weight:700; color:#0f1724; }
    .title p { margin-top:3px; font-size:.85rem; color:var(--muted); }

    .content { padding: 6px 20px 18px 20px; }

    /* transaction summary card */
    .tx-card {
      display:flex; justify-content:space-between; align-items:center;
      background: linear-gradient(180deg, rgba(6,182,212,0.03), rgba(6,182,212,0.01));
      border-radius: 12px; padding:12px; border:1px solid rgba(6,182,212,0.06);
    }
    .tx-left { display:flex; gap:10px; align-items:center; }
    .tx-amount { font-weight:800; font-size:1.25rem; color:#05263f; }
    .tx-meta { font-size:.86rem; color:var(--muted); }

    .section { margin-top:14px; }

    /* PIN inputs + keypad */
    .pin-row {
      display:flex; gap:12px; justify-content:center; margin-top:12px;
    }
    .pin-cell {
      width:3.75rem; height:3.75rem; border-radius:12px; display:grid; place-items:center;
      background:var(--glass); border:1px solid rgba(6,7,14,0.04); font-size:1.1rem; font-weight:700;
      letter-spacing:6px; color:#0f1724;
      transition: transform .12s ease, box-shadow .12s ease, background .12s ease;
      position:relative;
    }
    .pin-cell:focus-within { transform: translateY(-4px); box-shadow: 0 8px 22px rgba(2,6,23,0.08); background: white; }

    /* masked dot for privacy */
    .dot {
      width:12px; height:12px; border-radius:999px; background: #0f1724; opacity:0.95;
    }
    .pin-digit { font-size:1.05rem; font-weight:800; color:#0f1724; }

    /* keypad */
    .keypad {
      margin-top:14px; display:grid; grid-template-columns: repeat(3, 1fr); gap:10px;
    }
    .key {
      background: white; border-radius:12px; padding:14px; display:flex; align-items:center; justify-content:center;
      font-weight:700; font-size:1.05rem; color:#0b1220; box-shadow: 0 6px 18px rgba(2,6,23,0.06);
      transition: transform .08s ease, box-shadow .12s ease;
      user-select:none;
    }
    .key:active { transform: translateY(3px); box-shadow: 0 4px 12px rgba(2,6,23,0.05); }
    .key.func { font-size:0.95rem; color:var(--muted); }

    .actions { display:flex; gap:10px; margin-top:16px; align-items:center; justify-content:space-between; }
    .btn {
      padding:12px 14px; border-radius:12px; font-weight:700; display:inline-flex; gap:8px; align-items:center;
    }
    .btn.ghost { background:transparent; border:1px solid rgba(11,17,28,0.06); color:#0b1220; }
    .btn.primary { background:linear-gradient(90deg,var(--primary), #00a86b); color:white; box-shadow: 0 10px 30px rgba(0,184,117,0.14); }
    .btn.bio { background: linear-gradient(90deg,var(--accent), #06b6d4); color: white; border-radius:999px; padding:10px 12px; font-weight:700; }

    .msg { min-height:1.2rem; font-size:.92rem; color:var(--danger); margin-top:8px; text-align:center; }

    /* success check */
    .success {
      display:flex; gap:8px; align-items:center; justify-content:center; color:var(--success); font-weight:700;
      padding:12px 10px; border-radius:10px; border:1px solid rgba(16,185,129,0.12); margin-top:12px;
    }

    /* shake animation for error */
    @keyframes shake {
      10%, 90% { transform: translateX(-1px); }
      20%, 80% { transform: translateX(2px); }
      30%, 50%, 70% { transform: translateX(-4px); }
      40%, 60% { transform: translateX(4px); }
    }
    .shake { animation: shake .45s ease; }

    /* small screen tweak */
    @media (max-width:380px){
      .pin-cell { width:3.2rem; height:3.2rem; }
      .key { padding:10px; font-size:1rem; }
    }
  </style>
</head>
<body>

  <!-- Demo page content -->
  <div class="min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full text-center">
      <button id="openBtn" class="btn primary w-full">Confirm Transaction</button>
      <p class="mt-4 text-sm text-gray-600">Tap to open the fantastic confirm PIN popup with tactile keypad and smooth animations.</p>
    </div>
  </div>

  <!-- Modal overlay -->
  <div id="overlay" class="overlay" aria-hidden="true" role="dialog" aria-modal="true" aria-labelledby="confirmTitle">
    <div class="panel" role="document" aria-live="polite">
      <div class="header">
        <div class="brand">TX</div>
        <div class="title">
          <h3 id="confirmTitle">Confirm transaction</h3>
          <p>Enter your 5-digit PIN to authorize</p>
        </div>
        <button id="close" class="text-gray-500 hover:text-gray-800" aria-label="Close">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
      </div>

      <div class="content">
        <!-- transaction summary -->
        <div class="tx-card">
          <div class="tx-left">
            <div class="flex flex-col">
              <span class="tx-amount">₦1,250.00</span>
              <span class="tx-meta">To: Alice Doe — Wallet • Transfer</span>
            </div>
          </div>
          <div class="text-right">
            <div class="tx-meta">Fee <span class="block font-semibold">$0.00</span></div>
          </div>
        </div>

        <div class="section">
          <div class="text-xs text-gray-500 text-center mt-2">Tap digits on the keypad or use your device keyboard</div>

          <!-- PIN input row -->
          <div id="pinRow" class="pin-row" aria-hidden="false" role="group" aria-label="Enter PIN">
            <div class="pin-cell" data-index="0"><input inputmode="numeric" pattern="[0-9]*" maxlength="1" class="sr-only pin-input" aria-label="PIN digit 1"></div>
            <div class="pin-cell" data-index="1"><input inputmode="numeric" pattern="[0-9]*" maxlength="1" class="sr-only pin-input" aria-label="PIN digit 2"></div>
            <div class="pin-cell" data-index="2"><input inputmode="numeric" pattern="[0-9]*" maxlength="1" class="sr-only pin-input" aria-label="PIN digit 3"></div>
            <div class="pin-cell" data-index="3"><input inputmode="numeric" pattern="[0-9]*" maxlength="1" class="sr-only pin-input" aria-label="PIN digit 4"></div>
            <div class="pin-cell" data-index="4"><input inputmode="numeric" pattern="[0-9]*" maxlength="1" class="sr-only pin-input" aria-label="PIN digit 5"></div>
          </div>

          <!-- keypad -->
          <div class="keypad" role="application" aria-label="PIN keypad">
            <div class="key" data-key="1">1</div>
            <div class="key" data-key="2">2</div>
            <div class="key" data-key="3">3</div>
            <div class="key" data-key="4">4</div>
            <div class="key" data-key="5">5</div>
            <div class="key" data-key="6">6</div>
            <div class="key" data-key="7">7</div>
            <div class="key" data-key="8">8</div>
            <div class="key" data-key="9">9</div>
            <div class="key func" id="bioBtn"><i class="fa fa-fingerprint" aria-hidden="true"></i></div>
            <div class="key" data-key="0">0</div>
            <div class="key func" id="backspace"><i class="fa fa-long-arrow-left" aria-hidden="true"></i></div>
          </div>

          <div class="actions">
            <button id="cancel" type="button" class="btn ghost">Cancel</button>

            <div class="flex items-center gap-2">
              <button id="showToggle" class="btn ghost" title="Show PIN" aria-pressed="false"><i class="fa fa-eye"></i></button>
              <button id="confirmBtn" class="btn primary" type="button" aria-disabled="true">Confirm</button>
            </div>
          </div>

          <div id="message" class="msg" aria-live="assertive"></div>
          <div id="successMsg" class="success hidden" role="status" aria-live="polite">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 13l4 4L19 7"/></svg>
            <span>Authorized — transaction sent</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Elements
    const overlay = document.getElementById('overlay');
    const openBtn = document.getElementById('openBtn');
    const close = document.getElementById('close');
    const cancel = document.getElementById('cancel');
    const pinRow = document.getElementById('pinRow');
    const pinCells = Array.from(pinRow.querySelectorAll('.pin-cell'));
    const keys = Array.from(document.querySelectorAll('.key'));
    const backspace = document.getElementById('backspace');
    const bioBtn = document.getElementById('bioBtn');
    const confirmBtn = document.getElementById('confirmBtn');
    const showToggle = document.getElementById('showToggle');
    const message = document.getElementById('message');
    const successMsg = document.getElementById('successMsg');

    // State
    const PIN_LENGTH = 5;
    let pin = new Array(PIN_LENGTH).fill('');
    let show = false;

    // Open/close modal
    function openModal(){
      overlay.classList.add('show');
      clearAll();
      render();
      setTimeout(() => focusCell(0), 200);
    }
    function closeModal(){
      overlay.classList.remove('show');
      clearAll();
    }

    openBtn.addEventListener('click', openModal);
    close.addEventListener('click', closeModal);
    cancel.addEventListener('click', closeModal);
    overlay.addEventListener('click', e => { if (e.target === overlay) closeModal(); });

    // Focus fake input (keyboard entry)
    function focusCell(idx){
      // reveal hidden real input to capture keyboard typing
      const input = pinCells[idx].querySelector('.pin-input');
      if (input) {
        input.focus();
      }
    }

    // Render PIN cells (masked or shown)
    function render(){
      pinCells.forEach((cell, i) => {
        cell.innerHTML = ''; // clear
        const inputEl = document.createElement('input');
        inputEl.className = 'sr-only pin-input';
        inputEl.type = 'tel';
        inputEl.inputMode = 'numeric';
        inputEl.maxLength = 1;
        inputEl.autocomplete = 'one-time-code';
        inputEl.setAttribute('aria-label', `PIN digit ${i+1}`);
        inputEl.addEventListener('keydown', (ev) => {
          if (ev.key === 'Backspace') {
            ev.preventDefault();
            setDigit(i, '');
            focusPrev(i);
            return;
          } else if (/^[0-9]$/.test(ev.key)) {
            ev.preventDefault();
            setDigit(i, ev.key);
            if (i < PIN_LENGTH - 1) focusCell(i+1);
            return;
          } else if (ev.key === 'ArrowLeft') { focusPrev(i); return; }
          else if (ev.key === 'ArrowRight') { if (i < PIN_LENGTH - 1) focusCell(i+1); return; }
          else if (ev.key === 'Enter') { tryConfirm(); return; }
        });
        inputEl.addEventListener('input', (ev) => {
          const v = (ev.target.value || '').replace(/\D/g,'').slice(0,1);
          ev.target.value = v;
          setDigit(i, v);
          if (v && i < PIN_LENGTH - 1) focusCell(i+1);
        });
        inputEl.addEventListener('paste', (ev) => {
          ev.preventDefault();
          const paste = (ev.clipboardData || window.clipboardData).getData('text') || '';
          const digits = paste.replace(/\D/g,'').slice(0, PIN_LENGTH);
          for (let j=0;j<digits.length;j++) setDigit(j, digits[j]);
          render();
          if (digits.length >= PIN_LENGTH) tryConfirm();
          else focusCell(Math.min(digits.length, PIN_LENGTH-1));
        });

        // visible content
        if (!pin[i]) {
          const placeholder = document.createElement('div');
          placeholder.className = 'pin-placeholder';
          cell.appendChild(placeholder);
        } else {
          if (show) {
            const s = document.createElement('div');
            s.className = 'pin-digit';
            s.textContent = pin[i];
            cell.appendChild(s);
          } else {
            const d = document.createElement('div');
            d.className = 'dot';
            cell.appendChild(d);
          }
        }
        // append the hidden input for keyboard capture
        cell.appendChild(inputEl);
      });

      // update confirm button state
      confirmBtn.disabled = !pin.join('').match(new RegExp('^\\d{' + PIN_LENGTH + '}$'));
      confirmBtn.setAttribute('aria-disabled', String(confirmBtn.disabled));
      // message clear
      if (!message.textContent) message.style.opacity = 0.9;
    }

    function setDigit(i, val){
      pin[i] = val || '';
      render();
    }
    function focusPrev(i){
      if (i > 0) focusCell(i-1);
    }
    function clearAll(){
      pin = new Array(PIN_LENGTH).fill('');
      message.textContent = '';
      message.style.color = '';
      successMsg.classList.add('hidden');
      render();
    }

    // Keypad handling
    keys.forEach(k => {
      k.addEventListener('click', () => {
        const key = k.getAttribute('data-key');
        if (key !== null) {
          // find first empty
          const idx = pin.findIndex(ch => !ch);
          if (idx !== -1) {
            setDigit(idx, key);
            if (idx < PIN_LENGTH - 1) focusCell(idx + 1);
            else focusCell(PIN_LENGTH - 1);
          }
        }
      });
    });

    backspace.addEventListener('click', () => {
      const filled = pin.map((v,i) => v ? i : -1).filter(i => i >= 0);
      const lastIdx = filled.length ? filled[filled.length - 1] : -1;
      if (lastIdx >= 0) {
        setDigit(lastIdx, '');
        focusCell(lastIdx);
      } else {
        focusCell(0);
      }
    });

    // biometric (simulated)
    bioBtn.addEventListener('click', async () => {
      // nice micro-interaction while "authenticating"
      bioBtn.classList.add('active');
      message.textContent = 'Waiting for biometric...';
      message.style.color = '';
      await new Promise(r => setTimeout(r, 900));
      // Simulate success (in real app, call WebAuthn / native biometric)
      message.textContent = '';
      success('Biometric recognized — transaction authorized');
    });

    // show/hide toggle
    showToggle.addEventListener('click', () => {
      show = !show;
      showToggle.setAttribute('aria-pressed', String(show));
      showToggle.innerHTML = show ? '<i class="fa fa-eye-slash"></i>' : '<i class="fa fa-eye"></i>';
      render();
    });

    // Confirm flow
    confirmBtn.addEventListener('click', tryConfirm);

    function tryConfirm(){
      const code = pin.join('');
      if (!/^\d{5}$/.test(code)) {
        invalid('Enter your 5-digit PIN');
        return;
      }

      // UI: disable inputs while verifying
      setLocked(true);
      message.textContent = '';
      // simulate network verification - replace with secure POST fetch
      setTimeout(() => {
        // Demo: treat 86420 as "incorrect" only for playful behavior
        if (code === '86420') {
          invalid('Incorrect PIN. Please try again.');
          setLocked(false);
          // clear and animate
          clearCellsShake();
          return;
        }

        success('PIN accepted — sending transaction');
        setLocked(false);
      }, 900);
    }

    function invalid(txt) {
      message.textContent = txt;
      message.style.color = 'var(--danger)';
      // trigger shake on row
      pinRow.classList.remove('shake');
      void pinRow.offsetWidth;
      pinRow.classList.add('shake');
      // clear all for retry
      setTimeout(() => {
        pinRow.classList.remove('shake');
        // partial clear but keep last attempt for clarity? here we clear all
        pin = new Array(PIN_LENGTH).fill('');
        render();
        focusCell(0);
      }, 520);
    }

    function success(txt) {
      message.textContent = '';
      successMsg.classList.remove('hidden');
      successMsg.querySelector('span').textContent = txt;
      // subtle confetti mimic: small pulse
      successMsg.animate([{ transform: 'scale(.96)' }, { transform: 'scale(1)' }], { duration: 420, easing: 'cubic-bezier(.2,.9,.2,1)' });
      // clear after showing and close modal
      setTimeout(() => {
        closeModal();
        // show a toast or call callback for transaction success in real app
      }, 1100);
    }

    function clearCellsShake(){
      pinRow.classList.add('shake');
      setTimeout(() => {
        pinRow.classList.remove('shake');
      }, 500);
    }

    function setLocked(lock){
      // visually indicate locked state
      const state = lock ? 0.45 : 1;
      keys.forEach(k => k.style.pointerEvents = lock ? 'none' : '');
      confirmBtn.disabled = lock;
      confirmBtn.setAttribute('aria-disabled', String(lock));
      showToggle.style.pointerEvents = lock ? 'none' : '';
      pinCells.forEach(c => c.style.opacity = state);
    }

    // allow keyboard number entry: focus first hidden input, event handled in inputs
    document.addEventListener('keydown', (e) => {
      if (!overlay.classList.contains('show')) return;
      if (/^[0-9]$/.test(e.key)) {
        const idx = pin.findIndex(ch => !ch);
        if (idx !== -1) {
          setDigit(idx, e.key);
          if (idx < PIN_LENGTH - 1) focusCell(idx+1);
        }
        e.preventDefault();
      } else if (e.key === 'Backspace') {
        const filled = pin.map((v,i) => v ? i : -1).filter(i => i >= 0);
        const lastIdx = filled.length ? filled[filled.length - 1] : -1;
        if (lastIdx >= 0) {
          setDigit(lastIdx, '');
          focusCell(lastIdx);
        }
        e.preventDefault();
      } else if (e.key === 'Enter') {
        tryConfirm();
        e.preventDefault();
      }
    });

    // Auto-open for demo
    window.addEventListener('DOMContentLoaded', () => {
      // Open on load in demo; comment out if you will trigger from app
      // setTimeout(openModal, 350);
    });
  </script>

</body>
</html>

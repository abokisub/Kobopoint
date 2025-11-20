<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Bank Transfer</title>

  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" integrity="" crossorigin="anonymous" />
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..800&display=swap');

    :root{
      --primary-green: #00b875;
      --muted: #6b7280;
      --card-bg: #fff;
      --page-bg: #ffffff;
    }

    html,body {
      height: 100%;
      margin: 0;
      font-family: Inter, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
      background: var(--page-bg);
      color: #0f172a;
      -webkit-font-smoothing:antialiased;
      -moz-osx-font-smoothing:grayscale;
      font-size: 15px; /* increased a bit */
    }

    /* Container width reduced */
    .page {
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      padding: 1rem;
    }
    .max-col { max-width: 360px; margin: 0 auto; width: 100%; }

    /* back and titles */
    .go-back { width:36px; height:36px; border-radius:50%; background:#f8fafb; display:flex; align-items:center; justify-content:center; cursor:pointer; border:1px solid rgba(0,0,0,0.03); }
    .go-back:hover { transform: scale(1.03); }
    .page-title { margin-top:.6rem; margin-bottom:.25rem; font-size:1.15rem; font-weight:700; color:#0f172a; }
    .page-sub { font-size:.86rem; color:var(--muted); margin-bottom:.6rem; }

    /* progress */
    .progress-wrap { margin-bottom:.5rem; }
    .progress { height: 7px; background:#f1f5f9; border-radius:999px; overflow:hidden; }
    .progress > .bar { height:100%; background:var(--primary-green); width:25%; }

    label { display:block; font-size:.86rem; color:#374151; margin-bottom:.25rem; }
    .input { width:100%; padding:.66rem .85rem; border-radius:.6rem; border:1px solid #e6e7eb; background:#fbfdfe; font-size:1rem; outline:none; }
    .input:focus { box-shadow: 0 0 0 4px rgba(0,184,117,0.06); border-color:var(--primary-green); background:#fff; }

    /* bank dropdown */
    .custom-select { position:relative; }
    .select-button { display:flex; align-items:center; justify-content:space-between; padding:.66rem .85rem; border-radius:.6rem; background:#f9fafb; border:1px solid #e6e7eb; cursor:pointer; font-size:1rem; }
    .select-list { position:absolute; left:0; top:calc(100% + .35rem); background:#fff; border:1px solid #e6e7eb; border-radius:.6rem; box-shadow:0 10px 30px rgba(2,6,23,0.06); z-index:60; display:none; max-height:220px; overflow:auto; min-width:240px; max-width:320px; }
    .select-search { width:100%; padding:.45rem .65rem; border-bottom:1px solid #eef2f7; outline:none; font-size:.95rem; }
    .select-item { padding:.6rem .85rem; font-size:.95rem; cursor:pointer; display:flex; justify-content:space-between; align-items:center; gap:.5rem; }
    .select-item:hover, .select-item[aria-selected="true"] { background: rgba(0,184,117,0.06); color:#064e3b; }

    /* account input & flag */
    .account-wrap { position:relative; }
    .flag-small { position:absolute; left:10px; top:50%; transform:translateY(-50%); width:28px; height:28px; border-radius:50%; overflow:hidden; border:1px solid var(--primary-green); background:#fff; display:flex; align-items:center; justify-content:center; }
    .input.pl-12 { padding-left:52px; }

    /* recent beneficiaries slider */
    .recent-wrap { margin-top:.5rem; margin-bottom:.35rem; }
    .recent-scroll { display:flex; gap:.6rem; overflow-x:auto; padding-bottom:.25rem; -webkit-overflow-scrolling:touch; scroll-snap-type:x mandatory; }
    .recent-item { flex:0 0 auto; width:72px; scroll-snap-align:center; text-align:center; font-size:.82rem; color:#111827; }
    .recent-avatar { width:56px; height:56px; border-radius:50%; overflow:hidden; display:inline-flex; align-items:center; justify-content:center; background:#fff; border:1px solid #eef; box-shadow:0 6px 14px rgba(2,6,23,0.04); font-size:22px; color:var(--primary-green); }
    .recent-avatar img { width:100%; height:100%; object-fit:cover; }
    .recent-name { display:block; margin-top:.35rem; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; font-size:.82rem; color:#374151; }

    /* resolved badge */
    .resolved-badge { display:inline-flex; align-items:center; gap:.5rem; padding:.35rem .6rem; border-radius:999px; background:#f1fdf6; color:#064e3b; font-weight:600; border:1px solid rgba(0,184,117,0.12); font-size:.9rem; }

    .muted { color:var(--muted); font-size:.82rem; margin-top:.35rem; }

    .actions { display:flex; gap:.6rem; margin-top:.45rem; justify-content:flex-end; }
    .btn { padding:.6rem .9rem; border-radius:.6rem; font-weight:700; cursor:pointer; border:none; font-size:1rem; }
    .btn-primary { background:linear-gradient(90deg,var(--primary-green),#00d98a); color:#fff; box-shadow:0 8px 20px rgba(0,184,117,0.12); }
    .btn-primary:disabled { opacity:.55; cursor:not-allowed; box-shadow:none; }

    /* Confirmation modal (professional) */
    .modal-backdrop { position:fixed; inset:0; background:rgba(3,7,18,0.45); display:none; align-items:center; justify-content:center; z-index:200; padding:1rem; }
    .modal { width:100%; max-width:420px; background:#fff; border-radius:12px; box-shadow:0 20px 60px rgba(2,6,23,0.18); overflow:hidden; transform:translateY(8px); }
    .modal-head { padding:1rem 1.25rem; border-bottom:1px solid #f1f5f9; display:flex; gap:.75rem; align-items:center; }
    .modal-title { font-weight:700; font-size:1.05rem; }
    .modal-body { padding:1rem 1.25rem; display:grid; gap:.65rem; }
    .modal-row { display:flex; gap:.65rem; align-items:center; }
    .modal-avatar { width:56px; height:56px; border-radius:12px; background:#fbfffc; border:1px solid rgba(0,184,117,0.08); display:flex; align-items:center; justify-content:center; font-size:22px; color:var(--primary-green); }
    .summary { font-size:.95rem; color:#111827; }
    .summary small { display:block; color:var(--muted); margin-top:.25rem; font-size:.82rem; }

    .modal-foot { padding:0.8rem; display:flex; gap:.6rem; background:#f8fafb; justify-content:flex-end; }
    .btn-ghost { background:transparent; border:1px solid #e6e7eb; color:#374151; padding:.6rem .85rem; border-radius:.6rem; font-weight:700; cursor:pointer; }
    .spinner { border:3px solid rgba(0,0,0,0.06); border-top-color:var(--primary-green); border-radius:50%; width:22px; height:22px; animation:spin 0.9s linear infinite; display:inline-block; vertical-align:middle; margin-right:.5rem; }
    @keyframes spin { to { transform: rotate(360deg); } }

    /* small touches */
    .note { font-size:.82rem; color:var(--muted); }

    @media (max-width:400px) {
      .max-col { padding-left:.4rem; padding-right:.4rem; }
      .recent-item { width:68px; }
      .recent-avatar { width:50px; height:50px; font-size:20px; }
      .modal { max-width:360px; }
    }
  </style>
</head>
<body class="page">
  <div class="max-col">
    <div class="flex items-start gap-3">
      <button class="go-back" onclick="history.back()" aria-label="Go back">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-[#00b875]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="m15 18-6-6 6-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </button>
    </div>

    <div class="page-title">Bank Transfer</div>
    <div class="page-sub">Send money quickly — select recent beneficiary or add new one.</div>

    <div class="progress-wrap">
      <div class="flex items-center justify-between text-xs text-gray-500 mb-2">
        <span class="text-xs text-gray-500">One-time transfer</span>
        <span class="text-xs text-gray-500">Verify beneficiary</span>
      </div>
      <div class="progress"><div class="bar" style="width:25%"></div></div>
    </div>

    <main>
      <form id="transferForm" class="form" onsubmit="event.preventDefault(); openConfirmModal();">
        <!-- Recent beneficiaries -->
        <div class="recent-wrap">
          <label class="muted">Recent beneficiaries</label>
          <div id="recentScroll" class="recent-scroll" aria-label="Recent beneficiaries" tabindex="0"></div>
        </div>

        <!-- Bank -->
        <div>
          <label for="bankButton">Bank</label>
          <div class="custom-select" id="bankSelectWrap">
            <button type="button" id="bankButton" class="select-button" aria-haspopup="listbox" aria-expanded="false">
              <span id="bankLabel" class="text-gray-700">Select bank</span>
              <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="m6 9 6 6 6-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </button>

            <div class="select-list" id="bankList" role="listbox" aria-label="Banks">
              <input type="search" id="bankSearch" class="select-search" placeholder="Search bank..." aria-label="Search banks" />
              <div id="bankItems"></div>
            </div>
          </div>
          <input type="hidden" name="bank_code" id="bankInput" value="">
        </div>

        <!-- Account -->
        <div>
          <label for="accountNumber">Account Number</label>
          <div class="account-wrap" style="position:relative;">
            <div class="flag-small">
              <img src="https://flagcdn.com/w20/ng.png" alt="NG" style="width:100%; height:100%; object-fit:cover;" onerror="this.style.display='none'">
            </div>
            <input id="accountNumber" class="input pl-12" maxlength="10" inputmode="numeric" placeholder="Enter 10-digit account" />
          </div>
          <div id="resolvedNameWrap" style="margin-top:.35rem; display:none">
            <span id="resolvedName" class="resolved-badge"></span>
          </div>
          <div id="resolveHint" class="muted">We will automatically verify the beneficiary name when you enter a valid account number and bank.</div>
        </div>

        <!-- Amount -->
        <div>
          <label for="amount">Amount</label>
          <input id="amount" class="input" type="number" min="0" step="0.01" placeholder="0.00" inputmode="decimal" />
        </div>

        <!-- Narration -->
        <div>
          <label for="narration">Narration (optional)</label>
          <input id="narration" class="input" type="text" maxlength="140" placeholder="Description (optional)" />
        </div>

        <!-- Actions -->
        <div class="actions">
          <button id="continueBtn" class="btn btn-primary" type="button" disabled onclick="openConfirmModal()">Continue</button>
        </div>
      </form>
    </main>
  </div>

  <!-- confirmation modal -->
  <div id="confirmModalBackdrop" class="modal-backdrop" role="dialog" aria-modal="true" aria-hidden="true">
    <div class="modal" role="document" aria-labelledby="confirmTitle">
      <div class="modal-head">
        <div class="modal-avatar" id="confirmAvatar" aria-hidden="true"><i class="bi bi-bank"></i></div>
        <div style="flex:1">
          <div id="confirmTitle" class="modal-title">Confirm transfer</div>
          <div class="note" id="confirmSubtitle">Review transfer details before confirming</div>
        </div>
      </div>

      <div class="modal-body">
        <div class="modal-row">
          <div style="flex:1">
            <div class="summary" id="confirmBeneficiary">Beneficiary: <strong id="cName">—</strong></div>
            <small id="cBank" class="muted">Bank & Account</small>
          </div>
        </div>

        <div class="modal-row">
          <div style="flex:1">
            <div class="summary">Amount: <strong id="cAmount">₦0.00</strong></div>
            <small id="cNarration" class="muted">Narration (optional)</small>
          </div>
        </div>

        <div class="modal-row">
          <div style="flex:1">
            <div class="summary">Reference: <strong id="cRef">—</strong></div>
            <small class="muted">Transaction reference (will be returned by API)</small>
          </div>
        </div>

        <div id="confirmMessage" class="muted" style="margin-top:.25rem"></div>
      </div>

      <div class="modal-foot">
        <button class="btn-ghost" id="editBtn" type="button">Edit</button>
        <button class="btn btn-primary" id="confirmBtn" type="button">Confirm & Send</button>
      </div>
    </div>
  </div>

<script>
  // Configuration
  const API_BASE = localStorage.getItem('api_base') || 'http://127.0.0.1:8000';
  const TOKEN = localStorage.getItem('kp_token') || '';

  // DOM refs
  const bankButton = document.getElementById('bankButton');
  const bankList = document.getElementById('bankList');
  const bankItems = document.getElementById('bankItems');
  const bankSearch = document.getElementById('bankSearch');
  const bankLabel = document.getElementById('bankLabel');
  const bankInput = document.getElementById('bankInput');

  const accountNumberEl = document.getElementById('accountNumber');
  const resolvedNameEl = document.getElementById('resolvedName');
  const resolvedNameWrap = document.getElementById('resolvedNameWrap');
  const resolveHint = document.getElementById('resolveHint');

  const amountEl = document.getElementById('amount');
  const narrationEl = document.getElementById('narration');
  const continueBtn = document.getElementById('continueBtn');

  const recentScroll = document.getElementById('recentScroll');

  // confirmation modal refs
  const confirmBackdrop = document.getElementById('confirmModalBackdrop');
  const confirmAvatar = document.getElementById('confirmAvatar');
  const cName = document.getElementById('cName');
  const cBank = document.getElementById('cBank');
  const cAmount = document.getElementById('cAmount');
  const cNarration = document.getElementById('cNarration');
  const cRef = document.getElementById('cRef');
  const confirmMessage = document.getElementById('confirmMessage');
  const confirmBtn = document.getElementById('confirmBtn');
  const editBtn = document.getElementById('editBtn');

  let BANKS_CACHE = [];
  let resolveTimer = null;
  let kpResolvedName = undefined;
  let kpResolvedStatus = undefined; // 'ok' or 'err' or undefined

  // Sample recent beneficiaries - replace with server-side
  const RECENT_BENEFICIARIES = [
    { id: 'b1', name: 'T. Okonkwo', bankCode: '044', bankName: 'Access Bank', account: '0123456789', icon: '' },
    { id: 'b2', name: 'A. Musa', bankCode: '058', bankName: 'GTBank', account: '0987654321', icon: '' },
    { id: 'b3', name: 'J. Ade', bankCode: '032', bankName: 'Zenith Bank', account: '0123401234', icon: '' },
    { id: 'b4', name: 'N. Bello', bankCode: '011', bankName: 'First Bank', account: '0112233445', icon: '' }
  ];

  function renderRecent() {
    recentScroll.innerHTML = '';
    RECENT_BENEFICIARIES.forEach(b => {
      const item = document.createElement('button');
      item.type = 'button';
      item.className = 'recent-item';
      item.title = b.name + ' • ' + b.bankName;
      item.innerHTML = `
        <span class="recent-avatar" aria-hidden="true">
          ${b.icon ? `<img src="${b.icon}" alt="${b.bankName}">` : `<i class="bi bi-bank"></i>`}
        </span>
        <span class="recent-name">${escapeHtml(b.name)}</span>
      `;
      item.addEventListener('click', () => {
        bankLabel.textContent = b.bankName;
        bankInput.value = b.bankCode;
        accountNumberEl.value = b.account;
        kpResolvedName = b.name;
        kpResolvedStatus = 'ok';
        updateResolvedUI();
        setContinueState();
        item.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
      });
      recentScroll.appendChild(item);
    });
    // horizontal wheel scroll
    recentScroll.addEventListener('wheel', (e) => {
      if (Math.abs(e.deltaX) > 0 || e.deltaY !== 0) {
        recentScroll.scrollLeft += e.deltaY || e.deltaX;
        e.preventDefault();
      }
    }, { passive: false });
  }

  // load banks
  async function loadBanks() {
    bankItems.innerHTML = '<div class="select-item muted">Loading banks…</div>';
    try {
      const res = await fetch(API_BASE + '/api/banks', { headers: { 'Authorization': 'Bearer ' + TOKEN } });
      const json = await res.json().catch(()=>({}));
      const banks = (json && json.banks) ? json.banks : (Array.isArray(json) ? json : []);
      BANKS_CACHE = Array.isArray(banks) && banks.length ? banks : [
        { code:'044', name:'Access Bank' }, { code:'058', name:'GTBank' }, { code:'032', name:'Zenith Bank' },
        { code:'011', name:'First Bank' }, { code:'035', name:'Wema Bank' }
      ];
    } catch(e) {
      BANKS_CACHE = [
        { code:'044', name:'Access Bank' }, { code:'058', name:'GTBank' }, { code:'032', name:'Zenith Bank' },
        { code:'011', name:'First Bank' }, { code:'035', name:'Wema Bank' }
      ];
    }
    renderBankItems(BANKS_CACHE);
  }

  function renderBankItems(list) {
    bankItems.innerHTML = '';
    list.forEach(b => {
      const d = document.createElement('div');
      d.className = 'select-item';
      d.setAttribute('data-value', b.code || b.id || b.bank_code);
      d.innerHTML = `${escapeHtml(b.name)} <span style="float:right; color:#9ca3af; font-size:.82rem">${b.code || ''}</span>`;
      d.addEventListener('click', () => {
        bankLabel.textContent = b.name;
        bankInput.value = b.code || b.id || b.bank_code;
        closeBankList();
        maybeResolve();
      });
      bankItems.appendChild(d);
    });
  }

  function openBankList() {
    bankList.style.display = 'block';
    bankButton.setAttribute('aria-expanded','true');
    bankSearch.value = '';
    bankSearch.focus();
    const btnRect = bankButton.getBoundingClientRect();
    bankList.style.minWidth = Math.max(240, Math.min(320, btnRect.width)) + 'px';
  }
  function closeBankList() {
    bankList.style.display = 'none';
    bankButton.setAttribute('aria-expanded','false');
  }
  function toggleBankList() {
    if (bankList.style.display === 'block') closeBankList(); else openBankList();
  }
  bankButton.addEventListener('click', toggleBankList);
  bankSearch.addEventListener('input', (e)=> {
    const q = (e.target.value||'').toLowerCase().trim();
    const filtered = BANKS_CACHE.filter(b => (b.name||'').toLowerCase().includes(q) || (b.code||'').includes(q));
    renderBankItems(filtered);
  });
  document.addEventListener('click', (ev) => {
    if (!document.getElementById('bankSelectWrap').contains(ev.target)) closeBankList();
  });

  accountNumberEl.addEventListener('input', () => {
    accountNumberEl.value = accountNumberEl.value.replace(/\D/g,'').slice(0,10);
    maybeResolve();
    setContinueState();
  });
  amountEl.addEventListener('input', setContinueState);

  function maybeResolve() {
    clearTimeout(resolveTimer);
    const bankCode = bankInput.value;
    const acct = (accountNumberEl.value || '').replace(/\D/g,'');
    if (!bankCode || acct.length !== 10) {
      kpResolvedName = undefined;
      kpResolvedStatus = undefined;
      updateResolvedUI();
      setContinueState();
      return;
    }
    const matched = RECENT_BENEFICIARIES.find(b => b.bankCode === bankCode && b.account === acct);
    if (matched) {
      kpResolvedName = matched.name;
      kpResolvedStatus = 'ok';
      updateResolvedUI();
      setContinueState();
      return;
    }
    resolveTimer = setTimeout(()=> resolveAccountName(bankCode, acct), 300);
  }

  async function resolveAccountName(bankCode, accountNumber) {
    resolvedNameEl.textContent = 'Resolving…';
    resolvedNameWrap.style.display = 'block';
    resolveHint.style.display = 'none';
    kpResolvedStatus = undefined;
    kpResolvedName = undefined;
    setContinueState();
    try {
      const res = await fetch(API_BASE + `/api/banks/resolve?bank_code=${encodeURIComponent(bankCode)}&account_number=${encodeURIComponent(accountNumber)}`, {
        headers: { 'Authorization': 'Bearer ' + TOKEN }
      });
      const json = await res.json().catch(()=>({}));
      if (res.ok && (json.status === 'ok' || json.resolved_name || json.account_name)) {
        kpResolvedName = json.resolved_name || json.account_name || (json.data && json.data.account_name) || undefined;
        kpResolvedStatus = kpResolvedName ? 'ok' : 'err';
      } else {
        kpResolvedName = undefined;
        kpResolvedStatus = 'err';
      }
    } catch(e) {
      kpResolvedName = undefined;
      kpResolvedStatus = 'err';
    }
    updateResolvedUI();
    setContinueState();
  }

  function updateResolvedUI() {
    if (kpResolvedName && kpResolvedStatus === 'ok') {
      resolvedNameEl.textContent = kpResolvedName;
      resolvedNameWrap.style.display = 'block';
      resolveHint.style.display = 'none';
    } else if (kpResolvedStatus === 'err') {
      resolvedNameEl.textContent = 'Not found / verify details';
      resolvedNameWrap.style.display = 'block';
      resolveHint.style.display = 'none';
    } else {
      resolvedNameWrap.style.display = 'none';
      resolveHint.style.display = 'block';
    }
  }

  function setContinueState() {
    const bankCode = bankInput.value;
    const acct = (accountNumberEl.value || '').replace(/\D/g,'');
    const amount = Number(amountEl.value || 0);
    continueBtn.disabled = !(bankCode && acct.length === 10 && kpResolvedStatus === 'ok' && kpResolvedName && amount > 0);
  }

  // open confirmation modal with populated fields
  function openConfirmModal() {
    // validate quick
    const bankCode = bankInput.value;
    const acct = accountNumberEl.value.replace(/\D/g,'');
    const amount = Number(amountEl.value || 0);
    if (!bankCode) return showToast('Please select a bank');
    if (acct.length !== 10) return showToast('Enter a valid 10-digit account');
    if (!kpResolvedName || kpResolvedStatus !== 'ok') return showToast('Beneficiary not resolved');
    if (!amount || amount <= 0) return showToast('Enter a valid amount');

    // fill modal
    cName.textContent = kpResolvedName;
    cBank.innerHTML = `${bankLabel.textContent} • ${acct}`;
    cAmount.textContent = '₦' + formatAmount(amount);
    cNarration.textContent = narrationEl.value || '-';
    cRef.textContent = '—';
    confirmMessage.textContent = '';

    // set avatar icon (bank icon)
    confirmAvatar.innerHTML = `<i class="bi bi-bank"></i>`;

    // show modal
    confirmBackdrop.style.display = 'flex';
    confirmBackdrop.setAttribute('aria-hidden','false');

    // focus confirm button
    setTimeout(()=> confirmBtn.focus(), 120);
  }

  // close modal
  function closeConfirmModal() {
    confirmBackdrop.style.display = 'none';
    confirmBackdrop.setAttribute('aria-hidden','true');
  }

  // perform transfer after confirmation
  async function confirmAndSend() {
    confirmBtn.disabled = true;
    editBtn.disabled = true;
    confirmMessage.textContent = '';
    const spinner = document.createElement('span'); spinner.className = 'spinner';
    confirmBtn.prepend(spinner);
    const bankCode = bankInput.value;
    const accountNumber = accountNumberEl.value.trim();
    const amount = amountEl.value.trim();
    const narration = narrationEl.value.trim();

    try {
      const payload = { beneficiaryBankCode: bankCode, beneficiaryAccountNumber: accountNumber, amount: Number(amount), narration: narration || '' };
      const res = await fetch(API_BASE + '/api/transfers', {
        method: 'POST',
        headers: { 'Content-Type':'application/json', 'Authorization': 'Bearer ' + TOKEN },
        body: JSON.stringify(payload)
      });
      const body = await res.json().catch(()=>({}));
      spinner.remove();
      confirmBtn.disabled = false;
      editBtn.disabled = false;

      if (res.ok && (body.success || body.data)) {
        const d = body.data || body;
        const destinationName = d.destinationAccountName || kpResolvedName || 'Beneficiary';
        const destinationAcct = d.destinationAccountNumber || accountNumber;
        const destinationBank = d.destinationBankName || bankLabel.textContent;
        const ref = d.reference || d.ref || '';
        cRef.textContent = ref || '—';
        confirmMessage.textContent = 'Transfer submitted successfully';
        confirmMessage.style.color = 'green';
        // show success in modal and keep it open; you can auto-close or redirect
        setTimeout(()=> { closeConfirmModal(); showToast('Transfer submitted'); }, 1200);
      } else {
        const msg = (body && (body.message || body.error)) ? (body.message || body.error) : 'Transfer failed';
        confirmMessage.textContent = String(msg);
        confirmMessage.style.color = 'crimson';
      }
    } catch (e) {
      spinner.remove();
      confirmBtn.disabled = false;
      editBtn.disabled = false;
      confirmMessage.textContent = 'Network error. Please try again.';
      confirmMessage.style.color = 'crimson';
    }
  }

  // helpers
  function formatAmount(n) {
    const num = Number(n);
    if (isNaN(num)) return '0.00';
    return num.toLocaleString('en-NG', { minimumFractionDigits:2, maximumFractionDigits:2 });
  }
  function showToast(text, ttl = 2200) {
    // simple toast fallback: small in-page ephemeral
    const t = document.createElement('div');
    t.textContent = text;
    t.style.position = 'fixed';
    t.style.top = '18px';
    t.style.left = '50%';
    t.style.transform = 'translateX(-50%)';
    t.style.background = 'rgba(0,0,0,0.8)';
    t.style.color = '#fff';
    t.style.padding = '10px 14px';
    t.style.borderRadius = '8px';
    t.style.zIndex = 300;
    document.body.appendChild(t);
    setTimeout(()=> { t.remove(); }, ttl);
  }
  function escapeHtml(s){ return String(s||'').replaceAll('&','&amp;').replaceAll('<','&lt;').replaceAll('>','&gt;'); }

  // modal actions
  confirmBtn.addEventListener('click', confirmAndSend);
  editBtn.addEventListener('click', closeConfirmModal);
  document.addEventListener('keydown', (e)=> { if (e.key === 'Escape') closeConfirmModal(); });

  // init
  renderRecent();
  loadBanks();

  // Bank search keyboard nav (basic)
  bankSearch.addEventListener('keydown', (e)=>{
    const visible = Array.from(bankItems.querySelectorAll('.select-item')).filter(n => n.style.display !== 'none');
    if (!visible.length) return;
    const focusedIndex = visible.findIndex(el => el.classList.contains('focused'));
    if (e.key === 'ArrowDown') {
      e.preventDefault();
      const next = (focusedIndex + 1) % visible.length;
      visible.forEach(n=>n.classList.remove('focused'));
      visible[next].classList.add('focused');
      visible[next].scrollIntoView({block:'nearest'});
    } else if (e.key === 'ArrowUp') {
      e.preventDefault();
      const prev = (focusedIndex <= 0) ? visible.length-1 : focusedIndex-1;
      visible.forEach(n=>n.classList.remove('focused'));
      visible[prev].classList.add('focused');
      visible[prev].scrollIntoView({block:'nearest'});
    } else if (e.key === 'Enter') {
      e.preventDefault();
      const pick = visible[focusedIndex] || visible[0];
      pick && pick.click();
    }
  });
</script>
</body>
</html>

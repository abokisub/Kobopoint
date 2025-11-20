<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Bank Transfer</title>

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    :root{
      --bg:#faf9fb; --card:#ffffff; --muted:#7b6f93; --brand1:#00b875; --brand2:#00d98a; --accent:linear-gradient(90deg,var(--brand1),var(--brand2)); --radius:18px;
    }
    html,body{ margin:0; padding:0; background:var(--bg); min-height:100vh; color:#1b1730; font-family:'Poppins',system-ui,-apple-system,Segoe UI,Roboto,"Helvetica Neue",Arial; }
    .header{ position:fixed; top:0; left:50%; transform:translateX(-50%); width:100%; max-width:420px; background:var(--bg); padding:16px; box-shadow:0 2px 8px rgba(0,0,0,0.02); z-index:100; display:flex; align-items:center; gap:12px; }
    .back-btn{ width:36px; height:36px; border-radius:12px; background:rgba(0,184,117,0.08); display:flex; align-items:center; justify-content:center; color:var(--brand1); cursor:pointer; }
    .title{ font-weight:800; font-size:16px; }
    .app{ max-width:420px; margin:0 auto; padding:18px; padding-top:80px; padding-bottom:40px; }
    .card{ background:var(--card); border-radius:18px; box-shadow:0 6px 18px rgba(0,0,0,0.06); padding:16px; }
    label{ display:block; font-size:12px; font-weight:600; color:#2c2c4a; margin-bottom:6px; }
    select, input{ width:100%; box-sizing:border-box; padding:12px; border:1px solid #e9e7ef; border-radius:12px; font-size:14px; outline:none; }
    select:focus, input:focus{ border-color:#00b875; }
    .row{ margin-bottom:12px; }
    .muted{ font-size:12px; color:var(--muted); }
    .name-badge{ margin-top:6px; background:#f6f7fb; padding:10px 12px; border-radius:12px; font-size:13px; font-weight:600; color:#2c2c4a; }
    .actions{ margin-top:16px; display:flex; gap:12px; }
    .btn{ flex:1; padding:12px; border:none; border-radius:12px; font-weight:700; cursor:pointer; }
    .btn-primary{ background:var(--brand1); color:#fff; }
    .btn-primary:disabled{ background:#b7e9d3; cursor:not-allowed; }
  </style>
</head>
<body>
  <div class="header">
    <div class="back-btn" onclick="window.location.href='/send-money.php'" title="Back"><i class="fa fa-chevron-left"></i></div>
    <div class="title">Bank Transfer</div>
  </div>
  <div class="app">
    <div class="card">
      <div class="row">
        <label for="bankSelect">Bank</label>
        <select id="bankSelect"></select>
      </div>
      <div class="row">
        <label for="accountNumberInput">Account Number</label>
        <input id="accountNumberInput" type="tel" maxlength="10" placeholder="Enter 10-digit account" />
        <div id="resolvedName" class="name-badge" style="display:none;"></div>
        <div class="muted" id="resolveHint">We will automatically verify the beneficiary name.</div>
      </div>
      <div class="row">
        <label for="amountInput">Amount</label>
        <input id="amountInput" type="number" step="0.01" min="0" placeholder="0.00" />
      </div>
      <div class="row">
        <label for="narrationInput">Narration (optional)</label>
        <input id="narrationInput" type="text" placeholder="Description" />
      </div>
      <div class="actions">
        <button id="sendMoneyContinueBtn" class="btn btn-primary" disabled>Continue</button>
      </div>
    </div>
  </div>

<script>
  const API_BASE = localStorage.getItem('api_base') || 'http://127.0.0.1:8000';
  const TOKEN = localStorage.getItem('kp_token');
  let resolveDebounce;
  window.kpResolvedName = undefined;
  window.kpResolvedStatus = undefined;

  function formatAmount(n) {
    const num = Number(n);
    if (isNaN(num)) return '0.00';
    return num.toLocaleString('en-NG', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
  }

  async function loadBanks() {
    const sel = document.getElementById('bankSelect');
    sel.innerHTML = '<option value="">Loading banks…</option>';
    try {
      const res = await fetch(API_BASE + '/api/banks', {
        headers: { 'Authorization': 'Bearer ' + TOKEN }
      });
      const data = await res.json();
      const banks = (data && data.banks) ? data.banks : [];
      sel.innerHTML = '<option value="">Select bank</option>' + banks.map(b => `<option value="${b.code}">${b.name}</option>`).join('');
    } catch(e) {
      sel.innerHTML = '<option value="">Select bank</option>';
    }
  }

  function maybeAutoResolveAccountName() {
    clearTimeout(resolveDebounce);
    const bankCode = document.getElementById('bankSelect').value;
    const acct = (document.getElementById('accountNumberInput').value || '').replace(/\D+/g,'');
    if (!bankCode || acct.length !== 10) {
      window.kpResolvedStatus = undefined;
      window.kpResolvedName = undefined;
      updateResolvedNameUI();
      updateSendMoneyContinueState();
      return;
    }
    resolveDebounce = setTimeout(() => resolveAccountName(bankCode, acct), 350);
  }

  async function resolveAccountName(bankCode, accountNumber) {
    try {
      const res = await fetch(API_BASE + `/api/banks/resolve?bank_code=${encodeURIComponent(bankCode)}&account_number=${encodeURIComponent(accountNumber)}`, {
        headers: { 'Authorization': 'Bearer ' + TOKEN }
      });
      const data = await res.json();
      if (res.ok && data && data.status === 'ok' && data.resolved_name) {
        window.kpResolvedName = data.resolved_name;
        window.kpResolvedStatus = 'ok';
      } else {
        window.kpResolvedName = undefined;
        window.kpResolvedStatus = 'err';
      }
    } catch(e) {
      window.kpResolvedName = undefined;
      window.kpResolvedStatus = 'err';
    }
    updateResolvedNameUI();
    updateSendMoneyContinueState();
  }

  function updateResolvedNameUI() {
    const badge = document.getElementById('resolvedName');
    const hint = document.getElementById('resolveHint');
    if (window.kpResolvedName && window.kpResolvedStatus === 'ok') {
      badge.textContent = 'Beneficiary: ' + window.kpResolvedName;
      badge.style.display = 'block';
      hint.style.display = 'none';
    } else {
      badge.style.display = 'none';
      hint.style.display = 'block';
    }
  }

  function updateSendMoneyContinueState() {
    const bankCode = document.getElementById('bankSelect').value;
    const acct = (document.getElementById('accountNumberInput').value || '').replace(/\D+/g,'');
    const amount = document.getElementById('amountInput').value.trim();
    const ok = !!bankCode && acct.length === 10 && window.kpResolvedStatus === 'ok' && !!window.kpResolvedName && Number(amount) > 0;
    const btn = document.getElementById('sendMoneyContinueBtn');
    btn.disabled = !ok;
  }

  function submitSendMoney() {
    const bankCode = document.getElementById('bankSelect').value;
    const accountNumber = document.getElementById('accountNumberInput').value.trim();
    const amount = document.getElementById('amountInput').value.trim();
    const narration = document.getElementById('narrationInput').value.trim();
    if (!window.Swal) return doInitiateTransfer(bankCode, accountNumber, amount, narration);
    Swal.fire({
      icon: 'info',
      title: 'Preview',
      html: `<div class="fintech-text">Bank code: <strong>${bankCode}</strong><br>Account: <strong>${accountNumber}</strong><br>Beneficiary: <strong>${window.kpResolvedName || '—'}</strong><br>Amount: <strong>₦${formatAmount(amount)}</strong><br>Narration: <strong>${narration || '-'}</strong></div>`,
      showCancelButton: true,
      confirmButtonText: 'Looks good',
      cancelButtonText: 'Edit'
    }).then((res) => { if (res && res.isConfirmed) doInitiateTransfer(bankCode, accountNumber, amount, narration); });
  }

  async function doInitiateTransfer(bankCode, accountNumber, amount, narration) {
    try {
      if (window.Swal) {
        Swal.fire({ icon:'info', title:'Processing transfer…', text:'Please wait while we submit your transfer.', allowOutsideClick:false, allowEscapeKey:false, showConfirmButton:false });
      }
      const payload = { beneficiaryBankCode: bankCode, beneficiaryAccountNumber: accountNumber, narration: narration || '', amount: Number(amount) };
      const res = await fetch(API_BASE + '/api/transfers', {
        method: 'POST', headers: { 'Authorization': 'Bearer ' + TOKEN, 'Content-Type': 'application/json' }, body: JSON.stringify(payload)
      });
      const data = await res.json().catch(() => ({}));
      if (res.ok && data && data.success) {
        const d = data.data || {};
        const destinationName = d.destinationAccountName || window.kpResolvedName || 'Beneficiary';
        const destinationAcct = d.destinationAccountNumber || accountNumber;
        const destinationBank = d.destinationBankName || '';
        const ref = d.reference || '';
        if (window.Swal) {
          Swal.fire({ icon:'success', title:'Transfer submitted', html:`<div class="fintech-text">Sent to: <strong>${destinationName}</strong><br>Account: <strong>${destinationAcct}</strong><br>Bank: <strong>${destinationBank || bankCode}</strong><br>Amount: <strong>₦${formatAmount(amount)}</strong><br>Reference: <strong>${ref || '-'}</strong><br>Status: <strong>${d.status || 'pending'}</strong></div>`, confirmButtonText:'Back to Dashboard' }).then(()=>{ window.location.href='/dashboard.php'; });
        } else {
          alert('Transfer submitted. Reference: ' + (ref || '-'));
          window.location.href='/dashboard.php';
        }
      } else {
        const msg = (data && data.message) ? data.message : 'Request Unsuccessful';
        if (window.Swal) { Swal.fire({ icon:'error', title:'Transfer failed', text: msg, confirmButtonText:'Try again' }); } else { alert('Transfer failed: ' + msg); }
      }
    } catch (e) {
      if (window.Swal) { Swal.fire({ icon:'error', title:'Network error', text:'Please check your connection and try again.' }); } else { alert('Network error'); }
    }
  }

  // Events
  document.getElementById('accountNumberInput').addEventListener('input', maybeAutoResolveAccountName);
  document.getElementById('bankSelect').addEventListener('change', maybeAutoResolveAccountName);
  document.getElementById('amountInput').addEventListener('input', updateSendMoneyContinueState);
  document.getElementById('sendMoneyContinueBtn').addEventListener('click', submitSendMoney);

  // Init
  loadBanks();
</script>
</body>
</html>
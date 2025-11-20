<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Send to Kobopoint</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>
    :root{ --bg:#faf9fb; --card:#ffffff; --muted:#7b6f93; --brand1:#00b875; --brand2:#00d98a; }
    html,body{ margin:0; padding:0; background:var(--bg); min-height:100vh; color:#1b1730; font-family:'Poppins',system-ui,-apple-system,Segoe UI,Roboto,"Helvetica Neue",Arial; }
    .header{ position:fixed; top:0; left:50%; transform:translateX(-50%); width:100%; max-width:420px; background:var(--bg); padding:16px; box-shadow:0 2px 8px rgba(0,0,0,0.02); z-index:100; display:flex; align-items:center; gap:12px; }
    .back-btn{ width:36px; height:36px; border-radius:12px; background:rgba(0,184,117,0.08); display:flex; align-items:center; justify-content:center; color:var(--brand1); cursor:pointer; }
    .title{ font-weight:800; font-size:16px; }
    .app{ max-width:420px; margin:0 auto; padding:18px; padding-top:80px; padding-bottom:40px; }
    .page-title{ font-weight:800; font-size:16px; }
    .subtitle{ font-size:12px; color:var(--muted); margin-bottom:12px; }
    .card{ background:var(--card); border-radius:18px; box-shadow:0 6px 18px rgba(0,0,0,0.06); padding:16px; }
    /* stepper */
    .stepper{ display:flex; align-items:center; gap:14px; margin-bottom:12px; }
    .step{ display:flex; align-items:center; gap:6px; color:#8c8aa1; font-size:12px; }
    .step .bubble{ width:22px; height:22px; border-radius:50%; background:#eef6f3; color:#0b5c3e; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:12px; }
    .step.active{ color:#1b1730; }
    .step.active .bubble{ background:#00b875; color:#fff; }
    .divider{ flex:1; height:2px; background:#eef2f5; }
    /* form */
    label{ display:block; font-size:12px; font-weight:600; color:#2c2c4a; margin-bottom:6px; }
    input{ width:100%; box-sizing:border-box; padding:12px; border:1px solid #e9e7ef; border-radius:12px; font-size:14px; outline:none; }
    input:focus{ border-color:#00b875; }
    .row{ margin-bottom:12px; }
    .label-row{ display:flex; align-items:center; justify-content:space-between; }
    .amount-wrap{ display:flex; align-items:center; gap:10px; }
    .currency-addon{ width:44px; height:44px; border:1px solid #e9e7ef; border-radius:12px; display:flex; align-items:center; justify-content:center; background:#f7fbf9; color:#0b5c3e; font-weight:700; }
    .amount-input{ flex:1; }
    .amount-preview{ font-size:12px; font-weight:700; color:#00b875; margin-left:12px; }
    .actions{ margin-top:16px; display:flex; gap:12px; }
    .btn{ flex:1; padding:12px; border:none; border-radius:12px; font-weight:700; cursor:pointer; }
    .btn-primary{ background:#b7e9d3; color:#fff; }
    .btn-primary.enabled{ background:#00b875; }
    .btn-secondary{ background:#eef7f2; color:#0b5c3e; }
    /* confirm card */
    .summary{ background:#f6f7fb; border-radius:12px; padding:12px; font-size:13px; color:#2c2c4a; }
    .summary-item{ display:flex; justify-content:space-between; margin-bottom:8px; }
    /* recipient verification */
    .verify{ font-size:12px; margin-top:6px; display:none; align-items:center; gap:6px; }
    .verify .fa{ font-size:14px; }
    .verify.ok{ color:#0b8f62; display:flex; }
  </style>
</head>
<body>
  <div class="header">
    <div class="back-btn" onclick="window.location.href='/send-money.php'" title="Back"><i class="fa fa-chevron-left"></i></div>
    <div class="title">Send to Kobopoint</div>
  </div>
  <div class="app">
    <div class="page-title">Send to Kobopoint</div>
    <div class="subtitle">Send money to Kobopoint account</div>
    <div class="card">
      <div class="stepper">
        <div class="step active" id="step1Indicator"><div class="bubble">1</div><div>Transfer Details</div></div>
        <div class="divider"></div>
        <div class="step" id="step2Indicator"><div class="bubble">2</div><div>Confirm Transaction</div></div>
      </div>

      <div id="step1">
        <div class="row">
          <label for="kpIdInput">Enter Recipient (Phone or Email)</label>
          <input id="kpIdInput" type="text" placeholder="" />
        </div>
        <div class="row">
          <div class="label-row"><label for="kpAmountInput">Enter Amount</label><div class="amount-preview" id="amountPreview">₦0.00</div></div>
          <div class="amount-wrap">
            <div class="currency-addon">₦</div>
            <input id="kpAmountInput" class="amount-input" type="number" step="0.01" min="0" placeholder="0.00" />
          </div>
        </div>
        <div class="row">
          <label for="kpNarrationInput">Description (Optional)</label>
          <input id="kpNarrationInput" type="text" placeholder="Description" />
        </div>
        <div class="actions">
          <button class="btn btn-primary" id="nextBtn" disabled>Next</button>
        </div>
      </div>

      <div id="step2" style="display:none;">
        <div class="summary">
          <div class="summary-item"><div>Recipient</div><div id="summaryRecipient">—</div></div>
          <div class="summary-item"><div>Amount</div><div id="summaryAmount">₦0.00</div></div>
          <div class="summary-item"><div>Description</div><div id="summaryNarration">—</div></div>
        </div>
        <div class="actions">
          <button class="btn btn-secondary" id="backBtn">Back</button>
          <button class="btn btn-primary enabled" id="submitBtn">Confirm</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    function formatAmount(n) {
      const num = Number(n);
      if (isNaN(num)) return '₦0.00';
      return '₦' + num.toLocaleString('en-NG', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    // Backend API base (override by setting window.API_BASE if needed)
    const API_BASE = window.API_BASE || 'http://127.0.0.1:8000/api';

    function validateStep1() {
      const id = document.getElementById('kpIdInput').value.trim();
      const amt = document.getElementById('kpAmountInput').value.trim();
      const valid = id.length >= 3 && Number(amt) > 0;
      const next = document.getElementById('nextBtn');
      next.disabled = !valid;
      next.classList.toggle('enabled', valid);
      document.getElementById('amountPreview').textContent = formatAmount(amt || 0);
    }

    function goToStep2() {
      document.getElementById('step1').style.display = 'none';
      document.getElementById('step2').style.display = 'block';
      document.getElementById('step1Indicator').classList.remove('active');
      document.getElementById('step2Indicator').classList.add('active');
      // Fill summary
      const id = document.getElementById('kpIdInput').value.trim();
      const amt = document.getElementById('kpAmountInput').value.trim();
      const narr = document.getElementById('kpNarrationInput').value.trim();
      document.getElementById('summaryRecipient').textContent = id || '—';
      document.getElementById('summaryAmount').textContent = formatAmount(amt || 0);
      document.getElementById('summaryNarration').textContent = narr || '—';
    }

    function backToStep1() {
      document.getElementById('step2').style.display = 'none';
      document.getElementById('step1').style.display = 'block';
      document.getElementById('step2Indicator').classList.remove('active');
      document.getElementById('step1Indicator').classList.add('active');
    }

    async function submitKoboTransfer() {
      const id = document.getElementById('kpIdInput').value.trim();
      const amt = parseFloat(document.getElementById('kpAmountInput').value.trim());
      const narr = document.getElementById('kpNarrationInput').value.trim();

      if (!id || !(amt > 0)) {
        alert('Please provide a valid recipient (phone or email) and an amount greater than 0.');
        return;
      }

      const btn = document.getElementById('submitBtn');
      btn.disabled = true;
      btn.textContent = 'Processing...';

      try {
        const res = await fetch(API_BASE + '/transfers/internal', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          credentials: 'include',
          mode: 'cors',
          body: JSON.stringify({ recipient: id, amount: amt, narration: narr })
        });
        const data = await res.json();
        if (!res.ok || !data.success) {
          throw new Error((data && data.message) || 'Transfer failed');
        }
        const ref = data.data && data.data.reference ? data.data.reference : '—';
        alert('Transfer successful. Reference: ' + ref);
        // Optionally navigate back to dashboard or transfers page
        window.location.href = '/dashboard.php';
      } catch (err) {
        alert(err.message || 'An unexpected error occurred');
      } finally {
        btn.disabled = false;
        btn.textContent = 'Confirm';
      }
    }

    // recipient verification lookup (debounced)
    let lookupTimer = null;
    const verifyEl = document.createElement('div');
    verifyEl.className = 'verify';
    document.getElementById('kpIdInput').parentElement.appendChild(verifyEl);

    async function lookupRecipient(id) {
      if (!id || id.length < 3) { verifyEl.style.display = 'none'; verifyEl.innerHTML = ''; return; }
      try {
        const res = await fetch(API_BASE + '/users/lookup?recipient=' + encodeURIComponent(id), { credentials: 'include', mode: 'cors' });
        const data = await res.json();
        if (!res.ok || !data || !data.found) {
          // Hide when not found or unauthorized — no loading/error text
          verifyEl.style.display = 'none';
          verifyEl.innerHTML = '';
          return;
        }
        const name = data.display_name || data.name || 'User';
        verifyEl.className = 'verify ok';
        verifyEl.innerHTML = '<i class="fa fa-check"></i><span>' + name + '</span>';
        verifyEl.style.display = 'flex';
        // Update summary to show full name if available
        document.getElementById('summaryRecipient').textContent = name;
      } catch (e) {
        // Quietly hide on network errors
        verifyEl.style.display = 'none';
        verifyEl.innerHTML = '';
      }
    }

    function onRecipientInput() {
      validateStep1();
      const id = document.getElementById('kpIdInput').value.trim();
      if (lookupTimer) clearTimeout(lookupTimer);
      lookupTimer = setTimeout(() => lookupRecipient(id), 300);
    }

    document.getElementById('kpIdInput').addEventListener('input', onRecipientInput);
    document.getElementById('kpAmountInput').addEventListener('input', validateStep1);
    document.getElementById('nextBtn').addEventListener('click', goToStep2);
    document.getElementById('backBtn').addEventListener('click', backToStep1);
    document.getElementById('submitBtn').addEventListener('click', submitKoboTransfer);

    // init
    validateStep1();
  </script>
</body>
</html>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Send to Kobopoint</title>

  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" crossorigin="anonymous" />
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
      font-size: 15px;
    }

    .page {
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      padding: 1rem;
    }
    .max-col { max-width: 360px; margin: 0 auto; width: 100%; }

    .go-back { width:36px; height:36px; border-radius:50%; background:#f8fafb; display:flex; align-items:center; justify-content:center; cursor:pointer; border:1px solid rgba(0,0,0,0.03); }
    .go-back:hover { transform: scale(1.03); }
    .page-title { margin-top:.6rem; margin-bottom:.25rem; font-size:1.15rem; font-weight:700; color:#0f172a; }
    .page-sub { font-size:.86rem; color:var(--muted); margin-bottom:.6rem; }

    .progress-wrap { margin-bottom:.5rem; }
    .progress { height: 7px; background:#f1f5f9; border-radius:999px; overflow:hidden; }
    .progress > .bar { height:100%; background:var(--primary-green); width:20%; }

    label { display:block; font-size:.86rem; color:#374151; margin-bottom:.25rem; }
    .input { width:100%; padding:.66rem .85rem; border-radius:.6rem; border:1px solid #e6e7eb; background:#fbfdfe; font-size:1rem; outline:none; }
    .input:focus { box-shadow: 0 0 0 4px rgba(0,184,117,0.06); border-color:var(--primary-green); background:#fff; }

    /* recent beneficiaries */
    .recent-wrap { margin-top:.5rem; margin-bottom:.35rem; }
    .recent-scroll { display:flex; gap:.6rem; overflow-x:auto; padding-bottom:.25rem; -webkit-overflow-scrolling:touch; scroll-snap-type:x mandatory; }
    .recent-item { flex:0 0 auto; width:72px; scroll-snap-align:center; text-align:center; font-size:.82rem; color:#111827; }
    .recent-avatar { width:56px; height:56px; border-radius:50%; overflow:hidden; display:inline-flex; align-items:center; justify-content:center; background:#fff; border:1px solid #eef; box-shadow:0 6px 14px rgba(2,6,23,0.04); font-size:22px; color:var(--primary-green); }
    .recent-avatar img { width:100%; height:100%; object-fit:cover; border-radius:50%; }
    .recent-name { display:block; margin-top:.35rem; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; font-size:.82rem; color:#374151; }

    .resolved-badge { display:inline-flex; align-items:center; gap:.5rem; padding:.35rem .6rem; border-radius:999px; background:#f1fdf6; color:#064e3b; font-weight:600; border:1px solid rgba(0,184,117,0.12); font-size:.9rem; }

    .muted { color:var(--muted); font-size:.82rem; margin-top:.35rem; }

    .amount-row { display:flex; gap:.6rem; align-items:center; }
    .currency { width:46px; height:46px; border-radius:.6rem; display:flex; align-items:center; justify-content:center; border:1px solid #e9e7ef; background:#f7fbf9; color:var(--primary-green); font-weight:700; }
    .amount-input { flex:1; }

    .actions { display:flex; gap:.6rem; margin-top:.45rem; justify-content:flex-end; }
    .btn { padding:.6rem .9rem; border-radius:.6rem; font-weight:700; cursor:pointer; border:none; font-size:1rem; }
    .btn-primary { background:linear-gradient(90deg,var(--primary-green),#00d98a); color:#fff; box-shadow:0 8px 20px rgba(0,184,117,0.12); }
    .btn-primary:disabled { opacity:.55; cursor:not-allowed; box-shadow:none; }

    /* confirmation modal */
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

    <div class="page-title">Send to Kobopoint</div>
    <div class="page-sub">Send to a Kobopoint account quickly — pick a recent beneficiary or add a new one.</div>

    <div class="progress-wrap">
      <div class="flex items-center justify-between text-xs text-gray-500 mb-2">
        <span class="text-xs text-gray-500">Internal transfer</span>
        <span class="text-xs text-gray-500">Confirm & send</span>
      </div>
      <div class="progress"><div class="bar" style="width:20%"></div></div>
    </div>

    <main>
      <form id="kpForm" class="form" onsubmit="event.preventDefault(); openConfirmModal();">
        <!-- Recent beneficiaries -->
        <div class="recent-wrap">
          <label class="muted">Recent beneficiaries</label>
          <div id="recentScroll" class="recent-scroll" aria-label="Recent beneficiaries" tabindex="0"></div>
        </div>

        <!-- Recipient -->
        <div>
          <label for="kpId">Recipient (phone or email)</label>
          <input id="kpId" class="input" type="text" placeholder="Enter phone number or email" autocomplete="off" />
          <div id="resolvedNameWrap" style="margin-top:.35rem; display:none">
            <span id="resolvedName" class="resolved-badge"></span>
          </div>
          <div id="resolveHint" class="muted">We will verify the recipient if possible.</div>
        </div>

        <!-- Amount -->
        <div style="margin-top:.6rem;">
          <label for="kpAmount">Amount</label>
          <div class="amount-row" style="margin-top:.35rem;">
            <div class="currency">₦</div>
            <input id="kpAmount" class="input amount-input" type="number" step="0.01" min="0" placeholder="0.00" />
          </div>
        </div>

        <!-- Narration -->
        <div style="margin-top:.6rem;">
          <label for="kpNarr">Narration (optional)</label>
          <input id="kpNarr" class="input" type="text" maxlength="140" placeholder="Description (optional)" />
        </div>

        <div class="actions">
          <button id="continueBtn" class="btn btn-primary" type="submit" disabled>Continue</button>
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
            <small id="cBank" class="muted">Recipient ID</small>
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
            <small class="muted">Transaction reference (returned by API)</small>
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
  const recentScroll = document.getElementById('recentScroll');
  const kpId = document.getElementById('kpId');
  const kpAmount = document.getElementById('kpAmount');
  const kpNarr = document.getElementById('kpNarr');
  const continueBtn = document.getElementById('continueBtn');
  const resolvedNameEl = document.getElementById('resolvedName');
  const resolvedNameWrap = document.getElementById('resolvedNameWrap');
  const resolveHint = document.getElementById('resolveHint');

  // Modal refs
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

  // sample recent beneficiaries (replace with real API)
  const RECENT = [
    { id: 'r1', name: 'T. Okonkwo', recipient: '08031234567', iconClass: 'bi-bank' },
    { id: 'r2', name: 'A. Musa', recipient: '08039876543', iconClass: 'bi-bank' },
    { id: 'r3', name: 'J. Ade', recipient: 'kobopoint@example.com', iconClass: 'bi-bank' },
    { id: 'r4', name: 'N. Bello', recipient: '08040011223', iconClass: 'bi-bank' }
  ];

  // render recent beneficiary slider
  function renderRecent() {
    recentScroll.innerHTML = '';
    RECENT.forEach(r => {
      const btn = document.createElement('button');
      btn.type = 'button';
      btn.className = 'recent-item';
      const iconHtml = r.iconClass ? `<i class="bi ${r.iconClass}"></i>` : `<i class="bi bi-person-circle"></i>`;
      btn.innerHTML = `<span class="recent-avatar">${iconHtml}</span><span class="recent-name">${escapeHtml(r.name)}</span>`;
      btn.addEventListener('click', () => {
        kpId.value = r.recipient;
        resolvedNameEl.textContent = r.name;
        resolvedNameWrap.style.display = 'block';
        validateForm();
        btn.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
      });
      recentScroll.appendChild(btn);
    });

    recentScroll.addEventListener('wheel', (e) => {
      if (Math.abs(e.deltaX) > 0 || e.deltaY !== 0) {
        recentScroll.scrollLeft += e.deltaY || e.deltaX;
        e.preventDefault();
      }
    }, { passive: false });
  }

  // basic validation
  function validateForm() {
    const idVal = kpId.value.trim();
    const amt = Number(kpAmount.value || 0);
    const ok = idVal.length >= 3 && amt > 0;
    continueBtn.disabled = !ok;
  }

  kpId.addEventListener('input', () => {
    validateForm();
    // clear resolved while typing and attempt a lookup
    resolvedNameWrap.style.display = 'none';
    resolvedNameEl.textContent = '';
    debouncedLookup(kpId.value.trim());
  });

  kpAmount.addEventListener('input', validateForm);
  kpNarr.addEventListener('input', () => { /* no-op */ });

  // recipient lookup (debounced)
  let lookupTimer = null;
  function debouncedLookup(val) {
    if (lookupTimer) clearTimeout(lookupTimer);
    if (!val || val.length < 3) return;
    lookupTimer = setTimeout(() => lookupRecipient(val), 350);
  }

  async function lookupRecipient(value) {
    // attempt to fetch display name from backend; hide quietly on error
    try {
      const res = await fetch(`${API_BASE}/users/lookup?recipient=${encodeURIComponent(value)}`, {
        credentials: 'include',
        headers: TOKEN ? { 'Authorization': 'Bearer ' + TOKEN } : {}
      });
      const data = await res.json().catch(()=>({}));
      if (res.ok && data && data.found) {
        resolvedNameEl.textContent = data.display_name || data.name || value;
        resolvedNameWrap.style.display = 'block';
      } else {
        resolvedNameWrap.style.display = 'none';
      }
    } catch (e) {
      resolvedNameWrap.style.display = 'none';
    }
  }

  // show confirmation modal
  function openConfirmModal() {
    const id = kpId.value.trim();
    const amt = Number(kpAmount.value || 0);
    if (!id || !(amt > 0)) return;
    cName.textContent = resolvedNameEl.textContent || id;
    cBank.textContent = id;
    cAmount.textContent = '₦' + formatAmount(amt);
    cNarration.textContent = kpNarr.value.trim() || '-';
    cRef.textContent = '—';
    confirmMessage.textContent = '';
    confirmAvatar.innerHTML = `<i class="bi bi-bank"></i>`;
    confirmModalShow(true);
    setTimeout(()=> confirmBtn.focus(), 120);
  }

  function confirmModalShow(show) {
    confirmBackdrop.style.display = show ? 'flex' : 'none';
    confirmBackdrop.setAttribute('aria-hidden', show ? 'false' : 'true');
  }

  async function confirmAndSend() {
    confirmBtn.disabled = true;
    editBtn.disabled = true;
    confirmMessage.textContent = '';
    const spinner = document.createElement('span'); spinner.className = 'spinner';
    confirmBtn.prepend(spinner);

    const payload = {
      recipient: kpId.value.trim(),
      amount: Number(kpAmount.value || 0),
      narration: kpNarr.value.trim() || ''
    };

    try {
      const res = await fetch(`${API_BASE}/transfers/internal`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', ...(TOKEN ? { 'Authorization': 'Bearer ' + TOKEN } : {}) },
        credentials: 'include',
        body: JSON.stringify(payload)
      });
      const body = await res.json().catch(()=>({}));
      spinner.remove();
      confirmBtn.disabled = false;
      editBtn.disabled = false;

      if (res.ok && (body.success || body.data)) {
        const ref = (body.data && (body.data.reference || body.data.ref)) || body.reference || '—';
        confirmMessage.style.color = 'green';
        confirmMessage.textContent = 'Transfer submitted successfully. Reference: ' + ref;
        setTimeout(() => { confirmModalShow(false); showToast('Transfer submitted'); }, 1100);
      } else {
        const msg = (body && (body.message || body.error)) || 'Transfer failed';
        confirmMessage.style.color = 'crimson';
        confirmMessage.textContent = String(msg);
      }
    } catch (e) {
      spinner.remove();
      confirmBtn.disabled = false;
      editBtn.disabled = false;
      confirmMessage.style.color = 'crimson';
      confirmMessage.textContent = 'Network error. Please try again.';
    }
  }

  // helpers
  function formatAmount(n) {
    const num = Number(n);
    if (isNaN(num)) return '0.00';
    return num.toLocaleString('en-NG', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
  }
  function showToast(text, ttl = 2200) {
    const t = document.createElement('div');
    t.textContent = text;
    Object.assign(t.style, { position:'fixed', top:'18px', left:'50%', transform:'translateX(-50%)', background:'rgba(0,0,0,0.8)', color:'#fff', padding:'10px 14px', borderRadius:'8px', zIndex:300 });
    document.body.appendChild(t);
    setTimeout(()=> t.remove(), ttl);
  }
  function escapeHtml(s){ return String(s||'').replaceAll('&','&amp;').replaceAll('<','&lt;').replaceAll('>','&gt;'); }

  // modal bindings
  confirmBtn.addEventListener('click', confirmAndSend);
  editBtn.addEventListener('click', ()=> confirmModalShow(false));
  document.addEventListener('keydown', (e)=> { if (e.key === 'Escape') confirmModalShow(false); });

  // init
  renderRecent();
  validateForm();

  // utility: validate form
  function validateForm() {
    const idVal = kpId.value.trim();
    const amt = Number(kpAmount.value || 0);
    continueBtn.disabled = !(idVal.length >= 3 && amt > 0);
  }
  function renderRecent() {
    recentScroll.innerHTML = '';
    RECENT.forEach(r => {
      const item = document.createElement('button');
      item.type = 'button';
      item.className = 'recent-item';
      const icon = r.iconClass ? `<i class="bi ${r.iconClass}"></i>` : `<i class="bi bi-person-circle"></i>`;
      item.innerHTML = `<span class="recent-avatar">${icon}</span><span class="recent-name">${escapeHtml(r.name)}</span>`;
      item.addEventListener('click', () => {
        kpId.value = r.recipient;
        resolvedNameEl.textContent = r.name;
        resolvedNameWrap.style.display = 'block';
        validateForm();
        item.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
      });
      recentScroll.appendChild(item);
    });
  }
</script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Buy Cable TV</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    :root{
      --brand: #00b875;
      --brand-dark: #009e60;
    }
    html, body {
      height: 100%;
      background: #ffffff;
      font-family: 'Segoe UI', sans-serif;
      color: #fff;
      margin: 0;
      -webkit-font-smoothing:antialiased;
    }
    .topbar {
      width: 100%;
      background: #ffffff;
      display: flex;
      align-items: center;
      gap: 8px;
      padding: 8px 12px;
      z-index: 20;
    }
    .topbar .bi {
      font-size: 1.05rem;
      color: #333;
      margin-top: 20px;
      line-height: 1;
    }
    .topbar h5 {
      margin: 0;
      font-size: 0.92rem;
      font-weight: 600;
      margin-top: 20px;
      color: #111;
      line-height: 1;
    }
    .card-wrap {
      max-width: 480px;
      width: calc(100% - 16px);
      margin: 22px auto;
      margin-top: -7px;
      padding: 16px;
      /* Increase width/padding for desktop */
    }
    .card {
      background: #ffffff;
      border: 0;
      border-radius: 12px;
      padding: 16px;
    }
    .provider-icons {
      display: flex;
      justify-content: space-between;
      gap: 12px;
      margin-bottom: 16px;
    }
    .provider-icons img {
      width: 62px;
      height: 62px;
      border-radius: 14px;
      background: #f5f5f5;
      padding: 8px;
      object-fit: contain;
      border: 2px solid transparent;
      cursor: pointer;
      transition: border 0.17s, box-shadow 0.15s;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
    }
    .provider-icons img.selected {
      border: 2px solid var(--brand);
      background: #e9fdf0;
      box-shadow: 0 4px 16px rgba(0,184,117,0.09);
    }
    .input-label {
      font-size: 0.97rem;
      color: #555;
      font-weight: 500;
      margin-bottom: 6px;
      display: inline-block;
    }
    /* Container for grid scroll box */
    .data-plan-scrollbox {
      max-height: 340px;
      min-height: 120px;
      overflow-y: auto;
      background: #f8fff8;
      border: 1px solid #e7f9ef;
      border-radius: 14px;
      box-shadow: 0 2px 8px 0 rgba(0,184,117,0.04);
      padding: 8px 8px 6px 8px;
      margin-bottom: 22px;
      transition: max-width 0.2s;
    }
    .data-plan-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr); /* 2 per row as you scroll */
      gap: 16px;
      margin-top: 0;
    }
    .dataplan-card {
      background: #f8fff8;
      border: 1px solid #e7f9ef;
      border-radius: 10px;
      padding: 12px 8px 13px 8px;
      text-align: center;
      box-shadow: 0 2px 8px 0 rgba(0,184,117,0.04);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      font-size: 0.50rem;
      cursor: pointer;
      transition: box-shadow 0.14s, border 0.13s, transform 0.12s;
      min-width: 0;
      outline: none;
      border: 1px solid #e7f9ef;
    }
    .dataplan-card.selected, .dataplan-card:active, .dataplan-card:focus-visible {
      background: #e1faee;
      border: 1.7px solid var(--brand);
      box-shadow: 0 2.5px 12px 0 rgba(0, 184, 117, 0.09);
    }
    .dataplan-size {
      font-size: 0.91rem;
      color: #099e60;
      font-weight: 700;
      margin-bottom: 2px;
    }
    .dataplan-price {
      color: #333;
      font-size: 0.87rem;
      font-weight: 500;
      margin-bottom: 1px;
    }
    .dataplan-valid {
      color: #5f5f5f;
      font-size: 0.83rem;
      margin-top: 2px;
    }
    .form-control {
      border-radius: 12px;
    }
    #continueBtn {
      background: #00b875;
      border: none;
      border-radius: 12px;
      color: #fff;
      opacity: 1;
      cursor: pointer;
      margin-top: 18px;
      transition: background 0.12s, opacity 0.12s;
      position: relative;
      z-index: 2;
    }
    #continueBtn:disabled, #continueBtn[disabled] {
      opacity: 0.55 !important;
      cursor: not-allowed;
      box-shadow: none;
    }
    .confirm-sheet {
      position: fixed;
      left: 0;
      right: 0;
      bottom: -100%;
      z-index: 2222;
      background: #fff;
      border-radius: 22px 22px 0 0;
      box-shadow: 0 -4px 24px rgba(0,0,0,0.14);
      padding: 24px 20px 18px 20px;
      transition: bottom 0.32s cubic-bezier(.4,1.01,.55,1);
      max-width: 400px;
      margin-left: auto;
      margin-right: auto;
      border: 1px solid #eee;
    }
    .confirm-sheet.active {
      bottom: 0;
    }
    .sheet-backdrop {
      display: none;
      position: fixed;
      left: 0; top: 0; right: 0; bottom: 0;
      background: #1a303a35;
      z-index: 2221;
    }
    .sheet-backdrop.active {
      display: block;
    }
    .confirm-info-title {
      font-size: 1rem;
      font-weight: 600;
      color: #222;
      text-align: center;
      margin-bottom: 18px;
    }
    .confirm-row {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 13px;
    }
    .confirm-row-label {
      font-size: 0.98rem;
      color: #444;
      font-weight: 500;
    }
    .confirm-row-value {
      font-size: 0.98rem;
      color: #111;
      font-weight: 600;
      text-align: right;
      display: flex;
      align-items: center;
      gap: 7px;
    }
    .confirm-network-icon {
      width: 22px; height: 22px; border-radius: 8px; margin-right: 2px; background: #f7f7f7;
      object-fit: contain; border:1.5px solid #eff;
      box-shadow: 0 1px 7px rgba(0,184,117,0.04);
    }
    .paynow-btn {
      width: 100%;
      margin-top: 15px;
      padding: 13px 0;
      border: none;
      border-radius: 12px;
      background: var(--brand);
      color: #fff;
      font-size: 1.08rem;
      font-weight: bold;
      transition: background .15s;
    }
    .paynow-btn:active { background: var(--brand-dark); }

    .closer-sheet-btn {
      background: none;
      border: none;
      color: #444;
      font-size: 1.5rem;
      position: absolute;
      right: 15px;
      top: 13px;
      z-index: 12;
      opacity: .7;
      cursor: pointer;
      padding: 2px 6px;
    }
    @media (max-width: 600px) {
      .card-wrap { max-width: 99vw; width: 99vw; padding: 5vw; }
      .data-plan-scrollbox {max-height:180px;}
    }
    @media (max-width: 450px) {
      .data-plan-grid { grid-template-columns: 1fr; }
      .data-plan-scrollbox {max-height:120px;}
      .card-wrap { padding: 4vw; }
    }
  </style>
</head>
<body>
  <!-- Topbar -->
  <header class="topbar">
    <i class="bi bi-chevron-left" aria-hidden="true"></i>
    <h5>Buy Cable TV</h5>
  </header>

  <main class="card-wrap">
    <section class="card">
      <!-- Providers -->
      <label class="input-label mb-2">Service Provider</label>
      <div class="provider-icons mb-3">
        <img src="/images/dstv.png" alt="DSTV" data-provider="dstv" />
        <img src="/images/gotv.png" alt="GOTV" data-provider="gotv" />
        <img src="/images/startime.png" alt="Startimes" data-provider="startimes" />
        <img src="/images/showmax.png" alt="Showmax" data-provider="showmax" />
      </div>
      <!-- Smartcard/IUC Number Input -->
      <div class="mb-3">
        <label class="input-label" for="cableLuc">Smartcard / IUC / Customer Number</label>
        <input type="text" id="cableLuc" class="form-control" placeholder="Enter Smartcard/IUC/Customer No.">
      </div>
      <!-- Plan scrollable box: only show when provider selected -->
      <div id="plan-section" style="display:none;">
        <label class="input-label mb-2">Choose Subscription Plan</label>
        <div class="data-plan-scrollbox">
          <div class="data-plan-grid" id="cabletvPlanGrid"></div>
        </div>
      </div>
      <button id="continueBtn" class="btn btn-primary w-100 py-2 mt-3" style="background:#00b875" disabled>Continue</button>
    </section>
  </main>
  <!-- Bottom sheet confirmation dialog -->
  <div class="sheet-backdrop" id="sheetBackdrop"></div>
  <div class="confirm-sheet" id="confirmSheet">
    <button class="closer-sheet-btn" id="closeSheetBtn" aria-label="Close">&times;</button>
    <div class="confirm-info-title">Confirm Cable TV Payment</div>
    <div class="confirm-row">
      <span class="confirm-row-label">Provider</span>
      <span class="confirm-row-value" id="sheetNetwork">
        <img class="confirm-network-icon" src="" alt="Network" id="sheetNetworkIcon">
        <span id="sheetNetworkName"></span>
      </span>
    </div>
    <div class="confirm-row">
      <span class="confirm-row-label">Smartcard/IUC/Number</span>
      <span class="confirm-row-value" id="sheetLuc"></span>
    </div>
    <div class="confirm-row">
      <span class="confirm-row-label">Plan</span>
      <span class="confirm-row-value" id="sheetPlan"></span>
    </div>
    <div class="confirm-row">
      <span class="confirm-row-label">Amount</span>
      <span class="confirm-row-value" id="sheetAmount"></span>
    </div>
    <button class="paynow-btn mt-4" id="paynowBtn">Pay Now</button>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Provider mapping and logos
    const providerImages = {
      dstv: "/images/dstv.png",
      gotv: "/images/gotv.png",
      startimes: "/images/startime.png",
      showmax: "/images/showmax.png"
    };
    const providerLabels = {
      dstv: "DSTV",
      gotv: "GOTV",
      startimes: "Startimes",
      showmax: "Showmax"
    };
    // Example plans for providers
    const plans = {
      dstv: [
        {name:'DSTV Padi',    price:'₦2,500', valid:'30 Days'},
        {name:'DSTV Yanga',   price:'₦3,500', valid:'30 Days'},
        {name:'DSTV Confam',  price:'₦6,200', valid:'30 Days'},
        {name:'DSTV Compact', price:'₦10,500', valid:'30 Days'},
        {name:'DSTV Compact Plus', price:'₦16,600', valid:'30 Days'},
        {name:'DSTV Premium', price:'₦24,500', valid:'30 Days'},
        {name:'Xtraview',     price:'₦2,900', valid:'30 Days'},
        {name:'Access',       price:'₦1,200', valid:'30 Days'}
      ],
      gotv: [
        {name:'GOTV Smallie (Monthly)', price:'₦1,300', valid:'30 Days'},
        {name:'GOTV Jinja',             price:'₦2,250', valid:'30 Days'},
        {name:'GOTV Jolli',             price:'₦3,300', valid:'30 Days'},
        {name:'GOTV Max',               price:'₦4,850', valid:'30 Days'},
        {name:'GOTV Supa',              price:'₦6,500', valid:'30 Days'},
        {name:'GOTV Supa+',             price:'₦7,000', valid:'30 Days'}
      ],
      startimes: [
        {name:'Nova',           price:'₦1,200', valid:'30 Days'},
        {name:'Basic',          price:'₦2,100', valid:'30 Days'},
        {name:'Smart',          price:'₦2,800', valid:'30 Days'},
        {name:'Classic',        price:'₦3,900', valid:'30 Days'},
        {name:'Super',          price:'₦7,600', valid:'30 Days'},
        {name:'Nova Plus',      price:'₦1,700', valid:'30 Days'},
        {name:'Smart Plus',     price:'₦4,100', valid:'30 Days'},
        {name:'Classic Plus',   price:'₦6,000', valid:'30 Days'}
      ],
      showmax: [
        {name:'Showmax Mobile',         price:'₦1,200', valid:'30 Days'},
        {name:'Showmax Pro Mobile',     price:'₦3,200', valid:'30 Days'},
        {name:'Showmax',                price:'₦2,900', valid:'30 Days'},
        {name:'Showmax Pro',            price:'₦6,300', valid:'30 Days'},
        {name:'Showmax Family',         price:'₦1,650', valid:'30 Days'},
        {name:'Showmax Student',        price:'₦1,000', valid:'30 Days'}
      ]
    };
    let selectedProvider = null;
    let selectedPlanIdx = null;
    // Provider selection
    document.querySelectorAll('.provider-icons img').forEach(function(img) {
      img.addEventListener('click', function() {
        document.querySelectorAll('.provider-icons img').forEach(i => i.classList.remove('selected'));
        this.classList.add('selected');
        selectedProvider = this.getAttribute('data-provider');
        selectedPlanIdx = null;
        renderCabletvPlans(selectedProvider);
        document.getElementById('plan-section').style.display = "block";
        document.getElementById('continueBtn').disabled = true;
      });
    });
    function renderCabletvPlans(provider) {
      const planList = plans[provider] || [];
      let html = '';
      for (let i = 0; i < planList.length; i++) {
        html += `
          <div class="dataplan-card" tabindex="0" data-idx="${i}">
            <div class="dataplan-size">${planList[i].name}</div>
            <div class="dataplan-price">${planList[i].price}</div>
            <div class="dataplan-valid">${planList[i].valid}</div>
          </div>
        `;
      }
      document.getElementById('cabletvPlanGrid').innerHTML = html;
      document.querySelectorAll('.dataplan-card').forEach(function(card, idx) {
        card.addEventListener('click', function() {
          document.querySelectorAll('.dataplan-card').forEach(c => c.classList.remove('selected'));
          card.classList.add('selected');
          selectedPlanIdx = idx;
          document.getElementById('continueBtn').disabled = false;
        });
        card.addEventListener('keydown', function(e) {
          if(["Enter", " "].includes(e.key)) {
            card.click();
          }
        });
      });
    }
    // Bottom sheet logic
    function showConfirmSheet({provider, plan, number}) {
      document.getElementById('sheetNetworkIcon').src = providerImages[provider];
      document.getElementById('sheetNetworkName').textContent = providerLabels[provider] || provider;
      document.getElementById('sheetLuc').textContent = number;
      document.getElementById('sheetPlan').textContent = plan.name + ' (' + plan.valid + ')';
      document.getElementById('sheetAmount').textContent = plan.price;
      document.getElementById('sheetBackdrop').classList.add('active');
      document.getElementById('confirmSheet').classList.add('active');
    }
    function hideConfirmSheet() {
      document.getElementById('sheetBackdrop').classList.remove('active');
      document.getElementById('confirmSheet').classList.remove('active');
    }
    document.getElementById('sheetBackdrop').addEventListener('click', hideConfirmSheet);
    document.getElementById('closeSheetBtn').addEventListener('click', hideConfirmSheet);
    document.addEventListener('DOMContentLoaded', function() {
      let btn = document.getElementById('continueBtn');
      if(btn) {
        btn.addEventListener('click', function() {
          if(selectedPlanIdx !== null && selectedProvider) {
            const input = document.getElementById('cableLuc');
            const number = input ? input.value.trim() : "";
            if(!number){
              alert("Please enter a Smartcard/IUC/Customer Number.");
              return;
            }
            const plan = plans[selectedProvider][selectedPlanIdx];
            showConfirmSheet({
              provider: selectedProvider,
              plan,
              number
            });
          }
        });
      }
      document.getElementById('paynowBtn').addEventListener('click', function() {
        hideConfirmSheet();
        alert('Processing payment...');
      });
    });
  </script>
</body>
</html>

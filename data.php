<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Buy Data</title>
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
      color: #ffffff;
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
      max-width: 380px;
      width: calc(100% - 40px);
      margin: 12px auto;
      margin-top: -7px;
      padding: 12px;
    }
    .card {
      background: #ffffff;
      border: 0;
      border-radius: 12px;
      padding: 12px;
    }

    /* Increased service provider icon size */
    .provider-icons {
      display: flex;
      justify-content: space-between;
      gap: 8px;
      margin-bottom: 12px;
    }
    .provider-icons img {
      width: 58px;
      height: 58px;
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

    .recent-list-head {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 2px;
    }
    .recent-list-label {
      font-size: 0.70rem;
      color: #444;
      margin-bottom: 4px;
      font-weight: 500;
      line-height: 1;
      padding-left: 2px;
    }
    .recent-numbers-line {
      display: flex;
      gap: 10px;
      margin-bottom: 10px;
      flex-wrap: wrap;
    }
    .recent-number-item {
      display: flex;
      align-items: center;
      gap: 5px;
      cursor: pointer;
      padding: 2px 8px;
      border-radius: 10px;
      transition: background 0.08s;
      background: #f5f5f5;
      min-width: 0;
    }
    .recent-number-item:active, .recent-number-item:focus-visible {
      background: #e0ffef;
      outline: 1.5px solid #00b87540;
    }
    .recent-number-icon {
      background: #f2fdf7;
      border-radius: 50%;
      width: 26px;
      height: 26px;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 1px 2px rgba(0,0,0,0.03);
    }
    .recent-number-icon .bi {
      font-size: 0.60rem;
      color: var(--brand);
    }
    .recent-number-text {
      font-size: 0.81rem;
      color: #222;
      font-weight: 500;
      letter-spacing: 0.2px;
      white-space: nowrap;
      user-select: none;
    }

    .data-plan-tabs {
      display: flex;
      justify-content: space-between;
      gap: 10px;
      margin-bottom: 15px;
      background: #f5f5f5;
      border-radius: 10px;
      padding: 5px 5px 5px 8px;
    }
    .data-tab-btn {
      flex: 1 1 0;
      background: none;
      border: none;
      outline: none;
      font-size: 0.92rem;
      color: #555;
      padding: 8px 0 7px 0;
      border-radius: 8px;
      font-weight: 500;
      transition: color 0.10s, background 0.10s;
      cursor: pointer;
      min-width: 0;
      letter-spacing: 0.1px;
    }
    .data-tab-btn.active, .data-tab-btn:active, .data-tab-btn:focus {
      background: var(--brand);
      color: #fff;
      font-weight: 700;
    }

    .data-plan-scrollbox {
      max-height: 420px;
      min-height: 120px;
      overflow-y: auto;
      background: #f8fff8;
      border: 1px solid #e7f9ef;
      border-radius: 14px;
      box-shadow: 0 2px 8px 0 rgba(0,184,117,0.04);
      padding: 6px 4px 4px 4px;
    }
    .data-plan-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 12px;
      margin-top: 8px;
      margin-bottom: 8px;
    }
    .dataplan-card {
      background: #f8fff8;
      border: 1px solid #e7f9ef;
      border-radius: 10px;
      padding: 8px 6px 9px 6px;
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
      font-size: 0.70rem;
      color: #099e60;
      font-weight: 700;
      margin-bottom: 1px;
    }
    .dataplan-price {
      color: #333;
      font-size: 0.83rem;
      font-weight: 500;
      margin-bottom: 0;
    }
    .dataplan-valid {
      color: #5f5f5f;
      font-size: 0.76rem;
      margin-top: 2px;
    }

    .phone-label {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 6px;
      font-size: 0.85rem;
    }
    .phone-row {
      display: flex;
      gap: 8px;
      align-items: center;
    }
    .phone-row .form-control {
      flex: 1 1 auto;
      padding-right: 12px;
    }
    .beneficiary-btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      min-width: 40px;
      height: 40px;
      border-radius: 10px;
      background: #f5f5f5;
      border: 1px solid rgba(0,0,0,0.06);
      color: #333;
      font-size: 1rem;
    }
    .beneficiary-btn:active, .beneficiary-btn:focus {
      outline: none;
      box-shadow: none;
    }
    .form-control, .form-switch {
      border-radius: 12px;
    }
    .small-muted {
      font-size: 0.78rem;
      color: #6b6b6b;
    }
    .form-check-input {
      width: 2.2rem;
      height: 1.25rem;
      border-radius: 1.25rem;
    }
    #continueBtn {
      background: #00b875;
      border: none;
      border-radius: 12px;
      color: #fff;
      opacity: 1;
      cursor: pointer;
      margin-top: 14px;
      transition: background 0.12s, opacity 0.12s;
    }
    #continueBtn:disabled, #continueBtn[disabled] {
      opacity: 0.55 !important;
      cursor: not-allowed;
      box-shadow: none;
    }

    /* Slide-up (Bottom Sheet) for confirmation */
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
      font-size: 0.90rem;
      color: #444;
      font-weight: 500;
    }
    .confirm-row-value {
      font-size: 0.90rem;
      color: #111;
      font-weight: 600;
      text-align: right;
      display: flex;
      align-items: center;
      gap: 7px;
    }
    .confirm-network-icon {
      width: 20px; height: 20px; border-radius: 8px; margin-right: 2px; background: #f7f7f7;
      object-fit: contain; border:1.5px solid #eff;
      box-shadow: 0 1px 7px rgba(0,184,117,0.04);
    }
    .paynow-btn {
      width: 100%;
      margin-top: 15px;
      padding: 9px 0;
      border: none;
      border-radius: 12px;
      background: var(--brand);
      color: #fff;
      font-size: 1rem;
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
    @media (max-width: 550px) {
      .confirm-sheet { max-width: 100vw; }
    }
    @media (max-width: 360px) {
      .card-wrap { width: calc(100% - 24px); padding: 10px; }
      .recent-numbers-line { gap: 4px;}
      .recent-number-item { padding: 1px 3px;}
      .recent-number-icon { width: 20px; height: 20px; }
      .recent-number-text { font-size: 0.60rem; }
      .provider-icons img { width: 42px; height: 42px;}
      .data-plan-scrollbox {max-height:160px;}
    }
  </style>
</head>
<body>
  <!-- Topbar -->
  <header class="topbar">
    <i class="bi bi-chevron-left" aria-hidden="true"></i>
    <h5>Buy Data</h5>
  </header>

  <main class="card-wrap">
    <section class="card">
      <!-- Provider icons come first -->
      <label class="mb-2">Service Provider</label>
      <div class="provider-icons mb-3">
        <img src="/image/airtel.png" alt="Airtel" data-provider="airtel" />
        <img src="/image/mtn.png" alt="MTN" data-provider="mtn" />
        <img src="/image/glo.png" alt="Glo" data-provider="glo" />
        <img src="/image/9mobile.png" alt="9mobile" data-provider="9mobile" />
      </div>

      <!-- Recent Numbers HEAD and straight line LIST -->
      <div class="recent-list-head mb-1" style="margin-top:8px;">
        <label class="recent-list-label">Recent number</label>
      </div>
      <div class="recent-numbers-line mb-2">
        <div class="recent-number-item" data-ph="08031234567" tabindex="0">
          <span class="recent-number-icon"><i class="bi bi-telephone-fill"></i></span>
          <span class="recent-number-text">08031234567</span>
        </div>
        <div class="recent-number-item" data-ph="09022123456" tabindex="0">
          <span class="recent-number-icon"><i class="bi bi-telephone-fill"></i></span>
          <span class="recent-number-text">09022123456</span>
        </div>
        <div class="recent-number-item" data-ph="08151230192" tabindex="0">
          <span class="recent-number-icon"><i class="bi bi-telephone-fill"></i></span>
          <span class="recent-number-text">08151230192</span>
        </div>
        <div class="recent-number-item" data-ph="07080012341" tabindex="0">
          <span class="recent-number-icon"><i class="bi bi-telephone-fill"></i></span>
          <span class="recent-number-text">07080012341</span>
        </div>
        <div class="recent-number-item" data-ph="07051119111" tabindex="0">
          <span class="recent-number-icon"><i class="bi bi-telephone-fill"></i></span>
          <span class="recent-number-text">07051119111</span>
        </div>
        <div class="recent-number-item" data-ph="08180000006" tabindex="0">
          <span class="recent-number-icon"><i class="bi bi-telephone-fill"></i></span>
          <span class="recent-number-text">08180000006</span>
        </div>
      </div>

      <div class="mb-3">
        <div class="phone-label">
          <label class="form-label mb-0">Phone number</label>
          <button type="button" class="btn btn-link p-0 small-muted" style="text-decoration: none;">Select beneficiary</button>
        </div>
        <div class="phone-row">
          <input type="text" class="form-control" placeholder="Phone number">
          <button type="button" class="beneficiary-btn" title="Choose beneficiary">
            <i class="bi bi-person"></i>
          </button>
        </div>
      </div>

      <!-- Data Plan section: hidden by default, will show when provider selected -->
      <div id="plan-section" style="display:none;">
        <div class="data-plan-tabs mb-2">
          <button class="data-tab-btn active" data-plan="hot">Hot</button>
          <button class="data-tab-btn" data-plan="daily">Daily</button>
          <button class="data-tab-btn" data-plan="weekly">Weekly</button>
          <button class="data-tab-btn" data-plan="monthly">Monthly</button>
        </div>
        <div class="data-plan-scrollbox" id="dataPlanScrollBox">
          <div id="dataPlanGrids"></div>
        </div>
      </div>

      <!-- CONTINUE BUTTON always visible -->
      <button id="continueBtn" class="btn btn-primary w-100 py-2 mt-3" style="background:#00b875" disabled>Continue</button>
    </section>
  </main>

  <!-- Bottom sheet confirmation dialog -->
  <div class="sheet-backdrop" id="sheetBackdrop"></div>
  <div class="confirm-sheet" id="confirmSheet">
    <button class="closer-sheet-btn" id="closeSheetBtn" aria-label="Close">&times;</button>
    <div class="confirm-info-title">Confirm Data Purchase</div>
    <div class="confirm-row">
      <span class="confirm-row-label">Network</span>
      <span class="confirm-row-value" id="sheetNetwork">
        <img class="confirm-network-icon" src="" alt="Network" id="sheetNetworkIcon">
        <span id="sheetNetworkName"></span>
      </span>
    </div>
    <div class="confirm-row">
      <span class="confirm-row-label">Phone number</span>
      <span class="confirm-row-value" id="sheetNumber"></span>
    </div>
    <div class="confirm-row">
      <span class="confirm-row-label">Data Plan</span>
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
    // Provider icon image mapping for dialog
    const providerImages = {
      airtel: "/image/airtel.png",
      mtn: "/image/mtn.png",
      glo: "/image/glo.png",
      '9mobile': "/image/9mobile.png"
    };

    // Provider name mapping
    const providerLabels = {
      airtel: "Airtel",
      mtn: "MTN",
      glo: "Glo",
      "9mobile": "9mobile"
    };

    // Recent number picker logic
    document.querySelectorAll('.recent-number-item').forEach(function(item){
      item.addEventListener('click', function(){
        var phone = this.getAttribute('data-ph');
        var input = document.querySelector('.phone-row input');
        if(input) input.value = phone;
      });
    });

    // Provider selection and plan grid logic
    let selectedProvider = null;
    let selectedPlanIdx = null; // store selected plan's index
    let currentPlanType = "hot";
    document.querySelectorAll('.provider-icons img').forEach(function(img){
      img.addEventListener('click', function() {
        document.querySelectorAll('.provider-icons img').forEach(i => i.classList.remove('selected'));
        this.classList.add('selected');
        selectedProvider = this.getAttribute('data-provider');
        document.getElementById('plan-section').style.display = "block";
        // reset selection on provider switch
        selectedPlanIdx = null;
        renderPlans('hot');
        // tab to initial
        document.querySelectorAll('.data-tab-btn').forEach(btn => btn.classList.remove('active'));
        document.querySelector('.data-tab-btn[data-plan="hot"]').classList.add('active');
        document.getElementById('continueBtn').disabled = true;
      });
    });

    const planData = {
      hot: [
        {size:'500MB', price:'₦120', valid:'1 Day'},
        {size:'1GB',  price:'₦200', valid:'1 Day'},
        {size:'2GB',  price:'₦380', valid:'2 Days'},
        {size:'5GB',  price:'₦850', valid:'5 Days'},
        {size:'10GB', price:'₦1800', valid:'10 Days'},
        {size:'15GB', price:'₦2650', valid:'15 Days'},
        {size:'20GB', price:'₦3350', valid:'20 Days'},
        {size:'40GB', price:'₦6000', valid:'30 Days'},
        {size:'50GB', price:'₦7000', valid:'30 Days'},
        {size:'100GB', price:'₦12000', valid:'30 Days'},
        {size:'150GB', price:'₦16900', valid:'30 Days'},
        {size:'200GB', price:'₦20900', valid:'30 Days'},
        {size:'500GB', price:'₦49900', valid:'90 Days'},
        {size:'1TB', price:'₦79900', valid:'120 Days'}
      ],
      daily: [
        {size:'50MB',  price:'₦50', valid:'1 Day'},
        {size:'100MB', price:'₦90', valid:'1 Day'},
        {size:'200MB', price:'₦130', valid:'1 Day'},
        {size:'500MB', price:'₦150', valid:'1 Day'},
        {size:'1GB',   price:'₦200', valid:'1 Day'},
        {size:'2GB',   price:'₦380', valid:'2 Days'},
        {size:'3GB',   price:'₦550', valid:'3 Days'},
        {size:'5GB',   price:'₦850', valid:'5 Days'}
      ],
      weekly: [
        {size:'350MB', price:'₦230', valid:'7 Days'},
        {size:'750MB', price:'₦500', valid:'7 Days'},
        {size:'1.5GB', price:'₦850', valid:'7 Days'},
        {size:'2.5GB', price:'₦1100', valid:'7 Days'},
        {size:'3.5GB', price:'₦1290', valid:'7 Days'},
        {size:'5GB',   price:'₦1880', valid:'14 Days'},
        {size:'7GB',   price:'₦2450', valid:'14 Days'},
        {size:'9GB',   price:'₦2840', valid:'14 Days'}
      ],
      monthly: [
        {size:'1.5GB',  price:'₦1000', valid:'30 Days'},
        {size:'2GB',    price:'₦1200', valid:'30 Days'},
        {size:'3GB',    price:'₦1450', valid:'30 Days'},
        {size:'5GB',    price:'₦1950', valid:'30 Days'},
        {size:'10GB',   price:'₦3500', valid:'30 Days'},
        {size:'20GB',   price:'₦6600', valid:'30 Days'},
        {size:'40GB',   price:'₦12000', valid:'30 Days'},
        {size:'75GB',   price:'₦20000', valid:'30 Days'}
      ]
    };

    function renderPlans(type) {
      currentPlanType = type;
      selectedPlanIdx = null; // Always reset selection on tab switch
      let btn = document.getElementById('continueBtn');
      if(btn) btn.disabled = true;
      const plans = planData[type] || [];
      let html = `<div class="data-plan-grid">`;
      for (let i = 0; i < plans.length; i++) {
        html += `
          <div class="dataplan-card" tabindex="0" data-idx="${i}">
            <div class="dataplan-size">${plans[i].size}</div>
            <div class="dataplan-price">${plans[i].price}</div>
            <div class="dataplan-valid">${plans[i].valid}</div>
          </div>
        `;
      }
      html += `</div>`;
      document.getElementById('dataPlanGrids').innerHTML = html;

      // Add selection logic (enable continue only when plan selected)
      document.querySelectorAll('#dataPlanGrids .dataplan-card').forEach(function(card, idx){
        card.addEventListener('click', function() {
          document.querySelectorAll('#dataPlanGrids .dataplan-card').forEach(c => c.classList.remove('selected'));
          card.classList.add('selected');
          selectedPlanIdx = idx;
          let btn = document.getElementById('continueBtn');
          if(btn) btn.disabled = false;
        });
        card.addEventListener('keydown', function(e) {
          if(["Enter", " "].includes(e.key)) {
            card.click();
          }
        });
      });
    }

    // Tabs switch
    document.querySelectorAll('.data-tab-btn').forEach(function(tab) {
      tab.addEventListener('click', function() {
        document.querySelectorAll('.data-tab-btn').forEach(b=>b.classList.remove('active'));
        tab.classList.add('active');
        renderPlans(tab.getAttribute('data-plan'));
      });
    });

    // Handle "Continue" click and slide up the confirm sheet
    function showConfirmSheet({provider, plan, type, number}) {
      document.getElementById('sheetNetworkIcon').src = providerImages[provider];
      document.getElementById('sheetNetworkName').textContent = providerLabels[provider] || provider;
      document.getElementById('sheetNumber').textContent = number;
      document.getElementById('sheetPlan').textContent = plan.size + ' (' + plan.valid + ')';
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
            const input = document.querySelector('.phone-row input');
            const number = input ? input.value.trim() : "";
            if(!number){
              alert("Please enter a phone number.");
              return;
            }
            const plan = planData[currentPlanType][selectedPlanIdx];
            showConfirmSheet({
              provider: selectedProvider,
              plan,
              type: currentPlanType,
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

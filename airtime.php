<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Buy Airtime</title>
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

    .promo-carousel {
      border-radius: 12px;
      overflow: hidden;
      margin-bottom: 12px;
    }
    .promo-carousel .carousel-inner img {
      width: 100%;
      height: 100px;
      object-fit: cover;
      display: block;
    }

    .promo-carousel .carousel-indicators {
      bottom: 8px;
    }
    .promo-carousel .carousel-indicators [data-bs-target] {
      width: 8px;
      height: 8px;
      border-radius: 50%;
      background-color: rgba(255,255,255,0.75);
      border: none;
      transition: transform .15s ease;
      margin: 0 4px;
    }
    .promo-carousel .carousel-indicators .active {
      background-color: var(--brand);
      transform: scale(1.2);
    }

    .provider-icons {
      display:flex;
      justify-content:space-between;
      gap:8px;
      margin-bottom: 12px;
    }
    .provider-icons img {
      width: 44px;
      height: 44px;
      border-radius: 10px;
      background: #f5f5f5;
      padding: 8px;
      object-fit:contain;
    }

    /* Recent Numbers straight (not scroll) */
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
      /* ensures single horizontal row, wraps if not enough space */
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

    .form-control, .form-switch {
      border-radius: 12px;
    }

    .amount-box {
      background-color: #f5f5f5;
      border-radius: 16px;
      padding: 12px;
      text-align: center;
    }
    .amount-box .input-group {
      justify-content: center;
      align-items: center;
    }

    .btn-primary {
      background-color: var(--brand);
      border: none;
      border-radius: 12px;
    }
    .btn-primary:hover {
      background-color: var(--brand-dark);
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

    .small-muted {
      font-size: 0.78rem;
      color: #6b6b6b;
    }

    .form-check-input {
      width: 2.2rem;
      height: 1.25rem;
      border-radius: 1.25rem;
    }

    /* Bottom Sheet Styles */
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
    .confirm-sheet {
      position: fixed;
      left: 0;
      right: 0;
      bottom: -100%;
      z-index: 2222;
      background: #fff;
      border-radius: 22px 22px 0 0;
      box-shadow: 0 -4px 24px rgba(0,0,0,0.14);
      padding: 17px 18px 17px 18px;
      transition: bottom 0.32s cubic-bezier(.4,1.01,.55,1);
      max-width: 400px;
      margin-left: auto;
      margin-right: auto;
      border: 1px solid #eee;
      font-size: 0.97rem;
    }
    .confirm-sheet.active {
      bottom: 0;
    }
    .confirm-info-title {
      font-size: 1rem;
      font-weight: 600;
      color: #222;
      text-align: center;
      margin-bottom: 12px;
    }
    .confirm-row {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 11px;
    }
    .confirm-row-label {
      font-size: 0.89rem;
      color: #444;
      font-weight: 500;
    }
    .confirm-row-value {
      font-size: 1.01rem;
      color: #111;
      font-weight: 600;
      text-align: right;
      display: flex;
      align-items: center;
      gap: 7px;
    }
    .confirm-network-icon {
      width: 28px; height: 28px; border-radius: 8px; margin-right: 2px; background: #f7f7f7;
      object-fit: contain; border:1.5px solid #eff;
      box-shadow: 0 1px 7px rgba(0,184,117,0.04);
    }
    .paynow-btn {
      width: 100%;
      margin-top: 14px;
      padding: 9px 0;
      border: none;
      border-radius: 12px;
      background: var(--brand);
      color: #fff;
      font-size: 1.06rem;
      font-weight: bold;
      transition: background .15s;
    }
    .paynow-btn:active { background: var(--brand-dark); }
    .closer-sheet-btn {
      background: none;
      border: none;
      color: #444;
      font-size: 1.27rem;
      position: absolute;
      right: 10px;
      top: 7px;
      z-index: 12;
      opacity: .7;
      cursor: pointer;
      padding: 1px 6px;
      line-height: 1em;
    }
    @media (max-width: 360px) {
      .promo-carousel .carousel-inner img { height: 90px; }
      .card-wrap { width: calc(100% - 24px); padding: 10px; }
      .recent-numbers-line { gap: 4px;}
      .recent-number-item { padding: 1px 3px;}
      .recent-number-icon { width: 20px; height: 20px; }
      .recent-number-text { font-size: 0.60rem; }
      .confirm-network-icon { width: 21px; height: 21px; }
    }
  </style>
</head>
<body>
  <!-- Topbar is now directly on the body -->
  <header class="topbar">
    <i class="bi bi-chevron-left" aria-hidden="true"></i>
    <h5>Buy Airtime</h5>
  </header>

  <main class="card-wrap">
    <section class="card">
      <!-- Carousel with no prev/next controls, touch enabled & auto 10s -->
      <div id="promoCarousel" class="carousel slide promo-carousel" data-bs-ride="carousel" data-bs-interval="10000" data-bs-touch="true" data-bs-pause="false">
        <div class="carousel-indicators">
          <button type="button" data-bs-target="#promoCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
          <button type="button" data-bs-target="#promoCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
          <button type="button" data-bs-target="#promoCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="https://images.unsplash.com/photo-1542228262-4a2b2f4f9a6f?q=80&w=1200&auto=format&fit=crop&ixlib=rb-4.0.3&s=5d8f3f5a60f3f3b5fd4b8b4d7f0b9e0f" class="d-block w-100" alt="promo 1">
          </div>
          <div class="carousel-item">
            <img src="https://images.unsplash.com/photo-1508873696983-2dfd5898f1a9?q=80&w=1200&auto=format&fit=crop&ixlib=rb-4.0.3&s=8f1c1b8b3f8858f5dd1e4794b6b2c8b2" class="d-block w-100" alt="promo 2">
          </div>
          <div class="carousel-item">
            <img src="https://images.unsplash.com/photo-1542744173-8e7e53415bb0?q=80&w=1200&auto=format&fit=crop&ixlib=rb-4.0.3&s=2a2e6f865f4d9b4b9a1b4a3b6c2d8f0a" class="d-block w-100" alt="promo 3">
          </div>
        </div>
      </div>

      <label class="mb-2">Service Provider</label>
      <div class="provider-icons mb-2">
        <img src="/image/airtel.png" alt="airtel" />
        <img src="/image/mtn.png" alt="mtn" />
        <img src="/image/glo.png" alt="glo" />
        <img src="/image/9mobile.png" alt="9mobile" />
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
         <div class="recent-number-item" data-ph="07051119111" tabindex="0">
          <span class="recent-number-icon"><i class="bi bi-telephone-fill"></i></span>
          <span class="recent-number-text">07051119111</span>
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

      <div class="form-check form-switch mb-3">
        <input class="form-check-input" type="checkbox" role="switch" id="saveBeneficiary">
        <label class="form-check-label" for="saveBeneficiary">Save beneficiary</label>
      </div>

      <label class="form-label">Enter Amount</label>
      <div class="amount-box mb-3">
        <div class="input-group">
          <span class="input-group-text">₦</span>
          <input type="number" class="form-control text-center" placeholder="0.00">
        </div>
        <p class="mt-2 mb-0 small-muted">Balance Wallet: <strong>₦0.00</strong> (Available)</p>
      </div>

      <button class="btn btn-primary w-100 py-2" id="continueBtn">Continue</button>
    </section>
  </main>

  <!-- Bottom sheet confirmation dialog -->
  <div class="sheet-backdrop" id="sheetBackdrop"></div>
  <div class="confirm-sheet" id="confirmSheet">
    <button class="closer-sheet-btn" id="closeSheetBtn" aria-label="Close">&times;</button>
    <div class="confirm-info-title">Confirm Airtime Purchase</div>
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
      <span class="confirm-row-label">Amount</span>
      <span class="confirm-row-value" id="sheetAmount"></span>
    </div>
    <button class="paynow-btn mt-2" id="paynowBtn">Pay Now</button>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Ensure carousel is initialized with touch and 10s interval.
    (function(){
      var el = document.getElementById('promoCarousel');
      if (el) {
        var carousel = bootstrap.Carousel.getInstance(el) || new bootstrap.Carousel(el, {
          interval: 10000,
          ride: 'carousel',
          touch: true,
          pause: false,
          wrap: true
        });
      }
    })();

    // Fill phone number input when any number item is clicked
    document.querySelectorAll('.recent-number-item').forEach(function(item){
      item.addEventListener('click', function(){
        var phone = this.getAttribute('data-ph');
        var input = document.querySelector('.phone-row input');
        if(input) input.value = phone;
      });
    });

    // Handle continue button click to show the bottom sheet with purchase details
    function getSelectedProvider() {
      // get src/alt from selected .provider-icons img (provider selection is not implemented, so pick the first matching/non-greyed one)
      const providerIcons = document.querySelectorAll('.provider-icons img');
      for(let img of providerIcons) {
        if(img.classList.contains('selected')) return img;
      }
      // fallback: return first
      return providerIcons[0] || null;
    }
    document.getElementById('continueBtn').addEventListener('click', function() {
      // Provider info
      var providerImg = getSelectedProvider();
      var network = providerImg ? providerImg.alt : '';
      var netSrc = providerImg ? providerImg.src : '';
      // Phone number
      var number = document.querySelector('.phone-row input')?.value?.trim() || '';
      // Amount
      var amount = document.querySelector('.amount-box input[type="number"]')?.value || '';
      // Set details in sheet
      document.getElementById('sheetNetworkIcon').src = netSrc;
      document.getElementById('sheetNetworkIcon').alt = network;
      document.getElementById('sheetNetworkName').textContent = network;
      document.getElementById('sheetNumber').textContent = number;
      document.getElementById('sheetAmount').textContent = amount ? '₦'+Number(amount).toLocaleString() : '₦0.00';

      document.getElementById('sheetBackdrop').classList.add('active');
      document.getElementById('confirmSheet').classList.add('active');
    });
    document.getElementById('sheetBackdrop').addEventListener('click', hideSheet);
    document.getElementById('closeSheetBtn').addEventListener('click', hideSheet);
    function hideSheet() {
      document.getElementById('sheetBackdrop').classList.remove('active');
      document.getElementById('confirmSheet').classList.remove('active');
    }
    document.getElementById('paynowBtn').addEventListener('click', function() {
      hideSheet();
      alert('Processing payment...');
    });
    // Optional: Make provider image selectable for demo
    document.querySelectorAll('.provider-icons img').forEach(function(img){
      img.addEventListener('click', function() {
        document.querySelectorAll('.provider-icons img').forEach(i=>i.classList.remove('selected'));
        this.classList.add('selected');
      }, false);
    });
  </script>
</body>
</html>

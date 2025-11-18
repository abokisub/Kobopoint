<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Wallet Home - Mock</title>

  <!-- Google font -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

  <!-- Font Awesome (classic 'fa fa-' classes) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <style>
    :root{
      --bg:#faf9fb;
      --card:#ffffff;
      --muted:#7b6f93;
      --brand1:#00b875;
      --brand2:#00d98a;
      --accent:linear-gradient(90deg,var(--brand1),var(--brand2));
      --soft-shadow: 0 6px 18px rgba(0,184,117,0.12);
      --glass: rgba(255,255,255,0.7);
      --radius:18px;
      --line:#e9e7ef;
      font-family: 'Poppins',system-ui,-apple-system,Segoe UI,Roboto,"Helvetica Neue",Arial;
    }

    html,body{
      margin:0;
      padding:0;
      background:var(--bg);
      height:auto;
      min-height:100vh;
      overflow-x:hidden;
      overflow-y:auto;
      color:#1b1730;
      -webkit-font-smoothing:antialiased;
      -moz-osx-font-smoothing:grayscale;
    }

    /* Container */
    .app {
      max-width:420px;
      margin:0 auto;
      padding:18px;
      padding-top:80px;
      padding-bottom:80px;
      box-sizing:border-box;
    }
    .page-container {
      display:none;
    }
    .page-container.active {
      display:block;
    }

    /* Header */
    .header{
      position:fixed;
      top:0;
      left:50%;
      transform:translateX(-50%);
      width:100%;
      max-width:420px;
      background:var(--bg);
      padding:18px 18px 14px;
      box-sizing:border-box;
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap:12px;
      z-index:100;
      box-shadow:0 2px 8px rgba(0,0,0,0.02);
      flex-shrink:0;
    }
    .profile {
      display:flex;
      gap:10px;
      align-items:center;
    }
    .avatar{
      width:38px;
      height:38px;
      border-radius:50%;
      background:linear-gradient(180deg,#ffd8b8,#ffb4a2);
      display:flex;
      align-items:center;
      justify-content:center;
      font-weight:700;
      color:#5a2a0a;
      box-shadow:0 3px 8px rgba(0,0,0,0.06);
      flex-shrink:0;
      overflow:hidden;
    }
    .avatar img {
      width:100%;
      height:100%;
      object-fit:cover;
      border-radius:50%;
    }
    .greeting{
      font-size:14px;
      line-height:1;
    }
    .greeting small { 
      color:var(--muted); 
      display:flex; 
      align-items:center; 
      gap:4px;
      font-weight:600; 
    }
    .verified-badge {
      color:#00b875;
      font-size:13px;
    }

    .header-icons {
      display:flex;
      gap:14px;
      align-items:center;
    }
    .header-icon {
      position:relative;
      width:28px;
      height:28px;
      display:flex;
      align-items:center;
      justify-content:center;
      cursor:pointer;
      transition:transform 0.2s;
    }
    .header-icon:active {
      transform:scale(0.9);
    }
    .header-icon i {
      font-size:20px;
      color:#1b1730;
    }
    .orange-badge {
      position:absolute;
      top:2px;
      right:2px;
      width:8px;
      height:8px;
      background:#ff6b35;
      border-radius:50%;
      border:2px solid var(--bg);
    }

    /* Balance card */
    .card{
      background:linear-gradient(135deg, rgba(0,184,117,0.08) 0%, rgba(0,217,138,0.12) 100%);
      backdrop-filter:blur(10px);
      -webkit-backdrop-filter:blur(10px);
      border:1px solid rgba(0,184,117,0.15);
      border-radius:20px;
      padding:20px;
      box-shadow:0 8px 32px rgba(0,184,117,0.1);
      margin-bottom:16px;
    }

    .balance-header {
      margin-bottom:10px;
    }
    .balance-label-text {
      font-size:12px;
      color:var(--muted);
      font-weight:600;
      display:flex;
      align-items:center;
      gap:8px;
    }
    .balance-main-row {
      display:flex;
      align-items:flex-start;
      justify-content:space-between;
      gap:16px;
    }
    .balance-left {
      flex:1;
    }
    .currency-row{
      display:flex;
      align-items:center;
      justify-content:flex-end;
      gap:8px;
      position:relative;
      margin-top:4px;
    }
    .flag-pill{
      display:inline-flex;
      align-items:center;
      gap:8px;
      background: #f6f7fb;
      padding:6px 10px;
      border-radius:999px;
      font-weight:600;
      font-size:14px;
      color:#2c2c4a;
      box-shadow: inset 0 -1px rgba(0,0,0,0.02);
      cursor:pointer;
      position:relative;
      transition:background 0.2s;
    }
    .flag-pill #dropdownArrow {
      transition:transform 0.3s;
    }
    .flag-pill:hover {
      background: #e6f9f3;
    }
    
    /* Currency Dropdown */
    .currency-dropdown {
      position:absolute;
      top:calc(100% + 8px);
      right:0;
      background:var(--card);
      border-radius:12px;
      box-shadow: 0 8px 24px rgba(0,0,0,0.15);
      padding:8px;
      min-width:180px;
      z-index:1000;
      display:none;
      opacity:0;
      transition:opacity 0.2s, transform 0.2s;
    }
    .currency-dropdown.show {
      display:block;
      opacity:1;
    }
    .currency-option {
      display:flex;
      align-items:center;
      gap:10px;
      padding:10px 12px;
      border-radius:8px;
      cursor:pointer;
      transition:background 0.2s;
      font-size:14px;
      font-weight:600;
      color:#2c2c4a;
    }
    .currency-option:hover {
      background:#f6f7fb;
    }
    .currency-option.active {
      background:rgba(0,184,117,0.1);
      color:var(--brand1);
    }
    .currency-option svg {
      flex-shrink:0;
    }
    .currency-option .currency-code {
      flex:1;
    }
    .currency-option .check {
      color:var(--brand1);
      font-size:12px;
    }
    /* balance amount */
    .balance {
      text-align:left;
      font-size:28px;
      font-weight:700;
      letter-spacing: -0.5px;
      margin-bottom:8px;
      display:flex;
      align-items:center;
      justify-content:flex-start;
      gap:8px;
    }
    .eye { 
      color:var(--muted); 
      font-size:16px; 
      cursor:pointer;
    }

    .acc-info-left {
      display:flex;
      align-items:center;
      gap:6px;
      font-size:11px;
      color:var(--muted);
      cursor:pointer;
    }
    .acc-info-left i {
      font-size:12px;
      color:var(--brand1);
    }
    .acc-info-left:hover {
      color:var(--brand1);
    }

    /* quick actions row */
    .actions{
      display:flex;
      gap:14px;
      justify-content:space-between;
      margin-top:10px;
      position:relative;
    }
    .action {
      display:flex;
      align-items:center;
      justify-content:center;
      flex-direction:column;
      gap:6px;
      text-align:center;
      cursor:pointer;
      flex:1;
      min-width:0;
    }
    .action.more-action {
      position:relative;
    }
    .more-dropdown-overlay {
      position:fixed;
      top:0;
      left:0;
      right:0;
      bottom:0;
      background:rgba(0,0,0,0.4);
      z-index:1000;
      display:none;
      opacity:0;
      transition:opacity 0.2s;
    }
    .more-dropdown-overlay.show {
      display:block;
      opacity:1;
    }
    .more-dropdown {
      position:absolute;
      top:calc(100% + 12px);
      right:0;
      background:var(--card);
      border-radius:12px;
      box-shadow: 0 8px 24px rgba(0,0,0,0.15);
      padding:8px;
      min-width:160px;
      z-index:1001;
      display:none;
      opacity:0;
      transition:opacity 0.2s, transform 0.2s;
    }
    .more-dropdown.show {
      display:block;
      opacity:1;
    }
    .more-dropdown-item {
      display:flex;
      align-items:center;
      gap:10px;
      padding:10px 12px;
      border-radius:8px;
      cursor:pointer;
      transition:background 0.2s;
      font-size:13px;
      font-weight:600;
      color:#2c2c4a;
    }
    .more-dropdown-item:hover {
      background:#f6f7fb;
    }
    .more-dropdown-item i {
      color:var(--brand1);
      font-size:12px;
      width:32px;
      height:32px;
      border-radius:50%;
      background:rgba(0,184,117,0.06);
      display:flex;
      align-items:center;
      justify-content:center;
      flex-shrink:0;
    }
    .action-icon-wrapper {
      width:40px;
      height:40px;
      border-radius:50%;
      background: rgba(0,184,117,0.04);
      display:flex;
      align-items:center;
      justify-content:center;
      box-shadow: 0 4px 14px rgba(0,184,117,0.06);
      flex-shrink:0;
      transition:transform 0.2s;
    }
    .action:hover .action-icon-wrapper {
      transform:translateY(-2px);
    }
    .action i { 
      font-size:12px;
      color:var(--brand1);
    }
    .action-text {
      font-size:10px;
      color:var(--brand1);
      font-weight:600;
      margin-top:0;
      line-height:1.2;
      white-space:nowrap;
      overflow:hidden;
      text-overflow:ellipsis;
      max-width:100%;
    }

    /* Account Details Card */
    .account-details-card {
      background:#fff;
      border-radius:12px;
      padding:9px 16px;
      margin:14px 0;
      display:flex;
      align-items:center;
      justify-content:space-between;
      box-shadow:0 2px 8px rgba(0,0,0,0.04);
    }
    .account-left {
      display:flex;
      align-items:center;
      gap:10px;
      flex:1;
    }
    .shop-icon-wrapper {
      width:32px;
      height:32px;
      border-radius:50%;
      background:rgba(0,184,117,0.1);
      display:flex;
      align-items:center;
      justify-content:center;
      color:var(--brand1);
      font-size:14px;
      flex-shrink:0;
    }
    .account-text {
      font-size:13px;
      font-weight:600;
      color:#1b1730;
      letter-spacing:0.3px;
    }
    .copy-icon-wrapper {
      width:32px;
      height:32px;
      border-radius:50%;
      background:rgba(0,184,117,0.1);
      display:flex;
      align-items:center;
      justify-content:center;
      color:var(--brand1);
      font-size:14px;
      cursor:pointer;
      transition:all 0.2s;
      flex-shrink:0;
    }
    .copy-icon-wrapper:hover {
      background:rgba(0,184,117,0.15);
      transform:scale(1.05);
    }
    .copy-icon-wrapper:active {
      transform:scale(0.95);
    }

    /* Action Buttons */
    .action-buttons-row {
      display:flex;
      gap:12px;
      margin:14px 0;
    }
    .action-btn {
      flex:1;
      background:#00b875;
      color:#fff;
      border:none;
      border-radius:12px;
      padding:14px 16px;
      display:flex;
      align-items:center;
      justify-content:center;
      gap:8px;
      font-size:13px;
      font-weight:600;
      cursor:pointer;
      transition:all 0.2s;
      box-shadow:0 4px 12px rgba(0,184,117,0.2);
    }
    .action-btn:hover {
      background:#00a065;
      transform:translateY(-1px);
      box-shadow:0 6px 16px rgba(0,184,117,0.3);
    }
    .action-btn:active {
      transform:translateY(0);
    }
    .action-btn i {
      font-size:16px;
    }

    /* Quick Access */
    .section-head{
      display:flex;
      align-items:center;
      justify-content:space-between;
      margin:6px 0 12px;
    }
    .quick-grid{
      display:grid;
      grid-template-columns:repeat(4, 1fr);
      gap:10px;
      margin-bottom:14px;
    }
    .quick-card{
      background:var(--card);
      border-radius:12px;
      padding:16px 12px;
      box-shadow: 0 6px 16px rgba(32,22,56,0.04);
      display:flex;
      flex-direction:column;
      align-items:center;
      gap:8px;
      text-align:center;
      cursor:pointer;
      transition:all 0.2s;
    }
    .quick-card:hover {
      transform:translateY(-2px);
      box-shadow: 0 8px 20px rgba(32,22,56,0.08);
    }
    .quick-card:active {
      transform:translateY(0);
    }
    .quick-card i{
      width:40px;
      height:40px;
      border-radius:10px;
      display:flex;
      align-items:center;
      justify-content:center;
      background:rgba(0,184,117,0.06);
      color:var(--brand1);
      font-size:16px;
    }
    .quick-card h4{ 
      margin:0; 
      font-size:12px; 
      font-weight:600; 
      color:#1b1730;
    }

    /* Quick Access Dropdown */
    .quick-access-overlay {
      position:fixed;
      top:0;
      left:0;
      right:0;
      bottom:0;
      background:rgba(0,0,0,0.5);
      z-index:1000;
      display:none;
      opacity:0;
      transition:opacity 0.3s;
    }
    .quick-access-overlay.show {
      display:block;
      opacity:1;
    }
    .quick-access-dropdown {
      position:fixed;
      top:50%;
      left:50%;
      transform:translate(-50%, -50%) scale(0.9);
      width:80%;
      max-width:280px;
      background:var(--card);
      border-radius:20px;
      padding:20px 18px;
      box-shadow:0 8px 32px rgba(0,0,0,0.25);
      z-index:1001;
      max-height:70vh;
      overflow-y:auto;
      transition:transform 0.3s ease-out, opacity 0.3s;
      opacity:0;
      display:none;
      pointer-events:none;
    }
    .quick-access-dropdown.show {
      display:block;
      transform:translate(-50%, -50%) scale(1);
      opacity:1;
      pointer-events:auto;
    }
    .quick-access-dropdown-header {
      display:flex;
      align-items:center;
      justify-content:space-between;
      margin-bottom:20px;
      padding-bottom:16px;
      border-bottom:1px solid #f0f0f0;
    }
    .quick-access-dropdown-header h3 {
      margin:0;
      font-size:18px;
      font-weight:700;
      color:#2a2a37;
    }
    .quick-access-dropdown-close {
      width:32px;
      height:32px;
      border-radius:50%;
      background:rgba(0,184,117,0.06);
      display:flex;
      align-items:center;
      justify-content:center;
      color:var(--brand1);
      cursor:pointer;
      font-size:16px;
    }
    .quick-access-dropdown-grid {
      display:grid;
      grid-template-columns:repeat(4, 1fr);
      gap:16px;
      padding-bottom:20px;
    }
    .quick-access-dropdown-item {
      display:flex;
      flex-direction:column;
      align-items:center;
      gap:8px;
      cursor:pointer;
      transition:transform 0.2s;
    }
    .quick-access-dropdown-item:hover {
      transform:translateY(-2px);
    }
    .quick-access-dropdown-icon-wrapper {
      width:56px;
      height:56px;
      border-radius:50%;
      background:rgba(0,184,117,0.06);
      display:flex;
      align-items:center;
      justify-content:center;
      color:var(--brand1);
      font-size:20px;
      flex-shrink:0;
    }
    .quick-access-dropdown-item-text {
      font-size:11px;
      font-weight:600;
      color:#2a2a37;
      text-align:center;
      margin:0;
    }

    /* Recent Transactions */
    .transaction-item {
      display:flex;
      align-items:center;
      gap:12px;
      padding:12px 0;
      border-bottom:1px solid #f0f0f0;
      cursor:pointer;
      transition:background 0.2s;
    }
    .transaction-item:last-child {
      border-bottom:none;
    }
    .transaction-item:hover {
      background:rgba(0,184,117,0.02);
      margin:0 -18px;
      padding-left:18px;
      padding-right:18px;
    }
    .transaction-icon {
      width:36px;
      height:36px;
      border-radius:50%;
      background:rgba(0,184,117,0.06);
      display:flex;
      align-items:center;
      justify-content:center;
      color:var(--brand1);
      font-size:14px;
      flex-shrink:0;
    }
    .transaction-details {
      flex:1;
      min-width:0;
    }
    .transaction-name {
      font-size:12px;
      font-weight:600;
      color:#2a2a37;
      margin:0 0 2px;
    }
    .transaction-date {
      font-size:10px;
      color:var(--muted);
      margin:0;
    }
    .transaction-amount {
      font-size:13px;
      font-weight:700;
      color:#2a2a37;
      text-align:right;
      flex-shrink:0;
    }
    .transaction-amount.positive {
      color:var(--brand1);
    }
    .transaction-amount.negative {
      color:#e74c3c;
    }
    .transactions-list {
      background:var(--card);
      border-radius:16px;
      padding:8px 18px;
      box-shadow:var(--soft-shadow);
      margin-bottom:14px;
    }


    .support-header {
      text-align:center;
      margin-bottom:24px;
    }
    .support-header h2 {
      margin:0;
      font-size:22px;
      font-weight:700;
      color:#1b1730;
    }
    .support-header p {
      margin:8px 0 0;
      font-size:13px;
      color:var(--muted);
    }
    .support-section {
      background:var(--card);
      border-radius:16px;
      padding:18px;
      margin-top:14px;
      margin-bottom:14px;
      box-shadow:var(--soft-shadow);
    }
    .support-item {
      padding:14px 0;
      border-bottom:1px solid #f0f0f0;
      display:flex;
      align-items:flex-start;
      gap:12px;
      cursor:pointer;
      transition:background 0.2s;
    }
    .support-item:hover {
      background:rgba(0,184,117,0.02);
      margin:0 -18px;
      padding-left:18px;
      padding-right:18px;
    }
    .support-item:last-child {
      border-bottom:none;
      padding-bottom:0;
    }
    .support-item-icon {
      width:36px;
      height:36px;
      border-radius:50%;
      background:rgba(0,184,117,0.06);
      display:flex;
      align-items:center;
      justify-content:center;
      color:var(--brand1);
      font-size:16px;
      flex-shrink:0;
    }
    .support-item-content {
      flex:1;
    }
    .support-item-content h4 {
      margin:0 0 4px;
      font-size:14px;
      font-weight:700;
      color:#1b1730;
    }
    .support-item-content p {
      margin:0;
      font-size:12px;
      color:var(--muted);
      line-height:1.5;
    }
    .support-contact {
      background:linear-gradient(90deg,#00b875,#00d98a);
      border-radius:14px;
      padding:18px;
      color:#fff;
      text-align:center;
    }
    .support-contact h3 {
      margin:0 0 8px;
      font-size:16px;
      font-weight:700;
      color:#fff;
    }
    .support-contact p {
      margin:0 0 12px;
      font-size:13px;
      opacity:0.95;
    }
    .support-contact-btn {
      display:inline-block;
      background:rgba(255,255,255,0.2);
      padding:10px 18px;
      border-radius:10px;
      font-weight:600;
      color:#fff;
      text-decoration:none;
      font-size:13px;
    }

    .page-head {
      font-size:24px;
      font-weight:700;
      color:#1b1730;
      margin:0 0 18px;
    }
    .banner {
      background:linear-gradient(90deg, rgba(0,184,117,0.08), rgba(0,184,117,0.02));
      border-radius:14px;
      padding:16px;
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap:12px;
      box-shadow: 0 1px 0 rgba(0,0,0,0.02);
      margin-bottom:18px;
      cursor:pointer;
      transition:transform 0.2s;
    }
    .banner:hover {
      transform:translateY(-2px);
    }
    .banner-left {
      display:flex;
      align-items:center;
      gap:12px;
    }
    .banner-graphic {
      width:52px;
      height:52px;
      border-radius:50%;
      display:grid;
      place-items:center;
      background:rgba(0,184,117,0.06);
      box-shadow: inset 0 -6px 12px rgba(0,184,117,0.06);
      border:6px solid rgba(0,184,117,0.06);
    }
    .banner-graphic i {
      color:var(--brand1);
      font-size:20px;
    }
    .banner-title {
      font-weight:700;
      color:#1b1730;
      font-size:16px;
    }
    .banner-sub {
      font-size:13px;
      color:var(--muted);
      margin-top:4px;
    }
    .banner-arrow {
      width:44px;
      height:44px;
      border-radius:10px;
      display:grid;
      place-items:center;
      background:rgba(0,184,117,0.06);
      color:var(--brand1);
      border:1px solid rgba(0,184,117,0.06);
    }
    .me-card {
      background:var(--card);
      border-radius:14px;
      padding:4px 4px;
      box-shadow:var(--soft-shadow);
      margin-bottom:14px;
      overflow:clip;
    }
    .section-title {
      font-size:11px;
      font-weight:600;
      color:var(--muted);
      padding:8px 4px 6px 4px;
    }
    .list-item {
      display:flex;
      align-items:center;
      gap:10px;
      padding:10px 8px;
      background:transparent;
      cursor:pointer;
      transition:background 0.2s;
    }
    .list-item:hover {
      background:rgba(0,184,117,0.02);
    }
    .list-item + .divider {
      height:1px;
      background:var(--line);
      margin:0 8px;
    }
    .icon-wrap {
      width:38px;
      height:38px;
      border-radius:10px;
      display:grid;
      place-items:center;
      border:1px solid rgba(0,184,117,0.06);
      background:rgba(0,184,117,0.04);
      flex-shrink:0;
    }
    .icon-wrap i {
      font-size:14px;
      color:var(--brand1);
    }
    .item-text {
      flex:1;
    }
    .item-title {
      font-weight:600;
      color:#2a2a37;
      font-size:12px;
    }
    .item-sub {
      font-size:10px;
      color:var(--muted);
      margin-top:2px;
    }
    .chev {
      color:rgba(60,60,70,0.35);
      font-size:11px;
    }

    /* Card Page Styles */
    .card-page {
      padding-bottom:100px;
    }
    .card-display-container {
      margin:18px auto;
      margin-bottom:18px;
      margin-left: 10px;
      margin-right: -80px;
      perspective:1000px;
      cursor:pointer;
      height:140px;
      position:relative;
      width:85%;
      max-width:320px;
      display:block;
    }
    .card-stack {
      position:relative;
      width:100%;
      height:100%;
    }
    .card-display {
      position:absolute;
      top:0;
      left:0;
      width:100%;
      height:160px;
      border-radius:16px;
      padding:16px;
      color:#fff;
      overflow:hidden;
      box-shadow:0 8px 24px rgba(0,184,117,0.2);
      display:flex;
      flex-direction:column;
      justify-content:space-between;
      transition:transform 0.5s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.5s, z-index 0s;
      transform:scale(0.95) translateY(10px);
      opacity:0.6;
      z-index:1;
    }
    .card-display.active {
      transform:scale(1) translateY(0);
      opacity:1;
      z-index:3;
    }
    .card-display.next {
      transform:scale(0.92) translateY(15px);
      opacity:0.4;
      z-index:2;
    }
    .card-display.prev {
      transform:scale(0.92) translateY(15px);
      opacity:0.4;
      z-index:2;
    }
    .card-visa {
      background:linear-gradient(135deg, #00b875 0%, #00d98a 100%);
    }
    .card-mastercard {
      background:linear-gradient(135deg, #eb001b 0%, #f79e1b 100%);
    }
    .card-verve {
      background:linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
    }
    .card-display::before {
      content:'';
      position:absolute;
      top:-50%;
      right:-50%;
      width:200%;
      height:200%;
      background:radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
      pointer-events:none;
    }
    .card-chip {
      width:36px;
      height:28px;
      margin-bottom:12px;
      position:relative;
      z-index:1;
    }
    .card-number {
      display:flex;
      gap:10px;
      font-size:14px;
      font-weight:600;
      letter-spacing:1.5px;
      margin-bottom:16px;
      font-family:'Courier New', monospace;
      position:relative;
      z-index:1;
    }
    .card-number span {
      flex:1;
      text-align:center;
    }
    .card-info-row {
      display:flex;
      justify-content:flex-start;
      align-items:flex-start;
      position:relative;
      z-index:1;
      margin-bottom:12px;
    }
    .card-holder {
      flex:1;
    }
    .card-bottom-row {
      display:flex;
      justify-content:space-between;
      align-items:flex-end;
      position:relative;
      z-index:1;
    }
    .card-expiry {
      text-align:left;
    }
    .card-label {
      font-size:8px;
      opacity:0.8;
      margin-bottom:3px;
      text-transform:uppercase;
      letter-spacing:0.5px;
    }
    .card-value {
      font-size:11px;
      font-weight:700;
      letter-spacing:0.5px;
    }
    .card-logo {
      position:relative;
      z-index:1;
    }
    .visa-logo {
      font-size:18px;
      font-weight:900;
      letter-spacing:1.5px;
      opacity:0.9;
    }
    .mastercard-logo {
      position:relative;
      width:40px;
      height:40px;
    }
    .mc-circle {
      position:absolute;
      width:28px;
      height:28px;
      border-radius:50%;
    }
    .mc-circle-1 {
      background:#eb001b;
      left:0;
      z-index:1;
    }
    .mc-circle-2 {
      background:#f79e1b;
      right:0;
      z-index:2;
    }
    .verve-logo {
      font-size:16px;
      font-weight:900;
      letter-spacing:1px;
      opacity:0.9;
    }
    .card-balance-card {
      background:var(--card);
      border-radius:16px;
      padding:18px;
      margin-top:30px;
      margin-bottom:18px;
      box-shadow:var(--soft-shadow);
      display:flex;
      justify-content:space-between;
      gap:20px;
      clear:both;
    }
    .balance-info {
      flex:1;
    }
    .balance-label {
      font-size:11px;
      color:var(--muted);
      margin-bottom:6px;
      font-weight:600;
    }
    .balance-amount {
      font-size:20px;
      font-weight:700;
      color:#1b1730;
    }
    .balance-amount.spent {
      color:#e74c3c;
    }
    .card-actions {
      display:grid;
      grid-template-columns:repeat(3, 1fr);
      gap:10px;
      margin-bottom:18px;
    }
    .card-action-item {
      display:flex;
      flex-direction:column;
      align-items:center;
      gap:8px;
      padding:12px 8px;
      background:var(--card);
      border-radius:12px;
      cursor:pointer;
      transition:all 0.2s;
      box-shadow:var(--soft-shadow);
    }
    .card-action-item:active {
      transform:scale(0.95);
    }
    .card-action-icon {
      width:34px;
      height:34px;
      border-radius:50%;
      display:flex;
      align-items:center;
      justify-content:center;
      font-size:14px;
      color:var(--brand1);
      background:rgba(0,184,117,0.1);
    }
    .card-action-icon.freeze,
    .card-action-icon.details,
    .card-action-icon.replace,
    .card-action-icon.settings {
      background:rgba(0,184,117,0.1);
    }
    .card-action-text {
      font-size:10px;
      font-weight:600;
      color:#1b1730;
      text-align:center;
      white-space:nowrap;
    }
    .card-settings-section {
      margin-bottom:18px;
    }
    .section-title {
      font-size:14px;
      font-weight:700;
      color:#1b1730;
      margin-bottom:12px;
      padding:0 4px;
    }
    .card-list {
      background:var(--card);
      border-radius:16px;
      padding:8px;
      box-shadow:var(--soft-shadow);
    }
    .card-list-item {
      display:flex;
      align-items:center;
      gap:12px;
      padding:12px 8px;
      cursor:pointer;
      transition:background 0.2s;
      border-radius:12px;
    }
    .card-list-item:hover {
      background:rgba(0,184,117,0.04);
    }
    .card-list-icon {
      width:40px;
      height:40px;
      border-radius:10px;
      background:rgba(0,184,117,0.06);
      display:flex;
      align-items:center;
      justify-content:center;
      color:var(--brand1);
      font-size:16px;
      flex-shrink:0;
    }
    .card-list-content {
      flex:1;
      min-width:0;
    }
    .card-list-title {
      font-size:13px;
      font-weight:600;
      color:#1b1730;
      margin-bottom:2px;
    }
    .card-list-subtitle {
      font-size:11px;
      color:var(--muted);
    }
    .card-list-chev {
      color:rgba(60,60,70,0.35);
      font-size:12px;
    }
    .card-transactions-section {
      margin-bottom:18px;
      padding-bottom:20px;
    }
    .section-header {
      display:flex;
      align-items:center;
      justify-content:space-between;
      margin-bottom:12px;
      padding:0 4px;
    }
    .see-all-link {
      font-size:12px;
      font-weight:600;
      color:var(--brand1);
      cursor:pointer;
    }
    .card-transactions-list {
      background:var(--card);
      border-radius:16px;
      padding:8px 12px;
      box-shadow:var(--soft-shadow);
    }
    .card-transaction-item {
      display:flex;
      align-items:center;
      gap:12px;
      padding:12px 0;
      border-bottom:1px solid #f0f0f0;
    }
    .card-transaction-item:last-child {
      border-bottom:none;
    }
    .card-transaction-icon {
      width:40px;
      height:40px;
      border-radius:50%;
      background:rgba(0,184,117,0.06);
      display:flex;
      align-items:center;
      justify-content:center;
      color:var(--brand1);
      font-size:14px;
      flex-shrink:0;
    }
    .card-transaction-details {
      flex:1;
      min-width:0;
    }
    .card-transaction-name {
      font-size:13px;
      font-weight:600;
      color:#1b1730;
      margin-bottom:2px;
    }
    .card-transaction-date {
      font-size:11px;
      color:var(--muted);
    }
    .card-transaction-amount {
      font-size:14px;
      font-weight:700;
      color:#1b1730;
      flex-shrink:0;
    }
    .card-transaction-amount.negative {
      color:#e74c3c;
    }

    /* bottom nav */
    .bottom-nav{
      position:fixed;
      left:50%;
      transform:translateX(-50%);
      bottom:0;
      width:100%;
      max-width:420px;
      padding:0 18px 8px;
      box-sizing:border-box;
      pointer-events:none;
      z-index:999;
      background:var(--bg);
    }
    .bottom-nav-inner{
      display:flex;
      justify-content:space-between;
      align-items:center;
      background:#ffffff;
      border-radius:12px;
      padding:8px 12px;
      box-shadow: 0 14px 40px rgba(12,8,30,0.06);
      pointer-events:auto;
      position:relative;
      z-index:1000;
    }
    .nav-item{
      display:flex;
      flex-direction:column;
      align-items:center;
      justify-content:center;
      gap:4px;
      color:var(--muted);
      text-decoration:none;
      flex:1;
      padding:8px;
      border-radius:12px;
      transition:all 0.3s;
    }
    .nav-item i {
      font-size:20px;
    }
    .nav-avatar {
      width:20px;
      height:20px;
      border-radius:50%;
      overflow:hidden;
      display:flex;
      align-items:center;
      justify-content:center;
      flex-shrink:0;
      border:2px solid rgba(0,184,117,0.2);
      box-sizing:border-box;
    }
    .nav-avatar img {
      width:100%;
      height:100%;
      object-fit:cover;
      border-radius:50%;
    }
    .nav-item .nav-label {
      font-size:9px;
      font-weight:600;
      margin:0;
    }
    .nav-item.active{
      color:var(--brand1);
      background:rgba(0,184,117,0.1);
    }

    /* small screens tweaks */
    @media(min-width:560px){
      .app { padding:26px; }
    }

  </style>
</head>
<body>
  <!-- Home Page -->
  <div class="app page-container active" id="homePage">
    <!-- Header -->
    <div class="header">
      <div class="profile">
        <div class="avatar">
          <img src="https://my.9jasubplug.com.ng/app/Uploads/male.png" alt="Avatar" />
        </div>
        <div class="greeting">
          <div style="font-size:13px;color:var(--muted)">Hello 👋</div>
          <small>Fawwas <i class="fa fa-check-circle verified-badge"></i></small>
        </div>
      </div>
      <div class="header-icons">
        <div class="header-icon" title="Help & Support">
          <i class="fa fa-headphones" aria-hidden="true"></i>
          <span class="orange-badge"></span>
        </div>
        <div class="header-icon" title="Scan">
          <i class="fa fa-qrcode" aria-hidden="true"></i>
        </div>
        <div class="header-icon" title="Notifications">
          <i class="fa fa-bell" aria-hidden="true"></i>
          <span class="orange-badge"></span>
        </div>
      </div>
    </div>

    <!-- Balance Card -->
    <div class="card">
      <div class="balance-header">
        <div class="balance-label-text">
          Available Balance
          <i class="fa fa-eye-slash eye" title="hidden/visible"></i>
        </div>
      </div>

      <div class="balance-main-row">
        <div class="balance-left">
          <div class="balance">
            <span id="currencySymbol" style="font-size:18px;color:var(--muted);font-weight:700">₦</span>
            <span id="balanceAmount">100,000.00</span>
          </div>
          <div class="acc-info-left">
            <i class="fa fa-clock-o" aria-hidden="true"></i>
            <span>Last updated just now</span>
          </div>
        </div>

        <div class="currency-row">
          <div class="flag-pill" id="currencySelector" onclick="toggleCurrencyDropdown(event)" title="Select currency">
            <!-- Currency icon will be updated by JS -->
            <span id="currencyIcon">
              <svg width="20" height="14" viewBox="0 0 30 20" xmlns="http://www.w3.org/2000/svg" style="border-radius:4px;">
                <rect width="10" height="20" x="0" y="0" fill="#00923f"></rect>
                <rect width="10" height="20" x="10" y="0" fill="#fff"></rect>
                <rect width="10" height="20" x="20" y="0" fill="#00923f"></rect>
              </svg>
            </span>
            <strong style="font-size:13px" id="currencyCode">NGN</strong>
            <i class="fa fa-caret-down" id="dropdownArrow" style="color:var(--muted);font-size:12px"></i>
          </div>
          <div class="currency-dropdown" id="currencyDropdown">
            <div class="currency-option active" onclick="selectCurrency('NGN', '₦')" data-currency="NGN">
              <svg width="20" height="14" viewBox="0 0 30 20" xmlns="http://www.w3.org/2000/svg" style="border-radius:4px;">
                <rect width="10" height="20" x="0" y="0" fill="#00923f"></rect>
                <rect width="10" height="20" x="10" y="0" fill="#fff"></rect>
                <rect width="10" height="20" x="20" y="0" fill="#00923f"></rect>
              </svg>
              <span class="currency-code">NGN</span>
              <i class="fa fa-check check"></i>
            </div>
            <div class="currency-option" onclick="selectCurrency('USDC', '$')" data-currency="USDC">
              <svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" style="border-radius:50%;">
                <circle cx="10" cy="10" r="9" fill="#2775ca"/>
                <path d="M10 4L14 8H11V12H14L10 16L6 12H9V8H6L10 4Z" fill="#fff"/>
              </svg>
              <span class="currency-code">USDC</span>
              <i class="fa fa-check check" style="display:none"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Account Details Card -->
    <div class="account-details-card">
      <div class="account-left">
        <div class="shop-icon-wrapper">
          <i class="fa fa-building"></i>
        </div>
        <div class="account-text">1000001164 RUBIES MFB</div>
      </div>
      <div class="copy-icon-wrapper" onclick="copyAccountNumber()" title="Copy account number">
        <i class="fa fa-copy"></i>
      </div>
    </div>

    <!-- Action Buttons -->
    <div class="action-buttons-row">
      <button class="action-btn" onclick="handleAction('addMoney')">
        <i class="fa fa-plus-circle"></i>
        <span>Add Money</span>
      </button>
      <button class="action-btn" onclick="handleAction('sendMoney')">
        <i class="fa fa-paper-plane"></i>
        <span>Send Money</span>
      </button>
    </div>

    <!-- Quick Access -->
    <div class="section-head">
      <h3 style="margin:0;font-size:16px;">Quick Access</h3>
    </div>

    <div class="quick-grid">
      <div class="quick-card" onclick="handleQuickAction('airtime')">
        <i class="fa fa-phone" aria-hidden="true"></i>
        <h4>Airtime</h4>
      </div>

      <div class="quick-card" onclick="handleQuickAction('internet')">
        <i class="fa fa-wifi" aria-hidden="true"></i>
        <h4>Internet</h4>
      </div>

      <div class="quick-card" onclick="handleQuickAction('exchange')">
        <i class="fa fa-exchange" aria-hidden="true"></i>
        <h4>Exchange</h4>
      </div>

      <div class="quick-card" onclick="toggleQuickAccessDropdown(event)">
        <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
        <h4>More</h4>
      </div>
    </div>

    <!-- Quick Access Dropdown -->
    <div class="quick-access-overlay" id="quickAccessOverlay" onclick="closeQuickAccessDropdown()"></div>
    <div class="quick-access-dropdown" id="quickAccessDropdown">
      <div class="quick-access-dropdown-header">
        <h3>Quick Access</h3>
        <div class="quick-access-dropdown-close" onclick="closeQuickAccessDropdown()">
          <i class="fa fa-times"></i>
        </div>
      </div>
      <div class="quick-access-dropdown-grid">
        <div class="quick-access-dropdown-item">
          <div class="quick-access-dropdown-icon-wrapper">
            <i class="fa fa-phone"></i>
          </div>
          <p class="quick-access-dropdown-item-text">Airtime</p>
        </div>
        <div class="quick-access-dropdown-item">
          <div class="quick-access-dropdown-icon-wrapper">
            <i class="fa fa-wifi"></i>
          </div>
          <p class="quick-access-dropdown-item-text">Data</p>
        </div>
        <div class="quick-access-dropdown-item">
          <div class="quick-access-dropdown-icon-wrapper">
            <i class="fa fa-bolt"></i>
          </div>
          <p class="quick-access-dropdown-item-text">Electricity</p>
        </div>
        <div class="quick-access-dropdown-item">
          <div class="quick-access-dropdown-icon-wrapper">
            <i class="fa fa-tv"></i>
          </div>
          <p class="quick-access-dropdown-item-text">TV Sub</p>
        </div>
        <div class="quick-access-dropdown-item">
          <div class="quick-access-dropdown-icon-wrapper">
            <i class="fa fa-tags"></i>
          </div>
          <p class="quick-access-dropdown-item-text">Bundles</p>
        </div>
        <div class="quick-access-dropdown-item">
          <div class="quick-access-dropdown-icon-wrapper">
            <i class="fa fa-gamepad"></i>
          </div>
          <p class="quick-access-dropdown-item-text">Betting</p>
        </div>
        <div class="quick-access-dropdown-item">
          <div class="quick-access-dropdown-icon-wrapper">
            <i class="fa fa-bitcoin"></i>
          </div>
          <p class="quick-access-dropdown-item-text">Crypto</p>
        </div>
        <div class="quick-access-dropdown-item">
          <div class="quick-access-dropdown-icon-wrapper">
            <i class="fa fa-gift"></i>
          </div>
          <p class="quick-access-dropdown-item-text">Gift Cards</p>
        </div>
        <div class="quick-access-dropdown-item">
          <div class="quick-access-dropdown-icon-wrapper">
            <i class="fa fa-plane"></i>
          </div>
          <p class="quick-access-dropdown-item-text">Travel</p>
        </div>
        <div class="quick-access-dropdown-item">
          <div class="quick-access-dropdown-icon-wrapper">
            <i class="fa fa-credit-card"></i>
          </div>
          <p class="quick-access-dropdown-item-text">Bills</p>
        </div>
        <div class="quick-access-dropdown-item">
          <div class="quick-access-dropdown-icon-wrapper">
            <i class="fa fa-graduation-cap"></i>
          </div>
          <p class="quick-access-dropdown-item-text">Education</p>
        </div>
        <div class="quick-access-dropdown-item">
          <div class="quick-access-dropdown-icon-wrapper">
            <i class="fa fa-heart"></i>
          </div>
          <p class="quick-access-dropdown-item-text">Health</p>
        </div>
      </div>
    </div>

    <!-- Recent Transactions -->
    <div class="section-head">
      <h3 style="margin:0;font-size:16px;">Recent Transactions</h3>
      <a href="#" style="font-size:13px;color:var(--muted);text-decoration:none">See all</a>
    </div>

    <div class="transactions-list">
      <div class="transaction-item">
        <div class="transaction-icon">
          <i class="fa fa-file-text-o"></i>
        </div>
        <div class="transaction-details">
          <div class="transaction-name">Airtime Purchase</div>
          <div class="transaction-date">Today, 2:30 PM</div>
        </div>
        <div class="transaction-amount negative">-₦500.00</div>
      </div>
      <div class="transaction-item">
        <div class="transaction-icon">
          <i class="fa fa-file-text-o"></i>
        </div>
        <div class="transaction-details">
          <div class="transaction-name">Bank Transfer</div>
          <div class="transaction-date">Yesterday, 4:15 PM</div>
        </div>
        <div class="transaction-amount positive">+₦5,000.00</div>
      </div>
      <div class="transaction-item">
        <div class="transaction-icon">
          <i class="fa fa-file-text-o"></i>
        </div>
        <div class="transaction-details">
          <div class="transaction-name">Data Purchase</div>
          <div class="transaction-date">Dec 15, 10:20 AM</div>
        </div>
        <div class="transaction-amount negative">-₦1,000.00</div>
      </div>
      <div class="transaction-item">
        <div class="transaction-icon">
          <i class="fa fa-file-text-o"></i>
        </div>
        <div class="transaction-details">
          <div class="transaction-name">Payment Received</div>
          <div class="transaction-date">Dec 14, 3:45 PM</div>
        </div>
        <div class="transaction-amount positive">+₦10,000.00</div>
      </div>
      <div class="transaction-item">
        <div class="transaction-icon">
          <i class="fa fa-file-text-o"></i>
        </div>
        <div class="transaction-details">
          <div class="transaction-name">Electricity Bill</div>
          <div class="transaction-date">Dec 13, 1:10 PM</div>
        </div>
        <div class="transaction-amount negative">-₦2,500.00</div>
      </div>
    </div>
  </div>

  <!-- Support Page -->
  <div class="app page-container support-page" id="supportPage">
    <!-- Header -->
    <div class="header">
      <div class="profile">
        <div class="avatar">
          <img src="https://my.9jasubplug.com.ng/app/Uploads/male.png" alt="Avatar" />
        </div>
        <div class="greeting">
          <div style="font-size:13px;color:var(--muted)">Hello 👋</div>
          <small>Fawwas <i class="fa fa-check-circle verified-badge"></i></small>
        </div>
      </div>
      <div class="header-icons">
        <div class="header-icon" title="Help & Support">
          <i class="fa fa-headphones" aria-hidden="true"></i>
          <span class="orange-badge"></span>
        </div>
        <div class="header-icon" title="Scan">
          <i class="fa fa-qrcode" aria-hidden="true"></i>
        </div>
        <div class="header-icon" title="Notifications">
          <i class="fa fa-bell" aria-hidden="true"></i>
          <span class="orange-badge"></span>
        </div>
      </div>
    </div>

    <header>
      <div class="page-head">Support</div>
    </header>

    <div class="support-section">
      <div class="support-item" onclick="handleSupportAction('ai')">
        <div class="support-item-icon">
          <i class="fa fa-comments"></i>
        </div>
        <div class="support-item-content">
          <h4>Kobopoint</h4>
          <p>Reply instantly</p>
        </div>
      </div>

      <div class="support-item" onclick="handleSupportAction('email')">
        <div class="support-item-icon">
          <i class="fa fa-envelope"></i>
        </div>
        <div class="support-item-content">
          <h4>Email Support</h4>
          <p>Response within 24 hours</p>
        </div>
      </div>

      <div class="support-item" onclick="handleSupportAction('call')">
        <div class="support-item-icon">
          <i class="fa fa-phone"></i>
        </div>
        <div class="support-item-content">
          <h4>Call Support</h4>
          <p>Response instantly</p>
        </div>
      </div>

      <div class="support-item" onclick="handleSupportAction('whatsapp')">
        <div class="support-item-icon">
          <i class="fa fa-whatsapp"></i>
        </div>
        <div class="support-item-content">
          <h4>Chat on WhatsApp</h4>
          <p>Response within 5 minutes</p>
        </div>
      </div>

      <div class="support-item" onclick="handleSupportAction('dispute')">
        <div class="support-item-icon">
          <i class="fa fa-exclamation-triangle"></i>
        </div>
        <div class="support-item-content">
          <h4>Report a Dispute</h4>
          <p>File a complaint or report an issue</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Card Page -->
  <div class="app page-container card-page" id="cardPage">
    <!-- Header -->
    <div class="header">
      <div class="profile">
        <div class="avatar">
          <img src="https://my.9jasubplug.com.ng/app/Uploads/male.png" alt="Avatar" />
        </div>
        <div class="greeting">
          <div style="font-size:13px;color:var(--muted)">Hello 👋</div>
          <small>Fawwas <i class="fa fa-check-circle verified-badge"></i></small>
        </div>
      </div>
      <div class="header-icons">
        <div class="header-icon" title="Help & Support">
          <i class="fa fa-headphones" aria-hidden="true"></i>
          <span class="orange-badge"></span>
        </div>
        <div class="header-icon" title="Scan">
          <i class="fa fa-qrcode" aria-hidden="true"></i>
        </div>
        <div class="header-icon" title="Notifications">
          <i class="fa fa-bell" aria-hidden="true"></i>
          <span class="orange-badge"></span>
        </div>
      </div>
    </div>

    <header>
      <div class="page-head">My Card</div>
    </header>

    <!-- Card Display -->
    <div class="card-display-container" onclick="cycleCard()">
      <div class="card-stack">
        <!-- Visa Card -->
        <div class="card-display card-visa active" data-card-type="visa">
          <div class="card-chip">
            <svg width="32" height="24" viewBox="0 0 40 32">
              <rect x="0" y="0" width="40" height="32" rx="4" fill="rgba(255,255,255,0.3)"/>
              <rect x="4" y="4" width="32" height="24" rx="2" fill="rgba(255,255,255,0.2)"/>
            </svg>
          </div>
          <div class="card-number">
            <span>****</span>
            <span>****</span>
            <span>****</span>
            <span>1234</span>
          </div>
          <div class="card-info-row">
            <div class="card-holder">
              <div class="card-label">Card Holder</div>
              <div class="card-value">ANWURII</div>
            </div>
          </div>
          <div class="card-bottom-row">
            <div class="card-expiry">
              <div class="card-label">Expires</div>
              <div class="card-value">12/25</div>
            </div>
            <div class="card-logo">
              <div class="visa-logo">VISA</div>
            </div>
          </div>
        </div>
        
        <!-- Mastercard -->
        <div class="card-display card-mastercard" data-card-type="mastercard">
          <div class="card-chip">
            <svg width="32" height="24" viewBox="0 0 40 32">
              <rect x="0" y="0" width="40" height="32" rx="4" fill="rgba(255,255,255,0.3)"/>
              <rect x="4" y="4" width="32" height="24" rx="2" fill="rgba(255,255,255,0.2)"/>
            </svg>
          </div>
          <div class="card-number">
            <span>****</span>
            <span>****</span>
            <span>****</span>
            <span>5678</span>
          </div>
          <div class="card-info-row">
            <div class="card-holder">
              <div class="card-label">Card Holder</div>
              <div class="card-value">ANWURII</div>
            </div>
          </div>
          <div class="card-bottom-row">
            <div class="card-expiry">
              <div class="card-label">Expires</div>
              <div class="card-value">12/25</div>
            </div>
            <div class="card-logo">
              <div class="mastercard-logo">
                <div class="mc-circle mc-circle-1"></div>
                <div class="mc-circle mc-circle-2"></div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Verve Card -->
        <div class="card-display card-verve" data-card-type="verve">
          <div class="card-chip">
            <svg width="32" height="24" viewBox="0 0 40 32">
              <rect x="0" y="0" width="40" height="32" rx="4" fill="rgba(255,255,255,0.3)"/>
              <rect x="4" y="4" width="32" height="24" rx="2" fill="rgba(255,255,255,0.2)"/>
            </svg>
          </div>
          <div class="card-number">
            <span>****</span>
            <span>****</span>
            <span>****</span>
            <span>9012</span>
          </div>
          <div class="card-info-row">
            <div class="card-holder">
              <div class="card-label">Card Holder</div>
              <div class="card-value">ANWURII</div>
            </div>
          </div>
          <div class="card-bottom-row">
            <div class="card-expiry">
              <div class="card-label">Expires</div>
              <div class="card-value">12/25</div>
            </div>
            <div class="card-logo">
              <div class="verve-logo">VERVE</div>
            </div>
          </div>
        </div>
      </div>
    </div>
<br>
    <!-- Card Balance -->
    <div class="card-balance-card">
      <div class="balance-info">
        <div class="balance-label">Available Balance</div>
        <div class="balance-amount">₦95,000.00</div>
      </div>
      <div class="balance-info">
        <div class="balance-label">Spent This Month</div>
        <div class="balance-amount spent">₦5,000.00</div>
      </div>
    </div>

    <!-- Quick Actions -->
    <div class="card-actions">
      <div class="card-action-item" onclick="handleCardAction('freeze')">
        <div class="card-action-icon freeze">
          <i class="fa fa-lock"></i>
        </div>
        <div class="card-action-text">Freeze Card</div>
      </div>
      <div class="card-action-item" onclick="handleCardAction('details')">
        <div class="card-action-icon details">
          <i class="fa fa-eye"></i>
        </div>
        <div class="card-action-text">View Details</div>
      </div>
      <div class="card-action-item" onclick="handleCardAction('replace')">
        <div class="card-action-icon replace">
          <i class="fa fa-refresh"></i>
        </div>
        <div class="card-action-text">Replace Card</div>
      </div>
    </div>

    <!-- Card Settings Section -->
    <div class="card-settings-section">
      <div class="section-title">Card Management</div>
      <div class="card-list">
        <div class="card-list-item" onclick="handleCardAction('pin')">
          <div class="card-list-icon">
            <i class="fa fa-key"></i>
          </div>
          <div class="card-list-content">
            <div class="card-list-title">Change PIN</div>
            <div class="card-list-subtitle">Update your card PIN</div>
          </div>
          <div class="card-list-chev">
            <i class="fa fa-chevron-right"></i>
          </div>
        </div>
        <div class="card-list-item" onclick="handleCardAction('limits')">
          <div class="card-list-icon">
            <i class="fa fa-sliders"></i>
          </div>
          <div class="card-list-content">
            <div class="card-list-title">Spending Limits</div>
            <div class="card-list-subtitle">Set daily transaction limits</div>
          </div>
          <div class="card-list-chev">
            <i class="fa fa-chevron-right"></i>
          </div>
        </div>
        <div class="card-list-item" onclick="handleCardAction('notifications')">
          <div class="card-list-icon">
            <i class="fa fa-bell-o"></i>
          </div>
          <div class="card-list-content">
            <div class="card-list-title">Card Notifications</div>
            <div class="card-list-subtitle">Manage transaction alerts</div>
          </div>
          <div class="card-list-chev">
            <i class="fa fa-chevron-right"></i>
          </div>
        </div>
      </div>
    </div>

    <!-- Recent Card Transactions -->
    <div class="card-transactions-section">
      <div class="section-header">
        <div class="section-title">Recent Transactions</div>
        <div class="see-all-link" onclick="handleCardAction('allTransactions')">See all</div>
      </div>
      <div class="card-transactions-list">
        <div class="card-transaction-item">
          <div class="card-transaction-icon">
            <i class="fa fa-shopping-bag"></i>
          </div>
          <div class="card-transaction-details">
            <div class="card-transaction-name">Amazon Purchase</div>
            <div class="card-transaction-date">Dec 15, 2:30 PM</div>
          </div>
          <div class="card-transaction-amount negative">-₦3,500.00</div>
        </div>
        <div class="card-transaction-item">
          <div class="card-transaction-icon">
            <i class="fa fa-coffee"></i>
          </div>
          <div class="card-transaction-details">
            <div class="card-transaction-name">Starbucks</div>
            <div class="card-transaction-date">Dec 14, 9:15 AM</div>
          </div>
          <div class="card-transaction-amount negative">-₦1,200.00</div>
        </div>
        <div class="card-transaction-item">
          <div class="card-transaction-icon">
            <i class="fa fa-utensils"></i>
          </div>
          <div class="card-transaction-details">
            <div class="card-transaction-name">Restaurant Payment</div>
            <div class="card-transaction-date">Dec 13, 7:45 PM</div>
          </div>
          <div class="card-transaction-amount negative">-₦2,800.00</div>
        </div>
      </div>
    </div>
  </div>

  <!-- Me/Manage Page -->
  <div class="app page-container me-page" id="mePage">
    <!-- Header -->
    <div class="header">
      <div class="profile">
        <div class="avatar">
          <img src="https://my.9jasubplug.com.ng/app/Uploads/male.png" alt="Avatar" />
        </div>
        <div class="greeting">
          <div style="font-size:13px;color:var(--muted)">Hello 👋</div>
          <small>Fawwas <i class="fa fa-check-circle verified-badge"></i></small>
        </div>
      </div>
      <div class="header-icons">
        <div class="header-icon" title="Help & Support">
          <i class="fa fa-headphones" aria-hidden="true"></i>
          <span class="orange-badge"></span>
        </div>
        <div class="header-icon" title="Scan">
          <i class="fa fa-qrcode" aria-hidden="true"></i>
        </div>
        <div class="header-icon" title="Notifications">
          <i class="fa fa-bell" aria-hidden="true"></i>
          <span class="orange-badge"></span>
        </div>
      </div>
    </div>

    <header>
      <div class="page-head">Manage</div>
    </header>

    <main>
      <!-- Banner -->
      <div class="banner" role="banner" aria-label="Final touches banner" onclick="handleMeAction('final-touches')">
        <div class="banner-left">
          <div class="banner-graphic" aria-hidden="true">
            <i class="fa fa-check-circle"></i>
          </div>
          <div>
            <div class="banner-title">Final Touches <span style="font-size:14px;">🚀</span></div>
            <div class="banner-sub">Just finish these quick tasks!</div>
          </div>
        </div>

        <div class="banner-arrow" title="Go">
          <i class="fa fa-arrow-right"></i>
        </div>
      </div>

      <!-- Account section -->
      <div class="section-title">Account</div>
      <div class="me-card" role="list" aria-label="Account settings">
        <div class="list-item" role="listitem" onclick="handleMeAction('personal-details')">
          <div class="icon-wrap"><i class="fa fa-user"></i></div>
          <div class="item-text">
            <div class="item-title">Personal details</div>
          </div>
          <div class="chev"><i class="fa fa-chevron-right"></i></div>
        </div>
        <div class="divider"></div>

        <div class="list-item" role="listitem" onclick="handleMeAction('account-verification')">
          <div class="icon-wrap"><i class="fa fa-id-card"></i></div>
          <div class="item-text">
            <div class="item-title">Account verification</div>
          </div>
          <div class="chev"><i class="fa fa-chevron-right"></i></div>
        </div>
        <div class="divider"></div>

        <div class="list-item" role="listitem" onclick="handleMeAction('notification')">
          <div class="icon-wrap"><i class="fa fa-bell"></i></div>
          <div class="item-text">
            <div class="item-title">Notification</div>
          </div>
          <div class="chev"><i class="fa fa-chevron-right"></i></div>
        </div>
      </div>

      <!-- Security section -->
      <div class="section-title" style="margin-top:6px;">Security</div>
      <div class="me-card" role="list" aria-label="Security settings">
        <div class="list-item" role="listitem" onclick="handleMeAction('password')">
          <div class="icon-wrap"><i class="fa fa-lock"></i></div>
          <div class="item-text">
            <div class="item-title">Password</div>
          </div>
          <div class="chev"><i class="fa fa-chevron-right"></i></div>
        </div>
        <div class="divider"></div>

        <div class="list-item" role="listitem" onclick="handleMeAction('change-pin')">
          <div class="icon-wrap"><i class="fa fa-key"></i></div>
          <div class="item-text">
            <div class="item-title">Change PIN</div>
          </div>
          <div class="chev"><i class="fa fa-chevron-right"></i></div>
        </div>
      </div>
    </main>
  </div>

  <!-- Bottom nav (fixed) -->
  <div class="bottom-nav" aria-hidden="false">
    <div class="bottom-nav-inner">
      <a class="nav-item active" href="#" onclick="toggleNav(this, 'home'); return false;" data-page="home">
        <i class="fa fa-home"></i>
        <span class="nav-label">Home</span>
      </a>
      <a class="nav-item" href="#" onclick="toggleNav(this, 'card'); return false;" data-page="card">
        <i class="fa fa-credit-card"></i>
        <span class="nav-label">Card</span>
      </a>
      <a class="nav-item" href="#" onclick="toggleNav(this, 'support'); return false;" data-page="support">
        <i class="fa fa-commenting-o"></i>
        <span class="nav-label">Support</span>
      </a>
      <a class="nav-item" href="#" onclick="toggleNav(this, 'me'); return false;" data-page="me">
        <div class="nav-avatar">
          <img src="https://my.9jasubplug.com.ng/app/Uploads/male.png" alt="Avatar" />
        </div>
        <span class="nav-label">Me</span>
      </a>
    </div>
  </div>

  <script>
    // Copy account number
    function copyAccountNumber() {
      const accountNumber = '1000001164';
      navigator.clipboard.writeText(accountNumber).then(function() {
        alert('Account number copied: ' + accountNumber);
      }).catch(function(err) {
        console.error('Could not copy text: ', err);
      });
    }

    // Handle action buttons (Add Money, Send Money)
    function handleAction(action) {
      switch(action) {
        case 'addMoney':
          alert('Add Money feature will open here');
          break;
        case 'sendMoney':
          alert('Send Money feature will open here');
          break;
      }
    }

    // Handle Quick Access actions
    function handleQuickAction(action) {
      switch(action) {
        case 'airtime':
          alert('Buy Airtime feature will open here');
          break;
        case 'internet':
          alert('Buy Internet/Data feature will open here');
          break;
        case 'exchange':
          alert('Exchange feature will open here');
          break;
      }
    }

    let currentCurrency = 'NGN';
    let currentSymbol = '₦';
    let currentBalance = {
      'NGN': '100,000.00',
      'USDC': '500.00'
    };

    function toggleCurrencyDropdown(event) {
      event.stopPropagation();
      const dropdown = document.getElementById('currencyDropdown');
      const arrow = document.getElementById('dropdownArrow');
      
      if (dropdown.classList.contains('show')) {
        dropdown.classList.remove('show');
        arrow.style.transform = 'rotate(0deg)';
      } else {
        dropdown.classList.add('show');
        arrow.style.transform = 'rotate(180deg)';
      }
    }

    function selectCurrency(currency, symbol) {
      currentCurrency = currency;
      currentSymbol = symbol;
      
      // Update displayed currency
      document.getElementById('currencyCode').textContent = currency;
      document.getElementById('currencySymbol').textContent = symbol;
      
      // Update balance
      document.getElementById('balanceAmount').textContent = currentBalance[currency];
      
      // Update active state in dropdown
      document.querySelectorAll('.currency-option').forEach(option => {
        if (option.dataset.currency === currency) {
          option.classList.add('active');
          option.querySelector('.check').style.display = 'block';
        } else {
          option.classList.remove('active');
          option.querySelector('.check').style.display = 'none';
        }
      });
      
      // Update currency icon
      const iconContainer = document.getElementById('currencyIcon');
      if (currency === 'NGN') {
        iconContainer.innerHTML = `
          <svg width="20" height="14" viewBox="0 0 30 20" xmlns="http://www.w3.org/2000/svg" style="border-radius:4px;">
            <rect width="10" height="20" x="0" y="0" fill="#00923f"></rect>
            <rect width="10" height="20" x="10" y="0" fill="#fff"></rect>
            <rect width="10" height="20" x="20" y="0" fill="#00923f"></rect>
          </svg>
        `;
      } else if (currency === 'USDC') {
        iconContainer.innerHTML = `
          <svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" style="border-radius:50%;">
            <circle cx="10" cy="10" r="9" fill="#2775ca"/>
            <path d="M10 4L14 8H11V12H14L10 16L6 12H9V8H6L10 4Z" fill="#fff"/>
          </svg>
        `;
      }
      
      // Close dropdown
      document.getElementById('currencyDropdown').classList.remove('show');
      document.getElementById('dropdownArrow').style.transform = 'rotate(0deg)';
    }

    // Close dropdowns when clicking outside
    document.addEventListener('click', function(event) {
      const currencyDropdown = document.getElementById('currencyDropdown');
      const currencySelector = document.getElementById('currencySelector');
      const moreDropdown = document.getElementById('moreDropdown');
      const moreAction = document.querySelector('.more-action');
      
      // Close currency dropdown if clicking outside
      if (currencySelector && !currencySelector.contains(event.target) && 
          currencyDropdown && !currencyDropdown.contains(event.target)) {
        currencyDropdown.classList.remove('show');
        const arrow = document.getElementById('dropdownArrow');
        if (arrow) arrow.style.transform = 'rotate(0deg)';
      }
      
      // Close more dropdown if clicking outside
      const moreOverlay = document.getElementById('moreDropdownOverlay');
      const isDropdownOpen = moreDropdown && moreDropdown.classList.contains('show');
      
      if (isDropdownOpen) {
        const clickedInsideMoreAction = moreAction && moreAction.contains(event.target);
        const clickedInsideDropdown = moreDropdown && moreDropdown.contains(event.target);
        const clickedOnOverlay = event.target === moreOverlay || (moreOverlay && moreOverlay.contains(event.target));
        
        // Close if clicking outside the action button and dropdown, or if clicking the overlay
        if ((!clickedInsideMoreAction && !clickedInsideDropdown) || clickedOnOverlay) {
          closeMoreDropdown();
        }
      }
    });

    // Toggle navigation
    function toggleNav(element, page) {
      // Remove active class from all nav items
      document.querySelectorAll('.nav-item').forEach(item => {
        item.classList.remove('active');
      });
      // Add active class to clicked item
      element.classList.add('active');

      // Hide all pages
      document.querySelectorAll('.page-container').forEach(container => {
        container.classList.remove('active');
      });

      // Show the selected page
      switch(page) {
        case 'home':
          document.getElementById('homePage').classList.add('active');
          break;
        case 'support':
          document.getElementById('supportPage').classList.add('active');
          break;
        case 'card':
          document.getElementById('cardPage').classList.add('active');
          break;
        case 'me':
          document.getElementById('mePage').classList.add('active');
          break;
      }
    }

    // Handle Me/Manage page actions
    function handleMeAction(action) {
      switch(action) {
        case 'final-touches':
          alert('Final touches tasks will open here');
          break;
        case 'personal-details':
          alert('Personal details page will open here');
          break;
        case 'account-verification':
          alert('Account verification page will open here');
          break;
        case 'notification':
          alert('Notification settings will open here');
          break;
        case 'password':
          alert('Password change page will open here');
          break;
        case 'change-pin':
          alert('Change PIN page will open here');
          break;
      }
    }

    // Quick Access Dropdown
    function toggleQuickAccessDropdown(event) {
      event.stopPropagation();
      const overlay = document.getElementById('quickAccessOverlay');
      const dropdown = document.getElementById('quickAccessDropdown');
      
      overlay.classList.add('show');
      dropdown.classList.add('show');
      document.body.style.overflow = 'hidden';
    }

    function closeQuickAccessDropdown() {
      const overlay = document.getElementById('quickAccessOverlay');
      const dropdown = document.getElementById('quickAccessDropdown');
      
      overlay.classList.remove('show');
      dropdown.classList.remove('show');
      document.body.style.overflow = '';
    }

    // Close dropdown on escape key
    document.addEventListener('keydown', function(event) {
      if (event.key === 'Escape') {
        closeQuickAccessDropdown();
      }
    });

    // Card cycling functionality
    let currentCardIndex = 0;
    const cardTypes = ['visa', 'mastercard', 'verve'];
    
    function cycleCard() {
      const cards = document.querySelectorAll('.card-display');
      cards.forEach(card => {
        card.classList.remove('active', 'next', 'prev');
      });
      
      currentCardIndex = (currentCardIndex + 1) % cardTypes.length;
      
      cards.forEach((card, index) => {
        const cardType = card.dataset.cardType;
        const cardTypeIndex = cardTypes.indexOf(cardType);
        const diff = (cardTypeIndex - currentCardIndex + cardTypes.length) % cardTypes.length;
        
        if (diff === 0) {
          card.classList.add('active');
        } else if (diff === 1) {
          card.classList.add('next');
        } else {
          card.classList.add('prev');
        }
      });
    }
    
    // Initialize card stack on page load
    document.addEventListener('DOMContentLoaded', function() {
      const cards = document.querySelectorAll('.card-display');
      cards.forEach((card, index) => {
        const cardType = card.dataset.cardType;
        const cardTypeIndex = cardTypes.indexOf(cardType);
        
        if (cardTypeIndex === 0) {
          card.classList.add('active');
        } else if (cardTypeIndex === 1) {
          card.classList.add('next');
        } else {
          card.classList.add('prev');
        }
      });
    });

    // Handle Card page actions
    function handleCardAction(action) {
      switch(action) {
        case 'freeze':
          alert('Card freeze/unfreeze feature will open here');
          break;
        case 'details':
          alert('Card details (number, CVV, expiry) will be shown here');
          break;
        case 'replace':
          alert('Card replacement request will open here');
          break;
        case 'settings':
          alert('Card settings will open here');
          break;
        case 'pin':
          alert('Change PIN page will open here');
          break;
        case 'limits':
          alert('Spending limits settings will open here');
          break;
        case 'notifications':
          alert('Card notifications settings will open here');
          break;
        case 'allTransactions':
          alert('All card transactions page will open here');
          break;
        default:
          console.log('Card action:', action);
      }
    }

    // Handle Support page actions
    function handleSupportAction(action) {
      switch(action) {
        case 'ai':
          alert('Kobopoint chat will open here');
          // You can implement AI chat integration here
          break;
        case 'email':
          window.location.href = 'mailto:support@example.com?subject=Support Request';
          break;
        case 'call':
          window.location.href = 'tel:+1234567890';
          break;
        case 'whatsapp':
          window.open('https://wa.me/1234567890', '_blank');
          break;
        case 'dispute':
          alert('Dispute reporting form will open here');
          // You can implement dispute reporting here
          break;
      }
    }

    // Toggle More dropdown
    function toggleMoreDropdown(event) {
      event.stopPropagation();
      const dropdown = document.getElementById('moreDropdown');
      const overlay = document.getElementById('moreDropdownOverlay');
      
      if (dropdown.classList.contains('show')) {
        dropdown.classList.remove('show');
        overlay.classList.remove('show');
        document.body.style.overflow = '';
      } else {
        // Close currency dropdown if open
        const currencyDropdown = document.getElementById('currencyDropdown');
        if (currencyDropdown) {
          currencyDropdown.classList.remove('show');
        }
        overlay.classList.add('show');
        dropdown.classList.add('show');
        document.body.style.overflow = 'hidden';
      }
    }

    function closeMoreDropdown(event) {
      if (event) {
        event.stopPropagation();
      }
      const dropdown = document.getElementById('moreDropdown');
      const overlay = document.getElementById('moreDropdownOverlay');
      if (dropdown) dropdown.classList.remove('show');
      if (overlay) overlay.classList.remove('show');
      document.body.style.overflow = '';
    }

    // Handle More dropdown actions
    function handleMoreAction(action) {
      console.log('Action clicked:', action);
      
      // Handle different actions
      switch(action) {
        case 'settings':
          // Redirect to settings page or show settings modal
          // window.location.href = 'settings';
          break;
        case 'history':
          // Redirect to history page
          // window.location.href = 'history';
          break;
        case 'logout':
          // Handle logout
          // window.location.href = 'logout';
          break;
      }
    }

  </script>

</body>
</html>



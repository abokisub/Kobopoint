<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Send Money</title>

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
    .section-title{ font-size:14px; font-weight:700; color:#2c2c4a; margin:6px 0 12px; }
    .muted{ font-size:12px; color:var(--muted); }
    .option-card{ background:var(--card); border-radius:18px; box-shadow:0 6px 18px rgba(0,0,0,0.06); padding:12px; display:flex; align-items:center; gap:12px; cursor:pointer; }
    .option-card:active{ transform:scale(0.995); }
    .option-icon{ width:48px; height:48px; border-radius:12px; background:#f2fbf7; display:flex; align-items:center; justify-content:center; overflow:hidden; }
    .option-body{ flex:1; }
    .option-title{ font-weight:700; font-size:14px; color:#1b1730; }
    .option-desc{ font-size:12px; color:var(--muted); }
    .chev{ color:#aaa; }
    .stack{ display:flex; flex-direction:column; gap:12px; }
  </style>
</head>
<body>
  <div class="header">
    <div class="back-btn" onclick="window.location.href='/dashboard.php'" title="Back"><i class="fa fa-chevron-left"></i></div>
    <div class="title">Send Money</div>
  </div>
  <div class="app">
    <div class="muted">Send money from your account seamlessly with different method</div>
    <div class="section-title">Select your preference</div>
    <div class="stack">
      <div class="option-card" onclick="window.location.href='/send-money-kobo.php'">
        <div class="option-icon">
          <img src="/assets/img/logo.png" alt="Kobopoint" width="48" height="48" style="object-fit:contain;" />
        </div>
        <div class="option-body">
          <div class="option-title">Kobopoint</div>
          <div class="option-desc">Send money to a Kobopoint account</div>
        </div>
        <div class="chev"><i class="fa fa-chevron-right"></i></div>
      </div>

      <div class="option-card" onclick="window.location.href='/send-money-bank.php'">
        <div class="option-icon">
          <img src="/assets/img/bank-icon.svg" alt="Bank" width="48" height="48" />
        </div>
        <div class="option-body">
          <div class="option-title">Bank Transfer</div>
          <div class="option-desc">Send money to other bank account</div>
        </div>
        <div class="chev"><i class="fa fa-chevron-right"></i></div>
      </div>
    </div>
  </div>

<script>
  // No JS required for selection page yet
</script>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Signup</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');
    :root { --primary-green: #00b875; }
    body { font-family: 'Inter', sans-serif; background-color: #ffffff; }
    .btn-primary { background-color: var(--primary-green); color: white; transition: background-color 0.2s; }
    .btn-primary:hover { background-color: #009e68; }

    /* custom dropdown visuals */
    .custom-select {
      position: relative;
    }
    .custom-select-button {
      display: flex;
      align-items: center;
      justify-content: space-between;
      width: 100%;
      padding: 0.75rem 1rem;
      background: #f9fafb;
      border: 1px solid #e5e7eb;
      border-radius: 0.5rem;
      cursor: pointer;
    }
    .custom-select-list {
      position: absolute;
      z-index: 40;
      width: 100%;
      margin-top: 0.375rem;
      background: white;
      border: 1px solid #e5e7eb;
      border-radius: 0.5rem;
      box-shadow: 0 8px 20px rgba(0,0,0,0.08);
      max-height: 200px;
      overflow: auto;
    }
    .custom-select-item {
      padding: 0.5rem 0.75rem;
      cursor: pointer;
    }
    .custom-select-item:hover, .custom-select-item[aria-selected="true"] {
      background: rgba(0,184,117,0.08);
      color: #064e3b;
    }
    .custom-select-search {
      width: 100%;
      padding: 0.5rem 0.75rem;
      border-bottom: 1px solid #eef2f7;
      outline: none;
    }

    /* slightly tighter spacing before navigation */
    .nav-tight { margin-top: 0.25rem; }
  </style>
</head>
<body class="min-h-screen flex flex-col justify-between">
  <div class="p-6 flex flex-col flex-grow w-full max-w-md mx-auto">

    <!-- Header: arrow above, title below -->
    <header class="mb-3">
      <div class="flex items-center">
        <button aria-label="Go back" id="globalBack" class="p-1 rounded-full text-gray-800 hover:bg-gray-50 transition" onclick="onBack()">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="m15 18-6-6 6-6"/>
          </svg>
        </button>
      </div>
      <div class="mt-3">
        <h1 id="pageTitle" class="text-2xl font-bold text-gray-900">Create account</h1>
        <div class="text-xs text-gray-500">Signup in 4 steps</div>
      </div>
    </header>

    <!-- Step indicator -->
    <div class="mb-3">
      <div class="flex items-center justify-between text-xs text-gray-500 mb-2">
        <span id="stepLabel">Step 1 of 4</span>
        <span id="stepName" class="font-medium text-gray-700">Personal</span>
      </div>
      <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
        <div id="progressBar" class="h-full bg-[var(--primary-green)]" style="width:25%"></div>
      </div>
    </div>

    <main class="flex-grow">
      <!-- reduced vertical spacing (space-y-3) -->
      <form id="signupForm" class="space-y-3" onsubmit="handleSubmit(event)" novalidate>
        <!-- Stage 1 -->
        <div id="stage-1">
          <h2 class="text-gray-700 text-sm font-medium mb-1">Personal</h2>
          <div class="grid grid-cols-2 gap-3">
            <div>
              <label class="text-sm text-gray-600">First name</label>
              <input name="firstName" required type="text" placeholder="First name"
                class="mt-1 w-full px-4 py-3 border border-gray-200 bg-gray-50 rounded-lg focus:ring-1 focus:ring-[#00b875] focus:border-[#00b875]" />
            </div>
            <div>
              <label class="text-sm text-gray-600">Last name</label>
              <input name="lastName" required type="text" placeholder="Last name"
                class="mt-1 w-full px-4 py-3 border border-gray-200 bg-gray-50 rounded-lg focus:ring-1 focus:ring-[#00b875] focus:border-[#00b875]" />
            </div>
          </div>

          <div class="mt-1">
            <label class="text-sm text-gray-600 block mb-1">Gender</label>
            <div class="flex gap-2">
              <label class="flex items-center gap-2 px-3 py-2 rounded-lg border cursor-pointer bg-white">
                <input type="radio" name="gender" value="male" class="accent-[var(--primary-green)]" required/>
                <span class="text-sm text-gray-700">Male</span>
              </label>
              <label class="flex items-center gap-2 px-3 py-2 rounded-lg border cursor-pointer bg-white">
                <input type="radio" name="gender" value="female" class="accent-[var(--primary-green)]" />
                <span class="text-sm text-gray-700">Female</span>
              </label>
              <label class="flex items-center gap-2 px-3 py-2 rounded-lg border cursor-pointer bg-white">
                <input type="radio" name="gender" value="other" class="accent-[var(--primary-green)] />
                <span class="text-sm text-gray-700">Other</span>
              </label>
            </div>
          </div>
        </div>

        <!-- Stage 2: custom dropdown -->
        <div id="stage-2" class="hidden">
          <h2 class="text-gray-700 text-sm font-medium mb-1">Address</h2>

          <!-- Hidden input for form submission -->
          <input type="hidden" name="state" id="stateInput" required />

          <div>
            <label class="text-sm text-gray-600">State</label>
            <div class="custom-select mt-1" id="stateSelect" data-open="false">
              <button type="button" class="custom-select-button" id="stateButton" aria-haspopup="listbox" aria-expanded="false" aria-labelledby="stateLabel">
                <span id="stateLabel" class="text-gray-700">Select state</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="m6 9 6 6 6-6"/></svg>
              </button>

              <div class="custom-select-list hidden" id="stateList" role="listbox" tabindex="-1" aria-label="States list">
                <input type="search" id="stateSearch" class="custom-select-search" placeholder="Search state..." aria-label="Search states" />
                <div id="stateItems">
                  <!-- JS will populate list items -->
                </div>
              </div>
            </div>
          </div>

          <div class="mt-1">
            <label class="text-sm text-gray-600">City</label>
            <input name="city" required type="text" placeholder="City"
              class="mt-1 w-full px-4 py-3 border border-gray-200 bg-gray-50 rounded-lg focus:ring-1 focus:ring-[#00b875] focus:border-[#00b875]" />
          </div>

          <div class="mt-1">
            <label class="text-sm text-gray-600">Street address (optional)</label>
            <input name="address" type="text" placeholder="Street, apartment, etc."
              class="mt-1 w-full px-4 py-3 border border-gray-200 bg-gray-50 rounded-lg focus:ring-1 focus:ring-[#00b875] focus:border-[#00b875]" />
          </div>
        </div>

        <!-- Stage 3 -->
        <div id="stage-3" class="hidden">
          <h2 class="text-gray-700 text-sm font-medium mb-1">Contact & Password</h2>

          <div>
            <label class="text-sm text-gray-600">Phone number</label>
            <input name="phone" required type="tel" placeholder="+234 812 000 0000"
              class="mt-1 w-full px-4 py-3 border border-gray-200 bg-gray-50 rounded-lg focus:ring-1 focus:ring-[#00b875] focus:border-[#00b875]" />
          </div>

          <div class="mt-1">
            <label class="text-sm text-gray-600">Email</label>
            <input name="email" required type="email" placeholder="you@example.com"
              class="mt-1 w-full px-4 py-3 border border-gray-200 bg-gray-50 rounded-lg focus:ring-1 focus:ring-[#00b875] focus:border-[#00b875]" />
          </div>

          <div class="mt-1 grid grid-cols-2 gap-3">
            <div>
              <label class="text-sm text-gray-600">Password</label>
              <div class="relative">
                <input id="password" name="password" required type="password" placeholder="Create password"
                  class="mt-1 w-full px-4 py-3 border border-gray-200 bg-gray-50 rounded-lg pr-10 focus:ring-1 focus:ring-[#00b875] focus:border-[#00b875]" />
                <button type="button" onclick="togglePasswordVisibility('password','eyeIcon')" class="absolute inset-y-0 right-0 flex items-center pr-2">
                  <i id="eyeIcon" data-lucide="eye-off" class="w-5 h-5 text-gray-400"></i>
                </button>
              </div>
            </div>

            <div>
              <label class="text-sm text-gray-600">Confirm</label>
              <div class="relative">
                <input id="confirmPassword" name="passwordConfirm" required type="password" placeholder="Confirm password"
                  class="mt-1 w-full px-4 py-3 border border-gray-200 bg-gray-50 rounded-lg pr-10 focus:ring-1 focus:ring-[#00b875] focus:border-[#00b875]" />
                <button type="button" onclick="togglePasswordVisibility('confirmPassword','eyeIcon2')" class="absolute inset-y-0 right-0 flex items-center pr-2">
                  <i id="eyeIcon2" data-lucide="eye-off" class="w-5 h-5 text-gray-400"></i>
                </button>
              </div>
            </div>
          </div>

          <div class="mt-1">
            <label class="text-sm text-gray-600">Referral username (optional)</label>
            <input name="referral" type="text" placeholder="@referrer"
              class="mt-1 w-full px-4 py-3 border border-gray-200 bg-gray-50 rounded-lg focus:ring-1 focus:ring-[#00b875] focus:border-[#00b875]" />
          </div>
        </div>

        <!-- Stage 4 -->
        <div id="stage-4" class="hidden">
          <h2 class="text-gray-700 text-sm font-medium mb-1">Terms & Review</h2>

          <div class="flex items-start gap-3">
            <input id="terms" name="terms" type="checkbox" required class="mt-1 accent-[var(--primary-green)]" />
            <label for="terms" class="text-sm text-gray-700">I agree to the <a href="#" class="text-[var(--primary-green)] font-medium">Terms & Conditions</a> and <a href="#" class="text-[var(--primary-green)] font-medium">Privacy Policy</a>.</label>
          </div>

          <div class="mt-2 p-3 bg-gray-50 rounded-lg text-sm text-gray-600">
            <strong>Review your info:</strong>
            <div id="reviewBlock" class="mt-2 text-xs text-gray-700 space-y-1"></div>
          </div>
        </div>

        <!-- Message -->
        <div id="formMessage" class="text-sm text-red-600 min-h-[1.25rem]" aria-live="polite"></div>

        <!-- Navigation: reduced top space before buttons (nav-tight) -->
        <div class="flex items-center justify-between nav-tight">
          <button type="button" id="prevBtn" class="inline-flex items-center gap-2 px-3 py-2 rounded-xl border text-gray-700 hover:bg-gray-50" onclick="prevStage()" disabled>
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg>
            Back
          </button>

          <div class="flex gap-2">
            <button type="button" id="nextBtn" class="inline-flex items-center gap-2 px-3 py-2 rounded-xl btn-primary shadow-sm" onclick="nextStage()">
              Next
              <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg>
            </button>
            <button type="submit" id="submitBtn" class="hidden inline-flex items-center gap-2 px-3 py-2 rounded-xl btn-primary shadow-sm">
              Create account
            </button>
          </div>
        </div>

        <!-- footer link -->
        <div class="w-full flex justify-center pt-1">
          <span class="text-sm text-gray-800">Already have an account? <a href="#" class="font-semibold text-[var(--primary-green)] hover:text-[#009e68]">Login</a></span>
        </div>
      </form>
    </main>
  </div>

  <script>
    // lucide icons
    document.addEventListener('DOMContentLoaded', function(){ lucide.createIcons(); });

    // States (36 + FCT)
    const NIGERIA_STATES = [
      "Abia","Adamawa","Akwa Ibom","Anambra","Bauchi","Bayelsa","Benue","Borno",
      "Cross River","Delta","Ebonyi","Edo","Ekiti","Enugu","Gombe","Imo",
      "Jigawa","Kaduna","Kano","Katsina","Kebbi","Kogi","Kwara","Lagos",
      "Nasarawa","Niger","Ogun","Ondo","Osun","Oyo","Plateau","Rivers",
      "Sokoto","Taraba","Yobe","Zamfara","Federal Capital Territory (Abuja)"
    ];

    // Build state items
    const stateItemsContainer = document.getElementById('stateItems');
    const stateList = document.getElementById('stateList');
    const stateButton = document.getElementById('stateButton');
    const stateLabel = document.getElementById('stateLabel');
    const stateInput = document.getElementById('stateInput');
    const stateSearch = document.getElementById('stateSearch');
    let focusedIndex = -1;
    let visibleItems = [];

    function buildStateList() {
      stateItemsContainer.innerHTML = '';
      NIGERIA_STATES.forEach((s, idx) => {
        const div = document.createElement('div');
        div.className = 'custom-select-item text-sm text-gray-700';
        div.setAttribute('role','option');
        div.setAttribute('data-value', s);
        div.setAttribute('tabindex','-1');
        div.textContent = s;
        div.addEventListener('click', () => selectState(s));
        div.addEventListener('mouseenter', () => setFocused(idx));
        stateItemsContainer.appendChild(div);
      });
      visibleItems = Array.from(stateItemsContainer.children);
    }

    function openStateList() {
      stateList.classList.remove('hidden');
      stateButton.setAttribute('aria-expanded','true');
      document.getElementById('stateSelect').dataset.open = 'true';
      stateSearch.value = '';
      filterStates('');
      stateSearch.focus();
    }
    function closeStateList() {
      stateList.classList.add('hidden');
      stateButton.setAttribute('aria-expanded','false');
      document.getElementById('stateSelect').dataset.open = 'false';
      focusedIndex = -1;
      visibleItems.forEach(it => it.removeAttribute('aria-selected'));
    }

    function toggleStateList() {
      const open = document.getElementById('stateSelect').dataset.open === 'true';
      if (open) closeStateList(); else openStateList();
    }

    function selectState(value) {
      stateLabel.textContent = value;
      stateInput.value = value;
      closeStateList();
    }

    function filterStates(q) {
      q = String(q || '').toLowerCase().trim();
      visibleItems = [];
      Array.from(stateItemsContainer.children).forEach((child, idx) => {
        const txt = child.textContent.toLowerCase();
        const show = q === '' || txt.includes(q);
        child.style.display = show ? '' : 'none';
        if (show) visibleItems.push(child);
      });
      // reset focus index
      focusedIndex = -1;
    }

    function setFocused(idx) {
      focusedIndex = idx;
      visibleItems.forEach((el, i) => {
        el.setAttribute('aria-selected', i === focusedIndex ? 'true' : 'false');
      });
    }

    // keyboard navigation within dropdown
    function handleStateKeydown(e) {
      if (e.key === 'ArrowDown') {
        e.preventDefault();
        if (visibleItems.length === 0) return;
        focusedIndex = Math.min(visibleItems.length - 1, (focusedIndex + 1));
        setFocused(focusedIndex);
        visibleItems[focusedIndex].scrollIntoView({block:'nearest'});
      } else if (e.key === 'ArrowUp') {
        e.preventDefault();
        if (visibleItems.length === 0) return;
        focusedIndex = Math.max(0, (focusedIndex - 1));
        setFocused(focusedIndex);
        visibleItems[focusedIndex].scrollIntoView({block:'nearest'});
      } else if (e.key === 'Enter') {
        e.preventDefault();
        if (focusedIndex >= 0 && visibleItems[focusedIndex]) {
          const val = visibleItems[focusedIndex].getAttribute('data-value');
          selectState(val);
        }
      } else if (e.key === 'Escape') {
        closeStateList();
        stateButton.focus();
      }
    }

    // close on outside click
    document.addEventListener('click', (ev) => {
      const s = document.getElementById('stateSelect');
      if (!s.contains(ev.target)) closeStateList();
    });

    // initialize dropdown and events
    buildStateList();
    stateButton.addEventListener('click', toggleStateList);
    stateSearch.addEventListener('input', (e) => {
      filterStates(e.target.value);
    });
    stateSearch.addEventListener('keydown', handleStateKeydown);
    stateList.addEventListener('keydown', handleStateKeydown);

    // ------- form & navigation logic (same as before) -------
    let currentStage = 1;
    const totalStages = 4;

    function showStage(n) {
      for (let i=1;i<=totalStages;i++){
        const el = document.getElementById('stage-' + i);
        if (el) el.classList.toggle('hidden', i !== n);
      }
      document.getElementById('prevBtn').disabled = (n === 1);
      document.getElementById('nextBtn').classList.toggle('hidden', n === totalStages);
      document.getElementById('submitBtn').classList.toggle('hidden', n !== totalStages);
      currentStage = n;
      updateProgress(n);
      updateStepLabels(n);
      updateReview();
      document.getElementById('formMessage').textContent = '';
    }

    function updateProgress(n) {
      const percent = (n / totalStages) * 100;
      const bar = document.getElementById('progressBar');
      if (bar) bar.style.width = Math.max(25, percent) + '%';
    }

    function updateStepLabels(n) {
      const names = ['Personal', 'Address', 'Contact', 'Confirm'];
      document.getElementById('stepLabel').textContent = `Step ${n} of ${totalStages}`;
      document.getElementById('stepName').textContent = names[n - 1];
    }

    function nextStage() {
      if (!validateStage(currentStage)) return;
      if (currentStage < totalStages) showStage(currentStage + 1);
    }

    function prevStage() {
      if (currentStage > 1) showStage(currentStage - 1);
    }

    function validateStage(stage) {
      const form = document.getElementById('signupForm');
      let valid = true;
      let msg = '';

      if (stage === 1) {
        const fn = form.elements['firstName'].value.trim();
        const ln = form.elements['lastName'].value.trim();
        const genders = form.elements['gender'];
        const genderSelected = genders ? (genders.length ? Array.from(genders).some(r=>r.checked) : genders.checked) : false;
        if (!fn || !ln) { valid = false; msg = 'Please enter your first and last name.'; }
        else if (!genderSelected) { valid = false; msg = 'Please select your gender.'; }
      }

      if (stage === 2) {
        const state = form.elements['state'].value;
        const city = form.elements['city'].value.trim();
        if (!state) { valid = false; msg = 'Please select your state.'; }
        else if (!city) { valid = false; msg = 'Please enter your city.'; }
      }

      if (stage === 3) {
        const phone = form.elements['phone'].value.trim();
        const email = form.elements['email'].value.trim();
        const pwd = form.elements['password'].value;
        const pwd2 = form.elements['passwordConfirm'].value;
        if (!phone) { valid = false; msg = 'Please enter your phone number.'; }
        else if (!email) { valid = false; msg = 'Please enter your email.'; }
        else if (!pwd || pwd.length < 8) { valid = false; msg = 'Password must be at least 8 characters.'; }
        else if (pwd !== pwd2) { valid = false; msg = 'Passwords do not match.'; }
      }

      if (!valid) document.getElementById('formMessage').textContent = msg;
      else document.getElementById('formMessage').textContent = '';
      return valid;
    }

    function updateReview() {
      const form = document.getElementById('signupForm');
      const review = document.getElementById('reviewBlock');
      if (!review) return;
      const fields = {
        'Name': (form.elements['firstName'].value || '') + ' ' + (form.elements['lastName'].value || ''),
        'Gender': (() => {
          const g = form.elements['gender'];
          if (!g) return '';
          if (g.length) {
            const sel = Array.from(g).find(i=>i.checked);
            return sel ? sel.value : '';
          } else {
            return g.checked ? g.value : '';
          }
        })(),
        'State / City': (form.elements['state'].value || '') + ' / ' + (form.elements['city'].value || ''),
        'Address': form.elements['address'].value || '—',
        'Phone': form.elements['phone'].value || '',
        'Email': form.elements['email'].value || '',
        'Referral': form.elements['referral'].value || '—'
      };
      let html = '';
      Object.entries(fields).forEach(([k,v]) => {
        html += `<div><strong class="text-gray-700">${escapeHtml(k)}:</strong> <span class="text-gray-600">${escapeHtml(v)}</span></div>`;
      });
      review.innerHTML = html;
    }

    function escapeHtml(s) { return String(s || '').replaceAll('&','&amp;').replaceAll('<','&lt;').replaceAll('>','&gt;'); }

    function togglePasswordVisibility(inputId, iconId) {
      const input = document.getElementById(inputId);
      const icon = document.getElementById(iconId);
      if (!input) return;
      if (input.type === 'password') { input.type = 'text'; icon.setAttribute('data-lucide','eye'); }
      else { input.type = 'password'; icon.setAttribute('data-lucide','eye-off'); }
      lucide.createIcons();
    }

    function handleSubmit(e) {
      e.preventDefault();
      if (!validateStage(3)) { showStage(3); return; }
      const terms = document.getElementById('terms').checked;
      if (!terms) { document.getElementById('formMessage').textContent = 'You must accept the Terms & Conditions to continue.'; showStage(4); return; }

      const f = new FormData(document.getElementById('signupForm'));
      const payload = {};
      for (const [k,v] of f.entries()) payload[k] = v;

      document.getElementById('formMessage').textContent = '';
      document.getElementById('submitBtn').disabled = true;
      document.getElementById('submitBtn').textContent = 'Creating...';

      setTimeout(() => {
        document.getElementById('submitBtn').textContent = 'Created ✓';
        alert('Account created (simulation). Payload:\n' + JSON.stringify(payload, null, 2));
      }, 900);
    }

    function onBack() {
      if (currentStage > 1) prevStage(); else history.back();
    }

    // init
    showStage(1);
  </script>
</body>
</html>

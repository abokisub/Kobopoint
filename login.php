<!DOCTYPE html>
 <html lang="en">
 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Back Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
     <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');
         
         :root {
             --primary-green: #00b875;
         }
         
         body {
             font-family: 'Inter', sans-serif;
             background-color: #ffffff;
         }

         .btn-primary {
             background-color: var(--primary-green);
             color: white;
             transition: background-color 0.2s;
         }

         .btn-primary:hover {
             background-color: #009e68;
         }
     </style>
 </head>
 <body class="min-h-screen flex flex-col justify-between">
     <div class="p-6 flex flex-col flex-grow w-full max-w-md mx-auto">

         <header class="mb-8">
             <button aria-label="Go back" class="p-1 rounded-full text-gray-800 hover:bg-gray-50 transition">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                     <path d="m15 18-6-6 6-6"/>
                 </svg>
             </button>
         </header>

         <main class="flex-grow">
             <h1 class="text-3xl font-bold mb-1 text-gray-900">Welcome back 😎</h1>
             <p class="text-gray-600 mb-8">Login to your account.</p>

             <form action="#" method="POST" class="space-y-6">

                 <div class="flex justify-between items-end">
                     <label id="input-label" class="text-sm font-medium text-gray-700">Phone number</label>
                     <button type="button" id="toggle-link" onclick="toggleLoginType()" class="text-sm font-medium text-[#00b875] hover:text-[#009e68]">
                         Use Email address
                     </button>
                 </div>
                 
                 <div id="phone-input-group">
                     <input type="tel" placeholder="Enter your phone number"
                         class="w-full px-4 py-3 border border-gray-200 bg-gray-50 rounded-lg focus:ring-1 focus:ring-[#00b875] focus:border-[#00b875] placeholder-gray-400 text-gray-800">
                 </div>


 <div id="email-input-group" class="hidden">
     <input type="email" placeholder="Enter your email address"
         class="w-full px-4 py-3 border border-gray-200 bg-gray-50 rounded-lg focus:ring-1 focus:ring-[#00b875] focus:border-[#00b875] placeholder-gray-400 text-gray-800">
 </div>

     
                 <div>
                     <label class="text-sm font-medium text-gray-700 mb-1 block">Your password</label>
                     <div class="relative">
                         <input type="password" id="password" placeholder="Enter your password"
                             class="w-full px-4 py-3 border border-gray-200 bg-gray-50 rounded-lg focus:ring-1 focus:ring-[#00b875] focus:border-[#00b875] placeholder-gray-400 pr-12 text-gray-800">

                         <button type="button" onclick="togglePasswordVisibility()" 
                             id="eye-btn"
                             class="absolute inset-y-0 right-0 flex items-center pr-3">
                             <i id="eye-icon" data-lucide="eye-off" class="w-5 h-5 text-gray-400"></i>
                         </button>
                     </div>
                 </div>

                 <!-- Forgot Password -->
                 <div class="flex justify-end">
                    <a href="/auth/forget-password" class="text-sm font-medium text-[#00b875] hover:text-[#009e68]">
                         Forgot your password?
                     </a>
                 </div>

                 <!-- LOGIN BUTTON -->
                 <button type="submit" 
                     class="btn-primary w-full py-3 text-base font-semibold rounded-xl shadow-lg hover:shadow-xl transition">
                     Login to your account
                 </button>

                <!-- Inline message area (minimal) -->
                <p id="login-message" class="text-sm mt-2"></p>

                 <!-- Signup link -->
                 <div class="w-full flex justify-center pt-4">
                     <span class="text-sm text-gray-800">
                         New account?
                         <a href="signup.php" class="font-semibold text-[#00b875] hover:text-[#009e68]">Sign up</a>
                     </span>
                 </div>

             </form>
         </main>
     </div>

     <script>
         // Backend API base URL (update this if your backend runs elsewhere)
         let API_BASE = (localStorage.getItem('api_base') || 'http://127.0.0.1:8000').trim();
         // Normalize API_BASE if user saved it without scheme
         if (!/^https?:\/\//i.test(API_BASE)) {
             API_BASE = 'http://' + API_BASE.replace(/^\/+/, '');
             try { localStorage.setItem('api_base', API_BASE); } catch (_) {}
         }
         console.info('Using API_BASE:', API_BASE);

         // Avoid redeclaration errors in preview environments
         if (typeof window.isPhoneLogin === 'undefined') {
             window.isPhoneLogin = true;
         }

         // Initialize Lucide icons safely (in case script loads later)
         document.addEventListener('DOMContentLoaded', function() {
             if (window.lucide && typeof lucide.createIcons === 'function') {
                 lucide.createIcons();
             }
         });

         function toggleLoginType() {
             window.isPhoneLogin = !window.isPhoneLogin;
             document.getElementById('phone-input-group').classList.toggle('hidden');
             document.getElementById('email-input-group').classList.toggle('hidden');
             document.getElementById('toggle-link').textContent = 
                 window.isPhoneLogin ? 'Use Email address' : 'Use Phone number';
             document.getElementById('input-label').textContent = 
                 window.isPhoneLogin ? 'Phone number' : 'Email address';
         }

         function togglePasswordVisibility() {
             const input = document.getElementById('password');
             const icon = document.getElementById('eye-icon');
             if (input.type === 'password') {
                 input.type = 'text';
                 icon.setAttribute('data-lucide', 'eye');
             } else {
                 input.type = 'password';
                 icon.setAttribute('data-lucide', 'eye-off');
             }
             if (window.lucide && typeof lucide.createIcons === 'function') {
                 lucide.createIcons();
             }
         }

         // Wire form submission to backend API without changing layout
         document.addEventListener('DOMContentLoaded', function() {
             const form = document.querySelector('form');
            const msg = document.getElementById('login-message');

            function setMessage(text, type = 'error') {
                if (!msg) return;
                msg.textContent = text || '';
                msg.classList.remove('text-red-600', 'text-green-600');
                msg.classList.add(type === 'success' ? 'text-green-600' : 'text-red-600');
            }
             form.addEventListener('submit', async function(e) {
                 e.preventDefault();
                 // Loading state: disable submit and show progress text
                 const submitBtn = form.querySelector('button[type="submit"]');
                 if (submitBtn) {
                     submitBtn.disabled = true;
                     submitBtn.setAttribute('aria-busy', 'true');
                     // Preserve original text to restore on error
                     if (!submitBtn.dataset.originalText) {
                         submitBtn.dataset.originalText = submitBtn.textContent || 'Login';
                     }
                     submitBtn.textContent = 'Logging in...';
                 }
                 const isPhoneVisible = !document.getElementById('phone-input-group').classList.contains('hidden');
                 const phoneInput = document.querySelector('#phone-input-group input');
                 const emailInput = document.querySelector('#email-input-group input');
                 const passwordInput = document.getElementById('password');

                 const phoneVal = (phoneInput?.value || '').trim();
                 const emailVal = (emailInput?.value || '').trim();
                 const identifier = isPhoneVisible ? phoneVal : emailVal;
                 const looksLikeEmail = /@/.test(identifier);

                 if (!identifier) {
                     setMessage('Please enter your email or phone.', 'error');
                     if (submitBtn) {
                         submitBtn.disabled = false;
                         submitBtn.removeAttribute('aria-busy');
                         submitBtn.textContent = submitBtn.dataset.originalText || 'Login to your account';
                     }
                     return;
                 }
                 if (!passwordInput.value) {
                     setMessage('Please enter your password.', 'error');
                     if (submitBtn) {
                         submitBtn.disabled = false;
                         submitBtn.removeAttribute('aria-busy');
                         submitBtn.textContent = submitBtn.dataset.originalText || 'Login to your account';
                     }
                     return;
                 }

                 const payload = { password: passwordInput.value };
                 // Smart field selection: if the value looks like email, send as email; otherwise send as phone
                 if (looksLikeEmail) {
                     payload.email = identifier;
                 } else {
                     payload.phone = identifier;
                 }

                 try {
                     const res = await fetch(`${API_BASE}/api/login`, {
                         method: 'POST',
                         headers: { 'Content-Type': 'application/json' },
                         body: JSON.stringify(payload),
                     });

                     const data = await res.json().catch(() => ({}));

                    if (res.status === 202 && data.two_factor && data.challenge) {
                        // Redirect to OTP page with challenge and email (if available)
                        const qp = new URLSearchParams({ challenge: data.challenge });
                        if (payload.email) qp.set('email', payload.email);
                        qp.set('context', 'login');
                        window.location.href = '/otp.php?' + qp.toString();
                        return;
                    }

                     if (!res.ok) {
                        // Provide a helpful hint if the server says unauthorized
                        const baseMsg = data.message || 'Login failed';
                        const hint = (res.status === 401 && looksLikeEmail && isPhoneVisible)
                          ? ' Tip: Click "Use Email address" above or just keep typing your email — we auto-detect it.'
                          : '';
                        setMessage(baseMsg + hint, 'error');
                        if (submitBtn) {
                            submitBtn.disabled = false;
                            submitBtn.removeAttribute('aria-busy');
                            submitBtn.textContent = submitBtn.dataset.originalText || 'Login to your account';
                        }
                        return;
                     }
                     localStorage.setItem('kp_token', data.token);
                    setMessage('Login successful. Redirecting...', 'success');
        window.location.replace('/dashboard.php');
                 } catch (err) {
                    setMessage('Network error. Please try again.', 'error');
                     console.error(err);
                     if (submitBtn) {
                         submitBtn.disabled = false;
                         submitBtn.removeAttribute('aria-busy');
                         submitBtn.textContent = submitBtn.dataset.originalText || 'Login to your account';
                     }
                 }
             });
         });
     </script>
 </body>
 </html>

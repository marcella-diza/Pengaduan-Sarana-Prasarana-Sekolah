<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <script>
    try {
      if (localStorage.getItem('sipraska-theme') === 'dark') {
        document.documentElement.classList.add('dark');
      }
    } catch (error) { }
  </script>
  <title>SIPRASKA - Portal Pengaduan Sarana Prasarana Sekolah</title>
  
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
  
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          colors: {
            primary: '#1E40AF',
            secondary: '#2563EB',
            'surface-bright': '#F8FAFC',
            'surface-dark': '#0F172A',
          },
          fontFamily: {
            sans: ['Plus Jakarta Sans', 'sans-serif'],
          }
        }
      }
    }
  </script>
  <style>
    .sidebar-link { color: #475569; transition: background-color .18s ease, color .18s ease, box-shadow .18s ease; }
    .sidebar-link:hover { background: #f1f5f9; color: #1d4ed8; }
    .sidebar-link.active { background: #eff6ff; color: #1d4ed8; box-shadow: inset 3px 0 #2563eb; }
    .dark .sidebar-link { color: #cbd5e1; }
    .dark .sidebar-link:hover, .dark .sidebar-link.active { background: #334155; color: #93c5fd; }
    .dark .sidebar-link.active { box-shadow: inset 3px 0 #60a5fa; }
    #tbl-siswa-histori tr { cursor: pointer; transition: background-color .18s ease; }
    #tbl-siswa-histori tr:hover { background: #f8fafc; }
    .dark #tbl-siswa-histori tr:hover { background: rgb(51 65 85 / .55); }
    #section-profile.profile-layout:not(.hidden) { display: grid; grid-template-columns: minmax(0, 1fr); }
    @media (min-width: 1280px) {
      #section-profile.profile-layout:not(.hidden) { grid-template-columns: minmax(0, 1.3fr) minmax(18rem, .7fr); }
    }
    .school-pattern {
      background-color: #f8fafc;
      background-image: radial-gradient(#cbd5e1 0.75px, transparent 0.75px), radial-gradient(#cbd5e1 0.75px, #f8fafc 0.75px);
      background-size: 30px 30px;
      background-position: 0 0, 15px 15px;
    }
    .dark .school-pattern {
      background-color: #0f172a;
      background-image: radial-gradient(#334155 0.75px, transparent 0.75px), radial-gradient(#334155 0.75px, #0f172a 0.75px);
    }
    body.dashboard-active { height: 100vh; min-height: 0; overflow: hidden; }
    body.dashboard-active #view-dashboard { height: 100vh; min-height: 0; }
    body.dashboard-active #view-dashboard > div { min-height: 0; }
    body.dashboard-active #view-dashboard main { min-height: 0; }
    @media print {
      body { background: #fff !important; }
      #view-auth, #view-dashboard > header, #view-dashboard aside, .report-actions, .report-filters, .report-charts, .report-search, .report-pagination { display: none !important; }
      #view-dashboard, #section-admin-laporan { display: block !important; }
      #view-dashboard > div, #section-admin-laporan { overflow: visible !important; padding: 0 !important; }
      #section-admin-laporan > div { break-inside: avoid; }
      #report-table-wrap { overflow: visible !important; }
      #report-table { min-width: 100% !important; font-size: 9pt !important; }
    }
  </style>
</head>
<body class="bg-slate-50 dark:bg-slate-900 text-slate-800 dark:text-slate-100 font-sans min-h-screen flex flex-col school-pattern antialiased selection:bg-blue-600 selection:text-white transition-colors duration-200">

  <!-- ==================== VIEW 1: AUTHENTICATION (LOGIN & REGISTER) ==================== -->
  <div id="view-auth" class="flex-1 flex items-center justify-center p-4 w-full">
    <div class="w-full max-w-lg bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-slate-100 dark:border-slate-700 overflow-hidden my-auto transition-all">
      
      <!-- HEADER CARD -->
      <div class="p-6 sm:p-8">
        <div class="flex items-center justify-between mb-6">
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center font-bold text-xl shadow-lg shadow-blue-500/30">
              S
            </div>
            <div>
              <span class="font-bold text-xl text-blue-900 dark:text-blue-400 leading-none block">SIPRASKA</span>
              <span class="text-xs text-slate-500 dark:text-slate-400">Pengaduan Sarana Sekolah</span>
            </div>
          </div>
          <span class="px-2.5 py-1 rounded-full bg-blue-50 dark:bg-slate-700 text-blue-600 dark:text-blue-300 font-semibold text-xs">
            v2.4 Prod
          </span>
        </div>

        <!-- TAB ROLE SELECTOR (LOGIN MODE) -->
        <div id="role-selector" class="mb-6 p-1 bg-slate-100 dark:bg-slate-700/50 rounded-xl grid grid-cols-2 gap-1">
          <button id="tab-siswa" onclick="switchRole('siswa')" class="flex items-center justify-center gap-2 py-2.5 px-3 rounded-lg font-semibold text-sm transition-all shadow-sm bg-white dark:bg-slate-800 text-blue-600 dark:text-blue-400">
            <span class="material-symbols-outlined text-[20px]">person</span>
            <span>Siswa</span>
          </button>
          <button id="tab-admin" onclick="switchRole('admin')" class="flex items-center justify-center gap-2 py-2.5 px-3 rounded-lg font-semibold text-sm transition-all text-slate-600 dark:text-slate-300 hover:text-slate-900">
            <span class="material-symbols-outlined text-[20px]">shield_person</span>
            <span>Petugas / Admin</span>
          </button>
        </div>

        <div class="mb-6">
          <h1 id="auth-title" class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Masuk ke Portal</h1>
          <p id="auth-subtitle" class="text-sm text-slate-500 dark:text-slate-400 mt-1">
            Gunakan kredensial resmi sekolah untuk melanjutkan pengaduan.
          </p>
        </div>

        <!-- LOGIN FORM -->
        <form id="form-login" onsubmit="handleLogin(event)" class="space-y-4">
          <div>
            <label id="identity-label" class="block text-sm font-semibold mb-1.5 text-slate-700 dark:text-slate-300">
              NISN / Nomor Induk Siswa
            </label>
            <div class="relative">
              <span class="material-symbols-outlined absolute left-3 top-2.5 text-slate-400 text-[20px]">badge</span>
              <input id="login-identity" type="text" required value="12345678" placeholder="Masukkan 10 digit NISN..." class="w-full h-11 pl-10 pr-4 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">
            </div>
          </div>

          <div>
            <label class="block text-sm font-semibold mb-1.5 text-slate-700 dark:text-slate-300">Kata Sandi</label>
            <div class="relative">
              <span class="material-symbols-outlined absolute left-3 top-2.5 text-slate-400 text-[20px]">lock</span>
              <input id="login-password" type="password" required value="harapan2024" placeholder="Masukkan kata sandi..." class="w-full h-11 pl-10 pr-11 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">
              <button type="button" onclick="togglePasswordVisibility('login-password')" class="absolute right-3 top-2.5 text-slate-400 hover:text-slate-600">
                <span class="material-symbols-outlined text-[20px]">visibility</span>
              </button>
            </div>
          </div>

          <div class="flex items-center justify-between text-xs pt-1">
            <label class="flex items-center gap-2 cursor-pointer select-none">
              <input type="checkbox" checked class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
              <span>Ingat saya</span>
            </label>
            <a href="#" class="text-blue-600 dark:text-blue-400 font-semibold hover:underline">Lupa Sandi?</a>
          </div>

          <button type="submit" class="w-full h-11 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-semibold text-sm transition-all shadow-md flex items-center justify-center gap-2 active:scale-[0.99]">
            <span>Masuk Sekarang</span>
            <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
          </button>
        </form>

        <!-- REGISTER FORM (KHUSUS SISWA) -->
        <form id="form-register" onsubmit="handleRegister(event)" class="space-y-4 hidden">
          <div>
            <label class="block text-sm font-semibold mb-1">NIS (Nomor Induk Siswa)</label>
            <input id="reg-nis" type="text" required placeholder="Contoh: 12345678" class="w-full h-10 px-3 rounded-lg bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-sm focus:ring-2 focus:ring-blue-600">
          </div>
          <div>
            <label class="block text-sm font-semibold mb-1">Nama Lengkap</label>
            <input id="reg-nama" type="text" required placeholder="Nama Siswa..." class="w-full h-10 px-3 rounded-lg bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-sm focus:ring-2 focus:ring-blue-600">
          </div>
          <div>
            <label class="block text-sm font-semibold mb-1">Kelas</label>
            <input id="reg-kelas" type="text" required placeholder="Contoh: XII RPL 1" class="w-full h-10 px-3 rounded-lg bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-sm focus:ring-2 focus:ring-blue-600">
          </div>
          <div>
            <label class="block text-sm font-semibold mb-1">Kata Sandi</label>
            <input id="reg-pass" type="password" required placeholder="Buat kata sandi..." class="w-full h-10 px-3 rounded-lg bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-sm focus:ring-2 focus:ring-blue-600">
          </div>
          <button type="submit" class="w-full h-11 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-semibold text-sm transition-all shadow-md">
            Daftar Akun Sekarang
          </button>
        </form>

        <!-- HINT DOKUMENTASI -->
        <div class="mt-6 p-3 rounded-xl bg-blue-50 dark:bg-slate-700/50 flex items-start gap-3 text-xs text-slate-600 dark:text-slate-300">
          <span class="material-symbols-outlined text-blue-600 dark:text-blue-400 text-[20px] shrink-0">info</span>
          <div>
            <span class="font-semibold block text-slate-800 dark:text-slate-100">Uji Cepat Cepat:</span>
            <span id="hint-credential">Mode Siswa: ID <strong>12345678</strong> / Sandi <strong>harapan2024</strong></span>
          </div>
        </div>

        <!-- LINK SWITCH FORM -->
        <div class="mt-6 text-center text-sm">
          <span id="toggle-prompt" class="text-slate-500">Belum memiliki akun?</span>
          <button type="button" onclick="toggleAuthMode()" id="toggle-link" class="text-blue-600 dark:text-blue-400 font-semibold hover:underline ml-1">
            Daftar Akun Baru
          </button>
        </div>
      </div>

      <!-- FOOTER AUTH -->
      <div class="bg-slate-100 dark:bg-slate-900/50 p-4 border-t border-slate-100 dark:border-slate-700 flex items-center justify-between text-xs text-slate-500">
        <div class="flex items-center gap-1.5">
          <span class="material-symbols-outlined text-[16px] text-blue-600">lock</span>
          <span>Enkripsi 256-Bit SSL SMAN 1 Harapan</span>
        </div>
        <div class="flex items-center gap-1">
          <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
          <span>Sistem Online</span>
        </div>
      </div>
    </div>
  </div>

  <div id="modal-registration-success" class="fixed inset-0 z-[70] hidden items-center justify-center bg-slate-950/50 p-4 backdrop-blur-sm" onclick="if(event.target === this) closeRegistrationSuccess()">
    <section role="dialog" aria-modal="true" aria-labelledby="registration-success-title" class="w-full max-w-sm rounded-2xl border border-slate-200 bg-white p-6 text-center shadow-2xl dark:border-slate-700 dark:bg-slate-800 sm:p-7">
      <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-emerald-100 text-emerald-700 dark:bg-emerald-950/50 dark:text-emerald-300"><span class="material-symbols-outlined text-3xl">check</span></span>
      <h2 id="registration-success-title" class="mt-4 text-xl font-bold text-slate-900 dark:text-white">Pendaftaran Berhasil</h2>
      <p class="mt-2 text-sm leading-6 text-slate-600 dark:text-slate-300">Pendaftaran berhasil! Silakan masuk menggunakan akun Anda.</p>
      <button type="button" onclick="closeRegistrationSuccess()" class="mt-6 inline-flex h-11 w-full items-center justify-center rounded-xl bg-blue-600 px-4 text-sm font-semibold text-white transition hover:bg-blue-700">Masuk Sekarang</button>
    </section>
  </div>

  <!-- ==================== VIEW 2: DASHBOARD MAIN APP (SISWA & ADMIN) ==================== -->
  <div id="view-dashboard" class="h-screen min-h-0 min-w-0 flex flex-1 flex-col overflow-hidden hidden">
    <!-- TOP NAVBAR -->
    <header class="sticky top-0 z-50 flex h-16 shrink-0 items-center justify-between border-b border-slate-200 bg-white px-3 dark:border-slate-700 dark:bg-slate-800 sm:px-6">
      <div class="flex items-center gap-2 sm:gap-3">
        <button id="mobile-menu-toggle" type="button" onclick="toggleMobileSidebar()" aria-label="Buka menu navigasi" aria-controls="dashboard-sidebar" aria-expanded="false" class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 dark:border-slate-700 dark:text-slate-200 dark:hover:bg-slate-700 md:hidden">
          <span id="mobile-menu-icon" class="material-symbols-outlined">menu</span>
        </button>
        <div class="w-8 h-8 rounded-lg bg-blue-600 text-white flex items-center justify-center font-bold">S</div>
        <span class="hidden font-bold text-base text-slate-800 dark:text-white sm:inline sm:text-lg">SIPRASKA</span>
        <span id="user-role-badge" class="rounded bg-blue-100 px-2 py-0.5 text-[10px] font-semibold text-blue-700 dark:bg-blue-900/50 dark:text-blue-300 sm:text-xs">
          Siswa
        </span>
      </div>

      <!-- NOTIFICATIONS & PROFILE MENU -->
      <div class="flex items-center gap-3">
        <div class="relative">
          <button type="button" onclick="toggleNotifications()" aria-label="Notifikasi" aria-expanded="false" aria-controls="notification-panel" class="relative flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-600 transition hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700">
            <span class="material-symbols-outlined">notifications</span>
            <span id="notification-count" class="absolute right-1 top-1 flex h-4 min-w-4 items-center justify-center rounded-full bg-rose-500 px-1 text-[9px] font-bold text-white">0</span>
          </button>
          <div id="notification-panel" role="region" aria-label="Aktivitas terbaru" class="absolute right-0 top-12 z-40 hidden w-[min(20rem,calc(100vw-5rem))] rounded-2xl border border-slate-200 bg-white p-4 shadow-xl dark:border-slate-700 dark:bg-slate-800">
            <div class="mb-3 flex items-center justify-between"><h3 class="font-bold">Aktivitas Terbaru</h3><button type="button" onclick="markNotificationsRead()" class="text-xs font-semibold text-blue-600">Tandai dibaca</button></div>
            <div id="notification-list" class="max-h-64 space-y-3 overflow-y-auto text-sm text-slate-600 dark:text-slate-300"></div>
          </div>
        </div>
        <div id="profile-menu-container" class="relative flex items-center gap-1 sm:gap-2">
          <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-blue-100 text-sm font-bold text-blue-600 dark:bg-slate-700 dark:text-blue-300"><span id="nav-user-avatar">S</span></span>
          <button id="profile-menu-trigger" type="button" onclick="toggleProfileMenu()" aria-label="Menu akun" aria-haspopup="menu" aria-expanded="false" aria-controls="profile-menu" class="inline-flex w-fit max-w-32 items-center gap-2 rounded-lg px-3 py-2 text-left text-sm font-semibold text-slate-800 transition hover:bg-slate-50 dark:text-white dark:hover:bg-slate-700/70 sm:max-w-40 sm:px-4">
            <span id="nav-user-name" class="truncate">Budi Santoso</span>
            <span class="material-symbols-outlined shrink-0 text-lg text-slate-400">expand_more</span>
          </button>
          <div id="profile-menu" role="menu" aria-label="Menu akun" class="absolute right-0 top-full z-50 mt-2 hidden w-fit min-w-0 max-w-[calc(100vw-1rem)] overflow-hidden rounded-xl border border-slate-200 bg-white p-1.5 shadow-xl dark:border-slate-700 dark:bg-slate-800">
            <div class="border-b border-slate-100 px-3 py-2 dark:border-slate-700 sm:hidden"><span id="profile-menu-name" class="block truncate text-sm font-semibold text-slate-800 dark:text-white">Budi Santoso</span><span id="profile-menu-sub" class="mt-1 block truncate text-xs text-slate-500 dark:text-slate-400">NIS: 12345678</span></div>
            <button type="button" role="menuitem" onclick="handleLogout()" class="flex w-full items-center gap-2 rounded-lg px-3 py-2 text-left text-xs font-semibold text-rose-600 transition hover:bg-rose-50 dark:text-rose-300 dark:hover:bg-rose-950/40"><span class="material-symbols-outlined text-base">logout</span><span>Keluar</span></button>
          </div>
        </div>
      </div>
    </header>

    <div class="relative flex min-h-0 min-w-0 flex-1 items-stretch overflow-hidden">
      <button id="mobile-sidebar-backdrop" type="button" aria-label="Tutup menu navigasi" onclick="closeMobileSidebar()" class="fixed inset-x-0 bottom-0 top-16 z-30 hidden bg-slate-950/40 md:hidden"></button>
      <!-- SIDEBAR NAVIGASI (KIRI) -->
      <aside id="dashboard-sidebar" aria-label="Navigasi utama" class="fixed bottom-0 left-0 top-16 z-40 flex w-64 shrink-0 -translate-x-full flex-col border-r border-slate-200 bg-white transition-transform duration-200 dark:border-slate-700 dark:bg-slate-800 md:static md:h-auto md:min-h-0 md:self-stretch md:translate-x-0">
        <!-- MENU UTAMA -->
        <div class="min-h-0 flex-1 overflow-y-auto p-2 sm:p-4">
          <div class="space-y-1">
          <!-- MENU SISWA -->
          <div id="sidebar-siswa-menu" class="space-y-1">
            <button type="button" aria-label="Form Pengaduan" title="Form Pengaduan" onclick="switchTabSiswa('form')" id="btn-siswa-form" class="sidebar-link active w-full flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold">
              <span class="material-symbols-outlined">edit_note</span>
              <span>Form Pengaduan</span>
            </button>
            <button type="button" aria-label="Laporan & Status" title="Laporan & Status" onclick="switchTabSiswa('laporan')" id="btn-siswa-laporan" class="sidebar-link w-full flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold">
              <span class="material-symbols-outlined">history</span>
              <span>Laporan & Status</span>
            </button>
            <button type="button" aria-label="Profil Saya" title="Profil Saya" onclick="switchTabSiswa('profile')" id="btn-siswa-profile" class="sidebar-link w-full flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold">
              <span class="material-symbols-outlined">person</span>
              <span>Profil Saya</span>
            </button>
          </div>

          <!-- MENU ADMIN -->
          <div id="sidebar-admin-menu" class="space-y-1 hidden">
            <button type="button" aria-label="Dashboard" title="Dashboard" onclick="switchTabAdmin('dashboard')" id="btn-admin-dash" class="sidebar-link active w-full flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold">
              <span class="material-symbols-outlined">dashboard</span>
              <span>Dashboard</span>
            </button>
            <button type="button" aria-label="Pengaduan Masuk" title="Pengaduan Masuk" onclick="switchTabAdmin('pengaduan')" id="btn-admin-pengaduan" class="sidebar-link w-full flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold">
              <span class="material-symbols-outlined">inbox</span>
              <span>Pengaduan Masuk</span>
            </button>
            <button type="button" aria-label="Laporan Rekap" title="Laporan Rekap" onclick="switchTabAdmin('laporan')" id="btn-admin-laporan" class="sidebar-link w-full flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold">
              <span class="material-symbols-outlined">assessment</span>
              <span>Laporan Rekap</span>
            </button>
            <button type="button" aria-label="Profil Admin" title="Profil Admin" onclick="switchTabAdmin('profile')" id="btn-admin-profile" class="sidebar-link w-full flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold">
              <span class="material-symbols-outlined">manage_accounts</span>
              <span>Profil Admin</span>
            </button>
          </div>
          </div>
        </div>

        <!-- BOTTOM SIDEBAR: MULTILANGUAGE & THEME SWITCHER -->
        <div class="sticky bottom-0 z-10 mt-auto shrink-0 space-y-2 border-t border-slate-200 bg-white p-3 dark:border-slate-700 dark:bg-slate-900">
          <!-- MULTILANGUAGE -->
          <div class="flex flex-col items-center justify-between gap-1 text-xs sm:flex-row">
            <span class="font-semibold text-slate-600 dark:text-slate-200">Bahasa</span>
            <div class="flex items-center bg-white dark:bg-slate-800 rounded-lg p-0.5 border border-slate-200 dark:border-slate-700">
              <button onclick="setLang('ID')" id="btn-lang-id" class="px-2 py-1 rounded font-bold text-blue-600 bg-blue-50 dark:bg-slate-700">ID</button>
              <button onclick="setLang('EN')" id="btn-lang-en" class="px-2 py-1 rounded font-semibold text-slate-500">EN</button>
            </div>
          </div>

          <!-- THEME SWITCHER -->
          <div class="flex flex-col items-center justify-between gap-1 text-xs sm:flex-row">
            <span class="font-semibold text-slate-600 dark:text-slate-200">Tema</span>
            <button onclick="toggleDarkMode()" aria-label="Ganti tema" class="p-1.5 rounded-lg bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 hover:bg-slate-100 flex items-center gap-1.5 font-semibold">
              <span id="theme-icon" class="material-symbols-outlined text-[16px]">dark_mode</span>
              <span id="theme-text">Dark</span>
            </button>
          </div>
        </div>
      </aside>

      <!-- CONTENT AREA -->
      <main class="min-w-0 flex-1 overflow-x-hidden overflow-y-auto p-4 sm:p-7 bg-gradient-to-br from-slate-50 via-blue-50/40 to-cyan-50/50 dark:from-slate-900 dark:via-slate-900 dark:to-slate-800">
        
        <!-- SECTION SISWA: FORM PENGADUAN -->
        <section id="section-siswa-form" class="mx-auto grid w-full max-w-7xl grid-cols-1 items-start gap-5 xl:grid-cols-[minmax(0,1.55fr)_minmax(18rem,.75fr)]">
          <div class="min-w-0 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-800 sm:p-7">
            <h2 class="text-xl font-bold mb-1 text-slate-800 dark:text-white">Buat Laporan Pengaduan Sarana</h2>
            <p class="text-xs text-slate-500 mb-6">Sampaikan keluhan fasilitas sekolah secara rinci agar segera ditindaklanjuti.</p>

            <form onsubmit="submitAspirasi(event)" class="space-y-4">
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                  <label class="block text-xs font-semibold mb-1">NIS (Otomatis)</label>
                  <input type="text" id="form-nis" readonly value="12345678" class="w-full h-10 px-3 rounded-xl bg-slate-100 dark:bg-slate-700 text-slate-500 text-sm">
                </div>
                <div>
                  <label class="block text-xs font-semibold mb-1">Kelas</label>
                  <input type="text" id="form-kelas" readonly value="XII RPL 1" class="w-full h-10 px-3 rounded-xl bg-slate-100 dark:bg-slate-700 text-slate-500 text-sm">
                </div>
              </div>

              <div>
                  <label for="form-kategori" class="block text-xs font-semibold mb-1">Kategori Sarana Prasarana <span class="text-rose-500" aria-label="wajib diisi">*</span></label>
                <select id="form-kategori" required class="w-full h-10 px-3 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-sm focus:ring-2 focus:ring-blue-600">
                  <option value="Fasilitas Kelas">Fasilitas Kelas</option>
                  <option value="Laboratorium & IT">Laboratorium & IT</option>
                  <option value="Kebersihan & Toilet">Kebersihan & Toilet</option>
                  <option value="Sarana Olahraga">Sarana Olahraga</option>
                </select>
              </div>

              <div>
                <label for="form-lokasi" class="block text-xs font-semibold mb-1">Lokasi Spesifik Kerusakan <span class="text-rose-500" aria-label="wajib diisi">*</span></label>
                <input type="text" id="form-lokasi" required placeholder="Contoh: Ruang Lab Komputer 2 (Proyektor Matil)" class="w-full h-10 px-3 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-sm focus:ring-2 focus:ring-blue-600">
              </div>

              <div>
                <label for="form-ket" class="block text-xs font-semibold mb-1">Keterangan / Deskripsi Kerusakan <span class="text-rose-500" aria-label="wajib diisi">*</span></label>
                <textarea id="form-ket" rows="4" required placeholder="Jelaskan detail masalah sarana..." class="w-full p-3 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-sm focus:ring-2 focus:ring-blue-600"></textarea>
              </div>

              <div>
                <label for="form-urgensi" class="block text-xs font-semibold mb-1">Tingkat Urgensi</label>
                <select id="form-urgensi" class="w-full h-10 px-3 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-sm focus:ring-2 focus:ring-blue-600">
                  <option value="Rendah">Rendah</option><option value="Sedang" selected>Sedang</option><option value="Darurat">Darurat / High</option>
                </select>
              </div>

              <div>
                <label for="form-bukti" class="block text-xs font-semibold mb-1">Foto / Bukti Kerusakan</label>
                <label id="evidence-dropzone" for="form-bukti" class="flex cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed border-slate-300 bg-slate-50/80 px-5 py-6 text-center transition hover:border-blue-400 hover:bg-blue-50/60 dark:border-slate-600 dark:bg-slate-900/60 dark:hover:bg-slate-800">
                  <span class="material-symbols-outlined mb-1 text-3xl text-blue-600">add_a_photo</span>
                  <span class="text-sm font-semibold">Seret foto ke sini atau pilih file</span>
                  <span class="mt-1 text-xs text-slate-500">JPG, PNG, atau WEBP, maksimal 5 MB</span>
                  <input id="form-bukti" type="file" accept="image/jpeg,image/png,image/webp" class="sr-only" onchange="previewEvidence(event)">
                </label>
                <div id="evidence-preview" aria-live="polite" class="mt-3 hidden items-center gap-3 rounded-xl border border-slate-200 p-2 dark:border-slate-700"></div>
              </div>

              <button type="submit" class="w-full h-11 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-semibold text-sm transition-all shadow-md flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-[20px]">send</span>
                <span>Kirim Pengaduan</span>
              </button>
            </form>
          </div>
          <aside class="rounded-2xl border border-blue-100 bg-white/90 p-5 shadow-sm dark:border-slate-700 dark:bg-slate-800/90 sm:p-6">
            <div class="flex items-start gap-3"><span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-700 dark:bg-blue-950/40 dark:text-blue-300"><span class="material-symbols-outlined">fact_check</span></span><div><h3 class="font-bold text-slate-900 dark:text-white">Panduan Pengaduan</h3><p class="mt-1 text-sm text-slate-500">Agar laporan mudah ditindaklanjuti.</p></div></div>
            <ol class="mt-6 space-y-5">
              <li class="flex gap-3"><span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-blue-100 text-xs font-bold text-blue-700 dark:bg-blue-950/50 dark:text-blue-300">1</span><div><p class="text-sm font-semibold">Pilih kategori dan lokasi</p><p class="mt-1 text-xs leading-5 text-slate-500">Sebutkan ruang atau area secara spesifik.</p></div></li>
              <li class="flex gap-3"><span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-blue-100 text-xs font-bold text-blue-700 dark:bg-blue-950/50 dark:text-blue-300">2</span><div><p class="text-sm font-semibold">Jelaskan kerusakan</p><p class="mt-1 text-xs leading-5 text-slate-500">Ceritakan kondisi dan dampaknya pada kegiatan belajar.</p></div></li>
              <li class="flex gap-3"><span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-blue-100 text-xs font-bold text-blue-700 dark:bg-blue-950/50 dark:text-blue-300">3</span><div><p class="text-sm font-semibold">Sertakan foto bila tersedia</p><p class="mt-1 text-xs leading-5 text-slate-500">Foto yang jelas membantu petugas memahami kondisi fasilitas.</p></div></li>
              <li class="flex gap-3"><span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-emerald-100 text-xs font-bold text-emerald-700 dark:bg-emerald-950/50 dark:text-emerald-300">4</span><div><p class="text-sm font-semibold">Pantau tindak lanjut</p><p class="mt-1 text-xs leading-5 text-slate-500">Periksa menu Laporan & Status untuk melihat progres terbaru.</p></div></li>
            </ol>
            <div class="mt-6 flex items-start gap-2 rounded-xl bg-amber-50 p-3 text-xs leading-5 text-amber-800 dark:bg-amber-950/30 dark:text-amber-200"><span class="material-symbols-outlined text-base">info</span><p>Tandai tingkat urgensi sesuai dampak kerusakan, bukan perkiraan waktu perbaikan.</p></div>
          </aside>
        </section>

        <!-- SECTION SISWA: HISTORI / LAPORAN -->
        <section id="section-siswa-laporan" class="mx-auto hidden max-w-7xl space-y-6">
          <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div><p class="mb-1 text-xs font-bold uppercase tracking-wider text-blue-600">Ringkasan Siswa</p><h2 class="text-2xl font-bold text-slate-900 dark:text-white">Histori & Progress Pengaduan</h2><p class="mt-1 text-sm text-slate-500">Pantau tindak lanjut laporan fasilitas sekolah.</p></div>
            <button type="button" onclick="switchTabSiswa('form')" class="inline-flex h-11 items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 text-sm font-bold text-white shadow-lg shadow-blue-600/20 transition hover:-translate-y-0.5 hover:bg-blue-700">
              <span class="material-symbols-outlined text-[20px]">add</span>Buat Pengaduan Baru
            </button>
          </div>
          <div class="grid grid-cols-2 gap-2 sm:gap-3 xl:grid-cols-4">
            <div class="rounded-2xl border border-blue-100 bg-white/90 p-4 shadow-sm dark:border-slate-700 dark:bg-slate-800/90"><div class="flex items-center justify-between"><span class="text-sm font-semibold text-slate-500">Total Laporan Saya</span><span class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600"><span class="material-symbols-outlined">assignment</span></span></div><strong id="stat-total" class="mt-3 block text-3xl font-bold text-slate-900 dark:text-white">0</strong></div>
            <div class="rounded-2xl border border-amber-100 bg-white/90 p-4 shadow-sm dark:border-slate-700 dark:bg-slate-800/90"><div class="flex items-center justify-between"><span class="text-sm font-semibold text-slate-500">Dalam Proses</span><span class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-50 text-amber-600"><span class="material-symbols-outlined">pending_actions</span></span></div><strong id="stat-proses" class="mt-3 block text-3xl font-bold text-slate-900 dark:text-white">0</strong></div>
            <div class="rounded-2xl border border-emerald-100 bg-white/90 p-4 shadow-sm dark:border-slate-700 dark:bg-slate-800/90"><div class="flex items-center justify-between"><span class="text-sm font-semibold text-slate-500">Selesai</span><span class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600"><span class="material-symbols-outlined">task_alt</span></span></div><strong id="stat-selesai" class="mt-3 block text-3xl font-bold text-slate-900 dark:text-white">0</strong></div>
            <div class="rounded-2xl border border-rose-100 bg-white/90 p-4 shadow-sm dark:border-slate-700 dark:bg-slate-800/90"><div class="flex items-center justify-between"><span class="text-sm font-semibold text-slate-500">Ditolak</span><span class="flex h-10 w-10 items-center justify-center rounded-xl bg-rose-50 text-rose-600"><span class="material-symbols-outlined">cancel</span></span></div><strong id="stat-ditolak" class="mt-3 block text-3xl font-bold text-slate-900 dark:text-white">0</strong></div>
          </div>
          <div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white/95 shadow-sm shadow-slate-200/60 backdrop-blur dark:border-slate-700 dark:bg-slate-800/95 dark:shadow-black/10">
            <div class="flex flex-col gap-4 border-b border-slate-100 p-5 dark:border-slate-700 lg:flex-row lg:items-center lg:justify-between">
              <div><h3 class="font-bold text-slate-900 dark:text-white">Semua Laporan</h3><p class="mt-1 text-xs text-slate-500">Pilih baris untuk melihat riwayat penanganan.</p></div>
              <div class="grid grid-cols-1 gap-2 sm:grid-cols-2 lg:flex">
                <label class="relative"><span class="material-symbols-outlined absolute left-3 top-2.5 text-lg text-slate-400">search</span><input id="history-search" type="search" oninput="renderTables()" placeholder="Cari laporan..." class="h-10 w-full rounded-xl border border-slate-200 bg-slate-50 pl-10 pr-3 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 dark:border-slate-700 dark:bg-slate-900 lg:w-48"></label>
                <select id="history-category" onchange="renderTables()" aria-label="Filter kategori" class="h-10 rounded-xl border border-slate-200 bg-slate-50 px-3 text-sm dark:border-slate-700 dark:bg-slate-900"><option value="">Semua Kategori</option><option value="Fasilitas Kelas">Fasilitas Kelas</option><option value="Laboratorium & IT">Laboratorium & IT</option><option value="Kebersihan & Toilet">Kebersihan & Toilet</option><option value="Sarana Olahraga">Sarana Olahraga</option></select>
                <select id="history-status" onchange="renderTables()" aria-label="Filter status" class="h-10 rounded-xl border border-slate-200 bg-slate-50 px-3 text-sm dark:border-slate-700 dark:bg-slate-900"><option value="">Semua Status</option><option value="Menunggu">Menunggu</option><option value="Proses">Proses</option><option value="Selesai">Selesai</option><option value="Ditolak">Ditolak</option></select>
                <select id="history-urgency" onchange="renderTables()" aria-label="Filter urgensi" class="h-10 rounded-xl border border-slate-200 bg-slate-50 px-3 text-sm dark:border-slate-700 dark:bg-slate-900"><option value="">Semua Urgensi</option><option value="Rendah">Rendah</option><option value="Sedang">Sedang</option><option value="Darurat">Darurat</option><option value="Tinggi">Tinggi</option></select>
                <select id="history-sort" onchange="renderTables()" aria-label="Urutkan tanggal" class="h-10 rounded-xl border border-slate-200 bg-slate-50 px-3 text-sm dark:border-slate-700 dark:bg-slate-900"><option value="newest">Tanggal terbaru</option><option value="oldest">Tanggal terlama</option></select>
              </div>
            </div>
            <div class="overflow-x-auto">
              <table class="w-full min-w-[880px] text-left text-xs">
                <thead class="bg-slate-50 text-[10px] text-slate-500 dark:bg-slate-700/70 dark:text-slate-300 font-bold uppercase">
                  <tr>
                    <th class="p-4">ID / Tanggal</th><th class="p-4">Lokasi & Kategori</th><th class="p-4">Bukti</th><th class="p-4">Urgensi</th><th class="p-4">Status</th><th class="p-4">Umpan Balik / Aksi</th>
                  </tr>
                </thead>
                <tbody id="tbl-siswa-histori" class="divide-y divide-slate-200 dark:divide-slate-700">
                  <!-- JS Injection -->
                </tbody>
              </table>
            </div>
          </div>
        </section>

        <!-- SECTION ADMIN: DASHBOARD STATS -->
        <section id="section-admin-dash" class="space-y-6 hidden">
          <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
            <div class="bg-white dark:bg-slate-800 p-5 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm">
              <span class="text-xs font-semibold text-slate-500 block">Total Pengaduan</span>
              <span class="text-2xl font-bold text-slate-800 dark:text-white mt-1 block">12</span>
            </div>
            <div class="bg-amber-50 dark:bg-amber-950/20 p-5 rounded-2xl border border-amber-200 dark:border-amber-900/30">
              <span class="text-xs font-semibold text-amber-600 dark:text-amber-400 block">Menunggu</span>
              <span class="text-2xl font-bold text-amber-700 dark:text-amber-300 mt-1 block">3</span>
            </div>
            <div class="bg-blue-50 dark:bg-blue-950/20 p-5 rounded-2xl border border-blue-200 dark:border-blue-900/30">
              <span class="text-xs font-semibold text-blue-600 dark:text-blue-400 block">Dalam Proses</span>
              <span class="text-2xl font-bold text-blue-700 dark:text-blue-300 mt-1 block">4</span>
            </div>
            <div class="bg-emerald-50 dark:bg-emerald-950/20 p-5 rounded-2xl border border-emerald-200 dark:border-emerald-900/30">
              <span class="text-xs font-semibold text-emerald-600 dark:text-emerald-400 block">Selesai</span>
              <span class="text-2xl font-bold text-emerald-700 dark:text-emerald-300 mt-1 block">5</span>
            </div>
          </div>
        </section>

        <!-- SECTION ADMIN: PENGADUAN MASUK -->
        <section id="section-admin-pengaduan" class="space-y-4 hidden">
          <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-sm border border-slate-200 dark:border-slate-700">
            <div class="flex items-center justify-between mb-4">
              <h2 class="text-lg font-bold text-slate-800 dark:text-white">Daftar Pengaduan Sarana Masuk</h2>
              
              <!-- FILTER DATA -->
              <div class="grid grid-cols-1 gap-2 sm:grid-cols-2 xl:flex">
                <input id="admin-report-search" type="search" oninput="renderTables()" placeholder="Cari nama, ID, lokasi..." aria-label="Cari pengaduan admin" class="h-9 min-w-0 rounded-lg border border-slate-200 bg-slate-50 px-3 text-xs dark:border-slate-600 dark:bg-slate-900 xl:w-48">
                <select id="admin-report-category" onchange="renderTables()" aria-label="Filter kategori pengaduan admin" class="h-9 rounded-lg border-none bg-slate-100 px-3 text-xs dark:bg-slate-700">
                  <option value="">Semua Kategori</option><option value="Fasilitas Kelas">Fasilitas Kelas</option><option value="Laboratorium & IT">Laboratorium & IT</option><option value="Kebersihan & Toilet">Kebersihan & Toilet</option><option value="Sarana Olahraga">Sarana Olahraga</option>
                </select>
                <select id="admin-report-status" onchange="renderTables()" aria-label="Filter status pengaduan admin" class="h-9 rounded-lg border-none bg-slate-100 px-3 text-xs dark:bg-slate-700">
                  <option value="">Semua Status</option><option value="Menunggu">Menunggu</option><option value="Proses">Proses</option><option value="Selesai">Selesai</option><option value="Ditolak">Ditolak</option>
                </select>
                <select id="admin-report-urgency" onchange="renderTables()" aria-label="Filter urgensi pengaduan admin" class="h-9 rounded-lg border-none bg-slate-100 px-3 text-xs dark:bg-slate-700">
                  <option value="">Semua Urgensi</option><option value="Rendah">Rendah</option><option value="Sedang">Sedang</option><option value="Darurat">Darurat</option><option value="Tinggi">Tinggi</option>
                </select>
              </div>
            </div>

            <div class="overflow-x-auto">
              <table class="w-full text-left text-xs">
                <thead class="bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 font-semibold uppercase">
                  <tr>
                    <th class="p-3">ID</th>
                    <th class="p-3">NIS Siswa</th>
                    <th class="p-3">Lokasi & Kategori</th>
                    <th class="p-3">Deskripsi</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Urgensi</th>
                    <th class="p-3">Aksi Admin</th>
                  </tr>
                </thead>
                <tbody id="tbl-admin-pengaduan" class="divide-y divide-slate-200 dark:divide-slate-700">
                  <!-- JS Injection -->
                </tbody>
              </table>
            </div>
          </div>
        </section>

        <section id="section-admin-laporan" class="mx-auto hidden max-w-7xl space-y-6">
          <div class="flex flex-col gap-4 xl:flex-row xl:items-end xl:justify-between">
            <div>
              <p class="mb-1 text-xs font-bold uppercase tracking-wider text-blue-600">Pusat Analitik Sarpras</p>
              <h1 class="text-2xl font-bold text-slate-900 dark:text-white sm:text-3xl">Laporan & Rekapitulasi Pengaduan Sarana Prasarana</h1>
              <p class="mt-2 text-sm text-slate-500">Pantau tren, distribusi kategori, dan progres penyelesaian laporan.</p>
            </div>
            <div class="report-actions flex shrink-0 flex-wrap gap-2">
              <button type="button" onclick="printReport()" class="inline-flex h-10 items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200"><span class="material-symbols-outlined text-lg">picture_as_pdf</span>Cetak PDF</button>
              <button type="button" onclick="exportReportCsv()" class="inline-flex h-10 items-center gap-2 rounded-xl bg-emerald-600 px-4 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700"><span class="material-symbols-outlined text-lg">download</span>Export Excel</button>
            </div>
          </div>

          <form id="report-filter-form" onsubmit="applyReportFilters(event)" class="report-filters grid grid-cols-1 gap-3 rounded-2xl border border-slate-200 bg-white/95 p-4 shadow-sm dark:border-slate-700 dark:bg-slate-800/95 sm:grid-cols-2 xl:grid-cols-[1fr_1fr_1.1fr_.9fr_.9fr_auto_auto] xl:items-end">
            <div><label for="report-start-date" class="mb-1.5 block text-xs font-semibold text-slate-600 dark:text-slate-300">Mulai Tanggal</label><input id="report-start-date" type="date" class="h-10 w-full rounded-xl border border-slate-200 bg-slate-50 px-3 text-sm dark:border-slate-700 dark:bg-slate-900"></div>
            <div><label for="report-end-date" class="mb-1.5 block text-xs font-semibold text-slate-600 dark:text-slate-300">Sampai Tanggal</label><input id="report-end-date" type="date" class="h-10 w-full rounded-xl border border-slate-200 bg-slate-50 px-3 text-sm dark:border-slate-700 dark:bg-slate-900"></div>
            <div><label for="report-category" class="mb-1.5 block text-xs font-semibold text-slate-600 dark:text-slate-300">Kategori</label><select id="report-category" class="h-10 w-full rounded-xl border border-slate-200 bg-slate-50 px-3 text-sm dark:border-slate-700 dark:bg-slate-900"><option value="">Semua Kategori</option><option value="Fasilitas Kelas">Fasilitas Kelas</option><option value="Laboratorium & IT">Laboratorium & IT</option><option value="Sarana Olahraga">Sarana Olahraga</option><option value="Kebersihan & Toilet">Kebersihan & Toilet</option></select></div>
            <div><label for="report-status" class="mb-1.5 block text-xs font-semibold text-slate-600 dark:text-slate-300">Status</label><select id="report-status" class="h-10 w-full rounded-xl border border-slate-200 bg-slate-50 px-3 text-sm dark:border-slate-700 dark:bg-slate-900"><option value="">Semua Status</option><option value="Menunggu">Menunggu</option><option value="Proses">Dalam Proses</option><option value="Selesai">Selesai</option><option value="Ditolak">Ditolak</option></select></div>
            <div><label for="report-urgency" class="mb-1.5 block text-xs font-semibold text-slate-600 dark:text-slate-300">Urgensi</label><select id="report-urgency" class="h-10 w-full rounded-xl border border-slate-200 bg-slate-50 px-3 text-sm dark:border-slate-700 dark:bg-slate-900"><option value="">Semua Urgensi</option><option value="Rendah">Rendah</option><option value="Sedang">Sedang</option><option value="Darurat">Darurat</option><option value="Tinggi">Tinggi</option></select></div>
            <button type="submit" class="inline-flex h-10 items-center justify-center gap-2 rounded-xl bg-blue-600 px-4 text-sm font-semibold text-white hover:bg-blue-700"><span class="material-symbols-outlined text-lg">filter_alt</span>Terapkan</button>
            <button type="button" onclick="resetReportFilters()" class="inline-flex h-10 items-center justify-center gap-2 rounded-xl border border-slate-200 px-4 text-sm font-semibold text-slate-600 hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-700"><span class="material-symbols-outlined text-lg">restart_alt</span>Reset</button>
          </form>

          <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 2xl:grid-cols-4">
            <article class="rounded-2xl border border-blue-100 bg-white p-4 shadow-sm dark:border-slate-700 dark:bg-slate-800"><div class="flex items-center justify-between"><span class="text-sm font-semibold text-slate-500">Total Pengaduan Masuk</span><span class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-700 dark:bg-blue-950/40 dark:text-blue-300"><span class="material-symbols-outlined">inventory_2</span></span></div><strong id="report-kpi-total" class="mt-3 block text-3xl font-bold text-slate-900 dark:text-white">{{ $reportMetrics['total'] }}</strong><span class="mt-1 block text-xs text-slate-500">Laporan pada filter aktif</span></article>
            <article class="rounded-2xl border border-emerald-100 bg-white p-4 shadow-sm dark:border-slate-700 dark:bg-slate-800"><div class="flex items-center justify-between"><span class="text-sm font-semibold text-slate-500">Selesai Diperbaiki</span><span class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300"><span class="material-symbols-outlined">task_alt</span></span></div><strong id="report-kpi-completed" class="mt-3 block text-3xl font-bold text-slate-900 dark:text-white">{{ $reportMetrics['completed'] }}</strong><span class="mt-1 block text-xs text-slate-500">Laporan berhasil ditangani</span></article>
            <article class="rounded-2xl border border-amber-100 bg-white p-4 shadow-sm dark:border-slate-700 dark:bg-slate-800"><div class="flex items-center justify-between"><span class="text-sm font-semibold text-slate-500">Sedang Diproses</span><span class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-50 text-amber-700 dark:bg-amber-950/40 dark:text-amber-300"><span class="material-symbols-outlined">pending_actions</span></span></div><strong id="report-kpi-progress" class="mt-3 block text-3xl font-bold text-slate-900 dark:text-white">{{ $reportMetrics['inProgress'] }}</strong><span class="mt-1 block text-xs text-slate-500">Menunggu atau dalam proses</span></article>
            <article class="rounded-2xl border border-cyan-100 bg-white p-4 shadow-sm dark:border-slate-700 dark:bg-slate-800"><div class="flex items-center justify-between"><span class="text-sm font-semibold text-slate-500">Rata-rata Penanganan</span><span class="flex h-11 w-11 items-center justify-center rounded-xl bg-cyan-50 text-cyan-700 dark:bg-cyan-950/40 dark:text-cyan-300"><span class="material-symbols-outlined">schedule</span></span></div><strong class="mt-3 block text-3xl font-bold text-slate-900 dark:text-white"><span id="report-kpi-average">{{ $reportMetrics['averageDays'] }}</span><span class="ml-1 text-base font-semibold text-slate-500">hari</span></strong><span class="mt-1 block text-xs text-slate-500">Dihitung dari laporan selesai</span></article>
          </div>

          <div class="report-charts grid grid-cols-1 gap-4 2xl:grid-cols-[1.6fr_1fr]">
            <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-800"><div class="mb-4"><h2 class="font-bold text-slate-900 dark:text-white">Tren Pengaduan per Bulan</h2><p class="mt-1 text-xs text-slate-500">Jumlah laporan masuk berdasarkan tanggal pelaporan.</p></div><div class="relative h-64"><canvas id="report-trend-chart" aria-label="Grafik tren pengaduan per bulan"></canvas></div></article>
            <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-800"><div class="mb-4"><h2 class="font-bold text-slate-900 dark:text-white">Distribusi Kategori</h2><p class="mt-1 text-xs text-slate-500">Proporsi kategori dari laporan terpilih.</p></div><div class="relative mx-auto h-64 max-w-sm"><canvas id="report-category-chart" aria-label="Grafik distribusi kategori pengaduan"></canvas></div></article>
          </div>

          <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-800">
            <div class="flex flex-col gap-3 border-b border-slate-100 p-5 dark:border-slate-700 sm:flex-row sm:items-center sm:justify-between"><div><h2 class="font-bold text-slate-900 dark:text-white">Tabel Rekapitulasi Pengaduan</h2><p class="mt-1 text-xs text-slate-500">Rincian laporan sesuai rentang dan filter yang dipilih.</p></div><label class="report-search relative"><span class="material-symbols-outlined absolute left-3 top-2.5 text-lg text-slate-400">search</span><input id="report-search" type="search" oninput="searchReportTable()" placeholder="Cari ID, pelapor, lokasi..." class="h-10 w-full rounded-xl border border-slate-200 bg-slate-50 pl-10 pr-3 text-sm dark:border-slate-700 dark:bg-slate-900 sm:w-72"></label></div>
            <div id="report-table-wrap" class="overflow-x-auto"><table id="report-table" class="w-full min-w-[1050px] text-left text-xs"><thead class="bg-slate-50 text-[10px] font-bold uppercase text-slate-500 dark:bg-slate-700/70 dark:text-slate-300"><tr><th class="p-4">ID</th><th class="p-4">Tanggal Masuk</th><th class="p-4">Pelapor</th><th class="p-4">Lokasi / Kategori</th><th class="p-4">Deskripsi Singkat</th><th class="p-4">Status</th><th class="p-4">Tanggal Selesai</th><th class="p-4">Durasi</th></tr></thead><tbody id="report-table-body" class="divide-y divide-slate-100 dark:divide-slate-700"></tbody></table></div>
            <div class="report-pagination flex flex-col gap-3 border-t border-slate-100 p-4 dark:border-slate-700 sm:flex-row sm:items-center sm:justify-between"><p id="report-results-count" class="text-xs text-slate-500"></p><div class="flex items-center gap-2"><button id="report-page-previous" type="button" onclick="changeReportPage(-1)" class="inline-flex h-9 items-center gap-1 rounded-lg border border-slate-200 px-3 text-xs font-semibold text-slate-600 disabled:cursor-not-allowed disabled:opacity-40 dark:border-slate-700 dark:text-slate-300"><span class="material-symbols-outlined text-base">chevron_left</span>Sebelumnya</button><span id="report-page-label" class="min-w-16 text-center text-xs font-semibold text-slate-600 dark:text-slate-300"></span><button id="report-page-next" type="button" onclick="changeReportPage(1)" class="inline-flex h-9 items-center gap-1 rounded-lg border border-slate-200 px-3 text-xs font-semibold text-slate-600 disabled:cursor-not-allowed disabled:opacity-40 dark:border-slate-700 dark:text-slate-300">Berikutnya<span class="material-symbols-outlined text-base">chevron_right</span></button></div></div>
          </section>
        </section>

        <!-- COMMON PROFILE SECTION -->
        <section id="section-profile" class="profile-layout mx-auto hidden w-full max-w-7xl items-start gap-5">
          <div class="mb-5 flex flex-col gap-4 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-800 sm:flex-row sm:items-center xl:col-span-2 xl:mb-0">
            <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-blue-100 text-2xl font-bold text-blue-700 dark:bg-blue-950/50 dark:text-blue-300"><span id="prof-avatar">U</span></div>
            <div class="min-w-0 flex-1"><p class="text-xs font-bold uppercase tracking-wider text-blue-600">Profil Pengguna</p><h2 id="prof-name" class="mt-1 text-xl font-bold text-slate-900 dark:text-white">User Name</h2><p id="prof-sub" class="mt-1 text-sm text-slate-500">Role / Identity</p></div>
            <div id="profile-report-stat" class="flex min-w-36 items-center gap-3 rounded-xl bg-blue-50 px-4 py-3 dark:bg-blue-950/30"><span class="material-symbols-outlined text-2xl text-blue-600">assignment</span><div><span class="block text-xs text-slate-500">Total Pengaduan</span><strong id="profile-report-total" class="text-xl font-bold text-slate-900 dark:text-white">0</strong></div></div>
          </div>

          <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-800">
            <div class="mb-5"><h3 class="font-bold text-slate-900 dark:text-white">Informasi Kontak</h3><p class="mt-1 text-sm text-slate-500">Informasi yang terhubung dengan akun sekolah Anda.</p></div>
            <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-1">
              <div class="rounded-xl bg-slate-50 p-4 dark:bg-slate-900"><dt class="flex items-center gap-2 text-xs font-semibold text-slate-500"><span class="material-symbols-outlined text-base">mail</span>Email</dt><dd id="profile-email" class="mt-2 break-all text-sm font-semibold text-slate-800 dark:text-slate-100">-</dd></div>
              <div class="rounded-xl bg-slate-50 p-4 dark:bg-slate-900"><dt class="flex items-center gap-2 text-xs font-semibold text-slate-500"><span class="material-symbols-outlined text-base">call</span>No. HP</dt><dd id="profile-phone" class="mt-2 text-sm font-semibold text-slate-800 dark:text-slate-100">-</dd></div>
            </dl>
          </div>
          <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-800">
            <div class="flex items-start gap-3"><span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-200"><span class="material-symbols-outlined">shield_lock</span></span><div><h3 class="font-bold text-slate-900 dark:text-white">Keamanan Akun</h3><p class="mt-1 text-sm text-slate-500">Perbarui kata sandi secara berkala.</p></div></div>
            <button type="button" onclick="openPasswordModal()" class="mt-6 inline-flex h-10 w-full items-center justify-center gap-2 rounded-xl border border-slate-200 px-4 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 dark:border-slate-600 dark:text-slate-200 dark:hover:bg-slate-700"><span class="material-symbols-outlined text-lg">lock_reset</span>Ubah Kata Sandi</button>
          </div>
        </section>

      </main>
    </div>
  </div>

  <div id="modal-timeline" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/50 p-4 backdrop-blur-sm" onclick="if(event.target === this) closeTimeline()">
    <section class="w-full max-w-xl rounded-2xl border border-slate-200 bg-white p-6 shadow-2xl dark:border-slate-700 dark:bg-slate-800" role="dialog" aria-modal="true" aria-labelledby="timeline-title">
      <div class="mb-5 flex items-start justify-between gap-4"><div><p id="timeline-id" class="text-xs font-bold uppercase text-blue-600"></p><h2 id="timeline-title" class="mt-1 text-xl font-bold">Progress Pengaduan</h2><p id="timeline-description" class="mt-1 text-sm text-slate-500"></p></div><button type="button" onclick="closeTimeline()" aria-label="Tutup detail" class="rounded-lg p-2 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-700"><span class="material-symbols-outlined">close</span></button></div>
      <div id="timeline-content" class="space-y-0"></div>
    </section>
  </div>

  <div id="modal-rating" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/50 p-4 backdrop-blur-sm" onclick="if(event.target === this) closeRating()">
    <section class="w-full max-w-md rounded-2xl border border-slate-200 bg-white p-6 shadow-2xl dark:border-slate-700 dark:bg-slate-800" role="dialog" aria-modal="true" aria-labelledby="rating-title">
      <div class="mb-5 flex items-start justify-between"><div><p id="rating-report-id" class="text-xs font-bold uppercase text-emerald-600"></p><h2 id="rating-title" class="mt-1 text-xl font-bold">Bagaimana hasil perbaikannya?</h2></div><button type="button" onclick="closeRating()" aria-label="Tutup ulasan" class="rounded-lg p-2 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-700"><span class="material-symbols-outlined">close</span></button></div>
      <form onsubmit="saveRating(event)" class="space-y-4"><input id="rating-id" type="hidden"><div><span class="mb-2 block text-sm font-semibold">Rating kepuasan</span><div id="rating-stars" class="flex gap-2" role="radiogroup" aria-label="Pilih rating bintang"></div></div><div><label for="rating-review" class="mb-1 block text-sm font-semibold">Ulasan</label><textarea id="rating-review" rows="3" maxlength="500" placeholder="Ceritakan pengalaman Anda..." class="w-full rounded-xl border border-slate-200 bg-slate-50 p-3 text-sm dark:border-slate-700 dark:bg-slate-900"></textarea></div><div class="flex justify-end gap-2"><button type="button" onclick="closeRating()" class="rounded-xl bg-slate-100 px-4 py-2 text-sm font-semibold dark:bg-slate-700">Batal</button><button type="submit" class="rounded-xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">Kirim Ulasan</button></div></form>
    </section>
  </div>

  <div id="modal-password" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/50 p-4 backdrop-blur-sm" onclick="if(event.target === this) closePasswordModal()">
    <section class="w-full max-w-md rounded-2xl border border-slate-200 bg-white p-6 shadow-2xl dark:border-slate-700 dark:bg-slate-800" role="dialog" aria-modal="true" aria-labelledby="password-title">
      <div class="mb-5 flex items-start justify-between"><div><p class="text-xs font-bold uppercase text-blue-600">Keamanan Akun</p><h2 id="password-title" class="mt-1 text-xl font-bold">Ubah Kata Sandi</h2></div><button type="button" onclick="closePasswordModal()" aria-label="Tutup ubah kata sandi" class="rounded-lg p-2 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-700"><span class="material-symbols-outlined">close</span></button></div>
      <form id="password-change-form" onsubmit="changePassword(event)" class="space-y-4"><div><label for="current-password" class="mb-1 block text-sm font-semibold">Kata sandi saat ini</label><input id="current-password" type="password" required autocomplete="current-password" class="h-11 w-full rounded-xl border border-slate-200 bg-slate-50 px-3 text-sm dark:border-slate-700 dark:bg-slate-900"></div><div><label for="new-password" class="mb-1 block text-sm font-semibold">Kata sandi baru</label><input id="new-password" type="password" required minlength="8" autocomplete="new-password" class="h-11 w-full rounded-xl border border-slate-200 bg-slate-50 px-3 text-sm dark:border-slate-700 dark:bg-slate-900"></div><div><label for="confirm-password" class="mb-1 block text-sm font-semibold">Konfirmasi kata sandi baru</label><input id="confirm-password" type="password" required minlength="8" autocomplete="new-password" class="h-11 w-full rounded-xl border border-slate-200 bg-slate-50 px-3 text-sm dark:border-slate-700 dark:bg-slate-900"></div><p id="password-error" class="hidden text-sm font-medium text-rose-600" role="alert"></p><div class="flex justify-end gap-2 pt-2"><button type="button" onclick="closePasswordModal()" class="rounded-xl bg-slate-100 px-4 py-2 text-sm font-semibold dark:bg-slate-700">Batal</button><button type="submit" class="rounded-xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">Simpan Kata Sandi</button></div></form>
    </section>
  </div>

  <!-- MODAL ACTION ADMIN (UPDATE STATUS & FEEDBACK) -->
  <div id="modal-admin-action" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center hidden">
    <div class="bg-white dark:bg-slate-800 rounded-2xl max-w-md w-full p-6 shadow-xl border border-slate-200 dark:border-slate-700">
      <h3 class="text-lg font-bold mb-4 text-slate-800 dark:text-white">Tindak Lanjut Pengaduan</h3>
      <form onsubmit="saveAdminAction(event)" class="space-y-4">
        <input type="hidden" id="modal-aspirasi-id">
        <div>
          <label class="block text-xs font-semibold mb-1">Update Status Penyelesaian</label>
          <select id="modal-status" class="w-full h-10 px-3 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-sm">
            <option value="Menunggu">Menunggu</option>
            <option value="Proses">Dalam Proses</option>
            <option value="Selesai">Selesai</option>
            <option value="Ditolak">Ditolak</option>
          </select>
        </div>
        <div>
          <label class="block text-xs font-semibold mb-1">Umpan Balik / Feedback Admin</label>
          <textarea id="modal-feedback" rows="3" required placeholder="Berikan catatan perbaikan untuk siswa..." class="w-full p-3 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-sm"></textarea>
        </div>
        <div class="flex justify-end gap-2 pt-2">
          <button type="button" onclick="closeAdminModal()" class="px-4 py-2 rounded-xl text-xs font-semibold bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300">Batal</button>
          <button type="submit" class="px-4 py-2 rounded-xl text-xs font-semibold bg-blue-600 text-white hover:bg-blue-700">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>

  <!-- JAVASCRIPT LOGIC INTERAKTIF -->
  <script>
    // DATA STATE MOCKUP DARI DATABASE ERD
    let activeRole = 'siswa'; // 'siswa' | 'admin'
    let isRegisterMode = false;
    let currentUser = null;
    const translations = {
      id: {
        portalTitle: 'SIPRASKA - Portal Pengaduan Sarana Prasarana Sekolah',
        authSubtitle: 'Pengaduan Sarana Sekolah', roleAdmin: 'Petugas / Admin', signIn: 'Masuk ke Portal',
        authDescription: 'Gunakan kredensial resmi sekolah untuk melanjutkan pengaduan.', studentIdentity: 'NISN / Nomor Induk Siswa', adminIdentity: 'NIP / Username Pengelola Sarpras', adminIdentityPlaceholder: 'Masukkan NIP atau Username...', password: 'Kata Sandi', passwordHintSeparator: '/ Sandi',
        identityPlaceholder: 'Masukkan 10 digit NISN...', passwordPlaceholder: 'Masukkan kata sandi...', rememberMe: 'Ingat saya', forgotPassword: 'Lupa Sandi?', signInNow: 'Masuk Sekarang',
        testCredentials: 'Uji Cepat Cepat:', studentMode: 'Mode Siswa: ID', adminMode: 'Mode Admin: ID', noAccount: 'Belum memiliki akun?', register: 'Daftar Akun Baru', secureFooter: 'Enkripsi 256-Bit SSL SMAN 1 Harapan', online: 'Sistem Online', noActivity: 'Belum ada aktivitas.', studentNumberExample: 'Contoh: 12345678', studentNamePlaceholder: 'Nama Siswa...', classExample: 'Contoh: XII RPL 1', newPasswordPlaceholder: 'Buat kata sandi...',
        registerTitle: 'Daftar Akun Siswa Baru', registrationSuccessTitle: 'Pendaftaran Berhasil', alreadyAccount: 'Sudah memiliki akun?', student: 'Siswa', admin: 'Admin', logout: 'Keluar', registerStudentNumber: 'NIS (Nomor Induk Siswa)', fullName: 'Nama Lengkap', registerNow: 'Daftar Akun Sekarang',
        notification: 'Notifikasi', latestActivity: 'Aktivitas Terbaru', markRead: 'Tandai dibaca', accountMenu: 'Menu akun', language: 'Bahasa', theme: 'Tema', dark: 'Dark', light: 'Light', changeTheme: 'Ganti tema', openMenu: 'Buka menu navigasi', closeMenu: 'Tutup menu navigasi', chooseStar: 'Pilih rating bintang', required: 'wajib diisi',
        complaintForm: 'Form Pengaduan', reportHistory: 'Laporan & Status', profile: 'Profil Saya', dashboard: 'Dashboard', incomingReports: 'Pengaduan Masuk', reportRecap: 'Laporan Rekap', adminProfile: 'Profil Admin',
        createComplaint: 'Buat Laporan Pengaduan Sarana', complaintIntro: 'Sampaikan keluhan fasilitas sekolah secara rinci agar segera ditindaklanjuti.', studentNumber: 'NIS (Otomatis)', class: 'Kelas',
        facilityCategory: 'Kategori Sarana Prasarana', classroomFacilities: 'Fasilitas Kelas', laboratoryIt: 'Laboratorium & IT', hygieneToilet: 'Kebersihan & Toilet', sportsFacilities: 'Sarana Olahraga',
        location: 'Lokasi Spesifik Kerusakan', locationPlaceholder: 'Contoh: Ruang Lab Komputer 2 (Proyektor Matil)', description: 'Keterangan / Deskripsi Kerusakan', descriptionPlaceholder: 'Jelaskan detail masalah sarana...',
        urgency: 'Tingkat Urgensi', low: 'Rendah', medium: 'Sedang', emergencyHigh: 'Darurat / High', high: 'Tinggi', evidence: 'Foto / Bukti Kerusakan', dropPhoto: 'Seret foto ke sini atau pilih file', imageLimit: 'JPG, PNG, atau WEBP, maksimal 5 MB', submitComplaint: 'Kirim Pengaduan',
        complaintGuide: 'Panduan Pengaduan', guideIntro: 'Agar laporan mudah ditindaklanjuti.', chooseLocation: 'Pilih kategori dan lokasi', specificArea: 'Sebutkan ruang atau area secara spesifik.', explainDamage: 'Jelaskan kerusakan', learningImpact: 'Ceritakan kondisi dan dampaknya pada kegiatan belajar.',
        addPhotoIfAvailable: 'Sertakan foto bila tersedia', photoHelps: 'Foto yang jelas membantu petugas memahami kondisi fasilitas.', trackFollowUp: 'Pantau tindak lanjut', checkReportMenu: 'Periksa menu Laporan & Status untuk melihat progres terbaru.', urgencyTip: 'Tandai tingkat urgensi sesuai dampak kerusakan, bukan perkiraan waktu perbaikan.',
        studentSummary: 'Ringkasan Siswa', historyTitle: 'Histori & Progress Pengaduan', historyIntro: 'Pantau tindak lanjut laporan fasilitas sekolah.', newComplaint: 'Buat Pengaduan Baru', totalMyReports: 'Total Laporan Saya', inProgress: 'Dalam Proses', completed: 'Selesai', rejected: 'Ditolak',
        allReports: 'Semua Laporan', clickForTimeline: 'Pilih baris untuk melihat riwayat penanganan.', searchReports: 'Cari laporan...', allCategories: 'Semua Kategori', allStatuses: 'Semua Status', waiting: 'Menunggu', processing: 'Proses', teacher: 'Guru', complaintChartLabel: 'Pengaduan', noChartData: 'Belum ada data', adminSearchAccessible: 'Cari pengaduan admin', adminCategoryAccessible: 'Filter kategori pengaduan admin', adminStatusAccessible: 'Filter status pengaduan admin', adminUrgencyAccessible: 'Filter urgensi pengaduan admin',
        allUrgencies: 'Semua Urgensi', newestDate: 'Tanggal terbaru', oldestDate: 'Tanggal terlama', idDate: 'ID / Tanggal', locationCategory: 'Lokasi & Kategori', locationSlashCategory: 'Lokasi / Kategori', proof: 'Bukti', feedbackAction: 'Umpan Balik / Aksi', noPhoto: 'Tidak ada foto', rate: 'Beri rating', viewProgress: 'Lihat progres', noData: 'Data tidak ditemukan.',
        trendChartAria: 'Grafik tren pengaduan per bulan', categoryChartAria: 'Grafik distribusi kategori pengaduan',
        totalReports: 'Total Pengaduan', incomingReportsTitle: 'Daftar Pengaduan Sarana Masuk', searchAdmin: 'Cari nama, ID, lokasi...', filterCategory: 'Filter kategori', filterStatus: 'Filter status', filterUrgency: 'Filter urgensi', adminAction: 'Aksi Admin', followUp: 'Tindak Lanjut', studentIdHeader: 'NIS Siswa', briefDescription: 'Deskripsi',
        analytics: 'Pusat Analitik Sarpras', reportTitle: 'Laporan & Rekapitulasi Pengaduan Sarana Prasarana', reportIntro: 'Pantau tren, distribusi kategori, dan progres penyelesaian laporan.', printPdf: 'Cetak PDF', exportExcel: 'Export Excel',
        startDate: 'Mulai Tanggal', endDate: 'Sampai Tanggal', apply: 'Terapkan', reset: 'Reset', incomingTotal: 'Total Pengaduan Masuk', repaired: 'Selesai Diperbaiki', beingProcessed: 'Sedang Diproses', averageHandling: 'Rata-rata Penanganan', days: 'hari',
        reportsInFilter: 'Laporan pada filter aktif', reportsHandled: 'Laporan berhasil ditangani', waitingOrProcessing: 'Menunggu atau dalam proses', averageCompleted: 'Dihitung dari laporan selesai', monthlyTrend: 'Tren Pengaduan per Bulan', monthlyTrendDescription: 'Jumlah laporan masuk berdasarkan tanggal pelaporan.',
        categoryDistribution: 'Distribusi Kategori', categoryDistributionDescription: 'Proporsi kategori dari laporan terpilih.', recapTable: 'Tabel Rekapitulasi Pengaduan', recapDescription: 'Rincian laporan sesuai rentang dan filter yang dipilih.', searchRecap: 'Cari ID, pelapor, lokasi...',
        reportId: 'ID', dateReceived: 'Tanggal Masuk', reporter: 'Pelapor', role: 'Peran', descriptionShort: 'Deskripsi Singkat', completionDate: 'Tanggal Selesai', duration: 'Durasi',
        reportCount: 'laporan', showing: 'Menampilkan', from: 'dari', previous: 'Sebelumnya', next: 'Berikutnya',
        userProfile: 'Profil Pengguna', contactInformation: 'Informasi Kontak', contactIntro: 'Informasi yang terhubung dengan akun sekolah Anda.', email: 'Email', phone: 'No. HP', accountSecurity: 'Keamanan Akun', changePasswordTip: 'Perbarui kata sandi secara berkala.', changePassword: 'Ubah Kata Sandi',
        timelineTitle: 'Progress Pengaduan', closeDetails: 'Tutup detail', reportSubmitted: 'Laporan Dikirim', adminVerification: 'Verifikasi Admin', technicianAssignment: 'Penugasan Teknisi', repairInProgress: 'Proses Perbaikan', rejectedLabel: 'Laporan Ditolak',
        waitingPrevious: 'Menunggu tahapan sebelumnya.', notScheduled: 'Belum dijadwalkan', closeReview: 'Tutup ulasan', repairFeedbackTitle: 'Bagaimana hasil perbaikannya?', satisfactionRating: 'Rating kepuasan', review: 'Ulasan', reviewPlaceholder: 'Ceritakan pengalaman Anda...', cancel: 'Batal', submitReview: 'Kirim Ulasan', day: 'hari',
        chooseRating: 'Pilih rating bintang terlebih dahulu.', imageTypeError: 'Pilih gambar JPG, PNG, atau WEBP dengan ukuran maksimal 5 MB.', registrationSuccess: 'Pendaftaran berhasil! Silakan masuk menggunakan akun Anda.', adminFollowUpTitle: 'Tindak Lanjut Pengaduan', updateStatus: 'Update Status Penyelesaian', adminFeedback: 'Umpan Balik / Feedback Admin', adminFeedbackPlaceholder: 'Berikan catatan perbaikan untuk siswa...', saveChanges: 'Simpan Perubahan',
        closePassword: 'Tutup ubah kata sandi', currentPassword: 'Kata sandi saat ini', newPassword: 'Kata sandi baru', confirmPassword: 'Konfirmasi kata sandi baru', savePassword: 'Simpan Kata Sandi', passwordMismatch: 'Konfirmasi kata sandi baru belum cocok.', passwordNotSaved: 'Validasi berhasil. Perubahan belum disimpan karena layanan akun belum terhubung.', registerStudentId: 'NIS (Nomor Induk Siswa)',
        reportReceivedNote: 'Laporan diterima oleh sistem.', verificationNote: 'Laporan sedang diverifikasi oleh admin.', technicianNote: 'Teknisi sarana prasarana telah ditugaskan.', repairNote: 'Perbaikan sedang ditangani.', repairCompleteNote: 'Perbaikan telah diselesaikan.', reportNeedsDetails: 'Laporan belum dapat ditindaklanjuti.',
        dateLabel: 'Tanggal', reportStatus: 'Status', urgencyLabel: 'Urgensi', categoryLabel: 'Kategori', lowUrgency: 'Rendah', mediumUrgency: 'Sedang', emergency: 'Darurat'
      },
      en: {
        portalTitle: 'SIPRASKA - School Facilities Complaint Portal',
        authSubtitle: 'School Facilities Complaints', roleAdmin: 'Staff / Admin', signIn: 'Sign in to the Portal',
        authDescription: 'Use your official school credentials to continue.', studentIdentity: 'Student Number', adminIdentity: 'Staff ID / Administrator Username', adminIdentityPlaceholder: 'Enter staff ID or username...', password: 'Password', passwordHintSeparator: '/ Password',
        identityPlaceholder: 'Enter your student number...', passwordPlaceholder: 'Enter your password...', rememberMe: 'Remember me', forgotPassword: 'Forgot password?', signInNow: 'Sign In',
        testCredentials: 'Quick Test:', studentMode: 'Student mode: ID', adminMode: 'Admin mode: ID', noAccount: 'Do not have an account?', register: 'Create Account', secureFooter: '256-Bit SSL Encryption · SMAN 1 Harapan', online: 'System Online', noActivity: 'No recent activity.', registerStudentNumber: 'Student Number', fullName: 'Full Name', registerNow: 'Create Student Account',
        registerTitle: 'Create a Student Account', registrationSuccessTitle: 'Registration Successful', alreadyAccount: 'Already have an account?', student: 'Student', admin: 'Admin', logout: 'Log out',
        notification: 'Notifications', latestActivity: 'Recent Activity', markRead: 'Mark as read', accountMenu: 'Account menu', language: 'Language', theme: 'Theme', dark: 'Dark', light: 'Light', changeTheme: 'Change theme', openMenu: 'Open navigation menu', closeMenu: 'Close navigation menu', chooseStar: 'Choose a star rating', required: 'required',
        complaintForm: 'Complaint Form', reportHistory: 'Reports & Status', profile: 'My Profile', dashboard: 'Dashboard', incomingReports: 'Incoming Reports', reportRecap: 'Report Summary', adminProfile: 'Admin Profile',
        createComplaint: 'Submit a Facility Complaint', complaintIntro: 'Describe the facility issue so it can be followed up promptly.', studentNumber: 'Student No. (Automatic)', class: 'Class',
        facilityCategory: 'Facility Category', classroomFacilities: 'Classroom Facilities', laboratoryIt: 'Laboratory & IT', hygieneToilet: 'Cleanliness & Restrooms', sportsFacilities: 'Sports Facilities',
        location: 'Specific Damage Location', locationPlaceholder: 'Example: Computer Lab 2 (Projector is off)', description: 'Damage Details', descriptionPlaceholder: 'Describe the facility issue...',
        urgency: 'Priority', low: 'Low', medium: 'Medium', emergencyHigh: 'Emergency / High', high: 'High', evidence: 'Photo / Evidence', dropPhoto: 'Drop a photo here or browse files', imageLimit: 'JPG, PNG, or WEBP, up to 5 MB', submitComplaint: 'Submit Complaint',
        complaintGuide: 'Complaint Guide', guideIntro: 'Help the team follow up on your report.', chooseLocation: 'Choose a category and location', specificArea: 'Name the room or area as specifically as possible.', explainDamage: 'Describe the issue', learningImpact: 'Explain the condition and its impact on learning activities.',
        addPhotoIfAvailable: 'Add a photo if available', photoHelps: 'A clear photo helps staff assess the facility.', trackFollowUp: 'Track follow-up', checkReportMenu: 'Open Reports & Status to check the latest progress.', urgencyTip: 'Choose urgency based on the impact of the damage, not the estimated repair time.',
        studentSummary: 'Student Summary', historyTitle: 'My Complaint History & Progress', historyIntro: 'Track follow-up on school facility reports.', newComplaint: 'New Complaint', totalMyReports: 'My Total Reports', inProgress: 'In Progress', completed: 'Completed', rejected: 'Rejected',
        allReports: 'All Reports', clickForTimeline: 'Select a row to view its handling timeline.', searchReports: 'Search reports...', allCategories: 'All Categories', allStatuses: 'All Statuses', waiting: 'Waiting', processing: 'In Progress', teacher: 'Teacher', complaintChartLabel: 'Complaints', noChartData: 'No chart data yet', adminSearchAccessible: 'Search admin reports', adminCategoryAccessible: 'Filter admin category', adminStatusAccessible: 'Filter admin status', adminUrgencyAccessible: 'Filter admin priority',
        allUrgencies: 'All Priorities', newestDate: 'Newest first', oldestDate: 'Oldest first', idDate: 'ID / Date', locationCategory: 'Location & Category', locationSlashCategory: 'Location / Category', proof: 'Evidence', feedbackAction: 'Feedback / Action', noPhoto: 'No photo', rate: 'Rate this repair', viewProgress: 'View progress', noData: 'No data found.',
        trendChartAria: 'Monthly complaint trend chart', categoryChartAria: 'Complaint category distribution chart',
        totalReports: 'Total Reports', incomingReportsTitle: 'Incoming Facility Reports', searchAdmin: 'Search name, ID, location...', filterCategory: 'Filter category', filterStatus: 'Filter status', filterUrgency: 'Filter priority', adminAction: 'Admin Action', followUp: 'Follow up', studentIdHeader: 'Student ID', briefDescription: 'Description', studentNumberExample: 'Example: 12345678', studentNamePlaceholder: 'Student name...', classExample: 'Example: Grade 12 Software Engineering', newPasswordPlaceholder: 'Create a password...',
        analytics: 'Facilities Analytics', reportTitle: 'Facility Complaint Reports & Summary', reportIntro: 'Track trends, category distribution, and report resolution progress.', printPdf: 'Print PDF', exportExcel: 'Export Excel',
        startDate: 'Start Date', endDate: 'End Date', apply: 'Apply', reset: 'Reset', incomingTotal: 'Total Reports Received', repaired: 'Repaired', beingProcessed: 'In Progress', averageHandling: 'Average Handling Time', days: 'days',
        reportsInFilter: 'Reports in current filter', reportsHandled: 'Reports successfully handled', waitingOrProcessing: 'Waiting or in progress', averageCompleted: 'Calculated from completed reports', monthlyTrend: 'Complaints per Month', monthlyTrendDescription: 'Reports grouped by submission date.',
        categoryDistribution: 'Category Distribution', categoryDistributionDescription: 'Category share for matching reports.', recapTable: 'Complaint Report Summary', recapDescription: 'Report details matching the selected filters.', searchRecap: 'Search ID, reporter, location...',
        reportId: 'ID', dateReceived: 'Date Received', reporter: 'Reporter', role: 'Role', descriptionShort: 'Description', completionDate: 'Completion Date', duration: 'Duration',
        reportCount: 'reports', showing: 'Showing', from: 'of', previous: 'Previous', next: 'Next',
        userProfile: 'User Profile', contactInformation: 'Contact Information', contactIntro: 'Contact details linked to your school account.', email: 'Email', phone: 'Phone', accountSecurity: 'Account Security', changePasswordTip: 'Update your password regularly.', changePassword: 'Change Password',
        timelineTitle: 'Complaint Progress', closeDetails: 'Close details', reportSubmitted: 'Report Submitted', adminVerification: 'Admin Verification', technicianAssignment: 'Technician Assigned', repairInProgress: 'Repair in Progress', rejectedLabel: 'Report Rejected',
        waitingPrevious: 'Waiting for the previous step.', notScheduled: 'Not scheduled', closeReview: 'Close review', repairFeedbackTitle: 'How was the repair?', satisfactionRating: 'Satisfaction rating', review: 'Review', reviewPlaceholder: 'Share your experience...', cancel: 'Cancel', submitReview: 'Submit Review', day: 'day',
        chooseRating: 'Choose a star rating first.', imageTypeError: 'Choose a JPG, PNG, or WEBP image up to 5 MB.', registrationSuccess: 'Registration complete. Sign in with your account.', adminFollowUpTitle: 'Complaint Follow-up', updateStatus: 'Update Resolution Status', adminFeedback: 'Admin Feedback', adminFeedbackPlaceholder: 'Add a repair note for the student...', saveChanges: 'Save Changes',
        closePassword: 'Close password dialog', currentPassword: 'Current password', newPassword: 'New password', confirmPassword: 'Confirm new password', savePassword: 'Save Password', passwordMismatch: 'The new passwords do not match.', passwordNotSaved: 'Validation passed. Changes are not saved because the account service is not connected.', registerStudentId: 'Student ID',
        reportReceivedNote: 'The report was received by the system.', verificationNote: 'The report is being reviewed by an administrator.', technicianNote: 'A facilities technician has been assigned.', repairNote: 'The repair is in progress.', repairCompleteNote: 'The repair has been completed.', reportNeedsDetails: 'More information is needed before this report can be processed.',
        dateLabel: 'Date', reportStatus: 'Status', urgencyLabel: 'Priority', categoryLabel: 'Category', lowUrgency: 'Low', mediumUrgency: 'Medium', emergency: 'Emergency'
      }
    };
    let currentLanguage = localStorage.getItem('sipraska-language') === 'en' ? 'en' : 'id';
    const translationPhraseKeys = new Map();
    Object.entries(translations).forEach(([language, phrases]) => {
      Object.entries(phrases).forEach(([key, phrase]) => translationPhraseKeys.set(phrase, key));
    });
    let activeTimelineId = null;

    const dateOffset = (days) => new Date(Date.now() - days * 86400000).toISOString();
    const buildTimeline = (status, date, feedback = '') => {
      const stages = [
        ['Laporan Dikirim', 'Laporan diterima oleh sistem.'],
        ['Verifikasi Admin', 'Laporan sedang diverifikasi oleh admin.'],
        ['Penugasan Teknisi', 'Teknisi sarana prasarana telah ditugaskan.'],
        ['Proses Perbaikan', feedback || 'Perbaikan sedang ditangani.'],
        ['Selesai', feedback || 'Perbaikan telah diselesaikan.']
      ];
      const currentStage = { Menunggu: 1, Proses: 3, Selesai: -1, Ditolak: 1 }[status] ?? 0;
      return stages.map((stage, index) => {
        const complete = index === 0 || status === 'Selesai' || (status === 'Proses' && index < currentStage);
        const current = index === currentStage;
        return {
          title: status === 'Ditolak' && index === 1 ? 'Laporan Ditolak' : stage[0],
          note: status === 'Ditolak' && current ? feedback || 'Laporan belum dapat ditindaklanjuti.' : (current && feedback && status !== 'Menunggu' ? feedback : (complete ? stage[1] : 'Menunggu tahapan sebelumnya.')),
          date: complete || current ? new Date(new Date(date).getTime() + index * 3600000).toISOString() : null,
          complete,
          current
        };
      });
    };
    const controllerReportSeed = {{ \Illuminate\Support\Js::from($initialReports) }};
    let dummyAspirasi = controllerReportSeed.map(report => ({ ...report, timeline: [] }));
    dummyAspirasi.forEach(item => { item.timeline = buildTimeline(item.status, item.date, item.feedback); });
    let activityLog = [
      { message: 'Teknisi sedang mengecek laporan #101.', date: dateOffset(1), unread: true },
      { message: 'Laporan #102 telah selesai diperbaiki.', date: dateOffset(7), unread: true }
    ];
    let selectedRating = 0;
    let pendingEvidence = '';

    function escapeHTML(value) {
      return String(value ?? '').replace(/[&<>"']/g, character => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' })[character]);
    }

    function translateText(value) {
      const text = String(value ?? '').trim();
      const requiredSuffix = currentLanguage === 'en' ? ' wajib diisi' : ' required';
      if (text.endsWith(requiredSuffix)) {
        const baseText = text.slice(0, -requiredSuffix.length);
        return `${translateText(baseText)} ${translations[currentLanguage].required}`;
      }
      const key = translationPhraseKeys.get(text);
      return key ? translations[currentLanguage][key] : value;
    }

    function translateInterface() {
      const walker = document.createTreeWalker(document.body, NodeFilter.SHOW_TEXT);
      let textNode;
      while ((textNode = walker.nextNode())) {
        if (textNode.parentElement?.closest('script, style')) continue;
        const original = textNode.nodeValue;
        const trimmed = original.trim();
        if (!trimmed) continue;
        const translated = translateText(trimmed);
        if (translated !== trimmed) textNode.nodeValue = original.replace(trimmed, translated);
      }

      document.querySelectorAll('[placeholder], [aria-label], [title]').forEach(element => {
        ['placeholder', 'aria-label', 'title'].forEach(attribute => {
          const value = element.getAttribute(attribute);
          if (value) element.setAttribute(attribute, translateText(value));
        });
      });
      document.documentElement.lang = currentLanguage;
      document.title = translateText('SIPRASKA - Portal Pengaduan Sarana Prasarana Sekolah');
    }

    function formatDate(date) {
      return new Date(date).toLocaleDateString(currentLanguage === 'en' ? 'en-US' : 'id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
    }

    function addActivity(message) {
      activityLog.unshift({ message, date: new Date().toISOString(), unread: true });
      renderNotifications();
    }

    function renderNotifications() {
      const unread = activityLog.filter(activity => activity.unread).length;
      const count = document.getElementById('notification-count');
      count.textContent = unread > 9 ? '9+' : unread;
      count.classList.toggle('hidden', unread === 0);
      const list = document.getElementById('notification-list');
      list.innerHTML = activityLog.length ? activityLog.map(activity => `
        <div class="border-b border-slate-100 pb-3 last:border-0 dark:border-slate-700">
          <p class="${activity.unread ? 'font-semibold text-slate-800 dark:text-white' : ''}">${escapeHTML(translateText(activity.message))}</p>
          <time class="mt-1 block text-xs text-slate-400">${formatDate(activity.date)}</time>
        </div>`).join('') : `<p class="py-4 text-center text-sm text-slate-500">${escapeHTML(translateText('Belum ada aktivitas.'))}</p>`;
    }

    function toggleNotifications() {
      const panel = document.getElementById('notification-panel');
      const trigger = document.querySelector('[aria-controls="notification-panel"]');
      const isOpening = panel.classList.contains('hidden');
      panel.classList.toggle('hidden', !isOpening);
      trigger.setAttribute('aria-expanded', String(isOpening));
    }

    function toggleProfileMenu() {
      const menu = document.getElementById('profile-menu');
      const trigger = document.getElementById('profile-menu-trigger');
      const isOpening = menu.classList.contains('hidden');
      if (isOpening) syncProfileMenuWidth();
      menu.classList.toggle('hidden', !isOpening);
      trigger.setAttribute('aria-expanded', String(isOpening));
    }

    function syncProfileMenuWidth() {
      const menu = document.getElementById('profile-menu');
      const trigger = document.getElementById('profile-menu-trigger');
      if (window.matchMedia('(min-width: 640px)').matches) {
        menu.style.width = `${Math.min(trigger.getBoundingClientRect().width + 14, window.innerWidth - 16)}px`;
      } else {
        menu.style.width = 'max-content';
      }
    }

    function closeProfileMenu() {
      document.getElementById('profile-menu').classList.add('hidden');
      document.getElementById('profile-menu-trigger').setAttribute('aria-expanded', 'false');
    }

    window.addEventListener('resize', () => {
      if (!document.getElementById('profile-menu').classList.contains('hidden')) syncProfileMenuWidth();
    });

    function markNotificationsRead() {
      activityLog.forEach(activity => { activity.unread = false; });
      renderNotifications();
    }

    document.addEventListener('click', event => {
      const insideNotifications = event.target.closest('#notification-panel') || event.target.closest('[aria-controls="notification-panel"]');
      const insideProfileMenu = event.target.closest('#profile-menu-container');
      if (!insideNotifications) {
        document.getElementById('notification-panel').classList.add('hidden');
        document.querySelector('[aria-controls="notification-panel"]').setAttribute('aria-expanded', 'false');
      }
      if (!insideProfileMenu) closeProfileMenu();
    });

    function previewEvidence(event) {
      const file = event.target.files[0];
      if (!file) return;
      if (!['image/jpeg', 'image/png', 'image/webp'].includes(file.type) || file.size > 5 * 1024 * 1024) {
        alert(translateText('Pilih gambar JPG, PNG, atau WEBP dengan ukuran maksimal 5 MB.'));
        event.target.value = '';
        return;
      }
      const reader = new FileReader();
      reader.onload = () => {
        pendingEvidence = reader.result;
        const preview = document.getElementById('evidence-preview');
        preview.innerHTML = `<img src="${pendingEvidence}" alt="Pratinjau bukti kerusakan" class="h-14 w-14 rounded-lg object-cover"><span class="min-w-0 flex-1 truncate text-sm font-medium">${escapeHTML(file.name)}</span><button type="button" onclick="clearEvidence()" aria-label="Hapus foto" class="rounded-lg p-2 text-slate-500 hover:bg-slate-100"><span class="material-symbols-outlined">close</span></button>`;
        preview.classList.remove('hidden');
        preview.classList.add('flex');
      };
      reader.readAsDataURL(file);
    }

    function clearEvidence() {
      pendingEvidence = '';
      document.getElementById('form-bukti').value = '';
      document.getElementById('evidence-preview').classList.add('hidden');
      document.getElementById('evidence-preview').classList.remove('flex');
      document.getElementById('evidence-preview').innerHTML = '';
    }

    function setupEvidenceDropzone() {
      const dropzone = document.getElementById('evidence-dropzone');
      ['dragenter', 'dragover'].forEach(eventName => dropzone.addEventListener(eventName, event => {
        event.preventDefault();
        dropzone.classList.add('border-blue-500', 'bg-blue-50');
      }));
      ['dragleave', 'drop'].forEach(eventName => dropzone.addEventListener(eventName, event => {
        event.preventDefault();
        dropzone.classList.remove('border-blue-500', 'bg-blue-50');
      }));
      dropzone.addEventListener('drop', event => {
        const file = event.dataTransfer.files[0];
        if (!file) return;
        const input = document.getElementById('form-bukti');
        const transfer = new DataTransfer();
        transfer.items.add(file);
        input.files = transfer.files;
        previewEvidence({ target: input });
      });
    }

    setupEvidenceDropzone();
    renderNotifications();

    // ROLE SWITCHER ON AUTH
    function switchRole(role) {
      activeRole = role;
      const tabSiswa = document.getElementById('tab-siswa');
      const tabAdmin = document.getElementById('tab-admin');
      const identityLabel = document.getElementById('identity-label');
      const loginIdentity = document.getElementById('login-identity');
      const hintCred = document.getElementById('hint-credential');

      if (role === 'siswa') {
        tabSiswa.className = "flex items-center justify-center gap-2 py-2.5 px-3 rounded-lg font-semibold text-sm transition-all shadow-sm bg-white dark:bg-slate-800 text-blue-600 dark:text-blue-400";
        tabAdmin.className = "flex items-center justify-center gap-2 py-2.5 px-3 rounded-lg font-semibold text-sm transition-all text-slate-600 dark:text-slate-300 hover:text-slate-900";
        identityLabel.innerText = translateText('NISN / Nomor Induk Siswa');
        loginIdentity.placeholder = translateText('Masukkan 10 digit NISN...');
        loginIdentity.value = "12345678";
        hintCred.innerHTML = `${escapeHTML(translateText('Mode Siswa: ID'))} <strong>12345678</strong> ${escapeHTML(translateText('/ Sandi'))} <strong>harapan2024</strong>`;
      } else {
        tabAdmin.className = "flex items-center justify-center gap-2 py-2.5 px-3 rounded-lg font-semibold text-sm transition-all shadow-sm bg-white dark:bg-slate-800 text-blue-600 dark:text-blue-400";
        tabSiswa.className = "flex items-center justify-center gap-2 py-2.5 px-3 rounded-lg font-semibold text-sm transition-all text-slate-600 dark:text-slate-300 hover:text-slate-900";
        identityLabel.innerText = translateText('NIP / Username Pengelola Sarpras');
        loginIdentity.placeholder = translateText('Masukkan NIP atau Username...');
        loginIdentity.value = "admin_sarpras";
        hintCred.innerHTML = `${escapeHTML(translateText('Mode Admin: ID'))} <strong>admin_sarpras</strong> ${escapeHTML(translateText('/ Sandi'))} <strong>harapan2024</strong>`;
      }
    }

    // TOGGLE LOGIN / REGISTER
    function toggleAuthMode() {
      isRegisterMode = !isRegisterMode;
      const formLogin = document.getElementById('form-login');
      const formReg = document.getElementById('form-register');
      const roleSelector = document.getElementById('role-selector');
      const authTitle = document.getElementById('auth-title');
      const togglePrompt = document.getElementById('toggle-prompt');
      const toggleLink = document.getElementById('toggle-link');

      if (isRegisterMode) {
        formLogin.classList.add('hidden');
        formReg.classList.remove('hidden');
        roleSelector.classList.add('hidden');
        authTitle.innerText = translateText('Daftar Akun Siswa Baru');
        togglePrompt.innerText = translateText('Sudah memiliki akun?');
        toggleLink.innerText = translateText('Masuk Sekarang');
      } else {
        formLogin.classList.remove('hidden');
        formReg.classList.add('hidden');
        roleSelector.classList.remove('hidden');
        authTitle.innerText = translateText('Masuk ke Portal');
        togglePrompt.innerText = translateText('Belum memiliki akun?');
        toggleLink.innerText = translateText('Daftar Akun Baru');
      }
    }

    // AUTH ACTIONS
    function handleLogin(e) {
      e.preventDefault();
      const identity = document.getElementById('login-identity').value;
      
      if (activeRole === 'siswa') {
        currentUser = { role: 'siswa', name: 'Budi Santoso', identity: identity, kelas: 'XII RPL 1', email: 'budi.santoso@siswa.sman1.sch.id', phone: '+62 812-3456-7890' };
      } else {
        currentUser = { role: 'admin', name: 'Admin Sarpras (Pak Hendra)', identity: identity, jabatan: 'Kepala Inventaris', email: 'admin.sarpras@sman1.sch.id', phone: '+62 811-2222-3344' };
      }
      renderDashboard();
    }

    function handleRegister(e) {
      e.preventDefault();
      document.getElementById('registration-success-title').textContent = translateText('Pendaftaran Berhasil');
      document.querySelector('#modal-registration-success p').textContent = translateText('Pendaftaran berhasil! Silakan masuk menggunakan akun Anda.');
      document.querySelector('#modal-registration-success button').textContent = translateText('Masuk Sekarang');
      const modal = document.getElementById('modal-registration-success');
      modal.classList.remove('hidden');
      modal.classList.add('flex');
      document.querySelector('#modal-registration-success button').focus();
    }

    function closeRegistrationSuccess() {
      const modal = document.getElementById('modal-registration-success');
      const wasOpen = !modal.classList.contains('hidden');
      modal.classList.add('hidden');
      modal.classList.remove('flex');
      if (wasOpen) toggleAuthMode();
    }

    function handleLogout() {
      closeMobileSidebar();
      closeProfileMenu();
      document.body.classList.remove('dashboard-active');
      currentUser = null;
      document.getElementById('view-dashboard').classList.add('hidden');
      document.getElementById('view-auth').classList.remove('hidden');
    }

    // DASHBOARD RENDERER
    function renderDashboard() {
      document.body.classList.add('dashboard-active');
      document.getElementById('view-auth').classList.add('hidden');
      document.getElementById('view-dashboard').classList.remove('hidden');

      // Update Nav Details
      document.getElementById('nav-user-name').innerText = currentUser.role === 'admin' ? translateText('Admin') : currentUser.name;
      document.getElementById('profile-menu-name').innerText = currentUser.name;
      document.getElementById('profile-menu-sub').innerText = currentUser.role === 'siswa' ? `NIS: ${currentUser.identity}` : currentUser.jabatan;
      document.getElementById('nav-user-avatar').innerText = currentUser.name.charAt(0);
      document.getElementById('user-role-badge').innerText = translateText(currentUser.role === 'siswa' ? 'Siswa' : 'Admin');

      if (currentUser.role === 'siswa') {
        document.getElementById('sidebar-siswa-menu').classList.remove('hidden');
        document.getElementById('sidebar-admin-menu').classList.add('hidden');
        switchTabSiswa('form');
      } else {
        document.getElementById('sidebar-siswa-menu').classList.add('hidden');
        document.getElementById('sidebar-admin-menu').classList.remove('hidden');
        switchTabAdmin('dashboard');
      }
      renderTables();
    }

    // TAB NAVIGATION SISWA
    function switchTabSiswa(tab) {
      hideAllSections();
      if (tab === 'form') document.getElementById('section-siswa-form').classList.remove('hidden');
      if (tab === 'laporan') document.getElementById('section-siswa-laporan').classList.remove('hidden');
      if (tab === 'profile') showProfile();
      setActiveSidebar('siswa', tab);
      closeMobileSidebar();
    }

    // TAB NAVIGATION ADMIN
    function switchTabAdmin(tab) {
      hideAllSections();
      if (tab === 'dashboard') {
        document.getElementById('section-admin-dash').classList.remove('hidden');
        document.getElementById('section-admin-pengaduan').classList.remove('hidden');
      }
      if (tab === 'pengaduan') document.getElementById('section-admin-pengaduan').classList.remove('hidden');
      if (tab === 'laporan') {
        document.getElementById('section-admin-laporan').classList.remove('hidden');
        renderReportDashboard();
      }
      if (tab === 'profile') showProfile();
      setActiveSidebar('admin', tab);
      closeMobileSidebar();
    }

    function toggleMobileSidebar() {
      const sidebar = document.getElementById('dashboard-sidebar');
      const isOpening = sidebar.classList.contains('-translate-x-full');
      sidebar.classList.toggle('-translate-x-full', !isOpening);
      document.getElementById('mobile-sidebar-backdrop').classList.toggle('hidden', !isOpening);
      document.getElementById('mobile-menu-toggle').setAttribute('aria-expanded', String(isOpening));
      document.getElementById('mobile-menu-toggle').setAttribute('aria-label', isOpening ? 'Tutup menu navigasi' : 'Buka menu navigasi');
      document.getElementById('mobile-menu-icon').textContent = isOpening ? 'close' : 'menu';
    }

    function closeMobileSidebar() {
      document.getElementById('dashboard-sidebar').classList.add('-translate-x-full');
      document.getElementById('mobile-sidebar-backdrop').classList.add('hidden');
      document.getElementById('mobile-menu-toggle').setAttribute('aria-expanded', 'false');
      document.getElementById('mobile-menu-toggle').setAttribute('aria-label', 'Buka menu navigasi');
      document.getElementById('mobile-menu-icon').textContent = 'menu';
    }

    function setActiveSidebar(role, tab) {
      const menu = document.getElementById(`sidebar-${role}-menu`);
      menu.querySelectorAll('.sidebar-link').forEach(button => button.classList.remove('active'));
      const suffix = role === 'siswa' ? (tab === 'laporan' ? 'laporan' : tab) : (tab === 'dashboard' ? 'dash' : tab);
      document.getElementById(`btn-${role}-${suffix}`)?.classList.add('active');
    }

    function hideAllSections() {
      document.getElementById('section-siswa-form').classList.add('hidden');
      document.getElementById('section-siswa-laporan').classList.add('hidden');
      document.getElementById('section-admin-dash').classList.add('hidden');
      document.getElementById('section-admin-pengaduan').classList.add('hidden');
      document.getElementById('section-admin-laporan').classList.add('hidden');
      document.getElementById('section-profile').classList.add('hidden');
    }

    function showProfile() {
      document.getElementById('section-profile').classList.remove('hidden');
      document.getElementById('prof-name').innerText = currentUser.name;
      document.getElementById('prof-sub').innerText = currentUser.role === 'siswa' ? `Siswa Kelas - ${currentUser.kelas}` : currentUser.jabatan;
      document.getElementById('prof-avatar').innerText = currentUser.name.charAt(0);
      document.getElementById('profile-email').textContent = currentUser.email || '-';
      document.getElementById('profile-phone').textContent = currentUser.phone || '-';
      const studentReports = dummyAspirasi.filter(report => currentUser.role === 'siswa' && report.nis === currentUser.identity);
      document.getElementById('profile-report-stat').classList.toggle('hidden', currentUser.role !== 'siswa');
      document.getElementById('profile-report-total').textContent = studentReports.length;
    }

    function openPasswordModal() {
      const message = document.getElementById('password-error');
      message.classList.add('hidden');
      message.classList.remove('text-emerald-600');
      message.classList.add('text-rose-600');
      const modal = document.getElementById('modal-password');
      modal.classList.remove('hidden');
      modal.classList.add('flex');
      document.getElementById('current-password').focus();
    }

    function closePasswordModal() {
      const modal = document.getElementById('modal-password');
      modal.classList.add('hidden');
      modal.classList.remove('flex');
      document.getElementById('password-change-form')?.reset();
    }

    function changePassword(event) {
      event.preventDefault();
      const newPassword = document.getElementById('new-password').value;
      const confirmation = document.getElementById('confirm-password').value;
      const message = document.getElementById('password-error');
      if (newPassword !== confirmation) {
        message.textContent = translateText('Konfirmasi kata sandi baru belum cocok.');
        message.classList.remove('text-emerald-600');
        message.classList.add('text-rose-600');
        message.classList.remove('hidden');
        return;
      }
      message.textContent = translateText('Validasi berhasil. Perubahan belum disimpan karena layanan akun belum terhubung.');
      message.classList.remove('hidden');
      message.classList.remove('text-rose-600');
      message.classList.add('text-emerald-600');
    }

    // CRUD ASPIRASI SISWA
    function submitAspirasi(e) {
      e.preventDefault();
      const newAspirasi = {
        id: Math.max(...dummyAspirasi.map(item => item.id), 100) + 1,
        nis: currentUser.identity,
        pelapor: currentUser.name,
        peran: currentUser.role === 'admin' ? 'Admin' : 'Siswa',
        kategori: document.getElementById('form-kategori').value,
        lokasi: document.getElementById('form-lokasi').value,
        ket: document.getElementById('form-ket').value,
        status: 'Menunggu',
        feedback: 'Belum ada umpan balik',
        urgensi: document.getElementById('form-urgensi').value,
        bukti: pendingEvidence,
        date: new Date().toISOString(),
        completedAt: null,
        handlingDays: null,
        rating: 0,
        review: ''
      };
      newAspirasi.timeline = buildTimeline(newAspirasi.status, newAspirasi.date, newAspirasi.feedback);
      dummyAspirasi.unshift(newAspirasi);
      addActivity(`Laporan #${newAspirasi.id} berhasil dikirim.`);
      document.getElementById('form-lokasi').value = '';
      document.getElementById('form-ket').value = '';
      document.getElementById('form-kategori').selectedIndex = 0;
      document.getElementById('form-urgensi').value = 'Sedang';
      clearEvidence();
      switchTabSiswa('laporan');
      renderTables();
    }

    // RENDER TABLES
    function renderTables() {
      // Tabel Siswa
      const tblSiswa = document.getElementById('tbl-siswa-histori');
      const search = (document.getElementById('history-search')?.value || '').toLowerCase().trim();
      const category = document.getElementById('history-category')?.value || '';
      const status = document.getElementById('history-status')?.value || '';
      const urgency = document.getElementById('history-urgency')?.value || '';
      const sort = document.getElementById('history-sort')?.value || 'newest';
      const studentReports = dummyAspirasi.filter(item => currentUser?.role !== 'siswa' || item.nis === currentUser.identity);
      const filteredReports = studentReports.filter(item => {
        const matchesSearch = [item.id, item.nis, item.pelapor, item.kategori, translateText(item.kategori), item.lokasi, item.ket, item.status, translateText(item.status === 'Proses' ? 'Dalam Proses' : item.status), item.urgensi, translateText(item.urgensi)].some(value => String(value ?? '').toLowerCase().includes(search));
        return matchesSearch && (!category || item.kategori === category) && (!status || item.status === status) && (!urgency || item.urgensi === urgency);
      }).sort((first, second) => sort === 'oldest' ? new Date(first.date) - new Date(second.date) : new Date(second.date) - new Date(first.date));

      tblSiswa.innerHTML = filteredReports.length ? filteredReports.map(item => `
        <tr onclick="showTimeline(${item.id})" onkeydown="if(event.key === 'Enter' || event.key === ' ') { event.preventDefault(); showTimeline(${item.id}); }" tabindex="0" class="focus:outline-none focus-visible:ring-2 focus-visible:ring-inset focus-visible:ring-blue-500">
          <td class="whitespace-nowrap p-4"><strong class="text-slate-800 dark:text-white">#${item.id}</strong><time class="mt-1 block text-[10px] text-slate-400">${formatDate(item.date)}</time></td>
          <td class="p-4"><strong>${escapeHTML(item.lokasi)}</strong><span class="mt-1 block text-slate-400">${escapeHTML(translateText(item.kategori))}</span></td>
          <td class="p-4">${item.bukti ? `<img src="${item.bukti}" alt="Bukti ${escapeHTML(item.lokasi)}" class="h-12 w-12 rounded-lg border border-slate-200 object-cover dark:border-slate-600">` : '<span class="text-slate-400">Tidak ada foto</span>'}</td>
          <td class="p-4">${getBadgeUrgency(item.urgensi)}</td>
          <td class="p-4">${getBadgeStatus(item.status)}</td>
          <td class="p-4"><span class="block max-w-48 text-slate-500">${escapeHTML(translateText(item.feedback))}</span>${item.status === 'Selesai' ? (item.rating ? `<span class="mt-1 block text-amber-500" aria-label="Rating ${item.rating} dari 5">${'★'.repeat(item.rating)}${'☆'.repeat(5 - item.rating)}</span>${item.review ? `<span class="mt-1 block max-w-48 text-[11px] text-slate-500">${escapeHTML(translateText('Ulasan'))}: ${escapeHTML(item.review)}</span>` : ''}` : `<button type="button" onclick="event.stopPropagation(); openRating(${item.id})" class="mt-2 inline-flex items-center gap-1 rounded-lg bg-amber-50 px-2.5 py-1.5 font-bold text-amber-700 hover:bg-amber-100"><span class="material-symbols-outlined text-base">star</span>${escapeHTML(translateText('Beri rating'))}</button>`) : `<button type="button" onclick="event.stopPropagation(); showTimeline(${item.id})" class="mt-1 inline-flex items-center gap-1 font-semibold text-blue-600 hover:text-blue-800 hover:underline"><span>${escapeHTML(translateText('Lihat progres'))}</span><span aria-hidden="true">→</span></button>`}</td>
        </tr>
      `).join('') : `<tr><td colspan="6" class="p-10 text-center text-sm text-slate-500">${escapeHTML(translateText('Data tidak ditemukan.'))}</td></tr>`;

      document.getElementById('stat-total').textContent = studentReports.length;
      document.getElementById('stat-proses').textContent = studentReports.filter(item => item.status === 'Menunggu' || item.status === 'Proses').length;
      document.getElementById('stat-selesai').textContent = studentReports.filter(item => item.status === 'Selesai').length;
      document.getElementById('stat-ditolak').textContent = studentReports.filter(item => item.status === 'Ditolak').length;

      // Tabel Admin
      const tblAdmin = document.getElementById('tbl-admin-pengaduan');
      const adminSearch = (document.getElementById('admin-report-search')?.value || '').toLowerCase().trim();
      const adminCategory = document.getElementById('admin-report-category')?.value || '';
      const adminStatus = document.getElementById('admin-report-status')?.value || '';
      const adminUrgency = document.getElementById('admin-report-urgency')?.value || '';
      const adminReports = dummyAspirasi.filter(item => {
        const matchesSearch = [item.id, item.nis, item.pelapor, item.lokasi, item.kategori, translateText(item.kategori), item.ket, item.status, translateText(item.status === 'Proses' ? 'Dalam Proses' : item.status), item.urgensi, translateText(item.urgensi)]
          .some(value => String(value ?? '').toLowerCase().includes(adminSearch));
        return matchesSearch && (!adminCategory || item.kategori === adminCategory)
          && (!adminStatus || item.status === adminStatus) && (!adminUrgency || item.urgensi === adminUrgency);
      });
      tblAdmin.innerHTML = adminReports.length ? adminReports.map(item => `
        <tr>
          <td class="p-3 font-semibold">#${item.id}</td>
          <td class="p-3">${item.nis}</td>
          <td class="p-3"><strong>${escapeHTML(item.lokasi)}</strong><br><span class="text-slate-400">${escapeHTML(translateText(item.kategori))}</span></td>
          <td class="p-3">${escapeHTML(item.ket)}</td>
          <td class="p-3">${getBadgeStatus(item.status)}</td>
          <td class="p-3">${getBadgeUrgency(item.urgensi)}</td>
          <td class="p-3">
            <button onclick="openAdminModal(${item.id})" class="px-2.5 py-1 rounded bg-blue-600 text-white text-[11px] font-semibold hover:bg-blue-700">
              ${escapeHTML(translateText('Tindak Lanjut'))}
            </button>
          </td>
        </tr>
      `).join('') : `<tr><td colspan="7" class="p-8 text-center text-sm text-slate-500">${escapeHTML(translateText('Data tidak ditemukan.'))}</td></tr>`;
    }

    const reportPageSize = 5;
    let reportCurrentPage = 1;
    let reportTrendChart = null;
    let reportCategoryChart = null;

    function getFilteredReportRecords() {
      const startDate = document.getElementById('report-start-date').value;
      const endDate = document.getElementById('report-end-date').value;
      const category = document.getElementById('report-category').value;
      const status = document.getElementById('report-status').value;
      const urgency = document.getElementById('report-urgency').value;

      return dummyAspirasi.filter(report => {
        const parsedDate = new Date(report.date);
        const reportDate = new Date(parsedDate.getTime() - parsedDate.getTimezoneOffset() * 60000).toISOString().slice(0, 10);
        return (!startDate || reportDate >= startDate)
          && (!endDate || reportDate <= endDate)
          && (!category || report.kategori === category)
          && (!status || report.status === status)
          && (!urgency || report.urgensi === urgency);
      }).sort((first, second) => new Date(second.date) - new Date(first.date));
    }

    function applyReportFilters(event) {
      event.preventDefault();
      reportCurrentPage = 1;
      renderReportDashboard();
    }

    function resetReportFilters() {
      document.getElementById('report-filter-form').reset();
      document.getElementById('report-search').value = '';
      reportCurrentPage = 1;
      renderReportDashboard();
    }

    function searchReportTable() {
      reportCurrentPage = 1;
      renderReportTable();
    }

    function matchesReportSearch(report, search) {
      return [report.id, report.nis, report.pelapor, report.peran, report.lokasi, report.kategori, translateText(report.kategori), report.ket, report.status, translateText(report.status === 'Proses' ? 'Dalam Proses' : report.status), report.urgensi, translateText(report.urgensi)]
        .some(value => String(value ?? '').toLowerCase().includes(search));
    }

    function renderReportDashboard() {
      const reports = getFilteredReportRecords();
      const completedReports = reports.filter(report => report.status === 'Selesai');
      const handlingDurations = completedReports
        .map(report => report.handlingDays)
        .filter(duration => Number.isFinite(Number(duration)))
        .map(Number);
      const averageDays = handlingDurations.length
        ? (handlingDurations.reduce((total, duration) => total + duration, 0) / handlingDurations.length).toFixed(1).replace(/\.0$/, '')
        : '0';

      document.getElementById('report-kpi-total').textContent = reports.length;
      document.getElementById('report-kpi-completed').textContent = completedReports.length;
      document.getElementById('report-kpi-progress').textContent = reports.filter(report => report.status === 'Menunggu' || report.status === 'Proses').length;
      document.getElementById('report-kpi-average').textContent = averageDays;
      renderReportCharts(reports);
      renderReportTable();
    }

    function renderReportCharts(reports) {
      if (!window.Chart) return;
      const isDark = document.documentElement.classList.contains('dark');
      const tickColor = isDark ? '#cbd5e1' : '#64748b';
      const gridColor = isDark ? 'rgba(148, 163, 184, .16)' : 'rgba(148, 163, 184, .2)';
      const months = Array.from({ length: 6 }, (_, index) => {
        const date = new Date();
        date.setDate(1);
        date.setMonth(date.getMonth() - 5 + index);
        return date;
      });
      const monthLabels = months.map(date => date.toLocaleDateString(currentLanguage === 'en' ? 'en-US' : 'id-ID', { month: 'short', year: '2-digit' }));
      const monthlyCounts = months.map(month => reports.filter(report => {
        const reportDate = new Date(report.date);
        return reportDate.getMonth() === month.getMonth() && reportDate.getFullYear() === month.getFullYear();
      }).length);
      const categoryCounts = reports.reduce((counts, report) => {
        counts[report.kategori] = (counts[report.kategori] || 0) + 1;
        return counts;
      }, {});
      const palette = ['#2563eb', '#10b981', '#f59e0b', '#f43f5e', '#06b6d4', '#8b5cf6'];

      reportTrendChart?.destroy();
      reportCategoryChart?.destroy();
      reportTrendChart = new Chart(document.getElementById('report-trend-chart'), {
        type: 'line',
        data: {
          labels: monthLabels,
          datasets: [{
            label: translateText('Pengaduan'),
            data: monthlyCounts,
            borderColor: '#2563eb',
            backgroundColor: 'rgba(37, 99, 235, .12)',
            pointBackgroundColor: '#2563eb',
            pointRadius: 4,
            pointHoverRadius: 6,
            fill: true,
            tension: .35
          }]
        },
        options: {
          maintainAspectRatio: false,
          plugins: { legend: { display: false } },
          scales: {
            x: { ticks: { color: tickColor }, grid: { display: false } },
            y: { beginAtZero: true, ticks: { precision: 0, color: tickColor }, grid: { color: gridColor } }
          }
        }
      });
      reportCategoryChart = new Chart(document.getElementById('report-category-chart'), {
        type: 'doughnut',
        data: {
          labels: Object.keys(categoryCounts).length ? Object.keys(categoryCounts).map(translateText) : [translateText('Belum ada data')],
          datasets: [{
            data: Object.keys(categoryCounts).length ? Object.values(categoryCounts) : [1],
            backgroundColor: Object.keys(categoryCounts).length ? palette.slice(0, Object.keys(categoryCounts).length) : ['#cbd5e1'],
            borderColor: isDark ? '#1e293b' : '#ffffff',
            borderWidth: 3,
            hoverOffset: 6
          }]
        },
        options: {
          maintainAspectRatio: false,
          cutout: '62%',
          plugins: { legend: { position: 'bottom', labels: { color: tickColor, usePointStyle: true, padding: 16 } } }
        }
      });
    }

    function renderReportTable() {
      const search = document.getElementById('report-search').value.toLowerCase().trim();
      const reports = getFilteredReportRecords().filter(report => matchesReportSearch(report, search));
      const totalPages = Math.max(1, Math.ceil(reports.length / reportPageSize));
      reportCurrentPage = Math.min(reportCurrentPage, totalPages);
      const firstIndex = (reportCurrentPage - 1) * reportPageSize;
      const pageReports = reports.slice(firstIndex, firstIndex + reportPageSize);
      const tableBody = document.getElementById('report-table-body');

      tableBody.innerHTML = pageReports.length ? pageReports.map(report => `
        <tr class="transition-colors hover:bg-slate-50 dark:hover:bg-slate-700/40">
          <td class="whitespace-nowrap p-4 font-bold text-slate-800 dark:text-white">#${escapeHTML(report.id)}</td>
          <td class="whitespace-nowrap p-4 text-slate-600 dark:text-slate-300">${formatDate(report.date)}</td>
          <td class="p-4"><strong class="block font-semibold text-slate-800 dark:text-white">${escapeHTML(report.pelapor)}</strong><span class="mt-1 block text-[11px] text-slate-400">${escapeHTML(translateText(report.peran))} · ${escapeHTML(report.nis)}</span></td>
          <td class="p-4"><strong class="block font-semibold text-slate-800 dark:text-white">${escapeHTML(report.lokasi)}</strong><span class="mt-1 block text-[11px] text-slate-400">${escapeHTML(translateText(report.kategori))}</span></td>
          <td class="max-w-64 p-4 text-slate-600 dark:text-slate-300">${escapeHTML(report.ket)}</td>
          <td class="whitespace-nowrap p-4">${getBadgeStatus(report.status)}</td>
          <td class="whitespace-nowrap p-4 text-slate-600 dark:text-slate-300">${report.completedAt ? formatDate(report.completedAt) : '—'}</td>
          <td class="whitespace-nowrap p-4 text-slate-600 dark:text-slate-300">${report.handlingDays !== null && report.handlingDays !== undefined ? `${escapeHTML(report.handlingDays)} ${escapeHTML(translateText(Number(report.handlingDays) === 1 ? 'day' : 'hari'))}` : '—'}</td>
        </tr>`).join('') : `<tr><td colspan="8" class="p-10 text-center text-sm text-slate-500">${escapeHTML(translateText('Data tidak ditemukan.'))}</td></tr>`;

      document.getElementById('report-results-count').textContent = reports.length
        ? currentLanguage === 'en'
          ? `Showing ${firstIndex + 1}–${Math.min(firstIndex + reportPageSize, reports.length)} of ${reports.length} reports`
          : `Menampilkan ${firstIndex + 1}–${Math.min(firstIndex + reportPageSize, reports.length)} dari ${reports.length} laporan`
        : translateText('Data tidak ditemukan.');
      document.getElementById('report-page-label').textContent = `${reportCurrentPage} / ${totalPages}`;
      document.getElementById('report-page-previous').disabled = reportCurrentPage <= 1;
      document.getElementById('report-page-next').disabled = reportCurrentPage >= totalPages;
    }

    function changeReportPage(direction) {
      const search = document.getElementById('report-search').value.toLowerCase().trim();
      const totalReports = getFilteredReportRecords().filter(report => matchesReportSearch(report, search)).length;
      const totalPages = Math.max(1, Math.ceil(totalReports / reportPageSize));
      reportCurrentPage = Math.max(1, Math.min(totalPages, reportCurrentPage + direction));
      renderReportTable();
    }

    function escapeCsvCell(value) {
      const text = String(value ?? '');
      const safeText = /^[\s]*[=+\-@]/.test(text) ? `'${text}` : text;
      return `"${safeText.replace(/"/g, '""')}"`;
    }

    function exportReportCsv() {
      const search = document.getElementById('report-search').value.toLowerCase().trim();
      const reports = getFilteredReportRecords().filter(report => matchesReportSearch(report, search));
      const headers = ['ID', 'Tanggal Masuk', 'Pelapor', 'Peran', 'Lokasi', 'Kategori', 'Deskripsi Singkat', 'Status', 'Urgensi', 'Tanggal Selesai', 'Durasi'].map(translateText);
      const rows = reports.map(report => [report.id, formatDate(report.date), report.pelapor, report.peran, report.lokasi, report.kategori, report.ket, report.status, report.urgensi, report.completedAt ? formatDate(report.completedAt) : '', report.handlingDays ?? '']);
      const csv = `\uFEFF${[headers, ...rows].map(row => row.map(escapeCsvCell).join(',')).join('\r\n')}`;
      const downloadUrl = URL.createObjectURL(new Blob([csv], { type: 'text/csv;charset=utf-8;' }));
      const downloadLink = document.createElement('a');
      downloadLink.href = downloadUrl;
      downloadLink.download = `rekap-pengaduan-${new Date().toISOString().slice(0, 10)}.csv`;
      document.body.appendChild(downloadLink);
      downloadLink.click();
      downloadLink.remove();
      setTimeout(() => URL.revokeObjectURL(downloadUrl), 1000);
    }

    function printReport() {
      window.print();
    }

    function getBadgeStatus(status) {
      const styles = { Menunggu: 'bg-amber-100 text-amber-700', Proses: 'bg-orange-100 text-orange-700', Selesai: 'bg-emerald-100 text-emerald-700', Ditolak: 'bg-rose-100 text-rose-700' };
      const label = status === 'Proses' ? 'Dalam Proses' : status;
      return `<span class="inline-flex rounded-full px-2.5 py-1 text-[10px] font-bold ${styles[status] || 'bg-slate-100 text-slate-700'}">${escapeHTML(translateText(label))}</span>`;
    }

    function getBadgeUrgency(urgency) {
      const styles = { Rendah: 'bg-slate-100 text-slate-600', Sedang: 'bg-amber-100 text-amber-700', Darurat: 'bg-rose-100 text-rose-700' };
      return `<span class="inline-flex rounded-full px-2.5 py-1 text-[10px] font-bold ${styles[urgency] || styles.Sedang}">${escapeHTML(translateText(urgency))}</span>`;
    }

    function showTimeline(id) {
      const item = dummyAspirasi.find(report => report.id === id);
      if (!item) return;
      activeTimelineId = id;
      const reportLabel = currentLanguage === 'en' ? 'REPORT' : 'LAPORAN';
      document.getElementById('timeline-id').textContent = `${reportLabel} #${item.id} · ${translateText(item.status).toUpperCase()}`;
      document.getElementById('timeline-description').textContent = `${item.lokasi} · ${translateText(item.kategori)}`;
      const timeline = document.getElementById('timeline-content');
      timeline.innerHTML = item.timeline.map((stage, index) => `
        <div class="relative flex gap-4 pb-5 last:pb-0">
          ${index < item.timeline.length - 1 ? `<span class="absolute left-[11px] top-6 h-full w-px ${stage.complete ? 'bg-emerald-200' : 'bg-slate-200 dark:bg-slate-700'}"></span>` : ''}
          <span class="relative z-10 mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full ${stage.complete ? 'bg-emerald-100 text-emerald-700' : stage.current ? 'bg-blue-100 text-blue-700' : 'bg-slate-100 text-slate-400'}"><span class="material-symbols-outlined text-base">${stage.complete ? 'check' : stage.current ? 'pending' : 'radio_button_unchecked'}</span></span>
          <div class="min-w-0 flex-1"><div class="flex flex-wrap items-baseline justify-between gap-2"><h3 class="text-sm font-bold">${escapeHTML(translateText(stage.title))}</h3><time class="text-[11px] text-slate-400">${stage.date ? new Date(stage.date).toLocaleString(currentLanguage === 'en' ? 'en-US' : 'id-ID', { dateStyle: 'medium', timeStyle: 'short' }) : escapeHTML(translateText('Belum dijadwalkan'))}</time></div><p class="mt-1 text-sm text-slate-500">${escapeHTML(translateText(stage.note))}</p></div>
        </div>`).join('');
      const dialog = document.getElementById('modal-timeline');
      dialog.classList.remove('hidden');
      dialog.classList.add('flex');
    }

    function closeTimeline() {
      const dialog = document.getElementById('modal-timeline');
      dialog.classList.add('hidden');
      dialog.classList.remove('flex');
      activeTimelineId = null;
    }

    function openRating(id) {
      const item = dummyAspirasi.find(report => report.id === id && report.status === 'Selesai');
      if (!item) return;
      selectedRating = item.rating || 0;
      document.getElementById('rating-id').value = item.id;
      document.getElementById('rating-report-id').textContent = `LAPORAN #${item.id}`;
      document.getElementById('rating-review').value = item.review || '';
      renderRatingStars();
      const dialog = document.getElementById('modal-rating');
      dialog.classList.remove('hidden');
      dialog.classList.add('flex');
    }

    function renderRatingStars() {
      document.getElementById('rating-stars').innerHTML = [1, 2, 3, 4, 5].map(value => `<button type="button" role="radio" aria-checked="${selectedRating === value}" aria-label="${value} dari 5 bintang" onclick="setRating(${value})" class="rounded-lg p-1 text-3xl leading-none ${selectedRating >= value ? 'text-amber-400' : 'text-slate-300'}">★</button>`).join('');
    }

    function setRating(value) {
      selectedRating = value;
      renderRatingStars();
    }

    function closeRating() {
      const dialog = document.getElementById('modal-rating');
      dialog.classList.add('hidden');
      dialog.classList.remove('flex');
    }

    function saveRating(event) {
      event.preventDefault();
      if (!selectedRating) {
        alert(translateText('Pilih rating bintang terlebih dahulu.'));
        return;
      }
      const id = Number(document.getElementById('rating-id').value);
      const item = dummyAspirasi.find(report => report.id === id && report.status === 'Selesai');
      if (!item) return;
      item.rating = selectedRating;
      item.review = document.getElementById('rating-review').value.trim();
      closeRating();
      addActivity(`Ulasan untuk laporan #${item.id} berhasil dikirim.`);
      renderTables();
    }

    document.addEventListener('keydown', event => {
      if (event.key === 'Escape') {
        closeTimeline();
        closeRating();
        closePasswordModal();
        closeRegistrationSuccess();
        closeMobileSidebar();
        closeProfileMenu();
        document.getElementById('notification-panel').classList.add('hidden');
        document.querySelector('[aria-controls="notification-panel"]').setAttribute('aria-expanded', 'false');
      }
    });

    // MODAL ADMIN ACTION
    function openAdminModal(id) {
      const item = dummyAspirasi.find(a => a.id === id);
      if (!item) return;
      document.getElementById('modal-aspirasi-id').value = item.id;
      document.getElementById('modal-status').value = item.status;
      document.getElementById('modal-feedback').value = item.feedback === 'Belum ada umpan balik' ? '' : item.feedback;
      document.getElementById('modal-admin-action').classList.remove('hidden');
    }

    function closeAdminModal() {
      document.getElementById('modal-admin-action').classList.add('hidden');
    }

    function saveAdminAction(e) {
      e.preventDefault();
      const id = parseInt(document.getElementById('modal-aspirasi-id').value);
      const item = dummyAspirasi.find(a => a.id === id);
      if (item) {
        const previousStatus = item.status;
        item.status = document.getElementById('modal-status').value;
        item.feedback = document.getElementById('modal-feedback').value;
        if (item.status === 'Selesai' && previousStatus !== 'Selesai') {
          item.completedAt = new Date().toISOString();
          item.handlingDays = Math.max(1, Math.ceil((Date.now() - new Date(item.date).getTime()) / 86400000));
        } else if (item.status !== 'Selesai') {
          item.completedAt = null;
          item.handlingDays = null;
        }
        item.timeline = buildTimeline(item.status, item.date, item.feedback);
        if (previousStatus !== item.status) addActivity(`Status laporan #${item.id} diperbarui menjadi ${item.status}.`);
      }
      closeAdminModal();
      renderTables();
    }

    // UTILITIES (DARK MODE, LANG, PASSWORD)
    function toggleDarkMode() {
      document.documentElement.classList.toggle('dark');
      const isDark = document.documentElement.classList.contains('dark');
      try {
        localStorage.setItem('sipraska-theme', isDark ? 'dark' : 'light');
      } catch (error) { }
      updateThemeControl();
      if (!document.getElementById('section-admin-laporan').classList.contains('hidden')) {
        renderReportCharts(getFilteredReportRecords());
      }
    }

    function setLang(lang) {
      currentLanguage = String(lang).toLowerCase() === 'en' ? 'en' : 'id';
      try {
        localStorage.setItem('sipraska-language', currentLanguage);
      } catch (error) { }
      const isIndonesian = currentLanguage === 'id';
      const buttonClasses = {
        active: 'px-2 py-1 rounded font-bold text-blue-600 bg-blue-50 dark:bg-slate-700',
        inactive: 'px-2 py-1 rounded font-semibold text-slate-500 dark:text-slate-400'
      };
      document.getElementById('btn-lang-id').className = buttonClasses[isIndonesian ? 'active' : 'inactive'];
      document.getElementById('btn-lang-en').className = buttonClasses[isIndonesian ? 'inactive' : 'active'];
      document.getElementById('btn-lang-id').setAttribute('aria-pressed', String(isIndonesian));
      document.getElementById('btn-lang-en').setAttribute('aria-pressed', String(!isIndonesian));
      translateInterface();
      updateThemeControl();
      if (currentUser) {
        document.getElementById('user-role-badge').textContent = translateText(currentUser.role === 'siswa' ? 'Siswa' : 'Admin');
        document.getElementById('profile-menu-name').textContent = currentUser.name;
        document.getElementById('profile-menu-sub').textContent = currentUser.role === 'siswa' ? `NIS: ${currentUser.identity}` : currentUser.jabatan;
      }
      renderNotifications();
      if (currentUser) renderTables();
      if (!document.getElementById('section-admin-laporan').classList.contains('hidden')) renderReportDashboard();
      if (activeTimelineId !== null && !document.getElementById('modal-timeline').classList.contains('hidden')) showTimeline(activeTimelineId);
    }

    function updateThemeControl() {
      const isDark = document.documentElement.classList.contains('dark');
      document.getElementById('theme-text').textContent = translations[currentLanguage][isDark ? 'light' : 'dark'];
      document.getElementById('theme-icon').textContent = isDark ? 'light_mode' : 'dark_mode';
      document.querySelector('button[aria-label="Ganti tema"], button[aria-label="Change theme"]')?.setAttribute('aria-pressed', String(isDark));
    }

    function togglePasswordVisibility(id) {
      const input = document.getElementById(id);
      input.type = input.type === 'password' ? 'text' : 'password';
    }

    setLang(currentLanguage);
  </script>
</body>
</html>
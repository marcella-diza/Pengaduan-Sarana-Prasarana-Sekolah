<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SIPRASKA - Kelola Pengaduan Sarpras</title>
  
  <!-- Google Fonts & Material Symbols -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">
  
  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      darkMode: "class",
      theme: {
        extend: {
          colors: {
            "primary": "#00236f",
            "primary-container": "#1e3a8a",
            "on-primary": "#ffffff",
            "on-primary-container": "#90a8ff",
            "secondary": "#0051d5",
            "secondary-container": "#316bf3",
            "secondary-fixed": "#dbe1ff",
            "on-secondary-fixed": "#00174b",
            "background": "#f8f9ff",
            "surface": "#f8f9ff",
            "surface-container-lowest": "#ffffff",
            "surface-container-low": "#eff4ff",
            "surface-container": "#e5eeff",
            "surface-container-high": "#dce9ff",
            "surface-container-highest": "#d3e4fe",
            "on-surface": "#0b1c30",
            "on-surface-variant": "#444651",
            "outline": "#757682",
            "outline-variant": "#c5c5d3",
            "error": "#ba1a1a",
            "error-container": "#ffdad6",
            "on-error-container": "#93000a"
          },
          fontFamily: {
            sans: ['"Plus Jakarta Sans"', 'sans-serif']
          }
        }
      }
    };
  </script>
  <style>
    ::-webkit-scrollbar {
      width: 6px;
      height: 6px;
    }
    ::-webkit-scrollbar-track {
      background: transparent;
    }
    ::-webkit-scrollbar-thumb {
      background: #c5c5d3;
      border-radius: 9999px;
    }
    ::-webkit-scrollbar-thumb:hover {
      background: #757682;
    }
  </style>
</head>
<body class="bg-background font-sans text-on-surface antialiased h-full flex flex-col min-h-screen">

  <!-- SIDEBAR -->
  <aside class="fixed left-0 top-0 h-screen w-72 bg-surface-container-lowest flex flex-col justify-between z-50 shadow-[0_1px_8px_rgba(0,0,0,0.04)] border-r border-outline-variant/30">
    <div class="flex flex-col flex-1 overflow-y-auto">
      <!-- App Brand Logo -->
      <div class="h-20 px-6 flex items-center gap-3 border-b border-outline-variant/10">
        <div class="w-10 h-10 rounded-xl bg-primary flex items-center justify-center text-on-primary shadow-sm font-bold text-xl">
          S
        </div>
        <div class="flex flex-col">
          <span class="font-bold text-lg text-primary leading-tight tracking-tight">SIPRASKA</span>
          <span class="text-xs text-on-surface-variant font-medium">SMA Negeri 1 Harapan</span>
        </div>
      </div>

      <!-- Admin Navigation Links -->
      <div class="px-4 py-4">
        <span class="text-[11px] font-bold uppercase tracking-wider text-outline px-3 block mb-3">Menu Administrasi</span>
        <nav class="flex flex-col gap-1.5">
          <a href="#" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all">
            <span class="material-symbols-outlined text-[20px]">dashboard</span> Ringkasan Sistem
          </a>
          <a href="#" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-bold bg-primary text-on-primary shadow-md transition-all">
            <span class="material-symbols-outlined text-[20px]">report_problem</span> Kelola Pengaduan
          </a>
          <a href="#" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all">
            <span class="material-symbols-outlined text-[20px]">bar_chart</span> Laporan & Rekap
          </a>
          <a href="#" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all">
            <span class="material-symbols-outlined text-[20px]">manage_accounts</span> Pengaturan Akun
          </a>
        </nav>

        <span class="text-[11px] font-bold uppercase tracking-wider text-outline px-3 block mt-6 mb-3">Portal Siswa</span>
        <nav class="flex flex-col gap-1.5">
          <a href="#" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all">
            <span class="material-symbols-outlined text-[20px]">add_circle</span> Buat Laporan
          </a>
          <a href="#" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all">
            <span class="material-symbols-outlined text-[20px]">find_in_page</span> Lacak Status
          </a>
          <a href="#" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface transition-all">
            <span class="material-symbols-outlined text-[20px]">account_circle</span> Profil Siswa
          </a>
        </nav>
      </div>
    </div>

    <!-- Sidebar Bottom Preferences Footer -->
    <div class="p-4 bg-surface-container-low flex flex-col gap-2.5 border-t border-outline-variant/20">
      <!-- Language Switcher -->
      <div class="flex items-center justify-between px-3 py-2 rounded-xl bg-surface-container-lowest border border-outline-variant/30">
        <div class="flex items-center gap-2">
          <span class="material-symbols-outlined text-[18px] text-outline">translate</span>
          <span class="text-xs font-semibold text-on-surface-variant">Bahasa</span>
        </div>
        <div class="flex items-center gap-1 bg-surface-container-high p-0.5 rounded-lg">
          <button id="lang-id" onclick="setLanguage('id')" class="px-2 py-0.5 rounded-md text-xs font-bold bg-primary text-on-primary shadow-xs transition-all">ID</button>
          <button id="lang-en" onclick="setLanguage('en')" class="px-2 py-0.5 rounded-md text-xs font-semibold text-on-surface-variant hover:text-on-surface transition-all">EN</button>
        </div>
      </div>
      <!-- Dark/Light Theme Toggle -->
      <div class="flex items-center justify-between px-3 py-2 rounded-xl bg-surface-container-lowest border border-outline-variant/30">
        <div class="flex items-center gap-2">
          <span class="material-symbols-outlined text-[18px] text-outline" id="theme-icon">light_mode</span>
          <span class="text-xs font-semibold text-on-surface-variant">Tema Tampilan</span>
        </div>
        <button id="theme-toggle" onclick="toggleTheme()" class="w-11 h-6 bg-secondary rounded-full relative p-0.5 flex items-center justify-start transition-all">
          <span id="theme-dot" class="w-5 h-5 rounded-full bg-surface-container-lowest flex items-center justify-center shadow-sm transform transition-transform">
            <span class="material-symbols-outlined text-[14px] text-secondary">light_mode</span>
          </span>
        </button>
      </div>
    </div>
  </aside>

  <!-- MAIN LAYOUT WRAPPER -->
  <div class="pl-72 flex-1 flex flex-col min-w-0">
    <!-- Top Header -->
    <header class="fixed top-0 left-72 right-0 h-20 bg-surface/90 backdrop-blur-xl z-40 px-6 flex items-center justify-between border-b border-outline-variant/20 shadow-xs">
      <div class="flex items-center gap-3">
        <div class="w-9 h-9 rounded-xl bg-surface-container flex items-center justify-center text-secondary border border-outline-variant/30">
          <span class="material-symbols-outlined text-[22px]">domain</span>
        </div>
        <div class="flex flex-col">
          <div class="flex items-center gap-2">
            <span class="text-xs font-bold text-secondary tracking-wider uppercase">SIPRASKA PORTAL</span>
            <span class="w-1 h-1 rounded-full bg-outline-variant"></span>
            <span class="text-xs font-medium text-on-surface-variant">SMA Negeri 1 Harapan</span>
          </div>
          <span class="text-xs text-outline font-normal">Sistem Informasi Manajemen Sarana & Prasarana Terpadu</span>
        </div>
      </div>

      <div class="flex items-center gap-3">
        <button class="flex items-center gap-1.5 px-3 py-2 rounded-xl bg-surface-container-lowest border border-outline-variant/30 text-error hover:bg-error-container hover:text-on-error-container transition-all shadow-xs" title="Keluar Sistem">
          <span class="material-symbols-outlined text-[18px]">logout</span>
          <span class="text-xs font-bold hidden sm:inline">Keluar</span>
        </button>

        <div class="flex items-center gap-3 pl-3 bg-surface-container-lowest border border-outline-variant/30 py-1.5 px-3 rounded-xl shadow-xs">
          <div class="flex flex-col text-right">
            <span class="text-xs font-bold text-on-surface leading-snug">Budi Santoso</span>
            <span class="inline-flex items-center self-end px-2 py-0.5 rounded-full bg-secondary-fixed text-on-secondary-fixed text-[10px] font-bold">
              Administrator
            </span>
          </div>
          <div class="w-9 h-9 rounded-full bg-primary flex items-center justify-center text-on-primary font-bold text-sm shadow-sm">
            <span class="material-symbols-outlined text-[20px]">person</span>
          </div>
        </div>
      </div>
    </header>

    <!-- MAIN CONTENT AREA -->
    <main class="pt-24 px-6 pb-12 bg-background min-h-screen flex-1">
      <div class="max-w-[1600px] mx-auto flex flex-col gap-6">

        <!-- Page Header & Key KPI Stat Pills -->
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
          <div class="flex flex-col">
            <div class="flex items-center gap-2 mb-1">
              <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-surface-container-high text-secondary text-xs font-bold">
                <span class="w-2 h-2 rounded-full bg-secondary animate-pulse"></span>
                Sistem Aktif • Realtime
              </span>
              <span class="text-xs text-outline">Pusat Kendali Pengaduan</span>
            </div>
            <h1 class="text-2xl font-bold text-on-surface tracking-tight">Kelola Pengaduan Sarpras</h1>
          </div>

          <!-- Quick Metrics Strip -->
          <div class="flex flex-wrap items-center gap-3">
            <div class="flex items-center gap-3 px-3.5 py-2 rounded-xl bg-surface-container-lowest border border-outline-variant/30 shadow-xs">
              <div class="w-8 h-8 rounded-lg bg-surface-container flex items-center justify-center text-secondary">
                <span class="material-symbols-outlined text-[20px]">inbox</span>
              </div>
              <div class="flex flex-col">
                <span class="text-[11px] font-semibold text-outline uppercase tracking-wider">Masuk Hari Ini</span>
                <span class="text-sm font-bold text-on-surface">14 Berkas</span>
              </div>
            </div>

            <div class="flex items-center gap-3 px-3.5 py-2 rounded-xl bg-surface-container-lowest border border-outline-variant/30 shadow-xs">
              <div class="w-8 h-8 rounded-lg bg-error-container flex items-center justify-center text-error">
                <span class="material-symbols-outlined text-[20px]">priority_high</span>
              </div>
              <div class="flex flex-col">
                <span class="text-[11px] font-semibold text-error uppercase tracking-wider">Darurat / Tinggi</span>
                <span class="text-sm font-bold text-error">3 Tiket</span>
              </div>
            </div>

            <div class="flex items-center gap-3 px-3.5 py-2 rounded-xl bg-surface-container-lowest border border-outline-variant/30 shadow-xs">
              <div class="w-8 h-8 rounded-lg bg-surface-container-high flex items-center justify-center text-primary">
                <span class="material-symbols-outlined text-[20px]">engineering</span>
              </div>
              <div class="flex flex-col">
                <span class="text-[11px] font-semibold text-outline uppercase tracking-wider">Dalam Pengerjaan</span>
                <span class="text-sm font-bold text-on-surface">8 Tiket</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Search and Action Controls Card -->
        <div class="bg-surface-container-lowest rounded-2xl p-4 border border-outline-variant/30 shadow-xs flex flex-col gap-4">
          <!-- Top Row: Search Input and Buttons -->
          <div class="flex flex-col md:flex-row items-stretch md:items-center justify-between gap-3">
            <div class="relative flex-1">
              <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-outline text-[20px]">search</span>
              <input id="search-input" type="text" value="AC Ruang Lab Komputer" placeholder="Cari no. tiket, judul pengaduan, nama pelapor, atau lokasi..." class="w-full pl-10 pr-10 py-2 rounded-xl bg-surface-container-low text-sm font-medium text-on-surface border border-transparent focus:border-secondary focus:bg-surface-container-lowest outline-none transition-all">
              <button onclick="clearSearch()" class="absolute right-3 top-1/2 -translate-y-1/2 text-outline hover:text-on-surface">
                <span class="material-symbols-outlined text-[18px]">close</span>
              </button>
            </div>

            <div class="flex items-center gap-2 self-end md:self-auto">
              <button onclick="exportExcel()" class="flex items-center gap-2 px-3.5 py-2 rounded-xl bg-surface-container-low hover:bg-surface-container border border-outline-variant/30 text-on-surface text-xs font-bold transition-all shadow-xs">
                <span class="material-symbols-outlined text-[18px] text-secondary">table_view</span>
                <span>Export Excel</span>
              </button>
              <button onclick="printSummary()" class="flex items-center gap-2 px-3.5 py-2 rounded-xl bg-surface-container-low hover:bg-surface-container border border-outline-variant/30 text-on-surface text-xs font-bold transition-all shadow-xs">
                <span class="material-symbols-outlined text-[18px] text-outline">print</span>
                <span>Cetak Ringkasan</span>
              </button>
              <button onclick="refreshData()" class="w-9 h-9 rounded-xl bg-surface-container-low hover:bg-surface-container border border-outline-variant/30 flex items-center justify-center text-outline hover:text-on-surface transition-all shadow-xs" title="Muat Ulang Data">
                <span class="material-symbols-outlined text-[18px]">refresh</span>
              </button>
            </div>
          </div>

          <!-- Bottom Row: Filter Dropdowns -->
          <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-3 pt-1 border-t border-outline-variant/20">
            <!-- Kategori -->
            <div class="flex flex-col gap-1">
              <label class="text-[10px] font-bold text-outline uppercase tracking-wider">Kategori</label>
              <div class="relative">
                <select id="filter-kategori" class="w-full appearance-none bg-surface-container-low border border-outline-variant/30 rounded-xl px-3 py-1.5 text-xs font-semibold text-on-surface pr-8 focus:outline-none focus:border-secondary cursor-pointer">
                  <option>Semua Kategori</option>
                  <option selected>AC & Kelistrikan</option>
                  <option>Laboratorium & PC</option>
                  <option>Ruang Kelas & Mebel</option>
                  <option>Sanitasi & Toilet</option>
                </select>
                <span class="material-symbols-outlined absolute right-2.5 top-1/2 -translate-y-1/2 text-outline text-[18px] pointer-events-none">expand_more</span>
              </div>
            </div>

            <!-- Prioritas -->
            <div class="flex flex-col gap-1">
              <label class="text-[10px] font-bold text-outline uppercase tracking-wider">Tingkat Urgensi</label>
              <div class="relative">
                <select id="filter-urgensi" class="w-full appearance-none bg-surface-container-low border border-outline-variant/30 rounded-xl px-3 py-1.5 text-xs font-semibold text-on-surface pr-8 focus:outline-none focus:border-secondary cursor-pointer">
                  <option>Semua Prioritas</option>
                  <option selected>Tinggi (Mendesak)</option>
                  <option>Sedang</option>
                  <option>Rendah</option>
                </select>
                <span class="material-symbols-outlined absolute right-2.5 top-1/2 -translate-y-1/2 text-outline text-[18px] pointer-events-none">expand_more</span>
              </div>
            </div>

            <!-- Status -->
            <div class="flex flex-col gap-1">
              <label class="text-[10px] font-bold text-outline uppercase tracking-wider">Status Tiket</label>
              <div class="relative">
                <select id="filter-status" class="w-full appearance-none bg-surface-container-low border border-outline-variant/30 rounded-xl px-3 py-1.5 text-xs font-semibold text-on-surface pr-8 focus:outline-none focus:border-secondary cursor-pointer">
                  <option>Semua Status</option>
                  <option selected>Menunggu Verifikasi</option>
                  <option>Sedang Dikerjakan</option>
                  <option>Selesai</option>
                  <option>Ditolak</option>
                </select>
                <span class="material-symbols-outlined absolute right-2.5 top-1/2 -translate-y-1/2 text-outline text-[18px] pointer-events-none">expand_more</span>
              </div>
            </div>

            <!-- Rentang Tanggal -->
            <div class="flex flex-col gap-1">
              <label class="text-[10px] font-bold text-outline uppercase tracking-wider">Periode Tanggal</label>
              <div class="relative flex items-center bg-surface-container-low border border-outline-variant/30 rounded-xl px-3 py-1.5">
                <span class="material-symbols-outlined text-[16px] text-outline mr-2">calendar_today</span>
                <input type="text" value="20 - 24 Mei 2025" class="w-full bg-transparent text-xs font-semibold text-on-surface outline-none">
              </div>
            </div>

            <!-- Reset Button -->
            <div class="col-span-2 sm:col-span-2 md:col-span-4 lg:col-span-1 flex items-end">
              <button onclick="resetFilters()" class="w-full h-[32px] flex items-center justify-center gap-1.5 rounded-xl bg-surface-container border border-outline-variant/30 text-on-surface-variant hover:text-on-surface hover:bg-surface-container-high text-xs font-bold transition-all">
                <span class="material-symbols-outlined text-[16px]">filter_alt_off</span> Reset Filter
              </button>
            </div>
          </div>
        </div>

        <!-- MAIN GRID: LEFT (60% Table) and RIGHT (40% Detail Drawer) -->
        <div class="grid grid-cols-1 xl:grid-cols-12 gap-6 items-start">

          <!-- LEFT COLUMN: Complaints Table (7 Cols) -->
          <div class="xl:col-span-7 flex flex-col gap-4">
            <div class="bg-surface-container-lowest rounded-2xl border border-outline-variant/30 shadow-xs overflow-hidden">
              <!-- Table Subheader -->
              <div class="px-4 py-3 flex items-center justify-between bg-surface-container-low border-b border-outline-variant/20">
                <div class="flex items-center gap-2">
                  <span class="text-sm font-bold text-on-surface">Daftar Tiket Antrean</span>
                  <span class="px-2.5 py-0.5 rounded-full bg-secondary-fixed text-on-secondary-fixed text-xs font-bold">
                    4 Ditemukan
                  </span>
                </div>
                <div class="flex items-center gap-1 text-xs text-outline font-medium">
                  <span>Urutkan: Terkini</span>
                  <span class="material-symbols-outlined text-[16px]">sort</span>
                </div>
              </div>

              <!-- Table Content -->
              <div class="overflow-x-auto">
                <table class="w-full text-left">
                  <thead>
                    <tr class="bg-surface-container-lowest text-outline text-[11px] font-bold uppercase tracking-wider border-b border-outline-variant/20">
                      <th class="py-3 px-3 w-10 text-center">
                        <input type="checkbox" class="w-4 h-4 rounded text-secondary accent-secondary cursor-pointer">
                      </th>
                      <th class="py-3 px-3">NO. TIKET</th>
                      <th class="py-3 px-3">JUDUL & LOKASI</th>
                      <th class="py-3 px-3">PELAPOR</th>
                      <th class="py-3 px-3 text-center">PRIORITAS</th>
                      <th class="py-3 px-3 text-center">STATUS</th>
                      <th class="py-3 px-3 text-right">AKSI</th>
                    </tr>
                  </thead>
                  <tbody class="text-xs divide-y divide-outline-variant/10">

                    <!-- ROW 1 (SELECTED ITEM) -->
                    <tr onclick="selectRow('PG-2025-089')" class="bg-surface-container-high/60 transition-colors cursor-pointer border-l-4 border-l-secondary">
                      <td class="py-3.5 px-3 text-center" onclick="event.stopPropagation()">
                        <input type="checkbox" checked class="w-4 h-4 rounded text-secondary accent-secondary cursor-pointer">
                      </td>
                      <td class="py-3.5 px-3 whitespace-nowrap">
                        <div class="flex flex-col">
                          <span class="text-xs font-bold text-primary">#PG-2025-089</span>
                          <span class="text-[11px] text-outline font-medium">Hari ini, 08:15</span>
                        </div>
                      </td>
                      <td class="py-3.5 px-3 max-w-[200px]">
                        <div class="flex flex-col">
                          <span class="font-bold text-on-surface truncate">AC Ruang Lab Komputer 2 Bocor...</span>
                          <span class="text-[11px] text-on-surface-variant flex items-center gap-1 mt-0.5">
                            <span class="material-symbols-outlined text-[14px] text-secondary">location_on</span>
                            Gedung C - Lt. 2 (Lab Komp 2)
                          </span>
                        </div>
                      </td>
                      <td class="py-3.5 px-3 whitespace-nowrap">
                        <div class="flex flex-col">
                          <span class="font-bold text-on-surface">Ahmad Fauzi</span>
                          <span class="text-[11px] text-outline">XII MIPA 1</span>
                        </div>
                      </td>
                      <td class="py-3.5 px-3 text-center whitespace-nowrap">
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-error-container text-error text-[11px] font-bold">
                          <span class="w-1.5 h-1.5 rounded-full bg-error"></span> TINGGI
                        </span>
                      </td>
                      <td class="py-3.5 px-3 text-center whitespace-nowrap">
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-surface-container text-primary text-[11px] font-bold">
                          <span class="w-1.5 h-1.5 rounded-full bg-secondary animate-ping"></span> Menunggu
                        </span>
                      </td>
                      <td class="py-3.5 px-3 text-right whitespace-nowrap">
                        <button class="w-8 h-8 rounded-lg bg-primary text-on-primary inline-flex items-center justify-center hover:bg-primary-container transition-colors shadow-xs" title="Buka Detail">
                          <span class="material-symbols-outlined text-[18px]">edit_note</span>
                        </button>
                      </td>
                    </tr>

                    <!-- ROW 2 -->
                    <tr onclick="selectRow('PG-2025-088')" class="hover:bg-surface-container-low transition-colors cursor-pointer border-l-4 border-l-transparent">
                      <td class="py-3.5 px-3 text-center" onclick="event.stopPropagation()">
                        <input type="checkbox" class="w-4 h-4 rounded text-secondary accent-secondary cursor-pointer">
                      </td>
                      <td class="py-3.5 px-3 whitespace-nowrap">
                        <div class="flex flex-col">
                          <span class="font-bold text-on-surface">#PG-2025-088</span>
                          <span class="text-[11px] text-outline">Hari ini, 07:30</span>
                        </div>
                      </td>
                      <td class="py-3.5 px-3 max-w-[200px]">
                        <div class="flex flex-col">
                          <span class="font-bold text-on-surface truncate">Kran Air Wastafel Toilet Guru Patah...</span>
                          <span class="text-[11px] text-on-surface-variant flex items-center gap-1 mt-0.5">
                            <span class="material-symbols-outlined text-[14px] text-outline">location_on</span>
                            Gedung Utama - Lt. 1
                          </span>
                        </div>
                      </td>
                      <td class="py-3.5 px-3 whitespace-nowrap">
                        <div class="flex flex-col">
                          <span class="font-bold text-on-surface">Siti Nurhaliza, S.Pd.</span>
                          <span class="text-[11px] text-outline">Guru Kimia</span>
                        </div>
                      </td>
                      <td class="py-3.5 px-3 text-center whitespace-nowrap">
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-surface-container-high text-on-surface-variant text-[11px] font-bold">
                          <span class="w-1.5 h-1.5 rounded-full bg-outline"></span> Sedang
                        </span>
                      </td>
                      <td class="py-3.5 px-3 text-center whitespace-nowrap">
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-secondary-fixed text-on-secondary-fixed text-[11px] font-bold">
                          <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span> Diproses
                        </span>
                      </td>
                      <td class="py-3.5 px-3 text-right whitespace-nowrap">
                        <button class="w-8 h-8 rounded-lg bg-surface-container-low text-on-surface-variant hover:bg-surface-container inline-flex items-center justify-center transition-colors">
                          <span class="material-symbols-outlined text-[18px]">chevron_right</span>
                        </button>
                      </td>
                    </tr>

                    <!-- ROW 3 -->
                    <tr onclick="selectRow('PG-2025-087')" class="hover:bg-surface-container-low transition-colors cursor-pointer border-l-4 border-l-transparent">
                      <td class="py-3.5 px-3 text-center" onclick="event.stopPropagation()">
                        <input type="checkbox" class="w-4 h-4 rounded text-secondary accent-secondary cursor-pointer">
                      </td>
                      <td class="py-3.5 px-3 whitespace-nowrap">
                        <div class="flex flex-col">
                          <span class="font-bold text-on-surface">#PG-2025-087</span>
                          <span class="text-[11px] text-outline">23 Mei, 15:40</span>
                        </div>
                      </td>
                      <td class="py-3.5 px-3 max-w-[200px]">
                        <div class="flex flex-col">
                          <span class="font-bold text-on-surface truncate">Proyektor Ruang Multimedia Gambar...</span>
                          <span class="text-[11px] text-on-surface-variant flex items-center gap-1 mt-0.5">
                            <span class="material-symbols-outlined text-[14px] text-outline">location_on</span>
                            Gedung B - Ruang Multi 1
                          </span>
                        </div>
                      </td>
                      <td class="py-3.5 px-3 whitespace-nowrap">
                        <div class="flex flex-col">
                          <span class="font-bold text-on-surface">Dimas Bagus</span>
                          <span class="text-[11px] text-outline">XI IPS 2</span>
                        </div>
                      </td>
                      <td class="py-3.5 px-3 text-center whitespace-nowrap">
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-surface-container-high text-on-surface-variant text-[11px] font-bold">
                          <span class="w-1.5 h-1.5 rounded-full bg-outline"></span> Sedang
                        </span>
                      </td>
                      <td class="py-3.5 px-3 text-center whitespace-nowrap">
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-secondary-fixed text-on-secondary-fixed text-[11px] font-bold">
                          <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span> Diproses
                        </span>
                      </td>
                      <td class="py-3.5 px-3 text-right whitespace-nowrap">
                        <button class="w-8 h-8 rounded-lg bg-surface-container-low text-on-surface-variant hover:bg-surface-container inline-flex items-center justify-center transition-colors">
                          <span class="material-symbols-outlined text-[18px]">chevron_right</span>
                        </button>
                      </td>
                    </tr>

                    <!-- ROW 4 -->
                    <tr onclick="selectRow('PG-2025-086')" class="hover:bg-surface-container-low transition-colors cursor-pointer border-l-4 border-l-transparent">
                      <td class="py-3.5 px-3 text-center" onclick="event.stopPropagation()">
                        <input type="checkbox" class="w-4 h-4 rounded text-secondary accent-secondary cursor-pointer">
                      </td>
                      <td class="py-3.5 px-3 whitespace-nowrap">
                        <div class="flex flex-col">
                          <span class="font-bold text-on-surface">#PG-2025-086</span>
                          <span class="text-[11px] text-outline">23 Mei, 11:20</span>
                        </div>
                      </td>
                      <td class="py-3.5 px-3 max-w-[200px]">
                        <div class="flex flex-col">
                          <span class="font-bold text-on-surface truncate">Kunci Pintu Jendela Kelas X-A Longgar...</span>
                          <span class="text-[11px] text-on-surface-variant flex items-center gap-1 mt-0.5">
                            <span class="material-symbols-outlined text-[14px] text-outline">location_on</span>
                            Gedung A - Lt. 1 (Kelas X-A)
                          </span>
                        </div>
                      </td>
                      <td class="py-3.5 px-3 whitespace-nowrap">
                        <div class="flex flex-col">
                          <span class="font-bold text-on-surface">Rina Safitri</span>
                          <span class="text-[11px] text-outline">X MIPA 3</span>
                        </div>
                      </td>
                      <td class="py-3.5 px-3 text-center whitespace-nowrap">
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-surface-container text-on-surface-variant text-[11px] font-bold">
                          <span class="w-1.5 h-1.5 rounded-full bg-outline-variant"></span> Rendah
                        </span>
                      </td>
                      <td class="py-3.5 px-3 text-center whitespace-nowrap">
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-surface-container-highest text-primary text-[11px] font-bold">
                          <span class="w-1.5 h-1.5 rounded-full bg-primary"></span> Selesai
                        </span>
                      </td>
                      <td class="py-3.5 px-3 text-right whitespace-nowrap">
                        <button class="w-8 h-8 rounded-lg bg-surface-container-low text-on-surface-variant hover:bg-surface-container inline-flex items-center justify-center transition-colors">
                          <span class="material-symbols-outlined text-[18px]">chevron_right</span>
                        </button>
                      </td>
                    </tr>

                  </tbody>
                </table>
              </div>

              <!-- Pagination Footer -->
              <div class="px-4 py-3 flex items-center justify-between bg-surface-container-low border-t border-outline-variant/20">
                <span class="text-xs text-outline font-medium">Menampilkan 1-4 dari 42 total pengaduan</span>
                <div class="flex items-center gap-1">
                  <button class="w-8 h-8 rounded-lg bg-surface-container-lowest border border-outline-variant/30 text-outline flex items-center justify-center disabled:opacity-50" disabled>
                    <span class="material-symbols-outlined text-[16px]">first_page</span>
                  </button>
                  <button class="w-8 h-8 rounded-lg bg-surface-container-lowest border border-outline-variant/30 text-outline flex items-center justify-center disabled:opacity-50" disabled>
                    <span class="material-symbols-outlined text-[16px]">chevron_left</span>
                  </button>
                  <button class="w-8 h-8 rounded-lg bg-primary text-on-primary font-bold text-xs flex items-center justify-center">1</button>
                  <button class="w-8 h-8 rounded-lg bg-surface-container-lowest border border-outline-variant/30 text-on-surface hover:bg-surface-container font-semibold text-xs flex items-center justify-center">2</button>
                  <button class="w-8 h-8 rounded-lg bg-surface-container-lowest border border-outline-variant/30 text-on-surface hover:bg-surface-container font-semibold text-xs flex items-center justify-center">3</button>
                  <button class="w-8 h-8 rounded-lg bg-surface-container-lowest border border-outline-variant/30 text-outline hover:text-on-surface flex items-center justify-center">
                    <span class="material-symbols-outlined text-[16px]">chevron_right</span>
                  </button>
                  <button class="w-8 h-8 rounded-lg bg-surface-container-lowest border border-outline-variant/30 text-outline hover:text-on-surface flex items-center justify-center">
                    <span class="material-symbols-outlined text-[16px]">last_page</span>
                  </button>
                </div>
              </div>
            </div>

            <!-- SLA Target Mini-Card Below Table -->
            <div class="bg-surface-container-lowest rounded-2xl p-4 border border-outline-variant/30 shadow-xs flex items-center justify-between">
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-surface-container border border-outline-variant/30 flex items-center justify-center text-secondary">
                  <span class="material-symbols-outlined text-[22px]">domain_verification</span>
                </div>
                <div class="flex flex-col">
                  <span class="text-xs font-bold text-on-surface">Target Waktu Respon SIPRASKA (SLA)</span>
                  <span class="text-xs text-outline font-normal">Maksimal 2 jam untuk tiket prioritas tinggi</span>
                </div>
              </div>
              <div class="flex items-center gap-2">
                <span class="text-xl font-extrabold text-secondary tracking-tight">94.8%</span>
                <span class="text-xs text-outline font-semibold">Tercapai</span>
              </div>
            </div>
          </div>

          <!-- RIGHT COLUMN: Interactive Complaint Detail Drawer (5 Cols) -->
          <div class="xl:col-span-5 flex flex-col gap-4">
            <div id="detail-panel" class="bg-surface-container-lowest rounded-2xl border border-outline-variant/30 shadow-md p-5 flex flex-col gap-5 relative overflow-hidden">
              <!-- Top Urgent Accent Bar -->
              <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-error via-secondary to-primary"></div>

              <!-- Drawer Header -->
              <div class="flex items-start justify-between gap-3 pt-1">
                <div class="flex flex-col">
                  <div class="flex flex-wrap items-center gap-2 mb-1">
                    <span class="px-2.5 py-0.5 rounded-full bg-error-container text-error text-[11px] font-bold flex items-center gap-1">
                      <span class="material-symbols-outlined text-[14px]">warning</span> Prioritas: TINGGI
                    </span>
                    <span class="px-2.5 py-0.5 rounded-full bg-surface-container text-primary text-[11px] font-bold">
                      Menunggu Verifikasi
                    </span>
                  </div>
                  <h2 class="text-base font-bold text-on-surface leading-snug">
                    Detail Pengaduan #PG-2025-089
                  </h2>
                </div>
                <button onclick="closePanel()" class="w-8 h-8 rounded-xl bg-surface-container-low hover:bg-surface-container border border-outline-variant/30 text-outline hover:text-on-surface flex items-center justify-center transition-all">
                  <span class="material-symbols-outlined text-[18px]">close</span>
                </button>
              </div>

              <!-- Reporter and Time Meta Info -->
              <div class="grid grid-cols-2 gap-3 p-3.5 rounded-xl bg-surface-container-low border border-outline-variant/30">
                <div class="flex flex-col gap-0.5">
                  <span class="text-[10px] font-bold text-outline uppercase tracking-wider">Nama Pelapor</span>
                  <span class="text-xs font-bold text-on-surface">Ahmad Fauzi</span>
                  <span class="text-[11px] text-on-surface-variant font-medium">NISN: 0072918291</span>
                  <span class="text-[11px] text-outline font-medium">Kelas XII MIPA 1</span>
                </div>
                <div class="flex flex-col gap-0.5">
                  <span class="text-[10px] font-bold text-outline uppercase tracking-wider">Waktu Pelaporan</span>
                  <span class="text-xs font-bold text-on-surface">24 Mei 2025</span>
                  <span class="text-[11px] text-on-surface-variant font-medium">Pukul 08:15 WIB</span>
                  <span class="text-[11px] text-secondary font-bold flex items-center gap-1 mt-0.5">
                    <span class="material-symbols-outlined text-[14px]">schedule</span> 35 menit yang lalu
                  </span>
                </div>
              </div>

              <!-- Facility Location -->
              <div class="flex items-start gap-2.5 p-3 rounded-xl bg-surface-container-low/60 border border-outline-variant/20">
                <span class="material-symbols-outlined text-secondary text-[20px] mt-0.5">apartment</span>
                <div class="flex flex-col">
                  <span class="text-[10px] font-bold text-outline uppercase tracking-wider">Lokasi Kerusakan Fasilitas:</span>
                  <span class="text-xs font-bold text-on-surface">Gedung C Lantai 2 • Laboratorium Komputer 2</span>
                </div>
              </div>

              <!-- Description Box -->
              <div class="flex flex-col gap-1.5">
                <span class="text-[10px] font-bold text-outline uppercase tracking-wider">Deskripsi Masalah oleh Siswa:</span>
                <div class="p-3.5 rounded-xl bg-surface-container-low text-xs font-medium text-on-surface italic border-l-4 border-secondary leading-relaxed">
                  "AC di baris tengah bocor airnya cukup deras hingga menetes ke 2 unit PC komputer. Sangat mengganggu saat praktik dan berisiko korsleting listrik."
                </div>
              </div>

              <!-- Attachment Photo -->
              <div class="flex flex-col gap-2">
                <span class="text-[10px] font-bold text-outline uppercase tracking-wider">Bukti Foto Kerusakan:</span>
                <div class="p-2.5 rounded-xl bg-surface-container-low border border-outline-variant/30 flex items-center gap-3">
                  <div class="w-16 h-12 rounded-lg bg-surface-container-high overflow-hidden flex-shrink-0 relative border border-outline-variant/40">
                    <img src="https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&w=200&q=80" alt="Bukti AC Bocor" class="w-full h-full object-cover">
                  </div>
                  <div class="flex flex-col flex-1 min-w-0">
                    <span class="text-xs font-bold text-on-surface truncate">Bukti-AC-Bocor-LabKomp.jpg</span>
                    <span class="text-[11px] text-outline">Ukuran: 1.8 MB • Resolusi: 4032 x 3024</span>
                    <div class="flex items-center gap-3 mt-1">
                      <a href="#" class="text-[11px] font-bold text-secondary hover:underline flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]">visibility</span> Lihat Full HD
                      </a>
                      <a href="#" class="text-[11px] font-semibold text-outline hover:text-on-surface flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]">download</span> Unduh
                      </a>
                    </div>
                  </div>
                </div>
              </div>

              <hr class="border-outline-variant/20">

              <!-- Processing & Status Update Form -->
              <div class="bg-surface-container-low p-4 rounded-xl flex flex-col gap-4 border border-outline-variant/30">
                <div class="flex items-center justify-between">
                  <div class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-lg bg-primary text-on-primary flex items-center justify-center">
                      <span class="material-symbols-outlined text-[18px]">build</span>
                    </div>
                    <span class="text-xs font-bold text-on-surface">Proses & Update Penanganan</span>
                  </div>
                  <span class="text-[11px] font-bold text-outline">Langkah 1 dari 2</span>
                </div>

                <!-- Status Selector Buttons Grid -->
                <div class="flex flex-col gap-1.5">
                  <span class="text-[10px] font-bold text-outline uppercase tracking-wider">Tentukan Status Penanganan:</span>
                  <div class="grid grid-cols-2 gap-2" id="status-buttons">
                    <button type="button" onclick="setStatus(this)" class="status-btn flex items-center gap-2 p-2.5 rounded-xl border border-outline-variant/40 bg-surface-container-lowest text-left transition-all">
                      <span class="w-2 h-2 rounded-full bg-outline-variant"></span>
                      <div class="flex flex-col">
                        <span class="text-xs font-bold text-on-surface">Diterima / Sah</span>
                        <span class="text-[10px] text-outline">Tervalidasi</span>
                      </div>
                    </button>
                    <button type="button" onclick="setStatus(this)" class="status-btn active flex items-center gap-2 p-2.5 rounded-xl bg-primary text-on-primary text-left shadow-xs transition-all border border-primary">
                      <span class="w-2 h-2 rounded-full bg-secondary"></span>
                      <div class="flex flex-col">
                        <span class="text-xs font-bold">Sedang Diproses</span>
                        <span class="text-[10px] text-on-primary-container">Teknisi meluncur</span>
                      </div>
                    </button>
                    <button type="button" onclick="setStatus(this)" class="status-btn flex items-center gap-2 p-2.5 rounded-xl border border-outline-variant/40 bg-surface-container-lowest text-left transition-all">
                      <span class="w-2 h-2 rounded-full bg-outline-variant"></span>
                      <div class="flex flex-col">
                        <span class="text-xs font-bold text-on-surface">Selesai Ditangani</span>
                        <span class="text-[10px] text-outline">Tuntas</span>
                      </div>
                    </button>
                    <button type="button" onclick="setStatus(this)" class="status-btn flex items-center gap-2 p-2.5 rounded-xl border border-outline-variant/40 bg-surface-container-lowest text-left transition-all">
                      <span class="w-2 h-2 rounded-full bg-error"></span>
                      <div class="flex flex-col">
                        <span class="text-xs font-bold text-error">Tolak Laporan</span>
                        <span class="text-[10px] text-error">Tidak valid / duplikat</span>
                      </div>
                    </button>
                  </div>
                </div>

                <!-- Technician Assignment Dropdown -->
                <div class="flex flex-col gap-1.5">
                  <div class="flex items-center justify-between">
                    <label class="text-[10px] font-bold text-outline uppercase tracking-wider">Tugaskan Petugas Teknisi:</label>
                    <span class="text-[10px] font-bold text-secondary flex items-center gap-1">
                      <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span> Tersedia di Posko
                    </span>
                  </div>
                  <div class="relative">
                    <select class="w-full appearance-none bg-surface-container-lowest rounded-xl border border-outline-variant/40 px-3 py-2 text-xs font-semibold text-on-surface pr-8 focus:outline-none focus:border-secondary cursor-pointer">
                      <option selected>Pak Hendra Santoso (Teknisi Kelistrikan & Pendingin)</option>
                      <option>Pak Agus Riyadi (Sarpras Umum)</option>
                      <option>Tim IT & Laboratorium</option>
                    </select>
                    <span class="material-symbols-outlined absolute right-2.5 top-1/2 -translate-y-1/2 text-outline text-[18px] pointer-events-none">engineering</span>
                  </div>
                </div>

                <!-- Resolution Time Field -->
                <div class="flex flex-col gap-1.5">
                  <label class="text-[10px] font-bold text-outline uppercase tracking-wider">Estimasi Waktu Penyelesaian:</label>
                  <div class="relative flex items-center bg-surface-container-lowest rounded-xl border border-outline-variant/40 px-3 py-2">
                    <span class="material-symbols-outlined text-[18px] text-outline mr-2">event_available</span>
                    <input type="text" value="24 Mei 2025, 14:00 WIB (Hari ini saat istirahat)" class="w-full bg-transparent text-xs font-semibold text-on-surface outline-none">
                  </div>
                </div>

                <!-- Admin Response Note Field -->
                <div class="flex flex-col gap-1.5">
                  <label class="text-[10px] font-bold text-outline uppercase tracking-wider">Tanggapan Admin / Catatan Instruksi (Kirim SMS/WA bot):</label>
                  <textarea rows="3" class="w-full p-3 rounded-xl bg-surface-container-lowest border border-outline-variant/40 text-xs font-medium text-on-surface focus:outline-none focus:border-secondary transition-all leading-relaxed" placeholder="Tulis pesan konfirmasi...">Tim teknisi Pak Hendra telah ditugaskan membawa tangga dan peralatan servis AC. Penanganan dijadwalkan siang ini saat jam istirahat agar tidak mengganggu KBM siswa di kelas.</textarea>
                </div>

                <!-- Automatic Notification Checkbox -->
                <div class="flex items-center gap-2">
                  <input type="checkbox" id="notify" checked class="w-4 h-4 rounded text-secondary accent-secondary cursor-pointer">
                  <label for="notify" class="text-xs text-on-surface-variant font-medium cursor-pointer">
                    Kirim notifikasi otomatis ke akun portal siswa & wali kelas
                  </label>
                </div>

                <!-- Primary Form Submit Actions -->
                <div class="flex items-center gap-2 pt-2">
                  <button type="button" onclick="saveNotification()" class="flex-1 py-2.5 px-4 rounded-xl bg-primary text-on-primary font-bold text-xs hover:bg-primary-container transition-all flex items-center justify-center gap-2 shadow-xs">
                    <span class="material-symbols-outlined text-[18px]">send</span> Simpan & Kirim Notifikasi
                  </button>
                  <button type="button" onclick="closePanel()" class="py-2.5 px-4 rounded-xl bg-surface-container hover:bg-surface-container-high border border-outline-variant/30 text-on-surface font-bold text-xs transition-all">
                    Tutup Panel
                  </button>
                </div>
              </div>

              <!-- Ticket Audit History -->
              <div class="flex flex-col gap-2 pt-1">
                <span class="text-[10px] font-bold text-outline uppercase tracking-wider">Riwayat Status Tiket</span>
                <div class="flex flex-col gap-3 border-l-2 border-outline-variant/30 pl-3 ml-1.5">
                  <div class="flex flex-col">
                    <div class="flex items-center gap-2">
                      <span class="w-2 h-2 rounded-full bg-secondary -ml-[17px] border-2 border-surface-container-lowest"></span>
                      <span class="text-xs font-bold text-on-surface">Pengaduan Diunggah oleh Siswa</span>
                    </div>
                    <span class="text-[11px] text-outline mt-0.5">24 Mei 2025, 08:15 WIB via Portal Siswa Mobile</span>
                  </div>
                  <div class="flex flex-col">
                    <div class="flex items-center gap-2">
                      <span class="w-2 h-2 rounded-full bg-outline-variant -ml-[17px] border-2 border-surface-container-lowest"></span>
                      <span class="text-xs font-semibold text-on-surface">Dibuka oleh Admin Budi Santoso</span>
                    </div>
                    <span class="text-[11px] text-outline mt-0.5">24 Mei 2025, 08:42 WIB</span>
                  </div>
                </div>
              </div>

            </div>
          </div>

        </div>
      </div>
    </main>
  </div>

  <!-- JAVASCRIPT LOGIC -->
  <script>
    // Language Toggle Switcher
    function setLanguage(lang) {
      const btnId = document.getElementById('lang-id');
      const btnEn = document.getElementById('lang-en');
      if (lang === 'id') {
        btnId.className = "px-2 py-0.5 rounded-md text-xs font-bold bg-primary text-on-primary shadow-xs transition-all";
        btnEn.className = "px-2 py-0.5 rounded-md text-xs font-semibold text-on-surface-variant hover:text-on-surface transition-all";
      } else {
        btnEn.className = "px-2 py-0.5 rounded-md text-xs font-bold bg-primary text-on-primary shadow-xs transition-all";
        btnId.className = "px-2 py-0.5 rounded-md text-xs font-semibold text-on-surface-variant hover:text-on-surface transition-all";
      }
    }

    // Light/Dark Theme Switcher Toggle
    let isDark = false;
    function toggleTheme() {
      isDark = !isDark;
      const html = document.documentElement;
      const themeDot = document.getElementById('theme-dot');
      const themeIcon = document.getElementById('theme-icon');
      if (isDark) {
        html.classList.add('dark');
        themeDot.style.transform = 'translateX(20px)';
        themeIcon.innerText = 'dark_mode';
      } else {
        html.classList.remove('dark');
        themeDot.style.transform = 'translateX(0px)';
        themeIcon.innerText = 'light_mode';
      }
    }

    // Status Button Selector Logic
    function setStatus(element) {
      const buttons = document.querySelectorAll('.status-btn');
      buttons.forEach(btn => {
        btn.classList.remove('active', 'bg-primary', 'text-on-primary', 'border-primary');
        btn.classList.add('bg-surface-container-lowest', 'border-outline-variant/40');
      });
      element.classList.add('active', 'bg-primary', 'text-on-primary', 'border-primary');
      element.classList.remove('bg-surface-container-lowest', 'border-outline-variant/40');
    }

    // Table Row Selection Indicator
    function selectRow(ticketId) {
      const rows = document.querySelectorAll('tbody tr');
      rows.forEach(row => {
        row.classList.remove('bg-surface-container-high/60', 'border-l-secondary');
        row.classList.add('border-l-transparent');
      });
      event.currentTarget.classList.add('bg-surface-container-high/60', 'border-l-secondary');
      event.currentTarget.classList.remove('border-l-transparent');
    }

    // Clear Search Field
    function clearSearch() {
      document.getElementById('search-input').value = '';
    }

    // Reset Filters
    function resetFilters() {
      document.getElementById('filter-kategori').selectedIndex = 0;
      document.getElementById('filter-urgensi').selectedIndex = 0;
      document.getElementById('filter-status').selectedIndex = 0;
      document.getElementById('search-input').value = '';
    }

    // Actions mock triggers
    function exportExcel() {
      showToast("Data pengaduan berhasil diexport ke format Excel (.xlsx)");
    }

    function printSummary() {
      window.print();
    }

    function refreshData() {
      showToast("Data pengaduan terbaru diperbarui.");
    }

    function saveNotification() {
      showToast("Status pengaduan #PG-2025-089 berhasil disimpan & notifikasi terkirim!");
    }

    function closePanel() {
      const panel = document.getElementById('detail-panel');
      panel.style.display = 'none';
    }

    // Notification Toast Helper
    function showToast(message) {
      const toast = document.createElement('div');
      toast.className = 'fixed bottom-5 right-5 bg-primary text-on-primary px-4 py-3 rounded-xl shadow-xl z-50 text-xs font-bold flex items-center gap-2 animate-bounce';
      toast.innerHTML = `<span class="material-symbols-outlined text-[18px]">check_circle</span> ${message}`;
      document.body.appendChild(toast);
      setTimeout(() => {
        toast.remove();
      }, 3000);
    }
  </script>
</body>
</html>
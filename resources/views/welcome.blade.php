<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SIPRASKA - Pengaduan Sarana dan Prasarana</title>
    <script>try{var th=localStorage.getItem('sp_theme');if(!th){th=window.matchMedia('(prefers-color-scheme: dark)').matches?'dark':'light'}document.documentElement.setAttribute('data-theme',th)}catch(e){}</script>
    @if (auth()->check() && auth()->user()->role === 'admin')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
    @endif
@verbatim
    <script>
    /* ===== Bahasa (ID/EN) & tema, dipakai semua halaman ===== */
    window.SP=(function(){
    var D={
    id:{
    'panel':'Panel Administrator','menu.admin':'MENU ADMINISTRASI','nav.dashboard':'Ringkasan Sistem','nav.masuk':'Kelola Pengaduan','nav.rekap':'Laporan & Rekap','nav.users':'Kelola Pengguna','nav.riwayat':'Riwayat Admin','nav.profil':'Pengaturan Akun','lang':'Bahasa','theme':'Tema Tampilan',
    'top.sub':'Sistem Informasi Manajemen Sarana & Prasarana Terpadu','logout':'Keluar','menu.profile':'Profil & Ganti Sandi','role':'Admin',
    'title.dashboard':'Ringkasan Sistem','title.masuk':'Kelola Pengaduan','title.rekap':'Laporan & Rekap','title.users':'Kelola Pengguna','title.riwayat':'Riwayat Admin','title.profil':'Pengaturan Akun',
    'sys':'Sistem Aktif','center':'Pusat Kendali Pengaduan','chip.today':'Masuk Hari Ini','chip.urgent':'Darurat / Tinggi','chip.progress':'Dalam Pengerjaan','unit':'Tiket',
    'ph.search':'Cari tiket, judul, lokasi, atau pelapor…','export':'Export Excel','print':'Cetak Ringkasan','refresh':'Muat ulang',
    'f.cat':'Kategori','f.urg':'Tingkat Urgensi','f.status':'Status Tiket','f.period':'Periode Tanggal','f.reset':'Reset Filter','all':'Semua','sort.new':'Terkini','sort.old':'Terlama','sort.pri':'Prioritas','sortby':'Urutkan',
    'list.title':'Daftar Tiket Antrian','found':'ditemukan',
    'col.ticket':'No. Tiket','col.title':'Judul & Lokasi','col.reporter':'Pelapor','col.priority':'Prioritas','col.status':'Status','col.no':'No','col.date':'Tanggal','col.student':'Siswa','col.class':'Kelas','col.cat':'Kategori','col.loc':'Lokasi','col.judul':'Judul',
    'showing':'Menampilkan {a}–{b} dari {n} pengaduan','empty':'Tidak ada pengaduan.','selected':'{n} dipilih','clear':'Batal pilih','bulk':'Ubah status:',
    'pr.Tinggi':'Tinggi','pr.Sedang':'Sedang','pr.Rendah':'Rendah','pr.high':'Tinggi (Mendesak)',
    'st.Menunggu':'Menunggu Verifikasi','st.Diterima':'Diterima','st.Diproses':'Sedang Diproses','st.Selesai':'Selesai','st.Ditolak':'Ditolak',
    'stl.Diterima':'Diterima / Sah','stl.Diproses':'Sedang Diproses','stl.Selesai':'Selesai Ditangani','stl.Ditolak':'Tolak Laporan',
    'sub.Diterima':'Tervalidasi','sub.Diproses':'Teknisi meluncur','sub.Selesai':'Tuntas','sub.Ditolak':'Tidak valid / duplikat',
    'd.title':'Detail Pengaduan','d.reporter':'Nama Pelapor','d.time':'Waktu Pelaporan','d.loc':'Lokasi Kerusakan Fasilitas','d.desc':'Deskripsi Masalah oleh Siswa','d.photo':'Bukti Foto Kerusakan','d.view':'Lihat Foto','d.nophoto':'Siswa tidak melampirkan foto.','d.process':'Proses & Update Penanganan','d.setstatus':'Tentukan Status Penanganan','d.pri':'Prioritas','d.assign':'Tugaskan Petugas Teknis','d.assignph':'Nama petugas / teknisi','d.eta':'Estimasi Waktu Penyelesaian','d.reply':'Tanggapan Admin / Catatan Instruksi','d.replyph':'Tulis tanggapan untuk siswa…','d.notify':'Kirim notifikasi ke portal siswa','d.save':'Simpan & Kirim Notifikasi','d.close':'Tutup Panel','d.del':'Hapus pengaduan','d.timeline':'Riwayat Status Tiket',
    'sla.title':'Target Waktu Respon SIPRASKA (SLA)','sla.desc':'Maksimal 2 jam untuk tiket prioritas tinggi','sla.ok':'Tercapai',
    's.total':'Total Pengaduan','s.wait':'Menunggu','s.proc':'Diproses','s.done':'Selesai','s.rate':'{n}% terselesaikan','chart.curve':'Kurva Pengaduan','r6':'6 bulan terakhir','r12':'12 bulan terakhir','chart.cat':'Per Kategori','todo':'Perlu Ditindaklanjuti','todo.empty':'Tidak ada pengaduan yang menunggu 🎉','recent':'Pengaduan Terbaru','review':'Tinjau',
    'r.title':'Laporan Rekap Pengaduan','r.from':'Dari tanggal','r.to':'Sampai tanggal','r.student':'Siswa','r.group':'Kelompokkan','r.group_month':'Per bulan','r.group_student':'Per siswa','r.group_category':'Per kategori','r.breakdown':'Ringkasan per kelompok','r.group_name':'Kelompok','r.group_total':'Total pengaduan','r.group_done':'Selesai','r.csv':'Unduh CSV','r.sum':'Total {n} pengaduan — Menunggu: {a}, Diterima: {b}, Diproses: {c}, Selesai: {d}, Ditolak: {e}','r.empty':'Tidak ada data pada filter ini.',
    'h.title':'Riwayat Aktivitas Admin','h.from':'Dari tanggal','h.to':'Sampai tanggal','h.actor':'Role pelaku','h.all_roles':'Semua role','h.student':'Siswa','h.admin':'Admin','h.activity':'Jenis aktivitas','h.all_activities':'Semua aktivitas','h.action.account':'Akun','h.action.login':'Login','h.action.logout':'Logout','h.action.complaint':'Pengaduan','h.action.password':'Kata sandi','h.action.profile':'Profil','h.action.users':'Pengguna','h.action.delete':'Penghapusan','h.action.history':'Riwayat','h.search':'Cari nama atau aktivitas…','h.reset':'Reset filter','h.empty':'Tidak ada aktivitas yang cocok dengan filter.',
    'pf.title':'Profil Admin','pf.name':'Nama','pf.save':'Simpan Profil','pw.title':'Ganti Kata Sandi','pw.old':'Sandi Lama','pw.new':'Sandi Baru (min. 8 karakter)','pw.con':'Konfirmasi Sandi Baru','pw.btn':'Ganti Sandi','pw.mis':'Konfirmasi sandi tidak cocok.',
    'today':'Hari ini','ok.saved':'Pengaduan diperbarui','ok.del':'Pengaduan dihapus','ok.dl':'Mengunduh laporan…','c.del':'Hapus pengaduan ini secara permanen?','err':'Terjadi kesalahan, coba lagi.',
    'ac.add':'Tambah Pengaduan','ac.title':'Tambah Pengaduan atas Nama Siswa','ac.student':'Siswa pelapor','ac.student_ph':'Cari nama, NIS, atau kelas siswa…','ac.empty':'Siswa tidak ditemukan.','ac.category':'Kategori','ac.subject':'Judul pengaduan','ac.building':'Gedung / Wilayah','ac.detail':'Lantai & detail ruangan','ac.priority':'Prioritas','ac.description':'Deskripsi kerusakan','ac.status':'Status awal','ac.photos':'Foto bukti (maks. 3, 5 MB/foto)','ac.submit':'Simpan Pengaduan','ac.saving':'Menyimpan…','ac.created':'Pengaduan berhasil dibuat.','ac.edit_data':'Edit Data Pengaduan','ac.save_data':'Simpan Data Pengaduan','ac.saved_data':'Data pengaduan berhasil diperbarui.',
    'um.title':'Kelola Pengguna','um.subtitle':'Kelola akun siswa dan administrator.','um.add':'Tambah Pengguna','um.students':'Siswa','um.admins':'Admin','um.search':'Cari nama, NIS, kelas, atau username…','um.class':'Semua kelas','um.identity':'NIS / Username','um.email':'Email (opsional)','um.name':'Nama lengkap','um.name_required':'Nama wajib diisi.','um.identity_required':'NIS atau identitas login wajib diisi.','um.class_required':'Pilih kelas siswa.','um.password':'Sandi awal','um.generate':'Generate sandi acak','um.complaints':'Pengaduan','um.joined':'Tanggal daftar','um.actions':'Aksi','um.edit':'Ubah','um.reset':'Reset Sandi','um.delete':'Hapus','um.empty':'Tidak ada pengguna yang cocok.','um.create':'Tambah Pengguna','um.save':'Simpan','um.saving':'Menyimpan…','um.cancel':'Batal','um.reset_title':'Reset sandi pengguna?','um.reset_prompt':'Sandi baru akan menggantikan sandi akun {name}.','um.delete_title':'Hapus pengguna?','um.delete_prompt':'Akun {name} akan dihapus permanen.','um.delete_reports':'Siswa ini memiliki {n} pengaduan. Hapus akun beserta semua pengaduan, foto, dan riwayatnya?','um.delete_reports_check':'Saya memahami seluruh pengaduan dan foto siswa akan ikut dihapus.','um.confirm_reports_required':'Konfirmasi penghapusan pengaduan terlebih dahulu.','um.confirm_delete':'Ya, hapus','um.confirm_reset':'Ya, reset sandi','um.password_once':'Sandi baru (tampilkan sekali)','um.copy':'Salin','um.copied':'Sandi berhasil disalin.','um.copy_failed':'Tidak dapat menyalin sandi.','um.showing':'Menampilkan {a}-{b} dari {n} pengguna','um.created':'Pengguna berhasil ditambahkan.','um.updated':'Pengguna berhasil diperbarui.','um.deleted':'Pengguna berhasil dihapus.','um.reset_done':'Sandi berhasil direset.','um.password_required':'Sandi awal wajib diisi atau dibuat secara acak.','um.password_min':'Kata sandi minimal 8 karakter.','um.self_delete':'Anda tidak dapat menghapus akun sendiri.','um.last_admin':'Admin terakhir tidak dapat dihapus.','um.duplicate_nis':'NIS ini sudah terdaftar.','um.duplicate_email':'Email ini sudah digunakan.','um.role_student':'Siswa','um.role_admin':'Admin','um.select_class':'Pilih kelas',
    'g.brand':'Sistem Pengaduan Sarana','g.login_t':'Masuk ke Portal','g.login_s':'Gunakan kredensial resmi sekolah untuk melanjutkan pengaduan atau tindak lanjut.','g.tab_s':'Siswa','g.tab_a':'Petugas / Admin','g.id_s':'NISN / Nomor Induk Siswa','g.id_a':'Username / Email','g.hint_s':'Gunakan nomor induk aktif Anda yang terdaftar di sekolah.','g.hint_a':'Gunakan akun petugas yang diberikan admin sarpras.','g.pass':'Kata Sandi','g.remember':'Ingat saya di perangkat ini','g.forgot':'Lupa Sandi?','g.forgot_m':'Hubungi admin sarpras sekolah untuk mengatur ulang kata sandi Anda.','g.login_b':'Masuk Sekarang','g.noacc':'Belum memiliki akun?','g.reg_l':'Daftar Akun Baru',
    'g.reg_t':'Registrasi Akun Siswa','g.reg_s':'Daftarkan identitas resmi Anda untuk memantau laporan kerusakan secara transparan.','g.nis':'NISN / Nomor Induk Siswa','g.name':'Nama Lengkap Siswa','g.name_ph':'Nama sesuai buku induk siswa','g.class':'Kelas & Jurusan','g.class_ph':'Pilih Rombel','g.email':'Email (opsional)','g.pass_n':'Kata Sandi','g.pass_ph':'Min. 8 karakter','g.pass_c':'Konfirmasi Kata Sandi','g.pass_cph':'Ulangi kata sandi','g.strength':'Kekuatan Sandi','g.match':'Pastikan sandi sama persis','g.mismatch':'Sandi belum sama','g.s1':'Lemah','g.s2':'Cukup','g.s3':'Kuat','g.terms':'Saya menyatakan informasi ini benar sebagai siswa aktif sekolah ini.','g.reg_b':'Daftar Akun Baru','g.have':'Sudah memiliki akun aktif?','g.back':'Masuk ke Akun Anda','g.footer':'Portal Resmi Pengaduan Sarana Prasarana Sekolah',
    'u.role':'Siswa','u.menu':'PORTAL SISWA','u.buat':'Buat Laporan','u.lacak':'Lacak Status','u.history':'Riwayat','u.profil':'Profil Siswa','u.sub':'Portal Siswa','u.crumb':'FORM PENGADUAN BARU',
    'u.badge':'FASILITAS & INFRASTRUKTUR SEKOLAH','u.h1':'Buat Laporan Pengaduan Sarana & Prasarana','u.lead':'Sampaikan keluhan atau kerusakan fasilitas sekolah secara cepat, transparan, dan dapat dipantau langsung perkembangannya oleh tim sarpras.','u.tip_t':'Tips Pelaporan Cepat','u.tip':'Sertakan foto yang jelas dengan pencahayaan cukup dan cantumkan deskripsi lokasi yang spesifik agar teknisi lapangan dapat langsung menuju titik kerusakan tanpa hambatan.',
    'u.f1':'1. Pilih Kategori Sarana / Prasarana','u.req':'Wajib dipilih','u.f2':'2. Judul Ringkas Pengaduan','u.f2ph':'contoh: Kran air tempat wudhu putra patah','u.f2h':'Gunakan kalimat singkat yang langsung menjelaskan masalah utama.','u.f3':'3. Lokasi Spesifik Fasilitas','u.gedung':'Gedung / Wilayah Area','u.gedung_ph':'Pilih gedung / wilayah','u.detail':'Lantai & Detail Ruangan','u.detail_ph':'contoh: Lantai 1 - Samping Ruang XI MIPA 2',
    'u.f4':'4. Tingkat Urgensi Kerusakan','u.one':'Pilih satu level','u.pl':'Rendah','u.pld':'Kerusakan minor & estetika; tidak mengganggu KBM langsung.','u.pm':'Sedang','u.pmd':'Cukup mengganggu kenyamanan dan aktivitas kelas/siswa.','u.ph':'Tinggi / Mendesak','u.phd':'Air meluber, korsleting, atau berpotensi bahaya keselamatan siswa.',
    'u.f5':'5. Unggah Foto Bukti Kerusakan','u.pc':'{n} dari 3 Foto Terunggah','u.drop':'Tarik & lepas foto bukti di sini, atau','u.pick':'Klik untuk Memilih File','u.drop_h':'Mendukung file JPG, PNG, atau HEIC (Maksimal 5MB per berkas, hingga 3 foto)','u.att':'Lampiran yang Siap Dikirim:','u.f6':'6. Deskripsi Rinci Kerusakan','u.min30':'Minimal 30 karakter','u.descph':'Jelaskan kronologi, kondisi, dan dampak kerusakan...','u.decl':'Saya menyatakan bahwa informasi, rincian lokasi, dan foto bukti pengaduan ini adalah benar adanya sesuai kondisi di lapangan serta dapat dipertanggungjawabkan kepada pihak sekolah.','u.draft':'Simpan sebagai Draf','u.send':'Kirim Pengaduan Sekarang','u.draft_ok':'Draf tersimpan di perangkat ini','u.draft_back':'Draf sebelumnya dimuat','u.short':'Deskripsi minimal 30 karakter.','u.nocat':'Pilih kategori terlebih dahulu.','u.maxf':'Maksimal 3 foto, ukuran tiap foto 5 MB.',
    'u.flow':'Alur Penanganan','u.flow_s':'Standar Operasional Sarpras','u.s1':'1. Laporan Masuk','u.s1d':'Laporan siswa otomatis dicatat dalam database terintegrasi SIPRASKA.','u.s2':'2. Verifikasi Tim','u.s2d':'Petugas memvalidasi tingkat urgensi dan ketersediaan suku cadang.','u.s3':'3. Pengerjaan Teknisi','u.s3d':'Teknisi lapangan dikirim langsung ke lokasi untuk perbaikan.','u.s4':'4. Konfirmasi Selesai','u.s4d':'Foto hasil perbaikan diunggah; notifikasi sukses terkirim ke siswa.',
    'u.duty':'PETUGAS SIAGA HARI INI','u.duty_n':'{n} Teknisi On-Duty','u.duty_none':'Belum ada petugas yang sedang menangani laporan.','u.urgent':'Butuh bantuan darurat saat jam pelajaran? Laporkan langsung ke pos piket satpam gerbang utama atau ruang TU Sarpras.','u.faq':'PERTANYAAN UMUM (FAQ)','u.q1':'Berapa lama laporan ditindaklanjuti?','u.a1':'Laporan kategori tinggi ditangani dalam 1–3 jam, sedangkan perbaikan minor ditargetkan maksimal 1x24 jam kerja.','u.q2':'Apakah laporan saya anonim?','u.a2':'Nama dan kelas dicatat agar admin dapat meminta detail titik lokasi bila diperlukan verifikasi fisik.',
    'u.te':'PELACAKAN REAL-TIME','u.th':'Laporan Pengaduan Saya','u.ts':'Pantau status verifikasi, jadwal pengerjaan teknisi, dan riwayat penyelesaian fasilitas yang Anda laporkan secara transparan.','u.new':'Buat Pengaduan Baru','u.t_all':'Semua Pengaduan','u.t_proc':'Dalam Proses','u.t_done':'Selesai','u.t_rej':'Ditolak','u.search':'Cari tiket atau fasilitas…','u.list':'DAFTAR TIKET ANDA','u.sort':'Urut Berdasarkan: Terbaru','u.none':'Belum ada pengaduan.','u.see':'Lihat Detail','u.pick_t':'Pilih tiket untuk melihat detail penanganan.',
    'u.flowt':'PROSES PENANGANAN SARPRAS','u.p1':'Laporan Dikirim & Diterima Sistem','u.p1d':'Laporan berhasil dibuat oleh {name} dengan {n} lampiran foto bukti kerusakan.','u.p2':'Diverifikasi Admin Sarpras','u.p2d':'Ditinjau oleh {by}. Tingkat urgensi ditetapkan {pri}.','u.p2w':'Menunggu verifikasi oleh tim admin sarpras.','u.p2r':'Laporan ditolak oleh {by}.','u.p3':'Dalam Pengerjaan Teknisi Lapangan','u.p3w':'Menunggu penugasan teknisi.','u.p4':'Konfirmasi Selesai & Uji Coba','u.p4w':'Menunggu pengerjaan selesai.','u.p4d':'Pengerjaan telah selesai ditangani.','u.diag':'CATATAN DIAGNOSA TEKNIS:','u.feedback':'Umpan Balik Admin','u.eta':'Estimasi Selesai:','u.attc':'Lampiran Bukti Pengaduan','u.zoom':'Klik foto untuk memperbesar','u.contact':'Hubungi Admin','u.help':'Bantuan','u.resp':'Respon {n} mnt','u.fac':'Fasilitas','u.rep':'Pelapor','u.tech':'Teknisi Sarpras','u.ct':'Mengalami kendala mendesak?','u.cd':'Untuk insiden darurat (korsleting berapi, kebocoran pipa air utama), segera hubungi pos piket Sarpras di Lantai 1 atau ruang Tata Usaha.','u.close':'Tutup','u.sent':'Pengaduan berhasil dikirim ke admin!',
    'u.pt':'Profil Siswa','u.pn':'Nama','u.pnis':'NIS','u.pk':'Kelas',
    'rw.title':'Riwayat Pengaduan Saya','rw.subtitle':'Lihat aktivitas terbaru dari seluruh pengaduan Anda.','rw.total':'Total aktivitas','rw.done':'Selesai','rw.progress':'Dalam proses','rw.rejected':'Ditolak','rw.search':'Cari tiket, judul, lokasi, atau catatan…','rw.status':'Semua status','rw.from':'Dari tanggal','rw.to':'Sampai tanggal','rw.reset':'Reset','rw.empty':'Belum ada aktivitas yang cocok dengan filter.','rw.today':'Hari ini','rw.yesterday':'Kemarin','rw.showing':'Menampilkan {a}-{b} dari {n} aktivitas','rw.ticket':'Tiket {ticket}','rw.by':'Oleh {name}',
    'se.edit':'Ubah','se.delete':'Hapus','se.processed':'Pengaduan sudah diproses, tidak dapat diubah.','se.title':'Ubah Pengaduan','se.category':'Kategori','se.title_label':'Judul pengaduan','se.building':'Gedung / Wilayah','se.detail':'Lantai & detail ruangan','se.priority':'Prioritas','se.description':'Deskripsi kerusakan','se.photos':'Foto pengaduan','se.remove_photo':'Hapus foto','se.add_photos':'Tambah foto','se.photo_count':'{n} dari 3 foto','se.cancel':'Batal','se.save':'Simpan perubahan','se.saving':'Menyimpan…','se.delete_title':'Hapus pengaduan?','se.delete_prompt':'Pengaduan {ticket} akan dihapus permanen beserta foto dan riwayatnya.','se.confirm_delete':'Ya, hapus','se.deleting':'Menghapus…','se.updated':'Pengaduan berhasil diperbarui.','se.deleted':'Pengaduan berhasil dihapus.','se.max_photos':'Maksimal 3 foto, ukuran tiap foto 5 MB.','se.delete_failed':'Pengaduan tidak dapat dihapus.','se.category_error':'Pilih kategori pengaduan.','se.title_error':'Judul wajib diisi.','se.building_error':'Gedung wajib diisi.','se.detail_error':'Detail lokasi wajib diisi.','se.priority_error':'Pilih prioritas.','se.description_error':'Deskripsi minimal 30 karakter.'
    },
    en:{
    'panel':'Administrator Panel','menu.admin':'ADMINISTRATION MENU','nav.dashboard':'System Overview','nav.masuk':'Manage Complaints','nav.rekap':'Reports & Recap','nav.users':'Manage Users','nav.riwayat':'Admin History','nav.profil':'Account Settings','lang':'Language','theme':'Appearance',
    'top.sub':'Integrated School Facilities & Infrastructure Management System','logout':'Sign out','menu.profile':'Profile & Change Password','role':'Admin',
    'title.dashboard':'System Overview','title.masuk':'Manage Complaints','title.rekap':'Reports & Recap','title.users':'Manage Users','title.riwayat':'Admin History','title.profil':'Account Settings',
    'sys':'System Active','center':'Complaint Control Center','chip.today':'Received Today','chip.urgent':'Urgent / High','chip.progress':'In Progress','unit':'Tickets',
    'ph.search':'Search ticket, title, location, or reporter…','export':'Export Excel','print':'Print Summary','refresh':'Reload',
    'f.cat':'Category','f.urg':'Urgency Level','f.status':'Ticket Status','f.period':'Date Range','f.reset':'Reset Filters','all':'All','sort.new':'Newest','sort.old':'Oldest','sort.pri':'Priority','sortby':'Sort by',
    'list.title':'Ticket Queue','found':'found',
    'col.ticket':'Ticket No.','col.title':'Title & Location','col.reporter':'Reporter','col.priority':'Priority','col.status':'Status','col.no':'No','col.date':'Date','col.student':'Student','col.class':'Class','col.cat':'Category','col.loc':'Location','col.judul':'Title',
    'showing':'Showing {a}–{b} of {n} complaints','empty':'No complaints found.','selected':'{n} selected','clear':'Clear selection','bulk':'Change status:',
    'pr.Tinggi':'High','pr.Sedang':'Medium','pr.Rendah':'Low','pr.high':'High (Urgent)',
    'st.Menunggu':'Awaiting Verification','st.Diterima':'Accepted','st.Diproses':'In Progress','st.Selesai':'Completed','st.Ditolak':'Rejected',
    'stl.Diterima':'Accepted / Valid','stl.Diproses':'In Progress','stl.Selesai':'Completed','stl.Ditolak':'Reject Report',
    'sub.Diterima':'Validated','sub.Diproses':'Technician on the way','sub.Selesai':'Fully resolved','sub.Ditolak':'Invalid / duplicate',
    'd.title':'Complaint Detail','d.reporter':'Reporter','d.time':'Reported At','d.loc':'Damaged Facility Location','d.desc':'Problem Description by Student','d.photo':'Damage Photo Evidence','d.view':'View Photo','d.nophoto':'The student attached no photo.','d.process':'Process & Update Handling','d.setstatus':'Set Handling Status','d.pri':'Priority','d.assign':'Assign Technician','d.assignph':'Technician name','d.eta':'Estimated Completion','d.reply':'Admin Response / Instructions','d.replyph':'Write a response for the student…','d.notify':'Send notification to student portal','d.save':'Save & Send Notification','d.close':'Close Panel','d.del':'Delete complaint','d.timeline':'Ticket Status History',
    'sla.title':'SIPRASKA Response Time Target (SLA)','sla.desc':'Maximum 2 hours for high priority tickets','sla.ok':'Achieved',
    's.total':'Total Complaints','s.wait':'Pending','s.proc':'In Progress','s.done':'Completed','s.rate':'{n}% resolved','chart.curve':'Complaint Trend','r6':'Last 6 months','r12':'Last 12 months','chart.cat':'By Category','todo':'Needs Action','todo.empty':'No pending complaints 🎉','recent':'Latest Complaints','review':'Review',
    'r.title':'Complaint Recap Report','r.from':'From date','r.to':'To date','r.student':'Student','r.group':'Group by','r.group_month':'By month','r.group_student':'By student','r.group_category':'By category','r.breakdown':'Grouped complaint summary','r.group_name':'Group','r.group_total':'Total complaints','r.group_done':'Completed','r.csv':'Download CSV','r.sum':'Total {n} complaints — Pending: {a}, Accepted: {b}, In progress: {c}, Completed: {d}, Rejected: {e}','r.empty':'No data for this filter.',
    'h.title':'Activity History','h.from':'From date','h.to':'To date','h.actor':'Actor role','h.all_roles':'All roles','h.student':'Student','h.admin':'Admin','h.activity':'Activity type','h.all_activities':'All activities','h.action.account':'Account','h.action.login':'Login','h.action.logout':'Logout','h.action.complaint':'Complaint','h.action.password':'Password','h.action.profile':'Profile','h.action.users':'Users','h.action.delete':'Deletion','h.action.history':'History','h.search':'Search name or activity…','h.reset':'Reset filters','h.empty':'No activity matches these filters.',
    'pf.title':'Admin Profile','pf.name':'Name','pf.save':'Save Profile','pw.title':'Change Password','pw.old':'Current Password','pw.new':'New Password (min. 8 characters)','pw.con':'Confirm New Password','pw.btn':'Change Password','pw.mis':'Password confirmation does not match.',
    'today':'Today','ok.saved':'Complaint updated','ok.del':'Complaint deleted','ok.dl':'Downloading report…','c.del':'Delete this complaint permanently?','err':'Something went wrong, please try again.',
    'ac.add':'Add Complaint','ac.title':'Add Complaint on Behalf of a Student','ac.student':'Reporting student','ac.student_ph':'Search student name, ID, or class…','ac.empty':'No students found.','ac.category':'Category','ac.subject':'Complaint title','ac.building':'Building / Area','ac.detail':'Floor & room detail','ac.priority':'Priority','ac.description':'Damage description','ac.status':'Initial status','ac.photos':'Evidence photos (max 3, 5 MB each)','ac.submit':'Save Complaint','ac.saving':'Saving…','ac.created':'Complaint created successfully.','ac.edit_data':'Edit Complaint Data','ac.save_data':'Save Complaint Data','ac.saved_data':'Complaint data updated successfully.',
    'um.title':'Manage Users','um.subtitle':'Manage student and administrator accounts.','um.add':'Add User','um.students':'Students','um.admins':'Admins','um.search':'Search name, ID, class, or username…','um.class':'All classes','um.identity':'Student ID / Username','um.email':'Email (optional)','um.name':'Full name','um.name_required':'Name is required.','um.identity_required':'A student ID or login identifier is required.','um.class_required':'Choose a student class.','um.password':'Initial password','um.generate':'Generate random password','um.complaints':'Complaints','um.joined':'Registered','um.actions':'Actions','um.edit':'Edit','um.reset':'Reset Password','um.delete':'Delete','um.empty':'No users match these filters.','um.create':'Add User','um.save':'Save','um.saving':'Saving…','um.cancel':'Cancel','um.reset_title':'Reset user password?','um.reset_prompt':'A new password will replace the password for {name}.','um.delete_title':'Delete user?','um.delete_prompt':'The account for {name} will be permanently deleted.','um.delete_reports':'This student has {n} complaints. Delete the account with all complaints, photos, and history?','um.delete_reports_check':'I understand that all of this student’s complaints and photos will be deleted.','um.confirm_reports_required':'Confirm the complaint deletion first.','um.confirm_delete':'Yes, delete','um.confirm_reset':'Yes, reset password','um.password_once':'New password (shown once)','um.copy':'Copy','um.copied':'Password copied.','um.copy_failed':'Could not copy the password.','um.showing':'Showing {a}-{b} of {n} users','um.created':'User added successfully.','um.updated':'User updated successfully.','um.deleted':'User deleted successfully.','um.reset_done':'Password reset successfully.','um.password_required':'Enter an initial password or generate one.','um.password_min':'Password must be at least 8 characters.','um.self_delete':'You cannot delete your own account.','um.last_admin':'The last admin cannot be deleted.','um.duplicate_nis':'This ID is already registered.','um.duplicate_email':'This email is already in use.','um.role_student':'Student','um.role_admin':'Admin','um.select_class':'Select a class',
    'g.brand':'Facilities Complaint System','g.login_t':'Sign in to the Portal','g.login_s':'Use your official school credentials to continue with complaints or follow-ups.','g.tab_s':'Student','g.tab_a':'Staff / Admin','g.id_s':'Student ID Number','g.id_a':'Username / Email','g.hint_s':'Use your active student number registered at school.','g.hint_a':'Use the staff account issued by the facilities admin.','g.pass':'Password','g.remember':'Remember me on this device','g.forgot':'Forgot password?','g.forgot_m':'Please contact the school facilities admin to reset your password.','g.login_b':'Sign In','g.noacc':'Do not have an account?','g.reg_l':'Create New Account',
    'g.reg_t':'Student Account Registration','g.reg_s':'Register your official identity to track damage reports transparently.','g.nis':'Student ID Number','g.name':'Student Full Name','g.name_ph':'Name as in the student register','g.class':'Class & Major','g.class_ph':'Select class','g.email':'Email (optional)','g.pass_n':'Password','g.pass_ph':'Min. 8 characters','g.pass_c':'Confirm Password','g.pass_cph':'Repeat password','g.strength':'Password Strength','g.match':'Make sure both passwords match','g.mismatch':'Passwords do not match yet','g.s1':'Weak','g.s2':'Fair','g.s3':'Strong','g.terms':'I declare this information is true as an active student of this school.','g.reg_b':'Create Account','g.have':'Already have an active account?','g.back':'Sign in to Your Account','g.footer':'Official School Facilities Complaint Portal',
    'u.role':'Student','u.menu':'STUDENT PORTAL','u.buat':'Create Report','u.lacak':'Track Status','u.history':'History','u.profil':'Student Profile','u.sub':'Student Portal','u.crumb':'NEW COMPLAINT FORM',
    'u.badge':'SCHOOL FACILITIES & INFRASTRUCTURE','u.h1':'Submit a Facilities & Infrastructure Complaint','u.lead':'Report school facility problems quickly and transparently, and follow the progress directly with the facilities team.','u.tip_t':'Quick Reporting Tips','u.tip':'Attach a clear, well-lit photo and describe the exact location so field technicians can go straight to the damaged spot.',
    'u.f1':'1. Choose Facility Category','u.req':'Required','u.f2':'2. Short Complaint Title','u.f2ph':'e.g. Broken ablution tap in boys area','u.f2h':'Use a short sentence that states the main problem.','u.f3':'3. Specific Facility Location','u.gedung':'Building / Area','u.gedung_ph':'Select building / area','u.detail':'Floor & Room Detail','u.detail_ph':'e.g. Floor 1 - next to Room XI MIPA 2',
    'u.f4':'4. Damage Urgency Level','u.one':'Pick one level','u.pl':'Low','u.pld':'Minor or cosmetic damage; does not disrupt lessons directly.','u.pm':'Medium','u.pmd':'Noticeably disturbs comfort and class activities.','u.ph':'High / Urgent','u.phd':'Flooding, short circuit, or potential danger to student safety.',
    'u.f5':'5. Upload Damage Photo Evidence','u.pc':'{n} of 3 Photos Uploaded','u.drop':'Drag & drop evidence photos here, or','u.pick':'Click to Choose Files','u.drop_h':'JPG, PNG, or HEIC files (max 5MB each, up to 3 photos)','u.att':'Attachments Ready to Send:','u.f6':'6. Detailed Damage Description','u.min30':'Minimum 30 characters','u.descph':'Describe the chronology, condition, and impact of the damage...','u.decl':'I declare that the information, location details, and photo evidence in this complaint are true to the conditions on site and can be accounted for to the school.','u.draft':'Save as Draft','u.send':'Submit Complaint Now','u.draft_ok':'Draft saved on this device','u.draft_back':'Previous draft restored','u.short':'Description must be at least 30 characters.','u.nocat':'Please choose a category first.','u.maxf':'Maximum 3 photos, 5 MB each.',
    'u.flow':'Handling Flow','u.flow_s':'Facilities Operating Standard','u.s1':'1. Report Received','u.s1d':'Student reports are recorded automatically in the integrated SIPRASKA database.','u.s2':'2. Team Verification','u.s2d':'Staff validate urgency level and spare-part availability.','u.s3':'3. Technician Work','u.s3d':'Field technicians are sent straight to the location for repairs.','u.s4':'4. Completion Confirmed','u.s4d':'Repair photos are uploaded and a success notice is sent to the student.',
    'u.duty':'ON-DUTY STAFF TODAY','u.duty_n':'{n} Technicians On-Duty','u.duty_none':'No staff are handling reports right now.','u.urgent':'Need urgent help during lessons? Report directly to the main gate security post or the facilities admin office.','u.faq':'FREQUENTLY ASKED QUESTIONS','u.q1':'How long until a report is handled?','u.a1':'High priority reports are handled within 1–3 hours, while minor repairs target at most 1x24 working hours.','u.q2':'Is my report anonymous?','u.a2':'Your name and class are recorded so admins can ask for location details when physical verification is needed.',
    'u.te':'REAL-TIME TRACKING','u.th':'My Complaint Reports','u.ts':'Follow verification status, technician schedules, and the resolution history of facilities you reported.','u.new':'New Complaint','u.t_all':'All Complaints','u.t_proc':'In Progress','u.t_done':'Completed','u.t_rej':'Rejected','u.search':'Search ticket or facility…','u.list':'YOUR TICKETS','u.sort':'Sorted by: Newest','u.none':'No complaints yet.','u.see':'View Details','u.pick_t':'Select a ticket to see handling details.',
    'u.flowt':'FACILITIES HANDLING PROCESS','u.p1':'Report Submitted & Received','u.p1d':'Report created by {name} with {n} damage photo attachment(s).','u.p2':'Verified by Facilities Admin','u.p2d':'Reviewed by {by}. Urgency level set to {pri}.','u.p2w':'Waiting for verification by the facilities admin team.','u.p2r':'Report rejected by {by}.','u.p3':'Technician Work in Progress','u.p3w':'Waiting for technician assignment.','u.p4':'Completion Confirmed & Tested','u.p4w':'Waiting for the work to finish.','u.p4d':'The work has been completed.','u.diag':'TECHNICAL DIAGNOSIS NOTES:','u.feedback':'Administrator feedback','u.eta':'Estimated Completion:','u.attc':'Complaint Evidence Attachments','u.zoom':'Click a photo to enlarge','u.contact':'Contact Admin','u.help':'Help','u.resp':'Response {n} min','u.fac':'Facility','u.rep':'Reporter','u.tech':'Facilities Technician','u.ct':'Facing an urgent problem?','u.cd':'For emergencies (sparking short circuit, main water pipe leak), contact the facilities duty post on Floor 1 or the administration office immediately.','u.close':'Close','u.sent':'Complaint sent to the admin!',
    'u.pt':'Student Profile','u.pn':'Name','u.pnis':'Student ID','u.pk':'Class',
    'rw.title':'My Complaint History','rw.subtitle':'Review recent activity across all your complaints.','rw.total':'Total activities','rw.done':'Completed','rw.progress':'In progress','rw.rejected':'Rejected','rw.search':'Search ticket, title, location, or note…','rw.status':'All statuses','rw.from':'From date','rw.to':'To date','rw.reset':'Reset','rw.empty':'No activities match these filters.','rw.today':'Today','rw.yesterday':'Yesterday','rw.showing':'Showing {a}-{b} of {n} activities','rw.ticket':'Ticket {ticket}','rw.by':'By {name}',
    'se.edit':'Edit','se.delete':'Delete','se.processed':'This complaint has been processed and can no longer be changed.','se.title':'Edit Complaint','se.category':'Category','se.title_label':'Complaint title','se.building':'Building / Area','se.detail':'Floor & room detail','se.priority':'Priority','se.description':'Damage description','se.photos':'Complaint photos','se.remove_photo':'Remove photo','se.add_photos':'Add photos','se.photo_count':'{n} of 3 photos','se.cancel':'Cancel','se.save':'Save changes','se.saving':'Saving…','se.delete_title':'Delete complaint?','se.delete_prompt':'Complaint {ticket} will be permanently deleted with its photos and history.','se.confirm_delete':'Yes, delete','se.deleting':'Deleting…','se.updated':'Complaint updated successfully.','se.deleted':'Complaint deleted successfully.','se.max_photos':'Maximum 3 photos, 5 MB each.','se.delete_failed':'The complaint could not be deleted.','se.category_error':'Choose a complaint category.','se.title_error':'Title is required.','se.building_error':'Building is required.','se.detail_error':'Location detail is required.','se.priority_error':'Choose a priority.','se.description_error':'Description must be at least 30 characters.'
    }};
    var lang='id';try{if(localStorage.getItem('sp_lang')==='en')lang='en'}catch(e){}
    function t(k,v){var s=(D[lang][k]!==undefined)?D[lang][k]:((D.id[k]!==undefined)?D.id[k]:k);if(v){for(var x in v){s=s.split('{'+x+'}').join(v[x])}}return s}
    function q(s){return Array.prototype.slice.call(document.querySelectorAll(s))}
    function themeUI(){var d=document.documentElement.getAttribute('data-theme')==='dark';q('[data-theme-toggle]').forEach(function(b){b.setAttribute('aria-pressed',d?'true':'false')})}
    function apply(){
        document.documentElement.lang=lang;
        q('[data-i18n]').forEach(function(e){e.textContent=t(e.getAttribute('data-i18n'))});
        q('[data-i18n-ph]').forEach(function(e){e.placeholder=t(e.getAttribute('data-i18n-ph'))});
        q('[data-i18n-title]').forEach(function(e){e.title=t(e.getAttribute('data-i18n-title'))});
        q('[data-lang]').forEach(function(b){b.classList.toggle('on',b.getAttribute('data-lang')===lang)});
        themeUI();
    }
    document.addEventListener('click',function(e){
        var b=e.target.closest&&e.target.closest('[data-lang]');
        if(b){lang=b.getAttribute('data-lang');try{localStorage.setItem('sp_lang',lang)}catch(x){}apply();document.dispatchEvent(new Event('splang'));return}
        var h=e.target.closest&&e.target.closest('[data-theme-toggle]');
        if(h){var n=document.documentElement.getAttribute('data-theme')==='dark'?'light':'dark';document.documentElement.setAttribute('data-theme',n);try{localStorage.setItem('sp_theme',n)}catch(x){}themeUI();document.dispatchEvent(new Event('sptheme'))}
    });
    document.addEventListener('DOMContentLoaded',apply);
    return {t:t,apply:apply,loc:function(){return lang==='id'?'id-ID':'en-US'}};
    })();
    </script>
    <style>
        :root{--bg:#f3f6fc;--surface:#fff;--surface2:#f6f8fc;--text:#0f172a;--muted:#64748b;--line:#e2e8f0;--bd:#cbd5e1;--primary:#1d4ed8;--primary-d:#0b2a7a;--soft:#eaf1ff;--ok:#16a34a;--warn:#d97706;--bad:#dc2626;--info:#0891b2}
        [data-theme=dark]{--bg:#0b1120;--surface:#111a2e;--surface2:#0e1627;--text:#e5e7eb;--muted:#94a3b8;--line:#1f2a44;--bd:#2b3a5c;--primary:#3b82f6;--primary-d:#1d4ed8;--soft:#15233f}
        *{box-sizing:border-box;margin:0;padding:0}
        body{font-family:"Instrument Sans",system-ui,-apple-system,Segoe UI,Roboto,sans-serif;background:var(--bg);color:var(--text);font-size:14px;transition:background .2s,color .2s}
        button{font:inherit;cursor:pointer;color:inherit}
        a{color:var(--primary)}
        .hidden{display:none!important}
        label{display:block;font-weight:600;margin:12px 0 4px;font-size:12px;color:var(--muted)}
        input,select,textarea{width:100%;padding:10px 12px;border:1px solid var(--bd);border-radius:10px;font:inherit;background:var(--surface);color:var(--text)}
        input:focus,select:focus,textarea:focus{outline:2px solid rgba(59,130,246,.35);border-color:var(--primary)}
        input:disabled{background:var(--surface2);color:var(--muted)}
        input[type=checkbox],input[type=radio]{width:auto}
        .btn{background:var(--primary-d);color:#fff;border:0;padding:10px 18px;border-radius:10px;font-weight:600;margin-top:14px;transition:.15s}
        [data-theme=dark] .btn{background:var(--primary)}
        .btn:hover{filter:brightness(1.12)}
        .btn:disabled{opacity:.55;cursor:not-allowed}
        .btn.ghost{background:var(--surface);color:var(--text);border:1px solid var(--bd)}
        .btn.red{background:var(--bad);color:#fff}
        .btn.sm{padding:6px 11px;font-size:12px;margin-top:0}
        .btn.full{width:100%}
        .err{color:var(--bad);font-size:13px;margin-top:6px}
        .alert{padding:10px 14px;border-radius:10px;margin-bottom:14px;font-size:13px}
        .alert.ok{background:rgba(22,163,74,.15);color:var(--ok)}
        .alert.bad{background:rgba(220,38,38,.12);color:var(--bad)}
        .card{background:var(--surface);border-radius:14px;padding:18px;border:1px solid var(--line)}
        .card h3{font-size:14px;margin-bottom:12px}
        .tag{display:inline-flex;align-items:center;gap:5px;padding:3px 10px;border-radius:99px;font-size:12px;font-weight:600;white-space:nowrap}
        .Menunggu{background:rgba(245,158,11,.16);color:#b45309}
        .Diterima{background:rgba(59,130,246,.16);color:#1d4ed8}
        .Diproses{background:rgba(8,145,178,.16);color:#0e7490}
        .Selesai{background:rgba(22,163,74,.16);color:#15803d}
        .Ditolak{background:rgba(220,38,38,.16);color:#b91c1c}
        [data-theme=dark] .Menunggu{color:#fbbf24}[data-theme=dark] .Diterima{color:#93c5fd}[data-theme=dark] .Diproses{color:#67e8f9}[data-theme=dark] .Selesai{color:#86efac}[data-theme=dark] .Ditolak{color:#fca5a5}
        .pr{display:inline-block;padding:3px 10px;border-radius:99px;font-size:12px;font-weight:700;white-space:nowrap}
        .pr.Tinggi{background:rgba(220,38,38,.15);color:var(--bad)}
        .pr.Sedang,.pr.Rendah{background:var(--surface2);color:var(--muted);border:1px solid var(--line)}
        .empty{text-align:center;color:var(--muted);padding:26px}
        small.m,.m{color:var(--muted)}
        .logo{width:38px;height:38px;border-radius:10px;background:var(--primary-d);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:800;flex-shrink:0}
        [data-theme=dark] .logo{background:var(--primary)}
        .lang{display:flex;background:var(--bg);border-radius:8px;overflow:hidden;border:1px solid var(--line)}
        .lang button{border:0;background:none;padding:4px 10px;font-weight:700;font-size:12px;color:var(--muted)}
        .lang button.on{background:var(--primary-d);color:#fff}
        .switch{width:46px;height:24px;border-radius:99px;background:var(--bd);border:0;position:relative;transition:.2s;flex-shrink:0}
        .switch::after{content:"☀";position:absolute;top:2px;left:2px;width:20px;height:20px;border-radius:50%;background:#fff;color:#f59e0b;font-size:12px;display:flex;align-items:center;justify-content:center;transition:.2s}
        .switch[aria-pressed=true]{background:var(--primary)}
        .switch[aria-pressed=true]::after{content:"☾";left:24px;color:#1e3a8a}
        .toast{position:fixed;bottom:20px;right:20px;background:#111827;color:#fff;padding:11px 16px;border-radius:10px;z-index:99;box-shadow:0 8px 24px rgba(0,0,0,.25)}
        .toast.bad{background:var(--bad)}
        /* ===== tamu (login & register) ===== */
        .gwrap{min-height:100vh;display:flex;align-items:center;justify-content:center;padding:24px 16px 80px;background-image:radial-gradient(var(--line) 1px,transparent 1px);background-size:22px 22px}
        .gcard{background:var(--surface);border:1px solid var(--line);border-radius:18px;box-shadow:0 20px 50px rgba(15,23,42,.10);padding:30px;width:100%;max-width:480px}
        .gcard.wide{max-width:720px}
        .ghead{display:flex;align-items:center;gap:12px;margin-bottom:18px}
        .ghead b{font-size:18px;color:var(--primary-d);display:block}[data-theme=dark] .ghead b{color:var(--primary)}
        .ghead small{color:var(--muted);font-size:12px}
        .gcard h1{font-size:24px;margin-bottom:4px}
        .gcard p.sub{color:var(--muted);margin-bottom:16px;line-height:1.5}
        .rtabs{display:flex;gap:6px;background:var(--surface2);border:1px solid var(--line);padding:5px;border-radius:12px;margin-bottom:6px}
        .rtabs label{flex:1;margin:0;font-weight:600}
        .rtabs input{display:none}
        .rtabs span{display:block;text-align:center;padding:10px;border-radius:9px;cursor:pointer;color:var(--muted)}
        .rtabs input:checked+span{background:var(--surface);color:var(--primary-d);box-shadow:0 1px 4px rgba(0,0,0,.12)}
        [data-theme=dark] .rtabs input:checked+span{color:var(--primary)}
        .inp{position:relative}
        .inp>i{position:absolute;left:12px;top:50%;transform:translateY(-50%);font-style:normal;opacity:.7}
        .inp input,.inp select{padding-left:38px;background:var(--surface2)}
        .eye{position:absolute;right:8px;top:50%;transform:translateY(-50%);background:none;border:0;padding:6px;opacity:.7}
        .hint{font-size:12px;color:var(--muted);margin-top:6px}
        .row-b{display:flex;justify-content:space-between;align-items:center;gap:10px;margin-top:14px;font-size:13px}
        .row-b label{display:flex;gap:8px;align-items:center;margin:0;font-weight:400;color:var(--text)}
        .forgot{background:var(--soft);border-radius:10px;padding:10px 12px;margin-top:12px;font-size:13px}
        .center{text-align:center;margin-top:18px;color:var(--muted)}
        .g2c{display:grid;grid-template-columns:1fr 1fr;gap:0 14px}
        .meter{height:6px;background:var(--line);border-radius:99px;overflow:hidden;margin-top:8px}
        .meter i{display:block;height:100%;width:0;background:var(--bad);transition:.2s}
        .gfoot{position:fixed;left:0;right:0;bottom:0;display:flex;justify-content:space-between;align-items:center;padding:14px 22px;gap:10px;pointer-events:none;color:var(--muted);font-size:13px}
        .gfoot>*{pointer-events:auto}
        .gctl{display:flex;gap:8px;align-items:center;background:var(--surface);border:1px solid var(--line);border-radius:12px;padding:6px 10px}
        /* ===== shell ===== */
        #app{display:flex;min-height:100vh}
        aside{width:250px;background:var(--surface);border-right:1px solid var(--line);padding:18px 14px;flex-shrink:0;position:sticky;top:0;height:100vh;z-index:40;display:flex;flex-direction:column}
        .brand{display:flex;align-items:center;gap:10px;padding:4px 8px 18px}
        .brand b{font-size:16px;letter-spacing:.02em}.brand small{display:block;color:var(--muted);font-size:11px}
        .sec{font-size:11px;font-weight:700;letter-spacing:.08em;color:var(--muted);padding:10px 12px 6px}
        .nav{display:flex;align-items:center;gap:10px;width:100%;text-align:left;padding:11px 12px;border-radius:10px;background:none;border:0;color:var(--text);margin-bottom:3px;text-decoration:none;font-size:14px}
        .nav:hover{background:var(--surface2)}
        .nav.active{background:var(--primary-d);color:#fff}
        [data-theme=dark] .nav.active{background:var(--primary)}
        .badge{margin-left:auto;background:var(--bad);color:#fff;border-radius:99px;font-size:11px;padding:1px 7px}
        .side-foot{margin-top:auto;border-top:1px solid var(--line);padding-top:12px}
        .frow{display:flex;align-items:center;justify-content:space-between;background:var(--surface2);border:1px solid var(--line);border-radius:10px;padding:8px 10px;margin-top:8px;font-size:12px}
        .main{flex:1;min-width:0}
        header.top{background:var(--surface);border-bottom:1px solid var(--line);padding:10px 24px;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:30;gap:10px}
        .eyebrow{font-size:12px;color:var(--primary);font-weight:700}
        .tsub{font-size:12px;color:var(--muted)}
        .menu-btn{display:none;background:none;border:1px solid var(--line);border-radius:8px;padding:6px 10px;font-size:16px}
        .tright{display:flex;align-items:center;gap:10px}
        .user{position:relative}
        .user-btn{display:flex;align-items:center;gap:10px;background:none;border:0;padding:4px 6px;text-align:right}
        .user-btn b{display:block;font-size:14px}
        .role{display:inline-block;background:var(--soft);color:var(--primary);font-size:11px;font-weight:700;padding:1px 9px;border-radius:99px}
        .avatar{width:38px;height:38px;border-radius:50%;background:var(--primary-d);color:#fff;display:flex;align-items:center;justify-content:center;font-size:16px;font-weight:700}
        [data-theme=dark] .avatar{background:var(--primary)}
        .menu{position:absolute;right:0;top:calc(100% + 6px);background:var(--surface);border:1px solid var(--line);border-radius:12px;box-shadow:0 10px 30px rgba(0,0,0,.18);min-width:220px;overflow:hidden;z-index:50}
        .menu button{display:block;width:100%;text-align:left;padding:11px 14px;background:none;border:0}
        .menu button:hover{background:var(--surface2)}
        .menu form{border-top:1px solid var(--line)}.menu form button{color:var(--bad)}
        .content{padding:22px 24px}
        .ph-head{display:flex;justify-content:space-between;align-items:flex-end;gap:14px;flex-wrap:wrap;margin-bottom:16px}
        .ph-head h1{font-size:24px;margin-top:2px}
        .live{display:inline-block;background:var(--soft);color:var(--primary);font-size:11px;font-weight:700;padding:2px 10px;border-radius:99px;margin-right:8px}
        .chips{display:flex;gap:10px;flex-wrap:wrap}
        .chip{background:var(--surface);border:1px solid var(--line);border-radius:12px;padding:8px 14px;min-width:130px}
        .chip small{display:block;color:var(--muted);font-size:11px}.chip b{font-size:15px}
        .chip.red b{color:var(--bad)}.chip.blue b{color:var(--primary)}
        .grid4{display:grid;grid-template-columns:repeat(auto-fit,minmax(190px,1fr));gap:16px;margin-bottom:18px}
        .grid2{display:grid;grid-template-columns:2fr 1fr;gap:16px;margin-bottom:18px}
        .two{display:grid;grid-template-columns:1fr 1fr;gap:16px}
        .stat{border-left:4px solid var(--primary)}
        .stat .n{font-size:30px;font-weight:700;margin-top:4px}.stat .l{color:var(--muted);font-size:13px}
        .stat.w{border-color:var(--warn)}.stat.i{border-color:var(--info)}.stat.o{border-color:var(--ok)}
        .bar{height:8px;background:var(--line);border-radius:99px;overflow:hidden;margin-top:8px}
        .bar i{display:block;height:100%;background:var(--ok)}
        .chart-wrap{position:relative;height:260px}
        .head{display:flex;justify-content:space-between;align-items:center;gap:10px;margin-bottom:12px;flex-wrap:wrap}
        .head h3{margin:0}.head select{width:auto}
        .toolbar{display:flex;gap:10px;flex-wrap:wrap;align-items:center}
        .sbox{flex:1;min-width:220px;position:relative}
        .sbox input{padding-left:34px;padding-right:32px;background:var(--surface2)}
        .sbox i{position:absolute;left:11px;top:10px;font-style:normal;color:var(--muted)}
        .sbox button{position:absolute;right:6px;top:6px;border:0;background:none;color:var(--muted);font-size:16px}
        .fgrid{display:grid;grid-template-columns:repeat(auto-fit,minmax(170px,1fr));gap:12px;margin-top:6px;align-items:end}
        .fgrid label{margin-top:8px;font-size:11px;letter-spacing:.06em;text-transform:uppercase}
        .range{display:flex;gap:6px}
        .history-filters{display:grid;grid-template-columns:repeat(6,minmax(0,1fr));gap:10px;align-items:end;margin:14px 0}
        .history-filters>div{min-width:0}
        .history-filters label{margin-top:0;font-size:10px}
        .history-filters input,.history-filters select{width:100%;min-width:0}
        .history-filter-actions{display:flex;gap:8px;min-width:0}
        .history-filter-actions .btn{flex:1;min-width:0;white-space:nowrap}
        #p-masuk .fgrid{grid-template-columns:repeat(6,minmax(0,1fr))}
        #p-masuk .fgrid>div{min-width:0}
        #p-masuk .fgrid>div:nth-child(4){grid-column:span 2}
        #p-masuk .range{display:grid;grid-template-columns:repeat(2,minmax(0,1fr))}
        #p-masuk .range input{width:100%;min-width:0;padding-left:8px;padding-right:6px}
        @media(max-width:1100px){#p-masuk .fgrid{grid-template-columns:repeat(auto-fit,minmax(170px,1fr))}}
        @media(max-width:600px){#p-masuk .fgrid{grid-template-columns:minmax(0,1fr)}#p-masuk .fgrid>div:nth-child(4){grid-column:auto}}
        .split{display:grid;grid-template-columns:minmax(0,1fr);gap:16px;align-items:start;margin-top:16px}
        .split.open{grid-template-columns:minmax(0,1fr) 410px}
        .lhead{display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:8px;padding:14px 16px;background:var(--surface2);border-bottom:1px solid var(--line)}
        .lhead .cnt{background:var(--soft);color:var(--primary);font-size:11px;font-weight:700;padding:2px 9px;border-radius:99px;margin-left:8px}
        .lhead select{width:auto;padding:5px 8px;font-size:12px}
        .tcard{padding:0;overflow:hidden}
        .tbl{overflow-x:auto}
        table{width:100%;border-collapse:collapse}
        th,td{text-align:left;padding:11px 12px;border-bottom:1px solid var(--line);vertical-align:top}
        th{font-size:11px;text-transform:uppercase;letter-spacing:.06em;color:var(--muted);background:var(--surface2);white-space:nowrap}
        tbody tr[data-id]{cursor:pointer}
        tbody tr:hover{background:var(--surface2)}
        tbody tr.sel{background:var(--soft)}
        .tk{color:var(--primary)}
        .bulk{display:flex;gap:8px;align-items:center;flex-wrap:wrap;padding:10px 16px;background:var(--soft);border-bottom:1px solid var(--line);font-size:13px}
        .pager{display:flex;justify-content:space-between;align-items:center;gap:8px;flex-wrap:wrap;padding:12px 16px;color:var(--muted);font-size:13px}
        .pager div{display:flex;gap:6px}
        .pager button{min-width:32px;height:32px;border:1px solid var(--line);background:var(--surface);border-radius:8px}
        .pager button.on{background:var(--primary-d);color:#fff;border-color:var(--primary-d)}
        .pager button:disabled{opacity:.4;cursor:not-allowed}
        .sla{display:flex;align-items:center;gap:14px;margin-top:16px}
        .sla .ic{width:40px;height:40px;border-radius:10px;background:var(--soft);display:flex;align-items:center;justify-content:center}
        .sla .pct{margin-left:auto;font-size:22px;font-weight:800;color:var(--primary)}
        #detailWrap{position:sticky;top:78px}
        .panel{background:var(--surface);border:1px solid var(--line);border-top:4px solid var(--bad);border-radius:14px;padding:18px;max-height:calc(100vh - 100px);overflow:auto}
        .panel-top{display:flex;justify-content:space-between;align-items:flex-start;gap:8px;flex-wrap:wrap}
        .pill{display:inline-block;padding:3px 10px;border-radius:99px;font-size:11px;font-weight:700;margin-right:4px}
        .pill.Tinggi{background:rgba(220,38,38,.15);color:var(--bad)}
        .pill.Sedang,.pill.Rendah{background:var(--surface2);color:var(--muted);border:1px solid var(--line)}
        .x{border:0;background:var(--surface2);border-radius:8px;width:30px;height:30px}
        .dt{font-size:19px;margin:10px 0 12px}
        .info{background:var(--surface2);border-radius:12px;padding:12px}
        .g2{display:grid;grid-template-columns:1fr 1fr;gap:10px}
        .info small{display:block;font-size:10px;letter-spacing:.06em;text-transform:uppercase;color:var(--muted);font-weight:700}
        .info b{display:block}.info span{display:block;font-size:12px;color:var(--muted)}
        .info .lnk{color:var(--primary)}.info .late{color:var(--bad);font-weight:600}
        .loc{background:var(--surface);border:1px solid var(--line);border-radius:10px;padding:10px;margin-top:10px}
        .sh{font-size:11px;letter-spacing:.06em;text-transform:uppercase;color:var(--muted);font-weight:700;margin:16px 0 8px}
        .quote{background:var(--surface2);border-radius:12px;padding:14px;line-height:1.6;white-space:pre-line}
        .ph{display:flex;gap:12px;align-items:center;background:var(--soft);border-radius:12px;padding:10px;text-decoration:none;color:var(--text);margin-bottom:8px}
        .ph img{width:86px;height:64px;object-fit:cover;border-radius:8px}
        .ph span{color:var(--primary);font-weight:600;font-size:12px}
        .nophoto{background:var(--surface2);border-radius:12px;padding:12px;color:var(--muted);font-size:13px}
        .proc{background:var(--soft);border:1px solid var(--line);border-radius:12px;padding:14px;margin-top:16px}
        .proc h4{font-size:14px;margin-bottom:6px}
        .opts{display:grid;grid-template-columns:1fr 1fr;gap:8px}
        .opt{text-align:left;background:var(--surface);border:1px solid var(--line);border-radius:10px;padding:10px}
        .opt b{display:block;font-size:12px}.opt small{color:var(--muted);font-size:11px}
        .opt.on{background:var(--primary-d);border-color:var(--primary-d);color:#fff}
        .opt.on small{color:#cbd5e1}
        .row2{display:grid;grid-template-columns:1fr 1fr;gap:10px}
        .acts{display:flex;gap:8px;margin-top:14px}
        .acts .btn{margin-top:0}.acts .grow{flex:1}
        .lnkbtn{margin-top:10px;background:none;border:0;color:var(--bad);font-size:12px}
        .chk{display:flex;gap:8px;align-items:center;font-weight:400;margin-top:12px;color:var(--text);font-size:13px}
        .tl{list-style:none;margin-top:4px}
        .tl li{display:flex;gap:10px;padding:8px 0}
        .dot{width:10px;height:10px;border-radius:50%;background:var(--primary);margin-top:5px;flex-shrink:0}
        .dot.off{background:var(--bd)}
        .tl small,.hist small{color:var(--muted)}
        .hist{list-style:none}
        .hist li{display:flex;gap:12px;padding:12px 0;border-bottom:1px solid var(--line)}
        /* ===== siswa ===== */
        .crumbs{display:flex;justify-content:space-between;align-items:center;font-size:12px;color:var(--muted);margin-bottom:14px;gap:10px;flex-wrap:wrap}
        .crumbs b{color:var(--primary)}
        .who{background:var(--surface);border-radius:99px;padding:4px 12px;font-size:12px;color:var(--text)}
        .hero{margin-bottom:18px}
        .hero .tagl{display:inline-block;background:var(--soft);color:var(--primary);font-size:11px;font-weight:700;padding:4px 10px;border-radius:8px;margin-bottom:12px}
        .hero h1{font-size:26px;color:var(--primary-d);margin-bottom:8px}[data-theme=dark] .hero h1{color:var(--text)}
        .hero p{color:var(--muted);line-height:1.6;max-width:760px}
        .tipbox{background:var(--soft);border-radius:12px;padding:14px 16px;margin-top:14px;font-size:13px;line-height:1.6}
        .tipbox b{display:block;margin-bottom:2px}
        .stu{display:grid;grid-template-columns:minmax(0,1fr) 340px;gap:18px;align-items:start}
        .fsec{margin-bottom:22px}
        .fsec>.t{display:flex;justify-content:space-between;align-items:center;font-weight:700;font-size:14px;margin-bottom:10px}
        .fsec>.t small{font-weight:400;color:var(--muted);font-size:12px}
        .cats{display:grid;grid-template-columns:repeat(auto-fill,minmax(130px,1fr));gap:10px}
        .cats label,.urg label{margin:0;font-weight:500;color:var(--text);font-size:13px}
        .cats input,.urg input{position:absolute;opacity:0;pointer-events:none}
        .cat{display:flex;flex-direction:column;align-items:center;gap:8px;padding:14px 8px;background:var(--surface2);border:2px solid transparent;border-radius:12px;cursor:pointer;text-align:center;font-size:12px;position:relative}
        .cat em{font-style:normal;font-size:20px;background:var(--surface);width:40px;height:40px;border-radius:10px;display:flex;align-items:center;justify-content:center}
        .cats input:checked+.cat{border-color:var(--primary);background:var(--soft);color:var(--primary);font-weight:700}
        .urg{display:grid;grid-template-columns:repeat(3,1fr);gap:10px}
        .ucard{display:block;padding:12px;border:2px solid var(--line);border-radius:12px;cursor:pointer;font-size:12px;line-height:1.5;color:var(--muted);height:100%}
        .ucard b{display:block;color:var(--text);font-size:13px;margin-bottom:4px}
        .urg input:checked+.ucard{border-color:var(--primary);background:var(--soft)}
        .urg .hi input:checked+.ucard{border-color:var(--bad);background:rgba(220,38,38,.1)}
        .urg .hi input:checked+.ucard b{color:var(--bad)}
        .drop{border:2px dashed var(--bd);border-radius:14px;padding:26px 14px;text-align:center;background:var(--surface2);cursor:pointer}
        .drop.over{border-color:var(--primary);background:var(--soft)}
        .drop .ic{width:46px;height:46px;border-radius:50%;background:var(--surface);display:flex;align-items:center;justify-content:center;margin:0 auto 10px;font-size:20px}
        .drop a{cursor:pointer;text-decoration:underline}
        .files{margin-top:12px}
        .file{display:flex;align-items:center;gap:12px;background:var(--soft);border-radius:12px;padding:8px 12px;margin-top:8px}
        .file img{width:46px;height:46px;border-radius:8px;object-fit:cover;background:var(--surface)}
        .file div{flex:1;min-width:0;font-size:12px}
        .file b{display:block;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
        .file button{border:0;background:none;color:var(--muted);font-size:16px}
        .decl{display:flex;gap:10px;align-items:flex-start;background:var(--soft);border-radius:12px;padding:14px;font-size:13px;line-height:1.5;font-weight:400;color:var(--text);margin:0}
        .fbtn{display:flex;justify-content:space-between;gap:12px;margin-top:20px;flex-wrap:wrap}
        .fbtn .btn{margin-top:0}
        .side-c .card{margin-bottom:16px}
        .step{display:flex;gap:12px;margin-top:14px}
        .step i{width:26px;height:26px;border-radius:50%;background:var(--primary-d);color:#fff;font-style:normal;font-size:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
        .step.dim i{background:var(--surface2);color:var(--muted)}
        .step b{display:block;font-size:13px}.step span{font-size:12px;color:var(--muted);line-height:1.5}
        .duty{display:flex;justify-content:space-between;gap:8px;align-items:center;font-size:11px;font-weight:700;letter-spacing:.06em;color:var(--muted);margin-bottom:10px}
        .duty span{background:var(--soft);color:var(--primary);border-radius:99px;padding:3px 10px;letter-spacing:0}
        .tech{display:flex;gap:10px;align-items:center;background:var(--soft);border-radius:12px;padding:10px;margin-bottom:8px;font-size:13px}
        .tech .avatar{width:36px;height:36px}
        .note{background:var(--soft);border-radius:12px;padding:12px;font-size:12px;line-height:1.6;color:var(--muted)}
        .faq{background:var(--soft);border-radius:12px;padding:12px;margin-bottom:8px;font-size:12px;line-height:1.6;color:var(--muted)}
        .faq b{display:block;color:var(--text);font-size:12px}
        .tabs2{display:flex;gap:8px;align-items:center;flex-wrap:wrap;padding:8px}
        .tabs2 button{border:0;background:none;padding:10px 16px;border-radius:10px;font-weight:600;color:var(--muted);display:flex;gap:8px;align-items:center}
        .tabs2 button.on{background:var(--soft);color:var(--primary)}
        .tabs2 .c{background:var(--surface2);border-radius:99px;padding:1px 8px;font-size:11px}
        .tabs2 button.on .c{background:var(--primary-d);color:#fff}
        .tabs2 .sbox{margin-left:auto;min-width:220px;flex:0 1 280px}
        .lacak{display:grid;grid-template-columns:minmax(0,420px) minmax(0,1fr);gap:18px;align-items:start;margin-top:16px}
        .lh{display:flex;justify-content:space-between;font-size:11px;font-weight:700;letter-spacing:.06em;color:var(--muted);margin-bottom:10px}
        .tk2{background:var(--surface);border:1px solid var(--line);border-radius:14px;padding:14px;margin-bottom:12px;cursor:pointer;border-left:4px solid transparent}
        .tk2:hover{background:var(--surface2)}
        .tk2.sel{border-left-color:var(--primary);box-shadow:0 4px 14px rgba(29,78,216,.12)}
        .tk2 .r{display:flex;justify-content:space-between;align-items:center;gap:8px;font-size:12px;margin-bottom:8px}
        .tk2 h4{font-size:15px;margin-bottom:6px}
        .tk2 p{font-size:12px;color:var(--muted);line-height:1.5;margin-bottom:8px}
        .tk2 .f{display:flex;justify-content:space-between;font-size:12px;color:var(--muted)}
        .dpanel{background:var(--surface);border:1px solid var(--line);border-radius:14px;padding:22px}
        .dpanel h2{font-size:22px;margin:12px 0}
        .tkb{display:inline-block;background:var(--primary-d);color:#fff;font-weight:700;font-size:12px;padding:5px 12px;border-radius:8px;margin-right:6px}
        [data-theme=dark] .tkb{background:var(--primary)}
        .chp{display:inline-flex;gap:6px;align-items:center;background:var(--soft);border-radius:99px;padding:6px 12px;font-size:12px;margin:0 6px 8px 0}
        .tlv{position:relative;margin-top:14px}
        .ts{display:flex;gap:14px;position:relative;padding-bottom:22px}
        .ts::before{content:"";position:absolute;left:15px;top:32px;bottom:0;width:2px;background:var(--line)}
        .ts:last-child::before{display:none}
        .ts.done::before{background:var(--primary)}
        .ts .ic{width:32px;height:32px;border-radius:50%;background:var(--surface2);color:var(--muted);display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:14px;z-index:1}
        .ts.done .ic,.ts.cur .ic{background:var(--primary-d);color:#fff}
        [data-theme=dark] .ts.done .ic,[data-theme=dark] .ts.cur .ic{background:var(--primary)}
        .ts.rej .ic{background:var(--bad);color:#fff}
        .ts .bd{flex:1;min-width:0}
        .ts .hd{display:flex;justify-content:space-between;gap:8px;flex-wrap:wrap;font-weight:700}
        .ts .hd small{font-weight:600;color:var(--muted);font-size:12px}
        .ts p{font-size:13px;color:var(--muted);line-height:1.6;margin-top:4px}
        .ts.pend{opacity:.6}
        .tbox{background:var(--soft);border-radius:12px;padding:12px;margin-top:10px}
        .tbox .who2{display:flex;gap:10px;align-items:center;margin-bottom:10px}
        .diag{background:var(--surface);border-radius:10px;padding:10px;font-size:13px;line-height:1.6}
        .diag b{display:block;color:var(--primary);font-size:11px;letter-spacing:.04em;margin-bottom:4px}
        .eta{display:flex;justify-content:space-between;font-size:12px;color:var(--muted);margin-top:10px}.eta b{color:var(--primary)}
        .att{background:var(--surface2);border-radius:12px;padding:14px;margin-top:6px}
        .att .thumbs{display:flex;gap:10px;flex-wrap:wrap;margin-top:10px}
        .att img{width:90px;height:68px;object-fit:cover;border-radius:8px;border:1px solid var(--line)}
        .bhelp{display:flex;gap:10px;margin-top:14px;flex-wrap:wrap}
        .bhelp .btn{margin-top:0}
        .modal-bg{position:fixed;inset:0;background:rgba(15,23,42,.55);display:flex;align-items:center;justify-content:center;padding:16px;z-index:90}
        .modal{background:var(--surface);border-radius:14px;padding:22px;width:100%;max-width:440px}
        .modal h3{margin-bottom:8px}.modal p{color:var(--muted);line-height:1.6}
        .rw-stats{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:12px;margin:16px 0}
        .rw-stat{background:var(--surface);border:1px solid var(--line);border-radius:14px;padding:16px}
        .rw-stat span{display:block;color:var(--muted);font-size:12px}.rw-stat b{display:block;font-size:24px;margin-top:5px}
        .rw-filters{display:grid;grid-template-columns:minmax(180px,2fr) repeat(3,minmax(130px,1fr)) auto;gap:10px;align-items:end}
        .rw-filters label{display:block;font-size:12px;color:var(--muted);margin-bottom:5px}
        .rw-timeline{list-style:none;padding:0;margin:0}
        .rw-day{font-size:13px;font-weight:700;color:var(--muted);margin:18px 0 10px}
        .rw-item{display:flex;width:100%;gap:12px;text-align:left;background:transparent;border:0;padding:0 0 18px;cursor:pointer;color:var(--text)}
        .rw-rail{position:relative;display:flex;justify-content:center;width:18px;flex:0 0 18px}
        .rw-rail:after{content:"";position:absolute;top:15px;bottom:-3px;width:2px;background:var(--line)}
        .rw-item:last-child .rw-rail:after{display:none}
        .rw-dot{width:12px;height:12px;border-radius:50%;background:var(--primary);margin-top:3px;z-index:1}
        .rw-dot.Menunggu{background:var(--warn)}.rw-dot.Selesai{background:var(--ok)}.rw-dot.Ditolak{background:var(--bad)}.rw-dot.Diproses{background:var(--info)}
        .rw-body{flex:1;min-width:0;background:var(--surface);border:1px solid var(--line);border-radius:12px;padding:13px}
        .rw-body:hover{border-color:var(--primary)}
        .rw-meta{display:flex;gap:8px;align-items:center;justify-content:space-between;flex-wrap:wrap}
        .rw-body h3{font-size:14px;margin:8px 0 4px}.rw-body p{margin:0;color:var(--muted);font-size:13px;line-height:1.5}
        .rw-note{margin-top:8px!important;color:var(--text)!important}
        .rw-empty{padding:30px;text-align:center;color:var(--muted)}
        .md-modal{max-width:760px;max-height:calc(100vh - 32px);overflow:auto}
        .md-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:12px}
        .md-field{min-width:0}.md-field.md-wide{grid-column:1/-1}
        .md-field>label{display:block;font-size:12px;font-weight:600;margin-bottom:5px}
        .md-cats{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:8px}
        .md-cat{border:1px solid var(--line);border-radius:10px;padding:9px;text-align:center;cursor:pointer;font-size:12px}
        .md-cat.on{border-color:var(--primary);background:var(--soft);color:var(--primary)}
        .md-photo-list{display:flex;gap:8px;flex-wrap:wrap}
        .md-photo{width:112px;border:1px solid var(--line);border-radius:10px;padding:6px;position:relative}
        .md-photo img{width:100%;height:68px;object-fit:cover;border-radius:6px}
        .md-photo button{width:100%;margin-top:5px;padding:5px;border:0;border-radius:6px;background:var(--soft);color:var(--bad);cursor:pointer}
        .md-processed{font-size:12px;color:var(--muted);align-self:center}
        .md-actions{display:flex;justify-content:flex-end;gap:8px;margin-top:16px;flex-wrap:wrap}
        .md-modal .err{font-size:12px;min-height:0}
        .md-edit{border:1px solid var(--line);border-radius:11px;padding:12px;margin:12px 0}
        .md-edit summary{cursor:pointer;font-weight:700;color:var(--primary)}
        .md-student-results{position:absolute;z-index:5;left:0;right:0;top:100%;background:var(--surface);border:1px solid var(--line);border-radius:10px;box-shadow:0 10px 24px rgba(15,23,42,.14);max-height:200px;overflow:auto}
        .md-student-wrap{position:relative}
        .md-student-results button{display:block;width:100%;text-align:left;padding:9px 12px;border:0;background:transparent;color:var(--text);cursor:pointer}
        .md-student-results button:hover{background:var(--soft)}
        .um-tabs{display:flex;gap:8px;margin:16px 0}
        .um-tabs button{border:1px solid var(--line);border-radius:10px;background:var(--surface);padding:9px 14px;color:var(--muted);cursor:pointer}
        .um-tabs button.on{background:var(--primary);border-color:var(--primary);color:#fff}
        .um-count{font-size:11px;margin-left:6px}
        .um-toolbar{display:grid;grid-template-columns:minmax(220px,1fr) minmax(160px,240px);gap:10px;margin-bottom:12px}
        .um-table-wrap{overflow-x:auto}
        .um-table{min-width:720px}
        .um-person{display:flex;gap:9px;align-items:center;min-width:150px}
        .um-person .avatar{width:34px;height:34px}
        .um-actions{display:flex;gap:5px;flex-wrap:wrap}
        .um-modal{max-width:620px;max-height:calc(100vh - 32px);overflow:auto}
        .um-password{display:flex;gap:8px;align-items:center}
        .um-password input{flex:1}
        .um-confirm-row{display:flex;justify-content:flex-end;gap:8px;margin-top:18px}
        @media(max-width:900px){.rw-filters{grid-template-columns:repeat(2,minmax(0,1fr))}.rw-filters .sbox{grid-column:1/-1}.rw-stats{grid-template-columns:repeat(2,minmax(0,1fr))}}
        @media(max-width:600px){.rw-filters{grid-template-columns:1fr}.rw-filters .sbox{grid-column:auto}.rw-stats{gap:8px}.rw-stat{padding:12px}.rw-stat b{font-size:20px}.md-modal,.um-modal{width:100%;padding:16px}.md-grid{grid-template-columns:1fr}.md-field.md-wide{grid-column:auto}.md-cats{grid-template-columns:repeat(2,minmax(0,1fr))}.um-toolbar{grid-template-columns:1fr}.um-tabs{overflow-x:auto}.history-filters{grid-template-columns:1fr}}
        @media(max-width:1100px){
            .split.open{grid-template-columns:minmax(0,1fr)}
            #detailWrap{position:fixed;inset:0;z-index:70;background:rgba(15,23,42,.55);padding:12px;overflow:auto;top:0}
            .panel{max-height:none;max-width:480px;margin:0 auto}
            .stu,.lacak{grid-template-columns:1fr}
            .history-filters{grid-template-columns:repeat(auto-fit,minmax(170px,1fr))}
        }
        @media(max-width:900px){
            aside{position:fixed;left:-270px;transition:left .2s}aside.open{left:0}
            .menu-btn{display:block}.grid2,.two,.g2c,.urg{grid-template-columns:1fr}.content{padding:14px}header.top{padding:10px 14px}.tsub{display:none}
            .gcard{padding:22px}
        }
        @media print{aside,header.top,.noprint,.pager,#detailWrap,.bulk,.gfoot{display:none!important}.content{padding:0}.card{border:0}.split{display:block}}
    </style>
@endverbatim
</head>
<body>
@php
    $user    = auth()->user();
    $isAdmin = $user && $user->role === 'admin';
@endphp

@guest
{{-- ===================== TAMU: LOGIN & DAFTAR ===================== --}}
@php
    $showReg = old('_form') === 'register' || $errors->has('nis') || $errors->has('kelas') || $errors->has('name') || $errors->has('email');
    $levels  = ['X', 'XI', 'XII'];
    $majors  = ['MIPA 1', 'MIPA 2', 'MIPA 3', 'MIPA 4', 'IPS 1', 'IPS 2', 'IPS 3'];
    $hasEmail = $hasEmail ?? false;
@endphp
<div class="gwrap">
    {{-- LOGIN --}}
    <div class="gcard {{ $showReg ? 'hidden' : '' }}" id="cLogin">
        <div class="ghead"><div class="logo">S</div><div><b>SIPRASKA</b><small data-i18n="g.brand">Sistem Pengaduan Sarana</small></div></div>
        <h1 data-i18n="g.login_t">Masuk ke Portal</h1>
        <p class="sub" data-i18n="g.login_s">Gunakan kredensial resmi sekolah untuk melanjutkan pengaduan atau tindak lanjut.</p>

        @if (session('success')) <div class="alert ok">{{ session('success') }}</div> @endif

        <form method="POST" action="{{ route('login.store') }}">
            @csrf
            <input type="hidden" name="_form" value="login">
            <div class="rtabs">
                <label><input type="radio" name="role" value="siswa" {{ old('role', 'siswa') === 'siswa' ? 'checked' : '' }}><span>👤 <span data-i18n="g.tab_s">Siswa</span></span></label>
                <label><input type="radio" name="role" value="admin" {{ old('role') === 'admin' ? 'checked' : '' }}><span>🛡 <span data-i18n="g.tab_a">Petugas / Admin</span></span></label>
            </div>
            <label id="lblId" data-i18n="g.id_s">NISN / Nomor Induk Siswa</label>
            <div class="inp"><i>🪪</i><input name="identity" value="{{ old('identity') }}" required autofocus autocomplete="username"></div>
            <div class="hint" id="hintId" data-i18n="g.hint_s">Gunakan nomor induk aktif Anda yang terdaftar di sekolah.</div>
            @error('identity') <div class="err">{{ $message }}</div> @enderror

            <label data-i18n="g.pass">Kata Sandi</label>
            <div class="inp"><i>🔒</i><input type="password" id="lpass" name="password" required autocomplete="current-password"><button type="button" class="eye" data-eye="lpass">👁</button></div>
            @error('password') <div class="err">{{ $message }}</div> @enderror

            <div class="row-b">
                <label><input type="checkbox" name="remember" value="1"> <span data-i18n="g.remember">Ingat saya di perangkat ini</span></label>
                <a href="#" id="bForgot" data-i18n="g.forgot">Lupa Sandi?</a>
            </div>
            <div class="forgot hidden" id="forgotBox" data-i18n="g.forgot_m">Hubungi admin sarpras sekolah untuk mengatur ulang kata sandi Anda.</div>
            <button class="btn full" style="padding:13px"><span data-i18n="g.login_b">Masuk Sekarang</span></button>
        </form>
        <p class="center" id="regLine"><span data-i18n="g.noacc">Belum memiliki akun?</span> <a href="#" id="toReg" data-i18n="g.reg_l">Daftar Akun Baru</a></p>
    </div>

    {{-- REGISTER --}}
    <div class="gcard wide {{ $showReg ? '' : 'hidden' }}" id="cReg">
        <div class="ghead"><div class="logo">S</div><div><b>SIPRASKA</b><small data-i18n="g.brand">Sistem Pengaduan Sarana</small></div></div>
        <h1 data-i18n="g.reg_t">Registrasi Akun Siswa</h1>
        <p class="sub" data-i18n="g.reg_s">Daftarkan identitas resmi Anda untuk memantau laporan kerusakan secara transparan.</p>

        <form method="POST" action="{{ route('register.store') }}" id="fReg">
            @csrf
            <input type="hidden" name="_form" value="register">
            <label data-i18n="g.nis">NISN / Nomor Induk Siswa</label>
            <div class="inp"><i>🪪</i><input name="nis" value="{{ old('nis') }}" maxlength="20" inputmode="numeric" required></div>
            @error('nis') <div class="err">{{ $message }}</div> @enderror

            <div class="g2c">
                <div>
                    <label data-i18n="g.name">Nama Lengkap Siswa</label>
                    <div class="inp"><i>👤</i><input name="name" value="{{ old('name') }}" data-i18n-ph="g.name_ph" placeholder="Nama sesuai buku induk siswa" required></div>
                    @error('name') <div class="err">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label data-i18n="g.class">Kelas & Jurusan</label>
                    <div class="inp"><i>🎓</i>
                        <select name="kelas" required>
                            <option value="" data-i18n="g.class_ph">Pilih Rombel</option>
                            @foreach ($levels as $lv)
                                @foreach ($majors as $m)
                                    <option value="{{ $lv . ' ' . $m }}" @selected(old('kelas') === $lv . ' ' . $m)>{{ $lv . ' ' . $m }}</option>
                                @endforeach
                            @endforeach
                        </select>
                    </div>
                    @error('kelas') <div class="err">{{ $message }}</div> @enderror
                </div>
            </div>

            @if ($hasEmail)
                <label data-i18n="g.email">Email (opsional)</label>
                <div class="inp"><i>✉</i><input type="email" name="email" value="{{ old('email') }}"></div>
                @error('email') <div class="err">{{ $message }}</div> @enderror
            @endif

            <div class="g2c">
                <div>
                    <label data-i18n="g.pass_n">Kata Sandi</label>
                    <div class="inp"><i>🔒</i><input type="password" id="rpass" name="password" minlength="8" data-i18n-ph="g.pass_ph" placeholder="Min. 8 karakter" required autocomplete="new-password"><button type="button" class="eye" data-eye="rpass">👁</button></div>
                    <div class="meter"><i id="meter"></i></div>
                    <div class="hint"><span data-i18n="g.strength">Kekuatan Sandi</span>: <b id="meterTxt">—</b></div>
                    @error('password') <div class="err">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label data-i18n="g.pass_c">Konfirmasi Kata Sandi</label>
                    <div class="inp"><i>🔁</i><input type="password" id="rcon" name="password_confirmation" data-i18n-ph="g.pass_cph" placeholder="Ulangi kata sandi" required autocomplete="new-password"><button type="button" class="eye" data-eye="rcon">👁</button></div>
                    <div class="hint" id="matchTxt" data-i18n="g.match">Pastikan sandi sama persis</div>
                </div>
            </div>

            <label class="chk" style="margin-top:16px"><input type="checkbox" required> <span data-i18n="g.terms">Saya menyatakan informasi ini benar sebagai siswa aktif sekolah ini.</span></label>
            <button class="btn full" style="padding:13px"><span data-i18n="g.reg_b">Daftar Akun Baru</span></button>
        </form>
        <p class="center"><span data-i18n="g.have">Sudah memiliki akun aktif?</span> <a href="#" id="toLogin" data-i18n="g.back">Masuk ke Akun Anda</a></p>
    </div>

    <div class="gfoot">
        <span data-i18n="g.footer">Portal Resmi Pengaduan Sarana Prasarana Sekolah</span>
        <div class="gctl"><div class="lang"><button type="button" data-lang="id">ID</button><button type="button" data-lang="en">EN</button></div><button type="button" class="switch" data-theme-toggle aria-pressed="false" aria-label="Tema"></button></div>
    </div>
</div>
@verbatim
<script>
(function(){
    var $=function(s){return document.querySelector(s)};
    var cL=$('#cLogin'),cR=$('#cReg');
    function show(reg){cL.classList.toggle('hidden',reg);cR.classList.toggle('hidden',!reg)}
    $('#toReg').onclick=function(e){e.preventDefault();show(true)};
    $('#toLogin').onclick=function(e){e.preventDefault();show(false)};
    $('#bForgot').onclick=function(e){e.preventDefault();$('#forgotBox').classList.toggle('hidden')};
    document.querySelectorAll('[data-eye]').forEach(function(b){b.onclick=function(){var i=document.getElementById(b.getAttribute('data-eye'));i.type=i.type==='password'?'text':'password'}});

    // Tab Siswa / Admin: ganti label & petunjuk
    function role(){
        var admin=document.querySelector('input[name=role]:checked').value==='admin';
        var l=$('#lblId'),h=$('#hintId');
        l.setAttribute('data-i18n',admin?'g.id_a':'g.id_s');h.setAttribute('data-i18n',admin?'g.hint_a':'g.hint_s');
        $('#regLine').classList.toggle('hidden',admin);
        SP.apply();
    }
    document.querySelectorAll('input[name=role]').forEach(function(r){r.onchange=role});
    document.addEventListener('DOMContentLoaded',role);

    // Kekuatan & kecocokan sandi
    function strength(v){var s=0;if(v.length>=8)s++;if(/[A-Z]/.test(v)&&/[a-z]/.test(v))s++;if(/\d/.test(v)&&/[^A-Za-z0-9]/.test(v)||v.length>=12)s++;return s}
    function meter(){
        var v=$('#rpass').value,s=v?Math.max(1,strength(v)):0,m=$('#meter');
        m.style.width=(s*33.4)+'%';m.style.background=s<=1?'#dc2626':(s===2?'#d97706':'#16a34a');
        $('#meterTxt').textContent=s?SP.t('g.s'+s):'—';
        var c=$('#rcon').value;
        $('#matchTxt').textContent=c&&c!==v?SP.t('g.mismatch'):SP.t('g.match');
        $('#matchTxt').style.color=c&&c!==v?'#dc2626':'';
    }
    $('#rpass').oninput=meter;$('#rcon').oninput=meter;document.addEventListener('splang',meter);
    $('#fReg').addEventListener('submit',function(e){if($('#rpass').value!==$('#rcon').value){e.preventDefault();meter();$('#rcon').focus()}});
})();
</script>
@endverbatim

@else
@if (! $isAdmin)
{{-- ===================== SISWA ===================== --}}
@php
    $mine      = $mine ?? [];
    $petugas   = $petugas ?? [];
    $school    = config('app.school_name', 'SMA Negeri 1 Harapan');
    $catIcons  = ['Ruang Kelas' => '🚪', 'Toilet & Sanitasi' => '🚻', 'Laboratorium' => '🧪', 'AC & Kelistrikan' => '❄️', 'Lapangan Olahraga' => '🏀', 'IT & Jaringan' => '📶', 'Perpustakaan' => '📚', 'Lainnya' => '🔧'];
    $gedungs   = ['Gedung A', 'Gedung B', 'Gedung C', 'Gedung Utama', 'Lapangan / Area Luar', 'Perpustakaan', 'Kantin', 'Masjid / Mushola', 'Lainnya'];
    $stuData   = [
        'mine' => $mine,
        'open' => session('open'),
        'csrf' => csrf_token(),
        'kategori' => \App\Models\Complaint::KATEGORI,
        'gedungs' => $gedungs,
        'routes' => [
            'update' => route('complaint.update', ['complaint' => '__ID__']),
            'destroy' => route('complaint.destroy', ['complaint' => '__ID__']),
        ],
    ];
@endphp
<div id="app">
    <aside id="side">
        <div class="brand"><div class="logo">S</div><div><b>SIPRASKA</b><small>{{ $school }}</small></div></div>
        <div class="sec" data-i18n="u.menu">PORTAL SISWA</div>
        <button class="nav active" data-page="buat" type="button">⊕ <span data-i18n="u.buat">Buat Laporan</span></button>
        <button class="nav" data-page="lacak" type="button">📈 <span data-i18n="u.lacak">Lacak Status</span> <span class="badge" id="navCnt">0</span></button>
        <button class="nav" data-page="riwayat" type="button">🕘 <span data-i18n="u.history">Riwayat</span></button>
        <button class="nav" data-page="profil" type="button">👤 <span data-i18n="u.profil">Profil Siswa</span></button>
        <div class="side-foot">
            <div class="frow"><span data-i18n="lang">Bahasa</span><div class="lang"><button type="button" data-lang="id">ID</button><button type="button" data-lang="en">EN</button></div></div>
            <div class="frow"><span data-i18n="theme">Tema Tampilan</span><button type="button" class="switch" data-theme-toggle aria-pressed="false" aria-label="Tema"></button></div>
        </div>
    </aside>

    <div class="main">
        <header class="top">
            <div style="display:flex;align-items:center;gap:10px">
                <button class="menu-btn" id="menuBtn" type="button">☰</button>
                <div><div class="eyebrow">SIPRASKA PORTAL <span class="m">• {{ $school }}</span></div><div class="tsub" data-i18n="top.sub">Sistem Informasi Manajemen Sarana & Prasarana Terpadu</div></div>
            </div>
            <div class="tright">
                <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="btn ghost sm" style="color:var(--bad)">⏻ <span data-i18n="logout">Keluar</span></button></form>
                <div class="user"><span class="user-btn" style="cursor:default"><span><b>{{ $user->name }}</b><span class="role" data-i18n="u.role">Siswa</span></span><span class="avatar">{{ strtoupper(mb_substr($user->name, 0, 1)) }}</span></span></div>
            </div>
        </header>

        <div class="content">
            {{-- ===== BUAT LAPORAN ===== --}}
            <section id="p-buat">
                <div class="crumbs"><span><span data-i18n="u.menu">PORTAL SISWA</span> › <b data-i18n="u.crumb">FORM PENGADUAN BARU</b></span><span class="who">● {{ $user->name }} ({{ $user->kelas }})</span></div>

                <div class="card hero">
                    <span class="tagl" data-i18n="u.badge">FASILITAS & INFRASTRUKTUR SEKOLAH</span>
                    <h1 data-i18n="u.h1">Buat Laporan Pengaduan Sarana & Prasarana</h1>
                    <p data-i18n="u.lead">Sampaikan keluhan atau kerusakan fasilitas sekolah secara cepat, transparan, dan dapat dipantau langsung perkembangannya oleh tim sarpras.</p>
                    <div class="tipbox"><b data-i18n="u.tip_t">Tips Pelaporan Cepat</b><span data-i18n="u.tip">Sertakan foto yang jelas dengan pencahayaan cukup dan cantumkan deskripsi lokasi yang spesifik agar teknisi lapangan dapat langsung menuju titik kerusakan tanpa hambatan.</span></div>
                </div>

                <div class="stu">
                    <form class="card" method="POST" action="{{ route('complaint.store') }}" enctype="multipart/form-data" id="fReport" data-has-old="{{ old('judul') ? '1' : '0' }}" novalidate>
                        @csrf
                        @if ($errors->any())
                            <div class="alert bad">@foreach ($errors->all() as $msg) <div>• {{ $msg }}</div> @endforeach</div>
                        @endif

                        <div class="fsec">
                            <div class="t"><span data-i18n="u.f1">1. Pilih Kategori Sarana / Prasarana</span><small data-i18n="u.req">Wajib dipilih</small></div>
                            <div class="cats">
                                @foreach (\App\Models\Complaint::KATEGORI as $k)
                                    <label><input type="radio" name="kategori" value="{{ $k }}" @checked(old('kategori') === $k)><span class="cat"><em>{{ $catIcons[$k] ?? '🔧' }}</em>{{ $k }}</span></label>
                                @endforeach
                            </div>
                        </div>

                        <div class="fsec">
                            <div class="t"><span data-i18n="u.f2">2. Judul Ringkas Pengaduan</span></div>
                            <input name="judul" value="{{ old('judul') }}" maxlength="150" data-i18n-ph="u.f2ph" placeholder="contoh: Kran air tempat wudhu putra patah" required>
                            <div class="hint" data-i18n="u.f2h">Gunakan kalimat singkat yang langsung menjelaskan masalah utama.</div>
                        </div>

                        <div class="fsec">
                            <div class="t"><span data-i18n="u.f3">3. Lokasi Spesifik Fasilitas</span></div>
                            <div class="g2c">
                                <div><label data-i18n="u.gedung">Gedung / Wilayah Area</label>
                                    <select name="gedung" required>
                                        <option value="" data-i18n="u.gedung_ph">Pilih gedung / wilayah</option>
                                        @foreach ($gedungs as $g) <option @selected(old('gedung') === $g)>{{ $g }}</option> @endforeach
                                    </select></div>
                                <div><label data-i18n="u.detail">Lantai & Detail Ruangan</label><input name="detail" value="{{ old('detail') }}" maxlength="100" data-i18n-ph="u.detail_ph" placeholder="contoh: Lantai 1 - Samping Ruang XI MIPA 2" required></div>
                            </div>
                        </div>

                        <div class="fsec">
                            <div class="t"><span data-i18n="u.f4">4. Tingkat Urgensi Kerusakan</span><small data-i18n="u.one">Pilih satu level</small></div>
                            <div class="urg">
                                <label><input type="radio" name="prioritas" value="Rendah" @checked(old('prioritas') === 'Rendah')><span class="ucard"><b data-i18n="u.pl">Rendah</b><span data-i18n="u.pld">Kerusakan minor & estetika; tidak mengganggu KBM langsung.</span></span></label>
                                <label><input type="radio" name="prioritas" value="Sedang" @checked(old('prioritas', 'Sedang') === 'Sedang')><span class="ucard"><b data-i18n="u.pm">Sedang</b><span data-i18n="u.pmd">Cukup mengganggu kenyamanan dan aktivitas kelas/siswa.</span></span></label>
                                <label class="hi"><input type="radio" name="prioritas" value="Tinggi" @checked(old('prioritas') === 'Tinggi')><span class="ucard"><b>⚠ <span data-i18n="u.ph">Tinggi / Mendesak</span></b><span data-i18n="u.phd">Air meluber, korsleting, atau berpotensi bahaya keselamatan siswa.</span></span></label>
                            </div>
                        </div>

                        <div class="fsec">
                            <div class="t"><span data-i18n="u.f5">5. Unggah Foto Bukti Kerusakan</span><small id="fileCnt"></small></div>
                            <div class="drop" id="drop">
                                <div class="ic">📷</div>
                                <div><span data-i18n="u.drop">Tarik & lepas foto bukti di sini, atau</span> <a data-i18n="u.pick">Klik untuk Memilih File</a></div>
                                <div class="hint" data-i18n="u.drop_h">Mendukung file JPG, PNG, atau HEIC (Maksimal 5MB per berkas, hingga 3 foto)</div>
                            </div>
                            <input type="file" name="fotos[]" id="fileInput" accept="image/*,.heic,.heif" multiple class="hidden">
                            <div class="files" id="files"></div>
                        </div>

                        <div class="fsec">
                            <div class="t"><span data-i18n="u.f6">6. Deskripsi Rinci Kerusakan</span><small><span id="descCnt">0</span>/30 · <span data-i18n="u.min30">Minimal 30 karakter</span></small></div>
                            <textarea name="isi" id="isi" rows="5" maxlength="2000" data-i18n-ph="u.descph" placeholder="Jelaskan kronologi, kondisi, dan dampak kerusakan..." required>{{ old('isi') }}</textarea>
                        </div>

                        <label class="decl"><input type="checkbox" name="pernyataan" value="1" id="decl" @checked(old('pernyataan'))> <span data-i18n="u.decl">Saya menyatakan bahwa informasi, rincian lokasi, dan foto bukti pengaduan ini adalah benar adanya sesuai kondisi di lapangan serta dapat dipertanggungjawabkan kepada pihak sekolah.</span></label>

                        <div class="fbtn">
                            <button type="button" class="btn ghost" id="bDraft" style="padding:12px 18px">🗂 <span data-i18n="u.draft">Simpan sebagai Draf</span></button>
                            <button type="submit" class="btn" style="padding:12px 22px"><span data-i18n="u.send">Kirim Pengaduan Sekarang</span> ➤</button>
                        </div>
                    </form>

                    <div class="side-c">
                        <div class="card">
                            <div style="display:flex;gap:12px;align-items:center"><div class="logo">⚙</div><div><b style="font-size:16px" data-i18n="u.flow">Alur Penanganan</b><div class="m" style="font-size:12px" data-i18n="u.flow_s">Standar Operasional Sarpras</div></div></div>
                            <div class="step"><i>1</i><div><b data-i18n="u.s1">1. Laporan Masuk</b><span data-i18n="u.s1d">Laporan siswa otomatis dicatat dalam database terintegrasi SIPRASKA.</span></div></div>
                            <div class="step dim"><i>2</i><div><b data-i18n="u.s2">2. Verifikasi Tim</b><span data-i18n="u.s2d">Petugas memvalidasi tingkat urgensi dan ketersediaan suku cadang.</span></div></div>
                            <div class="step dim"><i>3</i><div><b data-i18n="u.s3">3. Pengerjaan Teknisi</b><span data-i18n="u.s3d">Teknisi lapangan dikirim langsung ke lokasi untuk perbaikan.</span></div></div>
                            <div class="step dim"><i>4</i><div><b data-i18n="u.s4">4. Konfirmasi Selesai</b><span data-i18n="u.s4d">Foto hasil perbaikan diunggah; notifikasi sukses terkirim ke siswa.</span></div></div>
                        </div>
                        <div class="card">
                            <div class="duty"><span style="background:none;padding:0;color:var(--muted)" data-i18n="u.duty">PETUGAS SIAGA HARI INI</span>@if (count($petugas)) <span id="dutyN" data-n="{{ count($petugas) }}"></span> @endif</div>
                            @forelse ($petugas as $p)
                                <div class="tech"><span class="avatar">{{ strtoupper(mb_substr($p, 0, 1)) }}</span><div><b>{{ $p }}</b><div class="m" style="font-size:12px" data-i18n="u.tech">Teknisi Sarpras</div></div></div>
                            @empty
                                <div class="note" data-i18n="u.duty_none">Belum ada petugas yang sedang menangani laporan.</div>
                            @endforelse
                            <div class="note" style="margin-top:10px" data-i18n="u.urgent">Butuh bantuan darurat saat jam pelajaran? Laporkan langsung ke pos piket satpam gerbang utama atau ruang TU Sarpras.</div>
                        </div>
                        <div class="card" id="faq">
                            <div class="duty"><span style="background:none;padding:0;color:var(--primary)" data-i18n="u.faq">PERTANYAAN UMUM (FAQ)</span></div>
                            <div class="faq"><b data-i18n="u.q1">Berapa lama laporan ditindaklanjuti?</b><span data-i18n="u.a1">Laporan kategori tinggi ditangani dalam 1–3 jam, sedangkan perbaikan minor ditargetkan maksimal 1x24 jam kerja.</span></div>
                            <div class="faq"><b data-i18n="u.q2">Apakah laporan saya anonim?</b><span data-i18n="u.a2">Nama dan kelas dicatat agar admin dapat meminta detail titik lokasi bila diperlukan verifikasi fisik.</span></div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- ===== LACAK STATUS ===== --}}
            <section id="p-lacak" class="hidden">
                <div class="ph-head">
                    <div><span class="live" data-i18n="u.te">PELACAKAN REAL-TIME</span><h1 data-i18n="u.th">Laporan Pengaduan Saya</h1><p class="m" style="max-width:640px;margin-top:6px;line-height:1.6" data-i18n="u.ts">Pantau status verifikasi, jadwal pengerjaan teknisi, dan riwayat penyelesaian fasilitas yang Anda laporkan secara transparan.</p></div>
                    <button class="btn" type="button" id="bNew" style="margin-top:0">⊕ <span data-i18n="u.new">Buat Pengaduan Baru</span></button>
                </div>
                <div class="card" style="padding:6px">
                    <div class="tabs2" id="tabs2">
                        <button type="button" data-tab="all" class="on"><span data-i18n="u.t_all">Semua Pengaduan</span> <span class="c" id="cAll">0</span></button>
                        <button type="button" data-tab="proc"><span data-i18n="u.t_proc">Dalam Proses</span> <span class="c" id="cProc">0</span></button>
                        <button type="button" data-tab="done"><span data-i18n="u.t_done">Selesai</span> <span class="c" id="cDone">0</span></button>
                        <button type="button" data-tab="rej"><span data-i18n="u.t_rej">Ditolak</span> <span class="c" id="cRej">0</span></button>
                        <div class="sbox"><i>⌕</i><input id="qTk" data-i18n-ph="u.search" placeholder="Cari tiket atau fasilitas…"></div>
                    </div>
                </div>
                <div class="lacak">
                    <div>
                        <div class="lh"><span><span data-i18n="u.list">DAFTAR TIKET ANDA</span> (<span id="lCnt">0</span>)</span><span data-i18n="u.sort">Urut Berdasarkan: Terbaru</span></div>
                        <div id="tkList"></div>
                        <div class="note"><b style="color:var(--text);display:block" data-i18n="u.ct">Mengalami kendala mendesak?</b><span data-i18n="u.cd">Untuk insiden darurat (korsleting berapi, kebocoran pipa air utama), segera hubungi pos piket Sarpras di Lantai 1 atau ruang Tata Usaha.</span></div>
                    </div>
                    <div id="tkDetail"></div>
                </div>
            </section>

            {{-- ===== RIWAYAT SISWA ===== --}}
            <section id="p-riwayat" class="hidden">
                <div class="ph-head"><div><h1 data-i18n="rw.title">Riwayat Pengaduan Saya</h1><p class="m" style="margin-top:6px" data-i18n="rw.subtitle">Lihat aktivitas terbaru dari seluruh pengaduan Anda.</p></div></div>
                <div class="rw-stats">
                    <div class="rw-stat"><span data-i18n="rw.total">Total aktivitas</span><b id="srTotal">0</b></div>
                    <div class="rw-stat"><span data-i18n="rw.done">Selesai</span><b id="srDone">0</b></div>
                    <div class="rw-stat"><span data-i18n="rw.progress">Dalam proses</span><b id="srProgress">0</b></div>
                    <div class="rw-stat"><span data-i18n="rw.rejected">Ditolak</span><b id="srRejected">0</b></div>
                </div>
                <div class="card">
                    <div class="rw-filters">
                        <div class="sbox"><i>⌕</i><input id="srSearch" data-i18n-ph="rw.search" placeholder="Cari tiket, judul, lokasi, atau catatan…"></div>
                        <div><label for="srStatus" data-i18n="f.status">Status Tiket</label><select id="srStatus"><option value="" data-i18n="rw.status">Semua status</option><option value="Menunggu" data-i18n="st.Menunggu">Menunggu Verifikasi</option><option value="Diterima" data-i18n="st.Diterima">Diterima</option><option value="Diproses" data-i18n="st.Diproses">Sedang Diproses</option><option value="Selesai" data-i18n="st.Selesai">Selesai</option><option value="Ditolak" data-i18n="st.Ditolak">Ditolak</option></select></div>
                        <div><label for="srFrom" data-i18n="rw.from">Dari tanggal</label><input id="srFrom" type="date"></div>
                        <div><label for="srTo" data-i18n="rw.to">Sampai tanggal</label><input id="srTo" type="date"></div>
                        <button class="btn ghost" type="button" id="srReset" data-i18n="rw.reset">Reset</button>
                    </div>
                </div>
                <div class="card" style="margin-top:14px">
                    <div id="srList" class="rw-timeline"></div>
                    <div class="pager" id="srPager"></div>
                </div>
            </section>

            {{-- ===== PROFIL ===== --}}
            <section id="p-profil" class="hidden">
                <div class="ph-head"><div><h1 data-i18n="u.pt">Profil Siswa</h1></div></div>
                @if (session('status') === 'password-updated') <div class="alert ok">✔ Kata sandi berhasil diganti.</div> @endif
                <div class="two" style="align-items:start">
                    <div class="card">
                        <h3 data-i18n="u.pt">Profil Siswa</h3>
                        <label data-i18n="u.pn">Nama</label><input value="{{ $user->name }}" disabled>
                        <label data-i18n="u.pnis">NIS</label><input value="{{ $user->nis }}" disabled>
                        <label data-i18n="u.pk">Kelas</label><input value="{{ $user->kelas }}" disabled>
                    </div>
                    <div class="card">
                        <h3 data-i18n="pw.title">Ganti Kata Sandi</h3>
                        <form method="POST" action="{{ route('account.password') }}" id="pwForm">
                            @csrf @method('PUT')
                            <label data-i18n="pw.old">Sandi Lama</label><input type="password" name="current_password" required autocomplete="current-password">
                            <label data-i18n="pw.new">Sandi Baru (min. 8 karakter)</label><input type="password" name="password" id="pwNew" required autocomplete="new-password">
                            <label data-i18n="pw.con">Konfirmasi Sandi Baru</label><input type="password" name="password_confirmation" id="pwCon" required autocomplete="new-password">
                            <div class="err" id="pwErr">{{ $errors->updatePassword->first() }}</div>
                            <button class="btn" data-i18n="pw.btn">Ganti Sandi</button>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<div class="modal-bg hidden" id="modal"><div class="modal"><h3 id="mT"></h3><p id="mP"></p><div style="text-align:right"><button class="btn" type="button" id="mX" data-i18n="u.close">Tutup</button></div></div></div>
<div class="modal-bg hidden" id="seModal" role="dialog" aria-modal="true" aria-labelledby="seTitle">
    <div class="modal md-modal">
        <h3 id="seTitle" data-i18n="se.title">Ubah Pengaduan</h3>
        <form id="seForm" novalidate>
            <div class="md-grid">
                <div class="md-field md-wide"><label data-i18n="se.category">Kategori</label><div class="md-cats" id="seCategories"></div><div class="err" id="seErrorKategori"></div></div>
                <div class="md-field"><label for="seJudul" data-i18n="se.title_label">Judul pengaduan</label><input id="seJudul" maxlength="150" required><div class="err" id="seErrorJudul"></div></div>
                <div class="md-field"><label for="seGedung" data-i18n="se.building">Gedung / Wilayah</label><select id="seGedung" required></select><div class="err" id="seErrorGedung"></div></div>
                <div class="md-field"><label for="seDetail" data-i18n="se.detail">Lantai & detail ruangan</label><input id="seDetail" maxlength="100" required><div class="err" id="seErrorDetail"></div></div>
                <div class="md-field"><label for="sePrioritas" data-i18n="se.priority">Prioritas</label><select id="sePrioritas"><option value="Tinggi" data-i18n="pr.Tinggi">Tinggi</option><option value="Sedang" data-i18n="pr.Sedang">Sedang</option><option value="Rendah" data-i18n="pr.Rendah">Rendah</option></select><div class="err" id="seErrorPrioritas"></div></div>
                <div class="md-field md-wide"><label for="seIsi" data-i18n="se.description">Deskripsi kerusakan</label><textarea id="seIsi" rows="4" maxlength="2000"></textarea><small class="m"><span id="seCharCount">0</span>/2000</small><div class="err" id="seErrorIsi"></div></div>
                <div class="md-field md-wide"><label data-i18n="se.photos">Foto pengaduan</label><div id="sePhotoList" class="md-photo-list"></div><label for="seFiles" data-i18n="se.add_photos">Tambah foto</label><input type="file" id="seFiles" accept="image/*,.heic,.heif" multiple><small class="m" id="sePhotoCount"></small><div class="err" id="seErrorFotos"></div></div>
            </div>
            <div class="fbtn"><button class="btn ghost" type="button" id="seCancel" data-i18n="se.cancel">Batal</button><button class="btn" type="submit" id="seSave" data-i18n="se.save">Simpan perubahan</button></div>
        </form>
    </div>
</div>
<div class="modal-bg hidden" id="seConfirmModal" role="dialog" aria-modal="true" aria-labelledby="seConfirmTitle">
    <div class="modal"><h3 id="seConfirmTitle" data-i18n="se.delete_title">Hapus pengaduan?</h3><p id="seConfirmText"></p><div class="fbtn"><button class="btn ghost" type="button" id="seDeleteCancel" data-i18n="se.cancel">Batal</button><button class="btn red" type="button" id="seDeleteConfirm" data-i18n="se.confirm_delete">Ya, hapus</button></div></div>
</div>

<script>
    window.STU = {!! json_encode($stuData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!};
    window.FLASH = {!! json_encode(session('success'), JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!};
    window.PW_ERR = {!! json_encode($errors->hasBag('updatePassword') || session('status') === 'password-updated') !!};
</script>
@verbatim
<script>
(function(){
'use strict';
var S=window.STU||{mine:[],open:null},t=SP.t;
var $=function(s){return document.querySelector(s)},$$=function(s){return Array.prototype.slice.call(document.querySelectorAll(s))};
var data=S.mine||[],cur='buat',sel=null,tab='all',qs='',srPage=1,editingComplaint=null,removePhotos=[],editUploads=[],deletingComplaint=null;
function esc(s){return String(s==null?'':s).replace(/[&<>"']/g,function(c){return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]})}
function toast(m,bad){var e=document.createElement('div');e.className='toast'+(bad?' bad':'');e.textContent=m;document.body.appendChild(e);setTimeout(function(){e.remove()},2800)}
function dt(iso){return new Date(iso).toLocaleDateString(SP.loc(),{day:'2-digit',month:'short',year:'numeric'})+', '+new Date(iso).toLocaleTimeString(SP.loc(),{hour:'2-digit',minute:'2-digit',hour12:false})}
function isToday(iso){return new Date(iso).toDateString()===new Date().toDateString()}
function when(iso){return isToday(iso)?t('today')+', '+new Date(iso).toLocaleTimeString(SP.loc(),{hour:'2-digit',minute:'2-digit',hour12:false}):dt(iso)}
function tag(s){return '<span class="tag '+s+'">● '+esc(t('st.'+s))+'</span>'}
var PAGES=['buat','lacak','riwayat','profil'];

/* ---- navigasi ---- */
$('#menuBtn').onclick=function(e){e.stopPropagation();$('#side').classList.toggle('open')};
document.addEventListener('click',function(e){if(!e.target.closest('#side')&&!e.target.closest('#menuBtn'))$('#side').classList.remove('open')});
function go(p){
    cur=p;
    $$('section[id^="p-"]').forEach(function(s){s.classList.add('hidden')});
    $('#p-'+p).classList.remove('hidden');
    $$('.nav[data-page]').forEach(function(n){n.classList.toggle('active',n.getAttribute('data-page')===p)});
    $('#side').classList.remove('open');
    if(location.hash!=='#'+p)history.replaceState(null,'','#'+p);
    if(p==='lacak')renderLacak();
    if(p==='riwayat')renderRiwayat();
    window.scrollTo(0,0);
}
$$('[data-page]').forEach(function(b){b.onclick=function(){go(b.getAttribute('data-page'))}});
$('#bNew').onclick=function(){go('buat')};
$('#navCnt').textContent=data.length;

/* ---- jumlah petugas ---- */
function duty(){var n=$('#dutyN');if(n)n.textContent=t('u.duty_n',{n:n.getAttribute('data-n')})}

/* ---- form laporan ---- */
var form=$('#fReport'),fi=$('#fileInput'),dtr=new DataTransfer();
function renderFiles(){
    var box=$('#files');box.innerHTML='';
    Array.prototype.forEach.call(dtr.files,function(f,i){
        var d=document.createElement('div');d.className='file';
        var img=document.createElement('img');
        if(/^image\/(jpe?g|png|webp|gif)/.test(f.type)){img.src=URL.createObjectURL(f)}else{img.alt='IMG'}
        var info=document.createElement('div');info.innerHTML='<b>'+esc(f.name)+'</b><span class="m">'+(f.size/1048576).toFixed(1)+' MB</span>';
        var x=document.createElement('button');x.type='button';x.textContent='🗑';x.onclick=function(){
            var n=new DataTransfer();Array.prototype.forEach.call(dtr.files,function(g,j){if(j!==i)n.items.add(g)});dtr=n;fi.files=dtr.files;renderFiles()};
        d.appendChild(img);d.appendChild(info);d.appendChild(x);box.appendChild(d);
    });
    $('#fileCnt').textContent=t('u.pc',{n:dtr.files.length});
}
function addFiles(list){
    var bad=false;
    Array.prototype.forEach.call(list,function(f){
        var ok=/^image\//.test(f.type)||/\.(heic|heif)$/i.test(f.name);
        if(!ok||f.size>5*1048576||dtr.files.length>=3){bad=true;return}
        dtr.items.add(f);
    });
    fi.files=dtr.files;renderFiles();
    if(bad)toast(t('u.maxf'),true);
}
$('#drop').onclick=function(){fi.click()};
fi.onchange=function(){var l=Array.prototype.slice.call(fi.files);fi.value='';addFiles(l)};
['dragover','dragenter'].forEach(function(ev){$('#drop').addEventListener(ev,function(e){e.preventDefault();$('#drop').classList.add('over')})});
['dragleave','drop'].forEach(function(ev){$('#drop').addEventListener(ev,function(e){e.preventDefault();$('#drop').classList.remove('over')})});
$('#drop').addEventListener('drop',function(e){addFiles(e.dataTransfer.files)});

function cnt(){$('#descCnt').textContent=$('#isi').value.trim().length}
$('#isi').addEventListener('input',cnt);cnt();

/* draf */
var DK='sp_draft';
function draft(){
    var o={};['judul','gedung','detail','isi'].forEach(function(n){o[n]=form.elements[n].value});
    var k=form.querySelector('input[name=kategori]:checked');o.kategori=k?k.value:'';
    o.prioritas=form.querySelector('input[name=prioritas]:checked').value;return o;
}
$('#bDraft').onclick=function(){try{localStorage.setItem(DK,JSON.stringify(draft()));toast(t('u.draft_ok'))}catch(e){}};
(function(){
    if(form.getAttribute('data-has-old')==='1')return;
    try{
        var o=JSON.parse(localStorage.getItem(DK)||'null');if(!o)return;
        ['judul','gedung','detail','isi'].forEach(function(n){if(o[n])form.elements[n].value=o[n]});
        if(o.kategori){var r=form.querySelector('input[name=kategori][value="'+o.kategori.replace(/"/g,'')+'"]');if(r)r.checked=true}
        if(o.prioritas){var p=form.querySelector('input[name=prioritas][value="'+o.prioritas+'"]');if(p)p.checked=true}
        cnt();toast(t('u.draft_back'));
    }catch(e){}
})();
form.addEventListener('submit',function(e){
    if(!form.querySelector('input[name=kategori]:checked')){e.preventDefault();toast(t('u.nocat'),true);return}
    if($('#isi').value.trim().length<30){e.preventDefault();toast(t('u.short'),true);$('#isi').focus();return}
    if(!form.checkValidity()){e.preventDefault();form.reportValidity();return}
    try{localStorage.removeItem(DK)}catch(x){}
});

/* ---- lacak status ---- */
function inTab(d){
    if(tab==='proc')return ['Menunggu','Diterima','Diproses'].indexOf(d.status)>=0;
    if(tab==='done')return d.status==='Selesai';
    if(tab==='rej')return d.status==='Ditolak';
    return true;
}
function rows(){
    var q=qs.toLowerCase();
    return data.filter(function(d){return inTab(d)&&(!q||[d.tiket,d.judul,d.lokasi,d.kategori].join(' ').toLowerCase().indexOf(q)>=0)})
        .sort(function(a,b){return new Date(b.waktu)-new Date(a.waktu)});
}
function counts(){
    $('#cAll').textContent=data.length;
    $('#cProc').textContent=data.filter(function(d){return ['Menunggu','Diterima','Diproses'].indexOf(d.status)>=0}).length;
    $('#cDone').textContent=data.filter(function(d){return d.status==='Selesai'}).length;
    $('#cRej').textContent=data.filter(function(d){return d.status==='Ditolak'}).length;
}
function renderLacak(){
    counts();
    var r=rows();$('#lCnt').textContent=r.length;
    if(!sel||!r.some(function(d){return d.id===sel}))sel=r.length?r[0].id:null;
    $('#tkList').innerHTML=r.map(function(d){
        return '<div class="tk2 '+(d.id===sel?'sel':'')+'" data-id="'+d.id+'"><div class="r"><span><b class="tk">'+esc(d.tiket)+'</b> '+tag(d.status)+'</span>'+(d.prioritas==='Tinggi'?'<span class="pr Tinggi">'+esc(t('pr.Tinggi'))+'</span>':'')+'</div><h4>'+esc(d.judul)+'</h4><p>'+esc(d.isi.length>90?d.isi.slice(0,90)+'…':d.isi)+'</p><div class="f"><span>🕑 '+esc(when(d.waktu))+'</span><span style="color:var(--primary);font-weight:600">'+esc(t('u.see'))+' ›</span></div></div>';
    }).join('')||'<div class="card empty">'+esc(t('u.none'))+'</div>';
    $$('#tkList .tk2').forEach(function(e){e.onclick=function(){sel=+e.getAttribute('data-id');renderLacak();if(window.innerWidth<1100)$('#tkDetail').scrollIntoView({behavior:'smooth'})}});
    renderDetail();
}
function first(d,sts){for(var i=0;i<d.riwayat.length;i++){if(sts.indexOf(d.riwayat[i].status)>=0)return d.riwayat[i]}return null}
function renderDetail(){
    var box=$('#tkDetail'),d=data.filter(function(x){return x.id===sel})[0];
    if(!d){box.innerHTML='<div class="dpanel empty">'+esc(t('u.pick_t'))+'</div>';return}
    var v=first(d,['Diterima','Diproses','Selesai','Ditolak']),w=first(d,['Diproses','Selesai']),f=first(d,['Selesai']),rej=d.status==='Ditolak';
    var nf=d.fotos.length;
    var s1='<div class="ts done"><div class="ic">✔</div><div class="bd"><div class="hd"><span>'+esc(t('u.p1'))+'</span><small>'+esc(dt(d.waktu))+'</small></div><p>'+esc(t('u.p1d',{name:d.nama,n:nf}))+'</p></div></div>';
    var s2;
    if(v&&rej){s2='<div class="ts rej"><div class="ic">✕</div><div class="bd"><div class="hd"><span>'+esc(t('u.p2'))+'</span><small>'+esc(dt(v.waktu))+'</small></div><p>'+esc(t('u.p2r',{by:v.oleh||'Admin'}))+(v.catatan?' '+esc(v.catatan):'')+'</p></div></div>'}
    else if(v){s2='<div class="ts done"><div class="ic">⚙</div><div class="bd"><div class="hd"><span>'+esc(t('u.p2'))+(d.respon_menit!=null?' <span class="tag Diterima" style="font-size:11px">'+esc(t('u.resp',{n:d.respon_menit}))+'</span>':'')+'</span><small>'+esc(dt(v.waktu))+'</small></div><p>'+esc(t('u.p2d',{by:v.oleh||'Admin',pri:t('pr.'+d.prioritas).toUpperCase()}))+'</p></div></div>'}
    else{s2='<div class="ts cur"><div class="ic">⚙</div><div class="bd"><div class="hd"><span>'+esc(t('u.p2'))+'</span></div><p>'+esc(t('u.p2w'))+'</p></div></div>'}
    var s3;
    if(rej){s3='<div class="ts pend"><div class="ic">🔧</div><div class="bd"><div class="hd"><span>'+esc(t('u.p3'))+'</span></div><p>—</p></div></div>'}
    else if(w){
        var note='';for(var i=d.riwayat.length-1;i>=0;i--){var e=d.riwayat[i];if(e.catatan&&['Diproses','Selesai'].indexOf(e.status)>=0){note=e.catatan;break}}
        s3='<div class="ts '+(f?'done':'cur')+'"><div class="ic">🔧</div><div class="bd"><div class="hd"><span>'+esc(t('u.p3'))+'</span><small style="color:var(--primary)">'+esc(dt(w.waktu))+'</small></div>'
          +'<div class="tbox">'+(d.petugas?'<div class="who2"><span class="avatar" style="width:36px;height:36px">'+esc(d.petugas.charAt(0).toUpperCase())+'</span><div><b>'+esc(d.petugas)+'</b><div class="m" style="font-size:12px">'+esc(t('u.tech'))+'</div></div></div>':'')
          +(note?'<div class="diag"><b>'+esc(t('u.diag'))+'</b>'+esc(note)+'</div>':'')
          +(d.estimasi?'<div class="eta"><span>'+esc(t('u.eta'))+'</span><b>'+esc(dt(d.estimasi))+'</b></div>':'')+'</div></div></div>';
    }else{s3='<div class="ts pend"><div class="ic">🔧</div><div class="bd"><div class="hd"><span>'+esc(t('u.p3'))+'</span></div><p>'+esc(t('u.p3w'))+'</p></div></div>'}
    var s4=f?'<div class="ts done"><div class="ic">✔</div><div class="bd"><div class="hd"><span>'+esc(t('u.p4'))+'</span><small>'+esc(dt(f.waktu))+'</small></div><p>'+esc(f.catatan||t('u.p4d'))+'</p></div></div>'
        :'<div class="ts pend"><div class="ic">✔</div><div class="bd"><div class="hd"><span>'+esc(t('u.p4'))+'</span></div><p>'+esc(rej?'—':t('u.p4w'))+'</p></div></div>';
    var att=nf?'<div class="att"><b>'+esc(t('u.attc'))+'</b><div class="thumbs">'+d.fotos.map(function(u){return '<a href="'+esc(u)+'" target="_blank" rel="noopener"><img src="'+esc(u)+'" alt=""></a>'}).join('')+'</div><div class="m" style="font-size:12px;margin-top:8px">'+esc(t('u.zoom'))+'</div></div>':'';
    box.innerHTML='<div class="dpanel"><span class="tkb">Tiket '+esc(d.tiket)+'</span>'+tag(d.status)
        +'<h2>'+esc(d.judul)+'</h2><div><span class="chp">📍 '+esc(d.lokasi)+'</span><span class="chp">👤 '+esc(t('u.rep'))+': '+esc(d.nama)+' ('+esc(d.kelas)+')</span><span class="chp">🏷 '+esc(t('u.fac'))+': '+esc(d.kategori)+'</span></div>'
        +'<div class="sh">'+esc(t('u.flowt'))+'</div><div class="tlv">'+s1+s2+s3+s4+'</div>'
        +(d.tanggapan!==null&&d.tanggapan!==''?'<div class="note"><b>'+esc(t('u.feedback'))+'</b><p>'+esc(d.tanggapan)+'</p></div>':'')+att
        +'<div class="bhelp"><button class="btn ghost sm" type="button" id="bHub">💬 '+esc(t('u.contact'))+'</button><button class="btn sm" type="button" id="bHelp">? '+esc(t('u.help'))+'</button>'
        +(d.status==='Menunggu'?'<button class="btn ghost sm" type="button" id="seEdit">✎ '+esc(t('se.edit'))+'</button><button class="btn red sm" type="button" id="seDelete">🗑 '+esc(t('se.delete'))+'</button>':'<small class="md-processed">'+esc(t('se.processed'))+'</small>')+'</div></div>';
    $('#bHub').onclick=function(){modal(t('u.ct'),t('u.cd'))};
    $('#bHelp').onclick=function(){go('buat');setTimeout(function(){var f=$('#faq');if(f)f.scrollIntoView({behavior:'smooth'})},60)};
    if(d.status==='Menunggu'){
        $('#seEdit').onclick=function(){openComplaintEditor(d)};
        $('#seDelete').onclick=function(){openComplaintDelete(d)};
    }
}
function historyItems(){
    var items=[];
    data.forEach(function(d){
        (d.riwayat||[]).forEach(function(h){
            items.push({complaint:d,event:h});
        });
    });
    return items.sort(function(a,b){return new Date(b.event.waktu).getTime()-new Date(a.event.waktu).getTime()});
}
function localDateKey(value){
    var d=new Date(value);
    return d.getFullYear()+'-'+String(d.getMonth()+1).padStart(2,'0')+'-'+String(d.getDate()).padStart(2,'0');
}
function historyDateLabel(value){
    var today=localDateKey(new Date()),yesterday=new Date();yesterday.setDate(yesterday.getDate()-1);
    var key=localDateKey(value);
    if(key===today)return t('rw.today');
    if(key===localDateKey(yesterday))return t('rw.yesterday');
    return new Date(value).toLocaleDateString(SP.loc(),{day:'2-digit',month:'long',year:'numeric'});
}
function renderRiwayat(){
    var all=historyItems(),statuses={Selesai:0,Ditolak:0,progress:0};
    $('#srTotal').textContent=all.length;
    data.forEach(function(d){
        if(d.status==='Selesai')statuses.Selesai++;
        if(d.status==='Ditolak')statuses.Ditolak++;
        if(['Menunggu','Diterima','Diproses'].indexOf(d.status)>=0)statuses.progress++;
    });
    $('#srDone').textContent=statuses.Selesai;
    $('#srProgress').textContent=statuses.progress;
    $('#srRejected').textContent=statuses.Ditolak;
    var q=$('#srSearch').value.trim().toLowerCase(),status=$('#srStatus').value,from=$('#srFrom').value,to=$('#srTo').value;
    var rows=all.filter(function(item){
        var d=item.complaint,h=item.event,day=localDateKey(h.waktu);
        return (!status||(d.status||h.status)===status)&&(!from||day>=from)&&(!to||day<=to)
            &&(!q||[d.tiket,d.judul,d.lokasi,h.catatan].join(' ').toLowerCase().indexOf(q)>=0);
    });
    var pages=Math.max(1,Math.ceil(rows.length/8));
    if(srPage>pages)srPage=pages;
    var start=(srPage-1)*8,page=rows.slice(start,start+8),groups=[],last='';
    page.forEach(function(item){
        var key=localDateKey(item.event.waktu);
        if(key!==last){groups.push('<li class="rw-day">'+esc(historyDateLabel(item.event.waktu))+'</li>');last=key}
        var d=item.complaint,h=item.event,currentStatus=d.status||h.status||'Menunggu';
        groups.push('<li><button type="button" class="rw-item" data-riwayat="'+d.id+'"><span class="rw-rail"><i class="rw-dot '+esc(currentStatus)+'"></i></span><span class="rw-body"><span class="rw-meta">'+tag(currentStatus)+'<b class="tk">'+esc(t('rw.ticket',{ticket:d.tiket}))+'</b><small class="m">'+esc(new Date(h.waktu).toLocaleTimeString(SP.loc(),{hour:'2-digit',minute:'2-digit',hour12:false}))+'</small></span><h3>'+esc(d.judul)+'</h3>'+(h.catatan?'<p class="rw-note">'+esc(h.catatan)+'</p>':'')+(h.oleh?'<p>'+esc(t('rw.by',{name:h.oleh}))+'</p>':'')+'</span></button></li>');
    });
    $('#srList').innerHTML=groups.join('')||'<li class="rw-empty">'+esc(t('rw.empty'))+'</li>';
    $('#srPager').innerHTML=rows.length?'<span>'+esc(t('rw.showing',{a:start+1,b:Math.min(start+8,rows.length),n:rows.length}))+'</span><div><button type="button" data-page="'+(srPage-1)+'" '+(srPage<=1?'disabled':'')+'>‹</button><button type="button" data-page="'+(srPage+1)+'" '+(srPage>=pages?'disabled':'')+'>›</button></div>':'';
    $$('#srPager button').forEach(function(b){b.onclick=function(){srPage=+b.getAttribute('data-page');renderRiwayat()}});
    $$('#srList [data-riwayat]').forEach(function(b){b.onclick=function(){
        sel=+b.getAttribute('data-riwayat');tab='all';qs='';$('#qTk').value='';
        $$('#tabs2 button').forEach(function(x){x.classList.toggle('on',x.getAttribute('data-tab')==='all')});
        go('lacak');
    }});
}
['#srSearch','#srStatus','#srFrom','#srTo'].forEach(function(s){$(s).addEventListener(s==='#srSearch'?'input':'change',function(){srPage=1;renderRiwayat()})});
$('#srReset').onclick=function(){$('#srSearch').value='';$('#srStatus').value='';$('#srFrom').value='';$('#srTo').value='';srPage=1;renderRiwayat()};
function requestJson(url,options){
    options=options||{};
    var headers=options.headers||{};
    headers.Accept='application/json';
    headers['X-CSRF-TOKEN']=S.csrf||document.querySelector('meta[name="csrf-token"]').content;
    return fetch(url,Object.assign({},options,{headers:headers})).then(function(response){
        return response.json().catch(function(){return {message:t('err')}}).then(function(payload){
            if(!response.ok){var error=new Error(payload.message||t('err'));error.errors=payload.errors||{};throw error}
            return payload;
        });
    });
}
function complaintUrl(template,id){return template.replace('__ID__',id)}
function renderEditCategories(){
    $('#seCategories').innerHTML=(S.kategori||[]).map(function(category){
        return '<button class="md-cat '+(editingComplaint.kategori===category?'on':'')+'" type="button" data-category="'+esc(category)+'">'+esc(category)+'</button>';
    }).join('');
    $$('#seCategories button').forEach(function(button){button.onclick=function(){
        editingComplaint.kategori=button.getAttribute('data-category');renderEditCategories();$('#seErrorKategori').textContent='';
    }});
}
function editPhotoCount(){
    var count=editingComplaint.fotos.length-removePhotos.length+editUploads.length;
    $('#sePhotoCount').textContent=t('se.photo_count',{n:count});
}
function renderEditPhotos(){
    var photos=editingComplaint.fotos.map(function(url,index){
        var removed=removePhotos.indexOf(index)>=0;
        return '<div class="md-photo '+(removed?'hidden':'')+'"><img src="'+esc(url)+'" alt=""><button type="button" data-remove-photo="'+index+'">'+esc(removed?t('se.edit'):t('se.remove_photo'))+'</button></div>';
    }).join('');
    var uploads=editUploads.map(function(file,index){return '<div class="md-photo"><div class="m" style="overflow-wrap:anywhere;font-size:12px">'+esc(file.name)+'</div><small>'+esc((file.size/1048576).toFixed(1))+' MB</small><button type="button" data-remove-upload="'+index+'">×</button></div>'}).join('');
    $('#sePhotoList').innerHTML=photos+uploads;
    $$('#sePhotoList [data-remove-photo]').forEach(function(button){button.onclick=function(){
        var index=+button.getAttribute('data-remove-photo'),at=removePhotos.indexOf(index);
        if(at>=0)removePhotos.splice(at,1);else removePhotos.push(index);
        renderEditPhotos();
    }});
    $$('#sePhotoList [data-remove-upload]').forEach(function(button){button.onclick=function(){
        editUploads.splice(+button.getAttribute('data-remove-upload'),1);renderEditPhotos();
    }});
    editPhotoCount();
}
function openComplaintEditor(complaint){
    editingComplaint=Object.assign({},complaint,{fotos:(complaint.fotos||[]).slice()});removePhotos=[];editUploads=[];
    var locationParts=(complaint.lokasi||'').split(' • ');
    $('#seJudul').value=complaint.judul||'';
    $('#seGedung').innerHTML='<option value="">—</option>'+(S.gedungs||[]).map(function(building){return '<option value="'+esc(building)+'">'+esc(building)+'</option>'}).join('');
    $('#seGedung').value=locationParts.shift()||'';
    if(!$('#seGedung').value&&locationParts.length===0){$('#seGedung').value=(S.gedungs||[]).indexOf(complaint.lokasi)>=0?complaint.lokasi:''}
    $('#seDetail').value=locationParts.join(' • ');
    $('#sePrioritas').value=complaint.prioritas||'Sedang';
    $('#seIsi').value=complaint.isi||'';
    $('#seCharCount').textContent=$('#seIsi').value.length;
    $('#seFiles').value='';
    $$('#seForm .err').forEach(function(error){error.textContent=''});
    renderEditCategories();renderEditPhotos();
    $('#seModal').classList.remove('hidden');
}
$('#seIsi').oninput=function(){$('#seCharCount').textContent=this.value.length};
$('#seFiles').onchange=function(){
    var list=Array.prototype.slice.call(this.files),current=editingComplaint.fotos.length-removePhotos.length+editUploads.length,bad=false;
    list.forEach(function(file){
        var supported=/\.(jpe?g|png|webp|heic|heif)$/i.test(file.name);
        if(!supported||file.size>5*1048576||current>=3){bad=true;return}
        editUploads.push(file);current++;
    });
    this.value='';renderEditPhotos();
    if(bad)toast(t('se.max_photos'),true);
};
function clearEditErrors(){
    $$('#seForm .err').forEach(function(error){error.textContent=''});
}
function displayEditErrors(errors){
    var fields={kategori:'seErrorKategori',judul:'seErrorJudul',gedung:'seErrorGedung',detail:'seErrorDetail',prioritas:'seErrorPrioritas',isi:'seErrorIsi',fotos:'seErrorFotos'};
    Object.keys(fields).forEach(function(field){
        if(errors[field]&&errors[field].length)$('#'+fields[field]).textContent=errors[field][0];
    });
}
$('#seForm').addEventListener('submit',function(event){
    event.preventDefault();
    if(!editingComplaint)return;
    clearEditErrors();
    var values={kategori:editingComplaint.kategori,judul:$('#seJudul').value.trim(),gedung:$('#seGedung').value,detail:$('#seDetail').value.trim(),prioritas:$('#sePrioritas').value,isi:$('#seIsi').value.trim()};
    var messages={kategori:'se.category_error',judul:'se.title_error',gedung:'se.building_error',detail:'se.detail_error',prioritas:'se.priority_error',isi:'se.description_error'},errors={};
    Object.keys(messages).forEach(function(field){
        if(!values[field]||(field==='isi'&&values[field].length<30))errors[field]=[t(messages[field])];
    });
    if(editingComplaint.fotos.length-removePhotos.length+editUploads.length>3)errors.fotos=[t('se.max_photos')];
    if(Object.keys(errors).length){displayEditErrors(errors);toast(t('err'),true);return}
    var formData=new FormData();
    Object.keys(values).forEach(function(field){formData.append(field,values[field])});
    formData.append('_method','PUT');
    removePhotos.forEach(function(index){formData.append('hapus_foto[]',index)});
    editUploads.forEach(function(file){formData.append('fotos[]',file)});
    var button=$('#seSave');button.disabled=true;button.textContent=t('se.saving');
    requestJson(complaintUrl(S.routes.update,editingComplaint.id),{method:'POST',body:formData}).then(function(payload){
        data=data.map(function(item){return item.id===payload.complaint.id?payload.complaint:item});
        editingComplaint=null;$('#seModal').classList.add('hidden');
        renderLacak();if(cur==='riwayat')renderRiwayat();
        toast(t('se.updated'));
    }).catch(function(error){
        displayEditErrors(error.errors||{});toast(error.message,true);
    }).finally(function(){button.disabled=false;button.textContent=t('se.save')});
});
function openComplaintDelete(complaint){
    deletingComplaint=complaint;
    $('#seConfirmText').textContent=t('se.delete_prompt',{ticket:complaint.tiket});
    $('#seConfirmModal').classList.remove('hidden');
}
$('#seDeleteCancel').onclick=function(){$('#seConfirmModal').classList.add('hidden');deletingComplaint=null};
$('#seConfirmModal').onclick=function(event){if(event.target.id==='seConfirmModal')$('#seDeleteCancel').click()};
$('#seDeleteConfirm').onclick=function(){
    if(!deletingComplaint)return;
    var deleted=deletingComplaint,button=this;button.disabled=true;button.textContent=t('se.deleting');
    requestJson(complaintUrl(S.routes.destroy,deleted.id),{method:'DELETE'}).then(function(){
        data=data.filter(function(item){return item.id!==deleted.id});
        sel=data.length?data[0].id:null;deletingComplaint=null;$('#seConfirmModal').classList.add('hidden');
        $('#navCnt').textContent=data.length;renderLacak();if(cur==='riwayat')renderRiwayat();
        toast(t('se.deleted'));
    }).catch(function(error){toast(error.message||t('se.delete_failed'),true)}).finally(function(){button.disabled=false;button.textContent=t('se.confirm_delete')});
};
$('#seCancel').onclick=function(){$('#seModal').classList.add('hidden');editingComplaint=null};
$('#seModal').onclick=function(event){if(event.target.id==='seModal')$('#seCancel').click()};
function modal(h,p){$('#mT').textContent=h;$('#mP').textContent=p;$('#modal').classList.remove('hidden')}
$('#mX').onclick=function(){$('#modal').classList.add('hidden')};
$('#modal').onclick=function(e){if(e.target.id==='modal')$('#modal').classList.add('hidden')};
$$('#tabs2 button').forEach(function(b){b.onclick=function(){tab=b.getAttribute('data-tab');$$('#tabs2 button').forEach(function(x){x.classList.toggle('on',x===b)});renderLacak()}});
$('#qTk').oninput=function(){qs=this.value.trim();renderLacak()};
document.addEventListener('splang',function(){duty();cnt();renderFiles();if(cur==='lacak')renderLacak();if(cur==='riwayat')renderRiwayat()});

/* ---- profil ---- */
$('#pwForm').addEventListener('submit',function(e){if($('#pwNew').value!==$('#pwCon').value){e.preventDefault();$('#pwErr').textContent=t('pw.mis')}});

/* ---- init ---- */
SP.apply();duty();renderFiles();
var h=location.hash.slice(1);
if(S.open==='lacak'){go('lacak');if(window.FLASH)toast(window.FLASH)}
else if(window.PW_ERR){go('profil')}
else go(PAGES.indexOf(h)>=0?h:'buat');
})();
</script>
@endverbatim

@else
{{-- ===================== ADMIN ===================== --}}
<div id="app">
    <aside id="side">
        <div class="brand"><div class="logo">S</div><div><b>SIPRASKA</b><small data-i18n="panel">Panel Administrator</small></div></div>
        <div class="sec" data-i18n="menu.admin">MENU ADMINISTRASI</div>
        <button class="nav active" data-page="dashboard" type="button">▦ <span data-i18n="nav.dashboard">Ringkasan Sistem</span></button>
        <button class="nav" data-page="masuk" type="button">⚠ <span data-i18n="nav.masuk">Kelola Pengaduan</span> <span class="badge" id="navBadge">0</span></button>
        <button class="nav" data-page="rekap" type="button">▮ <span data-i18n="nav.rekap">Laporan & Rekap</span></button>
        <button class="nav" data-page="pengguna" type="button">👥 <span data-i18n="nav.users">Kelola Pengguna</span></button>
        <button class="nav" data-page="riwayat" type="button">⏱ <span data-i18n="nav.riwayat">Riwayat Admin</span></button>
        <button class="nav" data-page="profil" type="button">⚙ <span data-i18n="nav.profil">Pengaturan Akun</span></button>
        <div class="side-foot">
            <div class="frow"><span data-i18n="lang">Bahasa</span><div class="lang"><button type="button" data-lang="id">ID</button><button type="button" data-lang="en">EN</button></div></div>
            <div class="frow"><span data-i18n="theme">Tema Tampilan</span><button type="button" class="switch" data-theme-toggle aria-pressed="false" aria-label="Tema"></button></div>
        </div>
    </aside>

    <div class="main">
        <header class="top">
            <div style="display:flex;align-items:center;gap:10px">
                <button class="menu-btn" id="menuBtn" type="button">☰</button>
                <div><div class="eyebrow">SIPRASKA PORTAL</div><div class="tsub" data-i18n="top.sub">Sistem Informasi Manajemen Sarana & Prasarana Terpadu</div></div>
            </div>
            <div class="tright">
                <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="btn ghost sm" style="color:var(--bad)">⏻ <span data-i18n="logout">Keluar</span></button></form>
                <div class="user">
                    <button class="user-btn" id="userBtn" type="button">
                        <span><b>{{ $user->name }}</b><span class="role" data-i18n="role">Admin</span></span>
                        <span class="avatar">👤</span>
                    </button>
                    <div class="menu hidden" id="userMenu">
                        <button type="button" data-page="profil">👤 <span data-i18n="menu.profile">Profil & Ganti Sandi</span></button>
                    </div>
                </div>
            </div>
        </header>

        <div class="content">
            {{-- RINGKASAN --}}
            <section id="p-dashboard">
                <div class="ph-head"><div><span class="live" data-i18n="sys">Sistem Aktif</span><span class="m" data-i18n="center">Pusat Kendali Pengaduan</span><h1 data-i18n="title.dashboard">Ringkasan Sistem</h1></div></div>
                <div class="grid4">
                    <div class="card stat"><div class="l" data-i18n="s.total">Total Pengaduan</div><div class="n" id="sTotal">0</div></div>
                    <div class="card stat w"><div class="l" data-i18n="s.wait">Menunggu</div><div class="n" id="sMenunggu">0</div></div>
                    <div class="card stat i"><div class="l" data-i18n="s.proc">Diproses</div><div class="n" id="sDiproses">0</div></div>
                    <div class="card stat o"><div class="l" data-i18n="s.done">Selesai</div><div class="n" id="sSelesai">0</div><div class="bar"><i id="sBar" style="width:0"></i></div><small class="m" id="sRate"></small></div>
                </div>
                <div class="grid2">
                    <div class="card">
                        <div class="head"><h3 data-i18n="chart.curve">Kurva Pengaduan</h3><select id="range"></select></div>
                        <div class="chart-wrap"><canvas id="lineChart"></canvas></div>
                    </div>
                    <div class="card"><h3 data-i18n="chart.cat">Per Kategori</h3><div class="chart-wrap"><canvas id="pieChart"></canvas></div></div>
                </div>
                <div class="two">
                    <div class="card"><h3 data-i18n="todo">Perlu Ditindaklanjuti</h3><div class="tbl"><table><tbody id="todoBody"></tbody></table></div></div>
                    <div class="card"><h3 data-i18n="recent">Pengaduan Terbaru</h3><div class="tbl"><table><tbody id="recentBody"></tbody></table></div></div>
                </div>
            </section>

            {{-- KELOLA PENGADUAN --}}
            <section id="p-masuk" class="hidden">
                <div class="ph-head">
                    <div><span class="live" data-i18n="sys">Sistem Aktif</span><span class="m" data-i18n="center">Pusat Kendali Pengaduan</span><h1 data-i18n="title.masuk">Kelola Pengaduan</h1></div>
                    <div class="chips">
                        <button class="btn" type="button" id="acOpen">＋ <span data-i18n="ac.add">Tambah Pengaduan</span></button>
                        <div class="chip"><small data-i18n="chip.today">Masuk Hari Ini</small><b><span id="chipToday">0</span> <span data-i18n="unit">Tiket</span></b></div>
                        <div class="chip red"><small data-i18n="chip.urgent">Darurat / Tinggi</small><b><span id="chipUrgent">0</span> <span data-i18n="unit">Tiket</span></b></div>
                        <div class="chip blue"><small data-i18n="chip.progress">Dalam Pengerjaan</small><b><span id="chipProg">0</span> <span data-i18n="unit">Tiket</span></b></div>
                    </div>
                </div>
                <div class="card">
                    <div class="toolbar">
                        <div class="sbox"><i>⌕</i><input id="mSearch" data-i18n-ph="ph.search" placeholder="Cari tiket, judul, lokasi, atau pelapor…"><button type="button" id="mClear" class="hidden">×</button></div>
                        <button class="btn ghost sm noprint" type="button" id="bExport">⬇ <span data-i18n="export">Export Excel</span></button>
                        <button class="btn ghost sm noprint" type="button" id="bPrint">🖨 <span data-i18n="print">Cetak Ringkasan</span></button>
                        <button class="btn ghost sm noprint" type="button" id="bRefresh" data-i18n-title="refresh" title="Muat ulang">⟳</button>
                    </div>
                    <div class="fgrid noprint">
                        <div><label data-i18n="f.cat">Kategori</label><select id="mKat"></select></div>
                        <div><label data-i18n="f.urg">Tingkat Urgensi</label><select id="mPri"></select></div>
                        <div><label data-i18n="f.status">Status Tiket</label><select id="mStatus"></select></div>
                        <div><label data-i18n="f.period">Periode Tanggal</label><div class="range"><input type="date" id="mFrom"><input type="date" id="mTo"></div></div>
                        <div><button class="btn ghost full" style="margin-top:0" type="button" id="mReset">⛔ <span data-i18n="f.reset">Reset Filter</span></button></div>
                    </div>
                </div>

                <div class="split" id="split">
                    <div>
                        <div class="card tcard">
                            <div class="lhead">
                                <div><b data-i18n="list.title">Daftar Tiket Antrian</b><span class="cnt" id="mCount">0</span></div>
                                <div class="m"><span data-i18n="sortby">Urutkan</span>: <select id="mSort"></select></div>
                            </div>
                            <div class="bulk hidden" id="bulkBar">
                                <b id="bulkCount"></b>
                                <span class="m" data-i18n="bulk">Ubah status:</span>
                                <button class="btn ghost sm" type="button" data-bulk="Diterima" data-i18n="stl.Diterima">Diterima / Sah</button>
                                <button class="btn ghost sm" type="button" data-bulk="Diproses" data-i18n="stl.Diproses">Sedang Diproses</button>
                                <button class="btn ghost sm" type="button" data-bulk="Selesai" data-i18n="stl.Selesai">Selesai Ditangani</button>
                                <button class="btn ghost sm" type="button" data-bulk="Ditolak" data-i18n="stl.Ditolak">Tolak Laporan</button>
                                <button class="btn ghost sm" type="button" id="bulkClear" data-i18n="clear">Batal pilih</button>
                            </div>
                            <div class="tbl">
                                <table>
                                    <thead><tr>
                                        <th><input type="checkbox" id="ckAll"></th>
                                        <th data-i18n="col.ticket">No. Tiket</th><th data-i18n="col.title">Judul & Lokasi</th><th data-i18n="col.reporter">Pelapor</th><th data-i18n="col.priority">Prioritas</th><th data-i18n="col.status">Status</th>
                                    </tr></thead>
                                    <tbody id="masukBody"></tbody>
                                </table>
                            </div>
                            <div class="pager" id="mPager"></div>
                        </div>
                        <div class="card sla">
                            <div class="ic">✔</div>
                            <div><b data-i18n="sla.title">Target Waktu Respon SIPRASKA (SLA)</b><br><small class="m" data-i18n="sla.desc">Maksimal 2 jam untuk tiket prioritas tinggi</small></div>
                            <div class="pct"><span id="slaPct">—</span> <small class="m" style="font-size:12px;font-weight:500" data-i18n="sla.ok">Tercapai</small></div>
                        </div>
                    </div>
                    <div id="detailWrap" class="hidden"><div class="panel" id="detail"></div></div>
                </div>
            </section>

            {{-- REKAP --}}
            <section id="p-rekap" class="hidden">
                <div class="ph-head"><div><h1 data-i18n="title.rekap">Laporan & Rekap</h1></div></div>
                <div class="card">
                    <h3 data-i18n="r.title">Laporan Rekap Pengaduan</h3>
                    <div class="fgrid noprint">
                        <div><label data-i18n="r.from">Dari tanggal</label><input type="date" id="rFrom"></div>
                        <div><label data-i18n="r.to">Sampai tanggal</label><input type="date" id="rTo"></div>
                        <div><label data-i18n="f.status">Status Tiket</label><select id="rStatus"></select></div>
                        <div><label data-i18n="f.cat">Kategori</label><select id="rKat"></select></div>
                        <div><label data-i18n="r.student">Siswa</label><select id="rStudent"></select></div>
                        <div><label data-i18n="r.group">Kelompokkan</label><select id="rGroup"><option value="month" data-i18n="r.group_month">Per bulan</option><option value="student" data-i18n="r.group_student">Per siswa</option><option value="category" data-i18n="r.group_category">Per kategori</option></select></div>
                        <div style="display:flex;gap:8px">
                            <button class="btn ghost sm" type="button" id="rPrint">🖨 <span data-i18n="print">Cetak Ringkasan</span></button>
                            <button class="btn sm" type="button" id="rCsv">⬇ <span data-i18n="r.csv">Unduh CSV</span></button>
                        </div>
                    </div>
                    <div id="rSummary" style="margin:14px 0;color:var(--muted)"></div>
                    <h3 data-i18n="r.breakdown">Ringkasan per kelompok</h3>
                    <div class="tbl"><table><thead><tr><th data-i18n="r.group_name">Kelompok</th><th data-i18n="r.group_total">Total pengaduan</th><th data-i18n="r.group_done">Selesai</th></tr></thead><tbody id="rBreakdown"></tbody></table></div>
                    <div class="tbl"><table><thead><tr><th data-i18n="col.no">No</th><th data-i18n="col.ticket">No. Tiket</th><th data-i18n="col.date">Tanggal</th><th data-i18n="col.student">Siswa</th><th data-i18n="col.class">Kelas</th><th data-i18n="col.cat">Kategori</th><th data-i18n="col.loc">Lokasi</th><th data-i18n="col.judul">Judul</th><th data-i18n="col.priority">Prioritas</th><th data-i18n="col.status">Status</th></tr></thead><tbody id="rekapBody"></tbody></table></div>
                    <div class="pager" id="rPager"></div>
                </div>
            </section>

            {{-- KELOLA PENGGUNA --}}
            <section id="p-pengguna" class="hidden">
                <div class="ph-head"><div><h1 data-i18n="title.users">Kelola Pengguna</h1><p class="m" style="margin-top:6px" data-i18n="um.subtitle">Kelola akun siswa dan administrator.</p></div><button class="btn" type="button" id="umAdd">＋ <span data-i18n="um.add">Tambah Pengguna</span></button></div>
                <div class="um-tabs">
                    <button type="button" data-user-tab="siswa" class="on"><span data-i18n="um.students">Siswa</span><span class="um-count" id="umStudentCount">0</span></button>
                    <button type="button" data-user-tab="admin"><span data-i18n="um.admins">Admin</span><span class="um-count" id="umAdminCount">0</span></button>
                </div>
                <div class="card">
                    <div class="um-toolbar">
                        <div class="sbox"><i>⌕</i><input id="umSearch" data-i18n-ph="um.search" placeholder="Cari nama, NIS, kelas, atau username…"></div>
                        <select id="umClass"><option value="" data-i18n="um.class">Semua kelas</option></select>
                    </div>
                    <div class="um-table-wrap"><table class="um-table"><thead><tr><th data-i18n="col.student">Siswa</th><th data-i18n="um.identity">NIS / Username</th><th data-i18n="col.class">Kelas</th><th data-i18n="um.complaints">Pengaduan</th><th data-i18n="um.joined">Tanggal daftar</th><th data-i18n="um.actions">Aksi</th></tr></thead><tbody id="umBody"></tbody></table></div>
                    <div class="pager" id="umPager"></div>
                </div>
            </section>

            {{-- RIWAYAT --}}
            <section id="p-riwayat" class="hidden">
                <div class="ph-head"><div><h1 data-i18n="title.riwayat">Riwayat Admin</h1></div></div>
                <div class="card">
                    <div class="head"><h3 data-i18n="h.title">Riwayat Aktivitas Admin</h3></div>
                    <div class="history-filters">
                        <div><label for="hFrom" data-i18n="h.from">Dari tanggal</label><input id="hFrom" type="date"></div>
                        <div><label for="hTo" data-i18n="h.to">Sampai tanggal</label><input id="hTo" type="date"></div>
                        <div><label for="hRole" data-i18n="h.actor">Role pelaku</label><select id="hRole"><option value="" data-i18n="h.all_roles">Semua role</option><option value="admin" data-i18n="h.admin">Admin</option><option value="siswa" data-i18n="h.student">Siswa</option></select></div>
                        <div><label for="hAction" data-i18n="h.activity">Jenis aktivitas</label><select id="hAction"><option value="" data-i18n="h.all_activities">Semua aktivitas</option><option value="akun" data-i18n="h.action.account">Akun</option><option value="login" data-i18n="h.action.login">Login</option><option value="logout" data-i18n="h.action.logout">Logout</option><option value="pengaduan" data-i18n="h.action.complaint">Pengaduan</option><option value="sandi" data-i18n="h.action.password">Kata sandi</option><option value="profil" data-i18n="h.action.profile">Profil</option><option value="pengguna" data-i18n="h.action.users">Pengguna</option><option value="hapus" data-i18n="h.action.delete">Penghapusan</option><option value="riwayat" data-i18n="h.action.history">Riwayat</option></select></div>
                        <div><label for="hSearch" data-i18n="h.search">Cari nama atau aktivitas…</label><input id="hSearch" type="search" data-i18n-ph="h.search" placeholder="Cari nama atau aktivitas…"></div>
                        <div class="history-filter-actions">
                            <button class="btn ghost sm" type="button" id="resetHistFilters" data-i18n="h.reset">Reset filter</button>
                            <button class="btn sm noprint" type="button" id="historyCsv">⬇ <span data-i18n="r.csv">Unduh CSV</span></button>
                        </div>
                    </div>
                    <ul class="hist" id="histList"></ul>
                    <div class="pager" id="hPager"></div>
                </div>
            </section>

            {{-- PROFIL --}}
            <section id="p-profil" class="hidden">
                <div class="ph-head"><div><h1 data-i18n="title.profil">Pengaturan Akun</h1></div></div>
                @if (session('status') === 'profile-updated') <div class="alert ok">✔ Profil berhasil disimpan.</div> @endif
                @if (session('status') === 'password-updated') <div class="alert ok">✔ Kata sandi berhasil diganti.</div> @endif
                <div class="two" style="align-items:start">
                    <div class="card">
                        <h3 data-i18n="pf.title">Profil Admin</h3>
                        <form method="POST" action="{{ route('admin.profile.update') }}">
                            @csrf @method('PUT')
                            <label data-i18n="pf.name">Nama</label><input name="name" value="{{ old('name', $user->name) }}" required>
                            @if ($errors->updateProfile->has('name')) <div class="err">{{ $errors->updateProfile->first('name') }}</div> @endif
                            <label>{{ $user->email ? 'Email' : 'NIS / Username' }}</label><input value="{{ $user->email ?? $user->nis }}" disabled>
                            <button class="btn" data-i18n="pf.save">Simpan Profil</button>
                        </form>
                    </div>
                    <div class="card">
                        <h3 data-i18n="pw.title">Ganti Kata Sandi</h3>
                        <form method="POST" action="{{ route('admin.password.update') }}" id="pwForm">
                            @csrf @method('PUT')
                            <label data-i18n="pw.old">Sandi Lama</label><input type="password" name="current_password" required autocomplete="current-password">
                            <label data-i18n="pw.new">Sandi Baru (min. 8 karakter)</label><input type="password" name="password" id="pwNew" required autocomplete="new-password">
                            <label data-i18n="pw.con">Konfirmasi Sandi Baru</label><input type="password" name="password_confirmation" id="pwCon" required autocomplete="new-password">
                            <div class="err" id="pwErr">{{ $errors->updatePassword->first() }}</div>
                            <button class="btn" data-i18n="pw.btn">Ganti Sandi</button>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<div class="modal-bg hidden" id="acModal" role="dialog" aria-modal="true" aria-labelledby="acTitle">
    <div class="modal md-modal">
        <h3 id="acTitle" data-i18n="ac.title">Tambah Pengaduan atas Nama Siswa</h3>
        <form id="acForm" novalidate>
            <div class="md-grid">
                <div class="md-field md-wide md-student-wrap"><label for="acStudentSearch" data-i18n="ac.student">Siswa pelapor</label><input id="acStudentSearch" data-i18n-ph="ac.student_ph" placeholder="Cari nama, NIS, atau kelas siswa…" autocomplete="off"><input type="hidden" id="acStudentId"><div id="acStudentResults" class="md-student-results hidden"></div><div class="err" id="acErrorUser"></div></div>
                <div class="md-field md-wide"><label data-i18n="ac.category">Kategori</label><div class="md-cats" id="acCategories"></div><div class="err" id="acErrorKategori"></div></div>
                <div class="md-field"><label for="acTitleInput" data-i18n="ac.subject">Judul pengaduan</label><input id="acTitleInput" maxlength="150"><div class="err" id="acErrorJudul"></div></div>
                <div class="md-field"><label for="acBuilding" data-i18n="ac.building">Gedung / Wilayah</label><select id="acBuilding"></select><div class="err" id="acErrorGedung"></div></div>
                <div class="md-field"><label for="acDetail" data-i18n="ac.detail">Lantai & detail ruangan</label><input id="acDetail" maxlength="100"><div class="err" id="acErrorDetail"></div></div>
                <div class="md-field"><label for="acPriority" data-i18n="ac.priority">Prioritas</label><select id="acPriority"><option value="Tinggi" data-i18n="pr.Tinggi">Tinggi</option><option value="Sedang" data-i18n="pr.Sedang">Sedang</option><option value="Rendah" data-i18n="pr.Rendah">Rendah</option></select><div class="err" id="acErrorPrioritas"></div></div>
                <div class="md-field"><label for="acStatus" data-i18n="ac.status">Status awal</label><select id="acStatus"><option value="Diterima" data-i18n="st.Diterima">Diterima</option><option value="Diproses" data-i18n="st.Diproses">Sedang Diproses</option><option value="Selesai" data-i18n="st.Selesai">Selesai</option><option value="Ditolak" data-i18n="st.Ditolak">Ditolak</option></select><div class="err" id="acErrorStatus"></div></div>
                <div class="md-field md-wide"><label for="acIsi" data-i18n="ac.description">Deskripsi kerusakan</label><textarea id="acIsi" rows="4" maxlength="2000"></textarea><div class="err" id="acErrorIsi"></div></div>
                <div class="md-field md-wide"><label for="acPhotos" data-i18n="ac.photos">Foto bukti (maks. 3, 5 MB/foto)</label><input type="file" id="acPhotos" accept="image/*,.heic,.heif" multiple><div class="err" id="acErrorFotos"></div></div>
            </div>
            <div class="md-actions"><button class="btn ghost" type="button" id="acCancel" data-i18n="um.cancel">Batal</button><button class="btn" type="submit" id="acSubmit" data-i18n="ac.submit">Simpan Pengaduan</button></div>
        </form>
    </div>
</div>
<div class="modal-bg hidden" id="umModal" role="dialog" aria-modal="true" aria-labelledby="umTitle">
    <div class="modal um-modal">
        <h3 id="umTitle"></h3>
        <form id="umForm" novalidate><div id="umFormFields" class="md-grid"></div><div id="umFormErrors" class="err"></div>
            <div class="um-confirm-row"><button class="btn ghost" type="button" id="umCancel" data-i18n="um.cancel">Batal</button><button class="btn" type="submit" id="umSave" data-i18n="um.save">Simpan</button></div>
        </form>
    </div>
</div>
<div class="modal-bg hidden" id="umConfirmModal" role="dialog" aria-modal="true" aria-labelledby="umConfirmTitle">
    <div class="modal"><h3 id="umConfirmTitle"></h3><p id="umConfirmText"></p><label class="chk hidden" id="umDeleteReportsLabel"><input type="checkbox" id="umDeleteReports"> <span data-i18n="um.delete_reports_check">Saya memahami seluruh pengaduan dan foto siswa akan ikut dihapus.</span></label><div class="um-confirm-row"><button class="btn ghost" type="button" id="umConfirmCancel" data-i18n="um.cancel">Batal</button><button class="btn red" type="button" id="umConfirmAction"></button></div></div>
</div>
<div class="modal-bg hidden" id="umSecretModal" role="dialog" aria-modal="true" aria-labelledby="umSecretTitle">
    <div class="modal"><h3 id="umSecretTitle" data-i18n="um.password_once">Sandi baru (tampilkan sekali)</h3><div class="um-password"><input type="text" id="umSecretValue" readonly><button type="button" class="btn ghost sm" id="umCopy" data-i18n="um.copy">Salin</button></div><div class="um-confirm-row"><button class="btn" type="button" id="umSecretClose" data-i18n="u.close">Tutup</button></div></div>
</div>

@php
    $appData = [
        'csrf'       => csrf_token(),
        'currentUserId' => $user->id,
        'complaints' => $complaints ?? [],
        'logs'       => $logs ?? [],
        'users' => $users ?? [],
        'siswa' => $siswa ?? [],
        'kategori'   => \App\Models\Complaint::KATEGORI,
        'gedungs' => ['Gedung A', 'Gedung B', 'Gedung C', 'Gedung Utama', 'Lapangan / Area Luar', 'Perpustakaan', 'Kantin', 'Masjid / Mushola', 'Lainnya'],
        'identityColumn' => $userIdentityColumn ?? 'nis',
        'hasUserEmail' => $hasUserEmail ?? false,
        'openPage'   => (session('status') || $errors->hasBag('updatePassword') || $errors->hasBag('updateProfile')) ? 'profil' : null,
        'routes'     => [
            'update'    => route('admin.complaints.update', ['complaint' => '__ID__']),
            'destroy'   => route('admin.complaints.destroy', ['complaint' => '__ID__']),
            'createComplaint' => route('admin.complaints.store'),
            'export'    => route('admin.rekap.export'),
            'activity'  => route('admin.logs.store'),
            'usersIndex' => route('admin.pengguna.index'),
            'usersStore' => route('admin.pengguna.store'),
            'usersUpdate' => route('admin.pengguna.update', ['user' => '__ID__']),
            'usersDestroy' => route('admin.pengguna.destroy', ['user' => '__ID__']),
            'usersReset' => route('admin.pengguna.reset-password', ['user' => '__ID__']),
        ],
    ];
@endphp
<script>
    window.APP = {!! json_encode($appData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!};
</script>
@verbatim
<script>
(function(){
'use strict';
var A=window.APP,t=SP.t,loc=SP.loc;
var $=function(s){return document.querySelector(s)},$$=function(s){return Array.prototype.slice.call(document.querySelectorAll(s))};
var PAGES=['dashboard','masuk','rekap','pengguna','riwayat','profil'];
var PER=8,PRI=['Tinggi','Sedang','Rendah'],ST=['Menunggu','Diterima','Diproses','Selesai','Ditolak'],OPEN=['Menunggu','Diterima','Diproses'],OPTS=['Diterima','Diproses','Selesai','Ditolak'];

var data=A.complaints||[],logs=A.logs||[],users=A.users||[],students=A.siswa||[],cur='dashboard',sel=null,selStatus='Diterima',lineC=null,pieC=null,userTab='siswa';
var CATS=A.kategori.slice();data.forEach(function(d){if(d.kategori&&CATS.indexOf(d.kategori)<0)CATS.push(d.kategori)});
var pg={masuk:1,rekap:1,riwayat:1,pengguna:1},checked=new Set(),selectedStudent=null,acCategory='';

function esc(s){return String(s==null?'':s).replace(/[&<>"']/g,function(c){return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]})}
function sub(h){return '<br><small class="m">'+h+'</small>'}
function tag(s){return '<span class="tag '+s+'">● '+esc(t('st.'+s))+'</span>'}
function pri(p){return '<span class="pr '+p+'">'+(p==='Tinggi'?'● '+esc(t('pr.'+p)).toUpperCase():esc(t('pr.'+p)))+'</span>'}
function dayStr(d){return new Date(d).toLocaleDateString(loc(),{day:'2-digit',month:'short',year:'numeric'})}
function dayOnly(d){return new Date(d+'T00:00:00').toLocaleDateString(loc(),{day:'2-digit',month:'short',year:'numeric'})}
function timeStr(iso){return new Date(iso).toLocaleTimeString(loc(),{hour:'2-digit',minute:'2-digit',hour12:false})}
function isToday(iso){return new Date(iso).toDateString()===new Date().toDateString()}
function when(iso){return isToday(iso)?t('today')+', '+timeStr(iso):new Date(iso).toLocaleDateString(loc(),{day:'2-digit',month:'short'})+', '+timeStr(iso)}
function ago(iso){var m=Math.max(0,Math.round((Date.now()-new Date(iso).getTime())/60000));var r=new Intl.RelativeTimeFormat(loc(),{numeric:'auto'});if(m<60)return r.format(-m,'minute');if(m<1440)return r.format(-Math.floor(m/60),'hour');return r.format(-Math.floor(m/1440),'day')}
function url(tpl,id){return tpl.replace('__ID__',id)}
function datetimeLocalValue(date){return new Date(date.getTime()-date.getTimezoneOffset()*60000).toISOString().slice(0,16)}

function toast(msg,bad){var e=document.createElement('div');e.className='toast'+(bad?' bad':'');e.textContent=msg;document.body.appendChild(e);setTimeout(function(){e.remove()},2800)}
async function api(u,method,body){
    var isForm=body instanceof FormData,headers={'Accept':'application/json','X-CSRF-TOKEN':A.csrf};
    if(body&&!isForm)headers['Content-Type']='application/json';
    var r=await fetch(u,{method:method,headers:headers,body:body?(isForm?body:JSON.stringify(body)):undefined});
    var j={};try{j=await r.json()}catch(e){}
    if(!r.ok){var error=new Error(j.message||t('err'));error.errors=j.errors||{};error.count=j.count||0;throw error}
    return j;
}
function pushLog(l){if(l){logs.unshift(l);logs=logs.slice(0,2000)}}
async function recordActivity(aksi, deskripsi) {
    try {
        var j = await api(A.routes.activity, 'POST', {
            aksi: aksi,
            deskripsi: deskripsi
        });

        if (j.log) {
            pushLog(j.log);

            if (cur === 'riwayat') {
                renderHist();
            }
        }
    } catch (e) {
        console.error('Gagal mencatat aktivitas:', e);
    }
}

/* ---------- selects ---------- */
function fill(id,items){var el=$(id),v=el.value;el.innerHTML=items.map(function(x){return '<option value="'+esc(x[0])+'">'+esc(x[1])+'</option>'}).join('');el.value=v;if(el.selectedIndex<0)el.selectedIndex=0}
function buildSelects(){
    var all=[['',t('all')]];
    var kat=all.concat(CATS.map(function(k){return [k,k]})),sts=all.concat(ST.map(function(s){return [s,t('st.'+s)]})),prs=all.concat([['Tinggi',t('pr.high')],['Sedang',t('pr.Sedang')],['Rendah',t('pr.Rendah')]]);
    fill('#mKat',kat);fill('#rKat',kat);fill('#mStatus',sts);fill('#rStatus',sts);fill('#mPri',prs);
    fill('#rStudent',all.concat(students.map(function(student){return [String(student.id),student.nama+' ('+student.nis+')']})));
    fill('#mSort',[['new',t('sort.new')],['old',t('sort.old')],['pri',t('sort.pri')]]);
    fill('#range',[['6',t('r6')],['12',t('r12')]]);
}
document.addEventListener('splang',function(){buildSelects();refresh()});
document.addEventListener('sptheme',function(){if(cur==='dashboard')renderDash()});

/* ---------- shell ---------- */
$('#userBtn').onclick=function(e){e.stopPropagation();$('#userMenu').classList.toggle('hidden')};
document.addEventListener('click',function(e){
    if(!e.target.closest('.user'))$('#userMenu').classList.add('hidden');
    if(!e.target.closest('#side')&&!e.target.closest('#menuBtn'))$('#side').classList.remove('open');
});
$('#menuBtn').onclick=function(){$('#side').classList.toggle('open')};

function go(p){
    cur=p;
    $$('section[id^="p-"]').forEach(function(s){s.classList.add('hidden')});
    $('#p-'+p).classList.remove('hidden');
    $$('.nav[data-page]').forEach(function(n){n.classList.toggle('active',n.getAttribute('data-page')===p)});
    $('#userMenu').classList.add('hidden');$('#side').classList.remove('open');
    if(location.hash!=='#'+p)history.replaceState(null,'','#'+p);
    refresh();
}
function refresh(){
    if(cur==='dashboard')renderDash();
    else if(cur==='masuk'){renderManage(false);renderDetail()}
    else if(cur==='rekap')renderRekap();
    else if(cur==='pengguna')renderUsers();
    else if(cur==='riwayat')renderHist();
    $('#navBadge').textContent=data.filter(function(d){return d.status==='Menunggu'}).length;
}
$$('[data-page]').forEach(function(b){b.addEventListener('click',function(){go(b.getAttribute('data-page'))})});

/* ---------- pager ---------- */
function pager(el,total,key,render){
    if(total===0){el.innerHTML='';return}
    var pages=Math.max(1,Math.ceil(total/PER));if(pg[key]>pages)pg[key]=pages;
    var p=pg[key],a=(p-1)*PER+1,b=Math.min(p*PER,total);
    var s=Math.max(1,Math.min(p-2,pages-4)),e=Math.min(pages,s+4),nums='';
    for(var i=s;i<=e;i++)nums+='<button type="button" data-p="'+i+'" class="'+(i===p?'on':'')+'">'+i+'</button>';
    el.innerHTML='<span>'+esc(t('showing',{a:a,b:b,n:total}))+'</span><div><button type="button" data-p="1" '+(p<=1?'disabled':'')+'>⏮</button><button type="button" data-p="'+(p-1)+'" '+(p<=1?'disabled':'')+'>‹</button>'+nums+'<button type="button" data-p="'+(p+1)+'" '+(p>=pages?'disabled':'')+'>›</button><button type="button" data-p="'+pages+'" '+(p>=pages?'disabled':'')+'>⏭</button></div>';
    el.querySelectorAll('button').forEach(function(btn){btn.onclick=function(){pg[key]=+btn.getAttribute('data-p');render()}});
}

var USER_CLASSES=['X MIPA 1','X MIPA 2','X MIPA 3','X MIPA 4','X IPS 1','X IPS 2','X IPS 3','XI MIPA 1','XI MIPA 2','XI MIPA 3','XI MIPA 4','XI IPS 1','XI IPS 2','XI IPS 3','XII MIPA 1','XII MIPA 2','XII MIPA 3','XII MIPA 4','XII IPS 1','XII IPS 2','XII IPS 3'];
var userEdit=null,userFormRole='siswa',userAction=null,userGeneratedPassword=null,userIdentityColumn=A.identityColumn||'nis';
function userIdentifier(account){
    return account[userIdentityColumn]||account.nis||account.username||account.email||'-';
}
function userRows(){
    var query=$('#umSearch').value.trim().toLowerCase(),schoolClass=$('#umClass').value;
    return users.filter(function(account){
        return account.role===userTab
            &&(!schoolClass||account.kelas===schoolClass)
            &&(!query||[account.name,account.nis,account.username,account.email,account.kelas].join(' ').toLowerCase().indexOf(query)>=0);
    }).sort(function(a,b){return a.name.localeCompare(b.name)});
}
function renderUserClassFilter(){
    var filter=$('#umClass'),selected=filter.value;
    filter.innerHTML='<option value="">'+esc(t('um.class'))+'</option>'+USER_CLASSES.map(function(value){return '<option value="'+esc(value)+'">'+esc(value)+'</option>'}).join('');
    filter.value=selected;
    filter.classList.toggle('hidden',userTab!=='siswa');
}
function renderUsers(){
    var studentCount=users.filter(function(account){return account.role==='siswa'}).length;
    var adminCount=users.filter(function(account){return account.role==='admin'}).length;
    $('#umStudentCount').textContent=studentCount;$('#umAdminCount').textContent=adminCount;
    renderUserClassFilter();
    var rows=userRows(),pages=Math.max(1,Math.ceil(rows.length/PER));
    if(pg.pengguna>pages)pg.pengguna=pages;
    var offset=(pg.pengguna-1)*PER,page=rows.slice(offset,offset+PER);
    $('#umBody').innerHTML=page.map(function(account){
        var initial=(account.name||'?').trim().charAt(0).toUpperCase(),self=account.id===A.currentUserId;
        var deleteDisabled=self||(account.role==='admin'&&adminCount<=1);
        var deleteTitle=self?t('um.self_delete'):(account.role==='admin'&&adminCount<=1?t('um.last_admin'):t('um.delete'));
        return '<tr><td><div class="um-person"><span class="avatar">'+esc(initial)+'</span><b>'+esc(account.name)+'</b></div></td><td>'+esc(userIdentifier(account))+'</td><td>'+esc(account.kelas||'-')+'</td><td>'+esc(account.complaints_count||0)+'</td><td>'+esc(account.created_at?new Date(account.created_at).toLocaleDateString(loc()):'—')+'</td><td><div class="um-actions"><button class="btn ghost sm" type="button" data-user-edit="'+account.id+'">'+esc(t('um.edit'))+'</button><button class="btn ghost sm" type="button" data-user-reset="'+account.id+'">'+esc(t('um.reset'))+'</button><button class="btn red sm" type="button" data-user-delete="'+account.id+'" title="'+esc(deleteTitle)+'" '+(deleteDisabled?'disabled':'')+'>'+esc(t('um.delete'))+'</button></div></td></tr>';
    }).join('')||'<tr><td colspan="6" class="empty">'+esc(t('um.empty'))+'</td></tr>';
    $('#umPager').innerHTML=rows.length?'<span>'+esc(t('um.showing',{a:offset+1,b:Math.min(offset+PER,rows.length),n:rows.length}))+'</span><div><button type="button" data-user-page="'+(pg.pengguna-1)+'" '+(pg.pengguna<=1?'disabled':'')+'>‹</button><button type="button" data-user-page="'+(pg.pengguna+1)+'" '+(pg.pengguna>=pages?'disabled':'')+'>›</button></div>':'';
    $$('#umPager [data-user-page]').forEach(function(button){button.onclick=function(){pg.pengguna=+button.getAttribute('data-user-page');renderUsers()}});
    $$('#umBody [data-user-edit]').forEach(function(button){button.onclick=function(){openUserModal(users.filter(function(account){return account.id===+button.getAttribute('data-user-edit')})[0])}});
    $$('#umBody [data-user-reset]').forEach(function(button){button.onclick=function(){openUserConfirmation('reset',users.filter(function(account){return account.id===+button.getAttribute('data-user-reset')})[0])}});
    $$('#umBody [data-user-delete]').forEach(function(button){button.onclick=function(){openUserConfirmation('delete',users.filter(function(account){return account.id===+button.getAttribute('data-user-delete')})[0])}});
}
function userFormValues(){
    var identity=$('#umIdentity');
    return {name:$('#umName')?$('#umName').value:'',identity:identity?identity.value:'',kelas:$('#umUserClass')?$('#umUserClass').value:'',email:$('#umEmail')?$('#umEmail').value:'',password:$('#umPassword')?$('#umPassword').value:''};
}
function renderUserForm(role,account,values){
    account=account||{};values=values||{};
    var identityColumn=role==='siswa'?'nis':userIdentityColumn;
    var identityLabel=identityColumn==='email'?t('um.email'):t('um.identity');
    var identityValue=values.identity!==undefined?values.identity:(account[identityColumn]||'');
    var html='';
    if(!userEdit){
        html+='<div class="md-field md-wide"><label for="umRole">'+esc(t('um.role_student'))+' / '+esc(t('um.role_admin'))+'</label><select id="umRole"><option value="siswa" '+(role==='siswa'?'selected':'')+'>'+esc(t('um.role_student'))+'</option><option value="admin" '+(role==='admin'?'selected':'')+'>'+esc(t('um.role_admin'))+'</option></select></div>';
    }
    html+='<div class="md-field md-wide"><label for="umName">'+esc(t('um.name'))+'</label><input id="umName" maxlength="255" value="'+esc(values.name!==undefined?values.name:(account.name||''))+'" required><small class="err" id="umErrorName"></small></div>';
    html+='<div class="md-field"><label for="umIdentity">'+esc(identityLabel)+'</label><input id="umIdentity" name="'+esc(identityColumn)+'" maxlength="255" type="'+(identityColumn==='email'?'email':'text')+'" value="'+esc(identityValue)+'" required><small class="err" id="umErrorIdentity"></small></div>';
    if(A.hasUserEmail&&identityColumn!=='email'){
        html+='<div class="md-field"><label for="umEmail">'+esc(t('um.email'))+'</label><input id="umEmail" type="email" maxlength="255" value="'+esc(values.email!==undefined?values.email:(account.email||''))+'"><small class="err" id="umErrorEmail"></small></div>';
    }
    if(role==='siswa'){
        html+='<div class="md-field md-wide"><label for="umUserClass">'+esc(t('g.class'))+'</label><select id="umUserClass"><option value="">'+esc(t('um.select_class'))+'</option>'+USER_CLASSES.map(function(value){return '<option value="'+esc(value)+'" '+((values.kelas!==undefined?values.kelas:account.kelas)===value?'selected':'')+'>'+esc(value)+'</option>'}).join('')+'</select><small class="err" id="umErrorClass"></small></div>';
    }
    if(!userEdit){
        html+='<div class="md-field md-wide"><label for="umPassword">'+esc(t('um.password'))+'</label><div class="um-password"><input id="umPassword" type="text" minlength="8" value="'+esc(values.password||'')+'"><button class="btn ghost sm" type="button" id="umGenerate">'+esc(t('um.generate'))+'</button></div><small class="err" id="umErrorPassword"></small></div>';
    }
    $('#umFormFields').innerHTML=html;
    if(!userEdit){
        $('#umRole').onchange=function(){var keep=userFormValues();userFormRole=this.value;renderUserForm(userFormRole,null,keep)};
        $('#umPassword').oninput=function(){userGeneratedPassword=null};
        $('#umGenerate').onclick=function(){
            try{
                var bytes=new Uint8Array(10);window.crypto.getRandomValues(bytes);
                var alphabet='ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz23456789';
                $('#umPassword').value=Array.prototype.map.call(bytes,function(byte){return alphabet[byte%alphabet.length]}).join('');
                userGeneratedPassword=$('#umPassword').value;
            }catch(error){toast(t('err'),true)}
        };
    }
}
function openUserModal(account){
    userEdit=account||null;userGeneratedPassword=null;
    userFormRole=userEdit?userEdit.role:(userTab==='admin'?'admin':'siswa');
    $('#umTitle').textContent=t(userEdit?'um.edit':'um.create');
    $('#umFormErrors').textContent='';
    renderUserForm(userFormRole,userEdit);
    $('#umModal').classList.remove('hidden');
}
$('#umAdd').onclick=function(){openUserModal(null)};
$('#umCancel').onclick=function(){$('#umModal').classList.add('hidden');userEdit=null;userGeneratedPassword=null};
$('#umModal').onclick=function(event){if(event.target.id==='umModal')$('#umCancel').click()};
function displayUserErrors(errors){
    var fields={name:'umErrorName',nis:'umErrorIdentity',username:'umErrorIdentity',email:'umErrorEmail',kelas:'umErrorClass',password:'umErrorPassword'};
    Object.keys(fields).forEach(function(field){
        if(errors[field]&&errors[field].length){
            var target=field==='email'&&userFormRole==='admin'&&userIdentityColumn==='email'?'umErrorIdentity':fields[field],element=$('#'+target);
            if(element)element.textContent=errors[field][0];
        }
    });
    var first=Object.keys(errors)[0];
    if(first&&!fields[first])$('#umFormErrors').textContent=errors[first][0];
}
$('#umForm').addEventListener('submit',async function(event){
    event.preventDefault();
    $$('#umForm .err').forEach(function(error){error.textContent=''});
    var identityColumn=userFormRole==='siswa'?'nis':userIdentityColumn;
    var payload={name:$('#umName').value.trim()};
    if(!userEdit)payload.role=userFormRole;
    payload[identityColumn]=$('#umIdentity').value.trim();
    if(userFormRole==='siswa')payload.kelas=$('#umUserClass').value;
    if(A.hasUserEmail&&identityColumn!=='email')payload.email=$('#umEmail').value.trim();
    if(!userEdit)payload.password=$('#umPassword').value;
    var errors={};
    if(!payload.name)errors.name=[t('um.name_required')];
    if(!payload[identityColumn])errors[identityColumn]=[t('um.identity_required')];
    if(userFormRole==='siswa'&&!payload.kelas)errors.kelas=[t('um.class_required')];
    if(!userEdit&&(!payload.password||payload.password.length<8))errors.password=[t(payload.password?'um.password_min':'um.password_required')];
    if(Object.keys(errors).length){displayUserErrors(errors);toast(t('err'),true);return}
    var button=$('#umSave');button.disabled=true;button.textContent=t('um.saving');
    try{
        var editing=!!userEdit;
        var result=editing
            ?await api(url(A.routes.usersUpdate,userEdit.id),'PUT',payload)
            :await api(A.routes.usersStore,'POST',payload);
        if(userEdit){users=users.map(function(account){return account.id===result.user.id?result.user:account})}
        else{users.push(result.user)}
        var generated=userGeneratedPassword;userEdit=null;userGeneratedPassword=null;$('#umModal').classList.add('hidden');
        renderUsers();toast(t(editing?'um.updated':'um.created'));
        if(generated)showSecret(generated);
    }catch(error){displayUserErrors(error.errors||{});toast(error.message,true)}
    finally{button.disabled=false;button.textContent=t('um.save')}
});
function openUserConfirmation(action,account){
    if(!account)return;
    userAction={type:action,account:account,forceDelete:false};
    $('#umDeleteReportsLabel').classList.add('hidden');$('#umDeleteReports').checked=false;
    $('#umConfirmTitle').textContent=t(action==='delete'?'um.delete_title':'um.reset_title');
    $('#umConfirmText').textContent=t(action==='delete'?'um.delete_prompt':'um.reset_prompt',{name:account.name});
    $('#umConfirmAction').textContent=t(action==='delete'?'um.confirm_delete':'um.confirm_reset');
    $('#umConfirmModal').classList.remove('hidden');
}
function closeUserConfirmation(){userAction=null;$('#umConfirmModal').classList.add('hidden');$('#umDeleteReportsLabel').classList.add('hidden');$('#umDeleteReports').checked=false}
$('#umConfirmCancel').onclick=closeUserConfirmation;
$('#umConfirmModal').onclick=function(event){if(event.target.id==='umConfirmModal')closeUserConfirmation()};
$('#umConfirmAction').onclick=async function(){
    if(!userAction)return;
    var state=userAction,account=state.account,button=this;button.disabled=true;
    try{
        if(state.type==='reset'){
            var result=await api(url(A.routes.usersReset,account.id),'POST',{});
            closeUserConfirmation();showSecret(result.password);toast(t('um.reset_done'));
        }else{
            if(state.forceDelete&&!$('#umDeleteReports').checked){toast(t('um.confirm_reports_required'),true);return}
            var result=await api(url(A.routes.usersDestroy,account.id),'DELETE',state.forceDelete?{hapus_pengaduan:1}:undefined);
            users=users.filter(function(item){return item.id!==result.id});
            closeUserConfirmation();renderUsers();toast(t('um.deleted'));
        }
    }catch(error){
        if(state.type==='delete'&&!state.forceDelete&&error.count){
            state.forceDelete=true;$('#umConfirmText').textContent=t('um.delete_reports',{n:error.count});
            $('#umDeleteReportsLabel').classList.remove('hidden');$('#umConfirmAction').textContent=t('um.confirm_delete');
        }else{toast(error.message,true)}
    }finally{button.disabled=false}
};
function showSecret(secret){
    $('#umSecretValue').value=secret;$('#umSecretModal').classList.remove('hidden');
}
$('#umCopy').onclick=async function(){
    try{await navigator.clipboard.writeText($('#umSecretValue').value);toast(t('um.copied'))}
    catch(error){toast(t('um.copy_failed'),true)}
};
function closeSecret(){ $('#umSecretValue').value='';$('#umSecretModal').classList.add('hidden') }
$('#umSecretClose').onclick=closeSecret;
$('#umSecretModal').onclick=function(event){if(event.target.id==='umSecretModal')closeSecret()};
$$('[data-user-tab]').forEach(function(button){button.onclick=function(){
    userTab=button.getAttribute('data-user-tab');pg.pengguna=1;
    $$('#p-pengguna [data-user-tab]').forEach(function(tabButton){tabButton.classList.toggle('on',tabButton===button)});
    $('#umSearch').value='';$('#umClass').value='';renderUsers();
}});
$('#umSearch').oninput=function(){pg.pengguna=1;renderUsers()};
$('#umClass').onchange=function(){pg.pengguna=1;renderUsers()};

/* ---------- RINGKASAN ---------- */
function renderDash(){
    var c=function(s){return data.filter(function(d){return d.status===s}).length},total=data.length,done=c('Selesai');
    $('#sTotal').textContent=total;$('#sMenunggu').textContent=data.filter(function(d){return d.status==='Menunggu'||d.status==='Diterima'}).length;
    $('#sDiproses').textContent=c('Diproses');$('#sSelesai').textContent=done;
    var rate=total?Math.round(done/total*100):0;$('#sBar').style.width=rate+'%';$('#sRate').textContent=t('s.rate',{n:rate});

    var n=parseInt($('#range').value,10)||6,now=new Date(),keys=[],labels=[];
    for(var i=n-1;i>=0;i--){var d0=new Date(now.getFullYear(),now.getMonth()-i,1);keys.push(d0.getFullYear()+'-'+String(d0.getMonth()+1).padStart(2,'0'));labels.push(d0.toLocaleDateString(loc(),{month:'short',year:'2-digit'}))}
    var counts=keys.map(function(k){return data.filter(function(d){return d.tanggal.indexOf(k)===0}).length});
    if(lineC){lineC.destroy();lineC=null}if(pieC){pieC.destroy();pieC=null}
    if(window.Chart){
        var css=getComputedStyle(document.documentElement);
        Chart.defaults.color=css.getPropertyValue('--muted').trim()||'#64748b';
        Chart.defaults.borderColor=css.getPropertyValue('--line').trim()||'#e2e8f0';
        lineC=new Chart($('#lineChart'),{type:'line',data:{labels:labels,datasets:[{label:t('s.total'),data:counts,borderColor:'#3b82f6',backgroundColor:'rgba(59,130,246,.14)',fill:true,tension:.35,pointRadius:4}]},options:{maintainAspectRatio:false,plugins:{legend:{display:false}},scales:{y:{beginAtZero:true,ticks:{precision:0}}}}});
        pieC=new Chart($('#pieChart'),{type:'doughnut',data:{labels:CATS,datasets:[{data:CATS.map(function(k){return data.filter(function(d){return d.kategori===k}).length}),backgroundColor:['#2563eb','#0891b2','#16a34a','#d97706','#dc2626','#7c3aed','#6b7280','#db2777','#0d9488'],borderWidth:0}]},options:{maintainAspectRatio:false,plugins:{legend:{position:'bottom',labels:{boxWidth:10}}}}});
    }
    var row=function(d){return '<tr><td><b>'+esc(d.judul)+'</b>'+sub(esc(d.nama)+' • '+esc(when(d.waktu)))+'</td><td style="text-align:right">'+tag(d.status)+'<br><button class="btn sm" style="margin-top:6px" type="button" data-open="'+d.id+'">'+esc(t('review'))+'</button></td></tr>'};
    var w=function(d){return new Date(d.waktu).getTime()};
    var todo=data.filter(function(d){return d.status==='Menunggu'}).sort(function(a,b){return w(a)-w(b)}).slice(0,5);
    $('#todoBody').innerHTML=todo.map(row).join('')||'<tr><td class="empty">'+esc(t('todo.empty'))+'</td></tr>';
    var rec=data.slice().sort(function(a,b){return w(b)-w(a)}).slice(0,5);
    $('#recentBody').innerHTML=rec.map(row).join('')||'<tr><td class="empty">'+esc(t('empty'))+'</td></tr>';
    $$('#p-dashboard [data-open]').forEach(function(b){b.onclick=function(){selectTicket(+b.getAttribute('data-open'))}});
}
$('#range').onchange=renderDash;

/* ---------- KELOLA PENGADUAN ---------- */
function manageRows(){
    var q=$('#mSearch').value.trim().toLowerCase(),k=$('#mKat').value,pr=$('#mPri').value,st=$('#mStatus').value,f=$('#mFrom').value,to=$('#mTo').value,so=$('#mSort').value;
    var r=data.filter(function(d){return (!k||d.kategori===k)&&(!pr||d.prioritas===pr)&&(!st||d.status===st)&&(!f||d.tanggal>=f)&&(!to||d.tanggal<=to)&&(!q||[d.tiket,d.nama,d.judul,d.lokasi,d.kelas].join(' ').toLowerCase().indexOf(q)>=0)});
    var w=function(d){return new Date(d.waktu).getTime()};
    if(so==='old')r.sort(function(a,b){return w(a)-w(b)});
    else if(so==='pri')r.sort(function(a,b){return PRI.indexOf(a.prioritas)-PRI.indexOf(b.prioritas)||w(b)-w(a)});
    else r.sort(function(a,b){return w(b)-w(a)});
    return r;
}
function renderChips(){
    $('#chipToday').textContent=data.filter(function(d){return isToday(d.waktu)}).length;
    $('#chipUrgent').textContent=data.filter(function(d){return d.prioritas==='Tinggi'&&OPEN.indexOf(d.status)>=0}).length;
    $('#chipProg').textContent=data.filter(function(d){return d.status==='Diproses'}).length;
    var ok=0,bad=0;
    data.forEach(function(d){
        if(d.prioritas!=='Tinggi')return;
        if(d.respon_menit!==null&&d.respon_menit!==undefined){if(d.respon_menit<=120)ok++;else bad++}
        else if((Date.now()-new Date(d.waktu).getTime())/60000>120)bad++;
    });
    $('#slaPct').textContent=(ok+bad)?(ok/(ok+bad)*100).toFixed(1)+'%':'—';
}
function updateBulk(){
    var n=checked.size;
    $('#bulkBar').classList.toggle('hidden',n===0);
    $('#bulkCount').textContent=t('selected',{n:n});
}
function renderManage(all){
    renderChips();
    $('#mClear').classList.toggle('hidden',!$('#mSearch').value);
    var rows=manageRows();
    $('#mCount').textContent=rows.length+' '+t('found');
    var pages=Math.max(1,Math.ceil(rows.length/PER));if(pg.masuk>pages)pg.masuk=pages;
    var page=all?rows:rows.slice((pg.masuk-1)*PER,pg.masuk*PER);
    $('#masukBody').innerHTML=page.map(function(d){return '<tr data-id="'+d.id+'" class="'+(d.id===sel?'sel':'')+'"><td><input type="checkbox" class="ck" data-id="'+d.id+'" '+(checked.has(d.id)?'checked':'')+'></td><td><b class="tk">'+esc(d.tiket)+'</b>'+sub(esc(when(d.waktu)))+'</td><td><b>'+esc(d.judul)+'</b>'+sub('📍 '+esc(d.lokasi))+'</td><td>'+esc(d.nama)+sub(esc(d.kelas))+'</td><td>'+pri(d.prioritas)+'</td><td>'+tag(d.status)+'</td></tr>'}).join('')||'<tr><td colspan="6" class="empty">'+esc(t('empty'))+'</td></tr>';
    if(all){$('#mPager').innerHTML=''}else{pager($('#mPager'),rows.length,'masuk',function(){renderManage(false)})}
    $$('#masukBody tr[data-id]').forEach(function(tr){tr.onclick=function(e){if(e.target.classList.contains('ck'))return;selectTicket(+tr.getAttribute('data-id'))}});
    $$('#masukBody .ck').forEach(function(c){c.onchange=function(){var id=+c.getAttribute('data-id');if(c.checked)checked.add(id);else checked.delete(id);updateBulk()}});
    $('#ckAll').checked=page.length>0&&page.every(function(d){return checked.has(d.id)});
    updateBulk();
}
$('#ckAll').onchange=function(e){
    var rows=manageRows().slice((pg.masuk-1)*PER,pg.masuk*PER);
    rows.forEach(function(d){if(e.target.checked)checked.add(d.id);else checked.delete(d.id)});
    renderManage(false);
};
['#mSearch','#mKat','#mPri','#mStatus','#mFrom','#mTo','#mSort'].forEach(function(s){$(s).addEventListener('input',function(){pg.masuk=1;renderManage(false)})});
$('#mClear').onclick=function(){$('#mSearch').value='';pg.masuk=1;renderManage(false)};
$('#mReset').onclick=function(){['#mSearch','#mKat','#mPri','#mStatus','#mFrom','#mTo'].forEach(function(s){$(s).value=''});$('#mSort').value='new';pg.masuk=1;renderManage(false)};
function renderAcCategories(){
    $('#acCategories').innerHTML=CATS.map(function(category){
        return '<button class="md-cat '+(acCategory===category?'on':'')+'" type="button" data-ac-category="'+esc(category)+'">'+esc(category)+'</button>';
    }).join('');
    $$('#acCategories button').forEach(function(button){button.onclick=function(){
        acCategory=button.getAttribute('data-ac-category');renderAcCategories();$('#acErrorKategori').textContent='';
    }});
}
function resetAcForm(){
    $('#acForm').reset();selectedStudent=null;acCategory='';
    $('#acStudentId').value='';$('#acStudentResults').classList.add('hidden');
    $('#acBuilding').innerHTML='<option value="">—</option>'+(A.gedungs||[]).map(function(building){return '<option value="'+esc(building)+'">'+esc(building)+'</option>'}).join('');
    $$('#acForm .err').forEach(function(error){error.textContent=''});
    renderAcCategories();
}
$('#acOpen').onclick=function(){resetAcForm();$('#acModal').classList.remove('hidden')};
$('#acCancel').onclick=function(){$('#acModal').classList.add('hidden')};
$('#acModal').onclick=function(event){if(event.target.id==='acModal')$('#acCancel').click()};
$('#acStudentSearch').oninput=function(){
    selectedStudent=null;$('#acStudentId').value='';
    var query=this.value.trim().toLowerCase(),results=$('#acStudentResults');
    if(!query){results.classList.add('hidden');return}
    var matches=students.filter(function(student){return [student.nama,student.nis,student.kelas].join(' ').toLowerCase().indexOf(query)>=0}).slice(0,8);
    results.innerHTML=matches.map(function(student){return '<button type="button" data-student="'+student.id+'"><b>'+esc(student.nama)+'</b><br><small>'+esc(student.nis)+' · '+esc(student.kelas)+'</small></button>'}).join('')||'<div class="rw-empty">'+esc(t('ac.empty'))+'</div>';
    results.classList.remove('hidden');
    $$('#acStudentResults [data-student]').forEach(function(button){button.onclick=function(){
        selectedStudent=students.filter(function(student){return student.id===+button.getAttribute('data-student')})[0];
        $('#acStudentId').value=selectedStudent.id;
        $('#acStudentSearch').value=selectedStudent.nama+' · '+selectedStudent.nis+' · '+selectedStudent.kelas;
        results.classList.add('hidden');$('#acErrorUser').textContent='';
    }});
};
function displayAcErrors(errors){
    var fields={user_id:'acErrorUser',kategori:'acErrorKategori',judul:'acErrorJudul',gedung:'acErrorGedung',detail:'acErrorDetail',prioritas:'acErrorPrioritas',status:'acErrorStatus',isi:'acErrorIsi',fotos:'acErrorFotos'};
    Object.keys(fields).forEach(function(field){if(errors[field]&&errors[field].length)$('#'+fields[field]).textContent=errors[field][0]});
}
$('#acForm').addEventListener('submit',async function(event){
    event.preventDefault();
    $$('#acForm .err').forEach(function(error){error.textContent=''});
    var values={user_id:selectedStudent?selectedStudent.id:'',kategori:acCategory,judul:$('#acTitleInput').value.trim(),gedung:$('#acBuilding').value,detail:$('#acDetail').value.trim(),prioritas:$('#acPriority').value,status:$('#acStatus').value,isi:$('#acIsi').value.trim()};
    var errors={};
    if(!values.user_id)errors.user_id=[t('ac.student')];
    if(!values.kategori)errors.kategori=[t('se.category_error')];
    if(!values.judul)errors.judul=[t('se.title_error')];
    if(!values.gedung)errors.gedung=[t('se.building_error')];
    if(!values.detail)errors.detail=[t('se.detail_error')];
    if(values.isi.length<30)errors.isi=[t('se.description_error')];
    var files=Array.prototype.slice.call($('#acPhotos').files);
    if(files.length>3||files.some(function(file){return file.size>5*1048576||!/\.(jpe?g|png|webp|heic|heif)$/i.test(file.name)}))errors.fotos=[t('se.max_photos')];
    if(Object.keys(errors).length){displayAcErrors(errors);toast(t('err'),true);return}
    var formData=new FormData();
    Object.keys(values).forEach(function(key){formData.append(key,values[key])});
    files.forEach(function(file){formData.append('fotos[]',file)});
    var button=$('#acSubmit');button.disabled=true;button.textContent=t('ac.saving');
    try{
        var result=await api(A.routes.createComplaint,'POST',formData);
        data.unshift(result.complaint);pushLog(result.log);
        $('#acModal').classList.add('hidden');refresh();toast(t('ac.created'));selectTicket(result.complaint.id);
    }catch(error){displayAcErrors(error.errors||{});toast(error.message,true)}
    finally{button.disabled=false;button.textContent=t('ac.submit')}
});
$('#bRefresh').onclick=function(){location.reload()};
$('#bPrint').onclick=function(){renderManage(true);window.print();renderManage(false)};
$('#bExport').onclick=function(){
    var p=new URLSearchParams();
    [['from','#mFrom'],['to','#mTo'],['status','#mStatus'],['kategori','#mKat'],['prioritas','#mPri']].forEach(function(x){var v=$(x[1]).value;if(v)p.set(x[0],v)});
    var q=p.toString();location.href=A.routes.export+(q?'?'+q:'');toast(t('ok.dl'));
};
$('#bulkClear').onclick=function(){checked.clear();renderManage(false)};
$$('[data-bulk]').forEach(function(b){b.onclick=async function(){
    var st=b.getAttribute('data-bulk'),ids=Array.from(checked);
    for(var k=0;k<ids.length;k++){
        try{var j=await api(url(A.routes.update,ids[k]),'PATCH',{status:st,notify:true});data=data.map(function(x){return x.id===ids[k]?j.complaint:x});pushLog(j.log)}
        catch(e){toast(e.message,true);break}
    }
    checked.clear();refresh();toast(t('ok.saved'));
}});

/* ---------- panel detail ---------- */
function selectTicket(id){
    var d=data.filter(function(x){return x.id===id})[0];if(!d)return;
    sel=id;selStatus=OPTS.indexOf(d.status)>=0?d.status:'Diterima';
    if(cur!=='masuk')go('masuk');else{renderManage(false);renderDetail()}
}
function closeDetail(){sel=null;renderDetail();if(cur==='masuk')renderManage(false)}
function detailHTML(d){
    var pets=[];data.forEach(function(x){if(x.petugas&&pets.indexOf(x.petugas)<0)pets.push(x.petugas)});
    var minEta=new Date(Date.now()+60000);minEta.setSeconds(0,0);
    var tl=d.riwayat.slice().reverse().map(function(h,i){return '<li><span class="dot '+(i?'off':'')+'"></span><div><b>'+esc(t('st.'+h.status))+(h.oleh?' — '+esc(h.oleh):'')+'</b>'+(h.catatan?sub(esc(h.catatan)):'')+sub(esc(when(h.waktu)))+'</div></li>'}).join('');
    var photo=d.fotos.length?d.fotos.map(function(u){return '<a class="ph" href="'+esc(u)+'" target="_blank" rel="noopener"><img src="'+esc(u)+'" alt=""><span>👁 '+esc(t('d.view'))+'</span></a>'}).join(''):'<div class="nophoto">'+esc(t('d.nophoto'))+'</div>';
    return '<div class="panel-top"><div><span class="pill '+d.prioritas+'">⚠ '+esc(t('d.pri'))+': '+esc(t('pr.'+d.prioritas)).toUpperCase()+'</span>'+tag(d.status)+'</div><button class="x" id="dClose" type="button">✕</button></div>'
+'<h3 class="dt">'+esc(t('d.title'))+' '+esc(d.tiket)+'</h3>'
+'<div class="info"><div class="g2"><div><small>'+esc(t('d.reporter'))+'</small><b>'+esc(d.nama)+'</b><span>NIS '+esc(d.nis)+'</span><span class="lnk">'+esc(d.kelas)+'</span></div><div><small>'+esc(t('d.time'))+'</small><b>'+esc(dayStr(d.waktu))+'</b><span>'+esc(timeStr(d.waktu))+'</span><span class="late">⏱ '+esc(ago(d.waktu))+'</span></div></div><div class="loc"><small>'+esc(t('d.loc'))+'</small><b>'+esc(d.kategori)+' • '+esc(d.lokasi)+'</b></div></div>'
+'<div class="sh">'+esc(t('d.desc'))+'</div><div class="quote">“'+esc(d.isi)+'”</div>'
+'<details class="md-edit"><summary>'+esc(t('ac.edit_data'))+'</summary><div class="md-grid" style="margin-top:12px"><div class="md-field"><label>'+esc(t('ac.subject'))+'</label><input id="dContentTitle" maxlength="150" value="'+esc(d.judul)+'"><small class="err" id="dErrorTitle"></small></div><div class="md-field"><label>'+esc(t('ac.category'))+'</label><select id="dContentCategory">'+CATS.map(function(category){return '<option value="'+esc(category)+'" '+(d.kategori===category?'selected':'')+'>'+esc(category)+'</option>'}).join('')+'</select><small class="err" id="dErrorCategory"></small></div><div class="md-field md-wide"><label>'+esc(t('ac.building'))+'</label><input id="dContentLocation" maxlength="250" value="'+esc(d.lokasi)+'"><small class="err" id="dErrorLocation"></small></div><div class="md-field md-wide"><label>'+esc(t('ac.description'))+'</label><textarea id="dContentBody" rows="4" maxlength="2000">'+esc(d.isi)+'</textarea><small class="err" id="dErrorBody"></small></div><div class="md-field md-wide"><button class="btn sm" type="button" id="dContentSave">'+esc(t('ac.save_data'))+'</button></div></div></details>'
+'<div class="sh">'+esc(t('d.photo'))+'</div>'+photo
+'<div class="proc"><h4>⚙ '+esc(t('d.process'))+'</h4><label>'+esc(t('d.setstatus'))+'</label>'
+'<div class="opts">'+OPTS.map(function(v){return '<button type="button" class="opt '+(selStatus===v?'on':'')+'" data-st="'+v+'"><b>'+esc(t('stl.'+v))+'</b><small>'+esc(t('sub.'+v))+'</small></button>'}).join('')+'</div>'
+'<div class="row2"><div><label>'+esc(t('d.pri'))+'</label><select id="fPri">'+PRI.map(function(p){return '<option value="'+p+'" '+(d.prioritas===p?'selected':'')+'>'+esc(t('pr.'+p))+'</option>'}).join('')+'</select></div>'
+'<div><label>'+esc(t('d.eta'))+'</label><input type="datetime-local" id="fEta" min="'+datetimeLocalValue(minEta)+'" value="'+esc(d.estimasi||'')+'"></div></div>'
+'<label>'+esc(t('d.assign'))+'</label><input id="fPet" list="dlPet" maxlength="100" value="'+esc(d.petugas||'')+'" placeholder="'+esc(t('d.assignph'))+'"><datalist id="dlPet">'+pets.map(function(p){return '<option value="'+esc(p)+'"></option>'}).join('')+'</datalist>'
+'<label>'+esc(t('d.reply'))+'</label><textarea id="fResp" rows="4" maxlength="1000" placeholder="'+esc(t('d.replyph'))+'">'+esc(d.tanggapan||'')+'</textarea>'
+'<label class="chk"><input type="checkbox" id="fNotify" checked> '+esc(t('d.notify'))+'</label>'
+'<div class="acts"><button class="btn grow" id="dSave" type="button">➤ '+esc(t('d.save'))+'</button><button class="btn ghost" id="dCloseB" type="button">'+esc(t('d.close'))+'</button></div>'
+'<button class="lnkbtn" id="dDel" type="button">🗑 '+esc(t('d.del'))+'</button></div>'
+'<div class="sh">'+esc(t('d.timeline'))+'</div><ul class="tl">'+tl+'</ul>';
}
function renderDetail(){
    var wrap=$('#detailWrap'),d=data.filter(function(x){return x.id===sel})[0];
    if(!d){sel=null;wrap.classList.add('hidden');$('#split').classList.remove('open');return}
    $('#detail').innerHTML=detailHTML(d);
    wrap.classList.remove('hidden');$('#split').classList.add('open');
    $$('#detail .opt').forEach(function(b){b.onclick=function(){selStatus=b.getAttribute('data-st');$$('#detail .opt').forEach(function(x){x.classList.toggle('on',x===b)})}});
    $('#dClose').onclick=closeDetail;$('#dCloseB').onclick=closeDetail;
    $('#dSave').onclick=saveDetail;$('#dDel').onclick=delDetail;
    $('#dContentSave').onclick=saveComplaintContent;
}
$('#detailWrap').addEventListener('click',function(e){if(e.target.id==='detailWrap')closeDetail()});
async function saveDetail(){
    var d=data.filter(function(x){return x.id===sel})[0];if(!d)return;
    var btn=$('#dSave');btn.disabled=true;
    var estimasi=$('#fEta').value;
    var body={status:selStatus,prioritas:$('#fPri').value,petugas:$('#fPet').value.trim(),estimasi:estimasi||null,estimasi_offset:estimasi?new Date(estimasi).getTimezoneOffset():null,tanggapan:$('#fResp').value.trim(),notify:$('#fNotify').checked};
    try{
        var j=await api(url(A.routes.update,d.id),'PATCH',body);
        data=data.map(function(x){return x.id===d.id?j.complaint:x});pushLog(j.log);
        refresh();toast(t('ok.saved'));
    }catch(e){toast(e.errors&&e.errors.estimasi?e.errors.estimasi[0]:e.message,true);btn.disabled=false}
}
async function saveComplaintContent(){
    var d=data.filter(function(x){return x.id===sel})[0];if(!d)return;
    ['#dErrorTitle','#dErrorCategory','#dErrorLocation','#dErrorBody'].forEach(function(id){$(id).textContent=''});
    var body={judul:$('#dContentTitle').value.trim(),kategori:$('#dContentCategory').value,lokasi:$('#dContentLocation').value.trim(),isi:$('#dContentBody').value.trim()};
    var errors={};
    if(!body.judul)errors.judul=t('se.title_error');
    if(!body.lokasi)errors.lokasi=t('se.building_error');
    if(body.isi.length<30)errors.isi=t('se.description_error');
    if(Object.keys(errors).length){
        if(errors.judul)$('#dErrorTitle').textContent=errors.judul;
        if(errors.lokasi)$('#dErrorLocation').textContent=errors.lokasi;
        if(errors.isi)$('#dErrorBody').textContent=errors.isi;
        toast(t('err'),true);return;
    }
    var button=$('#dContentSave');button.disabled=true;button.textContent=t('ac.saving');
    try{
        var result=await api(url(A.routes.update,d.id),'PATCH',body);
        data=data.map(function(item){return item.id===d.id?result.complaint:item});pushLog(result.log);
        refresh();toast(t('ac.saved_data'));
    }catch(error){
        var messages=error.errors||{};
        if(messages.judul)$('#dErrorTitle').textContent=messages.judul[0];
        if(messages.kategori)$('#dErrorCategory').textContent=messages.kategori[0];
        if(messages.lokasi)$('#dErrorLocation').textContent=messages.lokasi[0];
        if(messages.isi)$('#dErrorBody').textContent=messages.isi[0];
        toast(error.message,true);
    }finally{button.disabled=false;button.textContent=t('ac.save_data')}
}
async function delDetail(){
    var d=data.filter(function(x){return x.id===sel})[0];if(!d)return;
    if(!confirm(t('c.del')))return;
    try{
        var j=await api(url(A.routes.destroy,d.id),'DELETE');
        data=data.filter(function(x){return x.id!==d.id});checked.delete(d.id);pushLog(j.log);sel=null;
        refresh();toast(t('ok.del'));
    }catch(e){toast(e.message,true)}
}

/* ---------- REKAP ---------- */
function recapRows(){
    var f=$('#rFrom').value,to=$('#rTo').value,s=$('#rStatus').value,k=$('#rKat').value,student=$('#rStudent').value;
    return data.filter(function(d){return (!f||d.tanggal>=f)&&(!to||d.tanggal<=to)&&(!s||d.status===s)&&(!k||d.kategori===k)&&(!student||String(d.user_id)===student)}).sort(function(a,b){return new Date(a.waktu)-new Date(b.waktu)});
}
function renderRecapBreakdown(rows){
    var grouping=$('#rGroup').value,groups=Object.create(null);
    rows.forEach(function(report){
        var key,label;
        if(grouping==='student'){
            key=String(report.user_id);
            label=report.nama+' ('+(report.nis||'-')+')';
        }else if(grouping==='category'){
            key=report.kategori||'-';
            label=key;
        }else{
            key=(report.tanggal||'').slice(0,7);
            var parts=key.split('-');
            label=parts.length===2?new Intl.DateTimeFormat(loc(),{month:'long',year:'numeric'}).format(new Date(Number(parts[0]),Number(parts[1])-1,1)):key;
        }
        if(!groups[key])groups[key]={label:label,total:0,completed:0};
        groups[key].total++;
        if(report.status==='Selesai')groups[key].completed++;
    });
    $('#rBreakdown').innerHTML=Object.keys(groups).sort(function(a,b){
        return grouping==='student'
            ?groups[a].label.localeCompare(groups[b].label,loc())
            :a.localeCompare(b,loc(),{numeric:true});
    }).map(function(key){
        var group=groups[key];
        return '<tr><td>'+esc(group.label)+'</td><td>'+group.total+'</td><td>'+group.completed+'</td></tr>';
    }).join('')||'<tr><td colspan="3" class="empty">'+esc(t('r.empty'))+'</td></tr>';
}
function renderRekap(all){
    var rows=recapRows(),c=function(s){return rows.filter(function(d){return d.status===s}).length};
    $('#rSummary').innerHTML=esc(t('r.sum',{n:rows.length,a:c('Menunggu'),b:c('Diterima'),c:c('Diproses'),d:c('Selesai'),e:c('Ditolak')}));
    renderRecapBreakdown(rows);
    var pages=Math.max(1,Math.ceil(rows.length/PER));if(pg.rekap>pages)pg.rekap=pages;
    var off=all===true?0:(pg.rekap-1)*PER,page=all===true?rows:rows.slice(off,off+PER);
    $('#rekapBody').innerHTML=page.map(function(d,i){return '<tr><td>'+(off+i+1)+'</td><td>'+esc(d.tiket)+'</td><td>'+esc(dayOnly(d.tanggal))+'</td><td>'+esc(d.nama)+'</td><td>'+esc(d.kelas)+'</td><td>'+esc(d.kategori)+'</td><td>'+esc(d.lokasi)+'</td><td>'+esc(d.judul)+'</td><td>'+pri(d.prioritas)+'</td><td>'+tag(d.status)+'</td></tr>'}).join('')||'<tr><td colspan="10" class="empty">'+esc(t('r.empty'))+'</td></tr>';
    if(all===true){$('#rPager').innerHTML=''}else{pager($('#rPager'),rows.length,'rekap',function(){renderRekap(false)})}
}
['#rFrom','#rTo','#rStatus','#rKat','#rStudent','#rGroup'].forEach(function(s){$(s).addEventListener('input',function(){pg.rekap=1;renderRekap(false)})});
$('#rPrint').onclick=function(){renderRekap(true);window.print();renderRekap(false)};
$('#rCsv').onclick=function(){
    var p=new URLSearchParams();
    [['from','#rFrom'],['to','#rTo'],['student_id','#rStudent'],['status','#rStatus'],['kategori','#rKat']].forEach(function(x){var v=$(x[1]).value;if(v)p.set(x[0],v)});
    var q=p.toString();location.href=A.routes.export+(q?'?'+q:'');toast(t('ok.dl'));
};

/* ---------- RIWAYAT ---------- */
function filteredHistoryLogs(){
    var from=$('#hFrom').value,to=$('#hTo').value,role=$('#hRole').value,action=$('#hAction').value,query=$('#hSearch').value.trim().toLocaleLowerCase();
    return logs.filter(function(log){
        var date=new Date(log.waktu),day=date.getFullYear()+'-'+String(date.getMonth()+1).padStart(2,'0')+'-'+String(date.getDate()).padStart(2,'0');
        var searchable=(log.actor+' '+log.text).toLocaleLowerCase();
        return (!from||day>=from)&&(!to||day<=to)&&(!role||log.actor_role===role)&&(!action||log.aksi===action)&&(!query||searchable.indexOf(query)>=0);
    });
}
function renderHist(){
    var filtered=filteredHistoryLogs();
    var pages=Math.max(1,Math.ceil(filtered.length/PER));if(pg.riwayat>pages)pg.riwayat=pages;
    var off=(pg.riwayat-1)*PER;
    $('#histList').innerHTML=filtered.slice(off,off+PER).map(function(h){return '<li><span class="dot"></span><div>'+esc(h.text)+'<br><small>'+esc(h.actor)+' • '+esc(new Date(h.waktu).toLocaleString(loc()))+'</small></div></li>'}).join('')||'<li class="empty" style="display:block;width:100%">'+esc(t('h.empty'))+'</li>';
    pager($('#hPager'),filtered.length,'riwayat',renderHist);
}
function historyActionLabel(action){
    var labels={akun:'h.action.account',login:'h.action.login',logout:'h.action.logout',pengaduan:'h.action.complaint',sandi:'h.action.password',profil:'h.action.profile',pengguna:'h.action.users',hapus:'h.action.delete',riwayat:'h.action.history'};
    return labels[action]?t(labels[action]):action;
}
function csvCell(value){return '"'+String(value==null?'':value).replace(/"/g,'""')+'"'}
$('#historyCsv').onclick=function(){
    var rows=[['No','Waktu','Pelaku','Role','Jenis aktivitas','Deskripsi']];
    filteredHistoryLogs().forEach(function(log,index){
        rows.push([index+1,new Date(log.waktu).toLocaleString('id-ID'),log.actor,log.actor_role,historyActionLabel(log.aksi),log.text]);
    });
    var csv='\uFEFF'+rows.map(function(row){return row.map(csvCell).join(',')}).join('\r\n');
    var url=URL.createObjectURL(new Blob([csv],{type:'text/csv;charset=utf-8'}));
    var link=document.createElement('a');
    link.href=url;
    link.download='riwayat-aktivitas-'+new Date().toISOString().slice(0,10)+'.csv';
    document.body.appendChild(link);
    link.click();
    link.remove();
    setTimeout(function(){URL.revokeObjectURL(url)},1000);
};
['#hFrom','#hTo','#hRole','#hAction'].forEach(function(selector){$(selector).addEventListener('change',function(){pg.riwayat=1;renderHist()})});
$('#hSearch').addEventListener('input',function(){pg.riwayat=1;renderHist()});
$('#resetHistFilters').onclick=function(){
    ['#hFrom','#hTo','#hRole','#hAction','#hSearch'].forEach(function(selector){$(selector).value=''});
    pg.riwayat=1;renderHist();
};

/* ---------- PROFIL ---------- */
$('#pwForm').addEventListener('submit',function(e){
    if($('#pwNew').value!==$('#pwCon').value){e.preventDefault();$('#pwErr').textContent=t('pw.mis')}
});

/* ---------- init ---------- */
SP.apply();buildSelects();
var hash=location.hash.slice(1);
go(A.openPage||(PAGES.indexOf(hash)>=0?hash:'dashboard'));
})();
</script>
@endverbatim
@endif
@endguest
</body>
</html>
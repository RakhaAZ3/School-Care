<template>
  <div class="admin-layout">

    <!-- SIDEBAR -->
    <Sidebar
      :current-tab="currentTab"
      :pending-count="pendingCount"
      :is-collapsed="isCollapsed"
      @change-tab="changeTab"
      @toggle-sidebar="toggleSidebar"
      @logout="handleLogout"
    />

    <!-- MAIN -->
    <main
      class="main-area"
      :class="{ 'sidebar-collapsed': isCollapsed }"
    >

      <!-- NAVBAR -->
      <Navbar
        :page-title="pageTitle"
        :pending-count="pendingCount"
      />

      <!-- CONTENT -->
      <div class="page-content">

        <!-- ================= DASHBOARD ================= -->
        <section v-if="currentTab === 'dashboard'" class="dashboard-page">

          <!-- HEADER / JUDUL DIPERBARUI LEBIH ESTETIK -->
          <div class="welcome-section">
            <div class="welcome-text-wrapper">
              <div class="badge-pill">
                <span class="pulse-dot"></span>
                <span>Administrator Panel</span>
              </div>

              <h1>
                Dashboard Utama <span class="wave-emoji">👋</span>
              </h1>

              <p>
                Pantau seluruh inventaris, kelola ruangan, dan tinjau laporan fasilitas sekolah dalam satu kendali terpusat.
              </p>
            </div>

            <div class="date-card">
              <div class="date-icon-box">
                <i class="fa-regular fa-calendar-days"></i>
              </div>
              <div class="date-info">
                <small>Hari Ini</small>
                <span>{{ currentDate }}</span>
              </div>
            </div>
          </div>

          <!-- LOADING STATE / ERROR BANNER -->
          <div v-if="isLoading" class="alert-banner loading">
            <i class="fa-solid fa-spinner fa-spin"></i> Sinkronisasi data dengan server...
          </div>

          <!-- STATISTIK (Terhubung ke Data API) -->
          <div class="stats-grid">

            <div class="stat-card">
              <div class="stat-icon blue">
                <i class="fa-solid fa-door-open"></i>
              </div>

              <div>
                <span>Total Ruangan</span>
                <strong>{{ roomsList.length }}</strong>
              </div>
            </div>

            <div class="stat-card">
              <div class="stat-icon purple">
                <i class="fa-solid fa-boxes-stacked"></i>
              </div>

              <div>
                <span>Total Fasilitas</span>
                <strong>{{ totalFacilities }}</strong>
              </div>
            </div>

            <div class="stat-card">
              <div class="stat-icon orange">
                <i class="fa-solid fa-clock"></i>
              </div>

              <div>
                <span>Pengajuan Pending</span>
                <strong>{{ pendingCount }}</strong>
              </div>
            </div>

            <div class="stat-card">
              <div class="stat-icon green">
                <i class="fa-solid fa-screwdriver-wrench"></i>
              </div>

              <div>
                <span>Maintenance</span>
                <strong>{{ maintenanceList.length }}</strong>
              </div>
            </div>

          </div>

          <!-- BAGIAN BAWAH -->
          <div class="dashboard-grid">

            <!-- KONDISI FASILITAS -->
            <div class="dashboard-card condition-card">

              <div class="card-heading">
                <div>
                  <span class="card-label">INVENTARIS</span>
                  <h2>Kondisi Fasilitas</h2>
                </div>

                <div class="condition-percent">
                  {{ goodPercentage }}%
                </div>
              </div>

              <div class="condition-progress">
                <div
                  class="condition-fill"
                  :style="{ width: `${goodPercentage}%` }"
                ></div>
              </div>

              <div class="condition-info">

                <div>
                  <span class="dot good"></span>
                  <div>
                    <strong>{{ totalGood }}</strong>
                    <small>Baik</small>
                  </div>
                </div>

                <div>
                  <span class="dot broken"></span>
                  <div>
                    <strong>{{ totalBroken }}</strong>
                    <small>Rusak</small>
                  </div>
                </div>

              </div>

            </div>

            <!-- AKSI CEPAT -->
            <div class="dashboard-card">

              <div class="card-heading">
                <div>
                  <span class="card-label">MENU</span>
                  <h2>Aksi Cepat</h2>
                </div>
              </div>

              <div class="quick-actions">

                <button
                  type="button"
                  @click="changeTab('fasilitas')"
                >
                  <span class="quick-icon blue">
                    <i class="fa-solid fa-box"></i>
                  </span>

                  <div>
                    <strong>Fasilitas</strong>
                    <small>Kelola fasilitas</small>
                  </div>

                  <i class="fa-solid fa-chevron-right arrow"></i>
                </button>

                <button
                  type="button"
                  @click="changeTab('ruangan')"
                >
                  <span class="quick-icon purple">
                    <i class="fa-solid fa-door-open"></i>
                  </span>

                  <div>
                    <strong>Ruangan</strong>
                    <small>Kelola ruangan</small>
                  </div>

                  <i class="fa-solid fa-chevron-right arrow"></i>
                </button>

                <button
                  type="button"
                  @click="changeTab('pengajuan')"
                >
                  <span class="quick-icon orange">
                    <i class="fa-solid fa-file-circle-check"></i>
                  </span>

                  <div>
                    <strong>Pengajuan</strong>
                    <small>Periksa pengajuan</small>
                  </div>

                  <i class="fa-solid fa-chevron-right arrow"></i>
                </button>

                <button
                  type="button"
                  @click="changeTab('laporan')"
                >
                  <span class="quick-icon red">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                  </span>

                  <div>
                    <strong>Laporan</strong>
                    <small>Lihat laporan kerusakan</small>
                  </div>

                  <i class="fa-solid fa-chevron-right arrow"></i>
                </button>

              </div>

            </div>

          </div>

        </section>

        <!-- ================= HALAMAN LAIN ================= -->

        <RouterView v-else />

      </div>

      <!-- FOOTER -->
      <Footer />

    </main>

  </div>
</template>

<script setup>
import { computed, ref, onMounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'

import Sidebar from '../components/Sidebar.vue'
import Navbar from '../components/Navbar.vue'
import Footer from '../components/Footer.vue'

const router = useRouter()
const route = useRoute()

/* =========================
   STATE KONTROL & API
========================= */
const isCollapsed = ref(false)
const isLoading = ref(false)

const toggleSidebar = () => {
  isCollapsed.value = !isCollapsed.value
}

/* =========================
   SUMBER DATA DINAMIS (API READY)
========================= */
const roomsList = ref([])
const facilitiesList = ref([])
const pengajuanList = ref([])
const maintenanceList = ref([])

// Fungsi untuk menarik data dari Backend API
const fetchDashboardData = async () => {
  isLoading.value = true
  try {
    // TIPS: Ganti URL di bawah ini dengan base URL backend kamu (misal: 'http://localhost:8000/api')
    // const API_BASE = 'http://localhost:5000/api'
    
    // Karena backend belum aktif, kita sediakan fallback data aman agar aplikasi tidak error/blank
    // Nanti tinggal uncomment fetch di bawah jika backend sudah siap:
    /*
    const [resRooms, resFacilities, resPengajuan, resMaintenance] = await Promise.all([
      fetch(`${API_BASE}/rooms`).then(res => res.json()),
      fetch(`${API_BASE}/facilities`).then(res => res.json()),
      fetch(`${API_BASE}/submissions`).then(res => res.json()),
      fetch(`${API_BASE}/maintenance`).then(res => res.json()),
    ])

    roomsList.value = resRooms.data || []
    facilitiesList.value = resFacilities.data || []
    pengajuanList.value = resPengajuan.data || []
    maintenanceList.value = resMaintenance.data || []
    */

    // --- FALLBACK MOCK DATA SEMENTARA (Akan otomatis diganti data API nantinya) ---
    roomsList.value = [
      { id: 1, code: 'R-01', name: 'Lab Komputer 1', capacity: 30, location: 'Gedung A Lt. 2', status: 'Tersedia' },
      { id: 2, code: 'R-02', name: 'Ruang Multimedia', capacity: 50, location: 'Gedung B Lt. 1', status: 'Dipakai' },
      { id: 3, code: 'R-03', name: 'Aula Utama', capacity: 200, location: 'Gedung Utama', status: 'Tersedia' },
      { id: 4, code: 'R-04', name: 'Lab RPL', capacity: 36, location: 'Gedung A Lt. 3', status: 'Tersedia' }
    ]

    facilitiesList.value = [
      { id: 1, name: 'Proyektor Epson EB-X400', category: 'Elektronik', total: 15, good: 14, broken: 1 },
      { id: 2, name: 'Laptop Core i5 Lenovo', category: 'Komputer', total: 40, good: 38, broken: 2 },
      { id: 3, name: 'Meja Siswa Ergonomis', category: 'Mebel', total: 300, good: 295, broken: 5 },
      { id: 4, name: 'Kursi Siswa', category: 'Mebel', total: 320, good: 314, broken: 6 }
    ]

    pengajuanList.value = [
      // Jika data kosong atau status != 'Pending', pendingCount otomatis 0
    ]

    maintenanceList.value = [
      { id: 1, unit: 'AC Ruang Kelas 10-A', technician: 'Pak Joko (Teknisi)', estimate: '18 Sep 2026', progress: 'Penggantian Freon' },
      { id: 2, unit: 'Proyektor Lab 2', technician: 'Pak Rudi', estimate: '16 Sep 2026', progress: 'Pengecekan Lampu' },
      { id: 3, unit: 'Pintu Lab Komputer', technician: 'Pak Andi', estimate: '20 Sep 2026', progress: 'Penggantian Kunci' }
    ]

  } catch (error) {
    console.error('Gagal mengambil data dari server backend:', error)
  } finally {
    isLoading.value = false
  }
}

// Panggil fungsi API saat komponen dimuat (Mounted)
onMounted(() => {
  fetchDashboardData()
})

/* =========================
   CURRENT TAB & ROUTING
========================= */
const currentTab = computed(() => {
  const routeName = route.name
  const menuMap = {
    AdminDashboardHome: 'dashboard',
    AdminRuangan: 'ruangan',
    AdminFasilitas: 'fasilitas',
    AdminKategori: 'kategori',
    AdminPengajuan: 'pengajuan',
    AdminLaporan: 'laporan',
    AdminMaintenance: 'maintenance'
  }
  return menuMap[routeName] || 'dashboard'
})

const pageTitle = computed(() => {
  const titles = {
    dashboard: 'Dashboard',
    ruangan: 'Manajemen Ruangan',
    fasilitas: 'Fasilitas & Barang',
    kategori: 'Kategori Inventaris',
    pengajuan: 'Pengajuan',
    laporan: 'Laporan Kerusakan',
    maintenance: 'Maintenance & Perbaikan'
  }
  return titles[currentTab.value] || 'Dashboard'
})

/* =========================
   COMPUTED LOGIC (Dihitung Otomatis dari API)
========================= */
const totalFacilities = computed(() => {
  return facilitiesList.value.reduce((total, item) => total + (item.total || 0), 0)
})

const totalGood = computed(() => {
  return facilitiesList.value.reduce((total, item) => total + (item.good || 0), 0)
})

const totalBroken = computed(() => {
  return facilitiesList.value.reduce((total, item) => total + (item.broken || 0), 0)
})

const goodPercentage = computed(() => {
  if (totalFacilities.value === 0) return 0
  return Math.round((totalGood.value / totalFacilities.value) * 100)
})

const pendingCount = computed(() => {
  return pengajuanList.value.filter(item => item.status === 'Pending').length
})

const currentDate = computed(() => {
  const date = new Date()
  return date.toLocaleDateString('id-ID', {
    day: '2-digit',
    month: 'long',
    year: 'numeric'
  })
})

/* =========================
   NAVIGASI & AUTH
========================= */
const changeTab = (tab) => {
  const routes = {
    dashboard: '/admin/dashboard',
    ruangan: '/admin/ruangan',
    fasilitas: '/admin/fasilitas',
    kategori: '/admin/kategori',
    pengajuan: '/admin/pengajuan',
    laporan: '/admin/laporan',
    maintenance: '/admin/maintenance'
  }
  if (routes[tab]) {
    router.push(routes[tab])
  }
}

const handleLogout = () => {
  const confirmed = confirm('Keluar dari panel administrator?')
  if (!confirmed) return
  localStorage.removeItem('isLoggedIn')
  router.push('/login')
}
</script>

<style scoped>
* {
  box-sizing: border-box;
}

.admin-layout {
  min-height: 100vh;
  background: #f8fafc;
  color: #0f172a;
  font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
}

.main-area {
  min-height: 100vh;
  margin-left: 250px;
  transition: margin-left .3s ease;
}

.main-area.sidebar-collapsed {
  margin-left: 78px;
}

.page-content {
  min-height: calc(100vh - 150px);
  padding: 28px;
}

.alert-banner.loading {
  background: #eff6ff;
  border: 1px solid #bfdbfe;
  color: #1d4ed8;
  padding: 12px 18px;
  border-radius: 12px;
  font-size: 0.85rem;
  font-weight: 600;
  margin-bottom: 20px;
  display: flex;
  align-items: center;
  gap: 10px;
}

/* =========================================
   REDESIGNED WELCOME / HEADER SECTION
========================================= */
.welcome-section {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 20px;
  margin-bottom: 30px;
  background: linear-gradient(135deg, #ffffff 0%, #f1f5f9 100%);
  border: 1px solid #e2e8f0;
  padding: 28px 32px;
  border-radius: 20px;
  box-shadow: 0 4px 20px rgba(15, 23, 42, 0.03);
}

.badge-pill {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  background: #eff6ff;
  border: 1px solid #dbeafe;
  color: #2563eb;
  padding: 5px 12px;
  border-radius: 50px;
  font-size: 0.7rem;
  font-weight: 700;
  letter-spacing: 0.03em;
  margin-bottom: 10px;
}

.pulse-dot {
  width: 7px;
  height: 7px;
  background: #2563eb;
  border-radius: 50%;
  box-shadow: 0 0 0 rgba(37, 99, 235, 0.4);
  animation: pulse 2s infinite;
}

@keyframes pulse {
  0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(37, 99, 235, 0.4); }
  70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(37, 99, 235, 0); }
  100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(37, 99, 235, 0); }
}

.welcome-text-wrapper h1 {
  margin: 0;
  font-size: 1.85rem;
  font-weight: 800;
  color: #0f172a;
  letter-spacing: -.03em;
  display: flex;
  align-items: center;
  gap: 8px;
}

.wave-emoji {
  font-size: 1.6rem;
  animation: wave 1.8s infinite;
  transform-origin: 70% 70%;
  display: inline-block;
}

@keyframes wave {
  0% { transform: rotate(0deg); }
  10% { transform: rotate(14deg); }
  20% { transform: rotate(-8deg); }
  30% { transform: rotate(14deg); }
  40% { transform: rotate(-4deg); }
  50% { transform: rotate(10deg); }
  60% { transform: rotate(0deg); }
  100% { transform: rotate(0deg); }
}

.welcome-text-wrapper p {
  margin: 8px 0 0;
  color: #64748b;
  font-size: 0.9rem;
  line-height: 1.5;
  max-width: 600px;
}

.date-card {
  display: flex;
  align-items: center;
  gap: 14px;
  padding: 14px 18px;
  background: #ffffff;
  border: 1px solid #e2e8f0;
  border-radius: 16px;
  box-shadow: 0 2px 10px rgba(15, 23, 42, 0.02);
  flex-shrink: 0;
}

.date-icon-box {
  width: 42px;
  height: 42px;
  background: #eff6ff;
  color: #2563eb;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.1rem;
}

.date-info small {
  display: block;
  color: #94a3b8;
  font-size: 0.65rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.05em;
  margin-bottom: 2px;
}

.date-info span {
  display: block;
  color: #0f172a;
  font-size: 0.85rem;
  font-weight: 700;
}

.card-label {
  display: block;
  margin-bottom: 4px;
  color: #94a3b8;
  font-size: .55rem;
}

/* STATS GRID */
.stats-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 16px;
  margin-bottom: 20px;
}

.stat-card {
  display: flex;
  align-items: center;
  gap: 14px;
  min-height: 105px;
  padding: 20px;
  background: #fff;
  border: 1px solid #e2e8f0;
  border-radius: 16px;
  box-shadow: 0 5px 20px rgba(15, 23, 42, .04);
}

.stat-icon {
  width: 45px;
  height: 45px;
  flex-shrink: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 13px;
  font-size: 1rem;
}

.stat-icon.blue, .quick-icon.blue { background: #eff6ff; color: #2563eb; }
.stat-icon.purple, .quick-icon.purple { background: #f5f3ff; color: #7c3aed; }
.stat-icon.orange, .quick-icon.orange { background: #fff7ed; color: #ea580c; }
.stat-icon.green { background: #f0fdf4; color: #16a34a; }

.stat-card span {
  display: block;
  margin-bottom: 5px;
  color: #64748b;
  font-size: .68rem;
  font-weight: 600;
}

.stat-card strong {
  color: #0f172a;
  font-size: 1.45rem;
  font-weight: 800;
}

/* DASHBOARD GRID */
.dashboard-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 20px;
}

.dashboard-card {
  padding: 22px;
  background: #fff;
  border: 1px solid #e2e8f0;
  border-radius: 17px;
  box-shadow: 0 5px 20px rgba(15, 23, 42, .04);
}

.card-heading {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 15px;
}

.card-heading h2 {
  margin: 0;
  font-size: 1rem;
  font-weight: 800;
}

/* CONDITION */
.condition-percent {
  color: #16a34a;
  font-size: 1.3rem;
  font-weight: 800;
}

.condition-progress {
  width: 100%;
  height: 10px;
  margin: 27px 0 22px;
  overflow: hidden;
  background: #f1f5f9;
  border-radius: 20px;
}

.condition-fill {
  height: 100%;
  border-radius: inherit;
  background: linear-gradient(90deg, #2563eb, #7c3aed);
}

.condition-info {
  display: flex;
  gap: 35px;
}

.condition-info > div {
  display: flex;
  align-items: center;
  gap: 9px;
}

.dot {
  width: 9px;
  height: 9px;
  border-radius: 50%;
}
.dot.good { background: #22c55e; }
.dot.broken { background: #ef4444; }

.condition-info strong { display: block; font-size: .9rem; }
.condition-info small { display: block; margin-top: 2px; color: #94a3b8; font-size: .62rem; }

/* QUICK ACTION */
.quick-actions {
  display: grid;
  gap: 8px;
  margin-top: 15px;
}

.quick-actions button {
  width: 100%;
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 10px;
  border: 0;
  background: transparent;
  border-radius: 12px;
  text-align: left;
  cursor: pointer;
  transition: .2s ease;
}

.quick-actions button:hover {
  background: #f8fafc;
}

.quick-icon {
  width: 37px;
  height: 37px;
  flex-shrink: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 10px;
  font-size: .8rem;
}

.quick-icon.red { background: #fef2f2; color: #dc2626; }
.quick-actions button div { flex: 1; }
.quick-actions strong { display: block; color: #334155; font-size: .72rem; font-weight: 800; }
.quick-actions small { display: block; margin-top: 2px; color: #94a3b8; font-size: .58rem; }
.arrow { color: #cbd5e1; font-size: .6rem; }

/* RESPONSIVE */
@media (max-width: 1100px) {
  .stats-grid { grid-template-columns: repeat(2, 1fr); }
  .dashboard-grid { grid-template-columns: 1fr; }
}

@media (max-width: 768px) {
  .main-area { margin-left: 78px; }
  .main-area.sidebar-collapsed { margin-left: 0; }
  .page-content { padding: 20px; }
  .welcome-section { align-items: flex-start; flex-direction: column; padding: 20px; }
}

@media (max-width: 600px) {
  .stats-grid { grid-template-columns: 1fr; }
  .welcome-text-wrapper h1 { font-size: 1.5rem; }
}
</style>
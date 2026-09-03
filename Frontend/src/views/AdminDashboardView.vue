<template>
  <div class="admin-layout">
    <!-- Sidebar / Menu Samping Admin -->
    <aside class="admin-sidebar">
      <div class="sidebar-brand">
        <span class="brand-icon">🏫</span>
        <h2>School<span class="text-primary">Care</span></h2>
        <span class="badge-role">Admin</span>
      </div>

      <ul class="sidebar-menu">
        <li :class="{ active: activeTab === 'dashboard' }" @click="activeTab = 'dashboard'">
          <span>📊</span> Dashboard & Statistik
        </li>
        <li :class="{ active: activeTab === 'sarpras' }" @click="activeTab = 'sarpras'">
          <span>📦</span> Data Sarpras
        </li>
        <li :class="{ active: activeTab === 'kategori' }" @click="activeTab = 'kategori'">
          <span>🏷️</span> Kelola Kategori & Ruangan
        </li>
        <li :class="{ active: activeTab === 'peminjaman' }" @click="activeTab = 'peminjaman'">
          <span>📋</span> Kelola Peminjaman
        </li>
        <li :class="{ active: activeTab === 'laporan' }" @click="activeTab = 'laporan'">
          <span>🚨</span> Laporan Kerusakan
        </li>
        <li :class="{ active: activeTab === 'users' }" @click="activeTab = 'users'">
          <span>👥</span> Kelola Akun Pengguna
        </li>
      </ul>

      <div class="sidebar-footer">
        <button class="btn-logout" @click="handleLogout">
          <span>🚪</span> Keluar / Logout
        </button>
      </div>
    </aside>

    <!-- Main Content Area -->
    <main class="admin-main">
      <!-- Top Navbar Admin -->
      <header class="admin-header">
        <div class="header-title">
          <h1>{{ getPageTitle }}</h1>
          <p>Halo, Admin! Selamat datang kembali di panel kontrol sistem.</p>
        </div>
        <div class="header-actions">
          <button class="btn-export excel" @click="exportData('excel')">
            <span>📊</span> Export Excel
          </button>
          <button class="btn-export pdf" @click="exportData('pdf')">
            <span>📄</span> Export PDF
          </button>
          <div class="admin-profile-chip">
            <div class="avatar">A</div>
            <span>Administrator</span>
          </div>
        </div>
      </header>

      <!-- Dynamic Content Based on Tab -->
      <div class="admin-content-body">
        
        <!-- 1. DASHBOARD & STATISTIK (Jika tab 'dashboard' dipilih) -->
        <section v-if="activeTab === 'dashboard'" class="dashboard-section">
          <!-- Grid Statistik Utama -->
          <div class="dashboard-stats-grid">
            <div class="stat-card">
              <div class="stat-icon blue">📦</div>
              <div>
                <small>Total Sarpras</small>
                <h3>142 Unit</h3>
              </div>
            </div>
            <div class="stat-card">
              <div class="stat-icon yellow">⏳</div>
              <div>
                <small>Peminjaman Pending</small>
                <h3>5 Permintaan</h3>
              </div>
            </div>
            <div class="stat-card">
              <div class="stat-icon red">🚨</div>
              <div>
                <small>Laporan Kerusakan</small>
                <h3>3 Barang</h3>
              </div>
            </div>
            <div class="stat-card">
              <div class="stat-icon green">🏫</div>
              <div>
                <small>Ruangan Tersedia</small>
                <h3>28 Ruang</h3>
              </div>
            </div>
          </div>

          <!-- Bagian Aktivitas & Ringkasan Tambahan -->
          <div class="dashboard-grid-2">
            <div class="content-card">
              <div class="card-header-flex" style="margin-bottom: 16px;">
                <div>
                  <h2>Aktivitas Terbaru</h2>
                  <p>Log aktivitas peminjaman dan laporan masuk secara real-time.</p>
                </div>
              </div>
              <ul class="activity-list">
                <li class="activity-item">
                  <span class="activity-dot blue"></span>
                  <div class="activity-desc">
                    <strong>Budi (Guru)</strong> mengajukan peminjaman <em>Proyektor Epson</em>
                    <small>10 Menit yang lalu</small>
                  </div>
                </li>
                <li class="activity-item">
                  <span class="activity-dot red"></span>
                  <div class="activity-desc">
                    <strong>Siti Rahma</strong> melaporkan kerusakan <em>AC Ruang Kelas 10-A</em>
                    <small>1 Jam yang lalu</small>
                  </div>
                </li>
                <li class="activity-item">
                  <span class="activity-dot green"></span>
                  <div class="activity-desc">
                    <strong>Admin</strong> menyetujui peminjaman <em>Kamera DSLR Lab</em>
                    <small>3 Jam yang lalu</small>
                  </div>
                </li>
              </ul>
            </div>

            <div class="content-card">
              <div class="card-header-flex" style="margin-bottom: 16px;">
                <div>
                  <h2>Status Sistem</h2>
                  <p>Kondisi kesiapan infrastruktur dan server sekolah.</p>
                </div>
              </div>
              <div class="system-status-box">
                <div class="status-row">
                  <span>Server Database</span>
                  <span class="badge-tag admin">Normal (99.9%)</span>
                </div>
                <div class="status-row">
                  <span>Koneksi Jaringan Sekolah</span>
                  <span class="badge-tag guru">Stabil</span>
                </div>
                <div class="status-row">
                  <span>Pencadangan Otomatis</span>
                  <span class="badge-tag siswa">Aktif (Hari ini)</span>
                </div>
              </div>
            </div>
          </div>
        </section>

        <!-- 2. KELOLA AKUN PENGGUNA (Jika tab 'users' dipilih) -->
        <section v-else-if="activeTab === 'users'" class="content-card">
          <div class="card-header-flex">
            <div>
              <h2>Manajemen Akun Pengguna</h2>
              <p>Tambah, edit, atau hapus hak akses pengguna aplikasi SchoolCare.</p>
            </div>
            <button class="btn-primary-sm" @click="openUserModal">＋ Tambah User Baru</button>
          </div>

          <div class="table-responsive">
            <table class="data-table">
              <thead>
                <tr>
                  <th>Nama Lengkap</th>
                  <th>Email</th>
                  <th>Role / Peran</th>
                  <th>Status</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="user in dummyUsers" :key="user.id">
                  <td><strong>{{ user.name }}</strong></td>
                  <td>{{ user.email }}</td>
                  <td><span class="badge-tag" :class="user.role">{{ user.role }}</span></td>
                  <td><span class="status-dot active"></span> Aktif</td>
                  <td>
                    <button class="btn-action edit" @click="editUser(user)">Edit</button>
                    <button class="btn-action delete" @click="deleteUser(user.id)">Hapus</button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </section>

        <!-- 3. DEFAULT / MODUL LAINNYA -->
        <section v-else class="content-card placeholder-card">
          <div class="empty-state">
            <span class="empty-icon">🛠️</span>
            <h3>Modul {{ getPageTitle }}</h3>
            <p>Bagian ini akan menampilkan tabel data, form CRUD, atau statistik mendetail sesuai menu yang kamu pilih di sebelah kiri.</p>
          </div>
        </section>

      </div>
    </main>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const activeTab = ref('dashboard') // Default dibuka ke dashboard utama

// Judul dinamis sesuai tab aktif
const getPageTitle = computed(() => {
  const titles = {
    dashboard: 'Dashboard Utama',
    sarpras: 'Data Sarana & Prasarana',
    kategori: 'Kelola Kategori & Ruangan',
    peminjaman: 'Persetujuan Peminjaman',
    laporan: 'Laporan Kerusakan Fasilitas',
    users: 'Kelola Akun Pengguna'
  }
  return titles[activeTab.value] || 'Panel Admin'
})

// Contoh data dummy untuk Kelola Akun Pengguna
const dummyUsers = ref([
  { id: 1, name: 'Budi Santoso, S.Pd', email: 'budi@schoolcare.app', role: 'admin' },
  { id: 2, name: 'Siti Rahma, M.Kom', email: 'siti@schoolcare.app', role: 'guru' },
  { id: 3, name: 'Ahmad Fauzi', email: 'fauzi@student.schoolcare.app', role: 'siswa' },
])

const openUserModal = () => {
  alert('Form Tambah User baru akan muncul di sini (bisa pakai modal pop-up)!')
}

const editUser = (user) => {
  alert(`Edit data untuk: ${user.name}`)
}

const deleteUser = (id) => {
  dummyUsers.value = dummyUsers.value.filter(u => u.id !== id)
}

// Simulasi fungsi export Excel/PDF
const exportData = (type) => {
  if (type === 'excel') {
    alert('Mendownload laporan ke format Excel (.xlsx)... Berhasil!')
  } else {
    alert('Mendownload laporan ke format PDF (.pdf)... Berhasil!')
  }
}

const handleLogout = () => {
  // Hapus status login di localStorage saat logout
  localStorage.removeItem('isLoggedIn')
  router.push('/')
}
</script>

<style scoped>
.admin-layout {
  display: flex;
  min-height: 100vh;
  background: #f1f5f9;
  font-family: 'Plus Jakarta Sans', sans-serif;
  color: #1e293b;
  text-align: left;
}

/* Sidebar */
.admin-sidebar {
  width: 280px;
  background: #0f172a;
  color: #f8fafc;
  display: flex;
  flex-direction: column;
  border-right: 1px solid #1e293b;
}

.sidebar-brand {
  padding: 24px;
  display: flex;
  align-items: center;
  gap: 12px;
  border-bottom: 1px solid #1e293b;
}
.sidebar-brand h2 { margin: 0; font-size: 1.25rem; color: white; }
.badge-role { font-size: 0.7rem; background: #2563eb; color: white; padding: 2px 8px; border-radius: 10px; margin-left: auto; }

.sidebar-menu {
  list-style: none;
  padding: 16px;
  margin: 0;
  display: flex;
  flex-direction: column;
  gap: 6px;
  flex-grow: 1;
}

.sidebar-menu li {
  padding: 12px 16px;
  border-radius: 12px;
  cursor: pointer;
  font-weight: 600;
  font-size: 0.95rem;
  color: #94a3b8;
  display: flex;
  align-items: center;
  gap: 12px;
  transition: all 0.2s ease;
}

.sidebar-menu li:hover {
  background: rgba(255, 255, 255, 0.05);
  color: white;
}

.sidebar-menu li.active {
  background: #2563eb;
  color: white;
  box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
}

.sidebar-footer { padding: 20px; border-top: 1px solid #1e293b; }
.btn-logout {
  width: 100%;
  background: rgba(239, 68, 68, 0.1);
  color: #ef4444;
  border: 1px solid rgba(239, 68, 68, 0.2);
  padding: 12px;
  border-radius: 12px;
  font-weight: 700;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  transition: all 0.2s;
}
.btn-logout:hover { background: #ef4444; color: white; }

/* Main Content */
.admin-main { flex-grow: 1; display: flex; flex-direction: column; overflow-x: auto; }

.admin-header {
  background: white;
  padding: 20px 32px;
  border-bottom: 1px solid #e2e8f0;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.header-title h1 { margin: 0 0 4px 0; font-size: 1.5rem; font-weight: 800; color: #0f172a; }
.header-title p { margin: 0; color: #64748b; font-size: 0.9rem; }

.header-actions { display: flex; align-items: center; gap: 12px; }

.btn-export {
  padding: 10px 16px;
  border-radius: 10px;
  font-weight: 700;
  font-size: 0.85rem;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 6px;
  border: 1px solid #cbd5e1;
  background: white;
  transition: all 0.2s;
}
.btn-export.excel:hover { border-color: #16a34a; color: #16a34a; background: #f0fdf4; }
.btn-export.pdf:hover { border-color: #dc2626; color: #dc2626; background: #fef2f2; }

.admin-profile-chip {
  display: flex;
  align-items: center;
  gap: 8px;
  background: #f8fafc;
  padding: 6px 14px;
  border-radius: 20px;
  border: 1px solid #e2e8f0;
  font-weight: 600;
  font-size: 0.9rem;
}
.avatar {
  width: 28px; height: 28px; background: #2563eb; color: white;
  border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 0.8rem;
}

/* Content Body */
.admin-content-body { padding: 32px; flex-grow: 1; display: flex; flex-direction: column; gap: 24px; }

/* Dashboard Styles */
.dashboard-stats-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 20px;
}

.stat-card {
  background: white;
  padding: 20px;
  border-radius: 16px;
  border: 1px solid #e2e8f0;
  display: flex;
  align-items: center;
  gap: 16px;
  box-shadow: 0 2px 8px rgba(15, 23, 42, 0.02);
}

.stat-icon {
  width: 48px;
  height: 48px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.4rem;
}
.stat-icon.blue { background: #eff6ff; }
.stat-icon.yellow { background: #fef3c7; }
.stat-icon.red { background: #fef2f2; }
.stat-icon.green { background: #f0fdf4; }

.stat-card small { color: #64748b; font-size: 0.8rem; font-weight: 600; }
.stat-card h3 { color: #0f172a; font-size: 1.35rem; margin: 2px 0 0 0; font-weight: 800; }

.dashboard-grid-2 {
  display: grid;
  grid-template-columns: 1.2fr 0.8fr;
  gap: 24px;
}

.activity-list {
  list-style: none;
  padding: 0;
  margin: 0;
  display: flex;
  flex-direction: column;
  gap: 16px;
}

.activity-item {
  display: flex;
  align-items: flex-start;
  gap: 12px;
  font-size: 0.9rem;
  color: #334155;
  border-bottom: 1px solid #f1f5f9;
  padding-bottom: 12px;
}

.activity-dot {
  width: 10px;
  height: 10px;
  border-radius: 50%;
  margin-top: 5px;
  flex-shrink: 0;
}
.activity-dot.blue { background: #2563eb; }
.activity-dot.red { background: #ef4444; }
.activity-dot.green { background: #22c55e; }

.activity-desc { display: flex; flex-direction: column; gap: 2px; }
.activity-desc small { color: #94a3b8; font-size: 0.75rem; }

.system-status-box {
  display: flex;
  flex-direction: column;
  gap: 14px;
}

.status-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
  font-size: 0.9rem;
  font-weight: 600;
  color: #475569;
  background: #f8fafc;
  padding: 12px 16px;
  border-radius: 12px;
  border: 1px solid #f1f5f9;
}

/* Content Card */
.content-card {
  background: white;
  border-radius: 20px;
  border: 1px solid #e2e8f0;
  padding: 24px;
  box-shadow: 0 4px 16px rgba(15, 23, 42, 0.02);
}

.card-header-flex {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 24px;
}
.card-header-flex h2 { margin: 0 0 4px 0; font-size: 1.2rem; }
.card-header-flex p { margin: 0; color: #64748b; font-size: 0.9rem; }

.btn-primary-sm {
  background: #2563eb;
  color: white;
  border: none;
  padding: 10px 18px;
  border-radius: 10px;
  font-weight: 700;
  cursor: pointer;
  box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
}

/* Table Styling */
.table-responsive { width: 100%; overflow-x: auto; }
.data-table { width: 100%; border-collapse: collapse; text-align: left; }
.data-table th { padding: 12px 16px; background: #f8fafc; color: #475569; font-size: 0.85rem; font-weight: 700; border-bottom: 1px solid #e2e8f0; }
.data-table td { padding: 14px 16px; border-bottom: 1px solid #f1f5f9; font-size: 0.9rem; color: #334155; }

.badge-tag {
  padding: 4px 10px;
  border-radius: 8px;
  font-size: 0.75rem;
  font-weight: 700;
  text-transform: uppercase;
}
.badge-tag.admin { background: #eff6ff; color: #2563eb; }
.badge-tag.guru { background: #f5f3ff; color: #7c3aed; }
.badge-tag.siswa { background: #f0fdf4; color: #16a34a; }

.status-dot {
  height: 8px; width: 8px; background-color: #22c55e; border-radius: 50%; display: inline-block; margin-right: 6px;
}

.btn-action {
  padding: 6px 12px;
  border-radius: 8px;
  font-size: 0.8rem;
  font-weight: 600;
  cursor: pointer;
  border: none;
  margin-right: 6px;
}
.btn-action.edit { background: #f1f5f9; color: #475569; }
.btn-action.edit:hover { background: #e2e8f0; }
.btn-action.delete { background: #fef2f2; color: #ef4444; }
.btn-action.delete:hover { background: #fee2e2; }

/* Empty Placeholder */
.placeholder-card { min-height: 400px; display: flex; align-items: center; justify-content: center; }
.empty-state { text-align: center; color: #64748b; }
.empty-icon { font-size: 3rem; margin-bottom: 12px; display: block; }
.empty-state h3 { margin: 0 0 8px 0; color: #0f172a; font-size: 1.2rem; }
.empty-state p { max-width: 400px; margin: 0 auto; font-size: 0.95rem; }
</style>
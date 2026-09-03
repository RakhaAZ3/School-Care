<template>
  <div class="page-container">
    <!-- Baris Navigasi Atas: Tombol Kembali di Kiri -->
    <div class="page-header-nav">
      <button class="btn-back" @click="kembaliKeBeranda">
        <span>←</span> Kembali ke Beranda
      </button>
    </div>

    <!-- Header Section - Rata Tengah -->
    <header class="content-header-center">
      <div class="title-badge">
        <span class="dot"></span> Sistem Inventaris Sekolah
      </div>
      <h1>Persetujuan Peminjaman & Pengajuan 💡</h1>
      <p>Kelola dan berikan persetujuan untuk peminjaman alat serta pengajuan kebutuhan barang baru.</p>
    </header>

    <!-- Stat Cards Overview -->
    <div class="stats-grid">
      <div class="stat-card amber">
        <div class="stat-icon">⏳</div>
        <div class="stat-info">
          <span class="stat-label">Menunggu Persetujuan</span>
          <span class="stat-value">{{ totalMenunggu }} <small>Pengajuan</small></span>
        </div>
      </div>
      <div class="stat-card blue">
        <div class="stat-icon">📦</div>
        <div class="stat-info">
          <span class="stat-label">Total Peminjaman</span>
          <span class="stat-value">{{ peminjamanList.length }} <small>Item</small></span>
        </div>
      </div>
      <div class="stat-card purple">
        <div class="stat-icon">🛍️</div>
        <div class="stat-info">
          <span class="stat-label">Total Pengajuan Barang</span>
          <span class="stat-value">{{ kebutuhanList.length }} <small>Barang</small></span>
        </div>
      </div>
    </div>

    <!-- Tab Filter Navigasi & Search Bar -->
    <div class="action-bar-card">
      <div class="tab-menu">
        <button 
          :class="['tab-btn', activeTab === 'peminjaman' ? 'active' : '']" 
          @click="activeTab = 'peminjaman'"
        >
          📦 Peminjaman Fasilitas
        </button>
        <button 
          :class="['tab-btn', activeTab === 'kebutuhan' ? 'active' : '']" 
          @click="activeTab = 'kebutuhan'"
        >
          🛍️ Pengajuan Barang Baru
        </button>
      </div>

      <div class="search-box">
        <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
        <input 
          type="text" 
          v-model="searchQuery" 
          :placeholder="activeTab === 'peminjaman' ? 'Cari pemohon atau fasilitas...' : 'Cari pemohon atau nama barang...'" 
          class="input-search"
        />
        <button v-if="searchQuery" class="clear-btn" @click="searchQuery = ''">✕</button>
      </div>
    </div>

    <!-- Tabel Peminjaman -->
    <div v-if="activeTab === 'peminjaman'" class="main-card">
      <div class="table-responsive">
        <table class="styled-table">
          <thead>
            <tr>
              <th style="width: 20%">Pemohon</th>
              <th style="width: 22%">Fasilitas</th>
              <th style="width: 13%">Tgl Pinjam</th>
              <th style="width: 13%">Tgl Kembali</th>
              <th style="width: 15%">Keperluan</th>
              <th style="width: 10%" class="text-center">Status</th>
              <th style="width: 7%" class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(item, index) in filteredPeminjaman" :key="index" class="table-row">
              <td>
                <strong class="text-dark">{{ item.pemohon }}</strong>
              </td>
              <td class="font-medium">{{ item.fasilitas }}</td>
              <td>{{ item.tglPinjam }}</td>
              <td>{{ item.tglKembali }}</td>
              <td>{{ item.keperluan }}</td>
              <td class="text-center">
                <span :class="['badge-status', getStatusClass(item.status)]">
                  {{ item.status }}
                </span>
              </td>
              <td class="text-center">
                <div v-if="item.status === 'Menunggu'" class="action-buttons">
                  <button class="btn-approve" title="Setujui" @click="updateStatusPeminjaman(originalIndex(item, 'peminjaman'), 'Disetujui')">✓</button>
                  <button class="btn-reject" title="Tolak" @click="updateStatusPeminjaman(originalIndex(item, 'peminjaman'), 'Ditolak')">✕</button>
                </div>
                <span v-else class="text-muted">-</span>
              </td>
            </tr>

            <!-- Empty State -->
            <tr v-if="filteredPeminjaman.length === 0">
              <td colspan="7">
                <div class="empty-state-box">
                  <div class="empty-icon">🔍</div>
                  <h3>Data Peminjaman Tidak Ditemukan</h3>
                  <p>Coba gunakan kata kunci pencarian yang lain.</p>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Tabel Pengajuan Kebutuhan Barang Baru -->
    <div v-if="activeTab === 'kebutuhan'" class="main-card">
      <div class="table-responsive">
        <table class="styled-table">
          <thead>
            <tr>
              <th style="width: 20%">Pemohon</th>
              <th style="width: 22%">Nama Barang</th>
              <th style="width: 10%">Jumlah</th>
              <th style="width: 15%">Estimasi Biaya</th>
              <th style="width: 18%">Alasan Pengajuan</th>
              <th style="width: 10%" class="text-center">Status</th>
              <th style="width: 7%" class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(item, index) in filteredKebutuhan" :key="index" class="table-row">
              <td>
                <strong class="text-dark">{{ item.pemohon }}</strong>
              </td>
              <td class="font-medium">{{ item.namaBarang }}</td>
              <td>{{ item.jumlah }} unit</td>
              <td>Rp {{ item.estimasi.toLocaleString('id-ID') }}</td>
              <td>{{ item.alasan }}</td>
              <td class="text-center">
                <span :class="['badge-status', getStatusClass(item.status)]">
                  {{ item.status }}
                </span>
              </td>
              <td class="text-center">
                <div v-if="item.status === 'Menunggu'" class="action-buttons">
                  <button class="btn-approve" title="Setujui" @click="updateStatusKebutuhan(originalIndex(item, 'kebutuhan'), 'Disetujui')">✓</button>
                  <button class="btn-reject" title="Tolak" @click="updateStatusKebutuhan(originalIndex(item, 'kebutuhan'), 'Ditolak')">✕</button>
                </div>
                <span v-else class="text-muted">-</span>
              </td>
            </tr>

            <!-- Empty State -->
            <tr v-if="filteredKebutuhan.length === 0">
              <td colspan="7">
                <div class="empty-state-box">
                  <div class="empty-icon">🔍</div>
                  <h3>Data Pengajuan Barang Tidak Ditemukan</h3>
                  <p>Coba gunakan kata kunci pencarian yang lain.</p>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, watch } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()

const kembaliKeBeranda = () => {
  router.push('/')
}

const activeTab = ref('peminjaman')
const searchQuery = ref('')

// Reset search query when switching tabs
watch(activeTab, () => {
  searchQuery.value = ''
})

const peminjamanList = ref([
  { pemohon: 'Budi (Guru)', fasilitas: 'Proyektor Epson Lab 1', tglPinjam: '2026-09-03', tglKembali: '2026-09-03', keperluan: 'Presentasi Mengajar', status: 'Menunggu' },
  { pemohon: 'Siti (Siswa)', fasilitas: 'Kamera DSLR Canon', tglPinjam: '2026-09-05', tglKembali: '2026-09-07', keperluan: 'Liputan Acara Sekolah', status: 'Disetujui' }
])

const kebutuhanList = ref([
  { pemohon: 'Ahmad (Teknisi)', namaBarang: 'Kabel UTP Cat6 (1 Roll)', jumlah: 1, estimasi: 1200000, alasan: 'Peremajaan jaringan internet Gedung B', status: 'Menunggu' },
  { pemohon: 'Rina (Guru)', namaBarang: 'Marker Board Pastels', jumlah: 10, estimasi: 150000, alasan: 'Stok spidol kelas habis', status: 'Ditolak' }
])

// Total counts for stat cards
const totalMenunggu = computed(() => {
  const pWait = peminjamanList.value.filter(i => i.status === 'Menunggu').length
  const kWait = kebutuhanList.value.filter(i => i.status === 'Menunggu').length
  return pWait + kWait
})

// Filter logic for Peminjaman
const filteredPeminjaman = computed(() => {
  return peminjamanList.value.filter(item => {
    const q = searchQuery.value.toLowerCase()
    return item.pemohon.toLowerCase().includes(q) || 
           item.fasilitas.toLowerCase().includes(q) ||
           item.keperluan.toLowerCase().includes(q)
  })
})

// Filter logic for Kebutuhan
const filteredKebutuhan = computed(() => {
  return kebutuhanList.value.filter(item => {
    const q = searchQuery.value.toLowerCase()
    return item.pemohon.toLowerCase().includes(q) || 
           item.namaBarang.toLowerCase().includes(q) ||
           item.alasan.toLowerCase().includes(q)
  })
})

// Helper to get true index in original array for state mutation
const originalIndex = (item, type) => {
  if (type === 'peminjaman') {
    return peminjamanList.value.findIndex(i => i === item)
  } else {
    return kebutuhanList.value.findIndex(i => i === item)
  }
}

const getStatusClass = (status) => {
  if (status === 'Menunggu') return 'status-wait'
  if (status === 'Disetujui') return 'status-done'
  return 'status-reject'
}

const updateStatusPeminjaman = (index, status) => {
  if (index !== -1) {
    peminjamanList.value[index].status = status
  }
}

const updateStatusKebutuhan = (index, status) => {
  if (index !== -1) {
    kebutuhanList.value[index].status = status
  }
}
</script>

<style scoped>
.page-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 40px 24px;
  box-sizing: border-box;
  animation: fadeIn 0.4s ease-out;
}

/* Posisi Tombol Kembali di Kiri */
.page-header-nav {
  display: flex;
  justify-content: flex-start;
  margin-bottom: 16px;
}

.btn-back {
  background: white;
  border: 1px solid #cbd5e1;
  color: #334155;
  padding: 10px 18px;
  border-radius: 12px;
  font-weight: 700;
  font-size: 0.9rem;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  gap: 8px;
  box-shadow: 0 2px 6px rgba(15, 23, 42, 0.02);
  transition: all 0.2s ease;
}

.btn-back:hover {
  background: #f8fafc;
  border-color: #2563eb;
  color: #2563eb;
  transform: translateX(-3px);
}

/* Header Section Rata Tengah */
.content-header-center {
  text-align: center;
  margin-bottom: 32px;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.title-badge {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  background: #eff6ff;
  color: #2563eb;
  padding: 4px 12px;
  border-radius: 20px;
  font-size: 0.8rem;
  font-weight: 700;
  margin-bottom: 8px;
  border: 1px solid #bfdbfe;
}

.title-badge .dot {
  width: 6px;
  height: 6px;
  background: #2563eb;
  border-radius: 50%;
}

.content-header-center h1 {
  font-size: 2.1rem;
  font-weight: 800;
  color: #0f172a;
  letter-spacing: -0.02em;
  margin: 6px 0 6px 0;
}

.content-header-center p {
  color: #64748b;
  font-size: 0.98rem;
  margin: 0;
}

/* Stat Cards Grid */
.stats-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 16px;
  margin-bottom: 24px;
}

.stat-card {
  background: white;
  padding: 18px;
  border-radius: 14px;
  border: 1px solid #e2e8f0;
  display: flex;
  align-items: center;
  gap: 16px;
  box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
  transition: all 0.2s ease;
}

.stat-card:hover {
  transform: translateY(-3px);
  box-shadow: 0 8px 16px rgba(15, 23, 42, 0.08);
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

.stat-card.amber .stat-icon { background: #fef3c7; }
.stat-card.blue .stat-icon { background: #eff6ff; }
.stat-card.purple .stat-icon { background: #f5f3ff; }

.stat-info {
  display: flex;
  flex-direction: column;
}

.stat-label {
  font-size: 0.8rem;
  font-weight: 600;
  color: #64748b;
  text-transform: uppercase;
  letter-spacing: 0.03em;
}

.stat-value {
  font-size: 1.35rem;
  font-weight: 800;
  color: #0f172a;
}

.stat-value small {
  font-size: 0.85rem;
  font-weight: 500;
  color: #94a3b8;
}

/* Action Bar & Tabs */
.action-bar-card {
  background: white;
  padding: 14px 18px;
  border-radius: 14px;
  border: 1px solid #e2e8f0;
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 16px;
  margin-bottom: 20px;
  box-shadow: 0 2px 8px rgba(15, 23, 42, 0.03);
}

.tab-menu {
  display: flex;
  gap: 8px;
}

.tab-btn {
  background: #f1f5f9;
  border: none;
  padding: 10px 16px;
  border-radius: 10px;
  font-weight: 600;
  font-size: 0.88rem;
  cursor: pointer;
  color: #64748b;
  transition: all 0.2s ease;
}

.tab-btn:hover {
  background: #e2e8f0;
  color: #334155;
}

.tab-btn.active {
  background: #2563eb;
  color: white;
  box-shadow: 0 2px 6px rgba(37, 99, 235, 0.25);
}

.search-box {
  position: relative;
  width: 280px;
  display: flex;
  align-items: center;
}

.search-icon {
  position: absolute;
  left: 12px;
  color: #94a3b8;
}

.input-search {
  width: 100%;
  padding: 9px 12px 9px 36px;
  border: 1px solid #cbd5e1;
  border-radius: 10px;
  font-size: 0.88rem;
  outline: none;
  transition: all 0.2s ease;
  background: #f8fafc;
}

.input-search:focus {
  background: white;
  border-color: #2563eb;
  box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
}

.clear-btn {
  position: absolute;
  right: 10px;
  background: none;
  border: none;
  color: #94a3b8;
  cursor: pointer;
  font-size: 0.85rem;
}

/* Main Table Container */
.main-card {
  background: white;
  border-radius: 14px;
  border: 1px solid #e2e8f0;
  box-shadow: 0 4px 12px rgba(15, 23, 42, 0.03);
  overflow: hidden;
}

.table-responsive {
  width: 100%;
  overflow-x: auto;
}

.styled-table {
  width: 100%;
  border-collapse: collapse;
  text-align: left;
}

.styled-table th {
  background: #f8fafc;
  padding: 14px 18px;
  font-size: 0.78rem;
  font-weight: 700;
  color: #475569;
  text-transform: uppercase;
  letter-spacing: 0.05em;
  border-bottom: 1px solid #e2e8f0;
}

.styled-table td {
  padding: 16px 18px;
  border-bottom: 1px solid #f1f5f9;
  font-size: 0.9rem;
  color: #334155;
}

.table-row {
  transition: background-color 0.15s ease;
}

.table-row:hover {
  background-color: #f0f6ff;
}

.text-dark { color: #0f172a; }
.font-medium { font-weight: 500; }

/* Status Badges */
.badge-status {
  padding: 4px 12px;
  border-radius: 20px;
  font-size: 0.78rem;
  font-weight: 700;
  display: inline-block;
  letter-spacing: 0.02em;
}

.status-wait { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
.status-done { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
.status-reject { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }

.text-center { text-align: center; }

/* Action Buttons inside Table */
.action-buttons {
  display: flex;
  justify-content: center;
  gap: 6px;
}

.btn-approve {
  background: #22c55e;
  color: white;
  border: none;
  width: 30px;
  height: 30px;
  border-radius: 8px;
  cursor: pointer;
  font-size: 0.9rem;
  font-weight: 700;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.2s;
  box-shadow: 0 2px 5px rgba(34, 197, 94, 0.25);
}

.btn-approve:hover {
  background: #16a34a;
  transform: translateY(-1px);
}

.btn-reject {
  background: #ef4444;
  color: white;
  border: none;
  width: 30px;
  height: 30px;
  border-radius: 8px;
  cursor: pointer;
  font-size: 0.85rem;
  font-weight: 700;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.2s;
  box-shadow: 0 2px 5px rgba(239, 68, 68, 0.25);
}

.btn-reject:hover {
  background: #dc2626;
  transform: translateY(-1px);
}

.text-muted {
  color: #94a3b8;
  font-size: 0.9rem;
}

/* Empty State */
.empty-state-box {
  padding: 40px;
  text-align: center;
}

.empty-icon { font-size: 2.5rem; margin-bottom: 8px; }
.empty-state-box h3 { font-size: 1.1rem; color: #1e293b; margin-bottom: 4px; }
.empty-state-box p { color: #64748b; font-size: 0.88rem; margin: 0; }

/* Animation */
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(6px); }
  to { opacity: 1; transform: translateY(0); }
}
</style>
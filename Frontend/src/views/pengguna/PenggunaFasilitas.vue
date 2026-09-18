<template>
  <div class="pengguna-fasilitas">
    <!-- =========================
         HEADER UTAMA TENGAH (Gaya Admin)
    ========================== -->
    <div class="content-header-center">
      <div class="badge-header">Panel Pengguna</div>
      <h1>Manajemen Fasilitas & Sarpras</h1>
      <p>Kelola data fasilitas, inventaris, dan kondisi aset sekolah secara real-time.</p>
    </div>

    <!-- =========================
         STATISTICS CARDS
    ========================== -->
    <section class="stats-container">
      <div class="stat-card">
        <div class="stat-icon blue">
          <i class="fa-solid fa-boxes-stacked"></i>
        </div>
        <div class="stat-info">
          <span>TOTAL UNIT FASILITAS</span>
          <h3>{{ facilities.length }} Unit</h3>
        </div>
      </div>

      <div class="stat-card">
        <div class="stat-icon green">
          <i class="fa-solid fa-circle-check"></i>
        </div>
        <div class="stat-info">
          <span>KONDISI BAIK</span>
          <h3>{{ countGood }} Unit</h3>
        </div>
      </div>

      <div class="stat-card">
        <div class="stat-icon orange">
          <i class="fa-solid fa-triangle-exclamation"></i>
        </div>
        <div class="stat-info">
          <span>PERLU PERHATIAN / RUSAK</span>
          <h3>{{ countWarning }} Unit</h3>
        </div>
      </div>
    </section>

    <!-- =========================
         SEARCH & FILTER BAR
    ========================== -->
    <section class="filter-card">
      <div class="search-box">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input
          v-model="search"
          type="text"
          placeholder="Cari kode atau nama fasilitas..."
        />
      </div>

      <div class="filter-box">
        <select v-model="selectedCondition">
          <option value="">Semua Kondisi</option>
          <option value="Baik">Baik</option>
          <option value="Perlu Perhatian">Perlu Perhatian</option>
          <option value="Rusak">Rusak</option>
        </select>
        <button type="button" class="reset-filter-btn" @click="resetFilter" title="Reset Filter">
          <i class="fa-solid fa-rotate-right"></i>
        </button>
      </div>
    </section>

    <!-- =========================
         TABLE DATA FASILITAS
    ========================== -->
    <section class="table-container">
      <table class="facility-table">
        <thead>
          <tr>
            <th>KODE</th>
            <th>NAMA BARANG</th>
            <th>KATEGORI</th>
            <th>RUANGAN</th>
            <th>JUMLAH</th>
            <th>KONDISI</th>
            <th class="text-center">AKSI</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="facility in filteredFacilities" :key="facility.id">
            <td>
              <span class="code-badge">{{ facility.kode || 'FSL-' + facility.id }}</span>
            </td>
            <td>
              <div class="item-name">
                <i :class="facility.icon || 'fa-solid fa-box'" class="item-mini-icon"></i>
                <strong>{{ facility.nama }}</strong>
              </div>
            </td>
            <td>
              <span class="category-tag">{{ facility.kategori }}</span>
            </td>
            <td>{{ facility.ruangan }}</td>
            <td><strong>{{ facility.jumlah }} Unit</strong></td>
            <td>
              <span class="condition-badge" :class="getConditionClass(facility.kondisi)">
                <span class="status-dot"></span>
                {{ facility.kondisi }}
              </span>
            </td>
            <td class="text-center">
              <button
                type="button"
                class="borrow-btn"
                @click="ajukanPeminjaman(facility)"
              >
                <i class="fa-solid fa-file-circle-plus"></i>
                Ajukan Pinjam
              </button>
            </td>
          </tr>

          <!-- EMPTY STATE DALAM TABEL -->
          <tr v-if="filteredFacilities.length === 0">
            <td colspan="7" class="empty-cell">
              <div class="empty-state">
                <div class="empty-icon">
                  <i class="fa-solid fa-magnifying-glass"></i>
                </div>
                <h3>Fasilitas Tidak Ditemukan</h3>
                <p>Coba kata kunci atau filter kondisi lain.</p>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </section>

    <!-- =========================
         FOOTER
    ========================== -->
    <footer class="footer">
      <p>© {{ currentYear }} SchoolCare. All rights reserved.</p>
    </footer>
  </div>
</template>

<script setup>
import { computed, ref } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const search = ref('')
const selectedCondition = ref('')
const currentYear = new Date().getFullYear()

// Data dummy fasilitas
const facilities = ref([
  { id: 1, kode: 'FSL-001', nama: 'Proyektor Epson', kategori: 'Elektronik', ruangan: 'Lab Multimedia', jumlah: 5, kondisi: 'Baik', icon: 'fa-solid fa-video' },
  { id: 2, kode: 'FSL-002', nama: 'Kursi Lipat Siswa', kategori: 'Mebel', ruangan: 'Aula Utama', jumlah: 45, kondisi: 'Baik', icon: 'fa-solid fa-chair' },
  { id: 3, kode: 'FSL-003', nama: 'Mic Wireless Shure', kategori: 'Audio', ruangan: 'Ruang Musik', jumlah: 2, kondisi: 'Perlu Perhatian', icon: 'fa-solid fa-microphone' }
])

// Hitung Statistik
const countGood = computed(() => facilities.value.filter(f => f.kondisi === 'Baik').length)
const countWarning = computed(() => facilities.value.filter(f => f.kondisi !== 'Baik').length)

// Filter Data
const filteredFacilities = computed(() => {
  return facilities.value.filter(facility => {
    const keyword = search.value.toLowerCase().trim()
    const matchSearch = 
      !keyword || 
      facility.nama.toLowerCase().includes(keyword) || 
      (facility.kode && facility.kode.toLowerCase().includes(keyword)) ||
      facility.kategori.toLowerCase().includes(keyword)

    const matchCondition = 
      !selectedCondition.value || 
      facility.kondisi === selectedCondition.value

    return matchSearch && matchCondition
  })
})

const resetFilter = () => {
  search.value = ''
  selectedCondition.value = ''
}

const getConditionClass = (condition) => {
  if (condition === 'Baik') return 'good'
  if (condition === 'Perlu Perhatian') return 'warning'
  return 'broken'
}

const ajukanPeminjaman = (facility) => {
  router.push({
    path: '/pengguna/pengajuan',
    query: { fasilitas: facility.nama }
  })
}
</script>

<style scoped>
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css');

* {
  box-sizing: border-box;
}

.pengguna-fasilitas {
  min-height: 100vh;
  background: #f8fafc;
  color: #0f172a;
  font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
  padding: 30px 40px;
  display: flex;
  flex-direction: column;
}

/* HEADER TENGAH GAYA ADMIN */
.content-header-center {
  text-align: center;
  margin-bottom: 28px;
}

.badge-header {
  display: inline-block;
  background: #eff6ff;
  color: #2563eb;
  padding: 4px 12px;
  border-radius: 20px;
  font-size: 11px;
  font-weight: 700;
  margin-bottom: 8px;
}

.content-header-center h1 {
  margin: 0 0 6px 0;
  font-size: 24px;
  font-weight: 800;
  color: #0f172a;
}

.content-header-center p {
  margin: 0;
  color: #64748b;
  font-size: 13px;
}

/* STATS CONTAINER */
.stats-container {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 16px;
  margin-bottom: 24px;
}

.stat-card {
  background: white;
  border: 1px solid #e2e8f0;
  border-radius: 14px;
  padding: 18px;
  display: flex;
  align-items: center;
  gap: 16px;
}

.stat-icon {
  width: 44px;
  height: 44px;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 18px;
}

.stat-icon.blue { background: #eff6ff; color: #2563eb; }
.stat-icon.green { background: #f0fdf4; color: #16a34a; }
.stat-icon.orange { background: #fffbeb; color: #d97706; }

.stat-info span {
  display: block;
  font-size: 11px;
  color: #64748b;
  font-weight: 700;
  margin-bottom: 2px;
}

.stat-info h3 {
  margin: 0;
  font-size: 18px;
  font-weight: 800;
  color: #0f172a;
}

/* FILTER CARD */
.filter-card {
  background: white;
  border: 1px solid #e2e8f0;
  border-radius: 14px;
  padding: 14px;
  display: flex;
  gap: 12px;
  margin-bottom: 24px;
}

.search-box {
  flex: 1;
  height: 42px;
  border: 1px solid #e2e8f0;
  background: #f8fafc;
  border-radius: 9px;
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 0 12px;
}

.search-box input {
  width: 100%;
  border: none;
  outline: none;
  background: transparent;
  font-size: 12px;
  color: #334155;
}

.filter-box {
  width: 250px;
  display: flex;
  gap: 8px;
}

.filter-box select {
  flex: 1;
  height: 42px;
  border: 1px solid #e2e8f0;
  background: #f8fafc;
  border-radius: 9px;
  padding: 0 10px;
  font-size: 12px;
  color: #334155;
  outline: none;
  cursor: pointer;
}

.reset-filter-btn {
  width: 42px;
  height: 42px;
  border: 1px solid #e2e8f0;
  background: #f8fafc;
  color: #64748b;
  border-radius: 9px;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
}

.reset-filter-btn:hover {
  background: #e2e8f0;
  color: #0f172a;
}

/* TABLE CONTAINER */
.table-container {
  background: white;
  border: 1px solid #e2e8f0;
  border-radius: 14px;
  overflow: hidden;
}

.facility-table {
  width: 100%;
  border-collapse: collapse;
  text-align: left;
  font-size: 12px;
}

.facility-table th {
  background: #f8fafc;
  color: #475569;
  font-weight: 700;
  padding: 14px 16px;
  border-bottom: 1px solid #e2e8f0;
  text-transform: uppercase;
  font-size: 10px;
  letter-spacing: 0.5px;
}

.facility-table td {
  padding: 14px 16px;
  border-bottom: 1px solid #f1f5f9;
  color: #334155;
  vertical-align: middle;
}

.facility-table tr:last-child td {
  border-bottom: none;
}

.code-badge {
  background: #f1f5f9;
  padding: 4px 8px;
  border-radius: 6px;
  font-weight: 700;
  font-size: 11px;
  color: #475569;
}

.item-name {
  display: flex;
  align-items: center;
  gap: 10px;
}

.item-mini-icon {
  color: #2563eb;
  font-size: 14px;
}

.category-tag {
  color: #2563eb;
  font-weight: 700;
  font-size: 11px;
}

.condition-badge {
  padding: 4px 8px;
  border-radius: 20px;
  font-size: 10px;
  font-weight: 700;
  display: inline-flex;
  align-items: center;
  gap: 5px;
}

.status-dot {
  width: 5px;
  height: 5px;
  border-radius: 50%;
}

.condition-badge.good { background: #f0fdf4; color: #16a34a; }
.condition-badge.good .status-dot { background: #22c55e; }

.condition-badge.warning { background: #fffbeb; color: #d97706; }
.condition-badge.warning .status-dot { background: #f59e0b; }

.condition-badge.broken { background: #fef2f2; color: #dc2626; }
.condition-badge.broken .status-dot { background: #ef4444; }

.borrow-btn {
  border: none;
  background: #eff6ff;
  color: #2563eb;
  padding: 7px 12px;
  border-radius: 8px;
  font-size: 11px;
  font-weight: 700;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  gap: 6px;
  transition: all 0.2s;
}

.borrow-btn:hover {
  background: #2563eb;
  color: white;
}

.text-center {
  text-align: center;
}

/* EMPTY STATE */
.empty-cell {
  padding: 40px !important;
  text-align: center;
}

.empty-state {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}

.empty-icon {
  width: 50px;
  height: 50px;
  border-radius: 12px;
  background: #eff6ff;
  color: #2563eb;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 20px;
  margin-bottom: 12px;
}

.empty-state h3 {
  margin: 0 0 4px 0;
  font-size: 15px;
  font-weight: 800;
  color: #334155;
}

.empty-state p {
  margin: 0;
  color: #94a3b8;
  font-size: 12px;
}

/* FOOTER */
.footer {
  margin-top: 30px;
  padding-top: 15px;
  border-top: 1px solid #e2e8f0;
  text-align: center;
  color: #94a3b8;
  font-size: 11px;
}

@media (max-width: 900px) {
  .stats-container {
    grid-template-columns: 1fr;
  }
  .filter-card {
    flex-direction: column;
  }
  .filter-box {
    width: 100%;
  }
}
</style>
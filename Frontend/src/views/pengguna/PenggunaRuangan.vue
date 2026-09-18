<template>
  <div class="pengguna-ruangan">
    <!-- =========================
         HEADER UTAMA TENGAH (Gaya Fasilitas)
    ========================== -->
    <div class="content-header-center">
      <div class="badge-header">Panel Pengguna</div>
      <h1>Daftar Ruangan Sekolah</h1>
      <p>Lihat informasi ruangan dan ketersediaan ruangan secara real-time.</p>
    </div>

    <!-- =========================
         STATISTICS CARDS
    ========================== -->
    <section class="stats-container">
      <div class="stat-card">
        <div class="stat-icon blue">
          <i class="fa-solid fa-door-open"></i>
        </div>
        <div class="stat-info">
          <span>TOTAL RUANGAN</span>
          <h3>{{ rooms.length }} Unit</h3>
        </div>
      </div>

      <div class="stat-card">
        <div class="stat-icon green">
          <i class="fa-solid fa-circle-check"></i>
        </div>
        <div class="stat-info">
          <span>TERSEDIA</span>
          <h3>{{ countAvailable }} Unit</h3>
        </div>
      </div>

      <div class="stat-card">
        <div class="stat-icon orange">
          <i class="fa-solid fa-triangle-exclamation"></i>
        </div>
        <div class="stat-info">
          <span>DIPAKAI / PERHATIAN</span>
          <h3>{{ countNotAvailable }} Unit</h3>
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
          v-model="keyword"
          type="text"
          placeholder="Cari nama atau lokasi ruangan..."
        />
      </div>

      <div class="filter-box">
        <select v-model="selectedType">
          <option value="">Semua Jenis</option>
          <option v-for="type in roomTypes" :key="type" :value="type">
            {{ type }}
          </option>
        </select>
        <button type="button" class="reset-filter-btn" @click="resetFilter" title="Reset Filter">
          <i class="fa-solid fa-rotate-right"></i>
        </button>
      </div>
    </section>

    <!-- =========================
         TABLE DATA RUANGAN
    ========================== -->
    <section class="table-container">
      <table class="facility-table">
        <thead>
          <tr>
            <th>ID / KODE</th>
            <th>NAMA RUANGAN</th>
            <th>JENIS</th>
            <th>LOKASI</th>
            <th>KAPASITAS</th>
            <th>STATUS</th>
            <th class="text-center">AKSI</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="room in filteredRooms" :key="room.id">
            <td>
              <span class="code-badge">RNG-0{{ room.id }}</span>
            </td>
            <td>
              <div class="item-name">
                <i class="fa-solid fa-door-open item-mini-icon"></i>
                <strong>{{ room.name }}</strong>
              </div>
            </td>
            <td>
              <span class="category-tag">{{ room.type }}</span>
            </td>
            <td>{{ room.location || '-' }}</td>
            <td><strong>{{ room.capacity || '-' }} Orang</strong></td>
            <td>
              <span class="condition-badge" :class="getStatusClass(room.status)">
                <span class="status-dot"></span>
                {{ room.status }}
              </span>
            </td>
            <td class="text-center">
              <button
                type="button"
                class="borrow-btn"
                @click="showRoomDetail(room)"
              >
                <i class="fa-solid fa-circle-info"></i>
                Lihat Detail
              </button>
            </td>
          </tr>

          <!-- EMPTY STATE DALAM TABEL -->
          <tr v-if="filteredRooms.length === 0">
            <td colspan="7" class="empty-cell">
              <div class="empty-state">
                <div class="empty-icon">
                  <i class="fa-solid fa-magnifying-glass"></i>
                </div>
                <h3>Ruangan Tidak Ditemukan</h3>
                <p>Coba kata kunci atau filter jenis ruangan yang lain.</p>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </section>

    <!-- =========================
         DETAIL MODAL
    ========================== -->
    <div v-if="selectedRoom" class="modal-overlay" @click.self="closeRoomDetail">
      <div class="modal-card">
        <button class="close-btn" type="button" @click="closeRoomDetail">
          <i class="fa-solid fa-xmark"></i>
        </button>

        <div class="modal-icon-box">
          <i class="fa-solid fa-door-open"></i>
        </div>

        <span class="modal-type">{{ selectedRoom.type }}</span>
        <h2>{{ selectedRoom.name }}</h2>

        <div class="modal-info-list">
          <div class="modal-info-item">
            <span>Status</span>
            <strong>{{ selectedRoom.status }}</strong>
          </div>
          <div class="modal-info-item">
            <span>Lokasi</span>
            <strong>{{ selectedRoom.location || '-' }}</strong>
          </div>
          <div class="modal-info-item">
            <span>Kapasitas</span>
            <strong>{{ selectedRoom.capacity || '-' }} Orang</strong>
          </div>
          <div class="modal-info-item">
            <span>Keterangan</span>
            <strong>{{ selectedRoom.description || 'Belum ada keterangan.' }}</strong>
          </div>
        </div>

        <button class="modal-close-btn" type="button" @click="closeRoomDetail">
          Tutup
        </button>
      </div>
    </div>

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
const keyword = ref('')
const selectedType = ref('')
const selectedRoom = ref(null)
const currentYear = new Date().getFullYear()

// Data dummy ruangan
const rooms = ref([
  { 
    id: 1, 
    name: 'Lab Multimedia', 
    type: 'Laboratorium', 
    status: 'Tersedia', 
    location: 'Gedung A Lantai 2', 
    capacity: 35, 
    description: 'Dilengkapi dengan komputer spesifikasi tinggi dan proyektor untuk pembelajaran multimedia.' 
  },
  { 
    id: 2, 
    name: 'Aula Utama', 
    type: 'Aula', 
    status: 'Dipakai', 
    location: 'Gedung Utama', 
    capacity: 200, 
    description: 'Digunakan untuk kegiatan rapat besar, acara sekolah, dan pertemuan umum.' 
  },
  { 
    id: 3, 
    name: 'Ruang Musik', 
    type: 'Ruang Praktik', 
    status: 'Perlu Perhatian', 
    location: 'Gedung B Lantai 1', 
    capacity: 20, 
    description: 'Berisi alat-alat musik seperti gitar, drum, dan keyboard.' 
  }
])

// Statistik Ruangan
const countAvailable = computed(() => rooms.value.filter(r => r.status.toLowerCase().includes('tersedia')).length)
const countNotAvailable = computed(() => rooms.value.length - countAvailable.value)

// Jenis Ruangan untuk Dropdown
const roomTypes = computed(() => {
  const types = rooms.value.map(room => room.type).filter(Boolean)
  return [...new Set(types)]
})

// Filter Ruangan
const filteredRooms = computed(() => {
  return rooms.value.filter(room => {
    const search = keyword.value.toLowerCase().trim()
    const matchesKeyword =
      !search ||
      room.name?.toLowerCase().includes(search) ||
      room.location?.toLowerCase().includes(search)

    const matchesType =
      !selectedType.value ||
      room.type === selectedType.value

    return matchesKeyword && matchesType
  })
})

const resetFilter = () => {
  keyword.value = ''
  selectedType.value = ''
}

const showRoomDetail = (room) => {
  selectedRoom.value = room
}

const closeRoomDetail = () => {
  selectedRoom.value = null
}

const getStatusClass = (status) => {
  if (!status) return 'good'
  const val = status.toLowerCase()
  if (val.includes('tersedia') || val.includes('baik') || val.includes('aktif')) return 'good'
  if (val.includes('dipakai') || val.includes('digunakan')) return 'warning'
  return 'broken'
}
</script>

<style scoped>
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css');

* {
  box-sizing: border-box;
}

.pengguna-ruangan {
  min-height: 100vh;
  background: #f8fafc;
  color: #0f172a;
  font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
  padding: 30px 40px;
  display: flex;
  flex-direction: column;
}

/* HEADER TENGAH GAYA FASILITAS */
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
  color: #7c3aed;
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

/* MODAL */
.modal-overlay {
  position: fixed;
  inset: 0;
  z-index: 1000;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 20px;
  background: rgba(15, 23, 42, 0.55);
  backdrop-filter: blur(4px);
}

.modal-card {
  position: relative;
  width: 100%;
  max-width: 420px;
  padding: 24px;
  border: 1px solid #e2e8f0;
  border-radius: 16px;
  background: #ffffff;
  box-shadow: 0 20px 40px rgba(15, 23, 42, 0.15);
}

.close-btn {
  position: absolute;
  top: 16px;
  right: 16px;
  background: #f8fafc;
  border: 1px solid #e2e8f0;
  color: #64748b;
  width: 30px;
  height: 30px;
  border-radius: 8px;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
}

.modal-icon-box {
  width: 45px;
  height: 45px;
  background: #eff6ff;
  color: #2563eb;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 18px;
  margin-bottom: 12px;
}

.modal-type {
  font-size: 10px;
  font-weight: 700;
  color: #7c3aed;
  text-transform: uppercase;
}

.modal-card h2 {
  margin: 4px 0 16px 0;
  font-size: 18px;
  font-weight: 800;
}

.modal-info-list {
  display: flex;
  flex-direction: column;
  gap: 12px;
  background: #f8fafc;
  padding: 14px;
  border-radius: 10px;
  border: 1px solid #e2e8f0;
}

.modal-info-item {
  display: flex;
  flex-direction: column;
  gap: 2px;
}

.modal-info-item span {
  font-size: 10px;
  color: #64748b;
  font-weight: 700;
}

.modal-info-item strong {
  font-size: 12px;
  color: #0f172a;
}

.modal-close-btn {
  width: 100%;
  margin-top: 16px;
  padding: 10px;
  border: 1px solid #e2e8f0;
  background: white;
  color: #475569;
  font-weight: 700;
  border-radius: 9px;
  cursor: pointer;
}

.modal-close-btn:hover {
  background: #f1f5f9;
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
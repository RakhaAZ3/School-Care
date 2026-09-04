<template>
  <div class="page-container">
    <!-- Baris Navigasi Atas: Tombol Kembali di Kiri -->
    <div class="page-header-nav">
      <button class="btn-back" @click="kembaliKeBeranda">
        <span>←</span> Kembali ke Beranda
      </button>
    </div>

    <!-- Content Header: Teks Rata Tengah -->
    <header class="content-header-center">
      <div class="title-badge">
        <span class="dot"></span> Sistem Inventaris Sekolah
      </div>
      <h1>Laporan Kerusakan 🚨</h1>
      <p>Pantau dan perbarui status laporan fasilitas yang rusak secara berkala.</p>
      
      <div class="header-action-btn">
        <button class="btn-primary-glow" @click="openTambahModal">
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
          <span>Buat Laporan</span>
        </button>
      </div>
    </header>

    <!-- Stat Cards Overview -->
    <div class="stats-grid">
      <div class="stat-card blue">
        <div class="stat-icon">📋</div>
        <div class="stat-info">
          <span class="stat-label">Total Laporan</span>
          <span class="stat-value">{{ totalLaporan }} <small>Kasus</small></span>
        </div>
      </div>
      <div class="stat-card yellow">
        <div class="stat-icon">⏳</div>
        <div class="stat-info">
          <span class="stat-label">Sedang Diproses</span>
          <span class="stat-value">{{ laporanDiproses }} <small>Laporan</small></span>
        </div>
      </div>
      <div class="stat-card green">
        <div class="stat-icon">✅</div>
        <div class="stat-info">
          <span class="stat-label">Selesai Diperbaiki</span>
          <span class="stat-value">{{ laporanSelesai }} <small>Laporan</small></span>
        </div>
      </div>
    </div>

    <!-- Action Bar: Search -->
    <div class="action-bar-card">
      <div class="search-box">
        <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
        <input 
          type="text" 
          v-model="searchQuery" 
          placeholder="Cari judul laporan, fasilitas, atau ruangan..." 
          class="input-search"
        />
        <button v-if="searchQuery" class="clear-btn" @click="searchQuery = ''">✕</button>
      </div>
    </div>

    <!-- Main Table Card -->
    <div class="main-card">
      <div class="table-responsive">
        <table class="styled-table">
          <thead>
            <tr>
              <th style="width: 30%">Judul Laporan</th>
              <th style="width: 18%">Fasilitas</th>
              <th style="width: 15%">Ruangan</th>
              <th style="width: 12%">Prioritas</th>
              <th style="width: 12%">Status</th>
              <th style="width: 13%" class="text-center">Aksi Status</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="item in filteredLaporan" :key="item.id" class="table-row">
              <td>
                <strong class="text-dark">{{ item.judul }}</strong>
                <p class="desc-text">{{ item.deskripsi }}</p>
              </td>
              <td class="font-medium">{{ item.fasilitas }}</td>
              <td>
                <span class="room-tag">📍 {{ item.ruangan }}</span>
              </td>
              <td>
                <span :class="['badge-priority', item.prioritas.toLowerCase()]">
                  {{ item.prioritas }}
                </span>
              </td>
              <td>
                <span :class="['badge-status', getStatusClass(item.status)]">
                  {{ item.status }}
                </span>
              </td>
              <td class="text-center">
                <select 
                  :value="item.status" 
                  @change="updateStatus(item.id, $event.target.value)"
                  class="select-status"
                >
                  <option value="Menunggu">Menunggu</option>
                  <option value="Diverifikasi">Diverifikasi</option>
                  <option value="Diproses">Diproses</option>
                  <option value="Selesai">Selesai</option>
                </select>
              </td>
            </tr>

            <!-- Empty State -->
            <tr v-if="filteredLaporan.length === 0">
              <td colspan="6">
                <div class="empty-state-box">
                  <div class="empty-icon">🔍</div>
                  <h3>Laporan Tidak Ditemukan</h3>
                  <p>Coba kata kunci lain atau buat laporan kerusakan baru.</p>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Modal Form Tambah Laporan -->
    <Transition name="fade">
      <div v-if="showModal" class="modal-backdrop" @click.self="showModal = false">
        <div class="modal-container">
          <div class="modal-header">
            <div>
              <h3>Buat Laporan Kerusakan</h3>
              <p>Isi detail kerusakan fasilitas sekolah dengan benar.</p>
            </div>
            <button class="close-modal-btn" @click="showModal = false">✕</button>
          </div>

          <form @submit.prevent="tambahLaporan">
            <div class="modal-body">
              <div class="form-grid">
                <div class="form-group full-width">
                  <label>Judul Laporan <span class="required">*</span></label>
                  <input v-model="form.judul" type="text" placeholder="Misal: AC Mati / Tidak Dingin" required />
                </div>
                <div class="form-group full-width">
                  <label>Fasilitas <span class="required">*</span></label>
                  <input v-model="form.fasilitas" type="text" placeholder="Misal: AC Split 2PK" required />
                </div>
                <div class="form-group full-width">
                  <label>Ruangan <span class="required">*</span></label>
                  <select v-model="form.ruangan" required>
                    <option value="Lab RPL">Lab RPL</option>
                    <option value="Lab TKJ">Lab TKJ</option>
                    <option value="Perpustakaan">Perpustakaan</option>
                    <option value="Aula Utama">Aula Utama</option>
                    <option value="Ruang Guru">Ruang Guru</option>
                  </select>
                </div>
                <div class="form-group full-width">
                  <label>Prioritas <span class="required">*</span></label>
                  <select v-model="form.prioritas" required>
                    <option value="Rendah">Rendah</option>
                    <option value="Sedang">Sedang</option>
                    <option value="Tinggi">Tinggi</option>
                  </select>
                </div>
                <div class="form-group full-width">
                  <label>Deskripsi Kerusakan <span class="required">*</span></label>
                  <textarea v-model="form.deskripsi" rows="3" placeholder="Jelaskan detail kerusakannya..." required></textarea>
                </div>
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn-ghost" @click="showModal = false">Batal</button>
              <button type="submit" class="btn-primary-glow">Kirim Laporan</button>
            </div>
          </form>
        </div>
      </div>
    </Transition>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()

const kembaliKeBeranda = () => {
  router.push('/')
}

const showModal = ref(false)
const searchQuery = ref('')

const laporanList = ref([
  {
    id: 1,
    judul: 'Proyektor Buram',
    fasilitas: 'Proyektor Epson',
    ruangan: 'Lab RPL',
    prioritas: 'Tinggi',
    deskripsi: 'Tampilan proyektor bergaris dan warna pudar.',
    status: 'Menunggu'
  },
  {
    id: 2,
    judul: 'AC Bocor Air',
    fasilitas: 'AC Split 2PK',
    ruangan: 'Lab TKJ',
    prioritas: 'Sedang',
    deskripsi: 'Air menetes ke meja komputer nomor 5.',
    status: 'Diproses'
  }
])

const form = ref({
  judul: '',
  fasilitas: '',
  ruangan: 'Lab RPL',
  prioritas: 'Sedang',
  deskripsi: ''
})

// Statistics Computation
const totalLaporan = computed(() => laporanList.value.length)
const laporanDiproses = computed(() => laporanList.value.filter(i => i.status === 'Diproses' || i.status === 'Diverifikasi').length)
const laporanSelesai = computed(() => laporanList.value.filter(i => i.status === 'Selesai').length)

// Filter Logic
const filteredLaporan = computed(() => {
  return laporanList.value.filter(item => {
    const q = searchQuery.value.toLowerCase()
    return item.judul.toLowerCase().includes(q) || 
           item.fasilitas.toLowerCase().includes(q) ||
           item.ruangan.toLowerCase().includes(q)
  })
})

const getStatusClass = (status) => {
  if (status === 'Menunggu') return 'status-wait'
  if (status === 'Diverifikasi') return 'status-verify'
  if (status === 'Diproses') return 'status-process'
  return 'status-done'
}

const updateStatus = (id, statusBaru) => {
  const item = laporanList.value.find(i => i.id === id)
  if (item) {
    item.status = statusBaru
  }
}

const openTambahModal = () => {
  form.value = { judul: '', fasilitas: '', ruangan: 'Lab RPL', prioritas: 'Sedang', deskripsi: '' }
  showModal.value = true
}

const tambahLaporan = () => {
  const newId = laporanList.value.length > 0 ? Math.max(...laporanList.value.map(i => i.id)) + 1 : 1
  laporanList.value.unshift({
    id: newId,
    ...form.value,
    status: 'Menunggu'
  })
  showModal.value = false
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

/* Header Text Rata Tengah */
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
  margin: 0 0 20px 0;
}

.header-action-btn {
  margin-top: 4px;
}

/* Button Styling */
.btn-primary-glow {
  background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
  color: white;
  border: none;
  padding: 12px 22px;
  border-radius: 10px;
  font-weight: 600;
  font-size: 0.92rem;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  gap: 8px;
  box-shadow: 0 4px 14px rgba(37, 99, 235, 0.35);
  transition: all 0.25s ease;
  white-space: nowrap;
}

.btn-primary-glow:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(37, 99, 235, 0.45);
  background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
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

.stat-card.blue .stat-icon { background: #eff6ff; }
.stat-card.yellow .stat-icon { background: #fefce8; }
.stat-card.green .stat-icon { background: #f0fdf4; }

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

/* Action Bar */
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

.search-box {
  position: relative;
  flex: 1;
  display: flex;
  align-items: center;
}

.search-icon {
  position: absolute;
  left: 14px;
  color: #94a3b8;
}

.input-search {
  width: 100%;
  padding: 10px 14px 10px 40px;
  border: 1px solid #cbd5e1;
  border-radius: 10px;
  font-size: 0.9rem;
  outline: none;
  transition: all 0.2s ease;
  background: #f8fafc;
}

.input-search:focus {
  background: white;
  border-color: #2563eb;
  box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
}

.clear-btn {
  position: absolute;
  right: 12px;
  background: none;
  border: none;
  color: #94a3b8;
  cursor: pointer;
  font-size: 0.9rem;
}

/* Table Styling */
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

.desc-text {
  font-size: 0.82rem;
  color: #64748b;
  margin: 4px 0 0 0;
  line-height: 1.4;
}

.room-tag {
  font-size: 0.85rem;
  color: #475569;
  font-weight: 500;
}

/* Badges */
.badge-priority {
  font-size: 0.72rem;
  font-weight: 700;
  padding: 4px 10px;
  border-radius: 6px;
  text-transform: uppercase;
  display: inline-block;
  letter-spacing: 0.03em;
}
.badge-priority.tinggi { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
.badge-priority.sedang { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
.badge-priority.rendah { background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; }

.badge-status {
  padding: 4px 10px;
  border-radius: 20px;
  font-size: 0.78rem;
  font-weight: 700;
  display: inline-block;
  letter-spacing: 0.02em;
}
.status-wait { background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; }
.status-verify { background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; }
.status-process { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
.status-done { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }

.select-status {
  padding: 6px 10px;
  border-radius: 8px;
  border: 1px solid #cbd5e1;
  font-size: 0.82rem;
  outline: none;
  background: white;
  color: #334155;
  cursor: pointer;
  font-weight: 500;
  transition: all 0.2s ease;
}

.select-status:focus {
  border-color: #2563eb;
  box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
}

.text-center { text-align: center; }

/* Empty State */
.empty-state-box {
  padding: 40px;
  text-align: center;
}

.empty-icon { font-size: 2.5rem; margin-bottom: 8px; }
.empty-state-box h3 { font-size: 1.1rem; color: #1e293b; margin-bottom: 4px; }
.empty-state-box p { color: #64748b; font-size: 0.88rem; margin: 0; }

/* Modal Styling */
.modal-backdrop {
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  background: rgba(15, 23, 42, 0.5);
  backdrop-filter: blur(4px);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
}

.modal-container {
  background: white;
  border-radius: 16px;
  width: 460px;
  max-width: 90%;
  box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
  overflow: hidden;
  animation: scaleUp 0.25s ease-out;
}

.modal-header {
  padding: 20px 24px;
  background: #f8fafc;
  border-bottom: 1px solid #e2e8f0;
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
}

.modal-header h3 { font-size: 1.2rem; font-weight: 700; color: #0f172a; margin: 0 0 2px 0; }
.modal-header p { font-size: 0.85rem; color: #64748b; margin: 0; }

.close-modal-btn {
  background: none;
  border: none;
  font-size: 1.2rem;
  color: #94a3b8;
  cursor: pointer;
}

.modal-body { padding: 24px; }

.form-grid {
  display: flex;
  flex-direction: column;
  gap: 16px;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 6px;
}

.form-group label {
  font-size: 0.82rem;
  font-weight: 600;
  color: #334155;
}

.required { color: #ef4444; }

.form-group input, .form-group select, .form-group textarea {
  padding: 10px;
  border: 1px solid #cbd5e1;
  border-radius: 8px;
  font-size: 0.9rem;
  outline: none;
  font-family: inherit;
  background: white;
}

.form-group input:focus, .form-group select:focus, .form-group textarea:focus {
  border-color: #2563eb;
  box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
}

.modal-footer {
  padding: 16px 24px;
  background: #f8fafc;
  border-top: 1px solid #e2e8f0;
  display: flex;
  justify-content: flex-end;
  gap: 12px;
}

.btn-ghost {
  background: transparent;
  border: none;
  padding: 10px 18px;
  color: #64748b;
  font-weight: 600;
  cursor: pointer;
  border-radius: 8px;
}

.btn-ghost:hover { background: #e2e8f0; }

/* Animations */
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(6px); }
  to { opacity: 1; transform: translateY(0); }
}

@keyframes scaleUp {
  from { opacity: 0; transform: scale(0.95); }
  to { opacity: 1; transform: scale(1); }
}
</style>
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
      <h1>Maintenance & Jadwal Perawatan 🔧</h1>
      <p>Kelola riwayat perawatan berkala dan atur jadwal pemeriksaan fasilitas.</p>
      
      <div class="header-action-btn">
        <button class="btn-primary-glow" @click="openTambahModal">
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
          <span>Catat / Jadwalkan Maintenance</span>
        </button>
      </div>
    </header>

    <!-- Banner Pengingat (Reminder Box) - Teks Rata Tengah -->
    <div class="reminder-box card-box" v-if="jadwalMendekati.length > 0">
      <div class="reminder-icon">⚠️</div>
      <div class="reminder-text">
        <strong>Pengingat Maintenance!</strong>
        <p>Ada <span>{{ jadwalMendekati.length }} fasilitas</span> yang mendekati atau melewati jadwal pemeriksaan berikutnya.</p>
      </div>
    </div>

    <!-- Stat Cards Overview -->
    <div class="stats-grid">
      <div class="stat-card blue">
        <div class="stat-icon">🛠️</div>
        <div class="stat-info">
          <span class="stat-label">Total Perawatan</span>
          <span class="stat-value">{{ totalMaintenance }} <small>Catatan</small></span>
        </div>
      </div>
      <div class="stat-card red" v-if="jadwalMendekati.length > 0">
        <div class="stat-icon">🔔</div>
        <div class="stat-info">
          <span class="stat-label">Jadwal Mendekati Tenggat</span>
          <span class="stat-value">{{ jadwalMendekati.length }} <small>Fasilitas</small></span>
        </div>
      </div>
      <div class="stat-card green" v-else>
        <div class="stat-icon">✅</div>
        <div class="stat-info">
          <span class="stat-label">Status Jadwal</span>
          <span class="stat-value">Aman <small>Semua Terkontrol</small></span>
        </div>
      </div>
      <div class="stat-card green">
        <div class="stat-icon">💰</div>
        <div class="stat-info">
          <span class="stat-label">Total Biaya Perawatan</span>
          <span class="stat-value">Rp {{ totalBiaya.toLocaleString('id-ID') }}</span>
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
          placeholder="Cari fasilitas, jenis perawatan, atau teknisi..." 
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
              <th style="width: 22%">Fasilitas</th>
              <th style="width: 20%">Jenis Perawatan</th>
              <th style="width: 15%">Teknisi</th>
              <th style="width: 13%">Biaya</th>
              <th style="width: 13%">Tanggal</th>
              <th style="width: 13%">Pemeriksaan Berikutnya</th>
              <th style="width: 12%" class="text-center">Status</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="item in filteredMaintenance" :key="item.id" class="table-row">
              <td>
                <strong class="text-dark">{{ item.fasilitas }}</strong>
              </td>
              <td class="font-medium">{{ item.jenis }}</td>
              <td>
                <span class="tech-tag">👤 {{ item.teknisi }}</span>
              </td>
              <td>Rp {{ item.biaya.toLocaleString('id-ID') }}</td>
              <td>{{ item.tanggal }}</td>
              <td>
                <strong :class="{'text-danger': isMendekati(item.pemeriksaanBerikutnya)}">
                  {{ item.pemeriksaanBerikutnya }}
                </strong>
              </td>
              <td class="text-center">
                <span :class="['badge-status', item.status === 'Selesai' ? 'done' : 'process']">
                  {{ item.status }}
                </span>
              </td>
            </tr>

            <!-- Empty State -->
            <tr v-if="filteredMaintenance.length === 0">
              <td colspan="7">
                <div class="empty-state-box">
                  <div class="empty-icon">🔍</div>
                  <h3>Jadwal Maintenance Tidak Ditemukan</h3>
                  <p>Coba kata kunci lain atau tambahkan jadwal perawatan baru.</p>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Modal Catat Maintenance Baru -->
    <Transition name="fade">
      <div v-if="showModal" class="modal-backdrop" @click.self="showModal = false">
        <div class="modal-container">
          <div class="modal-header">
            <div>
              <h3>Catat & Jadwalkan Maintenance</h3>
              <p>Masukkan rincian perawatan atau pemeliharaan fasilitas.</p>
            </div>
            <button class="close-modal-btn" @click="showModal = false">✕</button>
          </div>

          <form @submit.prevent="tambahMaintenance">
            <div class="modal-body">
              <div class="form-grid">
                <div class="form-group full-width">
                  <label>Fasilitas <span class="required">*</span></label>
                  <input v-model="form.fasilitas" type="text" placeholder="Misal: Proyektor Lab RPL" required />
                </div>
                <div class="form-group full-width">
                  <label>Jenis Perawatan <span class="required">*</span></label>
                  <input v-model="form.jenis" type="text" placeholder="Misal: Pembersihan lensa & filter" required />
                </div>
                <div class="form-group">
                  <label>Teknisi / Vendor <span class="required">*</span></label>
                  <input v-model="form.teknisi" type="text" placeholder="Nama teknisi / vendor" required />
                </div>
                <div class="form-group">
                  <label>Biaya (Rp) <span class="required">*</span></label>
                  <input v-model.number="form.biaya" type="number" min="0" placeholder="0" required />
                </div>
                <div class="form-group">
                  <label>Tanggal Pemeliharaan <span class="required">*</span></label>
                  <input v-model="form.tanggal" type="date" required />
                </div>
                <div class="form-group">
                  <label>Pemeriksaan Berikutnya <span class="required">*</span></label>
                  <input v-model="form.pemeriksaanBerikutnya" type="date" required />
                </div>
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn-ghost" @click="showModal = false">Batal</button>
              <button type="submit" class="btn-primary-glow">Simpan Record</button>
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

const maintenanceList = ref([
  {
    id: 1,
    fasilitas: 'Proyektor Lab RPL',
    jenis: 'Pembersihan Lensa',
    teknisi: 'Ahmad (Internal)',
    biaya: 50000,
    tanggal: '2026-09-02',
    pemeriksaanBerikutnya: '2026-10-10',
    status: 'Selesai'
  },
  {
    id: 2,
    fasilitas: 'AC Lab TKJ',
    jenis: 'Cuci AC & Isi Freon',
    teknisi: 'CV Bintang Service',
    biaya: 150000,
    tanggal: '2026-08-15',
    pemeriksaanBerikutnya: '2026-09-05',
    status: 'Selesai'
  }
])

const form = ref({
  fasilitas: '',
  jenis: '',
  teknisi: '',
  biaya: 0,
  tanggal: '',
  pemeriksaanBerikutnya: '',
  status: 'Selesai'
})

// Statistics Computation
const totalMaintenance = computed(() => maintenanceList.value.length)
const totalBiaya = computed(() => maintenanceList.value.reduce((acc, curr) => acc + curr.biaya, 0))

const isMendekati = (tanggalStr) => {
  const targetDate = new Date(tanggalStr)
  const today = new Date('2026-09-02')
  const selisihHari = (targetDate - today) / (1000 * 60 * 60 * 24)
  return selisihHari <= 7 && selisihHari >= 0
}

const jadwalMendekati = computed(() => {
  return maintenanceList.value.filter(item => isMendekati(item.pemeriksaanBerikutnya))
})

// Filter Logic
const filteredMaintenance = computed(() => {
  return maintenanceList.value.filter(item => {
    const q = searchQuery.value.toLowerCase()
    return item.fasilitas.toLowerCase().includes(q) || 
           item.jenis.toLowerCase().includes(q) ||
           item.teknisi.toLowerCase().includes(q)
  })
})

const openTambahModal = () => {
  form.value = { fasilitas: '', jenis: '', teknisi: '', biaya: 0, tanggal: '', pemeriksaanBerikutnya: '', status: 'Selesai' }
  showModal.value = true
}

const tambahMaintenance = () => {
  const newId = maintenanceList.value.length > 0 ? Math.max(...maintenanceList.value.map(i => i.id)) + 1 : 1
  maintenanceList.value.unshift({
    id: newId,
    ...form.value
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

/* Banner Pengingat (Reminder Box) - Diatur Rata Tengah */
.reminder-box {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 16px;
  background: #fef2f2;
  border: 1px solid #fecaca;
  border-left: 6px solid #ef4444;
  padding: 16px 20px;
  border-radius: 14px;
  margin-bottom: 24px;
  box-shadow: 0 2px 8px rgba(239, 68, 68, 0.05);
  text-align: center;
}

.reminder-icon {
  font-size: 1.8rem;
}

.reminder-text {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.reminder-text strong {
  color: #991b1b;
  font-size: 0.95rem;
  margin-bottom: 2px;
}

.reminder-text p {
  font-size: 0.88rem;
  color: #7f1d1d;
  margin: 0;
}

.reminder-text span {
  color: #ef4444;
  font-weight: 700;
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
.stat-card.red .stat-icon { background: #fef2f2; }
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
.font-medium { font-weight: 500; }

.tech-tag {
  font-size: 0.85rem;
  color: #475569;
  font-weight: 500;
}

.text-danger {
  color: #ef4444;
}

/* Badges */
.badge-status {
  padding: 4px 12px;
  border-radius: 20px;
  font-size: 0.78rem;
  font-weight: 700;
  display: inline-block;
  letter-spacing: 0.02em;
}
.badge-status.done { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
.badge-status.process { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }

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
  width: 500px;
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
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 16px;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 6px;
}

.form-group.full-width {
  grid-column: span 2;
}

.form-group label {
  font-size: 0.82rem;
  font-weight: 600;
  color: #334155;
}

.required { color: #ef4444; }

.form-group input {
  padding: 10px;
  border: 1px solid #cbd5e1;
  border-radius: 8px;
  font-size: 0.9rem;
  outline: none;
  font-family: inherit;
  background: white;
}

.form-group input:focus {
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
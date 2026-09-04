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
      <h1>Manajemen Ruangan 🏢</h1>
      <p>Kelola daftar ruangan dan pantau skor kondisi fasilitasnya secara berkala.</p>
      
      <button class="btn-primary-glow mt-4" @click="openTambahModal">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
        <span>Tambah Ruangan</span>
      </button>
    </header>

    <!-- Stat Cards Overview -->
    <div class="stats-grid">
      <div class="stat-card blue">
        <div class="stat-icon">🏫</div>
        <div class="stat-info">
          <span class="stat-label">Total Ruangan</span>
          <span class="stat-value">{{ totalRuangan }} <small>Lokasi</small></span>
        </div>
      </div>
      <div class="stat-card green">
        <div class="stat-icon">📈</div>
        <div class="stat-info">
          <span class="stat-label">Rata-rata Skor Sekolah</span>
          <span class="stat-value">{{ rataRataScore }} <small>/100</small></span>
        </div>
      </div>
      <div class="stat-card yellow">
        <div class="stat-icon">⚠️</div>
        <div class="stat-info">
          <span class="stat-label">Perlu Perhatian (&lt;60)</span>
          <span class="stat-value">{{ ruanganPerluPerhatian }} <small>Ruangan</small></span>
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
          placeholder="Cari nama ruangan atau lokasi..." 
          class="input-search"
        />
        <button v-if="searchQuery" class="clear-btn" @click="searchQuery = ''">✕</button>
      </div>
    </div>

    <!-- Grid Ruangan Bergaya Card Modern -->
    <div class="room-grid" v-if="filteredRuangan.length > 0">
      <div v-for="item in filteredRuangan" :key="item.id" class="room-card">
        <div class="room-card-top">
          <div class="room-title-group">
            <h3>{{ item.nama }}</h3>
            <p class="room-desc">📍 {{ item.lokasi }}</p>
          </div>
          <div class="card-action-dropdown">
            <button class="btn-icon edit" title="Edit Ruangan" @click="editRuangan(item)">
              <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
            </button>
            <button class="btn-icon delete" title="Hapus Ruangan" @click="hapusRuangan(item.id)">
              <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
            </button>
          </div>
        </div>

        <div class="score-box">
          <div class="score-info">
            <span class="score-title-text">School Care Score</span>
            <strong :style="{ color: getScoreColor(item.score) }">⭐ {{ item.score }}/100</strong>
          </div>
          <div class="progress-bar">
            <div 
              class="progress-fill" 
              :style="{ width: item.score + '%', backgroundColor: getScoreColor(item.score) }"
            ></div>
          </div>
          <div class="score-status-label" :style="{ color: getScoreColor(item.score) }">
            {{ getScoreLabel(item.score) }}
          </div>
        </div>
      </div>
    </div>

    <!-- Empty State -->
    <div v-else class="empty-state-card">
      <div class="empty-icon">🔍</div>
      <h3>Ruangan Tidak Ditemukan</h3>
      <p>Coba kata kunci pencarian lain atau tambahkan data ruangan baru.</p>
    </div>

    <!-- Modal Form Tambah / Edit Ruangan -->
    <Transition name="fade">
      <div v-if="showModal" class="modal-backdrop" @click.self="showModal = false">
        <div class="modal-container">
          <div class="modal-header">
            <div>
              <h3>{{ isEditMode ? 'Edit Data Ruangan' : 'Tambah Ruangan Baru' }}</h3>
              <p>Masukkan rincian informasi ruangan sekolah.</p>
            </div>
            <button class="close-modal-btn" @click="showModal = false">✕</button>
          </div>

          <form @submit.prevent="simpanRuangan">
            <div class="modal-body">
              <div class="form-grid">
                <div class="form-group full-width">
                  <label>Nama Ruangan <span class="required">*</span></label>
                  <input v-model="form.nama" type="text" placeholder="Misal: Lab RPL" required />
                </div>
                <div class="form-group full-width">
                  <label>Lokasi / Keterangan <span class="required">*</span></label>
                  <input v-model="form.lokasi" type="text" placeholder="Misal: Gedung A Lt. 2" required />
                </div>
                <div v-if="isEditMode" class="form-group full-width">
                  <label>School Care Score (0 - 100)</label>
                  <input v-model.number="form.score" type="number" min="0" max="100" placeholder="80" required />
                </div>
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn-ghost" @click="showModal = false">Batal</button>
              <button type="submit" class="btn-primary-glow">
                {{ isEditMode ? 'Simpan Perubahan' : 'Simpan Ruangan' }}
              </button>
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
const isEditMode = ref(false)
const searchQuery = ref('')

const ruanganList = ref([
  { id: 1, nama: 'Lab RPL', lokasi: 'Gedung A Lt. 2', score: 82 },
  { id: 2, nama: 'Lab TKJ', lokasi: 'Gedung A Lt. 2', score: 65 },
  { id: 3, nama: 'Perpustakaan', lokasi: 'Gedung B Lt. 1', score: 90 },
  { id: 4, nama: 'Aula Utama', lokasi: 'Gedung C Lt. 1', score: 45 },
  { id: 5, nama: 'Ruang Guru', lokasi: 'Gedung Utama', score: 88 }
])

const form = ref({
  id: null,
  nama: '',
  lokasi: '',
  score: 100
})

// Statistics Computation
const totalRuangan = computed(() => ruanganList.value.length)
const rataRataScore = computed(() => {
  if (ruanganList.value.length === 0) return 0
  const total = ruanganList.value.reduce((acc, curr) => acc + curr.score, 0)
  return Math.round(total / ruanganList.value.length)
})
const ruanganPerluPerhatian = computed(() => {
  return ruanganList.value.filter(item => item.score < 60).length
})

// Filter Logic
const filteredRuangan = computed(() => {
  return ruanganList.value.filter(item => {
    const q = searchQuery.value.toLowerCase()
    return item.nama.toLowerCase().includes(q) || 
           item.lokasi.toLowerCase().includes(q)
  })
})

const getScoreColor = (score) => {
  if (score >= 80) return '#10b981' // Hijau modern
  if (score >= 60) return '#f59e0b' // Kuning/Amber
  return '#ef4444' // Merah
}

const getScoreLabel = (score) => {
  if (score >= 80) return 'Kondisi Sangat Baik'
  if (score >= 60) return 'Kondisi Cukup / Normal'
  return 'Perlu Perbaikan Segera'
}

const openTambahModal = () => {
  isEditMode.value = false
  form.value = { id: null, nama: '', lokasi: '', score: 100 }
  showModal.value = true
}

const editRuangan = (item) => {
  isEditMode.value = true
  form.value = { ...item }
  showModal.value = true
}

const simpanRuangan = () => {
  if (isEditMode.value) {
    const idx = ruanganList.value.findIndex(i => i.id === form.value.id)
    if (idx !== -1) {
      ruanganList.value[idx].nama = form.value.nama
      ruanganList.value[idx].lokasi = form.value.lokasi
      ruanganList.value[idx].score = form.value.score
    }
  } else {
    const newId = ruanganList.value.length > 0 ? Math.max(...ruanganList.value.map(i => i.id)) + 1 : 1
    ruanganList.value.unshift({
      id: newId,
      nama: form.value.nama,
      lokasi: form.value.lokasi,
      score: 100 // Default score ruangan baru
    })
  }
  showModal.value = false
}

const hapusRuangan = (id) => {
  if (confirm('Yakin ingin menghapus data ruangan ini?')) {
    ruanganList.value = ruanganList.value.filter(item => item.id !== id)
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

.mt-4 {
  margin-top: 16px;
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
.stat-card.green .stat-icon { background: #f0fdf4; }
.stat-card.yellow .stat-icon { background: #fefce8; }

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

/* Room Cards Grid */
.room-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 20px;
}

.room-card {
  background: white;
  border: 1px solid #e2e8f0;
  border-radius: 14px;
  padding: 20px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  box-shadow: 0 2px 8px rgba(15, 23, 42, 0.03);
  transition: all 0.25s ease;
}

.room-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 10px 20px rgba(15, 23, 42, 0.08);
  border-color: #cbd5e1;
}

.room-card-top {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  margin-bottom: 16px;
}

.room-title-group h3 {
  font-size: 1.1rem;
  font-weight: 700;
  color: #0f172a;
  margin: 0 0 4px 0;
}

.room-desc {
  font-size: 0.85rem;
  color: #64748b;
  margin: 0;
}

.card-action-dropdown {
  display: flex;
  gap: 6px;
}

.btn-icon {
  width: 30px;
  height: 30px;
  border-radius: 8px;
  border: 1px solid #e2e8f0;
  background: white;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.2s ease;
}

.btn-icon.edit { color: #2563eb; }
.btn-icon.edit:hover { background: #eff6ff; border-color: #bfdbfe; }

.btn-icon.delete { color: #ef4444; }
.btn-icon.delete:hover { background: #fef2f2; border-color: #fecaca; }

/* Score Box Styling */
.score-box {
  background: #f8fafc;
  padding: 14px;
  border-radius: 10px;
  border: 1px solid #f1f5f9;
}

.score-info {
  display: flex;
  justify-content: space-between;
  align-items: center;
  font-size: 0.85rem;
  margin-bottom: 8px;
}

.score-title-text {
  color: #475569;
  font-weight: 600;
}

.progress-bar {
  width: 100%;
  height: 8px;
  background: #e2e8f0;
  border-radius: 4px;
  overflow: hidden;
  margin-bottom: 8px;
}

.progress-fill {
  height: 100%;
  transition: width 0.4s ease;
  border-radius: 4px;
}

.score-status-label {
  font-size: 0.75rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.03em;
}

/* Empty State */
.empty-state-card {
  background: white;
  border: 1px solid #e2e8f0;
  border-radius: 14px;
  padding: 50px;
  text-align: center;
}

.empty-icon { font-size: 2.5rem; margin-bottom: 8px; }
.empty-state-card h3 { font-size: 1.1rem; color: #1e293b; margin-bottom: 4px; }
.empty-state-card p { color: #64748b; font-size: 0.88rem; margin: 0; }

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

.form-group input {
  padding: 10px;
  border: 1px solid #cbd5e1;
  border-radius: 8px;
  font-size: 0.9rem;
  outline: none;
  font-family: inherit;
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
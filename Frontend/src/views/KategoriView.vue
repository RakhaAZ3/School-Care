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
      <h1>Manajemen Kategori</h1>
      <p>Kelola dan kelompokkan jenis fasilitas serta aset sekolah secara terstruktur.</p>
      
      <div class="header-action-btn">
        <button class="btn-primary-glow" @click="openTambahModal">
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
          <span>Tambah Kategori</span>
        </button>
      </div>
    </header>

    <!-- Stats Cards Grid -->
    <div class="stats-grid">
      <div class="stat-card blue">
        <div class="stat-icon">🏷️</div>
        <div class="stat-info">
          <span class="stat-label">Total Kategori</span>
          <span class="stat-value">{{ totalKategori }} <small>Jenis</small></span>
        </div>
      </div>
      <div class="stat-card green">
        <div class="stat-icon">📦</div>
        <div class="stat-info">
          <span class="stat-label">Total Item Terhubung</span>
          <span class="stat-value">{{ totalItemTerhubung }} <small>Unit</small></span>
        </div>
      </div>
      <div class="stat-card yellow">
        <div class="stat-icon">⭐</div>
        <div class="stat-info">
          <span class="stat-label">Kategori Populer</span>
          <span class="stat-value">{{ kategoriTerbanyak }}</span>
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
          placeholder="Cari kode atau nama kategori..." 
          class="input-search"
        />
        <button v-if="searchQuery" class="clear-btn" @click="searchQuery = ''">✕</button>
      </div>
    </div>

    <!-- Tabel Data Kategori -->
    <div class="main-card">
      <div class="table-responsive">
        <table class="styled-table">
          <thead>
            <tr>
              <th style="width: 15%">Kode</th>
              <th style="width: 25%">Nama Kategori</th>
              <th style="width: 37%">Deskripsi</th>
              <th style="width: 13%">Jumlah Item</th>
              <th style="width: 10%" class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="item in filteredKategori" :key="item.kode" class="table-row">
              <td>
                <span class="code-badge">{{ item.kode }}</span>
              </td>
              <td class="font-semibold text-dark">
                <strong>{{ item.nama }}</strong>
              </td>
              <td class="description-text">
                {{ item.deskripsi }}
              </td>
              <td class="font-medium">
                <strong>{{ item.jumlahItem }}</strong> <span class="unit-text">Unit</span>
              </td>
              <td>
                <div class="action-buttons">
                  <button class="btn-icon edit" title="Edit Kategori" @click="editKategori(item)">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                  </button>
                  <button class="btn-icon delete" title="Hapus Kategori" @click="hapusKategori(item.kode)">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                  </button>
                </div>
              </td>
            </tr>

            <tr v-if="filteredKategori.length === 0">
              <td colspan="5">
                <div class="empty-state-box">
                  <div class="empty-icon">🔍</div>
                  <h3>Kategori Tidak Ditemukan</h3>
                  <p>Coba kata kunci lain atau tambah kategori baru.</p>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Modal Form Tambah/Edit Kategori -->
    <Transition name="fade">
      <div v-if="showModal" class="modal-backdrop" @click.self="showModal = false">
        <div class="modal-container">
          <div class="modal-header">
            <div>
              <h3>{{ isEditMode ? 'Edit Data Kategori' : 'Tambah Kategori Baru' }}</h3>
              <p>Isi rincian kategori untuk pengelompokkan barang.</p>
            </div>
            <button class="close-modal-btn" @click="showModal = false">✕</button>
          </div>

          <form @submit.prevent="simpanKategori">
            <div class="modal-body">
              <div class="form-grid">
                <div class="form-group full-width">
                  <label>Kode Kategori <span class="required">*</span></label>
                  <input v-model="form.kode" type="text" placeholder="MIS: KTG-001" :disabled="isEditMode" required />
                </div>
                <div class="form-group full-width">
                  <label>Nama Kategori <span class="required">*</span></label>
                  <input v-model="form.nama" type="text" placeholder="Misal: Elektronik" required />
                </div>
                <div class="form-group full-width">
                  <label>Deskripsi <span class="required">*</span></label>
                  <textarea v-model="form.deskripsi" rows="3" placeholder="Keterangan singkat kategori..." required></textarea>
                </div>
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn-ghost" @click="showModal = false">Batal</button>
              <button type="submit" class="btn-primary-glow">
                {{ isEditMode ? 'Simpan Perubahan' : 'Simpan Kategori' }}
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

const kategoriList = ref([
  { kode: 'KTG-001', nama: 'Elektronik', deskripsi: 'Perangkat elektronik, komputer, proyektor, dan aksesorisnya', jumlahItem: 24 },
  { kode: 'KTG-002', nama: 'Furniture', deskripsi: 'Meja, kursi, lemari, papan tulis, dan perabotan kelas', jumlahItem: 120 },
  { kode: 'KTG-003', nama: 'Peralatan Laboratorium', deskripsi: 'Alat penunjang lab sains, praktikum, dan kimia', jumlahItem: 45 },
  { kode: 'KTG-004', nama: 'Olahraga', deskripsi: 'Peralatan kegiatan olahraga seperti bola, raket, dan meja tenis', jumlahItem: 18 },
  { kode: 'KTG-005', nama: 'Perpustakaan', deskripsi: 'Buku, rak baca, dan fasilitas pendukung ruang baca', jumlahItem: 85 }
])

const form = ref({
  kode: '',
  nama: '',
  deskripsi: ''
})

// Statistics Computation
const totalKategori = computed(() => kategoriList.value.length)
const totalItemTerhubung = computed(() => kategoriList.value.reduce((acc, curr) => acc + curr.jumlahItem, 0))
const kategoriTerbanyak = computed(() => {
  if (kategoriList.value.length === 0) return '-'
  const sorted = [...kategoriList.value].sort((a, b) => b.jumlahItem - a.jumlahItem)
  return sorted[0].nama
})

// Filter Logic
const filteredKategori = computed(() => {
  return kategoriList.value.filter(item => {
    const q = searchQuery.value.toLowerCase()
    return item.nama.toLowerCase().includes(q) || 
           item.kode.toLowerCase().includes(q) ||
           item.deskripsi.toLowerCase().includes(q)
  })
})

const openTambahModal = () => {
  isEditMode.value = false
  form.value = { kode: '', nama: '', deskripsi: '' }
  showModal.value = true
}

const editKategori = (item) => {
  isEditMode.value = true
  form.value = { ...item }
  showModal.value = true
}

const simpanKategori = () => {
  if (isEditMode.value) {
    const idx = kategoriList.value.findIndex(i => i.kode === form.value.kode)
    if (idx !== -1) {
      kategoriList.value[idx].nama = form.value.nama
      kategoriList.value[idx].deskripsi = form.value.deskripsi
    }
  } else {
    kategoriList.value.unshift({ 
      ...form.value, 
      jumlahItem: 0 
    })
  }
  showModal.value = false
}

const hapusKategori = (kode) => {
  if (confirm(`Yakin ingin menghapus kategori dengan kode ${kode}?`)) {
    kategoriList.value = kategoriList.value.filter(item => item.kode !== kode)
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

.code-badge {
  background: #f1f5f9;
  color: #1e293b;
  padding: 4px 8px;
  border-radius: 6px;
  font-family: monospace;
  font-weight: 700;
  font-size: 0.82rem;
  border: 1px solid #cbd5e1;
  white-space: nowrap;
  display: inline-block;
}

.description-text {
  color: #64748b;
  font-size: 0.88rem;
  line-height: 1.4;
}

.unit-text {
  color: #94a3b8;
  font-size: 0.82rem;
}

/* Action Buttons */
.text-center { text-align: center; }
.action-buttons {
  display: flex;
  justify-content: center;
  gap: 8px;
}

.btn-icon {
  width: 32px;
  height: 32px;
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

/* Empty State */
.empty-state-box {
  padding: 40px;
  text-align: center;
}

.empty-icon { font-size: 2.5rem; margin-bottom: 8px; }
.empty-state-box h3 { font-size: 1.1rem; color: #1e293b; margin-bottom: 4px; }
.empty-state-box p { color: #64748b; font-size: 0.88rem; }

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

.form-group input, .form-group textarea {
  padding: 10px;
  border: 1px solid #cbd5e1;
  border-radius: 8px;
  font-size: 0.9rem;
  outline: none;
  font-family: inherit;
}

.form-group input:focus, .form-group textarea:focus {
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
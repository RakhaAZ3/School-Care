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
      <h1>Manajemen Fasilitas & Sarpras</h1>
      <p>Kelola data fasilitas, inventaris, dan kondisi aset sekolah secara real-time.</p>
      
      <div class="header-action-btn">
        <button class="btn-primary-glow" @click="openTambahModal">
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
          <span>Tambah Fasilitas</span>
        </button>
      </div>
    </header>

    <!-- Stats Cards Grid -->
    <div class="stats-grid">
      <div class="stat-card blue">
        <div class="stat-icon">🏢</div>
        <div class="stat-info">
          <span class="stat-label">Total Unit Fasilitas</span>
          <span class="stat-value">{{ totalUnit }} <small>Unit</small></span>
        </div>
      </div>
      <div class="stat-card green">
        <div class="stat-icon">✅</div>
        <div class="stat-info">
          <span class="stat-label">Kondisi Baik</span>
          <span class="stat-value">{{ totalKondisiBaik }} <small>Unit</small></span>
        </div>
      </div>
      <div class="stat-card yellow">
        <div class="stat-icon">🛠️</div>
        <div class="stat-info">
          <span class="stat-label">Perlu Perhatian</span>
          <span class="stat-value">{{ totalPerluPerhatian }} <small>Unit</small></span>
        </div>
      </div>
    </div>

    <!-- Action Bar: Search & Filter -->
    <div class="action-bar-card">
      <div class="search-box">
        <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
        <input 
          type="text" 
          v-model="searchQuery" 
          placeholder="Cari kode atau nama fasilitas..." 
          class="input-search"
        />
        <button v-if="searchQuery" class="clear-btn" @click="searchQuery = ''">✕</button>
      </div>

      <div class="filter-box">
        <select v-model="filterKondisi" class="styled-select">
          <option value="">Semua Kondisi</option>
          <option value="Baik">Baik</option>
          <option value="Perlu Perbaikan">Perlu Perbaikan</option>
          <option value="Rusak">Rusak</option>
        </select>
      </div>
    </div>

    <!-- Tabel Data Fasilitas -->
    <div class="main-card">
      <div class="table-responsive">
        <table class="styled-table">
          <thead>
            <tr>
              <th style="width: 12%">Kode</th>
              <th style="width: 25%">Nama Barang</th>
              <th style="width: 18%">Kategori</th>
              <th style="width: 18%">Ruangan</th>
              <th style="width: 10%">Jumlah</th>
              <th style="width: 12%">Kondisi</th>
              <th style="width: 10%" class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="item in filteredFasilitas" :key="item.kode" class="table-row">
              <td>
                <span class="code-badge">{{ item.kode }}</span>
              </td>
              <td class="font-semibold text-dark">
                <strong>{{ item.nama }}</strong>
              </td>
              <td>
                <span class="category-tag">{{ item.kategori }}</span>
              </td>
              <td class="room-text">{{ item.ruangan }}</td>
              <td class="font-medium">
                <strong>{{ item.jumlah }}</strong> <span class="unit-text">Unit</span>
              </td>
              <td>
                <span :class="['badge-status', getBadgeClass(item.kondisi)]">
                  <span class="badge-dot"></span>
                  {{ item.kondisi }}
                </span>
              </td>
              <td>
                <div class="action-buttons">
                  <button class="btn-icon edit" title="Edit Fasilitas" @click="editBarang(item)">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                  </button>
                  <button class="btn-icon delete" title="Hapus Fasilitas" @click="hapusBarang(item.kode)">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                  </button>
                </div>
              </td>
            </tr>

            <tr v-if="filteredFasilitas.length === 0">
              <td colspan="7">
                <div class="empty-state-box">
                  <div class="empty-icon">🔍</div>
                  <h3>Fasilitas Tidak Ditemukan</h3>
                  <p>Coba kata kunci atau filter kondisi lain.</p>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Modal Form Tambah/Edit Fasilitas -->
    <Transition name="fade">
      <div v-if="showModal" class="modal-backdrop" @click.self="showModal = false">
        <div class="modal-container">
          <div class="modal-header">
            <div>
              <h3>{{ isEditMode ? 'Edit Data Fasilitas' : 'Tambah Fasilitas Baru' }}</h3>
              <p>Rincian aset dan sarana prasarana sekolah.</p>
            </div>
            <button class="close-modal-btn" @click="showModal = false">✕</button>
          </div>

          <form @submit.prevent="simpanBarang">
            <div class="modal-body">
              <div class="form-grid">
                <div class="form-group">
                  <label>Kode Barang <span class="required">*</span></label>
                  <input v-model="form.kode" type="text" placeholder="MIS: INF-001" :disabled="isEditMode" required />
                </div>
                <div class="form-group">
                  <label>Nama Barang <span class="required">*</span></label>
                  <input v-model="form.nama" type="text" placeholder="Nama fasilitas" required />
                </div>
                <div class="form-group">
                  <label>Kategori <span class="required">*</span></label>
                  <select v-model="form.kategori" class="styled-select-input" required>
                    <option value="Elektronik">Elektronik</option>
                    <option value="Furniture">Furniture</option>
                    <option value="Olahraga">Olahraga</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Ruangan <span class="required">*</span></label>
                  <select v-model="form.ruangan" class="styled-select-input" required>
                    <option value="Lab RPL">Lab RPL</option>
                    <option value="Ruang X RPL">Ruang X RPL</option>
                    <option value="Lab TKJ">Lab TKJ</option>
                    <option value="Perpustakaan">Perpustakaan</option>
                    <option value="Aula">Aula</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Jumlah Unit <span class="required">*</span></label>
                  <input v-model.number="form.jumlah" type="number" min="1" required />
                </div>
                <div class="form-group">
                  <label>Kondisi <span class="required">*</span></label>
                  <select v-model="form.kondisi" class="styled-select-input" required>
                    <option value="Baik">Baik</option>
                    <option value="Perlu Perbaikan">Perlu Perbaikan</option>
                    <option value="Rusak">Rusak</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn-ghost" @click="showModal = false">Batal</button>
              <button type="submit" class="btn-primary-glow">
                {{ isEditMode ? 'Simpan Perubahan' : 'Simpan Data' }}
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
const filterKondisi = ref('')

const fasilitas = ref([
  { kode: 'INF-001', nama: 'Proyektor Epson', kategori: 'Elektronik', ruangan: 'Lab RPL', jumlah: 2, kondisi: 'Baik' },
  { kode: 'FUR-012', nama: 'Kursi Siswa', kategori: 'Furniture', ruangan: 'Ruang X RPL', jumlah: 36, kondisi: 'Baik' },
  { kode: 'INF-005', nama: 'AC Split 2PK', kategori: 'Elektronik', ruangan: 'Lab TKJ', jumlah: 1, kondisi: 'Perlu Perbaikan' },
  { kode: 'OLG-002', nama: 'Meja Tenis Meja', kategori: 'Olahraga', ruangan: 'Aula', jumlah: 1, kondisi: 'Rusak' }
])

const form = ref({
  kode: '',
  nama: '',
  kategori: 'Elektronik',
  ruangan: 'Lab RPL',
  jumlah: 1,
  kondisi: 'Baik'
})

// Ringkasan Statistik
const totalUnit = computed(() => fasilitas.value.reduce((acc, curr) => acc + Number(curr.jumlah), 0))
const totalKondisiBaik = computed(() => {
  return fasilitas.value
    .filter(item => item.kondisi === 'Baik')
    .reduce((acc, curr) => acc + Number(curr.jumlah), 0)
})
const totalPerluPerhatian = computed(() => {
  return fasilitas.value
    .filter(item => item.kondisi !== 'Baik')
    .reduce((acc, curr) => acc + Number(curr.jumlah), 0)
})

// Filter & Pencarian
const filteredFasilitas = computed(() => {
  return fasilitas.value.filter(item => {
    const q = searchQuery.value.toLowerCase()
    const matchSearch = item.nama.toLowerCase().includes(q) || item.kode.toLowerCase().includes(q)
    const matchKondisi = filterKondisi.value === '' || item.kondisi === filterKondisi.value
    return matchSearch && matchKondisi
  })
})

const getBadgeClass = (kondisi) => {
  if (kondisi === 'Baik') return 'badge-success'
  if (kondisi === 'Perlu Perbaikan') return 'badge-warning'
  return 'badge-danger'
}

const openTambahModal = () => {
  isEditMode.value = false
  form.value = { kode: '', nama: '', kategori: 'Elektronik', ruangan: 'Lab RPL', jumlah: 1, kondisi: 'Baik' }
  showModal.value = true
}

const editBarang = (item) => {
  isEditMode.value = true
  form.value = { ...item }
  showModal.value = true
}

const simpanBarang = () => {
  if (isEditMode.value) {
    const idx = fasilitas.value.findIndex(i => i.kode === form.value.kode)
    if (idx !== -1) {
      fasilitas.value[idx] = { ...form.value }
    }
  } else {
    fasilitas.value.unshift({ ...form.value })
  }
  showModal.value = false
}

const hapusBarang = (kode) => {
  if (confirm(`Yakin ingin menghapus item fasilitas dengan kode ${kode}?`)) {
    fasilitas.value = fasilitas.value.filter(item => item.kode !== kode)
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

.styled-select, .styled-select-input {
  padding: 10px 14px;
  border: 1px solid #cbd5e1;
  border-radius: 10px;
  font-size: 0.88rem;
  outline: none;
  background: #f8fafc;
  color: #334155;
  cursor: pointer;
}

.styled-select:focus, .styled-select-input:focus {
  background: white;
  border-color: #2563eb;
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

.category-tag {
  background: #f1f5f9;
  color: #475569;
  padding: 3px 8px;
  border-radius: 6px;
  font-size: 0.82rem;
  font-weight: 600;
}

.room-text {
  color: #475569;
  font-weight: 500;
}

.unit-text {
  color: #94a3b8;
  font-size: 0.82rem;
}

/* Status Badge */
.badge-status {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 4px 10px;
  border-radius: 20px;
  font-size: 0.78rem;
  font-weight: 700;
  white-space: nowrap;
}

.badge-dot {
  width: 6px;
  height: 6px;
  border-radius: 50%;
}

.badge-success { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }
.badge-success .badge-dot { background: #22c55e; }

.badge-warning { background: #fefce8; color: #854d0e; border: 1px solid #fef08a; }
.badge-warning .badge-dot { background: #eab308; }

.badge-danger { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }
.badge-danger .badge-dot { background: #ef4444; }

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
  width: 520px;
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

.form-group label {
  font-size: 0.82rem;
  font-weight: 600;
  color: #334155;
}

.required { color: #ef4444; }

.form-group input, .form-group select {
  padding: 10px;
  border: 1px solid #cbd5e1;
  border-radius: 8px;
  font-size: 0.9rem;
  outline: none;
  font-family: inherit;
}

.form-group input:focus, .form-group select:focus {
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
<template>
  <div class="pengguna-pengajuan">
    <!-- =========================
         HEADER UTAMA TENGAH (Gaya Fasilitas & Ruangan)
    ========================== -->
    <div class="content-header-center">
      <div class="badge-header">Panel Pengguna</div>
      <h1>Pengajuan Peminjaman</h1>
      <p>Ajukan peminjaman fasilitas atau ruangan dengan mudah dan pantau riwayatnya secara real-time.</p>
    </div>

    <!-- =========================
         FORM PENGAJUAN (CREATE / EDIT)
    ========================== -->
    <section class="form-card">
      <div class="section-heading">
        <div class="heading-icon">
          <i class="fa-solid fa-file-circle-plus"></i>
        </div>
        <div>
          <h2>{{ isEditing ? 'Edit Pengajuan Peminjaman' : 'Formulir Pengajuan Baru' }}</h2>
          <p>{{ isEditing ? 'Ubah detail formulir pengajuan di bawah ini.' : 'Isi formulir berikut untuk mengajukan peminjaman fasilitas atau ruangan.' }}</p>
        </div>
      </div>

      <form @submit.prevent="submitPengajuan">
        <!-- FASILITAS / RUANGAN -->
        <div class="form-group">
          <label for="fasilitas">
            Pilih Fasilitas / Ruangan <span>*</span>
          </label>
          <div class="input-wrapper">
            <i class="fa-solid fa-boxes-stacked"></i>
            <select
              id="fasilitas"
              v-model="form.fasilitas"
              required
            >
              <option value="">Pilih fasilitas atau ruangan</option>
              <option v-for="fac in facilities" :key="fac" :value="fac">
                {{ fac }}
              </option>
            </select>
          </div>
        </div>

        <!-- TANGGAL -->
        <div class="form-row">
          <div class="form-group">
            <label for="tanggal_mulai">
              Tanggal Peminjaman <span>*</span>
            </label>
            <div class="input-wrapper">
              <i class="fa-solid fa-calendar-days"></i>
              <input
                id="tanggal_mulai"
                v-model="form.tanggalMulai"
                type="date"
                required
              />
            </div>
          </div>

          <div class="form-group">
            <label for="tanggal_selesai">
              Tanggal Selesai <span>*</span>
            </label>
            <div class="input-wrapper">
              <i class="fa-solid fa-calendar-check"></i>
              <input
                id="tanggal_selesai"
                v-model="form.tanggalSelesai"
                type="date"
                required
              />
            </div>
          </div>
        </div>

        <!-- WAKTU -->
        <div class="form-row">
          <div class="form-group">
            <label for="waktu_mulai">
              Waktu Mulai <span>*</span>
            </label>
            <div class="input-wrapper">
              <i class="fa-solid fa-clock"></i>
              <input
                id="waktu_mulai"
                v-model="form.waktuMulai"
                type="time"
                required
              />
            </div>
          </div>

          <div class="form-group">
            <label for="waktu_selesai">
              Waktu Selesai <span>*</span>
            </label>
            <div class="input-wrapper">
              <i class="fa-solid fa-clock"></i>
              <input
                id="waktu_selesai"
                v-model="form.waktuSelesai"
                type="time"
                required
              />
            </div>
          </div>
        </div>

        <!-- KEPERLUAN -->
        <div class="form-group">
          <label for="keperluan">
            Keperluan <span>*</span>
          </label>
          <div class="input-wrapper textarea-wrapper">
            <i class="fa-solid fa-clipboard-list"></i>
            <textarea
              id="keperluan"
              v-model="form.keperluan"
              rows="4"
              placeholder="Contoh: Digunakan untuk kegiatan belajar kelompok..."
              required
            ></textarea>
          </div>
        </div>

        <!-- CATATAN -->
        <div class="form-group">
          <label for="catatan">
            Catatan <small>(opsional)</small>
          </label>
          <div class="input-wrapper textarea-wrapper">
            <i class="fa-solid fa-note-sticky"></i>
            <textarea
              id="catatan"
              v-model="form.catatan"
              rows="3"
              placeholder="Tambahkan catatan jika diperlukan..."
            ></textarea>
          </div>
        </div>

        <!-- BUTTON -->
        <div class="form-actions">
          <button
            v-if="isEditing"
            type="button"
            class="cancel-btn"
            @click="cancelEdit"
          >
            Batal
          </button>
          <button
            v-else
            type="button"
            class="cancel-btn"
            @click="resetForm"
          >
            Reset
          </button>

          <button
            type="submit"
            class="submit-btn"
          >
            <i class="fa-solid" :class="isEditing ? 'fa-floppy-disk' : 'fa-paper-plane'"></i>
            {{ isEditing ? 'Simpan Perubahan' : 'Ajukan Peminjaman' }}
          </button>
        </div>
      </form>
    </section>

    <!-- =========================
         RIWAYAT PENGAJUAN (READ, UPDATE, DELETE)
    ========================== -->
    <section class="history-section">
      <div class="result-info">
        <div>
          <h2>Riwayat Pengajuan</h2>
          <p>Daftar pengajuan peminjaman yang pernah kamu lakukan.</p>
        </div>
      </div>

      <!-- EMPTY STATE -->
      <div
        v-if="pengajuanList.length === 0"
        class="empty-state"
      >
        <div class="empty-icon">
          <i class="fa-solid fa-file-circle-xmark"></i>
        </div>
        <h3>Belum Ada Pengajuan</h3>
        <p>Pengajuan yang kamu buat akan tampil di halaman ini.</p>
      </div>

      <!-- HISTORY LIST -->
      <div
        v-else
        class="history-list"
      >
        <article
          v-for="pengajuan in pengajuanList"
          :key="pengajuan.id"
          class="history-card"
        >
          <div class="history-icon">
            <i class="fa-solid fa-file-lines"></i>
          </div>

          <div class="history-content">
            <div class="history-top">
              <div>
                <span class="history-category">
                  {{ pengajuan.fasilitas }}
                </span>
                <h3>{{ pengajuan.keperluan }}</h3>
              </div>

              <span
                class="status-badge"
                :class="getStatusClass(pengajuan.status)"
              >
                <span class="status-dot"></span>
                {{ pengajuan.status }}
              </span>
            </div>

            <div class="history-details">
              <span>
                <i class="fa-solid fa-calendar"></i>
                {{ pengajuan.tanggalMulai }} s/d {{ pengajuan.tanggalSelesai }}
              </span>
              <span>
                <i class="fa-solid fa-clock"></i>
                {{ pengajuan.waktuMulai }} - {{ pengajuan.waktuSelesai }}
              </span>
            </div>

            <p v-if="pengajuan.catatan" class="history-notes">
              <strong>Catatan:</strong> {{ pengajuan.catatan }}
            </p>

            <!-- TOMBOL AKSI CRUD (EDIT & DELETE) -->
            <div class="history-actions">
              <button 
                type="button" 
                class="action-btn edit" 
                @click="editPengajuan(pengajuan)"
                title="Edit Pengajuan"
              >
                <i class="fa-solid fa-pen-to-square"></i> Edit
              </button>
              <button 
                type="button" 
                class="action-btn delete" 
                @click="deletePengajuan(pengajuan.id)"
                title="Hapus Pengajuan"
              >
                <i class="fa-solid fa-trash"></i> Hapus
              </button>
            </div>
          </div>
        </article>
      </div>
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
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const currentYear = new Date().getFullYear()

// Pilihan fasilitas & ruangan dummy
const facilities = ref([
  'Lab Multimedia',
  'Aula Utama',
  'Ruang Musik',
  'Lapangan Basket',
  'Proyektor Portable'
])

// State Form
const form = ref({
  id: null,
  fasilitas: '',
  tanggalMulai: '',
  tanggalSelesai: '',
  waktuMulai: '',
  waktuSelesai: '',
  keperluan: '',
  catatan: ''
})

const isEditing = ref(false)
const pengajuanList = ref([])

onMounted(() => {
  const savedData = localStorage.getItem('schoolcare_pengajuan')
  if (savedData) {
    pengajuanList.value = JSON.parse(savedData)
  }
})

const saveToLocalStorage = () => {
  localStorage.setItem('schoolcare_pengajuan', JSON.stringify(pengajuanList.value))
}

const resetForm = () => {
  form.value = {
    id: null,
    fasilitas: '',
    tanggalMulai: '',
    tanggalSelesai: '',
    waktuMulai: '',
    waktuSelesai: '',
    keperluan: '',
    catatan: ''
  }
  isEditing.value = false
}

const submitPengajuan = () => {
  if (isEditing.value) {
    const index = pengajuanList.value.findIndex(item => item.id === form.value.id)
    if (index !== -1) {
      pengajuanList.value[index] = { ...form.value }
      saveToLocalStorage()
      alert('Pengajuan berhasil diperbarui!')
    }
  } else {
    const newItem = {
      ...form.value,
      id: Date.now(),
      status: 'Menunggu'
    }
    pengajuanList.value.unshift(newItem)
    saveToLocalStorage()
    alert('Pengajuan peminjaman berhasil dikirim!')
  }

  resetForm()
}

const editPengajuan = (item) => {
  form.value = { ...item }
  isEditing.value = true
  window.scrollTo({ top: 0, behavior: 'smooth' })
}

const cancelEdit = () => {
  resetForm()
}

const deletePengajuan = (id) => {
  if (confirm('Apakah kamu yakin ingin menghapus pengajuan ini?')) {
    pengajuanList.value = pengajuanList.value.filter(item => item.id !== id)
    saveToLocalStorage()
  }
}

const getStatusClass = (status) => {
  if (status === 'Menunggu') return 'pending'
  if (status === 'Disetujui') return 'approved'
  if (status === 'Ditolak') return 'rejected'
  return ''
}
</script>

<style scoped>
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css');

* {
  box-sizing: border-box;
}

.pengguna-pengajuan {
  min-height: 100vh;
  background: #f8fafc;
  color: #0f172a;
  font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
  padding: 30px 40px;
  display: flex;
  flex-direction: column;
}

/* HEADER TENGAH GAYA FASILITAS & RUANGAN */
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

/* FORM CARD */
.form-card {
  background: white;
  border: 1px solid #e2e8f0;
  border-radius: 14px;
  padding: 24px;
  margin-bottom: 30px;
}

.section-heading {
  display: flex;
  align-items: center;
  gap: 13px;
  margin-bottom: 22px;
}

.heading-icon {
  width: 44px;
  height: 44px;
  border-radius: 10px;
  background: #eff6ff;
  color: #2563eb;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 18px;
}

.section-heading h2 {
  margin: 0;
  font-size: 16px;
  font-weight: 800;
  color: #0f172a;
}

.section-heading p {
  margin: 3px 0 0;
  color: #64748b;
  font-size: 12px;
}

/* FORM STYLING */
.form-group {
  margin-bottom: 16px;
}

.form-row {
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
  gap: 16px;
}

.form-group label {
  display: block;
  margin-bottom: 6px;
  color: #334155;
  font-size: 12px;
  font-weight: 700;
}

.form-group label span {
  color: #ef4444;
}

.form-group label small {
  color: #94a3b8;
  font-weight: 500;
}

.input-wrapper {
  height: 42px;
  border: 1px solid #e2e8f0;
  background: #f8fafc;
  border-radius: 9px;
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 0 12px;
  transition: all 0.2s ease;
}

.input-wrapper:focus-within {
  border-color: #2563eb;
  background: white;
  box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.08);
}

.input-wrapper > i {
  color: #94a3b8;
  font-size: 13px;
  width: 15px;
  text-align: center;
  flex-shrink: 0;
}

.input-wrapper input,
.input-wrapper select,
.input-wrapper textarea {
  width: 100%;
  border: none;
  outline: none;
  background: transparent;
  color: #334155;
  font-family: inherit;
  font-size: 12px;
}

.input-wrapper select {
  cursor: pointer;
}

.textarea-wrapper {
  height: auto;
  align-items: flex-start;
  padding-top: 10px;
}

.textarea-wrapper textarea {
  resize: vertical;
  min-height: 70px;
  line-height: 1.5;
}

/* FORM ACTION */
.form-actions {
  display: flex;
  justify-content: flex-end;
  gap: 10px;
  margin-top: 22px;
  padding-top: 18px;
  border-top: 1px solid #f1f5f9;
}

.cancel-btn {
  border: 1px solid #e2e8f0;
  background: white;
  color: #64748b;
  padding: 10px 16px;
  border-radius: 9px;
  font-family: inherit;
  font-size: 12px;
  font-weight: 700;
  cursor: pointer;
  transition: all 0.2s ease;
}

.cancel-btn:hover {
  background: #f8fafc;
  color: #334155;
}

.submit-btn {
  border: none;
  background: #2563eb;
  color: white;
  padding: 10px 18px;
  border-radius: 9px;
  font-family: inherit;
  font-size: 12px;
  font-weight: 700;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 8px;
  transition: all 0.2s ease;
}

.submit-btn:hover {
  background: #1d4ed8;
}

/* HISTORY SECTION */
.history-section {
  margin-bottom: 30px;
}

.result-info {
  margin-bottom: 14px;
}

.result-info h2 {
  margin: 0;
  font-size: 16px;
  font-weight: 800;
  color: #0f172a;
}

.result-info p {
  margin: 3px 0 0;
  color: #64748b;
  font-size: 12px;
}

/* EMPTY STATE */
.empty-state {
  min-height: 220px;
  background: white;
  border: 1px dashed #cbd5e1;
  border-radius: 14px;
  padding: 30px 20px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  text-align: center;
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
  margin: 0;
  font-size: 15px;
  font-weight: 800;
  color: #334155;
}

.empty-state p {
  max-width: 350px;
  margin: 5px 0 0;
  color: #94a3b8;
  font-size: 12px;
  line-height: 1.5;
}

/* HISTORY LIST */
.history-list {
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.history-card {
  display: flex;
  align-items: flex-start;
  gap: 14px;
  background: white;
  border: 1px solid #e2e8f0;
  border-radius: 14px;
  padding: 16px;
  transition: all 0.2s ease;
}

.history-card:hover {
  border-color: #cbd5e1;
}

.history-icon {
  width: 42px;
  height: 42px;
  flex-shrink: 0;
  border-radius: 10px;
  background: #eff6ff;
  color: #2563eb;
  display: flex;
  align-items: center;
  justify-content: center;
}

.history-content {
  flex: 1;
  min-width: 0;
}

.history-top {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  gap: 15px;
}

.history-category {
  color: #2563eb;
  font-size: 10px;
  font-weight: 800;
  text-transform: uppercase;
}

.history-content h3 {
  margin: 3px 0 6px;
  color: #0f172a;
  font-size: 13px;
  font-weight: 800;
}

.history-details {
  display: flex;
  align-items: center;
  gap: 16px;
  color: #64748b;
  font-size: 11px;
  margin-bottom: 6px;
}

.history-details span {
  display: flex;
  align-items: center;
  gap: 6px;
}

.history-notes {
  margin: 6px 0 10px;
  font-size: 11px;
  color: #475569;
  background: #f8fafc;
  padding: 6px 10px;
  border-radius: 6px;
  border: 1px solid #f1f5f9;
}

.history-actions {
  display: flex;
  gap: 8px;
  margin-top: 8px;
}

.action-btn {
  padding: 5px 10px;
  border-radius: 6px;
  font-size: 10px;
  font-weight: 700;
  cursor: pointer;
  border: 1px solid transparent;
  display: inline-flex;
  align-items: center;
  gap: 5px;
}

.action-btn.edit {
  background: #eff6ff;
  color: #2563eb;
  border-color: #dbeafe;
}

.action-btn.edit:hover {
  background: #2563eb;
  color: white;
}

.action-btn.delete {
  background: #fef2f2;
  color: #dc2626;
  border-color: #fee2e2;
}

.action-btn.delete:hover {
  background: #dc2626;
  color: white;
}

.status-badge {
  flex-shrink: 0;
  padding: 4px 10px;
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

.status-badge.pending { background: #fffbeb; color: #d97706; }
.status-badge.pending .status-dot { background: #f59e0b; }

.status-badge.approved { background: #f0fdf4; color: #16a34a; }
.status-badge.approved .status-dot { background: #22c55e; }

.status-badge.rejected { background: #fef2f2; color: #dc2626; }
.status-badge.rejected .status-dot { background: #ef4444; }

/* FOOTER */
.footer {
  margin-top: auto;
  padding-top: 15px;
  border-top: 1px solid #e2e8f0;
  text-align: center;
  color: #94a3b8;
  font-size: 11px;
}

@media (max-width: 800px) {
  .pengguna-pengajuan {
    padding: 20px;
  }
  .form-row {
    grid-template-columns: 1fr;
    gap: 0;
  }
}
</style>
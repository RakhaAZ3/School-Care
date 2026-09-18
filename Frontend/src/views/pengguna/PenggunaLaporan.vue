<template>
  <div class="pengguna-laporan">
    <!-- =========================
         HEADER UTAMA TENGAH (Gaya Seragam)
    ========================== -->
    <div class="content-header-center">
      <div class="badge-header">Panel Pengguna</div>
      <h1>Laporan Kerusakan</h1>
      <p>Laporkan kerusakan fasilitas sekolah dengan mudah dan pantau status penanganannya.</p>
    </div>

    <!-- =========================
         PAGE CONTENT
    ========================== -->
    <main class="page-content">

      <!-- =========================
           FORM CARD
      ========================== -->
      <section class="report-card">
        <div class="card-title">
          <div class="title-icon">
            <i class="fa-solid fa-file-circle-exclamation"></i>
          </div>

          <div>
            <h3>Buat Laporan Baru</h3>
            <p>Isi data kerusakan fasilitas di bawah ini.</p>
          </div>
        </div>

        <form @submit.prevent="submitReport">

          <!-- FASILITAS -->
          <div class="form-group">
            <label for="fasilitas">
              Fasilitas <span>*</span>
            </label>

            <select
              id="fasilitas"
              v-model="form.fasilitas"
              required
            >
              <option value="" disabled>
                Pilih fasilitas
              </option>

              <option
                v-for="facility in facilities"
                :key="facility.id"
                :value="facility.id"
              >
                {{ facility.nama }}
              </option>
            </select>

            <small
              v-if="facilities.length === 0"
              class="form-info"
            >
              <i class="fa-solid fa-circle-info"></i>
              Data fasilitas akan muncul setelah terhubung dengan backend.
            </small>
          </div>

          <!-- KONDISI -->
          <div class="form-group">
            <label for="kondisi">
              Kondisi Kerusakan <span>*</span>
            </label>

            <select
              id="kondisi"
              v-model="form.kondisi"
              required
            >
              <option value="" disabled>
                Pilih kondisi
              </option>

              <option value="ringan">
                Kerusakan Ringan
              </option>

              <option value="sedang">
                Kerusakan Sedang
              </option>

              <option value="berat">
                Kerusakan Berat
              </option>
            </select>
          </div>

          <!-- JUDUL -->
          <div class="form-group">
            <label for="judul">
              Judul Laporan <span>*</span>
            </label>

            <input
              id="judul"
              v-model="form.judul"
              type="text"
              placeholder="Contoh: Kursi rusak di ruang kelas"
              required
            />
          </div>

          <!-- DESKRIPSI -->
          <div class="form-group">
            <label for="deskripsi">
              Deskripsi Kerusakan <span>*</span>
            </label>

            <textarea
              id="deskripsi"
              v-model="form.deskripsi"
              rows="5"
              placeholder="Jelaskan kondisi atau kerusakan fasilitas secara detail..."
              required
            ></textarea>
          </div>

          <!-- LOKASI -->
          <div class="form-group">
            <label for="lokasi">
              Lokasi <span>*</span>
            </label>

            <input
              id="lokasi"
              v-model="form.lokasi"
              type="text"
              placeholder="Contoh: Ruang XI RPL 1"
              required
            />
          </div>

          <!-- FOTO -->
          <div class="form-group">
            <label for="foto">
              Foto Kerusakan
            </label>

            <div class="upload-box">
              <input
                id="foto"
                type="file"
                accept="image/*"
                @change="handleFile"
              />

              <div class="upload-content">
                <div class="upload-icon">
                  <i class="fa-solid fa-cloud-arrow-up"></i>
                </div>

                <strong>
                  Klik untuk memilih foto
                </strong>

                <span>
                  JPG, JPEG, atau PNG
                </span>

                <small v-if="form.foto">
                  {{ form.foto.name }}
                </small>
              </div>
            </div>
          </div>

          <!-- BUTTON -->
          <div class="form-actions">
            <button
              type="button"
              class="btn-secondary"
              @click="resetForm"
            >
              <i class="fa-solid fa-rotate-left"></i>
              Reset
            </button>

            <button
              type="submit"
              class="btn-primary"
            >
              <i class="fa-solid fa-paper-plane"></i>
              Kirim Laporan
            </button>
          </div>

        </form>
      </section>

      <!-- =========================
           RIWAYAT LAPORAN
      ========================== -->
      <section class="history-section">
        <div class="section-header">
          <div>
            <h3>Riwayat Laporan Saya</h3>
            <p>Lihat laporan kerusakan yang pernah kamu buat.</p>
          </div>
        </div>

        <!-- EMPTY STATE -->
        <div
          v-if="reports.length === 0"
          class="empty-state"
        >
          <div class="empty-icon">
            <i class="fa-solid fa-file-circle-exclamation"></i>
          </div>

          <h4>Belum Ada Laporan</h4>

          <p>
            Kamu belum memiliki laporan kerusakan.
            Laporan yang kamu kirim akan muncul di sini.
          </p>
        </div>

        <!-- REPORT LIST -->
        <div
          v-else
          class="report-list"
        >
          <div
            v-for="report in reports"
            :key="report.id"
            class="report-item"
          >
            <div class="report-icon">
              <i class="fa-solid fa-triangle-exclamation"></i>
            </div>

            <div class="report-content">
              <div class="report-top">
                <h4>{{ report.judul }}</h4>

                <span
                  class="status-badge"
                  :class="getStatusClass(report.status)"
                >
                  {{ report.status }}
                </span>
              </div>

              <p>
                {{ report.deskripsi }}
              </p>

              <div class="report-meta">
                <span>
                  <i class="fa-solid fa-location-dot"></i>
                  {{ report.lokasi }}
                </span>

                <span>
                  <i class="fa-regular fa-calendar"></i>
                  {{ report.tanggal }}
                </span>
              </div>
            </div>
          </div>
        </div>
      </section>

    </main>

    <!-- =========================
         FOOTER
    ========================== -->
    <footer class="footer">
      <p>
        © {{ currentYear }} SchoolCare. All rights reserved.
      </p>
    </footer>

  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()

// FORM
const form = ref({
  fasilitas: '',
  kondisi: '',
  judul: '',
  deskripsi: '',
  lokasi: '',
  foto: null
})

// DATA FASILITAS & LAPORAN
const facilities = ref([])
const reports = ref([])

// FILE
const handleFile = (event) => {
  const file = event.target.files[0]
  if (file) {
    form.value.foto = file
  }
}

// SUBMIT
const submitReport = () => {
  console.log('Data laporan:', {
    fasilitas: form.value.fasilitas,
    kondisi: form.value.kondisi,
    judul: form.value.judul,
    deskripsi: form.value.deskripsi,
    lokasi: form.value.lokasi,
    foto: form.value.foto
  })

  alert(
    'Form laporan sudah siap. Pengiriman laporan akan aktif setelah backend terhubung.'
  )
}

// RESET
const resetForm = () => {
  form.value = {
    fasilitas: '',
    kondisi: '',
    judul: '',
    deskripsi: '',
    lokasi: '',
    foto: null
  }

  const fileInput = document.getElementById('foto')
  if (fileInput) {
    fileInput.value = ''
  }
}

// STATUS
const getStatusClass = (status) => {
  if (status === 'Selesai') return 'status-selesai'
  if (status === 'Diproses') return 'status-diproses'
  if (status === 'Ditolak') return 'status-ditolak'
  return 'status-menunggu'
}

// YEAR
const currentYear = new Date().getFullYear()
</script>

<style scoped>
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css');

* {
  box-sizing: border-box;
}

.pengguna-laporan {
  min-height: 100vh;
  background: #f8fafc;
  color: #0f172a;
  font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
  padding: 30px 40px;
  display: flex;
  flex-direction: column;
}

/* HEADER TENGAH GAYA SERAGAM */
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

/* PAGE CONTENT */
.page-content {
  width: 100%;
  max-width: 1200px;
  margin: 0 auto;
  flex: 1;
}

/* REPORT CARD */
.report-card {
  background: #ffffff;
  border: 1px solid #e2e8f0;
  border-radius: 14px;
  padding: 24px;
  margin-bottom: 30px;
  transition: all 0.2s ease;
}

.report-card:hover {
  border-color: #dbeafe;
}

/* CARD TITLE */
.card-title {
  display: flex;
  align-items: center;
  gap: 13px;
  margin-bottom: 22px;
  padding-bottom: 18px;
  border-bottom: 1px solid #f1f5f9;
}

.title-icon {
  width: 44px;
  height: 44px;
  border-radius: 10px;
  background: #eff6ff;
  color: #2563eb;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 18px;
  flex-shrink: 0;
}

.card-title h3 {
  margin: 0 0 3px;
  color: #0f172a;
  font-size: 16px;
  font-weight: 800;
}

.card-title p {
  margin: 0;
  color: #64748b;
  font-size: 12px;
}

/* FORM */
.form-group {
  margin-bottom: 16px;
}

.form-group label {
  display: block;
  margin-bottom: 6px;
  font-size: 12px;
  font-weight: 700;
  color: #334155;
}

.form-group label span {
  color: #ef4444;
}

.form-group input,
.form-group select,
.form-group textarea {
  width: 100%;
  border: 1px solid #e2e8f0;
  border-radius: 9px;
  background: #f8fafc;
  color: #334155;
  padding: 10px 12px;
  font-family: inherit;
  font-size: 12px;
  outline: none;
  transition: all 0.2s ease;
}

.form-group input:hover,
.form-group select:hover,
.form-group textarea:hover {
  border-color: #cbd5e1;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
  border-color: #2563eb;
  background: #ffffff;
  box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.08);
}

.form-group textarea {
  resize: vertical;
  min-height: 100px;
}

.form-info {
  display: flex;
  align-items: center;
  gap: 6px;
  margin-top: 6px;
  color: #64748b;
  font-size: 10px;
}

/* UPLOAD */
.upload-box {
  position: relative;
  min-height: 130px;
  border: 1.5px dashed #cbd5e1;
  border-radius: 11px;
  background: #f8fafc;
  overflow: hidden;
  transition: all 0.2s ease;
}

.upload-box:hover {
  border-color: #93c5fd;
  background: #eff6ff;
}

.upload-box input {
  position: absolute;
  inset: 0;
  width: 100%;
  height: 100%;
  opacity: 0;
  cursor: pointer;
  z-index: 2;
}

.upload-content {
  min-height: 130px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  gap: 4px;
  color: #64748b;
}

.upload-icon {
  width: 40px;
  height: 40px;
  border-radius: 10px;
  background: #ffffff;
  color: #2563eb;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 4px;
  box-shadow: 0 4px 12px rgba(15, 23, 42, 0.06);
}

.upload-content strong {
  color: #334155;
  font-size: 12px;
}

.upload-content span {
  font-size: 10px;
  color: #94a3b8;
}

.upload-content small {
  color: #2563eb;
  font-size: 10px;
  margin-top: 2px;
}

/* BUTTON */
.form-actions {
  display: flex;
  justify-content: flex-end;
  gap: 10px;
  margin-top: 22px;
  padding-top: 18px;
  border-top: 1px solid #f1f5f9;
}

.btn-primary,
.btn-secondary {
  border: none;
  border-radius: 9px;
  height: 40px;
  padding: 0 16px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  font-size: 11px;
  font-weight: 800;
  cursor: pointer;
  transition: all 0.2s ease;
}

.btn-primary {
  color: #ffffff;
  background: #2563eb;
}

.btn-primary:hover {
  background: #1d4ed8;
}

.btn-secondary {
  color: #475569;
  background: #f1f5f9;
  border: 1px solid #e2e8f0;
}

.btn-secondary:hover {
  background: #e2e8f0;
}

/* HISTORY */
.history-section {
  margin-top: 30px;
}

.section-header {
  margin-bottom: 14px;
}

.section-header h3 {
  margin: 0 0 3px;
  font-size: 16px;
  color: #0f172a;
  font-weight: 800;
}

.section-header p {
  margin: 0;
  color: #64748b;
  font-size: 12px;
}

/* EMPTY STATE */
.empty-state {
  min-height: 220px;
  padding: 30px 20px;
  background: #ffffff;
  border: 1px dashed #cbd5e1;
  border-radius: 14px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
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

.empty-state h4 {
  margin: 0 0 6px;
  color: #334155;
  font-size: 15px;
  font-weight: 800;
}

.empty-state p {
  margin: 0;
  max-width: 400px;
  color: #94a3b8;
  font-size: 11px;
  line-height: 1.6;
}

/* REPORT LIST */
.report-list {
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.report-item {
  background: #ffffff;
  border: 1px solid #e2e8f0;
  border-radius: 14px;
  padding: 16px;
  display: flex;
  gap: 14px;
  transition: all 0.2s ease;
}

.report-item:hover {
  border-color: #cbd5e1;
}

.report-icon {
  width: 42px;
  height: 42px;
  border-radius: 10px;
  background: #eff6ff;
  color: #2563eb;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.report-content {
  flex: 1;
  min-width: 0;
}

.report-top {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  gap: 12px;
}

.report-top h4 {
  margin: 0;
  font-size: 13px;
  color: #0f172a;
  font-weight: 800;
}

.report-content > p {
  margin: 6px 0 10px;
  color: #64748b;
  font-size: 11px;
  line-height: 1.5;
}

.report-meta {
  display: flex;
  flex-wrap: wrap;
  gap: 15px;
  color: #94a3b8;
  font-size: 10px;
}

.report-meta span {
  display: inline-flex;
  align-items: center;
  gap: 5px;
}

/* STATUS */
.status-badge {
  padding: 4px 10px;
  border-radius: 20px;
  font-size: 10px;
  font-weight: 700;
  white-space: nowrap;
}

.status-menunggu { color: #d97706; background: #fffbeb; }
.status-diproses { color: #2563eb; background: #eff6ff; }
.status-selesai { color: #16a34a; background: #f0fdf4; }
.status-ditolak { color: #dc2626; background: #fef2f2; }

/* FOOTER */
.footer {
  width: 100%;
  margin-top: auto;
  padding-top: 15px;
  border-top: 1px solid #e2e8f0;
  text-align: center;
  color: #94a3b8;
  font-size: 11px;
}

@media (max-width: 700px) {
  .pengguna-laporan {
    padding: 20px;
  }
  .form-actions {
    flex-direction: column-reverse;
  }
  .btn-primary,
  .btn-secondary {
    width: 100%;
  }
}
</style>
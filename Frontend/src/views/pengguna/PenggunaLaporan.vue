<template>
  <div class="pengguna-laporan">

    <!-- =========================
         HEADER
    ========================== -->
    <header class="page-header">
      <div class="header-left">
        <button
          type="button"
          class="back-btn"
          @click="goTo('/pengguna/dashboard')"
        >
          <i class="fa-solid fa-arrow-left"></i>
        </button>

        <div>
          <h1>Laporan Kerusakan</h1>
          <p>
            Laporkan kerusakan fasilitas sekolah dengan mudah.
          </p>
        </div>
      </div>

      <button
        type="button"
        class="dashboard-btn"
        @click="goTo('/pengguna/dashboard')"
      >
        <i class="fa-solid fa-house"></i>
        Dashboard
      </button>
    </header>

    <!-- =========================
         PAGE CONTENT
    ========================== -->
    <main class="page-content">

      <!-- =========================
           PAGE INTRO
      ========================== -->
      <section class="intro-section">
        <div>
          <span class="page-label">
            <i class="fa-solid fa-circle-exclamation"></i>
            Laporan
          </span>

          <h2>Lapor Kerusakan Fasilitas</h2>

          <p>
            Temukan fasilitas yang bermasalah? Laporkan agar dapat segera
            ditindaklanjuti oleh pihak sekolah.
          </p>
        </div>
      </section>

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
            <p>
              Isi data kerusakan fasilitas di bawah ini.
            </p>
          </div>
        </div>

        <form @submit.prevent="submitReport">

          <!-- FASILITAS -->
          <div class="form-group">
            <label for="fasilitas">
              Fasilitas
              <span>*</span>
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
              Kondisi Kerusakan
              <span>*</span>
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
              Judul Laporan
              <span>*</span>
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
              Deskripsi Kerusakan
              <span>*</span>
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
              Lokasi
              <span>*</span>
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
            <span class="section-label">
              <i class="fa-solid fa-clock-rotate-left"></i>
              Riwayat
            </span>

            <h3>Riwayat Laporan Saya</h3>

            <p>
              Lihat laporan kerusakan yang pernah kamu buat.
            </p>
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

// ==========================================
// FORM
// ==========================================

const form = ref({
  fasilitas: '',
  kondisi: '',
  judul: '',
  deskripsi: '',
  lokasi: '',
  foto: null
})

// ==========================================
// DATA FASILITAS
// ==========================================

// Sengaja kosong karena backend belum dibuat.
const facilities = ref([])

// ==========================================
// RIWAYAT LAPORAN
// ==========================================

// Sengaja kosong karena backend belum dibuat.
const reports = ref([])

// ==========================================
// NAVIGATION
// ==========================================

const goTo = (path) => {
  router.push(path)
}

// ==========================================
// FILE
// ==========================================

const handleFile = (event) => {
  const file = event.target.files[0]

  if (file) {
    form.value.foto = file
  }
}

// ==========================================
// SUBMIT
// ==========================================

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

// ==========================================
// RESET
// ==========================================

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

// ==========================================
// STATUS
// ==========================================

const getStatusClass = (status) => {
  if (status === 'Selesai') {
    return 'status-selesai'
  }

  if (status === 'Diproses') {
    return 'status-diproses'
  }

  if (status === 'Ditolak') {
    return 'status-ditolak'
  }

  return 'status-menunggu'
}

// ==========================================
// YEAR
// ==========================================

const currentYear = new Date().getFullYear()
</script>


<style scoped>
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css');

* {
  box-sizing: border-box;
}

/* =========================================
   GLOBAL
========================================= */

.pengguna-laporan {
  min-height: 100vh;
  background: #f8fafc;
  color: #0f172a;
  font-family:
    'Plus Jakarta Sans',
    'Inter',
    sans-serif;
  padding: 30px 40px;
  display: flex;
  flex-direction: column;
}

/* =========================================
   HEADER
========================================= */

.page-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 20px;
  margin-bottom: 30px;
}

.header-left {
  display: flex;
  align-items: center;
  gap: 15px;
}

.back-btn {
  width: 42px;
  height: 42px;
  border: 1px solid #e2e8f0;
  background: #ffffff;
  color: #475569;
  border-radius: 11px;
  cursor: pointer;
  transition: all 0.2s ease;
  display: flex;
  align-items: center;
  justify-content: center;
}

.back-btn:hover {
  color: #2563eb;
  border-color: #bfdbfe;
  transform: translateX(-2px);
}

.back-btn i {
  font-size: 14px;
}

.page-header h1 {
  margin: 0;
  font-size: 24px;
  font-weight: 800;
  color: #0f172a;
}

.page-header p {
  margin: 5px 0 0;
  color: #64748b;
  font-size: 12px;
}

.dashboard-btn {
  border: 1px solid #dbeafe;
  background: #eff6ff;
  color: #2563eb;
  padding: 11px 15px;
  border-radius: 10px;
  font-size: 12px;
  font-weight: 700;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 8px;
  transition: all 0.2s ease;
}

.dashboard-btn:hover {
  background: #dbeafe;
}

/* =========================================
   PAGE CONTENT
========================================= */

.page-content {
  width: 100%;
  max-width: 1200px;
  margin: 0 auto;
  flex: 1;
}

/* =========================================
   INTRO
========================================= */

.intro-section {
  margin-bottom: 24px;
}

.page-label,
.section-label {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  font-size: 11px;
  font-weight: 800;
  color: #2563eb;
  margin-bottom: 7px;
}

.page-header + .page-content h2,
.intro-section h2 {
  margin: 0 0 8px;
  font-size: 26px;
  font-weight: 800;
  color: #0f172a;
}

.intro-section p {
  max-width: 680px;
  margin: 0;
  color: #64748b;
  font-size: 13px;
  line-height: 1.7;
}

/* =========================================
   REPORT CARD
========================================= */

.report-card {
  background: #ffffff;
  border: 1px solid #e2e8f0;
  border-radius: 17px;
  padding: 26px;
  box-shadow:
    0 8px 25px rgba(15, 23, 42, 0.04);
  transition: all 0.2s ease;
}

.report-card:hover {
  border-color: #dbeafe;
}

/* =========================================
   CARD TITLE
========================================= */

.card-title {
  display: flex;
  align-items: center;
  gap: 13px;
  margin-bottom: 25px;
  padding-bottom: 20px;
  border-bottom: 1px solid #f1f5f9;
}

.title-icon {
  width: 48px;
  height: 48px;
  border-radius: 13px;
  background:
    linear-gradient(
      135deg,
      #eff6ff,
      #ede9fe
    );
  color: #2563eb;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 18px;
  flex-shrink: 0;
}

.card-title h3 {
  margin: 0 0 4px;
  color: #0f172a;
  font-size: 17px;
  font-weight: 800;
}

.card-title p {
  margin: 0;
  color: #64748b;
  font-size: 12px;
}

/* =========================================
   FORM
========================================= */

.form-group {
  margin-bottom: 19px;
}

.form-group label {
  display: block;
  margin-bottom: 8px;
  font-size: 12px;
  font-weight: 800;
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
  border-radius: 10px;
  background: #f8fafc;
  color: #334155;
  padding: 12px 14px;
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
  box-shadow:
    0 0 0 3px rgba(37, 99, 235, 0.08);
}

.form-group textarea {
  resize: vertical;
  min-height: 120px;
}

.form-group input::placeholder,
.form-group textarea::placeholder {
  color: #94a3b8;
}

.form-info {
  display: flex;
  align-items: center;
  gap: 6px;
  margin-top: 7px;
  color: #64748b;
  font-size: 10px;
}

/* =========================================
   UPLOAD
========================================= */

.upload-box {
  position: relative;
  min-height: 145px;
  border: 1.5px dashed #cbd5e1;
  border-radius: 13px;
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
  min-height: 145px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  gap: 5px;
  color: #64748b;
}

.upload-icon {
  width: 43px;
  height: 43px;
  border-radius: 12px;
  background: #ffffff;
  color: #2563eb;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 4px;
  box-shadow:
    0 4px 12px rgba(15, 23, 42, 0.06);
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
  margin-top: 3px;
}

/* =========================================
   BUTTON
========================================= */

.form-actions {
  display: flex;
  justify-content: flex-end;
  gap: 10px;
  margin-top: 25px;
  padding-top: 20px;
  border-top: 1px solid #f1f5f9;
}

.btn-primary,
.btn-secondary {
  border: none;
  border-radius: 10px;
  min-height: 42px;
  padding: 0 18px;
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
  background:
    linear-gradient(
      135deg,
      #2563eb,
      #7c3aed
    );
}

.btn-primary:hover {
  transform: translateY(-2px);
  box-shadow:
    0 8px 20px rgba(37, 99, 235, 0.20);
}

.btn-secondary {
  color: #475569;
  background: #f1f5f9;
}

.btn-secondary:hover {
  background: #e2e8f0;
}

/* =========================================
   HISTORY
========================================= */

.history-section {
  margin-top: 35px;
}

.section-header {
  margin-bottom: 15px;
}

.section-header h3 {
  margin: 0 0 5px;
  font-size: 19px;
  color: #0f172a;
  font-weight: 800;
}

.section-header p {
  margin: 0;
  color: #64748b;
  font-size: 12px;
}

/* =========================================
   EMPTY STATE
========================================= */

.empty-state {
  min-height: 280px;
  padding: 35px 20px;
  background: #ffffff;
  border: 1px dashed #cbd5e1;
  border-radius: 17px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  text-align: center;
}

.empty-icon {
  width: 64px;
  height: 64px;
  border-radius: 17px;
  background:
    linear-gradient(
      135deg,
      #eff6ff,
      #ede9fe
    );
  color: #2563eb;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 24px;
  margin-bottom: 15px;
}

.empty-state h4 {
  margin: 0 0 7px;
  color: #334155;
  font-size: 15px;
  font-weight: 800;
}

.empty-state p {
  margin: 0;
  max-width: 450px;
  color: #94a3b8;
  font-size: 11px;
  line-height: 1.7;
}

/* =========================================
   REPORT LIST
========================================= */

.report-list {
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.report-item {
  background: #ffffff;
  border: 1px solid #e2e8f0;
  border-radius: 15px;
  padding: 17px;
  display: flex;
  gap: 14px;
  transition: all 0.2s ease;
}

.report-item:hover {
  border-color: #bfdbfe;
  transform: translateY(-2px);
  box-shadow:
    0 10px 24px rgba(15, 23, 42, 0.06);
}

.report-icon {
  width: 44px;
  height: 44px;
  border-radius: 12px;
  background:
    linear-gradient(
      135deg,
      #eff6ff,
      #ede9fe
    );
  color: #2563eb;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.report-content {
  flex: 1;
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
  margin: 7px 0 10px;
  color: #64748b;
  font-size: 11px;
  line-height: 1.6;
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

/* =========================================
   STATUS
========================================= */

.status-badge {
  padding: 5px 9px;
  border-radius: 999px;
  font-size: 9px;
  font-weight: 800;
  white-space: nowrap;
}

.status-menunggu {
  color: #b45309;
  background: #fef3c7;
}

.status-diproses {
  color: #2563eb;
  background: #dbeafe;
}

.status-selesai {
  color: #15803d;
  background: #dcfce7;
}

.status-ditolak {
  color: #dc2626;
  background: #fee2e2;
}

/* =========================================
   FOOTER
========================================= */

.footer {
  width: 100%;
  margin-top: 35px;
  padding: 20px 0 5px;
  border-top: 1px solid #e2e8f0;
}

.footer p {
  margin: 0;
  color: #94a3b8;
  text-align: center;
  font-size: 10px;
}

/* =========================================
   RESPONSIVE
========================================= */

@media (max-width: 700px) {

  .pengguna-laporan {
    padding: 20px;
  }

  .page-header {
    align-items: flex-start;
  }

  .dashboard-btn {
    display: none;
  }

  .page-header h1 {
    font-size: 20px;
  }

  .intro-section h2 {
    font-size: 22px;
  }

  .report-card {
    padding: 20px;
  }

  .form-actions {
    flex-direction: column-reverse;
  }

  .btn-primary,
  .btn-secondary {
    width: 100%;
  }

  .report-top {
    flex-direction: column;
  }

  .report-item {
    padding: 15px;
  }

  .footer {
    padding: 18px 0 5px;
  }
}
</style>
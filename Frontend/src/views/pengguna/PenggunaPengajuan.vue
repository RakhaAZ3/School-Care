<template>

  <div class="pengguna-pengajuan">

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
          <h1>Pengajuan Saya</h1>

          <p>
            Ajukan peminjaman fasilitas dan lihat riwayat pengajuan.
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
         FORM PENGAJUAN
    ========================== -->
    <section class="form-card">

      <div class="section-heading">

        <div class="heading-icon">
          <i class="fa-solid fa-file-circle-plus"></i>
        </div>

        <div>
          <h2>Ajukan Peminjaman</h2>

          <p>
            Isi formulir berikut untuk mengajukan peminjaman fasilitas.
          </p>
        </div>

      </div>


      <form @submit.prevent="submitPengajuan">

        <!-- FASILITAS -->
        <div class="form-group">

          <label for="fasilitas">
            Fasilitas
            <span>*</span>
          </label>

          <div class="input-wrapper">

            <i class="fa-solid fa-boxes-stacked"></i>

            <select
              id="fasilitas"
              v-model="form.fasilitas"
              required
            >

              <option value="">
                Pilih fasilitas
              </option>

              <option
                v-for="facility in facilities"
                :key="facility.id"
                :value="facility.nama"
              >
                {{ facility.nama }}
              </option>

            </select>

          </div>

          <small v-if="facilities.length === 0">
            Data fasilitas akan tersedia setelah sistem terhubung dengan backend.
          </small>

        </div>


        <!-- TANGGAL -->
        <div class="form-row">

          <div class="form-group">

            <label for="tanggal_mulai">
              Tanggal Peminjaman
              <span>*</span>
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
              Tanggal Selesai
              <span>*</span>
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
              Waktu Mulai
              <span>*</span>
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
              Waktu Selesai
              <span>*</span>
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
            Keperluan
            <span>*</span>
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
            Catatan
            <small>(opsional)</small>
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
            <i class="fa-solid fa-paper-plane"></i>
            Ajukan Peminjaman
          </button>

        </div>

      </form>

    </section>


    <!-- =========================
         RIWAYAT PENGAJUAN
    ========================== -->
    <section class="history-section">

      <div class="result-info">

        <div>

          <h2>Riwayat Pengajuan</h2>

          <p>
            Daftar pengajuan peminjaman yang pernah kamu lakukan.
          </p>

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

        <h3>
          Belum Ada Pengajuan
        </h3>

        <p>
          Pengajuan yang kamu buat akan tampil di halaman ini.
        </p>

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

                <h3>
                  {{ pengajuan.keperluan }}
                </h3>

              </div>

              <span
                class="status-badge"
                :class="getStatusClass(pengajuan.status)"
              >
                {{ pengajuan.status }}
              </span>

            </div>


            <div class="history-details">

              <span>
                <i class="fa-solid fa-calendar"></i>
                {{ pengajuan.tanggal }}
              </span>

              <span>
                <i class="fa-solid fa-clock"></i>
                {{ pengajuan.waktu }}
              </span>

            </div>

          </div>

        </article>

      </div>

    </section>


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


// ==========================================
// ROUTER
// ==========================================

const router = useRouter()


// ==========================================
// TAHUN
// ==========================================

const currentYear = new Date().getFullYear()


// ==========================================
// FORM
// ==========================================

const form = ref({

  fasilitas: '',
  tanggalMulai: '',
  tanggalSelesai: '',
  waktuMulai: '',
  waktuSelesai: '',
  keperluan: '',
  catatan: ''

})


// ==========================================
// DATA FASILITAS
// ==========================================

// Sengaja kosong karena belum terhubung backend.
// Nanti data fasilitas diambil dari API.

const facilities = ref([])


// ==========================================
// RIWAYAT PENGAJUAN
// ==========================================

// Sengaja kosong karena belum ada backend.

const pengajuanList = ref([])


// ==========================================
// NAVIGATION
// ==========================================

const goTo = (path) => {

  router.push(path)

}


// ==========================================
// RESET FORM
// ==========================================

const resetForm = () => {

  form.value = {

    fasilitas: '',
    tanggalMulai: '',
    tanggalSelesai: '',
    waktuMulai: '',
    waktuSelesai: '',
    keperluan: '',
    catatan: ''

  }

}


// ==========================================
// SUBMIT PENGAJUAN
// ==========================================

const submitPengajuan = () => {

  console.log(
    'Data pengajuan:',
    form.value
  )

  alert(
    'Form pengajuan sudah siap. Pengiriman data akan diaktifkan setelah backend terhubung.'
  )

}


// ==========================================
// STATUS CLASS
// ==========================================

const getStatusClass = (status) => {

  if (status === 'Menunggu') {

    return 'pending'

  }

  if (status === 'Disetujui') {

    return 'approved'

  }

  if (status === 'Ditolak') {

    return 'rejected'

  }

  return ''

}

</script>


<style scoped>

/* =========================================
   FONT AWESOME
========================================= */

@import url(
  'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css'
);


/* =========================================
   GLOBAL
========================================= */

* {
  box-sizing: border-box;
}

.pengguna-pengajuan {

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

  margin-bottom: 25px;

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

  background: white;

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
   FORM CARD
========================================= */

.form-card {

  background: white;

  border: 1px solid #e2e8f0;

  border-radius: 18px;

  padding: 25px;

  margin-bottom: 35px;

}


.section-heading {

  display: flex;

  align-items: center;

  gap: 13px;

  margin-bottom: 25px;

}


.heading-icon {

  width: 45px;

  height: 45px;

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

  font-size: 17px;

}


.section-heading h2 {

  margin: 0;

  font-size: 18px;

  font-weight: 800;

}


.section-heading p {

  margin: 4px 0 0;

  color: #94a3b8;

  font-size: 11px;

}


/* =========================================
   FORM
========================================= */

.form-group {

  margin-bottom: 18px;

}


.form-row {

  display: grid;

  grid-template-columns:
    repeat(2, minmax(0, 1fr));

  gap: 18px;

}


.form-group label {

  display: block;

  margin-bottom: 7px;

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

  height: 44px;

  border: 1px solid #e2e8f0;

  background: #f8fafc;

  border-radius: 10px;

  display: flex;

  align-items: center;

  gap: 10px;

  padding: 0 13px;

  transition: all 0.2s ease;

}


.input-wrapper:focus-within {

  border-color: #2563eb;

  background: white;

  box-shadow:
    0 0 0 3px
    rgba(37, 99, 235, 0.08);

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

  padding-top: 12px;

}


.textarea-wrapper textarea {

  resize: vertical;

  min-height: 70px;

  line-height: 1.6;

}


.input-wrapper input::placeholder,
.input-wrapper textarea::placeholder {

  color: #94a3b8;

}


.form-group > small {

  display: block;

  margin-top: 6px;

  color: #94a3b8;

  font-size: 10px;

  line-height: 1.5;

}


/* =========================================
   FORM ACTION
========================================= */

.form-actions {

  display: flex;

  justify-content: flex-end;

  gap: 10px;

  margin-top: 25px;

  padding-top: 20px;

  border-top: 1px solid #f1f5f9;

}


.cancel-btn {

  border: 1px solid #e2e8f0;

  background: white;

  color: #64748b;

  padding: 11px 18px;

  border-radius: 10px;

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

  background:
    linear-gradient(
      135deg,
      #2563eb,
      #7c3aed
    );

  color: white;

  padding: 11px 18px;

  border-radius: 10px;

  font-family: inherit;

  font-size: 12px;

  font-weight: 700;

  cursor: pointer;

  display: flex;

  align-items: center;

  gap: 8px;

  transition: all 0.2s ease;

  box-shadow:
    0 7px 18px
    rgba(37, 99, 235, 0.15);

}


.submit-btn:hover {

  transform: translateY(-2px);

  box-shadow:
    0 10px 22px
    rgba(37, 99, 235, 0.2);

}


/* =========================================
   HISTORY
========================================= */

.history-section {

  margin-bottom: 35px;

}


.result-info {

  margin-bottom: 16px;

}


.result-info h2 {

  margin: 0;

  font-size: 18px;

  font-weight: 800;

}


.result-info p {

  margin: 4px 0 0;

  color: #94a3b8;

  font-size: 11px;

}


/* =========================================
   EMPTY STATE
========================================= */

.empty-state {

  min-height: 260px;

  background: white;

  border: 1px dashed #cbd5e1;

  border-radius: 18px;

  padding: 40px 20px;

  display: flex;

  flex-direction: column;

  align-items: center;

  justify-content: center;

  text-align: center;

}


.empty-icon {

  width: 65px;

  height: 65px;

  border-radius: 18px;

  background: #eff6ff;

  color: #2563eb;

  display: flex;

  align-items: center;

  justify-content: center;

  font-size: 25px;

  margin-bottom: 15px;

}


.empty-state h3 {

  margin: 0;

  font-size: 16px;

  font-weight: 800;

  color: #334155;

}


.empty-state p {

  max-width: 400px;

  margin: 7px 0 0;

  color: #94a3b8;

  font-size: 12px;

  line-height: 1.6;

}


/* =========================================
   HISTORY LIST
========================================= */

.history-list {

  display: flex;

  flex-direction: column;

  gap: 12px;

}


.history-card {

  display: flex;

  align-items: flex-start;

  gap: 15px;

  background: white;

  border: 1px solid #e2e8f0;

  border-radius: 15px;

  padding: 18px;

  transition: all 0.2s ease;

}


.history-card:hover {

  border-color: #bfdbfe;

  box-shadow:
    0 8px 20px
    rgba(15, 23, 42, 0.05);

}


.history-icon {

  width: 45px;

  height: 45px;

  flex-shrink: 0;

  border-radius: 12px;

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

  margin: 4px 0 9px;

  color: #1e293b;

  font-size: 14px;

  font-weight: 800;

}


.history-details {

  display: flex;

  align-items: center;

  gap: 18px;

  color: #64748b;

  font-size: 11px;

}


.history-details span {

  display: flex;

  align-items: center;

  gap: 6px;

}


.history-details i {

  color: #94a3b8;

}


.status-badge {

  flex-shrink: 0;

  padding: 6px 10px;

  border-radius: 20px;

  font-size: 10px;

  font-weight: 800;

}


.status-badge.pending {

  background: #fffbeb;

  color: #d97706;

}


.status-badge.approved {

  background: #f0fdf4;

  color: #16a34a;

}


.status-badge.rejected {

  background: #fef2f2;

  color: #dc2626;

}


/* =========================================
   FOOTER
========================================= */

.footer {

  margin-top: auto;

  padding: 20px 0 5px;

  border-top: 1px solid #e2e8f0;

}


.footer p {

  margin: 0;

  color: #94a3b8;

  text-align: center;

  font-size: 11px;

}


/* =========================================
   RESPONSIVE
========================================= */

@media (max-width: 800px) {

  .pengguna-pengajuan {

    padding: 25px;

  }

  .form-row {

    grid-template-columns: 1fr;

    gap: 0;

  }

}


@media (max-width: 650px) {

  .pengguna-pengajuan {

    padding: 20px;

  }

  .page-header {

    align-items: flex-start;

  }

  .dashboard-btn {

    display: none;

  }

  .form-card {

    padding: 20px;

  }

  .form-actions {

    flex-direction: column-reverse;

  }

  .cancel-btn,
  .submit-btn {

    width: 100%;

    justify-content: center;

  }

  .history-top {

    align-items: flex-start;

    flex-direction: column;

  }

  .history-details {

    align-items: flex-start;

    flex-direction: column;

    gap: 7px;

  }

}

</style>
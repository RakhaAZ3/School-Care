<template>

  <div class="pengguna-ruangan">

    <!-- =========================
         HEADER
    ========================== -->
    <header class="page-header">

      <div class="header-left">

        <button
          class="back-btn"
          type="button"
          @click="goTo('/pengguna/dashboard')"
        >
          <i class="fa-solid fa-arrow-left"></i>
          <span>Kembali</span>
        </button>

        <div class="title-area">

          <span class="title-label">
            <i class="fa-solid fa-door-open"></i>
            SchoolCare
          </span>

          <h1>Daftar Ruangan</h1>

          <p>
            Lihat informasi ruangan yang tersedia di sekolah.
          </p>

        </div>

      </div>

      <button
        class="dashboard-btn"
        type="button"
        @click="goTo('/pengguna/dashboard')"
      >
        <i class="fa-solid fa-house"></i>
        Dashboard
      </button>

    </header>


    <!-- =========================
         FILTER
    ========================== -->
    <section class="filter-section">

      <div class="filter-card">

        <div class="search-wrapper">

          <i class="fa-solid fa-magnifying-glass"></i>

          <input
            v-model="keyword"
            type="text"
            placeholder="Cari nama ruangan..."
          />

        </div>

        <div class="filter-wrapper">

          <i class="fa-solid fa-layer-group"></i>

          <select v-model="selectedType">

            <option value="">
              Semua Jenis
            </option>

            <option
              v-for="type in roomTypes"
              :key="type"
              :value="type"
            >
              {{ type }}
            </option>

          </select>

        </div>

        <button
          v-if="keyword || selectedType"
          class="reset-btn"
          type="button"
          @click="resetFilter"
        >
          <i class="fa-solid fa-rotate-left"></i>
          Reset
        </button>

      </div>

    </section>


    <!-- =========================
         RESULT INFO
    ========================== -->
    <section class="result-section">

      <div>

        <h2>Ruangan Sekolah</h2>

        <p v-if="filteredRooms.length > 0">
          Menampilkan {{ filteredRooms.length }} ruangan
        </p>

        <p v-else>
          Belum ada data ruangan
        </p>

      </div>

    </section>


    <!-- =========================
         EMPTY STATE
    ========================== -->
    <section
      v-if="filteredRooms.length === 0"
      class="empty-state"
    >

      <div class="empty-icon">

        <i class="fa-solid fa-door-closed"></i>

      </div>

      <h3>
        {{
          keyword || selectedType
            ? 'Ruangan Tidak Ditemukan'
            : 'Belum Ada Data Ruangan'
        }}
      </h3>

      <p>
        {{
          keyword || selectedType
            ? 'Coba gunakan kata kunci atau jenis ruangan yang berbeda.'
            : 'Data ruangan akan muncul di halaman ini setelah tersedia.'
        }}
      </p>

      <button
        v-if="keyword || selectedType"
        class="empty-reset-btn"
        type="button"
        @click="resetFilter"
      >
        <i class="fa-solid fa-rotate-left"></i>
        Reset Filter
      </button>

    </section>


    <!-- =========================
         ROOM GRID
    ========================== -->
    <section
      v-else
      class="room-grid"
    >

      <article
        v-for="room in filteredRooms"
        :key="room.id"
        class="room-card"
      >

        <!-- Icon -->
        <div class="room-icon">

          <i class="fa-solid fa-door-open"></i>

        </div>


        <!-- Content -->
        <div class="room-content">

          <div class="room-top">

            <span class="room-type">
              {{ room.type }}
            </span>

            <span
              class="status-badge"
              :class="getStatusClass(room.status)"
            >
              {{ room.status }}
            </span>

          </div>

          <h3>{{ room.name }}</h3>

          <div class="room-info">

            <div class="info-item">

              <i class="fa-solid fa-location-dot"></i>

              <span>
                {{ room.location || 'Lokasi belum tersedia' }}
              </span>

            </div>

            <div class="info-item">

              <i class="fa-solid fa-users"></i>

              <span>
                Kapasitas:
                {{ room.capacity || '-' }} orang
              </span>

            </div>

          </div>

          <button
            class="detail-btn"
            type="button"
            @click="showRoomDetail(room)"
          >
            <span>Lihat Detail</span>
            <i class="fa-solid fa-arrow-right"></i>
          </button>

        </div>

      </article>

    </section>


    <!-- =========================
         DETAIL MODAL
    ========================== -->
    <div
      v-if="selectedRoom"
      class="modal-overlay"
      @click.self="closeRoomDetail"
    >

      <div class="modal-card">

        <button
          class="close-btn"
          type="button"
          @click="closeRoomDetail"
        >
          <i class="fa-solid fa-xmark"></i>
        </button>

        <div class="modal-icon">

          <i class="fa-solid fa-door-open"></i>

        </div>

        <span class="modal-type">
          {{ selectedRoom.type }}
        </span>

        <h2>
          {{ selectedRoom.name }}
        </h2>

        <div class="modal-info">

          <div class="modal-info-item">

            <div class="modal-info-icon">
              <i class="fa-solid fa-circle-info"></i>
            </div>

            <div>

              <span>Status</span>

              <strong>
                {{ selectedRoom.status }}
              </strong>

            </div>

          </div>


          <div class="modal-info-item">

            <div class="modal-info-icon">
              <i class="fa-solid fa-location-dot"></i>
            </div>

            <div>

              <span>Lokasi</span>

              <strong>
                {{ selectedRoom.location || '-' }}
              </strong>

            </div>

          </div>


          <div class="modal-info-item">

            <div class="modal-info-icon">
              <i class="fa-solid fa-users"></i>
            </div>

            <div>

              <span>Kapasitas</span>

              <strong>
                {{ selectedRoom.capacity || '-' }} orang
              </strong>

            </div>

          </div>


          <div class="modal-info-item">

            <div class="modal-info-icon">
              <i class="fa-solid fa-align-left"></i>
            </div>

            <div>

              <span>Keterangan</span>

              <strong>
                {{ selectedRoom.description || 'Belum ada keterangan.' }}
              </strong>

            </div>

          </div>

        </div>

        <button
          class="modal-close-btn"
          type="button"
          @click="closeRoomDetail"
        >
          Tutup
        </button>

      </div>

    </div>


    <!-- =========================
         FOOTER
    ========================== -->
    <footer class="page-footer">

      <div class="footer-content">

        <div class="footer-brand">

          <div class="footer-logo">

            <i class="fa-solid fa-school"></i>

          </div>

          <div>

            <strong>SchoolCare</strong>

            <span>
              Sistem Informasi Fasilitas Sekolah
            </span>

          </div>

        </div>

        <p>
          © {{ currentYear }} SchoolCare. Semua hak dilindungi.
        </p>

      </div>

    </footer>

  </div>

</template>


<script setup>

import { computed, ref } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()


// =========================
// STATE
// =========================

const keyword = ref('')

const selectedType = ref('')

const selectedRoom = ref(null)


// =========================
// DATA RUANGAN
// =========================

// Sengaja kosong karena backend belum dibuat.
// Nanti data ini bisa diganti dengan data dari API.

const rooms = ref([])


// =========================
// JENIS RUANGAN
// =========================

const roomTypes = computed(() => {

  const types = rooms.value
    .map(room => room.type)
    .filter(Boolean)

  return [...new Set(types)]

})


// =========================
// FILTER RUANGAN
// =========================

const filteredRooms = computed(() => {

  return rooms.value.filter(room => {

    const search = keyword.value
      .toLowerCase()
      .trim()

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


// =========================
// TAHUN
// =========================

const currentYear = new Date().getFullYear()


// =========================
// NAVIGASI
// =========================

const goTo = (path) => {

  router.push(path)

}


// =========================
// RESET FILTER
// =========================

const resetFilter = () => {

  keyword.value = ''

  selectedType.value = ''

}


// =========================
// DETAIL RUANGAN
// =========================

const showRoomDetail = (room) => {

  selectedRoom.value = room

}


const closeRoomDetail = () => {

  selectedRoom.value = null

}


// =========================
// STATUS CLASS
// =========================

const getStatusClass = (status) => {

  if (!status) return ''

  const value = status.toLowerCase()

  if (
    value.includes('tersedia') ||
    value.includes('baik') ||
    value.includes('aktif')
  ) {

    return 'status-available'

  }

  if (
    value.includes('dipakai') ||
    value.includes('digunakan')
  ) {

    return 'status-used'

  }

  if (
    value.includes('rusak') ||
    value.includes('maintenance')
  ) {

    return 'status-maintenance'

  }

  return ''

}

</script>


<style scoped>

/* =========================================
   GLOBAL
========================================= */

.pengguna-ruangan {

  min-height: 100vh;

  background: #f8fafc;

  color: #0f172a;

  font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;

}


/* =========================================
   HEADER
========================================= */

.page-header {

  display: flex;

  align-items: flex-start;

  justify-content: space-between;

  gap: 30px;

  padding: 35px 7%;

  background: #ffffff;

  border-bottom: 1px solid #e2e8f0;

}


.header-left {

  display: flex;

  align-items: flex-start;

  gap: 25px;

}


.back-btn {

  display: inline-flex;

  align-items: center;

  gap: 8px;

  padding: 11px 16px;

  border: 1px solid #e2e8f0;

  border-radius: 12px;

  background: #ffffff;

  color: #475569;

  font-size: 13px;

  font-weight: 700;

  cursor: pointer;

  transition: 0.2s ease;

}


.back-btn:hover {

  border-color: #2563eb;

  color: #2563eb;

  transform: translateY(-1px);

}


.title-area {

  display: flex;

  flex-direction: column;

}


.title-label {

  display: inline-flex;

  align-items: center;

  gap: 7px;

  width: fit-content;

  margin-bottom: 7px;

  color: #2563eb;

  font-size: 12px;

  font-weight: 800;

}


.title-area h1 {

  margin: 0;

  font-size: 30px;

  font-weight: 800;

  letter-spacing: -0.8px;

}


.title-area p {

  margin: 7px 0 0;

  color: #64748b;

  font-size: 14px;

}


.dashboard-btn {

  display: inline-flex;

  align-items: center;

  gap: 9px;

  padding: 12px 18px;

  border: none;

  border-radius: 12px;

  background: linear-gradient(135deg, #2563eb, #7c3aed);

  color: #ffffff;

  font-size: 13px;

  font-weight: 700;

  cursor: pointer;

  transition: 0.2s ease;

  box-shadow: 0 8px 20px rgba(37, 99, 235, 0.15);

}


.dashboard-btn:hover {

  transform: translateY(-2px);

  box-shadow: 0 12px 25px rgba(37, 99, 235, 0.2);

}


/* =========================================
   FILTER
========================================= */

.filter-section {

  padding: 28px 7% 0;

}


.filter-card {

  display: flex;

  align-items: center;

  gap: 14px;

  padding: 18px;

  border: 1px solid #e2e8f0;

  border-radius: 18px;

  background: #ffffff;

}


.search-wrapper,
.filter-wrapper {

  position: relative;

  display: flex;

  align-items: center;

}


.search-wrapper {

  flex: 1;

}


.search-wrapper i,
.filter-wrapper i {

  position: absolute;

  left: 15px;

  color: #94a3b8;

  font-size: 14px;

  pointer-events: none;

}


.search-wrapper input,
.filter-wrapper select {

  width: 100%;

  height: 45px;

  padding: 0 15px 0 42px;

  border: 1px solid #e2e8f0;

  border-radius: 11px;

  outline: none;

  background: #f8fafc;

  color: #334155;

  font-family: inherit;

  font-size: 13px;

  transition: 0.2s ease;

}


.filter-wrapper {

  width: 220px;

}


.filter-wrapper select {

  cursor: pointer;

  appearance: auto;

}


.search-wrapper input:focus,
.filter-wrapper select:focus {

  border-color: #2563eb;

  background: #ffffff;

  box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.08);

}


.reset-btn {

  display: inline-flex;

  align-items: center;

  gap: 7px;

  height: 45px;

  padding: 0 16px;

  border: 1px solid #e2e8f0;

  border-radius: 11px;

  background: #ffffff;

  color: #475569;

  font-family: inherit;

  font-size: 13px;

  font-weight: 700;

  cursor: pointer;

  transition: 0.2s ease;

}


.reset-btn:hover {

  border-color: #2563eb;

  color: #2563eb;

}


/* =========================================
   RESULT
========================================= */

.result-section {

  padding: 35px 7% 20px;

}


.result-section h2 {

  margin: 0;

  font-size: 20px;

  font-weight: 800;

}


.result-section p {

  margin: 6px 0 0;

  color: #64748b;

  font-size: 13px;

}


/* =========================================
   EMPTY STATE
========================================= */

.empty-state {

  display: flex;

  align-items: center;

  flex-direction: column;

  max-width: 600px;

  margin: 20px auto 80px;

  padding: 55px 30px;

  text-align: center;

}


.empty-icon {

  display: flex;

  align-items: center;

  justify-content: center;

  width: 80px;

  height: 80px;

  margin-bottom: 20px;

  border-radius: 22px;

  background: linear-gradient(
    135deg,
    rgba(37, 99, 235, 0.1),
    rgba(124, 58, 237, 0.1)
  );

  color: #2563eb;

  font-size: 28px;

}


.empty-state h3 {

  margin: 0;

  font-size: 20px;

  font-weight: 800;

}


.empty-state p {

  max-width: 450px;

  margin: 9px auto 0;

  color: #64748b;

  font-size: 13px;

  line-height: 1.7;

}


.empty-reset-btn {

  display: inline-flex;

  align-items: center;

  gap: 8px;

  margin-top: 22px;

  padding: 11px 17px;

  border: none;

  border-radius: 11px;

  background: #2563eb;

  color: #ffffff;

  font-family: inherit;

  font-size: 13px;

  font-weight: 700;

  cursor: pointer;

}


/* =========================================
   ROOM GRID
========================================= */

.room-grid {

  display: grid;

  grid-template-columns: repeat(2, minmax(0, 1fr));

  gap: 20px;

  padding: 0 7% 70px;

}


.room-card {

  display: flex;

  gap: 18px;

  padding: 22px;

  border: 1px solid #e2e8f0;

  border-radius: 18px;

  background: #ffffff;

  transition: 0.25s ease;

}


.room-card:hover {

  border-color: rgba(37, 99, 235, 0.25);

  transform: translateY(-3px);

  box-shadow: 0 15px 35px rgba(15, 23, 42, 0.07);

}


.room-icon {

  display: flex;

  align-items: center;

  justify-content: center;

  flex: 0 0 58px;

  width: 58px;

  height: 58px;

  border-radius: 16px;

  background: linear-gradient(
    135deg,
    rgba(37, 99, 235, 0.1),
    rgba(124, 58, 237, 0.1)
  );

  color: #2563eb;

  font-size: 22px;

}


.room-content {

  flex: 1;

  min-width: 0;

}


.room-top {

  display: flex;

  align-items: center;

  justify-content: space-between;

  gap: 10px;

}


.room-type {

  color: #7c3aed;

  font-size: 11px;

  font-weight: 800;

  text-transform: uppercase;

  letter-spacing: 0.5px;

}


.status-badge {

  padding: 5px 9px;

  border-radius: 20px;

  font-size: 10px;

  font-weight: 800;

}


.status-available {

  background: #dcfce7;

  color: #15803d;

}


.status-used {

  background: #fef3c7;

  color: #b45309;

}


.status-maintenance {

  background: #fee2e2;

  color: #dc2626;

}


.room-content h3 {

  margin: 8px 0 12px;

  font-size: 18px;

  font-weight: 800;

}


.room-info {

  display: flex;

  flex-direction: column;

  gap: 8px;

}


.info-item {

  display: flex;

  align-items: center;

  gap: 9px;

  color: #64748b;

  font-size: 12px;

}


.info-item i {

  width: 15px;

  color: #2563eb;

  text-align: center;

}


.detail-btn {

  display: flex;

  align-items: center;

  justify-content: space-between;

  width: 100%;

  margin-top: 18px;

  padding: 11px 13px;

  border: 1px solid #dbeafe;

  border-radius: 10px;

  background: #eff6ff;

  color: #2563eb;

  font-family: inherit;

  font-size: 12px;

  font-weight: 800;

  cursor: pointer;

  transition: 0.2s ease;

}


.detail-btn:hover {

  background: #2563eb;

  color: #ffffff;

}


/* =========================================
   MODAL
========================================= */

.modal-overlay {

  position: fixed;

  inset: 0;

  z-index: 1000;

  display: flex;

  align-items: center;

  justify-content: center;

  padding: 20px;

  background: rgba(15, 23, 42, 0.55);

  backdrop-filter: blur(5px);

}


.modal-card {

  position: relative;

  width: 100%;

  max-width: 500px;

  padding: 30px;

  border: 1px solid #e2e8f0;

  border-radius: 22px;

  background: #ffffff;

  box-shadow: 0 25px 70px rgba(15, 23, 42, 0.18);

}


.close-btn {

  position: absolute;

  top: 18px;

  right: 18px;

  display: flex;

  align-items: center;

  justify-content: center;

  width: 35px;

  height: 35px;

  border: 1px solid #e2e8f0;

  border-radius: 10px;

  background: #ffffff;

  color: #64748b;

  cursor: pointer;

  transition: 0.2s ease;

}


.close-btn:hover {

  color: #dc2626;

  border-color: #fecaca;

  background: #fef2f2;

}


.modal-icon {

  display: flex;

  align-items: center;

  justify-content: center;

  width: 65px;

  height: 65px;

  margin-bottom: 15px;

  border-radius: 18px;

  background: linear-gradient(135deg, #2563eb, #7c3aed);

  color: #ffffff;

  font-size: 24px;

}


.modal-type {

  color: #7c3aed;

  font-size: 11px;

  font-weight: 800;

  text-transform: uppercase;

}


.modal-card h2 {

  margin: 6px 0 22px;

  padding-right: 40px;

  font-size: 24px;

  font-weight: 800;

}


.modal-info {

  display: flex;

  flex-direction: column;

  gap: 15px;

}


.modal-info-item {

  display: flex;

  align-items: flex-start;

  gap: 12px;

}


.modal-info-icon {

  display: flex;

  align-items: center;

  justify-content: center;

  flex: 0 0 38px;

  width: 38px;

  height: 38px;

  border-radius: 10px;

  background: #eff6ff;

  color: #2563eb;

}


.modal-info-item > div:last-child {

  display: flex;

  flex-direction: column;

  gap: 3px;

}


.modal-info-item span {

  color: #94a3b8;

  font-size: 11px;

  font-weight: 700;

}


.modal-info-item strong {

  color: #334155;

  font-size: 13px;

  line-height: 1.5;

}


.modal-close-btn {

  width: 100%;

  margin-top: 25px;

  padding: 12px;

  border: none;

  border-radius: 11px;

  background: #f1f5f9;

  color: #475569;

  font-family: inherit;

  font-size: 13px;

  font-weight: 800;

  cursor: pointer;

  transition: 0.2s ease;

}


.modal-close-btn:hover {

  background: #e2e8f0;

}


/* =========================================
   FOOTER
========================================= */

.page-footer {

  border-top: 1px solid #e2e8f0;

  background: #ffffff;

}


.footer-content {

  display: flex;

  align-items: center;

  justify-content: space-between;

  gap: 20px;

  padding: 25px 7%;

}


.footer-brand {

  display: flex;

  align-items: center;

  gap: 11px;

}


.footer-logo {

  display: flex;

  align-items: center;

  justify-content: center;

  width: 38px;

  height: 38px;

  border-radius: 10px;

  background: linear-gradient(135deg, #2563eb, #7c3aed);

  color: #ffffff;

}


.footer-brand div:last-child {

  display: flex;

  flex-direction: column;

}


.footer-brand strong {

  font-size: 13px;

  font-weight: 800;

}


.footer-brand span {

  margin-top: 2px;

  color: #94a3b8;

  font-size: 10px;

}


.footer-content > p {

  margin: 0;

  color: #94a3b8;

  font-size: 11px;

}


/* =========================================
   RESPONSIVE
========================================= */

@media (max-width: 900px) {

  .page-header {

    padding: 28px 5%;

  }

  .filter-section,
  .result-section {

    padding-left: 5%;

    padding-right: 5%;

  }

  .room-grid {

    padding-left: 5%;

    padding-right: 5%;

  }

  .filter-card {

    flex-wrap: wrap;

  }

  .search-wrapper {

    flex: 1 1 100%;

  }

  .filter-wrapper {

    flex: 1;

  }

  .room-grid {

    grid-template-columns: 1fr;

  }

}


@media (max-width: 650px) {

  .page-header {

    flex-direction: column;

    gap: 20px;

  }

  .header-left {

    flex-direction: column;

    gap: 18px;

  }

  .title-area h1 {

    font-size: 25px;

  }

  .dashboard-btn {

    width: 100%;

    justify-content: center;

  }

  .filter-card {

    flex-direction: column;

    align-items: stretch;

  }

  .search-wrapper,
  .filter-wrapper {

    width: 100%;

    flex: none;

  }

  .reset-btn {

    justify-content: center;

  }

  .room-card {

    flex-direction: column;

  }

  .room-icon {

    flex: none;

  }

  .room-top {

    align-items: flex-start;

    flex-direction: column;

  }

  .footer-content {

    align-items: flex-start;

    flex-direction: column;

  }

  .modal-card {

    padding: 25px 20px;

  }

}

</style>
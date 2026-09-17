<template>

  <div class="pengguna-fasilitas">

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

          <h1>Fasilitas Sekolah</h1>

          <p>
            Lihat fasilitas yang tersedia di sekolah.
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
         SEARCH & FILTER
    ========================== -->
    <section class="filter-card">

      <div class="search-box">

        <i class="fa-solid fa-magnifying-glass"></i>

        <input
          v-model="search"
          type="text"
          placeholder="Cari fasilitas..."
        />

      </div>

      <div class="filter-box">

        <i class="fa-solid fa-layer-group"></i>

        <select v-model="selectedCategory">

          <option value="">
            Semua Kategori
          </option>

          <option
            v-for="category in categories"
            :key="category"
            :value="category"
          >
            {{ category }}
          </option>

        </select>

      </div>

    </section>

    <!-- =========================
         INFO
    ========================== -->
    <div class="result-info">

      <div>

        <h2>Daftar Fasilitas</h2>

        <p>
          {{ filteredFacilities.length }} fasilitas tersedia
        </p>

      </div>

    </div>

    <!-- =========================
         EMPTY STATE
    ========================== -->
    <section
      v-if="filteredFacilities.length === 0"
      class="empty-state"
    >

      <div class="empty-icon">

        <i class="fa-solid fa-box-open"></i>

      </div>

      <h3>

        {{
          search || selectedCategory
            ? 'Fasilitas tidak ditemukan'
            : 'Belum ada data fasilitas'
        }}

      </h3>

      <p>

        {{
          search || selectedCategory
            ? 'Coba gunakan kata kunci atau kategori lain.'
            : 'Data fasilitas akan tampil setelah terhubung dengan sistem.'
        }}

      </p>

      <button
        v-if="search || selectedCategory"
        type="button"
        class="reset-btn"
        @click="resetFilter"
      >

        <i class="fa-solid fa-rotate-left"></i>

        Reset Filter

      </button>

    </section>

    <!-- =========================
         FACILITY GRID
    ========================== -->
    <section
      v-else
      class="facility-grid"
    >

      <article
        v-for="facility in filteredFacilities"
        :key="facility.id"
        class="facility-card"
      >

        <div class="facility-top">

          <div class="facility-icon">

            <i :class="facility.icon"></i>

          </div>

          <span
            class="condition-badge"
            :class="getConditionClass(facility.kondisi)"
          >

            <span class="status-dot"></span>

            {{ facility.kondisi }}

          </span>

        </div>

        <div class="facility-content">

          <span class="category">
            {{ facility.kategori }}
          </span>

          <h3>
            {{ facility.nama }}
          </h3>

          <div class="facility-details">

            <div class="detail-item">

              <i class="fa-solid fa-boxes-stacked"></i>

              <span>
                Jumlah:
                <strong>
                  {{ facility.jumlah }} unit
                </strong>
              </span>

            </div>

            <div class="detail-item">

              <i class="fa-solid fa-location-dot"></i>

              <span>
                {{ facility.ruangan }}
              </span>

            </div>

          </div>

        </div>

        <div class="facility-footer">

          <button
            type="button"
            class="borrow-btn"
            @click="ajukanPeminjaman(facility)"
          >

            <i class="fa-solid fa-file-circle-plus"></i>

            Ajukan Peminjaman

          </button>

        </div>

      </article>

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

import { computed, ref } from 'vue'
import { useRouter } from 'vue-router'

// ==========================================
// ROUTER
// ==========================================
const router = useRouter()

// ==========================================
// STATE
// ==========================================
const search = ref('')

const selectedCategory = ref('')

const currentYear = new Date().getFullYear()

// ==========================================
// DATA FASILITAS
// ==========================================
// Sengaja kosong karena backend belum dibuat.
// Nanti akan diganti dengan data dari API.
const facilities = ref([])

// ==========================================
// KATEGORI
// ==========================================
const categories = computed(() => {

  const categoryList = facilities.value
    .map(facility => facility.kategori)
    .filter(Boolean)

  return [...new Set(categoryList)]

})

// ==========================================
// FILTER FASILITAS
// ==========================================
const filteredFacilities = computed(() => {

  return facilities.value.filter(facility => {

    const keyword = search.value
      .toLowerCase()
      .trim()

    const nama = facility.nama
      ? facility.nama.toLowerCase()
      : ''

    const kategori = facility.kategori
      ? facility.kategori.toLowerCase()
      : ''

    const ruangan = facility.ruangan
      ? facility.ruangan.toLowerCase()
      : ''

    const matchesSearch =
      !keyword ||
      nama.includes(keyword) ||
      kategori.includes(keyword) ||
      ruangan.includes(keyword)

    const matchesCategory =
      !selectedCategory.value ||
      facility.kategori === selectedCategory.value

    return matchesSearch && matchesCategory

  })

})

// ==========================================
// NAVIGATION
// ==========================================
const goTo = (path) => {

  router.push(path)

}

// ==========================================
// RESET FILTER
// ==========================================
const resetFilter = () => {

  search.value = ''

  selectedCategory.value = ''

}

// ==========================================
// CONDITION CLASS
// ==========================================
const getConditionClass = (condition) => {

  if (condition === 'Baik') {
    return 'good'
  }

  if (condition === 'Perlu Perhatian') {
    return 'warning'
  }

  if (condition === 'Rusak') {
    return 'broken'
  }

  return ''

}

// ==========================================
// AJUKAN PEMINJAMAN
// ==========================================
const ajukanPeminjaman = (facility) => {

  console.log(
    'Fasilitas yang dipilih:',
    facility
  )

  // Nanti diarahkan ke halaman pengajuan
  // setelah backend dibuat.
  router.push('/pengguna/pengajuan')

}

</script>

<style scoped>

/* =========================================
   FONT AWESOME
========================================= */
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css');

/* =========================================
   GLOBAL
========================================= */

* {
  box-sizing: border-box;
}

.pengguna-fasilitas {

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

/* =========================
   HEADER
========================= */

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

.dashboard-btn i {

  font-size: 12px;

}

/* =========================
   FILTER
========================= */

.filter-card {

  background: white;

  border: 1px solid #e2e8f0;

  border-radius: 16px;

  padding: 15px;

  display: flex;

  gap: 12px;

  margin-bottom: 28px;

}

.search-box,
.filter-box {

  height: 44px;

  border: 1px solid #e2e8f0;

  background: #f8fafc;

  border-radius: 10px;

  display: flex;

  align-items: center;

  gap: 10px;

  padding: 0 13px;

}

.search-box {

  flex: 1;

}

.filter-box {

  width: 210px;

}

.search-box i,
.filter-box i {

  color: #94a3b8;

  font-size: 13px;

  flex-shrink: 0;

}

.search-box input,
.filter-box select {

  width: 100%;

  border: none;

  outline: none;

  background: transparent;

  color: #334155;

  font-size: 12px;

  font-family: inherit;

}

.search-box input::placeholder {

  color: #94a3b8;

}

.filter-box select {

  cursor: pointer;

}

/* =========================
   RESULT INFO
========================= */

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

/* =========================
   FACILITY GRID
========================= */

.facility-grid {

  display: grid;

  grid-template-columns:
    repeat(3, minmax(0, 1fr));

  gap: 18px;

}

.facility-card {

  background: white;

  border: 1px solid #e2e8f0;

  border-radius: 17px;

  padding: 18px;

  display: flex;

  flex-direction: column;

  min-height: 255px;

  transition: all 0.2s ease;

}

.facility-card:hover {

  border-color: #bfdbfe;

  transform: translateY(-3px);

  box-shadow:
    0 12px 28px
    rgba(15, 23, 42, 0.07);

}

.facility-top {

  display: flex;

  align-items: center;

  justify-content: space-between;

  gap: 10px;

}

.facility-icon {

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

}

.condition-badge {

  padding: 6px 9px;

  border-radius: 20px;

  font-size: 10px;

  font-weight: 700;

  display: flex;

  align-items: center;

  gap: 5px;

}

.status-dot {

  width: 6px;

  height: 6px;

  border-radius: 50%;

  display: inline-block;

}

.condition-badge.good {

  background: #f0fdf4;

  color: #16a34a;

}

.condition-badge.good .status-dot {

  background: #22c55e;

}

.condition-badge.warning {

  background: #fffbeb;

  color: #d97706;

}

.condition-badge.warning .status-dot {

  background: #f59e0b;

}

.condition-badge.broken {

  background: #fef2f2;

  color: #dc2626;

}

.condition-badge.broken .status-dot {

  background: #ef4444;

}

/* =========================
   FACILITY CONTENT
========================= */

.facility-content {

  flex: 1;

  padding-top: 17px;

}

.category {

  color: #2563eb;

  font-size: 10px;

  font-weight: 800;

  text-transform: uppercase;

  letter-spacing: 0.5px;

}

.facility-content h3 {

  margin: 5px 0 15px;

  color: #1e293b;

  font-size: 16px;

  font-weight: 800;

}

.facility-details {

  display: flex;

  flex-direction: column;

  gap: 8px;

}

.detail-item {

  display: flex;

  align-items: center;

  gap: 8px;

  color: #64748b;

  font-size: 11px;

}

.detail-item i {

  width: 15px;

  color: #94a3b8;

  text-align: center;

}

.detail-item strong {

  color: #334155;

}

/* =========================
   FOOTER CARD
========================= */

.facility-footer {

  margin-top: 17px;

  padding-top: 14px;

  border-top: 1px solid #f1f5f9;

}

.borrow-btn {

  width: 100%;

  border: none;

  background: #eff6ff;

  color: #2563eb;

  border-radius: 9px;

  padding: 10px;

  font-size: 11px;

  font-weight: 750;

  cursor: pointer;

  display: flex;

  align-items: center;

  justify-content: center;

  gap: 7px;

  transition: all 0.2s ease;

}

.borrow-btn:hover {

  background: #2563eb;

  color: white;

}

/* =========================
   EMPTY STATE
========================= */

.empty-state {

  background: white;

  border: 1px dashed #cbd5e1;

  border-radius: 18px;

  min-height: 300px;

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

  margin: 7px 0 18px;

  color: #94a3b8;

  font-size: 12px;

  line-height: 1.6;

}

.reset-btn {

  border: none;

  background: #2563eb;

  color: white;

  padding: 10px 15px;

  border-radius: 9px;

  font-size: 11px;

  font-weight: 700;

  cursor: pointer;

  display: inline-flex;

  align-items: center;

  gap: 7px;

}

/* =========================
   FOOTER
========================= */

.footer {

  margin-top: 35px;

  padding: 20px 0 5px;

  border-top: 1px solid #e2e8f0;

}

.footer p {

  margin: 0;

  color: #94a3b8;

  text-align: center;

  font-size: 11px;

}

/* =========================
   RESPONSIVE
========================= */

@media (max-width: 1000px) {

  .facility-grid {

    grid-template-columns:
      repeat(2, minmax(0, 1fr));

  }

}

@media (max-width: 700px) {

  .pengguna-fasilitas {

    padding: 20px;

  }

  .page-header {

    align-items: flex-start;

  }

  .dashboard-btn {

    display: none;

  }

  .filter-card {

    flex-direction: column;

  }

  .filter-box {

    width: 100%;

  }

  .facility-grid {

    grid-template-columns: 1fr;

  }

}

</style>
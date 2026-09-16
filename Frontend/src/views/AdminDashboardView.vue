<template>
  <div class="admin-layout">

    <!-- ================= SIDEBAR ================= -->
    <aside class="sidebar" :class="{ collapsed: isCollapsed }">

      <!-- Logo -->
      <div class="sidebar-brand">
        <div class="brand-logo">
          <i class="fas fa-school"></i>
        </div>

        <div class="brand-text" v-if="!isCollapsed">
          <h2>SARPRAS</h2>
          <span>Admin Panel</span>
        </div>

        <button
          class="collapse-btn"
          @click="isCollapsed = !isCollapsed"
          :title="isCollapsed ? 'Buka sidebar' : 'Tutup sidebar'"
        >
          <i :class="isCollapsed ? 'fas fa-chevron-right' : 'fas fa-chevron-left'"></i>
        </button>
      </div>

      <!-- User -->
      <div class="sidebar-user" v-if="!isCollapsed">
        <div class="user-avatar">
          A
        </div>

        <div class="user-detail">
          <strong>Admin Sekolah</strong>
          <span>Administrator</span>
        </div>

        <span class="online-dot"></span>
      </div>

      <!-- Navigation -->
      <nav class="sidebar-nav">

        <div class="nav-section" v-if="!isCollapsed">
          MENU UTAMA
        </div>

        <a
          href="#"
          :class="{ active: currentTab === 'dashboard' }"
          @click.prevent="currentTab = 'dashboard'"
          title="Dashboard"
        >
          <i class="fas fa-chart-pie"></i>
          <span v-if="!isCollapsed">Dashboard</span>
        </a>

        <div class="nav-section" v-if="!isCollapsed">
          DATA SARANA
        </div>

        <a
          href="#"
          :class="{ active: currentTab === 'ruangan' }"
          @click.prevent="currentTab = 'ruangan'"
          title="Ruangan"
        >
          <i class="fas fa-door-open"></i>
          <span v-if="!isCollapsed">Ruangan</span>
        </a>

        <a
          href="#"
          :class="{ active: currentTab === 'fasilitas' }"
          @click.prevent="currentTab = 'fasilitas'"
          title="Fasilitas"
        >
          <i class="fas fa-box-open"></i>
          <span v-if="!isCollapsed">Fasilitas</span>
        </a>

        <a
          href="#"
          :class="{ active: currentTab === 'kategori' }"
          @click.prevent="currentTab = 'kategori'"
          title="Kategori"
        >
          <i class="fas fa-layer-group"></i>
          <span v-if="!isCollapsed">Kategori</span>
        </a>

        <div class="nav-section" v-if="!isCollapsed">
          PENGELOLAAN
        </div>

        <a
          href="#"
          :class="{ active: currentTab === 'pengajuan' }"
          @click.prevent="currentTab = 'pengajuan'"
          title="Pengajuan"
        >
          <i class="fas fa-clipboard-check"></i>
          <span v-if="!isCollapsed">Pengajuan</span>

          <span
            class="nav-badge"
            v-if="!isCollapsed && pendingCount > 0"
          >
            {{ pendingCount }}
          </span>
        </a>

        <a
          href="#"
          :class="{ active: currentTab === 'laporan' }"
          @click.prevent="currentTab = 'laporan'"
          title="Laporan"
        >
          <i class="fas fa-file-circle-exclamation"></i>
          <span v-if="!isCollapsed">Laporan Kerusakan</span>
        </a>

        <a
          href="#"
          :class="{ active: currentTab === 'maintenance' }"
          @click.prevent="currentTab = 'maintenance'"
          title="Maintenance"
        >
          <i class="fas fa-screwdriver-wrench"></i>
          <span v-if="!isCollapsed">Maintenance</span>
        </a>

      </nav>

      <!-- Sidebar Footer -->
      <div class="sidebar-footer">

        <button class="logout-btn" @click="handleLogout">
          <i class="fas fa-right-from-bracket"></i>
          <span v-if="!isCollapsed">Keluar</span>
        </button>

      </div>

    </aside>


    <!-- ================= MAIN ================= -->
    <main class="main-content">

      <!-- TOPBAR -->
      <header class="topbar">

        <div class="topbar-left">
          <div class="page-heading">
            <span class="welcome-label">Sistem Informasi Sarpras</span>
            <h1>{{ getPageTitle }}</h1>
          </div>
        </div>

        <div class="topbar-right">

          <!-- Notification -->
          <button class="icon-button notification-btn">
            <i class="fas fa-bell"></i>
            <span class="notification-dot"></span>
          </button>

          <!-- Profile -->
          <div class="profile">
            <div class="profile-avatar">
              A
            </div>

            <div class="profile-info">
              <strong>Admin Sekolah</strong>
              <span>Administrator</span>
            </div>

            <i class="fas fa-chevron-down profile-arrow"></i>
          </div>

        </div>

      </header>


      <!-- ================= CONTENT ================= -->
      <section class="content-body">

        <!-- ================================================= -->
        <!-- DASHBOARD -->
        <!-- ================================================= -->
        <div v-if="currentTab === 'dashboard'" class="fade-in">

          <!-- Welcome -->
          <div class="welcome-card">

            <div class="welcome-content">
              <span class="welcome-small">SELAMAT DATANG 👋</span>

              <h2>
                Kelola Sarana & Prasarana
                <br>
                Sekolah dengan lebih mudah.
              </h2>

              <p>
                Pantau kondisi fasilitas, ruangan, pengajuan,
                dan maintenance dalam satu dashboard.
              </p>

              <button
                class="primary-btn"
                @click="currentTab = 'fasilitas'"
              >
                <i class="fas fa-box-open"></i>
                Lihat Data Fasilitas
              </button>
            </div>

            <div class="welcome-decoration">
              <i class="fas fa-building-columns"></i>
            </div>

          </div>


          <!-- STATISTICS -->
          <div class="section-title">
            <div>
              <span>OVERVIEW</span>
              <h2>Ringkasan Data</h2>
            </div>

            <button class="outline-btn" @click="currentTab = 'fasilitas'">
              Lihat Semua
              <i class="fas fa-arrow-right"></i>
            </button>
          </div>


          <div class="stats-grid">

            <!-- Total Ruangan -->
            <div class="stat-card blue">

              <div class="stat-icon">
                <i class="fas fa-door-open"></i>
              </div>

              <div class="stat-content">
                <span>Total Ruangan</span>
                <h3>{{ roomsList.length }}</h3>
                <small>
                  <i class="fas fa-arrow-up"></i>
                  Ruangan terdaftar
                </small>
              </div>

            </div>


            <!-- Total Fasilitas -->
            <div class="stat-card purple">

              <div class="stat-icon">
                <i class="fas fa-boxes-stacked"></i>
              </div>

              <div class="stat-content">
                <span>Total Fasilitas</span>
                <h3>{{ totalFacilities }}</h3>
                <small>
                  <i class="fas fa-chart-line"></i>
                  Semua inventaris
                </small>
              </div>

            </div>


            <!-- Pengajuan -->
            <div class="stat-card orange">

              <div class="stat-icon">
                <i class="fas fa-file-circle-check"></i>
              </div>

              <div class="stat-content">
                <span>Pengajuan Pending</span>
                <h3>{{ pendingCount }}</h3>
                <small>
                  <i class="fas fa-clock"></i>
                  Perlu diproses
                </small>
              </div>

            </div>


            <!-- Maintenance -->
            <div class="stat-card green">

              <div class="stat-icon">
                <i class="fas fa-screwdriver-wrench"></i>
              </div>

              <div class="stat-content">
                <span>Maintenance</span>
                <h3>{{ maintenanceList.length }}</h3>
                <small>
                  <i class="fas fa-wrench"></i>
                  Sedang ditangani
                </small>
              </div>

            </div>

          </div>


          <!-- ANALYTICS -->
          <div class="dashboard-grid">

            <!-- Chart -->
            <div class="dashboard-card chart-card">

              <div class="card-header">

                <div>
                  <span class="card-label">STATISTIK</span>
                  <h3>Data Fasilitas</h3>
                </div>

                <select class="period-select">
                  <option>6 Bulan</option>
                  <option>1 Tahun</option>
                </select>

              </div>

              <div class="chart-container">

                <div
                  v-for="item in chartData"
                  :key="item.label"
                  class="chart-column"
                >

                  <span class="chart-value">
                    {{ item.value }}
                  </span>

                  <div class="bar-wrapper">

                    <div
                      class="chart-bar"
                      :style="{ height: item.value + '%' }"
                    ></div>

                  </div>

                  <span class="chart-label">
                    {{ item.label }}
                  </span>

                </div>

              </div>

            </div>


            <!-- Quick Action -->
            <div class="dashboard-card quick-card">

              <div class="card-header">
                <div>
                  <span class="card-label">AKSI CEPAT</span>
                  <h3>Kelola Data</h3>
                </div>
              </div>

              <div class="quick-actions">

                <button
                  class="quick-action"
                  @click="openModal('fasilitas')"
                >
                  <div class="quick-icon blue-icon">
                    <i class="fas fa-plus"></i>
                  </div>

                  <div>
                    <strong>Tambah Fasilitas</strong>
                    <span>Tambahkan inventaris baru</span>
                  </div>

                  <i class="fas fa-chevron-right"></i>
                </button>


                <button
                  class="quick-action"
                  @click="currentTab = 'pengajuan'"
                >
                  <div class="quick-icon orange-icon">
                    <i class="fas fa-clipboard-list"></i>
                  </div>

                  <div>
                    <strong>Periksa Pengajuan</strong>
                    <span>{{ pendingCount }} pengajuan pending</span>
                  </div>

                  <i class="fas fa-chevron-right"></i>
                </button>


                <button
                  class="quick-action"
                  @click="currentTab = 'laporan'"
                >
                  <div class="quick-icon red-icon">
                    <i class="fas fa-triangle-exclamation"></i>
                  </div>

                  <div>
                    <strong>Laporan Kerusakan</strong>
                    <span>{{ laporanList.length }} laporan masuk</span>
                  </div>

                  <i class="fas fa-chevron-right"></i>
                </button>

              </div>

            </div>

          </div>


          <!-- BOTTOM GRID -->
          <div class="bottom-grid">

            <!-- Recent Pengajuan -->
            <div class="dashboard-card">

              <div class="card-header">

                <div>
                  <span class="card-label">TERBARU</span>
                  <h3>Pengajuan Terakhir</h3>
                </div>

                <button
                  class="view-all"
                  @click="currentTab = 'pengajuan'"
                >
                  Lihat semua
                </button>

              </div>

              <div class="table-wrapper">

                <table>

                  <thead>
                    <tr>
                      <th>Pemohon</th>
                      <th>Pengajuan</th>
                      <th>Status</th>
                    </tr>
                  </thead>

                  <tbody>

                    <tr
                      v-for="item in pengajuanList"
                      :key="item.id"
                    >

                      <td>
                        <div class="person-cell">
                          <div class="mini-avatar">
                            {{ item.requester.charAt(0) }}
                          </div>

                          <div>
                            <strong>{{ item.requester }}</strong>
                            <span>{{ item.role }}</span>
                          </div>
                        </div>
                      </td>

                      <td>
                        <span class="item-name">
                          {{ item.item }}
                        </span>
                        <small>{{ item.date }}</small>
                      </td>

                      <td>
                        <span
                          class="status-badge"
                          :class="getStatusClass(item.status)"
                        >
                          {{ item.status }}
                        </span>
                      </td>

                    </tr>

                  </tbody>

                </table>

              </div>

            </div>


            <!-- Kondisi Fasilitas -->
            <div class="dashboard-card condition-card">

              <div class="card-header">

                <div>
                  <span class="card-label">KONDISI</span>
                  <h3>Kondisi Fasilitas</h3>
                </div>

              </div>

              <div class="condition-content">

                <div class="condition-circle">
                  <strong>{{ goodPercentage }}%</strong>
                  <span>Baik</span>
                </div>

                <div class="condition-list">

                  <div class="condition-item">
                    <span>
                      <i class="condition-dot good"></i>
                      Kondisi Baik
                    </span>
                    <strong>{{ totalGood }}</strong>
                  </div>

                  <div class="condition-item">
                    <span>
                      <i class="condition-dot broken"></i>
                      Rusak
                    </span>
                    <strong>{{ totalBroken }}</strong>
                  </div>

                  <div class="condition-item">
                    <span>
                      <i class="condition-dot total"></i>
                      Total
                    </span>
                    <strong>{{ totalFacilities }}</strong>
                  </div>

                </div>

              </div>

            </div>

          </div>

        </div>


        <!-- ================================================= -->
        <!-- RUANGAN -->
        <!-- ================================================= -->
        <div v-else-if="currentTab === 'ruangan'" class="fade-in">

          <div class="page-card">

            <div class="page-card-header">

              <div>
                <span class="card-label">DATA SARANA</span>
                <h2>Manajemen Ruangan</h2>
                <p>Kelola seluruh ruangan yang tersedia di sekolah.</p>
              </div>

              <button
                class="primary-btn"
                @click="openModal('ruangan')"
              >
                <i class="fas fa-plus"></i>
                Tambah Ruangan
              </button>

            </div>

            <div class="table-wrapper">

              <table>

                <thead>
                  <tr>
                    <th>Kode</th>
                    <th>Nama Ruangan</th>
                    <th>Kapasitas</th>
                    <th>Lokasi</th>
                    <th>Status</th>
                    <th>Aksi</th>
                  </tr>
                </thead>

                <tbody>

                  <tr
                    v-for="item in roomsList"
                    :key="item.id"
                  >

                    <td>
                      <strong>{{ item.code }}</strong>
                    </td>

                    <td>{{ item.name }}</td>

                    <td>
                      {{ item.capacity }} orang
                    </td>

                    <td>{{ item.location }}</td>

                    <td>
                      <span
                        class="status-badge"
                        :class="item.status === 'Tersedia' ? 'success' : 'warning'"
                      >
                        {{ item.status }}
                      </span>
                    </td>

                    <td>
                      <div class="action-buttons">
                        <button
                          class="table-action edit"
                          title="Edit"
                        >
                          <i class="fas fa-pen"></i>
                        </button>

                        <button
                          class="table-action delete"
                          title="Hapus"
                          @click="deleteItem('ruangan', item.id)"
                        >
                          <i class="fas fa-trash"></i>
                        </button>
                      </div>
                    </td>

                  </tr>

                </tbody>

              </table>

            </div>

          </div>

        </div>


        <!-- ================================================= -->
        <!-- FASILITAS -->
        <!-- ================================================= -->
        <div v-else-if="currentTab === 'fasilitas'" class="fade-in">

          <div class="page-card">

            <div class="page-card-header">

              <div>
                <span class="card-label">INVENTARIS</span>
                <h2>Fasilitas & Barang</h2>
                <p>Kelola data seluruh fasilitas sekolah.</p>
              </div>

              <button
                class="primary-btn"
                @click="openModal('fasilitas')"
              >
                <i class="fas fa-plus"></i>
                Tambah Fasilitas
              </button>

            </div>

            <div class="table-wrapper">

              <table>

                <thead>
                  <tr>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Total</th>
                    <th>Baik</th>
                    <th>Rusak</th>
                    <th>Aksi</th>
                  </tr>
                </thead>

                <tbody>

                  <tr
                    v-for="item in facilitiesList"
                    :key="item.id"
                  >

                    <td>
                      <strong>{{ item.name }}</strong>
                    </td>

                    <td>
                      <span class="category-tag">
                        {{ item.category }}
                      </span>
                    </td>

                    <td>{{ item.total }}</td>

                    <td>
                      <span class="number-good">
                        {{ item.good }}
                      </span>
                    </td>

                    <td>
                      <span class="number-broken">
                        {{ item.broken }}
                      </span>
                    </td>

                    <td>
                      <div class="action-buttons">

                        <button class="table-action edit">
                          <i class="fas fa-pen"></i>
                        </button>

                        <button
                          class="table-action delete"
                          @click="deleteItem('fasilitas', item.id)"
                        >
                          <i class="fas fa-trash"></i>
                        </button>

                      </div>
                    </td>

                  </tr>

                </tbody>

              </table>

            </div>

          </div>

        </div>


        <!-- ================================================= -->
        <!-- KATEGORI -->
        <!-- ================================================= -->
        <div v-else-if="currentTab === 'kategori'" class="fade-in">

          <div class="page-card">

            <div class="page-card-header">

              <div>
                <span class="card-label">KATEGORI</span>
                <h2>Kategori Inventaris</h2>
                <p>Atur kategori fasilitas dan ruangan.</p>
              </div>

              <button
                class="primary-btn"
                @click="openModal('kategori')"
              >
                <i class="fas fa-plus"></i>
                Tambah Kategori
              </button>

            </div>

            <div class="category-grid">

              <div
                v-for="item in categoriesList"
                :key="item.id"
                class="category-card"
              >

                <div class="category-icon">
                  <i class="fas fa-layer-group"></i>
                </div>

                <div class="category-info">
                  <span>{{ item.type }}</span>
                  <h3>{{ item.name }}</h3>
                  <p>{{ item.count }} item terdaftar</p>
                </div>

                <button
                  class="delete-category"
                  @click="deleteItem('kategori', item.id)"
                >
                  <i class="fas fa-trash"></i>
                </button>

              </div>

            </div>

          </div>

        </div>


        <!-- ================================================= -->
        <!-- PENGAJUAN -->
        <!-- ================================================= -->
        <div v-else-if="currentTab === 'pengajuan'" class="fade-in">

          <div class="page-card">

            <div class="page-card-header">

              <div>
                <span class="card-label">PERSETUJUAN</span>
                <h2>Pengajuan</h2>
                <p>Periksa dan proses pengajuan dari pengguna.</p>
              </div>

            </div>

            <div class="table-wrapper">

              <table>

                <thead>
                  <tr>
                    <th>Pemohon</th>
                    <th>Pengajuan</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Aksi</th>
                  </tr>
                </thead>

                <tbody>

                  <tr
                    v-for="item in pengajuanList"
                    :key="item.id"
                  >

                    <td>
                      <div class="person-cell">

                        <div class="mini-avatar">
                          {{ item.requester.charAt(0) }}
                        </div>

                        <div>
                          <strong>{{ item.requester }}</strong>
                          <span>{{ item.role }}</span>
                        </div>

                      </div>
                    </td>

                    <td>{{ item.item }}</td>

                    <td>{{ item.date }}</td>

                    <td>
                      <span
                        class="status-badge"
                        :class="getStatusClass(item.status)"
                      >
                        {{ item.status }}
                      </span>
                    </td>

                    <td>

                      <div
                        v-if="item.status === 'Pending'"
                        class="action-buttons"
                      >

                        <button
                          class="approve-btn"
                          @click="approvePengajuan(item)"
                        >
                          <i class="fas fa-check"></i>
                          Setujui
                        </button>

                        <button
                          class="reject-btn"
                          @click="rejectPengajuan(item)"
                        >
                          <i class="fas fa-xmark"></i>
                        </button>

                      </div>

                      <span v-else class="completed-text">
                        Selesai diproses
                      </span>

                    </td>

                  </tr>

                </tbody>

              </table>

            </div>

          </div>

        </div>


        <!-- ================================================= -->
        <!-- LAPORAN -->
        <!-- ================================================= -->
        <div v-else-if="currentTab === 'laporan'" class="fade-in">

          <div class="page-card">

            <div class="page-card-header">

              <div>
                <span class="card-label">KERUSAKAN</span>
                <h2>Laporan Kerusakan</h2>
                <p>Monitor laporan kerusakan fasilitas sekolah.</p>
              </div>

              <div class="export-buttons">

                <button class="export-btn excel" @click="exportExcel">
                  <i class="fas fa-file-excel"></i>
                  Excel
                </button>

                <button class="export-btn pdf" @click="exportPDF">
                  <i class="fas fa-file-pdf"></i>
                  PDF
                </button>

              </div>

            </div>

            <div class="report-grid">

              <div
                v-for="item in laporanList"
                :key="item.id"
                class="report-card"
              >

                <div class="report-top">

                  <div class="report-icon">
                    <i class="fas fa-triangle-exclamation"></i>
                  </div>

                  <span
                    class="status-badge"
                    :class="item.status === 'Selesai' ? 'success' : 'warning'"
                  >
                    {{ item.status }}
                  </span>

                </div>

                <h3>{{ item.item }}</h3>

                <p>{{ item.desc }}</p>

                <div class="report-footer">
                  <span>
                    <i class="fas fa-user"></i>
                    {{ item.reporter }}
                  </span>
                </div>

              </div>

            </div>

          </div>

        </div>


        <!-- ================================================= -->
        <!-- MAINTENANCE -->
        <!-- ================================================= -->
        <div v-else-if="currentTab === 'maintenance'" class="fade-in">

          <div class="page-card">

            <div class="page-card-header">

              <div>
                <span class="card-label">PERBAIKAN</span>
                <h2>Maintenance & Perbaikan</h2>
                <p>Monitor fasilitas yang sedang diperbaiki.</p>
              </div>

            </div>

            <div class="maintenance-grid">

              <div
                v-for="item in maintenanceList"
                :key="item.id"
                class="maintenance-card"
              >

                <div class="maintenance-icon">
                  <i class="fas fa-screwdriver-wrench"></i>
                </div>

                <div class="maintenance-content">

                  <span class="maintenance-label">
                    SEDANG DIPERBAIKI
                  </span>

                  <h3>{{ item.unit }}</h3>

                  <div class="maintenance-info">
                    <span>
                      <i class="fas fa-user-gear"></i>
                      {{ item.technician }}
                    </span>

                    <span>
                      <i class="fas fa-calendar"></i>
                      {{ item.estimate }}
                    </span>
                  </div>

                  <div class="progress-area">

                    <div class="progress-header">
                      <span>Progress</span>
                      <strong>{{ item.progress }}</strong>
                    </div>

                    <div class="progress-bar">
                      <div class="progress-fill"></div>
                    </div>

                  </div>

                </div>

              </div>

            </div>

          </div>

        </div>

      </section>

    </main>


    <!-- ================= MODAL ================= -->
    <div
      v-if="showModal"
      class="modal-overlay"
      @click.self="showModal = false"
    >

      <div class="modal">

        <div class="modal-header">

          <div>
            <span class="card-label">DATA BARU</span>
            <h2>Tambah Data</h2>
          </div>

          <button
            class="modal-close"
            @click="showModal = false"
          >
            <i class="fas fa-xmark"></i>
          </button>

        </div>

        <div class="modal-body">

          <div class="form-group">

            <label>Nama</label>

            <input
              v-model="formData.name"
              type="text"
              placeholder="Masukkan nama..."
            >

          </div>

          <div class="form-group">

            <label>Deskripsi</label>

            <textarea
              v-model="formData.desc"
              rows="4"
              placeholder="Masukkan deskripsi..."
            ></textarea>

          </div>

        </div>

        <div class="modal-footer">

          <button
            class="cancel-btn"
            @click="showModal = false"
          >
            Batal
          </button>

          <button
            class="primary-btn"
            @click="saveData"
          >
            <i class="fas fa-check"></i>
            Simpan Data
          </button>

        </div>

      </div>

    </div>

  </div>
</template>


<script setup>
import { ref, computed } from 'vue'

/* =========================
   STATE
========================= */

const isCollapsed = ref(false)
const currentTab = ref('dashboard')
const showModal = ref(false)

const formData = ref({
  name: '',
  desc: ''
})


/* =========================
   CHART
========================= */

const chartData = ref([
  { label: 'Jan', value: 65 },
  { label: 'Feb', value: 80 },
  { label: 'Mar', value: 45 },
  { label: 'Apr', value: 90 },
  { label: 'Mei', value: 75 },
  { label: 'Jun', value: 85 }
])


/* =========================
   DATA RUANGAN
========================= */

const roomsList = ref([
  {
    id: 1,
    code: 'R-01',
    name: 'Lab Komputer 1',
    capacity: 30,
    location: 'Gedung A Lt. 2',
    status: 'Tersedia'
  },
  {
    id: 2,
    code: 'R-02',
    name: 'Ruang Multimedia',
    capacity: 50,
    location: 'Gedung B Lt. 1',
    status: 'Dipakai'
  },
  {
    id: 3,
    code: 'R-03',
    name: 'Aula Utama',
    capacity: 200,
    location: 'Gedung Utama',
    status: 'Tersedia'
  }
])


/* =========================
   DATA FASILITAS
========================= */

const facilitiesList = ref([
  {
    id: 1,
    name: 'Proyektor Epson EB-X400',
    category: 'Elektronik',
    total: 15,
    good: 14,
    broken: 1
  },
  {
    id: 2,
    name: 'Laptop Core i5 Lenovo',
    category: 'Komputer',
    total: 40,
    good: 38,
    broken: 2
  },
  {
    id: 3,
    name: 'Meja Siswa Ergonomis',
    category: 'Mebel',
    total: 300,
    good: 295,
    broken: 5
  }
])


/* =========================
   DATA KATEGORI
========================= */

const categoriesList = ref([
  {
    id: 1,
    name: 'Elektronik & Multimedia',
    type: 'Fasilitas',
    count: 18
  },
  {
    id: 2,
    name: 'Laboratorium Komputer',
    type: 'Ruangan',
    count: 4
  },
  {
    id: 3,
    name: 'Mebel & Perlengkapan Kelas',
    type: 'Fasilitas',
    count: 35
  }
])


/* =========================
   DATA PENGAJUAN
========================= */

const pengajuanList = ref([
  {
    id: 1,
    requester: 'Budi Santoso',
    role: 'Guru Matematika',
    item: 'Peminjaman Proyektor Lab 1',
    date: '15 Sep 2026',
    status: 'Pending'
  },
  {
    id: 2,
    requester: 'Dewi Lestari',
    role: 'Siswa (OSIS)',
    item: 'Pengajuan Pengadaan Mic Wireless',
    date: '14 Sep 2026',
    status: 'Pending'
  }
])


/* =========================
   DATA LAPORAN
========================= */

const laporanList = ref([
  {
    id: 1,
    reporter: 'Siti Rahma',
    item: 'AC Ruang Kelas 10-A',
    desc: 'Tidak dingin dan berbunyi bising',
    status: 'Proses'
  },
  {
    id: 2,
    reporter: 'Ahmad Fauzi',
    item: 'Pintu Lab Komputer',
    desc: 'Kunci agak seret saat dibuka',
    status: 'Selesai'
  }
])


/* =========================
   DATA MAINTENANCE
========================= */

const maintenanceList = ref([
  {
    id: 1,
    unit: 'AC Ruang Kelas 10-A',
    technician: 'Pak Joko (Teknisi)',
    estimate: '18 Sep 2026',
    progress: 'Penggantian Freon'
  },
  {
    id: 2,
    unit: 'Proyektor Lab 2',
    technician: 'Pak Rudi',
    estimate: '16 Sep 2026',
    progress: 'Pengecekan Lampu'
  }
])


/* =========================
   COMPUTED
========================= */

const getPageTitle = computed(() => {

  const titles = {
    dashboard: 'Dashboard & Statistik Utama',
    ruangan: 'Manajemen Ruangan Sekolah',
    fasilitas: 'Kelola Fasilitas & Barang',
    kategori: 'Kelola Kategori Inventaris',
    pengajuan: 'Persetujuan Pengajuan',
    laporan: 'Laporan Kerusakan Aset',
    maintenance: 'Maintenance & Perbaikan'
  }

  return titles[currentTab.value] || 'Dashboard Admin'
})


const totalFacilities = computed(() => {
  return facilitiesList.value.reduce(
    (total, item) => total + item.total,
    0
  )
})


const totalGood = computed(() => {
  return facilitiesList.value.reduce(
    (total, item) => total + item.good,
    0
  )
})


const totalBroken = computed(() => {
  return facilitiesList.value.reduce(
    (total, item) => total + item.broken,
    0
  )
})


const goodPercentage = computed(() => {

  if (totalFacilities.value === 0) {
    return 0
  }

  return Math.round(
    (totalGood.value / totalFacilities.value) * 100
  )
})


const pendingCount = computed(() => {

  return pengajuanList.value.filter(
    item => item.status === 'Pending'
  ).length

})


/* =========================
   FUNCTIONS
========================= */

const openModal = (type) => {

  formData.value = {
    name: '',
    desc: ''
  }

  showModal.value = true

}


const saveData = () => {

  if (!formData.value.name.trim()) {
    alert('Nama tidak boleh kosong.')
    return
  }

  alert('Data berhasil disimpan ke sistem!')

  showModal.value = false

}


const deleteItem = (type, id) => {

  if (
    confirm(
      'Yakin ingin menghapus data ini?'
    )
  ) {

    alert('Data berhasil dihapus!')

  }

}


const approvePengajuan = (item) => {

  item.status = 'Disetujui'

  alert(
    'Pengajuan berhasil disetujui.'
  )

}


const rejectPengajuan = (item) => {

  item.status = 'Ditolak'

  alert(
    'Pengajuan berhasil ditolak.'
  )

}


const exportExcel = () => {

  alert(
    'Berhasil mengekspor data laporan ke Excel (.xlsx)!'
  )

}


const exportPDF = () => {

  alert(
    'Berhasil mengunduh laporan ke PDF!'
  )

}


const handleLogout = () => {

  if (
    confirm(
      'Keluar dari panel administrator?'
    )
  ) {

    window.location.reload()

  }

}


const getStatusClass = (status) => {

  const classes = {
    Pending: 'warning',
    Disetujui: 'success',
    Ditolak: 'danger',
    Proses: 'warning',
    Selesai: 'success'
  }

  return classes[status] || 'info'

}
</script>


<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css');


/* =========================
   RESET
========================= */

* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

button,
input,
textarea,
select {
  font-family: inherit;
}

button {
  cursor: pointer;
}


/* =========================
   LAYOUT
========================= */

.admin-layout {
  min-height: 100vh;
  display: flex;
  background: #f5f7fb;
  color: #172033;
  font-family: 'Inter', sans-serif;
}


/* =========================
   SIDEBAR
========================= */

.sidebar {
  width: 270px;
  height: 100vh;
  position: sticky;
  top: 0;
  display: flex;
  flex-direction: column;
  background: #111827;
  color: white;
  transition: all .3s ease;
  flex-shrink: 0;
  z-index: 20;
}

.sidebar.collapsed {
  width: 82px;
}


/* BRAND */

.sidebar-brand {
  height: 82px;
  padding: 0 18px;
  display: flex;
  align-items: center;
  gap: 12px;
  border-bottom: 1px solid rgba(255,255,255,.07);
}

.brand-logo {
  width: 44px;
  height: 44px;
  border-radius: 13px;
  background: linear-gradient(135deg,#4f46e5,#7c3aed);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 19px;
  box-shadow: 0 8px 20px rgba(79,70,229,.25);
  flex-shrink: 0;
}

.brand-text {
  flex: 1;
}

.brand-text h2 {
  font-size: 17px;
  letter-spacing: .5px;
}

.brand-text span {
  display: block;
  margin-top: 2px;
  color: #9ca3af;
  font-size: 10px;
}

.collapse-btn {
  border: 0;
  background: transparent;
  color: #9ca3af;
  font-size: 13px;
}

.collapse-btn:hover {
  color: white;
}


/* USER */

.sidebar-user {
  margin: 18px;
  padding: 13px;
  border-radius: 14px;
  display: flex;
  align-items: center;
  gap: 10px;
  background: rgba(255,255,255,.055);
}

.user-avatar,
.profile-avatar,
.mini-avatar {
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 700;
}

.user-avatar {
  width: 38px;
  height: 38px;
  border-radius: 11px;
  background: linear-gradient(135deg,#6366f1,#8b5cf6);
}

.user-detail {
  min-width: 0;
  flex: 1;
}

.user-detail strong {
  display: block;
  font-size: 12px;
}

.user-detail span {
  display: block;
  color: #9ca3af;
  font-size: 10px;
  margin-top: 3px;
}

.online-dot {
  width: 8px;
  height: 8px;
  border-radius: 50%;
  background: #22c55e;
}


/* NAV */

.sidebar-nav {
  padding: 0 12px;
  flex: 1;
  overflow-y: auto;
}

.nav-section {
  padding: 17px 10px 8px;
  color: #6b7280;
  font-size: 9px;
  font-weight: 700;
  letter-spacing: 1px;
}

.sidebar-nav a {
  height: 45px;
  padding: 0 13px;
  margin-bottom: 4px;
  border-radius: 11px;
  display: flex;
  align-items: center;
  gap: 13px;
  text-decoration: none;
  color: #9ca3af;
  font-size: 12px;
  font-weight: 500;
  transition: .2s;
}

.sidebar-nav a i {
  width: 20px;
  text-align: center;
  font-size: 14px;
}

.sidebar-nav a:hover {
  background: rgba(255,255,255,.06);
  color: white;
}

.sidebar-nav a.active {
  color: white;
  background: linear-gradient(
    135deg,
    #4f46e5,
    #6366f1
  );
  box-shadow: 0 8px 18px rgba(79,70,229,.2);
}

.nav-badge {
  margin-left: auto;
  background: #ef4444;
  padding: 3px 7px;
  border-radius: 20px;
  font-size: 9px;
  color: white;
}


/* FOOTER */

.sidebar-footer {
  padding: 15px;
  border-top: 1px solid rgba(255,255,255,.07);
}

.logout-btn {
  width: 100%;
  height: 42px;
  border-radius: 10px;
  border: 1px solid rgba(239,68,68,.15);
  background: rgba(239,68,68,.08);
  color: #f87171;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 9px;
  font-size: 12px;
  font-weight: 600;
  transition: .2s;
}

.logout-btn:hover {
  background: #ef4444;
  color: white;
}


/* =========================
   MAIN
========================= */

.main-content {
  flex: 1;
  min-width: 0;
  display: flex;
  flex-direction: column;
}


/* =========================
   TOPBAR
========================= */

.topbar {
  height: 82px;
  padding: 0 30px;
  background: rgba(255,255,255,.92);
  border-bottom: 1px solid #e8ebf1;
  display: flex;
  align-items: center;
  justify-content: space-between;
  position: sticky;
  top: 0;
  z-index: 10;
  backdrop-filter: blur(10px);
}

.welcome-label {
  color: #8b95a7;
  font-size: 10px;
  font-weight: 600;
  letter-spacing: .4px;
}

.page-heading h1 {
  margin-top: 4px;
  font-size: 19px;
  font-weight: 800;
  color: #172033;
}

.topbar-right {
  display: flex;
  align-items: center;
  gap: 18px;
}

.icon-button {
  width: 38px;
  height: 38px;
  position: relative;
  border: 1px solid #e8ebf1;
  border-radius: 11px;
  background: white;
  color: #687386;
}

.icon-button:hover {
  background: #f7f8fb;
}

.notification-dot {
  width: 7px;
  height: 7px;
  position: absolute;
  top: 7px;
  right: 7px;
  background: #ef4444;
  border-radius: 50%;
  border: 2px solid white;
}

.profile {
  padding-left: 16px;
  border-left: 1px solid #e8ebf1;
  display: flex;
  align-items: center;
  gap: 9px;
}

.profile-avatar {
  width: 37px;
  height: 37px;
  border-radius: 11px;
  background: #ede9fe;
  color: #6d28d9;
  font-size: 13px;
}

.profile-info strong {
  display: block;
  color: #293348;
  font-size: 11px;
}

.profile-info span {
  display: block;
  color: #929aaa;
  font-size: 9px;
  margin-top: 3px;
}

.profile-arrow {
  color: #9ca3af;
  font-size: 9px;
  margin-left: 3px;
}


/* =========================
   CONTENT
========================= */

.content-body {
  padding: 28px 30px 40px;
  overflow-y: auto;
}


/* =========================
   WELCOME CARD
========================= */

.welcome-card {
  min-height: 205px;
  padding: 30px 34px;
  margin-bottom: 30px;
  position: relative;
  overflow: hidden;
  border-radius: 20px;
  color: white;
  background:
    linear-gradient(
      120deg,
      #4338ca,
      #6366f1 55%,
      #7c3aed
    );
  box-shadow: 0 15px 35px rgba(79,70,229,.18);
}

.welcome-card::after {
  content: '';
  position: absolute;
  width: 300px;
  height: 300px;
  right: -80px;
  top: -140px;
  border: 50px solid rgba(255,255,255,.06);
  border-radius: 50%;
}

.welcome-content {
  position: relative;
  z-index: 2;
}

.welcome-small {
  font-size: 9px;
  font-weight: 700;
  letter-spacing: 1.2px;
  opacity: .8;
}

.welcome-card h2 {
  margin: 9px 0;
  font-size: 25px;
  line-height: 1.3;
  font-weight: 800;
}

.welcome-card p {
  max-width: 580px;
  margin-bottom: 18px;
  color: rgba(255,255,255,.78);
  font-size: 11px;
  line-height: 1.6;
}

.welcome-decoration {
  position: absolute;
  right: 9%;
  bottom: -15px;
  font-size: 120px;
  color: rgba(255,255,255,.08);
  transform: rotate(-8deg);
}


/* =========================
   BUTTONS
========================= */

.primary-btn {
  min-height: 38px;
  padding: 0 15px;
  border: none;
  border-radius: 9px;
  background: #4f46e5;
  color: white;
  font-size: 11px;
  font-weight: 700;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  transition: .2s;
}

.welcome-card .primary-btn {
  background: white;
  color: #4338ca;
}

.primary-btn:hover {
  transform: translateY(-1px);
  box-shadow: 0 7px 18px rgba(0,0,0,.12);
}

.outline-btn {
  height: 34px;
  padding: 0 12px;
  border: 1px solid #e1e5ec;
  border-radius: 8px;
  background: white;
  color: #657084;
  font-size: 10px;
  font-weight: 600;
  display: flex;
  align-items: center;
  gap: 7px;
}


/* =========================
   SECTION TITLE
========================= */

.section-title {
  margin-bottom: 15px;
  display: flex;
  justify-content: space-between;
  align-items: flex-end;
}

.section-title span,
.card-label {
  color: #8b95a7;
  font-size: 8px;
  font-weight: 800;
  letter-spacing: 1px;
}

.section-title h2 {
  margin-top: 3px;
  font-size: 16px;
}


/* =========================
   STAT CARDS
========================= */

.stats-grid {
  display: grid;
  grid-template-columns: repeat(4,1fr);
  gap: 17px;
  margin-bottom: 20px;
}

.stat-card {
  padding: 19px;
  border: 1px solid #e9ecf2;
  border-radius: 16px;
  background: white;
  display: flex;
  align-items: center;
  gap: 13px;
  transition: .2s;
}

.stat-card:hover {
  transform: translateY(-3px);
  box-shadow: 0 10px 25px rgba(30,41,59,.06);
}

.stat-icon {
  width: 45px;
  height: 45px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.stat-card.blue .stat-icon {
  background: #e0e7ff;
  color: #4f46e5;
}

.stat-card.purple .stat-icon {
  background: #f3e8ff;
  color: #9333ea;
}

.stat-card.orange .stat-icon {
  background: #ffedd5;
  color: #ea580c;
}

.stat-card.green .stat-icon {
  background: #dcfce7;
  color: #16a34a;
}

.stat-content span {
  display: block;
  color: #8a94a6;
  font-size: 9px;
  font-weight: 600;
}

.stat-content h3 {
  margin: 3px 0;
  color: #172033;
  font-size: 21px;
}

.stat-content small {
  color: #16a34a;
  font-size: 8px;
}


/* =========================
   DASHBOARD GRID
========================= */

.dashboard-grid {
  display: grid;
  grid-template-columns: 1.65fr 1fr;
  gap: 18px;
  margin-bottom: 18px;
}

.dashboard-card,
.page-card {
  border: 1px solid #e8ebf1;
  border-radius: 16px;
  background: white;
  overflow: hidden;
}

.card-header {
  padding: 19px 20px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  border-bottom: 1px solid #eef0f4;
}

.card-header h3 {
  margin-top: 4px;
  font-size: 14px;
}

.period-select {
  padding: 7px 10px;
  border: 1px solid #e2e6ed;
  border-radius: 7px;
  outline: none;
  color: #667085;
  font-size: 9px;
}


/* =========================
   CHART
========================= */

.chart-container {
  height: 250px;
  padding: 25px 30px 20px;
  display: flex;
  align-items: flex-end;
  justify-content: space-around;
  gap: 15px;
}

.chart-column {
  height: 100%;
  flex: 1;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: flex-end;
}

.chart-value {
  margin-bottom: 6px;
  color: #6366f1;
  font-size: 9px;
  font-weight: 700;
}

.bar-wrapper {
  width: 28px;
  height: 165px;
  display: flex;
  align-items: flex-end;
  border-radius: 8px;
  background: #f1f3f8;
  overflow: hidden;
}

.chart-bar {
  width: 100%;
  border-radius: 8px 8px 3px 3px;
  background: linear-gradient(
    180deg,
    #6366f1,
    #818cf8
  );
  transition: height .5s ease;
}

.chart-label {
  margin-top: 8px;
  color: #8a94a6;
  font-size: 9px;
  font-weight: 600;
}


/* =========================
   QUICK ACTION
========================= */

.quick-actions {
  padding: 10px;
}

.quick-action {
  width: 100%;
  padding: 12px 10px;
  border: 0;
  background: transparent;
  display: flex;
  align-items: center;
  gap: 10px;
  text-align: left;
  border-radius: 10px;
}

.quick-action:hover {
  background: #f7f8fb;
}

.quick-icon {
  width: 36px;
  height: 36px;
  border-radius: 9px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.blue-icon {
  color: #4f46e5;
  background: #eef2ff;
}

.orange-icon {
  color: #ea580c;
  background: #fff7ed;
}

.red-icon {
  color: #dc2626;
  background: #fef2f2;
}

.quick-action div:nth-child(2) {
  flex: 1;
}

.quick-action strong {
  display: block;
  color: #293348;
  font-size: 10px;
}

.quick-action span {
  display: block;
  margin-top: 3px;
  color: #9aa2b1;
  font-size: 8px;
}

.quick-action > i {
  color: #c0c6d0;
  font-size: 9px;
}


/* =========================
   BOTTOM GRID
========================= */

.bottom-grid {
  display: grid;
  grid-template-columns: 1.65fr 1fr;
  gap: 18px;
}


/* =========================
   TABLE
========================= */

.table-wrapper {
  width: 100%;
  overflow-x: auto;
}

table {
  width: 100%;
  border-collapse: collapse;
  font-size: 10px;
}

th {
  padding: 13px 18px;
  text-align: left;
  color: #8a94a6;
  background: #fafbfc;
  font-size: 8px;
  text-transform: uppercase;
  letter-spacing: .5px;
  white-space: nowrap;
}

td {
  padding: 14px 18px;
  border-top: 1px solid #f0f1f4;
  color: #556174;
  white-space: nowrap;
}

tr:hover td {
  background: #fcfcfd;
}

.person-cell {
  display: flex;
  align-items: center;
  gap: 9px;
}

.mini-avatar {
  width: 29px;
  height: 29px;
  border-radius: 8px;
  background: #ede9fe;
  color: #6d28d9;
  font-size: 9px;
}

.person-cell strong {
  display: block;
  color: #293348;
  font-size: 9px;
}

.person-cell span {
  display: block;
  color: #9aa2b1;
  margin-top: 3px;
  font-size: 7px;
}

.item-name {
  display: block;
  color: #465166;
  font-size: 9px;
}

td small {
  display: block;
  color: #9aa2b1;
  margin-top: 3px;
  font-size: 7px;
}


/* =========================
   STATUS
========================= */

.status-badge {
  display: inline-flex;
  padding: 5px 8px;
  border-radius: 20px;
  font-size: 8px;
  font-weight: 700;
}

.status-badge.success {
  color: #15803d;
  background: #dcfce7;
}

.status-badge.warning {
  color: #b45309;
  background: #fef3c7;
}

.status-badge.danger {
  color: #b91c1c;
  background: #fee2e2;
}

.status-badge.info {
  color: #0369a1;
  background: #e0f2fe;
}


/* =========================
   CONDITION
========================= */

.condition-content {
  padding: 25px 20px;
  display: flex;
  align-items: center;
  gap: 22px;
}

.condition-circle {
  width: 120px;
  height: 120px;
  border-radius: 50%;
  background:
    radial-gradient(
      circle,
      white 58%,
      transparent 60%
    ),
    conic-gradient(
      #22c55e 0 94%,
      #fee2e2 94% 100%
    );
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.condition-circle strong {
  font-size: 21px;
}

.condition-circle span {
  color: #8b95a7;
  font-size: 8px;
  margin-top: 3px;
}

.condition-list {
  flex: 1;
}

.condition-item {
  display: flex;
  justify-content: space-between;
  padding: 8px 0;
  color: #687386;
  font-size: 9px;
  border-bottom: 1px solid #f0f1f4;
}

.condition-item:last-child {
  border: none;
}

.condition-item span {
  display: flex;
  align-items: center;
  gap: 6px;
}

.condition-dot {
  width: 7px;
  height: 7px;
  border-radius: 50%;
}

.condition-dot.good {
  background: #22c55e;
}

.condition-dot.broken {
  background: #ef4444;
}

.condition-dot.total {
  background: #6366f1;
}


/* =========================
   PAGE CARD
========================= */

.page-card {
  padding-bottom: 20px;
}

.page-card-header {
  padding: 24px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 15px;
  border-bottom: 1px solid #eef0f4;
}

.page-card-header h2 {
  margin: 5px 0;
  font-size: 19px;
}

.page-card-header p {
  color: #929aaa;
  font-size: 10px;
}

.page-card > .table-wrapper {
  margin-top: 5px;
}


/* =========================
   ACTION BUTTON
========================= */

.action-buttons {
  display: flex;
  align-items: center;
  gap: 5px;
}

.table-action {
  width: 29px;
  height: 29px;
  border: 0;
  border-radius: 7px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 9px;
}

.table-action.edit {
  color: #4f46e5;
  background: #eef2ff;
}

.table-action.delete {
  color: #dc2626;
  background: #fef2f2;
}

.table-action:hover {
  transform: scale(1.05);
}

.category-tag {
  padding: 5px 8px;
  border-radius: 6px;
  background: #f3f4f6;
  color: #667085;
  font-size: 8px;
}

.number-good {
  color: #16a34a;
  font-weight: 700;
}

.number-broken {
  color: #dc2626;
  font-weight: 700;
}


/* =========================
   CATEGORY
========================= */

.category-grid {
  padding: 22px;
  display: grid;
  grid-template-columns: repeat(3,1fr);
  gap: 15px;
}

.category-card {
  position: relative;
  padding: 20px;
  border: 1px solid #e8ebf1;
  border-radius: 14px;
  display: flex;
  align-items: center;
  gap: 13px;
}

.category-icon {
  width: 45px;
  height: 45px;
  border-radius: 12px;
  background: #eef2ff;
  color: #4f46e5;
  display: flex;
  align-items: center;
  justify-content: center;
}

.category-info {
  min-width: 0;
}

.category-info span {
  color: #929aaa;
  font-size: 8px;
}

.category-info h3 {
  margin: 4px 0;
  font-size: 11px;
}

.category-info p {
  color: #9aa2b1;
  font-size: 8px;
}

.delete-category {
  position: absolute;
  top: 10px;
  right: 10px;
  border: 0;
  background: transparent;
  color: #c5cad3;
}

.delete-category:hover {
  color: #ef4444;
}


/* =========================
   PENGAJUAN
========================= */

.approve-btn {
  height: 28px;
  padding: 0 9px;
  border: 0;
  border-radius: 7px;
  background: #dcfce7;
  color: #15803d;
  font-size: 8px;
  font-weight: 700;
}

.reject-btn {
  width: 28px;
  height: 28px;
  border: 0;
  border-radius: 7px;
  background: #fee2e2;
  color: #dc2626;
}

.completed-text {
  color: #9aa2b1;
  font-size: 8px;
}


/* =========================
   REPORT
========================= */

.export-buttons {
  display: flex;
  gap: 8px;
}

.export-btn {
  height: 35px;
  padding: 0 11px;
  border: 0;
  border-radius: 8px;
  display: flex;
  align-items: center;
  gap: 7px;
  font-size: 9px;
  font-weight: 700;
}

.export-btn.excel {
  color: #15803d;
  background: #dcfce7;
}

.export-btn.pdf {
  color: #b91c1c;
  background: #fee2e2;
}

.report-grid {
  padding: 22px;
  display: grid;
  grid-template-columns: repeat(2,1fr);
  gap: 15px;
}

.report-card {
  padding: 18px;
  border: 1px solid #e8ebf1;
  border-radius: 13px;
}

.report-top {
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.report-icon {
  width: 37px;
  height: 37px;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #dc2626;
  background: #fef2f2;
}

.report-card h3 {
  margin: 15px 0 7px;
  font-size: 12px;
}

.report-card p {
  color: #8a94a6;
  font-size: 9px;
  line-height: 1.6;
}

.report-footer {
  margin-top: 16px;
  padding-top: 12px;
  border-top: 1px solid #eef0f4;
  color: #929aaa;
  font-size: 8px;
}


/* =========================
   MAINTENANCE
========================= */

.maintenance-grid {
  padding: 22px;
  display: grid;
  grid-template-columns: repeat(2,1fr);
  gap: 15px;
}

.maintenance-card {
  padding: 18px;
  border: 1px solid #e8ebf1;
  border-radius: 14px;
  display: flex;
  gap: 14px;
}

.maintenance-icon {
  width: 45px;
  height: 45px;
  border-radius: 12px;
  background: #fff7ed;
  color: #ea580c;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.maintenance-content {
  flex: 1;
}

.maintenance-label {
  color: #ea580c;
  font-size: 7px;
  font-weight: 800;
  letter-spacing: .6px;
}

.maintenance-content h3 {
  margin: 5px 0 10px;
  font-size: 12px;
}

.maintenance-info {
  display: flex;
  gap: 15px;
  color: #8a94a6;
  font-size: 8px;
}

.maintenance-info span {
  display: flex;
  align-items: center;
  gap: 5px;
}

.progress-area {
  margin-top: 15px;
}

.progress-header {
  display: flex;
  justify-content: space-between;
  color: #8a94a6;
  font-size: 8px;
}

.progress-header strong {
  color: #6366f1;
}

.progress-bar {
  height: 5px;
  margin-top: 7px;
  border-radius: 20px;
  background: #eef0f4;
  overflow: hidden;
}

.progress-fill {
  width: 65%;
  height: 100%;
  border-radius: 20px;
  background: linear-gradient(
    90deg,
    #6366f1,
    #8b5cf6
  );
}


/* =========================
   VIEW ALL
========================= */

.view-all {
  border: 0;
  background: transparent;
  color: #6366f1;
  font-size: 9px;
  font-weight: 700;
}


/* =========================
   MODAL
========================= */

.modal-overlay {
  position: fixed;
  inset: 0;
  z-index: 100;
  padding: 20px;
  background: rgba(15,23,42,.55);
  display: flex;
  align-items: center;
  justify-content: center;
  backdrop-filter: blur(4px);
}

.modal {
  width: 100%;
  max-width: 460px;
  border-radius: 18px;
  background: white;
  overflow: hidden;
  box-shadow: 0 25px 70px rgba(0,0,0,.2);
  animation: modalIn .25s ease;
}

@keyframes modalIn {
  from {
    opacity: 0;
    transform: translateY(15px) scale(.98);
  }

  to {
    opacity: 1;
    transform: translateY(0) scale(1);
  }
}

.modal-header {
  padding: 21px;
  border-bottom: 1px solid #eef0f4;
  display: flex;
  justify-content: space-between;
}

.modal-header h2 {
  margin-top: 5px;
  font-size: 17px;
}

.modal-close {
  width: 32px;
  height: 32px;
  border: 0;
  border-radius: 8px;
  background: #f3f4f6;
  color: #687386;
}

.modal-body {
  padding: 22px;
}

.form-group {
  margin-bottom: 16px;
}

.form-group label {
  display: block;
  margin-bottom: 7px;
  color: #4b5563;
  font-size: 10px;
  font-weight: 700;
}

.form-group input,
.form-group textarea {
  width: 100%;
  padding: 11px 13px;
  border: 1px solid #dfe3ea;
  border-radius: 9px;
  outline: none;
  resize: vertical;
  color: #293348;
  font-size: 10px;
}

.form-group input:focus,
.form-group textarea:focus {
  border-color: #6366f1;
  box-shadow: 0 0 0 3px rgba(99,102,241,.1);
}

.modal-footer {
  padding: 16px 21px;
  border-top: 1px solid #eef0f4;
  display: flex;
  justify-content: flex-end;
  gap: 8px;
}

.cancel-btn {
  padding: 0 15px;
  height: 38px;
  border: 1px solid #e1e5ec;
  border-radius: 9px;
  background: white;
  color: #687386;
  font-size: 10px;
  font-weight: 600;
}


/* =========================
   ANIMATION
========================= */

.fade-in {
  animation: fadeIn .3s ease;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(5px);
  }

  to {
    opacity: 1;
    transform: translateY(0);
  }
}


/* =========================
   RESPONSIVE
========================= */

@media (max-width: 1100px) {

  .stats-grid {
    grid-template-columns: repeat(2,1fr);
  }

  .dashboard-grid,
  .bottom-grid {
    grid-template-columns: 1fr;
  }

  .category-grid {
    grid-template-columns: repeat(2,1fr);
  }

}


@media (max-width: 768px) {

  .sidebar {
    width: 82px;
  }

  .sidebar .brand-text,
  .sidebar .sidebar-user,
  .sidebar .nav-section,
  .sidebar .sidebar-nav span,
  .sidebar .logout-btn span {
    display: none;
  }

  .sidebar-brand {
    justify-content: center;
    padding: 0;
  }

  .collapse-btn {
    display: none;
  }

  .sidebar-nav a {
    justify-content: center;
    padding: 0;
  }

  .content-body {
    padding: 20px 15px;
  }

  .topbar {
    padding: 0 15px;
  }

  .profile-info,
  .profile-arrow {
    display: none;
  }

  .page-heading h1 {
    font-size: 15px;
  }

  .welcome-card {
    padding: 25px;
  }

  .welcome-card h2 {
    font-size: 20px;
  }

  .welcome-decoration {
    display: none;
  }

  .stats-grid {
    grid-template-columns: 1fr;
  }

  .category-grid,
  .report-grid,
  .maintenance-grid {
    grid-template-columns: 1fr;
  }

  .page-card-header {
    align-items: flex-start;
    flex-direction: column;
  }

}


@media (max-width: 480px) {

  .sidebar {
    width: 65px;
  }

  .topbar {
    height: 70px;
  }

  .content-body {
    padding: 15px 10px;
  }

  .welcome-card {
    border-radius: 15px;
  }

  .chart-container {
    padding-left: 10px;
    padding-right: 10px;
  }

}
</style>
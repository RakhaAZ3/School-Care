<template>
  <div class="pengguna-dashboard">

    <!-- SIDEBAR -->
    <aside class="sidebar">
      <div class="sidebar-header">
        <div class="logo-box">🏫</div>

        <div v-if="!isCollapsed" class="brand">
          <h2>School<span>Care</span></h2>
          <small>Pengguna Panel</small>
        </div>
      </div>

      <nav class="sidebar-nav">
        <p v-if="!isCollapsed" class="menu-title">MENU</p>

        <!-- DASHBOARD -->
        <button
          class="nav-item active"
          type="button"
          @click="goTo('/pengguna/dashboard')"
        >
          <i class="fa-solid fa-house"></i>
          <span v-if="!isCollapsed">
            Dashboard
          </span>
        </button>

        <!-- FASILITAS -->
        <button
          class="nav-item"
          type="button"
          @click="goTo('/pengguna/fasilitas')"
        >
          <i class="fa-solid fa-boxes-stacked"></i>
          <span v-if="!isCollapsed">
            Fasilitas
          </span>
        </button>

        <!-- RUANGAN -->
        <button
          class="nav-item"
          type="button"
          @click="goTo('/pengguna/ruangan')"
        >
          <i class="fa-solid fa-door-open"></i>
          <span v-if="!isCollapsed">
            Ruangan
          </span>
        </button>

        <!-- PENGAJUAN -->
        <button
          class="nav-item"
          type="button"
          @click="goTo('/pengguna/pengajuan')"
        >
          <i class="fa-solid fa-file-circle-check"></i>
          <span v-if="!isCollapsed">
            Pengajuan Saya
          </span>
        </button>

        <!-- LAPORAN -->
        <button
          class="nav-item"
          type="button"
          @click="goTo('/pengguna/laporan')"
        >
          <i class="fa-solid fa-triangle-exclamation"></i>
          <span v-if="!isCollapsed">
            Laporan Saya
          </span>
        </button>
      </nav>

      <!-- LOGOUT -->
      <div class="sidebar-bottom">
        <button
          class="nav-item logout-btn"
          type="button"
          @click="handleLogout"
        >
          <i class="fa-solid fa-right-from-bracket"></i>

          <span v-if="!isCollapsed">
            Logout
          </span>
        </button>
      </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="main-content">

      <!-- TOPBAR -->
      <header class="topbar">
        <div class="topbar-left">

          <button
            class="toggle-btn"
            type="button"
            @click="toggleSidebar"
          >
            <i class="fa-solid fa-bars"></i>
          </button>

          <div>
            <h1>Dashboard</h1>
            <p>
              Kelola kebutuhan fasilitas sekolah kamu dengan mudah.
            </p>
          </div>

        </div>

        <div class="profile">
          <div class="profile-avatar">
            👤
          </div>

          <div class="profile-info">
            <strong>Pengguna</strong>
            <span>SchoolCare</span>
          </div>
        </div>
      </header>

      <!-- PAGE CONTENT -->
      <section class="page-content">

        <!-- WELCOME -->
        <div class="welcome-card">

          <div class="welcome-content">

            <span class="welcome-label">
              👋 Selamat datang di SchoolCare
            </span>

            <h2>
              Halo, Pengguna!
              <br />
              <span>Butuh fasilitas sekolah?</span>
            </h2>

            <p>
              Cari fasilitas atau ruangan yang kamu butuhkan,
              lalu ajukan peminjaman dengan mudah melalui SchoolCare.
            </p>

            <div class="welcome-actions">

              <button
                type="button"
                class="btn-primary"
                @click="goTo('/pengguna/fasilitas')"
              >
                <i class="fa-solid fa-magnifying-glass"></i>
                Lihat Fasilitas
              </button>

              <button
                type="button"
                class="btn-secondary"
                @click="goTo('/pengguna/pengajuan')"
              >
                <i class="fa-solid fa-plus"></i>
                Buat Pengajuan
              </button>

            </div>
          </div>

          <div class="welcome-visual">
            <div class="visual-circle circle-one"></div>
            <div class="visual-circle circle-two"></div>

            <div class="school-icon">
              🏫
            </div>
          </div>

        </div>

        <!-- QUICK ACCESS -->
        <div class="section-header">
          <div>
            <span class="section-label">LAYANAN</span>

            <h2>Akses Cepat</h2>

            <p>
              Pilih layanan SchoolCare yang ingin kamu gunakan.
            </p>
          </div>
        </div>

        <div class="quick-grid">

          <!-- FASILITAS -->
          <button
            class="quick-card"
            type="button"
            @click="goTo('/pengguna/fasilitas')"
          >
            <div class="quick-icon blue">
              <i class="fa-solid fa-boxes-stacked"></i>
            </div>

            <div class="quick-content">
              <h3>Lihat Fasilitas</h3>

              <p>
                Cek fasilitas sekolah yang tersedia.
              </p>
            </div>

            <div class="arrow-box">
              <i class="fa-solid fa-arrow-right"></i>
            </div>
          </button>

          <!-- RUANGAN -->
          <button
            class="quick-card"
            type="button"
            @click="goTo('/pengguna/ruangan')"
          >
            <div class="quick-icon purple">
              <i class="fa-solid fa-door-open"></i>
            </div>

            <div class="quick-content">
              <h3>Lihat Ruangan</h3>

              <p>
                Cari ruangan yang ingin digunakan.
              </p>
            </div>

            <div class="arrow-box">
              <i class="fa-solid fa-arrow-right"></i>
            </div>
          </button>

          <!-- PENGAJUAN -->
          <button
            class="quick-card"
            type="button"
            @click="goTo('/pengguna/pengajuan')"
          >
            <div class="quick-icon green">
              <i class="fa-solid fa-file-circle-check"></i>
            </div>

            <div class="quick-content">
              <h3>Pengajuan Saya</h3>

              <p>
                Lihat status pengajuan peminjaman.
              </p>
            </div>

            <div class="arrow-box">
              <i class="fa-solid fa-arrow-right"></i>
            </div>
          </button>

          <!-- LAPORAN -->
          <button
            class="quick-card"
            type="button"
            @click="goTo('/pengguna/laporan')"
          >
            <div class="quick-icon orange">
              <i class="fa-solid fa-triangle-exclamation"></i>
            </div>

            <div class="quick-content">
              <h3>Lapor Kerusakan</h3>

              <p>
                Laporkan fasilitas yang mengalami masalah.
              </p>
            </div>

            <div class="arrow-box">
              <i class="fa-solid fa-arrow-right"></i>
            </div>
          </button>

        </div>

        <!-- INFO -->
        <div class="info-section">

          <div class="section-header">
            <div>
              <span class="section-label">CARA KERJA</span>

              <h2>Informasi</h2>

              <p>
                Beberapa hal yang bisa kamu lakukan di SchoolCare.
              </p>
            </div>
          </div>

          <div class="info-grid">

            <!-- INFO 01 -->
            <div class="info-card">
              <div class="info-number">
                01
              </div>

              <div>
                <h3>Cari fasilitas</h3>

                <p>
                  Temukan fasilitas sekolah yang tersedia
                  sebelum melakukan peminjaman.
                </p>
              </div>
            </div>

            <!-- INFO 02 -->
            <div class="info-card">
              <div class="info-number">
                02
              </div>

              <div>
                <h3>Buat pengajuan</h3>

                <p>
                  Ajukan penggunaan fasilitas atau ruangan
                  sesuai kebutuhanmu.
                </p>
              </div>
            </div>

            <!-- INFO 03 -->
            <div class="info-card">
              <div class="info-number">
                03
              </div>

              <div>
                <h3>Tunggu verifikasi</h3>

                <p>
                  Pantau status pengajuan sampai mendapatkan
                  persetujuan dari admin.
                </p>
              </div>
            </div>

          </div>
        </div>

      </section>

      <!-- FOOTER -->
      <footer class="footer">
        <p>
          © {{ currentYear }} SchoolCare. All rights reserved.
        </p>
      </footer>

    </main>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()

const isCollapsed = ref(false)

const currentYear = new Date().getFullYear()

const toggleSidebar = () => {
  isCollapsed.value = !isCollapsed.value
}

const goTo = (path) => {
  router.push(path)
}

const handleLogout = () => {
  const confirmLogout = confirm(
    'Apakah kamu yakin ingin keluar?'
  )

  if (!confirmLogout) {
    return
  }

  localStorage.removeItem('token')
  localStorage.removeItem('user')
  localStorage.removeItem('isLoggedIn')

  router.push('/login')
}
</script>

<style scoped>
* {
  box-sizing: border-box;
}

.pengguna-dashboard {
  min-height: 100vh;
  display: flex;
  background: #f8fafc;
  color: #0f172a;
  font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
}

/* =========================
   SIDEBAR
========================= */

.sidebar {
  width: 250px;
  min-height: 100vh;
  background: rgba(255, 255, 255, 0.96);
  border-right: 1px solid #e2e8f0;
  display: flex;
  flex-direction: column;
  padding: 24px 16px;
  position: sticky;
  top: 0;
  height: 100vh;
  flex-shrink: 0;
  transition: width 0.25s ease;
  backdrop-filter: blur(15px);
}

.sidebar-header {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 0 8px 28px;
  border-bottom: 1px solid #f1f5f9;
}

.logo-box {
  width: 44px;
  height: 44px;
  border-radius: 14px;
  background: linear-gradient(
    135deg,
    #eff6ff,
    #ede9fe
  );
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 21px;
  flex-shrink: 0;
  box-shadow: 0 8px 20px rgba(37, 99, 235, 0.08);
}

.brand h2 {
  margin: 0;
  font-size: 18px;
  font-weight: 800;
  letter-spacing: -0.5px;
  color: #0f172a;
}

.brand h2 span {
  color: #2563eb;
}

.brand small {
  display: block;
  margin-top: 3px;
  color: #94a3b8;
  font-size: 10px;
  font-weight: 600;
}

/* =========================
   NAVIGATION
========================= */

.sidebar-nav {
  flex: 1;
  padding-top: 25px;
}

.menu-title {
  margin: 0 10px 11px;
  font-size: 9px;
  font-weight: 800;
  color: #94a3b8;
  letter-spacing: 1.2px;
}

.nav-item {
  width: 100%;
  border: none;
  background: transparent;
  color: #64748b;
  padding: 12px 13px;
  margin-bottom: 5px;
  border-radius: 11px;
  display: flex;
  align-items: center;
  gap: 12px;
  font-size: 13px;
  font-weight: 650;
  cursor: pointer;
  text-align: left;
  transition: all 0.2s ease;
}

.nav-item i {
  width: 19px;
  text-align: center;
  font-size: 15px;
  flex-shrink: 0;
}

.nav-item:hover {
  background: #f8fafc;
  color: #2563eb;
  transform: translateX(2px);
}

.nav-item.active {
  color: #2563eb;
  background: linear-gradient(
    135deg,
    #eff6ff,
    #f5f3ff
  );
  box-shadow: 0 5px 15px rgba(37, 99, 235, 0.05);
}

.sidebar-bottom {
  border-top: 1px solid #f1f5f9;
  padding-top: 15px;
}

.logout-btn:hover {
  color: #dc2626;
  background: #fef2f2;
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
  min-height: 82px;
  background: rgba(255, 255, 255, 0.94);
  border-bottom: 1px solid #e2e8f0;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 16px 32px;
  backdrop-filter: blur(15px);
}

.topbar-left {
  display: flex;
  align-items: center;
  gap: 16px;
}

.toggle-btn {
  width: 40px;
  height: 40px;
  border: 1px solid #e2e8f0;
  background: white;
  color: #475569;
  border-radius: 11px;
  cursor: pointer;
  transition: all 0.2s ease;
}

.toggle-btn:hover {
  background: #eff6ff;
  color: #2563eb;
  border-color: #bfdbfe;
}

.topbar h1 {
  margin: 0;
  font-size: 21px;
  font-weight: 800;
  letter-spacing: -0.5px;
}

.topbar p {
  margin: 4px 0 0;
  color: #64748b;
  font-size: 12px;
}

.profile {
  display: flex;
  align-items: center;
  gap: 10px;
}

.profile-avatar {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  background: linear-gradient(
    135deg,
    #dbeafe,
    #ede9fe
  );
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 5px 15px rgba(37, 99, 235, 0.08);
}

.profile-info strong {
  display: block;
  font-size: 13px;
  color: #334155;
}

.profile-info span {
  display: block;
  margin-top: 2px;
  font-size: 10px;
  color: #94a3b8;
}

/* =========================
   PAGE
========================= */

.page-content {
  width: 100%;
  max-width: 1400px;
  margin: 0 auto;
  padding: 32px;
}

/* =========================
   WELCOME
========================= */

.welcome-card {
  min-height: 265px;
  border-radius: 24px;
  padding: 36px 40px;
  background: linear-gradient(
    135deg,
    #2563eb 0%,
    #4f46e5 50%,
    #7c3aed 100%
  );
  position: relative;
  overflow: hidden;
  display: flex;
  align-items: center;
  justify-content: space-between;
  box-shadow:
    0 20px 45px rgba(37, 99, 235, 0.18);
}

.welcome-card::before {
  content: '';
  position: absolute;
  width: 320px;
  height: 320px;
  border-radius: 50%;
  background: rgba(255, 255, 255, 0.07);
  right: 70px;
  top: -185px;
}

.welcome-card::after {
  content: '';
  position: absolute;
  width: 240px;
  height: 240px;
  border-radius: 50%;
  background: rgba(255, 255, 255, 0.07);
  right: -80px;
  bottom: -125px;
}

.welcome-content {
  position: relative;
  z-index: 2;
  max-width: 700px;
}

.welcome-label {
  display: inline-flex;
  align-items: center;
  padding: 7px 12px;
  border-radius: 20px;
  background: rgba(255, 255, 255, 0.14);
  border: 1px solid rgba(255, 255, 255, 0.12);
  color: white;
  font-size: 10px;
  font-weight: 700;
  margin-bottom: 15px;
}

.welcome-content h2 {
  margin: 0;
  color: white;
  font-size: 30px;
  line-height: 1.25;
  font-weight: 800;
  letter-spacing: -1px;
}

.welcome-content h2 span {
  color: #dbeafe;
}

.welcome-content p {
  max-width: 620px;
  margin: 13px 0 21px;
  color: rgba(255, 255, 255, 0.8);
  font-size: 13px;
  line-height: 1.7;
}

.welcome-actions {
  display: flex;
  gap: 10px;
  flex-wrap: wrap;
}

.btn-primary,
.btn-secondary {
  border-radius: 11px;
  padding: 11px 17px;
  font-size: 12px;
  font-weight: 700;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 8px;
  transition: all 0.2s ease;
}

.btn-primary {
  border: none;
  background: white;
  color: #2563eb;
  box-shadow: 0 8px 18px rgba(15, 23, 42, 0.08);
}

.btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 12px 22px rgba(15, 23, 42, 0.12);
}

.btn-secondary {
  background: rgba(255, 255, 255, 0.11);
  color: white;
  border: 1px solid rgba(255, 255, 255, 0.25);
}

.btn-secondary:hover {
  background: rgba(255, 255, 255, 0.2);
  transform: translateY(-2px);
}

.welcome-visual {
  position: relative;
  z-index: 2;
  width: 210px;
  height: 180px;
  margin-right: 15px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.school-icon {
  width: 125px;
  height: 125px;
  border-radius: 34px;
  background: rgba(255, 255, 255, 0.13);
  border: 1px solid rgba(255, 255, 255, 0.18);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 58px;
  position: relative;
  z-index: 3;
  backdrop-filter: blur(8px);
}

.visual-circle {
  position: absolute;
  border-radius: 50%;
  border: 1px solid rgba(255, 255, 255, 0.14);
}

.circle-one {
  width: 175px;
  height: 175px;
}

.circle-two {
  width: 220px;
  height: 220px;
}

/* =========================
   SECTION
========================= */

.section-header {
  margin-top: 35px;
  margin-bottom: 17px;
}

.section-label {
  display: block;
  margin-bottom: 6px;
  color: #2563eb;
  font-size: 9px;
  font-weight: 800;
  letter-spacing: 1.5px;
}

.section-header h2 {
  margin: 0;
  font-size: 20px;
  font-weight: 800;
  letter-spacing: -0.4px;
}

.section-header p {
  margin: 5px 0 0;
  color: #64748b;
  font-size: 12px;
}

/* =========================
   QUICK ACCESS
========================= */

.quick-grid {
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
  gap: 15px;
}

.quick-card {
  width: 100%;
  border: 1px solid #e2e8f0;
  background: white;
  border-radius: 17px;
  padding: 19px;
  display: flex;
  align-items: center;
  gap: 14px;
  text-align: left;
  cursor: pointer;
  transition: all 0.25s ease;
}

.quick-card:hover {
  border-color: #bfdbfe;
  transform: translateY(-3px);
  box-shadow:
    0 15px 30px rgba(37, 99, 235, 0.08);
}

.quick-icon {
  width: 46px;
  height: 46px;
  border-radius: 13px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
  font-size: 17px;
}

.quick-icon.blue {
  background: #eff6ff;
  color: #2563eb;
}

.quick-icon.purple {
  background: #f5f3ff;
  color: #7c3aed;
}

.quick-icon.green {
  background: #f0fdf4;
  color: #16a34a;
}

.quick-icon.orange {
  background: #fff7ed;
  color: #ea580c;
}

.quick-content {
  flex: 1;
}

.quick-content h3 {
  margin: 0;
  color: #1e293b;
  font-size: 14px;
  font-weight: 750;
}

.quick-content p {
  margin: 5px 0 0;
  color: #94a3b8;
  font-size: 11px;
  line-height: 1.5;
}

.arrow-box {
  width: 31px;
  height: 31px;
  border-radius: 9px;
  background: #f8fafc;
  color: #94a3b8;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 11px;
  transition: all 0.2s ease;
}

.quick-card:hover .arrow-box {
  background: #eff6ff;
  color: #2563eb;
  transform: translateX(3px);
}

/* =========================
   INFO
========================= */

.info-section {
  margin-top: 5px;
}

.info-grid {
  display: grid;
  grid-template-columns: repeat(3, minmax(0, 1fr));
  gap: 15px;
}

.info-card {
  background: white;
  border: 1px solid #e2e8f0;
  border-radius: 17px;
  padding: 21px;
  display: flex;
  gap: 15px;
  transition: all 0.2s ease;
}

.info-card:hover {
  border-color: #dbeafe;
  box-shadow: 0 10px 25px rgba(15, 23, 42, 0.04);
}

.info-number {
  font-size: 19px;
  font-weight: 800;
  color: #2563eb;
  line-height: 1;
}

.info-card h3 {
  margin: 0 0 6px;
  font-size: 13px;
  font-weight: 750;
  color: #334155;
}

.info-card p {
  margin: 0;
  color: #64748b;
  font-size: 11px;
  line-height: 1.6;
}

/* =========================
   FOOTER
========================= */

.footer {
  border-top: 1px solid #e2e8f0;
  background: white;
  padding: 18px 32px;
  margin-top: auto;
}

.footer p {
  margin: 0;
  color: #94a3b8;
  font-size: 11px;
  text-align: center;
}

/* =========================
   RESPONSIVE
========================= */

@media (max-width: 1000px) {
  .sidebar {
    width: 80px;
    padding-left: 10px;
    padding-right: 10px;
  }

  .sidebar-header {
    justify-content: center;
    padding-left: 0;
    padding-right: 0;
  }

  .nav-item {
    justify-content: center;
  }

  .welcome-visual {
    display: none;
  }

  .info-grid {
    grid-template-columns: 1fr;
  }
}

@media (max-width: 700px) {
  .topbar {
    padding: 15px 18px;
  }

  .profile-info {
    display: none;
  }

  .page-content {
    padding: 20px 18px;
  }

  .welcome-card {
    padding: 27px;
  }

  .welcome-content h2 {
    font-size: 24px;
  }

  .quick-grid {
    grid-template-columns: 1fr;
  }

  .topbar p {
    display: none;
  }
}

@media (max-width: 480px) {
  .topbar h1 {
    font-size: 18px;
  }

  .welcome-card {
    border-radius: 20px;
    padding: 23px;
  }

  .welcome-content h2 {
    font-size: 21px;
  }

  .welcome-content p {
    font-size: 12px;
  }

  .welcome-actions {
    flex-direction: column;
  }

  .btn-primary,
  .btn-secondary {
    width: 100%;
    justify-content: center;
  }

  .quick-card {
    padding: 16px;
  }

  .info-card {
    padding: 17px;
  }
}
</style>
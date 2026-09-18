<template>
  <div class="dashboard-content">
    <!-- BANNER SAPAAN PENGGUNA -->
    <div class="welcome-card">
      <div class="welcome-text">
        <h1>Selamat Datang, Pengguna! 👋</h1>
        <p>Kelola peminjaman fasilitas sekolah, ruangan, dan ajukan laporan kendala dengan mudah di SchoolCare.</p>
      </div>
      <div class="welcome-badge">
        <i class="fa-solid fa-shield-halved"></i>
        <span>Panel Aktif</span>
      </div>
    </div>

    <!-- KARTU STATISTIK -->
    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-icon blue">
          <i class="fa-solid fa-boxes-stacked"></i>
        </div>
        <div class="stat-info">
          <h3>Fasilitas Tersedia</h3>
          <p>120+ Item</p>
        </div>
      </div>

      <div class="stat-card">
        <div class="stat-icon purple">
          <i class="fa-solid fa-door-open"></i>
        </div>
        <div class="stat-info">
          <h3>Ruangan Sekolah</h3>
          <p>25 Ruangan</p>
        </div>
      </div>

      <div class="stat-card">
        <div class="stat-icon orange">
          <i class="fa-solid fa-file-circle-check"></i>
        </div>
        <div class="stat-info">
          <h3>Pengajuan Saya</h3>
          <p>2 Diproses</p>
        </div>
      </div>

      <div class="stat-card">
        <div class="stat-icon red">
          <i class="fa-solid fa-triangle-exclamation"></i>
        </div>
        <div class="stat-info">
          <h3>Laporan Kendala</h3>
          <p>0 Selesai</p>
        </div>
      </div>
    </div>

    <!-- AKSI CEPAT -->
    <div class="section-container">
      <h2>Aksi Cepat</h2>
      <div class="action-grid">
        <router-link to="/pengguna/pengajuan" class="action-card">
          <div class="action-icon">
            <i class="fa-solid fa-circle-plus"></i>
          </div>
          <div class="action-detail">
            <h4>Buat Pengajuan Baru</h4>
            <p>Pinjam ruangan atau fasilitas sekolah dengan cepat</p>
          </div>
          <i class="fa-solid fa-chevron-right arrow"></i>
        </router-link>

        <router-link to="/pengguna/laporan" class="action-card">
          <div class="action-icon red-bg">
            <i class="fa-solid fa-bullhorn"></i>
          </div>
          <div class="action-detail">
            <h4>Laporkan Kerusakan</h4>
            <p>Laporkan fasilitas atau ruangan yang mengalami kendala</p>
          </div>
          <i class="fa-solid fa-chevron-right arrow"></i>
        </router-link>
      </div>
    </div>
  </div>
</template>

<style scoped>
.dashboard-content {
  display: flex;
  flex-direction: column;
  gap: 28px;
}
.welcome-card {
  background: linear-gradient(135deg, #2563eb, #1d4ed8);
  color: white;
  border-radius: 20px;
  padding: 32px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  box-shadow: 0 10px 25px rgba(37, 99, 235, 0.2);
}
.welcome-text h1 { margin: 0 0 8px 0; font-size: 24px; font-weight: 800; }
.welcome-text p { margin: 0; opacity: 0.9; font-size: 14px; max-width: 600px; }
.welcome-badge { background: rgba(255, 255, 255, 0.2); padding: 8px 16px; border-radius: 50px; display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 600; backdrop-filter: blur(5px); }
.stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; }
.stat-card { background: white; padding: 20px; border-radius: 16px; border: 1px solid #e2e8f0; display: flex; align-items: center; gap: 16px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02); }
.stat-icon { width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; }
.stat-icon.blue { background: #eff6ff; color: #2563eb; }
.stat-icon.purple { background: #f5f3ff; color: #7c3aed; }
.stat-icon.orange { background: #fff7ed; color: #c2410c; }
.stat-icon.red { background: #fef2f2; color: #dc2626; }
.stat-info h3 { margin: 0 0 4px 0; font-size: 13px; color: #64748b; font-weight: 600; }
.stat-info p { margin: 0; font-size: 18px; font-weight: 800; color: #0f172a; }
.section-container h2 { font-size: 18px; font-weight: 700; color: #0f172a; margin-bottom: 16px; }
.action-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; }
.action-card { background: white; padding: 20px; border-radius: 16px; border: 1px solid #e2e8f0; display: flex; align-items: center; gap: 16px; text-decoration: none; color: inherit; transition: all 0.2s ease; }
.action-card:hover { border-color: #2563eb; transform: translateY(-3px); }
.action-icon { width: 48px; height: 48px; border-radius: 12px; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0; }
.action-icon.red-bg { background: #fef2f2; color: #dc2626; }
.action-detail { flex: 1; }
.action-detail h4 { margin: 0 0 4px 0; font-size: 14px; font-weight: 700; color: #0f172a; }
.action-detail p { margin: 0; font-size: 12px; color: #64748b; }
.arrow { color: #cbd5e1; font-size: 14px; }
</style>
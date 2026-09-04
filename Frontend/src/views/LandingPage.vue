<template>
  <div class="landing-container">
    <!-- Background Glow Ornaments -->
    <div class="bg-glow-blob blob-1"></div>
    <div class="bg-glow-blob blob-2"></div>

    <!-- Navbar -->
    <nav class="landing-nav">
      <div class="nav-brand">
        <div class="brand-logo">🏫</div>
        <span>School<strong class="text-primary">Care</strong></span>
      </div>
      <div class="nav-links">
        <a href="#fitur" @click.prevent="scrollToSection('fitur')">Fitur Utama</a>
        <a href="#statistik" @click.prevent="scrollToSection('statistik')">Statistik</a>
        <a href="#layanan" @click.prevent="scrollToSection('layanan')">Layanan</a>
      </div>
      <div class="nav-actions">
        <button class="btn-login" @click="handleLoginAction">
          <span>{{ isLoggedIn ? 'Buka Dashboard 🚀' : 'Masuk / Login Admin' }}</span>
          <span class="login-icon">→</span>
        </button>
      </div>
    </nav>

    <!-- Hero Section -->
    <header class="hero-section">
      <div class="hero-content">
        <div class="hero-badge">
          <span class="pulse-dot"></span>
          <span>✨ Solusi Modern Manajemen Aset Sekolah</span>
        </div>
        <h1>Kelola Fasilitas & Barang Sekolah Lebih <span class="text-gradient">Cerdas & Efisien</span></h1>
        <p>Platform terintegrasi untuk pengajuan peminjaman alat, pengelolaan ruangan, pelaporan kerusakan, hingga pengadaan barang baru dalam satu genggaman interaktif.</p>
        <div class="hero-buttons">
          <button class="btn-primary" @click="handleNavigate('fasilitas')">
            <span>📦 Fasilitas</span>
          </button>
          <button class="btn-outline" @click="handleNavigate('laporan')">
            <span>🚨 Laporkan Kerusakan</span>
          </button>
        </div>
      </div>

      <!-- Hero Visual Card Preview -->
      <div class="hero-preview-card">
        <div class="preview-header">
          <div class="dots-group">
            <div class="dot red"></div>
            <div class="dot yellow"></div>
            <div class="dot green"></div>
          </div>
          <div class="preview-url-box">
            <span class="lock-icon">🔒</span>
            <span class="preview-url">schoolcare.app/dashboard</span>
          </div>
        </div>
        <div class="preview-body">
          <div class="mini-stat-row">
            <div class="mini-box">
              <span class="mini-icon blue-bg">📦</span>
              <div>
                <small>Total Fasilitas</small>
                <h4>142 Unit</h4>
              </div>
            </div>
            <div class="mini-box">
              <span class="mini-icon purple-bg">🏫</span>
              <div>
                <small>Ruangan Aktif</small>
                <h4>28 Ruang</h4>
              </div>
            </div>
          </div>
          <div class="preview-banner-box">
            <div class="banner-info">
              <h5>Peminjaman Disetujui ⚡</h5>
              <p>Proyektor Epson Lab 1 siap digunakan hari ini.</p>
            </div>
            <span class="badge-active">Live System</span>
          </div>
        </div>
      </div>
    </header>

    <!-- Features Section -->
    <section id="fitur" class="features-section">
      <div class="section-title">
        <h2>Semua Kebutuhan Inventaris <span class="text-gradient">Dalam Satu Tempat</span></h2>
        <p>Akses berbagai fitur esensial untuk mendukung kegiatan belajar mengajar dan operasional sekolah secara instan.</p>
      </div>

      <div class="feature-grid">
        <div class="feature-card" @click="handleNavigate('kategori')">
          <div class="feature-icon blue">📦</div>
          <h3>Kategori Fasilitas</h3>
          <p>Jelajahi berbagai kategori fasilitas yang tersedia di sekolah.</p>
          <span class="link-arrow">Jelajahi Modul <span class="arrow-symbol">→</span></span>
        </div>

        <div class="feature-card" @click="handleNavigate('ruangan')">
          <div class="feature-icon purple">🏫</div>
          <h3>Manajemen Ruangan</h3>
          <p>Cek ketersediaan ruang kelas, lab komputer, dan aula sekolah secara real-time.</p>
          <span class="link-arrow">Jelajahi Modul <span class="arrow-symbol">→</span></span>
        </div>

        <div class="feature-card" @click="handleNavigate('maintenance')">
          <div class="feature-icon orange">🔧</div>
          <h3>Maintenance & Perbaikan</h3>
          <p>Laporkan fasilitas rusak dan pantau status perbaikan oleh tim teknisi sekolah.</p>
          <span class="link-arrow">Jelajahi Modul <span class="arrow-symbol">→</span></span>
        </div>

        <div class="feature-card" @click="handleNavigate('pengajuan')">
          <div class="feature-icon green">🛍️</div>
          <h3>Pengajuan Barang Baru</h3>
          <p>Ajukan kebutuhan inventaris atau alat pendukung pembelajaran baru dengan estimasi biaya.</p>
          <span class="link-arrow">Jelajahi Modul <span class="arrow-symbol">→</span></span>
        </div>
      </div>
    </section>

    <!-- Statistics Section -->
    <section id="statistik" class="stats-section">
      <div class="stat-box-item">
        <h2>150+</h2>
        <p>Fasilitas Sekolah Terdaftar</p>
      </div>
      <div class="stat-box-item">
        <h2>98%</h2>
        <p>Tingkat Kepuasan Layanan</p>
      </div>
      <div class="stat-box-item">
        <h2>24/7</h2>
        <p>Sistem Pemantauan Aset</p>
      </div>
      <div class="stat-box-item">
        <h2>0</h2>
        <p>Kehilangan Tanpa Lacak</p>
      </div>
    </section>

    <!-- Services / Layanan Section -->
    <section id="layanan" class="services-section">
      <div class="section-title">
        <h2>Bagaimana Layanan <span class="text-gradient">SchoolCare</span> Bekerja?</h2>
        <p>Prosedur pengajuan fasilitas dan pelaporan inventaris sekolah yang cepat dan transparan.</p>
      </div>

      <div class="service-grid-3">
        <div class="feature-card" style="cursor: default;">
          <div class="feature-icon blue">1️⃣</div>
          <h3>Pilih & Ajukan</h3>
          <p>Cari fasilitas atau ruangan yang ingin digunakan, lalu isi formulir pengajuan secara online.</p>
        </div>
        <div class="feature-card" style="cursor: default;">
          <div class="feature-icon purple">2️⃣</div>
          <h3>Verifikasi Admin</h3>
          <p>Tim sarpras atau admin sekolah akan memeriksa ketersediaan dan menyetujui peminjaman.</p>
        </div>
        <div class="feature-card" style="cursor: default;">
          <div class="feature-icon green">3️⃣</div>
          <h3>Siap Digunakan</h3>
          <p>Fasilitas atau ruangan siap dipakai sesuai jadwal yang telah dikonfirmasi oleh sistem.</p>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer class="landing-footer">
      <div class="footer-brand">
        <span>🏫 SchoolCare System © 2026</span>
        <p>Mendukung efisiensi operasional pendidikan masa kini dengan teknologi modern.</p>
      </div>
    </footer>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const isLoggedIn = ref(false)

// Cek status login saat halaman dimuat
onMounted(() => {
  const statusLogin = localStorage.getItem('isLoggedIn')
  if (statusLogin === 'true') {
    isLoggedIn.value = true
  }
})

// Fungsi aksi tombol login / dashboard (Diperbarui)
const handleLoginAction = () => {
  if (isLoggedIn.value) {
    // Jika sudah login, langsung ke halaman admin/dashboard
    router.push('/admin')
  } else {
    // Jika belum login, arahkan ke halaman login
    router.push('/login')
  }
}

const handleNavigate = (pathName) => {
  router.push(`/${pathName}`)
}

const scrollToSection = (sectionId) => {
  const element = document.getElementById(sectionId)
  if (element) {
    element.scrollIntoView({ behavior: 'smooth' })
  }
}
</script>

<style scoped>
html {
  scroll-behavior: smooth;
}

.landing-container {
  width: 100%;
  box-sizing: border-box;
  font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
  color: #0f172a;
  background: #f8fafc;
  padding: 0 24px;
  position: relative;
  overflow-x: hidden;
}

.bg-glow-blob {
  position: absolute;
  width: 450px;
  height: 450px;
  border-radius: 50%;
  filter: blur(80px);
  z-index: 0;
  opacity: 0.15;
  pointer-events: none;
}
.blob-1 { top: -50px; left: -100px; background: #2563eb; }
.blob-2 { top: 40%; right: -150px; background: #7c3aed; }

/* Navbar */
.landing-nav {
  max-width: 1200px;
  margin: 0 auto;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 28px 0;
  position: relative;
  z-index: 10;
}

.nav-brand {
  display: flex;
  align-items: center;
  gap: 12px;
  font-size: 1.25rem;
  font-weight: 800;
  letter-spacing: -0.02em;
}

.brand-logo {
  background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
  padding: 10px;
  border-radius: 14px;
  font-size: 1.3rem;
  box-shadow: 0 4px 12px rgba(37, 99, 235, 0.1);
}

.text-primary { color: #2563eb; }

.nav-links {
  display: flex;
  gap: 36px;
}

.nav-links a {
  text-decoration: none;
  color: #64748b;
  font-weight: 600;
  font-size: 0.95rem;
  transition: color 0.2s ease;
  cursor: pointer;
}

.nav-links a:hover {
  color: #2563eb;
}

.btn-login {
  background: white;
  border: 1px solid #e2e8f0;
  padding: 11px 22px;
  border-radius: 12px;
  font-weight: 700;
  cursor: pointer;
  color: #1e293b;
  display: flex;
  align-items: center;
  gap: 8px;
  box-shadow: 0 2px 6px rgba(15, 23, 42, 0.03);
  transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
}

.btn-login:hover {
  border-color: #2563eb;
  color: #2563eb;
  transform: translateY(-2px);
  box-shadow: 0 6px 16px rgba(37, 99, 235, 0.12);
}

.login-icon {
  transition: transform 0.2s;
}
.btn-login:hover .login-icon {
  transform: translateX(3px);
}

/* Hero Section */
.hero-section {
  max-width: 1200px;
  margin: 40px auto 90px auto;
  display: grid;
  grid-template-columns: 1.1fr 0.9fr;
  gap: 50px;
  align-items: center;
  position: relative;
  z-index: 10;
}

.hero-content {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
}

.hero-badge {
  background: white;
  border: 1px solid #bfdbfe;
  padding: 8px 16px;
  border-radius: 30px;
  color: #2563eb;
  font-size: 0.85rem;
  font-weight: 700;
  margin-bottom: 24px;
  display: flex;
  align-items: center;
  gap: 8px;
  box-shadow: 0 4px 12px rgba(37, 99, 235, 0.06);
}

.pulse-dot {
  width: 8px;
  height: 8px;
  background-color: #22c55e;
  border-radius: 50%;
  animation: pulse 2s infinite;
}

@keyframes pulse {
  0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7); }
  70% { transform: scale(1); box-shadow: 0 0 0 8px rgba(34, 197, 94, 0); }
  100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(34, 197, 94, 0); }
}

.hero-content h1 {
  font-size: 3.2rem;
  font-weight: 800;
  line-height: 1.15;
  letter-spacing: -0.03em;
  margin: 0 0 20px 0;
  color: #0f172a;
}

.text-gradient {
  background: linear-gradient(135deg, #2563eb 0%, #7c3aed 100%);
  background-clip: text;
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}

.hero-content p {
  color: #64748b;
  font-size: 1.1rem;
  line-height: 1.7;
  margin: 0 0 35px 0;
}

.hero-buttons {
  display: flex;
  gap: 16px;
}

.btn-primary {
  background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
  color: white;
  border: none;
  padding: 15px 28px;
  border-radius: 14px;
  font-weight: 700;
  cursor: pointer;
  box-shadow: 0 8px 20px rgba(37, 99, 235, 0.35);
  transition: all 0.25s ease;
}

.btn-primary:hover {
  transform: translateY(-3px);
  box-shadow: 0 12px 28px rgba(37, 99, 235, 0.45);
}

.btn-outline {
  background: white;
  color: #334155;
  border: 1px solid #cbd5e1;
  padding: 15px 28px;
  border-radius: 14px;
  font-weight: 700;
  cursor: pointer;
  box-shadow: 0 2px 6px rgba(15, 23, 42, 0.02);
  transition: all 0.25s ease;
}

.btn-outline:hover {
  border-color: #94a3b8;
  background: #f8fafc;
  transform: translateY(-3px);
}

/* Hero Preview Card Styling */
.hero-preview-card {
  background: white;
  border-radius: 24px;
  border: 1px solid #e2e8f0;
  box-shadow: 0 24px 50px rgba(15, 23, 42, 0.1);
  overflow: hidden;
  transition: transform 0.3s ease;
}

.hero-preview-card:hover {
  transform: translateY(-5px);
}

.preview-header {
  background: #f8fafc;
  padding: 14px 20px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  border-bottom: 1px solid #e2e8f0;
}

.dots-group { display: flex; gap: 6px; }
.dot { width: 10px; height: 10px; border-radius: 50%; }
.dot.red { background: #ef4444; }
.dot.yellow { background: #f59e0b; }
.dot.green { background: #22c55e; }

.preview-url-box {
  background: #e2e8f0;
  padding: 4px 12px;
  border-radius: 20px;
  display: flex;
  align-items: center;
  gap: 6px;
}

.lock-icon { font-size: 0.7rem; }
.preview-url { font-size: 0.75rem; color: #475569; font-weight: 600; }

.preview-body {
  padding: 24px;
  display: flex;
  flex-direction: column;
  gap: 16px;
  background: #ffffff;
}

.mini-stat-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
.mini-box {
  background: #f8fafc;
  border: 1px solid #f1f5f9;
  padding: 16px;
  border-radius: 16px;
  display: flex;
  align-items: center;
  gap: 14px;
}
.mini-icon {
  width: 42px;
  height: 42px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.2rem;
}
.blue-bg { background: #eff6ff; }
.purple-bg { background: #f5f3ff; }

.mini-box small { color: #64748b; font-size: 0.75rem; font-weight: 600; }
.mini-box h4 { color: #0f172a; font-size: 1.15rem; margin: 2px 0 0 0; font-weight: 800; }

.preview-banner-box {
  background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
  border: 1px solid #bfdbfe;
  padding: 18px;
  border-radius: 16px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.banner-info h5 { margin: 0 0 4px 0; color: #1e3a8a; font-size: 1rem; font-weight: 700; }
.banner-info p { margin: 0; color: #3b82f6; font-size: 0.85rem; font-weight: 500; }
.badge-active { background: #2563eb; color: white; padding: 6px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; }

/* Features Section */
.features-section {
  max-width: 1200px;
  margin: 0 auto 90px auto;
  text-align: center;
  position: relative;
  z-index: 10;
}

.section-title h2 {
  font-size: 2.4rem;
  font-weight: 800;
  color: #0f172a;
  margin-bottom: 12px;
}

.section-title p { color: #64748b; font-size: 1.05rem; margin-bottom: 50px; }

.feature-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px; }
.feature-card {
  background: white;
  padding: 28px;
  border-radius: 20px;
  border: 1px solid #e2e8f0;
  text-align: left;
  cursor: pointer;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  box-shadow: 0 4px 16px rgba(15, 23, 42, 0.03);
  display: flex;
  flex-direction: column;
}

.feature-card:hover {
  transform: translateY(-8px);
  border-color: #bfdbfe;
  box-shadow: 0 20px 35px rgba(37, 99, 235, 0.1);
}

.feature-icon {
  width: 54px;
  height: 54px;
  border-radius: 14px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.5rem;
  margin-bottom: 20px;
}
.feature-icon.blue { background: #eff6ff; }
.feature-icon.purple { background: #f5f3ff; }
.feature-icon.orange { background: #fff7ed; }
.feature-icon.green { background: #f0fdf4; }

.feature-card h3 { font-size: 1.15rem; font-weight: 700; color: #0f172a; margin-bottom: 10px; }
.feature-card p { color: #64748b; font-size: 0.9rem; line-height: 1.6; margin-bottom: 24px; flex-grow: 1; }

.link-arrow { color: #2563eb; font-weight: 700; font-size: 0.9rem; display: flex; align-items: center; gap: 6px; }
.arrow-symbol { transition: transform 0.2s; }
.feature-card:hover .arrow-symbol { transform: translateX(4px); }

/* Statistics Section */
.stats-section {
  max-width: 1200px;
  margin: 0 auto 90px auto;
  background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
  border-radius: 24px;
  padding: 50px 40px;
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 24px;
  text-align: center;
  color: white;
}

.stat-box-item h2 {
  font-size: 2.8rem;
  font-weight: 800;
  margin-bottom: 8px;
  background: linear-gradient(135deg, #60a5fa 0%, #38bdf8 100%);
  background-clip: text;
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}

.stat-box-item p { color: #94a3b8; font-size: 0.95rem; margin: 0; font-weight: 500; }

/* Services Section */
.services-section {
  max-width: 1200px;
  margin: 0 auto 90px auto;
  text-align: center;
  position: relative;
  z-index: 10;
}

.service-grid-3 {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 24px;
  text-align: left;
}

/* Footer */
.landing-footer {
  max-width: 1200px;
  margin: 0 auto 40px auto;
  border-top: 1px solid #e2e8f0;
  padding-top: 35px;
  text-align: center;
  color: #64748b;
  font-size: 0.9rem;
}
.footer-brand span { font-weight: 700; color: #0f172a; font-size: 1rem; }
.footer-brand p { margin: 8px 0 0 0; }
</style>
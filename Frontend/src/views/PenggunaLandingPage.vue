<template>
  <div class="user-landing">

    <!-- ==================== BACKGROUND GLOW ==================== -->
    <div class="bg-glow glow-blue"></div>
    <div class="bg-glow glow-purple"></div>

    <!-- ==================== NAVBAR ==================== -->
    <nav class="landing-nav">
      <div class="nav-brand">
        <div class="brand-logo">🏫</div>

        <span>
          School<strong>Care</strong>
        </span>
      </div>

      <div class="nav-links">
        <a
          href="#fitur"
          @click.prevent="scrollToSection('fitur')"
        >
          Fitur
        </a>

        <a
          href="#cara-kerja"
          @click.prevent="scrollToSection('cara-kerja')"
        >
          Cara Kerja
        </a>

        <a
          href="#layanan"
          @click.prevent="scrollToSection('layanan')"
        >
          Layanan
        </a>
      </div>

      <div class="nav-action">
        <button
          class="btn-login"
          type="button"
          @click="goToLogin"
        >
          <span>Masuk</span>
          <span class="login-arrow">→</span>
        </button>
      </div>
    </nav>


    <!-- ==================== HERO ==================== -->
    <header class="hero-section">

      <div class="hero-content">

        <div class="hero-badge">
          <span class="pulse-dot"></span>
          <span>✨ Selamat datang di SchoolCare</span>
        </div>

        <h1>
          Gunakan Fasilitas Sekolah
          Jadi Lebih
          <span class="text-gradient">
            Mudah & Praktis
          </span>
        </h1>

        <p>
          Temukan fasilitas dan ruangan sekolah, ajukan peminjaman,
          serta laporkan kerusakan dengan mudah melalui satu platform.
        </p>

        <div class="hero-buttons">

          <button
            class="btn-primary"
            type="button"
            @click="goToLogin"
          >
            <span>📦 Lihat Fasilitas</span>
            <span>→</span>
          </button>

          <button
            class="btn-outline"
            type="button"
            @click="goToLogin"
          >
            <span>📋 Ajukan Peminjaman</span>
          </button>

        </div>

        <div class="hero-note">
          <span>✓</span>
          <span>Mudah digunakan</span>

          <span>✓</span>
          <span>Proses transparan</span>

          <span>✓</span>
          <span>Terintegrasi</span>
        </div>

      </div>


      <!-- ==================== HERO PREVIEW ==================== -->
      <div class="hero-preview-wrapper">

        <div class="floating-card floating-top">
          <span class="floating-icon">📦</span>

          <div>
            <small>Fasilitas tersedia</small>
            <strong>Siap digunakan</strong>
          </div>
        </div>

        <div class="hero-preview-card">

          <div class="preview-header">

            <div class="dots-group">
              <span class="dot red"></span>
              <span class="dot yellow"></span>
              <span class="dot green"></span>
            </div>

            <div class="preview-url">
              🔒 schoolcare.app
            </div>

          </div>

          <div class="preview-body">

            <div class="preview-welcome">
              <div>
                <small>Dashboard Pengguna</small>
                <h3>Halo! 👋</h3>
              </div>

              <div class="user-avatar">
                👤
              </div>
            </div>


            <div class="preview-question">
              <span>Butuh fasilitas sekolah?</span>
              <strong>
                Temukan yang kamu butuhkan.
              </strong>
            </div>


            <div class="preview-menu">

              <div class="preview-menu-item">
                <div class="preview-menu-icon blue">
                  📦
                </div>

                <div>
                  <small>Fasilitas</small>
                  <strong>Lihat Fasilitas</strong>
                </div>
              </div>


              <div class="preview-menu-item">
                <div class="preview-menu-icon purple">
                  🏫
                </div>

                <div>
                  <small>Ruangan</small>
                  <strong>Cek Ruangan</strong>
                </div>
              </div>


              <div class="preview-menu-item">
                <div class="preview-menu-icon green">
                  📋
                </div>

                <div>
                  <small>Peminjaman</small>
                  <strong>Ajukan Sekarang</strong>
                </div>
              </div>


              <div class="preview-menu-item">
                <div class="preview-menu-icon orange">
                  🚨
                </div>

                <div>
                  <small>Laporan</small>
                  <strong>Laporkan Masalah</strong>
                </div>
              </div>

            </div>


            <div class="preview-status">

              <div class="status-icon">
                ✓
              </div>

              <div>
                <small>Status Pengajuan</small>
                <strong>Pengajuan sedang diproses</strong>
              </div>

              <span class="status-badge">
                Diproses
              </span>

            </div>

          </div>

        </div>


        <div class="floating-card floating-bottom">

          <div class="check-circle">
            ✓
          </div>

          <div>
            <small>Pengajuan</small>
            <strong>Berhasil dikirim</strong>
          </div>

        </div>

      </div>

    </header>


    <!-- ==================== FEATURES ==================== -->
    <section
      id="fitur"
      class="features-section"
    >

      <div class="section-title">

        <div class="section-badge">
          FITUR SCHOOLCARE
        </div>

        <h2>
          Semua kebutuhan fasilitas
          <span class="text-gradient">
            dalam satu tempat
          </span>
        </h2>

        <p>
          Gunakan berbagai layanan SchoolCare untuk membantu
          kegiatan belajar dan aktivitas sekolah.
        </p>

      </div>


      <div class="feature-grid">

        <!-- FASILITAS -->
        <div
          class="feature-card"
          @click="goToLogin"
        >

          <div class="feature-icon blue">
            📦
          </div>

          <div class="feature-number">
            01
          </div>

          <h3>
            Lihat Fasilitas
          </h3>

          <p>
            Temukan berbagai fasilitas sekolah beserta informasi
            kondisi dan ketersediaannya.
          </p>

          <span class="feature-link">
            Lihat fasilitas
            <span>→</span>
          </span>

        </div>


        <!-- RUANGAN -->
        <div
          class="feature-card"
          @click="goToLogin"
        >

          <div class="feature-icon purple">
            🏫
          </div>

          <div class="feature-number">
            02
          </div>

          <h3>
            Cek Ruangan
          </h3>

          <p>
            Cari ruangan yang tersedia untuk mendukung kegiatan
            belajar maupun kegiatan sekolah lainnya.
          </p>

          <span class="feature-link">
            Lihat ruangan
            <span>→</span>
          </span>

        </div>


        <!-- PEMINJAMAN -->
        <div
          class="feature-card"
          @click="goToLogin"
        >

          <div class="feature-icon green">
            📋
          </div>

          <div class="feature-number">
            03
          </div>

          <h3>
            Ajukan Peminjaman
          </h3>

          <p>
            Ajukan peminjaman fasilitas atau ruangan secara
            online tanpa proses yang rumit.
          </p>

          <span class="feature-link">
            Buat pengajuan
            <span>→</span>
          </span>

        </div>


        <!-- LAPORAN -->
        <div
          class="feature-card"
          @click="goToLogin"
        >

          <div class="feature-icon orange">
            🚨
          </div>

          <div class="feature-number">
            04
          </div>

          <h3>
            Lapor Kerusakan
          </h3>

          <p>
            Laporkan fasilitas yang mengalami kerusakan agar
            dapat segera ditindaklanjuti.
          </p>

          <span class="feature-link">
            Buat laporan
            <span>→</span>
          </span>

        </div>

      </div>

    </section>


    <!-- ==================== CARA KERJA ==================== -->
    <section
      id="cara-kerja"
      class="workflow-section"
    >

      <div class="section-title">

        <div class="section-badge">
          CARA KERJA
        </div>

        <h2>
          Menggunakan SchoolCare
          <span class="text-gradient">
            semudah itu
          </span>
        </h2>

        <p>
          Tidak perlu proses yang panjang. Semua bisa dilakukan
          secara online dan lebih praktis.
        </p>

      </div>


      <div class="workflow-grid">

        <div class="workflow-line"></div>


        <!-- STEP 1 -->
        <div class="workflow-item">

          <div class="workflow-number">
            01
          </div>

          <div class="workflow-icon">
            🔎
          </div>

          <h3>
            Cari
          </h3>

          <p>
            Cari fasilitas atau ruangan yang kamu butuhkan.
          </p>

        </div>


        <!-- STEP 2 -->
        <div class="workflow-item">

          <div class="workflow-number">
            02
          </div>

          <div class="workflow-icon purple-icon">
            📝
          </div>

          <h3>
            Ajukan
          </h3>

          <p>
            Isi data peminjaman sesuai kebutuhan.
          </p>

        </div>


        <!-- STEP 3 -->
        <div class="workflow-item">

          <div class="workflow-number">
            03
          </div>

          <div class="workflow-icon green-icon">
            🔔
          </div>

          <h3>
            Tunggu Verifikasi
          </h3>

          <p>
            Admin akan memeriksa dan memproses pengajuanmu.
          </p>

        </div>


        <!-- STEP 4 -->
        <div class="workflow-item">

          <div class="workflow-number">
            04
          </div>

          <div class="workflow-icon orange-icon">
            ✅
          </div>

          <h3>
            Siap Digunakan
          </h3>

          <p>
            Gunakan fasilitas sesuai jadwal yang disetujui.
          </p>

        </div>

      </div>

    </section>


    <!-- ==================== SERVICES ==================== -->
    <section
      id="layanan"
      class="services-section"
    >

      <div class="services-content">

        <div class="services-text">

          <div class="section-badge">
            SATU PLATFORM
          </div>

          <h2>
            Kegiatan sekolah jadi
            <span class="text-gradient">
              lebih terorganisir.
            </span>
          </h2>

          <p>
            SchoolCare membantu siswa dan guru mengakses layanan
            fasilitas sekolah tanpa harus melalui proses manual
            yang memakan waktu.
          </p>


          <div class="service-list">

            <div class="service-list-item">
              <div class="service-check">
                ✓
              </div>

              <div>
                <strong>
                  Informasi fasilitas lebih jelas
                </strong>

                <span>
                  Lihat kondisi dan informasi fasilitas.
                </span>
              </div>
            </div>


            <div class="service-list-item">
              <div class="service-check">
                ✓
              </div>

              <div>
                <strong>
                  Pengajuan lebih praktis
                </strong>

                <span>
                  Kirim pengajuan secara online.
                </span>
              </div>
            </div>


            <div class="service-list-item">
              <div class="service-check">
                ✓
              </div>

              <div>
                <strong>
                  Status dapat dipantau
                </strong>

                <span>
                  Pantau perkembangan pengajuanmu.
                </span>
              </div>
            </div>

          </div>

        </div>


        <div class="services-card">

          <div class="services-card-header">
            <span>SchoolCare</span>

            <span class="live-dot">
              ● Online
            </span>
          </div>

          <div class="services-card-body">

            <div class="service-stat">
              <span class="service-stat-icon blue">
                📦
              </span>

              <div>
                <small>
                  Fasilitas
                </small>

                <strong>
                  Mudah ditemukan
                </strong>
              </div>
            </div>


            <div class="service-stat">
              <span class="service-stat-icon purple">
                🏫
              </span>

              <div>
                <small>
                  Ruangan
                </small>

                <strong>
                  Mudah dicek
                </strong>
              </div>
            </div>


            <div class="service-stat">
              <span class="service-stat-icon green">
                📋
              </span>

              <div>
                <small>
                  Pengajuan
                </small>

                <strong>
                  Mudah dipantau
                </strong>
              </div>
            </div>

          </div>

        </div>

      </div>

    </section>


    <!-- ==================== CTA ==================== -->
    <section class="cta-section">

      <div class="cta-glow"></div>

      <div class="cta-content">

        <div class="cta-icon">
          🏫
        </div>

        <h2>
          Siap menggunakan
          <span>SchoolCare?</span>
        </h2>

        <p>
          Masuk ke akunmu dan mulai gunakan berbagai layanan
          fasilitas sekolah dengan lebih mudah.
        </p>

        <button
          class="cta-button"
          type="button"
          @click="goToLogin"
        >
          Mulai Sekarang
          <span>→</span>
        </button>

      </div>

    </section>


    <!-- ==================== FOOTER ==================== -->
    <footer class="landing-footer">

      <div class="footer-main">

        <div class="footer-brand">

          <div class="footer-logo">
            🏫
          </div>

          <div>
            <h3>
              School<span>Care</span>
            </h3>

            <p>
              Memudahkan akses fasilitas sekolah
              dalam satu platform.
            </p>
          </div>

        </div>


        <div class="footer-links">

          <a
            href="#fitur"
            @click.prevent="scrollToSection('fitur')"
          >
            Fitur
          </a>

          <a
            href="#cara-kerja"
            @click.prevent="scrollToSection('cara-kerja')"
          >
            Cara Kerja
          </a>

          <a
            href="#layanan"
            @click.prevent="scrollToSection('layanan')"
          >
            Layanan
          </a>

          <button
            type="button"
            @click="goToLogin"
          >
            Login
          </button>

        </div>

      </div>


      <div class="footer-bottom">

        <span>
          SchoolCare System © 2026
        </span>

        <span>
          Dibuat untuk mendukung kegiatan sekolah 💙
        </span>

      </div>

    </footer>

  </div>
</template>


<script setup>
import { useRouter } from 'vue-router'

const router = useRouter()


// ==================== LOGIN ====================

const goToLogin = () => {
  router.push('/login')
}


// ==================== SCROLL ====================

const scrollToSection = (sectionId) => {
  const element = document.getElementById(sectionId)

  if (element) {
    element.scrollIntoView({
      behavior: 'smooth'
    })
  }
}
</script>


<style scoped>

/* =====================================================
   GLOBAL
===================================================== */

.user-landing {
  width: 100%;
  min-height: 100vh;
  box-sizing: border-box;
  font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
  color: #0f172a;
  background: #f8fafc;
  padding: 0 24px;
  position: relative;
  overflow-x: hidden;
}


/* =====================================================
   BACKGROUND GLOW
===================================================== */

.bg-glow {
  position: absolute;
  width: 450px;
  height: 450px;
  border-radius: 50%;
  filter: blur(90px);
  opacity: 0.14;
  pointer-events: none;
  z-index: 0;
}

.glow-blue {
  top: -100px;
  left: -150px;
  background: #2563eb;
}

.glow-purple {
  top: 35%;
  right: -180px;
  background: #7c3aed;
}


/* =====================================================
   NAVBAR
===================================================== */

.landing-nav {
  max-width: 1200px;
  margin: 0 auto;
  padding: 28px 0;

  display: flex;
  align-items: center;
  justify-content: space-between;

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
  width: 42px;
  height: 42px;

  display: flex;
  align-items: center;
  justify-content: center;

  background: linear-gradient(
    135deg,
    #eff6ff,
    #ede9fe
  );

  border-radius: 14px;

  box-shadow:
    0 6px 18px rgba(37, 99, 235, 0.1);
}

.nav-brand strong {
  color: #2563eb;
}

.nav-links {
  display: flex;
  align-items: center;
  gap: 36px;
}

.nav-links a {
  color: #64748b;
  text-decoration: none;

  font-size: 0.94rem;
  font-weight: 600;

  transition: 0.2s ease;
}

.nav-links a:hover {
  color: #2563eb;
}

.nav-action {
  display: flex;
  align-items: center;
}

.btn-login {
  display: flex;
  align-items: center;
  gap: 9px;

  padding: 11px 20px;

  background: #ffffff;
  border: 1px solid #e2e8f0;
  border-radius: 12px;

  color: #1e293b;

  font-size: 0.9rem;
  font-weight: 700;

  cursor: pointer;

  box-shadow:
    0 3px 10px rgba(15, 23, 42, 0.04);

  transition: 0.25s ease;
}

.btn-login:hover {
  color: #2563eb;
  border-color: #bfdbfe;

  transform: translateY(-2px);

  box-shadow:
    0 8px 20px rgba(37, 99, 235, 0.1);
}

.login-arrow {
  transition: 0.2s ease;
}

.btn-login:hover .login-arrow {
  transform: translateX(4px);
}


/* =====================================================
   HERO
===================================================== */

.hero-section {
  max-width: 1200px;

  margin: 50px auto 110px;

  display: grid;
  grid-template-columns: 1.05fr 0.95fr;

  gap: 70px;

  align-items: center;

  position: relative;
  z-index: 5;
}

.hero-content {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
}

.hero-badge {
  display: inline-flex;
  align-items: center;
  gap: 9px;

  padding: 8px 15px;

  background: #ffffff;
  border: 1px solid #bfdbfe;

  border-radius: 30px;

  color: #2563eb;

  font-size: 0.82rem;
  font-weight: 700;

  margin-bottom: 24px;

  box-shadow:
    0 5px 15px rgba(37, 99, 235, 0.06);
}

.pulse-dot {
  width: 8px;
  height: 8px;

  background: #22c55e;

  border-radius: 50%;

  animation: pulse 2s infinite;
}

@keyframes pulse {

  0% {
    transform: scale(0.95);
    box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.5);
  }

  70% {
    transform: scale(1);
    box-shadow: 0 0 0 8px rgba(34, 197, 94, 0);
  }

  100% {
    transform: scale(0.95);
    box-shadow: 0 0 0 0 rgba(34, 197, 94, 0);
  }

}

.hero-content h1 {
  max-width: 680px;

  margin: 0 0 22px;

  color: #0f172a;

  font-size: 3.3rem;
  line-height: 1.12;

  font-weight: 800;

  letter-spacing: -0.04em;
}

.text-gradient {
  background: linear-gradient(
    135deg,
    #2563eb 0%,
    #7c3aed 100%
  );

  background-clip: text;
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}

.hero-content > p {
  max-width: 630px;

  margin: 0 0 32px;

  color: #64748b;

  font-size: 1.05rem;
  line-height: 1.75;
}

.hero-buttons {
  display: flex;
  gap: 13px;
  flex-wrap: wrap;
}

.btn-primary {
  display: flex;
  align-items: center;
  gap: 10px;

  padding: 14px 23px;

  background: linear-gradient(
    135deg,
    #2563eb,
    #1d4ed8
  );

  border: none;
  border-radius: 13px;

  color: white;

  font-size: 0.9rem;
  font-weight: 700;

  cursor: pointer;

  box-shadow:
    0 9px 22px rgba(37, 99, 235, 0.3);

  transition: 0.25s ease;
}

.btn-primary:hover {
  transform: translateY(-3px);

  box-shadow:
    0 13px 28px rgba(37, 99, 235, 0.38);
}

.btn-outline {
  padding: 14px 23px;

  background: white;

  border: 1px solid #cbd5e1;
  border-radius: 13px;

  color: #334155;

  font-size: 0.9rem;
  font-weight: 700;

  cursor: pointer;

  transition: 0.25s ease;
}

.btn-outline:hover {
  border-color: #94a3b8;
  background: #f8fafc;

  transform: translateY(-3px);
}

.hero-note {
  display: flex;
  align-items: center;
  flex-wrap: wrap;
  gap: 8px;

  margin-top: 22px;

  color: #64748b;

  font-size: 0.78rem;
  font-weight: 600;
}

.hero-note span:nth-child(odd) {
  color: #22c55e;
  font-weight: 800;
}


/* =====================================================
   HERO PREVIEW
===================================================== */

.hero-preview-wrapper {
  position: relative;
  min-height: 470px;

  display: flex;
  align-items: center;
  justify-content: center;
}

.hero-preview-card {
  width: 100%;
  max-width: 510px;

  background: white;

  border: 1px solid #e2e8f0;
  border-radius: 24px;

  overflow: hidden;

  box-shadow:
    0 30px 65px rgba(15, 23, 42, 0.12);

  position: relative;
  z-index: 2;

  transition: 0.3s ease;
}

.hero-preview-card:hover {
  transform: translateY(-5px);
}

.preview-header {
  padding: 14px 18px;

  background: #f8fafc;

  border-bottom: 1px solid #e2e8f0;

  display: flex;
  align-items: center;
  justify-content: space-between;
}

.dots-group {
  display: flex;
  gap: 6px;
}

.dot {
  width: 10px;
  height: 10px;
  border-radius: 50%;
}

.dot.red {
  background: #ef4444;
}

.dot.yellow {
  background: #f59e0b;
}

.dot.green {
  background: #22c55e;
}

.preview-url {
  padding: 5px 12px;

  background: #e2e8f0;

  border-radius: 20px;

  color: #64748b;

  font-size: 0.7rem;
  font-weight: 600;
}

.preview-body {
  padding: 24px;

  display: flex;
  flex-direction: column;
  gap: 18px;
}

.preview-welcome {
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.preview-welcome small {
  color: #94a3b8;
  font-size: 0.72rem;
  font-weight: 600;
}

.preview-welcome h3 {
  margin: 3px 0 0;

  color: #0f172a;

  font-size: 1.25rem;
  font-weight: 800;
}

.user-avatar {
  width: 42px;
  height: 42px;

  display: flex;
  align-items: center;
  justify-content: center;

  background: #eff6ff;

  border-radius: 13px;

  font-size: 1.2rem;
}

.preview-question {
  padding: 17px;

  background: linear-gradient(
    135deg,
    #eff6ff,
    #f5f3ff
  );

  border: 1px solid #dbeafe;

  border-radius: 15px;
}

.preview-question span {
  display: block;

  color: #64748b;

  font-size: 0.72rem;
  font-weight: 600;

  margin-bottom: 4px;
}

.preview-question strong {
  color: #1e3a8a;

  font-size: 0.95rem;
}

.preview-menu {
  display: grid;
  grid-template-columns: 1fr 1fr;

  gap: 12px;
}

.preview-menu-item {
  padding: 13px;

  display: flex;
  align-items: center;
  gap: 10px;

  background: #f8fafc;

  border: 1px solid #f1f5f9;
  border-radius: 13px;
}

.preview-menu-icon {
  width: 36px;
  height: 36px;

  flex-shrink: 0;

  display: flex;
  align-items: center;
  justify-content: center;

  border-radius: 10px;
}

.preview-menu-icon.blue {
  background: #eff6ff;
}

.preview-menu-icon.purple {
  background: #f5f3ff;
}

.preview-menu-icon.green {
  background: #f0fdf4;
}

.preview-menu-icon.orange {
  background: #fff7ed;
}

.preview-menu-item small {
  display: block;

  color: #94a3b8;

  font-size: 0.62rem;
  font-weight: 600;
}

.preview-menu-item strong {
  display: block;

  margin-top: 2px;

  color: #334155;

  font-size: 0.75rem;
}

.preview-status {
  padding: 13px;

  display: flex;
  align-items: center;
  gap: 10px;

  background: #f8fafc;

  border: 1px solid #e2e8f0;
  border-radius: 13px;
}

.status-icon {
  width: 34px;
  height: 34px;

  display: flex;
  align-items: center;
  justify-content: center;

  background: #dcfce7;

  border-radius: 10px;

  color: #16a34a;

  font-weight: 800;
}

.preview-status small {
  display: block;

  color: #94a3b8;

  font-size: 0.62rem;
}

.preview-status strong {
  display: block;

  color: #334155;

  font-size: 0.72rem;
}

.status-badge {
  margin-left: auto;

  padding: 5px 8px;

  background: #fef3c7;

  color: #b45309;

  border-radius: 20px;

  font-size: 0.6rem;
  font-weight: 700;
}


/* =====================================================
   FLOATING CARD
===================================================== */

.floating-card {
  position: absolute;

  padding: 12px 15px;

  background: white;

  border: 1px solid #e2e8f0;
  border-radius: 14px;

  display: flex;
  align-items: center;
  gap: 10px;

  box-shadow:
    0 15px 35px rgba(15, 23, 42, 0.1);

  z-index: 4;

  animation: floatCard 4s ease-in-out infinite;
}

.floating-top {
  top: 32px;
  right: -10px;
}

.floating-bottom {
  bottom: 28px;
  left: -15px;
  animation-delay: 1s;
}

.floating-icon {
  width: 35px;
  height: 35px;

  display: flex;
  align-items: center;
  justify-content: center;

  background: #eff6ff;

  border-radius: 10px;
}

.check-circle {
  width: 34px;
  height: 34px;

  display: flex;
  align-items: center;
  justify-content: center;

  background: #dcfce7;

  border-radius: 50%;

  color: #16a34a;
  font-weight: 800;
}

.floating-card small {
  display: block;

  color: #94a3b8;

  font-size: 0.62rem;
}

.floating-card strong {
  display: block;

  margin-top: 2px;

  color: #334155;

  font-size: 0.72rem;
}

@keyframes floatCard {

  0%,
  100% {
    transform: translateY(0);
  }

  50% {
    transform: translateY(-8px);
  }

}


/* =====================================================
   SECTION TITLE
===================================================== */

.section-title {
  max-width: 760px;

  margin: 0 auto 50px;

  text-align: center;
}

.section-badge {
  display: inline-block;

  margin-bottom: 14px;

  color: #2563eb;

  font-size: 0.7rem;
  font-weight: 800;

  letter-spacing: 0.12em;
}

.section-title h2 {
  margin: 0 0 14px;

  color: #0f172a;

  font-size: 2.35rem;
  line-height: 1.2;

  font-weight: 800;

  letter-spacing: -0.03em;
}

.section-title p {
  margin: 0;

  color: #64748b;

  font-size: 0.98rem;
  line-height: 1.7;
}


/* =====================================================
   FEATURES
===================================================== */

.features-section {
  max-width: 1200px;

  margin: 0 auto 110px;

  position: relative;
  z-index: 5;
}

.feature-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);

  gap: 20px;
}

.feature-card {
  min-height: 300px;

  padding: 25px;

  background: white;

  border: 1px solid #e2e8f0;
  border-radius: 20px;

  display: flex;
  flex-direction: column;

  cursor: pointer;

  box-shadow:
    0 5px 18px rgba(15, 23, 42, 0.03);

  transition: 0.3s ease;

  position: relative;
  overflow: hidden;
}

.feature-card::after {
  content: '';

  position: absolute;

  width: 100px;
  height: 100px;

  top: -45px;
  right: -45px;

  border-radius: 50%;

  background: #eff6ff;

  opacity: 0;

  transition: 0.3s ease;
}

.feature-card:hover {
  transform: translateY(-7px);

  border-color: #bfdbfe;

  box-shadow:
    0 18px 35px rgba(37, 99, 235, 0.09);
}

.feature-card:hover::after {
  opacity: 1;
}

.feature-icon {
  width: 52px;
  height: 52px;

  display: flex;
  align-items: center;
  justify-content: center;

  border-radius: 14px;

  font-size: 1.4rem;

  margin-bottom: 15px;

  position: relative;
  z-index: 2;
}

.feature-icon.blue {
  background: #eff6ff;
}

.feature-icon.purple {
  background: #f5f3ff;
}

.feature-icon.green {
  background: #f0fdf4;
}

.feature-icon.orange {
  background: #fff7ed;
}

.feature-number {
  position: absolute;

  top: 25px;
  right: 23px;

  color: #cbd5e1;

  font-size: 0.7rem;
  font-weight: 800;
}

.feature-card h3 {
  margin: 0 0 9px;

  color: #0f172a;

  font-size: 1.05rem;
  font-weight: 800;
}

.feature-card p {
  margin: 0 0 22px;

  color: #64748b;

  font-size: 0.84rem;
  line-height: 1.65;

  flex-grow: 1;
}

.feature-link {
  display: flex;
  align-items: center;
  gap: 7px;

  color: #2563eb;

  font-size: 0.82rem;
  font-weight: 700;
}

.feature-link span {
  transition: 0.2s ease;
}

.feature-card:hover .feature-link span {
  transform: translateX(4px);
}


/* =====================================================
   WORKFLOW
===================================================== */

.workflow-section {
  max-width: 1200px;

  margin: 0 auto 110px;

  position: relative;
  z-index: 5;
}

.workflow-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);

  gap: 20px;

  position: relative;
}

.workflow-item {
  text-align: center;

  padding: 15px;

  position: relative;
  z-index: 2;
}

.workflow-number {
  margin-bottom: 13px;

  color: #cbd5e1;

  font-size: 0.72rem;
  font-weight: 800;
}

.workflow-icon {
  width: 65px;
  height: 65px;

  margin: 0 auto 18px;

  display: flex;
  align-items: center;
  justify-content: center;

  background: #eff6ff;

  border: 7px solid #f8fafc;

  border-radius: 20px;

  font-size: 1.5rem;

  box-shadow:
    0 0 0 1px #dbeafe;
}

.purple-icon {
  background: #f5f3ff;

  box-shadow:
    0 0 0 1px #ddd6fe;
}

.green-icon {
  background: #f0fdf4;

  box-shadow:
    0 0 0 1px #bbf7d0;
}

.orange-icon {
  background: #fff7ed;

  box-shadow:
    0 0 0 1px #fed7aa;
}

.workflow-item h3 {
  margin: 0 0 8px;

  color: #0f172a;

  font-size: 1rem;
  font-weight: 800;
}

.workflow-item p {
  max-width: 210px;

  margin: 0 auto;

  color: #64748b;

  font-size: 0.8rem;
  line-height: 1.6;
}

.workflow-line {
  position: absolute;

  top: 74px;
  left: 12%;

  width: 76%;
  height: 1px;

  background: #dbeafe;

  z-index: 1;
}


/* =====================================================
   SERVICES
===================================================== */

.services-section {
  max-width: 1200px;

  margin: 0 auto 110px;

  position: relative;
  z-index: 5;
}

.services-content {
  padding: 55px;

  background: linear-gradient(
    135deg,
    #ffffff,
    #f8faff
  );

  border: 1px solid #e2e8f0;

  border-radius: 28px;

  display: grid;
  grid-template-columns: 1fr 0.85fr;

  gap: 70px;

  align-items: center;

  box-shadow:
    0 15px 40px rgba(15, 23, 42, 0.04);
}

.services-text h2 {
  max-width: 560px;

  margin: 0 0 16px;

  color: #0f172a;

  font-size: 2.2rem;
  line-height: 1.2;

  font-weight: 800;

  letter-spacing: -0.03em;
}

.services-text > p {
  max-width: 560px;

  margin: 0 0 28px;

  color: #64748b;

  font-size: 0.92rem;
  line-height: 1.7;
}

.service-list {
  display: flex;
  flex-direction: column;
  gap: 17px;
}

.service-list-item {
  display: flex;
  align-items: flex-start;
  gap: 12px;
}

.service-check {
  width: 24px;
  height: 24px;

  flex-shrink: 0;

  display: flex;
  align-items: center;
  justify-content: center;

  background: #dcfce7;

  border-radius: 7px;

  color: #16a34a;

  font-size: 0.7rem;
  font-weight: 800;
}

.service-list-item strong {
  display: block;

  margin-bottom: 3px;

  color: #334155;

  font-size: 0.84rem;
}

.service-list-item span {
  display: block;

  color: #94a3b8;

  font-size: 0.75rem;
}

.services-card {
  padding: 20px;

  background: white;

  border: 1px solid #e2e8f0;
  border-radius: 20px;

  box-shadow:
    0 15px 35px rgba(15, 23, 42, 0.07);
}

.services-card-header {
  display: flex;
  justify-content: space-between;
  align-items: center;

  padding-bottom: 15px;

  border-bottom: 1px solid #f1f5f9;

  color: #0f172a;

  font-size: 0.82rem;
  font-weight: 800;
}

.live-dot {
  color: #16a34a;

  font-size: 0.65rem;
}

.services-card-body {
  display: flex;
  flex-direction: column;
  gap: 12px;

  padding-top: 15px;
}

.service-stat {
  padding: 13px;

  display: flex;
  align-items: center;
  gap: 12px;

  background: #f8fafc;

  border-radius: 13px;
}

.service-stat-icon {
  width: 38px;
  height: 38px;

  display: flex;
  align-items: center;
  justify-content: center;

  border-radius: 10px;
}

.service-stat-icon.blue {
  background: #eff6ff;
}

.service-stat-icon.purple {
  background: #f5f3ff;
}

.service-stat-icon.green {
  background: #f0fdf4;
}

.service-stat small {
  display: block;

  color: #94a3b8;

  font-size: 0.65rem;
}

.service-stat strong {
  display: block;

  margin-top: 2px;

  color: #334155;

  font-size: 0.78rem;
}


/* =====================================================
   CTA
===================================================== */

.cta-section {
  max-width: 1200px;

  margin: 0 auto 80px;

  padding: 65px 30px;

  background: linear-gradient(
    135deg,
    #2563eb,
    #4f46e5,
    #7c3aed
  );

  border-radius: 28px;

  color: white;

  text-align: center;

  position: relative;
  overflow: hidden;
}

.cta-glow {
  position: absolute;

  width: 350px;
  height: 350px;

  top: -220px;
  right: -100px;

  background: rgba(255, 255, 255, 0.12);

  border-radius: 50%;

  filter: blur(10px);
}

.cta-content {
  position: relative;
  z-index: 2;
}

.cta-icon {
  width: 54px;
  height: 54px;

  margin: 0 auto 18px;

  display: flex;
  align-items: center;
  justify-content: center;

  background: rgba(255, 255, 255, 0.14);

  border: 1px solid rgba(255, 255, 255, 0.2);

  border-radius: 16px;

  font-size: 1.4rem;
}

.cta-content h2 {
  margin: 0 0 13px;

  font-size: 2.15rem;
  font-weight: 800;

  letter-spacing: -0.03em;
}

.cta-content h2 span {
  color: #bfdbfe;
}

.cta-content p {
  max-width: 570px;

  margin: 0 auto 25px;

  color: #dbeafe;

  font-size: 0.92rem;
  line-height: 1.7;
}

.cta-button {
  display: inline-flex;
  align-items: center;
  gap: 9px;

  padding: 13px 23px;

  background: white;

  border: none;
  border-radius: 12px;

  color: #2563eb;

  font-size: 0.85rem;
  font-weight: 800;

  cursor: pointer;

  transition: 0.25s ease;
}

.cta-button:hover {
  transform: translateY(-3px);

  box-shadow:
    0 10px 25px rgba(15, 23, 42, 0.15);
}


/* =====================================================
   FOOTER
===================================================== */

.landing-footer {
  max-width: 1200px;

  margin: 0 auto 30px;

  padding-top: 30px;

  border-top: 1px solid #e2e8f0;

  position: relative;
  z-index: 5;
}

.footer-main {
  display: flex;
  align-items: center;
  justify-content: space-between;

  padding-bottom: 25px;
}

.footer-brand {
  display: flex;
  align-items: center;
  gap: 12px;
}

.footer-logo {
  width: 42px;
  height: 42px;

  display: flex;
  align-items: center;
  justify-content: center;

  background: #eff6ff;

  border-radius: 12px;
}

.footer-brand h3 {
  margin: 0 0 3px;

  color: #0f172a;

  font-size: 0.95rem;
}

.footer-brand h3 span {
  color: #2563eb;
}

.footer-brand p {
  margin: 0;

  color: #94a3b8;

  font-size: 0.7rem;
}

.footer-links {
  display: flex;
  align-items: center;
  gap: 24px;
}

.footer-links a,
.footer-links button {
  padding: 0;

  background: none;

  border: none;

  color: #64748b;

  font-family: inherit;

  font-size: 0.76rem;
  font-weight: 600;

  text-decoration: none;

  cursor: pointer;

  transition: 0.2s ease;
}

.footer-links a:hover,
.footer-links button:hover {
  color: #2563eb;
}

.footer-bottom {
  padding-top: 20px;

  border-top: 1px solid #f1f5f9;

  display: flex;
  justify-content: space-between;

  color: #94a3b8;

  font-size: 0.68rem;
}


/* =====================================================
   RESPONSIVE
===================================================== */

@media (max-width: 1000px) {

  .hero-section {
    grid-template-columns: 1fr;

    gap: 50px;

    text-align: center;
  }

  .hero-content {
    align-items: center;
  }

  .hero-content h1 {
    max-width: 800px;
  }

  .hero-content > p {
    max-width: 700px;
  }

  .hero-note {
    justify-content: center;
  }

  .hero-preview-wrapper {
    max-width: 600px;
    width: 100%;

    margin: 0 auto;
  }

  .feature-grid {
    grid-template-columns: repeat(2, 1fr);
  }

  .services-content {
    grid-template-columns: 1fr;

    gap: 40px;
  }

}


@media (max-width: 750px) {

  .user-landing {
    padding: 0 16px;
  }

  .landing-nav {
    padding: 20px 0;
  }

  .nav-links {
    display: none;
  }

  .hero-section {
    margin-top: 35px;
    margin-bottom: 80px;
  }

  .hero-content h1 {
    font-size: 2.45rem;
  }

  .hero-content > p {
    font-size: 0.92rem;
  }

  .hero-buttons {
    width: 100%;

    flex-direction: column;
  }

  .btn-primary,
  .btn-outline {
    width: 100%;

    justify-content: center;
  }

  .floating-top {
    right: -5px;
  }

  .floating-bottom {
    left: -5px;
  }

  .feature-grid {
    grid-template-columns: 1fr;
  }

  .section-title h2 {
    font-size: 1.9rem;
  }

  .workflow-grid {
    grid-template-columns: 1fr 1fr;

    gap: 25px;
  }

  .workflow-line {
    display: none;
  }

  .services-content {
    padding: 30px 22px;
  }

  .services-text h2 {
    font-size: 1.85rem;
  }

  .cta-content h2 {
    font-size: 1.8rem;
  }

  .footer-main {
    flex-direction: column;
    align-items: flex-start;

    gap: 22px;
  }

  .footer-links {
    flex-wrap: wrap;
  }

  .footer-bottom {
    flex-direction: column;
    gap: 8px;
  }

}


@media (max-width: 500px) {

  .hero-content h1 {
    font-size: 2.05rem;
  }

  .hero-preview-wrapper {
    min-height: 400px;
  }

  .hero-preview-card {
    max-width: 100%;
  }

  .preview-body {
    padding: 17px;
  }

  .preview-menu {
    grid-template-columns: 1fr;
  }

  .floating-card {
    transform: scale(0.85);
  }

  .floating-top {
    top: 15px;
    right: -25px;
  }

  .floating-bottom {
    bottom: 10px;
    left: -25px;
  }

  .workflow-grid {
    grid-template-columns: 1fr;
  }

  .workflow-item {
    padding: 5px;
  }

  .cta-section {
    padding: 45px 20px;
  }

}

</style>
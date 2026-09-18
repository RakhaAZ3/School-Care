<template>
  <footer class="admin-footer-pro">
    <div class="footer-container">
      
      <!-- Bagian Kiri: Brand & Status Sistem -->
      <div class="footer-left">
        <div class="footer-logo-glow">
          <i class="fa-solid fa-school"></i>
        </div>
        <div class="footer-brand-info">
          <div class="brand-title-row">
            <strong>SchoolCare</strong>
            <span class="version-badge">v2.5 Pro</span>
          </div>
          <span>Sistem Manajemen Sarana & Prasarana Terintegrasi</span>
        </div>
      </div>

      <!-- Bagian Tengah: Quick Links / Shortcut Interaktif -->
      <div class="footer-center">
        <router-link to="/" class="footer-link">Beranda</router-link>
        <span class="link-divider">•</span>
        <router-link to="/kategori" class="footer-link">Kategori</router-link>
        <span class="link-divider">•</span>
        <a href="#" @click.prevent="showBantuanModal = true" class="footer-link highlight">
          <i class="fa-regular fa-circle-question"></i> Bantuan & Panduan
        </a>
      </div>

      <!-- Bagian Kanan: Status Online Dinamis & Tombol Kembali ke Atas -->
      <div class="footer-right">
        <div class="system-status-pill">
          <span class="pulse-dot-wrapper">
            <span class="pulse-ring"></span>
            <i class="fa-solid fa-circle online-icon"></i>
          </span>
          <span class="status-text">Server Optimal</span>
        </div>

        <button class="btn-scroll-top" @click="scrollToTop" title="Kembali ke atas halaman">
          <i class="fa-solid fa-arrow-up"></i>
        </button>
      </div>

    </div>

    <!-- Copyright Sub-Bar di Bagian Paling Bawah -->
    <div class="footer-bottom-bar">
      <p>© 2026 <strong>SchoolCare Inc.</strong> Hak Cipta Dilindungi Undang-Undang.</p>
      <div class="session-info">
        <span class="server-status-label"><i class="fa-solid fa-shield-halved"></i> Secure Session</span>
        <span class="server-time"><i class="fa-regular fa-clock"></i> {{ currentTime }}</span>
      </div>
    </div>

    <!-- Modal Bantuan Singkat (Interaktif) -->
    <Transition name="fade">
      <div v-if="showBantuanModal" class="footer-modal-backdrop" @click.self="showBantuanModal = false">
        <div class="footer-modal-card">
          <div class="modal-header-mini">
            <div class="modal-title-wrapper">
              <div class="modal-icon-header">
                <i class="fa-solid fa-headset"></i>
              </div>
              <h3>Pusat Bantuan Cepat</h3>
            </div>
            <button class="close-btn" @click="showBantuanModal = false">
              <i class="fa-solid fa-xmark"></i>
            </button>
          </div>
          <div class="modal-body-mini">
            <p>Butuh bantuan teknis seputar pengelolaan inventaris dan sarana sekolah?</p>
            <ul>
              <li>Pastikan koneksi internet stabil saat melakukan sinkronisasi data database.</li>
              <li>Gunakan tombol <strong>Refresh</strong> di halaman utama apabila data terbaru belum termuat.</li>
              <li>Hubungi administrator utama jika mengalami kendala hak akses akun.</li>
            </ul>
          </div>
          <div class="modal-footer-mini">
            <button class="btn-action-primary" @click="showBantuanModal = false">Mengerti, Terima Kasih</button>
          </div>
        </div>
      </div>
    </Transition>
  </footer>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

const showBantuanModal = ref(false)
const currentTime = ref('')
let timer = null

const updateTime = () => {
  const now = new Date()
  currentTime.value = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' })
}

const scrollToTop = () => {
  window.scrollTo({
    top: 0,
    behavior: 'smooth'
  })
}

onMounted(() => {
  updateTime()
  timer = setInterval(updateTime, 1000)
})

onUnmounted(() => {
  clearInterval(timer)
})
</script>

<style scoped>
.admin-footer-pro {
  background: #ffffff;
  border-top: 1px solid #e2e8f0;
  font-family: 'Inter', system-ui, -apple-system, sans-serif;
  color: #334155;
  margin-top: 60px;
  box-shadow: 0 -10px 30px rgba(15, 23, 42, 0.03);
}

.footer-container {
  max-width: 1400px;
  margin: 0 auto;
  padding: 24px 32px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 24px;
}

/* LEFT: Brand */
.footer-left {
  display: flex;
  align-items: center;
  gap: 14px;
}

.footer-logo-glow {
  width: 44px;
  height: 44px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 12px;
  background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
  color: #ffffff;
  font-size: 1.1rem;
  box-shadow: 0 4px 14px rgba(37, 99, 235, 0.25);
}

.footer-brand-info {
  display: flex;
  flex-direction: column;
  gap: 3px;
}

.brand-title-row {
  display: flex;
  align-items: center;
  gap: 8px;
}

.footer-brand-info strong {
  color: #0f172a;
  font-size: 0.95rem;
  font-weight: 800;
  letter-spacing: -0.01em;
}

.version-badge {
  background: #eff6ff;
  color: #2563eb;
  font-size: 0.65rem;
  font-weight: 700;
  padding: 2px 7px;
  border-radius: 6px;
  border: 1px solid #bfdbfe;
}

.footer-brand-info span {
  color: #64748b;
  font-size: 0.78rem;
  font-weight: 500;
}

/* CENTER: Quick Links */
.footer-center {
  display: flex;
  align-items: center;
  gap: 14px;
  font-size: 0.85rem;
  font-weight: 600;
}

.footer-link {
  color: #64748b;
  text-decoration: none;
  transition: all 0.2s ease;
}

.footer-link:hover {
  color: #2563eb;
}

.footer-link.highlight {
  color: #2563eb;
  background: #f8fafc;
  padding: 6px 12px;
  border-radius: 10px;
  border: 1px solid #e2e8f0;
  display: flex;
  align-items: center;
  gap: 6px;
}

.footer-link.highlight:hover {
  background: #eff6ff;
  border-color: #bfdbfe;
  color: #1d4ed8;
}

.link-divider {
  color: #cbd5e1;
  font-size: 0.6rem;
}

/* RIGHT: Status & Scroll Top */
.footer-right {
  display: flex;
  align-items: center;
  gap: 14px;
}

.system-status-pill {
  display: flex;
  align-items: center;
  gap: 8px;
  background: #f8fafc;
  padding: 8px 16px;
  border-radius: 20px;
  border: 1px solid #e2e8f0;
  font-size: 0.8rem;
  font-weight: 600;
  color: #475569;
}

/* Animasi Radar Detak Hijau */
.pulse-dot-wrapper {
  position: relative;
  width: 10px;
  height: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.online-icon {
  color: #22c55e;
  font-size: 0.5rem;
  z-index: 2;
}

.pulse-ring {
  position: absolute;
  width: 18px;
  height: 18px;
  background: rgba(34, 197, 94, 0.3);
  border-radius: 50%;
  animation: pulseAnimation 2s infinite cubic-bezier(0.4, 0, 0.6, 1);
}

@keyframes pulseAnimation {
  0% { transform: scale(0.8); opacity: 1; }
  100% { transform: scale(2.4); opacity: 0; }
}

.btn-scroll-top {
  width: 40px;
  height: 40px;
  border-radius: 12px;
  background: #ffffff;
  border: 1px solid #e2e8f0;
  color: #64748b;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.2s ease;
  box-shadow: 0 2px 6px rgba(15, 23, 42, 0.02);
}

.btn-scroll-top:hover {
  background: #2563eb;
  border-color: #2563eb;
  color: #ffffff;
  transform: translateY(-3px);
  box-shadow: 0 6px 16px rgba(37, 99, 235, 0.3);
}

/* BOTTOM SUB-BAR */
.footer-bottom-bar {
  background: #f8fafc;
  border-top: 1px solid #f1f5f9;
  padding: 14px 32px;
  font-size: 0.78rem;
  color: #64748b;
  display: flex;
  justify-content: space-between;
  align-items: center;
  max-width: 1400px;
  margin: 0 auto;
}

.footer-bottom-bar strong {
  color: #0f172a;
}

.session-info {
  display: flex;
  align-items: center;
  gap: 16px;
}

.server-status-label {
  display: flex;
  align-items: center;
  gap: 6px;
  color: #059669;
  font-weight: 600;
  background: #ecfdf5;
  padding: 3px 8px;
  border-radius: 6px;
  border: 1px solid #a7f3d0;
}

.server-time {
  font-family: monospace;
  font-weight: 700;
  color: #2563eb;
  background: #eff6ff;
  padding: 3px 8px;
  border-radius: 6px;
  border: 1px solid #bfdbfe;
  display: flex;
  align-items: center;
  gap: 6px;
}

/* MODAL MINI BANTUAN */
.footer-modal-backdrop {
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  background: rgba(15, 23, 42, 0.6);
  backdrop-filter: blur(6px);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 2000;
}

.footer-modal-card {
  background: #ffffff;
  border-radius: 20px;
  width: 440px;
  max-width: 90%;
  box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.25);
  overflow: hidden;
  animation: scaleUp 0.25s cubic-bezier(0.16, 1, 0.3, 1);
  border: 1px solid #e2e8f0;
}

.modal-header-mini {
  padding: 18px 24px;
  background: #f8fafc;
  border-bottom: 1px solid #e2e8f0;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.modal-title-wrapper {
  display: flex;
  align-items: center;
  gap: 12px;
}

.modal-icon-header {
  width: 36px;
  height: 36px;
  border-radius: 10px;
  background: #eff6ff;
  color: #2563eb;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 0.95rem;
  border: 1px solid #bfdbfe;
}

.modal-header-mini h3 {
  font-size: 1rem;
  font-weight: 800;
  color: #0f172a;
  margin: 0;
}

.close-btn {
  background: #ffffff;
  border: 1px solid #e2e8f0;
  width: 32px;
  height: 32px;
  border-radius: 8px;
  font-size: 0.9rem;
  color: #64748b;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.2s ease;
}

.close-btn:hover {
  background: #fef2f2;
  color: #ef4444;
  border-color: #fecaca;
}

.modal-body-mini {
  padding: 24px;
  font-size: 0.88rem;
  color: #475569;
  line-height: 1.6;
}

.modal-body-mini ul {
  margin: 12px 0 0 18px;
  padding: 0;
}

.modal-body-mini li {
  margin-bottom: 8px;
}

.modal-footer-mini {
  padding: 16px 24px;
  background: #f8fafc;
  border-top: 1px solid #e2e8f0;
  display: flex;
  justify-content: flex-end;
}

.btn-action-primary {
  background: #2563eb;
  color: #ffffff;
  border: none;
  padding: 10px 20px;
  border-radius: 10px;
  font-weight: 700;
  font-size: 0.85rem;
  cursor: pointer;
  transition: all 0.2s ease;
  box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
}

.btn-action-primary:hover {
  background: #1d4ed8;
  transform: translateY(-1px);
  box-shadow: 0 6px 16px rgba(37, 99, 235, 0.3);
}

/* RESPONSIVE */
@media (max-width: 992px) {
  .footer-container {
    flex-direction: column;
    text-align: center;
    gap: 20px;
    padding: 24px 20px;
  }

  .footer-left {
    flex-direction: column;
    align-items: center;
  }

  .footer-center {
    justify-content: center;
  }

  .footer-right {
    justify-content: center;
  }

  .footer-bottom-bar {
    flex-direction: column;
    gap: 12px;
    text-align: center;
    padding: 16px 20px;
  }
  
  .session-info {
    flex-direction: column;
    gap: 8px;
  }
}

@keyframes scaleUp {
  from { opacity: 0; transform: scale(0.95); }
  to { opacity: 1; transform: scale(1); }
}

.fade-enter-active, .fade-leave-active {
  transition: opacity 0.2s ease;
}
.fade-enter-from, .fade-leave-to {
  opacity: 0;
}
</style>
<template>
  <aside class="sidebar-pro" :class="{ collapsed: isCollapsed }">

    <!-- BRAND / LOGO -->
    <div class="brand">
      <div class="brand-logo-glow">
        <i class="fa-solid fa-school"></i>
      </div>
      <div v-if="!isCollapsed" class="brand-text">
        <strong>SchoolCare</strong>
        <span>School Management</span>
      </div>
    </div>

    <!-- TOGGLE BUTTON -->
    <button class="collapse-button" type="button" @click="$emit('toggle-sidebar')" title="Tutup/Buka Sidebar">
      <i class="fa-solid" :class="isCollapsed ? 'fa-angle-right' : 'fa-angle-left'"></i>
    </button>

    <!-- ADMIN PROFILE -->
    <div v-if="!isCollapsed" class="admin-profile">
      <div class="profile-avatar">
        <span>A</span>
        <span class="status-indicator-dot"></span>
      </div>
      <div class="profile-info">
        <strong>Admin Sekolah</strong>
        <span>Administrator</span>
      </div>
    </div>

    <!-- MENU NAVIGATION -->
    <nav class="sidebar-nav">
      <span v-if="!isCollapsed" class="menu-title">MENU UTAMA</span>

      <!-- Dashboard -->
      <button class="nav-item" :class="{ active: currentTab === 'dashboard' }" type="button" @click="changeTab('dashboard')">
        <i class="fa-solid fa-chart-pie"></i>
        <span v-if="!isCollapsed">Dashboard</span>
      </button>

      <!-- Ruangan -->
      <button class="nav-item" :class="{ active: currentTab === 'ruangan' }" type="button" @click="changeTab('ruangan')">
        <i class="fa-solid fa-door-open"></i>
        <span v-if="!isCollapsed">Ruangan</span>
      </button>

      <!-- Fasilitas -->
      <button class="nav-item" :class="{ active: currentTab === 'fasilitas' }" type="button" @click="changeTab('fasilitas')">
        <i class="fa-solid fa-boxes-stacked"></i>
        <span v-if="!isCollapsed">Fasilitas</span>
      </button>

      <!-- Kategori -->
      <button class="nav-item" :class="{ active: currentTab === 'kategori' }" type="button" @click="changeTab('kategori')">
        <i class="fa-solid fa-layer-group"></i>
        <span v-if="!isCollapsed">Kategori</span>
      </button>

      <!-- Pengajuan -->
      <button class="nav-item" :class="{ active: currentTab === 'pengajuan' }" type="button" @click="changeTab('pengajuan')">
        <i class="fa-solid fa-file-circle-check"></i>
        <span v-if="!isCollapsed">Pengajuan</span>
        <small v-if="!isCollapsed && pendingCount > 0" class="badge">{{ pendingCount }}</small>
        <!-- Badge mini khusus saat sidebar ditutup/collapsed -->
        <span v-if="isCollapsed && pendingCount > 0" class="mini-badge-dot" :title="pendingCount + ' Pengajuan baru'"></span>
      </button>

      <!-- Laporan -->
      <button class="nav-item" :class="{ active: currentTab === 'laporan' }" type="button" @click="changeTab('laporan')">
        <i class="fa-solid fa-triangle-exclamation"></i>
        <span v-if="!isCollapsed">Laporan</span>
      </button>

      <!-- Maintenance -->
      <button class="nav-item" :class="{ active: currentTab === 'maintenance' }" type="button" @click="changeTab('maintenance')">
        <i class="fa-solid fa-screwdriver-wrench"></i>
        <span v-if="!isCollapsed">Maintenance</span>
      </button>
    </nav>

    <!-- SIDEBAR BOTTOM -->
   
      
  </aside>
</template>

<script setup>
defineProps({
  currentTab: {
    type: String,
    default: 'dashboard'
  },
  pendingCount: {
    type: Number,
    default: 0
  },
  isCollapsed: {
    type: Boolean,
    default: false
  }
})

const emit = defineEmits([
  'change-tab',
  'toggle-sidebar',
  'logout'
])

const changeTab = (tab) => {
  emit('change-tab', tab)
}
</script>

<style scoped>
.sidebar-pro {
  position: fixed;
  top: 0;
  left: 0;
  z-index: 1000;
  width: 260px;
  height: 100vh;
  display: flex;
  flex-direction: column;
  padding: 20px 16px;
  background: #ffffff;
  border-right: 1px solid #e2e8f0;
  transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  font-family: 'Inter', system-ui, -apple-system, sans-serif;
  box-shadow: 4px 0 20px rgba(15, 23, 42, 0.02);
}

.sidebar-pro.collapsed {
  width: 84px;
  padding: 20px 12px;
}

/* BRAND */
.brand {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 4px 8px 24px;
}

.brand-logo-glow {
  width: 42px;
  height: 42px;
  flex-shrink: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 12px;
  color: #ffffff;
  background: linear-gradient(135deg, #2563eb, #7c3aed);
  box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
}

.brand-logo-glow i {
  font-size: 1rem;
}

.brand-text {
  display: flex;
  flex-direction: column;
}

.brand-text strong {
  color: #0f172a;
  font-size: 0.95rem;
  font-weight: 800;
  letter-spacing: -0.01em;
}

.brand-text span {
  margin-top: 2px;
  color: #64748b;
  font-size: 0.7rem;
}

/* TOGGLE BUTTON */
.collapse-button {
  position: absolute;
  top: 28px;
  right: -12px;
  width: 26px;
  height: 26px;
  display: flex;
  align-items: center;
  justify-content: center;
  border: 1px solid #cbd5e1;
  border-radius: 50%;
  background: #ffffff;
  color: #64748b;
  cursor: pointer;
  box-shadow: 0 3px 10px rgba(15, 23, 42, 0.08);
  transition: all 0.2s ease;
}

.collapse-button:hover {
  background: #2563eb;
  border-color: #2563eb;
  color: #ffffff;
}

/* PROFILE */
.admin-profile {
  display: flex;
  align-items: center;
  gap: 12px;
  margin: 0 0 20px;
  padding: 12px;
  background: #f8fafc;
  border: 1px solid #f1f5f9;
  border-radius: 14px;
}

.profile-avatar {
  position: relative;
  width: 38px;
  height: 38px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 10px;
  color: #ffffff;
  background: linear-gradient(135deg, #2563eb, #7c3aed);
  font-size: 0.85rem;
  font-weight: 800;
}

.status-indicator-dot {
  position: absolute;
  bottom: -1px;
  right: -1px;
  width: 10px;
  height: 10px;
  background: #22c55e;
  border: 2px solid #ffffff;
  border-radius: 50%;
}

.profile-info {
  display: flex;
  flex-direction: column;
}

.profile-info strong {
  color: #0f172a;
  font-size: 0.8rem;
  font-weight: 700;
}

.profile-info span {
  margin-top: 2px;
  color: #64748b;
  font-size: 0.7rem;
}

/* MENU NAVIGATION */
.sidebar-nav {
  display: flex;
  flex-direction: column;
  gap: 6px;
  flex: 1;
  overflow-y: auto;
  overflow-x: hidden;
  padding-right: 2px;
}

.sidebar-nav::-webkit-scrollbar {
  width: 4px;
}
.sidebar-nav::-webkit-scrollbar-thumb {
  background: #e2e8f0;
  border-radius: 4px;
}

.menu-title {
  margin: 4px 10px 8px;
  color: #94a3b8;
  font-size: 0.65rem;
  font-weight: 800;
  letter-spacing: 0.08em;
}

.nav-item {
  position: relative;
  width: 100%;
  display: flex;
  align-items: center;
  gap: 14px;
  min-height: 44px;
  padding: 0 14px;
  border: 0;
  border-radius: 12px;
  background: transparent;
  color: #64748b;
  font-family: inherit;
  font-size: 0.85rem;
  font-weight: 600;
  text-align: left;
  cursor: pointer;
  transition: all 0.2s ease;
}

.sidebar.collapsed .nav-item {
  justify-content: center;
  padding: 0;
}

.nav-item i {
  width: 20px;
  flex-shrink: 0;
  text-align: center;
  font-size: 0.95rem;
}

.nav-item:hover {
  color: #2563eb;
  background: #eff6ff;
}

.nav-item.active {
  color: #2563eb;
  background: #eff6ff;
  font-weight: 700;
}

/* Garis Indikator Aktif di Sebelah Kiri */
.nav-item.active::before {
  content: '';
  position: absolute;
  left: 0;
  width: 4px;
  height: 22px;
  border-radius: 0 4px 4px 0;
  background: #2563eb;
}

.badge {
  margin-left: auto;
  min-width: 20px;
  height: 20px;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 0 6px;
  border-radius: 20px;
  background: #ef4444;
  color: #ffffff;
  font-size: 0.65rem;
  font-weight: 800;
}

.mini-badge-dot {
  position: absolute;
  top: 10px;
  right: 14px;
  width: 8px;
  height: 8px;
  background: #ef4444;
  border-radius: 50%;
  border: 1px solid #ffffff;
}

/* SIDEBAR BOTTOM */
.sidebar-bottom {
  margin-top: 15px;
  padding-top: 12px;
  border-top: 1px solid #f1f5f9;
  display: flex;
  flex-direction: column;
  gap: 10px;
}

.system-status {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 10px 12px;
  background: #f8fafc;
  border: 1px solid #f1f5f9;
  border-radius: 12px;
}

/* Animasi Ping/Pulse Status Online */
.pulse-dot-wrapper {
  position: relative;
  width: 8px;
  height: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.status-dot {
  width: 8px;
  height: 8px;
  border-radius: 50%;
  background: #22c55e;
  z-index: 2;
}

.pulse-ring {
  position: absolute;
  width: 16px;
  height: 16px;
  background: rgba(34, 197, 94, 0.3);
  border-radius: 50%;
  animation: pulseAnimation 2s infinite cubic-bezier(0.4, 0, 0.6, 1);
}

@keyframes pulseAnimation {
  0% { transform: scale(0.8); opacity: 1; }
  100% { transform: scale(2.4); opacity: 0; }
}

.status-text-box {
  display: flex;
  flex-direction: column;
}

.status-text-box strong {
  color: #334155;
  font-size: 0.75rem;
  font-weight: 700;
}

.status-text-box small {
  margin-top: 1px;
  color: #94a3b8;
  font-size: 0.65rem;
}

.logout-button {
  width: 100%;
  min-height: 42px;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  border: 0;
  border-radius: 12px;
  background: #fef2f2;
  color: #dc2626;
  font-family: inherit;
  font-size: 0.8rem;
  font-weight: 700;
  cursor: pointer;
  transition: all 0.2s ease;
}

.logout-button:hover {
  background: #fee2e2;
  color: #b91c1c;
}

.logout-button i {
  font-size: 0.9rem;
}
</style>
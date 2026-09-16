<template>
  <aside
    class="sidebar"
    :class="{ collapsed: isCollapsed }"
  >

    <!-- BRAND -->
    <div class="brand">

      <div class="brand-logo">
        <i class="fa-solid fa-school"></i>
      </div>

      <div
        v-if="!isCollapsed"
        class="brand-text"
      >
        <strong>SchoolCare</strong>
        <span>School Management</span>
      </div>

    </div>


    <!-- TOGGLE -->
    <button
      class="collapse-button"
      type="button"
      @click="$emit('toggle-sidebar')"
    >
      <i
        class="fa-solid"
        :class="
          isCollapsed
            ? 'fa-angle-right'
            : 'fa-angle-left'
        "
      ></i>
    </button>


    <!-- PROFILE -->
    <div
      v-if="!isCollapsed"
      class="admin-profile"
    >
      <div class="profile-avatar">
        A
      </div>

      <div>
        <strong>Admin Sekolah</strong>
        <span>Administrator</span>
      </div>
    </div>


    <!-- MENU -->
    <nav class="sidebar-nav">

      <span
        v-if="!isCollapsed"
        class="menu-title"
      >
        MENU UTAMA
      </span>


      <!-- DASHBOARD -->
      <button
        class="nav-item"
        :class="{ active: currentTab === 'dashboard' }"
        type="button"
        @click="changeTab('dashboard')"
      >
        <i class="fa-solid fa-chart-pie"></i>

        <span v-if="!isCollapsed">
          Dashboard
        </span>
      </button>


      <!-- RUANGAN -->
      <button
         class="nav-item"
         :class="{ active: currentTab === 'ruangan' }"
         type="button"
         @click="changeTab('ruangan')"
         >
          <i class="fa-solid fa-door-open"></i>

          <span v-if="!isCollapsed">
          Ruangan
          </span>
         </button>


      <!-- FASILITAS -->
      <button
         class="nav-item"
         :class="{ active: currentTab === 'fasilitas' }"
         type="button"
         @click="changeTab('fasilitas')"
         >
          <i class="fa-solid fa-boxes-stacked"></i>

          <span v-if="!isCollapsed">
          Fasilitas
          </span>
         </button>


      <!-- KATEGORI -->
      <button
         class="nav-item"
         :class="{ active: currentTab === 'kategori' }"
         type="button"
         @click="changeTab('kategori')"
         >
          <i class="fa-solid fa-layer-group"></i>

          <span v-if="!isCollapsed">
          Kategori
          </span>
         </button>


      <!-- PENGAJUAN -->
      
         <button
         class="nav-item"
         :class="{ active: currentTab === 'pengajuan' }"
         type="button"
         @click="changeTab('pengajuan')"
         >
          <i class="fa-solid fa-file-circle-check"></i>

          <span v-if="!isCollapsed">
          Pengajuan
          </span>
        <small
          v-if="!isCollapsed && pendingCount > 0"
          class="badge"
        >
          {{ pendingCount }}
        </small>
      </button>


      <!-- LAPORAN -->
     <button
         class="nav-item"
         :class="{ active: currentTab === 'laporan' }"
         type="button"
         @click="changeTab('laporan')"
         >
          <i class="fa-solid fa-triangle-exclamation"></i>

          <span v-if="!isCollapsed">
          Laporan
          </span>
          </button  >



      <!-- MAINTENANCE -->
      <button
         class="nav-item"
         :class="{ active: currentTab === 'maintenance' }"
         type="button"
         @click="changeTab('maintenance')"
         >
          <i class="fa-solid fa-screwdriver-wrench"></i>

          <span v-if="!isCollapsed">
          Maintenance
          </span>
          </button>

    </nav>


    <!-- BOTTOM -->
    <div class="sidebar-bottom">

      <div
        v-if="!isCollapsed"
        class="system-status"
      >
        <span class="status-dot"></span>

        <div>
          <strong>Sistem Online</strong>
          <small>Semua layanan aktif</small>
        </div>
      </div>


      <button
        class="logout-button"
        type="button"
        @click="$emit('logout')"
      >
        <i class="fa-solid fa-right-from-bracket"></i>

        <span v-if="!isCollapsed">
          Keluar
        </span>
      </button>

    </div>

  </aside>
</template>

<script setup>

const props = defineProps({

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

.sidebar {
  position: fixed;
  top: 0;
  left: 0;
  z-index: 1000;

  width: 250px;
  height: 100vh;

  display: flex;
  flex-direction: column;

  padding: 20px 14px;

  background: #ffffff;
  border-right: 1px solid #e2e8f0;

  transition: width .3s ease;

  font-family:
    'Plus Jakarta Sans',
    'Inter',
    sans-serif;
}

.sidebar.collapsed {
  width: 78px;
}


/* BRAND */

.brand {
  display: flex;
  align-items: center;
  gap: 11px;

  padding: 4px 9px 22px;
}

.brand-logo {
  width: 38px;
  height: 38px;

  flex-shrink: 0;

  display: flex;
  align-items: center;
  justify-content: center;

  border-radius: 11px;

  color: #fff;

  background:
    linear-gradient(
      135deg,
      #2563eb,
      #7c3aed
    );

  box-shadow:
    0 7px 15px rgba(37, 99, 235, .2);
}

.brand-logo i {
  font-size: .9rem;
}

.brand-text {
  display: flex;
  flex-direction: column;
}

.brand-text strong {
  color: #0f172a;
  font-size: .85rem;
  font-weight: 800;
}

.brand-text span {
  margin-top: 2px;
  color: #94a3b8;
  font-size: .55rem;
}


/* TOGGLE */

.collapse-button {
  position: absolute;
  top: 25px;
  right: -12px;

  width: 24px;
  height: 24px;

  display: flex;
  align-items: center;
  justify-content: center;

  border: 1px solid #e2e8f0;
  border-radius: 50%;

  background: #fff;
  color: #64748b;

  cursor: pointer;

  box-shadow: 0 3px 10px rgba(15, 23, 42, .08);
}

.collapse-button:hover {
  color: #2563eb;
}


/* PROFILE */

.admin-profile {
  display: flex;
  align-items: center;
  gap: 10px;

  margin: 5px 4px 20px;
  padding: 12px;

  background: #f8fafc;
  border: 1px solid #f1f5f9;
  border-radius: 13px;
}

.profile-avatar {
  width: 35px;
  height: 35px;

  display: flex;
  align-items: center;
  justify-content: center;

  border-radius: 10px;

  color: #fff;
  background: linear-gradient(
    135deg,
    #2563eb,
    #7c3aed
  );

  font-size: .7rem;
  font-weight: 800;
}

.admin-profile div:last-child {
  display: flex;
  flex-direction: column;
}

.admin-profile strong {
  color: #334155;
  font-size: .65rem;
  font-weight: 800;
}

.admin-profile span {
  margin-top: 2px;
  color: #94a3b8;
  font-size: .55rem;
}


/* MENU */

.sidebar-nav {
  display: flex;
  flex-direction: column;
  gap: 4px;

  flex: 1;

  overflow-y: auto;
}

.menu-title {
  margin: 0 10px 8px;

  color: #94a3b8;
  font-size: .52rem;
  font-weight: 800;
  letter-spacing: .1em;
}

.nav-item {
  position: relative;

  width: 100%;

  display: flex;
  align-items: center;
  gap: 12px;

  min-height: 43px;

  padding: 0 12px;

  border: 0;
  border-radius: 11px;

  background: transparent;

  color: #64748b;

  font-family: inherit;
  font-size: .68rem;
  font-weight: 600;

  text-align: left;

  cursor: pointer;

  transition: .2s ease;
}

.sidebar.collapsed .nav-item {
  justify-content: center;
  padding: 0;
}

.nav-item i {
  width: 18px;

  flex-shrink: 0;

  text-align: center;

  font-size: .78rem;
}

.nav-item:hover {
  color: #2563eb;
  background: #eff6ff;
}

.nav-item.active {
  color: #2563eb;
  background: #eff6ff;
  font-weight: 800;
}

.nav-item.active::before {
  content: '';

  position: absolute;
  left: 0;

  width: 3px;
  height: 20px;

  border-radius: 0 5px 5px 0;

  background: #2563eb;
}

.badge {
  margin-left: auto;

  min-width: 20px;
  padding: 3px 6px;

  border-radius: 20px;

  background: #ef4444;
  color: #fff;

  font-size: .5rem;
  font-weight: 800;

  text-align: center;
}


/* BOTTOM */

.sidebar-bottom {
  margin-top: 15px;
}

.system-status {
  display: flex;
  align-items: center;
  gap: 9px;

  margin-bottom: 10px;
  padding: 11px;

  background: #f8fafc;
  border: 1px solid #f1f5f9;
  border-radius: 12px;
}

.status-dot {
  width: 7px;
  height: 7px;

  flex-shrink: 0;

  border-radius: 50%;

  background: #22c55e;

  box-shadow: 0 0 0 4px #dcfce7;
}

.system-status div {
  display: flex;
  flex-direction: column;
}

.system-status strong {
  color: #475569;
  font-size: .58rem;
}

.system-status small {
  margin-top: 2px;
  color: #94a3b8;
  font-size: .5rem;
}


.logout-button {
  width: 100%;
  min-height: 42px;

  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;

  border: 0;
  border-radius: 11px;

  background: #fef2f2;
  color: #dc2626;

  font-family: inherit;
  font-size: .65rem;
  font-weight: 700;

  cursor: pointer;
}

.logout-button:hover {
  background: #fee2e2;
}

.logout-button i {
  font-size: .75rem;
}

</style>
<template>
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

      <button class="nav-item active" type="button" @click="goTo('/pengguna/dashboard')">
        <i class="fa-solid fa-house"></i>
        <span v-if="!isCollapsed">Dashboard</span>
      </button>

      <button class="nav-item" type="button" @click="goTo('/pengguna/fasilitas')">
        <i class="fa-solid fa-boxes-stacked"></i>
        <span v-if="!isCollapsed">Fasilitas</span>
      </button>

      <button class="nav-item" type="button" @click="goTo('/pengguna/ruangan')">
        <i class="fa-solid fa-door-open"></i>
        <span v-if="!isCollapsed">Ruangan</span>
      </button>

      <button class="nav-item" type="button" @click="goTo('/pengguna/pengajuan')">
        <i class="fa-solid fa-file-circle-check"></i>
        <span v-if="!isCollapsed">Pengajuan Saya</span>
      </button>

      <button class="nav-item" type="button" @click="goTo('/pengguna/laporan')">
        <i class="fa-solid fa-triangle-exclamation"></i>
        <span v-if="!isCollapsed">Laporan Saya</span>
      </button>
    </nav>

    <div class="sidebar-bottom">
      <button class="nav-item logout-btn" type="button" @click="handleLogout">
        <i class="fa-solid fa-right-from-bracket"></i>
        <span v-if="!isCollapsed">Logout</span>
      </button>
    </div>
  </aside>
</template>

<script setup>
import { useRouter } from 'vue-router'

defineProps({
  isCollapsed: Boolean
})

const router = useRouter()

const goTo = (path) => {
  router.push(path)
}

const handleLogout = () => {
  const confirmLogout = confirm('Apakah kamu yakin ingin keluar?')
  if (!confirmLogout) return

  localStorage.removeItem('token')
  localStorage.removeItem('user')
  localStorage.removeItem('isLoggedIn')
  router.push('/login')
}
</script>

<style scoped>
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
.sidebar-header { display: flex; align-items: center; gap: 12px; padding: 0 8px 28px; border-bottom: 1px solid #f1f5f9; }
.logo-box { width: 44px; height: 44px; border-radius: 14px; background: linear-gradient(135deg, #eff6ff, #ede9fe); display: flex; align-items: center; justify-content: center; font-size: 21px; flex-shrink: 0; box-shadow: 0 8px 20px rgba(37, 99, 235, 0.08); }
.brand h2 { margin: 0; font-size: 18px; font-weight: 800; letter-spacing: -0.5px; color: #0f172a; }
.brand h2 span { color: #2563eb; }
.brand small { display: block; margin-top: 3px; color: #94a3b8; font-size: 10px; font-weight: 600; }
.sidebar-nav { flex: 1; padding-top: 25px; }
.menu-title { margin: 0 10px 11px; font-size: 9px; font-weight: 800; color: #94a3b8; letter-spacing: 1.2px; }
.nav-item { width: 100%; border: none; background: transparent; color: #64748b; padding: 12px 13px; margin-bottom: 5px; border-radius: 11px; display: flex; align-items: center; gap: 12px; font-size: 13px; font-weight: 650; cursor: pointer; text-align: left; transition: all 0.2s ease; }
.nav-item i { width: 19px; text-align: center; font-size: 15px; flex-shrink: 0; }
.nav-item:hover { background: #f8fafc; color: #2563eb; transform: translateX(2px); }
.nav-item.active { color: #2563eb; background: linear-gradient(135deg, #eff6ff, #f5f3ff); box-shadow: 0 5px 15px rgba(37, 99, 235, 0.05); }
.sidebar-bottom { border-top: 1px solid #f1f5f9; padding-top: 15px; }
.logout-btn:hover { color: #dc2626; background: #fef2f2; }
</style>
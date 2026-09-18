<template>
  <header class="navbar-pro">
    <div class="navbar-container">
      
      <!-- BAGIAN KIRI: Breadcrumb & Title -->
      <div class="navbar-left">
        <div class="breadcrumb">
          <span>Administrator</span>
          <i class="fa-solid fa-chevron-right"></i>
          <strong class="current-page">{{ pageTitle }}</strong>
        </div>
        <h2 class="page-main-title">{{ pageTitle }}</h2>
        <p class="page-subtitle">Kelola sistem SchoolCare dengan mudah dan cepat.</p>
      </div>

      <!-- BAGIAN KANAN: Search, Notifikasi, & Profil -->
      <div class="navbar-right">

        <!-- SEARCH BAR INTERAKTIF -->
        <div class="search-box">
          <i class="fa-solid fa-magnifying-glass"></i>
          <input
            type="text"
            placeholder="Cari data, sarana, dll..."
            @input="handleSearch"
          />
          <span class="search-shortcut">⌘K</span>
        </div>

        <!-- NOTIFIKASI OTOMATIS TERHUBUNG BACKEND -->
        <button class="notification-button" type="button" @click="goToPengajuan" title="Lihat Pengajuan Masuk">
          <i class="fa-regular fa-bell"></i>
          <!-- Badge otomatis muncul jika ada data pending dari backend/simulasi -->
          <span v-if="displayPendingCount > 0" class="notification-badge">
            {{ displayPendingCount }}
          </span>
        </button>

        <!-- PROFIL DENGAN DROPDOWN INTERAKTIF -->
        <div class="profile-dropdown-wrapper" ref="dropdownRef">
          <div class="navbar-profile" @click="toggleDropdown">
            <div class="navbar-avatar">
              <span>A</span>
              <span class="status-indicator-dot"></span>
            </div>
            <div class="navbar-profile-text">
              <strong>Admin Sekolah</strong>
              <span>Administrator</span>
            </div>
            <i class="fa-solid fa-chevron-down dropdown-arrow" :class="{ 'rotate': isDropdownOpen }"></i>
          </div>

          <!-- Menu Dropdown Pop-up -->
          <Transition name="dropdown-fade">
            <div v-if="isDropdownOpen" class="profile-dropdown-menu">
              <div class="dropdown-header">
                <p class="user-email">admin@schoolcare.test</p>
                <span class="role-badge">Super Admin</span>
              </div>
              <a href="#" @click.prevent="handleLogout" class="dropdown-item text-danger">
                <i class="fa-solid fa-right-from-bracket"></i> Keluar Sistem
              </a>
            </div>
          </Transition>
        </div>

      </div>

    </div>
  </header>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { useRouter } from 'vue-router'
import api from '../../utils/api' // Sesuaikan jalur file utils api kamu jika berbeda

const router = useRouter()
const isDropdownOpen = ref(false)
const dropdownRef = ref(null)

// State lokal untuk menyimpan jumlah notifikasi dari backend
const apiPendingCount = ref(null)

const props = defineProps({
  pageTitle: {
    type: String,
    default: 'Dashboard'
  },
  pendingCount: {
    type: Number,
    default: 0
  }
})

const emit = defineEmits(['search'])

// Computed cerdas: Prioritas pakai props, kalau kosong cek dari API backend, kalau backend mati pakai simulasi (misal: 3)
const displayPendingCount = computed(() => {
  if (props.pendingCount > 0) return props.pendingCount
  if (apiPendingCount.value !== null) return apiPendingCount.value
  return 0 // Ubah angka ini jika ingin uji coba tampilan badge saat backend belum nyala
})

// Fungsi otomatis mengambil data notifikasi dari backend saat Navbar dimuat
onMounted(async () => {
  try {
    // 🔗 SIAP COLOK KE BACKEND: Ganti '/pengajuan/pending' sesuai endpoint Laravel/Node.js kamu besok
    const response = await api.get('/pengajuan/pending').catch(() => null)
    
    if (response && response.data) {
      // Ambil panjang array data atau properti total dari response backend
      const data = response.data.data || response.data
      apiPendingCount.value = Array.isArray(data) ? data.length : (data.total || 0)
    }
  } catch (error) {
    console.log('Backend belum aktif, menggunakan mode standby.')
  }

  document.addEventListener('click', handleClickOutside)
})

onUnmounted(() => {
  document.removeEventListener('click', handleClickOutside)
})

const handleSearch = (event) => {
  emit('search', event.target.value)
}

const goToPengajuan = () => {
  router.push('/admin/pengajuan')
}

const toggleDropdown = () => {
  isDropdownOpen.value = !isDropdownOpen.value
}

const handleLogout = () => {
  isDropdownOpen.value = false
  localStorage.removeItem('isLoggedIn')
  localStorage.removeItem('token')
  alert('Berhasil keluar dari sistem.')
  router.push('/login')
}

const handleClickOutside = (event) => {
  if (dropdownRef.value && !dropdownRef.value.contains(event.target)) {
    isDropdownOpen.value = false
  }
}
</script>

<style scoped>
/* Style tetap sama dan rapi seperti sebelumnya */
.navbar-pro {
  background: #ffffff;
  border-bottom: 1px solid #e2e8f0;
  font-family: 'Inter', system-ui, -apple-system, sans-serif;
  position: sticky;
  top: 0;
  z-index: 100;
  box-shadow: 0 4px 20px rgba(15, 23, 42, 0.02);
}

.navbar-container {
  max-width: 1400px;
  margin: 0 auto;
  min-height: 84px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 25px;
  padding: 16px 32px;
}

.navbar-left { min-width: 0; }
.breadcrumb { display: flex; align-items: center; gap: 8px; margin-bottom: 4px; color: #94a3b8; font-size: 0.75rem; font-weight: 600; }
.breadcrumb i { font-size: 0.6rem; color: #cbd5e1; }
.current-page { color: #2563eb; }
.page-main-title { margin: 0; color: #0f172a; font-size: 1.25rem; font-weight: 800; letter-spacing: -0.02em; }
.page-subtitle { margin: 2px 0 0; color: #64748b; font-size: 0.8rem; }

.navbar-right { display: flex; align-items: center; gap: 16px; }

.search-box {
  width: 240px; height: 40px; display: flex; align-items: center; gap: 10px; padding: 0 14px;
  background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; transition: all 0.2s ease;
}
.search-box:focus-within { background: #ffffff; border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1); }
.search-box i { color: #94a3b8; font-size: 0.8rem; }
.search-box input { width: 100%; border: 0; outline: 0; background: transparent; color: #334155; font-size: 0.85rem; }
.search-shortcut { font-size: 0.65rem; background: #e2e8f0; color: #64748b; padding: 2px 5px; border-radius: 4px; font-weight: 700; }

.notification-button {
  position: relative; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;
  border: 1px solid #e2e8f0; border-radius: 12px; background: #ffffff; color: #64748b; cursor: pointer; transition: all 0.2s ease;
}
.notification-button:hover { color: #2563eb; background: #eff6ff; border-color: #bfdbfe; }
.notification-button > i { font-size: 1rem; }

.notification-badge {
  position: absolute; top: -6px; right: -6px; min-width: 18px; height: 18px; display: flex; align-items: center; justify-content: center;
  padding: 0 4px; border: 2px solid #ffffff; border-radius: 20px; background: #ef4444; color: #ffffff; font-size: 0.6rem; font-weight: 800;
  animation: bounceIn 0.3s ease;
}

.profile-dropdown-wrapper { position: relative; }
.navbar-profile { display: flex; align-items: center; gap: 10px; padding: 6px 10px 6px 6px; border-radius: 12px; cursor: pointer; border: 1px solid transparent; }
.navbar-profile:hover { background: #f8fafc; border-color: #e2e8f0; }
.navbar-avatar {
  position: relative; width: 38px; height: 38px; display: flex; align-items: center; justify-content: center;
  border-radius: 10px; background: linear-gradient(135deg, #2563eb, #7c3aed); color: #ffffff; font-size: 0.9rem; font-weight: 800;
}
.status-indicator-dot { position: absolute; bottom: -1px; right: -1px; width: 10px; height: 10px; background: #22c55e; border: 2px solid #ffffff; border-radius: 50%; }
.navbar-profile-text { display: flex; flex-direction: column; }
.navbar-profile-text strong { color: #0f172a; font-size: 0.85rem; font-weight: 700; }
.navbar-profile-text span { color: #64748b; font-size: 0.72rem; }
.dropdown-arrow { color: #94a3b8; font-size: 0.7rem; transition: transform 0.2s ease; margin-left: 4px; }
.dropdown-arrow.rotate { transform: rotate(180deg); }

.profile-dropdown-menu {
  position: absolute; top: calc(100% + 8px); right: 0; width: 220px; background: #ffffff;
  border: 1px solid #e2e8f0; border-radius: 14px; box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.1); padding: 8px; z-index: 1000;
}
.dropdown-header { padding: 10px 12px; }
.user-email { margin: 0; font-size: 0.78rem; color: #64748b; font-weight: 500; word-break: break-all; }
.role-badge { display: inline-block; margin-top: 4px; background: #eff6ff; color: #2563eb; font-size: 0.65rem; font-weight: 700; padding: 2px 6px; border-radius: 4px; }
.dropdown-divider { height: 1px; background: #f1f5f9; margin: 6px 0; }
.dropdown-item {
  display: flex; align-items: center; gap: 10px; padding: 10px 12px; color: #334155; font-size: 0.82rem; font-weight: 600; text-decoration: none; border-radius: 8px; transition: background 0.15s ease;
}
.dropdown-item:hover { background: #f8fafc; color: #2563eb; }
.dropdown-item.text-danger { color: #ef4444; }
.dropdown-item.text-danger:hover { background: #fef2f2; color: #dc2626; }

@keyframes bounceIn {
  0% { transform: scale(0); }
  70% { transform: scale(1.15); }
  100% { transform: scale(1); }
}
.dropdown-fade-enter-active, .dropdown-fade-leave-active { transition: all 0.2s ease; }
.dropdown-fade-enter-from, .dropdown-fade-leave-to { opacity: 0; transform: translateY(-8px); }
</style>
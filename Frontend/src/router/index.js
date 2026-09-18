import { createRouter, createWebHistory } from 'vue-router'

// ==========================================
// AUTH
// ==========================================

import LoginView from '../views/auth/LoginView.vue'
import RegisterView from '../views/auth/RegisterView.vue'

// ==========================================
// LANDING PAGE
// ==========================================

import LandingPage from '../views/LandingPage.vue'
import PenggunaLandingPage from '../views/PenggunaLandingPage.vue'

// ==========================================
// ADMIN LAYOUT & PAGES
// ==========================================

import AdminDashboard from '../views/admin/AdminDashboard.vue'
import FasilitasView from '../views/FasilitasView.vue'
import KategoriView from '../views/KategoriView.vue'
import RuanganView from '../views/RuanganView.vue'
import LaporanView from '../views/LaporanView.vue'
import MaintenanceView from '../views/MaintenanceView.vue'
import PengajuanView from '../views/PengajuanView.vue'

// ==========================================
// PENGGUNA LAYOUT & PAGES
// ==========================================

import PenggunaDashboard from '../views/pengguna/PenggunaDashboard.vue'
// Jika kamu punya file khusus untuk home dashboard, import di sini:
// import PenggunaDashboardHome from '../views/pengguna/PenggunaDashboardHome.vue'
import PenggunaFasilitas from '../views/pengguna/PenggunaFasilitas.vue'
import PenggunaRuangan from '../views/pengguna/PenggunaRuangan.vue'
import PenggunaPengajuan from '../views/pengguna/PenggunaPengajuan.vue'
import PenggunaLaporan from '../views/pengguna/PenggunaLaporan.vue'
import PenggunaDashboardHome from '../views/pengguna/PenggunaDashboardHome.vue'

// ==========================================
// ROUTES
// ==========================================

const routes = [

  // ========================================
  // LANDING PAGE
  // ========================================

  {
    path: '/',
    name: 'Landing',
    component: LandingPage
  },

  // ========================================
  // PENGGUNA LANDING PAGE
  // ========================================

  {
    path: '/pengguna',
    name: 'PenggunaLanding',
    component: PenggunaLandingPage
  },

  // ========================================
  // AUTH
  // ========================================

  {
    path: '/login',
    name: 'Login',
    component: LoginView
  },

  {
    path: '/register',
    name: 'Register',
    component: RegisterView
  },

  // ========================================
  // PENGGUNA PANEL (Nested Routes)
  // ========================================

  {
    path: '/pengguna',
    component: PenggunaDashboard,
    children: [

      {
        path: '',
        redirect: '/pengguna/dashboard'
      },

      {
        path: 'dashboard',
        name: 'PenggunaDashboardHome',
        component: PenggunaDashboardHome // Ubah ini ke komponen khusus dashboard kamu (misal: PenggunaDashboardHome) bila sudah ada
      },

      {
        path: 'fasilitas',
        name: 'PenggunaFasilitas',
        component: PenggunaFasilitas
      },

      {
        path: 'ruangan',
        name: 'PenggunaRuangan',
        component: PenggunaRuangan
      },

      {
        path: 'pengajuan',
        name: 'PenggunaPengajuan',
        component: PenggunaPengajuan
      },

      {
        path: 'laporan',
        name: 'PenggunaLaporan',
        component: PenggunaLaporan
      }

    ]
  },

  // ========================================
  // ADMIN PANEL
  // ========================================

  {
    path: '/admin',
    component: AdminDashboard,

    children: [

      {
        path: '',
        redirect: '/admin/dashboard'
      },

      {
        path: 'dashboard',
        name: 'AdminDashboardHome'
      },

      {
        path: 'ruangan',
        name: 'AdminRuangan',
        component: RuanganView
      },

      {
        path: 'fasilitas',
        name: 'AdminFasilitas',
        component: FasilitasView
      },

      {
        path: 'kategori',
        name: 'AdminKategori',
        component: KategoriView
      },

      {
        path: 'pengajuan',
        name: 'AdminPengajuan',
        component: PengajuanView
      },

      {
        path: 'laporan',
        name: 'AdminLaporan',
        component: LaporanView
      },

      {
        path: 'maintenance',
        name: 'AdminMaintenance',
        component: MaintenanceView
      }

    ]
  }

]

// ==========================================
// CREATE ROUTER
// ==========================================

const router = createRouter({

  history: createWebHistory(),

  routes,

  scrollBehavior() {
    return {
      top: 0,
      behavior: 'smooth'
    }
  }

})

export default router
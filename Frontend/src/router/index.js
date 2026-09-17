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
// ADMIN LAYOUT
// ==========================================

import AdminDashboard from '../views/admin/AdminDashboard.vue'

// ==========================================
// ADMIN PAGES
// ==========================================

import FasilitasView from '../views/FasilitasView.vue'
import KategoriView from '../views/KategoriView.vue'
import RuanganView from '../views/RuanganView.vue'
import LaporanView from '../views/LaporanView.vue'
import MaintenanceView from '../views/MaintenanceView.vue'
import PengajuanView from '../views/PengajuanView.vue'

// ==========================================
// PENGGUNA PAGES
// ==========================================

import PenggunaDashboard from '../views/pengguna/PenggunaDashboard.vue'
import PenggunaFasilitas from '../views/pengguna/PenggunaFasilitas.vue'
import PenggunaRuangan from '../views/pengguna/PenggunaRuangan.vue'
import PenggunaPengajuan from '../views/pengguna/PenggunaPengajuan.vue'
import PenggunaLaporan from '../views/pengguna/PenggunaLaporan.vue'

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
  // PENGGUNA PANEL
  // ========================================

  // Dashboard Pengguna
  {
    path: '/pengguna/dashboard',
    name: 'PenggunaDashboard',
    component: PenggunaDashboard
  },

  // Fasilitas Pengguna
  {
    path: '/pengguna/fasilitas',
    name: 'PenggunaFasilitas',
    component: PenggunaFasilitas
  },

  // Ruangan Pengguna
  {
    path: '/pengguna/ruangan',
    name: 'PenggunaRuangan',
    component: PenggunaRuangan
  },

  // Pengajuan Pengguna
  {
    path: '/pengguna/pengajuan',
    name: 'PenggunaPengajuan',
    component: PenggunaPengajuan
  },

  // Laporan Pengguna
  {
    path: '/pengguna/laporan',
    name: 'PenggunaLaporan',
    component: PenggunaLaporan
  },

  // ========================================
  // ADMIN PANEL
  // ========================================

  {
    path: '/admin',
    component: AdminDashboard,

    children: [

      // ====================================
      // DASHBOARD ADMIN
      // ====================================

      {
        path: '',
        redirect: '/admin/dashboard'
      },

      {
        path: 'dashboard',
        name: 'AdminDashboardHome'
      },

      // ====================================
      // RUANGAN ADMIN
      // ====================================

      {
        path: 'ruangan',
        name: 'AdminRuangan',
        component: RuanganView
      },

      // ====================================
      // FASILITAS ADMIN
      // ====================================

      {
        path: 'fasilitas',
        name: 'AdminFasilitas',
        component: FasilitasView
      },

      // ====================================
      // KATEGORI ADMIN
      // ====================================

      {
        path: 'kategori',
        name: 'AdminKategori',
        component: KategoriView
      },

      // ====================================
      // PENGAJUAN ADMIN
      // ====================================

      {
        path: 'pengajuan',
        name: 'AdminPengajuan',
        component: PengajuanView
      },

      // ====================================
      // LAPORAN ADMIN
      // ====================================

      {
        path: 'laporan',
        name: 'AdminLaporan',
        component: LaporanView
      },

      // ====================================
      // MAINTENANCE ADMIN
      // ====================================

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
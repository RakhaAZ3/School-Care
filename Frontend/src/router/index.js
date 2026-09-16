import { createRouter, createWebHistory } from 'vue-router'

// AUTH
import LoginView from '../views/auth/LoginView.vue'
import RegisterView from '../views/auth/RegisterView.vue'

// LANDING
import LandingPage from '../views/LandingPage.vue'

// ADMIN LAYOUT
import AdminDashboard from '../views/admin/AdminDashboard.vue'

// ADMIN PAGES
import FasilitasView from '../views/FasilitasView.vue'
import KategoriView from '../views/KategoriView.vue'
import RuanganView from '../views/RuanganView.vue'
import LaporanView from '../views/LaporanView.vue'
import MaintenanceView from '../views/MaintenanceView.vue'
import PengajuanView from '../views/PengajuanView.vue'

const routes = [
  // ==========================================
  // LANDING PAGE
  // ==========================================
  {
    path: '/',
    name: 'Landing',
    component: LandingPage
  },

  // ==========================================
  // AUTH
  // ==========================================
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

  // ==========================================
  // ADMIN PANEL
  // ==========================================
  {
    path: '/admin',
    component: AdminDashboard,
    children: [
      // DASHBOARD
      {
        path: '',
        redirect: '/admin/dashboard'
      },
      {
        path: 'dashboard',
        name: 'AdminDashboardHome'
      },

      // RUANGAN
      {
        path: 'ruangan',
        name: 'AdminRuangan',
        component: RuanganView
      },

      // FASILITAS
      {
        path: 'fasilitas',
        name: 'AdminFasilitas',
        component: FasilitasView
      },

      // KATEGORI
      {
        path: 'kategori',
        name: 'AdminKategori',
        component: KategoriView
      },

      // PENGAJUAN
      {
        path: 'pengajuan',
        name: 'AdminPengajuan',
        component: PengajuanView
      },

      // LAPORAN
      {
        path: 'laporan',
        name: 'AdminLaporan',
        component: LaporanView
      },

      // MAINTENANCE
      {
        path: 'maintenance',
        name: 'AdminMaintenance',
        component: MaintenanceView
      }
    ]
  }
]

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
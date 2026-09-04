import { createRouter, createWebHistory } from 'vue-router'
import LoginView from '../views/auth/LoginView.vue'
import RegisterView from '../views/auth/RegisterView.vue'
import LandingPage from '../views/LandingPage.vue' 
import FasilitasView from '../views/FasilitasView.vue'
import KategoriView from '../views/KategoriView.vue'
import RuanganView from '../views/RuanganView.vue'
import LaporanView from '../views/LaporanView.vue'
import MaintenanceView from '../views/MaintenanceView.vue'
import PengajuanView from '../views/PengajuanView.vue'
import AdminDashboardView from '../views/AdminDashboardView.vue' // <-- Tambahan rute Admin Dashboard

const routes = [
  { path: '/', name: 'Landing', component: LandingPage },
  { path: '/login', name: 'Login', component: LoginView },
  { path: '/register', name: 'Register', component: RegisterView },
  { path: '/fasilitas', name: 'Fasilitas', component: FasilitasView },
  { path: '/kategori', name: 'Kategori', component: KategoriView },
  { path: '/ruangan', name: 'Ruangan', component: RuanganView },
  { path: '/laporan', name: 'Laporan', component: LaporanView },
  { path: '/maintenance', name: 'Maintenance', component: MaintenanceView },
  { path: '/pengajuan', name: 'Pengajuan', component: PengajuanView },
  { path: '/admin', name: 'AdminDashboard', component: AdminDashboardView } // <-- Path URL untuk masuk ke panel admin
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
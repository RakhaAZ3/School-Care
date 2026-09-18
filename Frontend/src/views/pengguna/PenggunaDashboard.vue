<template>
  <div class="pengguna-dashboard">
    <!-- SIDEBAR -->
    <Sidebar :isCollapsed="isCollapsed" />

    <!-- MAIN CONTENT -->
    <main class="main-content">
      <!-- NAVBAR -->
      <Navbar @toggle="toggleSidebar" />

      <!-- PAGE CONTENT (Tempat isi halaman anak muncul secara dinamis) -->
      <section class="page-content">
        <router-view />
      </section>

      <!-- FOOTER -->
      <Footer />
    </main>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import Sidebar from '../components-pengguna/Sidebar.vue'
import Navbar from '../components-pengguna/Navbar.vue'
import Footer from '../components-pengguna/Footer.vue'

const isCollapsed = ref(false)

const toggleSidebar = () => {
  isCollapsed.value = !isCollapsed.value
}
</script>

<style scoped>
* {
  box-sizing: border-box;
}

.pengguna-dashboard {
  min-height: 100vh;
  display: flex;
  background: #f8fafc;
  color: #0f172a;
  font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
}

.main-content {
  flex: 1;
  min-width: 0;
  display: flex;
  flex-direction: column;
}

.page-content {
  width: 100%;
  max-width: 1400px;
  margin: 0 auto;
  padding: 32px;
  flex: 1;
}

@media (max-width: 700px) {
  .page-content {
    padding: 20px 18px;
  }
}
</style>
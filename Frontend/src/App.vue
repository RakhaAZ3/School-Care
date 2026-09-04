<template>
  <div class="main-app-container">
    <router-view />
  </div>
</template>

<script setup>
// Tidak perlu logika sidebar lagi, semua diatur langsung oleh Vue Router & halaman masing-masing.
</script>

<style>
/* Global Blue Theme Variables */
:root {
  --bg-main: #F4F7FC;
  --bg-card: #FFFFFF;
  --text-primary: #0F172A;
  --text-secondary: #64748B;
  
  --primary-color: #2563EB;
  --primary-hover: #1D4ED8;
  --primary-light: #EFF6FF;
  --primary-border: #BFDBFE;

  --border-color: #E2E8F0;
  --radius-lg: 16px;
  --radius-md: 10px;
}

* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
  font-family: 'Plus Jakarta Sans', 'Inter', 'Segoe UI', sans-serif;
}

body {
  background-color: var(--bg-main);
  color: var(--text-primary);
  -webkit-font-smoothing: antialiased;
}

.main-app-container {
  min-height: 100vh;
  width: 100%;
}
</style>
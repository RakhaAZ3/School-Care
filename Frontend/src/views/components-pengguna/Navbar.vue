<template>
  <header class="topbar">
    <div class="topbar-left">
      <button class="toggle-btn" type="button" @click="$emit('toggle')">
        <i class="fa-solid fa-bars"></i>
      </button>
      <div>
        <h1>Dashboard</h1>
        <p>Kelola kebutuhan fasilitas sekolah kamu dengan mudah.</p>
      </div>
    </div>

    <div class="profile">
      <div class="profile-avatar">👤</div>
      <div class="profile-info">
        <strong>Pengguna</strong>
        <span>SchoolCare</span>
      </div>
    </div>
  </header>
</template>

<script setup>
defineEmits(['toggle'])
</script>

<style scoped>
.topbar {
  min-height: 82px;
  background: rgba(255, 255, 255, 0.94);
  border-bottom: 1px solid #e2e8f0;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 16px 32px;
  backdrop-filter: blur(15px);
}
.topbar-left { display: flex; align-items: center; gap: 16px; }
.toggle-btn { width: 40px; height: 40px; border: 1px solid #e2e8f0; background: white; color: #475569; border-radius: 11px; cursor: pointer; transition: all 0.2s ease; }
.toggle-btn:hover { background: #eff6ff; color: #2563eb; border-color: #bfdbfe; }
.topbar h1 { margin: 0; font-size: 21px; font-weight: 800; letter-spacing: -0.5px; }
.topbar p { margin: 4px 0 0; color: #64748b; font-size: 12px; }
.profile { display: flex; align-items: center; gap: 10px; }
.profile-avatar { width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #dbeafe, #ede9fe); display: flex; align-items: center; justify-content: center; box-shadow: 0 5px 15px rgba(37, 99, 235, 0.08); }
.profile-info strong { display: block; font-size: 13px; color: #334155; }
.profile-info span { display: block; margin-top: 2px; font-size: 10px; color: #94a3b8; }
</style>
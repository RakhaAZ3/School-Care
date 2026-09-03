<template>
  <div class="auth-container">
    <!-- Background Glow Ornaments -->
    <div class="bg-glow-blob blob-1"></div>
    <div class="bg-glow-blob blob-2"></div>

    <div class="auth-card">
      <div class="auth-header">
        <div class="brand-logo">🏫</div>
        <h2>Masuk ke <span class="text-primary">SchoolCare</span></h2>
        <p>Silakan masukkan akun untuk mengakses panel sistem.</p>
      </div>

      <form @submit.prevent="handleLogin" class="auth-form">
        <div class="form-group">
          <label>Email Pengguna</label>
          <input 
            type="email" 
            v-model="email" 
            placeholder="contoh: admin@schoolcare.app" 
            required 
          />
        </div>

        <div class="form-group">
          <label>Kata Sandi</label>
          <input 
            type="password" 
            v-model="password" 
            placeholder="••••••••" 
            required 
          />
        </div>

        <button type="submit" class="btn-submit">
          Masuk Sekarang 🚀
        </button>
      </form>

      <div class="auth-footer">
        <p>Belum punya akun? <router-link to="/register">Daftar di sini</router-link></p>
        <p style="margin-top: 8px;"><router-link to="/" class="back-link">← Kembali ke Beranda</router-link></p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const email = ref('')
const password = ref('')

const handleLogin = () => {
  // Simulasi login sukses
  localStorage.setItem('isLoggedIn', 'true')
  alert('Login Berhasil! Mengarahkan ke Dashboard...')
  router.push('/admin') // atau sesuaikan dengan route dashboard kamu
}
</script>

<style scoped>
.auth-container {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #f8fafc;
  font-family: 'Plus Jakarta Sans', sans-serif;
  position: relative;
  overflow: hidden;
  padding: 20px;
}

.bg-glow-blob {
  position: absolute;
  width: 450px;
  height: 450px;
  border-radius: 50%;
  filter: blur(80px);
  z-index: 0;
  opacity: 0.15;
  pointer-events: none;
}
.blob-1 { top: -100px; left: -100px; background: #2563eb; }
.blob-2 { bottom: -100px; right: -100px; background: #7c3aed; }

.auth-card {
  background: white;
  padding: 40px;
  border-radius: 24px;
  border: 1px solid #e2e8f0;
  width: 100%;
  max-width: 420px;
  box-shadow: 0 20px 40px rgba(15, 23, 42, 0.05);
  position: relative;
  z-index: 10;
  text-align: left;
}

.auth-header {
  text-align: center;
  margin-bottom: 30px;
}

.brand-logo {
  background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
  width: 54px;
  height: 54px;
  margin: 0 auto 16px auto;
  border-radius: 16px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.5rem;
  box-shadow: 0 4px 12px rgba(37, 99, 235, 0.1);
}

.auth-header h2 {
  margin: 0 0 6px 0;
  font-size: 1.5rem;
  font-weight: 800;
  color: #0f172a;
}
.text-primary { color: #2563eb; }
.auth-header p { margin: 0; color: #64748b; font-size: 0.9rem; }

.auth-form {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.form-group label {
  font-size: 0.85rem;
  font-weight: 700;
  color: #334155;
}

.form-group input {
  padding: 12px 16px;
  border-radius: 12px;
  border: 1px solid #cbd5e1;
  font-size: 0.95rem;
  outline: none;
  transition: all 0.2s;
  background: #f8fafc;
}

.form-group input:focus {
  border-color: #2563eb;
  background: white;
  box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
}

.btn-submit {
  background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
  color: white;
  border: none;
  padding: 14px;
  border-radius: 12px;
  font-weight: 700;
  font-size: 1rem;
  cursor: pointer;
  box-shadow: 0 8px 20px rgba(37, 99, 235, 0.3);
  transition: all 0.25s;
  margin-top: 10px;
}

.btn-submit:hover {
  transform: translateY(-2px);
  box-shadow: 0 12px 24px rgba(37, 99, 235, 0.4);
}

.auth-footer {
  margin-top: 25px;
  text-align: center;
  font-size: 0.9rem;
  color: #64748b;
}

.auth-footer a {
  color: #2563eb;
  font-weight: 700;
  text-decoration: none;
}
.auth-footer a:hover { text-decoration: underline; }
.back-link { color: #64748b !important; font-size: 0.85rem; }
</style>
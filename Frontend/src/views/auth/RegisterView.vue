<template>
  <div class="auth-container">
    <div class="auth-glow glow-one"></div>
    <div class="auth-glow glow-two"></div>

    <div class="auth-card">

      <!-- BRAND -->
      <div class="brand">
        <div class="brand-icon">
          <i class="fa-solid fa-school"></i>
        </div>

        <div>
          <h1>SchoolCare</h1>
          <span>Sistem Informasi Sarana & Prasarana</span>
        </div>
      </div>

      <!-- HEADER -->
      <div class="auth-header">
        <h2>Buat Akun 👋</h2>
        <p>Daftarkan akun untuk menggunakan layanan SchoolCare.</p>
      </div>

      <!-- ERROR -->
      <div
        v-if="errorMessage"
        class="error-message"
      >
        <i class="fa-solid fa-circle-exclamation"></i>
        <span>{{ errorMessage }}</span>
      </div>

      <!-- SUCCESS -->
      <div
        v-if="successMessage"
        class="success-message"
      >
        <i class="fa-solid fa-circle-check"></i>
        <span>{{ successMessage }}</span>
      </div>

      <!-- FORM -->
      <form @submit.prevent="handleRegister">

        <!-- NAMA -->
        <div class="form-group">
          <label for="name">
            Nama
          </label>

          <div class="input-wrapper">
            <i class="fa-regular fa-user"></i>

            <input
              id="name"
              v-model="name"
              type="text"
              placeholder="Masukkan nama"
              required
            />
          </div>
        </div>

        <!-- EMAIL -->
        <div class="form-group">
          <label for="email">
            Email
          </label>

          <div class="input-wrapper">
            <i class="fa-regular fa-envelope"></i>

            <input
              id="email"
              v-model="email"
              type="email"
              placeholder="Masukkan email"
              required
            />
          </div>
        </div>

        <!-- PASSWORD -->
        <div class="form-group">
          <label for="password">
            Password
          </label>

          <div class="input-wrapper">
            <i class="fa-solid fa-lock"></i>

            <input
              id="password"
              v-model="password"
              type="password"
              placeholder="Masukkan password"
              required
            />
          </div>
        </div>

        <!-- KONFIRMASI PASSWORD -->
        <div class="form-group">
          <label for="password_confirmation">
            Konfirmasi Password
          </label>

          <div class="input-wrapper">
            <i class="fa-solid fa-lock"></i>

            <input
              id="password_confirmation"
              v-model="passwordConfirmation"
              type="password"
              placeholder="Ulangi password"
              required
            />
          </div>
        </div>

        <!-- BUTTON -->
        <button
          type="submit"
          class="register-button"
          :disabled="isLoading"
        >
          <span v-if="!isLoading">
            <i class="fa-solid fa-user-plus"></i>
            Daftar
          </span>

          <span v-else>
            <i class="fa-solid fa-spinner fa-spin"></i>
            Memproses...
          </span>
        </button>

      </form>

      <!-- LOGIN -->
      <div class="login-link">
        <span>Sudah punya akun?</span>

        <button
          type="button"
          @click="router.push('/login')"
        >
          Login sekarang
        </button>
      </div>

      <!-- BACK -->
      <button
        class="back-button"
        type="button"
        @click="router.push('/')"
      >
        <i class="fa-solid fa-arrow-left"></i>
        Kembali ke halaman utama
      </button>

    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import api from '../../utils/api'

const router = useRouter()

const name = ref('')
const email = ref('')
const password = ref('')
const passwordConfirmation = ref('')

const errorMessage = ref('')
const successMessage = ref('')
const isLoading = ref(false)

const handleRegister = async () => {
  errorMessage.value = ''
  successMessage.value = ''

  if (
    password.value !==
    passwordConfirmation.value
  ) {
    errorMessage.value =
      'Konfirmasi password tidak sama.'
    return
  }

  isLoading.value = true

  try {
    await api.post('/register', {
      name: name.value,
      email: email.value,
      password: password.value,
      password_confirmation:
        passwordConfirmation.value,
    })

    successMessage.value =
      'Registrasi berhasil. Silakan login.'

    setTimeout(() => {
      router.push('/login')
    }, 1000)

  } catch (error) {

    if (error.response?.status === 422) {

      const errors =
        error.response.data?.errors

      if (errors) {
        const firstError =
          Object.values(errors)[0]

        errorMessage.value =
          Array.isArray(firstError)
            ? firstError[0]
            : 'Data yang dimasukkan tidak valid.'
      } else {
        errorMessage.value =
          'Data registrasi tidak valid.'
      }

    } else if (error.request) {

      errorMessage.value =
        'Tidak bisa terhubung ke server. Pastikan backend sedang berjalan.'

    } else {

      errorMessage.value =
        'Terjadi kesalahan, coba lagi.'
    }

  } finally {
    isLoading.value = false
  }
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap');

* {
  box-sizing: border-box;
}

.auth-container {
  min-height: 100vh;
  position: relative;
  overflow: hidden;

  display: flex;
  align-items: center;
  justify-content: center;

  padding: 30px 20px;

  background:
    radial-gradient(
      circle at top left,
      rgba(37, 99, 235, 0.08),
      transparent 35%
    ),
    radial-gradient(
      circle at bottom right,
      rgba(124, 58, 237, 0.08),
      transparent 35%
    ),
    #f8fafc;

  font-family: 'Inter', sans-serif;
}

.auth-glow {
  position: absolute;

  border-radius: 50%;

  filter: blur(80px);

  pointer-events: none;
}

.glow-one {
  width: 260px;
  height: 260px;

  background: rgba(37, 99, 235, 0.12);

  top: -80px;
  left: -80px;
}

.glow-two {
  width: 280px;
  height: 280px;

  background: rgba(124, 58, 237, 0.12);

  right: -100px;
  bottom: -100px;
}

.auth-card {
  width: 100%;
  max-width: 450px;

  position: relative;
  z-index: 2;

  background: rgba(255, 255, 255, 0.96);

  border: 1px solid #e5e7eb;

  border-radius: 24px;

  padding: 38px;

  box-shadow:
    0 20px 60px rgba(15, 23, 42, 0.08);
}

.brand {
  display: flex;
  align-items: center;

  gap: 13px;

  margin-bottom: 32px;
}

.brand-icon {
  width: 48px;
  height: 48px;

  display: flex;
  align-items: center;
  justify-content: center;

  border-radius: 14px;

  background:
    linear-gradient(
      135deg,
      #2563eb,
      #7c3aed
    );

  color: white;

  font-size: 21px;
}

.brand h1 {
  margin: 0;

  font-family:
    'Plus Jakarta Sans',
    sans-serif;

  font-size: 21px;

  font-weight: 800;

  color: #111827;
}

.brand span {
  display: block;

  margin-top: 3px;

  font-size: 11px;

  color: #64748b;
}

.auth-header {
  margin-bottom: 23px;
}

.auth-header h2 {
  margin: 0 0 8px;

  font-family:
    'Plus Jakarta Sans',
    sans-serif;

  font-size: 27px;

  font-weight: 800;

  color: #111827;
}

.auth-header p {
  margin: 0;

  color: #64748b;

  font-size: 14px;

  line-height: 1.6;
}

.error-message,
.success-message {
  display: flex;
  align-items: center;

  gap: 9px;

  padding: 12px 14px;

  margin-bottom: 18px;

  border-radius: 12px;

  font-size: 13px;
}

.error-message {
  background: #fef2f2;

  border: 1px solid #fecaca;

  color: #dc2626;
}

.success-message {
  background: #f0fdf4;

  border: 1px solid #bbf7d0;

  color: #16a34a;
}

.form-group {
  margin-bottom: 17px;
}

.form-group label {
  display: block;

  margin-bottom: 8px;

  color: #374151;

  font-size: 13px;

  font-weight: 600;
}

.input-wrapper {
  position: relative;
}

.input-wrapper i {
  position: absolute;

  left: 15px;
  top: 50%;

  transform: translateY(-50%);

  color: #94a3b8;

  font-size: 14px;
}

.input-wrapper input {
  width: 100%;
  height: 48px;

  padding:
    0
    15px
    0
    43px;

  border:
    1px solid
    #e2e8f0;

  border-radius: 12px;

  outline: none;

  color: #1e293b;

  background: white;

  font-family:
    'Inter',
    sans-serif;

  font-size: 13px;

  transition: 0.2s;
}

.input-wrapper input:focus {
  border-color: #2563eb;

  box-shadow:
    0 0 0 3px
    rgba(37, 99, 235, 0.08);
}

.input-wrapper input::placeholder {
  color: #94a3b8;
}

.register-button {
  width: 100%;
  height: 49px;

  border: none;

  border-radius: 12px;

  background:
    linear-gradient(
      135deg,
      #2563eb,
      #7c3aed
    );

  color: white;

  font-family:
    'Inter',
    sans-serif;

  font-size: 14px;

  font-weight: 700;

  cursor: pointer;

  transition:
    transform 0.2s,
    box-shadow 0.2s;
}

.register-button:hover:not(:disabled) {
  transform: translateY(-2px);

  box-shadow:
    0 10px 25px
    rgba(37, 99, 235, 0.2);
}

.register-button:disabled {
  opacity: 0.7;

  cursor: not-allowed;
}

.register-button i {
  margin-right: 7px;
}

.login-link {
  display: flex;

  justify-content: center;

  gap: 5px;

  margin-top: 20px;

  font-size: 13px;

  color: #64748b;
}

.login-link button {
  padding: 0;

  border: none;

  background: none;

  color: #2563eb;

  font-family: inherit;

  font-size: 13px;

  font-weight: 700;

  cursor: pointer;
}

.login-link button:hover {
  text-decoration: underline;
}

.back-button {
  display: flex;

  align-items: center;
  justify-content: center;

  gap: 7px;

  width: 100%;

  margin-top: 18px;

  padding-top: 17px;

  border: none;

  border-top:
    1px solid
    #f1f5f9;

  background: none;

  color: #64748b;

  font-family: inherit;

  font-size: 12px;

  cursor: pointer;
}

.back-button:hover {
  color: #2563eb;
}

@media (max-width: 480px) {
  .auth-card {
    padding: 28px 22px;

    border-radius: 20px;
  }

  .auth-header h2 {
    font-size: 23px;
  }
}
</style>
<template>
  <header class="navbar">

    <div class="navbar-left">

      <div class="breadcrumb">
        <span>Administrator</span>

        <i class="fa-solid fa-chevron-right"></i>

        <strong>{{ pageTitle }}</strong>
      </div>

      <h2>
        {{ pageTitle }}
      </h2>

      <p>
        Kelola sistem SchoolCare dengan mudah.
      </p>

    </div>


    <div class="navbar-right">

      <!-- SEARCH -->
      <div class="search-box">

        <i class="fa-solid fa-magnifying-glass"></i>

        <input
          type="text"
          placeholder="Cari sesuatu..."
          @input="handleSearch"
        />

      </div>


      <!-- NOTIFICATION -->
      <button
        class="notification-button"
        type="button"
        @click="goToPengajuan"
      >

        <i class="fa-regular fa-bell"></i>

        <span
          v-if="pendingCount > 0"
          class="notification-badge"
        >
          {{ pendingCount }}
        </span>

      </button>


      <!-- PROFILE -->
      <div class="navbar-profile">

        <div class="navbar-avatar">
          A
        </div>

        <div class="navbar-profile-text">
          <strong>Admin Sekolah</strong>
          <span>Administrator</span>
        </div>

      </div>

    </div>

  </header>
</template>

<script setup>

import { useRouter } from 'vue-router'

const router = useRouter()

defineProps({

  pageTitle: {
    type: String,
    default: 'Dashboard'
  },

  pendingCount: {
    type: Number,
    default: 0
  }

})

const emit = defineEmits([
  'search'
])

const handleSearch = (event) => {

  emit(
    'search',
    event.target.value
  )

}

const goToPengajuan = () => {

  router.push('/admin/pengajuan')

}

</script>

<style scoped>

.navbar {
  min-height: 88px;

  display: flex;
  align-items: center;
  justify-content: space-between;

  gap: 25px;

  padding: 18px 28px;

  background: #fff;
  border-bottom: 1px solid #e2e8f0;

  font-family:
    'Plus Jakarta Sans',
    'Inter',
    sans-serif;
}


/* LEFT */

.navbar-left {
  min-width: 0;
}

.breadcrumb {
  display: flex;
  align-items: center;
  gap: 7px;

  margin-bottom: 5px;

  color: #94a3b8;

  font-size: .57rem;
  font-weight: 600;
}

.breadcrumb i {
  font-size: .45rem;
}

.breadcrumb strong {
  color: #2563eb;
}

.navbar-left h2 {
  margin: 0;

  color: #0f172a;

  font-size: 1.05rem;
  font-weight: 800;

  letter-spacing: -.02em;
}

.navbar-left p {
  margin: 3px 0 0;

  color: #94a3b8;

  font-size: .6rem;
}


/* RIGHT */

.navbar-right {
  display: flex;
  align-items: center;
  gap: 12px;
}


/* SEARCH */

.search-box {
  width: 210px;
  height: 38px;

  display: flex;
  align-items: center;
  gap: 9px;

  padding: 0 12px;

  background: #f8fafc;
  border: 1px solid #e2e8f0;
  border-radius: 10px;
}

.search-box i {
  color: #94a3b8;
  font-size: .65rem;
}

.search-box input {
  width: 100%;

  border: 0;
  outline: 0;

  background: transparent;

  color: #334155;

  font-family: inherit;
  font-size: .62rem;
}

.search-box input::placeholder {
  color: #94a3b8;
}


/* NOTIFICATION */

.notification-button {
  position: relative;

  width: 38px;
  height: 38px;

  display: flex;
  align-items: center;
  justify-content: center;

  border: 1px solid #e2e8f0;
  border-radius: 10px;

  background: #fff;
  color: #64748b;

  cursor: pointer;
}

.notification-button:hover {
  color: #2563eb;
  background: #eff6ff;
}

.notification-button > i {
  font-size: .78rem;
}

.notification-badge {
  position: absolute;

  top: -5px;
  right: -5px;

  min-width: 17px;
  height: 17px;

  display: flex;
  align-items: center;
  justify-content: center;

  padding: 0 4px;

  border: 2px solid #fff;
  border-radius: 20px;

  background: #ef4444;
  color: #fff;

  font-size: .45rem;
  font-weight: 800;
}


/* PROFILE */

.navbar-profile {
  display: flex;
  align-items: center;
  gap: 9px;

  padding-left: 5px;
}

.navbar-avatar {
  width: 36px;
  height: 36px;

  display: flex;
  align-items: center;
  justify-content: center;

  border-radius: 10px;

  background:
    linear-gradient(
      135deg,
      #2563eb,
      #7c3aed
    );

  color: #fff;

  font-size: .68rem;
  font-weight: 800;
}

.navbar-profile-text {
  display: flex;
  flex-direction: column;
}

.navbar-profile-text strong {
  color: #334155;
  font-size: .62rem;
  font-weight: 800;
}

.navbar-profile-text span {
  margin-top: 2px;
  color: #94a3b8;
  font-size: .52rem;
}


/* RESPONSIVE */

@media (max-width: 900px) {

  .search-box {
    width: 160px;
  }

  .navbar-profile-text {
    display: none;
  }

}

@media (max-width: 650px) {

  .navbar {
    padding: 16px 20px;
  }

  .search-box {
    display: none;
  }

  .navbar-left p {
    display: none;
  }

}

</style>
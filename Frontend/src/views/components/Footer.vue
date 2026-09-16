<template>
  <footer class="admin-footer">

    <div class="footer-left">

      <div class="footer-logo">
        <i class="fa-solid fa-school"></i>
      </div>

      <div class="footer-brand">
        <strong>SchoolCare</strong>

        <span>
          Sistem Manajemen Sarana Prasarana Sekolah
        </span>
      </div>

    </div>


    <div class="footer-right">

      <span>
        © 2026 SchoolCare
      </span>

      <span class="dot">
        •
      </span>

      <span class="online">
        <i class="fa-solid fa-circle"></i>
        Sistem Online
      </span>

    </div>

  </footer>
</template>

<style scoped>

.admin-footer {
  min-height: 65px;

  display: flex;
  align-items: center;
  justify-content: space-between;

  gap: 20px;

  padding: 14px 28px;

  background: #fff;
  border-top: 1px solid #e2e8f0;

  font-family:
    'Plus Jakarta Sans',
    'Inter',
    sans-serif;
}


/* LEFT */

.footer-left {
  display: flex;
  align-items: center;
  gap: 10px;
}

.footer-logo {
  width: 34px;
  height: 34px;

  display: flex;
  align-items: center;
  justify-content: center;

  border-radius: 10px;

  background: #eff6ff;
  color: #2563eb;

  font-size: .75rem;
}

.footer-brand {
  display: flex;
  flex-direction: column;
}

.footer-brand strong {
  color: #334155;
  font-size: .65rem;
  font-weight: 800;
}

.footer-brand span {
  margin-top: 2px;

  color: #94a3b8;

  font-size: .52rem;
}


/* RIGHT */

.footer-right {
  display: flex;
  align-items: center;
  gap: 8px;

  color: #94a3b8;

  font-size: .55rem;
  font-weight: 600;
}

.dot {
  color: #cbd5e1;
}

.online {
  display: flex;
  align-items: center;
  gap: 5px;
}

.online i {
  color: #22c55e;
  font-size: .38rem;
}


/* RESPONSIVE */

@media (max-width: 650px) {

  .admin-footer {
    padding: 14px 20px;
  }

  .footer-right {
    display: none;
  }

}

</style>
<template>
  <footer class="footer">
    <p>© {{ currentYear }} SchoolCare. All rights reserved.</p>
  </footer>
</template>

<script setup>
const currentYear = new Date().getFullYear()
</script>

<style scoped>
.footer {
  border-top: 1px solid #e2e8f0;
  background: white;
  padding: 18px 32px;
  margin-top: auto;
}
.footer p {
  margin: 0;
  color: #94a3b8;
  font-size: 11px;
  text-align: center;
}
</style>
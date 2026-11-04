<script setup>
import { RouterView } from 'vue-router'
</script>

<template>
  <div class="bg-dark text-light min-vh-100">
    <nav class="navbar navbar-expand-lg navbar-dark bg-black border-bottom border-secondary">
      <div class="container">
        <a class="navbar-brand fw-bold" href="#">Barber Studio</a>
        <div class="d-flex gap-3">
          <router-link class="nav-link" to="/">Home</router-link>
          <router-link class="nav-link" to="/">News</router-link>
        </div>
      </div>
    </nav>

    <main class="container py-4">
      <RouterView />
    </main>
  </div>
</template>

<style scoped>
.nav-link {
  color: rgba(255, 255, 255, 0.8);
  text-decoration: none;
}

.nav-link:hover {
  color: #fff;
}
</style>

<script setup>
import { RouterView, useRoute } from 'vue-router'
import { ref, watch } from 'vue'
import { isAuthenticated } from '@/services/auth'
import { useToast } from '@/services/toast'

const checkAuth = ref(isAuthenticated())
const route = useRoute()
const { toast, dismissToast } = useToast()

// Đồng bộ trạng thái đăng nhập để menu cập nhật sau login hoặc logout.
watch(() => route.fullPath, () => {
  checkAuth.value = isAuthenticated()

})
</script>

<template>
  <div class="bg-dark text-light min-vh-100">
    <nav class="navbar navbar-expand-lg navbar-dark bg-black border-bottom border-secondary">
      <div class="container">
        <a class="navbar-brand fw-bold" href="#">Barber Studio</a>
        <div class="d-flex gap-3">
          <router-link class="nav-link" to="/">Home</router-link>
          <router-link class="nav-link" to="/">News</router-link>
          <router-link class="nav-link" to="/">About</router-link>
          <router-link class="nav-link" to="/catalog" v-if="checkAuth">Catalog</router-link>
          <router-link class="nav-link" to="/login" v-if="!checkAuth">Login</router-link>
          <router-link class="nav-link" to="/profile" v-else>Profile</router-link>
        </div>
      </div>
    </nav>

    <main class="container py-4">
      <div
        v-if="toast"
        class="alert d-flex align-items-center justify-content-between gap-3 mb-3"
        :class="`alert-${toast.type}`"
        :role="toast.type === 'danger' ? 'alert' : 'status'"
        aria-live="polite"
        aria-atomic="true"
      >
        <span>{{ toast.message }}</span>
        <button
          type="button"
          class="btn-close flex-shrink-0"
          aria-label="Đóng thông báo"
          @click="dismissToast"
        ></button>
      </div>
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

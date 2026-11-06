<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import api from '@/services/api'
import { setAuthSession } from '@/services/auth'
import { useToast } from '@/services/toast'

const router = useRouter()
const { showToast } = useToast()
const loading = ref(false)
const form = ref({
  email: '',
  password: ''
})

// Lưu JWT và thông tin user từ BE trước khi chuyển trang để route guard nhận diện phiên đăng nhập.
  const fetchApiLogin = async () => {
  try {
    loading.value = true

    const response = await api.post('?action=api-login', {
      email: form.value.email,
      password: form.value.password
    })

    const token = response.data?.token
    const user = response.data?.user

    setAuthSession(token, user)
    showToast(response.data?.message || 'Đăng nhập thành công', 'success')
    router.push('/')
  } catch (error) {
    showToast(error.response?.data?.message || 'Lỗi đăng nhập', 'danger')
    console.error('Login failed:', error)
  } finally {
    loading.value = false
  }
}
</script>

<template>
  <div class="container py-4">
    <h1>Login</h1>

    <form @submit.prevent="fetchApiLogin">
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input
          id="email"
          v-model="form.email"
          type="email"
          class="form-control"
          autocomplete="email"
          required
        />
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input
          id="password"
          v-model="form.password"
          type="password"
          class="form-control"
          autocomplete="current-password"
          required
        />
      </div>

      <button type="submit" class="btn btn-primary" :disabled="loading">
        {{ loading ? 'Đang đăng nhập...' : 'Login' }}
      </button>
      <router-link to="/forgot-password" class="d-block mt-2">Quên mật khẩu?</router-link>
      <p>Chưa có tài khoản </p>
      <router-link to="/register" class="btn btn-secondary">Đăng ký</router-link>
    </form>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import api from '@/services/api'
import { useToast } from '@/services/toast'

const { showToast } = useToast()
const email = ref('')
const loading = ref(false)

// BE luôn trả thông báo chung để không tiết lộ email có đăng ký hay không.
const requestReset = async () => {
  try {
    loading.value = true
    const response = await api.post('?action=api-forgot-password', { email: email.value })
    showToast(response.data?.message || 'Nếu email được đăng ký, hướng dẫn sẽ được gửi.', 'success')
  } catch (error) {
    showToast(error.response?.data?.message || 'Không thể gửi yêu cầu đặt lại mật khẩu.', 'danger')
    console.error('Forgot password request failed:', error)
  } finally {
    loading.value = false
  }
}
</script>

<template>
  <section class="py-4">
    <h1>Quên mật khẩu</h1>
    <form @submit.prevent="requestReset">
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input
          id="email"
          v-model="email"
          type="email"
          class="form-control"
          autocomplete="email"
          required
        />
      </div>

      <button type="submit" class="btn btn-primary" :disabled="loading">
        {{ loading ? 'Đang gửi...' : 'Gửi hướng dẫn' }}
      </button>
      <router-link to="/login" class="btn btn-secondary ms-2">Quay lại đăng nhập</router-link>
    </form>
  </section>
</template>
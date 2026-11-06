<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import api from '@/services/api'
import { useToast } from '@/services/toast'

const router = useRouter()
const { showToast } = useToast()
const loading = ref(false)
const form = ref({
  currentPassword: '',
  newPassword: '',
  passwordConfirmation: ''
})

// api service tự gắn Bearer token; BE xác thực phiên và mật khẩu hiện tại.
  const changePassword = async () => {
  if (form.value.newPassword !== form.value.passwordConfirmation) {
    showToast('Mật khẩu xác nhận không khớp.', 'danger')
    return
  }

  try {
    loading.value = true
    const response = await api.post('?action=api-change-password', {
      current_password: form.value.currentPassword,
      new_password: form.value.newPassword
    })
    showToast(response.data?.message || 'Đổi mật khẩu thành công.', 'success')
    router.push('/profile')
  } catch (error) {
    showToast(error.response?.data?.message || 'Không thể đổi mật khẩu.', 'danger')
    console.error('Change password failed:', error)
  } finally {
    loading.value = false
  }
}
</script>

<template>
  <section class="py-4">
    <h1>Đổi mật khẩu</h1>

    <form @submit.prevent="changePassword">
      <div class="mb-3">
        <label for="current-password" class="form-label">Mật khẩu hiện tại</label>
        <input
          id="current-password"
          v-model="form.currentPassword"
          type="password"
          class="form-control"
          autocomplete="current-password"
          required
        />
      </div>

      <div class="mb-3">
        <label for="new-password" class="form-label">Mật khẩu mới</label>
        <input
          id="new-password"
          v-model="form.newPassword"
          type="password"
          class="form-control"
          autocomplete="new-password"
          minlength="8"
          required
        />
      </div>

      <div class="mb-3">
        <label for="password-confirmation" class="form-label">Xác nhận mật khẩu mới</label>
        <input
          id="password-confirmation"
          v-model="form.passwordConfirmation"
          type="password"
          class="form-control"
          autocomplete="new-password"
          required
        />
      </div>

      <button type="submit" class="btn btn-primary" :disabled="loading">
        {{ loading ? 'Đang cập nhật...' : 'Đổi mật khẩu' }}
      </button>
      <router-link to="/profile" class="btn btn-secondary ms-2">Hủy</router-link>
    </form>
  </section>
</template>
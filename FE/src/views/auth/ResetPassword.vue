<script setup>
import { onMounted, ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import api from '@/services/api'
import { useToast } from '@/services/toast'

const route = useRoute()
const router = useRouter()
const { showToast } = useToast()
const token = typeof route.query.token === 'string' ? route.query.token : ''
const checkingToken = ref(true)
const tokenValid = ref(false)
const loading = ref(false)
const form = ref({
  newPassword: '',
  passwordConfirmation: ''
})

// GET chỉ kiểm tra token; token chỉ bị tiêu thụ khi gửi POST đổi mật khẩu.
onMounted(async () => {
  if (!token) {
    showToast('Liên kết đặt lại mật khẩu không hợp lệ hoặc đã hết hạn.', 'danger')
    checkingToken.value = false
    return
  }

  try {
    await api.get('?action=api-reset-password', { params: { token } })
    tokenValid.value = true
  } catch (error) {
    showToast(error.response?.data?.message || 'Liên kết đặt lại mật khẩu không hợp lệ hoặc đã hết hạn.', 'danger')
  } finally {
    checkingToken.value = false
  }
})

// FE kiểm tra xác nhận, sau đó gửi token cùng mật khẩu mới để BE dùng token một lần.
const resetPassword = async () => {
  if (form.value.newPassword !== form.value.passwordConfirmation) {
    showToast('Mật khẩu xác nhận không khớp.', 'danger')
    return
  }

  try {
    loading.value = true
    const response = await api.post('?action=api-reset-password', {
      token,
      new_password: form.value.newPassword
    })
    showToast(response.data?.message || 'Đặt lại mật khẩu thành công.', 'success')
    router.push('/login')
  } catch (error) {
    showToast(error.response?.data?.message || 'Không thể đặt lại mật khẩu.', 'danger')
    console.error('Reset password failed:', error)
  } finally {
    loading.value = false
  }
}
</script>

<template>
  <section class="py-4">
    <h1>Đặt lại mật khẩu</h1>

    <p v-if="checkingToken">Đang kiểm tra liên kết...</p>

    <form v-else-if="tokenValid" @submit.prevent="resetPassword">
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
        <label for="password-confirmation" class="form-label">Xác nhận mật khẩu</label>
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
        {{ loading ? 'Đang cập nhật...' : 'Đặt lại mật khẩu' }}
      </button>
    </form>

    <router-link v-else to="/forgot-password" class="btn btn-secondary">
      Yêu cầu liên kết mới
    </router-link>
  </section>
</template>
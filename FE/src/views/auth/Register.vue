<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import api from '@/services/api'
import { useToast } from '@/services/toast'

const router = useRouter()
const { showToast } = useToast()
const loading = ref(false)
const form = ref({
	email: '',
	password: '',
	passwordConfirmation: ''
})

const register = async () => {
	// BE chỉ nhận email/password; passwordConfirmation chỉ dùng để kiểm tra ở FE.
// BE chỉ nhận email/password; passwordConfirmation chỉ dùng để kiểm tra ở FE.

	if (form.value.password !== form.value.passwordConfirmation) {
		showToast('Mật khẩu xác nhận không khớp', 'danger')
		return
	}

	try {
		loading.value = true
		const response = await api.post('?action=api-register', {
			email: form.value.email,
			password: form.value.password
		})

		showToast(response.data?.message || 'Đăng ký thành công. Vui lòng xác minh email.', 'success')
		router.push('/login')
	} catch (error) {
		showToast(error.response?.data?.message || 'Đăng ký thất bại', 'danger')
		console.error('Register failed:', error)
	} finally {
		loading.value = false
	}
}
</script>

<template>
	<div class="container py-4">
		<h1>Đăng ký</h1>

		<form @submit.prevent="register">
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
				<label for="password" class="form-label">Mật khẩu</label>
				<input
					id="password"
					v-model="form.password"
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
				{{ loading ? 'Đang đăng ký...' : 'Đăng ký' }}
			</button>
			<router-link to="/login" class="btn btn-secondary ms-2">Đăng nhập</router-link>
		</form>
	</div>
</template>

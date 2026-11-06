<script setup>
import { getUser, clearAuthSession } from '@/services/auth' // import hàm getUser và clearAuth từ file auth.js
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useToast } from '@/services/toast'
import api from '@/services/api'

const user = getUser() || {}
const router = useRouter()
const {showToast} = useToast()
const loading = ref(false)

// JWT stateless nên luôn xóa session cục bộ, kể cả khi request logout thất bại.
const handleLogout = async () => {
    if(!confirm('Bạn có chắc chắn muốn đăng xuất không?')) return
    try{
        loading.value = true
        const response = await api.post('?action=api-logout')
        showToast(response.data?.message || 'Đăng xuất thành công', 'success')
    }catch(err){
        console.error('Error during logout:', err)
		showToast('Có lỗi xảy ra khi đăng xuất', 'danger')
    }finally{
        loading.value = false
        clearAuthSession()
        router.push('/')
    }
}

</script>

<template>
	<section>
		<h1>Thông tin cá nhân</h1>

		<table class="table">
			<tbody>
				<tr>
					<th scope="row">ID</th>
					<td>{{ user.id || '-' }}</td>
				</tr>
				<tr>
					<th scope="row">Email</th>
					<td>{{ user.email || '-' }}</td>
				</tr>
				<tr>
					<th scope="row">Vai trò</th>
					<td>{{ user.role || '-' }}</td>
				</tr>
			</tbody>
		</table>

		<router-link to="/change-password" class="btn btn-primary me-2">Đổi mật khẩu</router-link>

		<button type="button" class="btn btn-danger" @click="handleLogout" :disabled="loading">
            {{ loading ? 'Đang xử lý...' : 'Đăng xuất' }}
		</button>
		<router-link to="/" class="btn btn-secondary">Quay lại</router-link>
	</section>
</template>

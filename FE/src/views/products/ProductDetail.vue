<script setup>
// Trang chi tiết sản phẩm gọi API sản phẩm và comments rồi hiển thị nguyên response.
import { onMounted, ref } from 'vue'
import { useRoute } from 'vue-router'
import api from '@/services/api'
import { dd } from '@/helpers/dd'

const route = useRoute()
// Lưu nguyên response từ API để helper dd() in đúng cả status và dữ liệu.
const productResponse = ref(null)
const commentsResponse = ref(null)
const loading = ref(false)
const errorMessage = ref('')

// Gọi hai endpoint GET dùng chung slug; comments lấy trang đầu tối đa 10 dòng.
async function fetchProductDetails() {
  loading.value = true
  errorMessage.value = ''

  try {
    const slug = route.params.slug
    const [productResult, commentsResult] = await Promise.all([
      api.get('/?action=api-product-detail', { params: { slug } }),
      api.get('/?action=api-product-comments', {
        params: { slug, page: 1, per_page: 10 },
      }),
    ])

    productResponse.value = productResult.data
    commentsResponse.value = commentsResult.data
  } catch (error) {
    errorMessage.value = error.response?.data?.message || 'Không tải được dữ liệu sản phẩm'
  } finally {
    loading.value = false
  }
}

// onMounted chạy một lần khi người dùng mở trang.
onMounted(fetchProductDetails)
</script>

<template>
  <main class="container py-4">
    <h1 class="h4 mb-3">Product detail</h1>

    <!-- Hiển thị trạng thái tải hoặc lỗi chung từ một trong hai endpoint. -->
    <p v-if="loading" class="mb-3">Đang tải dữ liệu...</p>
    <p v-else-if="errorMessage" class="alert alert-danger" role="alert">
      {{ errorMessage }}
    </p>

    <!-- In nguyên response của endpoint chi tiết sản phẩm. -->
    <section class="mb-4">
      <h2 class="h6">api-product-detail</h2>
      <pre v-if="productResponse" class="border rounded-1 bg-light p-3 overflow-auto">{{ dd(productResponse) }}</pre>
    </section>

    <!-- In nguyên response comments, bao gồm danh sách và phân trang. -->
    <section>
      <h2 class="h6">api-product-comments</h2>
      <pre v-if="commentsResponse" class="border rounded-1 bg-light p-3 overflow-auto">{{ dd(commentsResponse) }}</pre>
    </section>
  </main>
</template>
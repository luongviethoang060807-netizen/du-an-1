<script setup>
import { ref, onMounted } from 'vue'
import api from '@/services/api'

const products = ref([])
const loading = ref(true)
const error = ref('')

const imageUrl = (image) =>
  image ? `${api.defaults.baseURL}/uploads/products/${image}` : 'https://placehold.co/400x400?text=No+Image'

const formatPrice = (value) =>
  Number(value).toLocaleString('vi-VN', { style: 'currency', currency: 'VND' })

const fetchProducts = async () => {
  loading.value = true
  error.value = ''
  try {
    const { data } = await api.get('?action=api-products')
    products.value = data?.products?.data || []
  } catch (err) {
    error.value = 'Không thể tải sản phẩm.'
  } finally {
    loading.value = false
  }
}

onMounted(fetchProducts)
</script>

<template>
  <h1 class="mb-4">Sản phẩm</h1>
  <div v-if="loading">Đang tải...</div>
  <div v-else-if="error" class="alert alert-danger">{{ error }}</div>
  <div v-else class="row g-4">
    <div v-for="p in products" :key="p.id" class="col-6 col-md-4 col-lg-3">
      <div class="card h-100 bg-black text-light border-secondary">
        <img :src="imageUrl(p.image)" :alt="p.name" class="card-img-top" style="aspect-ratio: 1; object-fit: cover" />
        <div class="card-body">
          <small class="text-secondary">{{ p.category_name }}</small>
          <h6 class="card-title mt-1">{{ p.name }}</h6>
          <div v-if="p.sale_price">
            <span class="text-warning fw-bold">{{ formatPrice(p.sale_price) }}</span>
            <del class="text-secondary ms-2 small">{{ formatPrice(p.price) }}</del>
          </div>
          <span v-else class="text-warning fw-bold">{{ formatPrice(p.price) }}</span>
        </div>
      </div>
    </div>
  </div>
</template>
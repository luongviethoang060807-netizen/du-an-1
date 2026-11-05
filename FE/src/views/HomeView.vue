<script setup>
import { ref, onMounted } from 'vue'
import api from '../services/api'

const camchims = ref([])
const loading = ref(true)
const error = ref('')

const fetchCamChim = async () => {
  loading.value = true
  error.value = ''
  try {
    const response = await api.get('?action=api-camchim')
    camchims.value = response.data.camChims || []
  } catch (err) {
    error.value = 'Không thể tải dữ liệu. Vui lòng thử lại sau.'
  } finally {
    loading.value = false
  }
}

onMounted(fetchCamChim)
</script>

<template>
  <div class="home-view">
    <h1>Danh sách Cám Chim</h1>
    <div v-if="loading">Đang tải dữ liệu...</div>
    <div v-else-if="error">{{ error }}</div>
    <ul v-else>
      <li v-for="camchim in camchims" :key="camchim.id">
        <h2>{{ camchim.name }}</h2>
        <img class="camchim-image" :src="camchim.image" :alt="camchim.name" />
      </li>
    </ul>
  </div>
</template>

<style>
  .camchim-image {
    width: 200px;
    height: 200px;
    object-fit: cover;
    object-position: center;
    border-radius: 8px;
  }
</style>
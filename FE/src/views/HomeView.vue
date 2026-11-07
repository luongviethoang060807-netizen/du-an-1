<script setup>
import { onMounted, ref } from 'vue'
import BannerSlideshow from '@/components/BannerSlideshow.vue'
import api from '@/services/api'

// Trang chủ: tải danh sách banner từ api-banners và hiển thị carousel.

// Danh sách banner do API trả về; BannerSlideshow tự quản lý slide đang chọn.
const banners = ref([])
// Bắt đầu ở trạng thái tải để tránh nháy giao diện rỗng trước request đầu tiên.
const isLoadingBanners = ref(true)
// Lỗi tải banner được hiển thị riêng, không giả thành danh sách rỗng.
const bannerError = ref('')

// Tải banner khi trang chủ mở và khi người dùng bấm thử lại.
async function fetchBanners() {
  isLoadingBanners.value = true
  bannerError.value = ''

  try {
    // api-banners trả về status và mảng banners; image có thể null.
    const response = await api.get('/?action=api-banners')

    if (response.data?.status !== 'success' || !Array.isArray(response.data.banners)) {
      throw new Error('Dữ liệu banner không hợp lệ.')
    }

    banners.value = response.data.banners
  } catch (error) {
    bannerError.value = error.response?.data?.message || error.message || 'Không tải được banner.'
  } finally {
    isLoadingBanners.value = false
  }
}

// Tải banner một lần khi trang chủ được tạo.
onMounted(() => fetchBanners())
</script>

<template>
  <div class="home-view">
    <!-- Carousel chỉ hiện khi API tải thành công và có banner. -->
    <BannerSlideshow v-if="banners.length > 0 && !isLoadingBanners && !bannerError" :banners="banners" />

    <!-- Trạng thái chờ được giữ riêng với trạng thái danh sách rỗng. -->
    <section v-else-if="isLoadingBanners" class="home-banner-state" role="status" aria-live="polite">
      Đang tải banner...
    </section>

    <!-- Lỗi có nút tải lại để người dùng thử lại mà không cần tải lại trang. -->
    <section v-else-if="bannerError" class="home-banner-state home-banner-state--error" role="alert">
      <p>{{ bannerError }}</p>
      <button type="button" @click="fetchBanners">Thử lại</button>
    </section>

    <!-- API thành công nhưng chưa có banner. -->
    <section v-else class="home-banner-state" aria-label="Banner">
      Hiện chưa có banner.
    </section>

    <!-- Chỉ giữ tiêu đề và khoảng trống, không tạo sản phẩm mẫu. -->
    <section class="home-products-section" aria-labelledby="top-products-title">
      <div class="home-section-heading">
        <h1 id="top-products-title">Top 5 products</h1>
        <router-link class="home-view-all" to="/catalog">View all</router-link>
      </div>
      <div class="home-products-blank" aria-hidden="true"></div>
    </section>
  </div>
</template>

<style scoped>
.home-banner-state {
  display: grid;
  min-height: 240px;
  place-content: center;
  gap: 12px;
  padding: 24px;
  border-radius: 4px;
  background: #212529;
  color: #ffffff;
  text-align: center;
}

.home-banner-state p {
  margin: 0;
}

.home-banner-state button {
  justify-self: center;
  min-height: 44px;
  padding: 0 20px;
  border: 1px solid #ffffff;
  border-radius: 4px;
  background: #ffffff;
  color: #212529;
  font-weight: 600;
}

@media (min-width: 768px) {
  .home-banner-state {
    min-height: 320px;
  }
}

@media (min-width: 1200px) {
  .home-banner-state {
    min-height: 400px;
  }
}
</style>

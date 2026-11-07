<script setup>
// Khung trình bày dùng chung cho các màn hình tài khoản.
const props = defineProps({
  title: {
    type: String,
    required: true
  },
  description: {
    type: String,
    required: true
  },
  variant: {
    type: String,
    default: 'plain'
  }
})
</script>

<template>
  <div class="auth-page">
    <!-- Tiêu đề và nội dung của từng màn hình auth. -->
    <div class="row justify-content-center">
      <section class="auth-panel col-12 col-md-6 col-lg-4" :class="`auth-panel--${props.variant}`">
        <header class="auth-panel-header">
          <p class="auth-eyebrow">CLIENT PORTAL</p>
          <h1>{{ props.title }}</h1>
          <p class="auth-panel-description">{{ props.description }}</p>
        </header>

        <slot />

        <!-- Liên kết phụ tùy theo nghiệp vụ của màn hình. -->
        <div v-if="$slots.footer" class="auth-panel-footer">
          <slot name="footer" />
        </div>
      </section>
    </div>

    <!-- Ghi chú pháp lý chỉ xuất hiện ở màn hình có nội dung được cung cấp. -->
    <p v-if="$slots.note" class="auth-note">
      <slot name="note" />
    </p>
  </div>
</template>
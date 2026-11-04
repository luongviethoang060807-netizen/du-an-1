<script setup>
import { ref, onMounted } from 'vue'
import api from '../services/api'

const posts = ref([])
const loading = ref(true)
const error = ref('')

const fetchPosts = async () => {
  try {
    loading.value = true
    const { data } = await api.get('/posts')
    posts.value = Array.isArray(data) ? data : data.posts || []
  } catch (err) {
    error.value = 'Không thể kết nối tới backend. Hãy kiểm tra route API /api/posts.'
    console.error(err)
  } finally {
    loading.value = false
  }
}

onMounted(fetchPosts)
</script>

<template>
  <section class="hero">
    <div class="hero-copy">
      <p class="eyebrow">Barber Studio</p>
      <h1>Phong cách nam tính, lịch lãm và cá tính.</h1>
      <p class="subtitle">
        Cắt tóc, tạo kiểu và chăm sóc da đầu theo xu hướng hiện đại, mang đến trải nghiệm đẳng cấp.
      </p>
      <button class="primary-btn">Đặt lịch ngay</button>
    </div>

    <div class="hero-card">
      <span class="tag">Hot trend</span>
      <h3>Fade + Beardline</h3>
      <p>Kiểu tóc nam hiện đại, trẻ trung và mạnh mẽ.</p>
    </div>
  </section>

  <section class="content">
    <div class="section-head">
      <h2>Bài viết mới</h2>
    </div>

    <div v-if="loading" class="status">Đang tải dữ liệu...</div>
    <div v-else-if="error" class="status error">{{ error }}</div>

    <div v-else class="post-grid">
      <article v-for="post in posts" :key="post.id || post.slug" class="post-card">
        <img v-if="post.image" :src="post.image" :alt="post.title" />
        <div class="post-body">
          <span class="category">{{ post.category || 'Tin tức' }}</span>
          <h3>{{ post.title }}</h3>
          <p>{{ post.excerpt || post.content }}</p>
          <div class="meta">
            <span>{{ post.author || 'Barber Studio' }}</span>
            <span>{{ post.published_at || 'Mới' }}</span>
          </div>
        </div>
      </article>
    </div>
  </section>
</template>

<style scoped>
.hero {
  display: grid;
  grid-template-columns: 1.3fr 0.7fr;
  gap: 2rem;
  align-items: center;
  min-height: 420px;
  padding: 2rem 0;
}

.hero-copy {
  max-width: 700px;
}

.eyebrow {
  text-transform: uppercase;
  letter-spacing: 0.2em;
  color: #fbbf24;
  font-size: 0.75rem;
  margin-bottom: 1rem;
}

.hero-copy h1 {
  font-size: clamp(2.2rem, 5vw, 4rem);
  line-height: 1.1;
  margin: 0;
  color: #fff;
}

.subtitle {
  margin: 1rem 0 1.5rem;
  color: #d1d5db;
  font-size: 1.05rem;
  max-width: 600px;
}

.primary-btn {
  border: none;
  border-radius: 999px;
  padding: 0.9rem 1.5rem;
  background: linear-gradient(135deg, #f59e0b, #f97316);
  color: #111827;
  font-weight: 700;
  cursor: pointer;
}

.hero-card {
  background: rgba(17, 24, 39, 0.8);
  border: 1px solid rgba(255, 255, 255, 0.08);
  border-radius: 1.25rem;
  padding: 2rem;
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25);
}

.tag {
  display: inline-block;
  background: rgba(251, 191, 36, 0.12);
  border: 1px solid rgba(251, 191, 36, 0.4);
  color: #fbbf24;
  border-radius: 999px;
  padding: 0.4rem 0.7rem;
  font-size: 0.75rem;
  margin-bottom: 1rem;
}

.hero-card h3 {
  margin: 0 0 0.75rem;
  font-size: 1.6rem;
}

.hero-card p {
  color: #d1d5db;
  margin: 0;
}

.content {
  margin-top: 2rem;
}

.section-head h2 {
  margin-bottom: 1.25rem;
  font-size: 1.8rem;
}

.status {
  color: #f9fafb;
  padding: 1rem 1.25rem;
  border-radius: 0.75rem;
  background: rgba(148, 163, 184, 0.08);
}

.status.error {
  background: rgba(239, 68, 68, 0.08);
  color: #fca5a5;
}

.post-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
  gap: 1.5rem;
}

.post-card {
  overflow: hidden;
  background: rgba(15, 23, 42, 0.8);
  border: 1px solid rgba(255, 255, 255, 0.08);
  border-radius: 1rem;
  transition: transform 0.2s ease;
}

.post-card:hover {
  transform: translateY(-4px);
}

.post-card img {
  width: 100%;
  height: 220px;
  object-fit: cover;
  display: block;
}

.post-body {
  padding: 1rem;
}

.category {
  display: inline-block;
  margin-bottom: 0.75rem;
  color: #fbbf24;
  font-size: 0.75rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.08em;
}

.post-body h3 {
  margin: 0 0 0.75rem;
  font-size: 1.3rem;
  color: #fff;
}

.post-body p {
  color: #d1d5db;
  margin: 0 0 1rem;
  line-height: 1.6;
}

.meta {
  display: flex;
  justify-content: space-between;
  gap: 0.5rem;
  color: #94a3b8;
  font-size: 0.8rem;
}

@media (max-width: 768px) {
  .hero {
    grid-template-columns: 1fr;
  }
}
</style>

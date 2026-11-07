<template>
  <div class="home-view">
    <!-- Banner giữ vùng thiết kế trống đến khi nội dung thật được cung cấp. -->
    <section class="home-banner-blank" aria-label="Vùng banner"></section>

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

# Copilot Instructions cho FE project hiện tại

## Giới thiệu
Đây là project frontend Vue 3 + Vite, đang dùng:
- `vue` + `vue-router`
- `axios` cho gọi API backend
- `bootstrap 5` cho layout/style
- router theo kiểu `createWebHistory`
- API backend nằm trong thư mục `BE`, được gọi qua URL động theo origin/path hiện tại

Hãy code theo đúng cấu trúc thực tế của repo này, không suy đoán theo framework khác.

---

## 1) Công nghệ và cấu trúc dự án

### Frontend
- Dự án FE nằm trong thư mục: `FE/`
- Entry point: `FE/src/main.js`
- Router: `FE/src/router/index.js`
- Service API: `FE/src/services/api.js`
- Component chính: `FE/src/App.vue`
- Views: `FE/src/views/*.vue`

### Backend
- Dự án BE nằm trong thư mục: `BE/`
- Router API trong `BE/routes/index.php`
- Endpoint mẫu dạng:
  - `?action=api-check`
  - `?action=api-login`
  - `?action=api-products`
  - `?action=api-guns`

---

## 2) Quy tắc khi gọi API

Luôn dùng `axios` qua service đã có sẵn thay vì gọi `fetch` trực tiếp.

File chuẩn:
- `FE/src/services/api.js`

Ví dụ đúng:

```js
import api from '@/services/api'

const res = await api.get('/?action=api-guns')
const guns = res.data.guns || []
```

### Không làm
- Không hardcode `http://localhost/...` nếu không cần thiết
- Không gọi API trực tiếp bằng `fetch` khi project đã có `api.js`
- Không tạo một instance axios mới riêng nếu đã có service trung tâm

### Quy tắc base URL
`api.js` đã tự động xác định base URL theo `window.location.origin` và `pathname`:

```js
const getApiBaseUrl = () => {
  const { origin, pathname } = window.location

  if (pathname.includes('/du-an-1')) {
    return `${origin}/du-an-1/BE`
  }

  return `${origin}/BE`
}
```

Nên suy luận rằng:
- local: `http://localhost/du-an-1/BE`
- deploy: `https://domain.com/du-an-1/BE` hoặc `https://domain.com/BE`

Nếu cần thêm endpoint mới, hãy dùng format:

```js
await api.get('/?action=api-guns')
```

không phải:

```js
await axios.get('http://localhost/du-an-1/BE/?action=api-guns')
```

---

## 3) Quy tắc router Vue

Router hiện tại đang dùng `createWebHistory` và route dạng:

```js
const routes = [
  { path: '/', name: 'home', component: HomeView },
  { path: '/test', name: 'test', component: TestView }
]
```

### Khi thêm page mới
- Thêm component trong `FE/src/views/`
- Import component trong `FE/src/router/index.js`
- Thêm object route mới
- Dùng `<router-link to="/ten-route">` trong template

Ví dụ:

```vue
<router-link to="/test">Test</router-link>
```

---

## 4) Quy tắc component Vue

Thường dùng pattern:

```vue
<script setup>
import { ref, onMounted } from 'vue'
import api from '@/services/api'

const items = ref([])

onMounted(async () => {
  const res = await api.get('/?action=api-guns')
  items.value = res.data.guns || []
})
</script>
```

### Mẫu chuẩn
- Dùng `script setup`
- Dùng `ref` cho state
- Dùng `onMounted` cho fetch data lần đầu
- Render bằng `v-for` nếu là list
- Không dùng `this` trong Composition API

---

## 5) Quy tắc Bootstrap

Project đang import Bootstrap CSS ở `FE/src/main.js`:

```js
import 'bootstrap/dist/css/bootstrap.min.css'
```

### Khi viết giao diện
- ưu tiên dùng class Bootstrap như `container`, `row`, `col`, `card`, `btn`, `table`, `d-flex`, `gap-*`, `text-*`, `bg-*`
- Đừng tạo style phức tạp nếu Bootstrap có thể làm được
- Nếu cần custom CSS, thêm vào `style.css` hoặc scoped style trong component

Ví dụ đúng:

```vue
<div class="container py-4">
  <div class="card shadow-sm">
    <div class="card-body">
      <h3 class="card-title">Danh sách súng</h3>
    </div>
  </div>
</div>
```

---

## 6) Mẫu xử lý dữ liệu API

Hầu hết response backend sẽ có dạng:

```json
{
  "status": "success",
  "guns": [
    { "id": 1, "name": "M4A1" }
  ]
}
```

Khi render, hãy chuẩn hóa như sau:

```js
const guns = res.data.guns || []
```

Nếu có field khác, cho phép fallback:

```js
const items = res.data.data || res.data.guns || []
```

---

## 7) Quy tắc khi viết code mới cho AI

### Bắt buộc
- Code theo cấu trúc Vue 3 + Vite hiện có
- Dùng `api` service thay vì direct axios
- Dùng router hiện có và `router-link`
- Dùng Bootstrap class thay vì CSS hand-rolled khi có thể
- Giữ tên file và đường dẫn theo chuẩn hiện có

### Nên làm
- Tạo view/component đơn giản, dễ đọc
- Sử dụng `ref` và `computed` nếu cần
- Thêm xử lý loading / empty state
- Luôn kiểm tra response API trước khi render

### Không nên làm
- Không viết route phức tạp không cần thiết
- Không thay đổi `api.js` nếu chưa cần thiết
- Không tạo cấu trúc project mới khi đã có `src/`, `router/`, `views/`, `services/`
- Không bỏ qua xử lý error từ Axios

---

## 8) Mẫu code chuẩn cho danh sách dữ liệu

```vue
<script setup>
import { ref, onMounted } from 'vue'
import api from '@/services/api'

const guns = ref([])
const loading = ref(false)

onMounted(async () => {
  loading.value = true

  try {
    const res = await api.get('/?action=api-guns')
    guns.value = res.data.guns || []
  } catch (error) {
    console.error('Load guns failed:', error)
    guns.value = []
  } finally {
    loading.value = false
  }
})
</script>

<template>
  <div class="container py-4">
    <h2>Danh sách súng</h2>

    <div v-if="loading" class="text-muted">Đang tải...</div>
    <div v-else-if="guns.length === 0" class="text-muted">Không có dữ liệu</div>

    <div v-else class="row g-3">
      <div v-for="gun in guns" :key="gun.id" class="col-md-4">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <h5 class="card-title">{{ gun.name }}</h5>
            <p class="card-text mb-1">Loại: {{ gun.category }}</p>
            <p class="card-text mb-1">Giá: {{ gun.price }}</p>
            <p class="card-text mb-0">Kho: {{ gun.stock }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
```

---

## 9) Kết luận
AI nên làm việc theo hướng:
- FE Vue 3 + Vite
- gọi API qua `api.js`
- router theo route file hiện tại
- Bootstrap cho layout
- fetch dữ liệu trong `onMounted`
- render dữ liệu theo `ref` và `v-for`

Mọi tính năng mới phải phù hợp với cấu trúc hiện có, không phá vỡ pattern đang dùng của project.

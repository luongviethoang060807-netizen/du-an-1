import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import TestView from '../views/TestView.vue'
import LoginView from '../views/auth/Login.vue'
import { isAuthenticated } from '@/services/auth'


// [note:] phần profile do front-end dev chưa làm xong nên tạm thời comment lại, khi nào làm xong thì bỏ comment ra
// import Profile from '../views/auth/Profile.vue'

const routes = [
  {
    path: '/',
    name: 'home',
    component: HomeView
  },
    {
        path: '/test',
        name: 'test',
        component: TestView
    },
    {
      path: '/login',
      name: 'login',
      component: LoginView
    },

    // [note:] phần profile do front-end dev chưa làm xong nên tạm thời comment lại, khi nào làm xong thì bỏ comment ra
    // {
    //   path: '/profile',
    //   name: 'profile',
    //   component: Profile,
    //   // Đánh dấu route này chỉ dành cho người dùng đã đăng nhập.
    //   meta: { requiresAuth: true }
    // }
]

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes
})

// Chuyển người chưa đăng nhập về trang Login khi vào route cần xác thực.
router.beforeEach((to) => {
  if (to.meta.requiresAuth && !isAuthenticated()) {
    return { name: 'login' }
  }
})

export default router

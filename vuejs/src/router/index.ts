import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/login',
      name: 'login',
      component: () => import('../views/LoginView.vue')
    },
    {
      path: '/user-management',
      name: 'user-management',
      component: () => import('../views/UserManagementView.vue')
    },
    {
      path: '/users/add',
      name: 'users-add',
      component: () => import('../views/UserFormView.vue')
    },
    {
      path: '/users/edit/:id',
      name: 'users-edit',
      component: () => import('../views/UserFormView.vue'),
      props: true
    }
  ]
})

router.beforeEach((to, from, next) => {
  if (to.name !== 'login' && !localStorage.getItem('token')) {
    next({ name: 'login' })
  } else if (to.name === 'login' && localStorage.getItem('token')) {
    next({ name: 'user-management' })
  } else {
    next()
  }
})

export default router

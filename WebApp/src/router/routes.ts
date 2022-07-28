import { RouteRecordRaw } from 'vue-router'
// Estructura de la WebApp
const routes: RouteRecordRaw[] = [
  {
    path: '/',
    redirect: { name: 'DashboardLogin' },
  },
  {
    path: '/primer-usuario',
    component: () => import('layouts/LoginL.vue'),
    children: [
      {
        path: 'dashboard',
        name: 'DashboardPrimerUsuario',
        component: () => import('src/pages/dashboard/primerUsuario/DashPrimerUsuario.vue'),
      },
      {
        path: '/:catchAll(.*)*',
        redirect: { name: 'Error404' },
      },
    ],
  },
  {
    path: '/login',
    component: () => import('layouts/LoginL.vue'),
    children: [
      {
        path: 'dashboard',
        name: 'DashboardLogin',
        component: () => import('src/pages/dashboard/DashLogin.vue'),
      },
      {
        path: '/:catchAll(.*)*',
        redirect: { name: 'Error404' },
      },
    ],
  },
  // Dashboard
  {
    path: '/dashboard',
    component: () => import('layouts/dashboard/DashboardL.vue'),
    children: [
      {
        path: 'main',
        name: 'DashboardMain',
        component: () => import('src/pages/dashboard/DashMain.vue'),
      },
      {
        path: 'empleados',
        name: 'DashboardEmpleados',
        component: () => import('pages/dashboard/empleados/DashEmpleados.vue'),
      },
      {
        path: '/:catchAll(.*)*',
        redirect: { name: 'Error404' },
      },
    ],
  },
  {
    path: '/:catchAll(.*)*',
    name: 'Error404',
    component: () => import('pages/errors/Error404.vue'),
  },
]

export default routes

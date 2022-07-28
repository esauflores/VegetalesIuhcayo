import { defineStore } from 'pinia'
import { Link } from 'src/assets/models/link'
import { Page } from 'src/assets/models/page'

export const useDConfigStore = defineStore('DashboardConfig', {
  state: () => ({
    // Configuración tabla iniciar sesión
    sidenavState: false as boolean,
    accessLinks: [
      {
        title: 'Productos',
        icon: 'fa-solid fa-shopping-basket',
        sublinks: [
          {
            title: 'Productos',
            icon: 'fa-solid fa-shopping-basket',
            route: '/dashboard/productos',
          },
          {
            title: 'Inventario',
            icon: 'layers',
            route: '/dashboard/inventario',
          },
          {
            title: 'Categorías',
            icon: 'widgets',
            route: '/dashboard/categorias',
          },
        ],
      },
      {
        title: 'Empleados',
        icon: 'fa-regular fa-id-card',
        sublinks: [
          {
            title: 'Empleados',
            icon: 'fa-regular fa-id-card',
            route: { name: 'DashboardEmpleados' },
          },
          {
            title: 'Proveedores',
            icon: 'local_shipping',
            route: '/dashboard/proveedores',
          },
        ],
      },
      {
        title: 'Clientes',
        icon: 'fa-solid fa-user',
        sublinks: [
          {
            title: 'Clientes',
            icon: 'fa-solid fa-user',
            route: '/dashboard/clientes',
          },
          {
            title: 'Pedidos',
            icon: 'local_grocery_store',
            route: '/dashboard/pedidos',
          },
          {
            title: 'Reseñas',
            icon: 'comment',
            route: '/dashboard/resenas',
          },
        ],
      },
    ] as Link[],

    page: {
      title: '',
    } as Page,
  }),
  getters: {},
  actions: {},
})

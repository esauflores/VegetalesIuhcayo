import { defineStore } from 'pinia'
import { api } from 'src/boot/axios' // Importa la api para realizar consultas
import { loginData } from 'src/assets/ts/models'

export const useLoginStore = defineStore('login', {
  state: () => ({
    // Configuración tabla iniciar sesión
    usuario: '',
    contrasenia: '',

    // Validación de acceso
    accesoUsuario: false, // impide o admite el acceso

    // Datos de usuario
    userData: {} as loginData,
  }),
  actions: {
    async validarAcceso() {
      // Llama a la API
      return api({
        method: 'get',
        url: '/login/validar-acceso',
        timeout: 1000 * 10,
      })
        .then((response) => {
          try {
            return response.data.data.acceso
          } catch (error) {
            return false
          }
        })
        .catch(() => {
          return false
        })
    },
  },
})

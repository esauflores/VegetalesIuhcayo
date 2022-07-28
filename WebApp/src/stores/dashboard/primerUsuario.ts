import { defineStore } from 'pinia'
import { api } from 'src/boot/axios' // Importa la api para realizar consultas

export const usePrimerUsuarioStore = defineStore('primerUsuario', {
  state: () => ({
    imagen: null as File | null,
    nombreCompleto: 'Example Example' as string,
    telefono: '0000-0000' as string,
    dui: '00000000-0' as string,
    correo: 'VegetalesIuhcayo@gmail.com' as string,
    nombreUsuario: 'Admin' as string,
    contrasenia: 'Admin' as string,
  }),
  actions: {
    async validarPrimerUsuario() {
      // Llama a la API
      return api({
        method: 'get',
        url: '/primer-usuario/validar',
        timeout: 1000 * 10,
      })
        .then((response) => {
          try {
            const primerUsuario = response.data.data['primer-usuario']
            return primerUsuario
          } catch (error) {
            return false
          }
        })
        .catch(() => {
          return false
        })
    },

    async registrarPrimerUsuario() {
      const data = new FormData()
      if (this.imagen) data.append('imagen', this.imagen)
      data.append('nombreCompleto', this.nombreCompleto)
      data.append('telefono', this.telefono)
      data.append('dui', this.dui)
      data.append('correo', this.correo)
      data.append('nombreUsuario', this.nombreUsuario)
      data.append('contrasenia', this.contrasenia)

      return api({
        method: 'post',
        url: '/primer-usuario/registrar',
        timeout: 1000 * 10,
        data: data,
      })
        .then((response) => {
          if (response.data.data) return true
          return false
        })
        .catch((error) => {
          console.log(error)
          return false
        })
    },
  },
})

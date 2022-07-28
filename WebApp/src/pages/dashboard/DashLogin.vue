<template>
  <q-page class="flex flex-center">
    <div class="row full-width flex flex-center">
      <div class="col-md-4 col-sm-7 col-xs-10">
        <!-- Card -->
        <q-card>
          <q-card-section>
            <q-avatar size="115px" class="absolute-center shadow-10 logo-card">
              <img src="~assets/images/logo.png" class="bg-deep-purple-1" />
            </q-avatar>
          </q-card-section>

          <q-card-section class="text-center q-pt-xl">
            <div class="text-center q-pt-md">
              <div class="col text-h6 ellipsis text-uppercase">Portal de ingreso</div>
              <div class="col text-subtitle1 ellipsis text-uppercase">Dashboard - Login</div>
            </div>
          </q-card-section>
          <q-card-section class>
            <!-- sección del formulario -->
            <q-form
              class="q-gutter-lg"
              autocorrect="off"
              autocapitalize="off"
              autocomplete="off"
              spellcheck="false"
              @submit="loginUsuario()"
            >
              <q-input
                label="Correo Electrónico (Usuario)*"
                outlined
                v-model="usuario"
                maxlength="255"
                clear-icon="close"
                :rules="[(val) => val.length > 0 || 'El campo no debe estar vacío']"
              >
                <template v-slot:prepend>
                  <q-icon name="fa-solid fa-user" class="text-primary" />
                </template>
              </q-input>

              <q-input
                label="Password"
                outlined
                v-model="contrasenia"
                :type="contraseniaVisible ? 'text' : 'password'"
                maxlength="100"
                :rules="[(val) => val.length > 0 || 'El campo no debe estar vacío']"
                autocomplete="off"
              >
                <template v-slot:append>
                  <q-icon
                    :name="contraseniaVisible ? 'visibility' : 'visibility_off'"
                    class="cursor-pointer"
                    @click="contraseniaVisible = !contraseniaVisible"
                  />
                </template>
                <template v-slot:prepend>
                  <q-icon name="key" class="text-primary" />
                </template>
              </q-input>
              <div align="right">
                <router-link to="/login/dashboard" class="normal_link"> ¿Olvidaste tu contraseña? </router-link>
              </div>

              <!-- Botón submit -->
              <div align="right">
                <q-btn label="Acceder" to="" type="submit" color="primary" />
              </div>
            </q-form>
          </q-card-section>
        </q-card>
      </div>
    </div>
  </q-page>
</template>

<script lang="ts">
// import { useLoginStore } from 'src/stores/login'
import { useLoginStore } from 'src/stores/dashboard/login'
import { usePrimerUsuarioStore } from 'src/stores/dashboard/primerUsuario'

import { defineComponent, Ref, ref } from 'vue'

export default defineComponent({
  data() {
    return {
      usuario: ref('') as Ref<string>,
      contrasenia: ref('') as Ref<string>,
      contraseniaVisible: ref(false) as Ref<boolean>, // Visibilidad del campo contraseña
    }
  },
  methods: {
    loginUsuario(): void {
      this.$router.push({ name: 'DashboardMain' })
    },
  },

  async beforeRouteEnter(to, from, next) {
    if (await useLoginStore().validarAcceso()) {
      return next({ name: 'DashboardMain' })
    }

    if (await usePrimerUsuarioStore().validarPrimerUsuario()) {
      return next({ name: 'DashboardPrimerUsuario' })
    }

    next()
  },
})
</script>

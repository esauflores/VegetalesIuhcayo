<template>
  <q-page class="flex flex-center">
    <div class="row full-width full-height flex flex-center">
      <div class="col-md-5 col-sm-8 col-xs-10">
        <!-- Card principal -->
        <q-card class="q-mt-xl q-mb-lg">
          <!-- Card section: logo -->
          <q-card-section>
            <q-avatar size="115px" class="absolute-center shadow-10 logo-card">
              <img src="~assets/images/logo.png" class="bg-deep-purple-1" />
            </q-avatar>
          </q-card-section>
          <!-- Card section: contenido -->
          <q-card-section class="text-center q-pt-xl">
            <!-- card: texto principal -->
            <div class="text-center q-pt-md q-pb-md">
              <div class="col text-h6 ellipsis text-uppercase">Primer usuario administrador/a</div>
            </div>
            <!-- 3 Pasos para la creación del primer usuario -->
            <q-stepper v-model="paso" ref="stepper" color="primary" animated header-nav>
              <!-- Paso 1 - Datos personales: nombre, teléfono, dui y correo electrónico -->
              <q-step :name="1" title="Datos personales" icon="settings" :done="paso > 1" :header-nav="paso > 1">
                <q-form
                  class="q-gutter-xs"
                  @submit="paso++"
                  autocorrect="off"
                  autocapitalize="off"
                  autocomplete="off"
                  spellcheck="false"
                >
                  <!-- Fila nombre completo -->
                  <div class="row">
                    <div class="col-xs-12">
                      <q-item>
                        <q-input
                          outlined
                          dense
                          label="Nombre completo"
                          class="full-width"
                          v-model="nombreCompleto"
                          lazy-rules
                          :rules="Validator.validarNombreCompleto()"
                          hint="Caracteres válidos [a-z, A-Z, ñ, Ñ, tildes]"
                        >
                          <template v-slot:prepend>
                            <q-icon name="fa-solid fa-person" class="text-primary" />
                          </template>
                        </q-input>
                      </q-item>
                    </div>
                  </div>
                  <!-- Fila(s) teléfono y dui -->
                  <div class="row">
                    <!-- división teléfono -->
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <q-item>
                        <q-input
                          outlined
                          dense
                          label="Número de teléfono"
                          class="full-width"
                          mask="####-####"
                          hint="Debe comenzar con 2,6 o 7"
                          fill-mask
                          v-model="telefono"
                          lazy-rules
                          :rules="Validator.validarTelefono()"
                          type="tel"
                        >
                          <template v-slot:prepend>
                            <q-icon name="fa-solid fa-phone" class="text-primary" />
                          </template>
                        </q-input>
                      </q-item>
                    </div>
                    <!-- división dui -->
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <q-item>
                        <q-input
                          outlined
                          dense
                          label="DUI"
                          class="full-width"
                          mask="########-#"
                          fill-mask
                          v-model="dui"
                          lazy-rules
                          :rules="Validator.validarDUI()"
                        >
                          <template v-slot:prepend>
                            <q-icon name="fa-solid fa-id-card" class="text-primary" />
                          </template>
                        </q-input>
                      </q-item>
                    </div>
                  </div>
                  <!-- Fila correo electrónico -->
                  <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                      <q-item>
                        <q-input
                          outlined
                          dense
                          label="Correo electrónico"
                          class="full-width"
                          v-model="correo"
                          lazy-rules
                          :rules="Validator.validarCorreo()"
                        >
                          <template v-slot:prepend>
                            <q-icon name="email" class="text-primary" />
                          </template>
                        </q-input>
                      </q-item>
                    </div>
                  </div>
                  <!-- Paso 1: botones de navegación -->
                  <q-stepper-navigation>
                    <q-btn type="submit" color="primary" label="Siguiente" />
                  </q-stepper-navigation>
                </q-form> </q-step
              ><!-- Paso 2 - Usuario: imagen Usuario -->
              <q-step :name="2" title="Imagen" icon="settings" :done="paso > 2" :header-nav="paso > 2">
                <q-form
                  class="q-gutter-xs"
                  @submit="paso++"
                  autocorrect="off"
                  autocapitalize="off"
                  autocomplete="off"
                  spellcheck="false"
                >
                  <!-- Fila imagen -->
                  <div class="row flex flex-center q-mb-sm">
                    <div class="col-md-12 col-sm-12 col-xs-12 self-center">
                      <q-item class="flex flex-center">
                        <q-file
                          v-model="imagen"
                          outlined
                          clearable
                          dense
                          display-value="Imagen opcional"
                          class="full-width flex flex-center"
                          input-class="text-grey"
                          accept=".jpg, image/png, image/jpeg"
                          max-file-size="2097152"
                          hint="Imagen png, jpg o jpeg con 2MB o menos"
                          @update:model-value="cargarImagen()"
                          @clear="limpiarImagen()"
                        >
                          <template v-slot:prepend>
                            <q-icon name="fa-solid fa-image" class="text-primary" />
                          </template>
                        </q-file>
                      </q-item>
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12 flex flex-center">
                      <q-item>
                        <q-avatar
                          :size="imagenSize"
                          class="imgBorder cursor-pointer"
                          :square="imagenEstilo == 1"
                          v-ripple
                        >
                          <img
                            :src="imagenURL ? imagenURL : 'images/emptyUser.jpg'"
                            class="absolute-top"
                            @click="imagenEstilo ^= 1"
                            id="imgPrimerUsuario"
                          />
                        </q-avatar>
                      </q-item>
                    </div>
                  </div>
                  <!-- Paso 2: botones de navegación -->
                  <q-stepper-navigation>
                    <q-btn @click="paso--" color="primary" label="Anterior" class="q-mr-md" />
                    <q-btn class="q-ml-md" type="submit" color="primary" label="Siguiente" />
                  </q-stepper-navigation>
                </q-form>
              </q-step>

              <!-- Paso 3 - Credenciales: nombre de usuario y contraseña -->
              <q-step :name="3" title="Credenciales" icon="fa-solid fa-user" :done="paso > 3" :header-nav="paso > 3">
                <q-form
                  class="q-gutter-xs"
                  @submit="crearPrimerUsuario()"
                  autocorrect="off"
                  autocapitalize="off"
                  autocomplete="off"
                  spellcheck="false"
                >
                  <!-- Fila nombre de usuario -->
                  <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                      <q-item>
                        <q-input
                          outlined
                          dense
                          label="Nombre de usuario"
                          class="full-width"
                          v-model="nombreUsuario"
                          lazy-rules
                          :rules="Validator.validarNombreUsuario()"
                          hint="Caracteres válidos [a-z, A-Z, 1-9, '_' ]"
                        >
                          <template v-slot:prepend>
                            <q-icon name="fa-solid fa-user-gear" class="text-primary" />
                          </template>
                        </q-input>
                      </q-item>
                    </div>
                  </div>
                  <!-- Fila contraseña -->
                  <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                      <q-item>
                        <q-input
                          outlined
                          dense
                          label="Contraseña"
                          class="full-width"
                          :type="contraseniaVisible ? 'text' : 'password'"
                          v-model="contrasenia"
                          lazy-rules
                          :rules="Validator.validarContraseña()"
                          autocomplete="off"
                        >
                          <template v-slot:prepend>
                            <q-icon name="key" class="text-primary" />
                          </template>
                          <template v-slot:append>
                            <q-icon
                              :name="contraseniaVisible ? 'visibility' : 'visibility_off'"
                              class="cursor-pointer"
                              @click="contraseniaVisible = !contraseniaVisible"
                            />
                          </template>
                        </q-input>
                      </q-item>
                    </div>
                  </div>
                  <!-- Fila confirmar contraseña -->
                  <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                      <q-item>
                        <q-input
                          outlined
                          dense
                          label="Confirmar contraseña"
                          class="full-width"
                          :type="contraseniaConfirmarVisible ? 'text' : 'password'"
                          v-model="contraseniaConfirmar"
                          lazy-rules
                          :rules="Validator.validarConfirmarContraseña(contrasenia)"
                          autocomplete="off"
                        >
                          <template v-slot:prepend>
                            <q-icon name="key" class="text-primary" />
                          </template>
                          <template v-slot:append>
                            <q-icon
                              :name="contraseniaConfirmarVisible ? 'visibility' : 'visibility_off'"
                              class="cursor-pointer"
                              @click="contraseniaConfirmarVisible = !contraseniaConfirmarVisible"
                            />
                          </template>
                        </q-input>
                      </q-item>
                    </div>
                  </div>
                  <!-- Paso 2: botones de navegación -->
                  <q-stepper-navigation>
                    <q-btn @click="paso--" color="primary" label="Anterior" class="q-mr-md" />
                    <q-btn class="q-ml-md" type="submit" color="primary" label="Crear usuario" />
                  </q-stepper-navigation>
                </q-form>
              </q-step>
            </q-stepper>
          </q-card-section>
        </q-card>
      </div>
    </div>
  </q-page>
</template>

<script lang="ts">
import { defineComponent, Ref, ref } from 'vue'
import { Validator } from 'src/assets/ts/Validator'
import { usePrimerUsuarioStore } from 'src/stores/dashboard/primerUsuario'

export default defineComponent({
  data() {
    return {
      Validator,
      paso: ref(1) as Ref<number>, // número que determina el paso del formulario

      // Paso 1: imagen y nombre completo
      imagen: ref(null) as Ref<File | null>,
      imagenURL: ref(null) as Ref<string | null>,
      imagenSize: '150px', // Tamaño de la imagen
      imagenEstilo: ref(1) as Ref<number>, // Estilo de imagen 1 cuadrado, 0 cículo
      nombreCompleto: ref('César Esaú Flores Martínez') as Ref<string>,

      // Paso 2: teléfono, dui y correo
      telefono: ref('2000-0000') as Ref<string>,
      dui: ref('00000000-0') as Ref<string>,
      correo: ref('20200346@ricaldone.edu.sv') as Ref<string>,

      // Paso 3:
      nombreUsuario: ref('Admin') as Ref<string>,
      contrasenia: ref('Admin') as Ref<string>,
      contraseniaConfirmar: ref('Admin') as Ref<string>,
      contraseniaVisible: ref(false) as Ref<boolean>,
      contraseniaConfirmarVisible: ref(false) as Ref<boolean>,
    }
  },
  methods: {
    cargarImagen: function () {
      // si no hay imagen retorna
      if (this.imagen == null) return
      // crea la url de la imagen
      this.imagenURL = URL.createObjectURL(this.imagen)
    },

    // Limpia (setea a null) la imagen y url creada
    limpiarImagen: function () {
      this.imagen = null
      this.imagenURL = null
    },

    crearPrimerUsuario: async function () {
      let PU = usePrimerUsuarioStore()
      PU.imagen = this.imagen
      PU.nombreCompleto = this.nombreCompleto
      PU.telefono = this.telefono
      PU.dui = this.dui
      PU.correo = this.correo
      PU.nombreUsuario = this.nombreUsuario
      PU.contrasenia = this.contrasenia

      if ((await PU.registrarPrimerUsuario()) == true) {
        this.$router.push({ name: 'DashboardLogin' })
      }
    },
  },
})
</script>

<style lang="scss">
$imgSize: 150px;
#imgPrimerUsuario {
  height: calc(#{$imgSize} - 2px);
  width: calc(#{$imgSize} - 2px);
}

.imgBorder {
  border: 1px solid black;
  padding: 1px;
}

.q-stepper__nav {
  padding-top: 5px;
}
</style>
